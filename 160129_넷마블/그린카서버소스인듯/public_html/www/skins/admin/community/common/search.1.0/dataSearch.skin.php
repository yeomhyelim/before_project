<?	
	## 2013.12.11 kim hee sung
	## 엑셀 다운로드 버튼은 상담관리(USER_REPORT) 에서만 보이도록 합니다.
	$isExcelDownloadBtn		= false;
	if($_REQUEST['b_code'] == "USER_REPORT"):
		$isExcelDownloadBtn	= true;
	endif;

	## 2014.05.19 kim hee sung
	## USER_REPORT 일때, 카테고리/결과상태 검색 
	if($_REQUEST['b_code'] == "USER_REPORT"):

		## 모듈 설정
		$boardCategory					= new BoardCategoryModule($db);

		## 기본 설정
		$resultUse			= true;
		$userfieldKind		= "select";
		$searchResultState = $_GET['searchResultState'];
		$searchCategoryState = $_GET['searchCategoryState'];

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

		## 처리결과 설정
		$strResultFieldLower			= "ad_temp1";
		$resultUse						= false;
		$userfieldUse					= $_REQUEST['BOARD_INFO']["bi_userfield_use"];
		$userfieldFieldUse				= $_REQUEST['BOARD_INFO']["bi_{$strResultFieldLower}_use"];
		$userfieldName					= $_REQUEST['BOARD_INFO']["bi_{$strResultFieldLower}_name"];
		$userfieldSort					= $_REQUEST['BOARD_INFO']["bi_{$strResultFieldLower}_sort"];
		$userfieldEssential				= $_REQUEST['BOARD_INFO']["bi_{$strResultFieldLower}_essential"];
		$userfieldKind					= $_REQUEST['BOARD_INFO']["bi_{$strResultFieldLower}_kind"];
		$userfieldKindData				= $_REQUEST['BOARD_INFO']["bi_{$strResultFieldLower}_kind_data"];
		$userfieldKindDefault			= $_REQUEST['BOARD_INFO']["bi_{$strResultFieldLower}_kind_default"];

		## 처리결과 설정 체크
		if($userfieldUse == "Y" && $userfieldFieldUse == "Y"):
			$resultUse					= true;
			$userfieldKindDataArray		= explode(";", $userfieldKindData);
		endif;
	endif;

?>
<div class="searchFormWrap">
	<select id="searchKey" style="width:133px">
		<option value="">전체</option>
		<option value="title"<?if($_REQUEST['searchKey']=="title"){echo " selected";}?>>제목</option>
		<option value="text"<?if($_REQUEST['searchKey']=="text"){echo " selected";}?>>내용</option>
		<option value="title_text"<?if($_REQUEST['searchKey']=="title_text"){echo " selected";}?>>제목+내용</option>
		<option value="name"<?if($_REQUEST['searchKey']=="name"){echo " selected";}?>>작성자</option>
		<option value="id"<?if($_REQUEST['searchKey']=="id"){echo " selected";}?>>아이디</option>
	</select>
	<input type="text" id="searchVal" value="<?=$strSearchKey?>" <?=$nBox?> data-enter-event="goSearch" style="width:485px;border:0px solid"/>
</div>
<?if($strSearchOut != "Y"):?>
<table border="0">
	<colgroup>
		<col style="width:70px;"/>
		<col />
	<colgroup/>
	<tr>
		<th>작성일</th>
		<td  colspan="3">
			<input type="text" id="searchRegStartDt" value="<?=$_REQUEST['searchRegStartDt']?>" data-simple-datepicker  style="width:80px"> -
			<input type="text" id="searchRegEndDt"   value="<?=$_REQUEST['searchRegEndDt']?>" data-simple-datepicker   style="width:80px">
			<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong>전체</strong></a>
		</td>
	</tr>
	<?if($resultUse && $userfieldKind=="select"):?>
	<tr>
		<th>카테고리</th>
		<td >
			<?if($aryCategoryList):?>
			<select id="searchCategoryState">
				<option value="">전체</option>
				<?foreach($aryCategoryList as $key => $data):?>
				<option value="<?=$key?>"<?if($searchCategoryState==$key){echo " selected";}?>><?=$data?></option>
				<?endforeach;?>
			</select>
			<?endif;?>
		</td>
		<th>결과상태</th>
		<td>
			<?if($userfieldKindDataArray):?>
			<select id="searchResultState">
				<option value="">전체</option>
				<?foreach($userfieldKindDataArray as $key => $data):?>
				<option value="<?=$data?>"<?if($searchResultState==$data){echo " selected";}?>><?=$data?></option>
				<?endforeach;?>
			</select>
			<?endif;?>
		</td>
	</tr>
	<?endif;?>
	<tr>
		<td colspan="4" style="text-align:center">
			<a class="btn_blue_big" href="javascript:goDataSearchListMoveEvent();" style="width:400px;text-align:center"><strong>검색</strong></a>
			<a class="btn_blue_big" href="javascript:goDataSearchResetListMoveEvent();"><strong>초기화</strong></a>
			<?if($isExcelDownloadBtn):?>
			<a class="btn_blue_big" href="javascript:goDataUserReportListExcelDownloadEvent();"><strong>엑셀 다운로드</strong></a>
			<?endif;?>
		</td>
	</tr>
</table>
<?endif;?>