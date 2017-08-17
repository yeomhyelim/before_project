<?php

require_once MALL_CONF_LIB."CateMgr.php";
$cateMgr		= new CateMgr();
$cateMgr->setCL_LNG($S_SITE_LNG);
	## class 설정
	$strStyleDivName = "bestList{$no}";
include sprintf( "%s/www/include/shopCom.conf.inc.php", $S_DOCUMENT_ROOT);
?>

<div class="<?php echo $strStyleDivName;?>">
	<div id="ca-container1" class="ca-container" STYLE="border:2px;">
		<span class="ca-nav-prev"><a><span>Previous</span></a></span>
		<span class="ca-nav-next"><a><span>Next</span></a></span>
		<div class="ca-wrapper">
		<?php for($i=0;$i<$intHList;$i++):?>
		<?php for($j=0;$j<$intWList;$j++):?>
		<?php $row = mysql_fetch_array($shopResult);?>
		<?php if($row):?>
		<?php 
		$productMgr->setP_SHOP_NO($row[SH_NO]);
		$productMgr -> setP_LNG($strLang);
		$productCode = $productMgr->getShopProduct($db);

		if($productCode[P_CODE]){
			//$strProdView = "javascript:goProdView('".$productCode[P_CODE]."');";
			$strProdView = "./?menuType=product&mode=view&prodCode=".$productCode[P_CODE]."&comView=Y";
		}else{
			$strProdView = "#";
		}

		if(strP_CODE)

		//PRINT_R($row);
				## 기본 설정
				$strSH_COM_NAME				= $row['SH_COM_NAME']; // 사업자명
				$strSH_COM_CREDIT_GRADE		= $row['SH_COM_CREDIT_GRADE']; // 신용등급
				$strSH_COM_SALE_GRADE		= $row['SH_COM_SALE_GRADE']; // 판매등급
				$strSH_COM_LOCUS_GRADE		= $row['SH_COM_LOCUS_GRADE']; // 현장확인
				$strSH_COM_CATEGORY			= $row['SH_COM_CATEGORY']; // type
		?>
		<div class="ca-item">
			<div class="productInfoWrap">
				<div class="bestIco_<?php echo $j+1;?>"></div>
				<a href="<?=$strProdView?>"><img src="<?="/upload/shop/file4/{$row['SH_COM_FILE4']}"?>" class="listProdImg"/></a>
				<ul class="prodInfoTxt">
					<li class="title"><?php echo $strSH_COM_NAME; // 사업자명?></li>
					<li class="com"><?php echo $aryType[$strSH_COM_CATEGORY]; // type?></li>

					<li class="shopIcoWrap">
						<img src="<?php echo $aryCreditGradeImg[$strSH_COM_CREDIT_GRADE]; // 신용등급?>"/>
						<img src="<?php echo $arySaleGradeImg[$strSH_COM_SALE_GRADE]; // 판매등급?>" />
						<img src="<?php echo $aryLocusGradeImg[$strSH_COM_LOCUS_GRADE]; // 현장확인?>" />
					</li>					
				</ul>
			</div>
		</div>
		<?php endif;?>
		<?php endfor;?>
		<?php endfor;?>
		</div>
	</div>
</div>
<script type="text/javascript" src="../common/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../common/js/jquery.contentcarousel.js"></script>
<script type="text/javascript">
	$('#ca-container1').contentcarousel({
		sliderSpeed     : 500,
		sliderEasing    : 'easeOutExpo',
		itemSpeed       : 500,
		itemEasing      : 'easeOutExpo',
		scroll          : 1				
	});
</script>
