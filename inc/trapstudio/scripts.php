<?php 

function trp_site_scripts_and_css() {
    $dati_tema = wp_get_theme();

    //VARIABILI DA PASSARE A JS
    /*
    $var_array = array();
    $var_array['homeUrl'] = HOME_URL;   
    $var_array['themeUrl'] = THEME_URL;

    //cf7
    if (function_exists('wpcf7')):
        $var_array['cf7'] = 1;
    endif;
    
    //woocommerce
    if( class_exists('woocommerce') ):
        $var_array['woocommerce'] = 1;
        //wp_dequeue_style( 'wc-block-style' ); // REMOVE WOOCOMMERCE BLOCK CSS
    endif;
    */
    
    //FILE CSS
    wp_enqueue_style( 'astra-child-theme-css', THEME_URL . '/style.css', array('astra-theme-css'), $dati_tema->Version, 'all' );
    
    //FILE SCRIPTS
    /*
    wp_register_script( 'siteScripts', get_stylesheet_directory_uri() . "/assets/js/scripts.js", array('jquery'), '1.0', true );

    //PASSO VARIABILI PHP A JAVASCRIPT        
    wp_localize_script('siteScripts', 'phpVars', $var_array );
    
    //ACCODO CSS + JS
    wp_enqueue_style('app');
    wp_enqueue_style('style');

    //wp_enqueue_script('siteScripts-blocking');
    wp_enqueue_script('siteScripts');
    */
}
add_action( 'wp_enqueue_scripts', 'trp_site_scripts_and_css' );