<?php

namespace PcPuzzleCrossword_Plugin;

if( ! defined('ABSPATH') ) die;

include_once( 'PcPuzzleCrossword_LifeCycle.php');
use PcPuzzleCrossword_LifeCycle;

class PcPuzzleCrossword_Plugin extends PcPuzzleCrossword_LifeCycle\PcPuzzleCrossword_LifeCycle{

    function __construct(){
        parent::__construct();
    }
    
    public function getPluginDisplayName(){
        return 'Advanced Crossword';
    }

    public function getPluginSettingsDisplayName(){
        return esc_html__('Settings', 'advanced-crossword' );
    }

    public function getPluginInfoDisplayName(){
        return esc_html__('License', 'advanced-crossword' );
    }

    public function getPluginReleasesDisplayName(){
        return esc_html__('Releases & How To', 'advanced-crossword' );
    }

    private function createMainTable( $table_name, $charset_collate ){
        $sql_query =  "CREATE TABLE IF NOT EXISTS {$table_name} (
                    id mediumint(5) NOT NULL auto_increment,
                    pc_name varchar(50) NOT NULL default '',
                    is_active int(1) NOT NULL default '1', 
                    rows_no mediumint(5) NOT NULL default '15',
                    cols_no mediumint(5) NOT NULL default '15', 
                    deleted int(1) NOT NULL default '0',                                                   
                    shrt_extra varchar(250) NOT NULL default '',
                    pdf_filename varchar(200) NOT NULL default '',
                    shrt_ckb  int(1) NOT NULL default '0',
                    field_logic int(1) NOT NULL default '0',
                    field_int int(10) NOT NULL default '0',
                    field_char varchar(100) NOT NULL default '', 
                    field_char_two varchar(100) NOT NULL default '', 
                    data_json text NOT NULL default '',
                    data_json_two text NOT NULL default '',
                    data_json_three text NOT NULL default '',
                    answer_from varchar(100) NOT NULL default '',
                    answer_from_no varchar(50) NOT NULL default '',
                    view_from varchar(100) NOT NULL default '',
                    view_to varchar( 100 ) NOT NULL default '',
                    created_at datetime NOT NULL default CURRENT_TIMESTAMP, 
                    created_by mediumint(3) NOT NULL DEFAULT '0',                        
                    PRIMARY KEY  (id),
                    KEY is_active (is_active),
                    KEY deleted (deleted)                
                ) $charset_collate;"; 

        return $sql_query;

    }

    protected function installDatabaseTables(){
        global $wpdb;
       
        $table_main         = $this->prefixTableName('crossword');       
 
        $charset_collate    = $wpdb->get_charset_collate();
          
        $sql_main           = $this->createMainTable( $table_main, $charset_collate );

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql_main );  
    }

    private function bmp_hasColumn( $arrColumns, $colName ){
        if( is_array( $arrColumns ) ){
            foreach( $arrColumns as $column ){
                if( $column->Field == $colName ){
                    return true;                
                }
            }
        }
        return false;
    }

    public function drp_local_txt(){
        //here goes all the localization to front-end
        return array(
            'areYouSureYouWantToClearAllBlanks' =>__("Are you sure you want to clear all blank cells?", 'advanced-crossword' ),
            'areYouSureYouWantToClearAllAnswerCells' => __("Are you sure you want to clear all answer cells?", 'advanced-crossword' ),
            'saved'                 => esc_html__('Saved', 'advanced-crossword' ),
            'error_parsing_data'    => esc_html__ ('Error Parsing Data', 'advanced-crossword'),
            'id'                    => esc_html__('Id', 'advanced-crossword' ),
            'saving'                => esc_html__('Saving ...', 'advanced-crossword' ),
            'save'                  => esc_html__('Save', 'advanced-crossword' ),
            'info'                  => esc_html__('Info', 'advanced-crossword' ),
            'puzzleNameRequired'    => esc_html__('Puzzle Name Required', 'advanced-crossword' ),
            'rowsNoGreaterThanZero' => esc_html__('Rows Number need to be greater than Zero', 'advanced-crossword' ),
            'colsNoGreaterThanZero' => esc_html__('Columns Number need to be greater than Zero', 'advanced-crossword' ),
            'changesOccured'        => esc_html__('Changes made. Are you sure you want to go back without saving?'),
            'newCrossword'          => esc_html__('New Crossword', 'advanced-crossword' ),
            'newRule'               => esc_html__('New Rule', 'advanced-crossword' ),
            'editRule'              => esc_html__('Edit Rule', 'advanced-crossword' ),
            'deleteRule'            => esc_html__('Delete Rule', 'advanced-crossword' ),
            'loggedInUsers'         => esc_html__('Logged In Users', 'advanced-crossword' ),
            'anonUsers'             => esc_html__('Anonymous Users', 'advanced-crossword' ),
            'deleteCrosswordPerm'   => esc_html__('Delete Crossword Permanently', 'advanced-crossword')        
        );

    }

    protected function uninstallDatabaseTables(){
    }

    public function upgrade(){

    }

    public function activate(){

    }

    public function deactivate() {       

        if( isset( $_GET['action'] ) && ( $_GET['action'] == 'deactivate') && isset( $_GET['feedback'] ) ){            
           
            try{
             
                $plugin_name = sanitize_text_field( wp_unslash( $_GET['plugin'] ));                
                
                if( strpos( $plugin_name , 'advanced-crossword.php') !== false ){        

                    $bmp_option = sanitize_text_field( wp_unslash( $_GET['option'] ) );
                    $bmp_other  = sanitize_text_field(  wp_unslash( $_GET['other'] ) );
                    $bmp_email  = sanitize_text_field(  wp_unslash( $_GET['email'] ) );  
                    
                    $user_email = '';

                    if( $bmp_email == 'yes'){
                        $current_user = wp_get_current_user();
                        $user_email = $current_user->user_email;
                    }
                                                                       
                    $optionsToText = [
                        esc_html("Lack of functionality"),
                        esc_html("Too difficult to use"),
                        esc_html("The plugin isn't working"),
                        esc_html("The plugin isn't useful"),
                        esc_html("Temporarily disabling or troubleshooting"),
                        esc_html("I dont like the plugin"),
                        esc_html("Other")
                    ];
                    
                    if( strlen( $bmp_option ) > 0 ){
                        $bmp_option = intval( $bmp_option );
                        $bmp_option = $optionsToText[ $bmp_option ];
                    }
                
                    $bmp_to       = 'developer@tuskcode.com'; 
                    $bmp_subject  = 'Feedback - Crossword Plugin';
                    $bmp_message  = "<h1>Crossword Feedback</h1>";
                    $bmp_message .= "<p>User Email: " . $user_email . "</p>";
                    $bmp_message .= "<p> Option: ". $bmp_option."</p>";
                    $bmp_message .= "<p> Other: ". $bmp_other . "</p>";
                    $bmp_message .= "<p> Contact me: ". $bmp_email . "</p>";

                    $bmp_header = "From:feedback@wordpress.com \r\n";          
                    $bmp_header .= "MIME-Version: 1.0\r\n";
                    $bmp_header .= "Content-type: text/html\r\n";
                    
                    try {                        
                        wp_mail( $bmp_to, $bmp_subject, $bmp_message, $bmp_header );
                    } catch (\Throwable $th) {
                        try {                           
                            mail( $bmp_to, $bmp_subject, $bmp_message, $bmp_header );
                        } catch (\Throwable $th) {
                            //throw $th;
                        };
                    }                 
                   
               }

            }catch( \Exception $e ){
                error_log( $e->getMessage() );
            }
        
        }else{
    
        }
    }
 
    public function addActionsAndFilters(){    
        add_action('init', array( &$this, 'puzzle_shortcodes_init') );
        add_action('admin_menu', array(&$this, 'addMenuPages')); 
        add_action('admin_enqueue_scripts', array( &$this, 'pw_load_scripts')); 
        add_action('wp_ajax_pc_front_actions', array( &$this, 'pc_front_actions') );
        add_action('wp_ajax_save_prize_info', array( &$this, 'save_prize_info') );
        add_action('wp_ajax_set_puzzle_prize', array( &$this, 'set_puzzle_prize') );
        add_action('wp_ajax_pc_submit_actions', array( &$this, 'pc_submit_actions') );
        add_action('wp_ajax_puzzle_admin_actions', array( &$this, "puzzle_admin_actions") );
        add_action( 'admin_footer', array( &$this, 'crossword_feedback_uninstall') );
           
    }

    public function pw_load_scripts( $hook ){
        global $pc_puzzle_crossword_main_page; 
        global $pc_puzzle_crossword_settings_page;    
        global $pc_puzzle_crossword_info_page; 
        global $pc_puzzle_crossword_access_page;  
        global $pc_puzzle_crossword_releases_page;

        if( $pc_puzzle_crossword_main_page      != $hook && 
            $pc_puzzle_crossword_settings_page  != $hook &&
            $pc_puzzle_crossword_info_page      != $hook &&
            $pc_puzzle_crossword_access_page    != $hook && 
            $pc_puzzle_crossword_releases_page  != $hook )  
            return;
   
        wp_localize_script('pc-puzzle-script-lng', 'crswrd_new_lng', $this->drp_local_txt() );  

        wp_enqueue_style('pc-puzzle-style-bootstrap', PC_PUZZLE_CROSSWORD_URL.'/assets/css/back/bootstrap.min.css', '', $this->getVersion() );
        wp_enqueue_style('pc-puzzle-style-fontawsome', PC_PUZZLE_CROSSWORD_URL.'/assets/css/back/fa/all.min.css', '', $this->getVersion() );

        wp_enqueue_style('pc-puzzle-style-main', PC_PUZZLE_CROSSWORD_URL.'/assets/css/back/pc_puzzle_main.css', '', $this->getVersion() );
        wp_enqueue_script('pc-puzzle-script-bootstrap', PC_PUZZLE_CROSSWORD_URL.'/assets/js/back/bootstrap.min.js', '', $this->getVersion() );     
        wp_enqueue_script('pc-puzzle-script-vue', PC_PUZZLE_CROSSWORD_URL.'/assets/js/back/vue-prod.min.js', '', $this->getVersion(), array('in_footer' => false ) ); 

        wp_enqueue_script('pc-puzzle-script-bootbox', PC_PUZZLE_CROSSWORD_URL.'/assets/js/back/bootbox.min.js', array('jquery'), $this->getVersion(), true  );       
        
        if( $pc_puzzle_crossword_main_page == $hook ){
            wp_enqueue_script('pc-puzzle-script-view', PC_PUZZLE_CROSSWORD_URL.'/assets/js/back/pc_puzzle_view.js', '', $this->getVersion(), array('in_footer' => true ) );  
            wp_enqueue_script('pc-puzzle-script-new', PC_PUZZLE_CROSSWORD_URL.'/assets/js/back/pc_puzzle_new.js', '', $this->getVersion(), array('in_footer' => true ) );     
            wp_localize_script('pc-puzzle-script-new', 'crswrd_new_lng', $this->drp_local_txt() );                                     
        }else if( $pc_puzzle_crossword_settings_page == $hook ){
            wp_enqueue_editor();
            wp_enqueue_script('pc-puzzle-script-settings', PC_PUZZLE_CROSSWORD_URL.'/assets/js/back/pc_puzzle_settings.js', '', $this->getVersion(), array('in_footer' => true ) );      
            wp_localize_script('pc-puzzle-script-settings', 'crswrd_new_lng', $this->drp_local_txt() );        
        }else if ( $pc_puzzle_crossword_access_page  == $hook ){         
            wp_enqueue_script('pc-puzzle-script-access', PC_PUZZLE_CROSSWORD_URL.'/assets/js/back/pc_puzzle_access.js', '', $this->getVersion(), array('in_footer' => true ) ); 
            wp_localize_script('pc-puzzle-script-access', 'crswrd_new_lng', $this->drp_local_txt() ); 
          
        }

          
    }
}