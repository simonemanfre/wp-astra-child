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

require_once(THEME_DIR . '/inc/trapstudio/api.php');
require_once(THEME_DIR . '/inc/trapstudio/htaccess.php');
require_once(THEME_DIR . '/inc/trapstudio/performance.php');
require_once(THEME_DIR . '/inc/trapstudio/security.php');
require_once(THEME_DIR . '/inc/trapstudio/scripts.php');
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

//WPML
if(function_exists('wpml_loaded')):
    require_once(THEME_DIR . '/inc/trapstudio/wpml.php');
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
	return 50;
}


//ADD SCRIPT TO HEAD
/*
add_action( 'wp_head', 'trp_add_header_script', 1 );
function trp_add_header_script() {

}
*/

//ADD SCRIPT TO FOOTER
/*
add_action( 'wp_footer', 'trp_add_footer_script', 1 );
function trp_add_footer_script() {

    // Truendo
    echo '
<script defer id="truendoPrivacyPanel" type="text/javascript" data-src="https://cdn.priv.center/pc/app.pid.js" data-siteid="e489c91f-8391-4e42-9151-a2c2887818cd"></script>';

    // Analytics
    echo "
<!-- Google tag (gtag.js) -->
<script async truendo='true' data-trucookiecontrol='statistics' type='text/plain' src='https://www.googletagmanager.com/gtag/js?id=G-XXXXX'></script>
<script truendo='true' data-trucookiecontrol='statistics' type='text/plain'>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-XXXXX');
</script>
";

}
*/


//MOVE YOAST SETTINGS PANEL IN EDITOR TO BOTTOM
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');
