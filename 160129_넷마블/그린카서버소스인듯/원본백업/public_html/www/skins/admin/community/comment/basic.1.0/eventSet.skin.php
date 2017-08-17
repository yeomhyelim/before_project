	<?if($boardEventInfoAry['BI_POINT_C_USE']=="Y"):	// 댓글 포인트 ?>
		<?if($boardEventInfoAry['BI_POINT_C_GIVE']=="M"):	// 수동 지급 ?>
		* 체크한 회원을 <?=$boardEventInfoAry['BI_POINT_C_MARK']?> 포인트 지급합니다.
		<a class="btn_big" href="javascript:goCommentPointGiveActEvent()" id="menu_auth_w" style=""><strong>포인트 발급</strong></a>
		<?elseif($boardEventInfoAry['BI_POINT_C_GIVE']=="T"): // 차등 지급 ?>
			<select name="bi_point_c_multi_no">
			<?for($i=0;$i<$boardEventInfoAry['BI_POINT_C_MULTI_MAX'];$i++):?>
				<option value="<?=$i?>">
					<?=$boardEventInfoAry["BI_POINT_C_MULTI_COUNT_{$i}"]?> 명에게 
					<?=$boardEventInfoAry["BI_POINT_C_MULTI_TITLE_{$i}"]?> 이란 제목으로 
					<?=$boardEventInfoAry["BI_POINT_C_MULTI_POINT_{$i}"]?> 포인트 지급
				</option>
			<?endfor;?>
				</select>
				<a class="btn_big" href="javascript:goCommentPointGiveActEvent()" id="menu_auth_w" style=""><strong>포인트 발급</strong></a>
		<?endif;?>
	<?endif;?>
	<br>
 	<?if($boardEventInfoAry['BI_COUPON_C_USE']=="Y"):	// 댓글 쿠폰 ?>
		<?if($boardEventInfoAry['BI_COUPON_C_GIVE']=="M"):	// 수동 지급 ?>
		* 체크한 회원을 <?=$boardEventInfoAry['BI_COUPON_C_MARK']?> 쿠폰 지급합니다.
		<a class="btn_big" href="javascript:goCommentCouponGiveActEvent()" id="menu_auth_w" style=""><strong>쿠폰 발급</strong></a>
		<input type="hidden" name="bi_coupon_c_coupon" id="bi_coupon_c_coupon" value="<?=$boardEventInfoAry['BI_COUPON_C_COUPON']?>"/>
		<?elseif($boardEventInfoAry['BI_COUPON_C_GIVE']=="T"): // 차등 지급 ?>
			<select name="bi_coupon_c_multi_no">
			<?for($i=0;$i<$boardEventInfoAry['BI_COUPON_C_MULTI_MAX'];$i++):?>
				<option value="<?=$i?>">
					<?=$boardEventInfoAry["BI_COUPON_C_MULTI_COUNT_{$i}"]?> 명에게 
					<?=$boardEventInfoAry["BI_COUPON_C_MULTI_TITLE_{$i}"]?> 이란 제목으로 
					<?=$boardEventInfoAry["BI_COUPON_C_MULTI_POINT_{$i}"]?> 포인트 지급
				</option>
			<?endfor;?>
			</select>
			<a class="btn_big" href="javascript:goCommentCouponGiveActEvent()" id="menu_auth_w" style=""><strong>쿠폰 발급</strong></a>
		<?endif;?>
	<?endif;?>

	<input type="hidden" name="bi_point_c_give" id="bi_point_c_give" value="<?=$boardEventInfoAry['BI_POINT_C_GIVE']?>"> 
	<input type="hidden" name="bi_coupon_c_give" id="bi_coupon_c_give" value="<?=$boardEventInfoAry['BI_COUPON_C_GIVE']?>"> 



	