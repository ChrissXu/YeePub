<?php
require_once "../lib/common_lib.php";
header("Access-Control-Allow-Origin:*");

 
$appid=$_GET["appid"];

testApi($appid);


/**
 *  function介绍
 * 
 *  参数介绍
 *  appid:项目id
 * 
 *  Post/Get 举例:   119.29.104.62:100/xConfigSvrPhp/api/testApi.php?appid=24
 */
function testApi($appid){
 
    echo $appid;
}







