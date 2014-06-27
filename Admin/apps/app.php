<?php

$app = new Silex\Application();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/* Activation de doctrine */

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/../data/app.db',
    ),
));


use Doctrine\Common\Persistence\ObjectManager;


/* Parametres du site */

$app['siteName'] = 'MySitek'; 
$app['debug'] = true;


/* Recuperation du template */

$sql = "SELECT * FROM templates WHERE selected = 1";
$retour = $app['db']->fetchAssoc($sql);
$app['template'] = $retour['name']; 


/* Recuperation des modules */

//front à 1 signifie que le module à une partie publique
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = 1";
$app['modules_front'] = $app['db']->fetchAll($sql);

//front à 0 signifie module uniquement admin
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = 0";
$app['modules_back'] = $app['db']->fetchAll($sql);



/* ADD TEMPLATE A implementer dans install.php */ 
 
  // $sql = "INSERT INTO templates (name,selected) VALUES (?,?)";
  // $app['db']->executeUpdate($sql, array('sb_admin', TRUE));
 


/* ADD MODULE  A implementer dans install.php */
 
  
  // $sql = "INSERT INTO modules (name, lien, icon, selected) VALUES (?,?,?,?)";
  // $app['db']->executeUpdate($sql, array('dashboard', '#', 'fa-tachometer', TRUE));
  

/* Securisation */

$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


$app['security.firewalls'] = array(
    'unsecured' => array(
        'pattern' => '^/public',//enlever public 
        'anonymous' => true,
    ),
    'user' => array(
        'pattern' => '^/', //il faudra mettre admin ici et router les modules back dans admin
        'form' => array('login_path' => '/public/login', 'check_path' => '/login_check'),
        'logout' => array('logout_path' => '/logout'),
        'users' => array(
            'mysitek' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
        ),
    ),
);


//'users' => $app->share(function($app) { 
            //        return new App\User\UserProvider($app['db']); 
              //  }),

/* Login */

$app->register(new Silex\Provider\SessionServiceProvider());


$app->get('/public/login', function(Request $request) use ($app) {
    
    #echo (new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder())->encodePassword('foo', '');
    
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path'    => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__.'/templates/'.$app['template'].'/')
    )); 
    
    return $app['twig']->render('login.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username')
    ));
});

$app->get('/logout', function() use($app)
{
    $app['session']->set('user', null);
    return $app->redirect('/public/login');
 
});


/* Routage */

$app->get('/', function() use ($app) {

    
    //Pour l'admin on lui dit d'aller chercher le module dashboard et on lui envoie les memes infos mais 
    //pour mysitek il faudra faire un index.twig dans le template qui reenverra l'interface d'admin.
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path'    => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__.'/templates/'.$app['template'].'/',
                             __DIR__.'/modules/dashboard/templates/')
    ));    
    
    return $app['twig']->render('index.twig', array(
        'menu' => $app['modules_back'],        
        'adresse' => '',
        'hello' => 'Hello world!'
         
    ));
});

//Routage des différents modules

foreach ($app['modules_back'] as $module){

    include_once __DIR__.'/modules/'.$module['name'].'/actions/controler-back.php';

}

foreach ($app['modules_front'] as $module){

    include_once __DIR__.'/modules/'.$module['name'].'/actions/controler-front.php';

}

return $app;



