<?
#/*====================================================================*/# 
#|화일명	: 관리자 메뉴 권한 설정										|# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-03-10												|# 
#|작성내용	: 관리자 메뉴 권한 설정										|# 
#/*====================================================================*/# 


	$intMN_NO		= $_POST["mn_no"]			? $_POST["mn_no"]			: $_REQUEST["mn_no"];
	$intMN_LEVEL	= $_POST["mn_level"]		? $_POST["mn_level"]		: $_REQUEST["mn_level"];

	$result_array = array();
		
	
	$adminMenu->setM_NO($intM_NO);
	$menuMgr->setMN_NO($intMN_NO);
	$adminMgr->setM_NO($intM_NO);

	switch ($strAct) {
		case "idChk":

			$row = $adminMgr->getIdChk($db);
			
			if ($row) {
				$aryResult[0][RET] = "N";
				
				if ($row[A_STATUS] == 1) $aryResult[0][MSG] = $LNG_TRANS_CHAR["BS00010"]; //"이미 등록된 관리자 아이디입니다.";
				else $aryResult[0][MSG] = $LNG_TRANS_CHAR["BS00044"]; //"삭제된 관리자 아이디입니다.[삭제관리자]메뉴에서 복원하셔야 합니다.";
			} else {
				$aryResult[0][RET] = "Y";
				$aryResult[0][MSG] = "";
			}
		break;

		case "authChk":
			if ($intMN_NO >= 5000 || $intMN_NO == 6) {
				
				if ($intMN_LEVEL == 1) {
					$strHighCode1 = "006";
				
					$aryMenuList = $adminMenu->getCommunityList($db);

					$intCnt = 0;
					if (is_array($aryMenuList)){
						for($i=0;$i<sizeof($aryMenuList);$i++){
							if ($aryMenuList[$i]['MN_LEVEL'] >= $intMN_LEVEL){
								if ($aryMenuList[$i]['MN_LEVEL'] == 2) {
									$intMN_NO		= 6000 + $aryMenuList[$i][MN_NO];
								} else if ($aryMenuList[$i]['MN_LEVEL'] == 3) {
									if ($aryMenuList[$i]['MN_HIGH_02'] == "001") $intMN_NO = 5900 + (int)$aryMenuList[$i][MN_NO];
									else $intMN_NO = 5000 + (int)$aryMenuList[$i][MN_NO];
								}

								$aryResult[$intCnt][MN_NO] = intval($intMN_NO);
								$intCnt++;
							}
						}
					}

					$aryMenuList = $adminMenu->getCommunityAdmList($db);

					if (is_array($aryMenuList)){
						for($i=0;$i<sizeof($aryMenuList);$i++){
							if ($aryMenuList[$i]['MN_LEVEL'] >= $intMN_LEVEL){
								if ($aryMenuList[$i]['MN_LEVEL'] == 2) {
									$intMN_NO		= 6000 + $aryMenuList[$i][MN_NO];
								} else if ($aryMenuList[$i]['MN_LEVEL'] == 3) {
									if ($aryMenuList[$i]['MN_HIGH_02'] == "001") $intMN_NO = 5900 + (int)$aryMenuList[$i][MN_NO];
									else $intMN_NO = 5000 + (int)$aryMenuList[$i][MN_NO];
								}

								$aryResult[$intCnt][MN_NO] = intval($intMN_NO);
								$intCnt++;
							}
						}
					}

					$aryResult[0][CNT] = $intCnt;

				
				} else {
					
					$strHighCode1 = "006";
					
					if ($intMN_LEVEL == 2) $strHighCode2  = SUBSTR($intMN_NO,1);
					
					if (($intMN_NO >= 5901 && $intMN_NO < 6000) || $strHighCode2 == "001") {
						$strHighCode2 = "001";
						$aryMenuList = $adminMenu->getCommunityAdmList($db);
					
					} else if (($intMN_NO >= 5000 && $intMN_NO < 5900) || $strHighCode2 == "002") {
						$strHighCode2	= "002";
						$aryMenuList = $adminMenu->getCommunityList($db);
					} 
					
					if ($intMN_LEVEL != 3){
					
						$intCnt = 0;
						if (is_array($aryMenuList)){
							for($i=0;$i<sizeof($aryMenuList);$i++){
								if ($aryMenuList[$i]['MN_LEVEL'] >= $intMN_LEVEL){
									if ($aryMenuList[$i]['MN_LEVEL'] == 2) {
										$intMN_NO		= 6000 + $aryMenuList[$i][MN_NO];
									} else if ($aryMenuList[$i]['MN_LEVEL'] == 3) {
										if ($aryMenuList[$i]['MN_HIGH_02'] == "001") $intMN_NO = 5900 + (int)$aryMenuList[$i][MN_NO];
										else $intMN_NO = 5000 + (int)$aryMenuList[$i][MN_NO];
									}

									$aryResult[$intCnt][MN_NO] = intval($intMN_NO);
									$intCnt++;
								}
							}
							$aryResult[0][CNT] = $intCnt;
						}
					}
				}
				
			} else {
				$xml_string = file_get_contents("http://www.eumshop.com/api/xml/shop.lang.menu.view.xml.php?no=".$intMN_NO);
				$row = simplexml_load_string($xml_string);

				if ($intMN_LEVEL == 1) {
					$strHighCode1 = $row->ITEM[0]->MN_CODE;
				} else {
					
					$strHighCode1 = $row->ITEM[0]->MN_HIGH_01;
					$strHighCode2 = $row->ITEM[0]->MN_CODE;
				}
				
				$xml_string = file_get_contents("http://www.eumshop.com/api/xml/shop.lang.menu.json.xml.php?code1=".$strHighCode1."&code2=".$strHighCode2."&level=".$intMN_LEVEL);
				$xml = simplexml_load_string($xml_string);
				
				for ($i=0;$i<sizeof($xml->ITEM);$i++){
					$intMN_NO = $xml->ITEM[$i]->MN_NO;
					$aryResult[$i][MN_NO] = intval($intMN_NO);
				}
				
				$aryResult[0][CNT] = $i;
			}

		break;

		case "changeUseLng":
			
			$strUserSiteUseLng	= $_REQUEST["siteUserUseLng"];
			
			$arrTopSiteUseLng	= explode("/",$S_USE_LNG); 
			
			$aryResult['__STATE__']= "FAIL";
			if (in_array($strUserSiteUseLng,$arrTopSiteUseLng)){
				$aryResult['__STATE__']	= "SUCCESS";
				$_SESSION["ADMIN_LNG"]	= $strUserSiteUseLng;
			}
			
		break;
	}
	$db->disConnect();

	$result_array = json_encode($aryResult);
	echo $result_array;
?>