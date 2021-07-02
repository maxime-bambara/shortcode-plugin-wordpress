<?php
/*
  Plugin Name: Mon custom shortcode
  Description: Plugin fournissant des shortcodes. Veuillez créer un custom field 'mdp' pour le faire fonctionner dans la page concerné. Les shortcodes à inscrire : [contenu_securise][contenu_securise_checked]
  Author: Maxime Bambara
  Version: 1.0.0
 */

add_action('init', 'register_my_session', 1);
add_shortcode( 'contenu_securise', 'check' ); 
add_shortcode( 'contenu_securise_checked', 'show' );

//Initialisation de la session et enregistrement des données du formulaire dans la session.
function register_my_session()
{
  if( !session_id() ){
    session_start();
    if (isset($_POST['mdp'])) { 
        $_SESSION['mdp'] = $_POST['mdp'];
    }
  }
}

//Verification de la session. Si le mdp est déjà connu, le formulaire ne sera pas visible. 
function check() {
    $field = get_post_meta(get_the_ID(), 'mdp', true);
    if(!empty($field) && $field == $_SESSION['mdp']){
        return false;
    }

    echo '<form method = "post">
        <input type="text" name="mdp">
        <input  type="submit" name="check">
    </form>';
}

// Vérification du mdp enregistré en session
function show() {
    $text = 'Mot de passe invalide';
    $field = get_post_meta(get_the_ID(), 'mdp', true);
    if(!empty($field) && $field == $_SESSION['mdp']){
        $text = 'Mon contenu sécurisé';
    }

    echo $text;
}