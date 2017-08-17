<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-06-05												|# 
#|작성내용	: 게시판관리												|# 
#/*====================================================================*/# 

class BoardMgr
{
	private $query;
	private $param;

/*################################################### BOARD_GROUP FUNCTION #######################################################*/

	/********************************** select **********************************/
	function getBoardGroupSelect($db, $op="LIST")
	{
//		$query = "SELECT * FROM ".TBL_BOARD_GRP." ORDER BY BG_NO ASC";

		if($op == "LIST")
		{
//			$query = "SELECT * FROM BOARD_GROUP ORDER BY BG_NO DESC";
			$query  = "SELECT BG_NO, BG_NAME, BG_FILE1, BG_FILE2, COUNT(B.B_GRP_NO) AS B_GRP_NO ";
			$query .= "FROM BOARD_GROUP ";
			$query .= "A LEFT OUTER JOIN BOARD_MGR B ON A.BG_NO = B.B_GRP_NO GROUP BY A.BG_NO ORDER BY BG_NO DESC";
		}
		else if ($op == "JUST")
			$query = "SELECT * FROM BOARD_GROUP WHERE BG_NO = " . $this->getBG_NO() . " ORDER BY BG_NO DESC";

		
		return $db->getExecSql($query);
	}

	/********************************** Insert **********************************/
	function getBoardGroupInsert($db)
	{
		$query = "CALL SP_BOARD_GROUP_I (?,?,?,?,?);";

		$param[]  = $this->getBG_NAME();
		$param[]  = $this->getBG_FILE1();
		$param[]  = $this->getBG_FILE2();
		$param[]  = $this->getBG_REG_DT();
		$param[]  = $this->getBG_REG_NO();



		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Update **********************************/
	function getBoardGroupUpdate($db)
	{
		$query = "CALL SP_BOARD_GROUP_U (?,?,?,?,?);";

		$param[]  = $this->getBG_NO();
		$param[]  = $this->getBG_NAME();
		$param[]  = $this->getBG_FILE1();
		$param[]  = $this->getBG_FILE2();
		$param[]  = $this->getBG_REG_NO();
		
		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** List **********************************/
	function getBoardList($db)
	{
		$query  = "SELECT A.* FROM " . TBL_BOARD_MGR . " AS A ";
		$query .= "LEFT OUTER JOIN " . TBL_BOARD_GROUP . " AS B ON A.B_GRP_NO = B.BG_NO ";
		$query .= "WHERE A.B_NO IS NOT NULL	";

		if($this->getB_USE()):
			$query .= "AND A.B_USE = 'N' ";
		else:
			$query .= "AND A.B_USE != 'N' ";
		endif;

		if($this->getB_GRP_NO()):
			$query .= "AND A.B_GRP_NO = {$this->getB_GRP_NO()} ";
		endif;

		$query .= "ORDER BY B_CODE ASC";

//		$query = "SELECT * FROM ".TBL_BOARD_MGR." ORDER BY B_CODE ASC";
//		$query = "SELECT A.*, B.BG_NAME FROM ".TBL_BOARD_MGR." A LEFT OUTER JOIN ".TBL_BOARD_GROUP." B ON A.B_GRP_NO = B.BG_NO WHERE A.B_USE == '" . $this->getB_USE() . "'	ORDER BY B_CODE ASC";
//		$query = "SELECT A.*, B.BG_NAME FROM ".TBL_BOARD_MGR." A LEFT OUTER JOIN ".TBL_BOARD_GROUP." B ON A.B_GRP_NO = B.BG_NO ORDER BY B_CODE ASC";
//		return $db->getExecSql($query);		/* 이중 mysql_fetch_array() 사용 할 수 없음.
		return $db->getArrayTotal($query);
	}

	function getCommCodeListEx($db)
	{
		$query			 = "SELECT A.* FROM " . TBL_COMM_CODE . " AS A									";
		$query			.= "LEFT OUTER JOIN " . TBL_COMM_GRP . " AS B ON A.CG_NO = B.CG_NO ";
		if ( $this->getCG_CODE() ) : 
			$query			.= "WHERE B.CG_CODE = '" . $this->getCG_CODE() . "'";
		endif;

		return $db->getExecSql($query);
	}

	function getCommCodeList($db)
	{
		if($this->getCG_NO())
			$query = "SELECT * FROM ".TBL_COMM_CODE." WHERE CG_NO = ".$this->getCG_NO()." ORDER BY CC_SORT ASC";
		else if($this->getCC_NO())
			$query = "SELECT * FROM ".TBL_COMM_CODE." WHERE CC_NO = ".$this->getCC_NO()." ORDER BY CC_SORT ASC";
//		return $db->getArrayTotal($query);
		return $db->getExecSql($query);
	}

	function getCommGrpList($db)
	{
			if ( !$this->getCG_CODE() ) :
				return -100;
			endif;

			$query  = "SELECT * FROM " . TBL_COMM_GRP . " WHERE CG_CODE  ='" . $this->getCG_CODE() . "'";

			return $db->getArrayTotal($query);
	}

	
	function getDataTotal($db) {
				 
		$query  = "SELECT COUNT(*) FROM ".$this->getTable()." A				";
		$query .= "	LEFT OUTER JOIN ".TBL_MEMBER_MGR." E ON A.B_W_NO = E.M_NO	";
		$query .= "LEFT OUTER JOIN " . TBL_PRODUCT_IMG . " AS D ON D.P_CODE = A.B_TMP1 ";
		$query .= "AND D.PM_TYPE = 'list'		";
		$query .= " WHERE A.B_NO IS NOT NULL	";

		/* 선택된 상품에 대한 게시물 가져오기 */
		if($this->getB_TMP1()) 
			$query .= " AND  A.B_TMP1 = '".$this->getB_TMP1()."'";

		if ( $this->getB_TMP5() ) :
			$query .= " AND  A.B_TMP5 = '".$this->getB_TMP5()."'";
		endif;

		if ( $this->getB_REPLY() != "Y" ) :
			//$query .= " AND  A.B_LEVEL = 0 ";
		endif;
		
		if ($this->getSearchKey()) {
			$strSearchField = ""; 
			switch($this->getSearchField()){
				case "S":
					$strSearchField = "A.B_TITLE";
				break;				
				case "T":
					$strSearchField = "A.B_TEXT";
				break;
				case "N":
					$strSearchField = "E.M_F_NAME";
				break;								
			}
			
			if ($strSearchField) {
				$query .=" AND ".$strSearchField." LIKE '%".$this->getSearchKey()."%'";		
			} else {
				$query .=" AND (A.B_TITLE LIKE '%".$this->getSearchKey()."%' OR A.B_TEXT  LIKE '%".$this->getSearchKey()."%')";
			}
		}
		
		if ($this->getSearchCat1())
			$query .= " AND A.B_CAT1 = ".$this->getSearchCat1();
		
//		return $query;
		return $db->getCount($query);
	}
	
	function getDataList($db) {
		
		$query  = "SELECT A.*, B.M_ID, B.M_NO,B.M_F_NAME, D.PM_REAL_NAME						";
		//$query .= " ,(SELECT COUNT(*) FROM ".TBL_COMM_FILE." WHERE F_TABLE = '".$this->getTable()."' ";
		//$query .= "   AND F_TABLE_KEY = A.B_NO) AS FILE_CNT					";
		$query .= ",C.F_FILE_PATH	";
		$query .= "FROM ".$this->getTable()." A									";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." B ON B.M_NO  =  A.B_W_NO	";
		$query .= "LEFT OUTER JOIN ".TBL_COMM_FILE." C ON C.F_TABLE = '".$this->getTable()."'	";
		$query .= "AND C.F_TABLE_KEY = A.B_NO	";
		$query .= "AND C.F_GUBUN = 1			";
		$query .= "LEFT OUTER JOIN " . TBL_PRODUCT_IMG . " AS D ON D.P_CODE = A.B_TMP1 ";
		$query .= "AND D.PM_TYPE = 'list'		";
		$query .= "	WHERE A.B_NO IS NOT NULL	";

		/* 선택된 상품에 대한 게시물 가져오기 */
		if($this->getB_TMP1()) 
			$query .= " AND  A.B_TMP1 = '".$this->getB_TMP1()."'";

		if ( $this->getB_TMP5() ) :
			$query .= " AND  A.B_TMP5 = '".$this->getB_TMP5()."'";
		endif;
		
		if ( $this->getB_REPLY() != "Y" ) :
			//$query .= " AND  A.B_LEVEL = 0 ";
		endif;

		if ($this->getSearchKey()) {
			$strSearchField = ""; 
			switch($this->getSearchField()){
				case "S":
					$strSearchField = "A.B_TITLE";
				break;
				case "T":
					$strSearchField = "A.B_TEXT";
				break;
				case "N":
					$strSearchField = "B.M_NAME";
				break;
			}

			if ($strSearchField){
				$query .=" AND ".$strSearchField." LIKE '%".$this->getSearchKey()."%'";
			} else {
				$query .=" AND (A.B_TITLE LIKE '%".$this->getSearchKey()."%' OR A.B_TEXT  LIKE '%".$this->getSearchKey()."%')";
			}
		}

		if ($this->getSearchCat1())
			$query .= " AND A.B_CAT1 = ".$this->getSearchCat1();

		
		$query  .= " ORDER BY A.B_COUNT DESC,A.B_STEP ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
//		echo $query;
//		return $query;
		return $result = $db->getExecSql($query);
	}

	function getBoardTableCnt($db)
	{
		$query  = "SELECT COUNT(*) FROM information_schema.tables ";
		$query .= "WHERE table_schema = '".$db->db."'";
		$query .= "	AND table_name = '".$this->getTable()."'";

		return $db->getCount($query);
	}
	/********************************** View **********************************/
	function getBoardView($db)
	{
		$query = "SELECT * FROM ".TBL_BOARD_MGR." WHERE B_NO = ".$this->getB_NO();
	
		return $db->getSelect($query);
	}

	function getBoardData($db)
	{
		if ( $this->getB_CODE() ) :
			$query = "SELECT * FROM " . TBL_BOARD_MGR . " WHERE B_CODE = '" . $this->getB_CODE() . "'";
		elseif ( $this->getB_NO() ) :
			$query = "SELECT * FROM " . TBL_BOARD_MGR . " WHERE B_NO = '" . $this->getB_NO() . "'";
		else :
			return -100;				//  쿼리문에 필요한 데이터 없음.
		endif;

		return $db->getArrayTotal($query);
	}
	
	function getDataView($db){

		$db->getExecSql("UPDATE ".$this->getTable()." SET B_READ=IFNULL(B_READ,0)+1 WHERE B_NO=".$this->getB_NO());
		
		$query  = "SELECT A.*,B.M_ID,B.M_F_NAME FROM ".$this->getTable()." A ";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." B ";
		$query .= "ON A.B_W_NO = B.M_NO WHERE A.B_NO=".$this->getB_NO();

		//return $query;
		return $db->getSelect($query);
	}

	function getDataOrgView($db)
	{
		$query  = "SELECT A.* FROM ".$this->getTable()." A	"; 
		$query .= "WHERE A.B_COUNT = ".$this->getB_COUNT();
		$query .= "	AND A.B_STEP < ".$this->getB_STEP();
		$query .= "	AND A.B_LEVEL < ".$this->getB_LEVEL();
		$query .= "	ORDER BY A.B_COUNT DESC,A.B_STEP ASC";

		return $db->getArrayTotal($query);
	}


	function getDataInfo($db){

		$query  = "SELECT A.*,B.M_ID,B.M_F_NAME, B.M_MAIL  FROM ".$this->getTable()." A ";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." B ";
		$query .= "ON A.B_W_NO = B.M_NO WHERE A.B_NO=".$this->getB_NO();

		//return $query;
		return $db->getSelect($query);
	}

	function getDataViewNext($db,$intNo) {
		$query  = "SELECT * FROM ".$this->getTable()." WHERE B_NO > $intNo ORDER BY B_NO ASC LIMIT 0,1";
		$row	= $db->getSelect($query);
		return $row;
	}

	function getDataViewPre($db,$intNo) {
		$query  = "SELECT * FROM ".$this->getTable()." WHERE B_NO < $intNo ORDER BY B_NO DESC LIMIT 0,1";
		$row	= $db->getSelect($query);
		return $row;
	}
	
	function getDataViewFile($db,$intNo){
		
		$query  = "SELECT * FROM ".TBL_COMM_FILE;
		$query .= "	WHERE F_TABLE		='".$this->getTable()."'";

		if ( $intNo ) :
			$query .= "	  AND F_TABLE_KEY	= " . $intNo						. "				";
		endif;

		if ( $this->getF_NO() ) :
			$query .= "	  AND F_NO	= " . $this->getF_NO()				. "				";
		endif;
		
		$query .= "		ORDER BY F_FILE_SORT ASC";
		return $db->getArrayTotal($query);
	}

	function getCommFileView($db)
	{
		$query  = "SELECT A.* FROM " . TBL_COMM_FILE . " AS A ";
		$query .= "WHERE A.F_NO IS NOT NULL	";

		if ( $this->getF_NO() ) :
			$query .= "	  AND A.F_NO	= " . $this->getF_NO()				. "				";
		endif;

		return $db->getSelect($query);
	}





	/********************************** COMM_CODE *****************************************/
//	function getCommCodeList($db)
//	{
//		// need the getCG_NO() value
//		$query = "SELECT * FROM ".TBL_COMM_VIEW." WHERE CG_NO = " . $this->getCG_NO() . " AND CC_USE = '" . "Y' ORDER BY CC_SORT ASC";
//
//		return $db->getArrayTotal($query);
//	}


	/********************************** COMM_CODE Insert **********************************/
	function getCommCodeInsert($db)
	{
		$query = "CALL SP_COMM_CODE_I (?,?,?,?,?,?,?,?);";

		$param[]  = $this->getCC_NO();
		$param[]  = $this->getCG_NO();
//		$param[]  = $this->getCC_CODE();
		$param[]  = $this->getCC_NAME();
		$param[]  = $this->getCC_SORT();
		$param[]  = $this->getCC_USE();
		$param[]  = $this->getCC_ETC();
		$param[]  = $this->getCC_IMG1();
		$param[]  = $this->getCC_IMG2();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** COMM_CODE Update **********************************/
	function getCommCodeUpdate($db)
	{
		$query = "CALL SP_COMM_CODE_U (?,?,?,?,?,?,?);";

		$param[]  = $this->getCC_NO();
		$param[]  = $this->getCC_NAME();
		$param[]  = $this->getCC_SORT();
		$param[]  = $this->getCC_USE();
		$param[]  = $this->getCC_ETC();
		$param[]  = $this->getCC_IMG1();
		$param[]  = $this->getCC_IMG2();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** COMM_CODE Delete **********************************/
	// 공통 코드 그룹 삭제
	function getCommGrpDelete($db)
	{
		if ( !$this->getCG_NO() ) :
			return -100;
		endif;

		$strCG_NO	= mysql_real_escape_string( $this->getCG_NO() );
		$where			=  "CG_NO=" . $strCG_NO;

		return $db->getDelete ( TBL_COMM_GRP , $where );
	}

	// 공통 코드 삭제
	function getCommCodeDeleteEx($db)
	{
		if ( !$this->getCG_NO() ) :
			return -100;
		endif;

		$strCG_NO	= mysql_real_escape_string( $this->getCG_NO() );
		$where			= "CG_NO=" . $strCG_NO;

		return $db->getDelete ( TBL_COMM_CODE , $where );
	}

	// 첨부 파일 DB 삭제
	function getCommFileDelete($db)
	{
		if ( $this->getF_TABLE() ) :
			$strF_TABLE		= mysql_real_escape_string( $this->getF_TABLE() );
			$where			= "F_TABLE= '{$strF_TABLE}'";
		elseif ( $this->getF_NO() ) :
			$strF_NO		= $this->getF_NO();
			$where			= "F_NO= '{$strF_NO}'";
		endif;
		
		if($where) :
			return $db->getDelete ( TBL_COMM_FILE , $where );
		else :
			return -100;
		endif;
	}
	
	function getCommCodeDelete($db)
	{
		$query = "CALL SP_COMM_CODE_D (?);";
		$param[]  = $this->getCC_NO();
		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Drop **********************************/
	
	function getDataBoardDrop($db)
	{
		/********************************* 주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!! *********************************/
		if ( !$this->getTable() ) :
			return -100;						//  쿼리문에 필요한 데이터 없음.
		endif;

		$query = "drop table {$this->getTable()}";
		return $db->getExecSql($query);
	}

	/**************************************************************************************/
	
	/********************************** COMM_CODE *****************************************/


	/********************************** Insert **********************************/
	function getBoardCodeChk($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_BOARD_MGR." WHERE B_CODE = '".$this->getB_CODE()."'";
	
		return $db->getCount($query);
	}
	
	function getBoardInsert($db)
	{
		$query = "CALL SP_BOARD_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getB_CODE();
		$param[]  = $this->getB_TYPE();
		$param[]  = $this->getB_TITLE();
		$param[]  = $this->getB_WIDTH();
		$param[]  = $this->getB_WIDTH_TYPE();
		$param[]  = $this->getB_LINE_CNT();
		$param[]  = $this->getB_PAGE_CNT();
		$param[]  = $this->getB_WRITE();
		$param[]  = $this->getB_WRITE_GROUP();
		$param[]  = $this->getB_LIST();
		$param[]  = $this->getB_LIST_GROUP();
		$param[]  = $this->getB_VIEW();
		$param[]  = $this->getB_VIEW_GROUP();
		$param[]  = $this->getB_REPLY();
		$param[]  = $this->getB_CMT();
		$param[]  = $this->getB_LOCK();
		$param[]  = $this->getB_SKIN();
		$param[]  = $this->getB_REG_NO();
		$param[]  = $this->getB_CAT();
		$param[]  = $this->getB_CAT_TYPE();
		$param[]  = $this->getB_GRP_USE();
		$param[]  = $this->getB_GRP_NO();
		$param[]  = $this->getB_TOP_HTML();
		$param[]  = $this->getB_BOTTOM_HTML();
		$param[]  = $this->getB_USE();
		$param[]  = $this->getB_WIDTH_IMG_CNT();
		$param[]  = $this->getB_IMG_SIZE();
		$param[]  = $this->getB_FILE_CNT();
		$param[]  = $this->getB_EDIT_USE();
		$param[]  = $this->getB_SNS_USE();

		return $db->executeBindingQuery($query,$param,true);
	}
	
	function getBoardCreate($db){
		$query  = "CREATE TABLE `".$this->getTable()."` (               ";
		$query .= "  `B_NO` bigint(20) NOT NULL auto_increment,         ";
		$query .= "  `B_NAME` varchar(20) default NULL,                 ";
		$query .= "  `B_PASS` varchar(20) default NULL,                 ";
		$query .= "  `B_MAIL` varchar(50) default NULL,                 ";
		$query .= "  `B_NOTICE` varchar(1) default NULL,                ";
		$query .= "  `B_TITLE` varchar(100) default NULL,               ";
		$query .= "  `B_TEXT` text,                                     ";
		$query .= "  `B_HTML` varchar(1) default NULL,                  ";
		$query .= "  `B_LOCK` varchar(1) default NULL,                  ";
		$query .= "  `B_LINK` varchar(50) default NULL,                 ";
		$query .= "  `B_READ` int(11) default NULL,                     ";
		$query .= "  `B_COUNT` bigint(20) default NULL,                 ";
		$query .= "  `B_STEP` bigint(20) default NULL,                  ";
		$query .= "  `B_LEVEL` bigint(20) default NULL,                 ";
		$query .= "  `B_CAT1` int(11) default NULL,                     ";
		$query .= "  `B_CAT2` int(11) default NULL,                     ";
		$query .= "  `B_CAT3` int(11) default NULL,                     ";
		$query .= "  `B_TMP1` varchar(50) default NULL,                 ";
		$query .= "  `B_TMP2` varchar(50) default NULL,                 ";
		$query .= "  `B_TMP3` varchar(50) default NULL,                 ";
		$query .= "  `B_TMP4` varchar(50) default NULL,                 ";
		$query .= "  `B_TMP5` varchar(50) default NULL,                 ";
		$query .= "  `B_IP` varchar(20) default NULL,                   ";
		$query .= "  `B_C_NO` int(11) default NULL,                     ";
		$query .= "  `B_W_NO` int(11) default NULL,                     ";
		$query .= "  `B_R_NO` int(11) default NULL,                     ";
		$query .= "  `B_REG_DT` datetime default NULL,                  ";
		$query .= "  PRIMARY KEY  (`B_NO`)                              ";
		$query .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='".$this->getB_TITLE()."';";
				
		return $db->getExecSql($query);
	}

	function getDataInsert($db)
	{

		/************************************** 공지사항 **************************************/
		if ($this->getB_NOTICE()=="Y") {
			$intMaxNum = $db->getCount("SELECT MAX(B_COUNT) FROM ".$this->getTable());
		} else {
			$intMaxNum = $db->getCount("SELECT MAX(B_COUNT) FROM ".$this->getTable()." WHERE IFNULL(B_NOTICE,'N') !='Y'");
			$db->getExecSql("UPDATE ".$this->getTable()." SET B_COUNT=B_COUNT+1 WHERE IFNULL(B_NOTICE,'N') ='Y'");
		}
		$intMaxNum++;

		$this->setB_COUNT($intMaxNum);
		$this->setB_STEP(0);
		$this->setB_LEVEL(0);
		/************************************** 공지사항 **************************************/
		$columnField  = " B_NAME";
		$columnField .= ",B_PASS";
		$columnField .= ",B_MAIL";
		$columnField .= ",B_NOTICE";
		$columnField .= ",B_TITLE";
		$columnField .= ",B_TEXT";
		$columnField .= ",B_HTML";
		$columnField .= ",B_LOCK";
		$columnField .= ",B_LINK";
		$columnField .= ",B_COUNT";
		$columnField .= ",B_STEP";
		$columnField .= ",B_LEVEL";
		$columnField .= ",B_IP";
		$columnField .= ",B_CAT1";
		$columnField .= ",B_CAT2";
		$columnField .= ",B_CAT3";
		$columnField .= ",B_TMP1";
		$columnField .= ",B_TMP2";
		$columnField .= ",B_TMP3";
		$columnField .= ",B_TMP4";
		$columnField .= ",B_TMP5";
		$columnField .= ",B_C_NO";
		$columnField .= ",B_W_NO";
		$columnField .= ",B_R_NO";
		$columnField .= ",B_REG_DT";

		$columnData  = " '".mysql_escape_string($this->getB_NAME())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_PASS())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_MAIL())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_NOTICE())	."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TITLE())	."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TEXT())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_HTML())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_LOCK())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_LINK())		."'";
		$columnData .= ",". $this->getB_COUNT();
		$columnData .= ",". $this->getB_STEP();
		$columnData .= ",". $this->getB_LEVEL();
		$columnData .= ",'".$this->getB_IP()							."'";
		$columnData .= "," .$this->getB_CAT1();
		$columnData .= "," .$this->getB_CAT2();
		$columnData .= "," .$this->getB_CAT3();
		$columnData .= ",'".mysql_escape_string($this->getB_TMP1())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TMP2())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TMP3())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TMP4())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TMP5())		."'";		
		$columnData .= ",". $this->getB_C_NO();
		$columnData .= ",". $this->getB_W_NO();
		$columnData .= ",". $this->getB_R_NO();
		$columnData .= ",NOW() ";
		
		return $db->getInsertSql($this->getTable(),$columnField,$columnData,true);
	}
	
	function getDataReply($db)
	{

		$row = $db->getSelect("SELECT * FROM ".$this->getTable()." WHERE B_NO=".$this->getB_NO());
		$this->setB_LOCK($row[B_LOCK]);
		
		/************************************** 답변글   **************************************/
		$db->getExecSql("UPDATE ".$this->getTable()." SET B_STEP=B_STEP+1 WHERE B_COUNT=$row[B_COUNT] AND B_STEP > $row[B_STEP]");
		$intStep  = $row[B_STEP]+1;
		$intLevel = $row[B_LEVEL]+1;
					
		$this->setB_COUNT($row[B_COUNT]);
		$this->setB_STEP($intStep);
		$this->setB_LEVEL($intLevel);
		/************************************** 답변글   **************************************/
		
		$columnField  = " B_NAME";
		$columnField .= ",B_PASS";
		$columnField .= ",B_MAIL";
		$columnField .= ",B_NOTICE";
		$columnField .= ",B_TITLE";
		$columnField .= ",B_TEXT";
		$columnField .= ",B_HTML";
		$columnField .= ",B_LOCK";
		$columnField .= ",B_LINK";
		$columnField .= ",B_COUNT";
		$columnField .= ",B_STEP";
		$columnField .= ",B_LEVEL";
		$columnField .= ",B_IP";
		$columnField .= ",B_CAT1";
		$columnField .= ",B_CAT2";
		$columnField .= ",B_CAT3";
		$columnField .= ",B_TMP1";
		$columnField .= ",B_TMP2";
		$columnField .= ",B_TMP3";
		$columnField .= ",B_TMP4";
		$columnField .= ",B_TMP5";
		$columnField .= ",B_C_NO";
		$columnField .= ",B_W_NO";
		$columnField .= ",B_R_NO";
		$columnField .= ",B_REG_DT";

		$columnData  = " '".mysql_escape_string($this->getB_NAME())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_PASS())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_MAIL())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_NOTICE())	."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TITLE())	."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TEXT())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_HTML())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_LOCK())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_LINK())		."'";
		$columnData .= ",". $this->getB_COUNT();
		$columnData .= ",". $this->getB_STEP();
		$columnData .= ",". $this->getB_LEVEL();
		$columnData .= ",'".$this->getB_IP()							."'";
		$columnData .= "," .$this->getB_CAT1();
		$columnData .= "," .$this->getB_CAT2();
		$columnData .= "," .$this->getB_CAT3();
		$columnData .= ",'".mysql_escape_string($this->getB_TMP1())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TMP2())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TMP3())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TMP4())		."'";
		$columnData .= ",'".mysql_escape_string($this->getB_TMP5())		."'";		
		$columnData .= ",". $this->getB_C_NO();
		$columnData .= ",". $this->getB_W_NO();
		$columnData .= ",". $this->getB_R_NO();
		$columnData .= ",NOW() ";

		
		return $db->getInsertSql($this->getTable(),$columnField,$columnData,true);
	}

	/********************************** Update **********************************/
	function getBoardUpdate($db)
	{
		$query = "CALL SP_BOARD_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getB_NO();
		$param[]  = $this->getB_TYPE();
		$param[]  = $this->getB_TITLE();
		$param[]  = $this->getB_WIDTH();
		$param[]  = $this->getB_WIDTH_TYPE();
		$param[]  = $this->getB_LINE_CNT();
		$param[]  = $this->getB_PAGE_CNT();
		$param[]  = $this->getB_WRITE();
		$param[]  = $this->getB_WRITE_GROUP();
		$param[]  = $this->getB_LIST();
		$param[]  = $this->getB_LIST_GROUP();
		$param[]  = $this->getB_VIEW();
		$param[]  = $this->getB_VIEW_GROUP();
		$param[]  = $this->getB_REPLY();
		$param[]  = $this->getB_CMT();
		$param[]  = $this->getB_LOCK();
		$param[]  = $this->getB_SKIN();
		$param[]  = $this->getB_CAT();
		$param[]  = $this->getB_CAT_TYPE();
		$param[]  = $this->getB_GRP_USE();
		$param[]  = $this->getB_GRP_NO();
		$param[]  = $this->getB_TOP_HTML();
		$param[]  = $this->getB_BOTTOM_HTML();
		$param[]  = $this->getB_USE();
		$param[]  = $this->getB_WIDTH_IMG_CNT();
		$param[]  = $this->getB_IMG_SIZE();
		$param[]  = $this->getB_FILE_CNT();
		$param[]  = $this->getB_EDIT_USE();
		$param[]  = $this->getB_SNS_USE();
		$param[]  = $this->getB_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getDataUpdate($db)
	{
		$updateField  = "  B_MAIL	= '".mysql_escape_string($this->getB_MAIL())	."'";
		
		if ( $this->getB_NAME() ) :
			$updateField .= ", B_NAME	= '".mysql_escape_string($this->getB_NAME())	."'";
		endif;

		if ( $this->getB_PASS() ) :
			$updateField .= ", B_PASS = '".mysql_escape_string($this->getB_PASS())	."'";
		endif;

		$updateField .= ", B_TITLE	= '".mysql_escape_string($this->getB_TITLE())	."'";
		$updateField .= ", B_TEXT	= '".mysql_escape_string($this->getB_TEXT())	."'";
		$updateField .= ", B_HTML	= '".mysql_escape_string($this->getB_HTML())	."'";
		$updateField .= ", B_NOTICE	= '".mysql_escape_string($this->getB_NOTICE())	."'";
		$updateField .= ", B_LOCK	= '".mysql_escape_string($this->getB_LOCK())	."'";
		$updateField .= ", B_LINK	= '".mysql_escape_string($this->getB_LINK())	."'";
		$updateField .= ", B_IP		= '".$this->getB_IP()."'";
		$updateField .= ", B_CAT1	= " .$this->getB_CAT1();
		$updateField .= ", B_CAT2	= " .$this->getB_CAT2();
		$updateField .= ", B_CAT3	= " .$this->getB_CAT3();
		$updateField .= ", B_TMP1	= '".mysql_escape_string($this->getB_TMP1())	."'";
		$updateField .= ", B_TMP2	= '".mysql_escape_string($this->getB_TMP2())	."'";
		$updateField .= ", B_TMP3	= '".mysql_escape_string($this->getB_TMP3())	."'";
		$updateField .= ", B_TMP4	= '".mysql_escape_string($this->getB_TMP4())	."'";
		$updateField .= ", B_TMP5	= '".mysql_escape_string($this->getB_TMP5())	."'";

		
		return $db->getUpdateSql($this->getTable(),$updateField, " Where B_NO=".$this->getB_NO());
	}
	
	function getBoardUseUpdate($db)
	{
		if(!$this->getB_NO() || !$this->getB_USE())	{ return -1; }

		$updateField = "B_USE = '".mysql_escape_string($this->getB_USE())	."'";

		return $db->getUpdateSql(TBL_BOARD_MGR,$updateField, " Where B_NO=".$this->getB_NO());

//		$query = "CALL SP_BOARD_MGR_D (?);";
//		$param[]  = $this->getB_NO();
//		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Delete **********************************/
	/*board list*/
	function getBoardDelete($db)
	{
		if ( !$this->getB_NO() ) :
			return -100;
		endif;

		$strB_NO		= mysql_real_escape_string( $this->getB_NO() );
		$where			=  "B_NO=" . $strB_NO;

		return $db->getDelete ( TBL_BOARD_MGR , $where );

//		if(!$this->getB_NO() || !$this->getB_USE())	{ return -1; }
//		$updateField = "B_USE = '".mysql_escape_string($this->getB_USE())	."'";
//		return $db->getUpdateSql(TBL_BOARD_MGR,$updateField, " Where B_NO=".$this->getB_NO());

//		$query = "CALL SP_BOARD_MGR_D (?);";
//		$param[]  = $this->getB_NO();
//		return $db->executeBindingQuery($query,$param,true);
	}
	
	/*data list*/
	function getDataDelete($db)
	{
		$row = $this->getDataView($db);

		/************************************** 답변글 **************************************/
		
		$intReplyChk = $db->getCount("SELECT COUNT(*) FROM ".$this->getTable()." WHERE B_COUNT=$row[B_COUNT] AND B_STEP=$row[B_STEP]+1 AND B_LEVEL=$row[B_LEVEL]+1");
		if ($intReplyChk>0) {
			return 0;					
		}
		/************************************** 답변글 **************************************/
		
		$result = $db->getDelete($this->getTable()," B_NO=".$this->getB_NO());
		if ($result) return 1;
	}

	/*group list*/
	function getBoardGroupDelete($db)
	{
		$query = "CALL SP_BOARD_GROUP_D (?);";
		$param[]  = $this->getBG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/* 게시판 등록시 메뉴관리 INSERT UPDATE */
	function getBoardMenuInsertUpdate($db)
	{
		$query = "CALL SP_BOARD_MENU_IU (?,?);";
		$param[]  = $this->getB_NO();
		if (!$this->getB_GRP_NO()) $this->setB_GRP_NO(0);
		$param[]  = $this->getB_GRP_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getBoardMenuDelete($db)
	{
		$query = "CALL SP_BOARD_MENU_D (?,?,?);";
		
		$param[]  = $this->getB_CODE();
		$param[]  = $this->getB_NAME();
		$param[]  = $this->getB_GRP_NAME();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** variable **********************************/
	function setB_NO($B_NO){ $this->B_NO = $B_NO; }		
	function getB_NO(){ return $this->B_NO; }		

	function setB_CODE($B_CODE){ $this->B_CODE = $B_CODE; }		
	function getB_CODE(){ return $this->B_CODE; }		

	function setB_TYPE($B_TYPE){ $this->B_TYPE = $B_TYPE; }		
	function getB_TYPE(){ return $this->B_TYPE; }		

	function setB_TITLE($B_TITLE){ $this->B_TITLE = $B_TITLE; }		
	function getB_TITLE(){ return $this->B_TITLE; }		

	function setB_WIDTH($B_WIDTH){ $this->B_WIDTH = $B_WIDTH; }		
	function getB_WIDTH(){ return $this->B_WIDTH; }		

	function setB_LINE_CNT($B_LINE_CNT){ $this->B_LINE_CNT = $B_LINE_CNT; }		
	function getB_LINE_CNT(){ return $this->B_LINE_CNT; }		

	function setB_PAGE_CNT($B_PAGE_CNT){ $this->B_PAGE_CNT = $B_PAGE_CNT; }		
	function getB_PAGE_CNT(){ return $this->B_PAGE_CNT; }		

	function setB_WRITE($B_WRITE){ $this->B_WRITE = $B_WRITE; }		
	function getB_WRITE(){ return $this->B_WRITE; }		

	function setB_WRITE_GROUP($B_WRITE_GROUP){ $this->B_WRITE_GROUP = $B_WRITE_GROUP; }		
	function getB_WRITE_GROUP(){ return $this->B_WRITE_GROUP; }		

	function setB_LIST($B_LIST){ $this->B_LIST = $B_LIST; }		
	function getB_LIST(){ return $this->B_LIST; }		

	function setB_LIST_GROUP($B_LIST_GROUP){ $this->B_LIST_GROUP = $B_LIST_GROUP; }		
	function getB_LIST_GROUP(){ return $this->B_LIST_GROUP; }		

	function setB_VIEW($B_VIEW){ $this->B_VIEW = $B_VIEW; }		
	function getB_VIEW(){ return $this->B_VIEW; }		

	function setB_VIEW_GROUP($B_VIEW_GROUP){ $this->B_VIEW_GROUP = $B_VIEW_GROUP; }		
	function getB_VIEW_GROUP(){ return $this->B_VIEW_GROUP; }		

	function setB_REPLY($B_REPLY){ $this->B_REPLY = $B_REPLY; }		
	function getB_REPLY(){ return $this->B_REPLY; }		

	function setB_CMT($B_CMT){ $this->B_CMT = $B_CMT; }		
	function getB_CMT(){ return $this->B_CMT; }		

	function setB_LOCK($B_LOCK){ $this->B_LOCK = $B_LOCK; }		
	function getB_LOCK(){ return $this->B_LOCK; }		

	function setB_SKIN($B_SKIN){ $this->B_SKIN = $B_SKIN; }		
	function getB_SKIN(){ return $this->B_SKIN; }	
	
	/* 2012.08.07 게시판 관리 -- 카테고리 / 그룹 추가 */
	function setB_CAT($B_CAT){ $this->B_CAT = $B_CAT; }		
	function getB_CAT(){ return $this->B_CAT; }		

	function setB_CAT_TYPE($B_CAT_TYPE){ $this->B_CAT_TYPE = $B_CAT_TYPE; }		
	function getB_CAT_TYPE(){ return $this->B_CAT_TYPE; }		

	function setB_GRP_USE($B_GRP_USE){ $this->B_GRP_USE = $B_GRP_USE; }		
	function getB_GRP_USE(){ return $this->B_GRP_USE; }		

	function setB_GRP_NO($B_GRP_NO){ $this->B_GRP_NO = $B_GRP_NO; }		
	function getB_GRP_NO(){ return $this->B_GRP_NO; }		

	function setB_GRP_NAME($B_GRP_NAME){ $this->B_GRP_NAME = $B_GRP_NAME; }		
	function getB_GRP_NAME(){ return $this->B_GRP_NAME; }		

	function setB_TOP_HTML($B_TOP_HTML){ $this->B_TOP_HTML = $B_TOP_HTML; }		
	function getB_TOP_HTML(){ return $this->B_TOP_HTML; }		

	function setB_BOTTOM_HTML($B_BOTTOM_HTML){ $this->B_BOTTOM_HTML = $B_BOTTOM_HTML; }		
	function getB_BOTTOM_HTML(){ return $this->B_BOTTOM_HTML; }		
	/* 2012.08.07 게시판 관리 -- 카테고리 / 그룹 추가 */

	function setB_REG_DT($B_REG_DT){ $this->B_REG_DT = $B_REG_DT; }		
	function getB_REG_DT(){ return $this->B_REG_DT; }		

	function setB_REG_NO($B_REG_NO){ $this->B_REG_NO = $B_REG_NO; }		
	function getB_REG_NO(){ return $this->B_REG_NO; }		

	function setB_MOD_DT($B_MOD_DT){ $this->B_MOD_DT = $B_MOD_DT; }		
	function getB_MOD_DT(){ return $this->B_MOD_DT; }		

	function setB_MOD_NO($B_MOD_NO){ $this->B_MOD_NO = $B_MOD_NO; }		
	function getB_MOD_NO(){ return $this->B_MOD_NO; }
	
	function setB_SNS_USE($B_SNS_USE){ $this->B_SNS_USE = $B_SNS_USE; }		
	function getB_SNS_USE(){ return $this->B_SNS_USE; }	


	/*--------------------------------------------------------------*/	
	function setB_NAME($B_NAME){ $this->B_NAME = $B_NAME; }		
	function getB_NAME(){ return $this->B_NAME; }		

	function setB_PASS($B_PASS){ $this->B_PASS = @crypt($B_PASS,"MALL"); }		
	function getB_PASS(){ return $this->B_PASS; }		

	function setB_MAIL($B_MAIL){ $this->B_MAIL = $B_MAIL; }		
	function getB_MAIL(){ return $this->B_MAIL; }		

	function setB_NOTICE($B_NOTICE){ $this->B_NOTICE = $B_NOTICE; }		
	function getB_NOTICE(){ return $this->B_NOTICE; }		

	function setB_TEXT($B_TEXT){ $this->B_TEXT = $B_TEXT; }		
	function getB_TEXT(){ return $this->B_TEXT; }		

	function setB_HTML($B_HTML){ $this->B_HTML = $B_HTML; }		
	function getB_HTML(){ return $this->B_HTML; }		

	function setB_LINK($B_LINK){ $this->B_LINK = $B_LINK; }		
	function getB_LINK(){ return $this->B_LINK; }		

	function setB_READ($B_READ){ $this->B_READ = $B_READ; }		
	function getB_READ(){ return $this->B_READ; }		

	function setB_COUNT($B_COUNT){ $this->B_COUNT = $B_COUNT; }		
	function getB_COUNT(){ return $this->B_COUNT; }		

	function setB_STEP($B_STEP){ $this->B_STEP = $B_STEP; }		
	function getB_STEP(){ return $this->B_STEP; }		

	function setB_LEVEL($B_LEVEL){ $this->B_LEVEL = $B_LEVEL; }		
	function getB_LEVEL(){ return $this->B_LEVEL; }		

	function setB_CAT1($B_CAT1){ $this->B_CAT1 = $B_CAT1; }		
	function getB_CAT1(){ return $this->B_CAT1; }		

	function setB_CAT2($B_CAT2){ $this->B_CAT2 = $B_CAT2; }		
	function getB_CAT2(){ return $this->B_CAT2; }		

	function setB_CAT3($B_CAT3){ $this->B_CAT3 = $B_CAT3; }		
	function getB_CAT3(){ return $this->B_CAT3; }		

	function setB_TMP1($B_TMP1){ $this->B_TMP1 = $B_TMP1; }		
	function getB_TMP1(){ return $this->B_TMP1; }		

	function setB_TMP2($B_TMP2){ $this->B_TMP2 = $B_TMP2; }		
	function getB_TMP2(){ return $this->B_TMP2; }		

	function setB_TMP3($B_TMP3){ $this->B_TMP3 = $B_TMP3; }		
	function getB_TMP3(){ return $this->B_TMP3; }		

	function setB_TMP4($B_TMP4){ $this->B_TMP4 = $B_TMP4; }		
	function getB_TMP4(){ return $this->B_TMP4; }		

	function setB_TMP5($B_TMP5){ $this->B_TMP5 = $B_TMP5; }		
	function getB_TMP5(){ return $this->B_TMP5; }		

	function setB_IP($B_IP){ $this->B_IP = $B_IP; }		
	function getB_IP(){ return $this->B_IP; }		

	function setB_C_NO($B_C_NO){ $this->B_C_NO = $B_C_NO; }		
	function getB_C_NO(){ return $this->B_C_NO; }		

	function setB_W_NO($B_W_NO){ $this->B_W_NO = $B_W_NO; }		
	function getB_W_NO(){ return $this->B_W_NO; }		

	function setB_R_NO($B_R_NO){ $this->B_R_NO = $B_R_NO; }		
	function getB_R_NO(){ return $this->B_R_NO; }	
	
	function setB_USE($B_USE) { $this->B_USE = $B_USE; }
	function getB_USE() { return $this->B_USE; }

	function setB_FILE_CNT($B_FILE_CNT) { $this->B_FILE_CNT = $B_FILE_CNT; }
	function getB_FILE_CNT() { return $this->B_FILE_CNT; }

	function setB_EDIT_USE($B_EDIT_USE) { $this->B_EDIT_USE = $B_EDIT_USE; }
	function getB_EDIT_USE() { return $this->B_EDIT_USE; }

	function setB_WIDTH_TYPE($B_WIDTH_TYPE){ $this->B_WIDTH_TYPE = $B_WIDTH_TYPE; }		
	function getB_WIDTH_TYPE(){ return $this->B_WIDTH_TYPE; }

	function setB_WIDTH_IMG_CNT($B_WIDTH_IMG_CNT){ $this->B_WIDTH_IMG_CNT = $B_WIDTH_IMG_CNT; }		
	function getB_WIDTH_IMG_CNT(){ return $this->B_WIDTH_IMG_CNT; }		

	function setB_IMG_SIZE($B_IMG_SIZE){ $this->B_IMG_SIZE = $B_IMG_SIZE; }		
	function getB_IMG_SIZE(){ return $this->B_IMG_SIZE; }	

	/*--------------------------------------------------------------*/	
	function setTable($TBL_NAME){ $this->TBL_NAME = $TBL_NAME; }		
	function getTable(){ return "BOARD_".STR_PAD($this->TBL_NAME,3,'0',str_pad_left); }

	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }

	function setSearchCat1($SEAECH_CAT1) {$this->SEAECH_CAT1 = $SEAECH_CAT1; }	
	function getSearchCat1(){ return $this->SEAECH_CAT1; }

	/********************************** variable **********************************/


	/********************************** COMM_CODE *****************************************/
	/********************************** variable **********************************/
	function setCG_CODE($CG_CODE){ $this->CG_CODE = $CG_CODE; }		
	function getCG_CODE(){ return $this->CG_CODE; }

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

	/********************************** variable **********************************/

	/* comm_file */
	function setF_NO($F_NO){ $this->F_NO = $F_NO; }		
	function getF_NO(){ return $this->F_NO; }		

	function setF_ORG_NAME($F_ORG_NAME){ $this->F_ORG_NAME = $F_ORG_NAME; }		
	function getF_ORG_NAME(){ return $this->F_ORG_NAME; }		

	function setF_SAVE_NAME($F_SAVE_NAME){ $this->F_SAVE_NAME = $F_SAVE_NAME; }		
	function getF_SAVE_NAME(){ return $this->F_SAVE_NAME; }		

	function setF_TABLE($F_TABLE){ $this->F_TABLE = $F_TABLE; }		
	function getF_TABLE(){ return $this->F_TABLE; }		

	function setF_TABLE_KEY($F_TABLE_KEY){ $this->F_TABLE_KEY = $F_TABLE_KEY; }		
	function getF_TABLE_KEY(){ return $this->F_TABLE_KEY; }		

	function setF_GUBUN($F_GUBUN){ $this->F_GUBUN = $F_GUBUN; }		
	function getF_GUBUN(){ return $this->F_GUBUN; }		

	function setF_FILE_PATH($F_FILE_PATH){ $this->F_FILE_PATH = $F_FILE_PATH; }		
	function getF_FILE_PATH(){ return $this->F_FILE_PATH; }		

	function setF_FILE_TYPE($F_FILE_TYPE){ $this->F_FILE_TYPE = $F_FILE_TYPE; }		
	function getF_FILE_TYPE(){ return $this->F_FILE_TYPE; }		

	function setF_FILE_SIZE($F_FILE_SIZE){ $this->F_FILE_SIZE = $F_FILE_SIZE; }		
	function getF_FILE_SIZE(){ return $this->F_FILE_SIZE; }		

	function setF_FILE_SORT($F_FILE_SORT){ $this->F_FILE_SORT = $F_FILE_SORT; }		
	function getF_FILE_SORT(){ return $this->F_FILE_SORT; }		

	function setF_REG_DT($F_REG_DT){ $this->F_REG_DT = $F_REG_DT; }		
	function getF_REG_DT(){ return $this->F_REG_DT; }

	/********************************** COMM_CODE *****************************************/


/*################################################### BOARD_GROUP VARIABLE ################################################################*/

	function setBG_NO($BG_NO){ $this->BG_NO = $BG_NO; }		
	function getBG_NO(){ return $this->BG_NO; }		

	function setBG_NAME($BG_NAME){ $this->BG_NAME = $BG_NAME; }		
	function getBG_NAME(){ return $this->BG_NAME; }		

	function setBG_FILE1($BG_FILE1){ $this->BG_FILE1 = $BG_FILE1; }		
	function getBG_FILE1(){ return $this->BG_FILE1; }		
	
	function setBG_FILE2($BG_FILE2){ $this->BG_FILE2 = $BG_FILE2; }		
	function getBG_FILE2(){ return $this->BG_FILE2; }		

	function setBG_REG_DT($BG_REG_DT){ $this->BG_REG_DT = $BG_REG_DT; }		
	function getBG_REG_DT(){ return $this->BG_REG_DT; }		

	function setBG_REG_NO($BG_REG_NO){ $this->BG_REG_NO = $BG_REG_NO; }		
	function getBG_REG_NO(){ return $this->BG_REG_NO; }

/*################################################### BOARD_GROUP VARIARLE ################################################################*/

}
?>