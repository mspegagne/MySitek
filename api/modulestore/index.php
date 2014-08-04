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
        return $receiver->getAnswer();
    }
}

$welcome = new Welcome($_POST['json']);

if (!$welcome->isJsonOk()) {
    echo 'Vous vous trouvez actuellement sur une API. Les connexions directes ne sont pas prises en compte.';
    return;
}

date_default_timezone_set('Europe/Paris');

spl_autoload_register(
    function ($class) {
        $class = str_replace('\\', '/', $class);
        echo '[AUTOLOAD] : ' . __DIR__ . "/$class.php\n";
        require_once __DIR__ . "/$class.php";
    },
    true,
    true);

echo "Answer :\n";
$answer = $welcome->getAnswer();
