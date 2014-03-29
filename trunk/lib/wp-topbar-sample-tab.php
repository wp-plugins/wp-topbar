<?php 

/*
Sample ToolBars Tab

i18n Compatible 

*/



//=========================================================================			
// Sample Toolbars
//=========================================================================			


function wptb_fix_sample_filepath($wptb_filename, $wptb_pathname) {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if ($wptb_filename == "") return "";
	
	$path_parts = pathinfo($wptb_filename);
	
	$new_filename = str_ireplace( 'https://','http://', $wptb_pathname.$path_parts['basename'] );
		
	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_fix_sample_filepath() for filename: '.$wptb_filename.' to '.$new_filename.'</code>';
	
	return $new_filename;
		
} 

// end of wptb_fix_sample_filepath


function wptb_fix_sample_row($wptbOptions, $wptb_pathname) {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_fix_sample_row() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';

	$wptbOptions['enable_topbar'] = 'false';

	// following section converts all file paths to the /sample directory
	
	$wptbOptions['close_button_image']  = wptb_fix_sample_filepath($wptbOptions['close_button_image'], $wptb_pathname);
	$wptbOptions['reopen_button_image'] = wptb_fix_sample_filepath($wptbOptions['reopen_button_image'], $wptb_pathname );
	$wptbOptions['bar_image']           = wptb_fix_sample_filepath($wptbOptions['bar_image'], $wptb_pathname);
	for ($i=1; $i<=10; $i++)  {
		$wptbOptions['social_icon'.$i.'_image'] = wptb_fix_sample_filepath($wptbOptions['social_icon'.$i.'_image' ], $wptb_pathname);
	}

	return $wptbOptions;

} // end of wptb_fix_sample_row


function wptb_fix_all_rows($wptbRows, $wptb_pathname, $wptb_barid) {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_fix_all_rows() for ['.$wptb_pathname. ']. Starting ID is '.$wptb_barid.'</code>';

	$num_rows = count($wptbRows);
	$j = 0;
	
	while ( $j < $num_rows ) {	
		$data[$j] = wptb_fix_sample_row($wptbRows[$j], $wptb_pathname);		
		$data[$j]['bar_id'] = $wptb_barid + 1;		
//			echo "</br>Before: ".$wptbRows[$j]['bar_image']."</br>After: ".$data[$j]['bar_image']."</br>";			
		$wptb_barid++;
		$j++;
	}

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_fix_all_rows() Ending ID is '.$wptb_barid.'</code>';

	return $data;

} // end of wptb_fix_all_rows


function wptb_get_sample_data() {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_get_sample_data()</code>';

  	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();
	$wptbGlobalOptions [ 'custom_samples_path' ] = $wptbGlobalOptions [ 'custom_samples_path' ];

	$file_data1 = file_get_contents( dirname(__FILE__).'/samples/sample_topbars.json');
    $raw_data = wptb_fix_all_rows(json_decode($file_data1, true), plugins_url('', __FILE__).'/samples/', 0);
	
    if ( $wptbGlobalOptions [ 'custom_samples_path' ] != "" ) {
		if($wptb_debug)
			echo '</br><code>WP-TopBar Debug Mode: wptb_get_sample_data() - loading: ['.$wptbGlobalOptions [ 'custom_samples_path' ].'custom_topbars.json'.']</code>';

			$file_data2 = file_get_contents( $wptbGlobalOptions [ 'custom_samples_path' ].'custom_topbars.json' );
			if($wptb_debug) {
				echo '</br><code>WP-TopBar Debug Mode: wptb_get_sample_data() - Type Custom File '.gettype($file_data2).'</code>';
				echo '</br><code>WP-TopBar Debug Mode: wptb_get_sample_data() - Type JSON Decon '.gettype(json_decode($file_data2,2)).'</code>';
		}
		if ( is_array(json_decode($file_data2, true)) ) {
			if($wptb_debug)
				echo '</br><code>WP-TopBar Debug Mode: wptb_get_sample_data() - fixing: ['.$wptbGlobalOptions [ 'custom_samples_path' ].'custom_topbars.json'.']</code>';
		    $raw_data2 = wptb_fix_all_rows(json_decode($file_data2, true), $wptbGlobalOptions [ 'custom_samples_path' ], count($raw_data));
			$raw_data  = array_merge($raw_data, $raw_data2);
		}
	}
	
	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_get_sample_data(): Number of rows returning '.count($raw_data).'</code>';
	
//		echo '['.file_get_contents( $wptbGlobalOptions [ 'custom_samples_path' ].'custom_topbars.json').']';
//		var_dump($file_data2);
//		echo "</br>";
//		echo "Number of rows: ".count($file_data)."</br>";


	return $raw_data;
	
} // end of wptb_get_sample_data

//=========================================================================		
//  Display the Sample topbars table
//
//=========================================================================		
function wptb_display_Sample_TopBars() {

//	wptb_display_Sample_TopBarsWP()
	wptb_display_Sample_TopBarsFoo();
}

function wptb_display_Sample_TopBarsFoo() {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_display_all_TopBars()</code>';

	 //Prepare Table of elements

	global $WPTB_DB_VERSION;
	global $wpdb;

	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();
	
   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );


	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
    $data = wptb_get_sample_data();       		
   	
	?>
	
<style media="screen" type="text/css">
	.wptbactions {
	    visibility:hidden;
	}
</style>
	
	
     <div class="wrap">
        
        <div id="icon-options-general" class="icon32"><br/></div>
        <h2><?php _e('Sample TopBars','wp-topbar'); ?></h2>
        
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p><?php _e('You can copy one row (by hovering over the TopBar and clicking the Copy TopBar link.)  Or you can copy multiple samples by clicking on their checkboxes and then using the drop down box on the Bulk Options to copy those TopBars.','wp-topbar'); ?></p> 
            <?php if ( $wptbGlobalOptions [ 'custom_samples_path' ] != "") 
            			echo __('Attempting to load custom TopBars from this location:','wp-topbar').' <code>'.htmlspecialchars($wptbGlobalOptions [ 'custom_samples_path' ]).'custom_topbars.json</code>';
    	  		  echo '<br>'.__('To load your own Custom Samples Topbars, go to the', 'wp-topbar')." <a href='?page=wp-topbar.php&action=globalsettings'>".__('Global Settings tab','wp-topbar').'</a>';
 ?>
        </div>        
	</div>
    
 <div class="tab-pane active" id="demo">
      <p >
		<strong>Bulk Actions</strong>: <select id="selectOpt">
		<option></option>
		<?php 
			echo '<option value="bulkcopy">'.__('Copy to TopBar Table','wp-topbar')."</option>";
         ?>  
        </select>
        <button type="button" onclick="processCheckBoxes()">Apply</button>
&nbsp;&nbsp;&nbsp;
        <strong>Search</strong>: <input id="filter" type="text">
        <form id="topbar-filter" name="addform" method="get">
  	    <table data-filter="#filter" data-filter-disable-enter="true" data-page-size="20" id="footable">		
	    <thead>
			<tr>
		        <th data-sort-ignore="true" data-ignore="true"><input type="checkbox" id="chk_new"  onclick="checkAll('chk');" ></th>
				<th data-class="expand">ID</th>
		        <th data-sort-ignore="true" data-ignore="true"></th>
				<?php echo "<th>".__('Sample')."</th>"; ?>
			</tr>
		</thead>
		<tbody>
		
    <?php 

	foreach ( $data as $wptbOptions ) {	
			
		echo '<tr class="wptbrow" style="vertical-align: top;">';
		echo '<td data-ignore="true"><input type="checkbox"  class="wptbCheckBox" value="'.($wptbOptions['bar_id']+0).'"></td>';
		echo '<td data-type="numeric" data-value="'.($wptbOptions['bar_id']+0).'">'.$wptbOptions['bar_id']."</td>";
		echo '<td data-ignore="true">';	
				echo sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s&amp;noheader=true">Copy&nbspTopbar</a>',$_REQUEST['page'],'copysample',($wptbOptions['bar_id']+$wptb_barid_prefix));		
		echo '</td>';
		echo '<td>';

		if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes")
			wptb::wptb_display_TopBar('',$wptbOptions, false, 1, true);
		else 
			wptb::wptb_display_TopBar('',$wptbOptions, false, 1, false);		
		
		echo '</td>';
		
		echo '</tr>';
	}

	?>
		</tbody>
	<tfoot>
		<tr>
			<td colspan="5">
				<div class="pagination pagination-centered hide-if-no-paging"></div>
			</td>
		</tr>
	</tfoot>		
	</table>

	
    </form>
    </div>	
    </div>	
	
	<?php


} 
   function wptb_process_Sample_bulk_action() {

	    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : array();
	
	   	switch ( $action ) {
				
		case "bulkcopy":
	        $data = wptb_get_sample_data();       		
			$barid = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
			$barids = explode(",", $barid);
            $n = count($barids);
			foreach ($barids as $key => $barid) {
			  	$wptbOptions = $data [$barid - 1];			
			  	$wptbOptions['enable_topbar'] = 'false';
	  			wptb_insert_row($wptbOptions);
	  		}
			if ($n > 0) {
		        $wptb_i18n = sprintf( _n('%d row copied.', '%d rows copied.', $n, 'wp-topbar'), $n );
		        echo '<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
			}	  

		}
    }
    
   function wptb_display_Sample_TopBarsWP() {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_display_Sample_TopBars()</code>';
	
	//Our class extends the WP_List_Table class, so we need to make sure that it's there
	if(!class_exists('WP_List_Table')){
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}
	class wptb_Sample_TopBar_Table extends WP_List_Table {


/**
	 * Constructor, we override the parent to pass our own arguments
	 * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	 */
	 function __construct() {
		 parent::__construct( array(
		'singular'=> 'barid', //Singular label
		'plural' => 'barids', //plural label, also this well be one of the table css class
		'ajax'	=> false //We won't support Ajax for this table
		) );
	 }
    /**************************************************************************
     * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
     * is given special treatment when columns are processed. It ALWAYS needs to
     * have it's own method.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],      
            /*$2%s*/ $item['bar_id']               
        );
    }
	 /**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	function get_columns() {
		return $columns= array(
			'cb' => '<input type="checkbox" />',
			'bar_id' => __('ID','wp-topbar')
		);
	}
    /** ************************************************************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title() 
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as 
     * possible. 
     * 
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     * 
     * For more detailed insight into how columns are handled, take a look at 
     * WP_List_Table::single_row_columns()
     * 
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default($item, $column_name){

   	switch ( $column_name ) {
			case "bar_id":	
					return	$item[$column_name];	
					break;
			default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
		}
    }
    
    

        
    /** ************************************************************************
     * Recommended. This is a custom column method and is responsible for what
     * is rendered in any column with a name/slug of 'title'. Every time the class
     * needs to render a column, it first looks for a method named 
     * column_{$column_title} - if it exists, that method is run. If it doesn't
     * exist, column_default() is called instead.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
    function column_bar_id($item){

     	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
       	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
       	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

              
	    if ( isset ( $_GET['paged'] ) )
	        $current_page = '&paged='.$_GET['paged'];
	    else
	        $current_page = '';    
	        	        
/*
        $tabs = array( 'copysampletopbar' => 'Copy&nbspTopbar' );    

        //Build row actions
        
        foreach( $tabs as $tab => $name ) {
        	$actions[] = sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s">%s</a>',$_REQUEST['page'],$tab,($item['bar_id']+$wptb_barid_prefix), $current_page, $name);
        }
*/
        
        $actions = array('copysampletopbar'    => sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">Copy&nbspTopbar</a>',$_REQUEST['page'],'copysample',($item['bar_id']+$wptb_barid_prefix), $current_page));

        

        return sprintf('%1$s %2$s',
            /*$2%s*/ $item['bar_id'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }	
    
    function no_items() {
	    echo '<br><strong>'.__('Sorry, no sample TopBars to show.','wp-topbar').'</strong><br>';
	    return;
    }
    
    
    function single_row( $item ) {
		static $row_class = '';
		$row_class = ( $row_class == '' ? ' class="alternate"' : '' );

		echo '<tr' . $row_class . 'style="border-bottom-style:none;"'.'>';
		echo $this->single_row_columns( $item );
		echo '</tr>';
		echo '<tr' . $row_class .  '>';
		echo '<td>&nbsp</td>';
		echo '<td style="border-top: thin solid black; border-bottom: thin solid black;  border-left: thin solid black; border-right: thin solid black;" colspan="7">';
		if (isset($item['allow_reopen']) && ($item['allow_reopen']) == "yes")
			wptb::wptb_display_TopBar('',$item, false, 1, true);
		else 
			wptb::wptb_display_TopBar('',$item, false, 1, false);
		echo '</td>';
		echo '</tr>';
	}
    
    	function single_row_columns( $item ) {
		list( $columns, $hidden ) = $this->get_column_info();

		foreach ( $columns as $column_name => $column_display_name ) {
			$class = "class='$column_name column-$column_name'";

			$style = '';
			if ( in_array( $column_name, $hidden ) )
				$style = ' style="display:none;border-bottom-style:none;"';
			else
				$style = ' style="border-bottom-style:none;"';

			$attributes = "$class$style";

			if ( 'cb' == $column_name ) {
				echo '<th scope="row" class="check-column" style="border-bottom-style:none;">';
				echo $this->column_cb( $item );
				echo '</th>';
			}
			elseif ( method_exists( $this, 'column_' . $column_name ) ) {
				echo "<td $attributes>";
				echo call_user_func( array( &$this, 'column_' . $column_name ), $item );
				echo "</td>";
			}
			else {
				echo "<td $attributes>";
				echo $this->column_default( $item, $column_name );
				echo "</td>";
			}
		}
	}
 
	function print_column_headers( $with_id = true ) {
		$screen = get_current_screen();

		list( $columns, $hidden, $sortable ) = $this->get_column_info();

		$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$current_url = remove_query_arg( 'paged', $current_url );

		if ( isset( $_GET['orderby'] ) )
			$current_orderby = $_GET['orderby'];
		else
			$current_orderby = '';

		if ( isset( $_GET['order'] ) && 'desc' == $_GET['order'] )
			$current_order = 'desc';
		else
			$current_order = 'asc';

		foreach ( $columns as $column_key => $column_display_name ) {
			$class = array( 'manage-column', "column-$column_key" );

			$style = '';
			if ( in_array( $column_key, $hidden ) )
				$style = 'display:none;';


			switch ( $column_key ):
				case 'bar_id':
					 $style .= $style.'width:200px;';
			endswitch;
			
			$style = ' style="' . $style . '"';

			if ( 'cb' == $column_key )
				$class[] = 'check-column';
			elseif ( in_array( $column_key, array( 'posts', 'comments', 'links' ) ) )
				$class[] = 'num';
				
			if ( isset( $sortable[$column_key] ) ) {
				list( $orderby, $desc_first ) = $sortable[$column_key];

				if ( $current_orderby == $orderby ) {
					$order = 'asc' == $current_order ? 'desc' : 'asc';
					$class[] = 'sorted';
					$class[] = $current_order;
				} else {
					$order = $desc_first ? 'desc' : 'asc';
					$class[] = 'sortable';
					$class[] = $desc_first ? 'asc' : 'desc';
				}

				$column_display_name = '<a href="' . esc_url( add_query_arg( compact( 'orderby', 'order' ), $current_url ) ) . '"><span>' . $column_display_name . '</span><span class="sorting-indicator"></span></a>';
			}

			$id = $with_id ? "id='$column_key'" : '';

			if ( !empty( $class ) )
				$class = "class='" . join( ' ', $class ) . "'";

			echo "<th scope='col' $id $class $style>$column_display_name</th>";
		}
	}
  
	function get_1table_classes() {
		return array( 'border=0', 'fixed', $this->_args['plural'] );
	}
       
	/**
	 * Decide which columns to activate the sorting functionality on
	 * @return array $sortable, the array of columns that can be sorted by the user
	*/
	 
	function get_sortable_columns() {
		return $sortable = array(
			'bar_id' => array('bar_id',true)
		);
	}

	
	 /** ************************************************************************
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     * 
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     * 
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     * 
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
        $actions = array(
            'bulkcopy'    => __('Copy to TopBar Table','wp-topbar')
        );
        return $actions;
    }
    
    
       
    /** ************************************************************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this example package, we will handle it in the class to keep things
     * clean and organized.
     * 
     * @see $this->prepare_items()
     **************************************************************************/
    function process_bulk_action() {

	   	switch ( $this->current_action() ) {
				
		case "bulkcopy":
				$barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
		        $data = wptb_get_sample_data();       		
	            $n = count($barids);
				foreach ($barids as $key => $barid) {
				  	$wptbOptions = $data [$barid - 1];			
				  	$wptbOptions['enable_topbar'] = 'false';
		  			wptb_insert_row($wptbOptions);
		  		}
				if ($n > 0) {
			        $wptb_i18n = sprintf( _n('%d row copied. Go to the All TopBars tab to see them.', '%d rows copied. Go to the All TopBars tab to see them.', $n, 'wp-topbar'), $n );
			        echo '<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
				}	  

		}
    }
    
    
    /** ************************************************************************
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     * 
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items() {
        
      /**
         * First, lets decide how many records per page to show
         */
        $per_page = 20;
        
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        
        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
       
		$data[]="";
       
        $this->process_bulk_action(); 
        
        $data = wptb_get_sample_data();       		

        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */

		 $current_page = $this->get_pagenum();
	        
	    if (! isset($current_page))
			$current_page = 1;
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        
        
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        
        
        
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }


	}
	 
	 //Prepare Table of elements
	$wp_list_table = new wptb_Sample_TopBar_Table();
	$wp_list_table->prepare_items();

  	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();

	?>
	
    <div class="wrap">
        
        <div id="icon-options-general" class="icon32"><br/></div>
        <h2><?php _e('Sample TopBars','wp-topbar'); ?></h2>
        
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p><?php _e('You can copy one row (by hovering over the TopBar and clicking the Copy TopBar link.)  Or you can copy multiple samples by clicking on their checkboxes and then using the drop down box on the Bulk Options to copy those TopBars.','wp-topbar'); ?></p> 
            <?php if ( $wptbGlobalOptions [ 'custom_samples_path' ] != "") 
            			echo __('Attempting to load custom TopBars from this location:','wp-topbar').' <code>'.htmlspecialchars($wptbGlobalOptions [ 'custom_samples_path' ]).'custom_topbars.json</code>';
    	  		  echo '<br>'.__('To load your own Custom Samples Topbars, go to the', 'wp-topbar')." <a href='?page=wp-topbar.php&action=globalsettings'>".__('Global Settings tab','wp-topbar').'</a>';
 ?>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="topbar-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
		<?php $wp_list_table->display(); ?>
        </form>
        
    </div>

    <?php
	

} // end of wptb_display_all_TopBars
 
 
 

?>