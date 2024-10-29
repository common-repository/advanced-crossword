<?php

if( ! defined('ABSPATH') ) die;

require_once( 'includes/PcPuzzleCrossword_Plugin.php');

use PcPuzzleCrossword_Plugin as CrosswordPlugin;

if( ! function_exists('PcPuzzleCrossword_init')){
    
    function PcPuzzleCrossword_init( $file ){

        $pcPuzzleCrossword_aPlugin = new CrosswordPlugin\PcPuzzleCrossword_Plugin();
        
        if( $pcPuzzleCrossword_aPlugin->getVersionSaved() != PC_PUZZLE_CROSSWORD_VER ){
            $pcPuzzleCrossword_aPlugin->setVersionSaved( PC_PUZZLE_CROSSWORD_VER );    
            $pcPuzzleCrossword_aPlugin->install();
    
        }else{
            $pcPuzzleCrossword_aPlugin->upgrade();      
        }
        
        $pcPuzzleCrossword_aPlugin->addActionsAndFilters();

        if( ! $file )
            $file = __FILE__;
    
        register_activation_hook( $file, array( &$pcPuzzleCrossword_aPlugin, 'activate') );

        register_deactivation_hook( $file, array( &$pcPuzzleCrossword_aPlugin, 'deactivate') );        
        
    }

}