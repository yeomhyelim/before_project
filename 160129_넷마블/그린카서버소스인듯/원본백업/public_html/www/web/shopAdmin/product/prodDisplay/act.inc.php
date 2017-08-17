<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."DesignSetMgr.php";

	require_once "../conf/site_skin_product.conf.inc.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		
	$siteMgr = new SiteMgr();		
	$memberMgr = new MemberMgr();
	$designSetMgr = new DesignSetMgr();	

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	/*##################################### Parameter 셋팅 #####################################*/

	$strLinkPage = "";

	switch ($strAct) {
		
		case "prodDisplaySave":
			// 상품 진열장 저장.
			// SELECT * FROM ICON_MGR WHERE IC_TYPE = 'MAIN' ORDER BY IC_NO ASC

			$cateMgr->setIC_REG_NO($a_admin_no);

			$cateMgr->setIC_TYPE("MAIN");
			$aryProdMainList = $cateMgr->getProdDisplayList($db);

			for($i=0;$i<sizeof($aryProdMainList);$i++){
				$intNo = $aryProdMainList[$i][IC_NO];
				$strDisplayName	= $_POST["displayName_".$intNo]		? $_POST["displayName_".$intNo]		: $_REQUEST["displayName_".$intNo];
				$strDisplayUse	= $_POST["displayUseYN_".$intNo]	? $_POST["displayUseYN_".$intNo]	: $_REQUEST["displayUseYN_".$intNo];
				
				$cateMgr->setIC_NO($intNo);
				$cateMgr->setIC_NAME($strDisplayName);
				$cateMgr->setIC_USE($strDisplayUse);
				$cateMgr->getProdDisplayUpdate($db);
			}
			
			
			$cateMgr->setIC_TYPE("SUB");
			$aryProdSubList = $cateMgr->getProdDisplayList($db);

			for($i=0;$i<sizeof($aryProdSubList);$i++){
				$intNo = $aryProdSubList[$i][IC_NO];
				$strDisplayName	= $_POST["displayName_".$intNo]		? $_POST["displayName_".$intNo]		: $_REQUEST["displayName_".$intNo];
				$strDisplayUse	= $_POST["displayUseYN_".$intNo]	? $_POST["displayUseYN_".$intNo]	: $_REQUEST["displayUseYN_".$intNo];

				$cateMgr->setIC_NO($intNo);
				$cateMgr->setIC_NAME($strDisplayName);
				$cateMgr->setIC_USE($strDisplayUse);
				$cateMgr->getProdDisplayUpdate($db);
			}


			/* Icon */
			$aryProdIconName	= $_POST["iconName"]			? $_POST["iconName"]			: $_REQUEST["iconName"];
			$aryProdIconNo		= $_POST["iconNo"]				? $_POST["iconNo"]				: $_REQUEST["iconNo"];
			
			for($i=0;$i<sizeof($aryProdIconName);$i++){
				$intNo = $aryProdIconNo[$i];
				$cateMgr->setIC_IMG("");

				if ($_FILES["iconFile"][name][$i]){
					if (!getAllowImgFileExt($_FILES["iconFile"][name][$i])){

						goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
						exit;
					}
					
					$strFileName	= $_FILES["iconFile"][name][$i];
					$strFileTmpName = $_FILES["iconFile"][tmp_name][$i];
					$intFileSize	= $_FILES["iconFile"][size][$i];
					$strFileType	= $_FILES["iconFile"][type][$i];
					
					$strNewFileName = "icon_".($i+1);
					$fres = $fh->doUpload($strNewFileName,"../upload/icon",$strFileName,$strFileTmpName,$intFileSize,$strFileType);

					if($fres) {
						$cateMgr->setIC_IMG("/upload/icon/".$fres[file_real_name]);
					}
				}

				if ($cateMgr->getIC_IMG()){
					if ($intNo > 0){
						
						$cateMgr->setIC_NO($intNo);
						$cateMgr->setIC_USE("Y");
						$cateMgr->getProdIconUpdate($db);
						
					} else {
					
						$cateMgr->setIC_TYPE("ICON");
						$cateMgr->setIC_CODE(($i+1));
						$cateMgr->setIC_NAME("사용자정의");
						$cateMgr->setIC_USE("Y");
						$cateMgr->getProdIconInsert($db);			
					}
				}
			}
			

			$strMsg = $LNG_TRANS_CHAR["CS00003"]; //변경하신 정보가 저장되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=prodDisplay&".$strLinkPage;


			//exit;

		break;

		case "prodIconDel":
			$intNO		= $_POST["prodIconNo"]		? $_POST["prodIconNo"]		: $_REQUEST["prodIconNo"];

			$cateMgr->setIC_NO($intNO);
			$row = $cateMgr->getProdIconView($db);

			if ($row){
				
				$fh->fileDelete("..".$row[IC_IMG]);
				$cateMgr->getProdIconDelete($db);
			}


			$strMsg = $LNG_TRANS_CHAR["CS00005"]; //선택하신 아이콘이 삭제되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=prodDisplay&".$strLinkPage;

		break;

		case "prodIconRecovery":
		
			$intNO		= $_POST["prodIconNo"]		? $_POST["prodIconNo"]		: $_REQUEST["prodIconNo"];
			$cateMgr->setIC_NO($intNO);
			$row = $cateMgr->getProdIconView($db);

			$aryOrgIconList[1] = "/himg/icon/prod_icon_new.gif";
			$aryOrgIconList[2] = "/himg/icon/prod_icon_best.gif";
			$aryOrgIconList[3] = "/himg/icon/prod_icon_popul.gif";
			$aryOrgIconList[4] = "/himg/icon/prod_icon_rec.gif";
			$aryOrgIconList[5] = "/himg/icon/prod_icon_event.gif";
			$aryOrgIconList[6] = "/himg/icon/prod_icon_sale.gif";
			$aryOrgIconList[7] = "/himg/icon/prod_icon_plan.gif";


			$cateMgr->setIC_IMG($aryOrgIconList[$row[IC_CODE]]);
			$cateMgr->setIC_USE("Y");
			$cateMgr->getProdIconUpdate($db);
			
			$strMsg = $LNG_TRANS_CHAR["CS00006"]; //선택하신 아이콘이 복원되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=prodDisplay&".$strLinkPage;


		break;
	}

	/* 상품 리스트 아이콘 파일 생성 */
	if ($strAct == "prodDisplaySave" || $strAct == "prodIconDel" || $strAct == "prodIconRecovery"){
		include MALL_HOME."/web/shopAdmin/product/prodDisplay/prodListIconMakeFile.php";
	}
	/* 상품 리스트 아이콘 파일 생성 */
	
?>