<div class="contentTop">
	<h2>메인상품 진열방식 관리</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm mt20">
	<input type="hidden" name="pv_page" value="<?=$row[PV_PAGE]?>"/>
	<input type="hidden" name="pv_modul_type" value="<?=$row[PV_MODUL_TYPE]?>"/>
	<input type="hidden" name="pv_modul_name" value="<?=$row[PV_MODUL_NAME]?>"/>
	<input type="hidden" name="pv_design_no"  value="<?=$row[PV_DESIGN_NO]?>"/>
	<input type="hidden" name="dm_design_type"  value="<?=$row[DM_DESIGN_TYPE]?>"/>
	<input type="hidden" name="dm_design_code"  value="<?=$row[DM_DESIGN_CODE]?>"/>
	<table class="mt20">
		<tr>
			<th>모듈명</th>
			<td><?= $row[PV_NO] ?><?=$row[PV_MODUL_NAME]?></td>
		</tr>
	<?if($row[PV_PAGE] =="main" || $row[PV_PAGE] =="submain" || $row[PV_PAGE] =="subpage"){?>
	 <!--
		<tr>
			<th>적용위치</th>
			<td>
				<input type="radio" name="pv_page" value="main" <?=$row[PV_PAGE] == "main" ? "checked" : ""?>/>메인페이지 
				<input type="radio" name="pv_page" value="subpage" <?=$row[PV_PAGE] == "subpage" ? "checked" : ""?> class="ml10"/>서브페이지 
				<input type="radio" name="pv_page" value="submain" <?=$row[PV_PAGE] == "submain" ? "checked" : ""?>  class="ml10" disabled/> 상품목록메인
				<input type="radio" name="pv_page" value="submain" <?=$row[PV_PAGE] == "prodlist" ? "checked" : ""?>  class="ml10" disabled/> 상품목록페이지
				<input type="radio" name="pv_page" value="submain" <?=$row[PV_PAGE] == "prodview" ? "checked" : ""?>  class="ml10" disabled/> 상품상세보기페이지
			</td>
		</tr>
	-->
	<!-- 
		<tr>
			<th>적용모듈</th>
			<td><?=$row[PV_MODUL_TYPE]?>
				<input type="radio" name="pv_modul_type" value="new" <?=$row[PV_MODUL_TYPE]	== "new" ? "checked" : ""?>/> 신상품 
				<input type="radio" name="pv_modul_type" value="best" <?=$row[PV_MODUL_TYPE]== "best" ? "checked" : ""?> class="ml10"/> 베스트상품
				<input type="radio" name="pv_modul_type" value="md" <?=$row[PV_MODUL_TYPE]	== "md" ? "checked" : ""?> class="ml10"/> MD추천상품
				<input type="radio" name="pv_modul_type" value="recommend" <?=$row[PV_MODUL_TYPE] == "recommend" ? "checked" : ""?> class="ml10"/> 추천상품
			</td>
		</tr>
	-->
		<? if ( $row['PV_PAGE'] != "subpage" ) : ?>
		<tr>
			<th>예약어</th>
			<td><strong>{{__<?=$row[PV_PAGE]?>_<?=$row[PV_MODUL_TYPE]?>__}}</strong></td>
		</tr>
		<? else : ?>
		<tr>
			<th>사용여부</th>
			<td><input type="checkbox" name="pv_use" value="Y" <?=$row[PV_USE] == "Y" ? "checked" : ""?>/> <?=$row[PV_MODUL_NAME]?> 기능을 사용하기 </td>
		</tr>
		<? endif; ?>		
	<!-- 
		<tr>
			<th>적용순위</th>
			<td>메인 추천상품 그룹의 <input type="text" name="pv_order" value="<?=$row[PV_ORDER]?>" <?=$nBox?> style="width:40px;text-align:right;"/> 째로 노출</td>
		</tr>
	-->
	<?}?>
		<tr>
			<th>디자인타입</th>
			<td>
				<?=$row[PV_MODUL_NAME]?> Type <span id="design_type"><?=$row[DM_DESIGN_TYPE]?></span> - <span id="design_code"><?=$row[DM_DESIGN_CODE]?></span><a href="javascript:goImageGroupPopup('<?=$row['DM_DESIGN_GROUP']?>')" class="btn_sml ml10"><span>디자인선택</span></a>
			</td>
		</tr>
	<?if($row[PV_PAGE] =="prodview"){?>
		<tr>
			<th>상세이미지보기기능</th>
			<td>
				<input type="hidden" name="pv_view_function" value="<?=$row[PV_VIEW_FUNCTION]?>"/>
				기본 이미지뷰 <a href="#" class="btn_sml ml10"><span>기능선택</span></a>
			</td>
		</tr>
	<?}?>
	<?if($row[PV_PAGE] =="prodmain" || $row[PV_PAGE] =="prodlist" || $row[PV_PAGE] =="prodview"){?>
		<tr>
			<th>서브카테고리사용여부</th>
			<td>
				<input type="radio" name="pv_list_cate" value="Y" <?=$row[PV_LIST_CATE] == "Y" ? "checked" : ""?>/>사용 
				<input type="radio" name="pv_list_cate" value="N" <?=$row[PV_LIST_CATE] == "N" ? "checked" : ""?> class="ml10"/>사용하지 않음
			</td>
		</tr>
	<?}?>

		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="pv_image_size_w" id="pv_image_size_w" value="<?=$row[PV_IMAGE_SIZE_W]?>" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="pv_image_size_h" id="pv_image_size_h" value="<?=$row[PV_IMAGE_SIZE_H]?>" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
	<?if($row[PV_PAGE] !="prodview"){?>
		<tr>
			<th>이미지 노출수량</th>
			<td>
				<span class="spanTitle">가로</span> <input type="text" name="pv_image_cnt_w" id="pv_image_cnt_w" value="<?=$row[PV_IMAGE_CNT_W]?>" <?=$nBox?>  style="width:40px;"/> 개 <span class="blank ml20"></span>
				<span class="spanTitle">세로</span> <input type="text" name="pv_image_cnt_h" id="pv_image_cnt_h" value="<?=$row[PV_IMAGE_CNT_H]?>" <?=$nBox?>  style="width:40px;"/> 줄
			</td>
		</tr>
	<?}?>
	</table>
</div>
<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goProdpageAct('prodpageModify');" id="menu_auth_m"><strong>설정 저장</strong></a>
	<a class="btn_big" href="javascript:C_getMoveUrl('prodpageList','get','<?=$PHP_SELF?>');"><strong>목록</strong></a>
</div>