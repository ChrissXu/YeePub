<?php

//general err
define('XBOX_SUC', 1);      //成功
define('XBOX_FIL', 0);      //失败

//xBox
define('XBOX_LACK_PARAM', 2000);






//MongoDB ERR
define('MONGODBERR_SUCCESS',1);//操作成功
define('MONGODBERR_INSERT_AT_UPDATE',2);//更新时 约束不同 改为插入
define('MONGODBERR_UPDATE_AT_INSERT',3);//插入时 约束相同 改为更新
define('MONGODBERR_SUCCESS_FLAG',100);//成功的标识
define('MONGODBERR_CONNECT_FAIL',10000);//MongoDB 连接错误
define('MONGODBERR_QUERY_FAIL',10001);//MongoDB 查询错误   
define('MONGODBERR_INSERT_FAIL',10002);//MongoDB 插入错误
define('MONGODBERR_UPDATE_FAIL',10003);//MongoDB 更新失败
define('MONGODBERR_NO_INDEX',10004);//数据不存在相关索引
define('MONGODBERR_DATA_FORMAT_ERR',10005);//数据格式错误




define('ERRJSON_GETINFO_MINUS_1','{"code":"-1","msg":"get info fail"}');
define('ERRJSON_1001','{"code":"1001","msg":"The parameter is empty"}');
