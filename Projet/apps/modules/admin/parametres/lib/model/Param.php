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
    public function __construct($ref) {

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
     * @brief Sauvegarde le param
     */
    public function save() {

        $ref = $this->getRef();
        $value = $this->getValue();

        $sql = "SELECT * FROM param WHERE ref = '" . $ref . "'";
        $retour = $app['db']->fetchAssoc($sql);

        if ($retour == '') {

            $sql = "INSERT INTO param (ref, value) VALUES (?,?)";
            $app['db']->executeUpdate($sql, array($ref, $value));
        } else {
            $sql = "UPDATE param SET value = '" . $value . "' WHERE lien = '" . $ref . "'";
            $app['db']->executeUpdate($sql, array());
        }
    }
    
    /**
     * @brief Sauvegarde le param
     */
    public static function saveParam($ref, $value) {

        $param = new Param($ref);
        $param->setValue($value);
        $param->save();
    }

}
