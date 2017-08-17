<?php

	## 언어설정
	$strLang = $_GET['lang'];
	if(!$strLang) { $strLang = $S_ST_LNG; }
	$strLangLower = strtolower($strLang);

?>
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00100"] //추가페이지 관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->	
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col style="width:50px;"/>
				<col style="width:150px;"/>
				<col/>
				<col/>
				<col/>
				<col/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["CW00064"] //페이지명?></th>
				<th><?=$LNG_TRANS_CHAR["BW00101"] //링크?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
				<tr>
					<td colspan="9"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
				</tr>		
			<?}?>
			<?
				while($row = mysql_fetch_array($result)){

					## 기본설정
					$strCP_PAGE_NAME = $row['CP_PAGE_NAME'];
					$strCP_GROUP = $row['CP_GROUP'];

					## 그룹ID만들기
					$strGroupID = str_pad($strCP_GROUP, 5, "0", STR_PAD_LEFT);

					
			?>
			<tr>
				<td><?=$intListNum--?></td>
				<td><?php echo $strCP_PAGE_NAME;?></td>
				<td>./?menuType=contents&mode=userPage&id=<?php echo $strGroupID;?>
					 <a class="btn_sml" href="/<?php echo $strLangLower;?>/?menuType=contents&mode=userPage&id=<?php echo $strGroupID;?>" target="_blank"><strong>이동</strong></a></td>
				<td>
					 <a class="btn_blue_sml" href="javascript:goMoveUrl('contentModify',<?=$row[CP_GROUP]?>);" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a> 
					 <a class="btn_sml" href="javascript:goMoveUrl('contentDelete',<?=$row[CP_GROUP]?>);" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a> 
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
		<a class="btn_blue_big" href="./?menuType=layout&mode=contentWrite" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00028"] //페이지 추가?></strong></a>
	</div>
	