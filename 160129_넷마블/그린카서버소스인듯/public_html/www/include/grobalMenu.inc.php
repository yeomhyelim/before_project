<div class="glbNavWrap">
	<? if ($g_member_no){?>
		<a href="./?menuType=member&mode=act&act=logout"><img src="../himg/layout.<?=$S_DESIGN_LAYOUT?>/btn_glo_logout.gif"/><span class="txtHidden"><?=$LNG_TRANS_CHAR["MW00054"] //로그아웃?></span></a> <span class="txtHidden">|</span>
	<?}else{?>
		<a href="./?menuType=member&mode=login"><img src="../himg/layout.<?=$S_DESIGN_LAYOUT?>/btn_glo_login.gif"/><span class="txtHidden"><?=$LNG_TRANS_CHAR["MW00036"] //로그인?></span></a> <span class="txtHidden">|</span>
		<a href="./?menuType=member&mode=join1"><img src="../himg/layout.<?=$S_DESIGN_LAYOUT?>/btn_glo_join.gif"/><span class="txtHidden"><?=$LNG_TRANS_CHAR["MW00053"] //회원가입?></span></a> <span class="txtHidden">|</span>
	<?}?>
	<a href="./?menuType=order&mode=cart"><img src="../himg/layout.<?=$S_DESIGN_LAYOUT?>/btn_glo_cart.gif"/><span class="txtHidden"><?=$LNG_TRANS_CHAR["CW00003"] //장바구니?></span></a> <span class="txtHidden">|</span>
	<!--a href="./?menuType=order&mode=order"><span class="imgHidden"><img src="../himg/<?=$S_DESIGN_LAYOUT?>/btn_glo_order.gif"/></span><span class="txtHidden">주문조회</span></a> <span class="txtHidden">|</span -->
	<a href="./?menuType=mypage&mode=buyList"><img src="../himg/layout.<?=$S_DESIGN_LAYOUT?>/btn_glo_mypage.gif"/><span class="txtHidden"><?=$LNG_TRANS_CHAR["MW00048"] //마이페이지?></span></a> 
	<span class="txtHidden">|</span>
	<a href="./?menuType=community&b_code=NOTICE"><span class="imgHidden"><img src="../himg/layout.<?=$S_DESIGN_LAYOUT?>/btn_glo_center.gif"/></span><span class="txtHidden"><?=$LNG_TRANS_CHAR["CW00043"]  //고객센터?></span></a>
</div>