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
