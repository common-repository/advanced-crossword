


const { createApp } = Vue;
const AJAX_CROSSWORD_ACTION = 'puzzle_admin_actions';
var init_state_crossword = '';
const PUZZLE_ACTION = {
    new : 'new_puzzle',
    edit : 'edit_puzzle',
    del : 'del_puzzle'
};

let crossword_puzzle = document.querySelector('#container_crossword_page');

if( crossword_puzzle !== null ) {
    
    const puzzle_crossword_modal = createApp({

        data (){
            return {
                puzzle_name : crswrd_new_lng.newCrossword,
                puzzle_id : -1,
                rows_no : 15,
                cols_no : 15,
                table_data_prev : [],
                table_data : [],
                toggleCellNo : false,
                action : PUZZLE_ACTION.new,
                changesRecorded : false,
                drawBlanks : false,   
                BLANK_SYMBOL : '#',
                borderCollapse : false,
                hor_clues : {},
                ver_clues : {},
                q_start_at : 1,                   
                answer_data : [],
                inputAnswer : false, 
                acrossClueNotFilled : '',
                downClueNotFilled : '',
                answer_from_date : '',
                answer_from_time : '',
                input_reg_expr   : '',
                is_valid_reg_expr : true

            }
        },

        watch : {
            hor_clues :{
                handler( newVal, oldVal ){               
                    let counter = 0;
                    let allItems = 0;
                    let item_obj = null;

                    for( const item in newVal ){

                        item_obj = newVal[ item.toString() ];

                        if( item_obj.q.trim() !== '') counter++;

                        allItems++;
                    }            

                    if( counter == allItems )
                        this.acrossClueNotFilled = ''
                    else
                        this.acrossClueNotFilled = '<span class="text-danger fw-semibold">(' + (allItems - counter) + ') </span>'; 
                },
                deep : true,
                immediate : true
            },

            ver_clues :{
                handler( newVal, oldVal ){
        
                    let counter = 0;
                    let allItems = 0;
                    let item_obj = null;

                    for( const item in newVal ){

                        item_obj = newVal[ item.toString() ];

                        if( item_obj.q.trim() !== '')counter++;

                        allItems++;
                    }               

                    if( counter == allItems ) this.downClueNotFilled = ''
                    else
                        this.downClueNotFilled = '<span class="text-danger fw-semibold">(' + (allItems - counter) + ') </span>'; 
                },
                deep : true,
                immediate : true
            },

            inputAnswer( val, oldVal ){
                if( val ){ 
                    setTimeout( ()=>{                    
                        let first_input = this.findFirstEmptyInput();              
                        if( first_input !== null ){
                            first_input.focus();
                            first_input.setSelectionRange( 0, 1);
                        }
                    }, 200 );
                }            
            }
        },
        
        methods : {
            
            drawCells: function(){             
                
                this.fillArray();  
                this.updateAnswerData();                   
            },

            updateAnswerData: function(){
                let clone_answer = this.cloneAnswerTable();
            
                this.initAnswerData(); //reset the data

                //copy over from the clone with the new rows and cols
                for( let i = 0; i < this.answer_data.length; i++ ){
                    for( let j = 0; j < this.answer_data[i].length; j++ ){
                        this.answer_data[i][j] = ( ( clone_answer[i] !== null ) &&
                                                    typeof clone_answer[i] !== 'undefined' &&
                                                    typeof clone_answer[i][j] !== 'undefined' )
                                                    ? clone_answer[i][j] : '';
                    }
                }
                
            },

            inputRegExpr : function(){     

                if( this.input_reg_expr == ''){
                    this.$refs.input_reg_expr.style.borderColor = 'inherit';
                    this.is_valid_reg_expr = true;
                    return;              
                }

                this.is_valid_reg_expr = this.validateRegex( this.input_reg_expr );

                if( ! is_valid ){
                   this.$refs.input_reg_expr.style.borderColor = 'red';
                   this.$refs.input_reg_expr.style.color = 'red';
                   
                }else{
                    this.$refs.input_reg_expr.style.borderColor = 'inherit';
                    this.$refs.input_reg_expr.style.color = 'inherit';
                }

            },

            validateRegex : function(pattern) {
                var parts = pattern.split('/'),
                    regex = pattern,
                    options = "";
                if (parts.length > 1) {
                    regex = parts[1];
                    options = parts[2];
                }
                try {
                    return RegExp(regex, options);                             
                }
                catch(e) {
                    return false;
                }
            },


            inputCellKeyUp: function( $event ){  

                let $i = parseInt( $event.target.dataset.indexi );
                let $j = parseInt( $event.target.dataset.indexj );
                let keyCodeStr = $event.keyCode.toString();

                if( this.is_valid_reg_expr && this.input_reg_expr !== ''){
                    const regex = this.validateRegex( this.input_reg_expr );
                    let value = $event.target.value;
                    if( ! regex.test( value )){
                        this.answer_data[ $i ] [ $j ] = '';
                        return;
                    }
                }

                let directions = {
                    37 : 'left',
                    39 : 'right',
                    40 : 'down',
                    38 : 'up'
                };            

                if( keyCodeStr == 8 ){ //backspace
                    keyCodeStr = '37';
                    $event.target.value = '';
                }        

                if( keyCodeStr in directions ){
                    this.findInputByDirection( 
                                    $i, $j, directions[ keyCodeStr ]);
                
                }else{

                    let val = $event.target.value
                            .trim()
                            .toUpperCase();
                    $event.target.value = val;
                
                    this.answer_data[ $i ] [ $j ] = val;  

                    if( val !== '' ){
                        this.findNextEmptyInput( $event.target.id );
                    }  
                }                             
            },

            findNextEmptyInput: function( $id ){
                let table = document.querySelector( '.puzzle-view-tbl');
                let next_input_lst = table.querySelectorAll("input[type='text']");
                let next_input = null;       

                for( let i = 0; i < next_input_lst.length; i++ ){
                    next_input = next_input_lst[ i ];
                
                    if( ( next_input.id === $id ) && 
                        ( typeof next_input_lst[i + 1] !== 'undefined') ){
                            next_input_lst[i + 1].focus();
                            next_input_lst[i + 1].setSelectionRange(0, 1);                    
                            break;
                    }
                }
            },

            findInputById : function( $id ){
                let table = document.querySelector( '.puzzle-view-tbl');
                let input = table.querySelector('#' + $id );       
                return input;
            },

            findFirstEmptyInput : function(){
                let table = document.querySelector( '.puzzle-view-tbl');
                let input_lst = table.querySelectorAll("input[type='text']");    
                let input = null;

                for( let i = 0; i < input_lst.length; i++ ){
                    input = input_lst[ i ];
                    if( input.value.trim() === '' ){
                        return input;
                    }
                }

                return null;
            },

            findInputByDirection : function( $i, $j, $direction ){
            
                if( $direction == 'up') $i -= 1;
                else if( $direction == 'down') $i += 1;
                else if( $direction == 'left') $j -= 1;
                else if( $direction == 'right') $j += 1;

                //making move in all directions, even when reaching the end
                if( $i == this.rows_no ) $i = 0;
                if( $j == this.cols_no ) $j = 0;
                if( $i == -1 ) $i = this.rows_no;            
                if( $j == -1 ) $j = this.cols_no;            

                if( $i >= -1 && $j >= -1 && $i <= this.rows_no && $j <= this.cols_no ){

                    let table = document.querySelector( '.puzzle-view-tbl');
                    let id = '';                
                    
                    id = `#id${$i}-${$j}`;

                    let input = table.querySelector( id );
        

                    if( input === null ){    
                        return this.findInputByDirection( $i, $j, $direction );
                    }else{
                        input.focus();
                        input.setSelectionRange(0, 1 );
                    }
                                    
                }else{               
                    return null;
                }
            },

            generateHorQ : function(){

                let cell_val = '';
                let prev_cell = this.BLANK_SYMBOL;
                let top_cell = this.BLANK_SYMBOL;
                let next_cell = this.BLANK_SYMBOL;
                let bott_cell = this.BLANK_SYMBOL;
                let prev_hor_clues = Object.assign( {}, this.hor_clues );
                let prev_ver_clues = Object.assign( {}, this.ver_clues );
                this.hor_clues = {};
                this.ver_clues = {};
                this.clearDataFromClues();
                this.q_start_at = 1;
                let is_checked = false;

                for( let i = 0; i < this.table_data.length; i++ ){

                    for( let j = 0; j < this.table_data[ i ].length; j++ ){

                        cell_val = this.table_data[ i ][ j ];
                        prev_cell = typeof this.table_data[ i ][ j - 1] !== 'undefined' ? this.table_data[ i ][ j - 1] : this.BLANK_SYMBOL;
                        top_cell  = typeof this.table_data[ i - 1] !== 'undefined' ? this.table_data[ i -1 ][ j ] : this.BLANK_SYMBOL;
                        next_cell = typeof this.table_data[ i ][ j + 1 ] !== 'undefined' ? this.table_data[ i ][ j + 1 ] : this.BLANK_SYMBOL;
                        bott_cell = typeof this.table_data[ i + 1] !== 'undefined' ? this.table_data[ i + 1 ][ j ] : this.BLANK_SYMBOL;
                        is_checked = false;

                        if( cell_val === this.BLANK_SYMBOL ){
                            //nothing to do
                        }else if( prev_cell === this.BLANK_SYMBOL && next_cell === this.BLANK_SYMBOL ){
                            //check if vertical works
                            if( bott_cell !== this.BLANK_SYMBOL && top_cell === this.BLANK_SYMBOL ){
                                
                                this.ver_clues[ this.q_start_at.toString() ] = {
                                        'i' : i,
                                        'j' : j,
                                        'len' : 1,
                                        'clue' : this.q_start_at,
                                        'ans' : '',
                                        'q' : ( this.q_start_at.toString() in prev_ver_clues ) ?
                                                prev_ver_clues[ this.q_start_at.toString() ].q : ''
                                    };
                                                        
                                this.addClueToData( i, j, this.q_start_at );
                                this.q_start_at += 1;   
                            }
                        }else if( prev_cell !== this.BLANK_SYMBOL && next_cell !== this.BLANK_SYMBOL ){
                            //check only top
                            if( top_cell === this.BLANK_SYMBOL && bott_cell !== this.BLANK_SYMBOL ){
                                this.ver_clues[ this.q_start_at.toString() ] = {
                                    'i' : i,
                                    'j' : j,
                                    'len' : 1,
                                    'clue' : this.q_start_at,
                                    'ans' : '',
                                    'q' :  ( this.q_start_at.toString() in prev_ver_clues ) ?
                                            prev_ver_clues[ this.q_start_at.toString() ].q : ''
                                };                             
                                this.addClueToData( i, j, this.q_start_at );
                                this.q_start_at += 1;  
                            }
                        }else{
                            //check horizontal
                            if( prev_cell === this.BLANK_SYMBOL && next_cell !== this.BLANK_SYMBOL ){ 
                                this.hor_clues[ this.q_start_at.toString() ] = {
                                    'i' : i,
                                    'j' : j,
                                    'len' : 1,
                                    'clue' : this.q_start_at,
                                    'ans' : '',
                                    'q' :  ( this.q_start_at.toString() in prev_hor_clues ) ?
                                            prev_hor_clues[ this.q_start_at.toString() ].q : ''
                                }; 
                                this.addClueToData( i, j, this.q_start_at  ); 
                                
                                //check if works vertically too
                                if( bott_cell !== this.BLANK_SYMBOL && top_cell === this.BLANK_SYMBOL ){
                                    this.ver_clues[ this.q_start_at.toString() ] = {
                                        'i' : i,
                                        'j' : j,
                                        'len' : 1,
                                        'clue' : this.q_start_at,
                                        'ans' : '',
                                        'q' :  ( this.q_start_at.toString() in prev_ver_clues ) ?
                                                prev_ver_clues[ this.q_start_at.toString() ].q : ''
                                    };   
                                }

                                this.q_start_at += 1;  
                                is_checked = true;   

                            }

                            //check vertical 
                            if( !is_checked && top_cell === this.BLANK_SYMBOL && 
                                bott_cell !== this.BLANK_SYMBOL ){

                                this.ver_clues[ this.q_start_at.toString() ] = {
                                    'i' : i,
                                    'j' : j,
                                    'len' : 1,
                                    'clue' : this.q_start_at,
                                    'ans' : '',
                                    'q' :  ( this.q_start_at.toString() in prev_ver_clues ) ?
                                            prev_ver_clues[ this.q_start_at.toString() ].q : ''
                                };    

                                this.addClueToData( i, j, this.q_start_at );   
                                this.q_start_at += 1;                     
                            }
                        }
                    }
                }

                this.table_data_prev = this.cloneMainTable();
                this.calculateLenForEachClue();            
            },


            addClueToData : function( i, j, clueNo ){
                if( typeof this.table_data[i] !== 'undefined' && 
                    typeof this.table_data[i][j] !== 'undefined')
                        this.table_data[i][j] = clueNo;
            },

            calculateLenForEachClue : function(){

                let len = 0;
                let i = 0;
                let j = 0;
                let clue_obj = null;

                for( const clue in this.hor_clues ){

                    len = 0;
                    clue_obj = this.hor_clues[ clue ];
                    j = clue_obj.j;           
                    i = clue_obj.i;
        
                    while( j < this.cols_no ){        
                        if( this.table_data[i][j] !== this.BLANK_SYMBOL ){
                            len++;
                        }else{
                            j = this.cols_no;
                        }

                        j++;
                    }

                    clue_obj.len = len;
                }

                for( const clue in this.ver_clues ){
                    len = 0;
                    clue_obj = this.ver_clues[ clue ];
                    j = clue_obj.j;
            
                    i = clue_obj.i;
        
                    while( i < this.rows_no ){        
                        if( this.table_data[i][j] !== this.BLANK_SYMBOL ){
                            len++;
                        }else{
                            i = this.rows_no;
                        }

                        i++;
                    }

                    clue_obj.len = len;
                }
            },

            actionClueAcross : function( action, item ){

                let i = item.i;
                let j = item.j;
                let len = item.len + item.j;
                let table = document.querySelector( '.puzzle-view-tbl');
                let sel_item = null;
                let id = '';

                while( j < len ){

                    id = `#td-${i}-${j}`;
                    sel_item = table.querySelector( id );
                
                    if( sel_item !== null ){

                        if( action == 'focus')
                            sel_item.classList.add( 'td-highlight');
                        else if( action == 'blur')
                            sel_item.classList.remove( 'td-highlight');
                    }

                    j++;
                }   
            },

            actionClueDown : function(action, item ){

                let i = item.i;
                let j = item.j;
                let len = item.len + item.i;
                let table = document.querySelector( '.puzzle-view-tbl');
                let sel_item = null;
                let id = '';

                while( i < len ){

                    id = `#td-${i}-${j}`;
                    sel_item = table.querySelector( id );
                
                    if( sel_item !== null ){

                        if( action == 'focus')
                            sel_item.classList.add( 'td-highlight');
                        else if( action == 'blur')
                            sel_item.classList.remove( 'td-highlight');
                    }

                    i++;
                }
            },

            saveCrossword : function( $event ){  
                let allOk = this.readyToSave();
                if( ! allOk.lOk ){
                    bootbox.alert({
                        size : 'small',
                        title : crswrd_new_lng.info,
                        message :  allOk.message || ''
                    });

                    return false;
                }
                
                if( this.changesOccured() ){
                    this.saveCrosswordData( $event );                
                }else{
                    console.log( 'No Changes Recorded');
                }         
                
            },

            backAction : function( $event ){

                if( this.changesOccured() ){
            
                    bootbox.confirm({
                        message: crswrd_new_lng.changesOccured, 
                        centerVertical: true,                    
                        callback: function( result ){ 
                        
                            if( result )
                                window.location.href = $event.target.dataset.url;                                            
                        }
                    });  
                
                }else{
                    window.location.href = $event.target.dataset.url;
                }
                
            },

            clearDataFromClues : function(){
                let val = '';
                let arr = this.cloneMainTable();

                for( let i = 0; i < arr.length; i++ ){
                    for( let j = 0; j < arr[i].length; j++ ){
                        val = arr[i][j];
                        if( ( val !== 0 ) && ( val !== this.BLANK_SYMBOL ) ){                                        
                            arr[i][j] = 0;                                           
                        }
                    }
                }

                this.table_data = arr;
            },
        
            generateVerQ : function(){
        
            },

            initAnswerData : function(){
                this.answer_data = [];

                for( let i = 0; i < this.rows_no; i++ ){
                    this.answer_data[i] = [];
                    this.answer_data[i].length = this.cols_no;
                    this.answer_data[i].fill( '');             
                }   
            },

            saveDrawBlanks : function(){
                this.drawBlanks = false;
                this.table_data_prev = this.cloneMainTable();
            
                this.generateHorQ();
                this.updateAnswerBlanks();
            },

            updateAnswerBlanks : function(){
                for( let i = 0; i < this.table_data.length; i++ ){
                    for( let j = 0; j < this.table_data[i].length; j++ ){
                        if( this.table_data[i][j] == this.BLANK_SYMBOL ){
                            this.answer_data[i][j] = this.BLANK_SYMBOL;
                        }else if(   this.answer_data[i][j] == this.BLANK_SYMBOL 
                                    && this.table_data[i][j] !== this.BLANK_SYMBOL ){
                                        this.answer_data[i][j] = '';
                        }
                    }
                }
            },

            cancelDrawBlanks : function(){            
                this.drawBlanks = false;
                this.table_data = this.clonePrevTable();
            },

            setupAnswers : function(){
                    
                this.answer_data = this.cloneMainTable();

                for( let i = 0; i< this.answer_data.length; i++ ){

                    for( let j = 0; j< this.answer_data[i].length; j++ ){    
                        
                        if( this.answer_data[i][j] === this.BLANK_SYMBOL ) 
                            this.answer_data[i][j] = this.BLANK_SYMBOL; 
                        else 
                            this.answer_data[i][j] = '';
                    }
                }

            },

            fillArray: function(){
                //keep in any added blanks
                this.resetTableData();         

                for( let i = 0; i < this.table_data_prev.length; i++ ){                                
                    for( let j = 0; j < this.table_data_prev[i].length; j++ ){

                        if( typeof this.table_data[i] !== 'undefined' && 
                            typeof this.table_data[i][j] !== 'undefined' ){
                            this.table_data[i][j] = this.table_data_prev[i][j];
                        }
                    }
                }
            
                this.table_data_prev = this.cloneMainTable();  
            },

            changesOccured : function(){
                return init_state_crossword !== JSON.stringify( this.$data );
            },

            enableDrawBlanks : function(){
                this.drawBlanks = true;
            },

            cloneMainTable : function(){
                return JSON.parse( JSON.stringify( this.table_data ));
            },

            clonePrevTable : function(){
                return JSON.parse( JSON.stringify( this.table_data_prev ));
            },

            cloneAnswerTable : function(){
                return JSON.parse( JSON.stringify( this.answer_data ));
            },

            resetTableData: function(){         
                this.table_data = [];
            
                for( let i = 0; i < this.rows_no; i++ ){
                    this.table_data[i] = [];
                    this.table_data[i].length = this.cols_no;
                    this.table_data[i].fill(0); 
                } 
                
            },

            markBlank : function(row, col, el ){
                if( this.drawBlanks ){
                    el.target.classList.toggle( 'blank');                          
                    this.table_data[row][col] = el.target.classList.contains('blank') 
                                                ? this.BLANK_SYMBOL : 0;          
                }
            },

            clearAllBlanks : function(){
                let _this = this;
                bootbox.confirm({
                    message: crswrd_new_lng.areYouSureYouWantToClearAllBlanks,  
                    centerVertical: true,                    
                    callback: function( result ){ 
                    
                        if( result ){
                            _this.resetTableData();
                            _this.table_data_prev = _this.cloneMainTable();
                        }                     
                    }
                }); 
            },

            clearAllAnswers : function(){
                let _this = this;
                bootbox.confirm({
                    message: crswrd_new_lng.areYouSureYouWantToClearAllAnswerCells, 
                    centerVertical: true,                    
                    callback: function( result ){ 
                    
                        if( result ){
                            _this.initAnswerData();
                        }                     
                    }
                }); 
            },

            saveCrosswordData : function( $btnEvent ){
                //save current state of the crossword
                this.disabledSaveBtn( $btnEvent );

                let _wponce_val = document.querySelector('#pc_secure_nonce_field');
                let form = new FormData();
                let _this = this;

                form.append( 'action', AJAX_CROSSWORD_ACTION );
                form.append( 'page_action', this.action );
                form.append( 'data', JSON.stringify( this.$data ) );
                form.append( 'nonce', _wponce_val.value || '' );
                form.append( 'puzzle_name', this.puzzle_name );
                form.append( 'rows_no', this.rows_no );
                form.append( 'cols_no', this.cols_no );
                form.append( 'puzzle_id', this.puzzle_id );
                form.append( 'answer_from_date', this.answer_from_date  );
                form.append( 'answer_from_time', this.answer_from_time );                

                fetch( ajaxurl,{
                    method : 'POST',
                    body : form
                })
                .then( response => response.json() )
                .then( data => { 
            
                    _this.enableSaveBtn( $btnEvent );

                    if( ! data.response ){
                        bootbox.alert( data.message || ' ' );
                    }else{
                        //new saved, now is edit, change the url                     
                        if( this.action == PUZZLE_ACTION.new ){
                            history.replaceState({ editPage : 'crossword'}, '', 
                            'admin.php?page=PcPuzzleCrossword_Plugin_puzzle_crosswords&action=edit&id=' + data.puzzle_id )                      
                        }

                        this.puzzle_id = data.puzzle_id;
                        if( this.puzzle_id > -1 ) this.action = PUZZLE_ACTION.edit;

                        bootbox.alert({
                            size : 'small',
                            title : crswrd_new_lng.info,
                            message :  crswrd_new_lng.saved
                        } );

                        init_state_crossword = JSON.stringify( this.$data );
                    }

                })
                .catch( error =>{
                    _this.enableSaveBtn( $btnEvent );
                    bootbox.alert( 'Error ' + error );
                })
            },

            readyToSave : function(){
                let result = {
                    'lOk' : true,
                    'message' : ''
                };

                if( this.puzzle_name.trim() === '' )
                    result.message = crswrd_new_lng.puzzleNameRequired;
                else if( this.rows_no < 1 )
                    result.message = crswrd_new_lng.rowsNoGreaterThanZero;            
                else if( this.cols_no < 1 )
                    result.message = crswrd_new_lng.colsNoGreaterThanZero; 
                
                if( result.message !== '' ) result.lOk = false;

                return result;
            },

            disabledSaveBtn : function( $btnEvent ){
                $btnEvent.target.textContent = crswrd_new_lng.saving;
                $btnEvent.target.disabled = 'disabled';
            },
        
            enableSaveBtn : function( $btnEvent ){
                $btnEvent.target.textContent = crswrd_new_lng.save;
                $btnEvent.target.disabled = '';
            },

        },

        mounted(){
            
            if( puzzle_action == PUZZLE_ACTION.edit ){
                    
                puzzle_data = JSON.parse( puzzle_data );         
                for( const item in this.$data ){
                    if( item in puzzle_data ){
                        this.$data[ item.toString() ] = puzzle_data[ item.toString() ];
                    }
                } 
                
                this.action = PUZZLE_ACTION.edit;
                this.puzzle_id = puzzle_id;
                this.toggleCellNo = false;
                this.inputAnswer = false;
            }

            try {
                if( this.action == PUZZLE_ACTION.new ){
                    this.resetTableData();
                    this.fillArray(); 

                    this.initAnswerData(); 
                }
            } catch (error) {
                console.log('error mounting', error );
            }

            this.$refs.main_container.classList.add( 'show-loaded'); 
            init_state_crossword = JSON.stringify( this.$data );  

            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));


        }
    }).mount('#container_crossword_page');
}