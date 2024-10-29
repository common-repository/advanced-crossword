<?php
namespace W_PcPuzzleCrosswords_Settings_Labels;
if( ! defined('ABSPATH')) exit;

class W_PcPuzzleCrosswords_Settings_Labels{
    public static function pcpuzzle_settingsPageLabels(){

    ?>
        <!-- Labels Tab -->
        <div class="tab-pane fade settings-labels" id="nav-labels" 
            role="tabpanel" aria-labelledby="nav-labels-tab">

            <p></p>
            <img class='img-snapshot'
                src="<?php echo esc_url( PC_PUZZLE_CROSSWORD_URL ) . 
                    '/assets/images/settings-labels-one.png'  ?>" alt="" />
            
            <p></p>

            <img class='img-snapshot'
                src="<?php echo esc_url( PC_PUZZLE_CROSSWORD_URL ) . 
                    '/assets/images/settings-labels-two.png'  ?>" alt="" />


            <p></p>

            <img class='img-snapshot'
                src="<?php echo esc_url( PC_PUZZLE_CROSSWORD_URL ) . 
                    '/assets/images/settings-labels-three.png'  ?>" alt="" />

            <p></p>            

            <img class='img-snapshot'
                src="<?php echo esc_url( PC_PUZZLE_CROSSWORD_URL ). 
                    '/assets/images/settings-labels-four.png'  ?>" alt="" />

            <p></p>

        </div>


    <?php
    }
}