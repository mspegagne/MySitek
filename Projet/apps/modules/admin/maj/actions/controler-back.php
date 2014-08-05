<?php

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


$maj->post('/rang/front', function () use ($app) {

    $result = $_REQUEST["table"];
    $result = '&' . $result;
    $result = explode('&table-1[]=', $result);
    $i = 0;

    foreach ($result as $value) {
        $i++;
        $sql = "UPDATE modules SET rang = " . $i . " WHERE lien = ? AND front = 1";
        $app['db']->executeUpdate($sql, array($value));
    }

    return '';
});

$maj->post('/rang/back', function () use ($app) {

    $result = $_REQUEST["table"];
    $result = '&' . $result;
    $result = explode('&table-2[]=', $result);
    $i = 0;

    foreach ($result as $value) {
        $i++;
        $sql = "UPDATE modules SET rang = " . $i . " WHERE lien = ? AND front = 2";
        $app['db']->executeUpdate($sql, array($value));
    }

    return '';
});

$maj->post('/rang/param', function () use ($app) {

    $result = $_REQUEST["table"];
    $result = '&' . $result;
    $result = explode('&table-3[]=', $result);
    $i = 0;

    foreach ($result as $value) {
        $i++;
        $sql = "UPDATE modules SET rang = " . $i . " WHERE lien = ? AND front = 4";
        $app['db']->executeUpdate($sql, array($value));
    }

    return '';
});

//changer le nom du module
$app->mount('/admin/maj', $maj);
