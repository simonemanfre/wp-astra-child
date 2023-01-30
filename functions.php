<?php

/**

 * Astra Child Theme functions and definitions

 *

 * @link https://developer.wordpress.org/themes/basics/theme-functions/

 *

 * @package Astra Child

 * @since 1.0.0

 */

/**
 * Define Constants
 */

define( 'THEME_URL', get_stylesheet_directory_uri() . '/' );
define( 'THEME_DIR', dirname(__FILE__).'/' );


//LIBRARY
require_once(THEME_DIR . 'inc/trapstudio/cpt.php');
require_once(THEME_DIR . 'inc/trapstudio/scripts.php');
require_once(THEME_DIR . 'inc/trapstudio/api.php');
require_once(THEME_DIR . 'inc/trapstudio/security.php');
require_once(THEME_DIR . 'inc/trapstudio/svg.php');


//ACF
if( function_exists('acf_add_options_page') ):
    require_once(THEME_DIR . 'inc/trapstudio/acf.php');
endif;


//DISABLE COMMENTS (lascio attive le recensioni su woocommerce)
if( !class_exists('woocommerce') ):
    require_once(THEME_DIR . 'inc/trapstudio/comments.php');
endif;


//REMOVE ADMIN BAR FOR USER
if(!current_user_can('edit_posts')){
    add_filter('show_admin_bar', '__return_false');
}


//THUMBNAILS
add_theme_support('post-thumbnails' );
//add_image_size('hero', 1600, 1600, false);


//REMOVE MENU PAGES FOR NON ADMIN
function remove_posts_menu() {
    $current_user = wp_get_current_user();

    if(!in_array('administrator', $current_user->roles )):
        remove_menu_page('edit.php');
        remove_menu_page('tools.php');
        remove_menu_page('wpcf7');
        remove_menu_page('wpseo_workouts');
    endif;
}
add_action('admin_menu', 'remove_posts_menu');
