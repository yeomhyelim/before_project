<!--a href="<?=$_REQUEST['link']."1"?>" class="pre">처음으로</a-->

<? $tableName = "CommentMgr"; ?>

<? if($_REQUEST['prev_page'][$tableName]<=0): ?>
<a class="btnPrev">이전</a>
<? else: ?>
<a href="<?=$_REQUEST['link'][$tableName].$_REQUEST['prev_page'][$tableName]?>" class="btnPrev">이전</a>
<? endif; ?>

<? for($i=$_REQUEST['first_page'][$tableName]; $i<=$_REQUEST['last_page'][$tableName]; $i++) : ?>

	<? if($i==$_REQUEST['page'][$tableName]): ?>

		<strong><span><?=$i?></span></strong>

	<? else: ?>

		<a href="<?=$_REQUEST['link'][$tableName].$i?>"><span><?=$i?></span></a>

	<? endif; ?>

<? endfor; ?>

<? if($_REQUEST['page_total'][$tableName] == $_REQUEST['front_page'][$tableName]): ?>
<a class="btnNext">다음</a>
<? else: ?>
<a href="<?=$_REQUEST['link'][$tableName].$_REQUEST['front_page'][$tableName]?>" class="btnNext">다음</a>
<? endif; ?>

<!--a href="<?=$_REQUEST['link'].$_REQUEST['page_total']?>" class="next">마지막으로</a-->