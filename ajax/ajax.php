<?php
require_once dirname(dirname(__FILE__)) . "/config/config_common.php";
error_reporting(LOG_LEVEL);

$action = trim(get_request_var('action'));
if (empty($action)) {
    $action = trim(get_request_var('act'));
}
switch ($action) {
    case 'rsynch-string-change':
        $choice = get_post_var('choice');
        $content = get_post_var('content');
        switch ($choice) {
            case 'en':
                echo Common::encryptString($content);
                break;
            case 'de':
                echo Common::decryptString($content);
                break;
            default:
                echo 'unkonw error';
                break;
        }
        exit;
        break;
    default:
        echo 'null act';
        break;
}
exit;