<?php 
function trp_site_scripts_and_css() {
    $dati_tema = wp_get_theme();

    //VARIABILI DA PASSARE A JS
    $var_array = array();
    $var_array['homeUrl'] = HOME_URL;   
    $var_array['themeUrl'] = THEME_URL;

    //FILE CSS
    wp_register_style( 'astra-child-theme', THEME_URL . '/style.css', array('astra-theme-css'), $dati_tema->Version );
    wp_register_style( 'general', THEME_URL . "/assets/css/general.css", array('astra-theme-css'), $dati_tema->Version);

    //FANCYBOX PER GALLERY
    /*
    if(has_block('core/gallery')):
        $var_array['fancybox'] = 1;
        wp_enqueue_style( 'fancybox', "https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css", array(), $dati_tema->Version);
        wp_enqueue_script( 'fancybox', "https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js", array(), $dati_tema->Version, array('strategy'  => 'defer', 'in_footer' => true));
    endif;
    */

    //FILE SCRIPTS
    wp_register_script( 'siteScripts', THEME_URL . "/assets/js/scripts.js", array('jquery'), $dati_tema->Version, array('strategy'  => 'defer', 'in_footer' => true) );

    //PASSO VARIABILI PHP A JAVASCRIPT        
    wp_localize_script('siteScripts', 'phpVars', $var_array );

    //ACCODO CSS + JS
    wp_enqueue_style('general');
    wp_enqueue_style('astra-child-theme');
    
    wp_enqueue_script('siteScripts');

}
add_action( 'wp_enqueue_scripts', 'trp_site_scripts_and_css' );