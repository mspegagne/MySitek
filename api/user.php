<?php

class User {

    private $token;
    private $key;
    private $mail;

    public function __construct($mail) {

        //TODO recup key et token actuel en bdd where $mail
        $token = '';
        $key = '';
        $this->token = $token;
        $this->key = $key;
        $this->mail = $mail;
    }

    private function getKey() {

        return $this->key;
    }

    private function getToken() {

        return $this->token;
    }

    private function getMail() {

        return $this->mail;
    }

    private function setKey($value) {

        $this->key = $value;
    }

    private function setToken($value) {

        $this->token = $value;
    }

    private function setMail($value) {

        $this->mail = $value;
    }

    // -----------------------------------------
    // crypte une chaine (via une clé de cryptage)
    // -----------------------------------------
    private static function crypter($maCleDeCryptage = "", $maChaineACrypter) {
        if ($maCleDeCryptage == "") {
            $maCleDeCryptage = $GLOBALS['PHPSESSID'];
        }
        $maCleDeCryptage = md5($maCleDeCryptage);
        $letter = -1;
        $newstr = '';
        $strlen = strlen($maChaineACrypter);
        for ($i = 0; $i < $strlen; $i++) {
            $letter++;
            if ($letter > 31) {
                $letter = 0;
            }
            $neword = ord($maChaineACrypter{$i}) + ord($maCleDeCryptage{$letter});
            if ($neword > 255) {
                $neword -= 256;
            }
            $newstr .= chr($neword);
        }
        return base64_encode($newstr);
    }

    // -----------------------------------------
    // décrypte une chaine (avec la même clé de cryptage)
    // -----------------------------------------
    private static function decrypter($maCleDeCryptage = "", $maChaineCrypter) {
        if ($maCleDeCryptage == "") {
            $maCleDeCryptage = $GLOBALS['PHPSESSID'];
        }
        $maCleDeCryptage = md5($maCleDeCryptage);
        $letter = -1;
        $newstr = '';
        $maChaineCrypter = base64_decode($maChaineCrypter);
        $strlen = strlen($maChaineCrypter);
        for ($i = 0; $i < $strlen; $i++) {
            $letter++;
            if ($letter > 31) {
                $letter = 0;
            }
            $neword = ord($maChaineCrypter{$i}) - ord($maCleDeCryptage{$letter});
            if ($neword < 1) {
                $neword += 256;
            }
            $newstr .= chr($neword);
        }
        return $newstr;
    }

    public function calculToken($list) {

        $key = $this->getKey();
        $token = crypter($key, $list);
        return $token;
    }

    public function getList() {

        $token = $this->getToken();
        $key = $this->getKey();
        $list = decrypter($key, $token);
        return $list;
    }

    public function updateToken($module, $type) {

        $token = $this->calculToken(array_push($this->getList(), array($module => $type)));
        $this->setToken($token);
        //TODO : enregistrer en bdd nvl valeurs
    }

}
