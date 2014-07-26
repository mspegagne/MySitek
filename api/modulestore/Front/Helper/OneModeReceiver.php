<?php

namespace Front\Helper;

use Front\ReceptionException;
use Service\AbstractService;
use Service\OneModuleService;

abstract class OneModeHelper {

    /**
     * 
     * @param array $receivedArray
     * @return AbstractService Le service associé aux données reçues
     * @throws ReceptionException
     */
    public static function translate(array $receivedArray) {

        $type = $receivedArray['type'];

        if (empty($type)) {
            throw new ReceptionException("Type non trouvé dans l'élément Json");
        }

        switch ($type) {
            case "module":
                return new OneModuleService($receivedArray);
            case "theme":
                break;
            case "mixed":
                break;
            default :
                throw new ReceptionException("Type inconnu pour l'élément Json");
        }
    }
    
    protected static function moduleTranslation(array $receivedArray) {
        
    }
}
