
document.addEventListener('DOMContentLoaded', () =>{
    const AJAX_CROSSWORD_ACTION = 'puzzle_admin_actions';
    let section_grid = document.querySelector( '.section-content-grid');
    if( section_grid == null )
        return;

    const crossword_grid = createApp({
        data () {

            return {
                access : {
                    puzzle_id : 0,
                    au : false,
                    lu : false
                },
                cross : {},
                saving : false,
                action : 'save_cross_rules'

            }            
        },

        methods : {

            actionAccessPuzzle : function( puzzle_id, puzzle_name ){
                this.access.puzzle_id = puzzle_id;

                if( this.cross[ puzzle_id ] ){                               
                    this.access.au = this.cross[ puzzle_id ].au || false;
                    this.access.lu = false;
                }else{             
                    this.access.au = false;
                    this.access.lu = false;
                }

                this.$refs.btn_modal_access.click();
            
            },

            saveAccessRule :function(){
                let _this = this;
                this.cross[ _this.access.puzzle_id ] = {
                    'au' : _this.access.au,
                    'lu' : false
                };

                this.$refs.btn_close_modal.click();

                this.saveRules();

            },

            copyShortcode : function(){                                                  
                let td_parent = event.target.parentNode;
                let span_copied = null;

                navigator.clipboard.writeText( event.target.dataset.short );
                event.target.style.fill='blue';                
             
                if( td_parent !== null ){
                    span_copied = td_parent.querySelector( '.clipboard-span');
                    if( span_copied !== null ) span_copied.classList.remove( 'clipboard-hide')                    
                }

                let _event = event;
                setTimeout( ()=>{
                    _event.target.style.fill='currentColor';
                    _event.target.title = '';
                    if( span_copied !== null ) span_copied.classList.add( 'clipboard-hide');
                }, 1000 )
            },
            actionDeletePuzzle : function( $id, $name ){
                event.stopPropagation();
                let span_event = event;
                let puzzle_name = $name;
                bootbox.confirm({
                    message: `${ crswrd_new_lng.deleteCrosswordPerm }: ${ puzzle_name } ?`, 
                    centerVertical: true,                    
                    callback: function( result ){ 
                    
                        if( result ){
                            window.location.href = span_event.target.dataset.url;
                        }                     
                    }
                }); 
            },
            saveRules : function ( $event ){
                        
                this.saving = true;
                let _wponce_val = document.querySelector('#pc_secure_nonce_field');
                let form = new FormData();
                let _this = this;
                
               
                form.append( 'action', AJAX_CROSSWORD_ACTION );
                form.append( 'page_action', this.action );
                form.append( 'data', JSON.stringify( this.cross ) );
                form.append( 'nonce', _wponce_val.value || '' );       
    
                fetch( ajaxurl,{
                    method : 'POST',
                    body : form
                })
                .then( response => response.json() )
                .then( data => { 
                              
                    if( data.response == 'fine'){                                         
    
                        if( data.data ){                                           
                         //   this.cross =  data.data;                         
                        }
    
                        /*
                        bootbox.alert({
                            size : 'small',
                            title : crswrd_new_lng.info,
                            message :  crswrd_new_lng.saved
                        } );
                        */
                    }else{
    
                    }
    
                    this.saving = false;
    
                })
                .catch( error =>{
                    this.saving = false;
                    bootbox.alert( 'Error ' + error );
                })
            },
        },
        mounted (){
            this.cross = Object.assign( {}, crossword_rules );
          
        }
    }).mount('.section-content-grid')

});

