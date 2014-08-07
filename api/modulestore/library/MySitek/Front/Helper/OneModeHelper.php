<?php

namespace MySitek\Front\Helper;

use MySitek\Front\ReceptionException;
use MySitek\Service\AbstractService;
use MySitek\Service\OneModuleService;
use MySitek\Service\OneThemeService;

abstract class OneModeHelper
{

    /**
     * Methode permettant de retourner un service en fonction des données
     * 
     * @param array $receivedData
     * @return AbstractService Le service associé aux données reçues
     * @throws ReceptionException
     */
    public static function translate(array $receivedData)
    {

        $type = $receivedData['type'];
        if (empty($type)) {
            throw new ReceptionException(
                "Type non trouvé dans l'élément Json"
            );
        }

        switch ($type) {
            case "module":
                return new OneModuleService($receivedData);
            case "theme":
                return new OneThemeService($receivedData);
            default:
                throw new ReceptionException(
                    "Type inconnu pour l'élément Json"
                );
        }
    }
}
