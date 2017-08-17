<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: 심성일													|# 
#|작성일	: 2012-08-28												|# 
#|작성내용	: 버튼이미지 관리											|# 
#/*====================================================================*/# 

class BtnimagesMgr
{
	private $query;
	private $param;


	/********************************** List **********************************/
	function getBtnimagesList($db)
	{
		$query  = "SELECT														";
		$query .= "	*															";
		$query .= "FROM ".TBL_CONTENT."											";

		if($this->getSearchStatusY()=="Y"){
			$where = "'Y'														";
		}

		if($this->getSearchStatusN()=="N"){
			if ($where) $where .= ",";
			$where .= "'N'														";
		}
		
		if($where){
			$query .= "WHERE CP_PAGE_VIEW IN (".$where.")						";
		}

		if($this->getSearchKey()){
			if(!$wh){
				$query .= "WHERE BI_IMAGE_CATE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
			}else{
				$query .= "AND BI_IMAGE_CATE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'		";
			}
		}

		$query .= "ORDER BY BI_NO DESC	LIMIT ".$this->getLimitFirst().",".$this->getPageLine();

		return $db->getExecSql($query);
	}

	function getBtnimagesTotal($db)
	{
		$query  = "SELECT														";
		$query .= "	COUNT(*)													";
		$query .= "FROM ".TBL_CONTENT."											";
		
		if($this->getSearchStatusY()=="Y"){
			$where = "'Y'														";
		}

		if($this->getSearchStatusN()=="N"){
			if ($where) $where .= ",";
			$where .= "'N'														";
		}
		
		if($where){
			$query .= "WHERE CP_PAGE_VIEW IN (".$where.")						";
		}

		if($this->getSearchKey()){
			if(!$wh){
				$query .= "WHERE BI_IMAGE_CATE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
			}else{
				$query .= "AND BI_IMAGE_CATE LIKE '%".($this->getSearchKey())."%'		";
			}
		}

		return $db->getCount($query);
	}

	/********************************** Insert **********************************/
	function getBtnimagesInsert($db)
	{
		$query = "CALL SP_DESIGN_BTN_IMAGES_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";


		$param[]  = $this->getBI_GROUP();
		$param[]  = $this->getBI_IMAGE_CATE();
		$param[]  = $this->getBI_IMAGE_GUBUN();
		$param[]  = $this->getBI_IMAGE_PAGE();
		$param[]  = $this->getBI_IMAGE_DIR();
		$param[]  = $this->getBI_IMAGE_FILE_1();
		$param[]  = $this->getBI_IMAGE_FILE_2();
		$param[]  = $this->getBI_IMAGE_FILE_3();
		$param[]  = $this->getBI_IMAGE_FILE_4();
		$param[]  = $this->getBI_IMAGE_FILE_5();
		$param[]  = $this->getBI_ATATCH_TYPE();
		$param[]  = $this->getBI_IMAGE_W();
		$param[]  = $this->getBI_IMAGE_H();
		$param[]  = $this->getBI_REG_DT();
		$param[]  = $this->getBI_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getBtnimagesUpdate($db)
	{
		$query = "CALL SP_DESIGN_BTN_IMAGES_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getBI_NO();
		$param[]  = $this->getBI_GROUP();
		$param[]  = $this->getBI_IMAGE_CATE();
		$param[]  = $this->getBI_IMAGE_GUBUN();
		$param[]  = $this->getBI_IMAGE_PAGE();
		$param[]  = $this->getBI_IMAGE_DIR();
		$param[]  = $this->getBI_IMAGE_FILE_1();
		$param[]  = $this->getBI_IMAGE_FILE_2();
		$param[]  = $this->getBI_IMAGE_FILE_3();
		$param[]  = $this->getBI_IMAGE_FILE_4();
		$param[]  = $this->getBI_IMAGE_FILE_5();
		$param[]  = $this->getBI_ATATCH_TYPE();
		$param[]  = $this->getBI_IMAGE_W();
		$param[]  = $this->getBI_IMAGE_H();
		$param[]  = $this->getBI_MOD_DT();
		$param[]  = $this->getBI_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getBtnimagesDelete($db)
	{
		$query = "CALL SP_DESIGN_BTN_IMAGES_D (?);";
		$param[]  = $this->getBI_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** variable **********************************/
	function setBI_NO($BI_NO){ $this->BI_NO = $BI_NO; }		
	function getBI_NO(){ return $this->BI_NO; }		

	function setBI_GROUP($BI_GROUP){ $this->BI_GROUP = $BI_GROUP; }		
	function getBI_GROUP(){ return $this->BI_GROUP; }		

	function setBI_IMAGE_CATE($BI_IMAGE_CATE){ $this->BI_IMAGE_CATE = $BI_IMAGE_CATE; }		
	function getBI_IMAGE_CATE(){ return $this->BI_IMAGE_CATE; }		

	function setBI_IMAGE_GUBUN($BI_IMAGE_GUBUN){ $this->BI_IMAGE_GUBUN = $BI_IMAGE_GUBUN; }		
	function getBI_IMAGE_GUBUN(){ return $this->BI_IMAGE_GUBUN; }		

	function setBI_IMAGE_PAGE($BI_IMAGE_PAGE){ $this->BI_IMAGE_PAGE = $BI_IMAGE_PAGE; }		
	function getBI_IMAGE_PAGE(){ return $this->BI_IMAGE_PAGE; }		

	function setBI_IMAGE_DIR($BI_IMAGE_DIR){ $this->BI_IMAGE_DIR = $BI_IMAGE_DIR; }		
	function getBI_IMAGE_DIR(){ return $this->BI_IMAGE_DIR; }		

	function setBI_IMAGE_FILE_1($BI_IMAGE_FILE_1){ $this->BI_IMAGE_FILE_1 = $BI_IMAGE_FILE_1; }		
	function getBI_IMAGE_FILE_1(){ return $this->BI_IMAGE_FILE_1; }		

	function setBI_IMAGE_FILE_2($BI_IMAGE_FILE_2){ $this->BI_IMAGE_FILE_2 = $BI_IMAGE_FILE_2; }		
	function getBI_IMAGE_FILE_2(){ return $this->BI_IMAGE_FILE_2; }		

	function setBI_IMAGE_FILE_3($BI_IMAGE_FILE_3){ $this->BI_IMAGE_FILE_3 = $BI_IMAGE_FILE_3; }		
	function getBI_IMAGE_FILE_3(){ return $this->BI_IMAGE_FILE_3; }		

	function setBI_IMAGE_FILE_4($BI_IMAGE_FILE_4){ $this->BI_IMAGE_FILE_4 = $BI_IMAGE_FILE_4; }		
	function getBI_IMAGE_FILE_4(){ return $this->BI_IMAGE_FILE_4; }		

	function setBI_IMAGE_FILE_5($BI_IMAGE_FILE_5){ $this->BI_IMAGE_FILE_5 = $BI_IMAGE_FILE_5; }		
	function getBI_IMAGE_FILE_5(){ return $this->BI_IMAGE_FILE_5; }		

	function setBI_ATATCH_TYPE($BI_ATATCH_TYPE){ $this->BI_ATATCH_TYPE = $BI_ATATCH_TYPE; }		
	function getBI_ATATCH_TYPE(){ return $this->BI_ATATCH_TYPE; }		

	function setBI_IMAGE_W($BI_IMAGE_W){ $this->BI_IMAGE_W = $BI_IMAGE_W; }		
	function getBI_IMAGE_W(){ return $this->BI_IMAGE_W; }		

	function setBI_IMAGE_H($BI_IMAGE_H){ $this->BI_IMAGE_H = $BI_IMAGE_H; }		
	function getBI_IMAGE_H(){ return $this->BI_IMAGE_H; }		

	function setBI_REG_DT($BI_REG_DT){ $this->BI_REG_DT = $BI_REG_DT; }		
	function getBI_REG_DT(){ return $this->BI_REG_DT; }		

	function setBI_REG_NO($BI_REG_NO){ $this->BI_REG_NO = $BI_REG_NO; }		
	function getBI_REG_NO(){ return $this->BI_REG_NO; }		

	function setBI_MOD_DT($BI_MOD_DT){ $this->BI_MOD_DT = $BI_MOD_DT; }		
	function getBI_MOD_DT(){ return $this->BI_MOD_DT; }		

	function setBI_MOD_NO($BI_MOD_NO){ $this->BI_MOD_NO = $BI_MOD_NO; }		
	function getBI_MOD_NO(){ return $this->BI_MOD_NO; }		


	function setPageLine($PAGELINE){ $this->PAGELINE = $PAGELINE; }		
	function getPageLine(){ return $this->PAGELINE; }

	function setLimitFirst($LIMITFIRST){ $this->LIMITFIRST = $LIMITFIRST; }
	function getLimitFirst(){ return $this->LIMITFIRST; }

	function setSearchStatusY($SEARCHSTATUSY){ $this->SEARCHSTATUSY = $SEARCHSTATUSY; }
	function getSearchStatusY(){ return $this->SEARCHSTATUSY; }

	function setSearchStatusN($SEARCHSTATUSN){ $this->SEARCHSTATUSN = $SEARCHSTATUSN; }
	function getSearchStatusN(){ return $this->SEARCHSTATUSN; }

	function setSearchKey($SEARCHKEY){ $this->SEARCHKEY = $SEARCHKEY; }
	function getSearchKey(){ return $this->SEARCHKEY; }

	/********************************** variable **********************************/


}
?>