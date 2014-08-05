<?php

//changer le nom du module
$param = $app['controllers_factory'];

/* Routage du module */

$param->get('/', function() use ($app) {

    return $app->redirect('/admin/parametres/compte/');
    
});

//changer le nom du module
$app->mount('/admin/parametres', $param);
