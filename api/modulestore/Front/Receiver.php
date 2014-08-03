<?php

namespace Front;

use Logs\Logger;
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
     * @return array Information en Json et Url cible
     * 
     * @throws ReceptionException
     * 
     * @see \JsonSerializable
     */
    public static function receive($jsonElement) {

        $receivedData = json_decode($jsonElement, true);

        try {
            $url = $this->getUrlFormJson($receivedData);
            $service = $this->getServiceFromData($receivedData);
        } catch (ReceptionException $ex) {
            Logger::logMessage($ex->getMessage());
            throw $ex;
        }
        try {
            $infos['infos'] = json_encode($service->getInfos());
        } catch (Exception $ex) {
            Logger::logMessage($ex->getMessage());
            $infos['infos'] = json_encode(array('error' => $ex->getMessage()));
        }
        $infos['url'] = $url;
        
        return $infos;
    }

    /**
     * @param array $receivedData Les données à traiter
     * 
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
    
    /**
     * 
     * @param array $receivedData Les données à traiter
     * 
     * @return string L'Url de l'émetteur du message
     * 
     * @throws ReceptionException
     */
    protected function getUrlFormJson(array $receivedData) {
        $url = $receivedData['url'];
        if (empty($url)) {
            throw new ReceptionException("Url non trouvée dans l'élément Json");
        }
        return $url;
    }
}
