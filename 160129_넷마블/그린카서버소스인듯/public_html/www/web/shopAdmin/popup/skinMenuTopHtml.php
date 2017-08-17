<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode			= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];
	$strDM_CODE				= $_POST["dm_code"]			? $_POST["dm_code"]			: $_REQUEST["dm_code"];
	$strRE_LOAD				= $_POST["reload"]			? $_POST["reload"]			: $_REQUEST["reload"];

	if (!$strSubPageCode){
		exit;
	}
	
	$strSubPageType = SUBSTR($strSubPageCode,0,2);
		
	$designSetMgr->setDS_TYPE("SKIN_".$strSubPageType);
	$row = $designSetMgr->getCodeView($db);

	/* TOP IMG */
	$strSubPageTopImg = $row[$strSubPageType."_TOP_IMG"];
	
	/* HTML */
	$designSetMgr->setDHS_TYPE("SKIN_".$strSubPageType);
	$htmlRow = $designSetMgr->getCodeHtmlView($db);
		
	$strSubPageTopHtml = $htmlRow[$strSubPageType."_TOP_HTML"];				

?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	var strReload = "<?=$strRE_LOAD?>";
	$(document).ready(function(){
		
	});

	function goAct(){
		var doc = document.form;
		doc.menuType.value = "layout";
		
		document.form.encoding = "multipart/form-data";
		C_getAction("skinMenuTopImgHtml","<?=$PHP_SELF?>");	
	}


	function goTopImgDel(){
		var x = confirm("이미지를 삭제하시겠습니까?");
		if (x == true)
		{
			var doc = document.form;
			doc.menuType.value = "layout";

			C_getAction("skinMenuTopImgDel","<?=$PHP_SELF?>");
		}
	}
	
	function goClose() {
		parent.goSelfClose();
		if(strReload == "Y") {
			parent.location.reload();	
		}	
	}
//-->
</script>
<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/upload/editor";
	var uploadFile 	= "../index.php";
	var htmlYN		= "Y";
//]]>
</script>
	<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">
		<input type="hidden" name="dm_code" value="<?=$strDM_CODE?>">
			<div class="layerPopWrap">
				<div class="popTop">
				<h2>Top Img/Html관리</h2>
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clear"></div>
			</div>
			<!-- ******** 컨텐츠 ********* -->
				<div class="tableList" style="margin-top:10px;">
				<table>
					<tr>
						<th>상단영역 이미지</th>
						<td>
							<input type="file" name="top_img" <?=$nBox?>  style="width:300px;height:20px"/>
							<?if ($strSubPageTopImg){?>
								<a class="btn_sml" href="javascript:goTopImgDel();"><strong>X</strong></a>
							<?}?>
						</td>
					</tr>
					<tr>
						<th>HTML</th>
						<td><textarea name="top_html" id="top_html" title="higheditor_full" style="width:100%;height:200px;"><?=$strSubPageTopHtml?></textarea></td>
					</tr>
				</table>
			</div><!-- tableList -->

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAct();" id="menu_auth_w"><strong>저장</strong></a>
				<a class="btn_blue_big" href="javascript:goClose();"><strong>닫기</strong></a>
			</div>
		</div>
	</form>
</body>
</html>