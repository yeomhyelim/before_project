<?
#/*====================================================================*/# 
#|작성자	: 김희성(thav@naver.com)																												|# 
#|작성일	: 2012-09-17																																	|# 
#|작성내용	: 디자인 관리																																	|# 
#/*====================================================================*/# 

class DesignMgr
{
	private $query;
	private $param;

	/********************************** view **********************************/
	function getDesignLayoutView($db)
	{
		$query  = "SELECT																";
		$query .= "	*																	";
		$query .= "FROM ".TBL_LAYOUT."												";
		$query .= "WHERE DL_NO=1													";
		return $db->getSelect($query);
	}

	function getDesignMgrView($db)
	{
		$query  = "SELECT																";
		$query .= "	A.*																	";
		$query .= "FROM ".TBL_DESIGN_MGR."	AS A									";
		$query .= "WHERE A.DM_NO  IS NOT NULL									";
		
		// 적용 위치
		if($this->getDM_NO()) {
			$query .= "AND A.DM_NO = '" . $this->getDM_NO() . "'					";
		}
			
		return $db->getSelect($query);
	}	
	
	function getProdPageView($db)
	{
		$query  = "SELECT																					";
		$query .= "	A.*, B.DM_DESIGN_TYPE, B.DM_DESIGN_CODE, B.DM_DESIGN_GROUP					";
		$query .= "FROM " . TBL_DESIGN_PRODPAGE_MGR . " AS A					";
		$query .= "LEFT OUTER JOIN " . TBL_DESIGN_MGR . " AS B						";
		$query .= "ON A.PV_DESIGN_NO = B.DM_NO									";		
		$query .= "WHERE A.PV_NO  IS NOT NULL										";
		
		// 적용 위치
		if($this->getPV_NO()) {
			$query .= "AND A.PV_NO = '" . $this->getPV_NO() . "'						";
		}	
		
		return $db->getSelect($query);
	}
	
	function getDesignBtnImagesView($db)
	{
		$query  = "SELECT																";
		$query .= "	A.*																	";
		$query .= "FROM " . TBL_DESIGN_BTN_IMAGES . " AS A						";	
		$query .= "WHERE A.BI_NO  IS NOT NULL										";
		
		// 번호
		if($this->getBI_NO()) {
			$query .= "AND A.BI_NO = '" . $this->getBI_NO() . "'						";
		}
		
		return $db->getSelect($query);
	}
	
	function getDesignTopImageView($db)
	{
		$query  = "SELECT																";
		$query .= "	A.*																	";
		$query .= "FROM " . TBL_DESIGN_TOP_IMAGES . " AS A						";
		$query .= "WHERE A.TI_NO  IS NOT NULL										";
		
		// 번호
		if($this->getTI_NO()) {
			$query .= "AND A.TI_NO = '" . $this->getTI_NO() . "'						";
		}
		
		// 카테고리 사용 유무 체크
		if ( $this->getTI_CATE_CODE() ) {
			$query .= "AND A.TI_CATE_CODE  = '" . $this->getTI_CATE_CODE() . "'							";
		}
			
		return $db->getSelect($query);		
	}
	
	function getSliderView($db)
	{
		$query  = "SELECT														";
		$query .= "	A.*, B.DM_DESIGN_TYPE, B.DM_DESIGN_CODE, B.DM_DESIGN_GROUP					";
		$query .= "FROM " . TBL_SLIDING_BANNER . " AS A					";
		$query .= "LEFT OUTER JOIN " . TBL_DESIGN_MGR . " AS B				";
		$query .= "ON A.SB_DESIGN_CODE = B.DM_NO							";
		$query .= "WHERE A.SB_NO IS NOT NULL								";

		// 번호
		if( $this->getSB_NO() ) {
			$query .= "AND A.SB_NO = '" . $this->getSB_NO() . "'				";
		}

		return $db->getSelect($query);
	}
	
	/********************************** List **********************************/
	function getProdPageList($db)
	{
		$query  = "SELECT																					";
		$query .= "	*																						";
		$query .= "FROM " . TBL_DESIGN_PRODPAGE_MGR . "	AS A										";
		$query .= "LEFT OUTER JOIN " . TBL_DESIGN_MGR . " AS B											";
		$query .= "ON A.PV_DESIGN_NO = B.DM_NO														";
		$query .= "WHERE A.PV_NO  IS NOT NULL															";
	
		// 적용 위치
		if($this->getPV_PAGE()) {
			$query .= "AND A.PV_PAGE = '" . $this->getPV_PAGE() . "'										";
		}
		
		// 디자인 타입
		if ( $this->getDM_DESIGN_TYPE() ) {
			$query .= "AND B.DM_DESIGN_TYPE  = '" . $this->getDM_DESIGN_TYPE() . "'					";
		}
			
		// 디자인 그룹
		if ( $this->getDM_DESIGN_GROUP() ) {
			$query .= "AND B.DM_DESIGN_GROUP  = '" . $this->getDM_DESIGN_GROUP() . "'				";
		}
		
		if($this->getLimitFirst() && $this->getPageLine()) {
			$query .= "ORDER BY A.PV_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		} else {
			$query .= "ORDER BY A.PV_NO DESC ";
		}
		return $db->getExecSql($query);
	}
	
	function getDesignMgrList($db)
	{
		$query  = "SELECT																					";
		$query .= "	*																						";
		$query .= "FROM " . TBL_DESIGN_MGR . "	AS A													";
		$query .= "WHERE A.DM_NO  IS NOT NULL														";
		
		// 디자인 타입
		if ( $this->getDM_DESIGN_TYPE() ) {
			$query .= "AND A.DM_DESIGN_TYPE  = '" . $this->getDM_DESIGN_TYPE() . "'					";
		}
			
		// 디자인 그룹
		if ( $this->getDM_DESIGN_GROUP() ) {
			$query .= "AND A.DM_DESIGN_GROUP  = '" . $this->getDM_DESIGN_GROUP() . "'				";
		}
		
		if($this->getLimitFirst() && $this->getPageLine()) {
			$query .= "ORDER BY A.DM_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		} else {
			$query .= "ORDER BY A.DM_NO DESC ";
		}
		
		return $db->getExecSql($query);		
	}
	
	function getDesignBtnImageList($db)
	{
		$query  = "SELECT																					";
		$query .= "	*																						";
		$query .= "FROM " . TBL_DESIGN_BTN_IMAGES . "	AS A											";
		$query .= "WHERE A.BI_NO  IS NOT NULL															";
	
		// 디자인 그룹
		if ( $this->getBI_GROUP() ) {
			$query .= "AND A.BI_GROUP  = '" . $this->getBI_GROUP() . "'									";
		}
		
		// 디자인 카테고리
		if ( $this->getBI_IMAGE_CATE() ) {
			$query .= "AND A.BI_IMAGE_CATE  = '" . $this->getBI_IMAGE_CATE() . "'						";
		}
	
		if($this->getLimitFirst() && $this->getPageLine()) {
			$query .= "ORDER BY A.BI_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		} else {
			$query .= "ORDER BY A.BI_NO DESC ";
		} 
	
		return $db->getExecSql($query);
	}	
	/********************************** total **********************************/	
	function getProdPageTotal($db)
	{
		$query  = "SELECT																					";
		$query .= "	COUNT(*)																				";
		$query .= "FROM " . TBL_DESIGN_PRODPAGE_MGR . "	AS A												";
		$query .= "LEFT OUTER JOIN " . TBL_DESIGN . " AS B												";
		$query .= "ON A.PV_DESIGN_NO = B.DM_NO														";
		$query .= "WHERE A.PV_NO  IS NOT NULL															";
	
		// 적용 위치
		if($this->getPV_PAGE()) {
			$query .= "AND A.PV_PAGE = '" . $this->getPV_PAGE() . "'										";
		}
		
		// 디자인 타입
		if ( $this->getDM_DESIGN_TYPE() ) {
			$query .= "AND B.DM_DESIGN_TYPE  = '" . $this->getDM_DESIGN_TYPE() . "'					";
		}
			
		// 디자인 그룹
		if ( $this->getDM_DESIGN_GROUP() ) {
			$query .= "AND B.DM_DESIGN_GROUP  = '" . $this->getDM_DESIGN_GROUP() . "'				";
		}
		
		if($this->getLimitFirst() && $this->getPageLine()) {
			$query .= "ORDER BY A.PV_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		} else {
			$query .= "ORDER BY A.PV_NO DESC ";
		}
	
		return $db->getCount($query);
	}

	function getDesignMgrTotal($db)
	{
		$query  = "SELECT																					";
		$query .= "	COUNT(*)																				";
		$query .= "FROM " . TBL_DESIGN_MGR . "	AS A													";
		$query .= "WHERE A.DM_NO  IS NOT NULL														";
	
		// 디자인 타입
		if ( $this->getDM_DESIGN_TYPE() ) {
			$query .= "AND A.DM_DESIGN_TYPE  = '" . $this->getDM_DESIGN_TYPE() . "'					";
		}
			
		// 디자인 그룹
		if ( $this->getDM_DESIGN_GROUP() ) {
			$query .= "AND A.DM_DESIGN_GROUP  = '" . $this->getDM_DESIGN_GROUP() . "'				";
		}
	
		if($this->getLimitFirst() && $this->getPageLine()) {
			$query .= "ORDER BY A.DM_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		} else {
			$query .= "ORDER BY A.DM_NO DESC ";
		}
	
		return $db->getCount($query);
	}
	
	function getDesignBtnImageTotal($db)
	{
		$query  = "SELECT																					";
		$query .= "	COUNT(*)																				";
		$query .= "FROM " . TBL_DESIGN_BTN_IMAGES . "	AS A											";
		$query .= "WHERE A.BI_NO  IS NOT NULL															";
	
		// 디자인 그룹
		if ( $this->getBI_GROUP() ) {
			$query .= "AND A.BI_GROUP  = '" . $this->getBI_GROUP() . "'									";
		}
	
		if($this->getLimitFirst() && $this->getPageLine()) {
			$query .= "ORDER BY A.BI_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		} else {
			$query .= "ORDER BY A.BI_NO DESC ";
		}
		
		return $db->getCount($query);		
	}
	
	function getDesignTopImagetotal($db)
	{
		$query  = "SELECT																					";
		$query .= "	COUNT(*)																				";
		$query .= "FROM " . TBL_DESIGN_TOP_IMAGES . "	AS A											";
		$query .= "WHERE A.TI_NO  IS NOT NULL															";
		
		// 카테고리 사용 유무 체크
		if ( $this->getTI_CATE_CODE() ) {
			$query .= "AND A.TI_CATE_CODE  = '" . $this->getTI_CATE_CODE() . "'							";
		}
		
		return $db->getCount($query);
	}
	
	/********************************** Insert **********************************/
	function getDesignTopImageInsert($db)
	{
		$query = "CALL SP_DESIGN_TOP_IMAGES_I (?,?,?,?,?,?,?);";
	
		$param[]  = $this->getTI_CATE_CODE();
		$param[]  = $this->getTI_TOP_IMAGE();
		$param[]  = $this->getTI_LEFT_IMAGE();
		$param[]  = $this->getTI_HTML_TOP();
		$param[]  = $this->getTI_HTML_BOTTOM();
		$param[]  = $this->getTI_REG_DT();
		$param[]  = $this->getTI_REG_NO();
	
		return $db->executeBindingQuery($query,$param,true);
	}

	function getDesignBtnImageInsert($db)
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

	function getSliderInsert($db)
	{
		$query = "CALL SP_SLIDING_BANNER_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
	
		$param[]  = $this->getSB_GROUP();
		$param[]  = $this->getSB_DESIGN_CODE();
		$param[]  = $this->getSB_BANNER_NAME();
		$param[]  = $this->getSB_IMAGES_CNT();
		$param[]  = $this->getSB_IMAGE_W();
		$param[]  = $this->getSB_IMAGE_H();
		$param[]  = $this->getSB_IMAGE_FILE_1();
		$param[]  = $this->getSB_IMAGE_FILE_2();
		$param[]  = $this->getSB_IMAGE_FILE_3();
		$param[]  = $this->getSB_IMAGE_FILE_4();
		$param[]  = $this->getSB_IMAGE_FILE_5();
		$param[]  = $this->getSB_IMAGE_FILE_6();
		$param[]  = $this->getSB_IMAGE_FILE_7();
		$param[]  = $this->getSB_IMAGE_FILE_8();
		$param[]  = $this->getSB_IMAGE_FILE_9();
		$param[]  = $this->getSB_IMAGE_FILE_10();
		$param[]  = $this->getSB_IMAGE_LINK_1();
		$param[]  = $this->getSB_IMAGE_LINK_2();
		$param[]  = $this->getSB_IMAGE_LINK_3();
		$param[]  = $this->getSB_IMAGE_LINK_4();
		$param[]  = $this->getSB_IMAGE_LINK_5();
		$param[]  = $this->getSB_IMAGE_LINK_6();
		$param[]  = $this->getSB_IMAGE_LINK_7();
		$param[]  = $this->getSB_IMAGE_LINK_8();
		$param[]  = $this->getSB_IMAGE_LINK_9();
		$param[]  = $this->getSB_IMAGE_LINK_10();
		$param[]  = $this->getSB_IMAGES_TITLE_1();
		$param[]  = $this->getSB_IMAGES_TITLE_2();
		$param[]  = $this->getSB_IMAGES_TITLE_3();
		$param[]  = $this->getSB_IMAGES_TITLE_4();
		$param[]  = $this->getSB_IMAGES_TITLE_5();
		$param[]  = $this->getSB_IMAGES_TITLE_6();
		$param[]  = $this->getSB_IMAGES_TITLE_7();
		$param[]  = $this->getSB_IMAGES_TITLE_8();
		$param[]  = $this->getSB_IMAGES_TITLE_9();
		$param[]  = $this->getSB_IMAGES_TITLE_10();
		$param[]  = $this->getSB_IMAGES_TXT_1();
		$param[]  = $this->getSB_IMAGES_TXT_2();
		$param[]  = $this->getSB_IMAGES_TXT_3();
		$param[]  = $this->getSB_IMAGES_TXT_4();
		$param[]  = $this->getSB_IMAGES_TXT_5();
		$param[]  = $this->getSB_IMAGES_TXT_6();
		$param[]  = $this->getSB_IMAGES_TXT_7();
		$param[]  = $this->getSB_IMAGES_TXT_8();
		$param[]  = $this->getSB_IMAGES_TXT_9();
		$param[]  = $this->getSB_IMAGES_TXT_10();
		$param[]  = $this->getSB_LINK_TARGET();
		$param[]  = $this->getSB_REG_DT();
		$param[]  = $this->getSB_REG_NO();
	
		return $db->executeBindingQuery($query,$param,true);
	}
		
	/********************************** Update **********************************/
	function getDesignLayoutUpdate($db)
	{
		// 디자인 관리 / 첫화면 설정
		$query = "CALL SP_DESIGN_LAYOUT_U (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getDL_NO();
		$param[]  = $this->getDL_BG_TYPE();
		$param[]  = $this->getDL_BG_COLOR();
		$param[]  = $this->getDL_BG_IMAGE();
		$param[]  = $this->getDL_BG_IMG_DIR_H();
		$param[]  = $this->getDL_BG_IMG_DIR_V();
		$param[]  = $this->getDL_BG_REPEAT();
		$param[]  = $this->getDL_BG_ALIGN();
		$param[]  = $this->getDL_FIRST_PAGE();
		$param[]  = $this->getDL_FIRST_USE();
		$param[]  = $this->getDL_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	
	// 디자인 관리 / 레이아웃 설정 에서 레이아웃 변경시 레이아웃 코드, 레이아웃 타입 변경
	function getDesignLayoutCodeUpdate($db)
	{
		$updateField  = "  DL_CODE				= '".mysql_escape_string($this->getDL_CODE())	."'";
		$updateField .= ", DL_DESIGN_CODE		= '".mysql_escape_string($this->getDL_DESIGN_CODE())	."'";
	
		return $db->getUpdateSql(TBL_LAYOUT,$updateField, " Where DL_NO=1");
	}
		
	function getDesignTopImageUpdate($db)
	{
		$query = "CALL SP_DESIGN_TOP_IMAGES_U (?,?,?,?,?,?,?,?);";
	
		$param[]  = $this->getTI_NO();	
		$param[]  = $this->getTI_CATE_CODE();
		$param[]  = $this->getTI_TOP_IMAGE();
		$param[]  = $this->getTI_LEFT_IMAGE();
		$param[]  = $this->getTI_HTML_TOP();
		$param[]  = $this->getTI_HTML_BOTTOM();
		$param[]  = $this->getTI_MOD_DT();
		$param[]  = $this->getTI_MOD_NO();
	
		return $db->executeBindingQuery($query,$param,true);
	}
	
	function getDesignBtnImageUpdate($db)
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
	
	function getDesignLayoutIDUpdate($db)
	{
		$strDM_DESIGN_GROUP = $this->getDM_DESIGN_GROUP();
		
		if ( $strDM_DESIGN_GROUP == "common") :
			$updateField  = "  DL_COMMON_ID	= " 		. $this->getBI_GROUP() ;
		elseif ( $strDM_DESIGN_GROUP == "product") :
			$updateField  = "  DL_PRODUCT_ID	= " 		. $this->getBI_GROUP() ;
		elseif ( $strDM_DESIGN_GROUP == "member") :
			$updateField  = "  DL_MEMBER_ID	= " 			. $this->getBI_GROUP() ;
		elseif ( $strDM_DESIGN_GROUP == "community") :
			$updateField  = "  DL_COMMUNITY_ID	= " 		. $this->getBI_GROUP() ;
		else:
			return;
		endif;
		
		return $db->getUpdateSql(TBL_LAYOUT,$updateField, " Where DL_NO=1");
	}
	
	
	function getSliderUpdate($db)
	{
		$query = "CALL SP_SLIDING_BANNER_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
	
		$param[]  = $this->getSB_NO();
		$param[]  = $this->getSB_GROUP();
		$param[]  = $this->getSB_DESIGN_CODE();
		$param[]  = $this->getSB_BANNER_NAME();
		$param[]  = $this->getSB_IMAGES_CNT();
		$param[]  = $this->getSB_IMAGE_W();
		$param[]  = $this->getSB_IMAGE_H();
		$param[]  = $this->getSB_IMAGE_FILE_1();
		$param[]  = $this->getSB_IMAGE_FILE_2();
		$param[]  = $this->getSB_IMAGE_FILE_3();
		$param[]  = $this->getSB_IMAGE_FILE_4();
		$param[]  = $this->getSB_IMAGE_FILE_5();
		$param[]  = $this->getSB_IMAGE_FILE_6();
		$param[]  = $this->getSB_IMAGE_FILE_7();
		$param[]  = $this->getSB_IMAGE_FILE_8();
		$param[]  = $this->getSB_IMAGE_FILE_9();
		$param[]  = $this->getSB_IMAGE_FILE_10();
		$param[]  = $this->getSB_IMAGE_LINK_1();
		$param[]  = $this->getSB_IMAGE_LINK_2();
		$param[]  = $this->getSB_IMAGE_LINK_3();
		$param[]  = $this->getSB_IMAGE_LINK_4();
		$param[]  = $this->getSB_IMAGE_LINK_5();
		$param[]  = $this->getSB_IMAGE_LINK_6();
		$param[]  = $this->getSB_IMAGE_LINK_7();
		$param[]  = $this->getSB_IMAGE_LINK_8();
		$param[]  = $this->getSB_IMAGE_LINK_9();
		$param[]  = $this->getSB_IMAGE_LINK_10();
		$param[]  = $this->getSB_IMAGES_TITLE_1();
		$param[]  = $this->getSB_IMAGES_TITLE_2();
		$param[]  = $this->getSB_IMAGES_TITLE_3();
		$param[]  = $this->getSB_IMAGES_TITLE_4();
		$param[]  = $this->getSB_IMAGES_TITLE_5();
		$param[]  = $this->getSB_IMAGES_TITLE_6();
		$param[]  = $this->getSB_IMAGES_TITLE_7();
		$param[]  = $this->getSB_IMAGES_TITLE_8();
		$param[]  = $this->getSB_IMAGES_TITLE_9();
		$param[]  = $this->getSB_IMAGES_TITLE_10();
		$param[]  = $this->getSB_IMAGES_TXT_1();
		$param[]  = $this->getSB_IMAGES_TXT_2();
		$param[]  = $this->getSB_IMAGES_TXT_3();
		$param[]  = $this->getSB_IMAGES_TXT_4();
		$param[]  = $this->getSB_IMAGES_TXT_5();
		$param[]  = $this->getSB_IMAGES_TXT_6();
		$param[]  = $this->getSB_IMAGES_TXT_7();
		$param[]  = $this->getSB_IMAGES_TXT_8();
		$param[]  = $this->getSB_IMAGES_TXT_9();
		$param[]  = $this->getSB_IMAGES_TXT_10();
		$param[]  = $this->getSB_LINK_TARGET();
		$param[]  = $this->getSB_MOD_DT();
		$param[]  = $this->getSB_MOD_NO();
	
		return $db->executeBindingQuery($query,$param,true);
	}	

	/********************************** Delete **********************************/
	function getDesignTopImageDelete($db)
	{
		 return $db->getDelete(TBL_DESIGN_TOP_IMAGES," TI_NO=".$this->getTI_NO());
	}
	
	function getDesignBtnImagesDelete($db)
	{
		return $db->getDelete(TBL_DESIGN_BTN_IMAGES," BI_NO=".$this->getBI_NO());
	}
	
	function getSliderDelete($db)
	{
		return $db->getDelete(TBL_SLIDING_BANNER," SB_NO=".mysql_real_escape_string($this->getSB_NO()));
	}
	
	
	/********************************** variable **********************************/
	/* DESIGN_LAYOUT TABLE */
	function setDL_NO($DL_NO){ $this->DL_NO = $DL_NO; }		
	function getDL_NO(){ return $this->DL_NO; }		

	function setDL_CODE($DL_CODE){ $this->DL_CODE = $DL_CODE; }		
	function getDL_CODE(){ return $this->DL_CODE; }		

	function setDL_DESIGN_CODE($DL_DESIGN_CODE){ $this->DL_DESIGN_CODE = $DL_DESIGN_CODE; }		
	function getDL_DESIGN_CODE(){ return $this->DL_DESIGN_CODE; }		

	function setDL_BG_TYPE($DL_BG_TYPE){ $this->DL_BG_TYPE = $DL_BG_TYPE; }		
	function getDL_BG_TYPE(){ return $this->DL_BG_TYPE; }		

	function setDL_BG_COLOR($DL_BG_COLOR){ $this->DL_BG_COLOR = $DL_BG_COLOR; }		
	function getDL_BG_COLOR(){ return $this->DL_BG_COLOR; }		

	function setDL_BG_IMAGE($DL_BG_IMAGE){ $this->DL_BG_IMAGE = $DL_BG_IMAGE; }		
	function getDL_BG_IMAGE(){ return $this->DL_BG_IMAGE; }		

	function setDL_BG_IMG_DIR_H($DL_BG_IMG_DIR_H){ $this->DL_BG_IMG_DIR_H = $DL_BG_IMG_DIR_H; }		
	function getDL_BG_IMG_DIR_H(){ return $this->DL_BG_IMG_DIR_H; }		

	function setDL_BG_IMG_DIR_V($DL_BG_IMG_DIR_V){ $this->DL_BG_IMG_DIR_V = $DL_BG_IMG_DIR_V; }		
	function getDL_BG_IMG_DIR_V(){ return $this->DL_BG_IMG_DIR_V; }		

	function setDL_BG_REPEAT($DL_BG_REPEAT){ $this->DL_BG_REPEAT = $DL_BG_REPEAT; }		
	function getDL_BG_REPEAT(){ return $this->DL_BG_REPEAT; }		

	function setDL_BG_ALIGN($DL_BG_ALIGN){ $this->DL_BG_ALIGN = $DL_BG_ALIGN; }		
	function getDL_BG_ALIGN(){ return $this->DL_BG_ALIGN; }		

	function setDL_FIRST_PAGE($DL_FIRST_PAGE){ $this->DL_FIRST_PAGE = $DL_FIRST_PAGE; }		
	function getDL_FIRST_PAGE(){ return $this->DL_FIRST_PAGE; }		

	function setDL_FIRST_USE($DL_FIRST_USE){ $this->DL_FIRST_USE = $DL_FIRST_USE; }		
	function getDL_FIRST_USE(){ return $this->DL_FIRST_USE; }		

	function setDL_REG_DT($DL_REG_DT){ $this->DL_REG_DT = $DL_REG_DT; }		
	function getDL_REG_DT(){ return $this->DL_REG_DT; }		

	function setDL_REG_NO($DL_REG_NO){ $this->DL_REG_NO = $DL_REG_NO; }		
	function getDL_REG_NO(){ return $this->DL_REG_NO; }		

	function setDL_MOD_DT($DL_MOD_DT){ $this->DL_MOD_DT = $DL_MOD_DT; }		
	function getDL_MOD_DT(){ return $this->DL_MOD_DT; }		

	function setDL_MOD_NO($DL_MOD_NO){ $this->DL_MOD_NO = $DL_MOD_NO; }		
	function getDL_MOD_NO(){ return $this->DL_MOD_NO; }		
	/* DESIGN_LAYOUT TABLE */
	
	/* DESIGN_PRODPAGE_MGR TABLE */
	function setPV_NO($PV_NO){ $this->PV_NO = $PV_NO; }
	function getPV_NO(){ return $this->PV_NO; }
	
	function setPV_CODE($PV_CODE){ $this->PV_CODE = $PV_CODE; }
	function getPV_CODE(){ return $this->PV_CODE; }
	
	function setPV_PAGE($PV_PAGE){ $this->PV_PAGE = $PV_PAGE; }
	function getPV_PAGE(){ return $this->PV_PAGE; }
	
	function setPV_MODUL_TYPE($PV_MODUL_TYPE){ $this->PV_MODUL_TYPE = $PV_MODUL_TYPE; }
	function getPV_MODUL_TYPE(){ return $this->PV_MODUL_TYPE; }
	
	function setPV_DESIGN_NO($PV_DESIGN_NO){ $this->PV_DESIGN_NO = $PV_DESIGN_NO; }
	function getPV_DESIGN_NO(){ return $this->PV_DESIGN_NO; }
	
	function setPV_MODUL_NAME($PV_MODUL_NAME){ $this->PV_MODUL_NAME = $PV_MODUL_NAME; }
	function getPV_MODUL_NAME(){ return $this->PV_MODUL_NAME; }
	
	function setPV_IMAGE_FILE($PV_IMAGE_FILE){ $this->PV_IMAGE_FILE = $PV_IMAGE_FILE; }
	function getPV_IMAGE_FILE(){ return $this->PV_IMAGE_FILE; }
	
	function setPV_IMAGE_SIZE_W($PV_IMAGE_SIZE_W){ $this->PV_IMAGE_SIZE_W = $PV_IMAGE_SIZE_W; }
	function getPV_IMAGE_SIZE_W(){ return $this->PV_IMAGE_SIZE_W; }
	
	function setPV_IMAGE_SIZE_H($PV_IMAGE_SIZE_H){ $this->PV_IMAGE_SIZE_H = $PV_IMAGE_SIZE_H; }
	function getPV_IMAGE_SIZE_H(){ return $this->PV_IMAGE_SIZE_H; }
	
	function setPV_IMAGE_CNT_W($PV_IMAGE_CNT_W){ $this->PV_IMAGE_CNT_W = $PV_IMAGE_CNT_W; }
	function getPV_IMAGE_CNT_W(){ return $this->PV_IMAGE_CNT_W; }
	
	function setPV_IMAGE_CNT_H($PV_IMAGE_CNT_H){ $this->PV_IMAGE_CNT_H = $PV_IMAGE_CNT_H; }
	function getPV_IMAGE_CNT_H(){ return $this->PV_IMAGE_CNT_H; }
	
	function setPV_MODUL_TEXT($PV_MODUL_TEXT){ $this->PV_MODUL_TEXT = $PV_MODUL_TEXT; }
	function getPV_MODUL_TEXT(){ return $this->PV_MODUL_TEXT; }
	
	function setPV_LIST_CATE($PV_LIST_CATE){ $this->PV_LIST_CATE = $PV_LIST_CATE; }
	function getPV_LIST_CATE(){ return $this->PV_LIST_CATE; }
	
	function setPV_VIEW_FUNCTION($PV_VIEW_FUNCTION){ $this->PV_VIEW_FUNCTION = $PV_VIEW_FUNCTION; }
	function getPV_VIEW_FUNCTION(){ return $this->PV_VIEW_FUNCTION; }
	
	function setPV_USE($PV_USE){ $this->PV_USE = $PV_USE; }
	function getPV_USE(){ return $this->PV_USE; }
	
	function setPV_ORDER($PV_ORDER){ $this->PV_ORDER = $PV_ORDER; }
	function getPV_ORDER(){ return $this->PV_ORDER; }
	
	function setPV_REG_DT($PV_REG_DT){ $this->PV_REG_DT = $PV_REG_DT; }
	function getPV_REG_DT(){ return $this->PV_REG_DT; }
	
	function setPV_REG_NO($PV_REG_NO){ $this->PV_REG_NO = $PV_REG_NO; }
	function getPV_REG_NO(){ return $this->PV_REG_NO; }
	
	function setPV_MOD_DT($PV_MOD_DT){ $this->PV_MOD_DT = $PV_MOD_DT; }
	function getPV_MOD_DT(){ return $this->PV_MOD_DT; }
	
	function setPV_MOD_NO($PV_MOD_NO){ $this->PV_MOD_NO = $PV_MOD_NO; }
	function getPV_MOD_NO(){ return $this->PV_MOD_NO; }
	/* DESIGN_PRODPAGE_MGR TABLE */
	
	/* DESOGM_MGR TABLE */
	function setDM_NO($DM_NO){ $this->DM_NO = $DM_NO; }
	function getDM_NO(){ return $this->DM_NO; }
	
	function setDM_DESIGN_PAGE($DM_DESIGN_PAGE){ $this->DM_DESIGN_PAGE = $DM_DESIGN_PAGE; }
	function getDM_DESIGN_PAGE(){ return $this->DM_DESIGN_PAGE; }
	
	function setDM_DESIGN_GROUP($DM_DESIGN_GROUP){ $this->DM_DESIGN_GROUP = $DM_DESIGN_GROUP; }
	function getDM_DESIGN_GROUP(){ return $this->DM_DESIGN_GROUP; }
	
	function setDM_DESIGN_TYPE($DM_DESIGN_TYPE){ $this->DM_DESIGN_TYPE = $DM_DESIGN_TYPE; }
	function getDM_DESIGN_TYPE(){ return $this->DM_DESIGN_TYPE; }
	
	function setDM_DESIGN_CODE($DM_DESIGN_CODE){ $this->DM_DESIGN_CODE = $DM_DESIGN_CODE; }
	function getDM_DESIGN_CODE(){ return $this->DM_DESIGN_CODE; }
	
	function setDM_DESIGN_TITLE($DM_DESIGN_TITLE){ $this->DM_DESIGN_TITLE = $DM_DESIGN_TITLE; }
	function getDM_DESIGN_TITLE(){ return $this->DM_DESIGN_TITLE; }
	
	function setDM_DESIGN_TXT($DM_DESIGN_TXT){ $this->DM_DESIGN_TXT = $DM_DESIGN_TXT; }
	function getDM_DESIGN_TXT(){ return $this->DM_DESIGN_TXT; }
	
	function setDM_SAMPLE_LINK($DM_SAMPLE_LINK){ $this->DM_SAMPLE_LINK = $DM_SAMPLE_LINK; }
	function getDM_SAMPLE_LINK(){ return $this->DM_SAMPLE_LINK; }
	
	function setDM_SAMPLE_IMAGE_1($DM_SAMPLE_IMAGE_1){ $this->DM_SAMPLE_IMAGE_1 = $DM_SAMPLE_IMAGE_1; }
	function getDM_SAMPLE_IMAGE_1(){ return $this->DM_SAMPLE_IMAGE_1; }
	
	function setDM_SAMPLE_IMAGE_2($DM_SAMPLE_IMAGE_2){ $this->DM_SAMPLE_IMAGE_2 = $DM_SAMPLE_IMAGE_2; }
	function getDM_SAMPLE_IMAGE_2(){ return $this->DM_SAMPLE_IMAGE_2; }
	
	function setDM_REG_DT($DM_REG_DT){ $this->DM_REG_DT = $DM_REG_DT; }
	function getDM_REG_DT(){ return $this->DM_REG_DT; }
	
	function setDM_REG_NO($DM_REG_NO){ $this->DM_REG_NO = $DM_REG_NO; }
	function getDM_REG_NO(){ return $this->DM_REG_NO; }
	
	function setDM_MOD_DT($DM_MOD_DT){ $this->DM_MOD_DT = $DM_MOD_DT; }
	function getDM_MOD_DT(){ return $this->DM_MOD_DT; }
	
	function setDM_MOD_NO($DM_MOD_NO){ $this->DM_MOD_NO = $DM_MOD_NO; }
	function getDM_MOD_NO(){ return $this->DM_MOD_NO; }
	/* DESOGM_MGR TABLE */

	/* DESIGN_TOP_IMAGES TABLE */
	function setTI_NO($TI_NO){ $this->TI_NO = $TI_NO; }
	function getTI_NO(){ return $this->TI_NO; }
	
	function setTI_CATE_CODE($TI_CATE_CODE){ $this->TI_CATE_CODE = $TI_CATE_CODE; }
	function getTI_CATE_CODE(){ return $this->TI_CATE_CODE; }
	
	function setTI_TOP_IMAGE($TI_TOP_IMAGE){ $this->TI_TOP_IMAGE = $TI_TOP_IMAGE; }
	function getTI_TOP_IMAGE(){ return $this->TI_TOP_IMAGE; }
	
	function setTI_LEFT_IMAGE($TI_LEFT_IMAGE){ $this->TI_LEFT_IMAGE = $TI_LEFT_IMAGE; }
	function getTI_LEFT_IMAGE(){ return $this->TI_LEFT_IMAGE; }
	
	function setTI_HTML_TOP($TI_HTML_TOP){ $this->TI_HTML_TOP = $TI_HTML_TOP; }
	function getTI_HTML_TOP(){ return $this->TI_HTML_TOP; }
	
	function setTI_HTML_BOTTOM($TI_HTML_BOTTOM){ $this->TI_HTML_BOTTOM = $TI_HTML_BOTTOM; }
	function getTI_HTML_BOTTOM(){ return $this->TI_HTML_BOTTOM; }
	
	function setTI_REG_DT($TI_REG_DT){ $this->TI_REG_DT = $TI_REG_DT; }
	function getTI_REG_DT(){ return $this->TI_REG_DT; }
	
	function setTI_REG_NO($TI_REG_NO){ $this->TI_REG_NO = $TI_REG_NO; }
	function getTI_REG_NO(){ return $this->TI_REG_NO; }
	
	function setTI_MOD_DT($TI_MOD_DT){ $this->TI_MOD_DT = $TI_MOD_DT; }
	function getTI_MOD_DT(){ return $this->TI_MOD_DT; }
	
	function setTI_MOD_NO($TI_MOD_NO){ $this->TI_MOD_NO = $TI_MOD_NO; }
	function getTI_MOD_NO(){ return $this->TI_MOD_NO; }	
	/* DESIGN_TOP_IMAGES TABLE */
	
	/* DESIGN_BTN_IMAGES TABLE */
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
	/* DESIGN_BTN_IMAGES TABLE */

	/* SLIDING_BANNER */
	function setSB_NO($SB_NO){ $this->SB_NO = $SB_NO; }
	function getSB_NO(){ return $this->SB_NO; }
	
	function setSB_GROUP($SB_GROUP){ $this->SB_GROUP = $SB_GROUP; }
	function getSB_GROUP(){ return $this->SB_GROUP; }
	
	function setSB_DESIGN_CODE($SB_DESIGN_CODE){ $this->SB_DESIGN_CODE = $SB_DESIGN_CODE; }
	function getSB_DESIGN_CODE(){ return $this->SB_DESIGN_CODE; }
	
	function setSB_BANNER_NAME($SB_BANNER_NAME){ $this->SB_BANNER_NAME = $SB_BANNER_NAME; }
	function getSB_BANNER_NAME(){ return $this->SB_BANNER_NAME; }
	
	function setSB_IMAGES_CNT($SB_IMAGES_CNT){ $this->SB_IMAGES_CNT = $SB_IMAGES_CNT; }
	function getSB_IMAGES_CNT(){ return $this->SB_IMAGES_CNT; }
	
	function setSB_IMAGE_W($SB_IMAGE_W){ $this->SB_IMAGE_W = $SB_IMAGE_W; }
	function getSB_IMAGE_W(){ return $this->SB_IMAGE_W; }
	
	function setSB_IMAGE_H($SB_IMAGE_H){ $this->SB_IMAGE_H = $SB_IMAGE_H; }
	function getSB_IMAGE_H(){ return $this->SB_IMAGE_H; }
	
	function setSB_IMAGE_FILE_1($SB_IMAGE_FILE_1){ $this->SB_IMAGE_FILE_1 = $SB_IMAGE_FILE_1; }
	function getSB_IMAGE_FILE_1(){ return $this->SB_IMAGE_FILE_1; }
	
	function setSB_IMAGE_FILE_2($SB_IMAGE_FILE_2){ $this->SB_IMAGE_FILE_2 = $SB_IMAGE_FILE_2; }
	function getSB_IMAGE_FILE_2(){ return $this->SB_IMAGE_FILE_2; }
	
	function setSB_IMAGE_FILE_3($SB_IMAGE_FILE_3){ $this->SB_IMAGE_FILE_3 = $SB_IMAGE_FILE_3; }
	function getSB_IMAGE_FILE_3(){ return $this->SB_IMAGE_FILE_3; }
	
	function setSB_IMAGE_FILE_4($SB_IMAGE_FILE_4){ $this->SB_IMAGE_FILE_4 = $SB_IMAGE_FILE_4; }
	function getSB_IMAGE_FILE_4(){ return $this->SB_IMAGE_FILE_4; }
	
	function setSB_IMAGE_FILE_5($SB_IMAGE_FILE_5){ $this->SB_IMAGE_FILE_5 = $SB_IMAGE_FILE_5; }
	function getSB_IMAGE_FILE_5(){ return $this->SB_IMAGE_FILE_5; }
	
	function setSB_IMAGE_FILE_6($SB_IMAGE_FILE_6){ $this->SB_IMAGE_FILE_6 = $SB_IMAGE_FILE_6; }
	function getSB_IMAGE_FILE_6(){ return $this->SB_IMAGE_FILE_6; }
	
	function setSB_IMAGE_FILE_7($SB_IMAGE_FILE_7){ $this->SB_IMAGE_FILE_7 = $SB_IMAGE_FILE_7; }
	function getSB_IMAGE_FILE_7(){ return $this->SB_IMAGE_FILE_7; }
	
	function setSB_IMAGE_FILE_8($SB_IMAGE_FILE_8){ $this->SB_IMAGE_FILE_8 = $SB_IMAGE_FILE_8; }
	function getSB_IMAGE_FILE_8(){ return $this->SB_IMAGE_FILE_8; }
	
	function setSB_IMAGE_FILE_9($SB_IMAGE_FILE_9){ $this->SB_IMAGE_FILE_9 = $SB_IMAGE_FILE_9; }
	function getSB_IMAGE_FILE_9(){ return $this->SB_IMAGE_FILE_9; }
	
	function setSB_IMAGE_FILE_10($SB_IMAGE_FILE_10){ $this->SB_IMAGE_FILE_10 = $SB_IMAGE_FILE_10; }
	function getSB_IMAGE_FILE_10(){ return $this->SB_IMAGE_FILE_10; }
	
	function setSB_IMAGE_LINK_1($SB_IMAGE_LINK_1){ $this->SB_IMAGE_LINK_1 = $SB_IMAGE_LINK_1; }
	function getSB_IMAGE_LINK_1(){ return $this->SB_IMAGE_LINK_1; }
	
	function setSB_IMAGE_LINK_2($SB_IMAGE_LINK_2){ $this->SB_IMAGE_LINK_2 = $SB_IMAGE_LINK_2; }
	function getSB_IMAGE_LINK_2(){ return $this->SB_IMAGE_LINK_2; }
	
	function setSB_IMAGE_LINK_3($SB_IMAGE_LINK_3){ $this->SB_IMAGE_LINK_3 = $SB_IMAGE_LINK_3; }
	function getSB_IMAGE_LINK_3(){ return $this->SB_IMAGE_LINK_3; }
	
	function setSB_IMAGE_LINK_4($SB_IMAGE_LINK_4){ $this->SB_IMAGE_LINK_4 = $SB_IMAGE_LINK_4; }
	function getSB_IMAGE_LINK_4(){ return $this->SB_IMAGE_LINK_4; }
	
	function setSB_IMAGE_LINK_5($SB_IMAGE_LINK_5){ $this->SB_IMAGE_LINK_5 = $SB_IMAGE_LINK_5; }
	function getSB_IMAGE_LINK_5(){ return $this->SB_IMAGE_LINK_5; }
	
	function setSB_IMAGE_LINK_6($SB_IMAGE_LINK_6){ $this->SB_IMAGE_LINK_6 = $SB_IMAGE_LINK_6; }
	function getSB_IMAGE_LINK_6(){ return $this->SB_IMAGE_LINK_6; }
	
	function setSB_IMAGE_LINK_7($SB_IMAGE_LINK_7){ $this->SB_IMAGE_LINK_7 = $SB_IMAGE_LINK_7; }
	function getSB_IMAGE_LINK_7(){ return $this->SB_IMAGE_LINK_7; }
	
	function setSB_IMAGE_LINK_8($SB_IMAGE_LINK_8){ $this->SB_IMAGE_LINK_8 = $SB_IMAGE_LINK_8; }
	function getSB_IMAGE_LINK_8(){ return $this->SB_IMAGE_LINK_8; }
	
	function setSB_IMAGE_LINK_9($SB_IMAGE_LINK_9){ $this->SB_IMAGE_LINK_9 = $SB_IMAGE_LINK_9; }
	function getSB_IMAGE_LINK_9(){ return $this->SB_IMAGE_LINK_9; }
	
	function setSB_IMAGE_LINK_10($SB_IMAGE_LINK_10){ $this->SB_IMAGE_LINK_10 = $SB_IMAGE_LINK_10; }
	function getSB_IMAGE_LINK_10(){ return $this->SB_IMAGE_LINK_10; }
	
	function setSB_IMAGES_TITLE_1($SB_IMAGES_TITLE_1){ $this->SB_IMAGES_TITLE_1 = $SB_IMAGES_TITLE_1; }
	function getSB_IMAGES_TITLE_1(){ return $this->SB_IMAGES_TITLE_1; }
	
	function setSB_IMAGES_TITLE_2($SB_IMAGES_TITLE_2){ $this->SB_IMAGES_TITLE_2 = $SB_IMAGES_TITLE_2; }
	function getSB_IMAGES_TITLE_2(){ return $this->SB_IMAGES_TITLE_2; }
	
	function setSB_IMAGES_TITLE_3($SB_IMAGES_TITLE_3){ $this->SB_IMAGES_TITLE_3 = $SB_IMAGES_TITLE_3; }
	function getSB_IMAGES_TITLE_3(){ return $this->SB_IMAGES_TITLE_3; }
	
	function setSB_IMAGES_TITLE_4($SB_IMAGES_TITLE_4){ $this->SB_IMAGES_TITLE_4 = $SB_IMAGES_TITLE_4; }
	function getSB_IMAGES_TITLE_4(){ return $this->SB_IMAGES_TITLE_4; }
	
	function setSB_IMAGES_TITLE_5($SB_IMAGES_TITLE_5){ $this->SB_IMAGES_TITLE_5 = $SB_IMAGES_TITLE_5; }
	function getSB_IMAGES_TITLE_5(){ return $this->SB_IMAGES_TITLE_5; }
	
	function setSB_IMAGES_TITLE_6($SB_IMAGES_TITLE_6){ $this->SB_IMAGES_TITLE_6 = $SB_IMAGES_TITLE_6; }
	function getSB_IMAGES_TITLE_6(){ return $this->SB_IMAGES_TITLE_6; }
	
	function setSB_IMAGES_TITLE_7($SB_IMAGES_TITLE_7){ $this->SB_IMAGES_TITLE_7 = $SB_IMAGES_TITLE_7; }
	function getSB_IMAGES_TITLE_7(){ return $this->SB_IMAGES_TITLE_7; }
	
	function setSB_IMAGES_TITLE_8($SB_IMAGES_TITLE_8){ $this->SB_IMAGES_TITLE_8 = $SB_IMAGES_TITLE_8; }
	function getSB_IMAGES_TITLE_8(){ return $this->SB_IMAGES_TITLE_8; }
	
	function setSB_IMAGES_TITLE_9($SB_IMAGES_TITLE_9){ $this->SB_IMAGES_TITLE_9 = $SB_IMAGES_TITLE_9; }
	function getSB_IMAGES_TITLE_9(){ return $this->SB_IMAGES_TITLE_9; }
	
	function setSB_IMAGES_TITLE_10($SB_IMAGES_TITLE_10){ $this->SB_IMAGES_TITLE_10 = $SB_IMAGES_TITLE_10; }
	function getSB_IMAGES_TITLE_10(){ return $this->SB_IMAGES_TITLE_10; }
	
	function setSB_IMAGES_TXT_1($SB_IMAGES_TXT_1){ $this->SB_IMAGES_TXT_1 = $SB_IMAGES_TXT_1; }
	function getSB_IMAGES_TXT_1(){ return $this->SB_IMAGES_TXT_1; }
	
	function setSB_IMAGES_TXT_2($SB_IMAGES_TXT_2){ $this->SB_IMAGES_TXT_2 = $SB_IMAGES_TXT_2; }
	function getSB_IMAGES_TXT_2(){ return $this->SB_IMAGES_TXT_2; }
	
	function setSB_IMAGES_TXT_3($SB_IMAGES_TXT_3){ $this->SB_IMAGES_TXT_3 = $SB_IMAGES_TXT_3; }
	function getSB_IMAGES_TXT_3(){ return $this->SB_IMAGES_TXT_3; }
	
	function setSB_IMAGES_TXT_4($SB_IMAGES_TXT_4){ $this->SB_IMAGES_TXT_4 = $SB_IMAGES_TXT_4; }
	function getSB_IMAGES_TXT_4(){ return $this->SB_IMAGES_TXT_4; }
	
	function setSB_IMAGES_TXT_5($SB_IMAGES_TXT_5){ $this->SB_IMAGES_TXT_5 = $SB_IMAGES_TXT_5; }
	function getSB_IMAGES_TXT_5(){ return $this->SB_IMAGES_TXT_5; }
	
	function setSB_IMAGES_TXT_6($SB_IMAGES_TXT_6){ $this->SB_IMAGES_TXT_6 = $SB_IMAGES_TXT_6; }
	function getSB_IMAGES_TXT_6(){ return $this->SB_IMAGES_TXT_6; }
	
	function setSB_IMAGES_TXT_7($SB_IMAGES_TXT_7){ $this->SB_IMAGES_TXT_7 = $SB_IMAGES_TXT_7; }
	function getSB_IMAGES_TXT_7(){ return $this->SB_IMAGES_TXT_7; }
	
	function setSB_IMAGES_TXT_8($SB_IMAGES_TXT_8){ $this->SB_IMAGES_TXT_8 = $SB_IMAGES_TXT_8; }
	function getSB_IMAGES_TXT_8(){ return $this->SB_IMAGES_TXT_8; }
	
	function setSB_IMAGES_TXT_9($SB_IMAGES_TXT_9){ $this->SB_IMAGES_TXT_9 = $SB_IMAGES_TXT_9; }
	function getSB_IMAGES_TXT_9(){ return $this->SB_IMAGES_TXT_9; }
	
	function setSB_IMAGES_TXT_10($SB_IMAGES_TXT_10){ $this->SB_IMAGES_TXT_10 = $SB_IMAGES_TXT_10; }
	function getSB_IMAGES_TXT_10(){ return $this->SB_IMAGES_TXT_10; }
	
	function setSB_LINK_TARGET($SB_LINK_TARGET){ $this->SB_LINK_TARGET = $SB_LINK_TARGET; }
	function getSB_LINK_TARGET(){ return $this->SB_LINK_TARGET; }
	
	function setSB_REG_DT($SB_REG_DT){ $this->SB_REG_DT = $SB_REG_DT; }
	function getSB_REG_DT(){ return $this->SB_REG_DT; }
	
	function setSB_REG_NO($SB_REG_NO){ $this->SB_REG_NO = $SB_REG_NO; }
	function getSB_REG_NO(){ return $this->SB_REG_NO; }
	
	function setSB_MOD_DT($SB_MOD_DT){ $this->SB_MOD_DT = $SB_MOD_DT; }
	function getSB_MOD_DT(){ return $this->SB_MOD_DT; }
	
	function setSB_MOD_NO($SB_MOD_NO){ $this->SB_MOD_NO = $SB_MOD_NO; }
	function getSB_MOD_NO(){ return $this->SB_MOD_NO; }	
	/* SLIDING_BANNER */
	
	/* PUBLIC */
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
	/* PUBLIC */	
	
	/********************************** variable **********************************/

}

?>