<?
	# 상품 다중이미지로 표시(B)
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 
	include "prodView.MultyImage.OpenWindow.skin.js.php";
?>

<div class="zoomPopWrap<?=$strZoomPosition?>"> 
	<div class="popTitleWrap">
		<h3><?=$strP_NAME?></h3>
		<a href="javascript:goClose();"><img src="/himg/common/btn_pop_close_white.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>
	<div class="zoomImg"><a href="javascript:goClose();"><img src="" class="selectImage" id="selectImage" style="height:500px"/></a></div>
	<div class="popProdThumbList">
		<!-- start: thumb nail images -->
			<? for($i=0;$i<$intMListH;$i++): ?>
				<? for($j=0;$j<$intMListW;$j++):	?>
					<div class="thumbList">
					<? $row = mysql_fetch_array($aryMResult); 
						if($row):
						$no		= str_replace("view", "", $row['PM_TYPE']);
						$zImg	= $aryZResult["large{$no}"];
						if(!$zImg) { $zImg = $row['PM_REAL_NAME']; }		?>
						<!-- 코딩 -->
						<img src="<?=$row['PM_REAL_NAME']?>" id="selectImageClickEvent" zImg="<?=$zImg?>"/>
						<!-- 코딩 -->
					<? endif; ?>
					</div>
				<? endfor;	?>
			<? endfor; ?>
		<!-- start: thumb nail images -->
	</div>
	<div class="clear"></div>
	<div class="popInfoBottom"></div>
</div>


