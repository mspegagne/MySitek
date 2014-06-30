<?php
$dashboard = $app['controllers_factory'];


$dashboard->get('/', function() use ($app) {
    
    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.class_path'    => __DIR__ . '/../../../../vendor/Twig/lib',
            'twig.path' => array(__DIR__.'/../../../templates/'.$app['template'].'/',
                                 __DIR__.'/../templates/',)
    )); 
    
    //Recuperation de l'user
    $app['user'] =  $app['security']->getToken()->getUser() ;    
    
    $app['selected']='dashboard';

    return $app['twig']->render('index.twig', array(
        'hello' => 'Hello world 2 !'
    ));
    
});

$app->mount('/dashboard', $dashboard);