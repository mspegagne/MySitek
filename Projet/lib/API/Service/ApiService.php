<?php

namespace MySitek\Service;

use MySitek\Service\Helper\ApiCommunicationHelper;

class ApiService {

    /**
     * @var ApiCommunicationHelper 
     */
    protected $apiHelper;

    /**
     * @param string $apiUrl
     */
    public function __construct($apiUrl)
    {
        $this->apiHelper = new ApiCommunicationHelper($apiUrl);
    }

    /**
     * 
     * @param string $name
     * @return array Le module demandé
     * 
     * @throws Exception\ApiErrorException
     */
    public function getOneModule($name)
    {
        $data = array(
            "mode" => "one",
            "type" => "module",
            "name" => $name
        );
        $reponse = $this->apiHelper->sendDataToApi($data);
        $error = isset($reponse['error']);
        if ($error) {
            throw new Exception\ApiErrorException($reponse['error']);
        }
        return $reponse;
    }
}
