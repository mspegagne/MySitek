<?php

namespace MySitek\Front\Helper;

use MySitek\Front\ReceptionException;
use MySitek\Service\AbstractService;
use MySitek\Service\ManyModuleService;
use MySitek\Service\ManyThemeService;

abstract class ManyModeHelper
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
                return new ManyModuleService($receivedData);
            case "theme":
                return new ManyThemeService($receivedData);
            default:
                throw new ReceptionException(
                    "Type inconnu pour l'élément Json"
                );
        }
    }
}
