<?php

//changer le nom du module
$seo = $app['controllers_factory'];

//TODO : remplir les meta à partir de la bdd

$app['meta'] = '';
    
/* Routage du module */

$seo->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/', __DIR__ . '/../../admin/parametres/templates/',)
    ));
   
    $app['selected'] = 'seo';
    
    return $app['twig']->render('back.twig', array());
});

//changer le nom du module
$app->mount('/admin/parametres/seo', $seo);
