<?php
/* ---- SCRIPT qui recupere la requete d'achat à mettre dans le store = achat.php ----
 * Ce script permet de générer l'url de paiement si payant ou de mettre à jour les données client si gratuit
 * la variable $ipn correspond au code non commenté en dessous.
 
    //TODO récupérer ces donnees à partir du store
    $type ='';
    $file ='';
    $user_id =''; //permet de verfier que la requete provient bien du client
    $user_url ='';
 
    require_once __DIR__ . '/../lib/payplug/lib/Payplug.php';

    Payplug::setConfigFromFile(__DIR__ . '/../lib/payplug/parameters.json');

    $ipn = 'http://api.mysitek.com/payplug/ipn.php?user=' . $user_id . '&amp;type=' . $type . '&amp;module=' . $file . '';
    $install = $user_url . '/install/' . $type . '/' . $file . '/' . $user_id . '';

    //TODO #MODULE : Récupération de l'objet module et remplir à partir la variable prix ci dessous :
    $prix = '0150';

    if ($prix == 0) {
        //TODO execution de $ipn et recuperation de $confirmation                     
        if($confirmation)
        {
            return $app->redirect($install);
        }
        else
        {
            //erreur lors de la maj de la list
        }
        
    } else {

        $paymentUrl = PaymentUrl::generateUrl(array(
                    'amount' => $prix,
                    'currency' => 'EUR',
                    'ipnUrl' => $ipn,
                    'returnUrl' => $install,
                    'email' => $app['user_mail'],
                    'firstName' => $app['user_firstName'],
                    'lastName' => $app['user_name']
        ));

        header("Location: $paymentUrl");
        exit();

        return '';
    }
 
 */

require_once __DIR__ . '/lib/Payplug.php';
Payplug::setConfigFromFile("parameters.json");

$module = htmlspecialchars($_GET["module"]);
$type = htmlspecialchars($_GET["type"]);
$user_id = htmlspecialchars($_GET["user"]);

$confirmation = FALSE;

//TODO #MODULE : recuperation objet module à partir de l'api
//TODO #MODULE :recuperation du prix du module
$prixmodule = '';

 //TODO #USER : récupération de la list de l'user à partir de l'user_id

if ($prixmodule == 0) {

    //TODO : array_push du module dans la list
    //TODO #USER : enregistrement de la nouvelle list dans nos bdd
    
    $confirmation = TRUE;
    return $confirmation;
    
} else {

    try {
        $ipn = new IPN();

        $prix = $ipn->amount;

        //pour éviter qu'un ptit con modifie le formulaire en fixant le prix lui meme
        //la il se fait baiser il paie mais ca marche pas :P
        if ($prixmodule == $prix) {

            //TODO : array_push du module dans la list
            //TODO #USER : enregistrement de la nouvelle list dans nos bdd
                    
        }
    } catch (InvalidSignatureException $e) {
        //Petit con détecté, renvoi vers une url pour petits cons.
        header("Location: http://www.mysitek.com/");
    }
}