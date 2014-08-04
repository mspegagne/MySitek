<?php

namespace Front;

use Logs\Logger;
use Front\Helper\OneModeHelper;
use Front\Helper\ManyModeReceiver;
use Service\AbstractService;

class Receiver {
    
    /**
     * @var string Un élément Json
     */
    protected $json;
    
    /**
     * @param string $json L'élément Json reçu
     */
    public function __construct($json) {
        $this->json = $json;
    }

    /**
     * Methode permettant de récupérer la réponse associé à l'élément Json
     * donné lors de la construction de l'objet
     * 
     * @return string Elément Json réponse
     * 
     * @see \JsonSerializable
     */
    public function getAnswer() {
        $receivedData = json_decode($this->json, true);
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
                echo 'HERE : ' . __CLASS__ . ":" . __METHOD__ . "\n\n";
                $res = OneModeHelper::translate($receivedData);
            case "many":
                return ManyModeReceiver::translate($receivedData);
            default :
                throw new ReceptionException("Mode inconnu pour l'élément Json");
        }
    }
}
