<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: 심성일													|# 
#|작성일	: 2012-08-21												|# 
#|작성내용	: 슬라이딩 배너												|# 
#/*====================================================================*/# 

class SliderBannerMgr
{
	private $query;
	private $param;

	/********************************** List **********************************/
		function getSliderList($db)
		{
			$query  = "SELECT														";
			$query .= "	*															";
			$query .= "FROM ".TBL_SLIDING_BANNER."									";


			$query .= "ORDER BY SB_NO DESC ";

			return $db->getExecSql($query);
		}

		function getSliderTotal($db)
		{
			$query  = "SELECT														";
			$query .= "	COUNT(*)													";
			$query .= "FROM ".TBL_SLIDING_BANNER."									";
			

			if($this->getSearchKey()){
				if(!$wh){
					$query .= "WHERE SB_GROUP LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
				}else{
					$query .= "AND SB_GROUP LIKE '%".($this->getSearchKey())."%'		";
				}
			}

			return $db->getCount($query);
		}




	/********************************** Insert **********************************/
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


	/********************************** Insert **********************************/
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

	/********************************** view **********************************/
	function getSliderView($db)
	{
		$query  = "SELECT														";
		$query .= "	*															";
		$query .= "FROM ".TBL_SLIDING_BANNER."											";
		$query .= "WHERE SB_NO=".$this->getSB_NO()."							";
		return $db->getSelect($query);
	}

	/********************************** Insert **********************************/
	function getSliderDelete($db)
	{
		return $db->getDelete(TBL_SLIDING_BANNER," SB_NO=".mysql_real_escape_string($this->getSB_NO()));
	}


	/********************************** variable **********************************/
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