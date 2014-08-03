<?php

$json = htmlspecialchars($_POST['json']);

if (empty($json)) {
    echo 'Vous vous trouvez actuellement sur une API. Les connexions directes ne sont pas prises en compte.';
    return;
}

/**
 * @todo Répondre par un simple affichage
 */
echo $json;
