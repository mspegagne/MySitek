<?php

$name = 'api.mysitek.com';//nom du site


$data = array(
	'json'=> json_encode(array("mode" => "one","type" => "module",array("hello")))		
);



$rh = curl_init($name);
curl_setopt ($rh , CURLOPT_POST , true);
curl_setopt ($rh , CURLOPT_HEADER , true);
curl_setopt ($rh , CURLOPT_POSTFIELDS , $data);
curl_setopt ($rh , CURLOPT_RETURNTRANSFER , true);

$reponse = curl_exec($rh);

echo $reponse;