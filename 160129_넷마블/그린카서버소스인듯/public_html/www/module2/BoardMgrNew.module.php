<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-03												|# 
#|작성내용	: 커뮤니티 모듈 클레스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardMgrNewModule extends Module2
{
		function getBoardMgrNewMAX_B_NO()
		{
			$query			= "SELECT MAX(B_NO) AS MAX_B_NO FROM BOARD_MGR_NEW";
			return $this->getSelectQuery($query, "OP_COUNT");
		}

		function getBoardDataSelectEx2($op, $param)
		{
			## 기본설정
			$strLang = $param['LANG'];

			## column 설정
			$aryColumn[] = "B.*";

			## 관리자메인화면표시여부 컬럼 설정
			if($param['BI_ADMIN_MAIN_SHOW']):
				if(!$strLang) { return; }
				$aryColumn[] = "(SELECT BA.BA_VAL FROM BOARD_INFO_MGR AS BA WHERE BA.BA_B_CODE = B.B_CODE AND BA.BA_LNG = '{$strLang}' AND BA.BA_KEY = 'BI_ADMIN_MAIN_SHOW') AS BI_ADMIN_MAIN_SHOW";
			endif;

			## 관리자메인화면표시여부 정렬 설정
			if($param['BI_ADMIN_MAIN_SORT']):
				if(!$strLang) { return; }
				$aryColumn[] = "(SELECT BA.BA_VAL FROM BOARD_INFO_MGR AS BA WHERE BA.BA_B_CODE = B.B_CODE AND BA.BA_LNG = '{$strLang}' AND BA.BA_KEY = 'BI_ADMIN_MAIN_SORT') AS BI_ADMIN_MAIN_SORT";
			endif;

			## 검색(텍스트)
			## 기본 설정
			$aryWhere1 = ""; 
			$arySearchKey = $param['searchKey'];
			$strSearchVal = $param['searchVal'];
		
			## 공백 제거
			$strSearchVal = trim($strSearchVal);

			## search query 설정
			$arySearchText['name'] = "B.B_NAME LIKE ('%{$strSearchVal}%')";
			$arySearchText['code'] = "B.B_CODE LIKE ('%{$strSearchVal}%')";
			if($strSearchVal):
				$arySearchQuery = "";
				if($arySearchKey && !is_array($arySearchKey)) { $arySearchKey = array($arySearchKey); }
				if($arySearchKey):
					foreach($arySearchKey as $key => $data):
						$temp = $arySearchText[$data];
						if(!$temp) { continue; }
						$arySearchQuery[] = $temp;
					endforeach;
				endif;
				if(!$arySearchQuery):
					foreach($arySearchText as $key => $data):
						$arySearchQuery[] = $data;
					endforeach;
				endif;
				$strSearchQuery = implode(" OR ", $arySearchQuery);
				$strSearchQuery = "( {$strSearchQuery} )";
				$aryWhere1[] = $strSearchQuery;
			endif;

			## where 설정
			if($param['B_CODE']) { $aryWhere1[] = "B.B_CODE = '{$param['B_CODE']}'"; }
			if($param['B_USE']) { $aryWhere1[] = "B.B_USE = '{$param['B_USE']}'"; }
			if($param['B_BG_NO']) { $aryWhere1[] = "B.B_BG_NO = '{$param['B_BG_NO']}'"; }

			## join 설정
			if($param['JOIN_BG'] == "Y"):
				$aryColumn[] = "BG.*";

				$aryJoin['JOIN_BC']  = "    LEFT OUTER JOIN												  ";
				$aryJoin['JOIN_BC'] .= "        BOARD_GROUP_NEW AS BG 	    						      ";
				$aryJoin['JOIN_BC'] .= "    ON															  ";
				$aryJoin['JOIN_BC'] .= "        BG.BG_NO = B.B_BG_NO	 					              ";
			endif;


			## order by 설정
			$aryOrderBy['reg_dt_asc']		= "B.B_REG_DT ASC";
			$aryOrderBy['reg_dt_desc']		= "B.B_REG_DT DESC";
			$strOrderBy						= $aryOrderBy[$param['ORDER_BY']];

			## limit 설정
			if($param['LIMIT']):
				list($param['LIMIT_START'], $param['LIMIT_END']) = explode(",", $param['LIMIT']);
			endif;
			if($param['LIMIT_END']):
				if(!$param['LIMIT_START']) { $param['LIMIT_START'] = 0; }
				$strLimit					= "{$param['LIMIT_START']},{$param['LIMIT_END']}";
			endif;
			
			## 쿼리 만들기
			if($aryColumn) { $strColumn = implode(",", $aryColumn); } 
			if($op == "OP_COUNT") { $strColumn = "COUNT(*)"; }
			if(!$strColumn) { $strColumn = "*"; }
			if($aryWhere1) { $strWhere1 = "WHERE " .  implode(" AND ", $aryWhere1); } 
//			if($aryWhere2) { $strWhere2 = "WHERE " .  implode(" AND ", $aryWhere2); } 
//			if($aryWhere3) { $strWhere3 = "WHERE " .  implode(" AND ", $aryWhere3); } 
			if($strOrderBy) { $strOrderBy = "ORDER BY {$strOrderBy}"; }
			if($strLimit) { $strLimit = "LIMIT {$strLimit}"; }

			$SQL  = " SELECT {$strColumn}                                               ";
			$SQL .= " FROM									                            ";
			$SQL .= "	BOARD_MGR_NEW AS B						                        ";
			$SQL .= " {$aryJoin['JOIN_BG']}								    			";
			$SQL .= " {$strWhere1}										                ";
			$SQL .= " {$strOrderBy}									                    ";
			$SQL .= " {$strLimit}										                ";

			## 결과
			return $this->getSelectQuery($SQL, $op);	
		}	


		function getBoardMgrNewSelectEx($op, $param)
		{
			$column['OP_LIST']		= "B.*";
			$column['OP_SELECT']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*";

			## query(1) 영역
			
			## limit1
			if($param['LIMIT']):
				$limit1			= "LIMIT {$param['LIMIT']}";
			endif;		
			
			## order_by1
			if($param['ORDER_BY']):
				$order_by1		= "ORDER BY {$param['ORDER_BY']}";
			else:
				## default
				$order_by1		= "ORDER BY B.B_REG_DT ASC";
			endif;

			## where1
			$where1				= "WHERE B.B_CODE IS NOT NULL";

			if($param['B_CODE']):
				$where1			= "{$where1} AND B.B_CODE = '{$param['B_CODE']}'";
			endif;

			if($param['B_USE']):
				$where1			= "{$where1} AND B.B_USE = '{$param['B_USE']}'";
			endif;

			if($param['BOARD_GROUP_NEW_JOIN']):
				$column['OP_LIST']		.= ", BG.*";
				$join1_1				 = "LEFT OUTER JOIN BOARD_GROUP_NEW AS BG ON BG.BG_NO = B.B_BG_NO";
			endif;

			## from1
			$from1				= "FROM BOARD_MGR_NEW AS B";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getBoardMgrNewInsertEx($param)
		{
			$paramData					= "";
			$paramData['B_CODE']		= $this->db->getSQLString($param['B_CODE']);
			$paramData['B_NO']			= $this->db->getSQLInteger($param['B_NO']);
			$paramData['B_NAME']		= $this->db->getSQLString($param['B_NAME']);
			$paramData['B_KIND']		= $this->db->getSQLString($param['B_KIND']);
			$paramData['B_SKIN']		= $this->db->getSQLString($param['B_SKIN']);
			$paramData['B_CSS']			= $this->db->getSQLString($param['B_CSS']);
			$paramData['B_BG_NO']		= $this->db->getSQLInteger($param['B_BG_NO']);
			$paramData['B_USE']			= $this->db->getSQLString($param['B_USE']);
			$paramData['B_REG_DT']		= $this->db->getSQLDatetime($param['B_REG_DT']);
			$paramData['B_REG_NO']		= $this->db->getSQLInteger($param['B_REG_NO']);
			$paramData['B_MOD_DT']		= $this->db->getSQLDatetime($param['B_MOD_DT']);
			$paramData['B_MOD_NO']		= $this->db->getSQLInteger($param['B_MOD_NO']);

			return $this->db->getInsertParam("BOARD_MGR_NEW", $paramData);
		}

		function getBoardMgrNewUpdateEx($param)
		{
			$paramData					= "";
//			$paramData['B_CODE']		= $this->db->getSQLString($param['B_CODE']);
//			$paramData['B_NO']			= $this->db->getSQLInteger($param['B_NO']);
			$paramData['B_NAME']		= $this->db->getSQLString($param['B_NAME']);
			$paramData['B_KIND']		= $this->db->getSQLString($param['B_KIND']);
			$paramData['B_SKIN']		= $this->db->getSQLString($param['B_SKIN']);
			$paramData['B_CSS']			= $this->db->getSQLString($param['B_CSS']);
			$paramData['B_BG_NO']		= $this->db->getSQLInteger($param['B_BG_NO']);
//			$paramData['B_USE']			= $this->db->getSQLString($param['B_USE']);
//			$paramData['B_REG_DT']		= $this->db->getSQLDatetime($param['B_REG_DT']);
//			$paramData['B_REG_NO']		= $this->db->getSQLInteger($param['B_REG_NO']);
			$paramData['B_MOD_DT']		= $this->db->getSQLDatetime($param['B_MOD_DT']);
			$paramData['B_MOD_NO']		= $this->db->getSQLInteger($param['B_MOD_NO']);

			if($param['B_CODE']):
				$bCode				= $this->db->getSQLString($param['B_CODE']);
				$where				= "B_CODE = {$bCode}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_MGR_NEW", $paramData, $where);	

		}

		function getBoardMgrNewUseUpdateEx($param)
		{
			## 기본설정
			$strB_CODE = $param['B_CODE'];

			## 공백제거
			$strB_CODE = trim($strB_CODE);

			## 체크
			if(!$strB_CODE) { return; }

			## where 절 만들기
			$where = "B_CODE = '{$strB_CODE}'";

			## 수정데이터 설정
			$paramData					= "";
//			$paramData['B_CODE']		= $this->db->getSQLString($param['B_CODE']);
			$paramData['B_USE']			= $this->db->getSQLString($param['B_USE']);
			$paramData['B_MOD_DT']		= $this->db->getSQLDatetime($param['B_MOD_DT']);
			$paramData['B_MOD_NO']		= $this->db->getSQLInteger($param['B_MOD_NO']);

			return $this->db->getUpdateParam("BOARD_MGR_NEW", $paramData, $where);	

		}

		function getBoardMgrNewDeleteEx($param)
		{

		}

		function getBoardMgrNewBoardUbTableCreate($param) {

			## 기본설정
			$strBCode = $param['b_code'];
			$strBName = $param['b_name'];
			$strTable = "BOARD_UB_{$strBCode}";

			## 체크
			if(!$strBCode) { return; }
			if(!$strBName) { return; }

			$SQL  = "	CREATE																				";
			$SQL .= "       TABLE `{$strTable}`															";
			$SQL .= "       (																				";
			$SQL .= "           `UB_NO` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '번호',					";
			$SQL .= "           `UB_NAME` varchar(20) DEFAULT NULL COMMENT '이름',							";
			$SQL .= "           `UB_M_NO` bigint(20) DEFAULT NULL COMMENT '회원번호',						";
			$SQL .= "           `UB_M_ID` varchar(20) DEFAULT NULL COMMENT '아이디',						";
			$SQL .= "           `UB_PASS` varchar(100) DEFAULT NULL COMMENT '비밀번호',						";
			$SQL .= "           `UB_MAIL` varchar(50) DEFAULT NULL COMMENT '이메일',						";
			$SQL .= "           `UB_URL` varchar(200) DEFAULT NULL COMMENT '웹주소',						";
			$SQL .= "           `UB_TITLE` varchar(200) DEFAULT NULL COMMENT '제목',						";
			$SQL .= "           `UB_TEXT` text COMMENT '내용',												";
			$SQL .= "           `UB_TEXT_MOBILE` text COMMENT '내용(모바일)',								";
			$SQL .= "           `UB_FUNC` varchar(20) DEFAULT '0000000000' COMMENT '기능(공지글, 비밀글..)',";
			$SQL .= "           `UB_IP` varchar(20) DEFAULT NULL COMMENT 'IP',								";
			$SQL .= "           `UB_READ` int(11) DEFAULT '0' COMMENT '조회수',								";
			$SQL .= "           `UB_BC_NO` bigint(20) DEFAULT '0' COMMENT '카테고리 번호',                  ";
			$SQL .= "           `UB_LNG` varchar(2) DEFAULT NULL COMMENT '작성 언어',						";
			$SQL .= "           `UB_ANS_NO` bigint(20) default NULL COMMENT '계층형-최상위글 번호',         ";
			$SQL .= "           `UB_ANS_DEPTH` bigint(20) default NULL COMMENT '계층형-답변깊이',           ";
			$SQL .= "           `UB_ANS_STEP` varbinary(100) default NULL COMMENT '계층형-답변모양',        ";
			$SQL .= "           `UB_ANS_M_NO` bigint(20) default NULL COMMENT '계층형-원글 회원 ID',        ";
			$SQL .= "           `UB_PT_NO` bigint(20) default NULL COMMENT '이벤트-포인트 번호',            ";
			$SQL .= "           `UB_CI_NO` bigint(20) default NULL COMMENT '이벤트-쿠폰 번호',              ";
			$SQL .= "           `UB_WINNER` varchar(1) default NULL COMMENT '이벤트-담청자',                ";
			$SQL .= "           `UB_P_CODE` varchar(20) default NULL COMMENT '상품-코드',					";
			$SQL .= "           `UB_P_GRADE` smallint(6) default NULL COMMENT '상품-평점',					";
			$SQL .= "           `UB_DEL` varchar(1) default 'N' COMMENT '삭제(Y)',							";
			$SQL .= "           `UB_SHOP_NO` int(11) default NULL COMMENT '샵번호(입점몰번호)',             ";
			$SQL .= "           `UB_REG_DT` datetime DEFAULT NULL COMMENT '작성일',							";
			$SQL .= "           `UB_REG_NO` bigint(20) DEFAULT NULL COMMENT '작성자',						";
			$SQL .= "           `UB_MOD_DT` datetime DEFAULT NULL COMMENT '수정일',							";
			$SQL .= "           `UB_MOD_NO` bigint(20) DEFAULT NULL COMMENT '수정자',						";
			$SQL .= "           PRIMARY KEY (`UB_NO`),														";
			$SQL .= "           KEY `IDX_P_CODE` (`UB_P_CODE`)												";
			$SQL .= "       )																				";
			$SQL .= "       ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='커뮤니티-{$strBName}';				";
			$SQL .= "																						";
	
			return $this->db->getExecSql($SQL);
		}

		function getBoardMgrNewBoardFLTableCreate($param) {

			## 기본설정
			$strBCode = $param['b_code'];
			$strBName = $param['b_name'];
			$strTable = "BOARD_FL_{$strBCode}";

			## 체크
			if(!$strBCode) { return; }
			if(!$strBName) { return; }

			$SQL  = "	CREATE																						";
			$SQL .= "       TABLE `{$strTable}`																	";
			$SQL .= "       (																						";
			$SQL .= "           `FL_NO` bigint(20) NOT NULL auto_increment COMMENT '번호',							";
			$SQL .= "           `FL_UB_NO` bigint(20) default NULL COMMENT '게시판 번호',							";
			$SQL .= "           `FL_KEY` varchar(50) default NULL COMMENT '키',										";
			$SQL .= "           `FL_DIR` varchar(200) default NULL COMMENT '파일경로',								";
			$SQL .= "           `FL_NAME` varchar(100) default NULL COMMENT '파일이름',								";
			$SQL .= "           `FL_TYPE` varchar(20) default NULL COMMENT '파일형식',								";
			$SQL .= "           `FL_SIZE` int(11) default NULL COMMENT '파일크기',									";
			$SQL .= "           `FL_REG_DT` datetime default NULL COMMENT '작성일',									";
			$SQL .= "           `FL_REG_NO` bigint(20) default NULL COMMENT '작성자',								";
			$SQL .= "           `FL_MOD_DT` datetime default NULL COMMENT '수정일',									";
			$SQL .= "           `FL_MOD_NO` bigint(20) default NULL COMMENT '수정자',								";
			$SQL .= "           PRIMARY KEY (`FL_NO`)																";
			$SQL .= "       )																						";
			$SQL .= "       ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='첨부파일-{$strBName}';	";

			return $this->db->getExecSql($SQL);
		}

		function getBoardMgrNewBoardCMTableCreate($param) {

			## 기본설정
			$strBCode = $param['b_code'];
			$strBName = $param['b_name'];
			$strTable = "BOARD_CM_{$strBCode}";

			## 체크
			if(!$strBCode) { return; }
			if(!$strBName) { return; }

			$SQL  = " CREATE																					";
			$SQL .= "       TABLE `{$strTable}`																";
			$SQL .= "       (																					";
			$SQL .= "           `CM_NO` bigint(20) NOT NULL auto_increment COMMENT '번호',						";
			$SQL .= "           `CM_UB_NO` bigint(20) default NULL COMMENT '게시판 번호',						";
			$SQL .= "           `CM_NAME` varchar(20) default NULL COMMENT '비회원-이름',						";
			$SQL .= "           `CM_M_NO` bigint(20) default NULL COMMENT '회원 번호',							";
			$SQL .= "           `CM_M_ID` varchar(20) default NULL COMMENT '비회원-아이디',						";
			$SQL .= "           `CM_PASS` varchar(100) default NULL COMMENT '비회원-비밀번호',					";
			$SQL .= "           `CM_MAIL` varchar(50) default NULL COMMENT '비회원-이메일',						";
			$SQL .= "           `CM_TITLE` varchar(200) default NULL COMMENT '제목',							";
			$SQL .= "           `CM_TEXT` text COMMENT '내용',													";
			$SQL .= "           `CM_FUNC` varchar(20) default '0000000000' COMMENT '기능(공지글,비밀글)',		";
			$SQL .= "           `CM_IP` varchar(20) default NULL COMMENT 'IP',									";
			$SQL .= "           `CM_READ` int(11) default NULL COMMENT '추천수',								";
			$SQL .= "           `CM_ANS_NO` bigint(20) default NULL COMMENT '계층형-최상위글 번호',				";
			$SQL .= "           `CM_ANS_DEPTH` bigint(20) default NULL COMMENT '계층형-답변깊이',				";
			$SQL .= "           `CM_ANS_STEP` bigint(100) default NULL COMMENT '계층형-답변모양',				";
			$SQL .= "           `CM_ANS_M_NO` bigint(20) default NULL COMMENT '계층형-원글 회원 ID',			";
			$SQL .= "           `CM_PT_NO` bigint(20) default NULL COMMENT '이벤트-포인트 번호',				";
			$SQL .= "           `CM_CI_NO` bigint(20) default NULL COMMENT '이벤트-쿠폰 번호',					";
			$SQL .= "           `CM_WINNER` varchar(1) default NULL COMMENT '이벤트-담청자',					";
			$SQL .= "           `CM_LIKE` int(11) default '0' COMMENT '추천(좋아요)',							";
			$SQL .= "           `CM_HATE` int(11) default '0' COMMENT '반대(싫어요)',							";
			$SQL .= "           `CM_DEL` varchar(1) default NULL COMMENT '삭제(Y)',								";
			$SQL .= "           `CM_REG_DT` datetime default NULL COMMENT '작성일',								";
			$SQL .= "           `CM_REG_NO` bigint(20) default NULL COMMENT '작성자',							";
			$SQL .= "           `CM_MOD_DT` datetime default NULL COMMENT '수정일',								";
			$SQL .= "           `CM_MOD_NO` bigint(20) default NULL COMMENT '수정자',							";
			$SQL .= "           PRIMARY KEY (`CM_NO`),															";
			$SQL .= "           KEY `IDX_M_NO` (`CM_M_NO`)														";
			$SQL .= "       )																					";
			$SQL .= "       ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='코멘트-{$strBName}';	";
			$SQL .= "																							";

			return $this->db->getExecSql($SQL);
		}

		function getBoardMgrNewBoardADTableCreate($param) {

			## 기본설정
			$strBCode = $param['b_code'];
			$strBName = $param['b_name'];
			$strTable = "BOARD_AD_{$strBCode}";

			## 체크
			if(!$strBCode) { return; }
			if(!$strBName) { return; }

			$SQL  = " CREATE																	";
			$SQL .= "       TABLE `{$strTable}`											";
			$SQL .= "       (																	";
			$SQL .= "           `AD_UB_NO` bigint(20) NOT NULL COMMENT '게시판번호',			";
			$SQL .= "           `AD_PHONE1` varchar(30) default NULL COMMENT '연락처1',			";
			$SQL .= "           `AD_PHONE2` varchar(30) default NULL COMMENT '연락처2',			";
			$SQL .= "           `AD_PHONE3` varchar(30) default NULL COMMENT '연락처3',			";
			$SQL .= "           `AD_ZIP` varchar(10) default NULL COMMENT '우편번호',			";
			$SQL .= "           `AD_ADDR1` varchar(100) default NULL COMMENT '주소1',			";
			$SQL .= "           `AD_ADDR2` varchar(150) default NULL COMMENT '주소2',			";
			$SQL .= "           `AD_COMPANY` varchar(100) default NULL COMMENT '회사명',		";
			$SQL .= "           `AD_TEMP1` varchar(50) default NULL COMMENT '임시필드1',		";
			$SQL .= "           `AD_TEMP2` varchar(50) default NULL COMMENT '임시필드2',		";
			$SQL .= "           `AD_TEMP3` varchar(50) default NULL COMMENT '임시필드3',		";
			$SQL .= "           `AD_TEMP4` varchar(50) default NULL COMMENT '임시필드4',		";
			$SQL .= "           `AD_TEMP5` varchar(200) default NULL COMMENT '임시필드5',		";
			$SQL .= "           `AD_TEMP6` varchar(200) default NULL COMMENT '임시필드6',		";
			$SQL .= "           `AD_TEMP7` varchar(200) default NULL COMMENT '임시필드7',		";
			$SQL .= "           `AD_TEMP8` varchar(200) default NULL COMMENT '임시필드8',		";
			$SQL .= "           `AD_TEMP9` varchar(500) default NULL COMMENT '임시필드9',		";
			$SQL .= "           `AD_TEMP10` varchar(500) default NULL COMMENT '임시필드10',		";
			$SQL .= "           `AD_TEMP11` varchar(500) default NULL COMMENT '임시필드11',		";
			$SQL .= "           `AD_TEMP12` varchar(500) default NULL COMMENT '임시필드12',		";
			$SQL .= "           `AD_TEMP13` varchar(10) default NULL COMMENT '임시필드13',		";
			$SQL .= "           `AD_TEMP14` varchar(10) default NULL COMMENT '임시필드14',		";
			$SQL .= "           `AD_TEMP15` varchar(10) default NULL COMMENT '임시필드15',		";
			$SQL .= "           `AD_TEMP16` varchar(1) default NULL COMMENT '임시필드16',		";
			$SQL .= "           `AD_TEMP17` varchar(1) default NULL COMMENT '임시필드17',		";
			$SQL .= "           `AD_TEMP18` text COMMENT '임시필드18',							";
			$SQL .= "           `AD_TEMP19` text COMMENT '임시필드19',							";
			$SQL .= "           `AD_TEMP20` text COMMENT '임시필드20',							";
			$SQL .= "           PRIMARY KEY (`AD_UB_NO`),										";
			$SQL .= "           UNIQUE KEY `AD_UB_NO` (`AD_UB_NO`)								";
			$SQL .= "       )																	";
			$SQL .= "       ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='추가필드-{$strBName}';  ";
			$SQL .= "																			";


			return $this->db->getExecSql($SQL);
		}

		function getSelectQuery($query, $op)
		{
			if ( $op == "OP_LIST" ) :
				return $this->db->getExecSql($query);
			elseif ( $op == "OP_SELECT" ) :
				return $this->db->getSelect($query);
			elseif ( $op == "OP_COUNT" ) :
				return $this->db->getCount($query);
			elseif ( $op == "OP_ARYLIST" ) :
				return $this->db->getArray($query);
			elseif ( $op == "OP_ARYTOTAL" ) :
				return $this->db->getArrayTotal($query);
			else :
				return -100;
			endif;
		}	
}