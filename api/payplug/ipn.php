<?php

//TODO : inclure classe Token

require_once __DIR__ . '/lib/Payplug.php';
Payplug::setConfigFromFile("parameters.json");

$module = htmlspecialchars($_GET["module"]);
$type = htmlspecialchars($_GET["type"]);
$user = htmlspecialchars($_GET["tuser"]);

//TODO : recuperation objet module à partir de l'api
//TODO recuperation du prix du module
$prixmodule = '';

if ($prixmodule == 0) {

    //TODO : majToken($user, $module)
} else {

    try {
        $ipn = new IPN();

        $prix = $ipn->amount;

        //pour éviter qu'un ptit con modifie le formulaire en fixant le prix lui meme
        //la il se fait baiser il paie mais ca marche pas :P
        if ($prixmodule == $prix) {

            //TODO : majToken($user, $module)
        }
    } catch (InvalidSignatureException $e) {
        header("Location: http://www.mysitek.com/");
    }
}