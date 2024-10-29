<?php
/**
 * Info Template
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No Access here' );
}
?>

<div 
    class='puzzle-info-template-div'
>

        <h4 style='text-align:center;' >
            <?php esc_html_e( 'How to play the puzzle!', 'advanced-crossword' );?>
        </h4>

        <p>           
            <?php esc_html_e( 'Click on any cell to get started', 'advanced-crossword' );?>
        </p>

        <p>            
            <?php esc_html_e( 'Click on vertical / horizontal lines to change direction', 'advanced-crossword' );?>
        </p>
        
        <p>           
            <?php esc_html_e( 'Direction can also be changed by clicking on Space / Enter key', 'advanced-crossword' );?>
        </p>

        <p>           
            <?php esc_html_e( 'Across and Down Clues can be toggle visible by clicking on the down / up arrows', 'advanced-crossword' );?>
        </p>
    
</div>