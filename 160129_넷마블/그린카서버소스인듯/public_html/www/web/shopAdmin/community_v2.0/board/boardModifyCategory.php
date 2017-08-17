<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/community_v2.0/board/boardModifyCategory.js";
	$aryScriptEx[] = "/common/js/jquery.form.js";
?>
<div class="contentTop">
	<h2>커뮤니티 설정 (<?php echo $strB_NAME;?>)</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tabImgWrap">
<?php include MALL_HOME . "/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php";?>
</div>

<br>

<!-- 언어 선택 탭 -->
<?php include MALL_HOME . "/web/shopAdmin/include/tab_language.inc.php";?>
<!-- 언어 선택 탭-->

<!-- 카테고리 옵션 설정 //-->
<form name="form" id="form">
<input type="hidden" name="menuType" id="menuType" value="community_v2.0">
<input type="hidden" name="mode" id="mode" value="">
<input type="hidden" name="act" id="act" value="">
<input type="hidden" name="b_code" id="b_code" value="<?php echo $strB_CODE;?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $strLang;?>">
<div class="tableForm">
	<h3>커뮤니티 카테고리 옵션</h3>
	<table>
		<tr>
			<th>카테고리 사용</th>
			<td>
				<input type="radio" name="bi_category_use" value="Y"<?php if($strBI_CATEGORY_USE=="Y"){echo " checked";}?>> 사용(모든사용자)
				<input type="radio" name="bi_category_use" value="A"<?php if($strBI_CATEGORY_USE=="A"){echo " checked";}?>> 사용(관리자만)
				<input type="radio" name="bi_category_use" value="N"<?php if($strBI_CATEGORY_USE=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
		<tr>
			<th>카테고리 노출</th>
			<td>
				<input type="radio" name="bi_category_skin" value="combobox"<?php if($strBI_CATEGORY_SKIN=="combobox"){echo " checked";}?>/>콤보박스
				<input type="radio" name="bi_category_skin" value="text"<?php if($strBI_CATEGORY_SKIN=="text"){echo " checked";}?>/>텍스트
				<input type="radio" name="bi_category_skin" value="image"<?php if($strBI_CATEGORY_SKIN=="image"){echo " checked";}?>/>이미지
			</td>
		</tr>
		<tr>
			<th>카테고리 표시</th>
			<td>
				<input type="checkbox" name="bi_category_list_use" value="Y"<?php if($strBI_CATEGORY_LIST_USE=="Y"){echo " checked";}?>/> 리스트 화면 상단에 카테고리 사용
			</td>
		</tr>
	</table>
	<br>
	<div class="button">
		<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyCategoryInfoModifyActEvent();" id="menu_auth_m" style=""><strong>설정 변경</strong></a>
		<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyCategoryListMoveEvent();"><strong>목록</strong></a>
	</div>
</div>
</form>
<!-- 카테고리 옵션 설정 //-->
<!-- 카테고리 등록/수정 //-->
<form name="formWrite" id="formWrite" method="post" enctype="multipart/form-data">
<input type="hidden" name="menuType" id="menuType" value="community_v2.0">
<input type="hidden" name="mode" id="mode" value="">
<input type="hidden" name="act" id="act" value="">
<input type="hidden" name="b_code" id="b_code" value="<?php echo $strB_CODE;?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $strLang;?>">
<input type="hidden" name="bc_no" id="bc_no" value="">
<div class="tableForm">
	<h3>커뮤니티 카테고리 등록</h3>
	<table>
		<tr>
			<th>이름</th>
			<td>
				<input type="text" name="bc_name" id="bc_name" value="" style="width:300px"/>
			</td>
		</tr>
		<tr>
			<th>정렬</th>
			<td>
				<input type="text" name="bc_sort" id="bc_sort" value="" style="width:150px"/>
			</td>
		</tr>
		<tr>
			<th>이미지1</th>
			<td>
				<input type="file" name="bc_image_1" id="bc_image_1" style="width:300px"/>
			</td>
		</tr>
		<tr>
			<th>이미지2</th>
			<td>
				<input type="file" name="bc_image_2" id="bc_image_2" style="width:300px"/>
			</td>
		</tr>
	</table>
	<br>
	<div class="button">
		<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyCategoryWriteActEvent();" id="menu_auth_m" style=""><strong>카테고리 등록</strong></a>
	</div>
</div>
</form>
<!-- 카테고리 등록/수정 //-->
<!-- 카테고리 리스트 //-->
<div class="tableList">
	<h3>커뮤니티 카테고리 리스트</h3>
	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col width=40/>
			<col />
			<col width=200/>
			<col width=200/>
			<col width=100/>
			<col width=200/>
		</colgroup>
		<tr>
			<th>번호</th>
			<th>이름</th>
			<th>이미지1</th>
			<th>이미지2</th>
			<th>정렬</th>
			<th>설정</th>
		</tr>
		<?php if(!$intTotal):?>
		<tr>
			<td colspan="6">등록된 내용이 없습니다.</td>
		</tr>
		<?php else:?>
		<?php while($row = mysql_fetch_array($resResult)):
				
				## 기본정보
				$intBC_NO = $row['BC_NO'];
				$strBC_NAME = $row['BC_NAME'];
				$strBC_IMAGE_1 = $row['BC_IMAGE_1'];
				$strBC_IMAGE_2 = $row['BC_IMAGE_2'];
				$intBC_SORT = $row['BC_SORT'];
				$strBCL_NAME = $row['BCL_NAME'];
				$strBCL_IMAGE_1 = $row['BCL_IMAGE_1'];
				$strBCL_IMAGE_2 = $row['BCL_IMAGE_2'];

				## 이름 설정
				$strName = $strBC_NAME;
				if($strBCL_NAME) { $strName = $strBCL_NAME; }

				## 이미지1 설정
				$strImageFile1 = $strBC_IMAGE_1;
				if($strBCL_IMAGE_1) { $strImageFile1 = $strBCL_IMAGE_1; }
				if($strImageFile1) { $strImageFile1 = "{$strWebDir}/{$strImageFile1}"; }

				## 이미지2 설정
				$strImageFile2 = $strBC_IMAGE_2;
				if($strBCL_IMAGE_2) { $strImageFile2 = $strBCL_IMAGE_2; }
				if($strImageFile2) { $strImageFile2 = "{$strWebDir}/{$strImageFile2}"; }

		?>
		<tr>
			<td><?php echo $intListNum--;?></td>
			<td><?php echo $strName;?></td>
			<td><?php if($strImageFile1):?>
				<img src="<?php echo $strImageFile1;?>" style="width:100px">
				<?php endif;?>
			</td>
			<td><?php if($strImageFile2):?>
				<img src="<?php echo $strImageFile2;?>" style="width:100px">
				<?php endif;?>
			</td>
			<td><?php echo $intBC_SORT;?></td>
			<td><a href="javascript:void(0);" onclick="goCommunityBoardModifyCategoryModifyMoveEvent('<?php echo $strB_CODE;?>', '<?php echo $strLang;?>', <?php echo $intBC_NO;?>);" class="btn_blue_sml" id="menu_auth_m" style=""><strong>수정</strong></a>
				<?php if($isDelBtn):?>
				<a href="javascript:void(0);" onclick="goCommunityBoardModifyCategoryDeleteActEvent('<?php echo $strB_CODE;?>', '<?php echo $strLang;?>', <?php echo $intBC_NO;?>);" class="btn_blue_sml" id="menu_auth_d" style=""><strong>삭제</strong></a>
				<?php endif;?>
			</td>
		</tr>
		<?php endwhile;?>
		<?php endif;?>
	</table>
</div>
<!-- 카테고리 리스트 //-->