<?php

require_once __DIR__ . '/../token.php';

require_once __DIR__ . '/lib/Payplug.php';
Payplug::setConfigFromFile("parameters.json");

$module = htmlspecialchars($_GET["module"]);
$type = htmlspecialchars($_GET["type"]);
$user = htmlspecialchars($_GET["tuser"]);

//TODO : recuperation objet module à partir de l'api
//TODO recuperation du prix du module
$prixmodule = '';

$token = new Token($user);

if ($prixmodule == 0) {

    $token->update($module, $type);
} else {

    try {
        $ipn = new IPN();

        $prix = $ipn->amount;

        //pour éviter qu'un ptit con modifie le formulaire en fixant le prix lui meme
        //la il se fait baiser il paie mais ca marche pas :P
        if ($prixmodule == $prix) {

            $token->update($module, $type);
        }
    } catch (InvalidSignatureException $e) {
        header("Location: http://www.mysitek.com/");
    }
}