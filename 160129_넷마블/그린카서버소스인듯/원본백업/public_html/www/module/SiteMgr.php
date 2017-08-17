<?
#/*====================================================================*/#
#|작성자	: 박영미(ivetmi@naver.com)									|#
#|작성일	: 2012-05-11												|#
#|작성내용	: 쇼핑몰 기본설정 관리 										|#
#/*====================================================================*/#

class SiteMgr
{
	private $query;
	private $columnField;
	private $columnData;
	private $insert_id;


	/********************************** List **********************************/
	function getSiteCurTotal($db)
	{

		$query  = "SELECT						";
		$query .= "    COUNT(*)					";
		$query .= "FROM							";
		$query .= "(							";
		$query .= "    SELECT					";
		$query .= "        A.SCR_ST_DT			";
		$query .= "    FROM ".TBL_SITE_CUR." A	";
		$query .= "    GROUP BY A.SCR_ST_DT		";
		$query .= ") A							";

		return $db->getCount($query);
	}

	function getSiteCurList($db)
	{

		$query =    "SELECT					";
		$query .= "     A.SCR_ST_DT			";
		$query .= "    ,COUNT(*) CNT		";
		$query .= "FROM ".TBL_SITE_CUR." A  ";
		$query .= "GROUP BY A.SCR_ST_DT		";
		$query .= "ORDER BY A.SCR_ST_DT DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		return $db->getExecSql($query);
	}

	function getSiteInfo($db){
		//$query  = "SELECT * FROM ".TBL_SITE_MGR." ORDER BY S_NO ASC LIMIT 1	";
		//return $db->getSelect($query);

		$query  = "SELECT * FROM ".TBL_SITE_INFO." ";

		if ($this->getS_VIEW() == "N"){
			$query .= "WHERE VIEW = 'N'	";
		} else {
			$query .= "WHERE VIEW != 'N'	";
		}
		$query .= "ORDER BY NO ASC";
		return $db->getSiteInfoArray($query);
	}

	function getSiteTextView($db){
		$query  = "SELECT * FROM ".TBL_SITE_TEXT." ORDER BY NO ASC";

		return $db->getSiteInfoArray($query);
	}

	function getSiteInfoView($db){
		$query  = "SELECT * FROM ".TBL_SITE_INFO." ORDER BY NO ASC";
		return $db->getSiteInfoArray($query);
	}

	function getOneColInfo($db){
		$query  = "SELECT VAL FROM ".TBL_SITE_INFO." WHERE COL = '".$this->getS_COL()."'";

		return $db->getCount($query);
	}

	function getOneColText($db){
		$query  = "SELECT VAL FROM ".TBL_SITE_TEXT." WHERE COL = '".$this->getS_COL()."'";

		return $db->getCount($query);
	}

	function getSiteInfoArr($db)
	{
		$query  = "SELECT * FROM ".TBL_SITE_INFO." ORDER BY NO ASC";
		return $db->getArrayTotal($query);
	}

	function getSiteEventList($db){
		$query  = "SELECT											";
		$query .= "    A.*											";
		$query .= "FROM ".TBL_SITE_EVENT." A						";
		$query .= "WHERE A.SE_TYPE = 'N'							";
		$query .= "													";
		$query .= "UNION											";
		$query .= "													";
		$query .= "SELECT											";
		$query .= "    B.*											";
		$query .= "FROM ".TBL_SITE_EVENT." B						";
		$query .= "WHERE B.SE_TYPE = 'G'							";
		$query .= "AND NOW() BETWEEN B.SE_START_DT AND B.SE_END_DT	";
		$query .= "ORDER BY SE_NO ASC								";

		return $db->getArrayTotal($query);
	}

	/********************************** view **********************************/
	/* 공통관리 */
	function getSiteCommView($db)
	{
		$query  = "SELECT															";
		$query .= "	*																";
		$query .= "FROM ".TBL_SITE_COMM."											";
		$query .= "WHERE SC_NO=".$this->getSC_NO()."									";

		return $db->getSelect($query);
	}

	function getSiteCurView($db)
	{
		$query  = "SELECT															";
		$query .= "	*																";
		$query .= "FROM ".TBL_SITE_CUR."											";
		$query .= "WHERE SCR_ST_DT = '".$this->getSCR_ST_DT()."'					";

		return $db->getArrayTotal($query);
	}

	function getSiteUsdCurView($db)
	{
		$query  = "SELECT															";
		$query .= "	*																";
		$query .= "FROM ".TBL_SITE_CUR."											";
		$query .= "WHERE SCR_ST_DT = '".$this->getSCR_ST_DT()."'					";
		$query .= "	AND SCR_NAT = 'US'												";

		return $db->getArrayTotal($query);
	}

	/********************************** insert **********************************/
	function getSiteCommList($db)
	{
		$query  = "SELECT												";
		$query .= "	*													";
		$query .= "FROM ".TBL_SITE_COMM."								";

		/*--
		if($this->getSearchStatusY()=="Y"){
			$where = "'Y'												";
		}

		if($this->getSearchStatusN()=="N"){
			if ($where) $where .= ",";
			$where .= "'N'												";
		}

		if($where){
			$query .= "WHERE A_USE IN (".$where.")						";
		}
		--*/

		if($this->getSearchKey()){
			if(!$wh){
				$query .= "WHERE SC_TITLE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
			}else{
				$query .= "AND SC_TITLE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'		";
			}
		}

		$query .= "ORDER BY SC_NO DESC	LIMIT ".$this->getLimitFirst().",".$this->getPageLine();

		return $db->getExecSql($query);
	}

	/********************************** total **********************************/
	/* 공통관리 */
	function getSiteCommTotal($db)
	{
		$query  = "SELECT												";
		$query .= "	COUNT(*)											";
		$query .= "FROM ".TBL_SITE_COMM."								";

		/*--
		if($this->getSearchStatusY()=="Y"){
			$where = "'Y'												";
		}

		if($this->getSearchStatusN()=="N"){
			if ($where) $where .= ",";
			$where .= "'N'												";
		}

		if($where){
			$query .= "WHERE A_USE IN (".$where.")						";
		}
		--*/

		if($this->getSearchKey()){
			if(!$wh){
				$query .= "WHERE SC_TITLE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
			}else{
				$query .= "AND SC_TITLE LIKE '%".($this->getSearchKey())."%'		";
			}
		}

		return $db->getCount($query);
	}


	/********************************** Insert **********************************/
	/* 공통관리 */
	function getSiteCommInsert($db)
	{
//		$query = "CALL SP_SITE_COMM_I (?,?,?,?,?,?,?);";
		$query = "CALL SP_SITE_COMM_I (?,?,?,?);";

//		$param[]  = $this->getSC_NO();
		$param[]  = $this->getSC_TITLE();
		$param[]  = $this->getSC_TEXT();
		$param[]  = $this->getSC_REG_DT();
		$param[]  = $this->getSC_REG_NO();
//		$param[]  = $this->getSC_MOD_DT();
//		$param[]  = $this->getSC_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** update **********************************/
	/* 공통관리 */
	function getSiteCommUpdate($db)
	{
		$query = "CALL SP_SITE_COMM_U (?,?,?,?,?);";

		$param[]  = $this->getSC_NO();
		$param[]  = $this->getSC_TITLE();
		$param[]  = $this->getSC_TEXT();
		$param[]  = $this->getSC_MOD_DT();
		$param[]  = $this->getSC_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** delete **********************************/
	/* 공통관리 */
	function getSiteCommDelete($db)
	{
		return $db->getDelete(TBL_SITE_COMM," SC_NO=".mysql_real_escape_string($this->getSC_NO()));
	}

	function getDelRetHelpUpdate($db)
	{
		$query  = "  S_PROD_DELIVERY	= '".mysql_real_escape_string($this->getS_PROD_DELIVERY())."'";
		$query .= ", S_PROD_RETURN		= '".mysql_real_escape_string($this->getS_PROD_RETURN())."'";
		$query .= ", S_MOD_DT			= now()	";
		$query .= ", S_MOD_NO			= ".$this->getS_MOD_NO();

		return $db->getUpdateSql(TBL_SITE_MGR,$query, " Where S_NO = 1");
	}

	function getSmsMoneyUpdate($db)
	{
		$query  = "UPDATE ".TBL_SITE_INFO." SET VAL = IF(VAL > 0, VAL-1, 0)";
		$query .= "WHERE COL = 'S_SMS_MONEY'";

		return $db->getExecSql($query);
	}

	/* sms 사용 유무 */
	function getSmsUseUpdate($db)
	{
		$query  = "UPDATE ".TBL_SITE_INFO." SET VAL = '".mysql_real_escape_string($this->getS_SMS_USE())."'";
		$query .= "WHERE COL = 'S_SMS_USE'";
		return $db->getExecSql($query);
	}

	/* email 사용 유무 */
	function getEmailUseUpdate($db)
	{
		$query  = "UPDATE ".TBL_SITE_INFO." SET VAL = '".mysql_real_escape_string($this->getS_EMAIL_USE())."'";
		$query .= "WHERE COL = 'S_EMAIL_USE'";

		return $db->getExecSql($query);
	}

	/********************************** Delete **********************************/
	function getDelete($db)
	{
		return $db->getDelete(TBL_SITE_MGR," S_NO=".$this->getS_NO());
	}

	/********************************** Delivery Com InsertUpdate **********************************/
	function getDeliveryComInsertUpdate($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_COMM_CODE." WHERE CG_NO = 6 AND CC_CODE = '".$this->getCC_CODE()."'";
		$intDupCnt = $db->getCount($query);

		if ($intDupCnt == 0){

			$columnField  = " CC_NO";
			$columnField .= ",CG_NO";
			$columnField .= ",CC_CODE";
			$columnField .= ",CC_NAME_KR";
			$columnField .= ",CC_NAME_US";
			$columnField .= ",CC_NAME_CN";
			$columnField .= ",CC_NAME_JP";
			$columnField .= ",CC_NAME_ID";
			$columnField .= ",CC_NAME_FR";
			$columnField .= ",CC_NAME_ES";
			$columnField .= ",CC_NAME_RU";
			$columnField .= ",CC_NAME_DE";
			$columnField .= ",CC_SORT";
			$columnField .= ",CC_USE";
			$columnField .= ",CC_ETC";
//			$columnField .= ",CC_ABBR";

			$columnData  = "''";
			$columnData .= ",6";
			$columnData .= ",'".$this->getCC_CODE()."'";
			$columnData .= ",'".$this->getCC_NAME()."'";
			$columnData .= ",'".$this->getCC_NAME()."'";
			$columnData .= ",'".$this->getCC_NAME()."'";
			$columnData .= ",'".$this->getCC_NAME()."'";
			$columnData .= ",'".$this->getCC_NAME()."'";
			$columnData .= ",'".$this->getCC_NAME()."'";
			$columnData .= ",'".$this->getCC_NAME()."'";
			$columnData .= ",'".$this->getCC_NAME()."'";
			$columnData .= ",'".$this->getCC_NAME()."'";
			$columnData .= ",'".$this->getCC_SORT()."'";
			$columnData .= ",'Y'";
			$columnData .= ",'".$this->getCC_ETC()."'";
//			$columnData .= ",'".$this->getCC_ABBR()."'";

			return $db->getInsertSql(TBL_COMM_CODE,$columnField,$columnData,false);
		} else {

			$query  = "  CC_ETC			= '".mysql_real_escape_string($this->getCC_ETC())."'";
//			$query  .= "  ,CC_ABBR			= '".mysql_real_escape_string($this->getCC_ABBR())."'";

			return $db->getUpdateSql(TBL_COMM_CODE,$query, " Where CG_NO = 6 AND CC_CODE = '".$this->getCC_CODE()."'");
		}
	}

	function getDeliveryComDelete($db){
		$query = "DELETE FROM ".TBL_COMM_CODE." WHERE CG_NO = 6 AND CC_CODE NOT IN (".$this->getCC_CODE().")";
		return $db->getExecSql($query);

	}

	/********************************** Site Info InsertUpdate **********************************/
	function getSiteInfoInsertUpdate($db)
	{

		$query = "CALL SP_SITE_INFO_IU (?,?,?);";

		$param[]  = $this->getS_COL();
		$param[]  = $this->getS_VAL();
		$param[]  = $this->getS_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	function getSiteTextInsertUpdate($db)
	{

		$query = "CALL SP_SITE_TEXT_IU (?,?,?);";

		$param[]  = $this->getS_COL();
		$param[]  = $this->getS_VAL();
		$param[]  = $this->getS_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getSiteCurrencyInsertUpdate($db)
	{
		$query = "CALL SP_SITE_CUR_IU (?,?,?,?,?,?);";

		$param[]  = $this->getSCR_ST_DT();
		$param[]  = $this->getSCR_NAT();
		$param[]  = $this->getSCR_CUR();
		$param[]  = $this->getSCR_ST_CUR_RATE();
		$param[]  = $this->getSCR_SHOP_CUR_RATE();
		$param[]  = $this->getSCR_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Site COMM_GRP **********************************/
	function getSiteCommGrpSelectEx($db,$op="OP_LIST",$param)
	{
		$column["OP_ARYTOTAL"] = "*					";

		$query  = "SELECT ".$column[$op]." FROM ".TBL_COMM_GRP."		";
		$query .= "WHERE CG_NO IS NOT NULL										";

		if ($param['commCodeUseYN'] == "Y"){
			$query .= "AND CG_USE = 'Y'											";
		}

		if ($param['commCodeSearchKey']){
			$query .= "AND CG_CODE LIKE '".$param['commCodeSearchKey']."%'		";
		}

		return $this->getSelectQuery($db,$query,$op);
	}

	function getSiteCommCodeSelectEx($db,$op="OP_LIST",$param)
	{
		$column["OP_ARYTOTAL"] = "*				";

		$query  = "SELECT						";
		$query .= $column[$op];
		$query .= "FROM ".TBL_COMM_CODE."       ";
		$query .= "WHERE CG_NO = ".$param['CG_NO'];
		$query .= "    AND CC_USE = 'Y'			";
		$query .= "ORDER BY CC_SORT ASC			";

		return $this->getSelectQuery($db,$query,$op);
	}

	/********************************** Function **********************************/
	function getSelectQuery($db, $query, $op)
	{
		if ( $op == "OP_LIST" ) :
			return $db->getExecSql($query);
		elseif ( $op == "OP_SELECT" ) :
			return $db->getSelect($query);
		elseif ( $op == "OP_COUNT" ) :
			return $db->getCount($query);
		elseif ( $op == "OP_ARYLIST" ) :
			return $db->getArray($query);
		elseif ( $op == "OP_ARYTOTAL" ) :
			return $db->getArrayTotal($query);
		elseif ( $op == "OP_RESULT" ) :
			return $db->getResult($query);
		else :
			return -100;
		endif;
	}

	/********************************** variable **********************************/
	function setS_COL($S_COL){ $this->S_COL = $S_COL; }
	function getS_COL(){ return $this->S_COL; }

	function setS_VAL($S_VAL){ $this->S_VAL = $S_VAL; }
	function getS_VAL(){ return $this->S_VAL; }

	function setS_VIEW($S_VIEW){ $this->S_VIEW = $S_VIEW; }
	function getS_VIEW(){ return $this->S_VIEW; }

	function setS_NO($S_NO){ $this->S_NO = $S_NO; }
	function getS_NO(){ return $this->S_NO; }

	function setS_SITE_NM($S_SITE_NM){ $this->S_SITE_NM = $S_SITE_NM; }
	function getS_SITE_NM(){ return $this->S_SITE_NM; }

	function setS_SITE_ENG_NM($S_SITE_ENG_NM){ $this->S_SITE_ENG_NM = $S_SITE_ENG_NM; }
	function getS_SITE_ENG_NM(){ return $this->S_SITE_ENG_NM; }

	function setS_SITE_MAIL($S_SITE_MAIL){ $this->S_SITE_MAIL = $S_SITE_MAIL; }
	function getS_SITE_MAIL(){ return $this->S_SITE_MAIL; }

	function setS_SITE_URL($S_SITE_URL){ $this->S_SITE_URL = $S_SITE_URL; }
	function getS_SITE_URL(){ return $this->S_SITE_URL; }

	function setS_COM_NM($S_COM_NM){ $this->S_COM_NM = $S_COM_NM; }
	function getS_COM_NM(){ return $this->S_COM_NM; }

	function setS_COM_BUSI1($S_COM_BUSI1){ $this->S_COM_BUSI1 = $S_COM_BUSI1; }
	function getS_COM_BUSI1(){ return $this->S_COM_BUSI1; }

	function setS_COM_BUSI2($S_COM_BUSI2){ $this->S_COM_BUSI2 = $S_COM_BUSI2; }
	function getS_COM_BUSI2(){ return $this->S_COM_BUSI2; }

	function setS_COM_ZIP($S_COM_ZIP){ $this->S_COM_ZIP = $S_COM_ZIP; }
	function getS_COM_ZIP(){ return $this->S_COM_ZIP; }

	function setS_COM_ADDR($S_COM_ADDR){ $this->S_COM_ADDR = $S_COM_ADDR; }
	function getS_COM_ADDR(){ return $this->S_COM_ADDR; }

	function setS_COM_NUM1($S_COM_NUM1){ $this->S_COM_NUM1 = $S_COM_NUM1; }
	function getS_COM_NUM1(){ return $this->S_COM_NUM1; }

	function setS_COM_NUM2($S_COM_NUM2){ $this->S_COM_NUM2 = $S_COM_NUM2; }
	function getS_COM_NUM2(){ return $this->S_COM_NUM2; }

	function setS_REP_NM($S_REP_NM){ $this->S_REP_NM = $S_REP_NM; }
	function getS_REP_NM(){ return $this->S_REP_NM; }

	function setS_COM_PHONE($S_COM_PHONE){ $this->S_COM_PHONE = $S_COM_PHONE; }
	function getS_COM_PHONE(){ return $this->S_COM_PHONE; }

	function setS_COM_FAX($S_COM_FAX){ $this->S_COM_FAX = $S_COM_FAX; }
	function getS_COM_FAX(){ return $this->S_COM_FAX; }

	function setS_SITE_TITLE($S_SITE_TITLE){ $this->S_SITE_TITLE = $S_SITE_TITLE; }
	function getS_SITE_TITLE(){ return $this->S_SITE_TITLE; }

	function setS_SITE_KEYWORD($S_SITE_KEYWORD){ $this->S_SITE_KEYWORD = $S_SITE_KEYWORD; }
	function getS_SITE_KEYWORD(){ return $this->S_SITE_KEYWORD; }

	function setS_SITE_COPY($S_SITE_COPY){ $this->S_SITE_COPY = $S_SITE_COPY; }
	function getS_SITE_COPY(){ return $this->S_SITE_COPY; }

	function setS_USE_POLICY($S_USE_POLICY){ $this->S_USE_POLICY = $S_USE_POLICY; }
	function getS_USE_POLICY(){ return $this->S_USE_POLICY; }

	function setS_PERSON_POLICY($S_PERSON_POLICY){ $this->S_PERSON_POLICY = $S_PERSON_POLICY; }
	function getS_PERSON_POLICY(){ return $this->S_PERSON_POLICY; }

	function setS_AUTO_CANCEL($S_AUTO_CANCEL){ $this->S_AUTO_CANCEL = $S_AUTO_CANCEL; }
	function getS_AUTO_CANCEL(){ return $this->S_AUTO_CANCEL; }

	function setS_DELIVERY_ST($S_DELIVERY_ST){ $this->S_DELIVERY_ST = $S_DELIVERY_ST; }
	function getS_DELIVERY_ST(){ return $this->S_DELIVERY_ST; }

	function setS_DELIVERY_FREE($S_DELIVERY_FREE){ $this->S_DELIVERY_FREE = $S_DELIVERY_FREE; }
	function getS_DELIVERY_FREE(){ return $this->S_DELIVERY_FREE; }

	function setS_DELIVERY_FEE($S_DELIVERY_FEE){ $this->S_DELIVERY_FEE = $S_DELIVERY_FEE; }
	function getS_DELIVERY_FEE(){ return $this->S_DELIVERY_FEE; }

	function setS_DELIVERY_EXT($S_DELIVERY_EXT){ $this->S_DELIVERY_EXT = $S_DELIVERY_EXT; }
	function getS_DELIVERY_EXT(){ return $this->S_DELIVERY_EXT; }

	function setS_DELIVERY_EXT_AREA($S_DELIVERY_EXT_AREA){ $this->S_DELIVERY_EXT_AREA = $S_DELIVERY_EXT_AREA; }
	function getS_DELIVERY_EXT_AREA(){ return $this->S_DELIVERY_EXT_AREA; }

	function setS_DELIVERY_COM($S_DELIVERY_COM){ $this->S_DELIVERY_COM = $S_DELIVERY_COM; }
	function getS_DELIVERY_COM(){ return $this->S_DELIVERY_COM; }

	function setS_BANK($S_BANK){ $this->S_BANK = $S_BANK; }
	function getS_BANK(){ return $this->S_BANK; }

	function setS_SETTLE($S_SETTLE){ $this->S_SETTLE = $S_SETTLE; }
	function getS_SETTLE(){ return $this->S_SETTLE; }

	function setS_PG($S_PG){ $this->S_PG = $S_PG; }
	function getS_PG(){ return $this->S_PG; }

	function setS_POINT_USE1($S_POINT_USE1){ $this->S_POINT_USE1 = $S_POINT_USE1; }
	function getS_POINT_USE1(){ return $this->S_POINT_USE1; }

	function setS_POINT_USE2($S_POINT_USE2){ $this->S_POINT_USE2 = $S_POINT_USE2; }
	function getS_POINT_USE2(){ return $this->S_POINT_USE2; }

	function setS_POINT_ORDER_STATUS($S_POINT_ORDER_STATUS){ $this->S_POINT_ORDER_STATUS = $S_POINT_ORDER_STATUS; }
	function getS_POINT_ORDER_STATUS(){ return $this->S_POINT_ORDER_STATUS; }

	function setS_POINT_ST($S_POINT_ST){ $this->S_POINT_ST = $S_POINT_ST; }
	function getS_POINT_ST(){ return $this->S_POINT_ST; }

	function setS_POINT_ST_PRICE($S_POINT_ST_PRICE){ $this->S_POINT_ST_PRICE = $S_POINT_ST_PRICE; }
	function getS_POINT_ST_PRICE(){ return $this->S_POINT_ST_PRICE; }

	function setS_POINT_PRICE($S_POINT_PRICE){ $this->S_POINT_PRICE = $S_POINT_PRICE; }
	function getS_POINT_PRICE(){ return $this->S_POINT_PRICE; }

	function setS_POINT_PRICE_UNIT($S_POINT_PRICE_UNIT){ $this->S_POINT_PRICE_UNIT = $S_POINT_PRICE_UNIT; }
	function getS_POINT_PRICE_UNIT(){ return $this->S_POINT_PRICE_UNIT; }

	function setS_POINT_PRICE_POS($S_POINT_PRICE_POS){ $this->S_POINT_PRICE_POS = $S_POINT_PRICE_POS; }
	function getS_POINT_PRICE_POS(){ return $this->S_POINT_PRICE_POS; }

	function setS_POINT_MIN($S_POINT_MIN){ $this->S_POINT_MIN = $S_POINT_MIN; }
	function getS_POINT_MIN(){ return $this->S_POINT_MIN; }

	function setS_POINT_MAX($S_POINT_MAX){ $this->S_POINT_MAX = $S_POINT_MAX; }
	function getS_POINT_MAX(){ return $this->S_POINT_MAX; }

	function setS_POINT_COUPON_USE($S_POINT_COUPON_USE){ $this->S_POINT_COUPON_USE = $S_POINT_COUPON_USE; }
	function getS_POINT_COUPON_USE(){ return $this->S_POINT_COUPON_USE; }

	function setS_PROD_DELIVERY($S_PROD_DELIVERY){ $this->S_PROD_DELIVERY = $S_PROD_DELIVERY; }
	function getS_PROD_DELIVERY(){ return $this->S_PROD_DELIVERY; }

	function setS_PROD_RETURN($S_PROD_RETURN){ $this->S_PROD_RETURN = $S_PROD_RETURN; }
	function getS_PROD_RETURN(){ return $this->S_PROD_RETURN; }

	function setS_SMS_USE($S_SMS_USE){ $this->S_SMS_USE = $S_SMS_USE; }
	function getS_SMS_USE(){ return $this->S_SMS_USE; }

	function setS_SMS_MONEY($S_SMS_MONEY){ $this->S_SMS_MONEY = $S_SMS_MONEY; }
	function getS_SMS_MONEY(){ return $this->S_SMS_MONEY; }

	function setS_EMAIL_USE($S_EMAIL_USE){ $this->S_EMAIL_USE = $S_EMAIL_USE; }
	function getS_EMAIL_USE(){ return $this->S_EMAIL_USE; }

	function setS_PG_SITE_CODE($S_PG_SITE_CODE){ $this->S_PG_SITE_CODE = $S_PG_SITE_CODE; }
	function getS_PG_SITE_CODE(){ return $this->S_PG_SITE_CODE; }

	function setS_PG_SITE_KEY($S_PG_SITE_KEY){ $this->S_PG_SITE_KEY = $S_PG_SITE_KEY; }
	function getS_PG_SITE_KEY(){ return $this->S_PG_SITE_KEY; }

	function setS_PIM_NAME($S_PIM_NAME){ $this->S_PIM_NAME = $S_PIM_NAME; }
	function getS_PIM_NAME(){ return $this->S_PIM_NAME; }

	function setS_PIM_HP($S_PIM_HP){ $this->S_PIM_HP = $S_PIM_HP; }
	function getS_PIM_HP(){ return $this->S_PIM_HP; }

	function setS_PIM_MAIL($S_PIM_MAIL){ $this->S_PIM_MAIL = $S_PIM_MAIL; }
	function getS_PIM_MAIL(){ return $this->S_PIM_MAIL; }

	function setS_REG_DT($S_REG_DT){ $this->S_REG_DT = $S_REG_DT; }
	function getS_REG_DT(){ return $this->S_REG_DT; }

	function setS_REG_NO($S_REG_NO){ $this->S_REG_NO = $S_REG_NO; }
	function getS_REG_NO(){ return $this->S_REG_NO; }

	function setS_MOD_DT($S_MOD_DT){ $this->S_MOD_DT = $S_MOD_DT; }
	function getS_MOD_DT(){ return $this->S_MOD_DT; }

	function setS_MOD_NO($S_MOD_NO){ $this->S_MOD_NO = $S_MOD_NO; }
	function getS_MOD_NO(){ return $this->S_MOD_NO; }

	/*******************************************************************************/
	// 검색

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

	/*******************************************************************************/
	// 공통 관리

	function setSC_NO($SC_NO){ $this->SC_NO = $SC_NO; }
	function getSC_NO(){ return $this->SC_NO; }

	function setSC_TITLE($SC_TITLE){ $this->SC_TITLE = $SC_TITLE; }
	function getSC_TITLE(){ return $this->SC_TITLE; }

	function setSC_TEXT($SC_TEXT){ $this->SC_TEXT = $SC_TEXT; }
	function getSC_TEXT(){ return $this->SC_TEXT; }

	function setSC_REG_DT($SC_REG_DT){ $this->SC_REG_DT = $SC_REG_DT; }
	function getSC_REG_DT(){ return $this->SC_REG_DT; }

	function setSC_REG_NO($SC_REG_NO){ $this->SC_REG_NO = $SC_REG_NO; }
	function getSC_REG_NO(){ return $this->SC_REG_NO; }

	function setSC_MOD_DT($SC_MOD_DT){ $this->SC_MOD_DT = $SC_MOD_DT; }
	function getSC_MOD_DT(){ return $this->SC_MOD_DT; }

	function setSC_MOD_NO($SC_MOD_NO){ $this->SC_MOD_NO = $SC_MOD_NO; }
	function getSC_MOD_NO(){ return $this->SC_MOD_NO; }

	/*******************************************************************************/
	//공통코드
	function setCC_NO($CC_NO){ $this->CC_NO = $CC_NO; }
	function getCC_NO(){ return $this->CC_NO; }

	function setCG_NO($CG_NO){ $this->CG_NO = $CG_NO; }
	function getCG_NO(){ return $this->CG_NO; }

	function setCC_CODE($CC_CODE){ $this->CC_CODE = $CC_CODE; }
	function getCC_CODE(){ return $this->CC_CODE; }

	function setCC_NAME($CC_NAME){ $this->CC_NAME = $CC_NAME; }
	function getCC_NAME(){ return $this->CC_NAME; }

	function setCC_SORT($CC_SORT){ $this->CC_SORT = $CC_SORT; }
	function getCC_SORT(){ return $this->CC_SORT; }

	function setCC_USE($CC_USE){ $this->CC_USE = $CC_USE; }
	function getCC_USE(){ return $this->CC_USE; }

	function setCC_ETC($CC_ETC){ $this->CC_ETC = $CC_ETC; }
	function getCC_ETC(){ return $this->CC_ETC; }

	function setCC_IMG1($CC_IMG1){ $this->CC_IMG1 = $CC_IMG1; }
	function getCC_IMG1(){ return $this->CC_IMG1; }

	function setCC_IMG2($CC_IMG2){ $this->CC_IMG2 = $CC_IMG2; }
	function getCC_IMG2(){ return $this->CC_IMG2; }

	function setCC_ABBR($CC_ABBR){ $this->CC_ABBR = $CC_ABBR; }
	function getCC_ABBR(){ return $this->CC_ABBR; }
	/*******************************************************************************/
	// 통화 관리

	function setSCR_NO($SCR_NO){ $this->SCR_NO = $SCR_NO; }
	function getSCR_NO(){ return $this->SCR_NO; }

	function setSCR_ST_DT($SCR_ST_DT){ $this->SCR_ST_DT = $SCR_ST_DT; }
	function getSCR_ST_DT(){ return $this->SCR_ST_DT; }

	function setSCR_NAT($SCR_NAT){ $this->SCR_NAT = $SCR_NAT; }
	function getSCR_NAT(){ return $this->SCR_NAT; }

	function setSCR_CUR($SCR_CUR){ $this->SCR_CUR = $SCR_CUR; }
	function getSCR_CUR(){ return $this->SCR_CUR; }

	function setSCR_ST_CUR_RATE($SCR_ST_CUR_RATE){ $this->SCR_ST_CUR_RATE = $SCR_ST_CUR_RATE; }
	function getSCR_ST_CUR_RATE(){ return $this->SCR_ST_CUR_RATE; }

	function setSCR_SHOP_CUR_RATE($SCR_SHOP_CUR_RATE){ $this->SCR_SHOP_CUR_RATE = $SCR_SHOP_CUR_RATE; }
	function getSCR_SHOP_CUR_RATE(){ return $this->SCR_SHOP_CUR_RATE; }

	function setSCR_REG_DT($SCR_REG_DT){ $this->SCR_REG_DT = $SCR_REG_DT; }
	function getSCR_REG_DT(){ return $this->SCR_REG_DT; }

	function setSCR_REG_NO($SCR_REG_NO){ $this->SCR_REG_NO = $SCR_REG_NO; }
	function getSCR_REG_NO(){ return $this->SCR_REG_NO; }

	function setSCR_MOD_DT($SCR_MOD_DT){ $this->SCR_MOD_DT = $SCR_MOD_DT; }
	function getSCR_MOD_DT(){ return $this->SCR_MOD_DT; }

	function setSCR_MOD_NO($SCR_MOD_NO){ $this->SCR_MOD_NO = $SCR_MOD_NO; }
	function getSCR_MOD_NO(){ return $this->SCR_MOD_NO; }
	/*--------------------------------------------------------------*/



	/********************************** variable **********************************/

}
?>