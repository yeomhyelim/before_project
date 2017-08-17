<?
	$boardEventInfoAry		= $_REQUEST['result']['EventInfoMgr'];
	$giveType				= $boardEventInfoAry['BI_POINT_C_GIVE'];
	$giveCouponType			= $boardEventInfoAry['BI_COUPON_C_GIVE'];

	## 설정(데이터)
	$giftResult = $_REQUEST['result']['GiftMgr'];
	$cnt		= 0;
	while($row = mysql_fetch_array($giftResult)) : 
	//	print_r($row);
		$gm_type		= $row['GM_TYPE'];
		$gm_give_type	= $row['GM_GIVE_TYPE'];
		$gm_area		= $row['GM_AREA'];

		if(in_array($gm_give_type, array("A"))):
			$data[$gm_area][$gm_type]['A']['GM_NO']					= $row['GM_NO'];
			$data[$gm_area][$gm_type]['A']['GM_MAX']				= $row['GM_MAX'];
			$data[$gm_area][$gm_type]['A']['GM_TITLE']				= $row['GM_TITLE'];
			$data[$gm_area][$gm_type]['A']['GM_DATA']				= $row['GM_DATA'];
		elseif(in_array($gm_give_type, array("T"))):
			$aryData[$gm_area][$gm_type]['T']['GM_NO'][]			= $row['GM_NO'];
			$aryData[$gm_area][$gm_type]['T']['GM_MAX'][]			= $row['GM_MAX'];
			$aryData[$gm_area][$gm_type]['T']['GM_TITLE'][]			= $row['GM_TITLE'];
			$aryData[$gm_area][$gm_type]['T']['GM_DATA'][]			= $row['GM_DATA'];
		endif;
	endwhile;
?> 

	<?if($boardEventInfoAry['BI_POINT_C_USE']=="Y"):	// 댓글 포인트 ?>
		<?if($giveType=="M"):	// 수동 지급 ?>
		* 체크한 회원을 (<?=$data['comment']['point']["A"]['GM_DATA']?>) 포인트 지급합니다.
		<?elseif($giveType=="T"): // 차등 지급 ?>
			<select name="bi_point_c_multi_no">
			<option value="">포인트 발급 정보를 선택하세요.</a>
			<?$cnt = sizeof($aryData["comment"]["point"]['T']['GM_NO']);?>
			<?for($i=0;$i<$cnt;$i++):?>
				<option value="<?=$aryData["comment"]["point"]['T']['GM_NO'][$i]?>">
					<?=$aryData["comment"]["point"]['T']['GM_MAX'][$i]?> 명에게 
					<?=$aryData["comment"]["point"]['T']['GM_TITLE'][$i]?> 이란 제목으로 
					<?=$aryData["comment"]["point"]['T']['GM_DATA'][$i]?> 포인트 지급
				</option>
			<?endfor;?>
				</select>
		<?endif;?>
		<a class="btn_big" href="javascript:goCommentPointGiveActEvent()"   id="menu_auth_w" style=""><strong>포인트 발급</strong></a>
		<a class="btn_big" href="javascript:goCommentPointCancelActEvent()" id="menu_auth_w" style=""><strong>포인트 발급 취소</strong></a>
	<?endif;?>
	<br>
 	<?if($boardEventInfoAry['BI_COUPON_C_USE']=="Y"):	// 댓글 쿠폰 ?>
		<?if($giveCouponType=="M"):	// 수동 지급 ?>
		* 체크한 회원을 (<?=$data['comment']['coupon']['A']['GM_TITLE']?>) 쿠폰 지급합니다.
		<input type="hidden" name="bi_coupon_c_coupon" id="bi_coupon_c_coupon" value="<?=$boardEventInfoAry['BI_COUPON_C_COUPON']?>"/>
		<?elseif($giveCouponType=="T"): // 차등 지급 ?>
			<select name="bi_coupon_c_multi_no">
			<?$cnt = sizeof($aryData["comment"]["coupon"]['T']['GM_NO']);?>
			<option value="">쿠폰 발급 정보를 선택하세요.</a>
			<?for($i=0;$i<$cnt;$i++):?>
				<option value="<?=$aryData["comment"]["coupon"]['T']['GM_NO'][$i]?>">
					<?=$aryData["comment"]["coupon"]['T']['GM_MAX'][$i]?> 명에게 
					<?=$aryData["comment"]["coupon"]['T']['GM_TITLE'][$i]?> 이란 제목으로 
					<?=$aryData["comment"]["coupon"]['T']['GM_DATA'][$i]?> 포인트 지급
				</option>
			<?endfor;?>
			</select>
		<?endif;?>
		<a class="btn_big" href="javascript:goCommentCouponGiveActEvent()"   id="menu_auth_w" style=""><strong>쿠폰 발급</strong></a>
		<a class="btn_big" href="javascript:goCommentCouponCancelActEvent()" id="menu_auth_w" style=""><strong>쿠폰 발급 취소</strong></a>
	<?endif;?>

	<input type="hidden" name="bi_point_c_give" id="bi_point_c_give" value="<?=$giveType?>"> 
	<input type="hidden" name="bi_coupon_c_give" id="bi_coupon_c_give" value="<?=$giveCouponType?>"> 

	<input type="hidden" name="cm_point_gm_no"  value="<?=$data['comment']['point']["A"]['GM_NO']?>"> 
	<input type="hidden" name="cm_coupon_gm_no" value="<?=$data['comment']['coupon']["A"]['GM_NO']?>"> 
	
	