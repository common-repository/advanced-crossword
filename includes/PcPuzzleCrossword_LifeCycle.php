<?php
namespace PcPuzzleCrossword_LifeCycle;
if( ! defined('ABSPATH') ) die;

include_once( 'PcPUzzleCrosswords_OptionsManager.php');
include_once( 'PcPuzzleCrossword_Includes.php');
include_once( 'w/W_PcPuzzleCrosswords_View.php');
include_once( 'w/W_PcPuzzleCrosswords_Settings.php');
include_once( 'w/W_PcPuzzleCrosswords_License.php');
include_once( 'w/W_PcPuzzleCrosswords_Access.php');
include_once( 'w/W_PcPuzzleCrosswords_Releases.php');

use PcPUzzleCrosswords_OptionsManager\PcPUzzleCrosswords_OptionsManager as PcPUzzleCrosswords_OptionsManager;    
use W_PcPuzzleCrosswords_License;
use W_PcPuzzleCrosswords_View\W_PcPuzzleCrosswords_View as W_PcPuzzleCrosswords_View;
use W_PcPuzzleCrosswords_Settings\W_PcPuzzleCrosswords_Settings as W_PcPuzzleCrosswords_Settings;
use W_PcPuzzleCrosswords_Access\W_PcPuzzleCrosswords_Access as W_PcPuzzleCrosswords_Access;
use W_PcPuzzleCrosswords_Releases\W_PcPuzzleCrosswords_Releases as W_PcPuzzleCrosswords_Releases;
use PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes as PcPuzzleCrossword_Includes;

class PcPuzzleCrossword_LifeCycle extends PcPUzzleCrosswords_OptionsManager{

    const PUZZLE_ACTION_NEW             = 'new_puzzle';
    const PUZZLE_ACTION_EDIT            = 'edit_puzzle';
    const PUZZLE_ACTION_DEL             = 'del_puzzle';
    const PUZZLE_ACTION_SAVE_SETTINGS   = 'save_settings';
    const PUZZLE_ACTION_SAVE_RULES      = 'save_rules';
    const SAVE_CROSS_RULES              = 'save_cross_rules';
    const NONCE_NAME                    = 'puzzle_front_action_view_solved';

    //access
    const ACCESS_CRU_CROSSWORD          = 'crossword_cru';              //view / edit / add crossword
    const ACCESS_D_CROSSWORD            = 'crossword_d';                // delete crossword
    const ACCESS_SETTINGS               = 'crossword_settings_crud';    //create, read, update, delete
    const ACCESS_RULES                  = 'crossword_rules_crud';
    const ACCESS_LICENSE                = 'crossword_license_crud'; 
    const ACCESS_RELEASES               = 'crossword_releases_crud';

    public function __construct(){
        parent::__construct();
    }

    public function install(){
        
        // Initialize Plugin Options
        $this->initOptions();

        // Initialize DB Tables used by the plugin
        $this->installDatabaseTables();

        // Other Plugin initialization - for the plugin writer to override as needed
        $this->otherInstall();

        // To avoid running install() more then once
        $this->markAsInstalled();
    }

    public function uninstall(){
        $this->otherUninstall();
        $this->unInstallDatabaseTables();
        $this->deleteSavedOptions();
        $this->markAsUnInstalled();
    }

    public function upgrade() {
    }

    protected function initOptions() {
    }


    protected function installDatabaseTables() {
    }


    protected function unInstallDatabaseTables() {
    }


    protected function otherInstall() {
    }

  
    protected function otherUninstall() {
    }

    public function addMenuPages() {
        $this->addMainPage();    
        $this->addSettingsPage();
        $this->addAccessPage();      
        $this->addInfoPage();   
        $this->addReleasesPage();
    }
 
    protected function getPluginSlug() {
        return 'tuskcode_puzzle_crossword';
    }

    protected function getPluginSettingsSlug(){
        return 'tuskcode_crossword_settings';
    }

    protected function getPluginInfoSlug(){
        return 'tuskcode_crossword_info'; 
    }
    protected function getPluginAccessSlug(){
        return 'tuskcode_crossword_access'; 
    }

    protected function getPluginReleasesSlug(){
        return 'tuskcode_crossword_releases';
    }

    protected function addMainPage(){

        global $pc_puzzle_crossword_main_page;   
        $displayName = $this->getPluginDisplayName(); 

        $capab = current_user_can( self::ACCESS_CRU_CROSSWORD ) ? self:: ACCESS_CRU_CROSSWORD : 'manage_options';

        $pc_puzzle_crossword_main_page = add_menu_page( $displayName,
                                                        $displayName,
                                                        $capab,
                                                        $this->getPluginSlug(),
                                                        array( &$this, 'puzzle_crossword_main'),
                                                        (PC_PUZZLE_CROSSWORD_URL.'/assets/images/plugin-icon.png'),
                                                        150
                                );        
    }

    protected function addSettingsPage(){

        global $pc_puzzle_crossword_settings_page;
        $displayName = $this->getPluginSettingsDisplayName();

        $capab = current_user_can( self::ACCESS_SETTINGS ) ? self::ACCESS_SETTINGS : 'manage_options';

        $pc_puzzle_crossword_settings_page = add_submenu_page(
                                                        $this->getPluginSlug(), 
                                                        $displayName,
                                                        $displayName,
                                                        $capab,
                                                        $this->getPluginSettingsSlug(),
                                                        array( &$this, 'puzzle_crossword_settings'),              
                                                        151                        

        );
    }

    protected function addAccessPage(){
        global $pc_puzzle_crossword_access_page;
        $displayName = esc_html__('User Access', 'advanced-crossword');

        $capab = current_user_can(self::ACCESS_RULES ) ? self::ACCESS_RULES : 'manage_options';

        $pc_puzzle_crossword_access_page = add_submenu_page(
                                                        $this->getPluginSlug(), 
                                                        $displayName,
                                                        $displayName,
                                                        $capab,
                                                        $this->getPluginAccessSlug(),
                                                        array( &$this, 'puzzle_crossword_access'),              
                                                        152                      

        );
    }

    protected function addInfoPage(){
        global $pc_puzzle_crossword_info_page;
        $displayName = $this->getPluginInfoDisplayName();

        $capab = current_user_can( self::ACCESS_LICENSE ) ? self::ACCESS_LICENSE : 'manage_options';

        $pc_puzzle_crossword_info_page = add_submenu_page(
                                                        $this->getPluginSlug(), 
                                                        $displayName,
                                                        $displayName,
                                                        $capab,
                                                        $this->getPluginInfoSlug(),
                                                        array( &$this, 'puzzle_crossword_info'),              
                                                        155                   

        );
    }

    protected function addReleasesPage(){
        global $pc_puzzle_crossword_releases_page;
        $displayName = $this->getPluginReleasesDisplayName();

        $capab = current_user_can( self::ACCESS_RELEASES ) ? self::ACCESS_RELEASES : 'manage_options';

        $pc_puzzle_crossword_releases_page = add_submenu_page(
                                                        $this->getPluginSlug(), 
                                                        $displayName,
                                                        $displayName,
                                                        $capab,
                                                        $this->getPluginReleasesSlug(),
                                                        array( &$this, 'puzzle_crossword_releases'),              
                                                        165                   

        );
    }

    public function crossword_feedback_uninstall(){
        PcPuzzleCrossword_Includes::crossword_add_feedback_form();
    }

    public function puzzle_shortcodes_init(){
        add_shortcode( PC_PUZZLE_CROSSWORD_SHORTCODE, array( &$this, 'pc_shortcode_puzzle') );
    }

    public function pc_shortcode_puzzle( $atts, $content, $tag  ){

        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
      

        $wporg_atts = shortcode_atts([
            'id' => '',
            'name' => ''        
        ], $atts, $tag);

        $short_id          = $wporg_atts['id'];
        $short_name        = $wporg_atts['name'];
        $puzzle_obj        = null;
      
        if( $short_id != '' ){
            $puzzle_obj = $this->getCrosswordById( $short_id );
        }else{
            return $content;
        }

        if( $puzzle_obj == null )
            return $content;

        $rules_check = $this->rules_continue( $short_id );

        if( ! $rules_check['lok'] ){
            return $rules_check['message'];
        }

        $data_json = unserialize( $puzzle_obj->data_json );  
        $data_json = json_decode( $data_json );
    

        //$data_json = stripcslashes( $data_json );
        $table_data = wp_json_encode( $data_json->table_data, ( JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK ) );
        $hor_clues  = wp_json_encode( $data_json->hor_clues, (JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK ) );
        $ver_clues  = wp_json_encode( $data_json->ver_clues, (JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK) );
        
        //get custom menu template, and custom menu template per puzzle  
        $menu_template          = $this->get_custom_template('PcPuzzleCrosswordTemplate_MenuFront.php');
        $print_header_template  = ''; 
        $puzzle_top_template    = $this->get_custom_template('PcPuzzleCrosswordTemplate_TopSection.php');
        $puzzle_bottom_template = ''; 
        $puzzle_clues_template  = $this->get_custom_template('PcPuzzleCrosswordTemplate_Clues.php');
        $puzzle_info_template   = $this->get_custom_template('PcPuzzleCrosswordTemplate_Info.php');
    
        
        $default_settings_arr   = $this->pc_get_default_settings();

        if( isset( $default_settings_arr['menu']['general']['showInfoTemplate'] ) &&
            ( $default_settings_arr['menu']['general']['showInfoTemplate'] === true )
         ) {
            //load from template
            $default_settings_arr['info'] = wp_kses_post( $puzzle_info_template );           
        }

        $default_settings       = wp_json_encode( $default_settings_arr, ( JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK ) );
        $plugin_version         = PC_PUZZLE_CROSSWORD_VER; 

        $nonce          = wp_create_nonce( self::NONCE_NAME );
        $nonce_name     = self::NONCE_NAME;
        $ajax_url       = admin_url('admin-ajax.php');
        $show_answers   = false;
        $answers_data   = wp_json_encode( $data_json->answer_data, ( JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK ) );

        $show_answers = $show_answers ? 'true' : 'false';
    
        $content .= "<script>
                        if( typeof tuskcode_puzzle_data === 'undefined' ){
                            var tuskcode_puzzle_data = [];                            
                        } 

                        if( typeof tuskcode_plugin_version === 'undefined'){
                            var tuskcode_plugin_version = '$plugin_version';
                        }

                        if( typeof tuskcode_default_settings === 'undefined' ){
                            var tuskcode_default_settings = $default_settings;
                        } 
                        
                        if( typeof tuskcode_default_print_header === 'undefined'){
                            var tuskcode_default_print_header = `$print_header_template`;
                        }

                        if( typeof ajaxurl === 'undefined' ){
                            var ajaxurl =  '$ajax_url';
                        }
                                               
                        var tuskcode_puzzle_$short_id= {
                            table_data  : $table_data,
                            hor_clues   : $hor_clues,
                            ver_clues   : $ver_clues,
                            name        :'$data_json->puzzle_name',
                            rows_no     : $data_json->rows_no,
                            cols_no     : $data_json->cols_no,
                            id          : $short_id,
                            reg_expr     : '$data_json->input_reg_expr',
                            show_answers : $show_answers,
                            answers_data  : $answers_data,
                            reveal_date   : '',
                            reveal_time   : '',
                            menu_template : ` $menu_template `,
                            puzzle_top_template : ` $puzzle_top_template`,
                            puzzle_bottom_template : ` $puzzle_bottom_template `,
                            puzzle_clues_list_template : ` $puzzle_clues_template`                                                    
                        };

                        tuskcode_puzzle_data.push( tuskcode_puzzle_$puzzle_obj->id );
                        
                    </script>                     

                    <div class='tuskcode_puzzle' 
                        id='tuskcode_puzzle_$puzzle_obj->id'
                        ref='tuskcode_puzzle_$puzzle_obj->id'
                       
                    >
                    </div>

                    <input type='hidden' id='$nonce_name' value='$nonce' name='$nonce_name' />

                    ";

        if(  $puzzle_obj !== null ){
          
            wp_enqueue_script('pc-puzzle-script-vue', 
                PC_PUZZLE_CROSSWORD_URL.'/assets/js/back/vue-prod.min.js', '', $this->getVersion(), false );                 
            wp_enqueue_style( 'pc_puzzle_custom_style',  PC_PUZZLE_CROSSWORD_URL.'/assets/css/front/front-crossword.css' . '?v='.$this->getVersion() );   
            wp_enqueue_script('pc-puzzle-script-main-front', 
                PC_PUZZLE_CROSSWORD_URL.'/assets/js/front/js-front-crossword.js' . '?v='.$this->getVersion(), 
                '', null, array('in_footer' => true) );   
  
        }

        return $content;
    }

    private function rules_continue( $puzzle_id ){
        
        $result = array(
            'lok' => true,
            'message' => ''
        );

        try {
            //code...

            $rules = $this->get_rules();

            $cross_rules = (array) json_decode( $this->get_crosswordRules() ); 

            if( isset( $cross_rules[ $puzzle_id ] )){

                $added_rules = $cross_rules[ $puzzle_id ];

                //anonymous users              
                if(  ! is_user_logged_in() ){

                    $skip_rule_anon = apply_filters('crossowrd_skip_rule_anon', false, $puzzle_id );

                    if( ! $skip_rule_anon && $added_rules->au ){

                        $au_rules = $rules['login_rules']->au;
                        $au_template = $this->get_custom_template( 'PcPuzzleCrosswordTemplate_AnonUser.php' );

                        $bg_image   = trim( $au_rules->img_url ) != '' ? esc_url( $au_rules->img_url ) : '';
                        $bg_image   = $bg_image != '' ? "background-image: url(\"$bg_image\");" : '';
                        $text       = $au_rules->text;

                        $current_url = home_url($_SERVER['REQUEST_URI']);                      

                        $login_url  = trim( $au_rules->red_url ) != '' ? add_query_arg( 'redirect_to', urlencode( $current_url ), esc_html( $au_rules->red_url ) ) : '';

                        $login_url = $login_url == '' ?   wp_login_url( $current_url ) : $login_url;                    

                        $login_text = " onclick=\"window.location.href='$login_url';\" ";

                        $au_template = str_replace('{bgimage}', $bg_image , $au_template );
                        $au_template = str_replace('{text}',    $text , $au_template );

                        $au_template = str_replace('{onclicklogin}',  $login_text , $au_template );

                        $result['lok'] = false;
                        $result['message'] = $au_template;
                    }

                }else{ //logged in users

                }

            }

        }catch (\Throwable $th) {
            error_log('Filtering Rules Error');
            error_log( $th->getMessage() );
        }
           
        return $result;
    }

    private function get_custom_template( $template_name ){

        $result = '';

        ob_start();
        locate_template( $template_name, true );
        $result = ob_get_contents();

        if( $result == ''){
            $path = PC_PUZZLE_CROSSWORD_PATH . "templates/$template_name";           
            load_template( $path , false );
            $result = ob_get_contents();
        }

        ob_end_clean();

        return $result;
    }


    private function default_settings(){
        return array(
            'menu' => array(
                
                'general' => array(
                    'showMenu'                      => false,
                    'showDownloadEmptyPuzzlePdf'    => false,
                    'showPrintEmptyPuzzle'          => false,
                    'showPrintCurrentState'         => true,
                    'showRememberSettings'          => true,
                    'skipFilledCells'               => true,
                    'showCellSizeAdjs'              => true,
                    'showCellFontSize'              => true,
                    'showFontSizeClueNo'            => true,
                    'colorDefaultBlank'             => '#565a7b',
                    'colorDefaultHighlighted'       => '#b9efbc',
                    'colorDefaultFocused'           => '#ebd700',
                    'colorCellText'                 => '#2b0dbf',
                    'reportBugEmail'                => '',
                    'showInfo'                      => true,
                    'showInfoTemplate'              => true
                )
            ),
            'sizes' => array(
                'desktop' => array(
                    'low'               => 1200,
                    'cellSize'          => 34,
                    'fontSize'          => 1.3,
                    'fontSizeClueNo'    => 0.7
                ),
                'laptop' => array(
                    'cellSize'          => 30,
                    'fontSize'          => 1.2,
                    'fontSizeClueNo'    => 0.7
                ),
                'tablet' => array(
                    'high'              => 768,
                    'cellSize'         => 26,
                    'fontSize'          => 1.1,
                    'fontSizeClueNo'    => 0.7
                ),
                'mobile' => array(
                    'low'               => 0,
                    'high'              => 576,
                    'cellSize'          => 24,
                    'fontSize'          => 1,
                    'fontSizeClueNo'    => 0.7
                )
            ),
            'labels' => array(
                'general' => array(
                    'across_clues' => esc_html__( 'Across Clues', 'advanced-crossword' ),
                    'down_clues'   => esc_html__( 'Down Clues', 'advanced-crossword' ),
                    'clue_display' => esc_html__( 'Clue Display - Press on any cell to start', 'advanced-crossword'),
                    'clue'         => esc_html__( 'Clue', 'advanced-crossword'),
                    'cell'         => esc_html__( 'Cell', 'advanced-crossword'),
                    'puzzle'       => esc_html__( 'Puzzle', 'advanced-crossword'),
                ),

                'menu' => array(
                
                ),
                'message' => array(                  
                )
            ),
            'info' =>   ''
            
        );
    }

    private function pc_get_default_settings(){
        $opt_settings = $this->getDefaultSettings();
 
        if( $opt_settings == '' ){
            return  $this->default_settings();
        }else{
            $result = unserialize( $opt_settings );                   
            $result = $this->pc_update_default_settings( $result );       
            return $result;
        }
    }

    private function pc_update_default_settings( $saved_settings ){
        $def_settings = $this->default_settings();
        $saved_settings = json_decode( wp_json_encode( $saved_settings ), true );    

        foreach( $def_settings as $key=>$item ){   
            
            if( ! isset( $saved_settings[ $key ] ) ){
                $saved_settings[ $key ] = $def_settings[ $key ];
            }

            if( is_array( $item ) ){
                foreach( $item as $key2=>$item2 ){
                    if( ! isset( $saved_settings[ $key ][ $key2 ] ) ){
                        $saved_settings[ $key ][ $key2 ] = $def_settings[$key][ $key2 ];
                    }

                    if( is_array( $item2 ) ){
                        foreach( $item2 as $key3=>$item3 ){
                            if( ! isset( $saved_settings[$key][$key2][ $key3 ] ) ){
                                $saved_settings[$key][$key2][ $key3 ] = $def_settings[$key][$key2][ $key3 ];
                            } 
                        }
                    }
                }
            }
           
        }

        return $saved_settings;        
    }

    private function pc_set_default_settings( $settings ){

        foreach( $settings as $key=>$value ){            
            //$this->sanitize_array( $settings, $key );
            if( $key == 'info' ){
                $settings[ $key ] = wp_kses_post( $settings[ $key ]);
            }else{
                
                if( is_array( $value )){
                    foreach( $value as $key2=>$value2 ){
                        $text               = wp_json_encode( $value2 );
                        $txt_to_sanitize    = sanitize_text_field( $text );  
                        $value_array        = json_decode( $txt_to_sanitize, true );
                        $settings[ $key ][ $key2 ] = $value_array;                       
                    }
                }
            }
        }


        $str_opt = serialize( $settings );
        $this->setDefaultSettings( $str_opt );        
    }

    public function puzzle_admin_actions(){

        if( isset( $_POST['data'] ) && 
            is_user_logged_in() && 
            (   current_user_can( 'manage_options' ) || 
                current_user_can( self::ACCESS_CRU_CROSSWORD ) 
            ) && 
            is_admin() ){   

                if ( ! isset( $_POST['nonce'] ) 
                || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'pc_secure_action' ) 
                ) {
                    //did not verify 
                    echo  wp_json_encode(
                            array( 'response' => false,
                                'message' => esc_html__( 'The page did not pass the verification test', 'advanced-crossword' )
                            )
                        );

                    die();
                }

                $data_obj       =  wp_unslash( $_POST['data'] );
            
                $data_json      = json_decode( $data_obj );
                
                $page_action    = sanitize_text_field( wp_unslash( $_POST['page_action'] )); 
                
                //rules page
                if( $page_action === self::PUZZLE_ACTION_SAVE_RULES ){

                    if( trim( $data_json->lu->img_url ) !=  ''){
                        $data_json->lu->img_url = sanitize_url( wp_unslash( $data_json->lu->img_url ));
                    }

                    if( trim( $data_json->lu->red_url ) !=  ''){
                        $data_json->lu->red_url = sanitize_url( wp_unslash( $data_json->lu->red_url ));
                    }
                    
                    $data_json->lu->text    = wp_kses_post( wp_unslash( $data_json->lu->text ));
    
                    if( trim( $data_json->au->img_url ) !=  ''){
                        $data_json->au->img_url = sanitize_url( wp_unslash( $data_json->au->img_url ));
                    }

                    if( trim( $data_json->au->red_url ) !=  ''){
                        $data_json->au->red_url = sanitize_url( wp_unslash( $data_json->au->red_url ));
                    }
                    
                    $data_json->au->text    = wp_kses_post( wp_unslash( $data_json->au->text ));
    
                    $data_array = array();
                    $data_array['login_rules'] = $data_json;

                    $data_array = $this->set_rules( $data_array );
                    
                    echo  wp_json_encode(
                        array(  'response' => 'fine',
                                'data' => $this->get_rules(),
                                'type' => gettype( $data_array ) 
                        )
                    );

                    die();
                }
                

                $data_obj = sanitize_text_field( wp_unslash( $data_obj ) );

                if( $page_action == self::SAVE_CROSS_RULES ){
                    $data_obj = wp_unslash( $data_obj );
                    $this->set_crosswordRules( $data_obj );

                    echo  wp_json_encode(
                        array(  
                                'response' => 'fine',
                                'data' => wp_unslash(  $this->get_crosswordRules() )                               
                        )
                    );

                    die();

                }

                //settings page
                if( $page_action === self::PUZZLE_ACTION_SAVE_SETTINGS ){
                    $data_array = json_decode( wp_json_encode( $data_json ), true );
                    $data_array = $this->pc_set_default_settings( $data_array );
                    
                    echo  wp_json_encode(
                        array(  'response' => 'fine',
                                'data' => $this->pc_get_default_settings(),
                                'type' => gettype( $data_array ) 
                        )
                    );

                    die();
                }

                //crossword actions
                $h_clues_santzd = $this->sanitize_clues( $data_json->hor_clues );
                $v_clues_santzd = $this->sanitize_clues( $data_json->ver_clues );                

                $data_json->hor_clues = $h_clues_santzd;
                $data_json->ver_clues = $v_clues_santzd;

                $data_json->puzzle_name = sanitize_text_field( wp_unslash( $data_json->puzzle_name ) );
                $data_json->rows_no     = 15;
                $data_json->cols_no     = 15;
                $data_json->answer_data = unserialize( sanitize_text_field( serialize( $data_json->answer_data )));

                $data_obj       = sanitize_text_field( wp_json_encode( $data_json ) );
                            
                $puzzle_name    =  isset( $_POST['puzzle_name'] ) ? sanitize_text_field( $_POST['puzzle_name'] ) : '';
                $rows_no        = 15;
                $cols_no        = 15;
                $user_id        = get_current_user_id();
                $puzzle_id      = (int)  isset( $_POST['puzzle_id']) ? sanitize_text_field( $_POST['puzzle_id'] ) : -2;
                $answer_from_date   = isset( $_POST['answer_from_date'] ) ? sanitize_text_field ( $_POST['answer_from_date'] ) : '';
                $answer_from_time   = isset( $_POST['answer_from_time'] ) ? sanitize_text_field( $_POST['answer_from_time'] ) : '';
                $answer_from        = $answer_from_date . ' ' . $answer_from_time;
                $message        = '';
                $result         = false;

                $answer_from_number = '';

                if( $answer_from_date !== ''){                
                    $answer_from_number = strtotime( $answer_from_date . ' ' . $answer_from_time ); 
                }


                if( self::PUZZLE_ACTION_NEW ==  $page_action ){
                    $insert_data = array(
                        'pc_name'   => $puzzle_name,
                        'rows_no'   => $rows_no,
                        'cols_no'   => $cols_no,
                        'is_active' => 1,
                        'data_json' => $data_obj,
                        'user_id'   => $user_id,  
                        'answer_from' => $answer_from,                   
                        'pdf_filename' => '',
                        'answer_from_no' => $answer_from_number
                    );
    
                    try {
                        //code...
    
                        $result = $this->insertNewCrossword( $insert_data );
                        if( $result ){
                            $puzzle_id = $this->getLastInsertedId();
                        }

                    }catch( Exception $e ){
                        $result = false;
                        $message = esc_html__('Could not save the crossword puzzle', 'advanced-crossword' );
                        error_log( $e->getMessage() );
                    }

                }else if( self::PUZZLE_ACTION_EDIT == $page_action &&
                         $puzzle_id > -1 ){

                    $insert_data = array(
                        'pc_name'   => $puzzle_name,
                        'rows_no'   => $rows_no,
                        'cols_no'   => $cols_no,                        
                        'data_json' => $data_obj,     
                        'answer_from'       => $answer_from,
                        'answer_from_no'    => $answer_from_number                                          
                    );

                    try {
                        $result = $this->updateCrossword( 
                                    $puzzle_id, $insert_data );
                    } catch (\Throwable $th) {
                        $result = false;
                        $message = esc_html__('Could not save the crossword puzzle', 'advanced-crossword' );
                        error_log( $th->getMessage() );
                    }                   
                    //$this->createBlankPdfPuzzle( $table_html, $across_q_html, $down_q_html, $id );                 

                }else if( self::PUZZLE_ACTION_DEL == $page_action ){

                }

                echo  wp_json_encode( array(
                                'response' =>  $result,
                                'message' => $message,
                                'puzzle_id' => (int)$puzzle_id,
                                'lastAction' => $page_action
                                ), ( JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK ) 
                    );
                die;
        }

        echo wp_json_encode( 
                array(
                    'response'  => false,
                    'message'   => esc_html__('You dont have permission for such action', 'advanced-crossword')   ) 
            );
        die;
    }

    private function sanitize_clues( $data_clues ){
              
        foreach( $data_clues as $clue ){
            if( isset( $clue->q )){
                $clue->q = sanitize_text_field( $clue->q );
            }          
        } 

        return $data_clues;
    }
  

    public function puzzle_crossword_settings(){

        if( is_user_logged_in() && 
            (   current_user_can( 'manage_options' ) ||
                current_user_can( self::ACCESS_SETTINGS )
            )
            &&
            is_admin() ){

            $data = array(
                'main' => $this->pc_get_default_settings()
            );
            W_PcPuzzleCrosswords_Settings::pcpuzzle_settingsPage( $data );
        }
    }


    public function puzzle_crossword_main(){

        if( is_user_logged_in() && 
            (   current_user_can( 'manage_options' ) || 
                current_user_can( self::ACCESS_D_CROSSWORD ) ||
                current_user_can( self::ACCESS_CRU_CROSSWORD ) ) &&
            is_admin() ){

            $action = '';

            if( isset( $_GET['action'] ) ) 
                $action = sanitize_text_field( $_GET['action'] );
     
            $new_url    =  admin_url( 'admin.php?page=' . urlencode( $this->getPluginSlug() ) );

            if( $action == 'new' || $action == 'edit'){
                

                if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( 
                    sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'view_page' ) ) {
                    // Actions to do should the nonce is invalid
                    die('Page did not verify');                  
                } 
           
                $id     = '';

                if( $action == 'new'){
                    $data   = null;
                }else{
                    $action = 'edit';
                    $id = sanitize_text_field( $_GET['id'] );
                  
                    $data = $this->getCrosswordById( $id );
                }
                
                W_PcPuzzleCrosswords_View::pcpuzzle_addPage( $new_url, $data, $action, $id );        

            }else{

                if( $action == 'delete'){

                    if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash(  $_GET['_wpnonce'] ) ), 'view_page' ) ) {
                        // Actions to do should the nonce is invalid
                        die('Page did not verify');                  
                    } 

                    $id = sanitize_text_field( $_GET['id'] );
                    //delete pdf too   
                    if( current_user_can( 'manage_options' ) || current_user_can( self::ACCESS_D_CROSSWORD ) ){        
                        $this->deleteCrossword( $id );
                    }

                }

                $data = $this->getAllCrosswords();   
                $prize_data = array( 
                    'title' => $this->getPrizeTitle(),
                    'desc'  => $this->getPrizeDesc()
                );                  
                $rules = $this->get_crosswordRules(); 

                W_PcPuzzleCrosswords_View::pcpuzzle_viewPage( $new_url, $data, $prize_data, $rules );
                
            }        


        }
    }

    public function puzzle_crossword_access(){

        if ( is_user_logged_in() && 
            (   current_user_can( 'manage_options' ) ||
                current_user_can( self::ACCESS_RULES )
            )
            && is_admin() ) {

            $data = $this->get_rules();
            W_PcPuzzleCrosswords_Access::pcpuzzle_settingsPageAccess( $data );            
        }

    }

    public function puzzle_crossword_info(){

        if (  is_user_logged_in() &&
             ( current_user_can( 'manage_options' ) ||
               current_user_can( self::ACCESS_LICENSE ) 
             ) && is_admin() ) {

            $settings = array(
                'license' => false,
                'license_txt' => '',
                'version'   => PC_PUZZLE_CROSSWORD_VER,
                'last_checked' => '2020-01-01',
                'valid_license' => false
            );

            W_PcPuzzleCrosswords_License\W_PcPuzzleCrosswords_License::drp_InfoLicensePage( $settings );
        }

    }

    public function puzzle_crossword_releases(){
        if (  is_user_logged_in() &&
             ( current_user_can( 'manage_options' ) ||
               current_user_can( self::ACCESS_RELEASES ) 
             ) && is_admin() ) {
                

            W_PcPuzzleCrosswords_Releases::drp_InfoReleasesPage();
        }
    }

    protected function prefixTableName($name) {
        global $wpdb;
        return $wpdb->prefix .  strtolower($this->prefix($name));
    }

}

