<?php

//DISABILITARE EDITOR VISUALE ACF
//add_filter('acf/settings/show_admin', '__return_false');

// PAGE OPTION
/*
$dati_tema = wp_get_theme();
$title_option_page = 'Opzioni '.$dati_tema->Name;

acf_add_options_sub_page(array(
    'page_title' 	    => $title_option_page,
    'menu_slug' 	    => 'acf-options',
    'parent_slug'       => 'themes.php',
    'update_button'     => __('Aggiorna', 'acf'),
    'updated_message'   => __("Opzioni aggiornate", 'acf'),
));	
*/


// GUTENBERG CATEGORIES REGISTRATION
function trp_block_categories( $categories, $block_editor_context ) {
    return array_merge(
        array(
            array(
                'slug' => 'custom',
                'title' => get_bloginfo('name'),
                'icon'  => 'wordpress',
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories_all', 'trp_block_categories', 10, 2 );


//GUTENBERG BLOCKS REGISTRATION
function trp_register_acf_blocks() {
    //register_block_type( THEME_DIR . '/partials/blocks/custom-block' );
}
add_action( 'init', 'trp_register_acf_blocks' );


//REMOVE ADMIN BAR FOR ADMINISTRATOR IF OPTION FIELD IS CHECKED
if(!is_admin() && current_user_can('administrator') && get_field('admin_bar', 'option')){
    add_filter('show_admin_bar', '__return_false');
}