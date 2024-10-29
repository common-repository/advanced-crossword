<?php
namespace W_PcPuzzleCrosswords_Settings_Info;
if( ! defined('ABSPATH')) exit;

class W_PcPuzzleCrosswords_Settings_Info{

    public static function pcpuzzle_settingsPageInfo(){

    ?>
        <!-- Labels Tab -->
        <div class="tab-pane fade settings-info" id="nav-info" 
            role="tabpanel" aria-labelledby="nav-info-tab">

            <p></p>
            <p></p>


            <img class='img-snapshot'
                src="<?php echo esc_url( PC_PUZZLE_CROSSWORD_URL ) . '/assets/images/settings-info.png'  ?>" alt="" />
            <p></p>

        </div>


    <?php
    }
}