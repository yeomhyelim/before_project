<?php
	## 모듈 설정
	$objBoardIcon	= new BoardIconModule($db);
	$objBoardData	= new BoardDataModule($db);

	## 기본 설정
	$intPage						= $_GET['page'];

	## 리스트
	$param							= "";
	$intTotal						= $objBoardIcon->getBoardIconSelectEx("OP_COUNT", $param);					// 데이터 전체 개수 
	$intPageLine					= 10;																		// 리스트 개수 
	$intPage						= ( $intPage )				? $intPage		: 1;
	$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$param['BOARD_MGR_JOIN']		= "Y";
	$param['LIMIT']					= "{$intFirst},{$intPageLine}";
	$resBoardIconResult				= $objBoardIcon->getBoardIconSelectEx("OP_LIST", $param);

	$intPageBlock					= 10;																		// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );

	## 페이징 링크 주소
	$queryString	= explode("&", $_SERVER['QUERY_STRING']);
	$linkPage		= "";
	foreach($queryString as $string):
		list($key,$val)		= explode("=", $string);
		if($key == "page")	{ continue; }
		if($linkPage)		{ $linkPage .= "&"; }
		$linkPage		   .= $string;
	endforeach;

	$linkPage		= "./?{$linkPage}&page=";
//	echo $linkPage;
?>
<div class="contentTop">
	<h2>커뮤니티 아이콘 리스트</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tableList">
	<table>
		<colgroup>
			<col width=50/>
			<col width=100/>
			<col width=200/>
			<col />
			<col width=100/>
		</colgroup>
		<tr>
			<th>번호</th>
			<th>아이콘 이름</th>
			<th>게시판 이름(코드)</th>
			<th>게시판 번호(제목)</th>
			<th>관리</th>
		</tr>
		<? if(!$intTotal):?>
		<tr>
			<td colspan="7">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($resBoardIconResult)):
			$intNo			= $row['BI_NO'];
			$strName		= $row['BI_ICON'];
			$strBCode		= $row['BI_B_CODE'];
			$strBCodeName	= $row['B_NAME'];
			$strUBNo		= $row['BI_UB_NO'];	
			
			## 게시판 정보
			$param				= "";
			$param['B_CODE']	= $strBCode;
			$param['UB_NO']		= $strUBNo;
			$aryBoardData		= $objBoardData->getBoardDataSelectEx("OP_SELECT", $param);
			$strTitle			= $aryBoardData['UB_TITLE'];	?>
		<tr>
			<td><?=$intListNum--?></td>
			<td><?=$strName?></td>
			<td class="alignLeft"><?=$strBCodeName?>(<?=$strBCode?>)</td>
			<td class="alignLeft"><a href="./?menuType=community&mode=dataView&b_code=<?=$strBCode?>&ub_no=<?=$strUBNo?>" target="_blank"><?=$strUBNo?>. <?=$strTitle?></a></td>
			<td><a href="javascript:goBoardIconDeleteActEvent('<?=$intNo?>')" class="btn_blue_sml" id="menu_auth_m" style="display:none"><strong>삭제</strong></a></td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>
</div>

<div class="paginate" style="padding:10px">  
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
</div>  