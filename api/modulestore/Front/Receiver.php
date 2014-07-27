<?php

namespace Front;

use Front\Helper\OneModeHelper;
use Front\Helper\ManyModeReceiver;
use Service\AbstractService;

class Receiver {

    /**
     * Methode permettant de receptionner un element Json et de le rediriger
     * vers les methodes de traitement adapté
     * 
     * @param string $jsonElement
     * 
     * @throws ReceptionError
     * 
     * @see \JsonSerializable
     */
    public static function receive($jsonElement) {

        $receivedData = json_decode($jsonElement, true);

        $service = $this->getServiceFromData($receivedData);
        
        // TODO $service
    }
    
    /**
     * @param array $receivedData Les données à traiter
     * @return AbstractService Le service adapté pour traiter la chaine Json
     * 
     * @throws ReceptionError
     */
    protected function getServiceFromData(array $receivedData) {
        $mode = $receivedData['mode'];

        if (empty($mode)) {
            throw new ReceptionException("Mode non trouvé dans l'élément Json");
        }

        switch ($mode) {
            case "one":
                return OneModeHelper::translate($receivedData);
            case "many":
                return ManyModeReceiver::translate($receivedData);
            default :
                throw new ReceptionException("Mode inconnu pour l'élément Json");
        }
    }
}
