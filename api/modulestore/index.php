<?php

/**
 * @todo Gestion de la réception / envoi des requetes Json
 */

if (empty($_POST['url'])) {
    echo 'Vous vous trouvez actuellement sur une API. Les connexions directes ne sont pas prises en compte.';
    return;
}
echo 'Bienvenue';