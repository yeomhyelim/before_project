<table>
		<tr>
			<th>댓글</th>
			<td>
				<input type="radio"  name="bi_point_c_use" value="N"<?if($_REQUEST['BOARD_INFO']['bi_point_c_use']=="N"){echo " checked";}?>/>사용안함 
				<input type="radio"  name="bi_point_c_use" value="Y"<?if($_REQUEST['BOARD_INFO']['bi_point_c_use']=="Y"){echo " checked";}?>/>사용함 (
					<input type="radio"  name="bi_point_c_give" value="A"<?if($_REQUEST['BOARD_INFO']['BI_POINT_C_GIVE']=="A"){echo " checked";}?>/>자동포인트지급  
					<input type="radio"  name="bi_point_c_give" value="M"<?if($_REQUEST['BOARD_INFO']['BI_POINT_C_GIVE']=="M"){echo " checked";}?>/>수동포인트지급  
					<input type="radio"  name="bi_point_c_give" value="T"<?if($_REQUEST['BOARD_INFO']['BI_POINT_C_GIVE']=="T"){echo " checked";}?>/>멀티 차등포인트지급)
			</td>
		</tr>
		<tr>
			<th>댓글작성시 포인트설정</th>
			<td><input type="input" class="_w50" name="bi_point_c_mark" value="<?=$_REQUEST['BOARD_INFO']['bi_point_c_mark']?>"  maxlength="10"/>포인트 자동지급</td>
		</tr>
		<!-- 차등포인트 지급(댓글) -->
		<tr>
			<th>
				차등포인트 지급
				<a href="javascript:goPointCMultiFormAddEvent()" class="btn_blue_sml"><span>+추가</span></a>
			</th>
			<td>
				<?if(!$_REQUEST['BOARD_INFO']['bi_point_c_multi_max']) { $_REQUEST['BOARD_INFO']['bi_point_c_multi_max'] = 1; }?>
				<ul id="point_c_multi">
					<?for($i=0;$i<$_REQUEST['BOARD_INFO']['bi_point_c_multi_max'];$i++):?>
					<li id="point_c_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
						<input type="text" class="_w50" name="bi_point_c_multi_count[]" id="bi_point_c_multi_count" value="<?=$_REQUEST['BOARD_INFO']["bi_point_c_multi_count"][$i]?>"/>명에게 
						<input type="text" class="_w50" name="bi_point_c_multi_title[]" id="bi_point_c_multi_title" value="<?=$_REQUEST['BOARD_INFO']["bi_point_c_multi_title"][$i]?>"/>이란 제목으로 
						<input type="text" class="_w50" name="bi_point_c_multi_point[]" id="bi_point_c_multi_point" value="<?=$_REQUEST['BOARD_INFO']["bi_point_c_multi_point"][$i]?>"/>포인트 지급
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
				<input type="hidden" name="bi_point_c_multi_max" id="bi_point_c_multi_max" value="<?=$_REQUEST['BOARD_INFO']['bi_point_c_multi_max']?>"/>
			</td>
		</tr>
		<tr>
			<th>댓글작성시 쿠폰정책</th>
			<td>
				<input type="radio"  name="bi_coupon_c_use" value="N"<?if($_REQUEST['BOARD_INFO']['bi_coupon_c_use']=="N"){echo " checked";}?>/>사용안함 
				<input type="radio"  name="bi_coupon_c_use" value="Y"<?if($_REQUEST['BOARD_INFO']['bi_coupon_c_use']=="Y"){echo " checked";}?>/>사용함 (
					<input type="radio"  name="bi_coupon_c_give" value="A"<?if($_REQUEST['BOARD_INFO']['BI_COUPON_C_GIVE']=="A"){echo " checked";}?>/>자동쿠폰지급  
					<input type="radio"  name="bi_coupon_c_give" value="M"<?if($_REQUEST['BOARD_INFO']['BI_COUPON_C_GIVE']=="M"){echo " checked";}?>/>수동쿠폰지급  
					<input type="radio"  name="bi_coupon_c_give" value="T"<?if($_REQUEST['BOARD_INFO']['BI_COUPON_C_GIVE']=="T"){echo " checked";}?>/>멀티 차등쿠폰지급)
			</td>
		</tr>
		<tr>
			<th>댓글장성시 쿠폰설정</th>
			<td><input type="text" class="_w50" name="bi_coupon_c_mark" value="<?=$_REQUEST['BOARD_INFO']['bi_coupon_c_mark']?>"  maxlength="10"/>쿠폰 관리자 확인 후 지급</td>
		</tr>
		<!-- 차등쿠폰 지급(댓글) -->
		<tr>
			<th>
				차등쿠폰 지급
				<a href="javascript:goCouponCMultiFormAddEvent()" class="btn_blue_sml"><span>+추가</span></a>
			</th>
			<td>
				<?if(!$_REQUEST['BOARD_INFO']['bi_coupon_c_multi_max']) { $_REQUEST['BOARD_INFO']['bi_coupon_c_multi_max'] = 1; }?>
				<ul id="coupon_c_multi">
					<?for($i=0;$i<$_REQUEST['BOARD_INFO']['bi_coupon_c_multi_max'];$i++):?>
					<li id="coupon_c_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
						<input type="text" class="_w50" name="bi_coupon_c_multi_count[]" id="bi_coupon_c_multi_count" value="<?=$_REQUEST['BOARD_INFO']["bi_coupon_c_multi_count"][$i]?>"/>명에게 
						<input type="text" class="_w50" name="bi_coupon_c_multi_title[]" id="bi_coupon_c_multi_title" value="<?=$_REQUEST['BOARD_INFO']["bi_coupon_c_multi_title"][$i]?>"/>이란 제목으로 
						<input type="text" class="_w50" name="bi_coupon_c_multi_coupon[]" id="bi_coupon_c_multi_coupon" value="<?=$_REQUEST['BOARD_INFO']["bi_coupon_c_multi_coupon"][$i]?>"/>쿠폰 지급
						<a href="javascript:goCouponCMultiFormDeleteEvent('<?=$i?>')" id="couponCMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
					<?endfor;?>
				</ul>
				<!-- 차등포인트 폼 -->
				<textarea id="coupon_c_multi_form" style="display:none;" alt="차등포인트">
				<li><span id="no">{번호}</span> 
					<input type="text" class="_w50" name="bi_coupon_c_multi_count[]" id="bi_coupon_c_multi_count" value=""/>명에게 
					<input type="text" class="_w50" name="bi_coupon_c_multi_title[]" id="bi_coupon_c_multi_title" value=""/>이란 제목으로 
					<input type="text" class="_w50" name="bi_coupon_c_multi_coupon[]" id="bi_coupon_c_multi_coupon" value=""/>쿠폰 지급
					<a href="#" id="couponCMultiDelete" class="btn_sml"><span>-삭제</span></a></li>
				</textarea>
				<input type="hidden" name="bi_coupon_c_multi_max" id="bi_coupon_c_multi_max" value="<?=$_REQUEST['BOARD_INFO']['bi_coupon_c_multi_max']?>"/>
			</td>
		</tr>
	</table>		