<?php

namespace MySitek\Front;

class ReceiverTest extends \PHPUnit_Framework_TestCase
{
    protected $receiver;

    protected function setUp()
    {
        $data = json_encode(
            array(
                'mode' => 'one',
                'type' => 'module'
            )
        );
        $this->receiver = new Receiver($data);
    }
}
