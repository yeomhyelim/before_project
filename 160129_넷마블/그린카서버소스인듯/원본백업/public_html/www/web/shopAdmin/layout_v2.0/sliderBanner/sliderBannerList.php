<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/layout_v2.0/sliderBanner/sliderBannerList.js";
?>
<!-- 제목 //-->
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["BW00163"] //음직이는 배너 관리?></h2>
	<div class="clr"></div>
</div>
<!-- 제목 //-->

<br>

<!-- 움직이는 배너 리스트 //-->
<div class="tableList">
	<table>
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
		<?php if(!$intTotal):?>
		<tr>
			<td colspan="5">등록된 내용이 없습니다.</td>
		</tr>
		<?php else:?>
		<?php while($row = mysql_fetch_array($resResult)):

				## 기본 설정
				$intSB_NO				= $row['SB_NO'];
				$strSB_CODE				= $row['SB_CODE'];
				$strSB_COMMENT			= $row['SB_COMMENT'];
				$strSB_LINK_TYPE		= $row['SB_LINK_TYPE'];
				$intSB_REG_DT			= $row['SB_REG_DT'];

				## 링크타입 설정
				$strLinkTypeName		= $aryLinkType[$strSB_LINK_TYPE]
				
			?>
		<tr>
			<td><?php echo $intListNum--?></td>
			<td><?php echo $strSB_CODE?></td>
			<td><?php echo $strSB_COMMENT;?></td>
			<td><?php echo $strLinkTypeName;?></td>
			<td><a href="javascript:goLayoutSliderBannerListModifyMoveEvent('<?php echo $intSB_NO;?>')" class="btn_blue_sml" id="menu_auth_m" style=""><strong>수정</strong></a>
				<a href="javascript:goLayoutSliderBannerListDeleteMoveEvent('<?php echo $intSB_NO;?>')" class="btn_sml" id="menu_auth_d" style=""><strong>삭제</strong></a></td>
		</tr>
		<?php endwhile;?>
		<?php endif;?>
	</table>
</div>
<!-- 움직이는 배너 리스트 //-->

<br>

<!-- 버튼 //-->
<a class="btn_blue_big" href="./?menuType=layout&mode=sliderBannerWrite" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>	
<!-- 버튼 //-->