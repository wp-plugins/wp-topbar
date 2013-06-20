<?php 

/*
DB IO Functions
*/

//=========================================================================		
//
//
//=========================================================================		



function wptb_display_all_TopBars() {
	//Our class extends the WP_List_Table class, so we need to make sure that it's there
	if(!class_exists('WP_List_Table')){
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}
	class Link_List_Table extends WP_List_Table {

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
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['bar_id']                //The value of the checkbox should be the record's id
        );
    }
	 /**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	function get_columns() {
		return $columns= array(
			'cb' => '<input type="checkbox" />',
			'bar_id' => 'ID',
			'weighting_points' => 'Priority',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'show_it' => 'Time Check',
			'enable_topbar' => 'Enabled?',
			'only_logged_in' => 'Logged In Users Only?'
//			'text_line' => 'Bar and Link Text'
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
			case "text_line": return stripslashes($item[$column_name]);
			case "only_logged_in":
				if ($item[$column_name] == "yes" ) 
					return "Only Logged In";					
				else if ($item[$column_name] == "no" ) 
					return "Only NOT Logged In";	
				else 
					return "All Users";				
				break;			
			case "weighting_points": 
				$width=$item[$column_name]+0;
//				return $item[$column_name];
				echo $item[$column_name]."<br><img height='22px' width='".$width."%' src='".plugins_url('/images/priority.png', __FILE__)."' />";
				return;

			case "enable_topbar": 
				if ($item[$column_name] == 'false')								
					return sprintf( "<span class='wtpb-off-button'".'style="display: block;width: 32px;height: 32px;color:red;background:url('.plugins_url('/images/off.png', __FILE__).')"'."></span>");
				else
					return sprintf( "<span class='wtpb-on-button'".'style="display: block;width: 32px;height: 32px;color:red;background:url('.plugins_url('/images/on.png', __FILE__).')"'."></span>");
					break;
			case "show_it": 
				if ($item[$column_name] == 0 )							
					return sprintf( "<span class='wtpb-off-button'".'style="display: block;width: 32px;height: 32px;color:red;background:url('.plugins_url('/images/off.png', __FILE__).')"'."></span>");
				else
					return sprintf( "<span class='wtpb-on-button'".'style="display: block;width: 32px;height: 32px;color:red;background:url('.plugins_url('/images/on.png', __FILE__).')"'."></span>");
					break;
			case "start_time": 
			case "end_time": 
			
				if ($item[$column_name] == 0) 
					return "N/A";
				else 
					return $item[$column_name];
					
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
	        
//        $tabs = array( 'main' => 'Main&nbspOptions',  'control' => 'Control',  'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage',  'topbarcss' => 'TopBar&nbspCSS', 'colorselection' => 'Color&nbspSelection','closebutton' => 'Close&nbspButton', 'socialbuttons' => 'Social&nbspButtons','debug' => 'Debug', 'delete' => 'Delete&nbspSettings' );    
	        
        $tabs = array( 'main' => 'Main&nbspOptions',  'control' => 'Control',  'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage',  'topbarcss' => 'TopBar&nbspCSS', 'colorselection' => 'Color&nbspSelection','closebutton' => 'Close&nbspButton', 'socialbuttons' => 'Social&nbspButtons','phptexttab' => 'PHP', 'debug' => 'Debug' );    

        //Build row actions

        if ( $item['enable_topbar'] == "false" ) {
	        $actions = array('enable'    => sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">Enable</a>',$_REQUEST['page'],'enable',($item['bar_id']+$wptb_barid_prefix), $current_page));
        }
        else {
	        $actions = array('disable'   => sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">Disable</a>',$_REQUEST['page'],'disable',($item['bar_id']+$wptb_barid_prefix), $current_page));	        
        }
        
        $actions[] = sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">Duplicate</a>',$_REQUEST['page'],'duplicate',($item['bar_id']+$wptb_barid_prefix), $current_page);

        foreach( $tabs as $tab => $name ) {
        	$actions[] = sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s">%s</a>',$_REQUEST['page'],$tab,($item['bar_id']+$wptb_barid_prefix), $current_page, $name);
        }

        return sprintf('%1$s %2$s',
            /*$2%s*/ $item['bar_id'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }	
    
    function no_items() {
	    echo '<br><strong>No TopBars to show - if none exist will create default TopBar.</strong><br>	';
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
				case 'start_time':
				case 'end_time':
					 $style .= $style.'width:150px;';
					 break;
				case 'show_it':
				case 'weighting_points':
					 $style .= $style.'width:105px;';
					 break;
				case 'enable_topbar':
					 $style .= $style.'width:95px;';
					 break;
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
			'bar_id' => array('bar_id',true),
			'enable_topbar' => array('enable_topbar',false),
			'only_logged_in' => array('only_logged_in',false),
			'weighting_points' => array('weighting_points',false),
			'start_time' => array('start_time',false),
			'end_time' => array('end_time', false),
			'show_it' => array('show_it', false)
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
            'bulkdelete'    => 'Delete',
            'bulkduplicate' => 'Duplicate',
            'bulkenable'    => 'Enable',
            'bulkdisable'   => 'Disable',
            'bulkincrease'	=> 'Increase Priority by 10',
            'bulkdecrease'	=> 'Decrease Priority by 10'
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

	/*
	$string = ""; // initialize blank string
	foreach($_REQUEST as $key => $value) // loop through all $_GET values
	$string .= $key."=".$value."&"; // add key/value to string
	$string = substr_replace($string, "", -1); // remove trailing &
	echo $string;
	*/

	   	switch ( $this->current_action() ) {
		case "bulkincrease":	
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            if (is_array($barids)) $barids = implode(',', $barids);
	
	            if (!empty($barids)) {
	                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = `weighting_points`+10 WHERE bar_id IN($barids)");
	                $n = $wpdb->rows_affected;
	                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = 100 WHERE `weighting_points` > 100");
    				if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row changed priority by +10.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows changed priority by +10.</strong></p></div>';
	            }
				break;

		case "bulkdecrease":	
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            if (is_array($barids)) $barids = implode(',', $barids);
	
	            if (!empty($barids)) {
	                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = `weighting_points`-10 WHERE bar_id IN($barids)");
	                $n = $wpdb->rows_affected;
	                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = 1 WHERE `weighting_points` < 1");

    				if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row changed priority by -10.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows changed priority by -10.</strong></p></div>';
	            }
				break;
								
		case "bulkdisable":	
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            if (is_array($barids)) $barids = implode(',', $barids);
	
	            if (!empty($barids)) {
	                $wpdb->query("UPDATE $wptb_table_name SET `enable_topbar` = 'false' WHERE bar_id IN($barids)");
	                $n = $wpdb->rows_affected;
    				if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row disabled.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows disabled.</strong></p></div>';
	            }
				break;

		case "bulkenable": 
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            if (is_array($barids)) $barids = implode(',', $barids);
	
	            if (!empty($barids)) {
	                $wpdb->query("UPDATE $wptb_table_name SET `enable_topbar` = 'true' WHERE bar_id IN($barids)");
	                $n = $wpdb->rows_affected;
					if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row enabled.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows enabled.</strong></p></div>';
	            }
				break;
	
		case "bulkdelete": 
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
		        $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
		        if (is_array($barids)) $barids = implode(',', $barids);

		        if (!empty($barids)) {
		            $wpdb->query("DELETE FROM $wptb_table_name WHERE `bar_id` IN($barids)");
		            $n = $wpdb->rows_affected;
		            if ($n == 0) break;
		            if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row deleted.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows deleted.</strong></p></div>';
		         }
				break;
				
		case "bulkduplicate":
				$barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            $n = count($barids);
				foreach ($barids as $key => $barid) {
				  	$wptbOptions=wptb_get_Specific_TopBar($wptb_barid, false);
		  			$wptbOptions['enable_topbar']='false';
		  			wtpb_insert_row($wptbOptions, false);
		  		}
				if ($n == 1)	
					echo '<div class="updated"><p><strong>'.$n.' row duplicated.</strong></p></div>';
				else
					echo '<div class="updated"><p><strong>'.$n.' rows duplicated.</strong></p></div>';

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
        $per_page = 10;
        
        
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
        $this->process_bulk_action();
               
        
        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example 
         * package slightly different than one you might build on your own. In 
         * this example, we'll be using array manipulation to sort and paginate 
         * our data. In a real-world implementation, you will probably want to 
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
        global $wpdb;
		$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
		
	    $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'bar_id'; //If no sort, default to title
        $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
		
		$query = "SELECT *,  ((start_delta <= 0 ) AND (end_delta <=0 )) as show_it, concat(bar_text, '<br>',bar_link_text) as text_line
				  		FROM (
					
			SELECT 	*,	COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0), 
												COALESCE(STR_TO_DATE(  `start_time_utc`,  '%m/%d/%Y %H:%i'     ), 0)),0) as start_delta, 
						COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  `end_time_utc` ,  '%m/%d/%Y %H:%i'       ), 0), 					
												COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0)),0) as end_delta
						
						FROM ".$wptb_table_name."
						ORDER BY ".$orderby." ".$order."
						) as Table1;";

		$data = $wpdb->get_results($query, ARRAY_A);   
                
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */

        if ('bulkdelete' === $this->current_action()) 
			$current_page = 1;

		else
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
	$wp_list_table = new Link_List_Table();
	$wp_list_table->prepare_items();
	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	$myrows = $wpdb->get_results( 'SELECT * FROM '.$wptb_table_name);
	if ( $wpdb->num_rows == 0 ){
		$wptbOptions=wtpb_insert_default_row(false);
		$wp_list_table->prepare_items();
		echo '<div class="updated"><p><strong>All TopBars deleted; created default TopBar.</strong></p></div>';
	}
	
	?>
	
    <div class="wrap">
        
        <div id="icon-options-general" class="icon32"><br/></div>
        <h2>Listing of all TopBars</h2>
        
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>Select a TopBar to edit.  You can also enable, disable, bulk duplicate or delete your TopBars from here.</p> 
	        <p>Use the <strong>Test Priority</strong> tab to see how the plugin will randomly select 10 TopBars.</p>
	        <p>Hit the <strong>Create Default Row</strong> button to insert a default TopBar into the table.</p>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="topbar-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
		<table>
		<tr>
			<td style="valign:top;;"><p class="submit">
				<input type="submit" class="button-primary" name=wptbInsertBar value="<?php _e('Create Default Row', 'wptb') ?>" />
			</td>
		</tr>
		</table>
		<?php $wp_list_table->display(); ?>
        </form>
        
    </div>

    <?php
	

	
	

} // end of wptb_display_all_TopBars

//=========================================================================		
//Returns a random TopBar options,  sets enable_topbar to false if none are found
//=========================================================================		

function wptb_get_Random_TopBar($wptb_echo_on) {

	global $WPTB_VERSION;

	if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
	else $wptb_debug = false;			

	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: Getting Random TopBar</code>';

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

	$sql="SELECT * FROM ".$wptb_table_name." 
			WHERE  `enable_topbar` =  'true'
				AND COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0), 
											COALESCE(STR_TO_DATE( `start_time_utc`,  '%m/%d/%Y %H:%i'     ), 0)),0) <= 0 
				AND	COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  `end_time_utc` ,  '%m/%d/%Y %H:%i'       ), 0), 					
											COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0)),0) <=0
			ORDER BY ( `weighting_points` * RAND() ) DESC LIMIT 1
			";		

	$myrows = $wpdb->get_results( $sql, ARRAY_A );
	if ( $wpdb->num_rows != 0 ) {
		foreach ($myrows[0] as $key => $option)
			$wptbOptions[$key] = $option;
		echo '<!-- WP-TopBar Version="'.$wptbOptions['wptb_version'].'" | Showing Bar #="'.$wptbOptions['bar_id'].'" | Priority="'.$wptbOptions['weighting_points'].'" | Start Time (UTC)="'.$wptbOptions['start_time_utc'].'" | End Time (UTC)="'.$wptbOptions['end_time_utc'].'"-->
';
		echo '<!-- WP-TopBar Show homepage="'.$wptbOptions['show_homepage'].'" | Control logic="'.$wptbOptions['include_logic'].'" | Include pages="'.$wptbOptions['include_pages'].'" (invert="'.$wptbOptions['invert_include'].'") | Include categories="'.$wptbOptions['include_categories'].'" (invert="'.$wptbOptions['invert_categories'].'") -->
';
	}
	else {
		echo '<!-- WP-TopBar_'.$WPTB_VERSION.' :: not using options nor database -->
';
		$wptbOptions=array();
		$wptbOptions['enable_topbar'] = 'false';
	}
	
	if($wptb_debug) wptb_debug_display_TopBar_Options($wptbOptions);
	
	return $wptbOptions;
	
}	// End of wptb_get_Random_TopBar

//=========================================================================		
// Tests how the TopBar will show
//
// Parameter $wptb_echo_on is used for debugging:  
//		True=check for debuging flag, 0=don't check for debugging flag
//
//=========================================================================		

function wptb_test_topbar($number_to_show, $wptb_echo_on) {

	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

	if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
	else $wptb_debug = false;			

	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: In Test TopBar</code>';	

	?>
    <div class="wrap">
    
    <div id="icon-options-general" class="icon32"><br/></div>
    <h2>Test Priority of TopBars - Displaying <?php echo $number_to_show; ?> TopBars</h2>
    
    <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
        <p>This shows how the Plugin will show a random select a set of TopBars.  Only those TopBars that are enabled and pass the Time Check will be part of the selection pool. The Priority value is used to skew how often a TopBar is shown.  A higher number means that TopBar will be selected more frequently; a lower number means less frequently.</p> 
    </div>
	<table class="widefat alternate">
	<thead>
	    <tr>
	        <th>ID</th>
	        <th>Priority</th>       
	        <th>Sample</th>
	    </tr>
	</thead>
	<tfoot>
	    <th>ID</th>
	    <th>ID</th>
	    <th>Priority</th>
	    <th>Sample</th>
	    </tr>
	</tfoot>
	<tbody>
	<?php 
	$tabs = array( 'disable'=> '<br>Disable |<br>', 'main' => 'Main&nbspOptions |<br>',   'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage |<br>', 'topbarcss' => 'TopBar&nbspCSS |<br>', 'colorselection' => 'Color&nbspSelection' );    
	$n=1;
	while ( $n <= $number_to_show ) {
		$wptbOptions=wptb_get_Random_TopBar(false);
		if (isset ( $wptbOptions ['bar_id'] ) ) {
			echo "<tr>";
			echo "<td  width=125px>".$wptbOptions['bar_id'];

			foreach( $tabs as $tab => $name ) {
	        	echo '<a href="?page='.$_REQUEST['page'].'&amp;action='.$tab.'&amp;barid='.($wptb_barid_prefix+$wptbOptions['bar_id']).'">'.$name.'</a>';
	        	}
//			echo '<a href="?page='.$_REQUEST['page'].'&amp;action='.$tab.'&amp;barid='.$item['bar_id'].$current_page.">'.$name.'</a>';
			echo "</td>";
			echo "<td width=50px>".$wptbOptions['weighting_points']."</td>";
			echo '<td valign="top">';
			if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes")
				wptb::wptb_display_TopBar('',$wptbOptions, false, 1, true);
			else 
				wptb::wptb_display_TopBar('',$wptbOptions, false, 1, false);
			echo '</td>';
		}
		else break;
		$n++;
	}
	if ( $n == 0) {
		
		echo "<br><h3>No TopBars are enabled.</h3>";
	}
	
	echo "</tbody></table></div>";


} // end of wptb_display_all_TopBars





//=========================================================================		
//Returns an array of TopBar options, sets default values if none are loaded.
//
// Parameter $wptb_echo_on is used for debugging:  
//		True=check for debuging flag, 0=don't check for debugging flag
//
// $wptb_barid tells what bar to get -- 
// if == 0 then, get the first row in the table
// return empty array is nothing is found
//=========================================================================		

function wptb_get_Specific_TopBar($wptb_barid, $wptb_echo_on) {


	if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
	else $wptb_debug = false;			

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";

	if($wptb_debug)
		if ( $wptb_barid != 0)
			echo '<br><code>WP-TopBar Debug Mode: Getting TopBar #: '.$wptb_barid.' From Table: '.$wptb_table_name.'</code>';
		else
			echo '<br><code>WP-TopBar Debug Mode: Getting First TopBar In Table: '.$wptb_table_name.'</code>';

	// always check to see if table has been created .. if not then create it and insert default row.
	if( $wpdb->get_var("show tables like '".$wptb_table_name."'") != $wptb_table_name ) {
		if($wptb_debug)
			echo '<br><code>WP-TopBar Debug Mode: Table '.$wptb_table_name.' does not exist - creating it</code>';

		wptb_create_table($wptb_debug);				
		$wptbOptions=wtpb_insert_default_row($wptb_echo_on);
	}
	else {
		if ( $wptb_barid == 0)
			$myrows = $wpdb->get_results( 'SELECT * FROM '.$wptb_table_name.' ORDER BY bar_id LIMIT 1', ARRAY_A );
		else
			$myrows = $wpdb->get_results( 'SELECT * FROM '.$wptb_table_name.' WHERE bar_id = '.$wptb_barid, ARRAY_A );
		
		if ( $wpdb->num_rows == 0 ) {
			if($wptb_debug)
				echo '<br><code>WP-TopBar Debug Mode: Now rows found in Table: '.$wptb_table_name.' - using defaults</code>';
			$wptbOptions=wtpb_insert_default_row($wptb_echo_on);
		}
		else
			foreach ($myrows[0] as $key => $option)
				$wptbOptions[$key] = $option;		
	}
		
//	if($wptb_debug) wptb_debug_display_TopBar_Options($wptbOptions);
	
	return $wptbOptions;
	
}	// End of wptb_get_Specific_TopBar

	
//=========================================================================			
//	Check start/end times to see if TopBar should load: 
//     Returns 1 = yes, 0 = no
//  Args:  current time, start time, end time
//=========================================================================			
	
function wptb_check_time($wptb_barid) {
	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

	$sql="	SELECT 	1
				FROM ".$wptb_table_name."	

				WHERE `bar_id` = ".$wptb_barid."
				AND COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0), 
											COALESCE(STR_TO_DATE( `start_time_utc`,  '%m/%d/%Y %H:%i'     ), 0)),0) <= 0 
				AND	COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  `end_time_utc` ,  '%m/%d/%Y %H:%i'       ), 0), 					
											COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0)),0) <=0
		";
				

	$myrows = $wpdb->get_results( $sql, ARRAY_A );
	
//	echo "</div><br>".$sql."<br>";
//	echo "<br>rows found=".$wpdb->num_rows."<br>";
		
		
	if  ( $wpdb->num_rows == 0 )
		return false;
	else
		return true;

} // End of function wptb_check_time




//=========================================================================		
//
//Displays TopBar variables, if debug is turned on
//
//=========================================================================		
	
function wptb_debug_display_TopBar_Options($wptbOptions) {

	$wptb_current_time=current_time('timestamp', 1);

	echo '<br><code>WP-TopBar Debug Mode: Server Timezone:',date_default_timezone_get(),'</code>';
	echo '<br><code>WP-TopBar Debug Mode: Current Time&nbsp:',$wptb_current_time,'-',date('Y-m-d H:i:s (e)',$wptb_current_time),'</code>';				
	echo '<br><code>WP-TopBar Debug Mode: Starting Time:',$wptbOptions['start_time_utc'],'-',$wptbOptions['start_time'],'-',date('Y-m-d H:i:s (e)',$wptbOptions['start_time_utc']),'</code>';
	echo '<br><code>WP-TopBar Debug Mode: Ending Time&nbsp&nbsp:',$wptbOptions['end_time_utc'],'-',$wptbOptions['end_time'],'-',date('Y-m-d H:i:s (e)',$wptbOptions['end_time_utc']),'</code>';
	
	if ($wptbOptions['start_time_utc'] == 0) 
		echo '<br><code>WP-TopBar Debug Mode: Start Time is zero</code>';
	else
		if (($wptb_current_time - $wptbOptions['start_time_utc']) >= 0)
			echo '<br><code>WP-TopBar Debug Mode: Start Time is before or equal Current Time</code>';
		else
			echo '<br><code>WP-TopBar Debug Mode: Start Time is in the future</code>';

	if ($wptbOptions['end_time_utc'] == 0) 
		echo '<br><code>WP-TopBar Debug Mode: End Time is zero</code>';
	else {
		if ($wptbOptions['start_time_utc'] > $wptbOptions['end_time_utc']) 
			echo '<br><code>WP-TopBar Debug Mode: End Time is before Start Time - Error - TopBar will <strong>NOT</strong> display</code>';
		if (($wptbOptions['end_time_utc'] - $wptb_current_time) >= 0)
			echo '<br><code>WP-TopBar Debug Mode: End Time is after or equal to Current Time</code>';
		else
			echo '<br><code>WP-TopBar Debug Mode: End Time is in the past</code>';
	}
	if (wptb_check_time($wptbOptions['bar_id']))
		if ($wptbOptions['enable_topbar'] == 'false') 
			echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display because it is not enabled, even though the time settings would allow it</code>';
		else
			echo '<br><code>WP-TopBar Debug Mode: TopBar will display due to time settings and because it is enabled</code>';
	else
		if ($wptbOptions['enable_topbar'] == 'false') 
			echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings and because it is not enabled</code>';
		else
			echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings even though it is enabled</code>';
	
	switch ( $wptbOptions['show_homepage'] ) {
				
			case 'always':
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>ALWAYS</strong> display on the Home Page (if the TopBar is enabled)</code>';
				break;
				
			case 'never':
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NEVER</strong> display on the Home Page (if the TopBar is enabled)</code>';
				break;

			case 'conditionally':
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>check</strong> Page/Category criteria to determine if it should display on the Home Page (if the TopBar is enabled)</code>';
			
	}
	
	
	$wptb_cookie = "wptopbar_".$wptbOptions['bar_id'].'_'.COOKIEHASH; 
	
	echo "<br><code>WP-TopBar Debug Mode: Cookie Name: ".$wptb_cookie."</code>";
	if (isset($_COOKIE[$wptb_cookie]) && ($wptbOptions['respect_cookie'] = "always"))
		echo "<br><code>WP-TopBar Debug Mode: Cookie Value: ". $_COOKIE[$wptb_cookie]."</code>"; 
	else
		echo "<br><code>WP-TopBar Debug Mode: Cookie not found</code>";
	
	if  ( ($wptbOptions['respect_cookie'] == 'always' ) AND  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] ) ) {
		echo "<br><code>WP-TopBar Debug Mode: TopBar will not show</code>";

	}	
	
	// check for iPhone, iPad or iPod -- they can't use flash 
	
	$browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	
	if (!(stripos($browser,'iPod')) && !(stripos($browser,'iPhone')) && !(stripos($browser,'iPad'))) 
		echo '<br><code>WP-TopBar Debug Mode: Not an iPhone/iPad/iPod Device</code>';
	else 
		echo '<br><code>WP-TopBar Debug Mode: An iPhone/iPad/iPod Device</code>';

	echo '<br><code>WP-TopBar Debug Mode: Filename:',plugin_dir_path(__FILE__),'</code>';
	echo '<br><code>WP-TopBar Debug Mode: --------------------------------------</code>';
	echo '<br><code>WP-TopBar Debug Mode: Using these "wptbAdminOptions" Values:</code>';
	foreach ($wptbOptions as $i => $value) {
		  	echo '<br><code>WP-TopBar Debug Mode:&nbsp&nbsp[',$i,']: ',$value,'</code>';
		}
	echo '<br><code>WP-TopBar Debug Mode: --------------------------------------</code>';
	
}	// End of wptb_debug_display_TopBar_Options


//=========================================================================			
// Creates Table
// Parameter $wptb_echo_on is used for debugging:  
//		1=use echo function, 0=use error_log function
//=========================================================================			
	
function wptb_create_table($wptb_echo_on) { 

	if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
	else $wptb_debug = false;			

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

//	if($wptb_debug)
//		echo '<br><code>WP-TopBar Debug Mode: Creating Table:'.$wptb_table_name.'</code>';
		
	$sql = "CREATE TABLE ". $wptb_table_name. " ( 
		bar_id BIGINT(20) NOT NULL AUTO_INCREMENT,
		wptb_version VARCHAR(20),	
		weighting_points SMALLINT,
		enable_topbar VARCHAR(20), 
		include_pages TEXT,  
		invert_include VARCHAR(20), 
		include_categories TEXT, 
		invert_categories TEXT,
		include_logic TEXT,
		show_homepage VARCHAR(20),
		only_logged_in VARCHAR(20),
		php_text_prefix TEXT,
		php_text_suffix TEXT,
		delay_time INT,
		slide_time INT,  
		display_time INT,
		start_time VARCHAR(20), 
		end_time VARCHAR(20),
		start_time_utc VARCHAR(20), 
		end_time_utc VARCHAR(20), 
		respect_cookie VARCHAR(20),
		cookie_value VARCHAR(20),
		past_cookie_values  VARCHAR(20),
		allow_close VARCHAR(20),
		allow_reopen VARCHAR(20),
		topbar_pos VARCHAR (20),
		scroll_action VARCHAR (20),
		text_color VARCHAR(20),
		bar_color  VARCHAR(20),
		bottom_color VARCHAR(20),
		link_color VARCHAR(20),
		bottom_border_height SMALLINT,
		font_size SMALLINT,
		padding_top SMALLINT,
		padding_bottom SMALLINT,
		margin_top SMALLINT,
		margin_bottom SMALLINT,
		close_button_image TEXT,
		close_button_css TEXT,
		reopen_button_image TEXT,
		reopen_button_css TEXT,
		link_target VARCHAR(20),
		bar_link TEXT,
		bar_text TEXT,
		bar_link_text TEXT,
		text_align VARCHAR(20),
		bar_image TEXT,
		enable_image VARCHAR(20),
		custom_css_bar TEXT,
		custom_css_text TEXT,
		div_css TEXT,
		social_icon1 VARCHAR(20),
		social_icon2 VARCHAR(20),
		social_icon3 VARCHAR(20),
		social_icon4 VARCHAR(20),
		social_icon5 VARCHAR(20),
		social_icon6 VARCHAR(20),
		social_icon7 VARCHAR(20),
		social_icon8 VARCHAR(20),
		social_icon9 VARCHAR(20),
		social_icon10 VARCHAR(20),
		social_icon1_image TEXT,
		social_icon2_image TEXT,
		social_icon3_image TEXT,
		social_icon4_image TEXT,
		social_icon5_image TEXT,
		social_icon6_image TEXT,
		social_icon7_image TEXT,
		social_icon8_image TEXT,
		social_icon9_image TEXT,
		social_icon10_image TEXT,
		social_icon1_link TEXT,
		social_icon2_link TEXT,
		social_icon3_link TEXT,
		social_icon4_link TEXT,
		social_icon5_link TEXT,
		social_icon6_link TEXT,
		social_icon7_link TEXT,
		social_icon8_link TEXT,
		social_icon9_link TEXT,
		social_icon10_link TEXT,
		social_icon1_css TEXT,
		social_icon2_css TEXT,
		social_icon3_css TEXT,
		social_icon4_css TEXT,
		social_icon5_css TEXT,
		social_icon6_css TEXT,
		social_icon7_css TEXT,
		social_icon8_css TEXT,
		social_icon9_css TEXT,
		social_icon10_css TEXT,
		social_icon1_link_target VARCHAR(20),
		social_icon2_link_target VARCHAR(20),
		social_icon3_link_target VARCHAR(20),
		social_icon4_link_target VARCHAR(20),	
		social_icon5_link_target VARCHAR(20),	
		social_icon6_link_target VARCHAR(20),	
		social_icon7_link_target VARCHAR(20),	
		social_icon8_link_target VARCHAR(20),	
		social_icon9_link_target VARCHAR(20),	
		social_icon10_link_target VARCHAR(20),	
		social_icon1_position VARCHAR(20),
		social_icon2_position VARCHAR(20),
		social_icon3_position VARCHAR(20),
		social_icon4_position VARCHAR(20),	
		social_icon5_position VARCHAR(20),	
		social_icon6_position VARCHAR(20),	
		social_icon7_position VARCHAR(20),	
		social_icon8_position VARCHAR(20),	
		social_icon9_position VARCHAR(20),	
		social_icon10_position VARCHAR(20),	
		PRIMARY KEY  id (bar_id)
		) ;";
	
	dbDelta($sql);	


}	// End of wptb_create_table

//=========================================================================		
//
//Returns the default values for every TopBar
//
//=========================================================================		

function wtpb_set_default_settings() {

	global $WPTB_VERSION;

	return array(
	 	'weighting_points'=> 25,				 	
		'wptb_version' => $WPTB_VERSION,
		'enable_topbar' => 'false',
		'include_pages' => '0',
		'invert_include' => 'no',
		'include_categories' => '0',
		'invert_categories' => 'no',
		'include_logic' => 'page_only',
		'show_homepage' => 'conditionally',
		'only_logged_in' => 'all',
		'php_text_prefix' => '',
		'php_text_suffix' => '',
		'delay_time' => '5000',
		'slide_time' => '200',
		'display_time' => '0',
		'start_time' => '0',
		'end_time' => '0',
		'start_time_utc' => '0',
		'end_time_utc' => '0',
		'respect_cookie' => 'ignore',
		'cookie_value' => '1',
		'past_cookie_values' => '1',
		'allow_close' => 'no',
		'allow_reopen' => 'no',
		'topbar_pos' => 'header',
		'scroll_action' => 'off', 
		'text_color' => '#000000',
		'bar_color' => '#ffffff',
		'bottom_color' => '#f90000',
		'link_color' => '#c00000',
		'bottom_border_height' => '3', 
		'font_size' => '14',
		'padding_top' => '8',
		'padding_bottom' => '8',
		'margin_top' => '0',
		'margin_bottom' => '0',
		'close_button_image' => str_ireplace( 'https://','http://',plugins_url('/images/close.png', __FILE__) ),
		'close_button_css' => 'vertical-align:text-bottom;float:right;padding-right:20px;',
		'reopen_button_image' => str_ireplace( 'https://','http://',plugins_url('/images/open.png', __FILE__) ),
		'reopen_button_css' => 'display:none; float:right; left: 0px; width:100%; height: 17px; z-index:9999999; padding-right:10px; margin-right: 10px;color:#fff; width: 35px; height: 33px; text-decoration: none; cursor:pointer;',
		'link_target' => 'blank',
		'bar_link' => 'http://wordpress.org/extend/plugins/wp-topbar/',
		'bar_text' => 'Get your own TopBar ',
		'bar_link_text' => 'from the Wordpress plugin repository',
		'text_align' => 'center',
		'bar_image' => str_ireplace( 'https://','http://',plugins_url('/samples/wp-topbar_sample_image_2.jpg', __FILE__) ),
		'enable_image' => 'true',
		'custom_css_bar' => 'background-repeat: no-repeat;',
		'custom_css_text' => '',
		'div_css' => 'position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;',
		'social_icon1'  => 'off',
		'social_icon2'  => 'off', 
		'social_icon3'  => 'off',
		'social_icon4'  => 'off',
		'social_icon5'  => 'off',
		'social_icon6'  => 'off',
		'social_icon7'  => 'off',
		'social_icon8'  => 'off',
		'social_icon9'  => 'off',
		'social_icon10' => 'off',
		'social_icon1_image'  => str_ireplace( 'https://','http://',plugins_url('/icons/PNG/twitter.png', __FILE__) ),
		'social_icon2_image'  => str_ireplace( 'https://','http://',plugins_url('/icons/PNG/facebook.png', __FILE__) ),
		'social_icon3_image'  => str_ireplace( 'https://','http://',plugins_url('/icons/PNG/google.png', __FILE__) ),
		'social_icon4_image'  => '',
		'social_icon5_image'  => '',
		'social_icon6_image'  => '',
		'social_icon7_image'  => '',
		'social_icon8_image'  => '',
		'social_icon9_image'  => '',
		'social_icon10_image' => '',
		'social_icon1_link'  => 'http://twitter.com/#!/wordpress',
		'social_icon2_link'  => 'http://www.facebook.com/WordPress', 
		'social_icon3_link'  => 'http://plus.google.com/s/wordpress',
		'social_icon4_link'  => '',
		'social_icon5_link'  => '',
		'social_icon6_link'  => '',
		'social_icon7_link'  => '',
		'social_icon8_link'  => '',
		'social_icon9_link'  => '',
		'social_icon10_link' => '',
		'social_icon1_css'  => 'height:23px; vertical-align:text-bottom;',
		'social_icon2_css'  => 'height:23px; vertical-align:text-bottom;',
		'social_icon3_css'  => 'height:23px; vertical-align:text-bottom;',
		'social_icon4_css'  => '',
		'social_icon5_css'  => '',
		'social_icon6_css'  => '',
		'social_icon7_css'  => '',
		'social_icon8_css'  => '',
		'social_icon9_css'  => '',
		'social_icon10_css' => '',
		'social_icon1_link_target'  => 'blank',
		'social_icon2_link_target'  => 'blank',
		'social_icon3_link_target'  => 'blank',
		'social_icon4_link_target'  => 'blank',
		'social_icon5_link_target'  => 'blank',
		'social_icon6_link_target'  => 'blank',
		'social_icon7_link_target'  => 'blank',
		'social_icon8_link_target'  => 'blank',
		'social_icon9_link_target'  => 'blank',
		'social_icon10_link_target' => 'blank',
		'social_icon1_position'  => 'right',
		'social_icon2_position'  => 'right',
		'social_icon3_position'  => 'right',
		'social_icon4_position'  => 'right',
		'social_icon5_position'  => 'right',
		'social_icon6_position'  => 'right',
		'social_icon7_position'  => 'right',
		'social_icon8_position'  => 'right',
		'social_icon9_position'  => 'right',
		'social_icon10_position' => 'right'
		);

}	// End of wtpb_set_default_settings

//=========================================================================		
//
//Inserts a row in the database with the default values
//
//=========================================================================		

function wtpb_insert_default_row($wptb_echo_on) {

//	if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
//	else $wptb_debug = false;			

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

//	if ($wptb_debug)
//		echo '<br><code>WP-TopBar Debug Mode: Inserting Default Row in: '.$wptb_table_name.'</code>';
	
	$rows_affected = $wpdb->insert( $wptb_table_name, wtpb_set_default_settings() );
	
	return wtpb_set_default_settings();

}	// End of wtpb_insert_default_row

//=========================================================================		
//
//Inserts a new row into the database
//
//=========================================================================		

function wtpb_insert_row($wptbOptions, $wptb_echo_on) {

	if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
	else $wptb_debug = false;			
	
	
	// set any missing default values (this may occur if user using an old version of wp-topbar)
	
	$wptbDefaultValues=wtpb_set_default_settings();
	
	foreach ( $wptbDefaultValues as $option_name => $value ) {
		if (! isset( $wptbOptions[$option_name] ))  $wptbOptions[$option_name] = $value;
	}

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: Inserting Row in:'.$wptb_table_name.'</code>';
		
	$rows_affected = $wpdb->insert( $wptb_table_name, array(
	 	'weighting_points'=> $wptbOptions[ 'weighting_points' ],				 	
		'wptb_version' => $wptbOptions[ 'wptb_version' ],
		'enable_topbar' => $wptbOptions[ 'enable_topbar' ],
		'include_pages' => $wptbOptions[ 'include_pages' ],
		'invert_include' => $wptbOptions[ 'invert_include' ],
		'include_categories' => $wptbOptions[ 'include_categories' ],
		'invert_categories' => $wptbOptions[ 'invert_categories' ],
		'include_logic' => $wptbOptions[ 'include_logic' ],
		'show_homepage' => $wptbOptions[ 'show_homepage' ],
		'only_logged_in' => $wptbOptions[ 'only_logged_in' ],
		'php_text_prefix' => $wptbOptions[ 'php_text_prefix' ],
		'php_text_suffix' => $wptbOptions[ 'php_text_suffix' ],
		'delay_time' => $wptbOptions[ 'delay_time' ],
		'slide_time' => $wptbOptions[ 'slide_time' ],
		'display_time' => $wptbOptions[ 'display_time' ],
		'start_time' => $wptbOptions[ 'start_time' ],
		'end_time' => $wptbOptions[ 'end_time' ],
		'start_time_utc' => $wptbOptions[ 'start_time_utc' ],
		'end_time_utc' => $wptbOptions[ 'end_time_utc' ],
		'respect_cookie' => $wptbOptions[ 'respect_cookie' ],
		'cookie_value' => $wptbOptions[ 'cookie_value' ],
		'past_cookie_values' => $wptbOptions[ 'past_cookie_values' ],
		'allow_close' => $wptbOptions[ 'allow_close' ],
		'allow_reopen' => $wptbOptions[ 'allow_reopen' ],
		'topbar_pos' => $wptbOptions[ 'topbar_pos' ],
		'scroll_action' => $wptbOptions[ 'scroll_action' ], 
		'text_color' => $wptbOptions[ 'text_color' ],
		'bar_color' => $wptbOptions[ 'bar_color' ],
		'bottom_color' => $wptbOptions[ 'bottom_color' ],
		'link_color' => $wptbOptions[ 'link_color' ],
		'bottom_border_height' => $wptbOptions[ 'bottom_border_height' ], 
		'font_size' => $wptbOptions[ 'font_size' ],
		'padding_top' => $wptbOptions[ 'padding_top' ],
		'padding_bottom' => $wptbOptions[ 'padding_bottom' ],
		'margin_top' => $wptbOptions[ 'margin_top' ],
		'margin_bottom' => $wptbOptions[ 'margin_bottom' ],
		'close_button_image' => $wptbOptions[ 'close_button_image' ],
		'close_button_css' => $wptbOptions[ 'close_button_css' ],
		'reopen_button_image' => $wptbOptions[ 'reopen_button_image' ],
		'reopen_button_css' => $wptbOptions[ 'reopen_button_css' ],
		'link_target' => $wptbOptions[ 'link_target' ],
		'bar_link' => $wptbOptions[ 'bar_link' ],
		'bar_text' => $wptbOptions[ 'bar_text' ],
		'bar_link_text' => $wptbOptions[ 'bar_link_text' ],
		'text_align' => $wptbOptions[ 'text_align' ],
		'bar_image' => $wptbOptions[ 'bar_image' ],
		'enable_image' => $wptbOptions[ 'enable_image' ],
		'custom_css_bar' => $wptbOptions[ 'custom_css_bar' ],
		'custom_css_text' => $wptbOptions[ 'custom_css_text' ],
		'div_css' => $wptbOptions[ 'div_css' ],
		'social_icon1' => $wptbOptions[ 'social_icon1' ],
		'social_icon2' => $wptbOptions[ 'social_icon2' ], 
		'social_icon3' => $wptbOptions[ 'social_icon3' ],
		'social_icon4' => $wptbOptions[ 'social_icon4' ],
		'social_icon5' => $wptbOptions[ 'social_icon5' ],
		'social_icon6' => $wptbOptions[ 'social_icon6' ],
		'social_icon7' => $wptbOptions[ 'social_icon7' ],
		'social_icon8' => $wptbOptions[ 'social_icon8' ],
		'social_icon9' => $wptbOptions[ 'social_icon9' ],
		'social_icon10' => $wptbOptions[ 'social_icon10' ],
		'social_icon1_image' => $wptbOptions[ 'social_icon1_image' ],
		'social_icon2_image' => $wptbOptions[ 'social_icon2_image' ],
		'social_icon3_image' => $wptbOptions[ 'social_icon3_image' ],
		'social_icon4_image' => $wptbOptions[ 'social_icon4_image' ],
		'social_icon5_image' => $wptbOptions[ 'social_icon5_image' ],
		'social_icon6_image' => $wptbOptions[ 'social_icon6_image' ],
		'social_icon7_image' => $wptbOptions[ 'social_icon7_image' ],
		'social_icon8_image' => $wptbOptions[ 'social_icon8_image' ],
		'social_icon9_image' => $wptbOptions[ 'social_icon9_image' ],
		'social_icon10_image' => $wptbOptions[ 'social_icon10_image' ],
		'social_icon1_link' => $wptbOptions[ 'social_icon1_link' ],
		'social_icon2_link' => $wptbOptions[ 'social_icon2_link' ], 
		'social_icon3_link' => $wptbOptions[ 'social_icon3_link' ],
		'social_icon4_link' => $wptbOptions[ 'social_icon4_link' ],
		'social_icon5_link' => $wptbOptions[ 'social_icon5_link' ],
		'social_icon6_link' => $wptbOptions[ 'social_icon6_link' ],
		'social_icon7_link' => $wptbOptions[ 'social_icon7_link' ],
		'social_icon8_link' => $wptbOptions[ 'social_icon8_link' ],
		'social_icon9_link' => $wptbOptions[ 'social_icon9_link' ],
		'social_icon10_link' => $wptbOptions[ 'social_icon10_link' ],
		'social_icon1_css' => $wptbOptions[ 'social_icon1_css' ],
		'social_icon2_css' => $wptbOptions[ 'social_icon2_css' ],
		'social_icon3_css' => $wptbOptions[ 'social_icon3_css' ],
		'social_icon4_css' => $wptbOptions[ 'social_icon4_css' ],
		'social_icon5_css' => $wptbOptions[ 'social_icon5_css' ],
		'social_icon6_css' => $wptbOptions[ 'social_icon6_css' ],
		'social_icon7_css' => $wptbOptions[ 'social_icon7_css' ],
		'social_icon8_css' => $wptbOptions[ 'social_icon8_css' ],
		'social_icon9_css' => $wptbOptions[ 'social_icon9_css' ],
		'social_icon10_css' => $wptbOptions[ 'social_icon10_css' ],
		'social_icon1_link_target' => $wptbOptions[ 'social_icon1_link_target' ],
		'social_icon2_link_target' => $wptbOptions[ 'social_icon2_link_target' ],
		'social_icon3_link_target' => $wptbOptions[ 'social_icon3_link_target' ],
		'social_icon4_link_target' => $wptbOptions[ 'social_icon4_link_target' ],
		'social_icon5_link_target' => $wptbOptions[ 'social_icon5_link_target' ],
		'social_icon6_link_target' => $wptbOptions[ 'social_icon6_link_target' ],
		'social_icon7_link_target' => $wptbOptions[ 'social_icon7_link_target' ],
		'social_icon8_link_target' => $wptbOptions[ 'social_icon8_link_target' ],
		'social_icon9_link_target' => $wptbOptions[ 'social_icon9_link_target' ],
		'social_icon10_link_target' => $wptbOptions[ 'social_icon10_link_target' ],
		'social_icon1_position' => $wptbOptions[ 'social_icon1_position' ],
		'social_icon2_position' => $wptbOptions[ 'social_icon2_position' ],
		'social_icon3_position' => $wptbOptions[ 'social_icon3_position' ],
		'social_icon4_position' => $wptbOptions[ 'social_icon4_position' ],
		'social_icon5_position' => $wptbOptions[ 'social_icon5_position' ],
		'social_icon6_position' => $wptbOptions[ 'social_icon6_position' ],
		'social_icon7_position' => $wptbOptions[ 'social_icon7_position' ],
		'social_icon8_position' => $wptbOptions[ 'social_icon8_position' ],
		'social_icon9_position' => $wptbOptions[ 'social_icon9_position' ],
		'social_icon10_position' => $wptbOptions[ 'social_icon10_position' ]		
		) );


}	// End of wtpb_insert_row

//=========================================================================		
//
//Updates a row in the table with new values
//
//=========================================================================		


function wptb_update_row($wptbOptions, $wptb_echo_on) {

	if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
	else $wptb_debug = false;			

	// set any missing default values (this may occur if user using an old version of wp-topbar)
	
	$wptbDefaultValues=wtpb_set_default_settings();
	foreach ( $wptbDefaultValues as $option_name => $value ) {
		if (! isset( $wptbOptions[$option_name] ))  $wptbOptions[$option_name] = $value;
	}

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: Updating Row '. $wptbOptions[ 'bar_id' ].' in '.$wptb_table_name.'</code>';
		
	$rows_affected = $wpdb->update( $wptb_table_name, array(
	 	'weighting_points'=> $wptbOptions[ 'weighting_points' ],				 	
		'wptb_version' => $wptbOptions[ 'wptb_version' ],
		'enable_topbar' => $wptbOptions[ 'enable_topbar' ],
		'include_pages' => $wptbOptions[ 'include_pages' ],
		'invert_include' => $wptbOptions[ 'invert_include' ],
		'include_categories' => $wptbOptions[ 'include_categories' ],
		'invert_categories' => $wptbOptions[ 'invert_categories' ],
		'include_logic' => $wptbOptions[ 'include_logic' ],
		'show_homepage' => $wptbOptions[ 'show_homepage' ],
		'only_logged_in' => $wptbOptions[ 'only_logged_in' ],
		'php_text_prefix' => $wptbOptions[ 'php_text_prefix' ],
		'php_text_suffix' => $wptbOptions[ 'php_text_suffix' ],
		'delay_time' => $wptbOptions[ 'delay_time' ],
		'slide_time' => $wptbOptions[ 'slide_time' ],
		'display_time' => $wptbOptions[ 'display_time' ],
		'start_time' => $wptbOptions[ 'start_time' ],
		'end_time' => $wptbOptions[ 'end_time' ],
		'start_time_utc' => $wptbOptions[ 'start_time_utc' ],
		'end_time_utc' => $wptbOptions[ 'end_time_utc' ],
		'respect_cookie' => $wptbOptions[ 'respect_cookie' ],
		'cookie_value' => $wptbOptions[ 'cookie_value' ],
		'past_cookie_values' => $wptbOptions[ 'past_cookie_values' ],
		'allow_close' => $wptbOptions[ 'allow_close' ],
		'allow_reopen' => $wptbOptions[ 'allow_reopen' ],
		'topbar_pos' => $wptbOptions[ 'topbar_pos' ],
		'scroll_action' => $wptbOptions[ 'scroll_action' ], 
		'text_color' => $wptbOptions[ 'text_color' ],
		'bar_color' => $wptbOptions[ 'bar_color' ],
		'bottom_color' => $wptbOptions[ 'bottom_color' ],
		'link_color' => $wptbOptions[ 'link_color' ],
		'bottom_border_height' => $wptbOptions[ 'bottom_border_height' ], 
		'font_size' => $wptbOptions[ 'font_size' ],
		'padding_top' => $wptbOptions[ 'padding_top' ],
		'padding_bottom' => $wptbOptions[ 'padding_bottom' ],
		'margin_top' => $wptbOptions[ 'margin_top' ],
		'margin_bottom' => $wptbOptions[ 'margin_bottom' ],
		'close_button_image' => $wptbOptions[ 'close_button_image' ],
		'close_button_css' =>    preg_replace("/\n|\r/", " ",trim($wptbOptions[ 'close_button_css' ])),
		'reopen_button_image' => $wptbOptions[ 'reopen_button_image' ],
		'reopen_button_css' => preg_replace("/\n|\r/", " ",trim($wptbOptions[ 'reopen_button_css' ])),
		'link_target' => $wptbOptions[ 'link_target' ],
		'bar_link' => $wptbOptions[ 'bar_link' ],
		'bar_text' => $wptbOptions[ 'bar_text' ],
		'bar_link_text' => $wptbOptions[ 'bar_link_text' ],
		'text_align' => $wptbOptions[ 'text_align' ],
		'bar_image' => $wptbOptions[ 'bar_image' ],
		'enable_image' => $wptbOptions[ 'enable_image' ],
		'custom_css_bar' =>    preg_replace("/\n|\r/", " ",trim($wptbOptions[ 'custom_css_bar' ])),
		'custom_css_text' =>    preg_replace("/\n|\r/", " ",trim($wptbOptions[ 'custom_css_text' ])),
		'div_css' =>    preg_replace("/\n|\r/", " ",trim($wptbOptions[ 'div_css' ])),
		'social_icon1' => $wptbOptions[ 'social_icon1' ],
		'social_icon2' => $wptbOptions[ 'social_icon2' ], 
		'social_icon3' => $wptbOptions[ 'social_icon3' ],
		'social_icon4' => $wptbOptions[ 'social_icon4' ],
		'social_icon5' => $wptbOptions[ 'social_icon5' ],
		'social_icon6' => $wptbOptions[ 'social_icon6' ],
		'social_icon7' => $wptbOptions[ 'social_icon7' ],
		'social_icon8' => $wptbOptions[ 'social_icon8' ],
		'social_icon9' => $wptbOptions[ 'social_icon9' ],
		'social_icon10' => $wptbOptions[ 'social_icon10' ],
		'social_icon1_image' => $wptbOptions[ 'social_icon1_image' ],
		'social_icon2_image' => $wptbOptions[ 'social_icon2_image' ],
		'social_icon3_image' => $wptbOptions[ 'social_icon3_image' ],
		'social_icon4_image' => $wptbOptions[ 'social_icon4_image' ],
		'social_icon5_image' => $wptbOptions[ 'social_icon5_image' ],
		'social_icon6_image' => $wptbOptions[ 'social_icon6_image' ],
		'social_icon7_image' => $wptbOptions[ 'social_icon7_image' ],
		'social_icon8_image' => $wptbOptions[ 'social_icon8_image' ],
		'social_icon9_image' => $wptbOptions[ 'social_icon9_image' ],
		'social_icon10_image' => $wptbOptions[ 'social_icon10_image' ],
		'social_icon1_link' => $wptbOptions[ 'social_icon1_link' ],
		'social_icon2_link' => $wptbOptions[ 'social_icon2_link' ], 
		'social_icon3_link' => $wptbOptions[ 'social_icon3_link' ],
		'social_icon4_link' => $wptbOptions[ 'social_icon4_link' ],
		'social_icon5_link' => $wptbOptions[ 'social_icon5_link' ],
		'social_icon6_link' => $wptbOptions[ 'social_icon6_link' ],
		'social_icon7_link' => $wptbOptions[ 'social_icon7_link' ],
		'social_icon8_link' => $wptbOptions[ 'social_icon8_link' ],
		'social_icon9_link' => $wptbOptions[ 'social_icon9_link' ],
		'social_icon10_link' => $wptbOptions[ 'social_icon10_link' ],
		'social_icon1_css' => $wptbOptions[ 'social_icon1_css' ],
		'social_icon2_css' => $wptbOptions[ 'social_icon2_css' ],
		'social_icon3_css' => $wptbOptions[ 'social_icon3_css' ],
		'social_icon4_css' => $wptbOptions[ 'social_icon4_css' ],
		'social_icon5_css' => $wptbOptions[ 'social_icon5_css' ],
		'social_icon6_css' => $wptbOptions[ 'social_icon6_css' ],
		'social_icon7_css' => $wptbOptions[ 'social_icon7_css' ],
		'social_icon8_css' => $wptbOptions[ 'social_icon8_css' ],
		'social_icon9_css' => $wptbOptions[ 'social_icon9_css' ],
		'social_icon10_css' => $wptbOptions[ 'social_icon10_css' ],
		'social_icon1_link_target' => $wptbOptions[ 'social_icon1_link_target' ],
		'social_icon2_link_target' => $wptbOptions[ 'social_icon2_link_target' ],
		'social_icon3_link_target' => $wptbOptions[ 'social_icon3_link_target' ],
		'social_icon4_link_target' => $wptbOptions[ 'social_icon4_link_target' ],
		'social_icon5_link_target' => $wptbOptions[ 'social_icon5_link_target' ],
		'social_icon6_link_target' => $wptbOptions[ 'social_icon6_link_target' ],
		'social_icon7_link_target' => $wptbOptions[ 'social_icon7_link_target' ],
		'social_icon8_link_target' => $wptbOptions[ 'social_icon8_link_target' ],
		'social_icon9_link_target' => $wptbOptions[ 'social_icon9_link_target' ],
		'social_icon10_link_target' => $wptbOptions[ 'social_icon10_link_target' ],
		'social_icon1_position' => $wptbOptions[ 'social_icon1_position' ],
		'social_icon2_position' => $wptbOptions[ 'social_icon2_position' ],
		'social_icon3_position' => $wptbOptions[ 'social_icon3_position' ],
		'social_icon4_position' => $wptbOptions[ 'social_icon4_position' ],
		'social_icon5_position' => $wptbOptions[ 'social_icon5_position' ],
		'social_icon6_position' => $wptbOptions[ 'social_icon6_position' ],
		'social_icon7_position' => $wptbOptions[ 'social_icon7_position' ],
		'social_icon8_position' => $wptbOptions[ 'social_icon8_position' ],
		'social_icon9_position' => $wptbOptions[ 'social_icon9_position' ],
		'social_icon10_position' => $wptbOptions[ 'social_icon10_position' ]
		),
		array('bar_id' => $wptbOptions[ 'bar_id' ] )
		);


}	// End of wptb_update_row

//=========================================================================			
// Toggles Enable/Disable of a Row
//=========================================================================			

function wptb_toggle_enabled($tab,$wptb_barid,$wptbOptions,$wptb_debug) {

	
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Toggle Settings for Bar #: '.$wptb_barid.' - '.$tab.'</code>';

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	
	if ( $tab == 'enable' )	
		$wptbOptions['enable_topbar'] ='true';
	else
		$wptbOptions['enable_topbar'] ='false';
		
	$wpdb->query( 
		$wpdb->prepare( 
			"
             UPDATE ".$wptb_table_name." SET `enable_topbar` = '".$wptbOptions['enable_topbar'] ."' WHERE bar_id = %d
            ",
		        $wptb_barid 
	        )
	);
	$wptbOptions=array();
//	echo '<div class="updated"><p><strong>Settings Updated for TopBar #'.$wptb_barid.'.</strong></p></div>';
	return $wptbOptions;

}	// End of wptb_toggle_enabled

//=========================================================================			
// Deletes a row in the database
//=========================================================================			

function wptb_delete_settings($wptb_barid, $wptb_debug) {	
	
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Deleting Settings for Bar #: '.$wptb_barid.'</code>';

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	
	
	$wpdb->query( 
		$wpdb->prepare( 
			"
             DELETE FROM ".$wptb_table_name." WHERE bar_id = %d
            ",
		        $wptb_barid 
	        )
	);
	$wptbOptions=array();
//  need to set transient to show that a row was deleted
//	echo '<div class="updated"><p><strong>Settings Deleted.</strong></p></div>';
	
}	// End of wptb_delete_settings


//=========================================================================			
// Bulk Update CloseButton Settings 
//=========================================================================			

function wptb_bulkupdate_CloseButtonSettings() {

//	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Bulk Update Close Button Settings </code>';

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	
	$sql="  ";

	if (isset($_POST['wptballowclose'])) {
		$sql .= "`allow_close` = '".$_POST['wptballowclose']."', ";
	}
	if (isset($_POST['wptballowreopen'])) {
		$sql .= "`allow_reopen` = '".$_POST['wptballowreopen']."', ";
	}
	if (isset($_POST['wptbrespectcookie'])) {
		$sql .= "`respect_cookie` = '".$_POST['wptbrespectcookie']."', ";
	}
	if (isset($_POST['wptbcookievalue'])) {
		$sql .= "`cookie_value` = '".$_POST['wptbcookievalue']."', ";
		$sql .= "`past_cookie_values` = '', ";	
	}
	if (isset($_POST['wptbcloseimage'])) {
		$sql .= "`close_button_image` = '".esc_url($_POST['wptbcloseimage'])."', ";
	}	
	if (isset($_POST['wptbclosecss'])) {
		$sql .= "`close_button_css` = '".$_POST['wptbclosecss']."', ";
	}
	if (isset($_POST['wptbreopenimage'])) {
		$sql .= "`reopen_button_image` = '".esc_url($_POST['wptbreopenimage'])."', ";
	}	
	if (isset($_POST['wptbreopencss'])) {
		$sql .= "`reopen_button_css` = '".$_POST['wptbreopencss']."', ";
	}
	
	$sql=substr($sql,0,-2);

	if ( $sql != "" ) {
		$wpdb->query( 
			"
	         UPDATE ".$wptb_table_name." SET ".$sql
	        
		);
	}


}	// End of wptb_bulkupdate_CloseButtonsettings

//=========================================================================			
// Update Settings 
//=========================================================================			

function wptb_update_settings($wptb_barid, $wptb_debug) {	
	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In Update Settings</code>';
	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: Loading Settings for ID: '.$wptb_barid.'</code>';
		
	$wptbOptions = wptb_get_Specific_TopBar($wptb_barid,true);

	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: Checking for Changes in Settings via POST</code>';

	if (isset($_POST['wptbenabletopbar'])) {
		$wptbOptions['enable_topbar'] = $_POST['wptbenabletopbar'];
	}
	if (isset($_POST['wptbpriority'])) {
	
		if (!is_numeric($_POST['wptbpriority'])) {
			echo '<div class="error"><strong>Priority is not numeric. Resetting to 25.</strong></div>';
			$wptbOptions['weighting_points'] = 25;
		} 
		else 	
			$wptbOptions['weighting_points'] = $_POST['wptbpriority']+0;
			if ( $wptbOptions['weighting_points'] > 100 ) {
				echo '<div class="error"><strong>Priority is greater than 100. Resetting to 100.</strong></div>';
				$wptbOptions['weighting_points'] = 100;				
			}
			else if ( $wptbOptions['weighting_points'] < 0 ) {
				echo '<div class="error"><strong>Priority is less than 1. Resetting to 1.</strong></div>';
				$wptbOptions['weighting_points'] = 1;				
			}
	}
	if (isset($_POST['wptbtextcolor'])) {
		$wptbOptions['text_color'] = $_POST['wptbtextcolor'];
	}	
	if (isset($_POST['wptbbarcolor'])) {
		$wptbOptions['bar_color'] = $_POST['wptbbarcolor'];
	}
	if (isset($_POST['wptbbottomcolor'])) {
		$wptbOptions['bottom_color'] = $_POST['wptbbottomcolor'];
	}	
	if (isset($_POST['wptblinkcolor'])) {
		$wptbOptions['link_color'] = $_POST['wptblinkcolor'];
	}
	if (isset($_POST['wptbincludepages'])) {
		$wptbOptions['include_pages'] = $_POST['wptbincludepages'];
	}
	if (isset($_POST['wptbinvertinclude'])) {
		$wptbOptions['invert_include'] = $_POST['wptbinvertinclude'];
	}
	if (isset($_POST['wptbincludecategories'])) {
		$wptbOptions['include_categories'] = $_POST['wptbincludecategories'];
	}
	if (isset($_POST['wptbinvertcategories'])) {
		$wptbOptions['invert_categories'] = $_POST['wptbinvertcategories'];
	}
	if (isset($_POST['wptbincludelogic'])) {
		$wptbOptions['include_logic'] = $_POST['wptbincludelogic'];
	}		
	if (isset($_POST['wptbshowhomepage'])) {
		$wptbOptions['show_homepage'] = $_POST['wptbshowhomepage'];
	}	
	if (isset($_POST['wptbonlyloggedin'])) {
		$wptbOptions['only_logged_in'] = $_POST['wptbonlyloggedin'];
	}	
	if (isset($_POST['wptbphptextprefix'])) {
		$wptbOptions['php_text_prefix'] = $_POST['wptbphptextprefix'];
	}		
	if (isset($_POST['wptbphptextsuffix'])) {
		$wptbOptions['php_text_suffix'] = $_POST['wptbphptextsuffix'];
	}	
	if (isset($_POST['wptbbottomborderheight'])) {
	
		if (!is_numeric($_POST['wptbbottomborderheight'])) {
			echo '<div class="error"><strong>Bottom border height is not numeric. Resetting to 3px.</strong></div>';
				$wptbOptions['bottom_border_height'] = 3;
		} 
		else 	
			$wptbOptions['bottom_border_height'] = $_POST['wptbbottomborderheight']+0;
	}
	if (isset($_POST['wptbdelayintime'])) {
	
		if (!is_numeric($_POST['wptbdelayintime'])) {
			echo '<div class="error"><strong>Delay time is not numeric. Resetting to zero.</strong></div>';
				$wptbOptions['delay_time'] = 0;
		} 
		else 	
			$wptbOptions['delay_time'] = $_POST['wptbdelayintime']+0;
	}
	if (isset($_POST['wptbslidetime'])) {
	
		if (!is_numeric($_POST['wptbslidetime'])) {
			echo '<div class="error"><strong>Slide time is not numeric. Resetting to zero.</strong></div>';
			$wptbOptions['slide_time'] = 0;
		} 
		else 	
			$wptbOptions['slide_time'] = $_POST['wptbslidetime']+0;
	}
	if (isset($_POST['wptbdisplaytime'])) {
	
		if (!is_numeric($_POST['wptbdisplaytime'])) {
			echo '<div class="error"><strong>Display time is not numeric. Resetting to zero.</strong></div>';
			$wptbOptions['display_time'] = 0;
		} 
		else 	
			$wptbOptions['display_time'] = $_POST['wptbdisplaytime']+0;
	}			
	if (isset($_POST['wptbstarttime'])) {
				
			$wptbOptions['start_time'] = $_POST['wptbstarttime'];
			$wptbOptions['start_time_utc'] = $_POST['wptbstarttime'];
	}
	if (isset($_POST['wptbendtime'])) {

		$wptbOptions['end_time'] = $_POST['wptbendtime'];
		$wptbOptions['end_time_utc'] = $_POST['wptbendtime'];
	}
	if (isset($_POST['wptbfontsize'])) {
	
		if (!is_numeric($_POST['wptbfontsize'])) {
			echo '<div class="error"><strong>Top padding is not numeric. Resetting to 8px.</strong></div>';
			$wptbOptions['font_size'] = 8;
		} 
		else 	
			$wptbOptions['font_size'] = $_POST['wptbfontsize']+0;
	}						
	if (isset($_POST['wptbpaddingtop'])) {
	
		if (!is_numeric($_POST['wptbpaddingtop'])) {
			echo '<div class="error"><strong>Top padding is not numeric. Resetting to 8px.</strong></div>';
			$wptbOptions['padding_top'] = 8;
		} 
		else 	
			$wptbOptions['padding_top'] = $_POST['wptbpaddingtop']+0;
	}
	if (isset($_POST['wptbpaddingbottom'])) {
	
		if (!is_numeric($_POST['wptbpaddingbottom'])) {
			echo '<div class="error"><strong>Bottom padding is not numeric. Resetting to 8px.</strong></div>';
			$wptbOptions['padding_bottom'] = 8;
		} 
		else 	
			$wptbOptions['padding_bottom'] = $_POST['wptbpaddingbottom']+0;
	}						
	if (isset($_POST['wptbmargintop'])) {
	
		if (!is_numeric($_POST['wptbmargintop'])) {
			echo '<div class="error"><strong>Top margin is not numeric. Resetting to 0px.</strong></div>';
			$wptbOptions['margin_top'] = 0;
		} 
		else 	
			$wptbOptions['margin_top'] = $_POST['wptbmargintop']+0;
	}
	if (isset($_POST['wptbmarginbottom'])) {
	
		if (!is_numeric($_POST['wptbmarginbottom'])) {
			echo '<div class="error"><strong>Bottom margin is not numeric. Resetting to 0px.</strong></div>';
			$wptbOptions['margin_bottom'] = 0;
		} 
		else 	
			$wptbOptions['margin_bottom'] = $_POST['wptbmarginbottom']+0;
	}						
	if (isset($_POST['wptblinkurl'])) {
		$wptbOptions['bar_link'] = $_POST['wptblinkurl'];
	}			
	if (isset($_POST['wptbbartext'])) {
		$wptbOptions['bar_text'] = $_POST['wptbbartext'];
	}
	if (isset($_POST['wptblinktext'])) {
		$wptbOptions['bar_link_text'] = $_POST['wptblinktext'];
	}
	if (isset($_POST['wptbtextalign'])) {
		$wptbOptions['text_align'] = $_POST['wptbtextalign'];
	}
	if (isset($_POST['wptbbarimage'])) {
		$wptbOptions['bar_image'] = $_POST['wptbbarimage'];
	}
	if (isset($_POST['wptbenableimage'])) {
		$wptbOptions['enable_image'] = $_POST['wptbenableimage'];
	}
	if (isset($_POST['wptbcustomcssbar'])) {
		$wptbOptions['custom_css_bar']  = $_POST['wptbcustomcssbar'];
	}
	if (isset($_POST['wptbcustomcsstext'])) {
		$wptbOptions['custom_css_text'] = $_POST['wptbcustomcsstext'];
	}
	if (isset($_POST['wptbdivcss'])) {
		$wptbOptions['div_css'] = $_POST['wptbdivcss'];
	}
	if (isset($_POST['wptballowclose'])) {
		$wptbOptions['allow_close'] = $_POST['wptballowclose'];
	}
	if (isset($_POST['wptballowreopen'])) {
		$wptbOptions['allow_reopen'] = $_POST['wptballowreopen'];
	}	
	if (isset($_POST['wptbrespectcookie'])) {
		$wptbOptions['respect_cookie'] = $_POST['wptbrespectcookie'];
	}
	if (isset($_POST['wptbcookievalue'])) {
	
		$wptbOldCookieValue = $wptbOptions['cookie_value'];
		
		$wptbOptions['cookie_value'] = $_POST['wptbcookievalue'];
		
		$wptbNewCookieValue = $wptbOptions['cookie_value'];

		$wptbPastValues = $wptbOptions['past_cookie_values'];

		if ( $wptbNewCookieValue != $wptbOldCookieValue ) 
			$wptbOptions['past_cookie_values']=	$wptbOldCookieValue;	

	}
	if (isset($_POST['wptbcloseimage'])) {
		$wptbOptions['close_button_image'] = esc_url($_POST['wptbcloseimage']);
	}	
	if (isset($_POST['wptbclosecss'])) {
		$wptbOptions['close_button_css']  = $_POST['wptbclosecss'];
	}
	if (isset($_POST['wptbreopenimage'])) {
		$wptbOptions['reopen_button_image'] = esc_url($_POST['wptbreopenimage']);
	}	
	if (isset($_POST['wptbreopencss'])) {
		$wptbOptions['reopen_button_css']  = $_POST['wptbreopencss'];
	}
	if (isset($_POST['wptblinktarget'])) {
		$wptbOptions['link_target'] = $_POST['wptblinktarget'];
	}
	if (isset($_POST['wptbtopbarpos'])) {
		$wptbOptions['topbar_pos'] = $_POST['wptbtopbarpos'];
	}

	if (isset($_POST['wptbscrollaction'])) {
		$wptbOptions['scroll_action'] = $_POST['wptbscrollaction'];
	}
		
	// need to check the make sure we are the right tab to correctly handle the toggle buttons on the Social Buttons Tab
	
	if ( $_GET['action'] == 'socialbuttons') {

		for ($i=1; $i<=10; $i++)  {
			if (isset($_POST['wptbsocialicon'.$i])) 
				$wptbOptions['social_icon'.$i] = 'on';
			else
				$wptbOptions['social_icon'.$i] = 'off';
			if (isset($_POST['wptbsocialicon'.$i.'image'])) 
				$wptbOptions['social_icon'.$i.'_image'] = $_POST['wptbsocialicon'.$i.'image'];
			if (isset($_POST['wptbsocialicon'.$i.'link'])) 
				$wptbOptions['social_icon'.$i.'_link'] = $_POST['wptbsocialicon'.$i.'link'];
			if (isset($_POST['wptbsocialicon'.$i.'css']))
				$wptbOptions['social_icon'.$i.'_css'] = $_POST['wptbsocialicon'.$i.'css'];
			if (isset($_POST['wptbicon'.$i.'linktarget'])) 
				$wptbOptions['social_icon'.$i.'_link_target'] = $_POST['wptbicon'.$i.'linktarget'];
			if (isset($_POST['wptbicon'.$i.'position'])) 
				$wptbOptions['social_icon'.$i.'_position'] = $_POST['wptbicon'.$i.'position'];
		}			
	}	

// Handle magic quotes -- consolidate all of the handling here for easier debugging and changing of settings

	if ( (get_magic_quotes_gpc() ) &&  ( $wptb_debug ) )
		echo '<br><code>WP-TopBar Debug Mode: Magic Quotes is on</code>';

	$wtpbtextfields = array( '1' => 'custom_css_bar',  '2' => 'bar_text',  '3' => 'custom_css_text', '4' => 'bar_link_text', '5' => 'close_button_css', '6' => 'reopen_button_css' , '7' => 'div_css');

  	foreach( $wtpbtextfields as $number => $field ) {
		if (get_magic_quotes_gpc())
			$wptbOptions[$field] 	 = (str_replace('"',"'",stripslashes($wptbOptions[$field])));
		else
			$wptbOptions[$field] 	 = (str_replace('"',"'",$wptbOptions[$field]));

    }
    
	for ($i=1; $i<=10; $i++)  {
		if (get_magic_quotes_gpc())
			$wptbOptions['social_icon'.$i.'_css'] 	 = (str_replace('"',"'",stripslashes($wptbOptions['social_icon'.$i.'_css'])));
		else
			$wptbOptions['social_icon'.$i.'_css'] 	 = (str_replace('"',"'",$wptbOptions['social_icon'.$i.'_css']));
	
	}
    
	
	wptb_update_row($wptbOptions, $wptb_debug);
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Settings Updated</code>';
	echo '<div class="updated"><p><strong>Settings Updated.</strong></p></div>';
		
	return $wptbOptions;
	
}	// End of wptb_update_settings



//=========================================================================			
// Run this from options page to check
// if upgrade functions need to run.
// Parameter $wptb_echo_on is used for debugging:  
//		1=use echo function, 0=use error_log function
//
// DB Versions Listing:
// 4.17 - added scroll_action field
// 5.0 - added 6 more Social Buttons and ability to place them (left or right) 
//=========================================================================			
	
function wtpb_check_for_plugin_upgrade($wptb_echo_on) { 
		
	global $WPTB_VERSION;
	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";

	$wpdb->hide_errors();	

	$WPTB_DB_VERSION = "5.0";  // rev this only when this changes

	if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
	else $wptb_debug = false;			

	$wptbOptions = get_option('wptbAdminOptions');
				
	// if options are set, then convert to using a database else check to see if database is in use
	if ( isset( $wptbOptions['enable_topbar'] ) ) {
		wptb_create_table($wptb_echo_on);			
		
		if (! isset($wptbOptions['enable_image']) )
			$wptbOptions['enable_image'] = "false";    // default row has this turned on, so turn off since older version may not have this field
								
		wtpb_insert_row($wptbOptions, $wptb_echo_on);	
		delete_option('wptbAdminOptions');
	}
	else {
			if( $wpdb->get_var("show tables like '".$wptb_table_name."'") != $wptb_table_name ) {
				wptb_create_table($wptb_echo_on);				
				wtpb_insert_default_row($wptb_echo_on);
			}
			else {
				// OK, they are using a DB, now check to see if needs to be updated				
				$installed_ver = get_option( "wptb_db_version" );
				if( $installed_ver != $WPTB_DB_VERSION ) 
					wptb_create_table($wptb_echo_on);
			}
	}
	
	update_option( "wptb_db_version", $WPTB_DB_VERSION );
			
	if($wptb_debug) {
		if($wptb_echo_on) {
			echo '<br><code>WP-TopBar Debug Mode: in wtpb_check_for_plugin_upgrade</code>' ;
			echo '<br><code>WP-TopBar Debug Mode: Plugin Version: ',$WPTB_VERSION,'</code>';
		}
		else {
			error_log( 'WP-TopBar Debug Mode: in wtpb_check_for_plugin_upgrade' );
			error_Log( 'WP-TopBar Debug Mode: Plugin Version: '.$WPTB_VERSION);
		}
	}		
	
	
	$wptb_db_version=$wpdb->get_col(  
	"
	SELECT      min(wptb_version)
	FROM        ".$wptb_table_name."
	"
	); 

//	wptb_create_table($wptb_debug);

	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: DB Version: ',$wptb_db_version[0],'</code>';
	
	if ( $wptb_db_version[0] != $WPTB_VERSION ) {
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Version Upgrade Needed</code>';

		$wpdb->get_results( 
			"
			UPDATE ".$wptb_table_name." SET wptb_version='".$WPTB_VERSION."';
			"
		);

	}
	
		
	if($wptb_debug) {
		if($wptb_echo_on) 
			echo '<br><code>WP-TopBar Debug Mode: end of wtpb_check_for_plugin_upgrade</code>' ;
		else
			error_log( 'WP-TopBar Debug Mode: end of wtpb_check_for_plugin_upgrade' );
	}
	
		$wpdb->show_errors();
	
	
} // End of function wtpb_check_for_plugin_upgrade 	




?>
