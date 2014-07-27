<?php

namespace Front\Helper;

use Front\ReceptionException;
use Service\AbstractService;
use Service\OneMixedService;
use Service\OneModuleService;
use Service\OneThemeService;

abstract class OneModeHelper {

    /**
     * @param array $receivedData
     * @return AbstractService Le service associé aux données reçues
     * @throws ReceptionException
     */
    public static function translate(array $receivedData) {

        $type = $receivedData['type'];

        if (empty($type)) {
            throw new ReceptionException("Type non trouvé dans l'élément Json");
        }

        switch ($type) {
            case "module":
                return new OneModuleService($receivedData);
            case "theme":
                return new OneThemeService($receivedData);
            case "mixed":
                return new OneMixedService($receivedData);
            default :
                throw new ReceptionException("Type inconnu pour l'élément Json");
        }
    }
}
