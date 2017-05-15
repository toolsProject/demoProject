<?php
define('ENVIRONMENT', 'local');
define('DEBUG_MODE', true);
define('TIME_ZONE', 'Asia/Shanghai');

define('INCLUDE_LOG_ROOT', INCLUDE_ROOT . 'log/');
define('ERROR_LOG_NAME', 'error.txt');
define('INCLUDE_DATA_ROOT', INCLUDE_ROOT . 'data/');
define('INCLUDE_TMP_ROOT', INCLUDE_ROOT . 'tmp/');

define('DB_ENCODING', 'UTF8');
define('DB_HOST', 'localhost');
define('DB_WHOST', 'localhost');
define('DB_NAME', 'demo');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_SOCKET', '/var/lib/mysql/mysql.sock');