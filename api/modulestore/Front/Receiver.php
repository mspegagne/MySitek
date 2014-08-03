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
            $service = $this->getServiceFromData($receivedData);
            $jsonAnswer = json_encode($service->getInfos());
        } catch (Exception $ex) {
            Logger::logMessage($ex->getMessage());
            return json_encode(array('error' => $ex->getMessage()));
        }
        
        return $jsonAnswer;
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
}
