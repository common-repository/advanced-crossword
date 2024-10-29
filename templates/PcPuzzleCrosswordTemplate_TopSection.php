<?php
/**
 * Top Section Template
 */

// Do not allow directly accessing this file.
    if ( ! defined( 'ABSPATH' ) ) {
        exit( 'No Access here' );
    }
?>

<span class='block-raised 
            span-direction-control'
            @click='actionToggleDirection'
        >
    <span class='horizontal'>

        <svg fill="#000000" height="20px" width="20px" version="1.1" 
            id="dir_horizontal"
            :class='[ (last_focus_input !== null && dir=="hor") ? "fillSVGRed" : ""]'
            xmlns="http://www.w3.org/2000/svg" 
            xmlns:xlink="http://www.w3.org/1999/xlink" 
            viewBox="0 0 511.947 511.947" xml:space="preserve">
            <g>
                <g>
                    <path d="M508.933,248.353L402.267,141.687c-4.267-4.053-10.987-3.947-15.04,0.213c-3.947,4.16-3.947,10.667,0,14.827
                        l88.427,88.427H36.4l88.427-88.427c4.053-4.267,3.947-10.987-0.213-15.04c-4.16-3.947-10.667-3.947-14.827,0L3.12,248.353
                        c-4.16,4.16-4.16,10.88,0,15.04L109.787,370.06c4.267,4.053,10.987,3.947,15.04-0.213c3.947-4.16,3.947-10.667,0-14.827
                        L36.4,266.593h439.147L387.12,355.02c-4.267,4.053-4.373,10.88-0.213,15.04c4.053,4.267,10.88,4.373,15.04,0.213
                        c0.107-0.107,0.213-0.213,0.213-0.213l106.667-106.667C513.093,259.34,513.093,252.513,508.933,248.353z"/>
                </g>
            </g>
        </svg>

    </span>

    <span class='vertical'>                                     

    <svg fill="#000000" height="20px" width="20px" version="1.1"
        id="dir_vertical"
        :class='[ (last_focus_input !== null && dir=="ver") ? "fillSVGRed" : ""]' xmlns="http://www.w3.org/2000/svg" 
        xmlns:xlink="http://www.w3.org/1999/xlink" 
        viewBox="0 0 511.947 511.947" xml:space="preserve">
            <g>
                <g>
                    <path d="M370,387.12c-4.267-3.947-10.773-3.947-14.933,0l-88.427,88.533V36.4l88.427,88.427c4.267,4.053,10.987,3.947,15.04-0.213
                        c3.947-4.16,3.947-10.667,0-14.827L263.44,3.12c-4.16-4.16-10.88-4.16-15.04,0L141.733,109.787
                        c-4.053,4.267-3.947,10.987,0.213,15.04c4.16,3.947,10.667,3.947,14.827,0L245.307,36.4v439.147L156.88,387.12
                        c-4.267-4.053-10.987-3.947-15.04,0.213c-3.947,4.16-3.947,10.667,0,14.827l106.667,106.667c4.16,4.16,10.88,4.16,15.04,0
                        L370.213,402.16C374.267,397.893,374.16,391.173,370,387.12z"/>
                </g>
            </g>
        </svg>

    </span>
</span>

<span class='block-raised span-puzzle-info'
    v-show='settings.menu.general.showInfo'
    @click='actionShowInfo'
>
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" 
        viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
    </svg>
</span>