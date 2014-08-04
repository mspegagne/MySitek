<?php

header('Content-Type: text/plain'); //pour que la réponse s'affiche comme du texte brut
$name = 'api.mysitek.com';//nom du site

$json = json_encode(array("mode" => "one", "type" => "module",array("hello")));
$data = 'json=' . $json;
 
//la requête
$envoi  = "POST / HTTP/1.1\r\n";
$envoi .= "Host: ".$name."\r\n";
$envoi .= "Connection: Close\r\n";
$envoi .= "Content-type: application/x-www-form-urlencoded\r\n";
$envoi .= "Content-Length: ".strlen($data)."\r\n\r\n";
$envoi .= $data."\r\n";
 
/*ouverture socket*/
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if($socket < 0){
   die('FATAL ERROR: socket_create() : " '.socket_strerror($socket).' "');
}
 
if (socket_connect($socket,gethostbyname($name),80) < 0){
   die('FATAL ERROR: socket_connect()');
}
 
/*envoi demande*/
if(($int = socket_write($socket, $envoi, strlen($envoi))) === false){
   die('FATAL ERROR: socket_write() failed, '.$int.' characters written');
}
 
/*lecture réponse*/
$reception = '';
while($buff = socket_read($socket, 2000)){
   $reception.=$buff;
}
/*$startAnswer = strpos($reception, $startJson);
$endAnswer = strpos($reception, $endJson);
$shortAnswer = substr($reception, $startAnswer+strlen($startJson), $endAnswer-$startAnswer-strlen($startJson));
echo $shortAnswer . "\n";*/
echo $reception;
 
socket_close($socket);