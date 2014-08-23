<?php

use Silex\WebTestCase;

class ParamTest extends WebTestCase {

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
        $param = new Param('user_mail', $app);
        $this->assertInstanceOf('Param', $param);           
    }
    
    public function testSaveParam()
    {        
        $app = self::createApplication();
        if(Param::saveParam('testingazerty', 'test', $app))
        {
            $error = Param::saveParam('testingazerty', 'test2', $app);  
        }
        $this->assertTRUE($error);           
    }
    
    public function testSaveParams()
    {        
        $app = self::createApplication();
        $error = FALSE;
        if(Param::saveParam('testingazerty', 'test', $app) && Param::saveParam('testingqwerty', 'test2', $app))
        {
            $params = array(
                "testingazerty" => "essai",
                "testingqwerty" => "essai"
            ); 
            
            $error = Param::saveParams($params, $app);            
        }
        
        $this->assertEquals('Les données ont bien été enregistrées', $error);           
    }
    
    public function testDeleteParam()
    {        
        $app = self::createApplication();
        if(Param::saveParam('testingazerty', 'test', $app))
        {
            $error = Param::deleteParam('testingazerty', $app);  
        }
        $this->assertTRUE($error);           
    }
    
    public function testLoad()
    {
        $app = self::createApplication();
        Param::load($app);
        $this->assertNotEmpty($app['modules']); 
    }
    
    /**
     * Reste à tester les envois de mails lors du changement pwd ?
     */
    
}
