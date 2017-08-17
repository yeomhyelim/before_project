<!--a href="<?=$_REQUEST['link']."1"?>" class="pre">처음으로</a-->

<? $tableName = "ProductMgr"; ?>

<? if($_REQUEST['prev_page'][$tableName]<=0): ?>
<a class="pre"><img src="/shopAdmin/himg/common/btn_page_prev.gif" alt="prev"/></a>
<? else: ?>
<a href="<?=$_REQUEST['link'][$tableName].$_REQUEST['prev_page'][$tableName]?>" class="pre"><img src="/shopAdmin/himg/common/btn_page_prev.gif" alt="prev"/></a>
<? endif; ?>

<? for($i=$_REQUEST['first_page'][$tableName]; $i<=$_REQUEST['last_page'][$tableName]; $i++) : ?>

	<? if($i==$_REQUEST['page'][$tableName]): ?>

		<strong><span><?=$i?></span></strong>

	<? else: ?>

		<a href="javascript:goDataListPageJsonEvent('<?=$i?>');"><span><?=$i?></span></a>

	<? endif; ?>

<? endfor; ?>

<? if($_REQUEST['page_total'][$tableName] == $_REQUEST['front_page'][$tableName]): ?>
<a class="next"><img src="/shopAdmin/himg/common/btn_page_next.gif" alt="next"/></a>
<? else: ?>
<a href="<?=$_REQUEST['link'][$tableName].$_REQUEST['front_page'][$tableName]?>" class="next"><img src="/shopAdmin/himg/common/btn_page_next.gif" alt="next"/></a>
<? endif; ?>

<!--a href="<?=$_REQUEST['link'].$_REQUEST['page_total']?>" class="next">마지막으로</a-->