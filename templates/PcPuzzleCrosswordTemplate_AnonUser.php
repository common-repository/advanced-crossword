<?php
/**
 * Clues Template
 */

/*
    {bgimage}   - this will put the background image in place if existant, if empty no bg image will be displayed
    {text}      - this will change the text defined
    {onclicklogin} - change the click event with url 

*/

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No Access here' );
}
?>

<style>
    .au-container-div-template{
        width: 100%; 
        min-height: 400px !important; 
        background-size: cover; 
        background-repeat: no-repeat; 
        background-color: yellow;
        {bgimage}
    }

    .au-text-div-template{
        position: relative; 
        top: 100px; 
        width: fit-content; 
        padding: 20px; 
        border-radius: 10px; 
        margin: auto; 
        min-width: 200px;
        background-color: rgba(255, 255, 255, .75);  
        backdrop-filter: blur(8px);
        cursor: pointer;          
    }


</style>

<div class='au-container-div-template' >

   <div class='au-text-div-template' {onclicklogin} >
        {text}    
   </div>
    
</div>