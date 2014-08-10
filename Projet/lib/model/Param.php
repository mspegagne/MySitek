<?php

/**
 * @brief Classe de gestion des parametres
 *
 */
class Param {

    private $ref;
    private $value;

    /**
     * @brief Constructeur à partir de la ref
     * @param String $ref reference du param en bdd
     * @return Param avec la valeur
     */
    public function __construct($ref, $app) {

        $sql = "SELECT * FROM param WHERE ref = '" . $ref . "'";
        $retour = $app['db']->fetchAssoc($sql);

        if ($retour == '') {

            $this->ref = $ref;
            $this->value = '';
        } else {

            $this->ref = $ref;
            $this->value = $retour['value'];
        }
    }

    /**
     * @brief Retourne la ref du param en cours
     * @return $this->ref
     */
    private function getRef() {

        return $this->ref;
    }

    /**
     * @brief Retourne la valeur du param en cours
     * @return $this->value
     */
    private function getValue() {

        return $this->value;
    }

    /**
     * @brief Met à jour la ref
     * @param String $value
     */
    public function setRef($value) {

        $this->ref = $value;
    }

    /**
     * @brief Met à jour la valeur du param
     * @param String $value
     */
    public function setValue($value) {

        $this->value = $value;
    }

    /**
     * @brief Sauvegarde la valeur à la ref donnee
     * @param Array $array
     * @param App $app
     * @return String $response confirmation envoi
     */
    public static function saveParams($array, $app) {

        $sql = "UPDATE param SET value = ? WHERE ref = ?";

        $response = 'Erreur';

        foreach ($array as $ref => $value) {
            if ($app['db']->executeUpdate($sql, array($value, $ref))) {
                $response = 'Les données ont bien été enregistrées';
            } else {
                $response = 'Erreur lors de l\'enregistrement...';
            }
        }
        return $response;
    }

    /**
     * @brief Sauvegarde la valeur à la ref donnee
     * @param String $ref
     * @param String value
     * @param App $app
     * @return String $response confirmation envoi
     */
    public static function saveParam($ref, $value, $app) {

        $sql = "SELECT * FROM param WHERE ref = '" . $ref . "'";
        $retour = $app['db']->fetchAssoc($sql);

        $response = 'Erreur...';

        if ($retour == '') {

            $sql = "INSERT INTO param (ref, value) VALUES (?,?)";
            if ($app['db']->executeUpdate($sql, array($ref, $value))) {
                $response = 'Le mot de passe a bien été enregistré';
            } else {
                $response = 'Erreur lors de l\'enregistrement...';
            }
        } else {

            $sql = "UPDATE param SET value = ? WHERE lien = ?";
            if ($app['db']->executeUpdate($sql, array($value, $ref))) {
                $response = 'Le mot de passe a bien été enregistré';
            } else {
                $response = 'Erreur lors de l\'enregistrement...';
            }
        }

        return $response;
    }

    /**
     * @brief Sauvegarde le nouveu mail temporairement et envoie mail confirm
     * @param String $mail
     * @param App $app
     * @return String $response confirmation envoi
     */
    public static function saveMail($mail, $app) {
        
    }

    /**
     * @brief Sauvegarde le nouveu mail temporairement et envoie mail confirm
     * @param String $mail
     * @param App $app
     * @return String $response confirmation envoi
     */
    public static function savePwd($old_pwd, $new_pwd, $new_pwd2, $app) {

        $response = 'Erreur...';

        $token = $app['security']->getToken();
        $user = $token->getUser();
        $username = $user->getUsername();
        $old_pwd_bdd = $user->getPassword();

        $crypt_old = (new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder())->encodePassword($old_pwd, '');

        if ($crypt_old == $old_pwd_bdd) {

            if ($new_pwd == $new_pwd2) {

                $crypt = (new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder())->encodePassword($new_pwd, '');

                $sql = "UPDATE users SET password = ? WHERE username = ?";
                if ($app['db']->executeUpdate($sql, array($crypt, $username))) {
                    $response = 'Le mot de passe a bien été enregistré';
                } else {
                    $response = 'Erreur lors de l\'enregistrement...';
                }
            } else {
                $response = 'Les mots de passes ne sont pas identiques';
            }
        } else {
            $response = 'L\'ancien mot de passe ne correspond pas...';
        }
        return $response;
    }

    /**
     * @brief Charge tous les params dans l'application
     */
    public static function load($app) {

        $sql = "SELECT * FROM param";
        $retour = $app['db']->fetchAll($sql);

        foreach ($retour as $param) {
            $ref = $param['ref'];
            $value = $param['value'];
            $app[$ref] = $value;
        }
    }

}
