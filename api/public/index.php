<?php

namespace Front;

use MySitek\Front\Receiver;

class Welcome
{

    private $json;

    public function __construct($json)
    {
        $this->json = str_replace('&quot;', '"', htmlspecialchars($json));
    }

    public function isJsonOk()
    {
        return !empty($this->json);
    }

    public function getAnswer()
    {
        $receiver = new Receiver($this->json);
        return $receiver->getAnswer();
    }
}

$json = filter_input(INPUT_POST, 'json');

$welcome = new Welcome($json);

if (!$welcome->isJsonOk()) {
    echo 'Vous vous trouvez actuellement sur une API. Les connexions directes ne sont pas prises en compte.';
    return;
}

echo $welcome->getAnswer();
