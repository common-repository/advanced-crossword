<?php
namespace W_PcPuzzleCrosswords_Settings_Sizes;
if( ! defined('ABSPATH')) exit;

class W_PcPuzzleCrosswords_Settings_Sizes{
    public static function pcpuzzle_settingsPageSizes(){

    ?>

        <!-- Sizes -->
        <div class="tab-pane fade" id="nav-sizes" 
            role="tabpanel" aria-labelledby="nav-sizes-tab">

            <p></p>
            <img class='img-snapshot'
                src="<?php echo esc_url( PC_PUZZLE_CROSSWORD_URL ). 
                    '/assets/images/settings-sizes.png'  ?>" alt="" />
            <p></p>

        </div>

    <?php
    }
}