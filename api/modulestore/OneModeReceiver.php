<?php

namespace Front\Helper;

use Front\ReceptionException;
use Service\AbstractService;
use Service\OneModuleService;
use Service\OneThemeService;

abstract class OneModeHelper {

    /**
     * Methode permettant de retourner un service adapté en fonction des données
     * 
     * @param array $receivedData
     * @return AbstractService Le service associé aux données reçues
     * @throws ReceptionException
     */
    public static function translate(array $receivedData) {

        $type = $receivedData['type'];
        echo "Hey ! " . __CLASS__ . ":" . __METHOD__ . "\n\n";
        if (empty($type)) {
            throw new ReceptionException("Type non trouvé dans l'élément Json");
        }

        switch ($type) {
            case "module":
                return new OneModuleService($receivedData);
            case "theme":
                return new OneThemeService($receivedData);
            default :
                throw new ReceptionException("Type inconnu pour l'élément Json");
        }
    }
}
