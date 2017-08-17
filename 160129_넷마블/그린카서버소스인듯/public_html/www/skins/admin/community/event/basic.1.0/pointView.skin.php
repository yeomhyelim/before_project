<?
	## 설정
	$boardEventInfoAry = $_REQUEST['result']['EventInfoMgr'];

?>

<table>
	<?if($boardEventInfoAry['BI_POINT_C_USE']=="Y"):	// 댓글 포인트 ?>
	<tr>
		<th>댓글 포인트</th>
		<td>사용함(
			<?if($boardEventInfoAry['BI_POINT_C_GIVE']=="A"):?>자동포인트지급
			<?elseif($boardEventInfoAry['BI_POINT_C_GIVE']=="M"):?>수동포인트지급
			<?elseif($boardEventInfoAry['BI_POINT_C_GIVE']=="T"):?>멀티 차등포인트지급
			<?endif;?>)			
		</td>
	</tr>
	<?if(in_array($boardEventInfoAry['BI_POINT_C_GIVE'], array("A","M"))):?>
	<tr>
		<th>댓글작성시 포인트설정</th>
		<td><?=$boardEventInfoAry['BI_POINT_C_MARK']?> 포인트 자동지급</td>
	</tr>
	<?endif;?>
	<?if(in_array($boardEventInfoAry['BI_POINT_C_GIVE'], array("T"))):?>
	<tr>
		<th>댓글작성시 차등포인트 지급</th>
		<td>
			<ul id="point_c_multi">
				<?for($i=0;$i<$boardEventInfoAry['BI_POINT_C_MULTI_MAX'];$i++):?>
				<li id="point_c_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
					<?=$boardEventInfoAry["BI_POINT_C_MULTI_COUNT_{$i}"]?> 명에게 
					<?=$boardEventInfoAry["BI_POINT_C_MULTI_TITLE_{$i}"]?> 이란 제목으로 
					<?=$boardEventInfoAry["BI_POINT_C_MULTI_POINT_{$i}"]?> 포인트 지급
				<?endfor;?>
			</ul>
		</td>
	</tr>
	<?endif;?>
	<?else:?>
	<tr>
		<th>댓글 포인트</th>
		<td>사용안함		
		</td>
	</tr>
	<?endif;?>

	<?if($boardEventInfoAry['BI_COUPON_C_USE']=="Y"):	// 댓글 쿠폰 ?>
	<tr>
		<th>댓글 쿠폰</th>
		<td>사용함(
			<?if($boardEventInfoAry['BI_COUPON_C_GIVE']=="A"):?>자동쿠폰지급
			<?elseif($boardEventInfoAry['BI_COUPON_C_GIVE']=="M"):?>수동쿠폰지급
			<?elseif($boardEventInfoAry['BI_COUPON_C_GIVE']=="T"):?>멀티 차등쿠폰지급
			<?endif;?>)			
		</td>
	</tr>
	<?if(in_array($boardEventInfoAry['BI_COUPON_C_GIVE'], array("A","M"))):?>
	<tr>
		<th>댓글작성시쿠폰설정</th>
		<td><?=$boardEventInfoAry['BI_COUPON_C_MARK']?> 쿠폰 자동지급</td>
	</tr>
	<?endif;?>
	<?if(in_array($boardEventInfoAry['BI_COUPON_C_GIVE'], array("T"))):?>
	<tr>
		<th>댓글작성시 차등쿠폰 지급</th>
		<td>
			<ul id="point_c_multi">
				<?for($i=0;$i<$boardEventInfoAry['BI_COUPON_C_MULTI_MAX'];$i++):?>
				<li id="point_c_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
					<?=$boardEventInfoAry["BI_COUPON_C_MULTI_COUNT_{$i}"]?> 명에게 
					<?=$boardEventInfoAry["BI_COUPON_C_MULTI_TITLE_{$i}"]?> 이란 제목으로 
					<?=$boardEventInfoAry["BI_COUPON_C_MULTI_COUPON_{$i}"]?> 쿠폰 지급
				<?endfor;?>
			</ul>
		</td>
	</tr>
	<?endif;?>
	<?else:?>
	<tr>
		<th>댓글 쿠폰</th>
		<td>사용안함		
		</td>
	</tr>
	<?endif;?>
</table>

