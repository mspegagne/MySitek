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

$email = substr(clearPost($_POST['InputEmail']), 0, 200);
//$file = 'contact_email';

$handle = fopen($file, 'a');
$date = date("d-m-Y-H:i:s");
//fwrite($handle, "$date\n");

//fwrite($handle, "Email : $email\n");
//fwrite($handle, "\n--------------------------------------\n");
//fclose($handle);
mail("contact@mysitek.com", "[SiteVitrine-Email] Nouveau email enregistré", "$date\nEmail : $email\n");
    
header('Location: /index.php?succeed=1');