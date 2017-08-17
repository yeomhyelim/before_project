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
	$url							= $boardDataRow['UB_URL'];
	$title							= $boardDataRow['UB_TITLE'];
	$text							= $boardDataRow['UB_TEXT'];
	$grade							= $boardDataRow['UB_P_GRADE'];
	$ip								= $boardDataRow['UB_IP'];
	$cateName						= $boardDataRow['BC_NAME'];

	## 이메일 설정
	$email1							= "";
	$email2							= "";
	if($email):
		list($email1, $email2) = explode("@", $email);
	endif;

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
			<input type="hidden" name="b_code"	 value="<?=$bCode?>">
			<input type="hidden" name="no"		 value="<?=$ubNo?>">
			<input type="hidden" name="ub_mode"	 value="">
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
					<tr>
						<th>이메일</th>
						<td><input type="text" name="ub_mail1" value="<?=$email1?>"> @ 
							<input type="text" name="ub_mail2" value="<?=$email2?>"></td>
					</tr>
					<tr>
						<th>링크</th>
						<td><input type="text" name="ub_url" value="<?=$url?>" style="width:100%"></td>
					</tr>
					<?if($title):?>
					<tr>
						<th>제목</th>
						<td><input type="text" name="ub_title" value="<?=$title?>" style="width:100%"></td>
					</tr>
					<?endif;?>
					<?if($grade):?>
					<tr>
						<th>평점</th>
						<td>
							<?for($i=1;$i<=5;$i++):?>
							<input type="radio" name="ub_p_grade" value="<?=$i?>"<?if($grade == $i){ echo " checked";}?>/> <img src="/himg/board/icon/icon_star_<?=$i?>.png"/>
							<?endfor;?>
						</td>
					</tr>
					<?endif;?>
					<?if($text):?>
					<tr>
						<th>내용</th>
						<td><textarea id="ub_text" name="ub_text" title="higheditor_full" style="width:100%;height:250px"><?=$text?></textarea></td>
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
</div>

<br>

<div class="button">
	<a href="javascript:goDataModifyActEvent();" class="btn_big" id="menu_auth_m" style=""><strong>수정</strong></a>
	<a href="javascript:goDataListMoveEvent('<?=$strTab?>');" class="btn_big" id="menu_auth_m" style=""><strong>목록</strong></a>
</div>