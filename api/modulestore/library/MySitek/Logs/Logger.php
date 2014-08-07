<?php

namespace MySitek\Logs;

abstract class Logger
{
    public static function logMessage($message)
    {
        error_log($message . '\n', 3, 'api.log');
    }
}
