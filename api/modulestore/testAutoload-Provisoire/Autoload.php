<?php

class Autoloader {
    
    private static $loader;
    
    public static function loadClassLoader($class)
    {
        if ('\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }
    
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('Autoloader', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Autoload\ClassLoader();

        $loader->register(true);

        return $loader;
    }
    
    function myRequire($file) {
        require $file;
    }
}
