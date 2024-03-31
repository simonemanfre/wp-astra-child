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

//ADMIN PAGE OPTION ONLY FOR SPECIFIC USER
if( trp_is_super_admin() ):

    acf_add_options_sub_page(array(
        'page_title' 	    => 'Opzioni Trapstudio',
        'menu_slug' 	    => 'trap-options',
        'parent_slug'       => 'themes.php',
        'update_button'     => __('Aggiorna', 'dna'),
        'updated_message'   => __("Opzioni aggiornate", 'dna'),
    ));	

endif;