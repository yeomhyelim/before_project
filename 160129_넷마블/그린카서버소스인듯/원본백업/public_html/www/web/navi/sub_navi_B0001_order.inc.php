<?if ($g_member_no){?>
<div class="subNaviWrap">
	<div class="title"><img src="./himg/product/<?=$D_LAYOUT_HIMG?>/<?=$S_SITE_LNG_PATH?>/tit_sub_title_mypage.gif"/></div>
	<ul>
		<li><a href="./?menuType=order&mode=buyList"><?=$LNG_TRANS_CHAR["CW00013"] //구매내역?></a></li>
		<li><a href="./?menuType=order&mode=cartMyList"><?=$LNG_TRANS_CHAR["CW00003"] //장바구니?></a></li>
		<li><a href="./?menuType=order&mode=wishMyList"><?=$LNG_TRANS_CHAR["CW00005"] //담아둔 상품?></a></li>
		<li><a href="./?menuType=order&mode=pointList"><?=$LNG_TRANS_CHAR["CW00025"] //포인트관리?></a></li>
		<li><a href="./?menuType=order&mode=couponList"><?=$LNG_TRANS_CHAR["CW00014"] //쿠폰관리?></a></li>
		<li><a href="./?menuType=order&mode=myInfo"><?=$LNG_TRANS_CHAR["CW00015"] //내정보변경?></a></li>
	</ul>
</div>
<?}?>