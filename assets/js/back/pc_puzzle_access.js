
const { createApp } = Vue;
const AJAX_CROSSWORD_ACTION = 'puzzle_admin_actions';

const settings = createApp({
    data (){
        return {
            login_rules : {
                au : {
                    img_url : '',
                    red_url : '',
                    text : ''
                }
            },
            rules : [],
            saving : false,
            action : 'save_rules',
            tinyMCEsecs : 3,
            tinyCounter : 0

        }
    },
    methods : {
        actionRule : function( action ){
            
            this.$refs.btn_modal.click();
            this.$refs.modal_header.textContent = crswrd_new_lng[ action ] || 'Action';
        },

        saveSettings : function ( $event ){
            /*
            let tinyMceVisual = document.querySelector( '#tuskcode_info_editor-tmce');
            if( tinyMceVisual !== null ){
                tinyMceVisual.click();
            }
            */
                    
            this.saving = true;
            let _wponce_val = document.querySelector('#pc_secure_nonce_field');
            let form = new FormData();
            let _this = this;
            

            form.append( 'action', AJAX_CROSSWORD_ACTION );
            form.append( 'page_action', this.action );
            form.append( 'data', JSON.stringify( this.login_rules ) );
            form.append( 'nonce', _wponce_val.value || '' );       

            fetch( ajaxurl,{
                method : 'POST',
                body : form
            })
            .then( response => response.json() )
            .then( data => { 
                          
                if( data.response == 'fine'){

                    if( data.data && data.data.login_rules ){                      
                        this.login_rules = Object.assign({}, data.data.login_rules );                        
                    }

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
        this.login_rules = pc_puzzle_access.login_rules;
    },

    mounted (){       
        this.setInfoEditorContent2();
    }
}).mount('.pc-access-page');