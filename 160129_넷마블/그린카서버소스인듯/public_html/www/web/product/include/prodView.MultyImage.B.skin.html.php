<?
	# 상품 다중이미지로 표시(B)
	include "prodView.MultyImage.skin.js.php";
?>
<div class="detailImageView">
	<div class="multyImageSelect"><!--상품 메인 이미지-->
		<img src="<?=$strViewImg?>" class="selectImage" id="selectImage" style="width:<?=$intVSizeW?>px;height:<?=$intVSizeH?>px"/>
	</div>

	<div class="multyImageListWrap"><!--상품 다중 이미지-->
		<? 
		for($i=0;$i<$intMListH;$i++): ?>
			<? for($j=0;$j<$intMListW;$j++):	?>
			<div class="imgThumbList">
				<? $row = mysql_fetch_array($aryMResult); 
				   if($row):					
					 if(substr($row['PM_TYPE'], 0,4) != "view") { continue; }
					 $no		= str_replace("view", "", $row['PM_TYPE']);
					 $zImg	= $aryZResult["large{$no}"];
					 if(!$zImg) { $zImg = $row['PM_REAL_NAME']; }		?>
					 <?if($PRODUCT_VIEW_IMAGE_MOUSEOVER_EVENT == "NO"):?>
					<img src="<?=$row['PM_REAL_NAME']?>" id="selectImageOverEvent" style="width:<?=$intMSizeW?>px;height:<?=$intMSizeH?>px;" zImg="<?=$zImg?>"/>
					 <?else:?>
					<a><img src="<?=$row['PM_REAL_NAME']?>" id="selectImageClickEvent" style="width:<?=$intMSizeW?>px;height:<?=$intMSizeH?>px;" zImg="<?=$zImg?>"/></a>
					 <?endif;?>
				<? endif; ?>
			</div>
			<? endfor;	?>
		<? endfor; ?>
	</div>
	<div class="clear"></div>
</div>
