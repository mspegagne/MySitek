<?php

use Silex\WebTestCase;

class InstallTest extends WebTestCase {

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
    
    public function testCheckdependencies()
    {        
        $error = Install::checkdependencies();
        $this->assertEquals('', $error);           
    }
    
    public function testGetFile()
    {        
        $error = Install::getfile('http://download.mysitek.com/modules/testingazerty.zip', 'testingazerty.zip');        
        @unlink('testingazerty.zip');
        $this->assertEquals('', $error);           
    }
    
    public function testInstallation()
    {        
        $app = self::createApplication();
        $error = Install::installation('testingazerty', 'modules', $app);        
        $this->assertEquals('', $error);           
    }
    
    public function testUpdate()
    {        
        $app = self::createApplication();
        $error = Install::update('testingazerty', 'modules', $app);        
        $this->assertEquals('', $error);           
    }
    
    public function testDelete()
    {        
        $app = self::createApplication();
        $error = Install::delete('testingazerty', 'modules', $app);        
        $this->assertEquals('', $error);           
    }
  
}