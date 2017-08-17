<div class="contentTop">
	<h2>
		<?=$LNG_TRANS_CHAR["BW00163"] //음직이는 배너 관리?>
		<div class="clr"></div>
	</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<div class="tableList">
	<div>
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col style="width:40px;">
				<col style="width:200px;">	
				<col/>
				<col style="width:200px;">
				<col style="width:10%;">
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["BW00164"] //코드?></th>
				<th><?=$LNG_TRANS_CHAR["BW00165"] //설명?></th>
				<th><?=$LNG_TRANS_CHAR["BW00166"] //링크타입?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
				<tr>
					<td colspan="9"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
				</tr>		
			<?}?>
			<?
				$aryLinkType = array("M" => $LNG_TRANS_CHAR["BW00167"], "B" => $LNG_TRANS_CHAR["BW00168"], "N" => $LNG_TRANS_CHAR["BW00169"]); //"현재 페이지 열기":"새창으로 열기":"연결 없음"
				while($row = mysql_fetch_array($result)){		
				$setKeyWord = sprintf("{{__sliderBanner_%s_%d__}}", $row['IM_CODE'], $row['SB_NO']);
			?>
			<tr>
				<td><?=$intListNum--?></td>
				<td><?=$row['IM_CODE']?></td>
				<td><?=$row['SB_COMMENT']?></td>
				<td><?=$aryLinkType[$row['SB_LINK_TYPE']]?></td>
				<td>
					 <a class="btn_blue_sml" href="javascript:goMoveUrl('sliderBannerModify',<?=$row['SB_NO']?>)" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a> 
					 <a class="btn_sml" href="javascript:goMoveUrl('sliderBannerDelete',<?=$row['SB_NO']?>);" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a> 
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
		<a class="btn_blue_big" href="./?menuType=layout&mode=sliderBannerWrite" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00028"] //슬라딩배너 추가?></strong></a>	
	</div>
