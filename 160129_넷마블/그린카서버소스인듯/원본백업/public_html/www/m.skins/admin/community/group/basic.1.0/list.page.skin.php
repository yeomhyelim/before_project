<?
	// 설정
	if(!$groupView->field['page_block']):				
		$groupView->field['page_block'] = 5;
	endif;
	
	$page				= $groupView->field['page'];			// 현재 페이지		
	$list_total			= $groupView->field['list_total']['GroupMgr'];		// 리스트 전체 개수	
	$page_line			= $groupView->field['page_line'];		// 리스트 출력 개수	

	$page_total			= ceil($list_total / $page_line);		// 전체 페이지		
	$block_line			= $groupView->field['page_block'];		// 블럭 출력 개수	
	
	
	$block_total		= ceil($page_total / $block_line);		// 전체 블럭		
	$block				= ceil($page / $block_line);			// 현재 블럭

	$first_page			= ($block * $block_line) - $block_line + 1;		// 시작		블럭 
	$last_page			= ($block * $block_line);						// 마지막	블럭

	$prevLink			= $first_page	- 1;

	if($last_page>=$page_total):
		$last_page		= $page_total;
		$nextLink		= $page_total;
	else:
		$last_page		= $last_page;
		$nextLink		= $last_page	+ 1;	
	endif;
?>

	
<!--a href="<?=$link."1"?>" class="pre">처음으로</a-->

<? if($prevLink<=0): ?>
<img src="/shopAdmin/himg/common/btn_page_prev.gif" alt="prev"/>
<? else: ?>
<a href="<?=$link.$prevLink?>" class="pre"><img src="/shopAdmin/himg/common/btn_page_prev.gif" alt="prev"/></a>
<? endif; ?>

<? for($i=$first_page; $i<=$last_page; $i++) : ?>

	<? if($i==$page): ?>

		<strong><span><?=$i?></span></strong>

	<? else: ?>

		<a href="<?=$link.$i?>"><span><?=$i?></span></a>

	<? endif; ?>

<? endfor; ?>

<? if($page_total == $nextLink): ?>
<img src="/shopAdmin/himg/common/btn_page_next.gif" alt="next"/>
<? else: ?>
<a href="<?=$link.$nextLink?>" class="next"><img src="/shopAdmin/himg/common/btn_page_next.gif" alt="next"/></a>
<? endif; ?>

<!--a href="<?=$link.$page_total?>" class="next">마지막으로</a-->

