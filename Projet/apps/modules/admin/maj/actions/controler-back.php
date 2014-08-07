<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//changer le nom du module
$maj = $app['controllers_factory'];

/* Routage du module */

$maj->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/',)
    ));


    // TODO #API : récuperer version disponible et les fournir à twig
    // TODO #API version_compare(version actuelle, version dispo, '<') -> liste module à mettre à jour à fournir à twig

    return $app['twig']->render('back.twig', array());
});

$maj->get('/notif/{notif}', function($notif) use ($app) {

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/',)
    ));

    switch ($notif) {
        case 'deleteok':
            return $app['twig']->render('back.twig', array(
                        'notif' => 'Suppression réussie', //notif peut contenir du html
                        'time' => '5000'
            ));
        case 'deletenok':
            return $app['twig']->render('back.twig', array(
                        'notif' => 'Echec lors de la suppression',//Il faut mettre trois barres pour escape
                        'time' => '5000'
            ));
        default :
            return $app->redirect('/admin/maj/');
    }
});


$maj->post('/rang', function (Request $request) use ($app) {
    
    $result = $request->get('table'); 
    $type = $request->get('type');
    
    switch ($type) {
        case 'front':
            $table = 1;
            break;
        case 'back':
            $table = 2;
            break;
        case 'param':
            $table = 4;
            break;
        default :
            return $app->redirect('/admin/');
    }
    
    $result = '&' . $result;
    $explode = explode('&table-'.$table.'[]=', $result);
    $i = 0;
    
    $response = '';

    foreach ($explode as $value) {
        $i++;
        $sql = "UPDATE modules SET rang = " . $i . " WHERE lien = ? AND front = ".$table."";
        if (!$app['db']->executeUpdate($sql, array($value))) {
            $response = 'Erreur...';
        }
    }
       
    return new Response(json_encode(['response' => $response]),200);
});

//changer le nom du module
$app->mount('/admin/maj', $maj);
