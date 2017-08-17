<?
	$strBM_CODE		= $_POST["bm_code"]		? $_POST["bm_code"]		: $_REQUEST["bm_code"];	
?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$.getJSON("http://www.eumshop.com/api/json/shopDesign.json.php?act=getShopBoardSkinPageListHtml&bm_code=<?=$strBM_CODE?>&callback=?", function(data) {
			$("#designSkinList").html(data[0]["DESIGN_SKIN_LIST"]);
		});
	});

	var strNo = null;
	function changeLayoutType(no, strBmCode) {
		// 샘플 이미지 클릭시, 선택 표시
		strNo									= no;
		document.form.bm_code.value				= strBmCode;
		
		$("#designSkinList a").css( "border", "5px solid #fff" );
		$("#designSkinList a").hover ( function() {
			if( strNo != $(this).index() ) {
				$(this).css( "border"		, "5px solid #e5e5e5" );
			}
		}, function() {
			if( strNo != $(this).index() ) {
				$(this).css( "border"		, "5px solid #fff" );
			}
		} );
		$("#designSkinList a").eq(no).css("border", "5px solid #ff0000");		
	}

	<? // 기본 act.php 페이지로 이동 ?>
//	function goAction(mode){	
//		C_getAction(mode,"<?=$PHP_SELF?>");
//	}

	function goSelectBoardSkin() {
		var code = document.form.bm_code.value;
		parent.setSelectBoardSkin(code);
		goClose();
	}

	function goClose() {
		parent.goClose();
	}

//-->
</script>

<div class="layerPopWrap">
	<div class="popTop">
				<h2>상품리스트 관리</h2>
		<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>

	<form name="form" id="form">
	<input type="hidden" name="menuType" value="layout">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="bm_code" value="<?=$strBM_CODE?>">
		<div id="contentArea">
			<table style="width:100%;">
				<tr>
					<td class="contentWrap">
						<!-- ******************** contentsArea ********************** -->
						<div class="layoutWrap">
							<div id="designSkinList"  class="designListWrap">
								스킨리스트
							</div>
						</div>
						<div class="buttonWrap">
							<a class="btn_blue_big" href="javascript:goSelectBoardSkin();"><strong>디자인변경</strong></a>
						</div>

						<!-- ******************** contentsArea ********************** -->
					</td>
				</tr>
			</table>
		</div>
	</form>
</div>
</body>
</html>