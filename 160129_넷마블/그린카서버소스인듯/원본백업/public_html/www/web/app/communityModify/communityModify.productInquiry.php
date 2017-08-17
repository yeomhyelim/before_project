<?
require_once MALL_CONF_LIB."CateMgr.php";
require_once MALL_CONF_LIB."ProductMgr.php";

$productMgr		= new ProductMgr();
$cateMgr		= new CateMgr();

## 모듈 설정
$objBoardDataModule			= new BoardDataModule($db);
$objBoardFileModule			= new BoardFileModule($db);

$EUMSHOP_APP_INFO['b_code'] = "PROD_QNA";
$EUMSHOP_APP_INFO['pCode'] = $strP_CODE;
//$strAppMode = "prodInquiryWrite";
$strAppMode = "communityWrite";
$strAppSkin = "dataBasicSkin";
		## app ID
	if(!$strAppID):
		$intAppID = $intAppID + 1; 
		$strAppID = "COMMUNITY_WRITE_{$intAppID}";
	endif;

	## 스크립트 설정
	if($strDevice != 'mobile')
	{
		if($S_COMMUNITY_EDTOR != "eumEditor2"):
		$aryScriptEx[]				= "/common/eumEditor/highgardenEditor.js";
		else:
		$aryScriptEx[]				= "/common/eumEditor2/js/eumEditor2.js";
		endif;
	}else{
		$S_COMMUNITY_EDTOR ='';
	}
	$aryScriptEx[]				= "/common/js/jquery.form.js";
	$aryScriptEx[]				= "/common/js/app/communityWrite/communityWrite.dataBasicSkin.js";

	## 커뮤니티 코드 설정
	$strAppBCode = $EUMSHOP_APP_INFO['b_code'];
	if(!$strAppBCode) { $strAppBCode = $_GET['b_code']; }
	if(!$strAppBCode) { return; }
	$strAppBCodeLower = strtolower($strAppBCode);

	## 언어 설정
	$strLang = $S_SITE_LNG;
	$strLangS = $S_ST_LNG;
	$strLangLower = strtolower($strLang);
	$strLangSLower = strtolower($strLangS);

	## 커뮤니티 보드 설정
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	if(!$aryAppBoardInfo):
		include_once rtrim(MALL_SHOP, '/') . "/conf/community/{$strLangLower}/board.{$strAppBCode}.info.php";
		$aryAppBoardInfo = $BOARD_INFO[$strAppBCode];
		include_once rtrim(MALL_SHOP, '/') . "/conf/community/{$strLangSLower}/board.{$strAppBCode}.info.php";
		$aryAppBoardInfoS = $BOARD_INFO[$strAppBCode];
		foreach($aryAppBoardInfoS as $key => $data):
			$strTemp = $aryAppBoardInfo[$key];
			if($strTemp) { continue; }
			$aryAppBoardInfo[$key] = $data;
		endforeach;
	endif;

	$strBI_USERFIELD_USE = $aryAppBoardInfo['BI_USERFIELD_USE']; // 추가필드 사용 - 사용 = Y, 사용안함 = N

	## 기본 설정	
	$intAppUbNo = $EUMSHOP_APP_INFO['ubNo'];
	$strAppPCode = $EUMSHOP_APP_INFO['pCode'];
	$strCommunityCateDir = MALL_SHOP . "/conf/community/category/{$strLangLower}";
	$strCommunityCateFile = "category.{$strBCode}.info.php"; 
	$intMemberNo = $g_member_no;
	$strMemberGroup = $g_member_group;
	$strMemberName = $g_member_name; // 영문 - 이름, 한글 - 기록 안됨
	$strMemberLastName = $g_member_last_name; // 영문 - 성, 한글 - 성 + 이름
	$strMemberEmail = $g_member_email;
	$arySessionFileList = $_SESSION['FILE']; // 세션에 등록된 파일 리스트
//	$strLayout = $_GET['layout']; // 상단에서 처리하고 있음.
	$strEditorDir = "community/{$strAppBCodeLower}";

	## 체크
	if(!$strAppBCode):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "b_code가 없습니다.";
		//getDebug($param);
		goErrMsg($param['msg']);
		return;
	endif;
	if(!$aryAppBoardInfo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "boardInfo가 없습니다.";
		//getDebug($param);
		goErrMsg($param['msg']);
		return;		
	endif;
	if(!$intAppUbNo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "ubNo가 없습니다.";
		//getDebug($param);
		goErrMsg($param['msg']);
		return;		
	endif;


	## 회원인경우 추가 설정.
	$strUbName = "";
	if($intMemberNo):
		## 이름 설정. 세션정보에서 다시 가져옵니다.
		if($strMemberName && $strMemberLastName) { $strUbName = "{$strMemberName} {$strMemberLastName}"; }
		else if($strMemberLastName) { $strUbName = $strMemberLastName; }
		else if($strMemberName) { $strUbName = $strMemberName; }
	endif;

	## 커뮤니티 설정
	$strB_CSS = $aryAppBoardInfo['B_CSS'];
	$strBI_DATAWRITE_FORM = $aryAppBoardInfo['BI_DATAWRITE_FORM']; // 글쓰기 폼 설정
	$strBI_CATEGORY_USE = $aryAppBoardInfo['BI_CATEGORY_USE']; // 카테고리 사용 - 사용(모든사용자) = Y, 사용(관리자만) = A, 사용안함 = N
	$strBI_DATAWRITE_LOCK_USE = $aryAppBoardInfo['BI_DATAWRITE_LOCK_USE']; // 비밀글 사용 - 사용자선택 = C, 무조건 = E
	$strBI_DATAWRITE_USE = $aryAppBoardInfo['BI_DATAWRITE_USE']; // 쓰기권한(모든회원/비회원-A, 회원전용-M)
	$aryBI_DATAWRITE_MEMBER_AUTH = $aryAppBoardInfo['BI_DATAWRITE_MEMBER_AUTH']; // 쓰기권한 그룹 리스트
	$intBI_ATTACHEDFILE_USE = $aryAppBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
	$aryBI_ATTACHEDFILE_NAME = $aryAppBoardInfo['BI_ATTACHEDFILE_NAME']; // 첨부파일 이름
	$aryBI_ATTACHEDFILE_KEY = $aryAppBoardInfo['BI_ATTACHEDFILE_KEY']; // 첨부파일 키
	$strBI_START_MODE = $aryAppBoardInfo['BI_START_MODE']; // 시작페이지 
	//$strBI_DATAWRITE_END_MOVE = $aryAppBoardInfo['BI_DATAWRITE_END_MOVE']; // 글쓰기후이동 
	$strBI_DATAWRITE_END_MOVE = $aryAppBoardInfo['BI_DATAWRITE_END_MOVE']; // 글쓰기후이동 
	$aryBI_DATALIST_FIELD_USE = $aryAppBoardInfo['BI_DATALIST_FIELD_USE']; // 목록항목 표시 여부
	$aryBI_DATALIST_WRITER_SHOW = $aryAppBoardInfo['BI_DATALIST_WRITER_SHOW']; // 작성자 표시 항목


	## 사용권한 체크
	if($strBI_DATAWRITE_USE == "M"): // 회원전용인경우
		if(!$intMemberNo):
			goUrl("", "./?menuType=member&mode=login&layout={$strLayout}");
			return;		
		endif;
		if(!in_array($strMemberGroup, $aryBI_DATAWRITE_MEMBER_AUTH)):
			goErrMsg($LNG_TRANS_CHAR["MS00102"]); // 게시판을 사용하실 권한이 없습니다.\\n고객센터로 문의하시기 바랍니다.
			return;
		endif;
	endif;

	## 커뮤니티 카테고리 설정 파일
	include_once "{$strCommunityCateDir}/{$strCommunityCateFile}";
	$aryCategoryList = $CATEGORY_LIST;

	## 카테고리 설정
	$isCategory = false;
	if($strBI_CATEGORY_USE == "Y") { $isCategory = true; }

	## 공지사항 설정
	$isNotice = false;
	if(in_array($strMemberGroup, array("001"))) { $isNotice = true; } // 관리자그룹(001)

	## 비밀글 설정
	$isLock = false;
	if(in_array($strBI_DATAWRITE_LOCK_USE, array("C","E"))) { $isLock = true; }

	## 비밀번호 설정
	$isPassword = true;
	if($intMemberNo) { $isPassword = false; } // 회원인경우 비밀번호 입력 폼을 숨김.

	## 첨부파일 사용유무
	$isFile = true;
	if(!$intBI_ATTACHEDFILE_USE) { $isFile = false; }

	## 목록 설정
	$aryAppColumn = "";
//	$aryAppColumn[] = "제목";
//	if($aryBI_DATALIST_FIELD_USE[0] == "Y") { $aryAppColumn[] = "번호"; }
//	if($aryBI_DATALIST_FIELD_USE[1] == "Y") { $aryAppColumn[] = "작성자"; }
//	if($aryBI_DATALIST_FIELD_USE[2] == "Y") { $aryAppColumn[] = "등록일"; }
//	if($aryBI_DATALIST_FIELD_USE[3] == "Y") { $aryAppColumn[] = "조회수"; }
	if($aryBI_DATALIST_FIELD_USE[4] == "Y") { $aryAppColumn[] = "점수"; }
//	if($aryBI_DATALIST_FIELD_USE[5] == "Y") { $aryAppColumn[] = "카테고리"; }
//	if($aryBI_DATALIST_FIELD_USE[6] == "Y") { $aryAppColumn[] = "리스트이미지"; }

	## 작성자 설정
//	if(in_array("작성자", $aryAppColumn)):
//		if($aryBI_DATALIST_WRITER_SHOW[0] == "Y") { $aryAppColumn[] = "성명"; }
//		if($aryBI_DATALIST_WRITER_SHOW[1] == "Y") { $aryAppColumn[] = "아이디"; }
//		if($aryBI_DATALIST_WRITER_SHOW[2] == "Y") { $aryAppColumn[] = "닉네임"; }
//	endif;

	## 취소 버튼 표시 여부
	## 시작페이지, 글쓰기후 이동이 모두 글쓰기로 이동이면, 취소 버튼을 숨김 처리
	$isCancelBtnShow = true;
	if($strBI_START_MODE == "dataWrite" && $strBI_DATAWRITE_END_MOVE == "dataWrite") { $isCancelBtnShow = false; } 

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
	$aryLanguage['MW00103']	= $LNG_TRANS_CHAR['MW00103']; // 필수항목
	$aryLanguage['MS00104']	= $LNG_TRANS_CHAR['MS00104']; // {{단어1}}을 입력하세요.
	$aryLanguage['MS00107']	= $LNG_TRANS_CHAR['MS00107']; // {{단어1}}은 필수 항목입니다.
	$aryLanguage['MS00119']	= $LNG_TRANS_CHAR['MS00119']; // 첨부파일을 선택하세요.
	$aryLanguage['BS00001']	= $LNG_TRANS_CHAR['BS00001']; // 등록되었습니다.

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['B_CODE'] = $strAppBCode;
	$aryAppParam['LANG'] = $strLang;
	$aryAppParam['BI_DATAWRITE_END_MOVE'] = $strBI_DATAWRITE_END_MOVE;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;

	if($strAppView == "N") { return; }	

	## 상품카테고리 
	$cateMgr->setCL_LNG($S_SITE_LNG);
	$cateMgr->setC_LEVEL(1);
	$aryCategorys1 = $cateMgr->getCateLevelAry($db);
	for($i = 0; $i < sizeof($aryCategorys1); $i++){
		$aryCateNames1[$aryCategorys1[$i][CATE_CODE]] = $aryCategorys1[$i][CATE_NAME];
	}
	


	## 내용 불러오기
	$param						= "";
	$param['B_CODE']			= $strAppBCode;
	$param['UB_NO']				= $intAppUbNo;
	$aryAppRow					= $objBoardDataModule->getBoardDataSelectEx("OP_SELECT", $param);
	$strAppUB_NAME				= $aryAppRow['UB_NAME'];
	$strAppUB_M_ID				= $aryAppRow['UB_M_ID'];
	$strAppUB_MAIL				= $aryAppRow['UB_MAIL'];
	$strAppUB_TITLE				= $aryAppRow['UB_TITLE'];
	$intAppUB_READ				= $aryAppRow['UB_READ'];
	$strAppUB_TEXT				= $aryAppRow['UB_TEXT'];
	$strAppUB_LNG				= $aryAppRow['UB_LNG'];
	$strAppUB_REG_DT			= $aryAppRow['UB_REG_DT'];
	$strAppUB_ANS_M_NO			= $aryAppRow['UB_ANS_M_NO'];
	$strAppUB_DEL				= $aryAppRow['UB_DEL'];
	$strAppUB_FUNC				= $aryAppRow['UB_FUNC'];
	if(!$aryAppRow) { return; }
	
	$productMgr->setP_LNG($S_SITE_LNG);
	$productMgr->setP_CODE($aryAppRow[UB_P_CODE]);
	$prodRow = $productMgr->getProdView($db);
	
	
	//print_r($prodRow);
	$strMenuType = 'community';
	$strPM_REAL_NAME = $prodRow[PM_REAL_NAME];
	$strP_NAME = $prodRow[P_NAME];
	$strP_ORIGIN  = $prodRow[P_ORIGIN];
	$strP_CATE  = substr($prodRow[P_CATE],0,3);
	
?>
<script type="text/javascript">
//<![CDATA[

	// 메인 상품 베스트 수정
	function popProdInquiry(strAppID) {

		//goCommunityWriteDataBasicSkinWriteActEvent(strAppID);
		// 기본설정
		var strSiteJsLngLower = strSiteJsLng.toLowerCase();
		var objLanguage = objScriptData['APP'][strAppID]['LANGUAGE'];
		var strBI_DATAWRITE_END_MOVE = objScriptData['APP'][strAppID]['BI_DATAWRITE_END_MOVE'];
		var objTarget = $('#' + strAppID).find('[name=writeForm]');

		// 유효성 체크
		if(!goCommunityWriteDataBasicSkinWriteFormCheck(strAppID)) { return; }

		// 전달
		objTarget.find('[name=mode]').val('json');
		objTarget.find('[name=act]').val('dataModify');
		var data = objTarget.serializeArray();

		$.ajax({
			url			: '/' + strSiteJsLngLower + '/'
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
				
				if(data['__STATE__'] == "SUCCESS") {

					var strMsg = '<?php echo $LNG_TRANS_CHAR['BS00002'];?>'; // 수정되었습니다.
					alert(strMsg);

					// 이동
					var data = new Object();
					data['mode'] = strBI_DATAWRITE_END_MOVE;
					C_getAddLocationUrl(data);
					goPopClose();
					
				} else {
					var strMsg	= data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}

		    }
		});
	}

	// 팝업 닫고 다시 로드
	function goPopClose()
	{
		parent.goLayoutPopCloseEvent();
		//self.close();
	}
//]]>
</script>
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
		<input type="hidden" name="ub_no" value="<?php echo $intAppUbNo;?>">

		
		<?
		if($strDevice != 'mobile')
		{
		?>
		<input type="hidden" name="editorDir" value="<?php echo $strEditorDir;?>">
		<?
		}
		?>
		<table class="prodInquiryTable">
			<tr class="inquiryRow">
				<th>문의제품	</th>
				<td>
					<ul>
						<li class="prodImg"><img src="<?php echo $strPM_REAL_NAME;?>" class="listProdImg"/></li>
						<li class="prodInfo">
							<p class="title"><?=$strP_NAME?></p>
							<p class="info"><span>원산지</span> <strong><?php echo $strP_ORIGIN?></strong></p>
							<p class="info"><span>카테고리</span> <strong><?php echo $aryCateNames1[$strP_CATE]?></strong></p>
						</li>
					</ul>	
				</td>
			</tr>

			<tr>
				<th>	<?php echo $LNG_TRANS_CHAR["CW00062"];//제목?></th>
				<td>	<input type="text" name="ub_title" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00062"];//제목?>" value="<?=$strAppUB_TITLE?>" /></td>
			</tr>

			<tr>
				<th>	<?php echo $LNG_TRANS_CHAR["CW00063"];//내용?></th>
				<td>
					<?php if($S_COMMUNITY_EDTOR == "eumEditor2"):?>
						<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
						<textarea name="ub_text" id="ub_text"  style="display:none" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00063"];//내용?>" ><?=$strAppUB_TEXT?></textarea>
						<?php else:?>
						<textarea name="ub_text" id="ub_text" title="<?php echo $strBI_DATAWRITE_FORM;?>" style="width:98%;height:200px;" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00063"]; // 내용?>" ><?=$strAppUB_TEXT?></textarea>
						<?php endif;?>
				</td>
			</tr>
			<!-- 
			<tr>

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
	<?php 
	
	foreach($aryUserfieldSort as $key => $data):

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

					<th class="name"><?= $LNG_TRANS_CHAR["OW00003"]; // 수량 ?>
					<?php// echo $strAddTemp['TEMP1']['NAME'];?></th>
					<td colspan="3">
					
						<?php if($key != "ADDR1"):?>
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
			-->
		</table>
	</div>
	<div class="btnCenter">
		<a href="javascript:goPopClose();" class="btnCancel">취소</a>
		<a href="javascript:popProdInquiry('<?=$strAppID?>');" class="btnInquiry"  <?=$strLogBasketBtnEvent?>><span>수정하기</span></a>
	</div>
</div>
</form>