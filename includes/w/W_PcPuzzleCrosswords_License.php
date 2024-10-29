<?php
namespace W_PcPuzzleCrosswords_License;
if( ! defined('ABSPATH') ) die;
include_once( PC_PUZZLE_CROSSWORD_PATH . 'includes/PcPuzzleCrossword_Includes.php');
use PcPuzzleCrossword_Includes;

class W_PcPuzzleCrosswords_License {
    public static function drp_InfoLicensePage( $settings ){
             
    ?>     
        <div class='wrap'>
            <div class="container-fluid">   
                <div class='row'>
                    <?php
                        PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes::premium_link();                
                    ?>
                </div>
                <p></p>
                <p></p>
                <p></p>
                <p></p>

                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                            <a  class="nav-link active" id="v-pills-license-tab" data-toggle="pill" href="#v-pills-license"
                                role="tab" aria-controls="v-pills-license" aria-selected="true">
                                <?php esc_html_e('License',  'advanced-crossword' ); ?>
                            </a>

                        </div>
                    </div>

                    <div class="col-9">

                        <div class="tab-content" id="v-pills-tabContent">
                            <!-- license tab -->
                            <div class="tab-pane fade show active" id="v-pills-license" role="tabpanel" aria-labelledby="v-pills-license-tab">     
                            <div class='row'>
                                <form method="post">
                                    <div class='row'>
                                        <div class='col-sm-6'>
                                            <input type="text" class='form-control' 
                                            value='' 
                                            name="license_txt" id="input_license"
                                            placeholder="<?php esc_html_e('Enter the license number', 'advanced-crossword' ); ?>"
                                            /> 
                                            <div class='col text-danger h5'>
                                             
                                            </div>
                                        </div>

                                        <div class="col-sm-6">

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <?php esc_html_e('License Version', 'advanced-crossword' ); ?> 
                                                </div>              
                                                <div class="col-sm-6">
                                                    <input type="text" name="" readonly id="" 
                                                    value="" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <?php esc_html_e('License Active', 'advanced-crossword' ); ?> 
                                                </div>              
                                                <div class="col-sm-6">
                                                    <input type="text" name="" readonly id="" 
                                                    value="" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <?php esc_html_e('Domain License', 'advanced-crossword' ); ?> 
                                                </div>              
                                                <div class="col-sm-6">
                                                    <input type="text" readonly name="" id="" 
                                                    value="" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <?php esc_html_e('Support & Updates End Date', 'advanced-crossword' ); ?> 
                                                </div>              
                                                <div class="col-sm-6">
                                                    <input type="text" name="" readonly id=""
                                                    value="">
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <?php esc_html_e('Latest Version Available', 'advanced-crossword' ); ?> 
                                                </div>              
                                                <div class="col-sm-6">
                                                    <input type="text" name="" readonly id="" 
                                                    value="" />

                                                </div>
                                            </div>

                                            
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <?php esc_html_e('License Date last checked', 'advanced-crossword' ); ?> 
                                                </div>              
                                                <div class="col-sm-6">
                                                    <input type="text" name="" readonly id="" 
                                                    value="" />


                                                </div>
                                            </div>

                                            <div class="row text-success font-weight-bold ">
                                                <div class="col-sm-12 h5">                                                                                                    
                                                </div>
                                            </div>

                                        </div>
                                    
                                        <p></p>

                                        <div >
                                            <input class='button button-primary' type="submit" value="<?php esc_html_e('Validate License', 'advanced-crossword'); ?>">
                                        </div>


                                        <?php wp_nonce_field( 'nonce_field_form_license', 'nonce_field_form_license' ); ?>
                                    </div>
                                </form>
                                </div>
                            </div>

                            <!-- Installation tab -->
                            <div class="tab-pane fade show " id="v-pills-install" 
                                role="tabpanel" aria-labelledby="v-pills-install-tab">     

                            </div>

                            <!-- Default Raffle Setup tab -->
                            <div class="tab-pane fade show " id="v-pills-default" 
                                role="tabpanel" aria-labelledby="v-pills-default-tab">     

                            </div>

                            <!-- Raffles Setup tab -->
                            <div class="tab-pane fade show " id="v-pills-raffles" 
                                role="tabpanel" aria-labelledby="v-pills-raffles-tab">     

                            </div>

                            <!-- Winners tab -->
                            <div class="tab-pane fade show" id="v-pills-winners" 
                                role="tabpanel" aria-labelledby="v-pills-winners-tab">     

                            </div>     

                             <!-- Reports tab -->
                            <div class="tab-pane fade show" id="v-pills-reports" 
                                role="tabpanel" aria-labelledby="v-pills-reports-tab">     

                            </div>   
                            
                             <!-- PDF Attachment tab -->
                            <div class="tab-pane fade show" id="v-pills-pdf" 
                                role="tabpanel" aria-labelledby="v-pills-pdf-tab">     

                            </div> 

                        </div>


                    </div>


                </div>

            </div> <!-- /container-fluid -->
        </div> <!-- /wrap -->
        
      <?php  
    }

}