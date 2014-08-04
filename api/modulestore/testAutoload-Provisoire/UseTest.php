<?php

$function = function ($class)
    {
        if ('\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    };

spl_autoload_register($function, true, true);

require_once './Namespace3/Classe1.php';
    
echo "Test :\n\n";
\Namespace3\Classe1::whoAmI();