<?php

class Token {

    private $token;

    public function __construct($list) {

        $this->token = Token::calcul($list);
    }

    private static function calcul($list) {
        //TODO : conversion list -> token
        $token = $list;
        return $token;
    }

    private static function getList() {

        $token = $this->getToken();
        //TODO : conversion token -> list
        $list = '';
        return $list;
    }

    public function getToken() {

        return $this->token;
    }

    public function setToken($value) {

        $this->token = $value;
    }

    public function update($module) {

        $token = Token::calcul(array_push($this->getList(), $module));
        $this->setToken($token);
    }

}
