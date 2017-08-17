<?
	require_once MALL_CONF_LIB."WebLogMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_PROD_FUNC;

	$webLogMgr = new WebLogMgr();
	$siteMgr = new SiteMgr();
	
	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;		

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	$strSearchHCode1		= $_POST["searchCateHCode1"]		? $_POST["searchCateHCode1"]		: $_REQUEST["searchCateHCode1"];
	$strSearchHCode2		= $_POST["searchCateHCode2"]		? $_POST["searchCateHCode2"]		: $_REQUEST["searchCateHCode2"];
	$strSearchHCode3		= $_POST["searchCateHCode3"]		? $_POST["searchCateHCode3"]		: $_REQUEST["searchCateHCode3"];
	$strSearchHCode4		= $_POST["searchCateHCode4"]		? $_POST["searchCateHCode4"]		: $_REQUEST["searchCateHCode4"];

	$strSearchSettleC		= $_POST["searchSettleC"]	? $_POST["searchSettleC"]	: $_REQUEST["searchSettleC"];
	$strSearchSettleA		= $_POST["searchSettleA"]	? $_POST["searchSettleA"]	: $_REQUEST["searchSettleA"];
	$strSearchSettleT		= $_POST["searchSettleT"]	? $_POST["searchSettleT"]	: $_REQUEST["searchSettleT"];
	$strSearchSettleB		= $_POST["searchSettleB"]	? $_POST["searchSettleB"]	: $_REQUEST["searchSettleB"];
	$strSearchSettleY		= $_POST["searchSettleY"]	? $_POST["searchSettleY"]	: $_REQUEST["searchSettleY"];
	$strSearchSettleX		= $_POST["searchSettleX"]	? $_POST["searchSettleX"]	: $_REQUEST["searchSettleX"];

	$strSearchRegStartDt	= $_POST["searchRegStartDt"]	? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt		= $_POST["searchRegEndDt"]		? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];

	$strSearchStartYear		= $_POST["searchStartYear"]		? $_POST["searchStartYear"]		: $_REQUEST["searchStartYear"];
	$strSearchStartMonth	= $_POST["searchStartMonth"]	? $_POST["searchStartMonth"]	: $_REQUEST["searchStartMonth"];
	$strSearchStartDay		= $_POST["searchStartDay"]		? $_POST["searchStartDay"]		: $_REQUEST["searchStartDay"];

	$strSearchEndYear		= $_POST["searchEndYear"]		? $_POST["searchEndYear"]		: $_REQUEST["searchEndYear"];
	$strSearchEndMonth		= $_POST["searchEndMonth"]		? $_POST["searchEndMonth"]		: $_REQUEST["searchEndMonth"];
	$strSearchEndDay		= $_POST["searchEndDay"]		? $_POST["searchEndDay"]		: $_REQUEST["searchEndDay"];

	$strSearchShop			= $_POST["searchShop"]			? $_POST["searchShop"]			: $_REQUEST["searchShop"];

	$strOrderBySort			= $_POST["orderBySort"]			? $_POST["orderBySort"]			: $_REQUEST["orderBySort"];	
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || SUBSTR($strMode,0,3) == "pop" || $strMode == "excel"){

		include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/
	
	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "008";
	/* 관리자 권한 설정 */
	
	$webLogMgr->setLogLng($strAdmSiteLng);

	function getTotalDay($year,$month) { 
		$day = 1; 
		while(checkdate($month,$day,$year)) { 
			$day ++ ; 
		} 
		$day--; 
		return $day; 
	}

	if (substr($strMode,0,5) == "visit"){
		$tb_counter = "LOG_COUNT_".date("Y");
		$tb_referer = "LOG_REFERER_".date("Y");

		$query = "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".$db->db."' AND table_name = '".$tb_counter."'";
		$cnt = $db->getCount($query);
		if ($cnt == 0){
			$query  = "CREATE TABLE ".$tb_counter." (         ";
			$query .= "  `NO` int(11) NOT NULL auto_increment, ";
			$query .= "  `CODE` VARCHAR(2) default NULL,       ";
			$query .= "  `Y` smallint(6) default NULL,         ";
			$query .= "  `M` tinyint(4) default NULL,          ";
			$query .= "  `D` tinyint(4) default NULL,          ";
			$query .= "  `H` tinyint(4) default NULL,          ";
			$query .= "  `CNT` int(11) default NULL,           ";
			$query .= "  PRIMARY KEY  (`NO`),                  ";
			$query .= "  KEY `IDX_Y` (`Y`),";
			$query .= "  KEY `IDX_M` (`M`),";
			$query .= "  KEY `IDX_D` (`D`),";
			$query .= "  KEY `IDX_H` (`H`)";
			$query .= ")";
			
			$db->getExecSql($query);
		}
		
		$query = "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".$db->db."' AND table_name = '".$tb_referer."'";
		$cnt = $db->getCount($query);
		if ($cnt == 0){
			
			$query  = "CREATE TABLE `".$tb_referer."` (        ";
			$query .= "  `NO` int(11) NOT NULL auto_increment,";
			$query .= "  `IP` varchar(64) default NULL,     ";
			$query .= "  `Y` smallint(6) default NULL,         ";
			$query .= "  `M` tinyint(4) default NULL,          ";
			$query .= "  `D` tinyint(4) default NULL,          ";
			$query .= "  `H` tinyint(4) default NULL,          ";
			$query .= "  `SCHEME` varchar(8) default NULL,     ";
			$query .= "  `HOST` varchar(32) default NULL,     ";
			$query .= "  `PATH` varchar(64) default NULL,     ";
			$query .= "  `QUERY` varchar(128) default NULL,     ";
			$query .= "  `KEYWORD` varchar(128) default NULL,     ";
			$query .= "  `DEVICE` varchar(10) default NULL,     ";
			$query .= "  PRIMARY KEY  (`no`),                  ";
			$query .= "  KEY `IDX_Y` (`Y`),";
			$query .= "  KEY `IDX_M` (`M`),";
			$query .= "  KEY `IDX_D` (`D`),";
			$query .= "  KEY `IDX_H` (`H`)";
			$query .= ");                                      ";
			$db->getExecSql($query);

		}	
	}

	## 검색시 소속 사용
	if ($a_admin_type != "S")
	{
		if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){
			## 설정
			## 언어 설정
			$aryUseLng			= explode("/", $S_USE_LNG);

			## 회원소속관리 불러오기
			$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
			//include_once $fileName;
			//member.cate.inc.php 파일 자체가 아예 없음.
			if(is_file($fileName)):
				require_once "$fileName";
			endif;

			## 해당 회원 소속 가져오기
			if(!$memberCateMgr):
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();
			endif;

			## 차수별 회원 소속 설정
			if (!is_array($aryMemberCateList)):
				$param								= "";
				$param['C_CODE_COLUMN_ARYLIST']		= "Y";
				$param['M_NO']						= $a_admin_no;
				$aryMemberCateList					= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param);
			endif;

			//		echo $db->query;
			$aryMemberCate						= "";
			
			//print_r($aryMemberCateList);
			foreach($aryMemberCateList as $key => $c_code):
				$temp1		= substr($c_code, 0, 3);
				$temp2		= substr($c_code, 0, 6);
				$temp3		= substr($c_code, 0, 9);
				$temp4		= substr($c_code, 0, 12);
				$length		= strlen($c_code);
				foreach($MEMBER_CATE as $code => $data):
				//				echo strlen($c_code) . "<br>";
					if($temp1 == substr($code, 0, $length)  && !in_array($code, $aryMemberCate)) { $aryMemberCate[] = $code; }
					if($temp2 == substr($code, 0, $length)  && !in_array($code, $aryMemberCate)) { $aryMemberCate[] = $code; }
					if($temp3 == substr($code, 0, $length)  && !in_array($code, $aryMemberCate)) { $aryMemberCate[] = $code; }
					if($temp4 == substr($code, 0, $length) && !in_array($code, $aryMemberCate)) { $aryMemberCate[] = $code; }
				endforeach;
			endforeach;

			//		print_r($aryMemberCate);

			## 소속 검색
			$strSearchNation	= $_POST["searchNation"]		? $_POST["searchNation"]		: $_REQUEST["searchNation"];
			$strSearchCate1		= $_POST["searchCate1"]			? $_POST["searchCate1"]			: $_REQUEST["searchCate1"];
			$strSearchCate2		= $_POST["searchCate2"]			? $_POST["searchCate2"]			: $_REQUEST["searchCate2"];
			$strSearchCate3		= $_POST["searchCate3"]			? $_POST["searchCate3"]			: $_REQUEST["searchCate3"];
			$strSearchCate4		= $_POST["searchCate4"]			? $_POST["searchCate4"]			: $_REQUEST["searchCate4"];
			
			if($strSearchNation || $strSearchCate1 || $strSearchCate2 || $strSearchCate3 || $strSearchCate4):
				
				## 검색 카테고리 설정
				$cateCode				= "";
				if($strSearchCate1) { $cateCode = $strSearchCate1; }
				if($strSearchCate2) { $cateCode = $strSearchCate2; }
				if($strSearchCate3) { $cateCode = $strSearchCate3; }
				if($strSearchCate4) { $cateCode = $strSearchCate4; }

				## 데이터
				$param								= "";
				$param['M_CATE']					= $cateCode;
							
			endif;

			if ($a_admin_level > 0 && (!$strSearchCate2)):
				
				## 차수별 회원 소속 설정
				$param								= "";
				$param['C_CODE_COLUMN_ARYLIST']		= "Y";
				$param['M_NO']						= $a_admin_no;
				$aryMemberCateJoinList				= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYTOTAL", $param);
//				$cateCode							= $aryMemberCateJoinList[0]['C_CODE'];
//				$param['M_CATE']					= substr($cateCode,0,6);
				## 국가를 선택하였을때 소속관리자가 자기소속만 데이터만 보이도록 설정
				if (is_array($aryMemberCateJoinList)){
					$param['M_CATE_LIST']			= "Y";
					$param['M_CATE_LIST_DATA']		= "";
					
					$strMemberCateListData			= "";
					foreach($aryMemberCateJoinList as $key => $memberCateRow){
						if ($memberCateRow['C_CODE']){
							$strMemberCateListData .= "C_CODE LIKE '".$memberCateRow['C_CODE']."%',";
						}
					}

					if ($strMemberCateListData) {
						$strMemberCateListData		= substr($strMemberCateListData,0,strlen($strMemberCateListData)-1);
						$param['M_CATE_LIST_DATA']  = $strMemberCateListData;
					}
				}
			
			endif;

		}
	}
	
	## 입점업체 리스트 
	if ($a_admin_type == "A"){
		if ($ADMIN_SHOP_SELECT_USE == "Y"){
			if ($a_admin_tm == "Y" && $a_admin_shop_list) {
				/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
				$param['SHOP_LIST'] = $a_admin_shop_list;
				if (!$strSearchShop) $strSearchShop = $a_admin_shop_list;
			}
		}
		$aryShopList = $webLogMgr->getShopList($db,$param);
	} else {
		$strSearchShop = $a_admin_shop_no;
	}

	## 컬럼별 정렬
	if ($strOrderBySort) $param["orderBySort"] = $strOrderBySort;

?>
<? include "./include/header.inc.php"?>
<?
	switch($strMode){
		case "visitYear":

			if($_REQUEST[nowY])$nowY=$_REQUEST[nowY];
			else $nowY=date("Y");
			if($_REQUEST[nowM])$nowM=$_REQUEST[nowM];
			else $nowM=date("n");
			$nowD=date("j");
			
			$tb_counter = "LOG_COUNT_".$nowY;
			$tb_referer = "LOG_REFERER_".$nowY;
			$tb_pgview  = "LOG_PGVIEW_".$nowY;

		break;
	
		case "visitMonth":

			if($_REQUEST[nowY])$nowY=$_REQUEST[nowY];
			else $nowY=date("Y");
			if($_REQUEST[nowM])$nowM=$_REQUEST[nowM];
			else $nowM=date("n");
			
			$tb_counter = "LOG_COUNT_".$nowY;
			$tb_referer = "LOG_REFERER_".$nowY;
			$tb_pgview  = "LOG_PGVIEW_".$nowY;

			$totalDay=getTotalDay($nowY,$nowM);
			$query="select d,sum(cnt) as cnt from $tb_counter where y='$nowY' and m='$nowM' group by y,m,d";
			$result=$db->getResult($query);	


			$maxCnt=0;
			$minCnt=100000000;
			$totalCnt=0;
			while($row = mysql_fetch_array($result[result])){
				$d[$row[d]]=$row[d];
				$counter[$row[d]]=$row[cnt];
				if($row[cnt]>$maxCnt)$maxCnt=$row[cnt];
				if($row[cnt]<$minCnt)$minCnt=$row[cnt];
				$totalCnt+=$counter[$row[d]];

			}
		break;		

		case "visitDay":

			if($_REQUEST[nowY])$nowY=$_REQUEST[nowY];
			else $nowY=date("Y");
			if($_REQUEST[nowM])$nowM=$_REQUEST[nowM];
			else $nowM=date("n");
			if($_REQUEST[nowD])$nowD=$_REQUEST[nowD];
			else $nowD=date("j");

			$tb_counter = "LOG_COUNT_".$nowY;
			$tb_referer = "LOG_REFERER_".$nowY;
			$tb_pgview  = "LOG_PGVIEW_".$nowY;

			$totalDay=getTotalDay($nowY,$nowM);
			$query="select h,sum(cnt) as cnt from $tb_counter where y='$nowY' and m='$nowM' and d='$nowD' group by y,m,d,h";
			$result=$db->getResult($query);	

			$maxCnt=0;
			$minCnt=100000000;
			$totalCnt=0;
			while($row = mysql_fetch_array($result[result])){
				$d[$row[h]]=$row[h];
				$counter[$row[h]]=$row[cnt];
				if($row[cnt]>$maxCnt)$maxCnt=$row[cnt];
				if($row[cnt]<$minCnt)$minCnt=$row[cnt];
				$totalCnt+=$counter[$row[h]];
			}
		break;		
		
//		case "visitHostKeyWord":
//			if(!$_REQUEST[sortBy])$sortBy="HOST";
//			else $sortBy=$_REQUEST[sortBy];
//
//			if($_REQUEST[nowY])$nowY=$_REQUEST[nowY];
//			else $nowY=date("Y");
//			if($_REQUEST[nowM])$nowM=$_REQUEST[nowM];
//			else $nowM=date("n");
//			if($_REQUEST[nowD])$nowD=$_REQUEST[nowD];
//			else $nowD=date("j");
//
//
//			$tb_counter = "LOG_COUNT_".$nowY;
//			$tb_referer = "LOG_REFERER_".$nowY;
//			$tb_pgview  = "LOG_PGVIEW_".$nowY;
//
//			if($sortBy=="HOST"){
//				$query="select count(*) as cnt, host as sortKey from $tb_referer where host!=''";
////				if($_POST[year1])$query.=" and ((y>'$nowY') || (y='$nowY' && m>'$nowM') || (y='$nowY' && m='$nowM' && d>='$nowD'))"; 2013.07.09 kim hee sung 소스 오류인듯...
//				if($nowY && $nowM && $nowD):
////					$query.=" and ((y>'$nowY') || (y='$nowY' && m>'$nowM') || (y='$nowY' && m='$nowM' && d>='$nowD'))";
//					$query .= " and y = {$nowY} and m = {$nowM} and d = {$nowD}";
//				endif;
////				$query.=" group by host order by cnt desc";
//
//				if($_REQUEST['sortType'] == "HOST_DESC")			{ $query ="{$query} group by host order by host desc";  }
//				else if($_REQUEST['sortType'] == "HOST_ASC")		{ $query ="{$query} group by host order by host asc";	}
//				else if($_REQUEST['sortType'] == "RATE_DESC")		{ $query ="{$query} group by host order by cnt desc";	}
//				else if($_REQUEST['sortType'] == "RATE_ASC")		{ $query ="{$query} group by host order by cnt asc";	}
//				else if($_REQUEST['sortType'] == "VISITCNT_DESC")	{ $query ="{$query} group by host order by cnt desc";	}
//				else if($_REQUEST['sortType'] == "VISITCNT_ASC")	{ $query ="{$query} group by host order by cnt asc";	}
//				else												{ $query ="{$query} group by host order by host desc";  }
//			}
//			else if($sortBy=="KEYWORD"){
//				$query="select count(*) as cnt, keyword as sortKey from $tb_referer where keyword!=''";
//				if($_POST[year1])$query.=" and ((y>'$nowY') || (y='$nowY' && m>'$nowM') || (y='$nowY' && m='$nowM' && d>='$nowD'))";
//				$query.=" group by keyword order by cnt desc";
//			}
//			$result=$db->getResult($query); //echo $query;
//			$num=$result[cnt];
//			$maxCnt=0;
//			
//			$cnt = "";
//			$x = 0;
//			while($row = mysql_fetch_array($result[result])){
//				$key[$x]=$row[sortKey];
//				$cnt[$x]=$row[cnt];
//				//if($row[cnt]>$maxCnt)$maxCnt=$row[cnt];
//				$x++;
//				$maxCnt += $row[cnt];
//			}
//
//		break;
		case "visitHostKeyWord":
			// 2013.07.10 kim hee sung 소스 정리
			// SELECT  * FROM LOG_REFERER_2013 WHERE DATE_FORMAT(CONCAT(Y,'-', M,'-',D), '%Y-%m-%d')  BETWEEN DATE_FORMAT('2013-05-30', '%Y-%m-%d') AND DATE_FORMAT('2013-06-02', '%Y-%m-%d')

			## 설정
			$serchStartDate		= $_REQUEST['serchStartDate'];			
			$serchEndDate		= $_REQUEST['serchEndDate'];
			if(!$serchStartDate)	{ $serchStartDate = date("y-m-d");		}
			if(!$serchEndDate)		{ $serchEndDate = date("y-m-d");		}

			## 정렬 설정
			if($_REQUEST['sortType'] == "HOST_DESC")			{ $orderBy ="HOST DESC";		}
			else if($_REQUEST['sortType'] == "HOST_ASC")		{ $orderBy ="HOST ASC";			}
			else if($_REQUEST['sortType'] == "RATE_DESC")		{ $orderBy ="CNT DESC";			}
			else if($_REQUEST['sortType'] == "RATE_ASC")		{ $orderBy ="CNT ASC";			}
			else if($_REQUEST['sortType'] == "VISITCNT_DESC")	{ $orderBy ="CNT DESC";			}
			else if($_REQUEST['sortType'] == "VISITCNT_ASC")	{ $orderBy ="CNT ASC";			}
			else												{ $orderBy ="HOST DESC";		}

			## 리스트
			$param							= "";
//			$param['KEYWORD_IS_NOT_NULL']	= "Y";
			$param['YMD_START']				= $serchStartDate; 
			$param['YMD_END']				= $serchEndDate;
			$param['GROUP_BY']				= "HOST";
			$param['ORDER_BY']				= $orderBy;
			$intTotal						= $webLogMgr->getLogRefererList($db, "OP_COUNT", $param);					// 데이터 전체 개수 
			$intPageLine					= 30;																		// 리스트 개수 
			$intPage						= ( $intPage )				? $intPage		: 1;
			$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
			$param['LIMIT']					= "{$intFirst},{$intPageLine}";
			$logRefererResult				= $webLogMgr->getLogRefererList($db, "OP_LIST", $param);	// echo $db->query;
			$intPageBlock					= 10;																		// 블럭 개수 
			$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage						= ceil( $intTotal / $intPageLine );

			## 페이징 링크 주소
			$queryString	= explode("&", $_SERVER['QUERY_STRING']);
			$linkPage		= "";
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == "page")	{ continue; }
				if($linkPage)		{ $linkPage .= "&"; }
				$linkPage		   .= $string;
			endforeach;
			$linkPage		= "./?{$linkPage}&page=";

		break;
		case "visitRefer":
			// 2013.07.10 kim hee sung 소스 정리
			// SELECT  * FROM LOG_REFERER_2013 WHERE DATE_FORMAT(CONCAT(Y,'-', M,'-',D), '%Y-%m-%d')  BETWEEN DATE_FORMAT('2013-05-30', '%Y-%m-%d') AND DATE_FORMAT('2013-06-02', '%Y-%m-%d')

			## 설정
			$serchStartDate		= $_REQUEST['serchStartDate'];			
			$serchEndDate		= $_REQUEST['serchEndDate'];
			if(!$serchStartDate)	{ $serchStartDate = date("y-m-d");		}
			if(!$serchEndDate)		{ $serchEndDate = date("y-m-d");		}

			## 정렬 설정
			if($_REQUEST['sortType'] == "KEYWORD_DESC")			{ $orderBy ="KEYWORD DESC";		}
			else if($_REQUEST['sortType'] == "KEYWORD_ASC")		{ $orderBy ="KEYWORD ASC";		}
			else if($_REQUEST['sortType'] == "RATE_DESC")		{ $orderBy ="CNT DESC";			}
			else if($_REQUEST['sortType'] == "RATE_ASC")		{ $orderBy ="CNT ASC";			}
			else if($_REQUEST['sortType'] == "VISITCNT_DESC")	{ $orderBy ="CNT DESC";			}
			else if($_REQUEST['sortType'] == "VISITCNT_ASC")	{ $orderBy ="CNT ASC";			}
			else												{ $orderBy ="KEYWORD DESC";		}

			## 리스트
			$param							= "";
			$param['KEYWORD_IS_NOT_NULL']	= "Y";
			$param['YMD_START']				= $serchStartDate; 
			$param['YMD_END']				= $serchEndDate;
			$param['GROUP_BY']				= "KEYWORD";
			$param['ORDER_BY']				= $orderBy;
			$intTotal						= $webLogMgr->getLogRefererList($db, "OP_COUNT", $param);					// 데이터 전체 개수 
			$intPageLine					= 30;																		// 리스트 개수 
			$intPage						= ( $intPage )				? $intPage		: 1;
			$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
			$param['LIMIT']					= "{$intFirst},{$intPageLine}";
			$logRefererResult				= $webLogMgr->getLogRefererList($db, "OP_LIST", $param);	
			$intPageBlock					= 10;																		// 블럭 개수 
			$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage						= ceil( $intTotal / $intPageLine );

			## 페이징 링크 주소
			$queryString	= explode("&", $_SERVER['QUERY_STRING']);
			$linkPage		= "";
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == "page")	{ continue; }
				if($linkPage)		{ $linkPage .= "&"; }
				$linkPage		   .= $string;
			endforeach;
			$linkPage		= "./?{$linkPage}&page=";

		break;
//		case "visitRefer":
//
//			if(!$_REQUEST[sortBy])$sortBy="KEYWORD";
//			else $sortBy=$_REQUEST[sortBy];
//
//			if($_REQUEST[nowY])$nowY=$_REQUEST[nowY];
//			else $nowY=date("Y");
//			if($_REQUEST[nowM])$nowM=$_REQUEST[nowM];
//			else $nowM=date("n");
//			if($_REQUEST[nowD])$nowD=$_REQUEST[nowD];
//			else $nowD=date("j");
//
//			$tb_counter = "LOG_COUNT_".$nowY;
//			$tb_referer = "LOG_REFERER_".$nowY;
//			$tb_pgview  = "LOG_PGVIEW_".$nowY;
//
//
//			if($sortBy=="HOST"){
//				$query="select count(*) as cnt, host as sortKey from $tb_referer where host!=''";
//				if($_POST[year1])$query.=" and ((y>'$nowY') || (y='$nowY' && m>'$nowM') || (y='$nowY' && m='$nowM' && d>='$nowD'))";
//				$query.="group by host order by cnt desc";
//			}
//			else if($sortBy=="KEYWORD"){
//				$query="select count(*) as cnt, keyword as sortKey from $tb_referer where keyword!=''";
//				if($_POST[year1])$query.=" and ((y>'$nowY') || (y='$nowY' && m>'$nowM') || (y='$nowY' && m='$nowM' && d>='$nowD'))";
//				$query.=" group by keyword order by cnt desc";
//			}
//
//			$result=$db->getResult($query);//echo $query;
//			$num=$result[cnt];
//			$maxCnt=0;
//			
//			$x = 0;
//			while($row = mysql_fetch_array($result[result])){
//				$key[$x]=$row[sortKey];
//				$cnt[$x]=$row[cnt];
//				//if($row[cnt]>$maxCnt)$maxCnt=$row[cnt];
//				$x++;
//				$maxCnt += $row[cnt];
//			}
//
//		break;

		case "orderMonthStatics":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */


			/*if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y-m")."-01";
			if (!$strSearchRegEndDt) {
				$strLastDay = date("t",strtotime(date("Y-m-d")));
				$strSearchRegEndDt = date("Y-m")."-".$strLastDay;
			}*/

			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";
	
			$siteRow = $siteMgr->getSiteInfo($db);
			
			If ($siteRow[S_SETTLE]){
				$arySiteSettle = explode("/",$siteRow[S_SETTLE]);
				if (is_array($arySiteSettle)){
					$intSiteSettleB = $intSiteSettleA = $intSiteSettleC = $intSiteSettleT = "";
					for($z=0;$z<sizeof($arySiteSettle);$z++){
						if ($arySiteSettle[$z] == "B"){
							$intSiteSettleB = "Y";
						}

						if ($arySiteSettle[$z] == "C"){
							$intSiteSettleC = "Y";
						}

						if ($arySiteSettle[$z] == "A"){
							$intSiteSettleA = "Y";
						}

						if ($arySiteSettle[$z] == "T"){
							$intSiteSettleT = "Y";
						}
					}
				}
			}	


			$arySiteForSettle = explode("/",$S_FOR_PG);
			if (is_array($arySiteForSettle)){
				$intSiteSettleX = $intSiteSettleR = $intSiteSettleY = "";
				for($z=0;$z<sizeof($arySiteForSettle);$z++){
					if ($arySiteForSettle[$z] == "Y"){
						$intSiteSettleY = "Y";	//->해외결제(페이팔)
					}
					
					if ($arySiteForSettle[$z] == "X"){
						$intSiteSettleX = "Y"; //->해외결제(엑심베이)
					}

					if ($arySiteForSettle[$z] == "R"){
						$intSiteSettleR = "Y"; //->해외결제(알리페이)
					}
				}
			}


			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			$webLogMgr->setSearchSettleC($strSearchSettleC);
			$webLogMgr->setSearchSettleA($strSearchSettleA);
			$webLogMgr->setSearchSettleT($strSearchSettleT);
			$webLogMgr->setSearchSettleB($strSearchSettleB);
			$webLogMgr->setSearchSettleY($strSearchSettleY);
			$webLogMgr->setSearchSettleX($strSearchSettleX);

			$webLogMgr->setSearchGroupMode("M");
			
			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);
			$aryOrderSaleList = $webLogMgr->getOrderYearMonthDayList($db,$param);
			
			//echo $db->query;
		break;

		case "orderDayStatics":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) {
				$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
				$strLastWeek = strtotime("-1 week",$strTimeStamp); 
				$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
			}
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
			
			$siteRow = $siteMgr->getSiteInfo($db);
			
			If ($siteRow[S_SETTLE]){
				$arySiteSettle = explode("/",$siteRow[S_SETTLE]);
				if (is_array($arySiteSettle)){
					$intSiteSettleB = $intSiteSettleA = $intSiteSettleC = $intSiteSettleT = "";
					for($z=0;$z<sizeof($arySiteSettle);$z++){
						if ($arySiteSettle[$z] == "B"){
							$intSiteSettleB = "Y";
						}

						if ($arySiteSettle[$z] == "C"){
							$intSiteSettleC = "Y";
						}

						if ($arySiteSettle[$z] == "A"){
							$intSiteSettleA = "Y";
						}

						if ($arySiteSettle[$z] == "T"){
							$intSiteSettleT = "Y";
						}
					}
				}
			}	

			$arySiteForSettle = explode("/",$S_FOR_PG);
			if (is_array($arySiteForSettle)){
				$intSiteSettleX = $intSiteSettleR = $intSiteSettleY = "";
				for($z=0;$z<sizeof($arySiteForSettle);$z++){
					if ($arySiteForSettle[$z] == "Y"){
						$intSiteSettleY = "Y";	//->해외결제(페이팔)
					}
					
					if ($arySiteForSettle[$z] == "X"){
						$intSiteSettleX = "Y"; //->해외결제(엑심베이)
					}

					if ($arySiteForSettle[$z] == "R"){
						$intSiteSettleR = "Y"; //->해외결제(알리페이)
					}
				}
			}


			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			$webLogMgr->setSearchSettleC($strSearchSettleC);
			$webLogMgr->setSearchSettleA($strSearchSettleA);
			$webLogMgr->setSearchSettleT($strSearchSettleT);
			$webLogMgr->setSearchSettleB($strSearchSettleB);
			$webLogMgr->setSearchSettleY($strSearchSettleY);
			$webLogMgr->setSearchSettleX($strSearchSettleX);

			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$webLogMgr->setSearchGroupMode("D");

			$aryOrderSaleList = $webLogMgr->getOrderYearMonthDayList($db,$param);
		break;

		case "orderQuarterStatics":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";
			
			$siteRow = $siteMgr->getSiteInfo($db);
			
			If ($siteRow[S_SETTLE]){
				$arySiteSettle = explode("/",$siteRow[S_SETTLE]);
				if (is_array($arySiteSettle)){
					$intSiteSettleB = $intSiteSettleA = $intSiteSettleC = $intSiteSettleT = "";
					for($z=0;$z<sizeof($arySiteSettle);$z++){
						if ($arySiteSettle[$z] == "B"){
							$intSiteSettleB = "Y";
						}

						if ($arySiteSettle[$z] == "C"){
							$intSiteSettleC = "Y";
						}

						if ($arySiteSettle[$z] == "A"){
							$intSiteSettleA = "Y";
						}

						if ($arySiteSettle[$z] == "T"){
							$intSiteSettleT = "Y";
						}
					}
				}
			}	

			$arySiteForSettle = explode("/",$S_FOR_PG);
			if (is_array($arySiteForSettle)){
				$intSiteSettleX = $intSiteSettleR = $intSiteSettleY = "";
				for($z=0;$z<sizeof($arySiteForSettle);$z++){
					if ($arySiteForSettle[$z] == "Y"){
						$intSiteSettleY = "Y";	//->해외결제(페이팔)
					}
					
					if ($arySiteForSettle[$z] == "X"){
						$intSiteSettleX = "Y"; //->해외결제(엑심베이)
					}

					if ($arySiteForSettle[$z] == "R"){
						$intSiteSettleR = "Y"; //->해외결제(알리페이)
					}
				}
			}
			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			$webLogMgr->setSearchSettleC($strSearchSettleC);
			$webLogMgr->setSearchSettleA($strSearchSettleA);
			$webLogMgr->setSearchSettleT($strSearchSettleT);
			$webLogMgr->setSearchSettleB($strSearchSettleB);
			$webLogMgr->setSearchSettleY($strSearchSettleY);
			$webLogMgr->setSearchSettleX($strSearchSettleX);
			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$aryOrderSaleList = $webLogMgr->getOrderYearQuarterList($db,$param);
			//echo $db->query;
		break;

		case "orderProdCateStatics":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

			$webLogMgr->setSearchGroupMode("1");
			if ($strSearchHCode2){
				$webLogMgr->setSearchGroupMode("2");
			}
			
			if ($strSearchHCode3){
				$webLogMgr->setSearchGroupMode("3");
			}
			
			if ($strSearchHCode4){
				$webLogMgr->setSearchGroupMode("4");
			}
			
			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			$webLogMgr->setSearchHCode1($strSearchHCode1);
			$webLogMgr->setSearchHCode2($strSearchHCode2);
			$webLogMgr->setSearchHCode3($strSearchHCode3);
			$webLogMgr->setSearchHCode4($strSearchHCode4);
			
			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$aryOrderProdCateList = $webLogMgr->getOrderProdCateList($db,$param);
		break;

		case "orderProdStatics":
		
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) {
				$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
				$strLastWeek = strtotime("-1 week",$strTimeStamp); 
				$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
			}
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");

			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			
			$strProdCate = $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
			$webLogMgr->setSearchProductCate($strProdCate);

			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$aryOrderProdList = $webLogMgr->getOrderProdList($db,$param);
			//echo $db->query;
		break;

		case "prodBasketStatics":
		
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) {
				$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
				$strLastWeek = strtotime("-1 week",$strTimeStamp); 
				$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
			}
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");

			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);

			$strProdCate = $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
			$webLogMgr->setSearchProductCate($strProdCate);
			
			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$aryOrderProdList = $webLogMgr->getProductBasketList($db,$param);		
		break;
		case "prodWishStatics":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "004";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) {
				$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
				$strLastWeek = strtotime("-1 week",$strTimeStamp); 
				$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
			}
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");

			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);

			$strProdCate = $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
			$webLogMgr->setSearchProductCate($strProdCate);
			
			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$aryOrderProdList = $webLogMgr->getProductWishList($db,$param);		
		
		break;
		case "orderDayStatics2":
		case "orderMonthStatics2":	
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			if ($strMode == "orderDayStatics2"){
				if (!$strSearchRegStartDt) {
					$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
					$strLastWeek = strtotime("-1 week",$strTimeStamp); 
					$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
				}
				if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
			} else {
				$strLeftMenuCode02 = "002";

				if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
				if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";
			}
			
			$siteRow = $siteMgr->getSiteInfo($db);
			
			If ($siteRow[S_SETTLE]){
				$arySiteSettle = explode("/",$siteRow[S_SETTLE]);
				if (is_array($arySiteSettle)){
					$intSiteSettleB = $intSiteSettleA = $intSiteSettleC = $intSiteSettleT = "";
					for($z=0;$z<sizeof($arySiteSettle);$z++){
						if ($arySiteSettle[$z] == "B"){
							$intSiteSettleB = "Y";
						}

						if ($arySiteSettle[$z] == "C"){
							$intSiteSettleC = "Y";
						}

						if ($arySiteSettle[$z] == "A"){
							$intSiteSettleA = "Y";
						}

						if ($arySiteSettle[$z] == "T"){
							$intSiteSettleT = "Y";
						}
					}
				}
			}	

			$arySiteForSettle = explode("/",$S_FOR_PG);
			if (is_array($arySiteForSettle)){
				$intSiteSettleX = $intSiteSettleR = $intSiteSettleY = "";
				for($z=0;$z<sizeof($arySiteForSettle);$z++){
					if ($arySiteForSettle[$z] == "Y"){
						$intSiteSettleY = "Y";	//->해외결제(페이팔)
					}
					
					if ($arySiteForSettle[$z] == "X"){
						$intSiteSettleX = "Y"; //->해외결제(엑심베이)
					}

					if ($arySiteForSettle[$z] == "R"){
						$intSiteSettleR = "Y"; //->해외결제(알리페이)
					}
				}
			}

			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			$webLogMgr->setSearchSettleC($strSearchSettleC);
			$webLogMgr->setSearchSettleA($strSearchSettleA);
			$webLogMgr->setSearchSettleT($strSearchSettleT);
			$webLogMgr->setSearchSettleB($strSearchSettleB);
			$webLogMgr->setSearchSettleY($strSearchSettleY);
			$webLogMgr->setSearchSettleX($strSearchSettleX);
			
			if ($strMode == "orderDayStatics2") $webLogMgr->setSearchGroupMode("D");
			else $webLogMgr->setSearchGroupMode("M");

			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$aryOrderSaleList = $webLogMgr->getOrderDayList($db,$param);	
//		echo $db->query;

		break;

		case "orderProdStatusStatics":	

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) {
				$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
				$strLastWeek = strtotime("-1 week",$strTimeStamp); 
				$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
			}
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
			$siteRow = $siteMgr->getSiteInfo($db);
			
			If ($siteRow[S_SETTLE]){
				$arySiteSettle = explode("/",$siteRow[S_SETTLE]);
				if (is_array($arySiteSettle)){
					$intSiteSettleB = $intSiteSettleA = $intSiteSettleC = $intSiteSettleT = "";
					for($z=0;$z<sizeof($arySiteSettle);$z++){
						if ($arySiteSettle[$z] == "B"){
							$intSiteSettleB = "Y";
						}

						if ($arySiteSettle[$z] == "C"){
							$intSiteSettleC = "Y";
						}

						if ($arySiteSettle[$z] == "A"){
							$intSiteSettleA = "Y";
						}

						if ($arySiteSettle[$z] == "T"){
							$intSiteSettleT = "Y";
						}
					}
				}
			}	

			$arySiteForSettle = explode("/",$S_FOR_PG);
			if (is_array($arySiteForSettle)){
				$intSiteSettleX = $intSiteSettleR = $intSiteSettleY = "";
				for($z=0;$z<sizeof($arySiteForSettle);$z++){
					if ($arySiteForSettle[$z] == "Y"){
						$intSiteSettleY = "Y";	//->해외결제(페이팔)
					}
					
					if ($arySiteForSettle[$z] == "X"){
						$intSiteSettleX = "Y"; //->해외결제(엑심베이)
					}

					if ($arySiteForSettle[$z] == "R"){
						$intSiteSettleR = "Y"; //->해외결제(알리페이)
					}
				}
			}


			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			$webLogMgr->setSearchSettleC($strSearchSettleC);
			$webLogMgr->setSearchSettleA($strSearchSettleA);
			$webLogMgr->setSearchSettleT($strSearchSettleT);
			$webLogMgr->setSearchSettleB($strSearchSettleB);
			$webLogMgr->setSearchSettleY($strSearchSettleY);
			$webLogMgr->setSearchSettleX($strSearchSettleX);
			
			$webLogMgr->setSearchHCode1($strSearchHCode1);
			$webLogMgr->setSearchHCode2($strSearchHCode2);
			$webLogMgr->setSearchHCode3($strSearchHCode3);
			$webLogMgr->setSearchHCode4($strSearchHCode4);

			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			if ($strSearchHCode1 || $strSearchHCode2 || $strSearchHCode3 || $strSearchHCode4){
				$param['PROD_CATE']			= "Y";
				$param['SEARCH_PROD_CATE']	= $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
			}

			$aryOrderSaleList = $webLogMgr->getOrderProdStatusList($db,$param);	
			//echo $db->query;
		break;
		case "orderAgeStatics":	

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "004";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) {
				$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
				$strLastWeek = strtotime("-1 week",$strTimeStamp); 
				$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
			}
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
			$siteRow = $siteMgr->getSiteInfo($db);
			
			
			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			
			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$aryOrderSaleList = $webLogMgr->getOrderAgeList($db,$param);

		break;
		case "orderAreaStatics":	

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "005";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) {
				$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
				$strLastWeek = strtotime("-1 week",$strTimeStamp); 
				$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
			}
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
			$siteRow = $siteMgr->getSiteInfo($db);
			
			
			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			
			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$aryOrderSaleList = $webLogMgr->getOrderAreaList($db,$param);		

		break;

		case "orderSexStatics":	

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "006";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) {
				$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
				$strLastWeek = strtotime("-1 week",$strTimeStamp); 
				$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
			}
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
			$siteRow = $siteMgr->getSiteInfo($db);
			
			
			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			
			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

			$aryOrderSaleList = $webLogMgr->getOrderSexList($db,$param);		

		break;

		case "memberRegStatics":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "005";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			
			$aryMemberList = $webLogMgr->getMemberRegList($db,$param);		
//			echo $db->query;

		break;

		case "memberAgeStatics":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "005";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */
			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			
			$aryMemberList = $webLogMgr->getMemberAgeList($db,$param);		
//			echo $db->query;
		break;

		case "memberAreaStatics":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "005";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			
			$aryMemberList = $webLogMgr->getMemberAreaList($db,$param);		

		break;

		case "memberSexStatics":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "005";
			$strLeftMenuCode02 = "004";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";


			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			
			$aryMemberList = $webLogMgr->getMemberSexList($db,$param);		

		break;

		case "orderMemberCateList":	
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";
			
			$siteRow = $siteMgr->getSiteInfo($db);
			
			If ($siteRow[S_SETTLE]){
				$arySiteSettle = explode("/",$siteRow[S_SETTLE]);
				if (is_array($arySiteSettle)){
					$intSiteSettleB = $intSiteSettleA = $intSiteSettleC = $intSiteSettleT = "";
					for($z=0;$z<sizeof($arySiteSettle);$z++){
						if ($arySiteSettle[$z] == "B"){
							$intSiteSettleB = "Y";
						}

						if ($arySiteSettle[$z] == "C"){
							$intSiteSettleC = "Y";
						}

						if ($arySiteSettle[$z] == "A"){
							$intSiteSettleA = "Y";
						}

						if ($arySiteSettle[$z] == "T"){
							$intSiteSettleT = "Y";
						}
					}
				}
			}	

			$arySiteForSettle = explode("/",$S_FOR_PG);
			if (is_array($arySiteForSettle)){
				$intSiteSettleX = $intSiteSettleR = $intSiteSettleY = "";
				for($z=0;$z<sizeof($arySiteForSettle);$z++){
					if ($arySiteForSettle[$z] == "Y"){
						$intSiteSettleY = "Y";	//->해외결제(페이팔)
					}
					
					if ($arySiteForSettle[$z] == "X"){
						$intSiteSettleX = "Y"; //->해외결제(엑심베이)
					}

					if ($arySiteForSettle[$z] == "R"){
						$intSiteSettleR = "Y"; //->해외결제(알리페이)
					}
				}
			}

			$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
			$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
			$webLogMgr->setSearchSettleC($strSearchSettleC);
			$webLogMgr->setSearchSettleA($strSearchSettleA);
			$webLogMgr->setSearchSettleT($strSearchSettleT);
			$webLogMgr->setSearchSettleB($strSearchSettleB);
			$webLogMgr->setSearchSettleY($strSearchSettleY);
			$webLogMgr->setSearchSettleX($strSearchSettleX);
			
//			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);
//			print_r($param);
			$aryOrderSaleList = $webLogMgr->getOrderMemberCateList($db,$param);	
			//echo $db->query;
		break;

	}

	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}

?>
<link class="include" rel="stylesheet" type="text/css" href="./common/statics/jquery.jqplot.min.css" />
<link rel="stylesheet" type="text/css" href="./common/statics/examples.min.css" />
<link type="text/css" rel="stylesheet" href="./common/statics/syntaxhighlighter/styles/shCoreDefault.min.css" />
<link type="text/css" rel="stylesheet" href="./common/statics/syntaxhighlighter/styles/shThemejqPlot.min.css" />

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="./common/statics/excanvas.js"></script><![endif]-->

<script type="text/javascript">
<!--
	<?if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){?>
	var memberCate = new Array(4);
	<?}?>


	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";
	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		<?if ($strMode == "orderProdCateStatics" || $strMode == "orderProdStatics" || $strMode == "orderProdStatusStatics"){?>
		callCateList(1,"","","searchCateHCode1","<?=$strSearchHCode1?>");

			<?if ($strSearchHCode1){?>
			callCateList(2,"<?=$strSearchHCode1?>","","searchCateHCode2","<?=$strSearchHCode2?>");
			<?}?>
			<?if ($strSearchHCode2){?>
			callCateList(3,"<?=$strSearchHCode1.$strSearchHCode2?>","","searchCateHCode3","<?=$strSearchHCode3?>");
			<?}?>
			<?if ($strSearchHCode3){?>
			callCateList(4,"<?=$strSearchHCode1.$strSearchHCode2.$strSearchHCode3?>","","searchCateHCode4","<?=$strSearchHCode4?>");
			<?}?>

		var strHCode = "";

		$("#searchCateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","searchCateHCode2","");
			}
		});

		$("#searchCateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#searchCateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","searchCateHCode3","");
			}
		});

		$("#searchCateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#searchCateHCode1 option:selected").val()+$("#searchCateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","searchCateHCode4","");
			}
		});
		<?}?>



		<?if ($S_FIX_MEMBER_CATE_USE_YN  == "Y" && substr($strMode,0,5) != "visit" && $a_admin_type != "S" && $strMode != "orderMemberCateList"){?>
		$(".searchTableWrap table").css("width","730px");


		var defaultValue			= new Array(4);
		$("select[id=c_cate]").each(function(index) {
			memberCate[index+1]		= $(this).find("option");
			defaultValue[index+1]	= $(this).val();
			if(index <= 3) {
				$(this).change(function() {
					var no = $(this).attr("no");
					memberCateMake(no);
				});
			}
		});

		memberCateMake(0);
		for(var key in defaultValue){
			if(defaultValue[key]){
				$("select[id=c_cate][no="+key+"]").val(defaultValue[key]);	
				memberCateMake(key);
			}
		}		
	
		$("select#c_nation").change(function() { memberCateMake(0); });

		<?}?>
	});

	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
		
		var strJsonParam = "menuType=product&mode=json&jsonMode=cateLevelList&cateLng=<?=$strAdmSiteLng?>";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView;
		
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data){	
				var strCateSelectFirstVal = "";
				if (cateLevel == "1")
				{
					strCateSelectFirstVal = "<?=callLangTrans($LNG_TRANS_CHAR['EW00099'],array('1'))?>";
				}
				if (cateLevel == "2")
				{
					strCateSelectFirstVal = "<?=callLangTrans($LNG_TRANS_CHAR['EW00099'],array('2'))?>";
				}
				if (cateLevel == "3")
				{
					strCateSelectFirstVal = "<?=callLangTrans($LNG_TRANS_CHAR['EW00099'],array('3'))?>";
				}
				if (cateLevel == "4")
				{
					strCateSelectFirstVal = "<?=callLangTrans($LNG_TRANS_CHAR['EW00099'],array('4'))?>";
				}
				
				$("#"+cateObj).html("<option value=''>"+strCateSelectFirstVal+"</option>");
				for(var i=0;i<data.length;i++){
					var strCateSelected = "";
					if (data[i].CATE_CODE == cateSelected)
					{
						strCateSelected = "selected";
					}
					$("#"+cateObj).append("<option value='"+data[i].CATE_CODE+"' "+strCateSelected+">"+data[i].CATE_NAME+"</option>");
				}
			}
		});
	}

	function memberCateMake(no){
		no			= Number(no);
		var nation	= $("select[id=c_nation]").val();
		var code	= $("select[id=c_cate][no="+no+"]").val();
		var length	= 0;
		if(code) { length = code.length; }

		for(var i=(no+1);i<=4;i++){
			$("select[id=c_cate][no="+i+"]").find("option").remove();
			$("select[id=c_cate][no="+i+"]").append(memberCate[i].eq(0));
		}
		$(memberCate[no+1]).each(function() {
			if($(this).attr("nation") == nation) {
				if(length == 0 || code == $(this).val().substr(0,length)){
					$("select[id=c_cate][no="+(no+1)+"]").append($(this));
				}
			}
			$("select[id=c_cate][no="+(no+1)+"]").val("");
		});
	}

	function goSearch(){
		
		C_getMoveUrl(document.form.mode.value,"get","<?=$PHP_SELF?>");
	}

	function goStaticOrderBy(sort){

		document.form.orderBySort.value = sort;
		C_getMoveUrl(document.form.mode.value,"get","<?=$PHP_SELF?>");		
	}	

	function goPopClose() {
		$.smartPop.close();
	}

//-->
</script>
<!-- ******************** TopArea ********************** -->
	<? include "./include/top.inc.php"?>
<!-- ******************** TopArea ********************** -->
	<div id="contentArea">
	<table style="width:100%;">
		<tr>
			<td class="leftWrap">
				<!-- ******************** leftArea ********************** -->
					<?include "./include/left.inc.php"?>
				<!-- ******************** leftArea ********************** -->
			</td>
			<td class="contentWrap">
				<div class="bodyTopLine"></div>
				<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
					<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="orderBySort" value="">
						<?
							include $includeFile;
						?>
					</form>
					</div>
				<!-- ******************** contentsArea ********************** -->
			</td>
		</tr>
	</table>
	</div>
<!-- ******************** footerArea ********************** -->
	<?include "./include/bottom.inc.php"?>
<!-- ******************** footerArea ********************** -->
</body>

<script class="include" type="text/javascript" src="./common/statics/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="./common/statics/syntaxhighlighter/scripts/shCore.min.js"></script>
<script type="text/javascript" src="./common/statics/syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
<script type="text/javascript" src="./common/statics/syntaxhighlighter/scripts/shBrushXml.min.js"></script>
<!-- Additional plugins go here -->

<script class="include" type="text/javascript" src="./common/statics/plugins/jqplot.barRenderer.min.js"></script>
<script class="include" type="text/javascript" src="./common/statics/plugins/jqplot.pieRenderer.min.js"></script>
<script class="include" type="text/javascript" src="./common/statics/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script class="include" type="text/javascript" src="./common/statics/plugins/jqplot.pointLabels.min.js"></script>

<script type="text/javascript" src="./common/statics/plugins/jqplot.logAxisRenderer.min.js"></script>
<script type="text/javascript" src="./common/statics/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./common/statics/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="./common/statics/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./common/statics/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="./common/statics/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./common/statics/plugins/jqplot.barRenderer.min.js"></script>


<script type="text/javascript" src="./common/statics/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="./common/statics/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="./common/statics/plugins/jqplot.pointLabels.min.js"></script>


<!-- End Don't touch this! -->

<!-- Additional plugins go here -->


<!-- End additional plugins -->

</html>