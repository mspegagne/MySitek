<?php

use Silex\WebTestCase;

class ModuleTest extends WebTestCase {

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
    
    public function testConvertType()
    {
        $this->assertEquals(0, Module::convertType('admin'));
        $this->assertEquals(1, Module::convertType('front'));
        $this->assertEquals(2, Module::convertType('back'));   
        $this->assertEquals(3, Module::convertType('param'));
        $this->assertEquals(4, Module::convertType('param_plus'));
    }
    
    public function testGetList()
    {
        $app = self::createApplication();
        Module::getList($app, 'test');
        $this->assertNotEmpty($app['modules_test']);        
    }
    
    public function testGetAll()
    {
        $app = self::createApplication();
        Module::getAll($app);
        $this->assertNotEmpty($app['modules']);       
    }
    
    public function testRang()
    {
        $app = self::createApplication();
        $back = $app['modules_back'];
        $result = '';
        $i = 0;
        foreach ($back as $module)    
        {
            if($i == 0)
            {
                $result .='table-2[]='.$module['lien'].'';
            }
            else
            {
                $result .='&table-2[]='.$module['lien'].'';
            }
            $i++;
        }
        $response = Module::rang($result, 'back', $app);   
        $this->assertSame('', $response);       
    }
    
}