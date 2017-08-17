<?
	// 커뮤니티 데이터 보기

	## 모듈 설정
	require_once MALL_HOME . "/module2/BoardData.module.php";
	$boardData						= new BoardDataModule($db);

	## 기본 설정
	$bCode							= $_GET['b_code'];
	$ubNo							= $_GET['ubNo'];

	## 데이터 불러오기
	$param							= "";
	$param['B_CODE']				= $bCode;
	$param['UB_NO']					= $ubNo;
	$param['BOARD_CATEGORY_JOIN']	= "Y";
	$boardDataRow					= $boardData->getBoardDataSelectEx("OP_SELECT", $param);	
	
	## 정의
	$date							= $boardDataRow['UB_REG_DT'];
	$name							= $boardDataRow['UB_NAME'];	
	$id								= $boardDataRow['UB_M_ID'];
	$email							= $boardDataRow['UB_MAIL'];
	$title							= $boardDataRow['UB_TITLE'];
	$text							= $boardDataRow['UB_TEXT'];
	$grade							= $boardDataRow['UB_P_GRADE'];
	$ip								= $boardDataRow['UB_IP'];
	$cateName						= $boardDataRow['BC_NAME'];

	## 작성자(아이디) 설정
	$writer							= "";
	if($name)	{ $writer			= $name;				}
	if($id)		{ $writer			= "{$writer}({$id})";	}

	## b_code 별 tab 정의
	$aryTab['MY_QNA']				= "memberQnaList";
	$aryTab['PROD_QNA']				= "memberProdQnaList";
	$aryTab['USER_REPORT']			= "memberProdReportList";

	## tab 정의
	$strTab							= $aryTab[$bCode];

?>
<div id="contentArea" style="margin:0 10px">
	<div class="tableForm">
		<table>
			<caption></caption>
			<thead></thead>
			<tbody>
				<?if($date):?>
				<tr>
					<th>작성일</th>
					<td><?=$date?></td>
				</tr>
				<?endif;?>
				<?if($cateName):?>
				<tr>
					<th>카테고리</th>
					<td><?=$cateName?></td>
				</tr>
				<?endif;?>
				<?if($writer):?>
				<tr>
					<th>작성자(아이디)</th>
					<td><?=$writer?></td>
				</tr>
				<?endif;?>
				<?if($email):?>
				<tr>
					<th>이메일</th>
					<td><?=$email?></td>
				</tr>
				<?endif;?>
				<?if($title):?>
				<tr>
					<th>제목</th>
					<td><?=$title?></td>
				</tr>
				<?endif;?>
				<?if($grade):?>
				<tr>
					<th>평점</th>
					<td><?=$grade?></td>
				</tr>
				<?endif;?>
				<?if($text):?>
				<tr>
					<th>내용</th>
					<td><?=$text?></td>
				</tr>
				<?endif;?>
				<?if($ip):?>
				<tr>
					<th>아이피</th>
					<td><?=$ip?></td>
				</tr>
				<?endif;?>
			</tbody>
		</table>
	</div>
	<br>
	<div class="tableForm" id="answerMode" style="display:none">
		<h2>답변하기</h2>
		<table>
			<caption></caption>
			<thead></thead>
			<tbody>
				<tr>
					<th>제목</th>
					<td><input type="text" name="ub_title" value="Re : <?=$title?>" style="width:100%"></td>
				</tr>
				<tr>
					<th>내용</th>
					<td><textarea id="ub_text" name="ub_text" title="higheditor_full" style="width:100%;height:250px"></textarea></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<br>

<div class="button" id="viewBtnMode">
	<a href="javascript:goDataModifyMoveEvent(<?=$ubNo?>);" class="btn_big" id="menu_auth_m" style=""><strong>수정</strong></a>
	<a href="javascript:goDataDeleteActEvent(<?=$ubNo?>, '<?=$bCode?>', '<?=$strTab?>');" class="btn_big" id="menu_auth_m" style=""><strong>삭제</strong></a>
	<a href="javascript:goDataAnswerWriteShowEvent();" class="btn_big" id="menu_auth_m" style=""><strong>답변</strong></a>
	<a href="javascript:goDataListMoveEvent('<?=$strTab?>');" class="btn_big" id="menu_auth_m" style=""><strong>목록</strong></a>
</div>

<div class="button" id="answerBtnMode" style="display:none">
	<a href="javascript:goDataAnswerWriteActEvent('<?=$strTab?>');" class="btn_big" id="menu_auth_m" style=""><strong>답변</strong></a>
	<a href="javascript:goDataAnswerCancelShowEvent();" class="btn_big" id="menu_auth_m" style=""><strong>취소</strong></a>
</div>

<input type="hidden" name="b_code"	 value="<?=$bCode?>">
<input type="hidden" name="no"		 value="<?=$ubNo?>">
<input type="hidden" name="ub_mode"	 value="">
