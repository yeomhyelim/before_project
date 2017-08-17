<?
	## 설정(기본설정)
	$boardEventInfoAry = $_REQUEST['result']['EventInfoMgr'];

	## 설정(데이터)
	$giftResult = $_REQUEST['result']['GiftMgr'];
	$gm_ub_no	= $_REQUEST['result']['gm_ub_no'];
	$cnt		= 0;
	while($row = mysql_fetch_array($giftResult)) : 
	//	print_r($row);
		$gm_type		= $row['GM_TYPE'];
		$gm_give_type	= $row['GM_GIVE_TYPE'];
		$gm_area		= $row['GM_AREA'];

		if(in_array($gm_give_type, array("A","M"))):
			$data[$gm_area][$gm_type]['AM']['GM_NO']				= ($gm_ub_no == -1) ? ""  : $row['GM_NO'];
			$data[$gm_area][$gm_type]['AM']['GM_MAX']				= $row['GM_MAX'];
			$data[$gm_area][$gm_type]['AM']['GM_TITLE']				= $row['GM_TITLE'];
			$data[$gm_area][$gm_type]['AM']['GM_DATA']				= $row['GM_DATA'];
		elseif(in_array($gm_give_type, array("T"))):
			$aryData[$gm_area][$gm_type]['T']['GM_NO'][]			= ($gm_ub_no == -1) ? ""  : $row['GM_NO'];
			$aryData[$gm_area][$gm_type]['T']['GM_MAX'][]			= $row['GM_MAX'];
			$aryData[$gm_area][$gm_type]['T']['GM_TITLE'][]			= $row['GM_TITLE'];
			$aryData[$gm_area][$gm_type]['T']['GM_DATA'][]			= $row['GM_DATA'];
		endif;
	endwhile;


?>

	<table>
		<tr>
			<th>댓글</th>
			<td>
				<input type="radio"  name="bi_point_c_use" value="N"<?if($boardEventInfoAry['BI_POINT_C_USE']=="N"){echo " checked";}?>/>사용안함 
				<input type="radio"  name="bi_point_c_use" value="Y"<?if($boardEventInfoAry['BI_POINT_C_USE']=="Y"){echo " checked";}?>/>사용함 (
				<input type="radio"  name="bi_point_c_give" value="A"<?if($boardEventInfoAry['BI_POINT_C_GIVE']=="A"){echo " checked";}?>/>자동포인트지급  
				<input type="radio"  name="bi_point_c_give" value="M"<?if($boardEventInfoAry['BI_POINT_C_GIVE']=="M"){echo " checked";}?>/>수동포인트지급  
				<input type="radio"  name="bi_point_c_give" value="T"<?if($boardEventInfoAry['BI_POINT_C_GIVE']=="T"){echo " checked";}?>/>멀티 차등포인트지급)
			</td>
		</tr>
		<tr>
			<th>댓글작성시 포인트설정</th>
			<td>
				<input type="hidden" class="_w50"  name="bi_point_c_no"    value="<?=$data['comment']['point']['AM']['GM_NO']?>"/>
				<input type="text"   class="_w250" name="bi_point_c_title" value="<?=$data['comment']['point']['AM']['GM_TITLE']?>"  maxlength="10"/>
				<input type="text"   class="_w50"  name="bi_point_c_data"  value="<?=$data['comment']['point']['AM']['GM_DATA']?>"  maxlength="10"/>포인트 자동지급
			</td>
		</tr>
		<!-- 차등포인트 지급(댓글) -->
		<tr>
			<th>
				차등포인트 지급
				<a href="javascript:goPointCMultiFormAddEvent()" class="btn_blue_sml"><span>+추가</span></a>
			</th>
			<td>
				<? $cnt = sizeof($aryData['comment']['point']['T']['GM_NO']); if(!$cnt) { $cnt = 1; } ?>
				<ul id="point_c_multi">
					<?for($i=0; $i<$cnt; $i++):?>
					<li id="point_c_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
						<input type="hidden" class="_w50" name="bi_point_c_multi_no[]"  id="bi_point_c_multi_no"    value="<?=$aryData['comment']['point']['T']['GM_NO'][$i]?>"/>
						<input type="text" class="_w50" name="bi_point_c_multi_count[]" id="bi_point_c_multi_count" value="<?=$aryData['comment']['point']['T']['GM_MAX'][$i]?>"/>명에게 
						<input type="text" class="_w50" name="bi_point_c_multi_title[]" id="bi_point_c_multi_title" value="<?=$aryData['comment']['point']['T']['GM_TITLE'][$i]?>"/>이란 제목으로 
						<input type="text" class="_w50" name="bi_point_c_multi_point[]" id="bi_point_c_multi_point" value="<?=$aryData['comment']['point']['T']['GM_DATA'][$i]?>"/>포인트 지급
						<a href="javascript:goPointCMultiFormDeleteEvent('<?=$i?>')" id="pointCMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
					<?endfor;?>
				</ul>
				<!-- 차등포인트 폼 -->
				<textarea id="point_c_multi_form" style="display:none;" alt="차등포인트">
				<li id=""><span id="no">{번호}</span> 
					<input type="text" class="_w50" name="bi_point_c_multi_count[]" id="bi_point_c_multi_count" value=""/>명에게 
					<input type="text" class="_w50" name="bi_point_c_multi_title[]" id="bi_point_c_multi_title" value=""/>이란 제목으로 
					<input type="text" class="_w50" name="bi_point_c_multi_point[]" id="bi_point_c_multi_point" value=""/>포인트 지급
					<a href="#" id="pointCMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
				</textarea>
				<input type="hidden" name="bi_point_c_multi_max" id="bi_point_c_multi_max" value="<?=$boardEventInfoAry['BI_POINT_C_MULTI_MAX']?>"/>
			</td>
		</tr>
		<tr>
			<th>댓글작성시 쿠폰정책</th>
			<td>
				<input type="radio"  name="bi_coupon_c_use" value="N"<?if($boardEventInfoAry['BI_COUPON_C_USE']=="N"){echo " checked";}?>/>사용안함 
				<input type="radio"  name="bi_coupon_c_use" value="Y"<?if($boardEventInfoAry['BI_COUPON_C_USE']=="Y"){echo " checked";}?>/>사용함 (
					<input type="radio"  name="bi_coupon_c_give" value="A"<?if($boardEventInfoAry['BI_COUPON_C_GIVE']=="A"){echo " checked";}?>/>자동쿠폰지급  
					<input type="radio"  name="bi_coupon_c_give" value="M"<?if($boardEventInfoAry['BI_COUPON_C_GIVE']=="M"){echo " checked";}?>/>수동쿠폰지급  
					<input type="radio"  name="bi_coupon_c_give" value="T"<?if($boardEventInfoAry['BI_COUPON_C_GIVE']=="T"){echo " checked";}?>/>멀티 차등쿠폰지급)
			</td>
		</tr>
		<tr>
			<th>댓글장성시 쿠폰설정</th>
			<td><input type="hidden" name="bi_coupon_c_no"                            value="<?=$data['comment']['coupon']['AM']['GM_NO']?>"     class="_w50"/>
				<input type="text" name="bi_coupon_c_title" id="bi_coupon_c_mark"   value="<?=$data['comment']['coupon']['AM']['GM_TITLE']?>"  class="_w200" maxlength="10" readOnly/>
				<input type="hidden" name="bi_coupon_c_data"  id="bi_coupon_c_coupon" value="<?=$data['comment']['coupon']['AM']['GM_DATA']?>"/>
				쿠폰 자동 지급
				<a href="javascript:goCouponCSelectLayerPopEvent()" id="" class="btn_sml"><span>쿠폰 선택</span></a>
			</td>
		</tr>
		<!-- 차등쿠폰 지급(댓글) -->
		<tr>
			<th>
				차등쿠폰 지급
				<a href="javascript:goCouponCMultiFormAddEvent()" class="btn_blue_sml"><span>+추가</span></a>
			</th>
			<td>
				<? $cnt = sizeof($aryData['comment']['coupon']['T']['GM_NO']); if(!$cnt) { $cnt = 1; } ?>
				<ul id="coupon_c_multi">
					<?for($i=0; $i<$cnt; $i++):?>
					<li id="coupon_c_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
						<input type="hidden" class="_w50" name="bi_coupon_c_multi_no[]"    id="bi_coupon_c_multi_no"      value="<?=$aryData['comment']['coupon']['T']['GM_NO'][$i]?>"/>
						<input type="text" class="_w50" name="bi_coupon_c_multi_count[]" id="bi_coupon_c_multi_count"   value="<?=$aryData['comment']['coupon']['T']['GM_MAX'][$i]?>"/>명에게 
						<input type="text" class="_w50" name="bi_coupon_c_multi_title[]" id="bi_coupon_c_multi_title"   value="<?=$aryData['comment']['coupon']['T']['GM_TITLE'][$i]?>" readOnly/>이란 제목으로 
						<input type="text" class="_w50" name="bi_coupon_c_multi_point[]" id="bi_coupon_c_multi_coupon"  value="<?=$aryData['comment']['coupon']['T']['GM_DATA'][$i]?>" readOnly/>쿠폰 지급
						<a href="javascript:goCouponCSelectLayerPopEvent('<?=$i?>')" id="" class="btn_sml"><span>쿠폰 선택</span></a>
						<a href="javascript:goCouponCMultiFormDeleteEvent('<?=$i?>')" id="couponCMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
					<?endfor;?>
				</ul>
				<!-- 차등포인트 폼 -->
				<textarea id="coupon_c_multi_form" style="display:none;" alt="차등포인트">
				<li><span id="no">{번호}</span> 
					<input type="text" class="_w50" name="bi_coupon_c_multi_count[]" id="bi_coupon_c_multi_count" value=""/>명에게 
					<input type="text" class="_w50" name="bi_coupon_c_multi_title[]" id="bi_coupon_c_multi_title" value=""/>이란 제목으로 
					<input type="text" class="_w50" name="bi_coupon_c_multi_coupon[]" id="bi_coupon_c_multi_coupon" value=""/>쿠폰 지급
					<a href="#" id="couponCMultiSelect" class="btn_sml"><span>쿠폰 선택</span></a>
					<a href="#" id="couponCMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
				</textarea>
				<input type="hidden" name="bi_coupon_c_multi_max" id="bi_coupon_c_multi_max" value="<?=$boardEventInfoAry['BI_COUPON_C_MULTI_MAX']?>"/>
				<input type="hidden" name="point_coupon_delete_list" id="" value=""/>
			</td>
		</tr>
	</table>	