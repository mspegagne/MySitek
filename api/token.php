<?php

class Token {

    private $token;
    private $key;

    public function __construct($mail) {

        //TODO recup key et token actuel en bdd
        $token = '';
        $key = '';
        $this->token = $token;
        $this->key = $key;
    }

    private function getKey() {

        return $this->key;
    }

    private function getToken() {

        return $this->token;
    }

    private function setKey($value) {

        $this->key = $value;
    }

    public function setToken($value) {

        $this->token = $value;
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

    private function calcul($list) {

        $key = $this->getKey();
        $token = crypter($key, $list);
        return $token;
    }

    private function getList() {

        $token = $this->getToken();
        $key = $this->getKey();
        $list = decrypter($key, $token);
        return $list;
    }

    private function update($module, $type) {

        $token = array_push($this->getList(), array($module => $type));
        $this->setToken($token);
        //TODO : enregistrer en bdd nvl valeurs
    }

}
