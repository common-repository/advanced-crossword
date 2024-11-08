<?php
/**
 * Clues Template
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No Access here' );
}
?>

<div class='div-across-clue' >
    <span 
        class='block-raised span-toggle-clues'
        @click='userSettings.toggleShowCluesList = ! userSettings.toggleShowCluesList'
    >

        <svg xmlns="http://www.w3.org/2000/svg" 
            v-show='! userSettings.toggleShowCluesList'
            width="18" height="18" fill="currentColor" class="bi bi-arrow-down-square-fill" viewBox="0 0 16 16">
            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5a.5.5 0 0 1 1 0z"/>
        </svg>

        <svg xmlns="http://www.w3.org/2000/svg" 
            v-show='userSettings.toggleShowCluesList'
            width="18" height="18" fill="currentColor" class="bi bi-arrow-up-square-fill" viewBox="0 0 16 16">
            <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0z"/>
        </svg>
        
    </span>
    <h3>{{labels.general.across_clues}}</h3>

    <div class='across-clues-wrapper'
        v-show='userSettings.toggleShowCluesList'
    >
        <div class='across-clues-block' 
            style='display: none'                                   
        >
            <p  v-for="item in hor_clues" 
                @click="clueClick( 'hor', item.clue, event )"
                data-dir='hor'
                :id="'clue_hor_' + item.clue"
                class="p-clue-hor"
            >                                                          
                {{ item.clue + '. ' +item.q }}                              
            </p>$template
        </div>
    </div>

</div>

<div class='div-down-clue'>

    <span 
        class='block-raised span-toggle-clues'
        @click='userSettings.toggleShowCluesList = ! userSettings.toggleShowCluesList'
    >

    <svg xmlns="http://www.w3.org/2000/svg" 
        v-show='! userSettings.toggleShowCluesList'
        width="18" height="18" fill="currentColor" class="bi bi-arrow-down-square-fill" viewBox="0 0 16 16">
        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5a.5.5 0 0 1 1 0z"/>
    </svg>

    <svg xmlns="http://www.w3.org/2000/svg" 
        v-show=' userSettings.toggleShowCluesList'
        width="18" height="18" fill="currentColor" class="bi bi-arrow-up-square-fill" viewBox="0 0 16 16">
        <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0z"/>
    </svg>
        
    </span>
    <h3>{{labels.general.down_clues}}</h3>

    <div class='down-clues-wrapper'
        v-show='userSettings.toggleShowCluesList'
    >
        <div class='down-clues-block' 
            style='display: none' 
            
        >
            <p  v-for="item in ver_clues"
                @click="clueClick( 'ver', item.clue, event )"
                data-dir='ver'
                class="p-clue-ver"
                :data-clue="item.clue"
                :id="'clue_ver_' + item.clue">
                {{ item.clue + '. ' + item.q }}
            </p>
        </div>
    </div>

</div>