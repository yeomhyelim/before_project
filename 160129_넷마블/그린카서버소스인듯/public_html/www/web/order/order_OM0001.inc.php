<!-- (2) 상단 서브 카테고리 -->
<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
<!-- (2) 상단 서브 카테고리 -->

<div class="leftWrap mt20">
	<div class="subNavi">

		<?include sprintf("%snavi/%s", MALL_WEB_PATH, "sub_navi_A0001_mypage.inc.php" ); ?>
	</div>	
</div>
<div class="cartWrap">
	<div class="joinWrap mt20">
		<!-- (1) 기본정보 입력  -->
			<div class="regWrap">
				<?include MALL_WEB_PATH."order/memberModifyForm.inc.php";?>
			</div>
		<!-- (1) 기본정보 입력  -->

	</div><!-- loginFormWrap -->
	<div class="btnCenter">
		<a href="javascript:goMyInfoModify();"><img src="/himg/mypage/A0001/<?=$S_SITE_LNG_PATH?>/btn_myinfo_modify.gif"/></a>
		<a href="javascript:C_getMoveUrl('buyList','get','<?=$PHP_SELF?>');"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_page_prev.gif"/></a>
		<!--
		<a href="join_form_end.php"><img src="/himg/STL.AT001/mypage/btn_myinfo_modify.gif"/></a>
		<a href="join_form.php"><img src="/himg/STL.AT001/member/btn_page_prev.gif"/></a>
		-->
	</div>
</div>
<div class="clear"></div>