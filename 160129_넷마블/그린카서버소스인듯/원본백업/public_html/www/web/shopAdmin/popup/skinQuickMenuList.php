<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode			= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];

	if (!$strSubPageCode){
		exit;
	}

	$designSetMgr->setDS_TYPE("SKIN_EQ");
	$row = $designSetMgr->getCodeView($db);
?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goQuickMenuHtml(gb)
	{

		var strUrl = "./?menuType=popup&mode=skinQuickMenuListHtml&subPageCode="+document.form.subPageCode.value+"&quickMenuKind="+gb;
		$.smartPop.open({  bodyClose: false, width: 600, height: 450, url: strUrl, closeImg: {width:13, height:13, src:'../himg/common/btn_pop_close.png'} });

	}
	
	function goSelfClose() {
		$.smartPop.close();
	}
	
	function goClose() {
		parent.goClose();
	}
//-->
</script>

<!-- ******************** contentsArea ********************** -->

		<form name="form" id="form">
			<input type="hidden" name="menuType" value="<?=$strMenuType?>">
			<input type="hidden" name="mode" value="<?=$strMode?>">
			<input type="hidden" name="act" value="<?=$strMode?>">
			<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">	
			<div class="layerPopWrap">
				<div class="popTop">
					<h2>퀵메뉴</h2>
					<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
					<div class="clear"></div>
				</div>

			<!-- ******** 컨텐츠 ********* -->
			<div class="tableList" style="margin-top:10px;">
				<table>
				<tr>
					<th>종류</th>
					<th>사용유무</th>
					<th>설정</th>
				</tr>
				<tr>
					<td>오늘본 상품</td>
					<td><?=$row["EQ_QUICK_MENU_USE_1"]=="Y"?"사용함" : "사용안함"?></td>
					<td><a class="btn_blue_sml" href="javascript:goQuickMenuHtml('1');"><strong>O</strong></a></td>						
				</tr>
				<!--tr>
					<td>배너</td>
					<td><?=$row["EQ_QUICK_MENU_USE_2"]=="Y"?"사용함" : "사용안함"?></td>
					<td><a class="btn_blue_sml" href="javascript:goQuickMenuHtml('2');"><strong>O</strong></a></td>
				</tr-->
				</table>
			</div>
			<!-- ******** 컨텐츠 ********* -->

			<div class="buttonWrap"><a class="btn_blue_big" href="javascript:goClose();"><strong>닫기</strong></a></div>
		</form>
<!-- ******************** contentsArea ********************** -->
</body>
</html>