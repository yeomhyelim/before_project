<?
	## 설정
	$pointSet				= $_REQUEST['result']['pointSet'];
	$couponSet				= $_REQUEST['result']['couponSet'];
?>

<table>
<?if($pointSet['bi_point_use']=="Y"): // 포인트 지급 사용 ?>
	<tr>
		<?if($pointSet['where']=="w"):?>
		<th>작성글 포인트</th>
		<?else:?>
		<th>댓글 포인트</th>
		<?endif;?>
		<td>사용함(
			<?if($pointSet['bi_point_give']=="A"):?>자동포인트지급
			<?elseif($pointSet['bi_point_give']=="M"):?>수동포인트지급
			<?elseif($pointSet['bi_point_give']=="T"):?>멀티 차등포인트지급
			<?endif;?>)			
		</td>
	</tr>
	<?if(in_array($pointSet['bi_point_give'], array("A","M"))):?>
	<tr>
		<?if($pointSet['where']=="w"):?>
		<th>작성글 포인트설정</th>
		<?else:?>
		<th>댓글 포인트설정</th>
		<?endif;?>
		<td><?=$pointSet['bi_point_mark']?> 포인트 지급</td>
	</tr>
	<?endif;?>
	<?if(in_array($pointSet['bi_point_give'], array("T"))):?>
	<tr>
		<?if($pointSet['where']=="w"):?>
		<th>작성글 차등포인트 지급</th>
		<?else:?>
		<th>댓글 차등포인트 지급</th>
		<?endif;?>
		<td>
			<ul id="point_multi">
				<?for($i=0;$i<$pointSet['bi_point_multi_max'];$i++):?>
				<li id="point_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
					<?=$pointSet["bi_point_multi_count"][$i]?> 명에게 
					<?=$pointSet["bi_point_multi_title"][$i]?> 이란 제목으로 
					<?=$pointSet["bi_point_multi_point"][$i]?> 포인트 지급
				<?endfor;?>
			</ul>
		</td>
	</tr>
	<?endif;?>
<?else:?>
	<tr>
		<?if($pointSet['where']=="w"):?>
		<th>작성글 포인트</th>
		<?else:?>
		<th>댓글 포인트</th>
		<?endif;?>
		<td>사용안함		
		</td>
	</tr>
<?endif;?>
<?if($couponSet['bi_coupon_use']=="Y"): // 쿠폰 지급 사용 ?>
	<tr>
		<?if($pointSet['where']=="w"):?>
		<th>작성글 쿠폰</th>
		<?else:?>
		<th>댓글 쿠폰</th>
		<?endif;?>
		<td>사용함(
			<?if($couponSet['bi_coupon_give']=="A"):?>자동쿠폰지급
			<?elseif($couponSet['bi_coupon_give']=="M"):?>수동쿠폰지급
			<?elseif($couponSet['bi_coupon_give']=="T"):?>멀티 차등쿠폰지급
			<?endif;?>)			
		</td>
	</tr>
	<?if(in_array($couponSet['bi_coupon_give'], array("A","M"))):?>
	<tr>
		<?if($pointSet['where']=="w"):?>
		<th>작성글 쿠폰설정</th>
		<?else:?>
		<th>댓글 쿠폰설정</th>
		<?endif;?>
		<td><?=$couponSet['bi_coupon_mark']?> 쿠폰 지급</td>
	</tr>
	<?endif;?>
	<?if(in_array($couponSet['bi_coupon_give'], array("T"))):?>
	<tr>
		<?if($pointSet['where']=="w"):?>
		<th>작성글 차등쿠폰 지급</th>
		<?else:?>
		<th>댓글 차등쿠폰 지급</th>
		<?endif;?>
		<td>
			<ul id="coupon_multi">
				<?for($i=0;$i<$couponSet['bi_coupon_multi_max'];$i++):?>
				<li id="coupon_multi_<?=$i?>"><span id="no"><?=$i+1?>)</span> 
					<?=$couponSet["bi_coupon_multi_count"][$i]?> 명에게 
					<?=$couponSet["bi_coupon_multi_title"][$i]?> 이란 제목으로 
					<?=$couponSet["bi_coupon_multi_coupon"][$i]?> 포인트 지급
				<?endfor;?>
			</ul>
		</td>
	</tr>
	<?endif;?>
<?else:?>
	<tr>
		<?if($pointSet['where']=="w"):?>
		<th>작성글 쿠폰</th>
		<?else:?>
		<th>댓글 쿠폰</th>
		<?endif;?>
		<td>사용안함		
		</td>
	</tr>
<?endif;?>
</table>
