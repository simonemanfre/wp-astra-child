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

define('HOME_URL', get_home_url());
define('THEME_URL', get_stylesheet_directory_uri());
define('THEME_DIR', dirname(__FILE__));


//LIBRARY

//enable custom post type
//require_once(THEME_DIR . '/inc/trapstudio/cpt.php');

require_once(THEME_DIR . '/inc/trapstudio/scripts.php');
require_once(THEME_DIR . '/inc/trapstudio/api.php');
require_once(THEME_DIR . '/inc/trapstudio/security.php');
require_once(THEME_DIR . '/inc/trapstudio/backend.php');

//ACF
if( function_exists('acf_add_options_page') ):
    require_once(THEME_DIR . '/inc/trapstudio/acf.php');
endif;

//CF7
if(function_exists('wpcf7')):
    require_once(THEME_DIR . '/inc/trapstudio/cf7.php');
endif;

//DISABLE COMMENTS (lascio attive le recensioni su woocommerce)
if( !class_exists('woocommerce') ):
    require_once(THEME_DIR . '/inc/trapstudio/comments.php');
endif;


//THUMBNAILS
add_theme_support('post-thumbnails' );
//add_image_size('hero', 1600, 1600, false);

//remove default unused thumbnails
remove_image_size('medium_large');
remove_image_size('1536x1536');
remove_image_size('2048x2048');

//set default unused thumbnails to 0
update_option( 'medium_large_size_w', 0 );
update_option( 'medium_large_size_h', 0 );


//LIMITO REVISIONI POSTS
add_filter( 'wp_revisions_to_keep', 'trp_limit_post_revisions', 10, 2 );
function trp_limit_post_revisions( $num, $post ) {
    return 20;
}


//MOVE JQUERY TO FOOTER
add_action( 'wp_default_scripts','trp_move_jquery_to_footer' );
function trp_move_jquery_to_footer( $wp_scripts ){
  if( !is_admin() ){
    $wp_scripts->add_data( 'jquery', 'group', 1 );
    $wp_scripts->add_data( 'jquery-core', 'group', 1 );
    $wp_scripts->add_data( 'jquery-migrate', 'group', 1 );
  }
}


//MOVE YOAST SETTINGS PANEL IN EDITOR TO BOTTOM
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');
