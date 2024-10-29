<?php
namespace W_PcPuzzleCrosswords_Settings_Menu;
if( ! defined('ABSPATH')) exit;

class W_PcPuzzleCrosswords_Settings_Menu{
    public static function pcpuzzle_settingsPageMenu(){

    ?>

        <!-- General Settings -->
        <div class="tab-pane fade show active" id="nav-general" 
            role="tabpanel" aria-labelledby="nav-general-tab">

            <p></p>    

            <img class='img-snapshot'
                src="<?php echo esc_url(PC_PUZZLE_CROSSWORD_URL) . 
                    '/assets/images/settings-main.png'  ?>" alt="" />

            <p></p>

        </div>

    <?php
    }
}