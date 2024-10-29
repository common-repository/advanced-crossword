<?php
namespace W_PcPuzzleCrosswords_View;
if( ! defined('ABSPATH')) exit;
include_once( PC_PUZZLE_CROSSWORD_PATH . 'includes/PcPuzzleCrossword_Includes.php');
use PcPuzzleCrossword_Includes\PcPuzzleCrossword_Includes as PcPuzzleCrossword_Includes;

class W_PcPuzzleCrosswords_View{

public static function pcpuzzle_viewPage( $new_url, $data, $prize_data, $rules ){

    $new_puzzle_url = wp_nonce_url( $new_url . '&action=new', 'view_page');
    $pdf_folder = ABSPATH . 'wp-content/uploads/';
?>
    <div class='wrap'>
        <script>
            var crossword_rules = JSON.parse( <?php echo json_encode( $rules ); ?> );
        </script>

        <?php wp_nonce_field( 'pc_secure_action', 'pc_secure_nonce_field' ); ?>

        <p> <?php esc_html_e('Version', 'advanced-crossword');?> : <?php echo esc_html( PC_PUZZLE_CROSSWORD_VER ); ?></p>
        <div class="container-fluid">
            
            <?php
                PcPuzzleCrossword_Includes::premium_link();                
            ?>

            <div class="menu-section" style='border-bottom: 1px solid gray; padding-bottom: 5px;'>
                <button class="button button-secondary btn-new-cross ps-2 pe-2 pt-1 pb-1" 
                    onclick="window.location.href='<?php echo esc_url( $new_puzzle_url );?>'" >                   
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    <?php esc_html_e('New Crossword', 'advanced-crossword' ); ?>
                </button>
            </div>



            <div class="section-content section-content-grid">
                <table class='table table-striped table-view-puzzles' style='margin-top: 20px;'>
                    <thead>
                        <tr>
                            <th style='width: 110px;'><?php esc_html_e('Action', 'advanced-crossword' ); ?></th>
                            <th><?php esc_html_e('Id', 'advanced-crossword' ); ?>
                            - <?php esc_html_e('Name', 'advanced-crossword' ); ?></th>
                             <th style='text-align: left;' >
                                <?php esc_html_e('Shortcode', 'advanced-crossword' ); ?>
                            </th> 
                            <th style='text-align: center;' >
                                <?php esc_html_e('Show Answers From', 'advanced-crossword' ); ?>
                                    <?php
                                        PcPuzzleCrossword_Includes::premium_image();                
                                    ?>
                            </th>                                       
                        </tr>
                    </thead>

                    <tbody>
                        <?php 

                            foreach( $data as $item ){

                                $edit_url = $new_url .'&action=edit&id=' . $item->id;
                                $delete_url = $new_url .'&action=delete&id=' . $item->id;   
                                
                                $edit_url = wp_nonce_url( $edit_url , 'view_page');
                                $delete_url = wp_nonce_url( $delete_url, 'view_page');

                                $edit_url = esc_url( $edit_url );
                                $delete_url = esc_url( $delete_url );

                                $item->id = esc_html( $item->id );
                                $item->pc_name = esc_html( $item->pc_name );
                                $td_pc_name =  $item->pc_name . " (" . 
                                    esc_html( $item->rows_no ) . "x" . esc_html( $item->cols_no ) . ")";                         
                                $shortcode_name = esc_html( "[" .PC_PUZZLE_CROSSWORD_SHORTCODE ." id=$item->id name='$item->pc_name']" );
                                $copy       = esc_html__('Copy', 'advanced-crossword' );
                                $copied     = esc_html__('Copied', 'advanced-crossword' );
                                $edit_action_title    = esc_html__('Edit', 'advanced-crossword');
                                $delete_action_title  = esc_html__('Delete', 'advanced-crossword');
                                $login_action_title   = esc_html__('Login Access', 'advanced-crossword');
                            
                                echo  "<tr>".
                                        "<td style='min-width: 170px'>  

                                            <a href='$edit_url' title='$edit_action_title'> <i class='fa fa-edit'></i> </a> " .
                                            "<span class='delete-crossword' data-url='$delete_url' title='$delete_action_title'
                                                @click='actionDeletePuzzle( $item->id, \"$td_pc_name\")'    
                                            >
                                                <i class='fa fa-trash-alt'
                                                data-url='$delete_url'
                                                ></i> 
                                            </span> 
                                            <span @click='actionAccessPuzzle( $item->id, \"$item->pc_name\" )'
                                                class='btn-access-edit' title='$login_action_title' >

                                                <i class='fa fa-universal-access'></i>

                                                <span class='access-extra-icons' >
                                                    <i class='access-extra-letter' v-show='cross[$item->id] && cross[$item->id].au'>A</i>
                                                    <i class='access-extra-letter' v-show='cross[$item->id] && cross[$item->id].lu'>L</i>
                                                </span>

                                            </span>
                                            
                                        </td>".                                       
                                        "<td> $item->id - $td_pc_name </td>".
                                        "<td style='text-align: left;' >
                                          
                                            <svg style='cursor: pointer; margin-right: 5px;' 
                                                @click=\"copyShortcode()\" 
                                                title='$copy'
                                                data-short=\"$shortcode_name\"
                                                xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" class=\"bi bi-clipboard\" viewBox=\"0 0 16 16\">
                                                <path d=\"M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z\" />
                                                <path d=\"M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z\" />
                                            </svg>
                                                <span class='clipboard-span clipboard-hide'>
                                                    $copied 
                                                </span>

                                            $shortcode_name

                                        </td>
                                        <td style='text-align: center;'>
                                            $item->answer_from
                                        </td>
                                        " .                                 
                                        
                                    "</tr>";
                            }
                        ?>
                    </tbody>

                </table>


                <button type="button" class="btn btn-primary d-none" ref='btn_modal_access'
                    data-bs-toggle="modal" data-bs-target="#modal_user_access">
                    View
                </button>


                <!-- Modal -->
                <div class="modal fade" id="modal_user_access" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">
                                <?php esc_html_e('Rules to play Crossword', 'advanced-crossword'); ?>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <label for="ckb_au_rule">                                
                                <input type="checkbox" name="" v-model='access.au' id="ckb_au_rule">
                                (A) - 
                                <?php esc_html_e('Anonymous User Rule'); ?>
                            </label>

                            <p></p>
                            <p></p>

                            <label for="ckb_lu_rule">     
                      
                                <input type="checkbox" name=""  v-model='access.lu' id="ckb_lu_rule" >
                                (L) - 
                                <?php esc_html_e('Logged In User Rule'); ?>

                                <?php 
                                    PcPuzzleCrossword_Includes::premium_image();
                                ?>  
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" ref='btn_close_modal' data-bs-dismiss="modal"> <?php esc_html_e('Close', 'advanced-crossword');?> </button>
                            <button type="button" class="btn btn-primary" @click='saveAccessRule'>  <?php esc_html_e('Save', 'advanced-crossword');?>  </button>
                        </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



    <div class="modal delete-modal-confirm" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <?php esc_html_e('Confirm Delete', 'advanced-crossword' ); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php esc_html_e('Are you sure you want to delete it?', 'advanced-crossword'); ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="" id='delete_url'>
                <button type="button" id='btn_delete_yes' class="btn btn-primary"><?php esc_html_e('Yes', 'advanced-crossword' ); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <?php esc_html_e('No', 'advanced-crossword' ); ?> </button>
            </div>
            </div>
        </div>
    </div>



<?php
}

public static function pcpuzzle_addPage( $new_url, $data, $action, $id  ){
    $rows   = 15;
    $cols   = 15;
    $start  = 1;
    $i      = $start;
    $k      = $start;
    $j      = $start;

    if( $action == 'edit'){                      
?>
        <script>
            var puzzle_action = 'edit_puzzle';
            var puzzle_id = <?php echo (int) esc_html($id); ?>;
            var puzzle_data =  <?php                    
                    echo  wp_json_encode( unserialize( $data->data_json ), ( JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK ) );
                ?>;                                                                             
        </script>
<?php
    }else{  ?>
        <script>
            var puzzle_action = 'new_puzzle';
            var puzzle_id     = -1;
        </script>    
<?php
    } 
?>  

    <div class='wrap' id='container_crossword_page'>

        <div class="container-fluid crossword-page" 
            ref="main_container"
            style='visibility: hidden'
            > 
            
            <div class="row">
 
                <input type="hidden" name="" id='input_hid_action' value="<?php echo esc_html($action); ?>" />
                <input type="hidden" name="" id='input_hid_id' value="<?php echo esc_html( $id ); ?>" />


                <div class='div-top-action'>
                    <button class='button button-primary btn-save-exit-action'                        
                    >
                        <?php esc_html_e('Save & Back', 'advanced-crossword' ) ?>
                    </button>
                    <button class='button button-primary btn-save-action'
                        @click="saveCrossword($event)"
                    >
                        <?php esc_html_e('Save', 'advanced-crossword' ) ?>
                    </button>
                    <button class='button button-primary btn-back-action ms-2' 
                        @click="backAction( $event )"
                        data-url="<?php echo esc_url( $new_url ); ?>">
                        <?php esc_html_e('Back', 'advanced-crossword' ); ?>
                    </button>
                </div>

                <p></p>
            
                <div class="view-puzzle col-lg-12 col-md-12" style='min-width: 540px;'>

                    <button id="btn_gen_nos" class='button button-secondary' style='display: none;'>
                        <?php esc_html_e('2.Generate Numbers', 'advanced-crossword' ); ?>
                    </button>

                    <div class='div-puzzle-name mb-3'>                
                        <?php
                            PcPuzzleCrossword_Includes::premium_link();                
                        ?>
                        <div class="input-group mb-3">
                            <span class="input-group-text">  
                                 <?php esc_html_e('Puzzle Name', 'advanced-crossword' ); ?> 
                            </span>
                            <input type="text" class="form-control" 
                                    style='max-width: 300px; min-width: 100px'
                                    id="input_puzzle_name" v-model="puzzle_name" 
                                    placeholder="<?php esc_html_e('Name', 'advanced-crossword' ) ?>"
                            />

                            
                            <span class="input-group-text rows-number-span"> 
                                <?php
                                    PcPuzzleCrossword_Includes::premium_image();                
                                ?>
                                &nbsp;
                                <?php esc_html_e('Rows Number', 'advanced-crossword' ); ?> 
                                &nbsp;
                                <span
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" 
                                    title="<?php esc_html_e('Can be changed with premium version', 'advanced-crossword');?>"
                                >
                                    <svg 
                                       
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </svg>
                                </span>
                            </span>
                            <input type="number"
                                class="form-control input-numbers" 
                                value='15'                                                        
                                id="rows_no" readonly="true"
                            />

                            <span class="input-group-text"> 
                                <?php
                                    PcPuzzleCrossword_Includes::premium_image();                
                                ?>
                                &nbsp;
                                <?php esc_html_e('Cols Number', 'advanced-crossword' ); ?> 
                                &nbsp;
                                <span
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" 
                                    title="<?php esc_html_e('Can be changed with premium version', 'advanced-crossword');?>"
                                >
                                    <svg 
                                       
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </svg>
                                </span>
                            </span>
                            <input type="number"                                
                                class="form-control input-numbers"                                 
                                id="rows_no" value='15'
                                readonly="true"
                            />

                        </div>

                        <div class="input-group mb-3">

                            <span class="input-group-text">   
                                <?php
                                    PcPuzzleCrossword_Includes::premium_image();                
                                ?>
                                &nbsp;
                                <?php esc_html_e('View Answers From', 'advanced-crossword' ); ?> 
                                &nbsp;
                                <span
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" 
                                    title="<?php esc_html_e('Allow the player to view the solved puzzle after 
                                                    specific date and time. (Ideal when running competitions)', 'advanced-crossword');?>"
                                >
                                    <svg 
                                       
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </svg>
                                </span>
                            </span>


                            <input type="date" class="form-control" 
                                    style='max-width: 140px; min-width: 50px'
                                    pattern="\d{4}-\d{2}-\d{2}" readonly='true'
                                    id="input_answer_from_date"                                      
                                    placeholder="<?php esc_html_e('Date', 'advanced-crossword' ) ?>"
                            />

                            <input type="time" class="form-control"
                                    style='max-width: 100px; min-width: 60px'
                                    id="input_answer_from_time" 
                                    readonly='true'                                     
                                    pattern="\d{2}-\d{2}"
                                    placeholder="<?php esc_html_e('Time', 'advanced-crossword' ) ?>"
                            />
                            <span v-show='answer_from_date !== "" '
                                @click="answer_from_date = ''; answer_from_time=''; "
                                class='btn-outline-danger'
                                title="<?php esc_html_e('Clear Date', 'advanced-crossword' ) ?>" 
                                style='margin-top: 5px; cursor: pointer; margin-left: 3px;' 
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                                    fill="#dc3545" class="bi bi-x-octagon-fill" 
                                    viewBox="0 0 16 16">
                                    <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"></path>
                                </svg>
                            </span>                        

                            <span class="restrict-input input-group-text">   
                                <span> <?php esc_html_e('Restrict Input', 'advanced-crossword' );?> </span> 
                            </span>
                            <input type="text" name="" id="input_reg_expr"
                                style='min-width: 310px'
                                v-model.trim='input_reg_expr'
                                @input='inputRegExpr'
                                ref='input_reg_expr'
                                placeholder="/[A-Za-z]/ - <?php esc_html_e('Only to characters A to Z and a to z', 'advanced-crossword');?>"
                            />

                            <span
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html='true'
                                    title="<?php 
                                                '<p>' . esc_html_e('If left empty no input restriction is applied.', 'advanced-crossword') .
                                                '</p>'
                                            ?>

                                            <?php 
                                                '<p>' . esc_html_e('Use Javascript Regular expression to Restrict input:', 'advanced-crossword') .
                                                '</p>'
                                            ?>

                                            <?php 
                                                '<p> ' . esc_html_e('Placeholder example will restrict the input only to characters from A to Z and a to z (lowercase and uppercase)', 'advanced-crossword') .
                                                '</p>'
                                            ?>
                                        
                                        "
                                >
                                    <svg 
                                       style='margin-left: 5px; margin-top: 10px; cursor: pointer;'
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </svg>
                            </span>



                        </div>



                        <div class="input-group mb-3">

                            <button @click="enableDrawBlanks" 
                                class='btn btn-outline-success mt-1'> 
                                1.
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>

                                <?php esc_html_e('Draw Blanks', 'advanced-crossword'); ?> 
                            </button>

                            <input type="checkbox" v-model="inputAnswer" class="btn-check"
                                @click="!inputAnswer" id="btn-check3-outlined" autocomplete="off">
                            <label class="btn btn-outline-primary ms-2 mt-1" for="btn-check3-outlined">
                                2.
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-input-cursor" viewBox="0 0 16 16">
                                    <path d="M10 5h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-4v1h4a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-4v1zM6 5V4H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v-1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h4z"/>
                                    <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13A.5.5 0 0 1 8 1z"/>
                                </svg>
                                <?php esc_html_e('Input Answer Cell', 'advanced-crossword' ); ?>
                            </label>

                            <input type="checkbox" v-model="toggleCellNo" class="btn-check"
                                @click="!toggleCellNo" id="btn-check-outlined" autocomplete="off">
                            <label class="btn btn-outline-primary ms-2 mt-1" for="btn-check-outlined">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                    <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                                </svg>
                                <?php esc_html_e('Toggle Cells No', 'advanced-crossword' ); ?>
                            </label>

                            <input type="checkbox" v-model="borderCollapse" class="btn-check"
                                @click="!borderCollapse" id="btn-check2-outlined" autocomplete="off">
                            <label class="btn btn-outline-info ms-2 mt-1" for="btn-check2-outlined">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                                    class="bi bi-arrows-collapse" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8Zm7-8a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 4.293V.5A.5.5 0 0 1 8 0Zm-.5 11.707-1.146 1.147a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 11.707V15.5a.5.5 0 0 1-1 0v-3.793Z"/>
                                </svg>
                                <?php esc_html_e('Border Collapse', 'advanced-crossword' ); ?>
                            </label>


                            <button @click="clearAllBlanks" 
                                class='btn btn-outline-danger ms-2 mt-1'> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                    <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                </svg>
                                <?php esc_html_e('Clear All Blanks', 'advanced-crossword'); ?> 
                            </button>

                            <button @click="clearAllAnswers" 
                                class='btn btn-outline-danger ms-2 mt-1'> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                                    fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                    <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                </svg>
                                <?php esc_html_e('Clear All Answers', 'advanced-crossword'); ?> 
                            </button>

                        </div>


                    </div>

                    <div v-show="inputAnswer" class="mb-1">
                        <p class='text-center fw-semibold' > 
                            <?php esc_html_e('Navigate with the Arrow (up, down, left, right)', 'advanced-crossword' ); ?>
                            <?php esc_html_e('- To Save simply toggle back', 'advanced-crossword');?>
                        </p>
                    </div>

                    <div id='draw_control_block' v-show="drawBlanks" class='mb-5'>

                        <div class='child' v-if='drawBlanks'>
                            <p class='mb-0'> <strong> <?php esc_html_e('Click on the table cells to mark the blank cells', 'advanced-crossword' ) ?> </strong></p>
                            <span>
                                <i id='btn_cell_checked' class="fa fa-check-square btn btn-outline-info" 
                                    @click="saveDrawBlanks" >
                                    <?php esc_html_e('Save and Generate Clues', 'advanced-crossword' ); ?>
                                </i>
                                
                            </span>
                            <span>
                                <i id='btn_cell_cancel' class="fa fa-window-close btn btn-outline-warning" 
                                    @click="cancelDrawBlanks">                                        
                                    <?php esc_html_e('Cancel', 'advanced-crossword' ); ?>
                                </i>
                                
                            </span>
                        </div>
                      
                    </div>

                    <p class='mt-3'></p>

                    <table class='puzzle-view-tbl tbl-edit-blanks mt-5' 
                        :class="{'tbl-edit-blanks-collapse': borderCollapse,
                                 'tbl-draw-blanks' : drawBlanks }">
                        <tbody ref='table_body' :class="{'cursor-pointer' : drawBlanks }">
                            <tr v-for="(row, rowIndex) in table_data">
                                <td v-for="(colVal, index) in row" 
                                    :title="(rowIndex + 1) + '-' + ( index + 1 )"                                    
                                    :id="`td-${rowIndex}-${index}`"
                                    >
                                        <div @click="markBlank(rowIndex, index, $event)" v-if="toggleCellNo" 
                                            :class="{blank : colVal === BLANK_SYMBOL, 'inner-div-td': true }"  > 
                                            {{ rowIndex + 1 }}-{{ index + 1 }}  
                                        </div>
                                        <div v-else :class="{'blank' : colVal === BLANK_SYMBOL, 'inner-div-td': true }"
                                            @click="markBlank(rowIndex, index, $event)">
                                                <div class='td-clue-no'>
                                                    {{ [ 0, '#'].includes( colVal ) ? '' : colVal }}
                                                </div>

                                                <div class="cell-data-val"
                                                 :id="rowIndex.toString()+'-'+index.toString()">
                                                    <div v-if="inputAnswer && colVal !== BLANK_SYMBOL">
                                                        <input type="text" :id="`id${rowIndex}-${index}`" 
                                                            class='input-cell-value form-control' 
                                                            :maxlength='1'
                                                            @keyup="inputCellKeyUp($event)" 
                                                            :data-indexi="rowIndex" 
                                                            :data-indexj="index"                                                         
                                                            v-model="answer_data[rowIndex][index]"                                                                                                                      
                                                        />
                                                    </div>
                                                    <div v-else>
                                                        {{ typeof answer_data[rowIndex] !== 'undefined' ?
                                                         (['#', '0'].includes( answer_data[rowIndex][index]) ? ' ' : answer_data[rowIndex][index]  )  : '' }}
                                                    </div>
                                                  
                                                </div>                                                
                                        </div>
                                    </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="row clues-div">
                    <div class="col-md-6" style="">
                        <h5> 
                            <?php esc_html_e( 'Across Clue', 'advanced-crossword' ); ?> 
                            <span v-html="acrossClueNotFilled"></span>
                        </h5>
                        <div id='div_h_qa' class='mt-2'>
                            <div v-for="item in hor_clues">
                            
                                <div class="input-group mb-2 mt-2">
                                    <span class="input-group-text">   
                                        <?php esc_html_e('Clue', 'advanced-crossword' ); ?>-{{item.clue}} </span>
                                    <input type="text" class="form-control" style='max-width: 400px; min-width: 100px'
                                            id="clue-h-{{item}}" 
                                            @focus="actionClueAcross('focus', item)"
                                            @blur="actionClueAcross('blur', item)"                                           
                                            v-model="item.q"
                                            placeholder="<?php esc_html_e('Clue', 'advanced-crossword' ) ?>"
                                    />

                                    <span v-show="item.q.trim().length > 0" style="cursor: pointer" 
                                        @click="item.q=''"
                                        class="ms-1 mt-1" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" 
                                            fill="red" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                        </svg>
                                    </span>

                                </div>
                            </div>
                        
                        </div>
                    </div>

                    <div class="col-md-6">

                        <h5> 
                            <?php esc_html_e( 'Down Clue', 'advanced-crossword' ); ?> 
                            <span v-html="downClueNotFilled"></span>
                        </h5>

                        <div id="div_v_qa">
                            <div v-for="item in ver_clues">
                                
                                <div class="input-group mb-2 mt-2">
                                    <span class="input-group-text">   
                                        <?php esc_html_e('Clue', 'advanced-crossword' ); ?>-{{item.clue}} </span>
                                    <input type="text" class="form-control" style='max-width: 400px; min-width: 100px'
                                            id="clue-h-{{item}}" 
                                            @focus="actionClueDown('focus', item)"
                                            @blur="actionClueDown('blur', item)"
                                            v-model="item.q"
                                            placeholder="<?php esc_html_e('Clue', 'advanced-crossword' ) ?>"
                                    />

                                    <span v-show="item.q.trim().length > 0" style="cursor: pointer" 
                                        @click="item.q=''"
                                        class="ms-1 mt-1" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" 
                                            fill="red" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                        </svg>
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='div-bottom-action mt-3'>
                    <button class='button button-primary btn-save-exit-action'>
                        <?php esc_html_e('Save & Back', 'advanced-crossword' ) ?>
                    </button>
                    <button class='button button-primary btn-save-action'
                        @click="saveCrossword($event)"
                    >
                        <?php esc_html_e('Save', 'advanced-crossword' ) ?>
                    </button>
                    <button class='button button-primary btn-back-action ms-2'
                        @click="backAction( $event )"
                         data-url="<?php echo esc_url($new_url); ?>">
                        <?php esc_html_e('Back', 'advanced-crossword' ); ?>
                    </button>
                </div>

            </div>

        </div>

        <?php wp_nonce_field( 'pc_secure_action', 'pc_secure_nonce_field' ); ?>

    </div>
 
<?php
}
}