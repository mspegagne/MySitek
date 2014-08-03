<?php

namespace Front;

abstract class Sender {
    
    public static function send($url, $json) {
        $this->sendJsonRequest($json, $url);
    }

    protected function sendJsonRequest($json, $url) {

        /**
         * @todo Compléter cette classe
         */
        //$blogID = '8070105920543249955';
        //$authToken = 'OAuth 2.0 token here';
        // The data to send to the API
        $postData = array(
            //'blog' => array('id' => $blogID),
            'title' => 'Answer',
            'content' => $json
        );

        // Create the context for the request
        $context = stream_context_create(array(
            'http' => array(
                // http://www.php.net/manual/en/context.http.php
                'method' => 'POST',
                //'header' => "Authorization: {$authToken}\r\n" .
                "Content-Type: application/json\r\n",
                'content' => json_encode($postData)
            )
        ));

        // Send the request
        $response = file_get_contents($url, FALSE, $context);

        /* Check for errors
          if ($response === FALSE) {
          die('Error');
          }

          // Decode the response
          $responseData = json_decode($response, TRUE);

          // Print the date from the response
          echo $responseData['published'];
         */
    }
}
