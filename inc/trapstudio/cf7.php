<?php 
//RIMUOVO <P> AUTOMATICI DALL'OUTPUT DI CF7
add_filter('wpcf7_autop_or_not', '__return_false');


/*USARE COME ESEMPIO 
//AGGIUNGO ATTRIBUTO SHORTCODE CF7 (Aggiungo valori dinamici al form modificando lo shortcode di CF7)
add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );
function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
  $my_attr = 'attributo-custom';
 
  if ( isset( $atts[$my_attr] ) ) {
    $out[$my_attr] = $atts[$my_attr];
  }
 
  return $out;
}
*/

/*COME UTILIZZARE LO SHORTCODE APPENA CREATO:
UTILIZZO IN FORM CF7:
[hidden attributo-custom default:shortcode_attr]

UTILIZZO IN SHORTCODE PHP:
echo do_shortcode("[contact-form-7 id='{$contact_form_id}' html_class='c-form' attributo-custom='{$valore_dinamico}']");
*/


/*USARE COME ESEMPIO 
//VALIDAZIONE SELECT NOT REQUIRED
add_filter( 'wpcf7_validate_select', 'trp_select_confirmation_validation_filter', 20, 2 );
function trp_select_confirmation_validation_filter( $result, $tag ) {
    if ($tag->name == 'your-cilindrata-miscela'):
        //se il tag corrente è la cilindrata del form miscela
        $cilindrata = $_POST['your-cilindrata-miscela'];

        //se la cilindrata è diversa da 50cc mostro errore di validazione
        if($cilindrata != '50cc'):

            $error_msg = __("Ci dispiace, ma al Miscela Day sono ammessi solo mezzi con cilindrata originale 50cc! Cerca un veicolo con il quale partecipare, ma se non lo trovi non preoccuparti: l'evento è aperto al pubblico, vieni a trovarci con i tuoi amici. Il divertimento è assicurato!!!", 'malossi');
            $result->invalidate($tag, $error_msg);

        endif;
    endif;

    return $result;
}
*/


/*USARE COME ESEMPIO 
//VALIDAZIONE CAMPO TESTO REQUIRED (notare "*" nel filtro)
add_filter( 'wpcf7_validate_text*', 'trp_text_confirmation_validation_filter', 20, 2 );
function trp_text_confirmation_validation_filter( $result, $tag ) {
    if ($tag->name == 'your-scooter-miscela'):
        //se il tag corrente è la scelta dello scooter del form miscela
        $submit_count = get_option('miscela_day_subscription');

        //se utente già registrato mostro errore di validazione
        if(isset($_COOKIE['miscela_day'])):

            $error_msg = __("Ti sei già prenotato per questo evento!", 'malossi');
            $result->invalidate($tag, $error_msg);

        endif;

        //se è stato raggiunto il massimo di prenotazioni mostro errore di validazione
        if($submit_count >= 100):

            $error_msg = __("Ci dispiace, ma sei arrivato tardi, non ci sono più posti disponibili! Ma non disperare: l'evento è a ingresso libero, ti aspettiamo comunque, il divertimento è assicurato!", 'malossi');
            $result->invalidate($tag, $error_msg);

        endif;
    endif;

    return $result;
}
*/


/*USARE COME ESEMPIO 
//CONTEGGIO FORM SUBMITTED IN BASE AL FORM ID CREANDO UNA OPTION SUL DATABASE (cambiare id ed option)
add_action('wpcf7_mail_sent', 'trp_cf7_mail_sent' );
function trp_cf7_mail_sent($contact_form) {
    //prendo form ID
    $form_id = $contact_form->id();

    //form ID miscela day
    if($form_id == 10958):
        //prendo opzione dal database
        $submit_count = get_option('miscela_day_subscription');
        
        if($submit_count === false):
            //se l'opzione non è presente nel database la creo
            add_option('miscela_day_subscription', 1);
        else:
            //se l'opzione è presente nel database la aggiorno
            $submit_count++;
            update_option('miscela_day_subscription', $submit_count);
        endif;

        //imposto cookie per l'utente registrato
        setcookie('miscela_day', true, time() + (86400 * 30)); // 86400 = 1 day
    endif;
}
*/