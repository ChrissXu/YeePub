<?php

require_once '../config/err.php';
require_once 'common_lib.php';
require_once '../config/global_config.php';

abstract class db_mysqli {
	protected $_conn; //单态连接

	protected $_error; //错误信息
	protected $_errno; //错误号
	protected $_perPageRecord; //每页显示几条数据
	protected $_currentTime;
	protected $_recordCount;
	public function __construct() {

	}

	//根据id查找一条记录
	public function findById($table, $id) {
		$sql = "select * from {$table} where id={$id}";
		return $this->uniqueQuery($sql);
	}
	// 连数据库
    abstract protected function _connect();

	//检查并执行查询
	private function _check_query($result, $sql) {
		if (!$result) {
			$this->_error = mysqli_error($this->_conn);
			$this->_errno = mysqli_errno($this->_conn);
			$this->_error("invalid SQL: " . $sql);
		}
	}
	//设置每页显示的数量(用于分页,当query的offset为空时,此值无用
	public function setPerPageRecord($perPageRecord) {
		$this->_perPageRecord = $perPageRecord;
	}
	//执行SQL并返回结果
	protected function _sendSQL($sql, $offset = false) {
		if (is_numeric($offset) && is_numeric($this->_perPageRecord)) {
			$sql = $sql . " limit {$offset}, " . $this->_perPageRecord;
		}
		$result = mysqli_query($this->_conn,$sql);

		$this->_check_query($result, $sql);
		return $result;
	}

//执行多条SQL并返回结果,如果第一个查询失败则返回 FALSE。      mysqli_multi_query 有问题，抛弃
//    public function multiSQL($sql, $offset = false) {
//        if (is_numeric($offset) && is_numeric($this->_perPageRecord)) {
//            $sql = $sql . " limit {$offset}, " . $this->_perPageRecord;
//        }
//        $result = mysqli_multi_query($this->_conn,$sql);
//        $this->_check_query($result, $sql);
//        return $result;
//    }

    public function  getsendSQL($sql, $offset = false){
			return $this->_sendSQL($sql,$offset);
	}

	//取得多条数据集
	public function query($sql, $offset = false) {
		$result = $this->_sendSQL($sql, $offset);
		$datas  = array();
		while ($row = mysqli_fetch_array($result)) {
			$datas[] = $row;
		}
		return $datas;
	}

	//取 rows[]
    public function query_return_rows($sql, $offset = false) {
        $result = $this->_sendSQL($sql, $offset);
   	 	$row = mysqli_fetch_array($result);
        return $row;
    }

	//取得记录总数,假如不分页
	public function getRecordCount($sql) {
		$result = $this->_sendSQL($sql);
		return $this->_recordCount = mysqli_num_rows($result);
	}
	//取得总页数
	public function getTotalPage() {
	}
	//取得唯一一条记录
	public function uniqueQuery($sql) {
		$result = $this->_sendSQL($sql);
		return mysqli_fetch_array($result);
	}
    //查询多条记录
    public function multQuery( $sql, $offset = false )
    {
        $result = $this->_sendSQL( $sql, $offset );
        $datas = array();
        $nIndex = 0;
        while( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) )
        {
            $nIndex += 1;
            $datas[$nIndex] = $row;
        }
        return $datas;
    }
	//取得多个值 (select单个字段时用)
	public function fetchValues($sql, $offset = false) {
		$result = $this->_sendSQL($sql, $offset);
		$datas  = array();
		while ($row = mysqli_fetch_array($result)) {
			$datas[] = $row[0];
		}
		return $datas;
	}
	//错误处理
	private function _error($msg) {
	//	printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
	//	printf("<b>MySQL Error</b>: %s (%s)<br>\n", $this->_errno, $this->_error);
	AddConfigSvrPHPDBErrLog($this->_errno . '(' . $this->_error . ')'."sql:".$msg);

		die("Session halted");
	}
	//取得某一值
	public function fetchValue($sql) {
		$result = $this->_sendSQL($sql);
		$value  = mysqli_fetch_row($result);
		return $value[0];
	}
	//执行非查询语句返回id
	public function execute($sql) {
		$this->_sendSQL($sql);
		return mysqli_insert_id($this->_conn);
	}
	//执行非查询语句返回影响行数
	public function update($sql) {
		return $this->_sendSQL($sql);
	}
	//执行删除语句,要有返回值return,否则无法获得正确结果
	public function deletesql($sql) {
		return $this->_sendSQL($sql);
	}

	//获取connection
	public  function  get_conn(){
		return $this->_conn;
	}

	//关闭数据库
	public function close() {
		mysqli_close($this->_conn);
	}
	//析构函数
	public function __destruct() {
		@$this->close();
	}
}
    
class account_db extends db_mysqli {
	private $gsdb_host;
	private $gsdb_user;
	private $gsdb_pass;
	private $gsdb_name;
	private $gsdb_code;
    private $gsdb_port;

	function __construct($idx,$dataArr) {
		global $aryAccountDB;
		$this->gsdb_host = $aryAccountDB[$idx]["ip"];
		$this->gsdb_user = $aryAccountDB[$idx]["user"];
		$this->gsdb_pass = $aryAccountDB[$idx]["psw"];
        $this->gsdb_name = $aryAccountDB[$idx]['db'];
		$this->gsdb_code = $aryAccountDB[$idx]["code"];
		$this->gsdb_port = $aryAccountDB[$idx]["port"];
		$this->_connect($dataArr);
	}

	protected function _connect() {
		if (!is_resource($this->_conn)) {
            $this->_conn = new mysqli($this->gsdb_host,$this->gsdb_user,$this->gsdb_pass,$this->gsdb_name,$this->gsdb_port);
            if (mysqli_connect_errno()){
                AddConfigSvrPHPDBErrLog("account_db::_connect:".mysqli_connect_error());
            }
		}
	}
}







?>
