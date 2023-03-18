<?php 
//SANITIZE PHONE
function trp_phone($tel) {
    $tel = str_replace('+', '00', $tel);
    $tel = preg_replace("/[^0-9]/", "", $tel);

    return $tel;
}

//GET TEMPLATE PAGE
function trp_get_template_page($template_slug) {
    //esempio di $template_slug: "templates/p-thankyou.php"

    $args = array(
        'numberposts' => 1,
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => $template_slug,
        'fields' => 'ids'
    );
    $template_page = get_posts($args);
    $template_page = $template_page[0];

    return $template_page;
}

//GET TERMS
function trp_get_taxonomy($taxonomy = 'category', $args = array()) {

    $defaults = array(
        'taxonomy' => $taxonomy,
        'hide_empty' => 1,
    );

    $parsed_args = wp_parse_args( $args, $defaults );

    $terms = get_terms( $parsed_args );

    return $terms;
}

//GET POSTS
function trp_get_posts($args) {

    $defaults = array(
        'post_type' => 'post',
        'numberposts' => 5,
        'suppress_filters' => 0,
        'fields' => 'ids',
    );

    $parsed_args = wp_parse_args( $args, $defaults );

    $posts = get_posts( $parsed_args );

    return $posts;
}

//QUERY POSTS
function trp_query($args) {

    $defaults = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'suppress_filters' => 0,
        'fields' => 'ids',
    );

    $parsed_args = wp_parse_args( $args, $defaults );

    //PAGINATION
    $no_found_rows = 1;
    if(isset($args['paged'])):
        $no_found_rows = 0;
    endif;
    $parsed_args['no_found_rows'] = $no_found_rows;

    //CACHE TAX QUERY
    $update_term = 0;
    if(isset($args['tax_query'])):
        $update_term = 1;
    endif;
    $parsed_args['update_post_term_cache'] = $update_term;

    //CACHE META QUERY
    $update_meta = 0;
    if(isset($args['meta_query'])):
        $update_meta = 1;
    endif;
    $parsed_args['update_post_meta_cache'] = $update_meta;

    $query_posts = new WP_Query( $parsed_args );

    return $query_posts;
}

/*
ESEMPIO DI UTILIZZO:
//se passo una 'tax_query' o una 'meta_query' vengono aggiornati in automatico i valori di 'update_post_term_cache' e 'update_post_meta_cache'
//in caso serva la paginazione passare il parametro 'paged'

    $args = array(
        'post_type' => 'products',
        'posts_per_page' => 20,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy'  => 'product_cat',
                'field'     => 'slug',
                'terms'     => 'carte-crypto-cashback'
            ),
        ),
    );
    $query_products = trp_query($args);
*/

//TASSONOMIA PRIMARIA YOAST
function trp_get_primary_term($post_id = 0, $taxonomy = 'category', $term_as_obj = true) {

    if($post_id === 0):
		$post_id = get_the_ID();
	endif;

    //prendo tassonomie
    $terms = get_the_terms($post_id, $taxonomy);
    if($terms):

        if(class_exists('WPSEO_Primary_Term')):

            $primary_term  = new WPSEO_Primary_Term( $taxonomy, $post_id );
            $primary_term = $primary_term->get_primary_term();

            // Set the term object.
			$term_obj = get_term( $primary_term );

			if(is_wp_error($term_obj)):
				$term_obj  = $terms[0];
            endif;

        else:

            $term_obj  = $terms[0];

        endif;

    endif;

    if(!empty($term_obj)):
        return $term_as_obj ? $term_obj : $term_obj->name;
    endif;
}