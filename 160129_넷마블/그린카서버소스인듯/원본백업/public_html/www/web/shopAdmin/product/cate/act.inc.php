<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	require_once MALL_CONF_LIB."ProductPlanMgr.php";

	require_once "../conf/site_skin_product.conf.inc.php";

	$cateMgr = new CateMgr();
	$productMgr = new ProductAdmMgr();
	$siteMgr = new SiteMgr();
	$memberMgr = new MemberMgr();
	$designSetMgr = new DesignSetMgr();
	$planMgr = new ProductPlanMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	$strCATE_CODE	= $_POST["cateCode"]		? $_POST["cateCode"]		: $_REQUEST["cateCode"];
	$strC_HCODE1	= $_POST["cateHCode1"]		? $_POST["cateHCode1"]		: $_REQUEST["cateHCode1"];
	$strC_HCODE2	= $_POST["cateHCode2"]		? $_POST["cateHCode2"]		: $_REQUEST["cateHCode2"];
	$strC_HCODE3	= $_POST["cateHCode3"]		? $_POST["cateHCode3"]		: $_REQUEST["cateHCode3"];
	$strC_HCODE4	= $_POST["cateHCode4"]		? $_POST["cateHCode4"]		: $_REQUEST["cateHCode4"];

	$strC_NAME		= $_POST["cateName"]		? $_POST["cateName"]		: $_REQUEST["cateName"];
	$strC_LOW_YN	= $_POST["catelow_yn"]		? $_POST["catelow_yn"]		: $_REQUEST["catelow_yn"];
	$strC_GROUP		= $_POST["cateGroup"]		? $_POST["cateGroup"]		: $_REQUEST["cateGroup"];
	$intC_ORDER		= $_POST["cateOrder"]		? $_POST["cateOrder"]		: $_REQUEST["cateOrder"];
	$strC_VIEW_YN	= $_POST["cateView"]		? $_POST["cateView"]		: $_REQUEST["cateView"];
	$strC_SHARE		= $_POST["cateShare"]		? $_POST["cateShare"]		: $_REQUEST["cateShare"];

	$strC_TYPE		= $_POST["cateType"]		? $_POST["cateType"]		: $_REQUEST["cateType"];
	/*##################################### Parameter 셋팅 #####################################*/

	$strC_CODE		= strTrim($strC_CODE,20);
	$strC_NAME		= strTrim($strC_NAME,100);
	$strC_LOW_YN	= strTrim($strC_LOW_YN,1);
	$strC_HCODE		= strTrim($strC_HCODE,20);
	$strC_GROUP		= strTrim($strC_GROUP,3);
	$strC_VIEW_YN	= strTrim($strC_VIEW_YN,1);
	$strC_SHARE		= strTrim($strC_SHARE,1);
	$strC_TYPE		= strTrim($strC_TYPE,1);

	if (!$strC_SHARE) $strC_SHARE = "N";

	if (!$strC_HCODE1){
		$intC_LEVEL	= 1;
	}

	if ($strC_HCODE1 && !$strC_HCODE2){
		$intC_LEVEL	= 2;
		$strC_HCODE	= $strC_HCODE1;
	}

	if ($strC_HCODE1 && $strC_HCODE2 && !$strC_HCODE3){
		$intC_LEVEL	= 3;
		$strC_HCODE	= $strC_HCODE1.$strC_HCODE2;
	}

	if ($strC_HCODE1 && $strC_HCODE2 && $strC_HCODE3){
		$intC_LEVEL	= 4;
		$strC_HCODE	= $strC_HCODE1.$strC_HCODE2.$strC_HCODE3;
	}

// 2013.06.11 카테고리 수정을 할 때, 숨김 처리를 하고 싶어 view 부분을 체크 하지 않으면 자동으로 Y로 등록이 되무로 주석 처리 함.
//	$strC_VIEW_YN	= IM_IsBlank($strC_VIEW_YN,"Y");
	$intC_ORDER		= IM_IsBlank($intC_ORDER,"0");

	$cateMgr->setC_CODE($strC_CODE);
	$cateMgr->setCL_NAME($strC_NAME);
	$cateMgr->setC_LEVEL($intC_LEVEL);
	$cateMgr->setC_LOW_YN($strC_LOW_YN);
	$cateMgr->setC_HCODE($strC_HCODE);
	$cateMgr->setC_GROUP($strC_GROUP);
	$cateMgr->setC_ORDER($intC_ORDER);
	$cateMgr->setC_VIEW_YN($strC_VIEW_YN);
	$cateMgr->setC_SHARE($strC_SHARE);
	$cateMgr->setC_TYPE($strC_TYPE);
	$cateMgr->setC_REG_DT($S_NOW_TIME_FORMAT2);
	$cateMgr->setC_REG_NO($a_admin_no);
	$cateMgr->setC_MOD_DT($S_NOW_TIME_FORMAT2);
	$cateMgr->setC_MOD_NO($a_admin_no);

	$strLinkPage = "";


	switch ($strAct) {
		case "cateWrite":

			$strC_CODE = $cateMgr->getCateCode($db);
			$cateMgr->setC_CODE($strC_CODE);

			$strCateImgPath = "upload/category";
			$cateImgMakeFolderResult = getLangMakeFolder("category");

			if ($cateImgMakeFolderResult){
				for($i=1;$i<=2;$i++){

					if ($_FILES["cateImg".$i][name]){

						if (!getAllowImgFileExt($_FILES["cateImg".$i][name])){
							goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
							exit;
						}

						$strFileName	= $_FILES["cateImg".$i][name];
						$strFileTmpName = $_FILES["cateImg".$i][tmp_name];
						$intFileSize	= $_FILES["cateImg".$i][size];
						$strFileType	= $_FILES["cateImg".$i][type];

						$fres = $fh->doUpload($strC_CODE."_".$i,"../".$strCateImgPath."/".strtolower($S_ST_LNG),$strFileName,$strFileTmpName,$intFileSize,$strFileType);

						if($fres) {
							if ($i == 1){
								$cateMgr->setCL_IMG1($fres[file_real_name]);
							} else if ($i == 2){
								$cateMgr->setCL_IMG2($fres[file_real_name]);
							}
						}
					}
				}
			}

			$cateMgr->setCL_LNG($S_ST_LNG);
			$cateMgr->getInsert($db);

			/* 기준언어가 아닌 언어일때 기준언어 이미지 INSERT */
			if (is_array($S_ARY_USE_COUNTRY)){
				while(list($key,$val) = each($S_ARY_USE_COUNTRY)){
					if ($key != $S_ST_LNG){
						$cateMgr->setCL_LNG($key);

						if ($cateMgr->getCL_IMG1()){
							$strCopyOrgPath1 = $S_DOCUMENT_ROOT.$S_SHOP_HOME."/".$strCateImgPath."/".strtolower($S_ST_LNG)."/".$cateMgr->getCL_IMG1();
							$strCopyNewPath1 = $S_DOCUMENT_ROOT.$S_SHOP_HOME."/".$strCateImgPath."/".strtolower($key)."/".$cateMgr->getCL_IMG1();
							copy($strCopyOrgPath1,$strCopyNewPath1);
						}

						if ($cateMgr->getCL_IMG2()){
							$strCopyOrgPath2 = $S_DOCUMENT_ROOT.$S_SHOP_HOME."/".$strCateImgPath."/".strtolower($S_ST_LNG)."/".$cateMgr->getCL_IMG2();
							$strCopyNewPath2 = $S_DOCUMENT_ROOT.$S_SHOP_HOME."/".$strCateImgPath."/".strtolower($key)."/".$cateMgr->getCL_IMG2();
							copy($strCopyOrgPath2,$strCopyNewPath2);
						}

						$cateMgr->getCateLngInsert($db);
					}
				}
			}

			/* 기획전 카테고리일때 */
			if ($strC_TYPE == "P"){
				$cateMgr->getCatePlanUpdate($db);
			}

			$strLinkPage  = "&cateHCode1=$strC_HCODE1&cateHCode2=$strC_HCODE2";
			$strLinkPage .= "&cateHCode3=$strC_HCODE3&cateHCode4=$strC_HCODE4";
			$strLinkPage .= "&lang=$strStLng";

			$strUrl = "./?menuType=".$strMenuType."&mode=cateList".$strLinkPage;
			include MALL_HOME."/web/shopAdmin/layout/categoryMakeFile.php";

			goIfrmReflash($LNG_TRANS_CHAR["PS00026"],"goClose()"); //상품카테고리가 등록되었습니다.
			exit;

		break;

		case "cateModify":
			// 카테고리 수정

			$cateMgr->setCL_LNG($strStLng);
			$cateMgr->setC_CODE($strCATE_CODE);
			$cateRow = $cateMgr->getView($db);

			$strCateImgPath = "upload/category/".strtolower($strStLng);

			if($_POST['cateImg1_del']=="Y"):
				// 이미지 삭제
				$imgName			= $cateRow['CL_IMG1'];
				$imgFullDirName		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$strCateImgPath}/{$imgName}";
				$cateRow['CL_IMG1']	= "";
				unlink($imgFullDirName);
			endif;

			if($_POST['cateImg2_del']=="Y"):
				// 이미지 삭제
				$imgName			= $cateRow['CL_IMG2'];
				$imgFullDirName		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$strCateImgPath}/{$imgName}";
				$cateRow['CL_IMG2']	= "";
				unlink($imgFullDirName);
			endif;

			for($i=1;$i<=2;$i++){
				if ($_FILES["cateImg".$i][name]){

					if (!getAllowImgFileExt($_FILES["cateImg".$i][name])){
						goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
						exit;
					}

					$strFileName	= $_FILES["cateImg".$i][name];
					$strFileTmpName = $_FILES["cateImg".$i][tmp_name];
					$intFileSize	= $_FILES["cateImg".$i][size];
					$strFileType	= $_FILES["cateImg".$i][type];

					$fres = $fh->doUpload($strCATE_CODE."_".$i,"../".$strCateImgPath,$strFileName,$strFileTmpName,$intFileSize,$strFileType);

					if($fres) {
						if ($i == 1){
							$cateMgr->setCL_IMG1($fres[file_real_name]);
							if ($cateRow[CL_IMG1]) $fh->fileDelete("../".$strCateImgPath."/".$cateRow[CL_IMG1]);
						} else if ($i == 2){
							$cateMgr->setCL_IMG2($fres[file_real_name]);
							if ($cateRow[CL_IMG2]) $fh->fileDelete("../".$strCateImgPath."/".$cateRow[CL_IMG2]);
						}
					}
				} else {
					if ($i == 1){
						$cateMgr->setCL_IMG1($cateRow[CL_IMG1]);
					} else if ($i == 2){
						$cateMgr->setCL_IMG2($cateRow[CL_IMG2]);
					}
				}
			}
			if(!$strC_VIEW_YN) { $strC_VIEW_YN = "N"; }
			$cateMgr->setC_VIEW_YN($strC_VIEW_YN);
			$cateMgr->getUpdate($db);

			$strLinkPage  = "&cateHCode1=$strC_HCODE1&cateHCode2=$strC_HCODE2";
			$strLinkPage .= "&cateHCode3=$strC_HCODE3&cateHCode4=$strC_HCODE4";
			$strLinkPage .= "&lang=$strStLng";

			$strUrl = "./?menuType=".$strMenuType."&mode=cateList".$strLinkPage;


			include MALL_HOME."/web/shopAdmin/layout/categoryMakeFile.php";

			goIfrmReflash($LNG_TRANS_CHAR["PS00027"],"goClose()"); //상품카테고리가 수정되었습니다.
			exit;

		break;

		case "cateDelete":

			$cateMgr->setCL_LNG($strStLng);
			$cateMgr->setC_CODE($strCATE_CODE);
			$cateRow = $cateMgr->getView($db);

			if ($cateRow['C_TYPE'] == "P"){
				$strC_TYPE			= "P";

				$param				= "";
				$param['PL_P_CATE'] = $strCATE_CODE;
				$intProdCnt			= $planMgr->getProdPlanCateCount($db,$param);

				$cateMgr->setC_TYPE("P");
			} else {

				/* 삭제할 카테고리로 등록된 상품 확인*/
				$productMgr->setP_CATE($strCATE_CODE);
				$intProdCnt = $productMgr->getProductCateTotal($db);
			}

			if ($intProdCnt > 0)
			{
				goErrMsg($LNG_TRANS_CHAR["PS00023"]); //이미 등록된 상품이 존재합니다.상품을 먼저 삭제하세요.
				$db->disConnect();
				exit;
			}

			/* 하위 카테고리 존재 확인 */
			$cateMgr->setC_HCODE($strCATE_CODE);
			$intCateLowCnt = $cateMgr->getLowCount($db);

			if ($intCateLowCnt > 0){
				goErrMsg($LNG_TRANS_CHAR["PS00024"]); //이미 등록된 하위카테고리가 존재합니다. 하위카테고리를 먼저 삭제하세요.
				$db->disConnect();
				exit;
			}

			/* 카테고리 삭제*/
			$strCateImgPath = "upload/category";
			while(list($key,$val) = each($S_ARY_USE_COUNTRY)){
				$cateMgr->setC_CODE($strCATE_CODE);
				$cateMgr->setCL_LNG($key);
				$cateRow = $cateMgr->getView($db);

				if ($cateRow[CL_IMG1]) $fh->fileDelete("../".$strCateImgPath."/".strtolower($key)."/".$cateRow[CL_IMG1]);
				if ($cateRow[CL_IMG2]) $fh->fileDelete("../".$strCateImgPath."/".strtolower($key)."/".$cateRow[CL_IMG2]);
			}

			$cateMgr->getDelete($db);

			$strMsg = $LNG_TRANS_CHAR["CS00005"]; //선택하신 카테고리가 삭제되었습니다.

			$strLinkPage  = "&cateHCode1=$strC_HCODE1&cateHCode2=$strC_HCODE2";
			$strLinkPage .= "&cateHCode3=$strC_HCODE3&cateHCode4=$strC_HCODE4";
			$strLinkPage .= "&lang=$strStLng";

			$strUrl = "./?menuType=".$strMenuType."&mode=cateList".$strLinkPage;
			if ($strC_TYPE == "P")	$strUrl = "./?menuType=".$strMenuType."&mode=catePlanList".$strLinkPage;

		break;
	}

	/* 카테고리 파일 생성 */
	include MALL_HOME."/web/shopAdmin/layout/categoryMakeFile.php";
	/* 카테고리 파일 생성 */

?>