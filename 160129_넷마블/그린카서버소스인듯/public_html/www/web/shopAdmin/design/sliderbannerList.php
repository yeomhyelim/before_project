<div class="contentTop">
	<h2>움직이는 배너 관리</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<div class="tableList mt20">
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col style="width:40px;">				
				<col style="width:200px;">
				<col/>
				<col/>
				<col style="width:10%;">
			</colgroup>
			<tr>
				<th>번호</th>
				<th>예약어</th>
				<th>이미지</th>
				<th>등록이미지수</th>
				<th>관리</th>
			</tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
				<tr>
					<td colspan="9">등록된 데이터가 없습니다.</td>
				</tr>		
			<?}?>
			<?
				while($row = mysql_fetch_array($result)){					
			?>
			<tr>
				<td><?=$intListNum--?></td>
				<td>{{__<?=$row[SB_BANNER_NAME]?>__}}</td>
				<td>
					<?
						$bImage = "<img src='../upload/slider/".$row[SB_IMAGE_FILE_1]." 'style='width:200px;'/>";
						echo $bImage;
					?>
				</td>
				<td><?=$row[SB_IMAGES_CNT]?></td>
				<td>
					 <a class="btn_blue_sml" href="javascript:goMoveUrl('sliderbannerModify',<?=$row[SB_NO]?>)" id="menu_auth_m" ><strong>수정</strong></a> 
					 <a class="btn_sml" href="javascript:goMoveUrl('sliderbannerDelete',<?=$row[SB_NO]?>);" id="menu_auth_d"><strong>삭제</strong></a> 
				</td>
			</tr>
			<?
				}
			?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate" style="width:400px;padding:0px 5px;">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object -->
	

	<div class="buttonWrap">
		<a class="btn_big" href="./?menuType=design&mode=sliderbannerWrite" id="menu_auth_m"><strong>슬라딩배너 추가</strong></a>
		<a class="btn_blue_big" href="./?menuType=design&mode=sliderbannerWrite" id="menu_auth_m"><strong>슬라이딩 배너 쇼핑몰에 적용하기</strong></a>
	</div>