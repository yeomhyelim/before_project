<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once "{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
	
	$productMgr = new ProductAdmMgr();
	
	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField			= $_POST["searchField"]			? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]			? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]				? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine			= $_POST["pageLine"]			? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$intPR_NO				= $_POST["brandNo"]				? $_POST["brandNo"]			: $_REQUEST["brandNo"];	
	
	$strPR_NAME				= $_POST["pr_name"]				? $_POST["pr_name"]			: $_REQUEST["pr_name"];
	$strPR_LIST_IMG			= $_POST["pr_list_img"]			? $_POST["pr_list_img"]		: $_REQUEST["pr_list_img"];
	$strPR_TITLE_IMG		= $_POST["pr_title_img"]		? $_POST["pr_title_img"]	: $_REQUEST["pr_title_img"];
	$strPR_VIEW_IMG			= $_POST["pr_view_img"]			? $_POST["pr_view_img"]		: $_REQUEST["pr_view_img"];
	$strPR_ADD_IMG			= $_POST["pr_add_img"]			? $_POST["pr_add_img"]		: $_REQUEST["pr_add_img"];
	$strPR_COMMENT			= $_POST["pr_comment"]			? $_POST["pr_comment"]		: $_REQUEST["pr_comment"];
	$strPR_HTML				= $_POST["pr_html"]				? $_POST["pr_html"]			: $_REQUEST["pr_html"];
	$strPR_TMP1				= $_POST["pr_tmp1"]				? $_POST["pr_tmp1"]			: $_REQUEST["pr_tmp1"];
	$strPR_TMP2				= $_POST["pr_tmp2"]				? $_POST["pr_tmp2"]			: $_REQUEST["pr_tmp2"];
	$strPR_TMP3				= $_POST["pr_tmp3"]				? $_POST["pr_tmp3"]			: $_REQUEST["pr_tmp3"];
	$intPR_M_NO				= $_POST["pr_m_no"]				? $_POST["pr_m_no"]			: $_REQUEST["pr_m_no"];
	$intPR_ALIGN			= $_POST["pr_align"]			? $_POST["pr_align"]		: $_REQUEST["pr_align"];
	$intPR_REG_DT			= $_POST["pr_reg_dt"]			? $_POST["pr_reg_dt"]		: $_REQUEST["pr_reg_dt"];
	$intPR_REG_NO			= $_POST["pr_reg_no"]			? $_POST["pr_reg_no"]		: $_REQUEST["pr_reg_no"];
	$intPR_MOD_DT			= $_POST["pr_mod_dt"]			? $_POST["pr_mod_dt"]		: $_REQUEST["pr_mod_dt"];
	$intPR_MOD_NO			= $_POST["pr_mod_no"]			? $_POST["pr_mod_no"]		: $_REQUEST["pr_mod_no"];
	/*##################################### Parameter 셋팅 #####################################*/

	$strPR_NAME			= strTrim($strPR_NAME,50);
	$strPR_LIST_IMG		= strTrim($strPR_LIST_IMG,100);
	$strPR_TITLE_IMG	= strTrim($strPR_TITLE_IMG,100);
	$strPR_VIEW_IMG		= strTrim($strPR_VIEW_IMG,100);
	$strPR_ADD_IMG		= strTrim($strPR_ADD_IMG,100);
	$strPR_COMMENT		= strTrim($strPR_COMMENT,500);
	$strPR_HTML			= strTrim($strPR_HTML,65535);
	$strPR_TMP1			= strTrim($strPR_TMP1,50);
	$strPR_TMP2			= strTrim($strPR_TMP2,50);
	$strPR_TMP3			= strTrim($strPR_TMP3,200);

	$productMgr->setPR_NO($intPR_NO);
	$productMgr->setPR_NAME($strPR_NAME);
	$productMgr->setPR_LIST_IMG($strPR_LIST_IMG);
	$productMgr->setPR_TITLE_IMG($strPR_TITLE_IMG);
	$productMgr->setPR_VIEW_IMG($strPR_VIEW_IMG);
	$productMgr->setPR_ADD_IMG($strPR_ADD_IMG);
	$productMgr->setPR_COMMENT($strPR_COMMENT);
	$productMgr->setPR_HTML($strPR_HTML);
	$productMgr->setPR_TMP1($strPR_TMP1);
	$productMgr->setPR_TMP2($strPR_TMP2);
	$productMgr->setPR_TMP3($strPR_TMP3);
	$productMgr->setPR_M_NO($intPR_M_NO);
	$productMgr->setPR_ALIGN($intPR_ALIGN);
	$productMgr->setPR_REG_DT($intPR_REG_DT);
	$productMgr->setPR_REG_NO($intPR_REG_NO);
	$productMgr->setPR_MOD_DT($intPR_MOD_DT);
	$productMgr->setPR_MOD_NO($intPR_MOD_NO);

	/*##################################### PRODUCT    #####################################*/

	$strLinkPage = "";

	switch ($strAct) {
		case "prodBrandWrite":
			// 브랜드 등록

			/* 파일 업로드 */
			// 공통
			$strSaveDir		= WEB_UPLOAD_PATH . "/brand";
			$strSaveTime	= date("YmdHis");

			// 목록 이미지 업데이트
			$aryFileInfo	= $fh->getFileInfo($_FILES['pr_list_img']['name']);
			$strSaveName	= sprintf("LIST_%s_%s", $strSaveTime, $aryFileInfo['basename']);
			if($fh->doUploadEasy($strSaveDir. "/" . $strSaveName, "pr_list_img")):
				$strPR_LIST_IMG		= sprintf("/upload/brand/%s", $strSaveName);
				$productMgr->setPR_LIST_IMG($strPR_LIST_IMG);
			endif;

			// 제목 이미지 업데이트
			$aryFileInfo	= $fh->getFileInfo($_FILES['pr_title_img']['name']);
			$strSaveName	= sprintf("TITLE_%s_%s", $strSaveTime, $aryFileInfo['basename']);
			if($fh->doUploadEasy($strSaveDir. "/" . $strSaveName, "pr_title_img")):
				$strPR_TITLE_IMG	= sprintf("/upload/brand/%s", $strSaveName);
				$productMgr->setPR_TITLE_IMG($strPR_TITLE_IMG);
			endif;
			/* 파일 업로드 */

			// 제목 이미지 업데이트
			$aryFileInfo	= $fh->getFileInfo($_FILES['pr_view_img']['name']);
			$strSaveName	= sprintf("VIEW_%s_%s", $strSaveTime, $aryFileInfo['basename']);
			if($fh->doUploadEasy($strSaveDir. "/" . $strSaveName, "pr_view_img")):
				$strPR_VIEW_IMG		= sprintf("/upload/brand/%s", $strSaveName);
				$productMgr->setPR_VIEW_IMG($strPR_VIEW_IMG);
			endif;

			// 추가 이미지 업데이트
			$aryFileInfo	= $fh->getFileInfo($_FILES['pr_add_img']['name']);
			$strSaveName	= sprintf("ADD_%s_%s", $strSaveTime, $aryFileInfo['basename']);
			if($fh->doUploadEasy($strSaveDir. "/" . $strSaveName, "pr_add_img")):
				$strPR_ADD_IMG		= sprintf("/upload/brand/%s", $strSaveName);
				$productMgr->setPR_ADD_IMG($strPR_ADD_IMG);
			endif;
			/* 파일 업로드 */

			$productMgr->setPR_REG_NO($_SESSION["ADMIN_NO"]);
			$productMgr->setPR_MOD_NO($_SESSION["ADMIN_NO"]);

			$productMgr->getProdBrandInsert($db);
			$intPR_NO = $db->getLastInsertID();

			/** 2013.04.26 다국어 추가 **/
			$strPL_LNG = ($strStLng) ? $strStLng : $S_ST_LNG;
			$productMgr->setPL_PR_NO($intPR_NO);
			$productMgr->setPL_LNG($strPL_LNG);
			$brandRowLng = $productMgr->getProdBrandLngList($db, "OP_SELECT");

			$productMgr->setPL_PR_HTML($strPR_HTML);
			if($brandRowLng): // 데이터가 있으므로 수정
				$productMgr->getProdBrandLngUpdate($db);
			else: // 데이터가 없으므로 추가
				$productMgr->getProdBrandLngInsert($db);
			endif;
			/** 2013.04.26 다국어 추가 **/

			$strUrl = "./?menuType=product&mode=prodBrandList";

		break;

		case "prodBrandModify":
			// 브랜드 수정

			## 2014.09.02 kim hee sung 모든언어가 기준언어로 저장되는 문제 수정
			$strLang = $_POST['lang'];
			if(!$strLang) { $strLang = $S_ST_LNG; }
			$strPL_LNG = $strLang;

			$productMgr->setPR_NO($intPR_NO);
			$brandRow = $productMgr->getProdBrandView($db);
			$productMgr->setPR_LIST_IMG($brandRow["PR_LIST_IMG"]);
			$productMgr->setPR_TITLE_IMG($brandRow["PR_TITLE_IMG"]);
			$productMgr->setPR_VIEW_IMG($brandRow["PR_VIEW_IMG"]);
			$productMgr->setPR_ADD_IMG($brandRow["PR_ADD_IMG"]);

			if($strPL_LNG != $S_ST_LNG): 
				$productMgr->setPR_HTML($brandRow["PR_HTML"]);
			endif;

			/* 파일 업로드 */
			// 공통
			$strSaveDir		= WEB_UPLOAD_PATH . "/brand";
			$strSaveTime	= date("YmdHis");

			// 목록 이미지 업데이트
			$aryFileInfo	= $fh->getFileInfo($_FILES['pr_list_img']['name']);
			$strSaveName	= sprintf("LIST_%s_%s", $strSaveTime, $aryFileInfo['basename']);
			if($fh->doUploadEasy($strSaveDir. "/" . $strSaveName, "pr_list_img")):
				$strPR_LIST_IMG		= sprintf("/upload/brand/%s", $strSaveName);
				$productMgr->setPR_LIST_IMG($strPR_LIST_IMG);
				// 파일 삭제
				$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $brandRow["PR_LIST_IMG"]);
			endif;

			// 제목 이미지 업데이트
			$aryFileInfo	= $fh->getFileInfo($_FILES['pr_title_img']['name']);
			$strSaveName	= sprintf("TITLE_%s_%s", $strSaveTime, $aryFileInfo['basename']);
			if($fh->doUploadEasy($strSaveDir. "/" . $strSaveName, "pr_title_img")):
				$strPR_TITLE_IMG	= sprintf("/upload/brand/%s", $strSaveName);
				$productMgr->setPR_TITLE_IMG($strPR_TITLE_IMG);
				// 파일 삭제
				$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $brandRow["PR_TITLE_IMG"]);
			endif;
			/* 파일 업로드 */

			// 제목 이미지 업데이트
			$aryFileInfo	= $fh->getFileInfo($_FILES['pr_view_img']['name']);
			$strSaveName	= sprintf("VIEW_%s_%s", $strSaveTime, $aryFileInfo['basename']);
			if($fh->doUploadEasy($strSaveDir. "/" . $strSaveName, "pr_view_img")):
				$strPR_VIEW_IMG		= sprintf("/upload/brand/%s", $strSaveName);
				$productMgr->setPR_VIEW_IMG($strPR_VIEW_IMG);
				// 파일 삭제
				$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $brandRow["PR_VIEW_IMG"]);
			endif;

			// 추가 이미지 업데이트
			$aryFileInfo	= $fh->getFileInfo($_FILES['pr_add_img']['name']);
			$strSaveName	= sprintf("ADD_%s_%s", $strSaveTime, $aryFileInfo['basename']);
			if($fh->doUploadEasy($strSaveDir. "/" . $strSaveName, "pr_add_img")):
				$strPR_ADD_IMG		= sprintf("/upload/brand/%s", $strSaveName);
				$productMgr->setPR_ADD_IMG($strPR_ADD_IMG);
				// 파일 삭제
				$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $brandRow["PR_ADD_IMG"]);
			endif;
			/* 파일 업로드 */

			$productMgr->getProdBrandUpdate($db);


			/** 2013.04.26 다국어 추가 **/
//			$strPL_LNG = ($strStLng) ? $strStLng : $S_ST_LNG;
			$productMgr->setPL_PR_NO($intPR_NO);
			$productMgr->setPL_LNG($strPL_LNG);
			$brandRowLng = $productMgr->getProdBrandLngList($db, "OP_SELECT");

			$productMgr->setPL_PR_HTML($strPR_HTML);
			if($brandRowLng): // 데이터가 있으므로 수정
				$productMgr->getProdBrandLngUpdate($db);
			else: // 데이터가 없으므로 추가
				$productMgr->getProdBrandLngInsert($db);
			endif;
			/** 2013.04.26 다국어 추가 **/

			$strUrl = "./?menuType=product&mode=prodBrandModify&lang={$strStLng}&brandNo=$intPR_NO";
		break;

		case "prodBrandDelete":
			// 브랜드 삭제
			$productMgr->setPR_NO($intPR_NO);
			$brandRow = $productMgr->getProdBrandView($db);
			$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $brandRow["PR_LIST_IMG"]);
			$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $brandRow["PR_TITLE_IMG"]);
			$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $brandRow["PR_VIEW_IMG"]);
			$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $brandRow["PR_ADD_IMG"]);

			$productMgr->getProdBrandDelete($db);

			/** 2013.04.26 다국어 추가 **/
			$productMgr->setPL_PR_NO($intPR_NO);
			$productMgr->getProdBrandLngDelete($db);
			/** 2013.04.26 다국어 추가 **/

			$strMsg = $LNG_TRANS_CHAR["CS00005"]; //선택하신 브랜드가 삭제되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=prodBrandList".$strLinkPage;
		break;
	}	

	/** 2013.04.18 상품 브랜드 파일 생성 **/
	## STEP 1.
	## 데이터 만들기
	$data					= "";
	$prodBrandResult		= $productMgr->getProdBrandList( $db, "OP_LIST" );
	while($row = mysql_fetch_array($prodBrandResult)):
		/* 브랜드번호 */
		$dataTemp	= "";
		$dataTemp	= sprintf("\$PROD_BRAND['%s']['%s']", $row['PR_NO'], "PR_NO");
		$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
		$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $row['PR_NO']); 
		$dataTemp	= str_pad($dataTemp, 140, " ", STR_PAD_RIGHT);
		$dataTemp	= sprintf("%s // %s", $dataTemp, "브렌드번호"); 
		$data	   .= ($data) ? "\r\n" : "";
		$data	   .= $dataTemp;

		/* 브랜드이름 */
		$dataTemp	= "";
		$dataTemp	= sprintf("\$PROD_BRAND['%s']['%s']", $row['PR_NO'], "PR_NAME");
		$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
		$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $row['PR_NAME']); 
		$dataTemp	= str_pad($dataTemp, 140, " ", STR_PAD_RIGHT);
		$dataTemp	= sprintf("%s // %s", $dataTemp, "브렌드이름"); 
		$data	   .= ($data) ? "\r\n" : "";
		$data	   .= $dataTemp;
	endwhile;

	## STEP 2.
	## 파일 만들기(기존 데이터 업데이트 형)
	$prodBrandConfName	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/prodBrand.conf.inc.php";
	$file				= new FileHandler();	
	$file->getMadeInfo($prodBrandConfName, $data, "/*@ PROD_BRAND @*/");
	/** 2013.04.18 상품 브랜드 파일 생성 **/

?>