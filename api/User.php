<?php


/**
 * @brief Classe de gestion des utilisateurs et des tokens associés
 *
 */ 
class User {

    private $token;
    private $key;
    private $mail;

    /**
    * @brief Constructeur à partir de l'email (identifiant unique)
    * @param String $mail mail de l'user
    * @return User avec les param associés
    */  
    public function __construct($mail) {

        //TODO recup key et token actuel en bdd where $mail
        $token = '';
        $key = '';
        $this->token = $token;
        $this->key = $key;
        $this->mail = $mail;
    }
    
    /**
    * @brief Edite une nouvelle key, calcule le token à partir de la liste et enregistre
    * @param String $mail mail de l'user
    * @param Array of Modules $list
    */ 
    public static function newUser($mail, $list) {

        $key = uniqid(rand());
        $token = User::calculNewToken($list, $key);
        //TODO save tout ca en bdd
    }  
    
    /**
    * @brief Retourne la key de l'User en cours
    * @return $this->key
    */  
    private function getKey() {

        return $this->key;
    }

    /**
    * @brief Retourne le token de l'User en cours
    * @return $this->token
    */
    private function getToken() {

        return $this->token;
    }

    /**
    * @brief Retourne le mail de l'User en cours
    * @return $this->mail
    */
    private function getMail() {

        return $this->mail;
    }

    /**
    * @brief Met à jour la valeur de la key
    * @param String $value
    */
    private function setKey($value) {

        $this->key = $value;
    }

    /**
    * @brief Met à jour la valeur du token
    * @param String $value
    */
    private function setToken($value) {

        $this->token = $value;
    }

    /**
    * @brief Met à jour la valeur du mail
    * @param String $value
    */
    private function setMail($value) {

        $this->mail = $value;
    }

    /**
    * @brief Crypte une chaine (via une clé de cryptage)
    * @param String $maCleDeCryptage key de l'user
    * @param String $maChaineACrypter liste des modules de l'user
    * @return Token
    */
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

    /**
    * @brief Decrypte une chaine (avec la même clé de cryptage)
    * @param String $maCleDeCryptage key de l'user
    * @param String $maChaineCrypter token de l'user
    * @return Liste des modules de l'user
    */
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

    /**
    * @brief Calcul du token à partir de la liste des modules
    * @param Array of Modules $list Liste des modules de l'user
    * @return Token associé
    */
    public function calculToken($list) {

        $key = $this->getKey();
        $token = crypter($key, $list);
        return $token;
    }
    
    /**
    * @brief Calcul du token à partir de la liste des modules et d'une key
    * @param Array of Modules $list Liste des modules de l'user 
    * @param $key Key à utiliser pour le cryptage
    * @return Token associé
    */
    public static function calculNewToken($list, $key) {

        $token = crypter($key, $list);
        return $token;
    }

    /**
    * @brief Retourne la liste des modules de l'user
    * @return Liste des modules associés au token
    */
    public function getList() {

        $token = $this->getToken();
        $key = $this->getKey();
        $list = decrypter($key, $token);
        return $list;
    }

    /**
    * @brief Maj Token en bdd après installation d'un nouveau module
    * @param $module Nom du module 
    * @param $type Type du module, templates ou modules
    */
    public function updateToken($module, $type) {

        $token = $this->calculToken(array_push($this->getList(), array($module => $type)));
        $this->setToken($token);
        //TODO : enregistrer en bdd nvl valeurs
    }

    /**
    * @brief Verfication anti-piratage, comparaison nos bdd et celui chez le client
    * @param $token Token fourni
    * @return Boolean TRUE si token ok
    */
    public function checkToken($token) {

        $tokenuser = $this->getToken();
        if ($tokenuser == $token) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
