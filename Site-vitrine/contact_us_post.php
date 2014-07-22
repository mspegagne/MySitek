<?php

function clearPost($word) {
    $new_word = '';
    $i = 0;
    while (isset($word[$i])) {
        if ($word[$i] === '<' || $word[$i] === '>') {
            $new_word .= '_';
        } else {
            $new_word .= $word[$i];
        }
        $i++;
    }
    return $new_word;
}

$result['name'] = $_POST['InputName'];
$result['email'] = $_POST['InputEmail'];
$result['message'] = $_POST['InputMessage'];
$result['test'] = (int) $_POST['InputReal'];
//$file = 'contact_info';

if ($result['test'] === 7) {
    //$handle = fopen($file, 'a');
    $date = date("d-m-Y-H:i:s");
    //fwrite($handle, "$date\n");
    
    $message = "$date\n";
    foreach ($result as $key => $element) {
        $element = substr(clearPost($element), 0, 2000);
        $message .= "$key : $element\n";
        //fwrite($handle, "$key : $element\n");
    }
    mail("contact@mysitek.com", "[SiteVitrine-Contact] Nouveau message", $message);
    //fwrite($handle, "\n--------------------------------------\n");
    //fclose($handle);
    $succeed  = 1;
    include_once 'contact_us.php';
} else {
    $succeed = 2;
    include_once 'contact_us.php';
}