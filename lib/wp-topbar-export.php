<?php 

/*
export Functions

*/
//=========================================================================			
// Export Options
//=========================================================================			

function wptb_display_export_options() {
	
//	echo $_POST['wptbExportJSON'].'<BR>' ;
//	echo $_POST['wptbExportCSV'].'<BR>' ;

// siteurl broken in 3.4.1
	
	$url=get_option('siteurl');
	$url=get_option('siteurl')."/wp-admin/?page=wp-topbar.php&amp;action=export&amp;noheader=true";

	if ( is_ssl() AND (substr($url, 0, 5) != "https" ) AND ( substr($url, 0, 4) == "http" ) ) {
		$url="https".substr($url,4);
	}
	
//	$url.="/wp-admin/?page=wp-topbar.php&action=export&noheader=true";
	
	
	?>
	
	<div class="wrap">
    <div id="icon-options-general" class="icon32"><br/></div>
    <h2>Export Options</h2>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
  	      <p>Select the <strong>Export Options</strong> buttons to create either a CSV, SQL (insert) or JSON file for download.   Future versions will include an inport functions.</p> 
        </div>
		<div>
		   <form method="post" action="<?php echo $url;?>"></form>
		</div>
	    <form method="post"    action="<?php echo $url;?>">
	        <p class="submit">
	            <input type="submit" name=wptbExportJSON class="button-primary" value="Export Options in JSON Format" />
	            <input type="submit" name=wptbExportSQL class="button-primary"  value="Export Options in SQL Format" />
	            <input type="submit" name=wptbExportCSV class="button-primary"  value="Export Options in CSV Format" />
	        </p>
	    </form>
	</div>
	
	<?php

	
}

function wptb_export_options_csv() {

	// no html output is allows in this function

	if ( ! isset($_REQUEST['page']) || $_REQUEST['page'] != 'wp-topbar.php' )
		return;

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

	// select one row from the database to setup for the get_col_info function
	
	$sql ="SELECT * FROM ".$wptb_table_name." LIMIT 1";
	$mycols = $wpdb->query( $sql, ARRAY_A );
	$mycols = $wpdb->get_col_info();

	$csv_output = "";
	
	foreach ($mycols as $column_name => $column_value) {
		$csv_output .= $column_value.";";
	}
	// trim the trailing end semicolon from the export
	$csv_output = substr($csv_output, 0, -1);

	$csv_output .= "\n";
		
	$sql ="SELECT * FROM ".$wptb_table_name." ORDER BY `bar_id`";

	$myrows = $wpdb->get_results( $sql, ARRAY_A );
	
	$num_rows=$wpdb->num_rows;
	
	$csv_output = "";
	
	$j=0;
	while ( $j < $num_rows ) {	
		foreach ($myrows[$j] as $column_name => $column_value) {
		
		switch ( $column_name ) :
			//format numeric columns
			case 'bar_id':
			case 'weighting_points':
			case 'delay_time':
			case 'slide_time': 
			case 'display_time':
			case 'bottom_border_height':
			case 'font_size':
			case 'padding_top':
			case 'padding_bottom':
			case 'margin_top':
			case 'margin_bottom':
					$csv_output .= $column_value.';';
					break;
			// treat last column differently		
			case 'social_icon4_link_target':
					$csv_output .= "'".$column_value."'\n";
					break;
			//format the remaining -- as text
			default: 
					$csv_output .= "'".$column_value."';";
		endswitch;		
		}
		$j++;
	}

	$file = 'wp_topbar_export';
	$filename = $file."_".date("Y-m-d_H-i",time());

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
	header('Content-disposition: attachment; filename='.$filename.'.csv');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . strlen( $csv_output ) );
    echo $csv_output;
	return;

}	// End of wptb_export_options_csv



function wptb_export_options_json() {

	// no html output is allows in this function

	if ( ! isset($_REQUEST['page']) || $_REQUEST['page'] != 'wp-topbar.php' )
		return;

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

	$sql ="SELECT * FROM ".$wptb_table_name." ORDER BY `bar_id`";

	$myrows = $wpdb->get_results( $sql, ARRAY_A );
	
	$num_rows=$wpdb->num_rows;

	$settings = array();

	
	$j=0;
	while ( $j < $num_rows ) {	
		foreach ($myrows[$j] as $column_name => $column_value) {
			$settings[$j][$column_name] =  $column_value ;
		}
		$j++;
	}
	
//	if ( ! $settings ) return;

    $json_output = json_encode( (array) $settings );
    
	$file = 'wp_topbar_export';
	$filename = $file."_".date("Y-m-d_H-i",time());

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
	header('Content-disposition: attachment; filename='.$filename.'.json');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . strlen( $json_output ) );
    echo $json_output;
	return;

}	// End of wptb_export_options_json

function wptb_export_options_sql() {

	// no html output is allows in this function

	if ( ! isset($_REQUEST['page']) || $_REQUEST['page'] != 'wp-topbar.php' )
		return;

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	
	
	$sql ="SELECT * FROM ".$wptb_table_name." ORDER BY `bar_id`";

	$myrows = $wpdb->get_results( $sql, ARRAY_A );
	
	$num_rows=$wpdb->num_rows;

	$sql_output = '';
	
	$j=0;
	while ( $j < $num_rows ) {	
		foreach ($myrows[$j] as $column_name => $column_value) {
		
		switch ( $column_name ) :
			
			case 'bar_id': $sql_output .= 'INSERT INTO `'.$wptb_table_name.'` VALUES('.$column_value.',';
				  break;
			case 'weighting_points':
			case 'delay_time':
			case 'slide_time': 
			case 'display_time':
			case 'bottom_border_height':
			case 'font_size':
			case 'padding_top':
			case 'padding_bottom':
			case 'margin_top':
			case 'margin_bottom':
					$sql_output .= $column_value.',';
					break;
			case 'social_icon4_link_target':
					$sql_output .= "'".$column_value."');\n";
					break;
			default: 
					$sql_output .= "'".$column_value."',";
		endswitch;		
		}
		$j++;
	}
	
//	if ( ! $settings ) return;
    
	$file = 'wp_topbar_export';
	$filename = $file."_".date("Y-m-d_H-i",time());

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
	header('Content-disposition: attachment; filename='.$filename.'.sql');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . strlen( $sql_output ) );
    echo $sql_output;
	return;

}	// End of wptb_export_options_sql

?>