<?
	## 모듈 설정
	require_once MALL_HOME . "/module2/BoardData.module.php";
	require_once MALL_HOME . "/module2/BoardCategory.module.php";
	$boardData						= new BoardDataModule($db);
	$boardCategory					= new BoardCategoryModule($db);

	## 기본설정
	$bCode							= "USER_REPORT";
	$intMemberNo							= $_GET['memberNo'];

	## 기본설정 체크
	if(!$intMemberNo):
		echo "회원 번호가 없으면 페이지를 출력할 수 없습니다.";
		exit;
	endif;

	## 카테고리 리스트
	$param							= "";
	$param['BC_B_CODE']				= $bCode;
	$param['ORDER_BY']				= "BC.BC_SORT ASC";
	$boardCategoryArray				= $boardCategory->getBoardCategorySelectEx("OP_ARYTOTAL", $param);

	## 카테고리 정의
	$aryCategoryList				= "";
	if($boardCategoryArray):
		foreach($boardCategoryArray as $key => $data):
			$bcNo					= $data['BC_NO'];
			$bcName					= $data['BC_NAME'];
			$aryCategoryList[$bcNo]	= $bcName;
		endforeach;
	endif;

	## 데이터 불러오기(최근상담내역)
	$param							= "";
	$param['B_CODE']				= $bCode;
	$param['UB_M_NO']				= $intMemberNo;
	$param['ORDER_BY']				= "UB.UB_NO DESC";
	$intTotal						= $boardData->getBoardDataSelectEx("OP_COUNT", $param);						// 데이터 전체 개수 
	$intPageLine					= 5;																		// 리스트 개수 
	$intPage						= ( $intPage )				? $intPage		: 1;
	$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$param['LIMIT']							= "{$intFirst},{$intPageLine}";
	$param['MEMBER_MGR_UB_REG_NO_JOIN']		= "Y";
	$boardDataResult						= $boardData->getBoardDataSelectEx("OP_LIST", $param);

	$intPageBlock					= 10;																		// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );

?>

<div class="callForm">
	<h3><?=$LNG_TRANS_CHAR["MW00192"]  //상담관리?></h3>
	<table>
		<?if($boardCategoryArray):?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00193"] //상담분류?></th>
			<td>
				<select name="category">
					<?foreach($boardCategoryArray as $key => $data):
						$bcNo		= $data['BC_NO'];
						$bcName		= $data['BC_NAME'];		?>
					<option value="<?=$bcNo?>"><?=$bcName?></option>
					<?endforeach;?>
				</select>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00194"] //상담사?></th>
			<td><?=$a_admin_name?>(<?=$a_admin_id?>)</td>
		</tr>							
		<tr>
			<td colspan="4">
				<textarea name="text" maxlength="300"></textarea>
				<div class="helpTxt">
					<ul>
						<li>* <?=$LNG_TRANS_CHAR["MS00053"] //관리자 전용 고객상담 관리 입니다.?> </li>
						<li>* <?=$LNG_TRANS_CHAR["MS00054"] //상담내역을 등록해 주세요.?></li>
					</ul>
				</div>
			</td>
		</tr>
	</table>
	<div class="btnCenter">
		<a href="javascript:goMemberReportWriteActEvent()" class="btn_big" style="width:100%;"><strong><?=$LNG_TRANS_CHAR["MW00195"] //상담등록?></strong></a>
	</div>
</div>

<div class="callList">
	<h3><?=$LNG_TRANS_CHAR["MW00196"] //최근상담내역?></h3>
	<ul>
		<?while($row = mysql_fetch_array($boardDataResult)):
		    $ubBcNo		= $row['UB_BC_NO'];
			$ubName		= $row['REG_M_L_NAME'];	
			$ubText		= $row['UB_TEXT'];
			$ubId		= $row['REG_M_ID'];
			$bcName		= $aryCategoryList[$ubBcNo];				?>
		<li>
			<strong class="callCate">[<?=$bcName?>]</strong>
			<?=$ubText?>
			<span><strong><?=$ubName?>/<?=$ubId?></strong> <?=$row['UB_REG_DT']?></span>
		</li>
		<?endwhile;?>
	</ul>
</div>