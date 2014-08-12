<?php

namespace MySitek\Front;

use MySitek\Logs\Logger;
use MySitek\Service;

class Receiver
{
    /**
     * @var string Un élément Json
     */
    protected $json;

    /**
     * @var array
     */
    protected $receivedData;

    /**
     * @param string $json L'élément Json reçu
     */
    public function __construct($json)
    {
        $this->json = $json;
        $this->receivedData = json_decode($this->json, true);
    }

    /**
     * Methode permettant de récupérer la réponse associé à
     * l'élément Json donné lors de la construction de l'objet
     * 
     * @return string Elément Json réponse
     * 
     * @see \JsonSerializable
     */
    public function getAnswer()
    {
        try {
            $this->verifyCorrectJsonDecode();
            $service = $this->getServiceFromData($this->receivedData);
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
     * @return Service\AbstractService Le service adapté
     * 
     * @throws \InvalidArgumentException
     */
    protected function getServiceFromData()
    {
        $requestType = $this->receivedData['request_type'];
        $this->verifyEmpty($requestType, 'Type de requete');

        switch ($requestType) {
            case "user":
                break;
            case "module_store":
                return $this->getServiceFromModuleStoreData();
        }
    }

    /**
     * @return Service\AbstractService
     * 
     * @throws \InvalidArgumentException
     */
    protected function getServiceFromModuleStoreData()
    {
        $argumentName = 'Mode';
        $mode = $this->receivedData['mode'];
        $this->verifyEmpty($mode, $argumentName);

        switch ($mode) {
            case "one":
                return $this->getServiceFromModuleOneModeStoreData();
            case "many":
                return $this->getServiceFromModuleManyModeStoreData();
            default:
                $this->throwUnknownException($argumentName);
        }
    }

    /**
     * Methode permettant de retourner un service en fonction des données
     * Dans le cas d'une requete ModuleStore de en mode "one"
     * 
     * @return Service\AbstractService Le service associé aux données reçues
     * 
     * @throws \InvalidArgumentException
     */
    protected function getServiceFromModuleOneModeStoreData()
    {
        $argumentName = 'Type';
        $type = $this->receivedData['type'];

        $this->verifyEmpty($type, $argumentName);
        switch ($type) {
            case "module":
                return new Service\OneModuleService($this->receivedData);
            case "theme":
                return new Service\OneThemeService($this->receivedData);
            default:
                $this->throwUnknownException($argumentName);
        }
    }

    /**
     * Methode permettant de retourner un service en fonction des données
     * Dans le cas d'une requete ModuleStore de en mode "many"
     *
     * @return Service\AbstractService Le service associé aux données reçues
     * @throws \InvalidArgumentException
     */
    protected function getServiceFromModuleManyModeStoreData()
    {
        $argumentName = 'Type';
        $type = $this->receivedData['type'];

        $this->verifyEmpty($type, $argumentName);

        switch ($type) {
            case "module":
                return new Service\ManyModuleService($this->receivedData);
            case "theme":
                return new Service\ManyThemeService($this->receivedData);
            default:
                $this->throwUnknownException($argumentName);
        }
    }

    /**
     * Verifie si le decodage de la chaine s'est deroule correctement
     * 
     * @throws \InvalidArgumentException
     */
    protected function verifyCorrectJsonDecode()
    {
        if ($this->receivedData === null) {
            throw new \InvalidArgumentException(
                'La chaine Json n\'a pas pu etre decodee correctement'
            );
        }
    }

    /**
     * Vérifie si l'element est vide et renvoie une exception si c'est le cas
     * 
     * @param Mixed $element
     * @param string $name
     */
    protected function verifyEmpty($element, $name)
    {
        $empty = empty($element);
        if ($empty) {
            throw new \InvalidArgumentException(
                "$name non trouvé dans l'élément Json"
            );
        }
    }

    /**
     * Get Exception for Unknow argument
     * 
     * @param string $argumentName
     * @throws \InvalidArgumentException
     */
    protected function throwUnknownException($argumentName)
    {
        throw new \InvalidArgumentException(
            "$argumentName inconnu pour l'élément Json"
        );
    }
}
