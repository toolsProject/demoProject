<?php
require_once dirname(dirname(__FILE__)) . "/config/config_common.php";
error_reporting(LOG_LEVEL);
$smartyObj = new SmartyExt();
//$ciphertext = Common::encryptString('34filoveyou');
//Common::debugNoDie($ciphertext);
//Common::debug(Common::decryptString($ciphertext));
$choiceArray = array(
    'en' => 'encryption',
    'de' => 'decryption',
);
$smartyObj->assign(
    array(
        'title' => 'En De Cryption',
        'choiceArray' => $choiceArray,
    )
);
$smartyObj->display('endeCryption.tpl');