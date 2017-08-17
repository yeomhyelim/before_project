<div class="contentTop">
	<h2>페이지 상단영역 관리</h2>
</div>

<!-- ******** 컨텐츠 ********* -->
	<div class="imageListTable mt20">
		<table>
			<tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
				<tr>
					<td colspan="9">등록된 데이터가 없습니다.</td>
				</tr>		
			<?}?>
			<?	$cnt = 1;
				while($row = mysql_fetch_array($result)){	
				if($cnt%3 == "0") echo "<tr>";
			?>
				<td>
					<?
						if($row[TI_TOP_IMAGE]) :
							echo "<img src='../upload/subtopimg/".$row[TI_TOP_IMAGE]." 'style='width:500px;'/>";
						endif;
					?>
					<ul>
						<li>
							<a href="javascript:goMoveUrl('subtopModify',<?=$row[TI_NO]?>)" id="menu_auth_m" >수정</a> |
							<a href="javascript:goMoveUrl('subtopDelete',<?=$row[TI_NO]?>);" id="menu_auth_d">삭제</a>
						</li>
					</ul>
				</td>
			<?
				//echo $cnt%6;
				if($cnt%3 == "2") echo "</tr>";	
				$cnt++;
				}//while ?>
			
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate" style="width:400px;padding:0px 5px;">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object -->
	

	<div class="buttonWrap">
		<a class="btn_big" href="./?menuType=design&mode=subtopWrite" id="menu_auth_m"><strong>등록하기</strong></a>
		<a class="btn_blue_big" href="./?menuType=design&mode=subtopWrite" id="menu_auth_m"><strong>쇼핑몰에 적용하기</strong></a>
	</div>