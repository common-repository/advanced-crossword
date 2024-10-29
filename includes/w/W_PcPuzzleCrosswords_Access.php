<?php

namespace W_PcPuzzleCrosswords_Access;

if( ! defined('ABSPATH')) exit;

include_once( PC_PUZZLE_CROSSWORD_PATH . 'includes/PcPuzzleCrossword_Includes.php');
use PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes as PcPuzzleCrossword_Includes;

class W_PcPuzzleCrosswords_Access{

    public static function pcpuzzle_settingsPageAccess( $data ){

        ?>
        <script>
            var pc_puzzle_access = <?php echo json_encode( $data );  ?>;              
        </script>


        <div class='wrap pc-access-page'>
            <?php
                PcPuzzleCrossword_Includes::premium_link();                
            ?>

            <div class="container-fluid">
                <h5 class='h4'> <?php esc_html_e('Access Page - Rules', 'advanced-crossword');?> </h5>

                <ul class="nav nav-tabs access-main-tabs" id="myTab" role="tablist">

                    <li class="nav-item d-none" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" style='min-width: 150px'
                            data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                            <?php esc_html_e('Rules', 'advanced-crossword'); ?>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"  style='min-width: 150px'
                            data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                            <?php esc_html_e('Login Rules', 'advanced-crossword'); ?>
                            
                        </button>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade d-none" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <?php
                            include_once('access/W_PcPuzzleCrosswords_Rules.php');
                        ?>
                    </div>

                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <?php
                            include_once('access/W_PcPuzzleCrosswords_Settings.php');
                        ?>
                    </div>
                    
                </div> 

                <?php wp_nonce_field( 'pc_secure_action', 'pc_secure_nonce_field' ); ?>

            </div>
        </div>

    <?php
    }
}