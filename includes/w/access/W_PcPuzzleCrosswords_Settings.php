<?php

if( ! defined('ABSPATH')) exit;

include_once( PC_PUZZLE_CROSSWORD_PATH . 'includes/PcPuzzleCrossword_Includes.php');
use PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes as PcPuzzleCrossword_Includes;

?>
<p></p>
<p></p>

<div class="d-flex align-items-start">

  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">

    <button class="nav-link active" id="v-pills-au-tab" data-bs-toggle="pill" 
        data-bs-target="#v-pills-au" 
        type="button" role="tab" aria-controls="v-pills-au" aria-selected="false">
        <?php esc_html_e('Anonymous Users', 'advanced-crossword'); ?>
    </button>

    <button class="nav-link" id="v-pills-lu-tab" data-bs-toggle="pill" 
        data-bs-target="#v-pills-lu" type="button" role="tab" 
        aria-controls="v-pills-lu" aria-selected="true">
        <?php esc_html_e('Logged In Users', 'advanced-crossword'); ?>
    </button>
   
  </div>

  <div class="tab-content" id="v-pills-tabContent">

    <!--  Anonymous User -->
    <div class="tab-pane fade show active" id="v-pills-au" role="tabpanel" 
        aria-labelledby="v-pills-au-tab">

        <p class='h5'>
            <?php esc_html_e('If not allowed to play the crossword based on the rules', 'advanced-crossword'); ?>
        </p>
        <p>
            <?php esc_html_e('Display image instead of the crossword', 'advanced-crossword'); ?> 
            <br />
            <?php esc_html_e('Copy and paste image url here', 'advanced-crossword'); ?> 
            <br />
            <input type="text" name="" id="au_img_url" 
                v-model.trim="login_rules.au.img_url" class='form-control' >
        </p>

        <p>
            <?php esc_html_e('Login url (or product url)', 'advanced-crossword'); ?> 
            <br />
            <input type="text" name="" id="au_red_url" 
                v-model.trim="login_rules.au.red_url" class='form-control'>
        </p>

        <p>
            <?php esc_html_e('Text over image (html accepted)', 'advanced-crossword'); ?> 
            <br />
            <textarea name="" id="au_text" 
                v-model.trim="login_rules.au.text" class='form-control' 
                cols="30" rows="10"></textarea>
        </p>

    </div>

    <!-- Logged in user -->
    <div class="tab-pane fade" id="v-pills-lu" role="tabpanel" 
        aria-labelledby="v-pills-lu-tab">

        <p class='h5'>
            <?php esc_html_e('If not allowed to play the crossword based on the rules', 'advanced-crossword'); ?>
        </p>
        <p>
            <?php esc_html_e('Display image instead of the crossword', 'advanced-crossword'); ?> 
            <br />
            <?php esc_html_e('Copy and paste image url here', 'advanced-crossword'); ?> 
            <?php 
                    PcPuzzleCrossword_Includes::premium_image();
                ?>
            <br />

            <input type="text" name="" id="lu_img_url" 
                 class='form-control'>

        </p>

        <p>
            <?php esc_html_e('Url redirect when clicking on image (like url to product)', 'advanced-crossword'); ?> 
                <?php 
                    PcPuzzleCrossword_Includes::premium_image();
                ?>
            <br />

            <input type="text" name="" id="lu_red_url" 
                class='form-control'>

        </p>

        <p>
            <?php esc_html_e('Text over image (html accepted)', 'advanced-crossword'); ?> 

                <?php 
                    PcPuzzleCrossword_Includes::premium_image();
                ?>
            <br />

            <textarea name="" id="lu_text" 
                class='form-control' 
                cols="30" rows="10"></textarea>

        </p>

    </div>

  </div>
</div>

<button class='btn btn-primary btn-sett-save'            
    @click='saveSettings($event)' :disabled='saving'>  

        <svg xmlns="http://www.w3.org/2000/svg" fill='#fff' width='22' height='22' viewBox="0 0 24 24">
            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
        </svg>               

        <span v-if="! saving">
            <?php esc_html_e('Save', 'advanced-crossword' ) ?>             
        </span>

        <span v-else="">
            <?php esc_html_e('Saving ...', 'advanced-crossword' ) ?>             
        </span>               
</button>