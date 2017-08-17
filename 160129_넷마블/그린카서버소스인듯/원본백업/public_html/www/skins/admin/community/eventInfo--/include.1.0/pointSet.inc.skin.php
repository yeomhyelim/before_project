<?
	## 설정
	$pointSet				= $_REQUEST['result']['pointSet'];
	$couponSet				= $_REQUEST['result']['couponSet'];
	$where					= strtoupper($pointSet['where']);
?>

<?if($pointSet['bi_point_use']=="Y"):	// 글 포인트 ?>
	<?if($pointSet['bi_point_give']=="M"):	// 수동 지급 ?>
	* 체크한 회원을 <?=$pointSet['bi_point_mark']?> 포인트 지급합니다.
	<a class="btn_big" href="javascript:goCommentPointGiveActEvent('<?=$where?>')" id="menu_auth_w" style=""><strong>포인트 발급</strong></a>
	<?elseif($pointSet['bi_point_give']=="T"): // 차등 지급 ?>
	<select name="bi_point_c_multi_no">
		<?for($i=0;$i<$pointSet['bi_point_multi_max'];$i++):?>
		<option value="<?=$i?>">
			<?=$pointSet["bi_point_multi_count"][$i]?> 명에게 
			<?=$pointSet["bi_point_multi_title"][$i]?> 이란 제목으로 
			<?=$pointSet["bi_point_multi_point"][$i]?> 포인트 지급
		</option>
		<?endfor;?>
		</select>
		<a class="btn_big" href="javascript:goCommentPointGiveActEvent('<?=$where?>')" id="menu_auth_w" style=""><strong>포인트 발급</strong></a>
	<?endif;?>
<?endif;?>
<br>
<?if($couponSet['bi_coupon_use']=="Y"):	// 글 쿠폰 ?>
	<?if($couponSet['bi_coupon_give']=="M"):	// 수동 지급 ?>
	* 체크한 회원을 <?=$couponSet['bi_coupon_mark']?> 쿠폰 지급합니다.
	<a class="btn_big" href="javascript:goCommentCouponGiveActEvent('<?=$where?>')" id="menu_auth_w" style=""><strong>쿠폰 발급</strong></a>
	<?elseif($couponSet['bi_coupon_give']=="T"): // 차등 지급 ?>
	<select name="bi_coupon_multi_no">
		<?for($i=0;$i<$couponSet['bi_coupon_multi_max'];$i++):?>
		<option value="<?=$i?>">
			<?=$couponSet["bi_coupon_multi_count"][$i]?> 명에게 
			<?=$couponSet["bi_coupon_multi_title"][$i]?> 이란 제목으로 
			<?=$couponSet["bi_coupon_multi_coupon"][$i]?> 쿠폰 지급
		</option>
		<?endfor;?>
		</select>
		<a class="btn_big" href="javascript:goCommentCouponGiveActEvent('<?=$where?>')" id="menu_auth_w" style=""><strong>쿠폰 발급</strong></a>
	<?endif;?>
<?endif;?>