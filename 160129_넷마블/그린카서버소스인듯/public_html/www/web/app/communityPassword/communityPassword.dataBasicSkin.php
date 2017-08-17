<?php
	/**
	 * eumshop app - communityView - dataBasicSkin
	 *
	 * 비회원 전용
	 * 커뮤니티 비밀번호 입력폼을 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/home/shop_eng/www/web/app/communityPassword/communityPassword.dataBasicSkin.php
	 * @manual		menuType=app&mode=communityPassword&skin=dataBasicSkin
	 * @history
	 *				2014.07.22 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "COMMUNITY_PASSWORD_{$intAppID}";
	endif;

	## 모듈 설정
	$objBoardDataModule = new BoardDataModule($db);

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/communityPassword/communityPassword.dataBasicSkin.js";

	## 기본 설정
	$strAppBCode = $EUMSHOP_APP_INFO['bCode'];
	$intAppUbNo = $EUMSHOP_APP_INFO['ubNo'];
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	$aryAppNext = $EUMSHOP_APP_INFO['next'];
	$strAppLang = $S_SITE_LNG;
	$strAppLangLower = strtolower($strAppLang);
	$intMemberNo = $g_member_no;
	$strMemberGroup = $g_member_group;

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
	if(!$aryAppNext):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "next가 없습니다.";
		getDebug($param);
		return;		
	endif;

	## 커뮤니티 설정 
	$strB_CSS = $aryAppBoardInfo['B_CSS'];

	## 데이터 불러오기
	$param = "";
	$param['B_CODE'] = $strAppBCode;
	$param['UB_NO'] = $intAppUbNo;
	$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
	$intUB_M_NO = $aryBoardDataRow['UB_M_NO'];
	$intUB_ANS_M_NO = $aryBoardDataRow['UB_ANS_M_NO']; // 원글 회원 NO

	## 체크
	if(!$aryBoardDataRow):
		goErrMsg($LNG_TRANS_CHAR["MS00115"]); // 관련 내용이 없습니다.\\n고객센터로 문의하시기 바랍니다.
		return;		
	endif;
	if($intUB_M_NO && $intUB_ANS_M_NO):
		goErrMsg($LNG_TRANS_CHAR["MS00116"]); // 회원글은 비밀번호 찾기 기능을 지원하지 않습니다. 
		return;
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
	$aryAppParam['NEXT'] = $aryAppNext;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;	
?>
<div id="<?php echo $strAppID?>">
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.<?php echo $strB_CSS;?>.css"/>
	<div class="tableForm">
		<div class="subTitInfo">
			<?php echo $LNG_TRANS_CHAR["CW00072"]; // 글등록 시 입력한 비밀번호를 입력해 주세요.?>
		</div>
		<table>
		<tbody>
			<tr>
				<th><?php echo $LNG_TRANS_CHAR["MW00002"]; // 비밀번호?></th>
				<td><input type="password" id="ub_pass" name="ub_pass" alt="비밀번호" check="Y" class="_w300"></td>
			</tr>
		</tbody>
		</table>	
	</div>
	<div class="btnCenter">
		<a href="javascript:void(0);" onclick="goCommunityPasswordDataBasicSkinCheckActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write"><strong><?php echo $LNG_TRANS_CHAR["CW00001"]; // 확인?></strong></a>
		<a href="javascript:void(0);" onclick="goCommunityPasswordDataBasicSkinCancelMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write"><strong><?php echo $LNG_TRANS_CHAR["MW00044"]; // 취소?></strong></a>
	</div>
	<div class="clr"></div>
</div>




