<?php

date_default_timezone_set('Europe/Paris');

set_include_path(implode(PATH_SEPARATOR, array(realpath(realpath(dirname(__FILE__)) . '/api'), get_include_path())));

require_once './api/Front/Receiver.php';
require_once './api/Front/ReceptionException.php';
require_once './api/Front/Helper/OneModeReceiver.php';
require_once './api/Front/Helper/ManyModeReceiver.php';

require_once './api/Service/AbstractService.php';
require_once './api/Service/InvalidException.php';
require_once './api/Service/ManyAbstractService.php';
require_once './api/Service/ManyModuleService.php';
require_once './api/Service/ManyThemeService.php';
require_once './api/Service/OneAbstractService.php';
require_once './api/Service/OneModuleService.php';
require_once './api/Service/OneThemeService.php';