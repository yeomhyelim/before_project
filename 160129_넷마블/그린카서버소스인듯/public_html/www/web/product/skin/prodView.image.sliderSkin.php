<?php

	## 스크립트 설정
	$aryScriptEx[] = "/common/bxslider-4-master/jquery.bxslider.js";
	$aryScriptEx[] = "/common/js/product/skin/prodView.image.sliderSkin.js";

	## 모듈 설정
	$objProductImgModule = new ProductImgModule($db);

	## 기본설정
	$strPCode = $_GET['prodCode'];
	$intImageW = $S_PRODUCT_VIEW_ISW; // 상품 이미지 가로 크기
	$intImageH = $S_PRODUCT_VIEW_ISH; // 상품 이미지 세로 크기
	$intPageW = $S_PRODUCT_IMG_MULTY_SIZE_W; // 상품 페이징 이미지 가로 크기
	$intPageH = $S_PRODUCT_IMG_MULTY_SIZE_H; // 상품 페이징 이미지 세로 크기

	## 체크
	if(!$strPCode) { return; }

	## 상품 이미지 불러오기
	$param = "";
	$param['P_CODE'] = $strPCode;
	$aryProdImgList = $objProductImgModule->getProductImgSelectEx("OP_ARYTOTAL", $param);

	## 상품 이미지 정리
	$aryProdImg = "";
	if($aryProdImgList):
		foreach($aryProdImgList as $key => $row):
			## 기본설정
			$strPM_TYPE = $row['PM_TYPE'];
			$strPM_REAL_NAME = $row['PM_REAL_NAME'];
			$strTypeGroup = $S_PROD_IMG_GROUP[$strPM_TYPE];
			$aryProdImg[$strTypeGroup][$strPM_TYPE] = $strPM_REAL_NAME;
		endforeach;
	endif;
	$aryProdImgView = $aryProdImg['view'];

	## 상품 이미지 스타일 설정
	$strProdImgStyle = "";
	if($intImageW) { $strProdImgStyle .= "width:{$intImageW}px;"; }
	if($intImageH) { $strProdImgStyle .= "height:{$intImageH}px;"; }

	## 상품 페이징 이미지 스타일 설정
	$strProdImgPageStyle = "";
	if($intPageW) { $strProdImgPageStyle .= "width:{$intPageW}px;"; }
	if($intPageH) { $strProdImgPageStyle .= "height:{$intPageH}px;"; }
?>
<?php if(!$aryProdImgView):?>
<p>상품 이미지가 없습니다.</p>
<?php else:?>
<div class="detailImageView">
	<div class="multyImageSelect">
		<ul class="sliderImage">
			<?php foreach($aryProdImgView as $key => $img):?>
			<li><img src="<?php echo $img;?>" class="selectImage" id="selectImage" style="<?php echo $strProdImgStyle;?>"></li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="multyImageListWrap sliderPage">
		<?php $i = 0;?>
		<?php foreach($aryProdImgView as $key => $img):?>
		<a data-slide-index="<?php echo $i++;?>" href=""><img src="<?php echo $img;?>" style="<?php echo $strProdImgPageStyle;?>"/></a>
		<?php endforeach;?>
	</div>
	<div class="clear"></div>
</div>
<?php endif;?>