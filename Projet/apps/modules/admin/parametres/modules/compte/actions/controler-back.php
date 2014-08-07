<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//changer le nom du module
$compte = $app['controllers_factory'];


/* Routage du module */

$compte->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/', __DIR__ . '/../../../templates/',)
    ));


    $app['selected'] = 'compte';

    //TODO  modification des adresses en bdd

    return $app['twig']->render('back.twig', array());
});


$compte->post('/', function (Request $request) use($app) {

    $user = array(
        "user_name" => $request->get('user_name'),
        "user_firstName" => $request->get('user_firstName'),
        "user_mail" => $request->get('user_mail')
    );

    $sql = "UPDATE param SET value = ? WHERE ref = ?";

    $response = 'Les données ont bien été enregistrées';

    foreach ($user as $ref => $value) {
        if (!$app['db']->executeUpdate($sql, array($value, $ref))) {
            $response = 'Erreur lors de l\'enregistrement...';
        }
    }

    return new Response(json_encode(['response' => $response]), 200);
});


//changer le nom du module
$app->mount('/admin/parametres/compte', $compte);
