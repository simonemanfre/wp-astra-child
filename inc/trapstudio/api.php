<?php 
// FORMAT DATA
function trp_format_date($date) {
    // Trasformo data in timestamp
    $timestamp = strtotime($date);

    // Formatto la data (eventualmente cambiare formato "d F Y")
    $formattedDate = date_i18n('d F Y', $timestamp);

    return $formattedDate;
}

//FORMAT PHONE
function trp_format_phone($tel) {
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

    if(empty($template_page)):

        return null;
        
    endif;

    return $template_page[0];
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

//GET THE TERMS
function trp_get_the_terms($post, $taxonomy = 'category', $field = 'term_id') {

    $terms = get_the_terms($post, $taxonomy);
    $terms_array = wp_list_pluck($terms, $field); 

    return $terms_array;
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
function trp_get_primary_term($post_id = 0, $taxonomy = 'category', $fields = 'all') {

    if($post_id === 0):
		$post_id = get_the_ID();
	endif;

    //prendo tassonomie
    $terms = get_the_terms($post_id, $taxonomy);

    if(is_wp_error($terms)):
        return false;
    endif;

    if($terms === false):
        return false;
    endif;

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

    if(empty($term_obj)):
        return false;
    else:
        return $fields == 'all' ? $term_obj : $term_obj->$fields;
    endif;
}

//CONTROLLO SE UN BLOCCO LAYOUT È PRESENTE NEL COMPOSER
function trp_has_acf_layout($layout) {

    //prendo il composer dal post corrente
    $composer = get_field('composer');

    //se il composer è valorizzato
    if(!empty($composer)): 
        foreach($composer as $item):

            //se trovo il layout richiesto restituisto true ed interrompo
            if($item['acf_fc_layout'] == $layout):

                return true;
                break;

            endif;

        endforeach; 
    endif;

    //se non ho trovato il layout o il composer non ha valori restituisco false
    return false;
}

//PRENDO I BLOCCHI LAYOUT DAL COMPOSER
function trp_get_acf_layout($layout) {

    //prendo il composer dal post corrente
    $composer = get_field('composer');

    //lo stesso layout del blocco può essere presente n volte 
    $blocks = array();

    //se il composer è valorizzato
    if(!empty($composer)): 
        foreach($composer as $item):

            //se trovo il layout richiesto lo aggiungo ai risultati
            if($item['acf_fc_layout'] == $layout):

                array_push($blocks, $item);

            endif;

        endforeach;

        //se ho trovato almeno un layout restituisco l'array
        if(!empty($blocks)): 

            return $blocks;

        endif;

    endif;

    //se non ho trovato il layout o il composer non ha valori restituisco false
    return false;
}