<?php

require_once '../config/err.php';
require_once "../config/global_config.php";
require_once "db.php";

//log
if(PHP_OS=='Linux')
{
    $GLOBALS['xConfigSvrPhpLogPath']='/data/logs/xConfigSvrPhp/';
    $GLOBALS['xConfigSvrPhpErrLogPath']='/data/logs/xConfigSvrPhp/';
}
//因为windows有好多版本，且操作系统很多，这里先分为linux和非linux
else
{
    $GLOBALS['xConfigSvrPhpLogPath']='D:/xConfigSvrPhp/logs/';
    $GLOBALS['xConfigSvrPhpErrLogPath']='D:/xConfigSvrPhp/dbLogs/';
}

function AddConfigSvrPHPInfoLog($str)
{
    $date=date("Y-m-d");
    $dir=$GLOBALS['xConfigSvrPhpLogPath'];
    if(!is_dir($dir)) 
    {
        mkdir($dir,0777);
    }
    file_put_contents($dir . "xConfigSvr-info-$date.log", ' ' . $date . " " . date("H:i:s") . "\t" . ' ' . $str . "\n", FILE_APPEND | LOCK_EX);
}

function AddConfigSvrPHPErrLog($str)
{
    $date=date("Y-m-d");
    $dir=$GLOBALS['xConfigSvrPhpLogPath'];
    if(!is_dir($dir))
    {
        mkdir($dir,0777);
    }
    file_put_contents($dir . "xConfigSvr-err-$date.log", ' ' . $date . " " . date("H:i:s") . "\t" . ' ' . $str . "\n", FILE_APPEND | LOCK_EX);
}

function AddConfigSvrPHPDBErrLog($str)
{
    $date=date("Y-m-d");
    $dir=$GLOBALS['xConfigSvrPhpErrLogPath'];
    if(!is_dir($dir))
    {
        mkdir($dir,0777);
    }
    file_put_contents($dir . "xConfigSvr-db-err-$date.log", ' ' . $date . " " . date("H:i:s") . "\t" . ' ' . $str . "\n", FILE_APPEND | LOCK_EX);
}

 
