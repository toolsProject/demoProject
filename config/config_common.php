<?php
/*
 * define path
*/
define('INCLUDE_ROOT', dirname(dirname(__FILE__)) . '/');
define('INCLUDE_LOG_ROOT', INCLUDE_ROOT . 'log/');
define('INCLUDE_RESOURCE_ROOT', INCLUDE_ROOT . 'resource/');
define('INCLUDE_TMP_ROOT', INCLUDE_ROOT . 'tmp/');
define('INCLUDE_DATA_ROOT', INCLUDE_ROOT . 'data/');
require_once INCLUDE_ROOT . 'config/config.php';
include_once(INCLUDE_ROOT . 'func/Common.func.php');
include_once(INCLUDE_ROOT . 'config/innerUrlList.php');
spl_autoload_register('loadClass');
if (!defined('LOG_LEVEL')) {
    if (defined('ENVIRONMENT')) {
        if ('production' == ENVIRONMENT) {
            define('LOG_LEVEL', E_ALL & ~E_DEPRECATED & ~E_STRICT);
        } elseif ('local' == ENVIRONMENT) {
            define('LOG_LEVEL', E_ALL);
        } else {
            define('LOG_LEVEL', E_ALL);
        }
    } else {
        define('LOG_LEVEL', E_ALL);
    }
} else {
    // do nothing
}

