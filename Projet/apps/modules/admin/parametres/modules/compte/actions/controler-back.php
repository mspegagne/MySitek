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


$compte->post('/', function (Request $request) {
       
    $name = $request->get('user_name');    
    return new Response($name,200);
});


//changer le nom du module
$app->mount('/admin/parametres/compte', $compte);
