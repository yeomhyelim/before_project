<?
	$intMN_NO		= $_POST["mn_no"]			? $_POST["mn_no"]			: $_REQUEST["mn_no"];
	$strMN_CODE		= $_POST["mn_code"]			? $_POST["mn_code"]			: $_REQUEST["mn_code"];
	$strMN_NAME_KR	= $_POST["mn_name_kr"]		? $_POST["mn_name_kr"]		: $_REQUEST["mn_name_kr"];
	$strMN_NAME_US	= $_POST["mn_name_us"]		? $_POST["mn_name_us"]		: $_REQUEST["mn_name_us"];
	$strMN_NAME_CN	= $_POST["mn_name_cn"]		? $_POST["mn_name_cn"]		: $_REQUEST["mn_name_cn"];
	$strMN_NAME_JP	= $_POST["mn_name_jp"]		? $_POST["mn_name_jp"]		: $_REQUEST["mn_name_jp"];
	$strMN_NAME_ID	= $_POST["mn_name_id"]		? $_POST["mn_name_id"]		: $_REQUEST["mn_name_id"];
	$strMN_NAME_FR	= $_POST["mn_name_fr"]		? $_POST["mn_name_fr"]		: $_REQUEST["mn_name_fr"];

	$intMN_LEVEL	= $_POST["mn_level"]		? $_POST["mn_level"]		: $_REQUEST["mn_level"];
	$strMN_HIGH_01	= $_POST["mn_high_01"]		? $_POST["mn_high_01"]		: $_REQUEST["mn_high_01"];
	$strMN_HIGH_02	= $_POST["mn_high_02"]		? $_POST["mn_high_02"]		: $_REQUEST["mn_high_02"];
	$strMN_AUTH_L	= $_POST["mn_auth_l"]		? $_POST["mn_auth_l"]		: $_REQUEST["mn_auth_l"];
	$strMN_AUTH_W	= $_POST["mn_auth_w"]		? $_POST["mn_auth_w"]		: $_REQUEST["mn_auth_w"];
	$strMN_AUTH_M	= $_POST["mn_auth_m"]		? $_POST["mn_auth_m"]		: $_REQUEST["mn_auth_m"];
	$strMN_AUTH_D	= $_POST["mn_auth_d"]		? $_POST["mn_auth_d"]		: $_REQUEST["mn_auth_d"];
	$strMN_AUTH_E	= $_POST["mn_auth_e"]		? $_POST["mn_auth_e"]		: $_REQUEST["mn_auth_e"];
	$strMN_AUTH_C	= $_POST["mn_auth_c"]		? $_POST["mn_auth_c"]		: $_REQUEST["mn_auth_c"];
	$strMN_AUTH_S	= $_POST["mn_auth_s"]		? $_POST["mn_auth_s"]		: $_REQUEST["mn_auth_s"];
	$strMN_AUTH_P	= $_POST["mn_auth_p"]		? $_POST["mn_auth_p"]		: $_REQUEST["mn_auth_p"];
	$strMN_AUTH_U	= $_POST["mn_auth_u"]		? $_POST["mn_auth_u"]		: $_REQUEST["mn_auth_u"];
	$strMN_AUTH_E1	= $_POST["mn_auth_e1"]		? $_POST["mn_auth_e1"]		: $_REQUEST["mn_auth_e1"];
	$strMN_AUTH_E2	= $_POST["mn_auth_e2"]		? $_POST["mn_auth_e2"]		: $_REQUEST["mn_auth_e2"];
	$strMN_AUTH_E3	= $_POST["mn_auth_e3"]		? $_POST["mn_auth_e3"]		: $_REQUEST["mn_auth_e3"];
	$strMN_AUTH_E4	= $_POST["mn_auth_e4"]		? $_POST["mn_auth_e4"]		: $_REQUEST["mn_auth_e4"];
	$strMN_AUTH_E5	= $_POST["mn_auth_e5"]		? $_POST["mn_auth_e5"]		: $_REQUEST["mn_auth_e5"];
	
	$strMN_URL		= $_POST["mn_url"]			? $_POST["mn_url"]			: $_REQUEST["mn_url"];
	$strMN_USE		= $_POST["mn_use"]			? $_POST["mn_use"]			: $_REQUEST["mn_use"];

	$intMN_ORDER	= $_POST["mn_order"]		? $_POST["mn_order"]		: $_REQUEST["mn_order"];

	//메뉴번호
	$aryChkMenuNo		= $_POST["mn_no"]		? $_POST["mn_no"]			: $_REQUEST["mn_no"];

	$strMN_CODE		= strTrim($strMN_CODE,3);
	$strMN_NAME		= strTrim($strMN_NAME,50);
	$strMN_HIGH_01	= strTrim($strMN_HIGH_01,3);
	$strMN_HIGH_02	= strTrim($strMN_HIGH_02,3);
	$strMN_AUTH_L	= strTrim($strMN_AUTH_L,1);
	$strMN_AUTH_W	= strTrim($strMN_AUTH_W,1);
	$strMN_AUTH_M	= strTrim($strMN_AUTH_M,1);
	$strMN_AUTH_D	= strTrim($strMN_AUTH_D,1);
	$strMN_AUTH_E	= strTrim($strMN_AUTH_E,1);
	$strMN_AUTH_C	= strTrim($strMN_AUTH_C,1);
	$strMN_AUTH_S	= strTrim($strMN_AUTH_S,1);
	$strMN_AUTH_U	= strTrim($strMN_AUTH_U,1);
	$strMN_AUTH_P	= strTrim($strMN_AUTH_P,1);
	$strMN_AUTH_E1	= strTrim($strMN_AUTH_E1,1);
	$strMN_AUTH_E2	= strTrim($strMN_AUTH_E2,1);
	$strMN_AUTH_E3	= strTrim($strMN_AUTH_E3,1);
	$strMN_AUTH_E4	= strTrim($strMN_AUTH_E4,1);
	$strMN_AUTH_E5	= strTrim($strMN_AUTH_E5,1);

	$strMN_URL		= strTrim($strMN_URL,100);
	$strMN_USE		= strTrim($strMN_USE,1);

	$menuMgr->setMN_NO($intMN_NO);
	$menuMgr->setMN_CODE($strMN_CODE);
	
	$menuMgr->setMN_NAME_KR($strMN_NAME_KR);
	$menuMgr->setMN_NAME_US($strMN_NAME_US);
	$menuMgr->setMN_NAME_CN($strMN_NAME_CN);
	$menuMgr->setMN_NAME_JP($strMN_NAME_JP);
	$menuMgr->setMN_NAME_ID($strMN_NAME_ID);
	$menuMgr->setMN_NAME_FR($strMN_NAME_FR);
	$menuMgr->setMN_LEVEL($intMN_LEVEL);
	$menuMgr->setMN_HIGH_01($strMN_HIGH_01);
	$menuMgr->setMN_HIGH_02($strMN_HIGH_02);
	$menuMgr->setMN_AUTH_L($strMN_AUTH_L);
	$menuMgr->setMN_AUTH_W($strMN_AUTH_W);
	$menuMgr->setMN_AUTH_M($strMN_AUTH_M);
	$menuMgr->setMN_AUTH_D($strMN_AUTH_D);
	$menuMgr->setMN_AUTH_E($strMN_AUTH_E);
	$menuMgr->setMN_AUTH_C($strMN_AUTH_C);
	$menuMgr->setMN_AUTH_S($strMN_AUTH_S);
	$menuMgr->setMN_AUTH_U($strMN_AUTH_U);
	$menuMgr->setMN_AUTH_P($strMN_AUTH_P);
	$menuMgr->setMN_AUTH_E1($strMN_AUTH_E1);
	$menuMgr->setMN_AUTH_E2($strMN_AUTH_E2);
	$menuMgr->setMN_AUTH_E3($strMN_AUTH_E3);
	$menuMgr->setMN_AUTH_E4($strMN_AUTH_E4);
	$menuMgr->setMN_AUTH_E5($strMN_AUTH_E5);
	$menuMgr->setMN_URL($strMN_URL);
	$menuMgr->setMN_USE($strMN_USE);
	$menuMgr->setMN_ORDER($intMN_ORDER);
	
	$menuMgr->setMN_REG_NO(1);
	$menuMgr->setMN_MOD_NO(1);

	$linkPage = "./?menuType=menu&mode=list";

	switch ($strAct) {
		case "write":
			$menuMgr->getInsert($db);
			$strMsg = "저장되었습니다.";
			$strUrl = $linkPage;
		break;
		case "modify":
			
			if(is_Array($aryChkMenuNo)){
				for($i=0;$i<=count($aryChkMenuNo);$i++){
					
					if($aryChkMenuNo[$i] > 0){
																
						$intMN_NO		= $aryChkMenuNo[$i];
						
						$strMN_NAME_KR	= $_POST["mn_name_kr_".$intMN_NO]			? $_POST["mn_name_kr_".$intMN_NO]			: $_REQUEST["mn_name_kr_".$intMN_NO];
						$strMN_NAME_US	= $_POST["mn_name_us_".$intMN_NO]			? $_POST["mn_name_us_".$intMN_NO]			: $_REQUEST["mn_name_us_".$intMN_NO];
						$strMN_NAME_CN	= $_POST["mn_name_cn_".$intMN_NO]			? $_POST["mn_name_cn_".$intMN_NO]			: $_REQUEST["mn_name_cn_".$intMN_NO];
						$strMN_NAME_JP	= $_POST["mn_name_jp_".$intMN_NO]			? $_POST["mn_name_jp_".$intMN_NO]			: $_REQUEST["mn_name_jp_".$intMN_NO];
						$strMN_NAME_ID	= $_POST["mn_name_id_".$intMN_NO]			? $_POST["mn_name_id_".$intMN_NO]			: $_REQUEST["mn_name_id_".$intMN_NO];
						$strMN_NAME_FR	= $_POST["mn_name_fr_".$intMN_NO]			? $_POST["mn_name_fr_".$intMN_NO]			: $_REQUEST["mn_name_fr_".$intMN_NO];
												
						$strMN_AUTH_L	= $_POST["mn_auth_l_".$intMN_NO]			? $_POST["mn_auth_l_".$intMN_NO]			: $_REQUEST["mn_auth_l_".$intMN_NO];
						$strMN_AUTH_W	= $_POST["mn_auth_w_".$intMN_NO]			? $_POST["mn_auth_w_".$intMN_NO]			: $_REQUEST["mn_auth_w_".$intMN_NO];
						$strMN_AUTH_M	= $_POST["mn_auth_m_".$intMN_NO]			? $_POST["mn_auth_m_".$intMN_NO]			: $_REQUEST["mn_auth_m_".$intMN_NO];
						$strMN_AUTH_D	= $_POST["mn_auth_d_".$intMN_NO]			? $_POST["mn_auth_d_".$intMN_NO]			: $_REQUEST["mn_auth_d_".$intMN_NO];
						$strMN_AUTH_E	= $_POST["mn_auth_e_".$intMN_NO]			? $_POST["mn_auth_e_".$intMN_NO]			: $_REQUEST["mn_auth_e_".$intMN_NO];
						
						$strMN_AUTH_C	= $_POST["mn_auth_c_".$intMN_NO]			? $_POST["mn_auth_c_".$intMN_NO]			: $_REQUEST["mn_auth_c_".$intMN_NO];
						$strMN_AUTH_S	= $_POST["mn_auth_s_".$intMN_NO]			? $_POST["mn_auth_s_".$intMN_NO]			: $_REQUEST["mn_auth_s_".$intMN_NO];
						
						$strMN_AUTH_P	= $_POST["mn_auth_p_".$intMN_NO]			? $_POST["mn_auth_p_".$intMN_NO]			: $_REQUEST["mn_auth_p_".$intMN_NO];
						$strMN_AUTH_U	= $_POST["mn_auth_u_".$intMN_NO]			? $_POST["mn_auth_u_".$intMN_NO]			: $_REQUEST["mn_auth_u_".$intMN_NO];
						
						$strMN_AUTH_E1	= $_POST["mn_auth_e1_".$intMN_NO]			? $_POST["mn_auth_e1_".$intMN_NO]			: $_REQUEST["mn_auth_e1_".$intMN_NO];

						$strMN_AUTH_E2	= $_POST["mn_auth_e2_".$intMN_NO]			? $_POST["mn_auth_e2_".$intMN_NO]			: $_REQUEST["mn_auth_e2_".$intMN_NO];

						$strMN_AUTH_E3	= $_POST["mn_auth_e3_".$intMN_NO]			? $_POST["mn_auth_e3_".$intMN_NO]			: $_REQUEST["mn_auth_e3_".$intMN_NO];

						$strMN_AUTH_E4	= $_POST["mn_auth_e4_".$intMN_NO]			? $_POST["mn_auth_e4_".$intMN_NO]			: $_REQUEST["mn_auth_e4_".$intMN_NO];

						$strMN_AUTH_E5	= $_POST["mn_auth_e5_".$intMN_NO]			? $_POST["mn_auth_e5_".$intMN_NO]			: $_REQUEST["mn_auth_e5_".$intMN_NO];
						
						$strMN_URL		= $_POST["mn_url_".$intMN_NO]				? $_POST["mn_url_".$intMN_NO]				: $_REQUEST["mn_url_".$intMN_NO];
			
						$intMN_ORDER	= $_POST["mn_order_".$intMN_NO]				? $_POST["mn_order_".$intMN_NO]				: $_REQUEST["mn_order_".$intMN_NO];
						
						if (!$strMN_AUTH_L) $strMN_AUTH_L = "N";
						if (!$strMN_AUTH_W) $strMN_AUTH_W = "N";
						if (!$strMN_AUTH_M) $strMN_AUTH_M = "N";
						if (!$strMN_AUTH_D) $strMN_AUTH_D = "N";
						if (!$strMN_AUTH_E) $strMN_AUTH_E = "N";
						if (!$strMN_AUTH_C) $strMN_AUTH_C = "N";
						if (!$strMN_AUTH_S) $strMN_AUTH_S = "N";
						if (!$strMN_AUTH_P) $strMN_AUTH_P = "N";
						if (!$strMN_AUTH_U) $strMN_AUTH_U = "N";						
						if (!$strMN_AUTH_E1) $strMN_AUTH_E1 = "N";
						if (!$strMN_AUTH_E2) $strMN_AUTH_E2 = "N";
						if (!$strMN_AUTH_E3) $strMN_AUTH_E3 = "N";
						if (!$strMN_AUTH_E4) $strMN_AUTH_E4 = "N";
						if (!$strMN_AUTH_E5) $strMN_AUTH_E5 = "N";

						$menuMgr->setMN_NO($intMN_NO);
						$menuMgr->setMN_NAME_KR($strMN_NAME_KR);
						$menuMgr->setMN_NAME_US($strMN_NAME_US);
						$menuMgr->setMN_NAME_CN($strMN_NAME_CN);
						$menuMgr->setMN_NAME_JP($strMN_NAME_JP);
						$menuMgr->setMN_NAME_ID($strMN_NAME_ID);
						$menuMgr->setMN_NAME_FR($strMN_NAME_FR);

						$menuMgr->setMN_AUTH_L($strMN_AUTH_L);
						$menuMgr->setMN_AUTH_W($strMN_AUTH_W);
						$menuMgr->setMN_AUTH_M($strMN_AUTH_M);
						$menuMgr->setMN_AUTH_D($strMN_AUTH_D);
						$menuMgr->setMN_AUTH_E($strMN_AUTH_E);
						$menuMgr->setMN_AUTH_C($strMN_AUTH_C);
						$menuMgr->setMN_AUTH_S($strMN_AUTH_S);
						$menuMgr->setMN_AUTH_U($strMN_AUTH_U);
						$menuMgr->setMN_AUTH_P($strMN_AUTH_P);
						$menuMgr->setMN_AUTH_E1($strMN_AUTH_E1);
						$menuMgr->setMN_AUTH_E2($strMN_AUTH_E2);
						$menuMgr->setMN_AUTH_E3($strMN_AUTH_E3);
						$menuMgr->setMN_AUTH_E4($strMN_AUTH_E4);
						$menuMgr->setMN_AUTH_E5($strMN_AUTH_E5);
						$menuMgr->setMN_URL($strMN_URL);
						$menuMgr->setMN_USE("Y");
						$menuMgr->setMN_ORDER($intMN_ORDER);

						$menuMgr->getUpdate($db);

						
					}
				}
			}
			
			
			$strMsg = "저장되었습니다.";
			$strUrl = $linkPage;
		break;

		case "highMenu":
			$aryMenuList = $menuMgr->getListAry02($db);
			
			$strHtml = "";
			if (is_array($aryMenuList)){
				
				$strHtml .= "<select name='mn_high_02' id='mn_high_02'>";
				while(list($key,$val) = each($aryMenuList)){
					$strHtml .= "<option value=\"".$key."\">".$val."</option>";
				}

				$strHtml .= "</select>";
			}
			
			$db->disConnect();
			echo $strHtml;

			exit;
		break;

		case "modify2":
			if(is_Array($aryChkMenuNo)){
				for($i=0;$i<=count($aryChkMenuNo);$i++){
					
					if($aryChkMenuNo[$i] > 0){
																
						$intMN_NO		= $aryChkMenuNo[$i];
						
						$strMN_NAME_US	= $_POST["mn_name_us_".$intMN_NO]			? $_POST["mn_name_us_".$intMN_NO]			: $_REQUEST["mn_name_us_".$intMN_NO];
						$strMN_NAME_CN	= $_POST["mn_name_cn_".$intMN_NO]			? $_POST["mn_name_cn_".$intMN_NO]			: $_REQUEST["mn_name_cn_".$intMN_NO];
						$strMN_NAME_JP	= $_POST["mn_name_jp_".$intMN_NO]			? $_POST["mn_name_jp_".$intMN_NO]			: $_REQUEST["mn_name_jp_".$intMN_NO];
						$strMN_NAME_ID	= $_POST["mn_name_id_".$intMN_NO]			? $_POST["mn_name_id_".$intMN_NO]			: $_REQUEST["mn_name_id_".$intMN_NO];
						$strMN_NAME_FR	= $_POST["mn_name_fr_".$intMN_NO]			? $_POST["mn_name_fr_".$intMN_NO]			: $_REQUEST["mn_name_fr_".$intMN_NO];
												
						$menuMgr->setMN_NO($intMN_NO);
						$menuMgr->setMN_NAME_KR($strMN_NAME_KR);
						$menuMgr->setMN_NAME_US($strMN_NAME_US);
						$menuMgr->setMN_NAME_CN($strMN_NAME_CN);
						$menuMgr->setMN_NAME_JP($strMN_NAME_JP);
						$menuMgr->setMN_NAME_ID($strMN_NAME_ID);
						$menuMgr->setMN_NAME_FR($strMN_NAME_FR);
						$menuMgr->getUpdate2($db);
					}
				}
			}
			$strMsg = "저장되었습니다.";
			$strUrl = "./?menuType=menu&mode=list2";

		break;
	}

	$db->disConnect();

	if ($strUrl) {
		goUrl($strMsg,$strUrl);
	} else {
		exit;
	}
?>