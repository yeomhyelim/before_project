<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00026"] //배너 그룹 관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
			<input type="text" name="searchKey" id="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> style="width:550px;"/>
			<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchTableWrap -->
	</div>

	<br>
	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col style="width:50px;"/>
				<col style="width:150px;"/>
				<col style="width:150px;"/>
				<col/>
				<col style="width:15%;"/>
				<col style="width:15%;"/>
				<col style="width:15%;"/>
				<col style="width:80px;"/>
				<col style="width:150px;"/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["EW00027"] //태그?></th>
				<th><?=$LNG_TRANS_CHAR["EW00028"] //이름?></th>				
				<th><?=$LNG_TRANS_CHAR["EW00021"] //광고위치?></th>
				<th><?=$LNG_TRANS_CHAR["EW00029"] //구성?></th>
				<th><?=$LNG_TRANS_CHAR["EW00030"] //이미지 사이즈?></th>
				<th><?=$LNG_TRANS_CHAR["EW00031"] //간격?></th>
				<th><?=$LNG_TRANS_CHAR["EW00004"] //상태?></th>
				<th><?=$LNG_TRANS_CHAR["EW00026"] //CW00007?></th>
			</tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
			<tr>
				<td colspan="9"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
			</tr>		
			<?}?>
			<?
				while($row = mysql_fetch_array($result)){
			?>
			<tr>
				<td><?=$intListNum--?></td>
				<td>{{__banner_<?=$row[A_NO]?>__}}</td>
				<td><?=$row[A_NAME]?></td>
				<td style="text-align:left;"><?=$row[A_LOCA]?></td>
				<td><span class="spanTitle"><?=$LNG_TRANS_CHAR["EW00022"] //가로?></span>: <?=$row[A_TABLE_W]?>개 <span class="spanTitle"><?=$LNG_TRANS_CHAR["EW00023"] //세로?></span>: <?=$row[A_TABLE_H]?>개</td>
				<td><span class="spanTitle"><?=$LNG_TRANS_CHAR["EW00022"] //가로?></span>: <?=$row[A_SIZE_W]?>px <span class="spanTitle"><?=$LNG_TRANS_CHAR["EW00023"] //세로?></span>: <?=$row[A_SIZE_H]?>px</td>
				<td><span class="spanTitle"><?=$LNG_TRANS_CHAR["EW00022"] //가로?></span>: <?=$row[A_MARGIN_W]?>px <span class="spanTitle"><?=$LNG_TRANS_CHAR["EW00023"] //세로?></span>: <?=$row[A_MARGIN_H]?>px</td>
				<td><?=($row[A_USE] == "Y") ? $LNG_TRANS_CHAR["CW00010"]:$LNG_TRANS_CHAR["CW00011"]; //"사용함" : "사용안함" ;?></td>
				<td>
					 <a class="btn_blue_sml" href="javascript:goMoveUrl('adverModify',<?=$row[A_NO]?>)" id="menu_auth_m" style="display:none" ><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a> 
					 <a class="btn_sml" href="javascript:goMoveUrl('adverDelete',<?=$row[A_NO]?>);" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a> 
				</td>
			</tr>
			<?
				}
			?>
		</table>
	</div>
	<!-- tableList -->




		<!-- Pagenate object --> 
		<div class="paginate">  
			<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
		</div>  
		<!-- Pagenate object -->

		<div class="buttonBoxWrap">
			<a class="btn_new_blue" href="javascript:goMoveUrl('adverWrite');" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00028"] //배너그룹 추가?></strong></a>
		</div>

	<!-- 기능 공지 시작 -->
		<div class="noticeWrap">
			<div class="titleNotice"><img src="/shopAdmin/himg/common/tit_notice.gif"/></div>
			* <?=$LNG_TRANS_CHAR["ES00007"] //배너등록 전 반드시 그룹을 먼저 설정해 주세요.?><br/>
			* <?=$LNG_TRANS_CHAR["ES00008"] //배너 그룹설정은 등록하는 배너를 어디에 노출할지 결정하는 기능입니다.?>
		</div>
	<!-- 기능 공지 끝 -->

</div>
