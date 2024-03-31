<?php 

function trp_site_scripts_and_css() {
    $dati_tema = wp_get_theme();

    //FILE CSS
    wp_enqueue_style( 'astra-child-theme', THEME_URL . '/style.css', array('astra-theme-css'), $dati_tema->Version );
    wp_enqueue_style( 'general', THEME_URL . "/assets/css/general.css", array('astra-theme-css'), $dati_tema->Version);
    
    //FILE SCRIPTS
    wp_enqueue_script( 'siteScripts', THEME_URL . "/assets/js/scripts.js", array('jquery'), $dati_tema->Version, true );
}
add_action( 'wp_enqueue_scripts', 'trp_site_scripts_and_css' );