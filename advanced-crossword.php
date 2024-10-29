<?php
/*
* Plugin Name: Advanced Crossword
* Plugin URI: https://tuskcode.com
* Version: 1.0.7
* Author: dan009
* Description: Create a beautiful, responsive 15x15 grid crossword to your liking. You have full control over the blank cells and the clues. Unlimited crossword puzzle in your website. Responsive and lightweight.
* Text Domain: advanced-crossword
* License: GPLv3
*/

if( ! defined('ABSPATH') )
    die;

$Pc_Puzzle_Crossword_MinimalRequiredPhpVersion = '5.2';
if( ! defined('PC_PUZZLE_CROSSWORD_VER')) 
    define('PC_PUZZLE_CROSSWORD_VER', '1.0.7');
if( ! defined('PC_PUZZLE_CROSSWORD_URL')) 
    define( 'PC_PUZZLE_CROSSWORD_URL', plugins_url( '', __FILE__ ) );
if( ! defined('PC_PUZZLE_CROSSWORD_PATH') ) 
    define('PC_PUZZLE_CROSSWORD_PATH', wp_normalize_path( plugin_dir_path( __FILE__ )) );
if( ! defined('PC_PUZZLE_CROSSWORD_SHORTCODE') )
    define( 'PC_PUZZLE_CROSSWORD_SHORTCODE', 'ADVANCED_CROSSWORD');

/* Check the php version, and display a message if the running version is lower than the required on */

function PcPuzzleCrossword_noticePhpVersionWrong(){
    global $Pc_Puzzle_Crossword_MinimalRequiredPhpVersion;
    echo esc_html('<div class="updated fade">') .
        esc_html__( 'Error: Plugin "Puzzle Crossword" requires a higher version of PHP to be running.', 'advanced-crossword' ) .
        '<br/>' . esc_html__('Minimal version of PHP required: ', 'advanced-crossword' ) . '<strong>' . $Pc_Puzzle_Crossword_MinimalRequiredPhpVersion . '</strong>'.
        '<br/>' . esc_html__('Your server\'s PHP version: ', 'advanced-crossword' ) . '<strong>' . phpversion() . '</strong></div>';
}

function PcPuzzleCrossword_PhpVersionCheck(){
    global $Pc_Puzzle_Crossword_MinimalRequiredPhpVersion;
    if( version_compare(phpversion(), $Pc_Puzzle_Crossword_MinimalRequiredPhpVersion ) < 0 ){
        add_action('admin_notices', 'PcPuzzleCrossword_noticePhpVersionWrong');
        return false;
    }
    return true;
}

function Pc_Puzzle_Crossword_i18n_init(){
    $pluginDir = dirname( plugin_basename(__FILE__) );
    load_plugin_textdomain( 'advanced-crossword' , false, $pluginDir . '/languages/');
}

if( PcPuzzleCrossword_PhpVersionCheck() ){    
    include_once( 'Pc_Puzzle_Crossword_init.php'); 
    if( function_exists('PcPuzzleCrossword_init')){   
        PcPuzzleCrossword_init( __FILE__ );
    }
}

add_action( 'init', 'Pc_Puzzle_Crossword_i18n_init');    