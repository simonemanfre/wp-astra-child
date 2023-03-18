<?php 

//CAMBIO NOME POSTS IN EVENTI
/*
function trp_change_post_object() {
    $get_post_type = get_post_type_object('post');
    $labels = $get_post_type->labels;
	$labels->name = 'Eventi';
	$labels->singular_name = 'Evento';
	$labels->add_new = 'Aggiungi Evento';
	$labels->add_new_item = 'Aggiungi Evento';
	$labels->edit_item = 'Modifica Evento';
	$labels->new_item = 'Eventi';
	$labels->view_item = 'Vedi Evento';
	$labels->search_items = 'Cerca Evento';
	$labels->not_found = 'Nessun evento trovato';
	$labels->not_found_in_trash = 'Nessun evento nel cestino';
	$labels->all_items = 'Tutti gli Eventi';
	$labels->menu_name = 'Eventi';
	$labels->name_admin_bar = 'Eventi';
}
add_action( 'init', 'trp_change_post_object' );
*/

//REGISTRAZIONE CUSTOM POST TYPE
function cptui_register_my_cpts() {	
	$labels = [
		"name" => 'Example',
		"singular_name" => 'Example',
	];

	$args = [
		"label" => 'Example',
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "with_front" => false ],
		"query_var" => true,
		"supports" => [ "title", "editor", "excerpt", "thumbnail", "revisions", "page-attributes" ],
	];

	register_post_type( "example", $args );
}
add_action( 'init', 'cptui_register_my_cpts' );


function cptui_register_my_taxes() {
	$labels = [
		"name" => 'Example Typology',
		"singular_name" => 'Example Typology',
	];

	$args = [
		"label" => 'Example Typology',
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'with_front' => false ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
    ];
	register_taxonomy( "example_typology", [ "example" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );