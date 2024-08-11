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


// SPECULATION RULES FOR PRERENDER
function trp_speculation_rules_script() {

	// PRERENDER GLOBALE ALL'HOVER
	echo '
	<script type="speculationrules">
	{
		"prerender": [{
			"where": {
				"and": [
					{ "href_matches": "/*" },
					{ "not": {"href_matches": "/wp-admin"}},
					{ "not": {"selector_matches": ".no-prerender"}},
					{ "not": {"selector_matches": "[rel~=nofollow]"}}
				]    
			},
			"eagerness": "moderate"
		}]
	}
	</script>
	';

	// PRERENDER WOOCOMMERCE
	if( class_exists('woocommerce') ) {
		
		if(is_product()) {
			// Prerender del carrello se sono in una pagina prodotto
			$next_url = wc_get_cart_url();

			echo '
			<script type="speculationrules">
			{
				"prerender": [
					{
					"urls": ["'.$next_url.'"]
					}
				]
				}
			</script>
			';
		} 

		if(is_cart()) {
			// Prerender del checkout se sono nel carrello
			$next_url = wc_get_checkout_url();

			echo '
			<script type="speculationrules">
			{
				"prerender": [
					{
					"urls": ["'.$next_url.'"]
					}
				]
				}
			</script>
			';
		} 

		if(is_checkout()) {
			// Prerender del checkout se sono nel carrello
			$next_url = wc_get_cart_url();
			
			echo '
			<script type="speculationrules">
			{
				"prerender": [
					{
					"urls": ["'.$next_url.'"]
					}
				]
				}
			</script>
			';
		}
	}
}
add_action( 'wp_head', 'trp_speculation_rules_script', 1 );