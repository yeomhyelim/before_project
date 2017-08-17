<?

/*##################################### Parameter 셋팅 ##################################################*/

	$strPO_TYPE		= $_POST["po_type"]			? $_POST["po_type"]			: $_REQUEST["po_type"];
	$strPO_GUBUN	= $_POST["po_gubun"]		? $_POST["po_gubun"]		: $_REQUEST["po_gubun"];
	$intP_NO		= $_POST["p_no"]			? $_POST["p_no"]			: $_REQUEST["p_no"];
	$strPO_LINK		= $_POST["po_link"]			? $_POST["po_link"]			: $_REQUEST["po_link"];
	$strPO_TITLE	= $_POST["po_title"]		? $_POST["po_title"]		: $_REQUEST["po_title"];
	$strPO_LEFT		= $_POST["po_left"]			? $_POST["po_left"]			: $_REQUEST["po_left"];
	$strPO_TOP		= $_POST["po_top"]			? $_POST["po_top"]			: $_REQUEST["po_top"];
	$strPO_FILE		= $_POST["po_file"]			? $_POST["po_file"]			: $_REQUEST["po_file"];
	$strPO_START_DT = $_POST["po_start_dt"]		? $_POST["po_start_dt"]		: $_REQUEST["po_start_dt"];
	$strPO_END_DT	= $_POST["po_end_dt"]		? $_POST["po_end_dt"]		: $_REQUEST["po_end_dt"];
	$strPO_VIEW		= $_POST["po_view"]			? $_POST["po_view"]			: $_REQUEST["po_view"];

	$strB_TITLE		= $_POST["b_title"]			? $_POST["b_title"]			: $_REQUEST["b_title"];
	$strB_VIEW		= $_POST["b_view"]			? $_POST["b_view"]			: $_REQUEST["b_view"];
	$strB_TYPE		= $_POST["b_type"]			? $_POST["b_type"]			: $_REQUEST["b_type"];
	$intB_START_DT	= $_POST["b_start_dt"]		? $_POST["b_start_dt"]		: $_REQUEST["b_start_dt"];
	$intB_END_DT	= $_POST["b_end_dt"]		? $_POST["b_end_dt"]		: $_REQUEST["b_end_dt"];
	$strB_LINK_URL	= $_POST["b_link_url"]		? $_POST["b_link_url"]		: $_REQUEST["b_link_url"];	
	$strB_LINK_TYPE = $_POST["b_link_type"]		? $_POST["b_link_type"]		: $_REQUEST["b_link_type"];
	$intB_WIDTH		= $_POST["b_width"]			? $_POST["b_width"]			: $_REQUEST["b_width"];
	$intB_HEIGHT	= $_POST["b_height"]		? $_POST["b_height"]		: $_REQUEST["b_height"];

	$strPT_TYPE		= $_POST["pointType"]		? $_POST["pointType"]		: $_REQUEST["pointType"];
	$intPT_POINT	= $_POST["pointPrice"]		? $_POST["pointPrice"]		: $_REQUEST["pointPrice"];
	$strPT_MEMO		= $_POST["pointMemo"]		? $_POST["pointMemo"]		: $_REQUEST["pointMemo"];
	$strPT_END_DT	= $_POST["pointEndDt"]		? $_POST["pointEndDt"]		: $_REQUEST["pointEndDt"];
	$strPT_ETC		= $_POST["pointEtc"]		? $_POST["pointEtc"]		: $_REQUEST["pointEtc"];

	if (!$intP_NO) $intP_NO = 0;

	if (!$intB_WIDTH) $intB_WIDTH = 0;
	if (!$intB_HEIGHT) $intB_HEIGHT = 0;

/*##################################### Parameter 셋팅 ##################################################*/


/*##################################### Advertise Parameter 셋팅 ########################################*/

	$intA_NO				= $_POST["a_no"]				? $_POST["a_no"]				: $_REQUEST["a_no"];
	$strA_NAME				= $_POST["a_name"]				? $_POST["a_name"]				: $_REQUEST["a_name"];
	$strA_TAG				= $_POST["a_tag"]				? $_POST["a_tag"]				: $_REQUEST["a_tag"];
	$strA_LOCA				= $_POST["a_loca"]				? $_POST["a_loca"]				: $_REQUEST["a_loca"];
	$intA_TABLE_W			= $_POST["a_table_w"]			? $_POST["a_table_w"]			: $_REQUEST["a_table_w"];
	$intA_TABLE_H			= $_POST["a_table_h"]			? $_POST["a_table_h"]			: $_REQUEST["a_table_h"];
	$intA_SIZE_W			= $_POST["a_size_w"]			? $_POST["a_size_w"]			: $_REQUEST["a_size_w"];
	$intA_SIZE_H			= $_POST["a_size_h"]			? $_POST["a_size_h"]			: $_REQUEST["a_size_h"];
	$intA_MARGIN_W			= $_POST["a_margin_w"]			? $_POST["a_margin_w"]			: $_REQUEST["a_margin_w"];
	$intA_MARGIN_H			= $_POST["a_margin_h"]			? $_POST["a_margin_h"]			: $_REQUEST["a_margin_h"];
	$strA_USE				= $_POST["a_use"]				? $_POST["a_use"]				: $_REQUEST["a_use"];
	$intA_REG_DT			= $_POST["a_reg_dt"]			? $_POST["a_reg_dt"]			: $_REQUEST["a_reg_dt"];
	$intA_REG_NO			= $_POST["a_reg_no"]			? $_POST["a_reg_no"]			: $_REQUEST["a_reg_no"];
	$intA_MOD_DT			= $_POST["a_mod_dt"]			? $_POST["a_mod_dt"]			: $_REQUEST["a_mod_dt"];
	$intA_MOD_NO			= $_POST["a_mod_no"]			? $_POST["a_mod_no"]			: $_REQUEST["a_mod_no"];

/*##################################### Advertise Parameter 셋팅 ########################################*/


	$strPO_TYPE		= strTrim($strPO_TYPE,1);
	$strPO_GUBUN	= strTrim($strPO_GUBUN,1);
	$strPO_LINK		= strTrim($strPO_LINK,100);
	$strPO_TITLE	= strTrim($strPO_TITLE,100);
	$strPO_LEFT		= strTrim($strPO_LEFT,5);
	$strPO_TOP		= strTrim($strPO_TOP,5);
	$strPO_FILE		= strTrim($strPO_FILE,50);
	$strPO_VIEW		= strTrim($strPO_VIEW,1);

	$strB_TITLE		= strTrim($strB_TITLE,50);
	$strB_VIEW		= strTrim($strB_VIEW,1);
	$strB_TYPE		= strTrim($strB_TYPE,1);
	$strB_LINK_URL	= strTrim($strB_LINK_URL,200);
	$strB_LINK_TYPE = strTrim($strB_LINK_TYPE,1);

	$strPT_TYPE		= strTrim($strPT_TYPE,3);
	$strPT_MEMO		= strTrim($strPT_MEMO,"","N");
	$strPT_REG_IP	= strTrim($S_REOMTE_ADDR,20);
	$strPT_ETC		= strTrim($strPT_ETC,100);

	$strA_NAME		= strTrim($strA_NAME,50);
	$strA_TAG		= strTrim($strA_TAG,20);
	$strA_LOCA		= strTrim($strA_LOCA,50);
	$strA_USE		= strTrim($strA_USE,1);

	$strA_MARGIN_W	= (strB_TYPE != "F") ? 0 : $strA_MARGIN_W;
	$strA_MARGIN_H	= (strB_TYPE != "F") ? 0 : $strA_MARGIN_H;

	$popupMgr->setPO_NO($intPO_NO);
	$popupMgr->setPO_TYPE($strPO_TYPE);
	$popupMgr->setPO_GUBUN($strPO_GUBUN);
	$popupMgr->setP_NO($intP_NO);
	$popupMgr->setPO_LINK($strPO_LINK);
	$popupMgr->setPO_TITLE($strPO_TITLE);
	$popupMgr->setPO_LEFT($strPO_LEFT);
	$popupMgr->setPO_TOP($strPO_TOP);
	$popupMgr->setPO_FILE($strPO_FILE);
	$popupMgr->setPO_START_DT($strPO_START_DT);
	$popupMgr->setPO_END_DT($strPO_END_DT);
	$popupMgr->setPO_VIEW($strPO_VIEW);

	$bannerMgr->setB_TITLE($strB_TITLE);
	$bannerMgr->setB_VIEW($strB_VIEW);
	$bannerMgr->setB_TYPE($strB_TYPE);
	$bannerMgr->setB_START_DT($intB_START_DT);
	$bannerMgr->setB_END_DT($intB_END_DT);
	$bannerMgr->setB_LINK_URL($strB_LINK_URL);
	$bannerMgr->setB_LINK_TYPE($strB_LINK_TYPE);
	$bannerMgr->setB_WIDTH($intB_WIDTH);
	$bannerMgr->setB_HEIGHT($intB_HEIGHT);

	$orderMgr->setM_NO($intM_NO);
	$orderMgr->setB_NO(0);
	$orderMgr->setO_NO(0);
	$orderMgr->setPT_TYPE($strPT_TYPE);
	$orderMgr->setPT_POINT($intPT_POINT);
	$orderMgr->setPT_MEMO($strPT_MEMO);
	$orderMgr->setPT_START_DT(date("Y-m-d"));
	$orderMgr->setPT_END_DT($strPT_END_DT);
	$orderMgr->setPT_REG_IP($S_REMOTE_ADDR);
	$orderMgr->setPT_ETC($strPT_ETC);
	$orderMgr->setPT_REG_NO($a_admin_no);

	$bannerMgr->setA_NO(0);
	$bannerMgr->setA_NAME($strA_NAME);
	$bannerMgr->setA_TAG($strA_TAG);
	$bannerMgr->setA_LOCA($strA_LOCA);
	$bannerMgr->setA_TABLE_W($intA_TABLE_W);
	$bannerMgr->setA_TABLE_H($intA_TABLE_H);
	$bannerMgr->setA_SIZE_W($intA_SIZE_W);
	$bannerMgr->setA_SIZE_H($intA_SIZE_H);
	$bannerMgr->setA_MARGIN_W($intA_MARGIN_W);
	$bannerMgr->setA_MARGIN_H($intA_MARGIN_H);
	$bannerMgr->setA_USE($strA_USE);
	$bannerMgr->setA_REG_DT($intA_REG_DT);
	$bannerMgr->setA_REG_NO($intA_REG_NO);
	$bannerMgr->setA_MOD_DT($intA_MOD_DT);
	$bannerMgr->setA_MOD_NO($intA_MOD_NO);


	$strLinkPage  = "&searchField=$strSearchField&searchKey=$strSearchKey";
	$strLinkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";

	switch ($strAct) {
		case "adverWrite":

			$bannerMgr->getAdvertiseInsert($db);

			$strMsg= $LNG_TRANS_CHAR["CS00003"]; //"배너그룹 등록 되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=adverList&".$strLinkPage;

			/* 배너 그룹 관리(광고 관리) 정보 리스트 가져오기 */
//			$arrAdvertiseListRow = $bannerMgr->getAdvertiseListAll($db);
//			makeBannerGrpInfoFile($arrAdvertiseListRow);

		break;
		case "adverModify":
	
			$bannerMgr->setA_NO($intA_NO);

			$bannerMgr->getAdvertiseUpdate($db);

			$strMsg= $LNG_TRANS_CHAR["CS00004"]; //"배너그룹 수정이 되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=adverList&a_no=".$intA_NO."&page=".$intPage.$strLinkPage;

			## STEP 6.
			## 배너 파일 생성
			## 2013.04.27 배너 사용 안함으로 변경할 때, table 정보가 변경됨.
			$aryUseLng = explode("/", $S_USE_LNG);
			foreach($aryUseLng as $lng):
				makeBannerLayoutFile($lng);
			endforeach;

			/* 배너 그룹 관리(광고 관리) 정보 리스트 가져오기 */
//			$arrAdvertiseListRow = $bannerMgr->getAdvertiseListAll($db);
//			makeBannerGrpInfoFile($arrAdvertiseListRow);

		break;

		case "adverDelete":
		
			$bannerMgr->setA_NO($intA_NO);

			$bannerMgr->getAdvertiseDelete($db);

			$strMsg= $LNG_TRANS_CHAR["CS00005"]; //"배너그룹이 삭제되었습니다.";
			
			$strUrl = "./?menuType=".$strMenuType."&mode=adverList&page=".$intPage.$strLinkPage;

			/* 배너 그룹 관리(광고 관리) 정보 리스트 가져오기 */
//			$arrAdvertiseListRow = $bannerMgr->getAdvertiseListAll($db);
//			makeBannerGrpInfoFile($arrAdvertiseListRow);

		break;

		case "popupWrite":
			
			if ($_FILES["b_file"][name]) 
			{

				if (!getAllowImgFileExt($_FILES["b_file"][name])){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //"첨부하신 파일은 확장자가 금지된 파일입니다."
					exit;
				}

				$filename = $_FILES["b_file"][name];
				$tmpname  = $_FILES["b_file"][tmp_name];
				$filesize = $_FILES["b_file"][size];
				$filetype = $_FILES["b_file"][type];

				$number = date("YmdHis");		//파일명 숫자로 변경			
				$fres = $fh->doUpload("$number","../upload/popup",$filename,$tmpname,$filesize,$filetype);
				if($fres) {
					$popupMgr->setPO_FILE($fres[file_real_name]);
					$popupMgr->getInsert($db);
					$strMsg=$LNG_TRANS_CHAR["CS00003"]; //"팝업 등록이 성공 되었습니다.";
				}else{
					$strMsg= $LNG_TRANS_CHAR["CS00011"]; //"팝업 등록이 실패 되었습니다.";
				}
			}else{
				$strMsg= $LNG_TRANS_CHAR["ES00014"]; //"팝업 등록하시려면 이미지가 필요합니다.";
			}
			
			$strUrl = "./?menuType=".$strMenuType."&mode=popupList&".$strLinkPage;

					
		break;

		case "popupModify":
			
			$popupMgr->setPO_NO($intPO_NO);
			$row = $popupMgr->getView($db);

			if ($_FILES["b_file"][name]) 
			{

				if (!getAllowImgFileExt($_FILES["b_file"][name])){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //"첨부하신 파일은 확장자가 금지된 파일입니다."
					exit;
				}

				$filename = $_FILES["b_file"][name];
				$tmpname  = $_FILES["b_file"][tmp_name];
				$filesize = $_FILES["b_file"][size];
				$filetype = $_FILES["b_file"][type];

				$number = date("YmdHis");		//파일명 숫자로 변경			
				$fres = $fh->doUpload("$number","../upload/popup",$filename,$tmpname,$filesize,$filetype);
				if($fres) {
					
					$popupMgr->setPO_FILE($fres[file_real_name]);
					$popupMgr->getUpdate($db);

					if ($row[PO_FILE]){
						$fh->fileDelete("../upload/popup/".$row[PO_FILE]);
					}
					$strMsg= $LNG_TRANS_CHAR["CS00004"]; //"팝업 수정이 완료되었습니다.";
				}else{
					$strMsg= $LNG_TRANS_CHAR["CS00011"]; //"팝업 수정이 실패 되었습니다.";
				}

			}else{
				$popupMgr->setPO_FILE($row[PO_FILE]);
				$popupMgr->getUpdate($db);
				$strMsg= $LNG_TRANS_CHAR["CS00004"]; //"팝업 수정이 완료되었습니다.";
			}

			$strUrl = "./?menuType=".$strMenuType."&mode=popupModify&po_no=".$intPO_NO."&page=".$intPage.$strLinkPage;

		break;

		case "popupDelete":
			$popupMgr->setPO_NO($intPO_NO);
			$row = $popupMgr->getView($db);

			if ($row[PO_FILE]){
				$fh->fileDelete("../upload/popup/".$row[PO_FILE]);
			}
			$popupMgr->getDelete($db);
			
			$strMsg= $LNG_TRANS_CHAR["CS00005"]; //"팝업 삭제가 완료되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=popupList&page=".$intPage.$strLinkPage;
		break;

		case "bannerWrite":
		
			## 모듈 설정
			$objBannerMgrModule = new BannerMgrModule($db);
			
			## 기본 설정
			$aryUseLng = explode("/", $S_USE_LNG);
			$intAdminLogin = $_SESSION['ADMIN_LOGIN'];
			$intAdminNo = $_SESSION['ADMIN_NO'];
			$intAdvertiseNo = $_POST['a_no'];

			## 유효성 체크
			if(!$aryUseLng):
				echo "적용할 언어가 없습니다.";
				exit;
			endif;
			if(!$intAdminLogin || !$intAdminNo):
				echo "로그인이 필요합니다.";
				exit;
			endif;
//			if(!$intAdvertiseNo):
//				echo "그룹번호가 없습니다.";
//				exit;
//			endif;			

			## 파일 등록
			require_once MALL_HOME . "/classes/file/file.handler.class.php";
			$file				= new FileHandler();
			$b_file				= "";
			foreach($_FILES as $name => $data):
				if($data['error']) { continue; }
				$aryTemp				= array(		"F_NAME"		=> $name,
														"F_FILTER"		=> "gif;jpg;png",
														"F_SPATH"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/banner/",
														"F_WPATH"		=> "/upload/banner/",
														"F_SFNAME"		=> date("YmdHis") . "_" . $name,
														"F_SECTION"		=> $intB_NO,
														"F_NUM"			=> ""								);
				$re						= $file->getFileUpload($aryTemp);
				$b_file[$name]			= $aryTemp['F_SFNAME'];

				$tempFuncName = strtoupper($name);
				$_POST[$name] = $b_file[$name];
			endforeach;

			## 등록 데이터 만들기
			$param['ARY_USE_LNG']	= $aryUseLng;
			$param['A_NO']			= $intAdvertiseNo;
			$param['B_TITLE']		= $_POST['b_title'];
			$param['B_VIEW']		= $_POST['b_view'];
			$param['B_TYPE']		= $_POST['b_type'];
//			$param['B_START_DT']	= "";
//			$param['B_END_DT']		= "";
//			$param['B_LINK_URL']	= "";
			$param['B_LINK_TYPE']	= $_POST['b_link_type'];
//			$param['B_FILE']		= "";
			$param['B_WIDTH']		= $_POST['b_width'];
			$param['B_HEIGHT']		= $_POST['b_height'];
			$param['B_REG_DT']		= "NOW()";
			$param['B_REG_NO']		= $intAdminNo;
			$param['B_MOD_DT']		= "NOW()";
			$param['B_MOD_NO']		= $intAdminNo;
			
			## 등록 데이터 만들기(언어별 자료)
			foreach($aryUseLng as $lng):
				$lngLow = strtolower($lng);
				$param["B_LINK_URL_{$lng}"] = $_POST["b_link_url_{$lngLow}"];
				$param["B_FILE_{$lng}"] = $_POST["b_file_{$lngLow}"];
			endforeach;

			## 데이터 등록
			$objBannerMgrModule->getBannerMgrInsertEx($param);

			## 배너 파일 생성
			foreach($aryUseLng as $lng):
				makeBannerLayoutFile($lng);
			endforeach;

			## 마무리
			$strMsg		= $LNG_TRANS_CHAR["CS00003"]; //"배너 등록이 성공 되었습니다.";
			$strUrl		= "./?menuType=".$strMenuType."&mode=bannerList&".$strLinkPage;

// 2014.04.30 kim hee sung - old style(프로시저용)
//			## STEP 1.
//			## 파일 등록
//			require_once MALL_HOME . "/classes/file/file.handler.class.php";
//			$file				= new FileHandler();
//			$b_file				= "";
//			foreach($_FILES as $name => $data):
//				if($data['error']) { continue; }
//				$aryTemp				= array(		"F_NAME"		=> $name,
//														"F_FILTER"		=> "gif;jpg;png",
//														"F_SPATH"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/banner/",
//														"F_WPATH"		=> "/upload/banner/",
//														"F_SFNAME"		=> date("YmdHis") . "_" . $name,
//														"F_SECTION"		=> $intB_NO,
//														"F_NUM"			=> ""								);
//				$re						= $file->getFileUpload($aryTemp);
//				$b_file[$name]			= $aryTemp['F_SFNAME'];
//
//				$tempFuncName = strtoupper($name);
//				$bannerMgr->{"set{$tempFuncName}"}($b_file[$name]);
//			endforeach;
//
//			## STEP 4.
//			## 언어별 링크
//			$aryUseLng = explode("/", $S_USE_LNG);
//			foreach($aryUseLng as $lng):
//				$strUrlTemp		= $_POST["b_link_url_".strtolower($lng)];
//				$bannerMgr->{"setB_LINK_URL_{$lng}"}($strUrlTemp);
//			endforeach;	
//
//			## STEP 5.
//			## 쓰기
//			$bannerMgr->setA_NO($intA_NO);
//			$bannerMgr->getInsert($db);
//
//			## STEP 6.
//			## 배너 파일 생성
//			$aryUseLng = explode("/", $S_USE_LNG);
//			foreach($aryUseLng as $lng):
//				makeBannerLayoutFile($lng);
//			endforeach;
//
//			$strMsg		= $LNG_TRANS_CHAR["CS00003"]; //"배너 등록이 성공 되었습니다.";
//			$strUrl		= "./?menuType=".$strMenuType."&mode=bannerList&".$strLinkPage;
			
		break;

			case "bannerDesignWrite":

			## STEP 5.
			## 배너 파일 생성
			$aryUseLng = explode("/", $S_USE_LNG);
			foreach($aryUseLng as $lng):
				makeBannerLayoutFile($lng);
			endforeach;

			$strMsg = "배너 디자인 생성을 완료하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=bannerList&".$strLinkPage;

		break;

		case "bannerModify":
			// 배너 수정

			## 모듈 설정
			$objBannerMgrModule = new BannerMgrModule($db);

			## 기본 설정
			$aryUseLng = explode("/", $S_USE_LNG);
			$intAdminLogin = $_SESSION['ADMIN_LOGIN'];
			$intAdminNo = $_SESSION['ADMIN_NO'];
			$intAdvertiseNo = $_POST['a_no'];
			$intBannerNo = $_POST['b_no'];

			## 유효성 체크
			if(!$aryUseLng):
				echo "적용할 언어가 없습니다.";
				exit;
			endif;
			if(!$intAdminLogin || !$intAdminNo):
				echo "로그인이 필요합니다.";
				exit;
			endif;
			if(!$intBannerNo):
				echo "배너 번호가 없습니다.";
				exit;
			endif;
//			if(!$intAdvertiseNo):
//				echo "그룹번호가 없습니다.";
//				exit;
//			endif;	

			## 데이터 불러오기
			$param = "";
			$param['B_NO'] = $intBannerNo;
			$row = $objBannerMgrModule->getBannerMgrSelectEx("OP_SELECT", $param);

			## 파일 등록
			require_once MALL_HOME . "/classes/file/file.handler.class.php";
			$file				= new FileHandler();
			$b_file				= "";
			foreach($_FILES as $name => $data):
				if($data['error']) { continue; }
				$aryTemp				= array(		"F_NAME"		=> $name,
														"F_FILTER"		=> "gif;jpg;png",
														"F_SPATH"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/banner/",
														"F_WPATH"		=> "/upload/banner/",
														"F_SFNAME"		=> date("YmdHis") . "_" . $name,
														"F_SECTION"		=> $intB_NO,
														"F_NUM"			=> ""								);
				$re						= $file->getFileUpload($aryTemp);
				$b_file[$name]			= $aryTemp['F_SFNAME'];
				$_POST[$name]			= $b_file[$name];
				$_POST["{$name}_del"]	= "Y";
			endforeach;
	
			## 이미지 설정
			foreach($aryUseLng as $lng):
				$lngLow = strtolower($lng);
				$strFile = $row["B_FILE_{$lng}"];
				$strFileDel = $_POST["b_file_{$lngLow}_del"];
				if($strFileDel != "Y"):
					$_POST["b_file_{$lngLow}"] = $row["B_FILE_{$lng}"];
					continue;
				endif;
				if($strFile) { 
					unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/banner/{$strFile}");
				}
			endforeach;

			## 등록 데이터 만들기
			$param['ARY_USE_LNG']	= $aryUseLng;
			$param['B_NO']			= $intBannerNo;
			$param['A_NO']			= $intAdvertiseNo;
			$param['B_TITLE']		= $_POST['b_title'];
			$param['B_VIEW']		= $_POST['b_view'];
			$param['B_TYPE']		= $_POST['b_type'];
//			$param['B_START_DT']	= "";
//			$param['B_END_DT']		= "";
//			$param['B_LINK_URL']	= "";
			$param['B_LINK_TYPE']	= $_POST['b_link_type'];
//			$param['B_FILE']		= "";
			$param['B_WIDTH']		= $_POST['b_width'];
			$param['B_HEIGHT']		= $_POST['b_height'];
//			$param['B_REG_DT']		= "NOW()";
//			$param['B_REG_NO']		= $intAdminNo;
			$param['B_MOD_DT']		= "NOW()";
			$param['B_MOD_NO']		= $intAdminNo;
			
			## 등록 데이터 만들기(언어별 자료)
			foreach($aryUseLng as $lng):
				$lngLow = strtolower($lng);
				$param["B_LINK_URL_{$lng}"] = $_POST["b_link_url_{$lngLow}"];
				$param["B_FILE_{$lng}"] = $_POST["b_file_{$lngLow}"];
			endforeach;

			## 데이터 수정
			$objBannerMgrModule->getBannerMgrUpdateEx($param);

			## 배너 파일 생성
			foreach($aryUseLng as $lng):
				makeBannerLayoutFile($lng);
			endforeach;

			$strMsg = "배너 디자인 수정을 완료하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=bannerList&".$strLinkPage;

// 2014.04.30 kim hee sung old style(프로시저용)
//			## STEP 1.
//			## 파일 등록
//			require_once MALL_HOME . "/classes/file/file.handler.class.php";
//			$file				= new FileHandler();
//			$b_file				= "";
//			foreach($_FILES as $name => $data):
//				if($data['error']) { continue; }
//				$aryTemp				= array(		"F_NAME"		=> $name,
//														"F_FILTER"		=> "gif;jpg;png",
//														"F_SPATH"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/banner/",
//														"F_WPATH"		=> "/upload/banner/",
//														"F_SFNAME"		=> date("YmdHis") . "_" . $name,
//														"F_SECTION"		=> $intB_NO,
//														"F_NUM"			=> ""								);
//				$re						= $file->getFileUpload($aryTemp);
//				$b_file[$name]			= $aryTemp['F_SFNAME'];
//			endforeach;
//
//			## STEP 2.
//			## 기존 데이터 불러오기
//			$bannerMgr->setB_NO($intB_NO);
//			$row = $bannerMgr->getView($db);
//
//			## STEP 3.
//			## 이미지 삭제
//			$aryUseLng = explode("/", $S_USE_LNG);
//			foreach($aryUseLng as $lng):
//				if($_POST["b_file_".strtolower($lng)."_del"] == "Y"):
//					$fileTemp = $row["B_FILE_{$lng}"];
//					unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/banner/{$fileTemp}");
//					$row["B_FILE_{$lng}"] = "";
//				endif;
//			endforeach;
//			
//			## STEP 3.
//			## 파일 체크, 
//			foreach($_FILES as $name => $data):
//				$fileTemp = $row[strtoupper($name)];
//				if($b_file[$name]):
//					if($fileTemp):
//						unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/banner/{$fileTemp}");
//					endif;
//					$fileTemp = $b_file[$name];
//				endif;
//				$tempFuncName = strtoupper($name);
//				$bannerMgr->{"set{$tempFuncName}"}($fileTemp);
//			endforeach;
//
//			## STEP 4.
//			## 언어별 링크
//			$aryUseLng = explode("/", $S_USE_LNG);
//			foreach($aryUseLng as $lng):
//				$strUrlTemp		= $_POST["b_link_url_".strtolower($lng)];
//				$bannerMgr->{"setB_LINK_URL_{$lng}"}($strUrlTemp);
//			endforeach;	
//
//			## STEP 5.
//			## 업데이트
//			$bannerMgr->setA_NO($intA_NO);
//			$bannerMgr->getUpdate($db);
//
//			## STEP 6.
//			## 배너 파일 생성
//			$aryUseLng = explode("/", $S_USE_LNG);
//			foreach($aryUseLng as $lng):
//				makeBannerLayoutFile($lng);
//			endforeach;
//			
//			$strUrl = "./?menuType=".$strMenuType."&mode=bannerModify&b_no=".$intB_NO."&page=".$intPage.$strLinkPage;
		break;
		
		case "bannerDelete":
			$bannerMgr->setB_NO($intB_NO);
			$row = $bannerMgr->getView($db);		

			if ($row[B_FILE]){
				$fh->fileDelete("../upload/banner/".$row[B_FILE]);
			}

			## 2013.04.29
			## 다국어로 파일 삭제
			$aryUseLng = explode("/", $S_USE_LNG);
			foreach($aryUseLng as $lng):
				$fh->fileDelete("../upload/banner/".$row["B_FILE_{$lng}"]);
			endforeach;

			$bannerMgr->getDelete($db);
			
			$strMsg= $LNG_TRANS_CHAR["CS00005"]; //"배너 삭제가 완료되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=bannerList&page=".$intPage.$strLinkPage;
		break;

		case "pointWrite":

			$strGubun	= $_POST["gb"];
			$aryChkNo	= $_POST["chkNo"];

			if (!$strGubun) $strGubun = "1";
			if ($strGubun == "1"){
				$aryChkNo[0] = $intM_NO;
			}

			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
					$intM_NO = $aryChkNo[$i];
					
					$orderMgr->setM_NO($intM_NO);
					if ($strPT_TYPE == "007") {
						$strPT_END_DT = date("Y-m-d");
						$orderMgr->setPT_POINT(-$intPT_POINT);
						$memberMgr->setM_POINT(-$intPT_POINT);
					} else {
						$memberMgr->setM_POINT($intPT_POINT);
					}
					$orderMgr->setPT_END_DT($strPT_END_DT);
					
					$orderMgr->getOrderPointInsert($db);
				
					$memberMgr->setM_NO($intM_NO);
					$memberMgr->getMemberPointUpdate($db);
				}
			}

			$strUrl = "./?menuType=member&mode=popMemberPointWrite";
			if ($strGubun == "1") $strUrl .= "&memberNo=".$intM_NO;
			else {
				goLayerPopClose("포인트가 적립/차감 되었습니다.");
				$db->disConnect();
				exit;
			}
		
		break;

	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);

	## 함수 모음 ##


	function makeBannerGrpInfoFile(&$rowTemp)
	{

		/* 기본정보 */
		$file = "../conf/banner.inc.php";

		@chmod($file,0707);

		$fw = fopen($file, "w");

		fwrite($fw, "<?\n");
		fwrite($fw, "	/*################ 일반배너 설정 정보 ################*/	\n\n\n");

		while($alRow = mysql_fetch_array($rowTemp))
		{
			$intA_NO			= $alRow[A_NO];
			$strA_NAME			= $alRow[A_NAME];
			$strA_TAG			= $alRow[A_TAG];
			$strA_LOCA			= $alRow[A_LOCA];
			$strA_TABLE_W		= (!$alRow[A_TABLE_W]) ? 0 : $alRow[A_TABLE_W];
			$strA_TABLE_H		= (!$alRow[A_TABLE_H]) ? 0 : $alRow[A_TABLE_H];
			$strA_SIZE_W		= (!$alRow[A_SIZE_W]) ? 0 : $alRow[A_SIZE_W];
			$strA_SIZE_H		= (!$alRow[A_SIZE_H]) ? 0 : $alRow[A_SIZE_H];
			$strA_MARGIN_W		= (!$alRow[A_MARGIN_W]) ? 0 : $alRow[A_MARGIN_W];
			$strA_MARGIN_H		= (!$alRow[A_MARGIN_H]) ? 0 : $alRow[A_MARGIN_H];

			fwrite($fw, "	/*$intA_NO*/																\n");
			fwrite($fw, "	\$ARR_BANNER_GRP_INFO[$intA_NO][A_NAME] = \"$strA_NAME\";					\n");
			fwrite($fw, "	\$ARR_BANNER_GRP_INFO[$intA_NO][A_TAG] = \"$strA_TAG\";						\n");
			fwrite($fw, "	\$ARR_BANNER_GRP_INFO[$intA_NO][A_LOCA] = \"$strA_LOCA\";					\n");
			fwrite($fw, "	\$ARR_BANNER_GRP_INFO[$intA_NO][A_TABLE_W] = $strA_TABLE_W;					\n");
			fwrite($fw, "	\$ARR_BANNER_GRP_INFO[$intA_NO][A_TABLE_H] = $strA_TABLE_H;					\n");
			fwrite($fw, "	\$ARR_BANNER_GRP_INFO[$intA_NO][A_SIZE_W] = $strA_SIZE_W;					\n");
			fwrite($fw, "	\$ARR_BANNER_GRP_INFO[$intA_NO][A_SIZE_H] = $strA_SIZE_H;					\n");
			fwrite($fw, "	\$ARR_BANNER_GRP_INFO[$intA_NO][A_MARGIN_W] = $strA_MARGIN_W;				\n");
			fwrite($fw, "	\$ARR_BANNER_GRP_INFO[$intA_NO][A_MARGIN_H] = $strA_MARGIN_H;				\n");
			fwrite($fw, "																				\n");
			fwrite($fw, "																				\n");
			
		} // while

		fwrite($fw, "?>\n");
		fclose($fw);
	}


function makeBannerLayoutFile($lng) {
	
	global $S_DOCUMENT_ROOT, $S_SHOP_HOME, $db, $bannerMgr;
	
	$advertiseRow = $bannerMgr->getAdvertiseListAll($db);

	while($aRow = mysql_fetch_array($advertiseRow)):
		

		$htmlTag			= "";
		$intCountW			= 0;
		$intA_NO			= $aRow['A_NO'];
		if(!$aRow['A_TABLE_W']) { $aRow['A_TABLE_W'] = 1; } $intA_TABLE_W = $aRow['A_TABLE_W']; // 가로 td 개수
		if(!$aRow['A_TABLE_H']) { $aRow['A_TABLE_H'] = 1; } $intA_TABLE_H = $aRow['A_TABLE_H']; // 세로 tr 개수
		$intLIMIT			= $intA_TABLE_W * $intA_TABLE_H;

		$intA_MARGIN_W		= ($aRow['A_MARGIN_W']) ? $aRow['A_MARGIN_W'] : 0;	// 가로 마진
		$intA_MARGIN_H		= ($aRow['A_MARGIN_H']) ? $aRow['A_MARGIN_H'] : 0;  // 세로 마진
		$strMarginW			= "padding-right:{$aRow['A_MARGIN_W']}px;";
		$strMarginH			= "padding-bottom:{$aRow['A_MARGIN_H']}px;";

		$tagImgSizeW		= (!$aRow['A_SIZE_W']) ? "" : sprintf(" width=\"%dpx\"",$aRow['A_SIZE_W']); ;
		$tagImgSizeH		= (!$aRow['A_SIZE_H']) ? "" : sprintf(" height=\"%dpx\"",$aRow['A_SIZE_H']); ;

		/* 배너 이미지 리스트 호출 */
		$bannerMgr->setA_NO($intA_NO);
		$bannerMgr->setPageLine($intLIMIT);
		$bannerRow			= $bannerMgr->getBannerListForAdvertise($db);
		$intBannerTotal		= mysql_num_rows($bannerRow);
		/* 배너 이미지 리스트 호출 */

		while($bRow = mysql_fetch_array($bannerRow)):

			## STEP 1.
			## 이미지 설정
			$file	= $bRow["B_FILE_{$lng}"];
			if(!file) { continue; }
			$file	= "/upload/banner/$file";

			//$tag	= "<img src='{$file}' />";
			$tag	= sprintf("<img src=\"%s\"%s%s/>", $file, $tagImgSizeW, $tagImgSizeH);


			## STEP 2.
			## 링크 설정
			$url	= $bRow["B_LINK_URL_{$lng}"];
			if($bRow['B_LINK_TYPE'] == 1):
				$tag = "<a href='{$url}' target='_blank'>{$tag}</a>";
			elseif($bRow['B_LINK_TYPE'] == 2):
				$tag = "<a href='{$url}' target='_self'>{$tag}</a>";
			endif;

			## STEP 3.
			## margin 설정
			$strMargin	= "";
			if(($intCountW % $intA_TABLE_W) != $intA_TABLE_W - 1):
				$strMargin = $strMargin . $strMarginW;
			endif;
			if(ceil(($intCountW+1) / $intA_TABLE_W) != $intA_TABLE_H):
				$strMargin = $strMargin . $strMarginH;
			endif;

			## STEP 4.
			## <td> 설정
			$intCountW	= $intCountW + 1;
			$tag		= "<td style='{$strMargin}'>{$tag}</td>\n";
			$htmlTag	= $htmlTag . $tag;
			

			## STEP 5.
			## <tr> 설정
			if($intCountW == 1):
				// 시작 태그
				$htmlTag = "<tr>\n{$htmlTag}";
			endif;

			if(($intCountW) == $intBannerTotal):
				// 마지막 태그
				$htmlTag = "{$htmlTag}</tr>\n";
			else:
				if(($intCountW % $intA_TABLE_W) == 0):
					// 중간 태그
					$htmlTag = "{$htmlTag}</tr>\n<tr>\n";		
				endif;
			endif;

		endwhile;
		
		$htmlTag = "<table>\n{$htmlTag}</table>";

		if($aRow['A_USE'] == "N") { $htmlTag = ""; } // 배너 사용 안함.

		/* 파일 생성 */
		$fileName	= sprintf( "%s%s/layout/banner/%s/banner_%d.html.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($lng), $intA_NO );	
		$fw			= fopen($fileName, "w");
		fwrite($fw, $htmlTag);	
		fclose($fw);
		@chmod($file,0707);
		/* 파일 생성 */			
	endwhile;
}

// 2013.05.22 소스 정리
// tr 테크 오류 있음.
//function makeBannerLayoutFile_1($lng)
//{
//		global $S_DOCUMENT_ROOT, $S_SHOP_HOME, $db, $bannerMgr;
//
//		$advertiseRow = $bannerMgr->getAdvertiseListAll($db);
//
//		while($aRow = mysql_fetch_array($advertiseRow)) :
//
//			$intA_NO			= $aRow['A_NO'];	
//			$intA_TABLE_W		= ($aRow[A_TABLE_W] == 0) ? 1 : $aRow[A_TABLE_W];		$intCountW = 1;
//			$intA_TABLE_H		= ($aRow[A_TABLE_H] == 0) ? 1 : $aRow[A_TABLE_H];		$intCountH = 1;
//			$intLIMIT			= $intA_TABLE_W * $intA_TABLE_H;
//			$intA_MARGIN_W		= ($aRow[A_MARGIN_W]) ? $aRow[A_MARGIN_W] : 0;	
//			$intA_MARGIN_H		= ($aRow[A_MARGIN_H]) ? $aRow[A_MARGIN_H] : 0;
//			$strStyle			= "style='padding-right:".$intA_MARGIN_W."px;padding-bottom:".$intA_MARGIN_H."px;'";
//
//			$tagImgSizeW		= (!$aRow['A_SIZE_W']) ? "" : sprintf(" width=\"%dpx\"",$aRow['A_SIZE_W']); ;
//			$tagImgSizeH		= (!$aRow['A_SIZE_H']) ? "" : sprintf(" height=\"%dpx\"",$aRow['A_SIZE_H']); ;
//			
//			$strMarginW			= sprintf("padding-right:%spx;",$aRow['A_MARGIN_W']);
//			$strMarginH			= sprintf("padding-bottom:%spx;",$aRow['A_MARGIN_H']);
//			/* 배너 이미지 리스트 호출 */
//			$bannerMgr->setA_NO($intA_NO);
//			$bannerMgr->setPageLine($intLIMIT);
//			$bannerRow			= $bannerMgr->getBannerListForAdvertise($db);
//			$intBannerTotal		= mysql_num_rows($bannerRow);
//			/* 배너 이미지 리스트 호출 */
//			
//			$aryTarget	= array(1 => " target=\"_blank\"",2 => " target=\"_self\"");
//			$tagTd		= "";
//			$tagTr		= "";
//			$intCnt		= 0;
//			while($bRow = mysql_fetch_array($bannerRow)) :
//
//				if($bRow["B_FILE_{$lng}"]) :
//					// 이미지 생성
//					$tagfls		= sprintf("<script type=\"text/javascript\">insertFlash('/upload/banner/%s', '%d', '%d', '', '', '');</script>", $bRow["B_FILE_{$lng}"], $bRow['B_WIDTH'], $bRow['B_HEIGHT']);
//					$tagImg		= sprintf("<img src=\"/upload/banner/%s\"%s%s/>", $bRow["B_FILE_{$lng}"], $tagImgSizeW, $tagImgSizeH);				
//		
//					/* 링크 설정 */
//					if($bRow['B_LINK_TYPE'] != 4) :
//						$tagImg		= sprintf("<a href=\"%s\"%s>%s</a>", $bRow["B_LINK_URL_{$lng}"], $aryTarget[$bRow['B_LINK_TYPE']], $tagImg);
//					endif;
//					/* 링크 설정 */
//
//					/* margin 설정 */
//					if(($intBannerTotal-1) == $intCnt) :
//						// 마지막 단계에서 실행
//						$strMarginH = "";
//					endif;
//
//					if($intCountW == $intA_TABLE_W) :
//						// 마지막 단계에서 실행
//						$strMarginW = "";
//					endif;
//
//					$strMargin = sprintf(" style=\"%s%s\"", $strMarginW, $strMarginH);
//					$intCnt++;
//					/* margin 설정 */
//
//
//					/* 플래시 / 이미지 설정 */
//					if($bRow[B_TYPE] == 'F') :
//						$tagTd		= sprintf("%s<td%s>%s</td>", $tagTd, $strMargin, $tagfls);
//					else :
//						$tagTd		= sprintf("%s<td%s>%s</td>", $tagTd, $strMargin, $tagImg);
//					endif;
//
//
//					/* 플래시 / 이미지 설정 */
//					if($intCountW == $intA_TABLE_W) :
//						$tagTr		= sprintf("%s  <tr>%s</tr>\r\n", $tagTr, $tagTd);
//						$tagTd		= "";
//						$intCountW	= 1;
//						continue;
//					endif;
//										
//					$intCountW++;
//
//				endif;
//				
//			endwhile;
//		
//			$tagTable = sprintf("<table>\r\n%s</table>", $tagTr);	
//			if($aRow['A_USE'] == "N") :
//				$tagTable = "";
//			endif;
//
//
//			/* 파일 생성 */
//			$fileName	= sprintf( "%s%s/layout/banner/%s/banner_%d.html.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($lng), $intA_NO );	
//			$fw			= fopen($fileName, "w");
//			fwrite($fw, $tagTable);	
//			fclose($fw);
//			@chmod($file,0707);
//			/* 파일 생성 */
//
//		endwhile;
//
//	}
?>