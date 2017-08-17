<?php
	$strPCode = $_REQUEST['prodCode'];
	$strReviewSrc = "./?menuType=community&mode=dataList&b_code=PROD_REVIEW&ub_p_code={$strPCode}&myTarget=iframe&bodyClass=bdCtl";
	$strQnaSrc = "./?menuType=community&mode=dataList&b_code=PROD_QNA&ub_p_code={$strPCode}&myTarget=iframe&bodyClass=bdCtl";
?>
<script type="text/javascript">
	<!--
		$(document).ready(function(){
			$(".scroll").click(function(event){
				//prevent the default action for the click event
				event.preventDefault();

				//get the full url - like mysitecom/index.htm#home
				var full_url = this.href;

				//split the url by # and get the anchor target name - home in mysitecom/index.htm#home
				var parts = full_url.split("#");
				var trgt = parts[1];

				//get the top offset of the target anchor
				var target_offset = $("#"+trgt).offset();
				var target_top = target_offset.top;

				//goto that anchor by setting the body scroll top to anchor top
				$('html, body').animate({scrollTop:target_top}, 500);
			});
		});

		// 아이프레임 리사이즈
		function autoResize(i)
		{
			var iframeHeight = i.contentWindow.document.body.scrollHeight;
			i.height=iframeHeight+20;
		}
	//-->
</script>
<style>
	div.multyImageListWrap {margin-top:10px;width:<?=$intVSizeW?>px;}
	div.multyImageListWrap .selectImage {width:<?=$intVSizeW?>px;height:<?=$intVSizeH?>px;}
	div.multyImageListWrap img {width:<?=$intMSizeW?>px;height:<?=$intMSizeH?>px;}
</style>
<div id="passwordDialog" style="display:none">
	<table width="100%" height="100%" border="1" >
		<tr><td align="center"><?=$LNG_TRANS_CHAR["PW00001"] //비밀번호를 입력하세요.?></td></tr>
		<tr><td align="center"><?=$LNG_TRANS_CHAR["PS00002"] //비밀번호?> : <input type="password" name="b_pass_bbs" />&nbsp;<a href="javascript:goJsonBBSAction()"><?=$LNG_TRANS_CHAR["CW0001"]?></a></td></tr>
	</table>
</div>
<input type="hidden" name="b_code_bbs" />
<input type="hidden" name="b_no_bbs" />
<input type="hidden" name="mode_bbs" />
<input type="hidden" name="b_page" />
<div class="mainProdView">
	<!-- 상품 탑 상세정보 -->
	<? include "include/prodView.topDetailInfo.index.inc.php" ?>
	<!-- 상품 탑 상세정보 -->


	<?php //이 파일 자체가 없음..; include MALL_SHOP . "/layout/userAdd/user.prodView.detailInfo.skin.php";?>
</div>

