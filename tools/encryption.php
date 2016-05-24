<?php
require_once dirname(dirname(__FILE__)) . "/config/config_common.php";

$ciphertext = Common::encryptString('34filoveyou');
Common::debugNoDie($ciphertext);
Common::debug(Common::decryptString($ciphertext));