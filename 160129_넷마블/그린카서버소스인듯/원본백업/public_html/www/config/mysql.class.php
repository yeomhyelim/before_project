<?
class MySQL {
	var $dbConfig		= null;
	var $tables			= null;
	var $siteConfig 	= null;

	var $Conn			= null;
	var $query			= '';
	var $result			= null;
	var $transaction 	= true;

	var $host			= "";	
	var $db				= "";
	var $user			= "";
	var $password		= "";
	
	var $stmt			= null;
	var $sqlParamNameArray = array();


	private $error_desc		= "";
	private $error_number	= 0;
	private $error_desc2	= "";

	public $ThrowExceptions = false;
	public $logWriter		= "";

	var $logFileName	= '';
	var $logFileContent	= '';

	function MySQL() {}

	function initConfig() {

		global $DB_PATH;

		$conf_set = parse_ini_file("$DB_PATH");
		@extract($conf_set);

		if (!$this->host){
			$this->host = $db_host;
			$this->db = $db_name;
			$this->user = $db_user;
			$this->password = $db_pass;
		}	
	}

	function connect() {

		$this->initConfig();
		$this->connectEx();
	
	}

	function connectEx() {

		$this->Conn =  mysql_connect($this->host, $this->user, $this->password) or exit('DB Connect Error: ./www/config/mysql.class.php');

		mysql_select_db($this->db, $this->Conn) or exit('DB Select Error');

		//register_shutdown_function(array(&$this, 'Close'));
		
		$this->getExecSql("SET NAMES utf8");	
	}

	function Start() {
		if($this->transaction == true) {
			$this->getExecSql("START TRANSACTION");
		}
	}

	function Close() {
		
		if($this->transaction == true) {
			$this->Commit();
		}
		
		@mysql_close($this->Conn);
	}

	function CloseError() {
		
		if($this->transaction == true) {
			$this->RollBack();
			//echo "DB Close Error, All Transaction Was Rollback...";
		}
	}

	function Commit() {

		if($this->transaction == true) {
			$this->getExecSql("COMMIT");
		}
	}

	function RollBack() {
		if($this->transaction == true) {
			$result = mysql_query("ROLLBACK",$this->Conn);
			if(!$result) echo "롤백실패";
		}
	}
	
	function Roll() {
		$this->RollBack();	
	}

	function getExecSql($query) {
		$this->query	= $query;
		$this->result	= mysql_query($this->query,$this->Conn);

		//$this->error_number = 99999;
		//$this->writeLog();

		if(!$this->result) {			
			return $this->getErrorMsg();
		} else {
			return $this->result;
		}
	}

	function getExecSqlNoErrorMsg($query) {
		$this->query	= $query;
		$this->result	= mysql_query($this->query,$this->Conn);	
		return $this->result;
	}

	function getResult($query){
		
		if (!$this->getExecSql($query)) {
			$result["result"] = $this->getErrorMsg();
			$result["cnt"]	= 0;		
		} else {
			$result["result"] = $this->result;
			$result["cnt"]	= @mysql_affected_rows();
		}

		return $result;
	}

	function getFreeResult() {
		return mysql_free_result($this->result);
	}

	function getCount($query){

		$re = $this->getExecSql($query);
		if ($this->result == -9999) return $this->result;
		if ($re == -9999) return $re;

		$row = mysql_fetch_array($this->result);	
		return $row[0];
	}

	function getNum($query){
		$this->getExecSql($query);
		if ($this->result == -9999) return $this->result;

		return mysql_num_rows($this->result);													            
	}

	function getSelect($query){
		$this->getExecSql($query);
		if ($this->result == -9999) return $this->result;

		return mysql_fetch_array($this->result);
	}


	#데이터를 배열로 변환해서 가져옴.
	//key와 값을 가져올때사용
	function getArray($query){
		$aryCode = "";
		$this->result = $this->getExecSql($query);
		if ($this->result == -9999) return $this->result;

		while($row = mysql_fetch_array($this->result)){
			$aryCode[$row[0]] = $row[1];
		}


		return $aryCode;
	}

	#데이터를 배열로 변환해서 가져옴.
	//key와 값을 가져올때사용
	function getArrayTotal($query){
		$aryCode = "";
		//echo $query;
		$this->result = $this->getExecSql($query);
		while($row = mysql_fetch_array($this->result)){
			$aryCode[] = $row;
		}
		return $aryCode;
	}

	#데이터를 배열로 변환해서 가져옴.
	//key와 값을 가져올때사용
	function getLayoutCodeArray($query){
		$aryCode = "";
		//echo $query;
		$this->result = $this->getExecSql($query);
		
		while($row = mysql_fetch_array($this->result)){
			$aryCode[$row[DS_CODE]] = $row[DS_VAL];
		}
		return $aryCode;
	}

	function getLayoutHtmlArray($query){
		$aryCode = "";
		//echo $query;
		$this->result = $this->getExecSql($query);
		
		while($row = mysql_fetch_array($this->result)){
			$aryCode[$row[DHS_CODE]] = $row[DHS_HTML];
		}
		return $aryCode;
	}

	function getSiteInfoArray($query){
		$aryCode = "";
		//echo $query;
		$this->result = $this->getExecSql($query);
		while($row = mysql_fetch_array($this->result)){
			$aryCode[$row[COL]] = $row[VAL];
		}
		return $aryCode;
	}


	function getLastInsertID() {
		return $this->getCount("SELECT LAST_INSERT_ID()");				
	}
	

	function prepareStatement($query) {
		
		$this->query = $query;
		
		$this->error_desc2 = $query;

		$this->stmt 	= 'spac_stmt';
		$query 			= "PREPARE ".$this->stmt." FROM \"".$this->query."\";";
		$this->getExecSql($query);
	}

	function setParam($param) {
		
		$sqlParamName 		= '';
		$this->sqlParamNameArray 	= array();
		$bindQuery 			= '';
		
		if(!is_array($param)) {
			$param = array($param);
		}		
		
		for($i = 0; $i<count($param);$i++) {
			
			$sqlParamName 	 			= "@param".$i;
			
			if($i == 0) { 
				$bindQuery				= "SET";
			}
				
			$bindQuery					.= " " . $sqlParamName . " = '". mysql_real_escape_string($param[$i]) . "'";
			
			if($i < (count($param)-1)) {
				$bindQuery				.= ",";	
			} else {
				$bindQuery				.= ";";
			}
			
			$this->sqlParamNameArray[] 	= $sqlParamName; 			
		}
		
		$this->getExecSql($bindQuery);	 
	}
	
	function executeStatement() {		
		
		if(count($this->sqlParamNameArray)) {
			$usingParamString = implode(",",$this->sqlParamNameArray);		
		}
		
		$stmt_query = "EXECUTE " . $this->stmt ." USING ".$usingParamString.";";		
		$this->getExecSql($stmt_query);
	}
	
	function closeStatement() { 
		
		$deallocate_query = "DEALLOCATE PREPARE " . $this->stmt .";";

		$this->getExecSql($deallocate_query);

	}
	
	function executeBindingQuery($query,$param,$auto_close = false) {
		$this->prepareStatement($query);
		$this->setParam($param);
		$this->executeStatement();

		if($auto_close == true) {			
			$this->closeStatement();
		}

		if ($this->error_number == 0) {
			return true;
		} else {
			return false;
		}
	}


	function executeBindingSelect($query,$param) {
		$this->prepareStatement($query);
		$this->setParam($param);
		$this->executeStatement();

		return $this->result;
	}

	function getProcedureSelect(&$db){
		return mysql_fetch_array($this->result);
	}

	function closeBindingQuery() {
		$this->closeStatement();
	}
	
	
	function isConnect(){
		if (gettype($this->Conn) == "resource") {
			return true;
		} else {
			return false;
		}
	}	
	
	function disConnect(){
		if (!$this->Conn) mysql_close($this->Conn);
	}

	private function getErrorMsg($errorMessage = "", $errorNumber = 0) {
		try {
			if (strlen($errorMessage) > 0) {
				$this->error_desc = $errorMessage;
			} else {
				if ($this->isConnect()) {
					$this->error_desc = mysql_error($this->Conn);
				} else {
					$this->error_desc = mysql_error();
				}
			}

			if ($errorNumber <> 0) {
				$this->error_number = $errorNumber;
			} else {
				if ($this->isConnect()) {
					$this->error_number = @mysql_errno($this->Conn);
				} else {
					$this->error_number = @mysql_errno();
				}
			}

			//print_r($this->error_desc);
			if ($this->error_number > 0) {
				$this->CloseError();
				$this->writeLog();
				
				$this->error_number = -9999;
				return $this->error_number;
				//print_r($this->error_number);
				exit;
			}

		} catch(Exception $e) {

			$this->error_desc = $e->getMessage();
			$this->error_number = -999;

			return $this->error_number;
		}

		if ($this->ThrowExceptions) {

			throw new Exception($this->error_number);
		}		
	}

	public function getInsertParam($tableName, $param,$insert_id = true) {
	
		if(!is_array($param)) { return; }

		$field		= "";
		$data		= "";
		foreach($param as $key => $value) :
		
			$field	.= ($field) ? ", " : "";
			$field	.= $key;

			$data	.= ($data) ? ", " : "";
			$data	.= $value;

		endforeach;
	
		return $this->getInsertSql($tableName, $field, $data, $insert_id);
	}

	public function getInsert($tableName,$array,$insert_id){
		$i = 0;
		while(list($field,$val) =each($array)){
			 if($i ==0){
				 $fields  = $field;
				 $vals    = "'".mysql_real_escape_string($val)."'";
			 }else{
				 $fields .= ",$field";
				 $vals   .= ",'".mysql_real_escape_string($val)."'";
			 }
			 $i ++;
		}
		
		$this->result = $this->getExecSql("INSERT INTO $tableName ($fields) VALUES ($vals)");

		if ($insert_id) 
		{
			return mysql_insert_id();
		}
		else
		{
			return $this->result;
		}
	}

	public function getInsertSql($tableName,$field,$data,$insert_id){
		$qry			= sprintf("INSERT INTO %s (%s) VALUES (%s)",$tableName,$field,$data);
		$this->result	= $this->getExecSql($qry);
		
		if($insert_id) return mysql_insert_id(); else return $this->result;			
	}

	#데이터 Update
	public function getUpdateParam($tableName, $param, $where = "") {
		if(!is_array($param)) { return; }
		
		$data		= "";
		foreach($param as $key => $value) :
			$data	.= ($data) ? ", " : "";
			$data	.= "{$key} = {$value}";
		endforeach;
		
		if(!empty($where)) { $where ="WHERE ".$where; }

		return $this->getUpdateSql($tableName, $data, $where);
	}

	public function getUpdate($tableName,$array,$where =""){
		 if(!empty($where)) $where ="WHERE ".$where;
		 $i = 0;
		 while(list($field,$val) =each($array)){
			 if($i ==0)
				 $term  = "$field ='".mysql_real_escape_string($val)."'";
			 else
				 $term .= ",$field ='".mysql_real_escape_string($val)."'";
			 $i++;
		 }

		 //echo "UPDATE $tableName set $term $where";
		 return $this->getExecSql("UPDATE $tableName set $term $where");
	}

	public function getUpdateSql($tableName,$field,$where){
		$qry	= sprintf("UPDATE %s SET %s %s",$tableName,$field,$where);

		$result	= $this->getExecSql($qry);
		if($result)	return $result; else return false;	
		
	}

	#데이터 Delete
	public function getDelete($tableName,$where =""){
		 if(!empty($where)) $where ="WHERE ".$where;
		 return $this->getExecSql("DELETE FROM $tableName $where");
	}

	function writeLog()
	{
		if ($this->error_number > 0)
		{
			$this->logFileContent	 = "";		
			$this->logFileName		 = date("Ymd").'.log';
			$this->logFileContent	.= "[query1]:".$this->error_desc2;
			$this->logFileContent	.= "[query2]:".$this->query;
			$this->logFileContent	.= "[error]:".$this->error_desc;	
			

			if(!file_exists($_SERVER["DOCUMENT_ROOT"]."/www/logs/".$this->logFileName)) {
				$fp = fopen($_SERVER["DOCUMENT_ROOT"]."/www/logs/".$this->logFileName,"w");
			} else {
				$fp = fopen($_SERVER["DOCUMENT_ROOT"]."/www/logs/".$this->logFileName,"a");
			}

			flock( $fp, LOCK_EX );

			fwrite($fp,"#".date("Y-m-d H:i:s")."[".$this->logWriter."]------------------------------------\n");
			fwrite($fp,$this->logFileContent);
			fwrite($fp,"\n\n\n");

			flock( $fp, LOCK_UN );
			fclose($fp);
		}
	}

	/**
	 * 작성일 : 2013.06.19
	 * 작성자 : kim hee sung
	 * getSQLString($str)
	 * SQL 문자형으로 형변환	ex) text => "text"
	 * **/		
	function getSQLString($str) {
		$str	= addslashes($str);
		return "\"{$str}\"";
	}

	/**
	 * 작성일 : 2013.06.19
	 * 작성자 : kim hee sung
	 * getSQLString($str)
	 * SQL 정수형으로 형변환	ex) "" => 0
	 * **/		
	function getSQLInteger($int) {
		if($int) { return $int; }
		return 0;
	}

	/**
	 * 작성일 : 2013.06.19
	 * 작성자 : kim hee sung
	 * getSQLString($str)
	 * SQL 년월일시분초 형변환	ex) 
	 * **/	
	function getSQLDatetime($str) {
		
		if($str == "NOW()") {return $str; }
		
		if(!$str) { return "\"\""; }

		$str = date("Y-m-d H:i:s", strtotime($str));
		
		return "\"{$str}\"";
	}

	/**
	 * 작성일 : 2015.01.16
	 * 작성자 : kim hee sung
	 * getIsTable()
	 * 테이블 확인
	 * **/	
	function getIsTable($table_name) {
		
		 if(!$table_name) { return; }
		
		$result = mysql_query("SHOW TABLES LIKE '{$table_name}'");
		$row = mysql_fetch_array($result, MYSQL_NUM);
		return ($row === false) ? false : true;
	}

	/**
	 * 작성일 : 2015.01.16
	 * 작성자 : kim hee sung
	 * getIsTable()
	 * 테이블 확인
	 * **/	
	function getIsColumn($table_name, $column_name) {
		
		 if(!$table_name) { return; }
		 if(!$column_name) { return; }

		$SQL  = "SELECT count(*) as CNT                              ";
		$SQL .= "  FROM INFORMATION_SCHEMA.COLUMNS                   ";
		$SQL .= " WHERE								                 ";
		$SQL .= "           TABLE_NAME = '{$table_name}'             ";
		$SQL .= "       AND COLUMN_NAME = '{$column_name}'           ";
//	    print_r($SQL);
		$result = mysql_query($SQL);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		return ($row[0]) ? true : false;
	}


} 

#오브젝트 생성
$db = new MySQL;

?>
