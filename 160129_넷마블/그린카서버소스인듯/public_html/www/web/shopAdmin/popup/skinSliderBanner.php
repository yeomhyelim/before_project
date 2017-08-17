<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode			= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];

	if (!$strSubPageCode){
		exit;
	}

?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$.getJSON("http://www.eumshop.com/api/json/shopDesign.json.php?act=getShopSkinBannerPageListHtml&im_code=<?=$strSubPageCode?>&callback=?", function(data) {
			$("#designBannerList").html(data[0]["DESIGN_SKIN_LIST"]);
		});	
	});

	function goClose() {
		parent.goClose();
	}

	function goSelectBanner(no) {
		parent.setSelectBanner(no);
		goClose();
	}
//-->
</script>
<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>

	<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="text" name="subPageCode" value="<?=$strSubPageCode?>">
			<div class="layerPopWrap">
				<div class="popTop">
				<h2>움직이는 배너 리스트</h2>
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clear"></div>
			</div>
			<!-- ******** 컨텐츠 ********* -->
			<div id="designBannerList" class="tableList" style="margin-top:10px;">
				<table>
					<tr>
						<th>종류</th>
						<th>예약어</th>
						<th>설정</th>
					</tr>
				</table>
			</div><!-- tableList -->

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goClose();"><strong>닫기</strong></a>
			</div>
		</div>
	</form>
</body>
</html>