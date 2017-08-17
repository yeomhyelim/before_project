<?
	
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$cateMgr = new CateMgr();	

	require_once "basic.param.inc.php";
	
	/*##################################### Parameter 셋팅 #####################################*/
	$strJ_CERITY			= $_POST["cerity"]			? $_POST["cerity"]			: $_REQUEST["cerity"];
	$intJ_RE_DAY			= $_POST["re_day"]			? $_POST["re_day"]			: $_REQUEST["re_day"];
	$strJ_NO_ID				= $_POST["no_id"]			? $_POST["no_id"]			: $_REQUEST["no_id"];
	$intJ_POINT				= $_POST["point"]			? $_POST["point"]			: $_REQUEST["point"];
	$strJ_COUPON			= $_POST["coupon"]			? $_POST["coupon"]			: $_REQUEST["coupon"];
	$strJ_GROUP				= $_POST["joinGroup"]		? $_POST["joinGroup"]		: $_REQUEST["joinGroup"];
	$intJ_REC_POINT1		= $_POST["rec_point1"]		? $_POST["rec_point1"]		: $_REQUEST["rec_point1"];
	$intJ_REC_POINT2		= $_POST["rec_point2"]		? $_POST["rec_point2"]		: $_REQUEST["rec_point2"];
	$strJ_JUMIN				= $_POST["jumin"]			? $_POST["jumin"]			: $_REQUEST["jumin"];
	$strJ_IPIN				= $_POST["ipin"]			? $_POST["ipin"]			: $_REQUEST["ipin"];
	$strJ_GROUP_VIEW		= $_POST["group_view"]		? $_POST["group_view"]		: $_REQUEST["group_view"];
	$strJ_PHONE				= $_POST["phone"]			? $_POST["phone"]			: $_REQUEST["phone"];
	

	/*##################################### Parameter 셋팅 #####################################*/

	$strJ_CERITY			= strTrim($strJ_CERITY,1);
	$strJ_NO_ID				= strTrim($strJ_NO_ID,"","N");
	$strJ_COUPON			= strTrim($strJ_COUPON,1);
	$strJ_GROUP				= strTrim($strJ_GROUP,3);
	$strJ_JUMIN				= strTrim($strJ_JUMIN,1);
	$strJ_IPIN				= strTrim($strJ_IPIN,1);
	$strJ_GROUP_VIEW		= strTrim($strJ_GROUP_VIEW,1);
	$strJ_PHONE				= strTrim($strJ_PHONE,1);

	if (!$intJ_RE_DAY) $intJ_RE_DAY = 0;
	if (!$intJ_REC_POINT1) $intJ_REC_POINT1 = 0;
	if (!$intJ_REC_POINT2) $intJ_REC_POINT2 = 0;
	if (!$intJ_POINT) $intJ_POINT = 0;

	$memberMgr->setJ_CERITY($strJ_CERITY);
	$memberMgr->setJ_RE_DAY($intJ_RE_DAY);
	$memberMgr->setJ_NO_ID($strJ_NO_ID);
	$memberMgr->setJ_POINT($intJ_POINT);
	$memberMgr->setJ_COUPON($strJ_COUPON);
	$memberMgr->setJ_GROUP($strJ_GROUP);
	$memberMgr->setJ_REC_POINT1($intJ_REC_POINT1);
	$memberMgr->setJ_REC_POINT2($intJ_REC_POINT2);
	$memberMgr->setJ_JUMIN($strJ_JUMIN);
	$memberMgr->setJ_IPIN($strJ_IPIN);
	$memberMgr->setJ_GROUP_VIEW($strJ_GROUP_VIEW);
	$memberMgr->setJ_PHONE($strJ_PHONE);
	$memberMgr->setJ_MOD_NO($a_admin_no);
			
	switch ($strAct) {
		case "settingModify":
			
			$memberMgr->getSettingUpdate($db);
			
			$strUrl = "./?menuType=".$strMenuType."&mode=setting".$strLinkPage;
		break;

		case "joinItemSave":
			/* 회원그룹 */
			$aryMemberGroup = $memberMgr->getGroupList($db);
			
			/* 사용중인 나라 */
			$aryUseLng = explode("/",$S_USE_LNG);

			$aryItemList = $memberMgr->getJoinItemList($db);
			
			/* 사용자항목 저장 */
			if (is_array($aryItemList)){
				for($k=0;$k<sizeof($aryItemList);$k++){
					$intNo = $aryItemList[$k][JI_NO];
					
					$strJI_NES		= $_POST["item_nes_".$intNo]			? $_POST["item_nes_".$intNo]			: $_REQUEST["item_nes_".$intNo];
					$strJI_TYPE		= $_POST["item_type_".$intNo]			? $_POST["item_type_".$intNo]			: $_REQUEST["item_type_".$intNo];
					$strJI_TYPE_VAL = $_POST["item_type_val_".$intNo]		? $_POST["item_type_val_".$intNo]		: $_REQUEST["item_type_val_".$intNo];
					$strJI_JOIN		= $_POST["item_join_".$intNo]			? $_POST["item_join_".$intNo]			: $_REQUEST["item_join_".$intNo];
					$strJI_MYPAGE	= $_POST["item_mypage_".$intNo]			? $_POST["item_mypage_".$intNo]			: $_REQUEST["item_mypage_".$intNo];
					$aryJI_GRADE	= $_POST["item_grade_".$intNo]			? $_POST["item_grade_".$intNo]			: $_REQUEST["item_grade_".$intNo];
					$strJI_USE		= $_POST["item_use_".$intNo]			? $_POST["item_use_".$intNo]			: $_REQUEST["item_use_".$intNo];
					$intJI_ORDER	= $_POST["item_order_".$intNo]			? $_POST["item_order_".$intNo]			: $_REQUEST["item_order_".$intNo];

					if ($aryItemList[$k][JI_USE] == "A"){
						$strJI_NES		= "Y";
						$strJI_TYPE		= $aryItemList[$k][JI_TYPE];
						$strJI_TYPE_VAL	= $aryItemList[$k][JI_TYPE_VAL];
						$strJI_JOIN		= $aryItemList[$k][JI_JOIN];
						$strJI_MYPAGE	= $aryItemList[$k][JI_MYPAGE];
						$strJI_USE		= $aryItemList[$k][JI_USE];
						$intJI_ORDER	= $aryItemList[$k][JI_ORDER];
						$strJI_GRADE	= "";
					} else {

						if (!$strJI_NES) $strJI_NES = "N";
						if (!$strJI_TYPE) $strJI_TYPE = $aryItemList[$k][JI_TYPE];
						if (!$strJI_TYPE_VAL) $strJI_TYPE_VAL = $aryItemList[$k][JI_TYPE_VAL];
						if (!$strJI_JOIN) $strJI_JOIN = "N";
						if (!$strJI_MYPAGE) $strJI_MYPAGE = "N";
						if (!$strJI_USE) $strJI_USE = "N";
						if (!$intJI_ORDER) $intJI_ORDER	= $aryItemList[$k][JI_ORDER];

						$strJI_GRADE	= "";
						if (is_array($aryJI_GRADE)){
							for($i=0;$i<sizeof($aryJI_GRADE);$i++){
								$strJI_GRADE .= $aryJI_GRADE[$i]."/";
							}

							if ($strJI_GRADE){
								$strJI_GRADE = SUBSTR($strJI_GRADE,0,STRLEN($strJI_GRADE)-1);
							}
						}
					}
					

					if ($aryItemList[$k][JI_GB] == "T"){
						for($j=0;$j<sizeof($aryUseLng);$j++){
							$strJI_NAME		= "item_name_".$aryUseLng[$j]."_".$intNo;
							${"strJI_NAME_".$aryUseLng[$j]}	= $_POST[$strJI_NAME] ? $_POST[$strJI_NAME] : $_REQUEST[$strJI_NAME];
						}
					}
					
					$memberMgr->setJI_NO($intNo);
					$memberMgr->setJI_NES($strJI_NES);
					$memberMgr->setJI_TYPE($strJI_TYPE);
					$memberMgr->setJI_TYPE_VAL($strJI_TYPE_VAL);
					$memberMgr->setJI_JOIN($strJI_JOIN);
					$memberMgr->setJI_MYPAGE($strJI_MYPAGE);
					$memberMgr->setJI_GRADE($strJI_GRADE);
					$memberMgr->setJI_USE($strJI_USE);
					$memberMgr->setJI_ORDER($intJI_ORDER);
					$memberMgr->setJI_MOD_NO($a_admin_no);
					$memberMgr->setJI_NAME_KR($strJI_NAME_KR);
					$memberMgr->setJI_NAME_US($strJI_NAME_US);
					$memberMgr->setJI_NAME_CN($strJI_NAME_CN);
					$memberMgr->setJI_NAME_JP($strJI_NAME_JP);
					$memberMgr->setJI_NAME_ID($strJI_NAME_ID);
					$memberMgr->setJI_NAME_FR($strJI_NAME_FR);
					$memberMgr->getJoinItemUpdate($db);
						
					/* 언어별 UPDATE */
					$joinItemLngUpdate = "";
					if ($aryItemList[$k][JI_GB] == "T"){
						for($j=0;$j<sizeof($aryUseLng);$j++){
							$strJoinItemUpdateLng = $aryUseLng[$j];
							$joinItemLngUpdate .= ",JI_NAME_".$strJoinItemUpdateLng." = '".${"strJI_NAME_".$strJoinItemUpdateLng}."'";
						}
					
						if ($joinItemLngUpdate){
							$joinItemLngUpdate				= substr($joinItemLngUpdate,1);
							$joinItemUpdateParam			= "";
							$joinItemUpdateParam['COLUMN']	= $joinItemLngUpdate;
							$joinItemUpdateParam['JI_NO']	= $intNo;
							$memberMgr->getJoinItemLngUpdate($db,$joinItemUpdateParam);
							
						}
					}
					
				}
			}
			include MALL_HOME."/web/shopAdmin/member/memberJoin/memberMakeFile.php";

			$strUrl = "./?menuType=".$strMenuType."&mode=joinItem";

		break;

	}

?>
