<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	
	$productMgr = new ProductAdmMgr();

	/*##################################### Parameter 셋팅 #####################################*/	
	$strPR_IMG_TYPE		= $_POST["pr_img_type"]		? $_POST["pr_img_type"]		: $_REQUEST["pr_img_type"];
	$intPR_NO			= $_POST["brandNo"]			? $_POST["brandNo"]			: $_REQUEST["brandNo"];	
	/*##################################### Parameter 셋팅 #####################################*/

	
	switch ($strJsonMode){
		case "prodBrandImgDelete":
			// 브랜드 이미지 삭제
			$productMgr->setPR_NO($intPR_NO);
			$brandRow			= $productMgr->getProdBrandView($db);
			$strColumnName		= "PR_{$strPR_IMG_TYPE}_IMG";
			if(!$brandRow[$strColumnName]):
				// 등록된 정보가 없을 때
				$result[0][RET]				= "N";
				$result[0][PR_IMG_TYPE]		= $strPR_IMG_TYPE;
				$result[0][MSG]				= "이미지 정보가 없습니다.";
				$result_array				= json_encode($result);
				echo $result_array;	
				break;
			endif;

			// 파일 삭제
			$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $brandRow["PR_{$strPR_IMG_TYPE}_IMG"]);
			
			// DB 업데이트
			$productMgr->getProdBrandSelfUpdate($db, $strColumnName, '', $intPR_NO);

			$result[0][RET]				= "Y";
			$result[0][PR_IMG_TYPE]		= $strPR_IMG_TYPE;
			$result[0][MSG]				= "이미지가 삭제 되었습니다.";
			$result_array				= json_encode($result);
			echo $result_array;			
		break;		
	}	
?>