<?php
//DISABILITO FUNZIONALITÀ AVANZATE EDITOR AD ALTRI UTENTI
function trp_disable_editor_function( $editor_settings ) { 
	$editor_settings['canLockBlocks'] = trp_is_super_admin();
	$editor_settings['codeEditingEnabled'] = trp_is_super_admin();
	$editor_settings['fontLibraryEnabled'] = trp_is_super_admin();

	return $editor_settings; 
}
add_filter( "block_editor_settings_all", "trp_disable_editor_function" );


// GUTENBERG CATEGORIES REGISTRATION
/*
function trp_block_categories( $categories, $block_editor_context ) {
    return array_merge(
        array(
            array(
                'slug' => 'custom',
                'title' => get_option('blogname'),
                'icon'  => 'admin-customizer',
            ),
            array(
                'slug' => 'wp_default',
                'title' => 'Default',
                'icon'  => 'wordpress',
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories_all', 'trp_block_categories', 10, 2 );
*/


//GUTENBERG BLOCKS REGISTRATION
/*
function trp_gutenberg_custom_blocks() {
    $custom_blocks = array(
        
    );

    return $custom_blocks;
}


function trp_register_acf_blocks() {
    $custom_blocks = trp_gutenberg_custom_blocks();

    if(!empty($custom_blocks)) {
        //per ogni elemento dell'array custom registro il blocco Gutenberg
        foreach($custom_blocks as $block):

            register_block_type( THEME_DIR . "/partials/blocks/$block" );

        endforeach;
    }
}
add_action( 'init', 'trp_register_acf_blocks' );
*/


//ABILITO SOLO ALCUNI BLOCCHI GUTEBERG
/*
function trp_allowed_block_types($allowed_blocks, $editor_context) {
    $custom_blocks = trp_gutenberg_custom_blocks();

    //blocchi Gutenberg disponibili in base al post type
    if($editor_context->post->post_type == 'page'):

        //blocchi default abilitati
        $allowed_blocks = array();

        //aggiungo ogni blocco custom all'array di blocchi abilitati
        foreach ($custom_blocks as $block):

            $allowed_blocks[] = 'acf/' . $block;

        endforeach;

    else:

        //blocchi default abilitati
        $allowed_blocks = array(
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/quote',
            'core/image',
            'core/gallery',
            'core/freeform',
            'core/spacer',
            'core/html',
            'contact-form-7/contact-form-selector',
        );

        //aggiungo ogni blocco custom all'array di blocchi abilitati
        foreach ($custom_blocks as $block):

            $allowed_blocks[] = 'acf/' . $block;

        endforeach;

    endif;

    return $allowed_blocks;
}
add_filter( 'allowed_block_types_all', 'trp_allowed_block_types', 10, 2 );
*/


//REGISTRO NEW BLOCK BINDINS SOURCE
function trp_register_block_bindings_options_source() {

	register_block_bindings_source(
		'trp/options',
		array(
			'label'              => _x( 'Campi Opzioni', 'block bindings source' ),
			'get_value_callback' => 'trp_block_bindings_options_callback',
		)
	);

    register_block_bindings_source(
		'trp/term',
		array(
			'label'              => _x( 'Campi Tassonomia', 'block bindings source' ),
			'get_value_callback' => 'trp_block_bindings_term_callback',
		)
	);
}

add_action( 'init', 'trp_register_block_bindings_options_source' );

//RECUPERO CAMPI ACF OPTIONS DA PASSARE AI BLOCCHI GUTENBERG
function trp_block_bindings_options_callback( $source_attrs ) {
	if ( ! isset( $source_attrs['key'] ) ) {
		return null;
	}

	// Chiave del campo
	$field_key = $source_attrs['key'];

	// Restituisco il campo ACF corrispondente in pagina options
	return get_field($field_key, 'option');
}

//RECUPERO CAMPI ACF DELL'OGGETTO DA PASSARE AI BLOCCHI GUTENBERG
function trp_block_bindings_term_callback( $source_attrs ) {
	if ( ! isset( $source_attrs['key'] ) ) {
		return null;
	}

	// Chiave del campo
	$field_key = $source_attrs['key'];

	// Oggetto corrente
	$current_obj = get_queried_object();

	// Se non ho un oggetto corrente interrompo l'esecuzione
	if( !isset( $current_obj ) ) {
		return null;
	}

	// Campo oggetto
	$field_text = get_field($field_key, $current_obj);

	// Se sto cercando il titolo dell'oggetto e non è valorizzato faccio fallback sul name
	if($field_key == 'title' && empty($field_text)) {
		$field_text = $current_obj->name;
	}

	// Restituisco il campo ACF corrispondente nell'oggetto
	return $field_text;
}

/* Esempio di utilizzo
wp:heading {
"textAlign":"center",
"textColor":"grey",
"className":"c-hero__subtitle",
"fontSize":"title-1",
"metadata":{
    "bindings":{
        "content":{
            "source":"trp/options",
            "args":{
                "key":"news_subtitle"
            }
        }
    }
}
*/