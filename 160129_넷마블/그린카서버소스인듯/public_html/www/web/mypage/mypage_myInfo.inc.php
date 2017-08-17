	<h4 class="titMemInfo"><span><?=$LNG_TRANS_CHAR["CW00015"] //내 정보?></span></h4>
	<div class="joinWrap">
		<!-- (1) 기본정보 입력  -->
			<?include MALL_WEB_PATH."mypage/memberModifyForm.inc.php";?>
		<!-- (1) 기본정보 입력  -->
	</div><!-- loginFormWrap -->

	<div class="btnCenter">		
		<a href="javascript:goMyInfoModify();" class="okBigBtn"><span><?=$LNG_TRANS_CHAR["OW00113"] //저장?></span></a>
		<a href="javascript:C_getMoveUrl('buyList','get','<?=$PHP_SELF?>');" class="cancelBigBtn"><span><?=$LNG_TRANS_CHAR["MW00044"] //취소?></span></a>		
	</div>