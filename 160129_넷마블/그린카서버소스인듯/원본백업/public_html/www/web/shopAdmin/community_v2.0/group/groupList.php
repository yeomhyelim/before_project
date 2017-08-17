<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/community_v2.0/group/groupList.js";
	$aryScriptEx[] = "/common/js/jquery.form.js";
?>
<!-- 제목 //-->
<div class="contentTop">
	<h2>커뮤니티 그룹 관리</h2>
	<div class="clr"></div>
</div>
<!-- 제목 //-->

<br>

<!-- 언어탭 //-->
<?php include MALL_ADMIN . "/include/tab_language.inc.php";?>
<!-- 언어탭 //-->

<!-- 커뮤니티 그룹 등록 or 수정 //-->
<div class="tableFormWrap">
	<h3 class="groupTitle">커뮤니티 그룹 등록</h3>
	<form id="formData" method="post" enctype="multipart/form-data" action="./">
	<input type="hidden" name="menuType" value="community_v2.0">
	<input type="hidden" name="mode" value="json">
	<input type="hidden" name="act" value="groupWrite">
	<input type="hidden" name="bg_no" value="">
	<input type="hidden" name="lang" value="<?php echo $strStLng;?>">
	<table class="tableForm">
		<tr>
			<th>그룹명</th>
			<td><input type="text" name="bg_name"></td>
		</tr>
		<tr>
			<th>정렬번호</th>
			<td><input type="text" name="bg_sort"></td>
		</tr>
		<tr>
			<th>메뉴사용여부</th>
			<td><input type="radio" name="bg_menu_use" value="Y" checked> 사용
				<input type="radio" name="bg_menu_use" value="N"> 사용 안함</td>
		</tr>
		<tr>
			<th>대표이미지</th>
			<td><input type="file" name="bg_file1">
				<span class="bg_file1_del" style="display:none">
					<input type="checkbox" name="bg_file1_del" value="Y"> 대표이미지 삭제
				</span>
			</td>
		</tr>
		<tr>
			<th>서브이미지</th>
			<td><input type="file" name="bg_file2">
				<span class="bg_file2_del" style="display:none">
					<input type="checkbox" name="bg_file2_del" value="Y"> 서브이미지 삭제
				</span>
			</td>
		</tr>
	</table>
	</form>

	<div class="buttonBoxWrap">
		<?php if($strStLang == $strLang):?>
		<a href="javascript:void(0);" onclick="goCommunityGroupListWriteActEvent();" class="btn_big btnWrite" id="menu_auth_m"><strong>그룹명 추가</strong></a>
		<?php endif;?>
		<a href="javascript:void(0);" onclick="goCommunityGroupListModifyActEvent();" class="btn_big btnModify" id="menu_auth_m" style="display:none"><strong>그룹 수정</strong></a>
		<a href="javascript:void(0);" onclick="goCommunityGroupListCancelActEvent();" class="btn_big btnCancel" id="menu_auth_m" style="display:none"><strong>취소</strong></a>
		<!-- a href="javascript:void(0);" onclick="goCommunityGroupListFileActEvent();" class="btn_big btnFile" id="menu_auth_m"><strong>그룹 파일 생성</strong></a //-->
	</div>
</div>


<!-- 커뮤니티 그룹 등록 or 수정 //-->

<!-- 커뮤니티 그룹 리스트 //-->
<div class="tableListWrap mt30">
	<table class="tableList">
		<colgroup>
			<col width=40/>
			<col/>
			<col width=200/>
			<col width=200/>
			<col width=200/>
			<col width=200/>
		</colgroup>
		<tr>
			<th>번호</th>
			<th>그룹명</th>
			<th>게시판 수</th>
			<th>대표이미지</th>
			<th>서브이미지</th>
			<th>정렬</th>
			<th>메뉴사용여부</th>
			<th>관리</th>
		</tr>
		<?php if(!$intTotal):?>
		<tr>
			<td colspan="8">등록된 내용이 없습니다.</td>
		</tr>
		<?php else:?>
		<?php while($row = mysql_fetch_array($resResult)):

			## 기본 설정
			$intBG_NO				= $row['BG_NO'];
			$strBG_NAME				= $row['BG_NAME'];
			$strBG_FILE1			= $row['BG_FILE1'];
			$strBG_FILE2			= $row['BG_FILE2'];
			$intBG_SORT				= $row['BG_SORT'];
			$strBG_MENU_USE			= $row['BG_MENU_USE'];
			$intBG_BOARD_CNT		= $row['BG_BOARD_CNT'];

			## 메뉴 사용 여부 설정
			if(!$strBG_MENU_USE) { $strBG_MENU_USE = "Y"; }

			## 정렬 설정
			$intBG_SORT = number_format($intBG_SORT);

			## 이미지 설정
			if($strBG_FILE1) { $strBG_FILE1 = "{$strWebDir}/{$strBG_FILE1}"; }
			if($strBG_FILE2) { $strBG_FILE2 = "{$strWebDir}/{$strBG_FILE2}"; }

			?>
		<tr>
			<td><?php echo $intListNum--?></td>
			<td><?php echo $strBG_NAME?></td>
			<td><?php echo $intBG_BOARD_CNT;?></td>
			<td><?php if($strBG_FILE1):?>
				<img src="<?php echo $strBG_FILE1?>" style="height:30px">
				<?php endif;?>
			</td>
			<td><?php if($strBG_FILE2):?>
				<img src="<?php echo $strBG_FILE2?>" style="height:30px">
				<?php endif;?>
			</td>
			<td><?php echo $intBG_SORT?></td>
			<td><?php echo $strBG_MENU_USE?></td>
			<td><a href="javascript:goCommunityGroupListModifyMoveEvent('<?php echo $intBG_NO;?>')" class="btn_blue_sml" id="menu_auth_m"><strong>수정</strong></a>
				<a href="javascript:goCommunityGroupListDeleteMoveEvent('<?php echo $intBG_NO;?>')" class="btn_sml" id="menu_auth_d"><strong>삭제</strong></a></td>
		</tr>
		<?php endwhile;?>
		<?php endif;?>
	</table>
</div>
<!-- 커뮤니티 그룹 리스트 //-->