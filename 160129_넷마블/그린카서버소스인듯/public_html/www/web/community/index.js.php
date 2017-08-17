<?
	include MALL_HOME . "/web/app/setScript/setScript.php";

	## STEP 1.
	## 공통 JS 파일 모음
	$aryCommonJsFile[] = "/common/js/jquery-1.7.2.min.js";
	$aryCommonJsFile[] = "/common/js/jquery.form.js";
	$aryCommonJsFile[] = "/common/js/common.js";
	$aryCommonJsFile[] = "/common/js/commonReady.js";
	$aryCommonJsFile[] = "/skins/javascript/common.js";
	$aryCommonJsFile[] = "/common/js/jquery.smartPop.js";
	$aryCommonJsFile[] = "http://connect.facebook.net/en_US/all.js";
	$aryCommonJsFile[] = "/common/js/community/dataCommon.js";


	## STEP 2.
	## 요청한 모듈별, 액션별 JS 파일 실행
	switch($_REQUEST['mode']) :

		case "dataPassword":
			// 비밀번호 
		case "dataList":
			// 커뮤니티 글 리스트
			if($_REQUEST['BOARD_INFO']['b_kind'] == "talk"):
			$aryJavascriptFile[] = "../skins/user/community/talk/comment.1.0/javascript/data.js";
			elseif($_REQUEST['BOARD_INFO']['b_kind'] == "product"):
			$aryJavascriptFile[] = "../skins/user/community/product/common.1.0/javascript/data.js";
			else:
			$aryJavascriptFile[] = "../skins/user/community/data/basic.1.0/javascript/data.js";
			endif;
			$aryJavascriptFile[] = "../skins/user/community/common/javascript/common.js";
			$aryJavascriptFile[] = "../skins/javascript/sns.js";
			if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용
			$aryJavascriptFile[] = "../skins/user/community/category/javascript/include.js";
			endif;

		break;
		
		case "dataView":
			// 커뮤니티 글 보기
			if($_REQUEST['BOARD_INFO']['b_kind'] == "product"):
			$aryJavascriptFile = array ( "../skins/user/community/product/common.1.0/javascript/data.js"				);
			else:
			$aryJavascriptFile = array ( "../skins/user/community/data/basic.1.0/javascript/data.js",
//										 "../skins/user/community/comment/basic.1.0/javascript/comment.js",
										 "http://connect.facebook.net/en_US/all.js",
										 "../skins/javascript/sns.js"													);
			endif;
			break;
		case "dataModify":
			// 커뮤니티 글 수정
		case "dataWrite":	
			// 커뮤니티 글 작성
		case "dataAnswer":
			// 커뮤니티 글 답변
			if($_REQUEST['BOARD_INFO']['b_kind'] == "product"):
			$aryJavascriptFile = array ( "../skins/user/community/product/common.1.0/javascript/data.js"				);
			else:
			$aryJavascriptFile = array ( "../skins/user/community/data/basic.1.0/javascript/data.js",
										 "http://connect.facebook.net/en_US/all.js",
										 "../common/eumEditor/highgardenEditor.js"										);
			endif;
		break;

		case "attachedfileWrite":
			// 커뮤니티 글 첨부파일 쓰기
			$aryJavascriptFile = array ( "../skins/user/community/attachedfile/basic.1.0/javascript/attachedfile.js",
										 "http://connect.facebook.net/en_US/all.js",
										 "../skins/user/community/data/basic.1.0/javascript/data.js"						);

		break;

		case "dataMenuList":
			// 커뮤니티 메뉴 리스트
		break;
	endswitch;


	if($_REQUEST['BOARD_INFO']['b_kind'] == "data"):
		$aryJavascriptFile = "";
		switch($_REQUEST['mode']):
		case "attachedfileWrite":
			// 첨부파일
			$aryJavascriptFile[] = "/common/js/community/data.js";
			$aryJavascriptFile[] = "../skins/user/community/attachedfile/basic.1.0/javascript/attachedfile.js";
		break;
		case "dataView":
			// 보기
			$aryJavascriptFile[] = "/common/js/community/data.js";
//			$aryJavascriptFile[] = "../skins/user/community/comment/basic.1.0/javascript/comment.js";
			$aryJavascriptFile[] = "../skins/javascript/sns.js";
		break;
		case "dataList":
			// 리스트
			$aryJavascriptFile[] = "/common/js/community/data.js";
//			$aryJavascriptFile[] = "../skins/user/community/comment/basic.1.0/javascript/comment.js";
			if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용
			$aryJavascriptFile[] = "../skins/user/community/category/javascript/include.js";
			endif;
			$aryJavascriptFile[] = "../skins/javascript/sns.js";
		break;
		case "dataAnswer":
			// 답변
		case "dataModify":
			// 수정
		case "dataWrite":
			// 쓰기
			$aryJavascriptFile[] = "/common/js/community/data.js";
			$aryJavascriptFile[] = "../common/eumEditor/highgardenEditor.js";
			$aryJavascriptFile[] = "../skins/user/community/attachedfile/basic.1.0/javascript/attachedfile.js";
//			$aryJavascriptFile[] = "../skins/user/community/comment/basic.1.0/javascript/comment.js";
		break;
		case "dataPassword":
			// 비밀번호
			$aryJavascriptFile[] = "/common/js/community/data.js";
		break;
		endswitch;
	endif;

?>

<? foreach($aryCommonJsFile as $file): ?>
<script language="javascript" type="text/javascript" src="<?=$file?>"></script>
<? endforeach; ?>

<? foreach($aryJavascriptFile as $file): ?>
<script language="javascript" type="text/javascript" src="<?=$file?>"></script>
<? endforeach; ?>

 <?if($aryScript):
  foreach($aryScript as $key => $data):?>
	<script language="javascript" type="text/javascript" src="<?=$data?>"></script>
<?endforeach;
  endif;?>

<? if($_REQUEST['myTarget'] == "iframe"):?>
<script type="text/javascript">
//	function init() {
//		setInterval(function() {
//			var height		= $("body").prop("offsetHeight");
//			var frameId		= "<?=strtolower($_REQUEST['b_code']) . "_frame"; ?>";
//		//	parent.document.getElementById(frameId).height = height + 25 + "px";
//		}, 100);
//	}
//
//	window.onload = function() { init(); }


</script>
<? endif;?>
<script type="text/javascript">
<!--
	var G_PHP_SELF			= "./";
	var strSiteHost			= "<?=$S_HTTP_HOST?>";
	var strSiteJsLng		= "<?=$S_SITE_LNG?>";
	var strSiteReqUri		= "<?=SUBSTR($S_REQUEST_URI,1,STRLEN($S_REQUEST_URI))?>";
	var strMemberLogin		= "<?=$g_member_login?>";
	var strMemberLoginNo	= "<?=$g_member_no?>";
	var G_PHP_PARAM			= "<?=$_SERVER['QUERY_STRING']?>";
	var G_APP_PARAM			= new Object();

	//<![CDATA[
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/editor/board";
	var uploadFile 	= "../<?php echo $S_SITE_LNG_PATH;?>/index.php";
	var htmlYN		= "Y";
	//]]>

	/* 페이스북 */
	FB.init({appId: "<?=$S_SITE_FACEBOOK_APP_ID?>", status: true, cookie: true});

	<?if($S_MAIN_LAYERPOP_LOGIN_USE=="Y"):?>
	function goLoginLayerpop(type) {
		var strUrl = "/kr/?menuType=member&mode=login&target=layer&clickType="+type;
		$.smartPop.open({  
				bodyClose	: false, 
				width		: 455, 
				height		: 460, 
				conOptUse	:'Y',	// 배경 투명하게..
				url			: strUrl				});
	}
	<?endif;?>

	<?if($S_MAIN_LAYERPOP_JOIN_USE=="Y"):?>
	function goJoinLayerpop() {
		var strUrl = "/kr/?menuType=member&mode=join1&target=layer&type=<?=$strMenuType?>";
		$.smartPop.open({  bodyClose: false, width: 690, height: 300, conOptUse:'Y', url: strUrl });
	}
	<?endif;?>
	
	/* smartPop 레이어 띄우기 */
	function goOpenWinSmartPop(url, img, width, height, closeImg) {
		
		var strImg = "";
		if (img)
		{
			strImg = "<img src='"+img+"' style='width:"+width+"px;height:"+height+"px'>";
		}

		if (C_isNull(closeImg))
		{
			$.smartPop.open({width:width,url:url,height:height,conOptUse:'Y',closeImg:{width:32,height:32,src:'/images/common/btn_pop_close.png'},bodyClose: false,html: strImg});
		} else {
			$.smartPop.open({width:width,url:url,height: height,conOptUse:'Y',bodyClose: false,html: strImg});
		}
	}

	function goLayerPopClose(url,clickType)
	{
		$.smartPop.close();
		
		if (!C_isNull(url))
		{
			if (clickType)
			{
				location.reload();
				return;
			}

			location.href = url
		}
	}
//-->
</script>

<? include "{$S_DOCUMENT_ROOT}www/common/js/community/dataLanguage.js"; ?>

