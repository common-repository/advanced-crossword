<?php
    if( ! defined('ABSPATH') ) die();
?>

<div class="card">
    <div class="card-body">
        <h5> <?php esc_html_e('Version 1.0.2', 'advanced-crossword'); ?> </h5>

        <p> <?php esc_html_e('Added login rule for anonymous users and logged in users', 'advanced-crossword'); ?> </p>
        <p> <?php esc_html_e('You can now select what crosswords can be played by logged in users or anonymous users', 'advanced-crossword'); ?> </p>
        <p> <?php esc_html_e('Added access to each page of the crossword plugin. Delegate work for other members of your website.', 'advanced-crossword'); ?> </p>

        <div class="card" style="width: 110%">
            <?php esc_html_e('Plugin Pages Capabilities', 'advanced-crossword'); ?>
            <ul class="list-group list-group-flush">

                <li class="list-group-item">
                    <b> crossword_cru </b> -
                    <?php esc_html_e('Create / Read / Update Crossword', 'advanced-crossword'); ?>
                </li>
                <li class="list-group-item">
                    <b> crossword_d </b> -
                    <?php esc_html_e('Delete Crossword', 'advanced-crossword'); ?>
                </li>
                <li class="list-group-item">
                    <b> crossword_settings_crud </b> -  
                    <?php esc_html_e('Full Access - Settings', 'advanced-crossword'); ?>
                </li>

                <li class="list-group-item">
                    <b> crossword_rules_crud </b> -  
                    <?php esc_html_e('Full Access - User Access', 'advanced-crossword'); ?>
                </li>

                <li class="list-group-item">
                    <b> crossword_license_crud </b> -  
                    <?php esc_html_e('Full Access - License', 'advanced-crossword'); ?>
                </li>

                <li class="list-group-item">
                    <b> crossword_releases_crud </b> -  
                    <?php esc_html_e('Full Access - Releases', 'advanced-crossword'); ?>
                </li>
            </ul>
        </div>
        
        <p> 
            <?php esc_html_e('Video available here', 'advanced-crossword'); ?> 
        </p>
        <p>
            <?php esc_html_e('If no video available here, check the website ', 'advanced-crossword'); ?> 
            <a href="https://tuskcode.com/advanced-crossword" target='_blank'> <?php esc_html_e('Releases', 'advanced-crossword'); ?> </a>
        </p>

    </div>
</div>