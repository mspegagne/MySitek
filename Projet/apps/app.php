<?php

$app = new Silex\Application();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Common\Persistence\ObjectManager;

require_once __DIR__ . '/../lib/model/Install.php';
require_once __DIR__ . '/../lib/model/User.php';
require_once __DIR__ . '/../lib/model/Module.php';
require_once __DIR__ . '/../lib/model/Param.php';
require_once __DIR__ . '/../lib/model/UserProvider.php';


/* Activation de doctrine */

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/../data/app.db',
    ),
));

//TODO #PROD : mettre register(false)
ErrorHandler::register();
ExceptionHandler::register();

/* Parametres du site */

$app['debug'] = true; //TODO #PROD : mettre false
$app['url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/';
$app['selected'] = ''; //module en cours (pour affichage lien actif)

Param::load($app);


/* Recuperation du template */

$sql = "SELECT * FROM templates WHERE selected = 1";
$retour = $app['db']->fetchAssoc($sql);
$app['template'] = $retour['name'];


/* Recuperation des modules */

Module::getList($app, 'front');

Module::getList($app, 'back');

Module::getList($app, 'admin');

Module::getList($app, 'param');

Module::getList($app, 'param_plus');

Module::getAll($app);



/* Securisation */

$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


/* FIREWALL */
$app['security.firewalls'] = array(
    'user' => array(
        'pattern' => '^/admin/',
        'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
        'logout' => array('logout_path' => '/admin/logout'),
        'users' => $app->share(function () use ($app) {
            return new UserProvider($app['db']);
        }),
    ),
);



/* Login */

$app->register(new Silex\Provider\SessionServiceProvider());


$app->get('/login', function(Request $request) use ($app) {

    #echo (new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder())->encodePassword('foo', '');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/templates/' . $app['template'] . '/')
    ));

    return $app['twig']->render('login.twig', array(
                'error' => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username')
    ));
});



/* Routage */

$app->get('/', function() use ($app) {

    return $app->redirect('/' . $app['index']);
});


$app->get('/admin/', function() use ($app) {

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/templates/' . $app['template'] . '/')
    ));

    return $app['twig']->render('admin.twig', array(
                'hello' => 'Hello world Admin !',
    ));
});


$app->get('/admin/notif/{notif}', function($notif) use ($app) {

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/templates/' . $app['template'] . '/')
    ));

    switch ($notif) {
        case 'installok':
            return $app['twig']->render('admin.twig', array(
                        'hello' => 'Hello world Admin !',
                        'notif' => 'Le fichier est maintenant installé', //notif peut contenir du html
                        'time' => '5000'
            ));
        case 'installnok':
            return $app['twig']->render('admin.twig', array(
                        'hello' => 'Hello world Admin !',
                        'notif' => 'Erreur lors de l\\\'installation...', //Il faut mettre trois barres pour escape
                        'time' => '5000'
            ));
        default :
            return $app->redirect('/admin/');
    }
});


$app->get('/admin/delete/{type}/{file}', function($type, $file) use ($app) {

    require_once __DIR__ . '/../lib/model/Install.php';

    $error = Install::delete($file, $type, $app);

    if ($error == '') {
        return $app->redirect('/admin/maj/notif/deleteok');
    } else {
        return $app->redirect('/admin/maj/notif/deletenok');
    }
});


$app->post('/admin/update', function (Request $request) use ($app) {

    $type = $request->get('type');
    $file = $request->get('file');

    require_once __DIR__ . '/../lib/model/Install.php';

    if (User::checklist($app)) {
        $error = Install::update($file, $type, $app);
    } else {
        $error = 'Module illégal !';
    }

    return new Response($error, 200);
});


/* API cote client pour install à partir du store */
$app->post('/install', function (Request $request) use ($app) {

    $type = $request->get('type');
    $file = $request->get('file');
    $user_id = $request->get('user_id'); //sert à confirmer l'identité de l'user

    if ($user_id == $app['user_id']) {
        require_once __DIR__ . '/../lib/model/Install.php';

        if (User::checklist($app)) {
            $error = Install::installation($file, $type, $app);
        } else {
            $error = 'Installation hors Store !';
        }
    } else {
        $error = 'Utilisateur non autorisé !';
    }

    return $error;
});


$app->get('/install/{type}/{file}/{user_id}', function ($type, $file, $user_id) use ($app) {

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/templates/' . $app['template'] . '/')
    ));

     if ($user_id == $app['user_id']) {
        require_once __DIR__ . '/../lib/model/Install.php';

        if (User::checklist($app)) {
            $error = Install::installation($file, $type, $app);
        } else {
            $error = 'Installation hors Store !';
        }
    } else {
        $error = 'Utilisateur non autorisé !';
    }

    if ($error == '') {
        return $app->redirect('/admin/notif/installok');
    } else {
        return $app->redirect('/admin/notif/installnok');
    }
});

//Routage des différents modules

foreach ($app['modules_back'] as $module) {

    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-back.php';
}

foreach ($app['modules_admin'] as $module) {

    include_once __DIR__ . '/modules/admin/' . $module['lien'] . '/actions/controler-back.php';
}

foreach ($app['modules_param_plus'] as $module) {

    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-back.php';
}

foreach ($app['modules_param'] as $module) {

    include_once __DIR__ . '/modules/admin/parametres/modules/' . $module['lien'] . '/actions/controler-back.php';
}

foreach ($app['modules_front'] as $module) {

    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-back.php';
    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-front.php';
}



return $app;



