<?php

use Silex\WebTestCase;

class UserTest extends WebTestCase {

    public function createApplication() {
        $app = require __DIR__ . '/../../apps/app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();  
       
        return $app;
    }
    
    /**
     * @brief Copie la bdd pour pouvoir executer les requetes
     */
    public function setUp()
    {
        $database = __DIR__ . '/../../data/app.db';
        $databaseTest = __DIR__ . '/../../data/appSave.db';

        copy($database, $databaseTest);          
    }
    
    /**
     * @brief Supprime la sauvegarde de la bdd
     */
    public function tearDown()
    {
        $database = __DIR__ . '/../../data/appSave.db';
        $databaseTest = __DIR__ . '/../../data/app.db';

        copy($database, $databaseTest); 
        unlink($database);
    }
    
    
    public function testConstruct()
    {        
        $app = self::createApplication();
        $user = new User($app);
        $this->assertInstanceOf('User', $user);           
    }
  
    public function testCheckList()
    {        
        $app = self::createApplication();
        $error = User::checkList($app); 
        $this->assertTRUE($error);           
    }
}