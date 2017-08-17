<?include "{$S_DOCUMENT_ROOT}www/include/header.inc.php"?>
<?

	## STEP 1.
	## 미니샵 사용 유무 체크
	$minishopUse = $PRODUCT_VIEW_MINISHOP_USE;				// 미니샵 사용 하는 경우 코드 수행
	if(!$_REQUEST['sh_no']) { $minishopUse = "N"; }			// 미니샵 회원이 아닌 경우.

	if($minishopUse != "Y"):
		echo "메일 보내기를 사용 할 수 없습니다.";
		exit;
	endif;

	## STEP 2.
	## 상점 정보
	require_once MALL_CONF_LIB."ShopMgr.php";
	$shopMgr				= new ShopMgr();
	$shopMgr->setSH_NO($_REQUEST['sh_no']);
	$storeRow				= $shopMgr->getStoreView($db);

	## STEP 3.
	## 구매만족도
	$param					= "";
	$param['P_SHOP_NO']		= $prodRow['P_SHOP_NO'];
	$averageRow				= $shopMgr->getShopAverageEx($db, $param);

	## STEP 3.
	## 상점 상품 5개 랜덤 리스트
	require_once MALL_CONF_LIB."ProductMgr.php";
	$productMgr				= new ProductMgr();
	$param					= "";
	$param['P_SHOP_NO']		= $prodRow['P_SHOP_NO'];
	$param['ORDER_BY']		= "rand()";
	$param['LIMIT']			= "0,5";
	$shopProduct_result = $productMgr->getProdListEx($db, "OP_LIST", $param);

	## STEP 4.
	## 설정
	$minishopImg = "/himg/product/A0001/photo_minishop.gif";
	if($storeRow['ST_LOGO']) { $minishopImg = "/upload/shop/store_4/design/{$storeRow['ST_LOGO']}"; }

	## 평점
	$average = round($averageRow['AVERAGE']);
	if(!$average) { $average = 0; }
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){


	});

	function goMailWriteActEvent() { goMailWriteAct(); }

	function goMailWriteAct() {
		if(!C_chkInput("name",true,"이름",true)) { return; }
		if(!C_chkInput("mail",true,"메일주소",true)) { return; }
		if(!C_chkInput("title",true,"제목",true)) { return; }
		if(!C_chkInput("text",true,"내용",true)) { return; }
		C_getAction("paperMailForMinishop","<?=$PHP_SELF?>");
	}
//-->
</script>
</head>
<body>
	<form name="form" method="post" id="form">
	<input type="hidden" name="menuType" value="message">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="prodCode" value="<?=$_REQUEST['prodCode']?>">
	<input type="hidden" name="sh_no" value="<?=$_REQUEST['sh_no']?>">

	<div class="popInfoWrap">
		<h4><?=$LNG_TRANS_CHAR["PW00043"] //판매자 정보?></h4>
		<div class="sellerInfo">
			<a href="/minishop/" target="_blank"><img src="<?=$minishopImg?>" class="shopPhoto"></a>
			<ul>
				<li class="shopName"><strong><?=$storeRow['ST_NAME_ENG']?></strong></li>
				<li class="rateWrap">
					<span><?=$LNG_TRANS_CHAR["PW00045"] //구매만족도?></span>
					<img src="/upload/images/icon_star_<?=$average?>.png" class="starIcon">
				</li>
			</ul>
			<div class="clr"></div>
		</div>

		<div class="messageForm">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["CW00053"] //작성자?></th>
					<td><input type="text" name="name" id="name" class="messageTit" value="<?=$g_member_name?> <?=$g_member_last_name?>" readOnly/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00010"] //메일주소?></th>
					<td><input type="text" name="mail" id="mail" class="messageTit" value="<?=$g_member_email?>" readOnly/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["CW00062"] //제목?></th>
					<td><input type="text" name="title" id="title" id="mp_title" class="messageTit"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["CW00063"] //내용?></th>
					<td><textarea name="text" id="text" class="messageForm"></textarea></td>
				</tr>
			</table>
		</div>
		<div class="btnCenter">
			<a href="javascript:goMailWriteActEvent()" class="sendMsg"><span><?=$LNG_TRANS_CHAR["CW00066"] //보내기?></span> </a>
			<a href="javascript:self.close()" class="cancelMsg"><span><?=$LNG_TRANS_CHAR["MW00044"] //취소?></span> </a>
		</div>
	</div>
	</form>
</body>
</html>