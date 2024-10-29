<?php
include_once('includes/PcPUzzleCrosswords_OptionsManager.php');

if( ! defined('WP_UNINSTALL_PLUGIN'))
    die;

global $wpdb;

use PcPUzzleCrosswords_OptionsManager\PcPUzzleCrosswords_OptionsManager as PcPUzzleCrosswords_OptionsManager;

$pc_crossword = new PcPUzzleCrosswords_OptionsManager();
$pc_main_table = $wpdb->prefix . 'puzzle_crossword';

if ( !is_multisite() ) {

    try {
    
        $pc_crossword->deleteOption( '_installed');
        $pc_crossword->deleteOption( '_version');
        $pc_crossword->deleteOption( 'rules');
        $pc_crossword->deleteOption( 'crossword_rules');
        $pc_crossword->deleteOption( 'settings');
        
        //not working with prepare statement.
        $wpdb->query(  
            $wpdb->prepare( 
                "DROP TABLE IF EXISTS %i", 
                $pc_main_table
        )); 

    } catch (\Throwable $th) {
        error_log( $th->getMessage() );
    }

}else {

    global $wpdb;
    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
    $original_blog_id = get_current_blog_id();

    foreach ( $blog_ids as $blog_id ) {

        try {          

            switch_to_blog( $blog_id );
            
            $pc_crossword = new PcPUzzleCrosswords_OptionsManager();

            $pc_crossword->deleteOption( '_installed');
            $pc_crossword->deleteOption( '_version');   
            $pc_crossword->deleteOption( 'rules');
            $pc_crossword->deleteOption( 'crossword_rules');
            $pc_crossword->deleteOption( 'settings');
        
            //not working with prepare statement.
            $wpdb->query(  
                $wpdb->prepare( 
                    "DROP TABLE IF EXISTS %i", 
                    $pc_main_table
            ));   
        
        } catch (\Throwable $th) {
            //throw $th;
        }
  
    }

    switch_to_blog( $original_blog_id );
}