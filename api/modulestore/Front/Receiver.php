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
        

        try {
            $url = $this->getUrlFormJson($receivedData);
            $service = $this->getServiceFromData($receivedData);
        } catch (ReceptionException $ex) {
            // Logger l'exception
            return json_encode(array('error' => $ex->getMessage()));
        }
        try {
            $infos = $service->getInfos();
            $infos['url'] = $url;
        } catch (Exception $ex) {
            // Logger l'exception
            return json_encode(array('error' => $ex->getMessage()));
        }
        
        return json_encode($infos);
    }

    /**
     * @param array $receivedData Les données à traiter
     * @return AbstractService Le service adapté pour traiter la chaine Json
     * 
     * @throws ReceptionException
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
    
    protected function getUrlFormJson(array $receivedData) {
        $url = $receivedData['url'];
        if (empty($mode)) {
            throw new ReceptionException("Url non trouvée dans l'élément Json");
        }
        return $url;
    }
}
