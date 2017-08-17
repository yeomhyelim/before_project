<?php
/**
 * eumshop app - communityView - dataBasicSkin
 *
 * 커뮤니티 보기 내용을 불러옵니다.
 *
 * @package		eumshop shopping mall
 * @author		ExpressionEngine Dev HeeSung Kim
 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
 * @license		http://www.eumshop.com/user_guide/license.html
 * @link		http://www.eumshop.com
 * @since		Version 1.0
 * @filesource	/www/web/app/communityView/communityView.dataBasicSkin.php
 * @manual		menuType=app&mode=communityView&skin=dataBasicSkin
 * @history
 *				2014.06.08 kim hee sung - 개발 완료
 */

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
$strCommunityCateDir = MALL_SHOP . "/conf/community/category/{$strAppLangLower}";
$strCommunityCateFile = "category.{$strAppBCode}.info.php";
$intMemberNo = $g_member_no;
$strMemberGroup = $g_member_group;
$strSiteFacebook = $S_SITE_FACEBOOK;
$strSiteTwitter = $S_SITE_TWITTER;
$strSiteFacebookAppID = $S_SITE_FACEBOOK_APP_ID;
$strSiteFacebookSecret = $S_SITE_FACEBOOK_SECRET;

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

## 커뮤니티 카테고리 설정 파일
include_once "{$strCommunityCateDir}/{$strCommunityCateFile}";
$aryCategoryList = $CATEGORY_LIST;

## 커뮤니티 설정
$strBI_START_MODE = $aryAppBoardInfo['BI_START_MODE'];
$strB_KIND_SKIN = $aryAppBoardInfo['B_KIND_SKIN'];
$strB_CSS = $aryAppBoardInfo['B_CSS'];
$strBI_CATEGORY_USE = $aryAppBoardInfo['BI_CATEGORY_USE'];
$aryBI_DATALIST_FIELD_USE = $aryAppBoardInfo['BI_DATALIST_FIELD_USE'];
$aryBI_DATALIST_WRITER_SHOW = $aryAppBoardInfo['BI_DATALIST_WRITER_SHOW'];
$intBI_DATALIST_WRITER_HIDDEN = $aryAppBoardInfo['BI_DATALIST_WRITER_HIDDEN'];
$strBI_DATAVIEW_USE = $aryAppBoardInfo['BI_DATAVIEW_USE']; // 글보기권한(모든회원/비회원-A, 회원전용-M)
$aryBI_DATAVIEW_MEMBER_AUTH = $aryAppBoardInfo['BI_DATAVIEW_MEMBER_AUTH'];
$strBI_DATAANSWER_USE = $aryAppBoardInfo['BI_DATAANSWER_USE']; // 답변권환(모든회원/비회원-A, 회원전용-M)
$aryBI_DATAANSWER_MEMBER_AUTH = $aryAppBoardInfo['BI_DATAANSWER_MEMBER_AUTH'];
$strBI_DATAVIEW_FACEBOOK_USE = $aryAppBoardInfo['BI_DATAVIEW_FACEBOOK_USE']; // 페이스북 사용 유무
$strBI_DATAVIEW_TWITTER_USE = $aryAppBoardInfo['BI_DATAVIEW_TWITTER_USE']; // 트위터 사용 유무
$strBI_DATALIST_ORDERBY = $aryAppBoardInfo['BI_DATALIST_ORDERBY']; // 리스트 정렬
$strBI_START_MODE = $aryAppBoardInfo['BI_START_MODE']; // 시작페이지
$strBI_DATAWRITE_END_MOVE = $aryAppBoardInfo['BI_DATAWRITE_END_MOVE']; // 글쓰기후이동
$strBI_DATAVIEW_NEXTPRVE_USE = $aryAppBoardInfo['BI_DATAVIEW_NEXTPRVE_USE']; // 글보기 네비게이션 설정
$strBI_DATAWRITE_LOCK_USE = $aryAppBoardInfo['BI_DATAWRITE_LOCK_USE']; //비밀글(무조건비밀글-E)

## 사용권한 체크
if($strBI_DATAVIEW_USE == "M"): // 회원전용인경우
	if(!$intMemberNo):
		goUrl("", "./?menuType=member&mode=login");
		return;
	endif;
	if(!in_array($strMemberGroup, $aryBI_DATAVIEW_MEMBER_AUTH)):
		goErrMsg($LNG_TRANS_CHAR["MS00102"]); // 게시판을 사용하실 권한이 없습니다.\\n고객센터로 문의하시기 바랍니다.
		return;
	endif;
endif;

## 조회수 증가
## 무조건 증가하는 형태입니다.
$param = "";
$param['B_CODE'] = $strAppBCode;
$param['UB_NO'] = $intAppUbNo;
$objBoardDataModule->getBoardDataReadUpdateEx($param);

## 데이터 불러오기
$param = "";
$param['B_CODE'] = $strAppBCode;
$param['UB_NO'] = $intAppUbNo;
$param['UB_LNG_IN'][] = "--";
$param['UB_LNG_IN'][] = $strAppLang;
$param['JOIN_MM'] = "Y";
$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
//	echo $db->query;

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
$strUB_FUNC = $aryBoardDataRow['UB_FUNC'];
$strUB_PASS = $aryBoardDataRow['UB_PASS'];
$intUB_ANS_NO = $aryBoardDataRow['UB_ANS_NO'];

## UB_FUNC 설정
$aryFunc = "";
$strFuncNotice = $strUB_FUNC[0]; // 공지글
$strFuncLock = $strUB_FUNC[1]; // 비밀글
$strFuncText = $strUB_FUNC[2]; // text
//	$aryFunc[] = $strUB_FUNC[3]; // 대기
//	$aryFunc[] = $strUB_FUNC[4]; // 대기
//	$aryFunc[] = $strUB_FUNC[5]; // 대기
//	$aryFunc[] = $strUB_FUNC[6]; // 대기
//	$aryFunc[] = $strUB_FUNC[7]; // 대기
//	$aryFunc[] = $strUB_FUNC[8]; // 대기
//	$aryFunc[] = $strUB_FUNC[9]; // 대기

## 답변글인경우, 원글 정보도 불러옵니다.
if($intAppUbNo != $intUB_ANS_NO):
	$param = "";
	$param['B_CODE'] = $strAppBCode;
	$param['UB_NO'] = $intUB_ANS_NO;
	$aryAnsBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
	$intANS_UB_M_NO = $aryAnsBoardDataRow['UB_M_NO'];
	$strANS_UB_PASS = $aryAnsBoardDataRow['UB_PASS'];
else:
	$intANS_UB_M_NO = $intUB_M_NO;
endif;

## 무조건 비밀글 설정인경우
if($strBI_DATAWRITE_LOCK_USE == "E") { $strFuncLock = "Y"; }

## 비밀글 체크
## 관리자 그룹(001)은 비밀글을 볼 수 있습니다.
if($strFuncLock == "Y" && !in_array($strMemberGroup, array("001"))):

	if($intUB_M_NO && $intANS_UB_M_NO): // 회원글

		if(!$intMemberNo): // 비회원경우
			goUrl("", "./?menuType=member&mode=login");
			return;
		endif;

		if($intUB_M_NO != $intMemberNo && $intANS_UB_M_NO!= $intMemberNo): // 자신의 글이 아닌 경우, 답변글인경우, 원글도 체크
			goErrMsg($LNG_TRANS_CHAR["MS00126"]); // 비밀글은 작성자만 보실수 있습니다.
			return;
		endif;

	else: // 비회원글

		## 기본 설정
		$strCommunityPasswordCode = $_SESSION['communityPasswordCode'];

		## 체크
		if(!$strCommunityPasswordCode):
			goErrMsg($LNG_TRANS_CHAR["MS00118"]); // 비회원이 작성한 글은 비밀번호가 필요합니다.
			return;
		endif;
		if(!$strUB_PASS && !$strANS_UB_PASS):
			goErrMsg($LNG_TRANS_CHAR["MS00127"]); // 비밀글에 비밀번호가 없습니다. 관리자에게 문의하세요.
			return;
		endif;

		## 비밀번호 체크
		## 답변글도 체크
		$strTemp = "{$strBCode}_{$intUbNo}_{$strUB_PASS}";
		$strTemp = crypt($strTemp, $strCommunityPasswordCode);
		$strAnsTemp = "{$strBCode}_{$intUbNo}_{$strANS_UB_PASS}";
		$strAnsTemp = crypt($strAnsTemp, $strCommunityPasswordCode);
		if($strCommunityPasswordCode != $strTemp && $strCommunityPasswordCode != $strAnsTemp):
			goErrMsg($LNG_TRANS_CHAR["MS00111"]); // 게시판을 삭제하실 권한이 없습니다.\\n본인글만 삭제할 수 있습니다.
			return;
		endif;

	endif;

endif;

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

// echo "<!--123123 " . print_r($_SESSION, true) . " //-->";
// echo "<!--123123 {$strMemberGroup} //-->";
// echo "<!--123123 " . print_r($aryBI_DATAANSWER_MEMBER_AUTH, true) . " //-->";

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
$param['UB_ANS_M_NO'] = $g_member_no;
$param['UB_LNG_IN'][]				= "--";
$param['UB_LNG_IN'][]				= $strAppLang;
//$param['UB_LNG'] = $strAppLang;
$param['ORDER_BY'] = "reg_dt_desc";
$param['LIMIT_END'] = 1;

$aryBoardDataPrveRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
$intPrveDataUB_NO = $aryBoardDataPrveRow['UB_NO'];

$strPrveDataUB_TITLE = strHanCutUtf2($aryBoardDataPrveRow['UB_TITLE'],50);

//if(!$strPrveDataUB_TITLE) { $strPrveDataUB_TITLE = $LNG_TRANS_CHAR["MS00109"]; /* 첫번째 내용입니다. */ }

## 다음
$param = "";
$param['B_CODE'] = $strAppBCode;
$param['UB_NO_RAB'] = $intAppUbNo;
$param['UB_ANS_M_NO'] = $g_member_no;
$param['UB_LNG_IN'][]				= "--";
$param['UB_LNG_IN'][]				= $strAppLang;
//$param['UB_LNG'] = $strAppLang;
$param['ORDER_BY'] = "reg_dt_asc";
$param['LIMIT_END'] = 1;
$aryNextDataNextRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
$intNextDataUB_NO = $aryNextDataNextRow['UB_NO'];

$strNextDataUB_TITLE =  strHanCutUtf2($aryNextDataNextRow['UB_TITLE'],50);

//if(!$strNextDataUB_TITLE) { $strNextDataUB_TITLE = $LNG_TRANS_CHAR["MS00110"]; /* 마지막 내용입니다. */ }

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
?>
<div id="<?php echo $strAppID?>">
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.<?php echo $strB_CSS;?>.css"/>
	<!--h2>
		<span><?php echo $strB_NAME;?></span>
	</h2-->
	<div class="tableForm">
		<table class="tableForm">
			<tbody>
			<tr>
				<th class="boardTit" colspan="4"><?php echo $strUB_TITLE;?></th>
			</tr>
			<?php if(in_array("카테고리",$aryAppColumn)):?>
				<tr>
					<th><?php echo $LNG_TRANS_CHAR["CW00064"]; // 카테고리?></th>
					<td colspan="4" style="text-align:left"><?php echo $strCategoryName;?></td>
				</tr>
			<?php endif;?>
			<?php if(in_array("작성자,조회수",$aryAppColumn)):?>
				<tr class="writerInfo">
					<?php if(in_array("작성자",$aryAppColumn)):?>
						<th class="name"><?php echo $LNG_TRANS_CHAR["CW00053"]; //작성자?></th>
						<td class="writerVal" colspan="<?php echo $intWriteColspan;?>">
							<?php if(in_array("성명",$aryAppColumn)):?>
								<span class="txtName"><?php echo $strUB_NAME;?></span>
							<?php endif;?>
							<?php if(in_array("아이디",$aryAppColumn)):?>
								( <span class="txtName"><?php echo $strUB_M_ID;?></span> )
							<?php endif;?>
							<?php if(in_array("닉네임",$aryAppColumn)):?>
								<span class="txtName"><?php echo $strMM_NICK_NAME;?></span>
							<?php endif;?>
							<span class="txtDate"><?php echo $strRegDate;?></span>
						</td>
					<?php endif;?>
					<?php if(in_array("조회수",$aryAppColumn)):?>
						<th class="read"><?php echo $LNG_TRANS_CHAR["CW00055"]; // 조회수?></th>
						<td class="readCnt" colspan="<?php echo $intWriteColspan;?>"><?php echo $strUB_READ;?></td>
					<?php endif;?>
				</tr>
			<?php endif;?>
			<?php include "communityView.dataBasicSkin.userfield.inc.php";?>
			<?php if(in_array("점수",$aryAppColumn)):?>
				<tr>
					<th><?php echo $LNG_TRANS_CHAR["CW00056"]; // 평점?></th>
					<td colspan="3" style="text-align:left">
						<img src="/himg/board/icon/icon_star_<?php echo $intUB_P_GRADE;?>.png">
					</td>
				</tr>
			<?php endif;?>
			<?php if(is_array($aryBoardFile)):?>
				<tr>
					<th><?php echo $LNG_TRANS_CHAR["CW00058"]; // 첨부파일?></th>
					<td colspan="3" style="text-align:left">
						<?php foreach($aryBoardFile['file'] as $key => $row):

							## 기본 설정
							$intFL_NO = $row['FL_NO'];
							$strFL_DIR = $row['FL_DIR'];
							$intFL_SIZE = $row['FL_SIZE'];
							$strFL_NAME = $row['FL_NAME'];

							## 파일명 설정
							list($strFrontName, $strRealName) = explode("_@_", $strFL_NAME);

							## 파일 크기 설정
							$strUnit = "byte";
							if($intFL_SIZE > 1024):
								$strUnit = "kb";
								$intFL_SIZE = $intFL_SIZE / 1024;
							endif;
							if($intFL_SIZE > 1024):
								$strUnit = "mb";
								$intFL_SIZE = $intFL_SIZE / 1024;
							endif;
							if($intFL_SIZE > 1024):
								$strUnit = "gb";
								$intFL_SIZE = $intFL_SIZE / 1024;
							endif;
							$strFL_SIZE = number_format($intFL_SIZE);
							$strFL_SIZE = "{$strFL_SIZE}{$strUnit}";

							## 이미지 설정
							$strImageFile = "{$strFL_DIR}/{$strFL_NAME}";
							$aryFileName	= explode('.',$strFL_NAME);
							$intFileName = count($aryFileName) -1;

							$aryFileExt = array('jpg','jpeg','gif','png','bmp');

							if(!in_array($aryFileName[$intFileName],$aryFileExt) ){

								$strFileCheck = '<a href="'.$strImageFile.'" class="btn_big">'.$strRealName.'</a>';
							}else{

								$strFileCheck = '<img src="'.$strImageFile.'">';
							}
							?>
							<p><?php echo $strFileCheck;?><!--<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinFileDownEvent('<?php echo $strAppID;?>',<?php echo $intFL_NO;?>)"><?php echo $strRealName;?>--> <span>(<?php echo $strFL_SIZE;?>)</span></a></p>
						<?php endforeach;?>
					</td>
				</tr>
			<?php endif;?>
			</tbody>
		</table>
		<div class="viewContentArea">
			<?php if(is_array($aryBoardFile)):?>
				<div class="community-view-image">
					<?php foreach($aryBoardFile['image'] as $key => $row):

						## 기본 설정
						$strFL_DIR = $row['FL_DIR'];
						$strFL_NAME = $row['FL_NAME'];

						## 이미지 설정
						$strImageFile = "{$strFL_DIR}/{$strFL_NAME}";
						$aryFileName	= explode('.',$strFL_NAME);
						$intFileName = count($aryFileName) -1;
						$aryFileExt = array('jpg','jpeg','gif','png','bmp');

						if(!in_array($aryFileName[$intFileName],$aryFileExt) ){

							$strFileCheck = '<a href="'.$strImageFile.'" class="btn_big">download</a>';
						}else{

							$strFileCheck = '<img src="'.$strImageFile.'">';
						}
						?>
						<?php echo $strFileCheck;?>
					<?php endforeach;?>
				</div>
			<?php endif;?>
			<?php echo $strUB_TEXT;?>
		</div>
		<?php if($isTwitterUse || $isFacebookUse):?>
			<div class="snsIcoWrap">
				<?php if($isTwitterUse):?>
					<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinTwitterMoveEvent('<?php echo $strAppID;?>');"><img src="/images/icon_twitter.png"></a>
				<?php endif;?>
				<?php if($isFacebookUse):?>
					<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinFacebookMoveEvent('<?php echo $strAppID;?>');"><img src="/images/icon_facebook.png"></a>
				<?php endif;?>
			</div>
		<?php endif;?>
		<?php if(in_array("이전/다음", $aryAppColumn)):?>
			<div class="nextPrve">
				<div class="nextTextWrap">
					<ul>
						<li class="prveList">
							<strong><?php echo $LNG_TRANS_CHAR["MW00052"]; // 이전?></strong>
							<?php if($strPrveDataUB_TITLE) {?>
								<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinViewMoveEvent(<?php echo $intPrveDataUB_NO;?>)"><?php echo $strPrveDataUB_TITLE;?></a>
								<?php
							}else{
								echo $LNG_TRANS_CHAR["MS00109"]; /* 첫번째 내용입니다. */
							}?>
						</li>
						<li class="nextList">
							<strong><?php echo $LNG_TRANS_CHAR["MW00043"]; // 다음?></strong>
							<?php if($strNextDataUB_TITLE) {?>
								<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinViewMoveEvent(<?php echo $intNextDataUB_NO;?>)"><?php echo $strNextDataUB_TITLE;?></a>
								<?php
							}else{
								echo $LNG_TRANS_CHAR["MS00110"]; /* 마지막 내용입니다. */
							}?>

						</li>
					</ul>
				</div>
			</div>
		<?php endif;?>
	</div>
	<div class="btnRight right">
		<?php if($isAnswer):?>
			<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinReplyMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_board_black"><strong><?php echo $LNG_TRANS_CHAR["CW00060"]; // 답변?></strong></a>
		<?php endif;?>
		<?php if($isModify):?>
			<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinModifyMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_board_black"><strong><?php echo $LNG_TRANS_CHAR["OW00072"]; // 수정?></strong></a>
		<?php endif;?>
		<?php if($isDelete):?>
			<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinDeleteActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_board_black"><strong><?php echo $LNG_TRANS_CHAR["CW00036"]; // 삭제?></strong></a>
		<?php endif;?>
		<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinListMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_board_red"><strong><?php echo $LNG_TRANS_CHAR["CW00059"]; // 목록?></strong></a>
	</div>
	<div class="clr"></div>
</div>

<script>
	function goCommunityViewDataBasicSkinFileDownEvent(appId,  intFL_NO ){
		alert(appId);
		alert();
		$("#" + appId + " .tableForm a" ).html("href");
		$("#" + appId + " .tableForm a" ).attr("href");
	}
</script>

<?php include "communityView.dataBasicSkin.comment.inc.php";?>
