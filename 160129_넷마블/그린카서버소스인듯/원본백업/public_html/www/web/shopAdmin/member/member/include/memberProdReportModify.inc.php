<?
	// 1:1 게시판 

	## 모듈 설정
	require_once MALL_HOME . "/module2/BoardData.module.php";
	$boardData						= new BoardDataModule($db);
	$boardCategory					= new BoardCategoryModule($db);

	## 기본 설정
	$bCode							= "USER_REPORT";
	$intReportNo					= $_GET['reportNo'];
//	$strResultField					= "AD_TEMP13"; // 2014.03.31 kim hee sung 잘못된듯...
	$strResultField					= "AD_TEMP1";
	$strResultFieldLower			= strtolower($strResultField);

	## 설정 파일 불러오기
	if($bCode && !$aryBoardInfo):
		include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.{$bCode}.info.php";
		$aryBoardInfo				= $BOARD_INFO[$bCode];
		if(!$aryBoardInfo):
			echo "설정 파일이 없습니다.";
			exit;
		endif;
	endif;

	## 처리결과 설정
	$resultUse						= false;
	$userfieldUse					= $aryBoardInfo["bi_userfield_use"];
	$userfieldFieldUse				= $aryBoardInfo["bi_{$strResultFieldLower}_use"];
	$userfieldName					= $aryBoardInfo["bi_{$strResultFieldLower}_name"];
	$userfieldSort					= $aryBoardInfo["bi_{$strResultFieldLower}_sort"];
	$userfieldEssential				= $aryBoardInfo["bi_{$strResultFieldLower}_essential"];
	$userfieldKind					= $aryBoardInfo["bi_{$strResultFieldLower}_kind"];
	$userfieldKindData				= $aryBoardInfo["bi_{$strResultFieldLower}_kind_data"];
	$userfieldKindDefault			= $aryBoardInfo["bi_{$strResultFieldLower}_kind_default"];

	## 처리결과 설정 체크
	if($userfieldUse == "Y" && $userfieldFieldUse == "Y"):
		$resultUse					= true;
		$userfieldKindDataArray		= explode(";", $userfieldKindData);
	endif;

	## null 값 포함하여 검색 여부 체크
	if($searchResultState && ($searchResultState == $userfieldKindDefault)):
		$searchResultStateNull = "Y";
	endif;

	## 데이터 불러오기
	$param							= "";
	$param['B_CODE']				= $bCode;
	$param['UB_NO']					= $intReportNo;
	$param['BOARD_AD_JOIN']			= "Y";
	$param['MEMBER_MGR_UB_REG_NO_JOIN'] = "Y";
	$param['BOARD_CATEGORY_JOIN']	= "Y";
	$param['ORDER_MGR_JOIN']		= "Y";
	$param['ORDER_BY']				= "UB.UB_ANS_NO DESC, UB.UB_ANS_STEP ASC";
	$row							= $boardData->getBoardDataSelectEx("OP_SELECT", $param);	

	## 기본 설정
	$no					= $row['UB_NO'];
	$name				= $row['UB_NAME'];
	$title				= $row['UB_TITLE'];
	$text				= $row['UB_TEXT'];
	$regDt				= $row['UB_REG_DT'];
	$read				= $row['UB_READ'];
	$step				= $row['UB_ANS_STEP'];
	$regFName			= $row['REG_M_F_NAME'];
	$refLName			= $row['REG_M_L_NAME'];
	$cateName			= $row['BC_NAME'];
	$strOrderKey		= $row['O_KEY'];
	$categoryState		= $row['UB_BC_NO'];
	$resultState		= $row[$strResultField];

	## 이름 정의
	$regName			= "";
	if($regFName):
		$regName		= $regFName; 
	endif;
	if($refLName):
		if($regName) { $regName = "{$regName} "; }
		$regName = "{$regName}{$refLName}"; 
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




//	## 게시판 설정 정보 불러오기
//	$boardInfo = SHOP_HOME . "/conf/community/board.{$bCode}.info.php";
//	require_once $boardInfo;	
//
//	## 전달 데이터 만들기
//	$_REQUEST['S_DOCUMENT_ROOT']			= $S_DOCUMENT_ROOT;
//	$_REQUEST['result']['DataMgr']			= $aryRow;
//	$_REQUEST['BOARD_INFO']					= $BOARD_INFO[$bCode]; 

?>

<div id="contentArea" style="margin:0 20px 0 10px;">
	<div id="contentWrap">
		<div class="tableForm">
			<table>
				<tr>
					<th>카테고리</th>
					<td>
						<?if($aryCategoryList):?>
						<select name="ub_bc_no">
							<option value="">전체</option>
							<?foreach($aryCategoryList as $key => $data):?>
							<option value="<?=$key?>"<?if($categoryState==$key){echo " selected";}?>><?=$data?></option>
							<?endforeach;?>
						</select>
						<?endif;?>
					</td>
				</tr>
				<tr>
					<th>결과상태</th>
					<td>
						<?if($userfieldKindDataArray):?>
						<select name="ad_temp1">
							<option value="">전체</option>
							<?foreach($userfieldKindDataArray as $key => $data):?>
							<option value="<?=$data?>"<?if($resultState==$data){echo " selected";}?>><?=$data?></option>
							<?endforeach;?>
						</select>
						<?endif;?>
					</td>
				</tr>
				<tr>
					<th>작성자</th>
					<td><?php echo $regName;?></td>
				</tr>
				<?php if($strOrderKey):?>
				<tr>
					<th>주문번호</th>
					<td><?php echo $strOrderKey;?></td>
				</tr>
				<?php endif;?>
				<tr>
					<th>작성일</th>
					<td><?php echo $regDt?></td>
				</tr>
				<tr>
					<th>내용</th>
					<td>
						<textarea name="ub_text" style="height:200px;width:100%"><?php echo $text;?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<div class="buttonWrap">
			<a class="btn_big" href="javascript:C_getAction('memberReportModify','');" id="menu_auth_m" style=""><strong>수정</strong></a>
			<a class="btn_big" href="javascript:C_getGoBack();"><strong>취소</strong></a>
		</div>
	</div>
</div>

<input type="hidden" name="ub_no"	 value="<?=$intReportNo?>">
<input type="hidden" name="b_code"	 value="<?=$bCode?>">
