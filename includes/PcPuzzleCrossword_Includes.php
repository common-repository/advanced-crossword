<?php
namespace PcPuzzleCrossword_Includes;
if( ! defined('ABSPATH') ) die;

class PcPuzzleCrossword_Includes {
    static function loading_screen(){
        ?>
        <div class="drp-loader-img" id="drpLoaderImg"></div>
        <?php
    }

    static function create_dropdown( $arr, $id ){
        $result =  "<select name='{$id}' id='{$id}'>";
        
        foreach( $arr as $key=>$value ){
                    
            $result .= "<option value='{$key}'> {$value} </option>";
        }

        $result .= "</select>";

        return $result;
    }

    static function premium_image(){
        echo  "<img class='rpwoo-premium-image' src='". esc_url( PC_PUZZLE_CROSSWORD_URL )."/assets/images/premium-image.png' 
                data-toggle='tooltip' data-placement='right'  title='". esc_html__('Premium Feature', 'advanced-crossword' )."' />";
    }

    static function premium_link(){
        echo " <span style='font-size: 14px; float: right; white-space:nowrap;'><img class='rpwoo-premium-image' src='". esc_url( PC_PUZZLE_CROSSWORD_URL )."/assets/images/premium-image.png' /> 
               <a href='http://tuskcode.com/advanced-crossword' target='_blank'>"  . esc_html__('Get Premium License', 'advanced-crossword' )." </a> 
               <img class='rpwoo-premium-image' src='". esc_url( PC_PUZZLE_CROSSWORD_URL )."/assets/images/premium-image.png' /> </span> ";
    }

    public static function crossword_add_feedback_form() {
        ?>
            <style>
                .crossword-feedback-header{
                    background-color: #00bda5;
                    background-image: linear-gradient(-303deg, #7b7b7b, #00afb2 56%, #00bda5);
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    width: 100%;
                    align-items: center;
                    min-height: 80px;
                }

                .crossword-feedback-header h2{
                    color: white;                        
                    padding-left: 15px;
                    font-size: 1.5rem;
                    padding-top: 5px;
                }

                #crossword_feedback_wrapper{
                    background: #000;
                    opacity: 0.7;
                    filter: alpha(opacity=70);
                    position: fixed;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    left: 0;
                    z-index: 1000050;
                }
                #crossword_feedback_container{
                    display: block;
                    position: fixed;
                    top: 0px;
                    z-index: 1000051;
                    background-color: white;
                    left: 30%;
                    margin: 20px;
                    padding: 20px;
                    margin-top: 50px;                      
                    left: 50%;
                    width: 450px;
                    transform: translateX(-50%);
                }
                #crossword_modal_close{
                    width: 16px;
                    height: 16px;
                    float: right;
                    cursor: pointer;
                    margin-top: -35px;
                    margin-right: 20px;
                    color: white;
                }

                .crossword-close-path{
                    fill: currentcolor;
                    stroke: currentcolor;
                    stroke-width: 2;
                }
                #crossword_close_svg{
                    display: block;
                    -webkit-box-flex: 1;
                    flex-grow: 1;
                }
                .crossword-radio-input-container{
                    padding: 5px;
                }
                .crossword-feedback-body{
                    margin-top: 90px;
                }
                #crossword_feedback_textarea{
                    margin-bottom: 10px;
                    text-align: left;
                    vertical-align: middle;
                    transition-property: all;
                    transition-duration: 0.15s;
                    transition-timing-function: ease-out;
                    transition-delay: 0s;
                    border-radius: 3px;
                    border: 1px solid #cbd6e2;
                    background-color: #f5f8fa;
                    margin-top: 10px;
                    padding: 9px 10px;
                    width: 100%;
                }
                .crossword-radio-input-container{
                    font-size: 1rem;
                }
                #crossword_email_input{
                    border-radius: 3px;
                    border: 1px solid #cbd6e2;
                    background-color: #f5f8fa;
                    margin-top: 10px;
                    padding: 9px 10px;
                    width: 100%; 
                    margin-bottom: 20px;
                }
                .crossword-req-sel{
                    text-decoration: underline;
                }

            </style>
            <div id="crossword_feedback_wrapper" style="display: none"> </div>
                <div id="crossword_feedback_container" style="display: none;">
                    <div class="crossword-feedback-header">
                            <h2><?php echo esc_html( __( "We're sorry to see you go", 'advanced-crossword' ) ); ?></h2>
                            <div id="crossword_modal_close" >
                                <svg id="crossword_close_svg" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                    <path class="crossword-close-path" d="M14.5,1.5l-13,13m0-13,13,13" transform="translate(-1 -1)"></path>
                                </svg>
                            </div>
                    </div>
                    <div class="crossword-feedback-body">
                        <div>
                            <strong>
                                <h3> <?php echo esc_html( __( "If you have a moment, please let us know why you're deactivating the plugin.", 'advanced-crossword' ) ); ?> </h3>
                            </strong>
                        </div>
                        <form id='crossword_deactivate_form' class="crossword-deactivate-form">
                            <?php

                            $radio_buttons = array(
                                esc_html__( "Lack of functionality", 'advanced-crossword' ),
                                esc_html__( "Too difficult to use", 'advanced-crossword' ),
                                esc_html__( "The plugin isn't working", 'advanced-crossword' ),
                                esc_html__( "The plugin isn't useful", 'advanced-crossword' ),
                                esc_html__( 'Temporarily disabling or troubleshooting', 'advanced-crossword' ),
                                esc_html__( 'I dont like the plugin or the developer', 'advanced-crossword' ),
                                esc_html__( 'Other', 'advanced-crossword' )                                       
                            );

                            $buttons_count = count( $radio_buttons );
                            for ( $i = 0; $i < $buttons_count; $i++ ) {
                                ?>
                                    <div class="crossword-radio-input-container">
                                        <input
                                            type="radio"
                                            id="crossword_Feedback<?php echo esc_attr( $i ); ?>"
                                            name="bmpfeedback"
                                            value="<?php echo esc_attr( $i ); ?>"
                                            class="crossword-feedback-radio"
                                            required
                                        />
                                        <label for="crossword_Feedback<?php echo esc_attr( $i ); ?>">
                                            <?php echo esc_html( $radio_buttons[ $i ] ); ?>
                                        </label>
                                    </div>
                                <?php
                            }
                            ?>

                            <textarea name="details" id="crossword_feedback_textarea" class="crossword-feedback-text-area crossword-feedback-text-control"
                                placeholder="<?php echo esc_html( __( 'Extra Feedback...', 'advanced-crossword' ) ); ?>"></textarea>
                            
                            <p>
                                <label for="crossword_include_email" style='font-size: 0.9rem; font-weight: bold;' >
                                    <input type="checkbox" id='crossword_include_email' />
                                    <?php esc_html_e('Include my email. I want to be contacted by the developer.', 'advanced-crossword'); ?>
                                </label>
                            </p>

                            <hr/>

                            <div>
                                <strong>
                                    <h3> <?php echo esc_html( __( "Thank you for your feedback. Much appreciated.", 'advanced-crossword' ) ); ?> </h3>
                                </strong>
                            </div>

                            <div class="crossword-button-container">
                                <button type="submit" id="crossword_btn_feedback_submit" class="button button-primary">
                                    <div class="crossword-loader-button-content">
                                        <?php echo esc_html( __( 'Submit & deactivate', 'advanced-crossword' ) ); ?>
                                    </div>                                       
                                </button>
                                <button type="button" id="crossword_btn_feedback_skip" class="button action">
                                    <?php echo esc_html( __( 'Skip & deactivate', 'advanced-crossword' ) ); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    (function(){

                        var crossword_btn_feedback_close  = document.getElementById('crossword_modal_close');
                        var crossword_btn_uninstall       = document.querySelector('[data-slug="advanced-crossword"] .deactivate a');
                        var crossword_btn_uninstall_href  = '';
                        
                        if( crossword_btn_uninstall  !== null )
                            crossword_btn_uninstall_href = crossword_btn_uninstall.getAttribute('href');    

                        var crossword_feedback_wrapper    = document.getElementById('crossword_feedback_wrapper');   
                        var crossword_feedback_container  = document.getElementById('crossword_feedback_container');                 
                        var crossword_btn_feedback_submit = document.getElementById('crossword_btn_feedback_submit');
                        var crossword_btn_feedback_skip   = document.getElementById('crossword_btn_feedback_skip');

                        if( crossword_btn_feedback_close !== null ){
                            crossword_btn_feedback_close.addEventListener('click', function( e ){                               
                                crossword_feedback_wrapper.style.display = 'none';
                                crossword_feedback_container.style.display = 'none';
                            });
                        }

                        if( crossword_btn_uninstall !== null ){
                            crossword_btn_uninstall.addEventListener('click', function( e ){
                                if( crossword_feedback_wrapper !== null && crossword_feedback_container !== null ){

                                    e.preventDefault();
                                    crossword_feedback_wrapper.style.display = 'block';
                                    crossword_feedback_container.style.display = 'block';
                                    return false;
                                }                                   
                            });
                        }

                        if( crossword_btn_feedback_skip !== null ){
                            crossword_btn_feedback_skip.addEventListener( 'click', function( e ){
                                window.location.href = crossword_btn_uninstall_href;
                            });                               
                        }

                        if( crossword_btn_feedback_submit !== null && crossword_btn_uninstall !== null ){
                            crossword_btn_feedback_submit.addEventListener( 'click', function( e ){
                                e.preventDefault();
                                let crossword_option_val, crossword_other_val, crossword_email_val = '';
                                let crossword_option = document.querySelector("input[name='bmpfeedback']:checked");
                                let crossword_other  = document.getElementById('crossword_feedback_textarea');
                                let crossword_email  = document.getElementById('crossword_include_email');

                                if( crossword_option == null || typeof crossword_option === 'undefined'){
                                    document.querySelectorAll('.crossword-radio-input-container').forEach( function( item ){
                                        item.classList.add('crossword-req-sel');
                                    });
                                    return;
                                }
                                                            
                                try{

                                    if( crossword_option )
                                        crossword_option_val = crossword_option.value;
                                    if( crossword_other )
                                        crossword_other_val = crossword_other.value;
                                    if( crossword_email )
                                        crossword_email_val = crossword_email.checked ? 'yes' : 'no';
                          
                                    crossword_option_val  = encodeURI( crossword_option_val );
                                    crossword_other_val   = encodeURI( crossword_other_val );
                                    crossword_email_val   = encodeURI( crossword_email_val );
                                }catch( e ){
                                    console.error('wrong value for uri encoding');
                                }
                                
                                let crossword_append_url = '&feedback=true&option=' + crossword_option_val + '&other=' + crossword_other_val + '&email=' + crossword_email_val;
                                let crossword_new_href = crossword_btn_uninstall_href.concat( crossword_append_url );
                                
                                window.location.href = crossword_new_href;                                  
                            });
                        }

                    }() );
                </script>               
        <?php
 
    }

}