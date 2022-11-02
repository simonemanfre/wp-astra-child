<?php 

function site_scripts_and_css() {
    $dati_tema = wp_get_theme();
    $var_array = array();

    //FILE CSS
    wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), $dati_tema->Version, 'all' );
    
    //FILE SCRIPTS
    /*
    wp_register_script( 'siteScripts', get_stylesheet_directory_uri() . "/assets/js/scripts.js", array('jquery'), '1.0', true );

    //VARIABILI DA PASSARE A JS
    $var_array['home'] = get_bloginfo('url');
    
    if( class_exists('woocommerce') ):
        $var_array['woocommerce'] = true;
    endif;

    wp_localize_script('siteScripts', 'php_vars', $var_array );
    
    wp_enqueue_script('siteScripts');
    */
}
add_action( 'wp_enqueue_scripts', 'site_scripts_and_css' );