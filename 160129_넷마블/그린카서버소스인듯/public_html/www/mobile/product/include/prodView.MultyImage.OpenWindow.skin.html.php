<?
	# 상품 다중이미지로 표시(B)
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 
	include "prodView.MultyImage.OpenWindow.skin.js.php";
?>

<style>
	body{margin:0px;padding:0px;font-size:12px;}


	div.popTitleWrap{padding: 10px;height:30px;background: url(/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/bg_pop_tit.gif) left top repeat-x;}
	div.popTitleWrap h3{float:left;color:#FFF;}
	div.popTitleWrap a{display:inline-block;float:right;}



	/* 오른쪽 메뉴 */
	div.zoomPopWrapRight ul{margin:10px 20px;}
	div.zoomPopWrapRight li.zoomImg img{width:500px;}

	div.zoomPopWrapRight li.thumbImgList{margin:10px;}
	div.zoomPopWrapRight li.thumbImgList img{width:80px;margin:10px;}

	/* 아래쪽 메뉴 */
	div.zoomPopWrapBottom ul{margin:10px 20px;}
	div.zoomPopWrapBottom li.zoomImg img{width:500px;}

	div.zoomPopWrapBottom li.thumbImgList{margin:10px;}
	div.zoomPopWrapBottom li.thumbImgList img{width:80px;margin:10px;}
</style>

<div class="zoomPopWrap<?=$strZoomPosition?>"> 
	<div class="popTitleWrap">
		<h3><?=$strP_NAME?></h3>
		<a  href="javascript:goClose();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>
	<ul>
	
		<li class="zoomImg"><img src="" class="selectImage" id="selectImage"/></li>
		<!-- start: thumb nail images -->
		<li class="thumbImgList">
			<table>
				<? for($i=0;$i<$intMListH;$i++): ?>
				<tr>
					<? for($j=0;$j<$intMListW;$j++):	?>
					<td>
						<? $row = mysql_fetch_array($aryMResult); 
						   if($row):					?>
							<!-- 코딩 -->
							<img src="<?=$row['PM_REAL_NAME']?>" id="selectImageClickEvent"/>
							<!-- 코딩 -->
						<? endif; ?>
					</td>
					<? endfor;	?>
				</tr>
				<? endfor; ?>
			</table>
		</li>
		<!-- start: thumb nail images -->
	</ul>
	<div class="clear"></div>
</div>


