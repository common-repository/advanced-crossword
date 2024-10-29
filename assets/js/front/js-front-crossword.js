const{createApp:e}=Vue,PUZZLE_BLANK_SYMBOL="#";function tuskcode_saved_user_settings(){let e={skipFilledCells:!0,cellSize:18,fontSize:1,fontSizeClueNo:.8,colorDefaultBlank:"#565a7b",colorDefaultHighlighted:"#b9efbc",colorDefaultFocused:"#ebd700",colorCellText:"#2b0dbf",showTimer:!0,printIncludeClues:!0,toggleShowCluesList:!1,range:{cellSize:{default:25,range:10,min:15,max:35,extraMax:6},fontSize:{default:1.2,range:.6,min:.6,max:1.8},clueNoSize:{default:.9,range:.5,min:.4,max:1.4},cellTicks:2,fontTicks:.1}};return null!==localStorage.getItem("tuskcode_puzzle_store")&&(e=JSON.parse(localStorage.getItem("tuskcode_puzzle_store"))),e}function tuskcode_get_saved_puzzle(e){return null!==localStorage.getItem(e)?JSON.parse(localStorage.getItem(e)):null}if("undefined"!=typeof tuskcode_puzzle_data)for(const puzzle in tuskcode_puzzle_data){var t=Object.assign({},tuskcode_puzzle_data[puzzle]);e({data:()=>({puzzle_name:t.name,id:t.id,puzzle_store:"tuskcode_puzzle_store",puzzle_save_name:"tuskcode_puzzle_"+t.id,table_data:JSON.parse(JSON.stringify(t.table_data)),cols_no:t.cols_no,rows_no:t.rows_no,hor_clues:Object.assign({},t.hor_clues),ver_clues:Object.assign({},t.ver_clues),answer_data:[],blank_symbol:"#",dir:"hor",dir_h:"hor",dir_v:"ver",prev_dir:"ver",puzzle_selector:"#tuskcode_puzzle_"+t.id,skip_filled_cells:!1,puzzle_selector_obj:null,queue_selected:{},puzzle_clues_hor_obj:null,puzzle_clues_ver_obj:null,menu_show:!1,input_reg_expr:t.reg_expr,rememberSettings:null!==localStorage.getItem("tuskcode_puzzle_store"),userSettings:tuskcode_saved_user_settings(),boxShadow:{dir:"inset",shadow:"3px",width:"2px"},template:{active_clue_p:"active-clue-p",ckb_skip_cells_id:"ckb_skip_cells_"+t.id,active_cell_class:"active-cell",active_cell_color:"blue"},clue_info:tuskcode_default_settings.labels.general.clue_display,labels:Object.assign({},tuskcode_default_settings.labels),settings:{menu:Object.assign({},tuskcode_default_settings.menu),sizes:Object.assign({},tuskcode_default_settings.sizes)},row_obj:null,timer:!1,time:0,timeStr:"00:00",timeInterval:null,infoMessage:"",show_info:!1,show_answers:t.show_answers,reveal_date_time:t.reveal_date,puzzle_answers:t.answers_data,last_focus_input:null,fadeMessageTime:3e3,changing_dir:{32:"space",13:"enter"}}),watch:{userSettings:{handler(e,t){this.rememberSettings&&this.setSavedUserSettings(!0)},deep:!0,immediate:!0},menu_show:{handler(e,t){this.resizePuzzleUpdate(!1)}},rememberSettings:{handler(e,t){this.setSavedUserSettings(e)},immediate:!0},timer:{handler(e,t){e?this.timeInterval=setInterval(()=>{this.time+=1},1e3):clearInterval(this.timeInterval)},immediate:!0},time:{handler(e,t){let i=0,s=0;i=(i=parseInt(e/60))<10?"0"+i:i,s=(s=e%60)<10?"0"+s:s,this.timeStr=i+":"+s}}},template:`
                          
                <div ref='main_div' class='crossword-main-div' 
                    style='visibility: hidden'>  

                    <div class='crossword-grid'>

                        <p class='tuskcode-puzzle-name'> {{ puzzle_name }} </p> 

                        <div class='div-row menu-container div-adjed'>
                            <div class='div-menu' v-show='false'>
                                <div class='div-menu-wrapper' @click="toggleMenu" >                            

                                    <svg  v-show='!menu_show'
                                        xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#006400" class="bi bi-list" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                    </svg>

                                    <svg  v-show="menu_show"
                                        xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="salmon" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
            

                                    <span class='menu-label'>
                                        {{ labels.menu.menu }}
                                    </span>   
                                    
                                </div>
                            </div>

                            <div class='div-menu-block' v-show="menu_show" >
                            
                                <div class='controls'>

                                    <!-- Menu template -->
                                    ${t.menu_template}

                                </div>

                                <div class='menu-controls-close' @click="toggleMenu" >
                                    <svg v-show="menu_show"
                                        xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="salmon" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </div>
                            </div>



                            <div class='div-puzzle-top-section'>
                            
                                ${t.puzzle_top_template}

                            </div>

                        </div>                    

                        <div class='div-row puzzle-clue-info div-adjed puzzle-clue-info-top'>
                            <p> {{clue_info}} </p>
                            <div class='puzzle-info-message' 
                                ref='divMessageTop'                            
                            >
                                {{infoMessage}}
                            </div>
                        </div>

                        <div class='crossword-rows'>

                            <div v-for="(row, index_i) in table_data" 
                                class='div-row div-row-cells'  
                                style='display: inline-flex'                                
                                >

                                <div v-for="(col_val, index_j) in row" 
                                    class='td-row'
                                    :class="index_i + '-td-' + index_j"                            
                                    :data-index="index_i + '-' + index_j" 
                                    :data-indexj="index_j" 
                                    :data-indexi="index_i"                            
                                    :data-blank="( col_val == blank_symbol ) ? blank_symbol : ''"
                                    :style="{backgroundColor: userSettings.colorDefaultBlank,
                                            width: userSettings.cellSize + 'px', 
                                            height: userSettings.cellSize + 'px'}"
                                    >
                                    
                                    <span class='td-clue-no'
                                        :style="{fontSize: userSettings.fontSizeClueNo + 'rem',
                                                color: userSettings.colorDefaultBlank}"
                                        :class="[ (userSettings.cellSize < 25 ) ? 'clueNoMarginZero' : '',
                                                  (userSettings.cellSize <= 30 && userSettings.cellSize > 25 ) ?
                                                  'clueNoMarginTopOne' : ''
                                                ]"
                                    >
                                        {{ [ 0, blank_symbol ].includes( col_val ) ? '' : col_val}}
                                    </span>

                                    <input v-if="col_val !== blank_symbol"
                                        v-show='true'
                                        type='text' maxlength='1' 
                                        :id="'td_' +index_i + '_' + index_j" 
                                        v-model="answer_data[ index_i ][ index_j ]"
                                        @click="cellClick( $event )"
                                        @dblclick="cellDblClick( $event )"
                                        @keyup="cellKeyUp($event)" 
                                        @input="cellKeyDown( $event )"
                                        @focus="actionCell('focus', $event )"
                                        @blur="actionCell('blur', $event )" 
                                        :data-indexi="index_i"
                                        :data-indexj="index_j"
                                        :style="{width: userSettings.cellSize + 'px', 
                                            height: userSettings.cellSize + 'px',
                                            fontSize: userSettings.fontSize + 'rem',
                                            borderColor: userSettings.colorDefaultBlank,
                                            color: userSettings.colorCellText}"
                                    />
                                    <input v-else
                                        disabled='true'
                                        type='text'
                                        class='disabled-input'
                                        :style="{width: userSettings.cellSize + 'px', 
                                                height: userSettings.cellSize + 'px',
                                                borderColor: userSettings.colorDefaultBlank,
                                                backgroundColor: userSettings.colorDefaultBlank}"
                                    />
                            
                                </div>
                            </div>
                        </div>

                        <div class='div-row puzzle-clue-info div-adjed puzzle-clue-info-bottom'>
                            <p> {{clue_info}} </p>
                            <div class='puzzle-info-message' 
                                ref='divMessageDown'                            
                            >
                                {{infoMessage}}
                            </div>
                        </div>

                    
                        <div class='div-row div-adjed'>
                            <div class='div-puzzle-reveal-answers'>
   
                                ${t.puzzle_bottom_template}

                            </div> 

                        </div>

                    </div> 

                    <div class='tuskcode-crossword-clues'>
                                                    
                        ${t.puzzle_clues_list_template}

                    </div>
                </div> 

                <div class='tuskcode-modal-info' v-show="show_info" @click="show_info = !show_info" >
                    <div class='tuskcode-modal-content' @click="show_info = !show_info">
                        ${tuskcode_default_settings.info}
                    </div>
                </div>
                                
            `,computed:{settingsSizes(){return this.settings.sizes}},methods:{printInfoHeaderTemplate:function(){if("undefined"==typeof tuskcode_default_print_header)return"<h2>"+this.puzzle_name.toString()+"</h2>";{let e=tuskcode_default_print_header.replace("\n","");return(e=(e=(e=(e=(e=e.replace("%%print_company_logo%%",this.labels.menu.print_company_logo)).replace("%%display_company_logo%%",""===this.labels.menu.print_company_logo.trim()?"none":"block")).replace("%%print_company_name%%",this.labels.menu.print_company_name)).replace("%%display_company_name%%",""===this.labels.menu.print_company_name.trim()?"none":"block")).replace("%%puzzle_name%%",this.puzzle_name)).replace("%%display_puzzle_name%%",""===this.puzzle_name.trim()?"none":"block")}},showPrintSection:function(){return this.settings.menu.general.showPrintEmptyPuzzle||this.settings.menu.general.showPrintCurrentState},showPrintBlock:function(){return!(!this.settings.menu.general.showPrintEmptyPuzzle&&!this.settings.menu.general.showPrintCurrentState)},userSettingsCalc:function(){let e=window.innerWidth,t=this.settings.sizes,i=null;i=e>=t.desktop.low?t.desktop:e>t.tablet.high?t.laptop:e<=t.mobile.high?t.mobile:t.tablet,this.userSettings.cellSize=i.cellSize,this.userSettings.fontSize=i.fontSize,this.userSettings.fontSizeClueNo=i.fontSizeClueNo,this.userSettings.range.cellSize.default=i.cellSize,this.userSettings.range.fontSize.default=i.fontSize,this.userSettings.range.clueNoSize.default=i.fontSizeClueNo,this.userSettings.range.cellSize.min=this.userSettings.range.cellSize.default-this.userSettings.range.cellSize.range,this.userSettings.range.cellSize.max=this.userSettings.range.cellSize.default+this.userSettings.range.cellSize.range+this.userSettings.range.cellSize.extraMax,this.userSettings.range.fontSize.min=this.userSettings.range.fontSize.default-this.userSettings.range.fontSize.range,this.userSettings.range.fontSize.max=this.userSettings.range.fontSize.default+this.userSettings.range.fontSize.range,this.userSettings.range.clueNoSize.min=this.userSettings.range.clueNoSize.default-this.userSettings.range.clueNoSize.range,this.userSettings.range.clueNoSize.max=this.userSettings.range.clueNoSize.default+this.userSettings.range.clueNoSize.range},actionSavePuzzle:function(){let e={time:this.time,data:this.answer_data};localStorage.setItem(this.puzzle_save_name,JSON.stringify(e)),this.showFadeMessage(this.labels.message.puzzleSaved),this.menu_show=!1},showFadeMessage(e){let t=this.$refs.divMessageTop,i=this.$refs.divMessageDown;t&&(t.style.display="block",this.infoMessage=e,this.fadeElement(t,this.fadeMessageTime)),i&&(i.style.display="block",this.infoMessage=e,this.fadeElement(i,this.fadeMessageTime))},actionTimerVisibility:function(){this.timer=!1},actionToggleDirection:function(e){if(null===this.last_focus_input)return;let t=this.triggerEnter();this.last_focus_input.dispatchEvent(t),this.last_focus_input.focus()},actionShowInfo:function(){this.show_info=!this.show_info},actionClearPuzzle:function(){},actionRevealAnswers:function(e){},actionResetToDefault:function(){},actionReportEmail:function(){},actionPrintCurrentState:function(e){return e.preventDefault(),this.printPuzzleWindow(!0),!1},actionPrintEmptyPuzzle:function(e){return e.preventDefault(),this.printPuzzleWindow(!1),!1},printPuzzleWindow:function(e){},getPrintHeader:function(){return""},printPuzzle:function(e){return""},fadeElement(e,t){e.style.opacity=1,function i(){e.style.opacity-=1/(t/100),e.style.filter="alpha(opacity="+100*e.style.opacity+")",e.style.opacity>0?setTimeout(i,100):e.style.display="none"}()},resetToDefault:function(){this.userSettings.colorDefaultBlank=this.settings.menu.general.colorDefaultBlank,this.userSettings.colorDefaultHighlighted=this.settings.menu.general.colorDefaultHighlighted,this.userSettings.colorDefaultFocused=this.settings.menu.general.colorDefaultFocused,this.userSettings.colorCellText=this.settings.menu.general.colorCellText},getSavedUserSettings:function(){let e=!1,t=localStorage.getItem(this.puzzle_store);return null!==t&&(this.userSettings=JSON.parse(t),e=!0,this.rememberSettings=!0),e},setSavedUserSettings:function(e){if(e){let t=JSON.stringify(this.userSettings);localStorage.setItem(this.puzzle_store,t)}else localStorage.removeItem(this.puzzle_store)},cellClick:function(e){},toggleMenu:function(){this.menu_show=!this.menu_show},cellDblClick:function(e){let t=this.triggerEnter();e.target.dispatchEvent(t)},triggerEnter:function(){return new KeyboardEvent("keyup",{altKey:!1,bubbles:!0,cancelBubble:!1,cancelable:!0,charCode:0,code:"Enter",composed:!0,ctrlKey:!1,currentTarget:null,defaultPrevented:!0,detail:0,eventPhase:0,isComposing:!1,isTrusted:!0,key:"Enter",keyCode:13,location:0,metaKey:!1,repeat:!1,returnValue:!1,shiftKey:!1,type:"keyup",which:13})},changeCellSize:function(e){let t=25,i="up"===e?this.userSettings.range.cellTicks:-1*this.userSettings.range.cellTicks;(t=this.userSettings.cellSize+i)>=this.userSettings.range.cellSize.min&&t<=this.userSettings.range.cellSize.max&&(this.userSettings.cellSize=t)},changeFontSize:function(e){let t=1.2,i="up"===e?this.userSettings.range.fontTicks:-1*this.userSettings.range.fontTicks;(t=this.userSettings.fontSize+i)>=this.userSettings.range.fontSize.min&&t<=this.userSettings.range.fontSize.max&&(this.userSettings.fontSize=t)},changeClueNoSize:function(e){let t=.9,i="up"===e?this.userSettings.range.fontTicks:-1*this.userSettings.range.fontTicks;(t=this.userSettings.fontSizeClueNo+i)>=this.userSettings.range.clueNoSize.min&&t<=this.userSettings.range.clueNoSize.max&&(this.userSettings.fontSizeClueNo=t)},cellKeyUp:function(e){let t={37:"left",39:"right",40:"down",38:"up"},i=parseInt(e.target.dataset.indexi),s=parseInt(e.target.dataset.indexj),l=e.keyCode.toString();if(8==l&&(l="37",e.target.value=""),l in this.changing_dir){this.dir=this.dir===this.dir_h?this.dir_v:this.dir_h,this.addActiveClueClass(e),32==l&&(e.target.value=""==e.target.value.trim()?"":e.target.value,this.answer_data[i][s]=e.target.value,e.target.focus());return}if(l in t)this.findInputByDirection(i,s,t[l]);else{this.userSettings.showTimer&&!this.timer&&(this.timer=!0);let n=e.target.value.trim();e.target.value=n,this.answer_data[i][s]=n,""!==n&&this.findNextEmptyInput(e.target)}},cellKeyDown:function(e){let t=this.validateRegex(this.input_reg_expr);if(!t)return;let i=parseInt(e.target.dataset.indexi),s=parseInt(e.target.dataset.indexj),l=e.target.value,n=l.length>0?l.charCodeAt(0):0;t.test(l)?this.answer_data[i][s]=l:(n in this.changing_dir||""!==this.labels.message.invalidChar&&this.showFadeMessage(this.labels.message.invalidChar),this.answer_data[i][s]="")},validateRegex:function(e){var t=e.split("/"),i=e,s="";t.length>1&&(i=t[1],s=t[2]);try{return RegExp(i,s)}catch(l){return!1}},actionCell:function(e,t){"focus"===e?(t.target.style.boxShadow=this.boxShadow.dir+" 0 0 "+this.boxShadow.shadow+" "+this.boxShadow.width+" "+this.userSettings.colorDefaultFocused,t.target.classList.add(this.template.active_cell_class),this.last_focus_input=t.target,this.addActiveClueClass(t)):(t.target.style.boxShadow="",t.target.classList.remove(this.template.active_cell_class))},clueClick:function(e,t,i){this.removeClueActiveClass(e);let s="clue_"+e+"_"+t;this.addClueActiveClass(e,s);let l=null;if(null==(l=e==this.dir_h?this.hor_clues[t.toString()]:this.ver_clues[t.toString()]))return;this.dir=e;let n="#td_"+l.i+"_"+l.j,r=this.puzzle_selector_obj.querySelector(n);null!==r&&(r.scrollIntoView({behavior:"smooth",block:"end",inline:"nearest"}),r.focus({preventScroll:!0}),r.setSelectionRange(0,1))},addClueActiveClass:function(e,t){if(e==this.dir_h)for(let i of this.puzzle_clues_hor_obj)i.id==t?i.classList.add(this.template.active_clue_p):i.classList.remove(this.template.active_clue_p);else for(let s of this.puzzle_clues_ver_obj)s.id==t?s.classList.add(this.template.active_clue_p):s.classList.remove(this.template.active_clue_p)},removeClueActiveClass:function(e){if(e==this.dir_h)for(let t of this.puzzle_clues_hor_obj)t.classList.remove(this.template.active_clue_p);else for(let i of this.puzzle_clues_ver_obj)i.classList.remove(this.template.active_clue_p)},addActiveClueClass:function(e){let t="",i="",s="";if(this.dir==this.dir_h?(i=e.target.dataset.dirh,void 0===(t=e.target.dataset.clueh)&&(t=e.target.dataset.cluev,i=e.target.dataset.dirv)):(i=e.target.dataset.dirv,void 0===(t=e.target.dataset.cluev)&&(t=e.target.dataset.clueh,i=e.target.dataset.dirh)),this.dir=i,s=i+"_clue_"+t,void 0!==t&&t.toString() in this.queue_selected&&this.dir==this.prev_dir);else{for(let l in this.queue_selected)(this.queue_selected[l]||[]).forEach((e,t)=>{e.style.background=""});this.queue_selected={},this.queue_selected[t.toString()]=[];this.puzzle_selector_obj.querySelectorAll("."+s).forEach(e=>{e.style.background=this.userSettings.colorDefaultHighlighted,this.queue_selected[t.toString()].push(e)}),this.dir==this.dir_h?t in this.hor_clues&&(this.clue_info=t+". "+this.hor_clues[t].q+" ("+this.hor_clues[t].len+")"):t in this.ver_clues&&(this.clue_info=t+". "+this.ver_clues[t].q+" ("+this.ver_clues[t].len+")"),this.prev_dir=i}},findInputByDirection:function(e,t,i){if("up"==i?e-=1:"down"==i?e+=1:"left"==i?t-=1:"right"==i&&(t+=1),e==this.rows_no&&(e=0),t==this.cols_no&&(t=0),-1==e&&(e=this.rows_no),-1==t&&(t=this.cols_no),!(e>=-1)||!(t>=-1)||!(e<=this.rows_no)||!(t<=this.cols_no))return null;{let s=document.querySelector(this.puzzle_selector),l="";l=`#td_${e}_${t}`;let n=s.querySelector(l);if(null===n)return this.findInputByDirection(e,t,i);n.focus(),n.setSelectionRange(0,1)}},findNextEmptyInput:function(e){let t="",i="",s="",l="",n=null,r="",a="",o="",u=null;if(i=e.dataset.indexi,s=e.dataset.indexj,this.dir==this.dir_h?(t=e.dataset.dirh,l=e.dataset.clueh,n=this.hor_clues[l]||null,r=parseInt(i),a=parseInt(s)+1):(t=e.dataset.dirv,l=e.dataset.cluev,n=this.ver_clues[l]||null,r=parseInt(i)+1,a=parseInt(s)),o="#td_"+r+"_"+a,null!==(u=this.puzzle_selector_obj.querySelector(o))){if(this.userSettings.skipFilledCells&&""!==u.value.trim())return this.findNextEmptyInput(u);u.focus(),u.setSelectionRange(0,1)}else{let c=null;if(t==this.dir_h){let d=Object.keys(this.hor_clues),h=d.indexOf(l);if(-1!==h){let g=d[h+1];void 0!==g&&(c=this.hor_clues[g])}}else{let f=Object.keys(this.ver_clues),p=f.indexOf(l);if(-1!==p){let z=f[p+1];void 0!==z&&(c=this.ver_clues[z])}}if(null!=c&&(o="#td_"+c.i+"_"+c.j,null!==(u=this.puzzle_selector_obj.querySelector(o)))){if(this.userSettings.skipFilledCells&&""!==u.value.trim())return this.findNextEmptyInput(u);u.focus(),u.setSelectionRange(0,1)}}},clearPuzzle:function(){this.answer_data=[];for(let e=0;e<this.rows_no;e++)this.answer_data[e]=Array(this.cols_no).fill("")},fillCluesInTheGrid:function(){let e=null,t=0,i=0,s=0,l="",n=null,r="",a=document.querySelector(this.puzzle_selector);for(let o in this.hor_clues)for(t=(e=this.hor_clues[o]).i,i=e.j,s=e.len+i,l="hor_clue_"+o;i<s;)r="#td_"+t+"_"+i,null!==(n=a.querySelector(r))&&(n.classList.add(l),n.dataset.clueh=o,n.dataset.dirh=this.dir_h),i++;for(let u in this.ver_clues)for(t=(e=this.ver_clues[u]).i,i=e.j,s=e.len+t,l="ver_clue_"+u;t<s;)r="#td_"+t+"_"+i,null!==(n=a.querySelector(r))&&(n.classList.add(l),n.dataset.cluev=u,n.dataset.dirv=this.dir_v),t++},resizePuzzleUpdate:function(e){this.getSavedUserSettings(),e&&!this.rememberSettings&&this.userSettingsCalc(),setTimeout(()=>{this.row_obj=this.puzzle_selector_obj.querySelector(".div-row-cells");let e=this.puzzle_selector_obj.querySelectorAll(".div-adjed"),t=this.puzzle_selector_obj.querySelector(".div-menu-block");if(this.puzzle_selector_obj.querySelector(".crossword-grid"),this.$refs.divMessageTop.style.width=this.row_obj.offsetWidth-20+"px",this.$refs.divMessageDown.style.width=this.row_obj.offsetWidth-20+"px",e.forEach((e,t)=>{e.style.width=this.row_obj.offsetWidth+"px"}),null!==t){let i=this.row_obj.offsetWidth>600?500:this.row_obj.offsetWidth;i=i<220?220:i,t.style.minWidth=i+"px"}},200)},windowResizeEvent:function(e){this.resizePuzzleUpdate(!0)}},beforeMount(){this.settings.menu.general.showRememberSettings||(this.rememberSettings=!1),this.clearPuzzle();let e=tuskcode_get_saved_puzzle(this.puzzle_save_name);if(null!==e){this.time=e.time||0,e=e.data;for(let t=0;t<this.answer_data.length;t++)for(let i=0;i<this.answer_data[t].length;i++)void 0!==e[t]&&void 0!==e[t][i]&&(this.answer_data[t][i]=e[t][i])}},created(){window.addEventListener("resize",this.windowResizeEvent)},mounted(){if(this.getSavedUserSettings(),this.fillCluesInTheGrid(),this.puzzle_selector_obj=document.querySelector(this.puzzle_selector),null!==this.puzzle_selector_obj){this.puzzle_clues_hor_obj=this.puzzle_selector_obj.querySelectorAll(".p-clue-hor"),this.puzzle_clues_ver_obj=this.puzzle_selector_obj.querySelectorAll(".p-clue-ver");let e=this.puzzle_selector_obj.querySelector(".across-clues-block"),t=this.puzzle_selector_obj.querySelector(".down-clues-block"),i=this.puzzle_selector_obj.offsetHeight-255;null!==e&&e.setAttribute("style","height: "+i+"px !important"),null!==t&&t.setAttribute("style","height: "+i+"px !important")}this.$refs.main_div.classList.add("show-loaded"),this.resizePuzzleUpdate(!0)}}).mount("#tuskcode_puzzle_"+t.id)}