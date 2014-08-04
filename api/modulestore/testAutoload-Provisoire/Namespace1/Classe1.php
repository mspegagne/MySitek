<?php

namespace Namespace1;

class Classe1 {
    public static function whoAmI(){
        echo "I am : \n"
        . "Class : " . __CLASS__ . "\n"
        . "Namespace : " . __NAMESPACE__ . "\n"
        . "Dir : " . __DIR__ . "\n";
    }
}
