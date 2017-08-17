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
		
	});

	function goSubProdListTopHtml(gb)
	{

		var strUrl = "./?menuType=popup&mode=skinSubProdListHtml&subPageCode="+document.form.subPageCode.value+"&prodListOrder="+gb;
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
			<input type="text" name="subPageCode" value="<?=$strSubPageCode?>">
			<div class="layerPopWrap">
				<div class="popTop">
					<h2>상품 리스트(진열관리)</h2>
					<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
					<div class="clear"></div>
				</div>
				<!-- ******** 컨텐츠 ********* -->
				<div class="tableList" style="margin-top:10px;">
					<table>
						<tr>
							<th>종류</th>
							<th>예약어</th>
							<th>설정</th>
						</tr>
						<tr>
							<td>신상품</td>
							<td>{SUB_PRODLIST_1}}</td>
							<td><a class="btn_blue_sml" href="javascript:goSubProdListTopHtml('1');"><strong>O</strong></a></td>						
						</tr>
						<tr>
							<td>베스트</td>
							<td>{{SUB_PRODLIST_2}}</td>
							<td><a class="btn_blue_sml" href="javascript:goSubProdListTopHtml('2');"><strong>O</strong></a></td>

						</tr>
						<tr>
							<td>MD추천</td>
							<td>{{SUB_PRODLIST_3}}</td>
							<td><a class="btn_blue_sml" href="javascript:goSubProdListTopHtml('3');"><strong>O</strong></a></td>

						</tr>
						<tr>
							<td>신상품</td>
							<td>{{SUB_PRODLIST_4}}</td>
							<td><a class="btn_blue_sml" href="javascript:goSubProdListTopHtml('4');"><strong>O</strong></a></td>
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