<?php

namespace MySitek\Service\Helper;

class ApiCommunicationHelper {

    /**
     * @var string 
     */
    protected $apiUrl;
    
    /**
     * @var Curl Handle 
     */
    protected $curlConnexion;

    /**
     * @param string $apiUrl
     */
    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @param array $data
     * @return array Réponse de l'API
     * 
     * @throws Exception\ApiConnexionException
     */
    public function sendDataToApi(array $data)
    {
        
        $dataForApi = array('json'=> json_encode($data));
        $this->prepareConnexion();
        curl_setopt($this->curlConnexion, CURLOPT_POSTFIELDS, $dataForApi);
        $reponse = curl_exec($this->curlConnexion);
        if (!$reponse) {
            throw new Exception\ApiConnexionException();
        }
        curl_close($this->curlConnexion);
        return json_decode($reponse, true);
    }

    protected function prepareConnexion()
    {
        $this->curlConnexion = curl_init($this->apiUrl);
        curl_setopt($this->curlConnexion, CURLOPT_POST, true);
        curl_setopt($this->curlConnexion, CURLOPT_HEADER, false);
        curl_setopt($this->curlConnexion, CURLOPT_RETURNTRANSFER, true);
    }
}
