<div class="tabSubNaviWrap">
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=buyList" <?if($strSubPageDesign == "buyList") { echo "class='selected'"; } ?>>회원 구매내역</a> |	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=buyNonList" <?if($strSubPageDesign == "buyNonList") { echo "class='selected'"; } ?>>비회원구매내역</a> |	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=buyView" <?if($strSubPageDesign == "buyList") { echo "class='selected'"; } ?>>회원 구매내역 상세</a> |	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=buyNonView" <?if($strSubPageDesign == "buyNonList") { echo "class='selected'"; } ?>>비회원구매내역 상세</a> |
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=cartMyList" <?if($strSubPageDesign == "cartMyList") { echo "class='selected'"; } ?>>장바구니</a> |	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=wishMyList" <?if($strSubPageDesign == "wishMyList") { echo "class='selected'"; } ?>>담아둔 상품</a> |		
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=pointList" <?if($strSubPageDesign == "pointList") { echo "class='selected'"; } ?>>포인트관리</a> |		
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=couponList" <?if($strSubPageDesign == "couponList") { echo "class='selected'"; } ?>>쿠폰관리</a> |		
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=myInfo" <?if($strSubPageDesign == "myInfo") { echo "class='selected'"; } ?>>내정보변경</a> |
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=addrList" <?if($strSubPageDesign == "addrList") { echo "class='selected'"; } ?>>주소록관리</a> |
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=community" <?if($strSubPageDesign == "community") { echo "class='selected'"; } ?>>마이커뮤니티</a>

	<?if ($S_PRODUCT_AUCTION_USE == "Y"){?>
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=auctionMyList" <?if($strSubPageDesign == "auctionMyList") { echo "class='selected'"; } ?>> | 경매리스트</a>
	<?}?>
</div>