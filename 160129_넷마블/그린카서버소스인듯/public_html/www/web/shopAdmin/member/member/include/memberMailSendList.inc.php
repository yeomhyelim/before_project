<?
	// SMS 리스트

	## 모듈 설정
	require_once MALL_HOME . "/module2/PostEmailLog.module.php";
	$postEmailLog					= new PostEmailLogModule($db);

	## 기본 설정
	$intPage						= $_GET['page'];
	$intMemberNo					= $_GET['memberNo'];

	if($intMemberNo):
		## 데이터 불러오기
		$param							= "";
		$param['PL_TO_M_NO']			= $intMemberNo;
		$intTotal						= $postEmailLog->getPostEmailLogSelectEx("OP_COUNT", $param);					// 데이터 전체 개수 
		$intPageLine					= 10;																			// 리스트 개수 
		$intPage						= ( $intPage )				? $intPage		: 1;
		$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

		$param['LIMIT']					= "{$intFirst},{$intPageLine}";
		$postEmailLogResult				= $postEmailLog->getPostEmailLogSelectEx("OP_LIST", $param);

		$intPageBlock					= 10;																		// 블럭 개수 
		$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
		$intTotPage						= ceil( $intTotal / $intPageLine );
	endif;

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
?>
<div id="contentArea">
	<div class="tableList" style="margin:0 10px 0 10px">
		<table>
			<caption></caption>
			<colgroup>
				<col class="no" style="width:50px"/>
				<col class="writer" style="width:80px"/>
				<col class="title""/>
				<col class="date" style="width:80px"/>
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
					<th>보낸사람 이름</th>
					<th>제목</th>
					<th>작성일</th>
				</tr>
			</thead>
			<tbody>
				<?while($row = mysql_fetch_array($postEmailLogResult)):
					
					## 기본 설정
					$no			= $row['PL_NO'];
					$fromName	= $row['PL_FROM_M_NAME'];
					$text		= $row['PL_TITLE'];
					$regDt		= $row['PL_REG_DT'];
					
				
					##작성일 설정
					$regDt		= date("Y.m.d", strtotime($regDt));		?>
				<tr>
					<td class="no"><?=$intListNum--?></td>
					<td class="writer"><?=$fromName?></td>
					<td class="" style="text-align:left"><a href="javascript:goMemberMailSendViewMoveEvent('<?=$no?>')"><?=$text?></a></td>
					<td class="date"><?=$regDt?></td>
				</tr>
				<?endwhile;?>
			</tbody>
		</table>
	</div>
</div>

<div class="paginate mt20">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

<div class="buttonWrap right">
	<a class="btn_blue_big" href="javascript:goMemberMailSendMoveEvent()" id="menu_auth_m" style=""><strong>이메일 전송</strong></a>
</div>