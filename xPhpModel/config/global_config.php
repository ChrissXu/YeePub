<?php

//$XCONFIGSVRPHP_ID = 1;
if (file_exists(__DIR__ . '/not_git.php')) {
    require_once 'not_git.php';
    global $XCONFIGSVRPHP_ID;
} else {
    $XCONFIGSVRPHP_ID = 0;
}

switch ($XCONFIGSVRPHP_ID) {
    case 1:
 
        break;
 
    default:
        require_once "xconfigsvr_config.php";
 
}

$ok = @session_start();
if (!$ok) {
    session_regenerate_id(true); // replace the Session ID
    session_start();
}
header("Expires: Sat, 1 Jan 2005 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type:text/html;charset=utf-8");
// date_default_timezone_set('PRC'); //时区设置
error_reporting(E_ALL);
//error_reporting(0);
