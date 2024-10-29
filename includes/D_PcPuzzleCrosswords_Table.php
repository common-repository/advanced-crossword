<?php
namespace D_PcPuzzleCrosswords_Table;

if( ! defined('ABSPATH') ) die;

class D_PcPuzzleCrosswords_Table{
    private $db = null;
    private $table = '';

    function __construct(){
        global $wpdb;

        $this->db               = $wpdb;
        $this->table            = $wpdb->prefix . 'puzzle_crossword';
    }

    public function getAllCrosswords(){
        $result = $this->db->get_results( " SELECT *                                           
                                            FROM {$this->table} as main                                            
                                            ORDER BY id DESC ");

        return $result;      
    }

    public function getPuzzleNameFromId( $id ){

        $id = intval( $id);

        $result = $this->db->get_results( $this->db->prepare( "SELECT * FROM $this->table
                                                               WHERE id = %d;", 
                                                               $id ));

        if( sizeof( $result ) > 0 )
            $result = $result[0]->pc_name;
        else 
            $result = '';

        return $result;
    }

    public function getCrosswordById( $id ){
        
        try {

            $id = intval( $id);

            $result = $this->db->get_results( $this->db->prepare( "SELECT * FROM $this->table
                                                                    WHERE id = %d;", $id ));

            if( sizeof( $result ) > 0 )
                $result = $result[0];
            else 
                $result = null;

                    
        } catch (\Throwable $th) {
            $result = null;
        }

        if( $result !== null )
            $result->data_json_two = unserialize( base64_decode(  $result->data_json_two ) );
            
        return $result;     
    }


    public function updateCrossword( $id, $data ){
        $id             = (int) $id;
        $pc_name        = $data['pc_name'];      
        $data_json      = serialize( $data['data_json'] );
        $rows_no        = (int) $data['rows_no'];
        $cols_no        = (int) $data['cols_no'];
        $answer_from    = $data['answer_from'];
        $answer_from_no = $data['answer_from_no'];

        $result = $this->db->query( 
                    $this->db->prepare(
                            "UPDATE {$this->table} 
                            SET pc_name = %s,
                                rows_no = %d,
                                cols_no = %d,
                                data_json = %s,
                                answer_from = %s,
                                answer_from_no = %s                                                       
                            WHERE id = %d",  
                                $pc_name, 
                                $rows_no,
                                $cols_no,
                                $data_json, 
                                $answer_from,
                                $answer_from_no,
                                $id )
                    );
        return $result;                                                        
    }

    public function deleteCrossword( $id ){
        $id = intval( $id );
        $result = $this->db->query( $this->db->prepare( "DELETE FROM {$this->table} 
                                                         WHERE id = %d", 
                                                         $id ));     
    }

    public function getLastInsertedId(){
        $result = $this->db->get_results( " SELECT * from {$this->table} 
                                            ORDER BY id DESC 
                                            LIMIT 1");

        if( count( $result ) > 0 )
            return $result[0]->id;
        else
            return false;

    }


    public function insertNewCrossword( $data ){
        $pc_name        = $data['pc_name'];
        $is_active      = intval( $data['is_active'] );
        $data_json      = serialize( $data['data_json'] );
        $created_by     = intval( $data['user_id'] );    
        $pdf_filename   = $data['pdf_filename'];
        $rows_no        = $data['rows_no'];
        $cols_no        = $data['cols_no'];
        $answer_from    = $data['answer_from'];
        $answer_from_no = $data['answer_from_no'];

        $result = $this->db->query( $this->db->prepare(     
                            "INSERT INTO {$this->table} 
                            (pc_name, rows_no, cols_no, is_active, 
                            data_json, created_by, pdf_filename, answer_from,
                            answer_from_no )
                            VALUES( %s, %d, %d, %d, 
                                    %s, %d, %s, %s,
                                    %s )", 
                            $pc_name, $rows_no, $cols_no, $is_active, 
                            $data_json, $created_by, $pdf_filename, $answer_from,
                            $answer_from_no ) );

        return $result;                                                        
    }

}