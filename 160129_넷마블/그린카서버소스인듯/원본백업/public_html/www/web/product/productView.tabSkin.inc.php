<?php
	$strPCode = $_REQUEST['prodCode'];
	$strReviewSrc = "./?menuType=community&mode=dataList&b_code=PROD_REVIEW&ub_p_code={$strPCode}&myTarget=iframe&bodyClass=bdCtl";
	$strQnaSrc = "./?menuType=community&mode=dataList&b_code=PROD_QNA&ub_p_code={$strPCode}&myTarget=iframe&bodyClass=bdCtl";
	if($S_COMMUNITY_VERSION == "V2.0"):
		$strReviewSrc = "./?menuType=community&b_code=PROD_REVIEW&layout=product&p_code={$strPCode}";
		$strQnaSrc = "./?menuType=community&b_code=PROD_QNA&layout=product&p_code={$strPCode}";
	endif;
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

			// 기본설정
			var objTarget = $('.mainProdView');

			// 초기화
//			objTarget.find('.prodDetailExp').hide();
			objTarget.find('.reviewArea').hide();
			objTarget.find('.qnaArea').hide();
			objTarget.find('.deliveryArea').hide();

			objTarget.find('.detailInfoTabWrap').find('.detailTab_1').click(function() {
				objTarget.find('.prodDetailExp').show();
				objTarget.find('.reviewArea').hide();
				objTarget.find('.qnaArea').hide();
				objTarget.find('.deliveryArea').hide();
			});
			objTarget.find('.detailInfoTabWrap').find('.detailTab_2').click(function() {
				objTarget.find('.prodDetailExp').hide();
				objTarget.find('.reviewArea').show();
				objTarget.find('.qnaArea').hide();
				objTarget.find('.deliveryArea').hide();
			});
			objTarget.find('.detailInfoTabWrap').find('.detailTab_3').click(function() {

			});
			objTarget.find('.detailInfoTabWrap').find('.detailTab_4').click(function() {
				objTarget.find('.prodDetailExp').hide();
				objTarget.find('.reviewArea').hide();
				objTarget.find('.qnaArea').show();
				objTarget.find('.deliveryArea').hide();
			});
			objTarget.find('.detailInfoTabWrap').find('.detailTab_5').click(function() {
				objTarget.find('.prodDetailExp').hide();
				objTarget.find('.reviewArea').hide();
				objTarget.find('.qnaArea').hide();
				objTarget.find('.deliveryArea').show();
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
	<!-- 미니샵 -->
	<? include "include/prodView.minishop.index.inc.php"; ?>
	<!-- 미니샵 -->
	<!-- 상품설명 //-->
	<?php if($S_FIX_PROD_VIEW_USER_FLAG == "Y"): // 사용자 정의 상품설명을 할 때 사용.?>
	<?php include MALL_SHOP . "/layout/userAdd/user.prodView.detailInfo.skin.php";?>
	<?php else:?>
	<div class="bgAddWrap">
		<!-- 상세설명, 관련상품 -->
		<div class="prodDetailExp mt30">
			<? include "include/prodView.detailInfo.index.inc.php" ?>
		</div>
		<!-- 상세설명, 관련상품 -->
		<!-- 리뷰 //-->
		<?php if($S_PRODUCT_BBS_REVIEW_USE == "Y"):?>
		<div class="reviewArea mt30">
			<?php $select='review'; include MALL_HOME . "/web/product/include/tabMenu.inc.php"; // 탭버튼?>
			<iframe id="prod_review_frame" src="<?php echo $strReviewSrc;?>" onload="autoResize(this)" width="100%" height="100%"  scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
			<?php endif;?>
		</div>
		<!-- 리뷰 //-->
		<!-- QNA //-->
		<?php if($S_PRODUCT_BBS_QNA_USE == "Y"):?>
		<div class="qnaArea mt30">
			<?php $select='qna'; include MALL_HOME . "/web/product/include/tabMenu.inc.php"; // 탭버튼?>
			<iframe id="prod_qna_frame" src="<?php echo $strQnaSrc;?>" onload="autoResize(this)" width="100%" height="100%"  scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
			<?php endif;?>
		</div>
		<!-- QNA //-->
		<!-- 배송안내/교환반품 //-->
		<?php if($strProdDeliveryText):?>
		<div class="deliveryArea prodDetailDelivery mt30">
			<?php $select='delivery'; include MALL_HOME . "/web/product/include/tabMenu.inc.php"; // 탭버튼?>
			<div class="txtInfo mt20">
				<?php echo $strProdDeliveryText;?>
			</div>
			<div class="txtInfo mt20">
				<?php echo $strProdReturnText;?>
			</div>
		</div>
		<?php endif;?>
		<!-- 배송안내/교환반품 //-->
	</div>
	<?php endif;?>
	<!-- 상품설명 //-->
</div>

