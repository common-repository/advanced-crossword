<?php
namespace W_PcPuzzleCrosswords_Releases;

if( ! defined('ABSPATH') ) die;

class W_PcPuzzleCrosswords_Releases {
    public static function drp_InfoReleasesPage( ){
             
    ?>     
        <div class='wrap releases-page'>

            <div class="container-fluid"> 

                <h5 class='h5'> 
                    <?php esc_html_e('Releases & How to', 'advanced-crossword');?> 
                </h5>

                <p></p>
                <p></p>

                <ul class="nav nav-tabs nav-tabs-settings" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="releases-tab" data-bs-toggle="tab" data-bs-target="#releases" 
                            type="button" role="tab" aria-controls="releases" aria-selected="true">
                            <?php esc_html_e('Releases', 'advanced-crossword'); ?>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="howto-tab" data-bs-toggle="tab" data-bs-target="#howto" 
                            type="button" role="tab" aria-controls="howto" aria-selected="false">
                            <?php esc_html_e('How To', 'advanced-crossword'); ?>
                        </button>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="releases" role="tabpanel" aria-labelledby="releases-tab">

                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                    include_once('releases/W_PcPuzzleCrosswords_R102.php');
                                ?>
                            </div>

                            <div class="col-lg-6">
                                <?php
                                    include_once('releases/W_PcPuzzleCrosswords_R101.php');
                                ?>
                            </div>
                        </div>

                    </div>

                    <!-- how to tab content -->
                    <div class="tab-pane fade" id="howto" role="tabpanel" aria-labelledby="howto-tab">

                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                    include_once('howto/W_PcPuzzleCrosswords_R102.php');
                                ?>
                            </div>

                            <div class="col-lg-6">

                            </div>
                        </div>
                        
                    </div>

                </div>
            </div> <!-- /container-fluid -->
        </div> <!-- /wrap -->
        
      <?php  
    }

}