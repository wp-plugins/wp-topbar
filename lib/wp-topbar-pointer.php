<?php 

/*
Pointer Function

*/


//=========================================================================			
// PHP Options
//=========================================================================			



 
function wptb_pointer_load( $hook_suffix ) {
 
    // Don't run on WP < 3.3
    if ( get_bloginfo( 'version' ) < '3.3' )
        return;
 
    $screen = get_current_screen();
    $screen_id = $screen->id;
 
    // Get pointers for this screen
    $pointers = apply_filters( 'wptb_admin_pointers-' . $screen_id, array() );
    
 
    if ( ! $pointers || ! is_array( $pointers ) )
        return;
  
    // Get dismissed pointers
    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
    $valid_pointers =array();
 
    // Check pointers and remove dismissed ones.
    foreach ( $pointers as $pointer_id => $pointer ) {
 
        // Sanity check
        if ( in_array( $pointer_id, $dismissed ) || empty( $pointer )  || empty( $pointer_id ) || empty( $pointer['target'] ) || empty( $pointer['options'] ) )
            continue;
 
        $pointer['pointer_id'] = $pointer_id;
 
        // Add the pointer to $valid_pointers array
        $valid_pointers['pointers'][] =  $pointer;
    }
    
 
    // No valid pointers? Stop here.
    if ( empty( $valid_pointers ) )
        return;
        
    // Add pointers style to queue.
    wp_enqueue_style( 'wp-pointer' );
 
    // Add pointers script to queue. Add custom script.
    wp_enqueue_script( 'wptb-pointer', plugins_url( './js/wp-topbar-pointers.js', __FILE__ ), array( 'wp-pointer' ) );
 
    // Add pointer options to script.
    wp_localize_script( 'wptb-pointer', 'wptbPointer', $valid_pointers );

}	// End of wptb_pointer_load 



function wptb_register_pointer( $p ) {
   // EDGE: On what edge do we want the pointer to appear. Options are 'top', 'left', 'right', 'bottom'
   // ALIGN: How do we want out custom pointer to align to the element it is attached to. Options are 'left', 'right', 'center'

    $p['417pointer2'] = array(
        'target' => '.wptb-phptexttab',
        'options' => array(
            'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
                __( 'New Features in Version 4.15!' ,'plugindomain'),
                __( 'You can now enter PHP to be executed on each TopBar...note this is for <strong>Advanced Swimmers</strong> only!','plugindomain')
            ),
            'position' => array( 'edge' => 'left', 'align' => 'right' )
        )
    );
    $p['417pointer1'] = array(
        'target' => '.wptb-table',
        'options' => array(
            'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
                __( 'New Features in Version 4.17!' ,'plugindomain'),
                __( 'Check out a new feature in this version:</br></br>You now have a new option to only display the TopBar when the user scrolls the screen. For each ToolBar, look in <strong>Main Options</strong> tab for the new <strong>Scroll Action</strong> option.','plugindomain')
            ),
            'position' => array( 'edge' => 'top', 'align' => 'left' )
        )
    ); 
    return $p;
}


?>