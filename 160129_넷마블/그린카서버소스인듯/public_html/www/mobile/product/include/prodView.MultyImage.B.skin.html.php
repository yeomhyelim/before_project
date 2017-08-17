<?
	# 상품 다중이미지로 표시(B)
	include "prodView.MultyImage.skin.js.php";
?>

<style>
	div.multyImageListWrap {margin-top:10px;width:<?=$intVSizeW?>px;}
	div.multyImageListWrap img {width:<?=$intMSizeW?>px;height:<?=$intMSizeH?>px;border:3px solid #e5e5e5}
	div.multyImageListWrap td{padding: 5px;}
	div.multyImageSelect .selectImage {width:<?=$intVSizeW?>px;height:<?=$intVSizeH?>px}
</style>

<div class="multyImageSelect"><!--상품 메인 이미지-->
	<img src="<?=$strViewImg?>" class="selectImage" id="selectImage" /><br>
</div>

<div class="multyImageListWrap"><!--상품 다중 이미지-->
	<center>
		<table>
			<? for($i=0;$i<$intMListH;$i++): ?>
			<tr>
				<? for($j=0;$j<$intMListW;$j++):	?>
				<td>
					<? $row = mysql_fetch_array($aryMResult); 
					   if($row):					?>
						<!-- 코딩 -->
						<a><img src="<?=$row['PM_REAL_NAME']?>" id="selectImageClickEvent"/></a>
						<!-- 코딩 -->
					<? endif; ?>
				</td>
				<? endfor;	?>
			</tr>
			<? endfor; ?>
		</table>
	</center>
</div>

