<?php

namespace Front;

use Front\Receiver;

class Welcome {
    
    private $json;

    public function __construct($json) {
        $this->json = str_replace('&quot;', '"', htmlspecialchars($json));
    }
    
    public function isJsonOk() {
        return !empty($this->json);
    }
    
    public function getAnswer() {
        $receiver = new Receiver($this->json);
        echo "Hey ! " . __CLASS__ . ":" . __METHOD__ . "\n\n";
        return $receiver->getAnswer();
    }
}

$welcome = new Welcome($_POST['json']);

if (!$welcome->isJsonOk()) {
    echo 'Vous vous trouvez actuellement sur une API. Les connexions directes ne sont pas prises en compte.';
    return;
}

require_once 'app.php';

echo "Answer :\n";
$answer = $welcome->getAnswer();

/**
 * @todo Regler le problème d'import 
 */
