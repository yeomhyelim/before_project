<?
	switch($strAct):
	case "memberCateDelete":
		// 회원소속 삭제
		## 설정
		require_once MALL_CONF_LIB."memberCateMgr.php";
		$memberCateMgr			= new MemberCateMgr();
			
		## 삭제 가능 여부 체크
		$param					= "";
		$param['C_CODE_LIKE_L']	= $_POST['c_code'];
		$childCount				= $memberCateMgr->getMemberCateListEx($db, "OP_COUNT", $param);
		if($childCount > 1):
			$strMsg		= "삭제할수 없습니다..";
			$strUrl		= $_SERVER['HTTP_REFERER'];
			break;	
		endif;

		## 사용된 소속 여부 체크
		$param				= "";
		$param['C_CODE']	= $_POST['c_code'];
		$intMemberCnt		= $memberCateMgr->getMemberCateCntEx($db,$param);
		if ($intMemberCnt > 0){
			$strMsg		= "소속된 회원이 존재합니다.삭제할수 없습니다..";
			$strUrl		= $_SERVER['HTTP_REFERER'];			
			break;
		}
		
		if ($S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN == "Y")
		{
			## 3차 소속 가상 회원 삭제
			$param				= "";
			$param['C_CODE']	= $_POST['c_code'];
			$cateRow			= $memberCateMgr->getMemberCateListEx($db,"OP_SELECT",$param);
			if ($cateRow['C_M_NO'] > 0){
				$param	= "";
				$param['C_M_NO'] = $cateRow['C_M_NO'];
				$memberCateMgr->getMemberCateVirtualMemberDeleteEx($db,$param);
			}
		}
		
		## 삭제
		$param					= "";
		$param['C_CODE']		= $_POST['c_code'];
		$memberCateRow			= $memberCateMgr->getMemberCateDeleteEx($db, $param);
		$memberCateMakeFile		= "Y";

		## 이동
		$strMsg		= "삭제되었습니다.";
		$strUrl		= $_SERVER['HTTP_REFERER'];


	break;
	case "memberCateModify":
		// 회원소속 수정
		## 설정
		require_once MALL_CONF_LIB."memberCateMgr.php";
		$memberCateMgr			= new MemberCateMgr();

		## 기존 정보
		$param					= "";
		$param['C_CODE']		= $_POST['c_code'];
		$memberCateRow			= $memberCateMgr->getMemberCateListEx($db, "OP_SELECT", $param);

		## insert
		$param					= "";
		$param['C_CODE']		= $_POST['c_code'];
		$param['C_NAME']		= $_POST['c_name'];
		$param['C_LEVEL']		= strlen($_POST['c_code']) / 3;
		$param['C_LOW_YN']		= "N";
//		$param['C_HCODE']		= "";
		$param['C_ORDER']		= "";
		$param['C_VIEW']		= $_POST['c_view'];
		$param['C_NATION']		= $memberCateRow['C_NATION'];
		$param['C_POINT']		= $_POST['c_point'];
		$param['C_POINT_OFF']	= $_POST['c_point_off'];
		$param['C_POINT2']		= $_POST['c_point2'];
		$param['C_POINT2_OFF']	= $_POST['c_point2_off'];
//		$param['C_REG_NO']		= $a_admin_no;
		$param['C_MOD_NO']		= $a_admin_no;
		$memberCateMgr->getMemberCateUpdateEx($db, $param);
		$memberCateMakeFile		= "Y";
				
		if ($S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN == "Y"){
			/** 비밀번호 변경 **/
			if ($_POST["memberPass"]){
				$param['M_NO']		= $memberCateRow['C_M_NO']; 
				$param['M_PASS']	= $_POST['memberPass'];
				$memberCateMgr->getMemberCateVirtualPwdUpdate($db,$param);
			}

			/** 아이디 변경 **/
			if ($_POST["memberId"]){
				$param['M_NO']	= $memberCateRow['C_M_NO']; 
				$param['M_ID']	= $_POST['memberId'];
				$memberCateMgr->getMemberCateVirtualIdUpdate($db,$param);
			}
		}

		## 이동
		$strMsg		= "수정되었습니다.";
		$strUrl		= $_SERVER['HTTP_REFERER'];

		echo "<script language=\"javascript\">alert('".$strMsg."');parent.goPopClose();</script>";

	break;
	case "memberCateWrite":
		// 회원소속 등록

		## 설정
		require_once MALL_CONF_LIB."memberCateMgr.php";
		$memberCateMgr			= new MemberCateMgr();

		## 레벨 설정
		$c_level				= 1;
		$c_high_code			= "";

		if($_POST['c_cate_1']) { $c_level = 2; $c_high_code  = $_POST['c_cate_1'];}
		if($_POST['c_cate_2']) { $c_level = 3; $c_high_code  = $_POST['c_cate_2'];}
		if($_POST['c_cate_3']) { $c_level = 4; $c_high_code  = $_POST['c_cate_3'];}
		if($_POST['c_cate_4']) { $c_level = 5;}

		## 회원소속 코드 가져오기
		$param					= "";
		$param['C_LEVEL']		= $c_level;
		$param['C_CODE_LIKE_L']	= $c_high_code; 
		$memberCateRow			= $memberCateMgr->getMemberCateListEx($db, "OP_MAX_C_CODE", $param);
		if(!$memberCateRow['MAX_C_CODE']):
			$c_code				= "";
			if ($_POST['c_cate_1']) $c_code  = $_POST['c_cate_1'];
			if ($_POST['c_cate_2']) $c_code  = $_POST['c_cate_2'];
			if ($_POST['c_cate_3']) $c_code  = $_POST['c_cate_3'];
			
			$c_code				 .= "001";
		else:
			
			$length				= strlen($memberCateRow['MAX_C_CODE']);
			$c_code				= $memberCateRow['MAX_C_CODE'] + 1;
			$c_code				= str_pad($c_code, $length, "0", "STR_PAD_LEFT"); 
		endif;
		## insert
		$param					= "";
		$param['C_CODE']		= $c_code;
		$param['C_NAME']		= $_POST['c_name'];
		$param['C_LEVEL']		= strlen($c_code) / 3;
		$param['C_LOW_YN']		= "N";
		$param['C_HCODE']		= $c_high_code;
		$param['C_ORDER']		= "";
		$param['C_VIEW']		= $_POST['c_view'];
		$param['C_NATION']		= $_POST['c_nation'];
		$param['C_POINT']		= $_POST['c_point'];
		$param['C_POINT_OFF']	= $_POST['c_point_off'];
		$param['C_POINT2']		= $_POST['c_point2'];
		$param['C_POINT2_OFF']	= $_POST['c_point2_off'];
		$param['C_REG_NO']		= $a_admin_no;
		$param['C_MOD_NO']		= $a_admin_no;

		$memberCateMgr->getMemberCateInsertEx($db, $param);
		$memberCateMakeFile		= "Y";
		
		if ($S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN == "Y"){
			## 3차일때 가상소속회원 만들기
			if (strlen($c_code) / 3 == 2 || strlen($c_code) / 3 == 3){
				$param				= "";
				$param['M_L_NAME']	= $_POST['c_name'];
				$param['M_GROUP']	= "006";
				$param['M_REG_NO']	= $a_admin_no;
				$param['M_ID']		= $_POST['memberId'];
				
				## 1. MEMBER_MGR 추가
				$memberCateMgr->getMemberCateVirtualMake($db,$param);
				$intM_NO			= $db->getLastInsertID();
				
				## 2. MEMBER_ADD 추가
				$param['M_NO']		= $intM_NO;
				$memberCateMgr->getMemberCateVirtualAddMake($db,$param);
				
				## 3. MEMBER_MGR 비밀번호 UPDATE 
				$param['M_PASS']	= $_POST['memberPass'];
				$memberCateMgr->getMemberCateVirtualPwdUpdate($db,$param);

				## 4. MEMBER_CATE 소속아이디 UPDATE
				$param['C_CODE']	= $c_code;
				$memberCateMgr->getMemberCateUpdateVirtualUpdate($db,$param);
			}
		}
		## 이동
		$strMsg		= "등록되었습니다.";
		$strUrl		= $_SERVER['HTTP_REFERER'];
		
	break;

	endswitch;	


	if($memberCateMakeFile == "Y"):

		## 회원소속(케테고리) 데이터 만들기
		$param					= "";
		$memberCateResult		= $memberCateMgr->getMemberCateListEx($db, "OP_LIST", $param);
		$data					= "";

		while($row = mysql_fetch_array($memberCateResult)):
			
			$cateTag	= "['{$row['C_CODE']}']";

			## 회원소속코드
			$dataTemp	= "";
			$dataTemp	= "\$MEMBER_CATE{$cateTag}['C_CODE']";
			$dataTemp	= str_pad($dataTemp, 100, " ", STR_PAD_RIGHT);
			$dataTemp	= "{$dataTemp} = \"{$row['C_CODE']}\";";
			$data	   .= ($data) ? "\r\n" : "";
			$data	   .= $dataTemp;

			## 카테고리명
			$dataTemp	= "";
			$dataTemp	= "\$MEMBER_CATE{$cateTag}['C_NAME']";
			$dataTemp	= str_pad($dataTemp, 100, " ", STR_PAD_RIGHT);
			$dataTemp	= "{$dataTemp} = \"{$row['C_NAME']}\";";
			$data	   .= ($data) ? "\r\n" : "";
			$data	   .= $dataTemp;

			## 국가
			$dataTemp	= "";
			$dataTemp	= "\$MEMBER_CATE{$cateTag}['C_NATION']";
			$dataTemp	= str_pad($dataTemp, 100, " ", STR_PAD_RIGHT);
			$dataTemp	= "{$dataTemp} = \"{$row['C_NATION']}\";";
			$data	   .= ($data) ? "\r\n" : "";
			$data	   .= $dataTemp;

			## 카테고리레벨
			$dataTemp	= "";
			$dataTemp	= "\$MEMBER_CATE{$cateTag}['C_LEVEL']";
			$dataTemp	= str_pad($dataTemp, 100, " ", STR_PAD_RIGHT);
			$dataTemp	= "{$dataTemp} = \"{$row['C_LEVEL']}\";";
			$data	   .= ($data) ? "\r\n" : "";
			$data	   .= $dataTemp;

			## 사용여부
			$dataTemp	= "";
			$dataTemp	= "\$MEMBER_CATE{$cateTag}['C_VIEW']";
			$dataTemp	= str_pad($dataTemp, 100, " ", STR_PAD_RIGHT);
			$dataTemp	= "{$dataTemp} = \"{$row['C_VIEW']}\";";
			$data	   .= ($data) ? "\r\n" : "";
			$data	   .= $dataTemp;

			$data	   .= ($data) ? "\r\n" : "";
		endwhile;

		## 파일 만들기(기존 데이터 업데이트 형)
		require_once "{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
		$file				= new FileHandler();
		$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
		$file				= new FileHandler();	
		$file->getMadeInfo($fileName, $data, "/*@ 회원소속관리 @*/");

	endif;

	if($_POST['close'] == "close"):
		echo "<script>alert('{$strMsg}');parent.location.reload();</script>";
		exit;
	endif;
?>