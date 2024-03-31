<?php
// REMOVE JQUERY MIGRATE
if ( get_field( 'performance_jquery_migrate', 'option' ) ) :
	function trp_dequeue_jquery_migrate( $scripts ) {
		if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
			$scripts->registered['jquery']->deps = array_diff(
				$scripts->registered['jquery']->deps,
				array( 'jquery-migrate' )
			);
		}
	}
	add_action( 'wp_default_scripts', 'trp_dequeue_jquery_migrate' );
endif;


// MOVE JQUERY TO FOOTER
if ( get_field( 'performance_jquery_footer', 'option' ) ) :

	add_action( 'wp_default_scripts', 'trp_move_jquery_to_footer' );
	function trp_move_jquery_to_footer( $wp_scripts ) {
		if ( ! is_admin() ) {
			$wp_scripts->add_data( 'jquery', 'group', 1 );
			$wp_scripts->add_data( 'jquery-core', 'group', 1 );
		}
	}
endif;
