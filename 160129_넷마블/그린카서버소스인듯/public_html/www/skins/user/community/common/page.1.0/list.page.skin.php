<? 
	## 설정
	$pageResult = $_REQUEST['result'][$tableName]['pageResult'];

	## 2013.08.29 kim hee sung 페이지가 1개이면, 페이징이 안보이도록 요청함.(아로마리즈)
	if($pageResult['page_total'] > 0):
?>

<!--a href="<?=$pageResult['link']."1"?>" class="pre">처음으로</a-->

<? if($pageResult['prev_page']<=0): ?>
	<a  class="btn_board_prev"><span><?=$LNG_TRANS_CHAR["MW00052"] //이전?></span></a>
<? else: ?>
	<a href="<?=$pageResult['link'].$pageResult['prev_page']?>" class="btn_board_prev"><span><?=$LNG_TRANS_CHAR["MW00052"] //이전?></span></a>
<? endif; ?>

<? for($i=$pageResult['first_page']; $i<=$pageResult['last_page']; $i++) : ?>

	<? if($i==$pageResult['page']): ?>

		<strong><span class="chkPage"><?=$i?></span></strong>

	<? else: ?>

		<a href="<?=$pageResult['link'].$i?>"><span class="pageCnt"><?=$i?></span></a>

	<? endif; ?>

<? endfor; ?>

<? if($pageResult['page_total'] == $pageResult['front_page']): ?>
<a class="btn_board_next"><span><?=$LNG_TRANS_CHAR["MW00043"] //다음?></span></a>
<? else: ?>
<a href="<?=$pageResult['link'].$pageResult['front_page']?>" class="btn_board_next"><span><?=$LNG_TRANS_CHAR["MW00043"] //다음?></span></a>
<? endif; ?>

<!--a href="<?=$pageResult['link'].$pageResult['page_total']?>" class="next">마지막으로</a-->

<?
	endif;
?>