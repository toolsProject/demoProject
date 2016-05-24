<?php
/*
 * define path
*/
define('INCLUDE_ROOT', dirname(dirname(__FILE__)) . '/');
define('INCLUDE_LOG_ROOT', INCLUDE_ROOT . 'log/');
define('INCLUDE_RESOURCE_ROOT', INCLUDE_ROOT . 'resource/');
define('INCLUDE_TMP_ROOT', INCLUDE_ROOT . 'tmp/');
define('INCLUDE_DATA_ROOT', INCLUDE_ROOT . 'data/');
define('DEBUG_MODE', false);
require_once INCLUDE_ROOT . "config/config.php";

require_once INCLUDE_ROOT . "config/config.php";

include_once(INCLUDE_ROOT . "func/Common.func.php");
spl_autoload_register('loadClass');

