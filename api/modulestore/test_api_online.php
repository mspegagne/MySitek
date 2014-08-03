<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT, 'http://api.mysitek.com/modulestore/public/');
curl_setopt($ch, CURLOPT_RETURNTRANSFERT, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$content = curl_exec($ch);

var_dump($content);

$reponse = curl_getinfo($ch);

var_dump($reponse);

curl_close($ch);
