<? 
	## 설정
	$pageResult = $_REQUEST['result'][$tableName]['pageResult'];
?>



<!--a href="<?=$pageResult['link']."1"?>" class="pre">처음으로</a-->

<? if($pageResult['prev_page']<=0): ?>
<a class="pre"><img src="/shopAdmin/himg/common/btn_page_prev.gif" alt="prev"/></a>
<? else: ?>
<a href="<?=$pageResult['link'].$pageResult['prev_page']?>" class="pre"><img src="/shopAdmin/himg/common/btn_page_prev.gif" alt="prev"/></a>
<? endif; ?>

<? for($i=$pageResult['first_page']; $i<=$pageResult['last_page']; $i++) : ?>

	<? if($i==$pageResult['page']): ?>

		<strong><span><?=$i?></span></strong>

	<? else: ?>

		<a href="<?=$pageResult['link'].$i?>"><span><?=$i?></span></a>

	<? endif; ?>

<? endfor; ?>

<? if($pageResult['page_total'] == $pageResult['front_page']): ?>
<a class="next"><img src="/shopAdmin/himg/common/btn_page_next.gif" alt="next"/></a>
<? else: ?>
<a href="<?=$pageResult['link'].$pageResult['front_page']?>" class="next"><img src="/shopAdmin/himg/common/btn_page_next.gif" alt="next"/></a>
<? endif; ?>

<!--a href="<?=$pageResult['link'].$pageResult['page_total']?>" class="next">마지막으로</a-->

