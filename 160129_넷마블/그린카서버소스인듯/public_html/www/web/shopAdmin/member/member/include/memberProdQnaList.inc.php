<?
	// 1:1 게시판

	## 모듈 설정
	require_once MALL_HOME . "/module2/BoardData.module.php";
	$boardData						= new BoardDataModule($db);

	## 기본 설정
	$bCode							= "PROD_QNA";
	$intPage						= $_GET['page'];
	$intMemberNo					= $_GET['memberNo'];
	$lngLower						= strtolower($_SESSION['ADMIN_LNG']);




	## 데이터 불러오기
	$param							= array();
	$param['B_CODE']				= $bCode;
	$param['UB_ANS_M_NO']			= $intMemberNo;
	$param['ORDER_BY']				= "UB.UB_ANS_NO DESC, UB.UB_ANS_STEP ASC";
	//샵번호 추가(상품QnA) 남덕희
	$param['UB_SHOP_NO']			= $a_admin_shop_no;

	$intTotal						= $boardData->getBoardDataSelectEx("OP_COUNT", $param);						// 데이터 전체 개수
	$intPageLine					= 10;																		// 리스트 개수
	$intPage						= ( $intPage )				? $intPage		: 1;
	$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$param['PRODUCT_IMG_JOIN']		= "Y";
	$param['BOARD_CATEGORY_JOIN']	= "Y";
	$param['LIMIT']					= "{$intFirst},{$intPageLine}";
	$boardDataResult				= $boardData->getBoardDataSelectEx("OP_LIST", $param);

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
?>


<div id="contentArea">
	<div class="tableList" style="margin:0 10px 0 10px">
		<table>
			<caption></caption>
			<colgroup>
				<col class="no"/>
				<!--<col class="category"/>-->
				<col class="prodImg"/>
				<col class="title"/>
				<col class="writer"/>
				<col class="date"/>
<!--				<col class="read"/>-->
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
					<!--<th>카테고리</th>-->
					<th>상품</th>
					<th>제목</th>
					<th>작성자</th>
					<th>작성일</th>
<!--					<th>조회수</th>-->
				</tr>
			</thead>
			<tbody>
				<?while($row = mysql_fetch_array($boardDataResult)):

					## 기본 설정
					$no			= $row['UB_NO'];
					$name		= $row['UB_NAME'];
					$title		= $row['UB_TITLE'];
					$regDt		= $row['UB_REG_DT'];
					$read		= $row['UB_READ'];
					$step		= $row['UB_ANS_STEP'];
					$pCode		= $row['P_CODE'];
					$prodImg	= $row['PM_REAL_NAME'];
					$cateName	= $row['BC_NAME'];

					## 답변 정의
					if($step):
						$step			= explode(",", $step);
						$step			= sizeof($step);
						$step			= str_pad("", $step, " ", STR_PAD_LEFT);
						$step			= str_replace(" ", "&nbsp;", $step);
						$title			= "{$step}<img src='/himg/board/A0001/icon_bbs_reply.png'>{$title}";
					endif;

					##작성일 설정
					$regDt		= date("Y.m.d", strtotime($regDt));		?>
				<tr>
					<td class="no"><?=$intListNum--?></td>
					<!-- <td class="category"><?=$cateName?></td> -->
					<td class="prodImg"><a href="/<?=$lngLower?>/?menuType=product&mode=view&prodCode=<?=$pCode?>" target="_blank"><img src="<?=$prodImg?>" style="width:50px;height:50px"></a></td>
					<td class="" style="text-align:left"><a href="javascript:goDataViewMoveEvent('<?=$no?>','<?=$bCode?>')"><?=$title?></a></td>
					<td class="writer"><?=$name?></td>
					<td class="date"><?=$regDt?></td>
<!--					<td class="read">--><?//=$read?><!--</td>-->
				</tr>
				<?endwhile;?>
			</tbody>
		</table>
	</div>
</div>

<div class="paginate mt20">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>