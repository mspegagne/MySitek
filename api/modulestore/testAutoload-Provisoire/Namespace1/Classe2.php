<?php

namespace Namespace1;

use Namespace2\Classe1;

class Classe2 {
    public static function whoAmI(){
        echo "I am : \n"
        . "  Class : " . __CLASS__ . "\n"
        . "  Namespace : " . __NAMESPACE__ . "\n"
        . "  Dir : " . __DIR__ . "\n";
    }
    
    public static function whoIsShe() {
        echo "{{WHOISSHE :\n";
        Classe1::whoAmI();
    }
    
    public static function whoIsShe2() {
        echo "{{WHOISSHE2 :\n";
        \Namespace3\Classe2::whoAmI();
    }
}
