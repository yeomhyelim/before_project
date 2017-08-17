<?php
	/**
	 * eumshop app - communityView - mobileSkin
	 *
	 * 커뮤니티 보기 내용을 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityView/communityView.mobileSkin.php
	 * @manual		menuType=app&mode=communityView&skin=mobileSkin
	 * @history
	 *				2014.06.08 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "COMMUNITY_VIEW_{$intAppID}";
	endif;

	## 모듈 설정
	$objBoardDataModule			= new BoardDataModule($db);
	$objBoardFileModule			= new BoardFileModule($db);

	## 스크립트 설정
	$aryScriptEx[]				= "/common/bxslider-4-master/jquery.bxslider.js";
	$aryScriptEx[]				= "/common/js/app/communityView/communityView.mobileSkin.js";

	## 기본 설정
	$intMemberNo				= $g_member_no;
	$strMemberGroup				= $g_member_group;
	
	## 커뮤니티 코드 설정
	$strAppBCode = $EUMSHOP_APP_INFO['b_code'];
	if(!$strAppBCode) { $strAppBCode = $_GET['b_code']; }
	if(!$strAppBCode) { return; }

	## 커뮤니티 번호 설정
	$intAppUBNo = $EUMSHOP_APP_INFO['ubNo'];
	if(!$intAppUBNo) { $intAppUBNo = $_GET['ubNo']; }
	if(!$intAppUBNo) { return; }

	
	## 설정 파일 불러오기
	if($S_COMMUNITY_VERSION != "V2.0"):
		include_once MALL_SHOP . "/conf/community/board.{$strAppBCode}.info.php";
		$strAppB_NAME						= $BOARD_INFO[$strAppBCode]['b_name'];
		$aryAppBI_DATALIST_FIELD_USE		= $BOARD_INFO[$strAppBCode]['bi_datalist_field_use']; // 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3,점수=4)
		$strAppB_SKIN						= $BOARD_INFO[$strAppBCode]['b_skin']; // basic, gallery, blog
		$strAppPageBlock					= $BOARD_INFO[$strAppBCode]['pageBlock']; 
		$aryAppWriterShow					= $BOARD_INFO[$strAppBCode]['bi_datalist_writer_show']; // 작성자 표시방법([0]:성명,[1]:아이디,[2]닉네임
		$intAppHidden						= $BOARD_INFO[$strAppBCode]['bi_datalist_writer_hidden']; // 작성자/아이디 암호화 설정
		$strBI_DATALIST_USE					= $BOARD_INFO[$strAppBCode]['bi_datalist_use']; // 목록권한(모든회원/비회원-A, 회원전용-M)
		$aryBI_DATALIST_MEMBER_AUTH			= $BOARD_INFO[$strAppBCode]['bi_datalist_member_auth'];

		## 본인글만 보이도록 하는 게시판 설정
		$strOnlyMyRead = "";
		if(in_array($strAppBCode, array("MY_QNA"))) { $strOnlyMyRead = "Y"; };

	else:
		//게시판정보불러오기추가 2.0정보 못불러옴 (왜한거지??)
		include_once MALL_SHOP . "/conf/community/board.{$strAppBCode}.info.php";
		$strAppB_NAME						= $BOARD_INFO[$strAppBCode]['b_name'];
		$aryAppBI_DATALIST_FIELD_USE		= $BOARD_INFO[$strAppBCode]['bi_datalist_field_use']; // 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3,점수=4)
		$strAppB_SKIN						= $BOARD_INFO[$strAppBCode]['b_skin']; // basic, gallery, blog
		$strAppPageBlock					= $BOARD_INFO[$strAppBCode]['pageBlock']; 
		$aryAppWriterShow					= $BOARD_INFO[$strAppBCode]['bi_datalist_writer_show']; // 작성자 표시방법([0]:성명,[1]:아이디,[2]닉네임
		$intAppHidden						= $BOARD_INFO[$strAppBCode]['bi_datalist_writer_hidden']; // 작성자/아이디 암호화 설정
		$strBI_DATALIST_USE					= $BOARD_INFO[$strAppBCode]['bi_datalist_use']; // 목록권한(모든회원/비회원-A, 회원전용-M)
		$aryBI_DATALIST_MEMBER_AUTH			= $BOARD_INFO[$strAppBCode]['bi_datalist_member_auth'];

		## 본인글만 보이도록 하는 게시판 설정
		$strOnlyMyRead = "";
		if(in_array($strAppBCode, array("MY_QNA"))) { $strOnlyMyRead = "Y"; };
		
		/*
		$strBI_START_MODE					= $BOARD_INFO[$strAppBCode]['BI_START_MODE']; 
		$strB_KIND_SKIN						= $BOARD_INFO[$strAppBCode]['B_KIND_SKIN']; 
		$strB_CSS							= $BOARD_INFO[$strAppBCode]['B_CSS'];
		$strBI_CATEGORY_USE					= $BOARD_INFO[$strAppBCode]['BI_CATEGORY_USE'];
		$aryBI_DATALIST_FIELD_USE			= $BOARD_INFO[$strAppBCode]['BI_DATALIST_FIELD_USE'];
		$aryBI_DATALIST_WRITER_SHOW			= $BOARD_INFO[$strAppBCode]['BI_DATALIST_WRITER_SHOW'];
		$intBI_DATALIST_WRITER_HIDDEN		= $BOARD_INFO[$strAppBCode]['BI_DATALIST_WRITER_HIDDEN'];
		$strBI_DATAVIEW_USE					= $BOARD_INFO[$strAppBCode]['BI_DATAVIEW_USE']; // 글보기권한(모든회원/비회원-A, 회원전용-M)
		$aryBI_DATAVIEW_MEMBER_AUTH			= $BOARD_INFO[$strAppBCode]['BI_DATAVIEW_MEMBER_AUTH'];
		$strBI_DATAANSWER_USE				= $BOARD_INFO[$strAppBCode]['BI_DATAANSWER_USE']; // 답변권환(모든회원/비회원-A, 회원전용-M)
		$aryBI_DATAANSWER_MEMBER_AUTH		= $BOARD_INFO[$strAppBCode]['BI_DATAANSWER_MEMBER_AUTH'];
		$strBI_DATAVIEW_FACEBOOK_USE		= $BOARD_INFO[$strAppBCode]['BI_DATAVIEW_FACEBOOK_USE']; // 페이스북 사용 유무
		$strBI_DATAVIEW_TWITTER_USE			= $BOARD_INFO[$strAppBCode]['BI_DATAVIEW_TWITTER_USE']; // 트위터 사용 유무
		$strBI_DATALIST_ORDERBY				= $BOARD_INFO[$strAppBCode]['BI_DATALIST_ORDERBY']; // 리스트 정렬
		$strBI_START_MODE					= $BOARD_INFO[$strAppBCode]['BI_START_MODE']; // 시작페이지 
		$strBI_DATAWRITE_END_MOVE			= $BOARD_INFO[$strAppBCode]['BI_DATAWRITE_END_MOVE']; // 글쓰기후이동 
		$strBI_DATAVIEW_NEXTPRVE_USE		= $BOARD_INFO[$strAppBCode]['BI_DATAVIEW_NEXTPRVE_USE']; // 글보기 네비게이션 설정
		*/
	endif;

	## 사용권한 체크
	if($strBI_DATALIST_USE == "M"): // 회원전용인경우
		if(!$intMemberNo):
			goUrl("", "./?menuType=member&mode=login");
			return;		
		endif;
		if(!in_array($strMemberGroup, $aryBI_DATALIST_MEMBER_AUTH)):
			goErrMsg($LNG_TRANS_CHAR["MS00102"]); // 게시판을 사용하실 권한이 없습니다.\\n고객센터로 문의하시기 바랍니다.
			return;
		endif;
	endif;

	## 내용 불러오기
	$param						= "";
	$param['B_CODE']			= $strAppBCode;
	$param['UB_NO']				= $intAppUBNo;
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

	## UB_FUNC 설정
	$aryFunc = "";
	$strFuncNotice = $strAppUB_FUNC[0]; // 공지글
	$strFuncLock = $strAppUB_FUNC[1]; // 비밀글
	$strFuncText = $strAppUB_FUNC[2]; // text
//	$aryFunc[] = $strAppUB_FUNC[3]; // 대기
//	$aryFunc[] = $strAppUB_FUNC[4]; // 대기
//	$aryFunc[] = $strAppUB_FUNC[5]; // 대기
//	$aryFunc[] = $strAppUB_FUNC[6]; // 대기
//	$aryFunc[] = $strAppUB_FUNC[7]; // 대기
//	$aryFunc[] = $strAppUB_FUNC[8]; // 대기
//	$aryFunc[] = $strAppUB_FUNC[9]; // 대기

	## 본인 체크
	if($strOnlyMyRead == "Y"):
		if($intMemberNo != $strAppUB_ANS_M_NO):
			goErrMsg($LNG_TRANS_CHAR["PS00017"]); // 본인의 글만 조회 가능합니다.
			return;	
		endif;
	endif;
	if($strAppUB_DEL == "Y"):
		goErrMsg($LNG_TRANS_CHAR["MS00131"]); // 삭제된 글입니다.
		return;	
	endif;

	## 파일 불러오기
	## 2014.06.23 kim hee sung, 뷰이미지에 리스트 이미지 포함하여 출력하도록 변경함(한중관)
	$param						= "";
	$param['B_CODE']			= $strAppBCode;
	$param['FL_UB_NO']			= $intAppUBNo;
	//$param['FL_KEY'][]			= "image";
	//$param['FL_KEY'][]			= "listImage";
	$aryAppFileList				= $objBoardFileModule->getBoardFileSelectEx("OP_ARYTOTAL", $param);

	## 아이디 설정
	if($intAppHidden):
		$intCnt	= mb_strlen($strAppUB_M_ID, "UTF-8");
		$strWriteID = mb_substr($strAppUB_M_ID, 0, $intAppHidden, "UTF-8");
		for($i=0;$i<3;$i++) { $strAppUB_M_ID .= "*"; }
	endif;

	## 내용 설정
	## 모바일에서 글작성을 하면, html 편집기로 작성을 하지 않기 때문에, 엔터값(\n) 을 br 테그로 변환 해줘야 합니다.
	if($strFuncText == "Y"):
		$strAppUB_TEXT = strConvertCut2($strAppUB_TEXT, 0, "N");
	endif;
?>
<!-- eumshop app - communityView - MobileSkin (<?php echo $strAppID?>) -->
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']								= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['LANGUAGE']					= <?php echo json_encode($aryLanguage);?>; 
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']						= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']						= "<?php echo $strAppSkin;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['B_CODE']					= "<?php echo $strAppBCode;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['UB_NO']						= "<?php echo $intAppUbNo;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['MEMBER_NO']					= "<?php echo $intAppMemberNo;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['PAGE_LINE_OPTION']			= <?php echo json_encode($aryAppPageLineOption);?>;
	G_APP_PARAM['<?php echo $strAppID;?>']['B_NAME']					= "<?php echo $strAppB_NAME;?>"; 
</script>
<div id="<?php echo $strAppID?>">
	<div class="detailForm">
		<?
		/*
		php if($aryAppFileList):?>
			<div class="gallerySliderWrap">
				<ul class="app-slider">
					<?php foreach($aryAppFileList as $key => $data):
							$strFL_DIR = $data['FL_DIR'];
							$strFL_NAME = $data['FL_NAME'];
							$strFL_TYPEE = $data['FL_TYPE'];
							$strFL_DIR = rtrim($strFL_DIR, "/");
					?>
					<li><img src="<?php echo "{$strFL_DIR}/{$strFL_NAME}"?>"></li>
					<?php endforeach;?>
				</ul>
			</div>
		<?php endif;
		*/
		?>
		<div class="writerInfo">
			<h3><?php echo $strAppUB_TITLE;?></h3>
			<span class="writer"><strong><?php echo $strAppUB_M_ID;?></strong><span class="txtDate">(<?php echo $strAppUB_REG_DT;?>)</span></span>
			<span class="read">View: <?php echo $intAppUB_READ;?></span>
			<div class="clr"></div>
		</div>
		<?php include "communityView.mobileSkin.userfield.inc.php";?>
		<div class="viewContentArea">
			<?php echo $strAppUB_TEXT;?>
		</div>
		<?php if($aryAppFileList):?>
		<div>
			<ul>
				<?php foreach($aryAppFileList as $key => $data):
						$strFL_DIR = $data['FL_DIR'];
						$strFL_NAME = $data['FL_NAME'];
						$strFL_TYPEE = $data['FL_TYPE'];
						$strFL_DIR = rtrim($strFL_DIR, "/");
						
						## 파일명 설정
						list($strFrontName, $strRealName) = explode("_@_", $strFL_NAME);

						## 이미지 설정
						$strImageFile	= "{$strFL_DIR}/{$strFL_NAME}";
						$aryFileName	= explode('.',$strFL_NAME);
						$intFileName	= count($aryFileName) -1;

						$aryFileExt = array('jpg','jpeg','gif','png','bmp');

						if(!in_array($aryFileName[$intFileName],$aryFileExt) )
						{
							$strFileCheck = '<a href="'.$strImageFile.'" class="btn_big">'.$strRealName.'</a>';
						}
						else
						{
							$strFileCheck = '<img src="'.$strImageFile.'">';
						}

				?>
				<li><?php echo $strFileCheck;?></li>
				<?php endforeach;?>
			</ul>
		</div>
		<?php endif;?>
		<div class="btnCenterWrap">
			<a href="javascript:goCommunityViewMobileSkinListMoveEvent();" id="menu_auth_w" class="btn_bbs_list btn_red"><strong><?=$LNG_TRANS_CHAR["CW00059"] //List ?></strong></a>
		</div>
	</div><!-- detailForm //-->
</div>
<!-- eumshop app - communityView - MobileSkin (<?php echo $strAppID?>) -->
