<?php
namespace PcPUzzleCrosswords_OptionsManager;

if( ! defined('ABSPATH') ) die;

include_once( 'D_PcPuzzleCrosswords_Table.php');
use D_PcPuzzleCrosswords_Table;

class PcPUzzleCrosswords_OptionsManager extends D_PcPuzzleCrosswords_Table\D_PcPuzzleCrosswords_Table{

    const optionInstalled       = '_installed';
    const optionVersion         = '_version';  
    const optionPrizeTitle      = 'prize_title';
    const optionPrizeDesc       = 'prize_desc';
    const optionDefaultSettings = 'settings';
    const OPTION_RULES          = 'rules';
    const RULE_LU_ID            = 8888;
    const RULE_AU_ID            = 9999;
    const CROSSWORD_RULES       = 'crossword_rules';
    
    function __construct(){
        parent::__construct();
    }

    protected function get_rules(){
        
        $rules = ( array )json_decode( $this->getOption( self::OPTION_RULES, '{}' ) );

        if( ! isset( $rules['login_rules'] ) ){
            $login_rules = array(
                'lu' => array (
                    'id'         => 8888,
                    'name'       => esc_html__('Logged In Users', 'advanced-crossword' ),
                    'img_url'    => '',
                    'red_url'    => '',
                    'text'       => '',
                    'from'       => 0,
                    'to'         => 0,
                    'extra_one'  => '',
                    'extra_two'  => '',
                    'extra_thr'  => ''
                ),
                'au' => array (
                    'id'         => 9999,
                    'name'       => esc_html__('Anonymous Users', 'advanced-crossword' ),
                    'img_url'    => '',
                    'red_url'    => '',
                    'text'       => '',
                    'from'       => 0,
                    'to'         => 0,
                    'extra_one'  => '',
                    'extra_two'  => '',
                    'extra_thr'  => ''
                )
            );
            $login_rules = (object) $login_rules;
            $rules['login_rules'] = $login_rules;
        }

        return $rules;
    }



    protected function set_rules( $value ){
        $value = json_encode( $value );
        if( ! $this->updateOption( self::OPTION_RULES, $value ) )
            $this->addOption( self::OPTION_RULES, $value );
    }

    protected function get_crosswordRules(){
        
        $val = $this->getOption( self::CROSSWORD_RULES, '');
       
        if( $val ){
            return json_decode( $val );
        }else{
            return '{}';
        }
    }

    protected function set_crosswordRules( $value ){
        $value = json_encode( $value );
        if( ! $this->updateOption( self::CROSSWORD_RULES, $value ) )
            $this->addOption( self::CROSSWORD_RULES, $value );
    }
   
    protected function isInstalled() {
        return self::getOption(self::optionInstalled) == true;
    }

    protected function markAsInstalled() {
        return self::updateOption(self::optionInstalled, true);
    }


    protected function markAsUnInstalled() {
        return self::deleteOption(self::optionInstalled);
    }


    public function getVersionSaved() {
        return self::getOption(self::optionVersion);
    }


    public function setVersionSaved($version) {
        return self::updateOption(self::optionVersion, $version);
    }

    public function getPrizeTitle(){
        return self::getOption( self::optionPrizeTitle, '' );
    }
    
    public function setPrizeTitle( $value ){
        if( ! self::addOption( self::optionPrizeTitle, $value) )
            self::updateOption( self::optionPrizeTitle, $value );
    }

    public function getPrizeDesc(){
        return self::getOption( self::optionPrizeDesc, '' );
    }
    
    public function setPrizeDesc( $value ){
        $value = nl2br( $value );

        if( ! self::addOption( self::optionPrizeDesc, $value) )
            self::updateOption( self::optionPrizeDesc, $value );
    }

    protected function getDefaultSettings(){
        return self::getOption( self::optionDefaultSettings, '' );
    }

    protected function setDefaultSettings( $settings ){
        if( ! self::addOption( self::optionDefaultSettings, $settings) )
            self::updateOption( self::optionDefaultSettings, $settings );
    }


    protected function deleteSavedOptions() {
        $optionMetaData = $this->getOptionMetaData();
        if (is_array($optionMetaData)) {
            foreach ($optionMetaData as $aOptionKey => $aOptionMeta) {
                $prefixedOptionName = $this->prefix($aOptionKey); // how it is stored in DB
                delete_option($prefixedOptionName);
            }
        }
    }

    protected function getVersion(){
        return esc_html( PC_PUZZLE_CROSSWORD_VER );
    }

    public function getOptionNamePrefix() {
        return 'puzzle_';
    }

    public function getOptionMetaData() {
        return array();
    }


    public function getOptionNames() {
        return array_keys($this->getOptionMetaData());
    }

    
    public function prefix($name) {
        $optionNamePrefix = $this->getOptionNamePrefix();
        if (strpos($name, $optionNamePrefix) === 0) { // 0 but not false
            return $name; // already prefixed
        }
        return $optionNamePrefix . $name;
    }


    public function &unPrefix($name) {
        $optionNamePrefix = $this->getOptionNamePrefix();
        if (strpos($name, $optionNamePrefix) === 0) {
            return substr($name, strlen($optionNamePrefix));
        }
        return $name;
    }


    public function getOption($optionName, $default = null) {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB       
        $retVal = get_option($prefixedOptionName);
        if (!$retVal && $default) {
            $retVal = $default;
        }
        return $retVal;
    }


    public function deleteOption($optionName) {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return delete_option($prefixedOptionName);
    }


    public function addOption($optionName, $value) {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return add_option($prefixedOptionName, $value);
    }

    public function updateOption($optionName, $value) {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return update_option($prefixedOptionName, $value);
    }

    public function getRoleOption($optionName) {
        $roleAllowed = $this->getOption($optionName);
        if (!$roleAllowed || $roleAllowed == '') {
            $roleAllowed = 'Administrator';
        }
        return $roleAllowed;
    }

    public function isUserRoleEqualOrBetterThan($roleName) {
        if ('Anyone' == $roleName) {
            return true;
        }
        $capability = $this->roleToCapability($roleName);
        return current_user_can($capability);
    }

    public function canUserDoRoleOption($optionName) {
        $roleAllowed = $this->getRoleOption($optionName);
        if ('Anyone' == $roleAllowed) {
            return true;
        }
        return $this->isUserRoleEqualOrBetterThan($roleAllowed);
    }

    public function registerSettings() {
        $settingsGroup = get_class($this) . '-settings-group';
        $optionMetaData = $this->getOptionMetaData();
        foreach ($optionMetaData as $aOptionKey => $aOptionMeta) {
            register_setting($settingsGroup, $aOptionMeta);
        }
    }
 

    protected function getMySqlVersion() {
        global $wpdb;
        $rows = $wpdb->get_results('select version() as mysqlversion');
        if (!empty($rows)) {
             return $rows[0]->mysqlversion;
        }
        return false;
    }

 
    public function getEmailDomain() {
        // Get the site domain and get rid of www.
        $sitename = sanitize_text_field( strtolower($_SERVER['SERVER_NAME']) );
        if (substr($sitename, 0, 4) == 'www.') {
            $sitename = substr($sitename, 4);
        }
        return $sitename;
    }

}