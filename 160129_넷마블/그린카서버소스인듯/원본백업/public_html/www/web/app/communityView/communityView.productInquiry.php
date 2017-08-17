<?
require_once MALL_CONF_LIB."CateMgr.php";
require_once MALL_CONF_LIB."ProductMgr.php";

$productMgr		= new ProductMgr();
$cateMgr		= new CateMgr();


//print_r($prodRow);
$strMenuType = 'community';




$EUMSHOP_APP_INFO['bCode'] = "PROD_QNA";

//$strAppMode = "prodInquiryWrite";
$strAppMode = "communityWrite";
$strAppSkin = "productInquiry";
		## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "COMMUNITY_VIEW_{$intAppID}";
	endif;

	## 모듈 설정
	$objBoardFileModule = new BoardFileModule($db);
	$objBoardDataModule = new BoardDataModule($db);

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/communityView/communityView.dataBasicSkin.js";

	

	## 기본 설정
	$strAppBCode = $EUMSHOP_APP_INFO['bCode'];
	$intAppUbNo = $EUMSHOP_APP_INFO['ubNo'];
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	$strAppLang = $S_SITE_LNG;
	$strAppLangLower = strtolower($strAppLang);
	//$strAppBCodeLower = strtolower($strAppBCode);
	$strCommunityCateDir = MALL_SHOP . "/conf/community/category/{$strAppLangLower}";
	$strCommunityCateFile = "category.{$strAppBCode}.info.php"; 
	$intMemberNo = $g_member_no;
	$strMemberGroup = $g_member_group;
	$strCommunityTempWebDir = "/upload/community/temp";
	$strCommunityTempDefaultDir = MALL_SHOP . $strCommunityTempWebDir;
	$arySessionFileList = $_SESSION["FILE"];
	$strEditorDir = "community/{$strAppBCodeLower}";
	

	## 커뮤니티 보드 설정
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	if(!$aryAppBoardInfo){
		include_once rtrim(MALL_SHOP, '/') . "/conf/community/{$strLangLower}/board.{$strAppBCode}.info.php";
		$aryAppBoardInfo = $BOARD_INFO[$strAppBCode];
		include_once rtrim(MALL_SHOP, '/') . "/conf/community/{$strLangSLower}/board.{$strAppBCode}.info.php";
		$aryAppBoardInfoS = $BOARD_INFO[$strAppBCode];
		foreach($aryAppBoardInfoS as $key => $data){
			$strTemp = $aryAppBoardInfo[$key];
			if($strTemp) { continue; }
			$aryAppBoardInfo[$key] = $data;
		}
	}

	## 체크
	if(!$strAppBCode):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "b_code가 없습니다.";
		getDebug($param);
		return;
	endif;
	if(!$aryAppBoardInfo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "boardInfo가 없습니다.";
		getDebug($param);
		return;		
	endif;
	if(!$intAppUbNo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "ubNo가 없습니다.";
		getDebug($param);
		return;		
	endif;

	## 언어 설정
	$strLang = $S_SITE_LNG;
	$strLangS = $S_ST_LNG;
	$strLangLower = strtolower($strLang);
	$strLangSLower = strtolower($strLangS);

	$strBI_USERFIELD_USE = $aryAppBoardInfo['BI_USERFIELD_USE']; // 추가필드 사용 - 사용 = Y, 사용안함 = N

	## 커뮤니티 카테고리 설정 파일
	include_once "{$strCommunityCateDir}/{$strCommunityCateFile}";
	$aryCategoryList = $CATEGORY_LIST;

	## 커뮤니티 설정
	$strBI_START_MODE = $aryAppBoardInfo['BI_START_MODE']; 
	$strB_KIND_SKIN = $aryAppBoardInfo['B_KIND_SKIN']; 
	$strB_CSS = $aryAppBoardInfo['B_CSS'];
	$strBI_DATAWRITE_FORM = $aryAppBoardInfo['BI_DATAWRITE_FORM'];
	$strBI_CATEGORY_USE = $aryAppBoardInfo['BI_CATEGORY_USE'];
	$strBI_DATAWRITE_LOCK_USE = $aryAppBoardInfo['BI_DATAWRITE_LOCK_USE']; // 비밀글 사용 - 사용자선택 = C, 무조건 = E
	$aryBI_DATALIST_FIELD_USE = $aryAppBoardInfo['BI_DATALIST_FIELD_USE']; // 목록항목 표시 여부
	$aryBI_DATALIST_WRITER_SHOW = $aryAppBoardInfo['BI_DATALIST_WRITER_SHOW']; // 작성자 표시 항목
	$intBI_DATALIST_WRITER_HIDDEN = $aryAppBoardInfo['BI_DATALIST_WRITER_HIDDEN'];
	$strBI_DATAWRITE_USE = $aryAppBoardInfo['BI_DATAVIEW_USE']; // 글보기권한(모든회원/비회원-A, 회원전용-M)
	$aryBI_DATAWRITE_MEMBER_AUTH = $aryAppBoardInfo['BI_DATAVIEW_MEMBER_AUTH'];
	$intBI_ATTACHEDFILE_USE = $aryAppBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
	$aryBI_ATTACHEDFILE_NAME = $aryAppBoardInfo['BI_ATTACHEDFILE_NAME']; // 첨부파일 이름
	$aryBI_ATTACHEDFILE_KEY = $aryAppBoardInfo['BI_ATTACHEDFILE_KEY']; // 첨부파일 키

	## 사용권한 체크
	if($strBI_DATAWRITE_USE == "M"): // 회원전용인경우
		if(!$intMemberNo):
			goUrl("", "./?menuType=member&mode=login");
			return;		
		endif;
		if(!in_array($strMemberGroup, $aryBI_DATAWRITE_MEMBER_AUTH)):
			goErrMsg($LNG_TRANS_CHAR["MS00102"]); // 게시판을 사용하실 권한이 없습니다.\\n고객센터로 문의하시기 바랍니다.
			return;
		endif;
	endif;

	## 데이터 불러오기
	$param = "";
	$param['B_CODE'] = $strAppBCode;
	$param['UB_NO'] = $intAppUbNo;
	$param['JOIN_MM'] = "Y";
	$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);

	## 데이터 기본 설정
	$strUB_TITLE = $aryBoardDataRow['UB_TITLE'];
	$strUB_NAME = $aryBoardDataRow['UB_NAME'];
	$intUB_M_NO = $aryBoardDataRow['UB_M_NO'];
	$strUB_M_ID = $aryBoardDataRow['UB_M_ID'];
	$strUB_TITLE = $aryBoardDataRow['UB_TITLE'];
	$strUB_REG_DT = $aryBoardDataRow['UB_REG_DT'];
	$intUB_READ = $aryBoardDataRow['UB_READ'];
	$intUB_P_GRADE = $aryBoardDataRow['UB_P_GRADE'];
	$intUB_BC_NO = $aryBoardDataRow['UB_BC_NO'];
	$strUB_TEXT = $aryBoardDataRow['UB_TEXT'];
	$strUB_MAIL = $aryBoardDataRow['UB_MAIL'];
	$strUB_PASS = $aryBoardDataRow['UB_PASS'];
	$strUB_FUNC = $aryBoardDataRow['UB_FUNC'];
	$strP_CODE	= $aryBoardDataRow['UB_P_CODE'];
	$strAppPCode	= $aryBoardDataRow['UB_P_CODE'];

	$productMgr->setP_LNG($S_SITE_LNG);
	$productMgr->setP_CODE($strP_CODE);
	$prodRow = $productMgr->getProdView($db);


	$strPM_REAL_NAME = $prodRow[PM_REAL_NAME];
	$strP_NAME = $prodRow[P_NAME ];
	$strP_ORIGIN  = $prodRow[P_ORIGIN];
	$strP_CATE  = substr($prodRow[P_CATE],0,3);
	$EUMSHOP_APP_INFO['pCode'] = $strP_CODE;


	## 작성자 권한 체크
	$isModify = false;
	$isDelete = false;
	if($intUB_M_NO): 
		##회원글
		if($intMemberNo && $intMemberNo == $intUB_M_NO):
			$isModify = true;
			$isDelete = true;
		endif;
	else: 
		##비회원글
		$isModify = true;
		$isDelete = true;
	endif;

	## 답변권환 설정
	## 공지글은 답변을 달 수 없습니다.
	$isAnswer = false;
	if($strBI_DATAANSWER_USE == "A") { $isAnswer = true; }
	if($strBI_DATAANSWER_USE == "M"):
		if($intMemberNo && in_array($strMemberGroup, $aryBI_DATAANSWER_MEMBER_AUTH)):
			$isAnswer = true;
		endif;
	endif;
	if($strFuncNotice == "Y") { $isAnswer = false; }


	## 작성자(성명) 설정
	if($intBI_DATALIST_WRITER_HIDDEN):		
		$strUB_NAME = strHanCutUtf2($strUB_NAME, $intBI_DATALIST_WRITER_HIDDEN, false, "***");
	endif;					

	## 아이디 설정
	if(!$strUB_M_ID) { $strUB_M_ID = "guest"; }
	if($intBI_DATALIST_WRITER_HIDDEN):
		$strUB_M_ID = strHanCutUtf2($strUB_M_ID, $intBI_DATALIST_WRITER_HIDDEN, false, "***");
	endif;	

	## 닉네임 설정
	if(!$strMM_NICK_NAME) { $strMM_NICK_NAME = $LNG_TRANS_CHAR["MW00100"]; /* 손님 */ }
	if($intBI_DATALIST_WRITER_HIDDEN):
		$strMM_NICK_NAME = strHanCutUtf2($strMM_NICK_NAME, $intBI_DATALIST_WRITER_HIDDEN, false, "***");
	endif;	

	## 작설일 설정
	$strRegDate = date("Y.m.d H:i:s", strtotime($strUB_REG_DT));

	## 조회수 설정
	$strUB_READ = number_format($intUB_READ);

	## 카테고리 설정
	$strCategoryName = $aryCategoryList[$intUB_BC_NO]['bc_name'];
	
	## 목록 설정
	$aryAppColumn = "";
	$aryAppColumn[] = "제목";
	if($aryBI_DATALIST_FIELD_USE[0] == "Y") { $aryAppColumn[] = "번호"; }
	if($aryBI_DATALIST_FIELD_USE[1] == "Y") { $aryAppColumn[] = "작성자"; }
	if($aryBI_DATALIST_FIELD_USE[2] == "Y") { $aryAppColumn[] = "등록일"; }
	if($aryBI_DATALIST_FIELD_USE[3] == "Y") { $aryAppColumn[] = "조회수"; }
	if($aryBI_DATALIST_FIELD_USE[4] == "Y") { $aryAppColumn[] = "점수"; }
	if($aryBI_DATALIST_FIELD_USE[5] == "Y") { $aryAppColumn[] = "카테고리"; }
	if($aryBI_DATALIST_FIELD_USE[6] == "Y") { $aryAppColumn[] = "리스트이미지"; }

	## 작성자 설정
	if(in_array("작성자", $aryAppColumn)):
		if($aryBI_DATALIST_WRITER_SHOW[0] == "Y") { $aryAppColumn[] = "성명"; }
		if($aryBI_DATALIST_WRITER_SHOW[1] == "Y") { $aryAppColumn[] = "아이디"; }
		if($aryBI_DATALIST_WRITER_SHOW[2] == "Y") { $aryAppColumn[] = "닉네임"; }
	endif;

	## 작성자/조회수 컬럼 설정
	$intWriteColspan = 1;
	if(!in_array("작성자",$aryAppColumn)) { $intWriteColspan += 2; }
	if(!in_array("조회수",$aryAppColumn)) { $intWriteColspan += 2; }
	if($intWriteColspan < 5) { $aryAppColumn[] = "작성자,조회수"; }

	## 글보기 네비게이션 설정
	if($strBI_DATAVIEW_NEXTPRVE_USE == "Y") { $aryAppColumn[] = "이전/다음"; }

	## 이전
	$param = "";
	$param['B_CODE'] = $strAppBCode;
	$param['UB_NO_LAB'] = $intAppUbNo;
	$param['UB_LNG'] = $strAppLang;
	$param['ORDER_BY'] = "reg_dt_desc";
	$param['LIMIT_END'] = 1;
	$aryBoardDataPrveRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
	$intPrveDataUB_NO = $aryBoardDataPrveRow['UB_NO'];
	$strPrveDataUB_TITLE = $aryBoardDataPrveRow['UB_TITLE'];
	if(!$strPrveDataUB_TITLE) { $strPrveDataUB_TITLE = $LNG_TRANS_CHAR["MS00109"]; /* 첫번째 내용입니다. */ }

	## 다음
	$param = "";
	$param['B_CODE'] = $strAppBCode;
	$param['UB_NO_RAB'] = $intAppUbNo;
	$param['UB_LNG'] = $strAppLang;
	$param['ORDER_BY'] = "reg_dt_asc";
	$param['LIMIT_END'] = 1;
	$aryNextDataNextRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
	$intNextDataUB_NO = $aryNextDataNextRow['UB_NO'];
	$strNextDataUB_TITLE = $aryNextDataNextRow['UB_TITLE'];
	if(!$strNextDataUB_TITLE) { $strNextDataUB_TITLE = $LNG_TRANS_CHAR["MS00110"]; /* 마지막 내용입니다. */ }

	## 페이스북 사용유무
	$isFacebookUse = false;
	if($strSiteFacebook == "Y" && $strBI_DATAVIEW_FACEBOOK_USE == "Y"):
		if($strSiteFacebookAppID && $strSiteFacebookSecret):
			$isFacebookUse = true;
		endif;
	endif;
	if($isFacebookUse):

		## facebook script 정보
		$aryFacebookInfo['APP_ID'] = $strSiteFacebookAppID;
//		$aryFacebookInfo['SECRET'] = $strSiteFacebookSecret;
		$aryFacebookInfo['NAME'] = $strUB_TITLE;
		$aryFacebookInfo['LINK'] = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";
		$aryFacebookInfo['PICTURE'] = "http://{$S_HTTP_HOST}{$S_WEB_LOGO_IMG}";
		$aryFacebookInfo['CAPTION'] = $S_SITE_NM;
		$aryFacebookInfo['DESCRIPTION'] = $S_SITE_URL;

		## script data 만들기
		$aryAppParam['FACEBOOK'] = $aryFacebookInfo;
		$aryScriptData['APP'][$strAppID] = $aryAppParam;	

		## 스크립트 설정
		$aryScriptEx[] = "http://connect.facebook.net/en_US/all.js";
		$aryScriptEx[] = "/common/js/classes/sns/snsClass.js";	
	endif;

	## 내용 설정
	## 모바일에서 글작성을 하면, html 편집기로 작성을 하지 않기 때문에, 엔터값(\n) 을 br 테그로 변환 해줘야 합니다.
	if($strFuncText == "Y"):
		$strUB_TEXT = strConvertCut2($strUB_TEXT, 0, "N");
	endif;

	## 트위터 사용유무
	$isTwitterUse = false;
	if($strSiteTwitter == "Y" && $strBI_DATAVIEW_TWITTER_USE == "Y") { $isTwitterUse = true; }

	## 첨부파일 불러오기
	$param = "";
	$param['B_CODE'] = $strAppBCode;
	$param['FL_UB_NO'] = $intAppUbNo;
	$aryBoardFileList = $objBoardFileModule->getBoardFileSelectEx("OP_ARYTOTAL", $param);
	
	## 첨부파일 설정
	$aryBoardFile = "";
	if($aryBoardFileList):
		foreach($aryBoardFileList as $key => $row):
			
			## 기본설정
			$strFL_KEY = $row['FL_KEY'];

			## 만들기
			$aryBoardFile[$strFL_KEY][] = $row;

		endforeach;
	endif;

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
	$aryLanguage['PS00018']	= $LNG_TRANS_CHAR['PS00018']; // 삭제하시겠습니까?

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['B_CODE'] = $strAppBCode;
	$aryAppParam['UB_NO'] = $intAppUbNo;
	$aryAppParam['UB_M_NO'] = $intUB_M_NO;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;	

	## 상품카테고리 
	$cateMgr->setCL_LNG($S_SITE_LNG);
	$cateMgr->setC_LEVEL(1);
	$aryCategorys1 = $cateMgr->getCateLevelAry($db);
	for($i = 0; $i < sizeof($aryCategorys1); $i++){
		$aryCateNames1[$aryCategorys1[$i][CATE_CODE]] = $aryCategorys1[$i][CATE_NAME];
	}
	//국가
	$aryCountryList		= getCountryList();			
	$aryCountryState	= getCommCodeList("STATE","");

	$strProdViewLink = './?menuType=product&mode=view&prodCode='.$strP_CODE;
?>
<div id="<?php echo $strAppID?>" class="popProdInquiryBox">
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.<?php echo $strB_CSS;?>.css"/>
	<div class="prodInquiryWrap">
		<form name="writeForm" id="tx_editor_form" method="post" enctype="multipart/form-data" action="./">
		<input type="hidden" name="menuType" value="<?php echo $strMenuType;?>">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="act" value="">
		<input type="hidden" name="b_code" value="<?php echo $strAppBCode;?>">
		<input type="hidden" name="ub_lng" value="<?php echo $strLang;?>">
		<input type="hidden" name="ub_p_code" value="<?php echo $strAppPCode;?>">
		<input type="hidden" name="editorDir" value="<?php echo $strEditorDir;?>">
		<h3 class="qnaTit"><span class="txt_red">Q</span> <?= $LNG_TRANS_CHAR["PW00106"]; //문의사항입니다. ?></h3>
		<div class="tableBox">
			<table class="prodInquiryTable">
				<tr class="inquiryRow">
					<th><?= $LNG_TRANS_CHAR["PW00107"]; //문의제품 ?>	</th>
					<td>
					
						<ul>
							<li class="prodImg"><a href="<?=$strProdViewLink?>"><img src="<?php echo $strPM_REAL_NAME;?>" class="listProdImg"/></a></li>
							<li class="prodInfo">
								<p class="title"><a href="<?=$strProdViewLink?>"><?=$strP_NAME?></a></p>
								<p class="info"><a href="<?=$strProdViewLink?>"><span><?= $LNG_TRANS_CHAR["PW00028"]; //원산지 ?></span> <strong><?php echo $aryCountryList[$strP_ORIGIN]?></strong></a></p>
								<p class="info"><a href="<?=$strProdViewLink?>"><span><?= $LNG_TRANS_CHAR["SW00010"]; //카테고리 ?></span> <strong><?php echo $aryCateNames1[$strP_CATE]?></strong></a></p>
							</li>
						</ul>
					</td>
				</tr>

				<tr>
					<th>	<?php echo $LNG_TRANS_CHAR["CW00062"];//제목?></th>
					<td><?=$strUB_TITLE?></td>
				</tr>

				<tr>
					<th>	<?php echo $LNG_TRANS_CHAR["CW00063"];//내용?></th>
					<td><?=$strUB_TEXT?>
					</td>
				</tr>
				<?php

		## 모듈 설정
		$objBoardAddFieldModule = new BoardAddFieldModule($db);

		## 체크
		if(!$strAppBCode) { return; }
		if(!$intAppUbNo) { return; }

		## 커뮤니티 설정
		$strAppLang = $S_SITE_LNG;
		$strBI_USERFIELD_USE = $aryAppBoardInfo['BI_USERFIELD_USE']; // 추가필드 사용 - 사용 = Y, 사용안함 = N

		## 추가필드 사용유무 설정
		if($strBI_USERFIELD_USE != "Y") { return; }

		## 데이터 불러오기
		$param = "";
		$param['B_CODE'] = $strAppBCode;
		$param['AD_UB_NO'] = $intAppUbNo;
		$aryBoardAddDataRow = $objBoardAddFieldModule->getBoardAddFieldSelectEx("OP_SELECT", $param);

		## 추가필드 배열 만들기
		$aryUserfieldSort = "";
		$aryUserfieldList = "";
		foreach($aryAppBoardInfo as $key => $data):
			
			## 기본설정
			$aryTemp = "";
			$aryTemp = explode("_", $key);
			$intTempCnt = sizeof($aryTemp);
			if($intTempCnt == 4): 
				$strTemp1 = $aryTemp[0];
				$strTemp2 = $aryTemp[1];
				$strTemp3 = $aryTemp[2];
				$strTemp4 = $aryTemp[3];
			elseif($intTempCnt == 5):
				$strTemp1 = $aryTemp[0];
				$strTemp2 = $aryTemp[1];
				$strTemp3 = $aryTemp[2];
				$strTemp4 = "{$aryTemp[3]}_{$aryTemp[4]}";
			endif;

			## 체크
			if($key == "BI_USERFIELD_USE") { continue; }
			if($strTemp2 != "AD") { continue; }
			

			## 추가필드 배열 만들기
			$aryUserfieldList[$strTemp3][$strTemp4] = $data;

			## 정렬 설정
			if($strTemp4 != "SORT") { continue; }
			$aryUserfieldSort[$strTemp3] = $data;

		endforeach;

		## 정렬
		//asort($aryUserfieldSort);
	?>
	<?php foreach($aryUserfieldSort as $key => $data):

			## 기본 설정
			$strKeyLower =strtolower($key);
			$aryData = $aryUserfieldList[$key];
			$strESSENTIAL = $aryData['ESSENTIAL']; // 필수 입력
			$strKIND = $aryData['KIND'];
			$strNAME = $aryData['NAME'];
			$strAddTemp[$key]['NAME'] = $aryData['NAME'];
			$strONLYADMIN = $aryData['ONLYADMIN'];
			$strUSE = $aryData['USE'];
			$strKIND_DATA = $aryData['KIND_DATA'];
			$strKIND_DEFAULT = $aryData['KIND_DEFAULT'];
			$aryCheck = "";
			$isUserAddField = false;

			## 체크
			if($strUSE != "Y") { continue; }
			if($strONLYADMIN == "Y") { continue; }

			## 데이터 불러오기
			if($key != "ADDR1"):
				$strValue = $aryBoardAddDataRow["AD_{$key}"];
				$strAddTemp[$key]['VALUE'] = $strValue;
				if($strValue) { $isUserAddField = true; };
			else:
				$strZip = $aryBoardAddDataRow["AD_ZIP"];
				$strAddr1 = $aryBoardAddDataRow["AD_ADDR1"];
				$strAddr2 = $aryBoardAddDataRow["AD_ADDR2"];	
				if($strZip && $strAddr1 && $strAddr2) { $isUserAddField = true; };
			endif;

			## 출력 여부 설정
			if(!$isUserAddField) { continue; }
			
	endforeach;
	?>
				<?php if($strAddTemp['TEMP1']['VALUE']){ ?>}
				<tr>
					<th class="name"><?= $LNG_TRANS_CHAR["OW00003"]; // 수량 ?><!--<?php echo $strAddTemp['TEMP1']['NAME'];?>--></th>
					<td colspan="3"><?php if($key != "ADDR1"):?>
						<?php// echo $strValue;?>
						<?php echo  $strAddTemp['TEMP1']['VALUE'];//수량?>
						<?php echo '('.$strAddTemp['TEMP2']['VALUE'].')';//단위?>
						<?php else:?>
						<p><?php echo $strZip;?></p>
						<p><?php echo $strAddr1;?></p>
						<p><?php echo $strAddr2;?></p>
						<?php endif;?>
					</td>
				</tr>
	<? }?>
			</table>
		</div>
		</form>
	</div>
	
	<?
	## 데이터 불러오기

	$strAppANSNo	= $aryBoardDataRow['UB_ANS_NO'];


	## 데이터 불러오기
	$param = "";
	$param['B_CODE'] = $strAppBCode;
	$param['UB_ANS_NO'] = $strAppANSNo;
	$param['UB_ANS_DEPTH'] = 2;
	
	$param['JOIN_MM'] = "Y";
	$aryANSBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
	if($aryANSBoardDataRow){
	?>
	<div class="prodInquiryWrap">
		<h3 class="qnaTit"><span class="txt_org">A</span> 문의에 대한 답변입니다.</h3>
			<div class="tableBox">
			<table>
				<tr>
					<th><?= $LNG_TRANS_CHAR["CW00062"]; //제목 ?></th>
					<td><?=$aryANSBoardDataRow[UB_TITLE];?></td>
				</tr>
				<tr>
					<th><?= $LNG_TRANS_CHAR["CW00063"]; //내용 ?></th>
					<td><?=$aryANSBoardDataRow[UB_TEXT];?></td>
				</tr>
			</table>
		</div>
	</div>
	<?}?>
	<div class="btnRight prodInquiryBtnWrap right">
		<?php if($isAnswer):?>
		<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinReplyMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write"><strong><?php echo $LNG_TRANS_CHAR["CW00060"]; // 답변?></strong></a>
		<?php endif;?>
		<?php if($isModify):?>
		<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinModifyMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_gray"><strong><?php echo $LNG_TRANS_CHAR["OW00072"]; // 수정?></strong></a>
		<?php endif;?>
		<?php if($isDelete):?>
		<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinDeleteActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_gray"><strong><?php echo $LNG_TRANS_CHAR["CW00036"]; // 삭제?></strong></a>
		<?php endif;?>
		<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinListMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_red"><strong><?php echo $LNG_TRANS_CHAR["CW00059"]; // 목록?></strong></a>
	</div>
	<div class="clr"></div>
	<!--div class="btnCenter">
		<a href="javascript:goPopClose();" class="btnCancel">취소</a>
		<a href="javascript:popProdInquiry('<?=$strAppID?>');" class="btnInquiry"  <?=$strLogBasketBtnEvent?>><span>문의하기</span></a>
	</div-->
</div>

<?php include "communityView.dataBasicSkin.comment.inc.php";?>