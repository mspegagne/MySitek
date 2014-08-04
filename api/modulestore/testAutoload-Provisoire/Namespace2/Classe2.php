<?php

namespace Namespace2;

class Classe2 {
    public static function whoAmI(){
        echo 'I am : \n'
        . 'Class : ' . __CLASS__ . '\n'
        . 'Namespace : ' . __NAMESPACE__ . '\n'
        . 'Dir : ' . __DIR__ . '\n';
    }
}
