<?php

$json = htmlspecialchars($_POST['json']);

if (empty($json)) {
    echo 'Vous vous trouvez actuellement sur une API. Les connexions directes ne sont pas prises en compte.';
    return;
}

$translation = json_decode(str_replace('&quot;', '"', $json));

echo 'Version originale :';
var_dump($json);
echo 'Traduction :';

var_dump($translation);



/**
 * @todo Répondre par un simple affichage
 */
//echo $json;
