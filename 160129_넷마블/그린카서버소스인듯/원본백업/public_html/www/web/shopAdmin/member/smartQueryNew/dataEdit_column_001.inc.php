<?
	## STEP 1.
	## 설정
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	$memberMgr = new MemberMgr();

	## STEP 2-1.
	## 컬럼 만들기
	$scnt				= 0;
	$wcnt				= 0;
	$select_column		= null;
	$where_column		= null;

	$select_column[$scnt]['COLUMN']		= "A.M_NO";
	$select_column[$scnt]['NAME']		= "회원번호";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_ID";
	$select_column[$scnt]['NAME']		= "회원아이디";
	$scnt++;		
//	$select_column[$scnt]['COLUMN']		= "A.M_PASS";
//	$select_column[$scnt]['NAME']		= "회원비밀번호";
//	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_F_NAME, A.M_L_NAME";
	$select_column[$scnt]['NAME']		= "이름";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_NICK_NAME";
	$select_column[$scnt]['NAME']		= "닉네임";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_BIRTH";
	$select_column[$scnt]['NAME']		= "생년월일";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_BIRTH_CAL";
	$select_column[$scnt]['NAME']		= "양력/음력";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_SEX";
	$select_column[$scnt]['NAME']		= "성별";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_MAIL";
	$select_column[$scnt]['NAME']		= "메일";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_PHONE";
	$select_column[$scnt]['NAME']		= "전화번호";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_FAX";
	$select_column[$scnt]['NAME']		= "팩스번호";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_HP";
	$select_column[$scnt]['NAME']		= "휴대폰";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_ZIP";
	$select_column[$scnt]['NAME']		= "우편번호";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_ADDR, A.M_ADDR2";
	$select_column[$scnt]['NAME']		= "주소";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_SMSYN";
	$select_column[$scnt]['NAME']		= "SMS수신여부";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_MAILYN";
	$select_column[$scnt]['NAME']		= "메일수신여부";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_TEXT";
	$select_column[$scnt]['NAME']		= "남기는글";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_REC_ID";
	$select_column[$scnt]['NAME']		= "추천인";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_GROUP";
	$select_column[$scnt]['NAME']		= "회원그룹";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_AUTH";
	$select_column[$scnt]['NAME']		= "회원승인";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_POINT";
	$select_column[$scnt]['NAME']		= "포인트";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_BUY_PRICE";
	$select_column[$scnt]['NAME']		= "구매금액";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_BUY_CNT";
	$select_column[$scnt]['NAME']		= "구매횟수";
	$scnt++;
	$select_column[$scnt]['COLUMN']		= "A.M_VISIT_CNT";
	$select_column[$scnt]['NAME']		= "방문횟수";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_REVIEW_CNT";
	$select_column[$scnt]['NAME']		= "리뷰횟수";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_OUT";
	$select_column[$scnt]['NAME']		= "탈퇴및삭제여부";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_OUT_DT";
	$select_column[$scnt]['NAME']		= "탈퇴및삭제일";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_OUT_TXT";
	$select_column[$scnt]['NAME']		= "탈퇴및삭제사유";
	$scnt++;	
//	$select_column[$scnt]['COLUMN']		= "A.M_FACEBOOK_ID";
//	$select_column[$scnt]['NAME']		= "페이스북로그인 ";
//	$scnt++;	
//	$select_column[$scnt]['COLUMN']		= "A.M_FACEBOOK_TOKEN";
//	$select_column[$scnt]['NAME']		= "페이스북키";
//	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_LOGIN_DT";
	$select_column[$scnt]['NAME']		= "최종로그인 ";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_TM_ID";
	$select_column[$scnt]['NAME']		= "TM코드";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_LNG";
	$select_column[$scnt]['NAME']		= "사용언어";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_REG_DT";
	$select_column[$scnt]['NAME']		= "등록일";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_REG_NO";
	$select_column[$scnt]['NAME']		= "등록자";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_MOD_DT";
	$select_column[$scnt]['NAME']		= "수정일";
	$scnt++;	
	$select_column[$scnt]['COLUMN']		= "A.M_MOD_NO";
	$select_column[$scnt]['NAME']		= "수정자";
	$scnt++;

	$where_column[$wcnt]['PARTITION']	= "word";
	$where_column[$wcnt]['STYLE']		= "";
	$where_column[$wcnt]['COLUMN']		= "A.M_NO";
	$where_column[$wcnt]['NAME']		= "회원번호";
	$wcnt++;	
	$where_column[$wcnt]['PARTITION']	= "word";
	$where_column[$wcnt]['STYLE']		= "";
	$where_column[$wcnt]['COLUMN']		= "A.M_ID";
	$where_column[$wcnt]['NAME']		= "회원아이디";
	$wcnt++;	
	$where_column[$wcnt]['PARTITION']	= "word";
	$where_column[$wcnt]['STYLE']		= "";
	$where_column[$wcnt]['COLUMN']		= "A.M_L_NAME";
	$where_column[$wcnt]['NAME']		= "이름";
	$wcnt++;	
	$where_column[$wcnt]['PARTITION']	= "word";
	$where_column[$wcnt]['STYLE']		= "";
	$where_column[$wcnt]['COLUMN']		= "A.M_NICK_NAME";
	$where_column[$wcnt]['NAME']		= "닉네임";
	$wcnt++;	
	$where_column[$wcnt]['PARTITION']	= "word";
	$where_column[$wcnt]['STYLE']		= "where_style_birth";
	$where_column[$wcnt]['MODE']		= "date";
	$where_column[$wcnt]['COLUMN']		= "A.M_BIRTH";
	$where_column[$wcnt]['NAME']		= "생년월일";
	$wcnt++;	
	$where_column[$wcnt]['PARTITION']	= "word";
	$where_column[$wcnt]['STYLE']		= "where_style_birth_cal";
	$where_column[$wcnt]['COLUMN']		= "A.M_BIRTH_CAL";
	$where_column[$wcnt]['NAME']		= "양력/음력";
	$wcnt++;

	## STEP 2-1.
	## 컬럼 만들기
//	$scnt				= 0;
//	$wcnt				= 0;
//	$select_column		= null;
//	$where_column		= null;
//	foreach($aryJI_GB_Naming as $key => $val):
//		$memberMgr->setJI_GB($val);
//		$resultTemp			= $memberMgr->getMemberJoinItemSelect($db, "OP_LIST");
//		while($row = mysql_fetch_array($resultTemp)):
//
//			/** select **/
//			if($row['JI_USE'] == 'N')					{ continue; }
//			if(!$row['JI_NAME_KR'])						{ continue; }
//			if($row['JI_CODE'] == 'PASS')				{ continue; }
//			if($row['JI_CODE'] == 'NAME')				{ continue; }
//			if($row['JI_CODE'] == 'REC')				{ continue; }
//			if($row['JI_CODE'] == 'ADD_CONCERN')		{ continue; }
//
//			$select_column[$scnt]['COLUMN']		= "A.M_{$row['JI_CODE']}";
//			$select_column[$scnt]['NAME']		= $row['JI_NAME_KR'];
//			$scnt++;		
//
//			/** where **/
//			$partition		= "word";
//			$style			= "";
//			if($row['JI_CODE'] == "SEX"):
//				$style = "where_style_sex";
//			elseif($row['JI_CODE'] == "BIRTH"):
//				$partition = "date";
//			elseif($row['JI_CODE'] == "BIRTH_CAL"):
//				$style = "where_style_birth_cal";
//			elseif($row['JI_CODE'] == "SMSYN"):
//				$style = "where_style_smsyn";
//			elseif($row['JI_CODE'] == "MAILYN"):
//				$style = "where_style_mailyn";
//			elseif($row['JI_CODE'] == "REC"):
//				$style = "where_style_rec";
//			elseif($row['JI_CODE']	== "M_BIRTH"):
//				$partition = "date";
//			elseif($row['JI_CODE']	== "M_BIRTH"):
//
//			endif;
//			
//			$where_column[$wcnt]['PARTITION']	= $partition;
//			$where_column[$wcnt]['STYLE']		= $style;
//			$where_column[$wcnt]['COLUMN']		= "A.M_{$row['JI_CODE']}";
//			$where_column[$wcnt]['NAME']		= $row['JI_NAME_KR'];
//			$wcnt++;	
//			
//		endwhile;
//	endforeach;

	/** de_where_defalut **/
	$de_where_defalut			= "A.M_NO IS NOT NULL AND IFNULL(A.M_OUT,'N') <> 'Y' ";
	$de_where_join_defalut		= "A.O_STATUS = 'E' ";
?>

<textarea style="width:100%;height:100px;" id="where_style_birth">
	<input type="text" id="whereDateStart">-<input type="text" id="whereDateEnd">
</textarea>

<textarea style="width:100%;height:100px;" id="where_style_sex">
	<select onChange="goDataEditSelectValueGiveEvent(this);">
		<option value="" >선택</option>
		<option value="M">남자</option>
		<option value="W">여자</option>
	</select>
</textarea>

<textarea style="width:100%;height:100px;" id="where_style_birth_cal">
	<select onChange="goDataEditSelectValueGiveEvent(this);">
		<option value="" >선택</option>
		<option value="M">음력</option>
		<option value="W">양력</option>
	</select>
</textarea>

<textarea style="width:100%;height:100px;" id="where_style_smsyn">
	<select onChange="goDataEditSelectValueGiveEvent(this);">
		<option value="" >선택</option>
		<option value="M">수신함</option>
		<option value="W">수신거부</option>
	</select>
</textarea>

<textarea style="width:100%;height:100px;" id="where_style_mailyn">
	<select onChange="goDataEditSelectValueGiveEvent(this);">
		<option value="" >선택</option>
		<option value="M">수신함</option>
		<option value="W">수신거부</option>
	</select>
</textarea>

<textarea style="width:100%;height:100px;" id="where_style_rec">
	<a class="btn_sml" href="javascript:goDataEditWhereWordRecMoveEvent()"><strong>추천인검색</strong></a>
</textarea>