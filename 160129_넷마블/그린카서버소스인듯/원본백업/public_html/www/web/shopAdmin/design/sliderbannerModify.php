<div class="contentTop">
	<h2>움직이는 배너 관리</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm mt20">
	<!-- 디자인관리의 : 디자인명과 디자인코드 hidden으로 전달 -->
	<input type="hidden" name="sb_design_code" value="<?=$row[SB_DESIGN_CODE]?>">
	<input type="hidden" name="sb_banner_name" value="<?=$row[SB_BANNER_NAME]?>">
	<input type="hidden" name="pv_page" value="<?=$row[PV_PAGE]?>"/>
	<input type="hidden" name="pv_modul_type" value="<?=$row[PV_MODUL_TYPE]?>"/>
	<input type="hidden" name="pv_modul_name" value="<?=$row[PV_MODUL_NAME]?>"/>
	<input type="hidden" name="pv_design_no"  value="<?=$row[PV_DESIGN_NO]?>"/>
	<input type="hidden" name="dm_design_type"  value="<?=$row[DM_DESIGN_TYPE]?>"/>
	<input type="hidden" name="dm_design_code"  value="<?=$row[DM_DESIGN_CODE]?>"/>
	
	<table class="mt20" id="tabSlideBanner">
		<tr>
			<th>예약어</th>
			<td><strong>{{__<?=$row[SB_BANNER_NAME]?>__}}</strong></td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td>
				<?=$row[PV_MODUL_NAME]?> Type <span id="design_type"><?=$row[DM_DESIGN_TYPE]?></span> - <span id="design_code"><?=$row[DM_DESIGN_CODE]?></span><a href="javascript:goImageGroupPopup('<?=$row['DM_DESIGN_GROUP']?>')" class="btn_sml ml10"><span>디자인선택</span></a>
			</td>			
		</tr>
		<tr>
			<th>슬라이딩 이미지 수</th>
			<td> <input type="TEXT" name="sb_images_cnt" id="sb_images_cnt" value="<?=$row[SB_IMAGES_CNT]?>" readonly />  <a href="javascript:goAddSlideBanner();" class="btn_blue_sml ml10"><span>이미지 추가</span></a></td>
		</tr>
		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="sb_image_w" value="<?=$row[SB_IMAGE_W]?>" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="sb_image_h" value="<?=$row[SB_IMAGE_H]?>" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
		<?
			for ( $i=1; $i <= $row[SB_IMAGES_CNT]; $i++ ) :
				$strImgName 	= "SB_IMAGE_FILE_" . $i;
				$strImg 		= sprintf( "<img src='../upload/slider/%s' style='width:%dpx; height:%dpx' />" , $row [$strImgName], $row[SB_IMAGE_W], $row[SB_IMAGE_H] );
		?>
		<tr>
			<th><span class="numberOrange_<?=$i?> mr5"></span> 적용이미지 </th>
			<td>
				<dl class="tdListUl">
					<dd><span class="spanTitle">이미지</span><input type="file" name="sb_image_file_<?=$i?>" id="sb_image_file_<?=$i?>"<?=$nBox?>  style="height:22px;"/></dd>
					<dd><span class="spanTitle">링크</span><input type="text" name="sb_image_link_<?=$i?>" id="sb_image_link_<?=$i?>" value="<?=$row["SB_IMAGE_LINK_".$i]?>" <?=$nBox?> style="width:400px;"/></dd>
					<dd><span class="spanTitle">카피문구</span><input type="text" name="sb_images_txt_<?=$i?>" id="sb_images_txt_<?=$i?>" value="<?=$row["SB_IMAGES_TXT_".$i]?>" <?=$nBox?> style="width:400px;"/></dd>
					<?if ($i==1){?>
						<dd>
							<span class="spanTitle">링크적용</span>
							<input type="radio" name="sb_link_target" value="M" 	<?= ( $row[SB_LINK_TARGET] == "M" ) ? "checked" : "" ?>/>현제 페이지 열기
							<input type="radio" name="sb_link_target" value="B"  	<?= ( $row[SB_LINK_TARGET] == "B" ) ? "checked" : "" ?>/>새창으로 열기 						
							<input type="radio" name="sb_link_target" value="N"  	<?= ( $row[SB_LINK_TARGET] == "N" ) ? "checked" : "" ?>/>열결 없음
						</dd>
					<?}?>
					<? if ( $row[$strImgName] ) : ?>
						<div class="attachImg ml50">
							<?= $strImg ?>
							<p style="margin-top:5px;">File name: <?= $row[$strImgName] ?></p>
							<input type="text" name="sb_image_file_<?=$i?>_bak" id="sb_image_file_<?=$i?>_bak" value="<?= $row[$strImgName] ?>" />
						</div>
					<? endif; ?>
				</dl>
			</td>
		</tr>
		<? endfor; ?>
	</table>
</div>
	

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goSliderbannerAct('sliderbannerModify');" id="menu_auth_m"><strong>슬라이딩 배너 저장</strong></a>
	<a class="btn_big" href="javascript:goMoveUrl('sliderbannerList');"><strong>목록</strong></a>
</div>