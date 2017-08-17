<?
	## 샵 정보1
	require_once MALL_CONF_LIB."ShopMgr.php";
	$shopMgr				= new ShopMgr();
	$param					= "";
	$param['sh_no']			= $_REQUEST['sh_no'];
	$shopSiteRow			= $shopMgr->getShopSiteListEx($db, "OP_SELECT", $param);


	## 샵 정보2
	$param					= "";
	$param['sh_no']			= $_REQUEST['sh_no'];
	$shopRow				= $shopMgr->getShopListEx($db, "OP_SELECT", $param);
	

	## 미니샵 회원 정보
	$param					= "";
	$param['sh_no']			= $_REQUEST['sh_no'];
	$param['su_type']		= "A";
	$shopMemberRow			= $shopMgr->getShopUserListEx($db, "OP_SELECT", $param);
	$shopMemberRow['NAME']	= "{$shopMemberRow['M_F_NAME']}{$shopMemberRow['M_L_NAME']}";

	## 샵 평점
	$param					= "";
	$param['P_SHOP_NO']		= $_REQUEST['sh_no'];
	$shopAverageRow			= $shopMgr->getShopAverageEx($db, $param);
	
	## 미니샵 상점이미지
	$shopTopImg				= "";
	if($shopSiteRow['ST_IMG']):
		$shopTopImg			= "/upload/shop/store_{$_REQUEST['sh_no']}/design/{$shopSiteRow['ST_IMG']}";
	endif;

	## 미니샵 상점이미지
	$shopMainImg			= "";
	if($shopSiteRow['ST_THUMB_IMG']):
		$shopMainImg		= "/upload/shop/store_{$_REQUEST['sh_no']}/design/{$shopSiteRow['ST_THUMB_IMG']}";
	endif;


?>
	<!-- start: topArea -->
		<div id="minishopTopArea">
			<div id="minishopTopWrap">
				<div class="minishopGlbInfo">
					<strong><?=$shopSiteRow['ST_NAME']; // 미니샵명?></strong>
					<a class="btnShopInfo" data-mouseEnter-show-mouseOver-hidden="sellerInfoArea"><?=$LNG_TRANS_CHAR["MN00005"] //판매자정보?></a> | <img src="/upload/images/icon_star_<?=ceil($shopAverageRow['AVERAGE'])?>.png"/>
					<div id="sellerInfoArea" style="display:none">
						<ul>
							<li><span><?=$LNG_TRANS_CHAR["MW00032"] //상호?></span>: <?=$shopSiteRow['ST_NAME']?></li>
							<li><span><?=$LNG_TRANS_CHAR["MW00064"] //대표자?></span>: <?=$shopRow['SH_COM_NAME']?></li>
							<li><span><?=$LNG_TRANS_CHAR["OW00016"] //전화번호?></span>: <?=$shopRow['SH_COM_PHONE']?></li>
							<li><span><?=$LNG_TRANS_CHAR["MN00006"] //응대가능시간?></span>: 11시-17시</li>
							<li><span><?=$LNG_TRANS_CHAR["MW00017"] //팩스번호?></span>: <?=$shopRow['SH_COM_FAX']?></li>
							<li><span><?=$LNG_TRANS_CHAR["OW00011"] //E-mail?></span>: <?=$shopRow['SH_COM_MAIL']?></li>
							<li><span><?=$LNG_TRANS_CHAR["MW00033"] //사업자번호?></span>: <?=$shopRow['SH_COM_NUM']?></li>	
						</ul>
					</div>
				</div>
			</div>
		</div>
	<!-- end: topArea -->

	<!-- start: 미니샵 로고영역 -->
		<?if($shopTopImg):?>
		<div class="logoWrap">
			<img src="<?=$shopTopImg?>"/>
		</div>
		<?endif;?>
	<!-- end: 미니샵 로고영역 -->

	<!-- start 메뉴 영역 -->
		<div id="minishopNavWrap">
			<div class="mnNav">
				<a href="./?menuType=minishop&mode=main&sh_no=<?=$_REQUEST['sh_no']?>"				data-menu-selected-id="main"><?=$LNG_TRANS_CHAR["MN00001"] //미니샵홈?></a> 
				<a href="./?menuType=minishop&mode=sellerProdList&sh_no=<?=$_REQUEST['sh_no']?>"	data-menu-selected-id="sellerProdList"><?=$LNG_TRANS_CHAR["MN00002"] //판매자상품보기?></a> 
				<a href="./?menuType=minishop&mode=sellerProdReviewList&sh_no=<?=$_REQUEST['sh_no']?>"	data-menu-selected-id="sellerProdReview"><?=$LNG_TRANS_CHAR["MN00003"] //상품평?></a> 
				<a href="./?menuType=minishop&mode=sellerInfo&sh_no=<?=$_REQUEST['sh_no']?>"		data-menu-selected-id="sellerInfo"><?=$LNG_TRANS_CHAR["MN00004"] //판매자소개?></a>
			</div>
			<div class="minishopSearchWrap">
				<input type="text" name="searchKey" value="<?=$_REQUEST['searchKey']?>" data-auto-focus data-enter-event="goSearch"/><a href="javascript:goSearch()" class="btnSearch"><span>Search</span></a>
			</div>
			<div class="clr"></div>
		</div>
	<!-- end: 메뉴 영역 -->