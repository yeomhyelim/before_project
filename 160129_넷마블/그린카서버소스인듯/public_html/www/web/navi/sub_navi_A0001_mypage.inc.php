<?php
	## 기본설정
	$strSearchOrderStatus = $_GET['searchOrderStatus'];
	$strBCode = $_GET['b_code'];

	## 구분
	$strSelectName = "";
	if($strMenuType == "mypage" && $strMode == "buyList"){ $strSelectName = 1; }
	if($strMenuType == "mypage" && $strMode == "buyList" && $strSearchOrderStatus == "UI"){ $strSelectName = 2; }
	if($strMenuType == "mypage" && $strMode == "buyList" && $strSearchOrderStatus == "E"){ $strSelectName = 3; }
	if($strMenuType == "mypage" && $strMode == "buyList" && $strSearchOrderStatus == "R"){ $strSelectName = 4; }
	if($strMenuType == "community" && $strBCode == "MY_QNA"){ $strSelectName = 5; }
	if($strMenuType == "community" && $strBCode == "PROD_QNA"){ $strSelectName = 6; }
	if($strMenuType == "mypage" && $strMode == "auctionMyList"){ $strSelectName = 7; }
	if($strMenuType == "mypage" && $strMode == "cartMyList"){ $strSelectName = 8; }
	if($strMenuType == "mypage" && $strMode == "wishMyList"){ $strSelectName = 9; }
	if($strMenuType == "mypage" && $strMode == "pointList"){ $strSelectName = 10; }
	if($strMenuType == "mypage" && $strMode == "couponList"){ $strSelectName = 11; }
	if($strMenuType == "mypage" && $strMode == "myInfo"){ $strSelectName = 12; }
	if($strMenuType == "mypage" && $strMode == "droupout"){ $strSelectName = 13; }
	if($strMenuType == "mypage" && $strMode == "addrList"){ $strSelectName = 14; }

?>
<div class="subNaviWrap">
	<div class="maNavTit">
		<strong><?=$LNG_TRANS_CHAR["MW00048"]//마이페이지?></strong>
	</div>
	<div class="inNavBox">
		<ul>
			<li class="subNaviTitle"><?=$LNG_TRANS_CHAR["CW00016"] //구매관련?></li>
			<li><a href="./?menuType=mypage&mode=buyList" class="<?php if($strSelectName==1){echo "on";}?>"><?=$LNG_TRANS_CHAR["CW00085"] //주문내역 및 배송현황 ?></a></li>
			<li class="returnBtn"><a href="./?menuType=mypage&mode=buyList&searchOrderStatus=R" class="<?php if($strSelectName==4){echo "on";}?>"><?=$LNG_TRANS_CHAR["CW00020"] //반품/환불/취소?></a></li>
			<li class="menu-cart"><a href="./?menuType=mypage&mode=cartMyList" class="<?php if($strSelectName==8){echo "on";}?>"><?=$LNG_TRANS_CHAR["CW00003"] //장바구니?></a></li>
			<li class="menu-wish"><a href="./?menuType=mypage&mode=wishMyList" class="<?php if($strSelectName==9){echo "on";}?>"><?=$LNG_TRANS_CHAR["CW00005"] //담아둔 상품?></a></li>

			<li class="subNaviTitle"><?=$LNG_TRANS_CHAR["CW00021"] //문의현황?></li>
			<li><a href="./?menuType=community&mode=dataList&b_code=MY_QNA&myTarget=mypage&layout=mypage" class="<?php if($strSelectName==5){echo "on";}?>"><?=$LNG_TRANS_CHAR["CW00023"] //나의 1:1상담?></a></li>
			<li class="qnaBtn"><a href="./?menuType=community&mode=dataList&b_code=PROD_QNA&myTarget=mypage&layout=mypage" class="<?php if($strSelectName==6){echo "on";}?>"><?=$LNG_TRANS_CHAR["CW00024"] //나의 상품Q&A?></a></li>

			<li class="menu-my subNaviTitle"><?=$LNG_TRANS_CHAR["CW00022"] //MY?></li>
			<?if ($S_POINT_USE1 == "Y"){?>
				<li class="menu-point pointBtn"><a href="./?menuType=mypage&mode=pointList" class="<?php if($strSelectName==10){echo "on";}?>"><?=$LNG_TRANS_CHAR["CW00025"] //포인트 현황?></a></li>
			<?}?>
			<?if ($S_COUPON_USE == "Y"){?>
				<li class="menu-coupon couponBtn"><a href="./?menuType=mypage&mode=couponList" class="<?php if($strSelectName==11){echo "on";}?>"><?=$LNG_TRANS_CHAR["CW00026"] //쿠폰/보너스 쿠폰?></a></li>
			<?}?>
			<li class="menu-myinfo"><a href="./?menuType=mypage&mode=myInfo" class="<?php if($strSelectName==12){echo "on";}?>"><?=$LNG_TRANS_CHAR["CW00015"] //내정보?></a></li>
			<?if($S_SHOP_HOME=="demo1"):?>
			<li class="menu-droupout"><a href="./?menuType=mypage&mode=droupout" class="<?php if($strSelectName==13){echo "on";}?>"><?="회원 탈퇴 신청" //주소록관리?></a></li>
			<?endif;?>
			<li class="menu-address addressList"><a href="./?menuType=mypage&mode=addrList" class="<?php if($strSelectName==14){echo "on";}?>"><?=$LNG_TRANS_CHAR["OW00085"] //주소록?></a></li>
		</ul>
	</div>
<? include sprintf ( "%s%s/layout/html/customer_ico.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>

</div>

