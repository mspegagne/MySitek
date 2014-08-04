<?php
$function = function ($class)
    {
        $class = str_replace('\\', '/', $class);
        echo '[AUTOLOAD] : ' . __DIR__ . "/$class.php\n";
        require_once __DIR__ . "/$class.php";
    };

spl_autoload_register($function, true, true);

    
echo "Test :\n\n";
\Namespace3\Classe1::whoAmI();

use Namespace1\Classe2;

Classe2::whoAmI();

Classe2::whoIsShe();

Classe2::whoIsShe2();