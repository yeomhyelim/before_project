<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-11-12												|# 
#|작성내용	: 디자인 관리												|# 
#/*====================================================================*/# 

class DesignSetMgr
{
	private $query;
	private $param;

	/********************************** view **********************************/
	function getDesignSliderBannerList($db, $total="LIST")
	{
		if ( $total == "LIST" ) :
			$query  = "SELECT * FROM " . TBL_DESIGN_SLIDER_BANNER . " AS A ";
		elseif ( $total == "COUNT" ) :
			$query  = "SELECT COUNT(*) FROM " . TBL_DESIGN_SLIDER_BANNER . " AS A ";
		else :
			return -100;
		endif;

		$query .= "WHERE A.SB_NO IS NOT NULL ";

		if ( $this->getLimitFirst() != 0 || $this->getPageLine() != 0 ) :
			$query  .= sprintf( "LIMIT %d,%d ", $this->getLimitFirst(), $this->getPageLine() );
		endif;

		if ( $total == "LIST" ) :
			return $db->getExecSql($query);
		elseif ( $total == "COUNT" ) :
			return $db->getCount($query);
		else :
			return -100;
		endif;
	}

	function getDesignSliderBannerImgList($db, $total="LIST")
	{
		if ( $total == "LIST" ) :
			$query  = "SELECT * FROM " . TBL_DESIGN_SLIDER_BANNER_IMG . " AS A ";
		elseif ( $total == "COUNT" ) :
			$query  = "SELECT COUNT(*) FROM " . TBL_DESIGN_SLIDER_BANNER_IMG . " AS A ";
		else :
			return -100;
		endif;

		$query .= "WHERE A.SI_NO IS NOT NULL ";

		if ( $this->getSB_NO() ) :
			$query .= "AND A.SB_NO = " . $this->getSB_NO() . " ";
		endif;

		if ( $this->getLimitFirst() != 0 || $this->getPageLine() != 0 ) :
			$query  .= sprintf( "LIMIT %d,%d ", $this->getLimitFirst(), $this->getPageLine() );
		endif;

		if ( $total == "LIST" ) :
			return $db->getExecSql($query);
		elseif ( $total == "COUNT" ) :
			return $db->getCount($query);
		else :
			return -100;
		endif;
	}

	function getConfDataList($db)
	{
		$query  = "SELECT																";
		$query .= "	*																	";
		$query .= "FROM ".TBL_DESIGN_SET."												";
		

		if($this->getDS_CODE()) :
			$query .= "WHERE DS_TYPE LIKE '".$this->getDS_TYPE()."%'					";
			$query .= "AND DS_CODE LIKE '".$this->getDS_CODE()."%'						";
		else :
			$query .= "WHERE DS_TYPE = '".$this->getDS_TYPE()."'						";
		endif;

		return $db->getArrayTotal($query);
	}

	function getCodeList($db)
	{
		$query  = "SELECT																";
		$query .= "	*																	";
		$query .= "FROM ".TBL_DESIGN_SET."												";
		$query .= "WHERE DS_TYPE = '".$this->getDS_TYPE()."'							";
		$query .= "		AND DS_CODE LIKE '%".$this->getDS_CODE()."%'					";

		return $db->getArrayTotal($query);
	}

	function getCodeHtmlList($db)
	{
		$query  = "SELECT																";
		$query .= "	*																	";
		$query .= "FROM ".TBL_DESIGN_HTML_SET."											";
		$query .= "WHERE DHS_TYPE = '".$this->getDHS_TYPE()."'							";
		$query .= "		AND DHS_CODE LIKE '%".$this->getDHS_CODE()."%'					";

		return $db->getArrayTotal($query);
	}

	function  getMenuTopList($db)
	{
		$query  = "SELECT																";
		$query .= "	*																	";
		$query .= "FROM ".TBL_DESIGN_SET."												";
		$query .= "WHERE DS_CODE LIKE '{$this->getDS_CODE()}' AND DS_VAL <> ''			";

		return $db->getArrayTotal($query);
	}

	function  getMenuTopHtmlList($db)
	{
		$query  = "SELECT																";
		$query .= "	*																	";
		$query .= "FROM ".TBL_DESIGN_HTML_SET."											";
		$query .= "WHERE DHS_CODE LIKE '{$this->getDS_CODE()}' AND DHS_HTML <> ''		";

		return $db->getArrayTotal($query);
	}

	function getCateLevelAry($db)
	{
		$query  = "SELECT                                                 ";
		
		if ($this->getC_LEVEL()){
			switch ($this->getC_LEVEL()){
				case 1:
					$query .= "	SUBSTRING(A.C_CODE,1,3) CATE_CODE		";
				break;
				case 2:
					$query .= "	SUBSTRING(A.C_CODE,4,6) CATE_CODE		";
				break;
				case 3:
					$query .= "	SUBSTRING(A.C_CODE,7,9) CATE_CODE		";
				break;
				case 4:
					$query .= "	SUBSTRING(A.C_CODE,10,12) CATE_CODE		";
				break;
			}
		}
		$query .= "    ,B.CL_NAME CATE_NAME									";
		$query .= "    ,A.C_LOW_YN CATE_LOW_YN								";
		$query .= "    ,B.CL_IMG1 CATE_IMG1								";
		$query .= "    ,B.CL_IMG2 CATE_IMG2								";
		$query .= "    ,A.C_SHARE CATE_SHARE							";
//		$query .= "    ,A.C_VIEW_YN CATE_VIEW							";
		$query .= "    ,B.CL_VIEW_YN CATE_VIEW							";

		$query .= "	   ,(SELECT DS_VAL FROM ".TBL_DESIGN_SET." WHERE DS_TYPE = 'SKIN_PL' AND DS_CODE = CONCAT('PL_TOP_USE_CATE_',";
		if ($this->getC_LEVEL()){
			switch ($this->getC_LEVEL()){
				case 1:
					$query .= "	SUBSTRING(A.C_CODE,1,3),'000000000','_IMG')) PL_TOP_IMG		";
				break;
				case 2:
					$query .= "	SUBSTRING(A.C_CODE,1,6),'000000','_IMG')) PL_TOP_IMG		";
				break;
				case 3:
					$query .= "	SUBSTRING(A.C_CODE,1,9),'000','_IMG')) PL_TOP_IMG			";
				break;
				case 4:
					$query .= "	SUBSTRING(A.C_CODE,1,12),'_IMG')) PL_TOP_IMG				";
				break;
			}
		}

		$query .= "	   ,(SELECT DS_VAL FROM ".TBL_DESIGN_SET." WHERE DS_TYPE = 'SKIN_PL' AND DS_CODE = CONCAT('PL_TOP_USE_CATE_',";
		if ($this->getC_LEVEL()){
			switch ($this->getC_LEVEL()){
				case 1:
					$query .= "	SUBSTRING(A.C_CODE,1,3),'000000000','_HTML')) PL_TOP_HTML		";
				break;
				case 2:
					$query .= "	SUBSTRING(A.C_CODE,1,6),'000000','_HTML')) PL_TOP_HTML		";
				break;
				case 3:
					$query .= "	SUBSTRING(A.C_CODE,1,9),'000','_HTML')) PL_TOP_HTML			";
				break;
				case 4:
					$query .= "	SUBSTRING(A.C_CODE,1,12),'_HTML')) PL_TOP_HTML				";
				break;
			}
		}

// 2013.04.22 HTML 태그를 DB에 저장하는것이 아닌, 파일명을 저장하는것으로 변경
//		$query .= "	   ,(SELECT DHS_HTML FROM ".TBL_DESIGN_HTML_SET." WHERE DHS_TYPE = 'SKIN_PL' AND DHS_CODE = CONCAT('PL_TOP_USE_CATE_',";
//		if ($this->getC_LEVEL()){
//			switch ($this->getC_LEVEL()){
//				case 1:
//					$query .= "	SUBSTRING(A.C_CODE,1,3),'000000000','_HTML')) PL_TOP_HTML		";
//				break;
//				case 2:
//					$query .= "	SUBSTRING(A.C_CODE,1,6),'000000','_HTML')) PL_TOP_HTML		";
//				break;
//				case 3:
//					$query .= "	SUBSTRING(A.C_CODE,1,9),'000','_HTML')) PL_TOP_HTML			";
//				break;
//				case 4:
//					$query .= "	SUBSTRING(A.C_CODE,1,12),'_HTML')) PL_TOP_HTML				";
//				break;
//			}
//		}
			
		$query .= "FROM ".TBL_CATE_MGR." A									";
		$query .= "LEFT OUTER JOIN CATE_LNG AS B ON B.C_CODE = A.C_CODE		";
		$query .= "WHERE A.C_CODE IS NOT NULL								";
		$query .= "AND B.CL_LNG = '".$this->getC_LNG()."'					";

		if ($this->getC_LEVEL()){
			$query .= "	AND A.C_LEVEL = ".$this->getC_LEVEL()."				";
		}

		if ($this->getC_HCODE()){
			if ($this->getC_LEVEL() > 1){
				switch ($this->getC_LEVEL()){
					case 2:
						$query .= "	AND SUBSTRING(A.C_CODE,1,3) = '".$this->getC_HCODE()."'";
					break;
					case 3:
						$query .= "	AND SUBSTRING(A.C_CODE,1,6) = '".$this->getC_HCODE()."'";
					break;
					case 4:
						$query .= "	AND SUBSTRING(A.C_CODE,1,9) = '".$this->getC_HCODE()."'";
					break;
				}
			}
		}
		
		if ($this->getC_VIEW_YN() == "Y"){
			$query .= "	AND IFNULL(A.C_VIEW_YN,'Y') = 'Y'	";
		}

		if ($this->getC_TYPE() == "P"){
			$query .= "	AND IFNULL(A.C_TYPE,'') = 'P'	";
		} else {
			$query .= "	AND IFNULL(A.C_TYPE,'') = ''	";
		}

		$query .= "ORDER BY A.C_ORDER,A.C_CODE  ";

		return $db->getArrayTotal($query);
	}
	
	function getDesignSliderBannerView($db) 
	{
		$query  = "SELECT															";
		$query .= "	*																";
		$query .= "FROM " . TBL_DESIGN_SLIDER_BANNER . "							";
		$query .= "WHERE SB_NO=" . $this->getSB_NO() . "							";

		return $db->getSelect($query);
	}
	
	function getCodeView($db)
	{
		$query  = "SELECT																";
		$query .= "	*																	";
		$query .= "FROM ".TBL_DESIGN_SET."												";
		$query .= "WHERE DS_TYPE = '".$this->getDS_TYPE()."'							";
		return $db->getLayoutCodeArray($query);
	}

	function getCodeHtmlView($db)
	{
		$query  = "SELECT																";
		$query .= "	*																	";
		$query .= "FROM ".TBL_DESIGN_HTML_SET."											";
		$query .= "WHERE DHS_TYPE = '".$this->getDHS_TYPE()."'							";
		return $db->getLayoutHtmlArray($query);
	}

	function getCodeVal($db)
	{
		$query  = "SELECT																";
		$query .= "	DS_VAL																";
		$query .= "FROM ".TBL_DESIGN_SET."												";
		$query .= "WHERE DS_TYPE = '".$this->getDS_TYPE()."'							";
		$query .= "		AND DS_CODE = '".$this->getDS_CODE()."'							";
		
		return $db->getCount($query);
	}

	function getCodeHtmlVal($db)
	{
		$query  = "SELECT																";
		$query .= "	DHS_HTML															";
		$query .= "FROM ".TBL_DESIGN_HTML_SET."											";
		$query .= "WHERE DHS_TYPE = '".$this->getDHS_TYPE()."'							";
		$query .= "		AND DHS_CODE = '".$this->getDHS_CODE()."'						";
		
		return $db->getCount($query);
	}

	function getCodeCount($db)
	{
		$query  = "SELECT COUNT(*) FROM ".TBL_DESIGN_SET;
		$query .= "	WHERE DS_TYPE = '".$this->getDS_TYPE()."'";
		$query .= "		AND DS_CODE = '".$this->getDS_CODE()."'";
		return $db->getCount($query);
	}

	function getCodeHtmlCount($db)
	{
		$query  = "SELECT COUNT(*) FROM ".TBL_DESIGN_HTML_SET;
		$query .= "	WHERE DHS_TYPE = '".$this->getDHS_TYPE()."'";
		$query .= "		AND DHS_CODE = '".$this->getDHS_CODE()."'";
		return $db->getCount($query);
	}


	/********************************** Insert **********************************/

	function getCodeInsert($db){
		
		$query  = "INSERT INTO ".TBL_DESIGN_SET." (DS_TYPE,DS_CODE,DS_VAL) VALUES (";
		$query .= " '".mysql_real_escape_string($this->getDS_TYPE())."'";
		$query .= ",'".mysql_real_escape_string($this->getDS_CODE())."'";
		$query .= ",'".mysql_real_escape_string($this->getDS_VAL())."'";
		$query .= ")";
		
		return $db->getExecSql($query);
	}


	function getCodeHtmlInsert($db){
		
		$query  = "INSERT INTO ".TBL_DESIGN_HTML_SET." (DHS_TYPE,DHS_CODE,DHS_HTML) VALUES (";
		$query .= " '".mysql_real_escape_string($this->getDHS_TYPE())."'";
		$query .= ",'".mysql_real_escape_string($this->getDHS_CODE())."'";
		$query .= ",'".mysql_real_escape_string($this->getDHS_HTML())."'";
		$query .= ")";
		
		return $db->getExecSql($query);
	}

	function getDesignSliderBannerInsert($db) 
	{
		/*--
		$columnField  = " IM_CODE";
		$columnField .= ",SB_W_SIZE";
		$columnField .= ",SB_H_SIZE";
		$columnField .= ",SB_LINK_TYPE";
		$columnField .= ",SB_REG_DT";		
		$columnField .= ",SB_REG_NO";

		$columnData  = " '".mysql_escape_string($this->getIM_CODE())		."'";
		$columnData .= ",". $this->getSB_W_SIZE();
		$columnData .= ",". $this->getSB_H_SIZE();
		$columnData .= ",'".mysql_escape_string($this->getSB_LINK_TYPE())		."'";
		$columnData .= ", NOW() ";
		$columnData .= ",". $this->getSB_REG_NO();

		return $db->getInsertSql(TBL_DESIGN_SLIDER_BANNER,$columnField,$columnData,true);
		--*/

		$query = "CALL SP_DESIGN_SLIDER_BANNER_I (?,?,?,?,?,?);";

		$param[]  = $this->getIM_CODE();
		$param[]  = $this->getSB_COMMENT();
		$param[]  = $this->getSB_W_SIZE();
		$param[]  = $this->getSB_H_SIZE();
		$param[]  = $this->getSB_LINK_TYPE();
		$param[]  = $this->getSB_REG_NO();

		$re = $db->executeBindingQuery($query,$param,true);

		if($re == 1) :
			$re = $db->getCount("SELECT MAX(SB_NO) FROM " . TBL_DESIGN_SLIDER_BANNER);
		endif;

		return $re;
	}

	function getDesignSliderBannerImgInsert($db)
	{
		$query = "CALL SP_DESIGN_SLIDER_BANNER_IMG_I (?,?,?,?,?);";

		$param[]  = $this->getSB_NO();
		$param[]  = $this->getSI_IMG();
		$param[]  = $this->getSI_LINK();
		$param[]  = $this->getSI_TEXT();
		$param[]  = $this->getSI_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	/********************************** Update **********************************/

	function getCodeInsertUpdate($db,$array){
		
		while(list($field,$val) = each($array)){
			 
			$this->setDS_CODE(STRTOUPPER($field));
			$this->setDS_VAL($val);
			
			if ($this->getCodeCount($db) == 0) {
				$this->getCodeInsert($db);
			} else {
				$this->getCodeUpdate($db);
			}
		}

		return true;
	}

	function getCodeHtmlInsertUpdate($db,$array){
		
		while(list($field,$val) = each($array)){
			 
			$this->setDHS_CODE(STRTOUPPER($field));
			$this->setDHS_HTML($val);
			
			if ($this->getCodeHtmlCount($db) == 0) {
				$this->getCodeHtmlInsert($db);
			} else {
				$this->getCodeHtmlUpdate($db);
			}
		}

		return true;
	}

	function getCodeUpdate($db){
		
		$query  = "UPDATE ".TBL_DESIGN_SET." ";
		$query .= " SET DS_VAL = '".mysql_real_escape_string($this->getDS_VAL())."'";
		$query .= "	WHERE DS_TYPE = '".mysql_real_escape_string($this->getDS_TYPE())."'";
		$query .= "	AND DS_CODE = '".mysql_real_escape_string($this->getDS_CODE())."'";

		return $db->getExecSql($query);
	}

	function getCodeHtmlUpdate($db){
		
		$query  = "UPDATE ".TBL_DESIGN_HTML_SET." ";
		$query .= " SET DHS_HTML = '".mysql_real_escape_string($this->getDHS_HTML())."'";
		$query .= "	WHERE DHS_TYPE = '".mysql_real_escape_string($this->getDHS_TYPE())."'";
		$query .= "	AND DHS_CODE = '".mysql_real_escape_string($this->getDHS_CODE())."'";

		return $db->getExecSql($query);
	}

	function getDesignSliderBannerUpdate($db)
	{
		$query = "CALL SP_DESIGN_SLIDER_BANNER_U (?,?,?,?,?,?,?);";

		$param[]  = $this->getSB_NO();
		$param[]  = $this->getIM_CODE();
		$param[]  = $this->getSB_COMMENT();
		$param[]  = $this->getSB_W_SIZE();
		$param[]  = $this->getSB_H_SIZE();
		$param[]  = $this->getSB_LINK_TYPE();
		$param[]  = $this->getSB_MOD_NO();
		
		return $db->executeBindingQuery($query,$param,true);
	}

	function getDesignSliderBannerImgUpdate($db)
	{
		$query = "CALL SP_DESIGN_SLIDER_BANNER_IMG_U (?,?,?,?,?,?);";

		$param[]  = $this->getSI_NO();
		$param[]  = $this->getSB_NO();
		$param[]  = $this->getSI_IMG();
		$param[]  = $this->getSI_LINK();
		$param[]  = $this->getSI_TEXT();
		$param[]  = $this->getSI_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	/********************************** Delete **********************************/

	function getCodeDelete($db){
		
		$query  = "DELETE FROM ".TBL_DESIGN_SET." ";
		$query .= "	WHERE DS_TYPE = '".mysql_real_escape_string($this->getDS_TYPE())."'";
		$query .= "	AND DS_CODE = '".mysql_real_escape_string($this->getDS_CODE())."'";

		return $db->getExecSql($query);
	}
	
	function getCodeHtmlDelete($db){
		
		$query  = "DELETE FROM ".TBL_DESIGN_HTML_SET." ";
		$query .= "	WHERE DHS_TYPE = '".mysql_real_escape_string($this->getDHS_TYPE())."'";
		$query .= "	AND DHS_CODE = '".mysql_real_escape_string($this->getDHS_CODE())."'";

		return $db->getExecSql($query);
	}

	function getDesignSliderBannerDelete($db)
	{
		$query = "CALL SP_DESIGN_SLIDER_BANNER_D (?);";
		$param[]  = $this->getSB_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getDesignSliderBannerImgDelete($db)
	{
		$query = "CALL SP_DESIGN_SLIDER_BANNER_IMG_D (?);";
		$param[]  = $this->getSB_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	
	
	function getDesignSliderBannerImgDeleteEx($db, $param)
	{
			$where			= "";
			
			if($param['SI_NO']):
				$where			= "{$where} AND SI_NO = {$param['SI_NO']}";
			endif;

			if($where):
				$where			= "SI_NO IS NOT NULL {$where}";
			endif;

			if(!$where) { return; }

			$db->getDelete("DESIGN_SLIDER_BANNER_IMG", $where);
	}

	/********************************** Category ColorSize List **********************************/
	
	function getCateColorSizeList($db)
	{
		$query  = "SELECT                                                             ";
		$query .= "     CC_CODE                                                       ";
		$query .= "    ,CC_NAME_KR                                                    ";
		$query .= "    ,CC_USE                                                        ";
		$query .= "    ,CC_IMG1                                                       ";
		$query .= "FROM ".TBL_COMM_CODE."                                             ";
		$query .= "WHERE CG_NO = (SELECT CG_NO FROM ".TBL_COMM_GRP." WHERE CG_CODE = '".$this->getCG_CODE()."') ";
		$query .= "ORDER BY CC_SORT ASC                                               ";
		
		return $db->getArrayTotal($query);
	}
	
	/********************************** variable **********************************/

	/* DESIGN_LAYOUT TABLE */
	function setDS_NO($DS_NO){ $this->DS_NO = $DS_NO; }		
	function getDS_NO(){ return $this->DS_NO; }		

	function setDS_TYPE($DS_TYPE){ $this->DS_TYPE = $DS_TYPE; }		
	function getDS_TYPE(){ return $this->DS_TYPE; }		

	function setDS_CODE($DS_CODE){ $this->DS_CODE = $DS_CODE; }		
	function getDS_CODE(){ return $this->DS_CODE; }		

	function setDS_VAL($DS_VAL){ $this->DS_VAL = $DS_VAL; }		
	function getDS_VAL(){ return $this->DS_VAL; }		

	function setC_CODE($C_CODE){ $this->C_CODE = $C_CODE; }		
	function getC_CODE(){ return $this->C_CODE; }		

	function setC_LNG($C_LNG){ $this->C_LNG = $C_LNG; }		
	function getC_LNG(){ return $this->C_LNG; }	

	function setC_LEVEL($C_LEVEL){ $this->C_LEVEL = $C_LEVEL; }		
	function getC_LEVEL(){ return $this->C_LEVEL; }		
	
	function setC_HCODE($C_HCODE){ $this->C_HCODE = $C_HCODE; }		
	function getC_HCODE(){ return $this->C_HCODE; }		

	function setC_VIEW_YN($C_VIEW_YN){ $this->C_VIEW_YN = $C_VIEW_YN; }		
	function getC_VIEW_YN(){ return $this->C_VIEW_YN; }

	function setC_TYPE($C_TYPE){ $this->C_TYPE = $C_TYPE; }		
	function getC_TYPE(){ return $this->C_TYPE; }

	function setDHS_NO($DHS_NO){ $this->DHS_NO = $DHS_NO; }		
	function getDHS_NO(){ return $this->DHS_NO; }		

	function setDHS_TYPE($DHS_TYPE){ $this->DHS_TYPE = $DHS_TYPE; }		
	function getDHS_TYPE(){ return $this->DHS_TYPE; }		

	function setDHS_CODE($DHS_CODE){ $this->DHS_CODE = $DHS_CODE; }		
	function getDHS_CODE(){ return $this->DHS_CODE; }		

	function setDHS_HTML($DHS_HTML){ $this->DHS_HTML = $DHS_HTML; }		
	function getDHS_HTML(){ return $this->DHS_HTML; }		

	function setDHS_REG_DT($DHS_REG_DT){ $this->DHS_REG_DT = $DHS_REG_DT; }		
	function getDHS_REG_DT(){ return $this->DHS_REG_DT; }		

	function setDHS_REG_NO($DHS_REG_NO){ $this->DHS_REG_NO = $DHS_REG_NO; }		
	function getDHS_REG_NO(){ return $this->DHS_REG_NO; }		

	function setDHS_MOD_DT($DHS_MOD_DT){ $this->DHS_MOD_DT = $DHS_MOD_DT; }		
	function getDHS_MOD_DT(){ return $this->DHS_MOD_DT; }		

	function setDHS_MOD_NO($DHS_MOD_NO){ $this->DHS_MOD_NO = $DHS_MOD_NO; }		
	function getDHS_MOD_NO(){ return $this->DHS_MOD_NO; }

	// 움직이는 베너
	function setSB_NO($SB_NO){ $this->SB_NO = $SB_NO; }		
	function getSB_NO(){ return $this->SB_NO; }		

	function setIM_CODE($IM_CODE){ $this->IM_CODE = $IM_CODE; }		
	function getIM_CODE(){ return $this->IM_CODE; }	
	
	function setSB_COMMENT($SB_COMMENT){ $this->SB_COMMENT = $SB_COMMENT; }		
	function getSB_COMMENT(){ return $this->SB_COMMENT; }	

	function setSB_W_SIZE($SB_W_SIZE){ $this->SB_W_SIZE = $SB_W_SIZE; }		
	function getSB_W_SIZE(){ return $this->SB_W_SIZE; }		

	function setSB_H_SIZE($SB_H_SIZE){ $this->SB_H_SIZE = $SB_H_SIZE; }		
	function getSB_H_SIZE(){ return $this->SB_H_SIZE; }		

	function setSB_LINK_TYPE($SB_LINK_TYPE){ $this->SB_LINK_TYPE = $SB_LINK_TYPE; }		
	function getSB_LINK_TYPE(){ return $this->SB_LINK_TYPE; }		

	function setSB_REG_DT($SB_REG_DT){ $this->SB_REG_DT = $SB_REG_DT; }		
	function getSB_REG_DT(){ return $this->SB_REG_DT; }		

	function setSB_REG_NO($SB_REG_NO){ $this->SB_REG_NO = $SB_REG_NO; }		
	function getSB_REG_NO(){ return $this->SB_REG_NO; }		

	function setSB_MOD_DT($SB_MOD_DT){ $this->SB_MOD_DT = $SB_MOD_DT; }		
	function getSB_MOD_DT(){ return $this->SB_MOD_DT; }		

	function setSB_MOD_NO($SB_MOD_NO){ $this->SB_MOD_NO = $SB_MOD_NO; }		
	function getSB_MOD_NO(){ return $this->SB_MOD_NO; }	


	// 움직이는 베너 (이미지)
	function setSI_NO($SI_NO){ $this->SI_NO = $SI_NO; }		
	function getSI_NO(){ return $this->SI_NO; }		

//	function setSB_NO($SB_NO){ $this->SB_NO = $SB_NO; }		
//	function getSB_NO(){ return $this->SB_NO; }		

	function setSI_IMG($SI_IMG){ $this->SI_IMG = $SI_IMG; }			/* array */
	function getSI_IMG(){ return $this->SI_IMG; }		

	function setSI_LINK($SI_LINK){ $this->SI_LINK = $SI_LINK; }		/* array */
	function getSI_LINK(){ return $this->SI_LINK; }		

	function setSI_TEXT($SI_TEXT){ $this->SI_TEXT = $SI_TEXT; }		/* array */
	function getSI_TEXT(){ return $this->SI_TEXT; }		

	function setSI_REG_DT($SI_REG_DT){ $this->SI_REG_DT = $SI_REG_DT; }	
	function getSI_REG_DT(){ return $this->SI_REG_DT; }		

	function setSI_REG_NO($SI_REG_NO){ $this->SI_REG_NO = $SI_REG_NO; }		
	function getSI_REG_NO(){ return $this->SI_REG_NO; }		

	function setSI_MOD_DT($SI_MOD_DT){ $this->SI_MOD_DT = $SI_MOD_DT; }		
	function getSI_MOD_DT(){ return $this->SI_MOD_DT; }		

	function setSI_MOD_NO($SI_MOD_NO){ $this->SI_MOD_NO = $SI_MOD_NO; }		
	function getSI_MOD_NO(){ return $this->SI_MOD_NO; }	

	/* PUBLIC */
	function setPageLine($PAGELINE){ $this->PAGELINE = $PAGELINE; }
	function getPageLine(){ return $this->PAGELINE; }
	
	function setLimitFirst($LIMITFIRST){ $this->LIMITFIRST = $LIMITFIRST; }
	function getLimitFirst(){ return $this->LIMITFIRST; }
	
	function setSearchKey($SEARCHKEY){ $this->SEARCHKEY = $SEARCHKEY; }
	function getSearchKey(){ return $this->SEARCHKEY; }
	/* PUBLIC */	
	

	
	function setCG_CODE($CG_CODE){ $this->CG_CODE = $CG_CODE; }		
	function getCG_CODE(){ return $this->CG_CODE; }	
	/********************************** variable **********************************/

}

?>