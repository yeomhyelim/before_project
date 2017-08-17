<?
	## STEP 1.
	## 설정
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	$memberMgr = new MemberMgr();

	## STEP 2-1.
	## 컬럼 만들기(user)
	$cnt				= 0;
	$memberMgr->setJI_GB($aryJI_GB_Naming['user']);
	$resultTemp			= $memberMgr->getMemberJoinItemSelect($db, "OP_LIST");
	while($row = mysql_fetch_array($resultTemp)):

		$row['JI_CODE'] = str_replace("REC", "M_REC_ID", $row['JI_CODE']);
		$row['JI_CODE'] = str_replace("NICKNAME", "NICK_NAME", $row['JI_CODE']);
		
		if($row['JI_CODE'] == "NAME"):
			if($S_SITE_LNG != "KR"):
				$select_column[$cnt]['COLUMN']		= "A.M_F_NAME";
				$select_column[$cnt]['NAME']		= "성";
				$cnt++;	
			endif;

			$select_column[$cnt]['COLUMN']		= "A.M_L_NAME";
			$select_column[$cnt]['NAME']		= "이름";
			$cnt++;	
			continue;
		elseif($row['JI_CODE'] == "ADDR"):
			$select_column[$cnt]['COLUMN']		= "A.M_ZIP";
			$select_column[$cnt]['NAME']		= "우편번호";
			$cnt++;	

			$select_column[$cnt]['COLUMN']		= "A.M_ADDR";
			$select_column[$cnt]['NAME']		= "주소";
			$cnt++;	

			$select_column[$cnt]['COLUMN']		= "A.M_ADDR2";
			$select_column[$cnt]['NAME']		= "상세주소";
			$cnt++;	
			continue;
		endif;

		// 추천인
		if($row['JI_CODE'] == "M_REC_ID"):

			$select_column[$cnt]['COLUMN']		= "(CASE WHEN IFNULL(A.M_REC_ID, 0) > 0 THEN (SELECT M_ID FROM MEMBER_MGR WHERE M_NO = A.M_REC_ID) ELSE NULL END) as M_REC_ID";
			$select_column[$cnt]['TAG']			= "A.M_REC_ID";
			$select_column[$cnt]['NAME']		= $row['JI_NAME_KR'];
			$cnt++;	
			continue;
		endif;

		if($row['JI_CODE'] == 'PASS') { continue; } 
		if($row['JI_USE'] == 'N') { continue; } 

		$select_column[$cnt]['COLUMN']		= "A.M_{$row['JI_CODE']}";
		$select_column[$cnt]['NAME']		= $row['JI_NAME_KR'];
		$cnt++;		
	endwhile;

	$select_column[$cnt]['COLUMN']		= "A.M_REG_DT";
	$select_column[$cnt]['NAME']		= "회원 가입일";
	$cnt++;		



	## STEP 2-2.
	## 컬럼 만들기(business)
//	$cnt				= 0;
	$memberMgr->setJI_GB($aryJI_GB_Naming['business']);
	$resultTemp			= $memberMgr->getMemberJoinItemSelect($db, "OP_LIST");
	while($row = mysql_fetch_array($resultTemp)):
		if($row['JI_USE'] == 'N') { continue; } 
		$row['JI_CODE']						= str_replace("COM", "COM_NM", $row['JI_CODE']);
		$select_column[$cnt]['COLUMN']		= "B.M_{$row['JI_CODE']}";
		$select_column[$cnt]['NAME']		= $row['JI_NAME_KR'];
		$cnt++;		
	endwhile;


	## STEP 2-4.
	## 컬럼 만들기(temp)
//	$cnt				= 0;
	$memberMgr->setJI_GB($aryJI_GB_Naming['temp']);
	$resultTemp			= $memberMgr->getMemberJoinItemSelect($db, "OP_LIST");
	while($row = mysql_fetch_array($resultTemp)):
		if($row['JI_USE'] == 'N') { continue; } 
		$row['JI_CODE']						= str_replace("TMP_1", "M_TMP1", $row['JI_CODE']);
		$row['JI_CODE']						= str_replace("TMP_2", "M_TMP2", $row['JI_CODE']);
		$row['JI_CODE']						= str_replace("TMP_3", "M_TMP3", $row['JI_CODE']);
		$row['JI_CODE']						= str_replace("TMP_4", "M_TMP4", $row['JI_CODE']);
		$row['JI_CODE']						= str_replace("TMP_5", "M_TMP5", $row['JI_CODE']);
		$select_column[$cnt]['COLUMN']	= "B.{$row['JI_CODE']}";
		$select_column[$cnt]['NAME']	= $row['JI_NAME_KR'];
		$cnt++;		
	endwhile;

	## STEP 2-3.
	## 컬럼 만들기(family)
	$cnt				= 0;
	$memberMgr->setJI_GB($aryJI_GB_Naming['family']);
	$resultTemp			= $memberMgr->getMemberJoinItemSelect($db, "OP_LIST");
	while($row = mysql_fetch_array($resultTemp)):
//		if($row['JI_USE'] == 'N') { continue; } 
		$name = str_replace("FAMILY", "MF", $row['JI_CODE']);
		$select_family_column[$cnt]['TYPE']		= "where_family_column";
		
		if($name == "MF_FEED"):
		$select_family_column[$cnt]['TYPE']		= "where_family_feed_column";
		endif;

		$select_family_column[$cnt]['COLUMN']	= "C.{$name}";
//		echo $select_family_column[$cnt]['COLUMN'] . "<br>";
		$select_family_column[$cnt]['NAME']		= $row['JI_NAME_KR'];
		$cnt++;		
	endwhile;




	/** 주문 필드 **/
	$cnt = 0;
	$where_order_buy_column[$cnt]['TAG']		= "O.O_BUY_CNT = 1";
	$where_order_buy_column[$cnt]['COLUMN']		= "tag_use";
	$where_order_buy_column[$cnt]['NAME']		= "첫구매회원";
	$cnt++;

	$where_order_buy_column[$cnt]['TAG']		= "O.O_BUY_CNT > 0";
	$where_order_buy_column[$cnt]['COLUMN']		= "tag_use";
	$where_order_buy_column[$cnt]['NAME']		= "구매회원";
	$cnt++;

	$where_order_buy_column[$cnt]['TAG']		= "O.O_BUY_CNT = 0";
	$where_order_buy_column[$cnt]['COLUMN']		= "tag_use";
	$where_order_buy_column[$cnt]['NAME']		= "비구매회원";
	$cnt++;


	/** 날짜 항목(주문 필드) **/
//	$cnt = 0;
//	$where_order_column[$cnt]['COLUMN']			= "B.P_CODE";
//	$where_order_column[$cnt]['NAME']			= "상품코드";
//	$cnt++;	

	/** 상품 필드 **/
	$cnt = 0;
	$where_prod_buy_column[$cnt]['COLUMN']		= "B.P_CODE";
	$where_prod_buy_column[$cnt]['NAME']		= "상품코드";
	$cnt++;
	
	/** 날짜 항목 **/
	$cnt = 0;
	$where_date_column[$cnt]['COLUMN']			= "A.M_BIRTH";
	$where_date_column[$cnt]['NAME']			= "생년월일";
	$cnt++;	

	$where_date_column[$cnt]['COLUMN']			= "A.M_LOGIN_DT";
	$where_date_column[$cnt]['NAME']			= "최종로그인 ";
	$cnt++;	

	$where_date_column[$cnt]['COLUMN']			= "A.M_REG_DT";
	$where_date_column[$cnt]['NAME']			= "가입일 ";
	$cnt++;	

	/** 날짜 항목(주문 필드) **/
	$cnt = 0;
	$where_order_date_column[$cnt]['COLUMN']	= "A.O_REG_DT";
	$where_order_date_column[$cnt]['NAME']		= "구매일자";
	$cnt++;	
	
	/** de_where_defalut **/
	$de_where_defalut			= "A.M_NO IS NOT NULL AND IFNULL(A.M_OUT,'N') <> 'Y' ";
	$de_where_join_defalut		= "A.O_STATUS = 'E' ";
?>