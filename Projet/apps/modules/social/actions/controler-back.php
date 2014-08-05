<?php

//changer le nom du module
$social = $app['controllers_factory'];


//TODO : remplir les reseaux à partir de la bdd

$app['reseaux'] = array(
    "facebook" => "https://www.facebook.com/OuestINSA",
    "twitter" => "https://twitter.com/OuestINSA",
);

    
/* Routage du module */

$social->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/', __DIR__ . '/../../admin/parametres/templates/',)
    ));
        
    $app['selected'] = 'social';
        
    return $app['twig']->render('back.twig', array());
});

//changer le nom du module
$app->mount('/admin/parametres/social', $social);
