
const { createApp } = Vue;
const AJAX_CROSSWORD_ACTION = 'puzzle_admin_actions';

const settings = createApp({
    data (){
        return {
            settings : {
                menu : Object.assign( {}, pc_puzzle_settings.menu ),
                sizes : Object.assign( {}, pc_puzzle_settings.sizes ),
                labels : Object.assign( {}, pc_puzzle_settings.labels ),
                info : pc_puzzle_settings.info
            },
            saving : false,
            action : 'save_settings',
            tinyMCEsecs : 3,
            tinyCounter : 0

        }
    },
    computed :{
        isValidEmail() {
            if( this.settings.menu.general.reportBugEmail.trim() == '' )
                return true;
                
            return /^[^@]+@\w+(\.\w+)+\w$/.test(this.settings.menu.general.reportBugEmail);
          }
    },
    methods : {
        saveSettings : function ( $event ){
            
            let tinyMceVisual = document.querySelector( '#tuskcode_info_editor-tmce');
            if( tinyMceVisual !== null ){
                tinyMceVisual.click();
            }
                    
            this.saving = true;
            let _wponce_val = document.querySelector('#pc_secure_nonce_field');
            let form = new FormData();
            let _this = this;
            this.settings.info = '';

            form.append( 'action', AJAX_CROSSWORD_ACTION );
            form.append( 'page_action', this.action );
            form.append( 'data', JSON.stringify( this.$data.settings ) );
            form.append( 'nonce', _wponce_val.value || '' );       

            fetch( ajaxurl,{
                method : 'POST',
                body : form
            })
            .then( response => response.json() )
            .then( data => { 
                          
                if( data.response == 'fine'){
                    this.settings = Object.assign({}, data.data );            

                    bootbox.alert({
                        size : 'small',
                        title : crswrd_new_lng.info,
                        message :  crswrd_new_lng.saved
                    } );
                }else{

                }

                this.saving = false;

            })
            .catch( error =>{
                this.saving = false;
                bootbox.alert( 'Error ' + error );
            })
        },

        setInfoEditorContent2 : function(){

        },

        setInfoEditorContent : function(){
            try {
               
                setTimeout( ()=>{
                    if( typeof tinyMCE ==='undefined' && this.tinyCounter < this.tinyMCEsecs ){
                        this.tinyCounter += 1;
                        this.setInfoEditorContent();                       
                    }           

                    if( typeof tinyMCE.editors.tuskcode_info_editor !== 'undefined'){ 

                        tinyMCE.init({
                        
                            init_instance_callback: function(){
                                tinyMCE.editors.tuskcode_info_editor.setContent( 
                                    this.settings.info
                                );  
                            }
                        });                                                                      
                                            
                    }else{
                        console.log( 'Editor MCE editor is not defined');
                    } 
                
                    
                }, 1000 );

            } catch (error) {
                console.error( error );
            }
        }
    },

    beforeMount(){

    },

    mounted (){       
        this.setInfoEditorContent2();
    }
}).mount('.pc-settings-page');