<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/community_v2.0/board/boarList.js";
?>
<div class="contentTop">
	<h2>커뮤니티 리스트</h2>
	<div class="clr"></div>
</div>

<div class="tableListWrap mt10">
<div class="buttonBoxWrap">
	<select name="searchGroup" id="searchGroup" data-select="<?php echo $strSearchGroup;?>">
		<option value="">그룹 전체</option>
		<option value="007">고객센터</option>
		<option value="006">상품관련</option>
	</select>
	<select name="searchKey" id="searchKey" data-select="<?php echo $strSearchKey;?>">
		<option value="name">게시판명</option>
		<option value="code">게시판코드</option>
	</select>
	<input type="text" name="searchVal" id="searchVal" value="<?php echo $strSearchVal;?>" alt="검색어" check="search" data-enter-event="goCommunityBoardListSearchMoveEvent">
	<a href="javascript:void(0);" onclick="goCommunityBoardListSearchMoveEvent();" class="btn_sml" id="menu_auth_w" style="display: inline-block;"><strong>검색</strong></a>	
</div>


	<table class="tableList">
	<colgroup>
		<col width="40/">
		<col width="60/">
		<col>
		<col width="100/">
	</colgroup>
	<tbody>
		<tr>
			<th>번호</th>
			<th colspan="2">게시판정보</th>
			<th>관리</th>
		</tr>
		<?php if(!$intTotal):?>
		<tr>
			<td colspan="4">등록된 내용이 없습니다.</td>
		</tr>
		<?php else:?>
		<?php while($row = mysql_fetch_array($resResult)):
		
				## 기본설정
				$strB_CODE = $row['B_CODE'];
				$intB_NO = $row['B_NO'];
				$strB_NAME = $row['B_NAME'];
				$strB_KIND = $row['B_KIND'];
				$strB_SKIN = $row['B_SKIN'];
				$strB_CSS = $row['B_CSS'];
				$intB_BG_NO = $row['B_BG_NO'];
				$strB_USE = $row['B_USE'];
				$strB_REG_DT = $row['B_REG_DT'];

				## 그룹명 설정
				$intGroupName = $GROUP_LIST[$intB_BG_NO]['bg_name'];

				## URL 설정
				$strUrl = "/{$strLangSLower}/?menuType=community&b_code={$strB_CODE}";

		?>
		<tr>
			<td><?php echo $intListNum--;?></td>
			<td class="vTop noRboder">
				<img src="/shopAdmin/himg/layout/sample/board_type_data_basic.gif">
			</td>
			<td class="alignLeft">
				<ul class="inTdUlList">
					<li><span>타이틀</span>: <strong><?php echo $strB_NAME;?></strong></li>
					<li><span>관리그룹</span>: <?php echo $intGroupName;?></li>
					<li><span>코드명</span>: <?php echo $strB_CODE;?></li>
					<li><span></span><a href="<?php echo $strUrl;?>" target="_blank" class="btn_sml" id="menu_auth_e1" style="display: inline-block;"><strong style="font-weight:normal;">게시판 보기</strong></a></li>
				</ul>
			</td>
			<td>
				<a href="javascript:void(0);" onclick="goCommunityBoardListModifyMoveEvent('<?php echo $strB_CODE;?>')" class="btn_blue_sml" id="menu_auth_m" style="display: inline-block;"><strong>기능설정</strong></a>
				<a href="javascript:void(0);" onclick="goCommunityBoardListStopActEvent('<?php echo $strB_CODE;?>')" class="btn_sml" id="menu_auth_d" style="display: inline-block;"><strong>운영정지</strong></a>
			</td>
		</tr>
		<?php endwhile;?>
		<?php endif;?>
	</tbody>
	</table>
</div>
<div class="paginate">
	<a href="javascript:void(0)" onclick="goCommunityBoardListMoveEvent(<?php echo $intPrevBlock;?>)" class="btn_board_prev direction "><span>이전</span></a>
	<?php for($i=$intFirstBlock;$i<=$intLastBlock;$i++):?>
	<?php if($i == $intPage):?>
	<strong><span class="chkPage"><?php echo $i;?></span></strong>
	<?php else:?>
	<a href="javascript:void(0)" onclick="goCommunityBoardListMoveEvent(<?php echo $i;?>)" ><span class="pageCnt"><?php echo $i;?></span></a>
	<?php endif;?>
	<?php endfor;?>
	<a href="javascript:void(0)" onclick="javascript:goCommunityBoardListMoveEvent(<?php echo $intNextBlock;?>)" class="btn_board_next direction"><span>다음</span></a>
</div>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:void(0);" onclick="goCommunityBoardListWriteMoveEvent();" id="menu_auth_w" style="display: inline-block;"><strong>커뮤니티  추가</strong></a>
	<!-- <a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityBoardListFileActEvent();" id="menu_auth_w" style="display: inline-block;"><strong>파일 생성</strong></a> -->
</div>