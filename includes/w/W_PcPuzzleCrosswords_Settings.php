<?php
namespace W_PcPuzzleCrosswords_Settings;
if( ! defined('ABSPATH')) exit;

include_once('W_PcPuzzleCrosswords_Settings_Sizes.php');
include_once('W_PcPuzzleCrosswords_Settings_Menu.php');
include_once('W_PcPuzzleCrosswords_Settings_Labels.php');
include_once('W_PcPuzzleCrosswords_Settings_Info.php');
include_once( PC_PUZZLE_CROSSWORD_PATH . 'includes/PcPuzzleCrossword_Includes.php');

use W_PcPuzzleCrosswords_Settings_Info;
use PcPuzzleCrossword_Includes;
use W_PcPuzzleCrosswords_Settings_Sizes;
use W_PcPuzzleCrosswords_Settings_Menu;
use W_PcPuzzleCrosswords_Settings_Labels;

class W_PcPuzzleCrosswords_Settings{
    public static function pcpuzzle_settingsPage( $data ){
    ?>
        <script>
            var pc_puzzle_settings =  <?php echo wp_json_encode( $data['main'] );?>;        
        </script>


        <div class='wrap pc-settings-page'>
            <h5 class='h5'> <?php esc_html_e('Settings - Premium Page', 'advanced-crossword');?> </h5>
                <?php
                    PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes::premium_link();                
                ?>
            <div class="container-fluid">

            <p>
                <button class='btn btn-primary btn-sett-save'            
                    @click='saveSettings($event)' :disabled='saving'>  
                        <svg xmlns="http://www.w3.org/2000/svg" fill='#fff' width='22' height='22' viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>               
                        <span v-if="! saving">
                            <?php esc_html_e('Save', 'advanced-crossword' ) ?>             
                            <?php 
                                PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes::premium_image();
                            ?>
                        </span>
                        <span v-else="">
                            <?php esc_html_e('Saving ...', 'advanced-crossword' ) ?>             
                        </span>               
                </button>
            </p>

            <nav>
                <div class="nav nav-tabs nav-tabs-settings" id="nav-tab" role="tablist">

                    <button class="nav-link active" id="nav-general-tab" 
                        data-bs-toggle="tab" data-bs-target="#nav-general"
                        type="button" role="tab" 
                        aria-controls="nav-general" aria-selected="true">
                        <?php esc_html_e('Puzzle Menu', 'advanced-crossword' ); ?>   
                        <?php 
                                PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes::premium_image();
                            ?>     
                    </button>

                    <button class="nav-link" id="nav-sizes-tab" 
                        data-bs-toggle="tab" data-bs-target="#nav-sizes" 
                        type="button" 
                        role="tab" aria-controls="nav-sizes" aria-selected="false">
                        <?php esc_html_e('Sizes', 'advanced-crossword' ); ?> 
                        <?php 
                                PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes::premium_image();
                        ?>   
                    </button>

                    <button class="nav-link" id="nav-labels-tab" 
                        data-bs-toggle="tab" data-bs-target="#nav-labels" 
                        type="button" 
                        role="tab" aria-controls="nav-labels" aria-selected="false">                
                        <?php esc_html_e('Labels', 'advanced-crossword' ); ?>   
                        <?php 
                                PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes::premium_image();
                        ?>                  
                    </button>

                    <button class="nav-link" id="nav-info-tab" 
                        data-bs-toggle="tab" data-bs-target="#nav-info" 
                        type="button" 
                        role="tab" aria-controls="nav-labels" 
                        aria-selected="false">                
                        <?php esc_html_e('Info', 'advanced-crossword' ); ?>   
                        <?php 
                                PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes::premium_image();
                        ?>                  
                    </button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">

                <!-- Menu -->
                <?php W_PcPuzzleCrosswords_Settings_Menu\W_PcPuzzleCrosswords_Settings_Menu::pcpuzzle_settingsPageMenu() ?>

                <!-- Sizes -->
                <?php W_PcPuzzleCrosswords_Settings_Sizes\W_PcPuzzleCrosswords_Settings_Sizes::pcpuzzle_settingsPageSizes() ?>

                <!-- Labels -->
                <?php W_PcPuzzleCrosswords_Settings_Labels\W_PcPuzzleCrosswords_Settings_Labels::pcpuzzle_settingsPageLabels() ?>

                <!-- Info -->
                <?php W_PcPuzzleCrosswords_Settings_Info\W_PcPuzzleCrosswords_Settings_Info::pcpuzzle_settingsPageInfo() ?>
                        
            </div>

            <p class='p-save-setting-bottom-fixed'>
                <button class='btn btn-primary btn-sett-save'             
                    @click='saveSettings($event)'
                    :disabled='saving' > 
                        <svg xmlns="http://www.w3.org/2000/svg" fill='#fff' width='22' height='22' viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>               
                        <span v-if="! saving">
                            <?php esc_html_e('Save', 'advanced-crossword' ) ?>             
                        </span>
                        <span v-else="">
                            <?php esc_html_e('Saving ...', 'advanced-crossword' ) ?>             
                        </span>
                </button>
            </p>

            <?php wp_nonce_field( 'pc_secure_action', 'pc_secure_nonce_field' ); ?>

            </div>
        </div>

    <?php
    }
}