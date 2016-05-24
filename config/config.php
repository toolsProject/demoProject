<?php
$iniFile = INCLUDE_ROOT . 'config/account.ini';
$configArray = parse_ini_file($iniFile, true);
$environmentPostfix = isset($configArray['ENVIRONMENT']['configPostfix']) ? trim($configArray['ENVIRONMENT']['configPostfix']) : 'local';
$constFile = INCLUDE_ROOT . "config/config_{$environmentPostfix}.php";
if(file_exists($constFile)) {
    require_once $constFile;
} else {
    die('illegal request');
}