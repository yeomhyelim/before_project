<?php
	
	## 모듈 설정
	$objSearchWordModule = new SearchWordModule($db);

	## 리스트 불러오기
	$param = '';
	$param['LIMIT_END'] = 20;
	$param['ORDER_BY'] = 'countDesc';
	$arySearchWordList = $objSearchWordModule->getSearchWordSelectEx("OP_ARYTOTAL", $param);
	if(!$arySearchWordList) return;

?>
<div class="searchMainWrap">
	<ul class="searchMain">
		<?php foreach($arySearchWordList as $key => $row):?>
		<li class="item item-<?php echo $key;?>"><a href="/?menuType=product&mode=search&searchField=N&searchKey=<?php echo $row['SW_WORD'];?>"><span class="num"><?php echo $key+1;?></span><span class="word"><?php echo $row['SW_WORD'];?></span></a></li>
		<?php endforeach;?>
	</ul>
	<div class="clr"></div>
</div>