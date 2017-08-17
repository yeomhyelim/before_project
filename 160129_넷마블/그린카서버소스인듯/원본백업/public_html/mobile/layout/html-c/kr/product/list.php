<?php
	## helper 설정
	include_once WEB_FRWORK_HELP."product.php";

	## 기본 설정
	$strSort = $_GET['sort'];

	## 카테고리 설정
	$strCate1 = $_GET['lcate'];
	$strCate2 = $_GET['mcate'];
	$strCate3 = $_GET['scate'];
	$strCate4 = $_GET['fcate'];
	$strCate = $strCate1 . $strCate2 . $strCate3 . $strCate4;
	$strCate = str_pad($strCate, 12, '0');

	## 스크립트 설정
	$aryScriptEx[]				= "/mobile/layout/common/js/product.list.js";

	## 페이지 출력 형식(skin) 설정
	$strProdListSkin = $_COOKIE['prodListSkin'];
	if(!$strProdListSkin) { $strProdListSkin = "prodThumbList"; }

?>
<script type="text/javascript">
	<!--
	$(function() {
		$('#allViewBox').on('click', function() {
			var gradeAllView = $('#popComGradeAllView');
			if(gradeAllView.css('display') == 'none') {
				gradeAllView.css('display', 'block');
			} else {
				gradeAllView.css('display', 'none');
			}
		});
	});
//-->
</script>
<div class="prodListBodyWrap">
	<div class="prodTitWrap">
		<?php
		$EUMSHOP_APP_INFO					= "";
		$EUMSHOP_APP_INFO['name']			= "상품이름";
		$EUMSHOP_APP_INFO['mode']			= "productLocation";
		$EUMSHOP_APP_INFO['skin']			= "lastNameSkin";
		$EUMSHOP_APP_INFO['cate1']			= $strCate1;
		$EUMSHOP_APP_INFO['cate2']			= $strCate2;
		$EUMSHOP_APP_INFO['cate3']			= $strCate3;
		$EUMSHOP_APP_INFO['cate4']			= $strCate4;
		$EUMSHOP_APP_INFO['lang']			= $S_SITE_LNG;
		$EUMSHOP_APP_INFO['prodCntShow']	= true;
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
		?>
	</div>
	<div class="locationNavWrap">
		<?php
		$EUMSHOP_APP_INFO				= "";
		$EUMSHOP_APP_INFO['name']		= "상품네비게이션";
		$EUMSHOP_APP_INFO['mode']		= "productLocation";
		$EUMSHOP_APP_INFO['cate1']		= $strCate1;
		$EUMSHOP_APP_INFO['cate2']		= $strCate2;
		$EUMSHOP_APP_INFO['cate3']		= $strCate3;
		$EUMSHOP_APP_INFO['cate4']		= $strCate4;
		$EUMSHOP_APP_INFO['location']	= "home;cate1;cate2;cate3;cate4";
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
		?>
		<!-- ul>
			<li class="homeImg"><img src="/himg/mobile/ico_home.png" alt="Kome"></li>
			<li>여성의류 > </li>
			<li>티셔츠/블라우스<span>(25,480)</span></li>
		</ul -->
	</div>
	<div class="subNaviWrap">
		<?php
		$EUMSHOP_APP_INFO				= "";
		$EUMSHOP_APP_INFO['name']		= "상품카테고리";
		$EUMSHOP_APP_INFO['mode']		= "productCateMenu";
		$EUMSHOP_APP_INFO['skin']		= "styleFixed2Skin";
		$EUMSHOP_APP_INFO['selectCate']	= $strCate;
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
		?>
		<!-- ul>
			<li class="navOn"><a href="#">일화인삼<span>(74)</span></a></li>
			<li><a href="#">코나커피<span>(59)</span></a></li>
			<li><a href="#">건강식품<span>(50)</span></a></li>
			<li><a href="#">제주특산물<span>(14)</span></a></li>
			<li><a href="#">가공식품<span>(24)</span></a></li>
			<li><a href="#">쌀/잡곡<span>(0)</span></a></li>
			<li><a href="#">일화해외<span>(17)</span></a></li>
		</ul>
		<div class="clr"></div -->
	</div>

	<?php
	$EUMSHOP_APP_INFO				= "";
	$EUMSHOP_APP_INFO['name']		= "상품탑이미지";
	$EUMSHOP_APP_INFO['mode']		= "productTopImage";
	include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
	?>

	<div class="sortWrap">
		<div class="selectSort">
			<select onChange="goProductListSortChangeMoveEvent(this)" data-select="<?php echo $strSort;?>">
				<option value="TD"><?php echo $LNG_TRANS_CHAR['PW00033']; // 신규등록순?></option>
				<option value="BD"><?php echo $LNG_TRANS_CHAR['PW00030']; // 판매인기도순?></option>
				<option value="SD"><?php echo $LNG_TRANS_CHAR['PW00031']; // 누적판매순?></option>
				<option value="RA"><?php echo $LNG_TRANS_CHAR['PW00034']; // 낮은가격순?></option>
				<option value="RD"><?php echo $LNG_TRANS_CHAR['PW00035']; // 높은가격순?></option>
			</select>
		</div>
		<div class="listType">
			<?php if($strProdListSkin == "prodThumbList"):?>
			<a href="javascript:goProductListClassChangeMoveEvent('prodThumbList')" data-mouseenter-show2="prod1" class="open"><img src="/upload/images/ico_m_thumbList.png" group="img1"></a>
			<a href="javascript:goProductListClassChangeMoveEvent('prodLineList')"  data-mouseenter-show2="prod2" class="close"><img src="/upload/images/ico_m_lineLine.png" group="img1"></a>
			<div id="prod1" group="prod"></div>
			<div id="prod2" group="prod" style="display:none"></div>
			<?php else:?>
			<a href="javascript:goProductListClassChangeMoveEvent('prodThumbList')" data-mouseenter-show2="prod1" class="close"><img src="/upload/images/ico_m_thumbList.png" group="img1"></a>
			<a href="javascript:goProductListClassChangeMoveEvent('prodLineList')"  data-mouseenter-show2="prod2" class="open"><img src="/upload/images/ico_m_lineLine.png" group="img1"></a>
			<div id="prod1" group="prod" style="display:none"></div>
			<div id="prod2" group="prod"></div>
			<?php endif;?>
		</div>
		<div class="clr"></div>
	</div>
	<div class="productAllView">
		<a href="#" class="btnAllViewBox" id="allViewBox"><?= $LNG_TRANS_CHAR["CW00112"]; //업체등급심사 안내 ?><span class="listOff"></span></a>
		<div id="popComGradeAllView" class="popComGradeAllView" style="display:none;">
			<div class="popProductAll">
				<div class="gradeBox">
					<h3><?= $LNG_TRANS_CHAR["CW00113"]; //판매등급 ?></h3>
					<ul>
						<li><img src="<?=$aryCreditGradeImg["G"]?>"><span><?= $LNG_TRANS_CHAR["CW00095"]; //골드 ?></span></li>
						<li><img src="<?=$aryCreditGradeImg["S"]?>"><span><?= $LNG_TRANS_CHAR["CW00096"]; //실버 ?></span></li>
						<li><img src="<?=$aryCreditGradeImg["B"]?>"><span><?= $LNG_TRANS_CHAR["CW00097"]; //일반 ?></span></li>
					</ul>
				</div>

				<div class="gradeBox">
					<h3><?= $LNG_TRANS_CHAR["CW00114"]; //신용등급 ?></h3>
					<ul>
						<li><img src="<?=$arySaleGradeImg["B"]?>"><span><?= $LNG_TRANS_CHAR["CW00098"]; //최우수 ?></span></li>
						<li><img src="<?=$arySaleGradeImg["E"]?>"><span><?= $LNG_TRANS_CHAR["CW00099"]; //우수 ?></span></li>
						<li><img src="<?=$arySaleGradeImg["G"]?>"><span><?= $LNG_TRANS_CHAR["CW00100"]; //일반 ?></span></li>
					</ul>
				</div>

				<div class="gradeBox lastBox">
					<h3><?= $LNG_TRANS_CHAR["CW00115"]; //현장확인 ?></h3>
					<ul>
						<li><img src="<?=$aryLocusGradeImg["Y"]?>"><span><?= $LNG_TRANS_CHAR["CW00101"]; //확인 ?></span></li>
						<li><img src="<?=$aryLocusGradeImg["N"]?>"><span><?= $LNG_TRANS_CHAR["CW00102"]; //미확인 ?></span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="prodList <?php echo $strProdListSkin;?>">
	<?php
		## 상품 리스트
		include_once MALL_HOME . "/mobile/product/productList.inc.php";
	?>
	</div>
</div>