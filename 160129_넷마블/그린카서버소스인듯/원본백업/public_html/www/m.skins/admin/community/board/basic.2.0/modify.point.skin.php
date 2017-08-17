<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 포인트/쿠폰 옵션</h3>
</div>

<div class="tableForm">
	<table>
		<tr>
			<th>포인트정책</th>
			<td>
				<input type="radio" name="bi_point_use" value="Y"<?if($boardInfoAry['BI_POINT_USE']=="Y"){echo " checked";}?>/> 사용함
				<input type="radio" name="bi_point_use" value="N"<?if($boardInfoAry['BI_POINT_USE']=="N"){echo " checked";}?>/> 사용안함
			</td>
		</tr>
		<tr>
			<th>글쓰기시 포인트정책</th>
			<td>
				<input type="radio" name="bi_point_w_use" value="N"<?if($boardInfoAry['BI_POINT_W_USE']=="N"){echo " checked";}?>/>사용안함 
				<input type="radio" name="bi_point_w_use" value="Y"<?if($boardInfoAry['BI_POINT_W_USE']=="Y"){echo " checked";}?>/>사용함 (
					<input type="radio" name="bi_point_w_give" value="A"<?if($boardInfoAry['BI_POINT_W_GIVE']=="A"){echo " checked";}?>/>자동포인트지급  
					<input type="radio" name="bi_point_w_give" value="M"<?if($boardInfoAry['BI_POINT_W_GIVE']=="M"){echo " checked";}?>/>수동포인트지급  
					<input type="radio" name="bi_point_w_give" value="T"<?if($boardInfoAry['BI_POINT_W_GIVE']=="T"){echo " checked";}?>/>멀티 차등포인트지급)
			</td>
		</tr>
		<tr>
			<th>글쓰기시 포인트설정</th>
			<td><input type="text" class="_w50" name="bi_point_w_mark" value="<?=$boardInfoAry['BI_POINT_W_MARK']?>"/>포인트 자동지급</td>
		</tr>
		<!-- 차등포인트 지급(글수기) -->
		<tr>
			<th>
				차등포인트 지급
				<a href="javascript:goPointWMultiFormAddEvent()" class="btn_blue_sml"><span>+추가</span></a>
			</th>
			<td>
				<?if(!$boardInfoAry['BI_POINT_W_MULTI_MAX']) { $boardInfoAry['BI_POINT_W_MULTI_MAX'] = 1; }?>
				<ul id="point_w_multi">
					<?for($i=0;$i<$boardInfoAry['BI_POINT_W_MULTI_MAX'];$i++):?>
					<li id="point_w_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
						<input type="text" class="_w50" name="bi_point_w_multi_count[]" id="bi_point_w_multi_count" value="<?=$boardInfoAry["BI_POINT_W_MULTI_COUNT_{$i}"]?>"/>명에게 
						<input type="text" class="_w50" name="bi_point_w_multi_title[]" id="bi_point_w_multi_title" value="<?=$boardInfoAry["BI_POINT_W_MULTI_TITLE_{$i}"]?>"/>이란 제목으로 
						<input type="text" class="_w50" name="bi_point_w_multi_point[]" id="bi_point_w_multi_point" value="<?=$boardInfoAry["BI_POINT_W_MULTI_POINT_{$i}"]?>"/>포인트 지급
						<a href="javascript:goPointWMultiFormDeleteEvent('<?=$i?>')" id="pointWMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
					<?endfor;?>
				</ul>
				<!-- 차등포인트 폼 -->
				<textarea id="point_w_multi_form" style="display:none;" alt="차등포인트">
				<li id=""><span id="no">{번호}</span> 
					<input type="text" class="_w50" name="bi_point_w_multi_count[]" id="bi_point_w_multi_count" value=""/>명에게 
					<input type="text" class="_w50" name="bi_point_w_multi_title[]" id="bi_point_w_multi_title" value=""/>이란 제목으로 
					<input type="text" class="_w50" name="bi_point_w_multi_point[]" id="bi_point_w_multi_point" value=""/>포인트 지급
					<a href="#" id="pointWMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
				</textarea>
				<input type="hidden" name="bi_point_w_multi_max" id="bi_point_w_multi_max" value="<?=$boardInfoAry['BI_POINT_W_MULTI_MAX']?>"/>
			</td>
		</tr>
		<tr>
			<th>글쓰기시 쿠폰정책</th>
			<td>
				<input type="radio" name="bi_coupon_w_use" value="N"<?if($boardInfoAry['BI_COUPON_W_USE']=="N"){echo " checked";}?>/>사용안함 
				<input type="radio" name="bi_coupon_w_use" value="Y"<?if($boardInfoAry['BI_COUPON_W_USE']=="Y"){echo " checked";}?>/>사용함 (
					<input type="radio" name="bi_coupon_w_give" value="A"<?if($boardInfoAry['BI_COUPON_W_GIVE']=="A"){echo " checked";}?>/>자동쿠폰지급  
					<input type="radio" name="bi_coupon_w_give" value="M"<?if($boardInfoAry['BI_COUPON_W_GIVE']=="M"){echo " checked";}?>/>수동쿠폰지급  
					<input type="radio" name="bi_coupon_w_give" value="T"<?if($boardInfoAry['BI_COUPON_W_GIVE']=="T"){echo " checked";}?>/>멀티 차등쿠폰지급)
			</td>
		</tr>
		<tr>
			<th>댓글장성시 쿠폰설정</th>
			<td><input type="text" class="_w200" name="bi_coupon_w_mark" id="bi_coupon_w_mark" value="<?=$boardInfoAry['BI_COUPON_W_MARK']?>"  maxlength="10" readOnly/>
				<input type="hidden" name="bi_coupon_w_coupon" id="bi_coupon_w_coupon" value="<?=$boardInfoAry['BI_COUPON_W_COUPON']?>"/>
				쿠폰 관리자 확인 후 지급
				<a href="javascript:goCouponWSelectLayerPopEvent()" id="" class="btn_sml"><span>쿠폰 선택</span></a></li>
			</td>
		</tr>
		<!-- 차등쿠폰 지급(글쓰기) -->
		<tr>
			<th>
				차등포인트 지급
				<a href="javascript:goCouponWMultiFormAddEvent()" class="btn_blue_sml"><span>+추가</span></a>
			</th>
			<td>
				<?if(!$boardInfoAry['BI_COUPON_W_MULTI_MAX']) { $boardInfoAry['BI_COUPON_W_MULTI_MAX'] = 1; }?>
				<ul id="coupon_w_multi">
					<?for($i=0;$i<$boardInfoAry['BI_COUPON_W_MULTI_MAX'];$i++):?>
					<li id="coupon_w_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
						<input type="text" class="_w50" name="bi_coupon_w_multi_count[]" id="bi_coupon_w_multi_count" value="<?=$boardInfoAry["BI_COUPON_W_MULTI_COUNT_{$i}"]?>"/>명에게 
						<input type="text" class="_w50" name="bi_coupon_w_multi_title[]" id="bi_coupon_w_multi_title" value="<?=$boardInfoAry["BI_COUPON_W_MULTI_TITLE_{$i}"]?>" readOnly/>이란 제목으로 
						<input type="text" class="_w50" name="bi_coupon_w_multi_coupon[]" id="bi_coupon_w_multi_coupon" value="<?=$boardInfoAry["BI_COUPON_W_MULTI_COUPON_{$i}"]?>" readOnly/>쿠폰 지급
						<a href="javascript:goCouponWSelectLayerPopEvent('<?=$i?>')" id="" class="btn_sml"><span>쿠폰 선택</span></a>
						<a href="javascript:goCouponWMultiFormDeleteEvent('<?=$i?>')" id="couponCMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
					<?endfor;?>
				</ul>
				<!-- 차등쿠폰 폼 -->
				<textarea id="coupon_w_multi_form" style="display:none;" alt="차등포인트">
				<li><span id="no">{번호}</span> 
					<input type="text" class="_w50" name="bi_coupon_w_multi_count[]" id="bi_coupon_w_multi_count" value=""/>명에게 
					<input type="text" class="_w50" name="bi_coupon_w_multi_title[]" id="bi_coupon_w_multi_title" value="" readOnly/>이란 제목으로 
					<input type="text" class="_w50" name="bi_coupon_w_multi_coupon[]" id="bi_coupon_w_multi_coupon" value="" readOnly/>쿠폰 지급
					<a href="#" id="couponWMultiSelect" class="btn_sml"><span>쿠폰 선택</span></a>
					<a href="#" id="couponWMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
				</textarea>
				<input type="hidden" name="bi_coupon_w_multi_max" id="bi_coupon_w_multi_max" value="<?=$boardInfoAry['BI_COUPON_W_MULTI_MAX']?>"/>
			</td>
		</tr>
		<tr>
			<th>댓글</th>
			<td>
				<input type="radio"  name="bi_point_c_use" value="N"<?if($boardInfoAry['BI_POINT_C_USE']=="N"){echo " checked";}?>/>사용안함 
				<input type="radio"  name="bi_point_c_use" value="Y"<?if($boardInfoAry['BI_POINT_C_USE']=="Y"){echo " checked";}?>/>사용함 (
					<input type="radio"  name="bi_point_c_give" value="A"<?if($boardInfoAry['BI_POINT_C_GIVE']=="A"){echo " checked";}?>/>자동포인트지급  
					<input type="radio"  name="bi_point_c_give" value="M"<?if($boardInfoAry['BI_POINT_C_GIVE']=="M"){echo " checked";}?>/>수동포인트지급  
					<input type="radio"  name="bi_point_c_give" value="T"<?if($boardInfoAry['BI_POINT_C_GIVE']=="T"){echo " checked";}?>/>멀티 차등포인트지급)
			</td>
		</tr>
		<tr>
			<th>댓글작성시 포인트설정</th>
			<td><input type="input" class="_w50" name="bi_point_c_mark" value="<?=$boardInfoAry['BI_POINT_C_MARK']?>"  maxlength="10"/>포인트 자동지급</td>
		</tr>
		<!-- 차등포인트 지급(댓글) -->
		<tr>
			<th>
				차등포인트 지급
				<a href="javascript:goPointCMultiFormAddEvent()" class="btn_blue_sml"><span>+추가</span></a>
			</th>
			<td>
				<?if(!$boardInfoAry['BI_POINT_C_MULTI_MAX']) { $boardInfoAry['BI_POINT_C_MULTI_MAX'] = 1; }?>
				<ul id="point_c_multi">
					<?for($i=0;$i<$boardInfoAry['BI_POINT_C_MULTI_MAX'];$i++):?>
					<li id="point_c_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
						<input type="text" class="_w50" name="bi_point_c_multi_count[]" id="bi_point_c_multi_count" value="<?=$boardInfoAry["BI_POINT_C_MULTI_COUNT_{$i}"]?>"/>명에게 
						<input type="text" class="_w50" name="bi_point_c_multi_title[]" id="bi_point_c_multi_title" value="<?=$boardInfoAry["BI_POINT_C_MULTI_TITLE_{$i}"]?>"/>이란 제목으로 
						<input type="text" class="_w50" name="bi_point_c_multi_point[]" id="bi_point_c_multi_point" value="<?=$boardInfoAry["BI_POINT_C_MULTI_POINT_{$i}"]?>"/>포인트 지급
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
				<input type="hidden" name="bi_point_c_multi_max" id="bi_point_c_multi_max" value="<?=$boardInfoAry['BI_POINT_C_MULTI_MAX']?>"/>
			</td>
		</tr>
		<tr>
			<th>댓글작성시 쿠폰정책</th>
			<td>
				<input type="radio"  name="bi_coupon_c_use" value="N"<?if($boardInfoAry['BI_COUPON_C_USE']=="N"){echo " checked";}?>/>사용안함 
				<input type="radio"  name="bi_coupon_c_use" value="Y"<?if($boardInfoAry['BI_COUPON_C_USE']=="Y"){echo " checked";}?>/>사용함 (
					<input type="radio"  name="bi_coupon_c_give" value="A"<?if($boardInfoAry['BI_COUPON_C_GIVE']=="A"){echo " checked";}?>/>자동쿠폰지급  
					<input type="radio"  name="bi_coupon_c_give" value="M"<?if($boardInfoAry['BI_COUPON_C_GIVE']=="M"){echo " checked";}?>/>수동쿠폰지급  
					<input type="radio"  name="bi_coupon_c_give" value="T"<?if($boardInfoAry['BI_COUPON_C_GIVE']=="T"){echo " checked";}?>/>멀티 차등쿠폰지급)
			</td>
		</tr>
		<tr>
			<th>댓글장성시 쿠폰설정</th>
			<td><input type="text" class="_w200" name="bi_coupon_c_mark" id="bi_coupon_c_mark" value="<?=$boardInfoAry['BI_COUPON_C_MARK']?>"  maxlength="10" readOnly/>
				<input type="hidden" name="bi_coupon_c_coupon" id="bi_coupon_c_coupon" value="<?=$boardInfoAry['BI_COUPON_C_COUPON']?>"/>
				쿠폰 관리자 확인 후 지급
				<a href="javascript:goCouponCSelectLayerPopEvent()" id="" class="btn_sml"><span>쿠폰 선택</span></a></li>
			</td>
		</tr>
		<!-- 차등쿠폰 지급(댓글) -->
		<tr>
			<th>
				차등쿠폰 지급
				<a href="javascript:goCouponCMultiFormAddEvent()" class="btn_blue_sml"><span>+추가</span></a>
			</th>
			<td>
				<?if(!$boardInfoAry['BI_COUPON_C_MULTI_MAX']) { $boardInfoAry['BI_COUPON_C_MULTI_MAX'] = 1; }?>
				<ul id="coupon_c_multi">
					<?for($i=0;$i<$boardInfoAry['BI_COUPON_C_MULTI_MAX'];$i++):?>
					<li id="coupon_c_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
						<input type="text" class="_w50" name="bi_coupon_c_multi_count[]" id="bi_coupon_c_multi_count" value="<?=$boardInfoAry["BI_COUPON_C_MULTI_COUNT_{$i}"]?>"/>명에게 
						<input type="text" class="_w50" name="bi_coupon_c_multi_title[]" id="bi_coupon_c_multi_title" value="<?=$boardInfoAry["BI_COUPON_C_MULTI_TITLE_{$i}"]?>" readOnly/>이란 제목으로 
						<input type="text" class="_w50" name="bi_coupon_c_multi_coupon[]" id="bi_coupon_c_multi_coupon" value="<?=$boardInfoAry["BI_COUPON_C_MULTI_COUPON_{$i}"]?>" readOnly/>쿠폰 지급
						<a href="javascript:goCouponCSelectLayerPopEvent('<?=$i?>')" id="" class="btn_sml"><span>쿠폰 선택</span></a>
						<a href="javascript:goCouponCMultiFormDeleteEvent('<?=$i?>')" id="couponCMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
					<?endfor;?>
				</ul>
				<!-- 차등쿠폰 폼 -->
				<textarea id="coupon_c_multi_form" style="display:none;" alt="차등포인트">
				<li><span id="no">{번호}</span> 
					<input type="text" class="_w50" name="bi_coupon_c_multi_count[]" id="bi_coupon_c_multi_count" value=""/>명에게 
					<input type="text" class="_w50" name="bi_coupon_c_multi_title[]" id="bi_coupon_c_multi_title" value=""/>이란 제목으로 
					<input type="text" class="_w50" name="bi_coupon_c_multi_coupon[]" id="bi_coupon_c_multi_coupon" value=""/>쿠폰 지급
					<a href="#" id="couponCMultiSelect" class="btn_sml"><span>쿠폰 선택</span></a>
					<a href="#" id="couponCMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
				</textarea>
				<input type="hidden" name="bi_coupon_c_multi_max" id="bi_coupon_c_multi_max" value="<?=$boardInfoAry['BI_COUPON_C_MULTI_MAX']?>"/>
			</td>
		</tr>

	</table>
</div>
<!-- ******** 컨텐츠 ********* -->