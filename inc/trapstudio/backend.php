<?php 
//REMOVE ADMIN BAR FOR SUBSCRIBER USER
if(!current_user_can('edit_posts')){
    add_filter('show_admin_bar', '__return_false');
}


//ADMIN LOGO
function my_login_logo_url() {
    return HOME_URL;
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return get_option('blogname');
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );


//DISABLE EDITOR FULLSCREEN BY DEFAULT
function ghub_disable_editor_fullscreen_mode() {
	$script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
	wp_add_inline_script( 'wp-blocks', $script );
}
add_action( 'enqueue_block_editor_assets', 'ghub_disable_editor_fullscreen_mode' );


//REDIRECT TO DASHBOARD FOR USER
function trp_admin_redirect() {
    if (!current_user_can( 'edit_posts' ) && !wp_doing_ajax() ):

        wp_safe_redirect(HOME_URL);
        exit;

    endif;
}
add_action( 'admin_init', 'trp_admin_redirect', 1 );

//redirect after login
function login_redirect( $redirect_to, $request, $user ){
    if($redirect_to):
        $url = $redirect_to;
    else:
        $url = HOME_URL;
    endif;

    return $url;
}
add_filter( 'login_redirect', 'login_redirect', 10, 3 );


//REMOVE MENU PAGES FOR NOT ADMINISTRATOR USER
function remove_posts_menu() {

    //se l'utente non è amministratore
    if(!current_user_can('edit_dashboard')):

        //rimuovo tutte le voci di amministrazione a parte Articoli, Media, Pagine e Profilo
        global $menu;

        foreach($menu as $i => $item):
            if($item[2] != 'edit.php' && $item[2] != 'edit.php?post_type=page' && $item[2] != 'upload.php' && $item[2] != 'profile.php'):
                unset( $menu[ $i ] );
            endif;
        endforeach;

        //reindirizzo tutte le altre pagine
        global $pagenow;

        //se la pagina di amministrazione è diversa da edit.php o post.php o post-new.php o upload.php o profile.php faccio redirect
        if(!($pagenow == 'edit.php' || $pagenow == 'post.php' || $pagenow == 'post-new.php' || $pagenow == 'upload.php' || $pagenow == 'profile.php' || wp_doing_ajax())):

            //faccio redirect alla pagina admin candidature
            //wp_safe_redirect( admin_url( '/edit.php?post_type=page' ) );

        endif;

    endif;
}
add_action('admin_init', 'remove_posts_menu');
