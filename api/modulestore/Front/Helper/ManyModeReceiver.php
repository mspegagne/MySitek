<?php

namespace Front\Helper;

use Front\ReceptionException;
use Service\AbstractService;
use Service\ManyMixedService;
use Service\ManyModuleService;
use Service\ManyThemeService;

abstract class ManyModeReceiver {
    
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
                return new ManyModuleService($receivedData);
            case "theme":
                return new ManyThemeService($receivedData);
            case "mixed":
                return new ManyMixedService($receivedData);
            default :
                throw new ReceptionException("Type inconnu pour l'élément Json");
        }
    }
}
