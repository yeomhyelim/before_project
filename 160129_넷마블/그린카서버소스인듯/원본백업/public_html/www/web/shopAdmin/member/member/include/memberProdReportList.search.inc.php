<?php
	## 모듈 설정
	$boardCategory					= new BoardCategoryModule($db);


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
?>
<div class="searchFormWrap">
	<select id="searchField2" style="width:133px">
		<option value=""		<?if($strSearchField2 == "")			{echo " selected";}?>>전체</option>
		<option value="text"	<?if($strSearchField2 == "text")		{echo " selected";}?>>내용</option>
	</select>
	<input type="text" id="searchKey2" value="<?=$strSearchKey2?>" <?=$nBox?> data-enter-event="goSearch" style="width:485px;border:0px solid"/>
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
		<td >
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
			<a class="btn_blue_big" href="javascript:goMemberProdReportListSearch();" style="width:400px;text-align:center"><strong>검색</strong></a>
			<a class="btn_blue_big" href="./?menuType=member&mode=popMemberCrmView&tab=memberProdReportList&memberNo=<?=$intMemberNo?>"><strong>초기화</strong></a>
			<a class="btn_blue_big" href="javascript:goMemberProdReportListExcelDownloadEvent();"><strong>엑셀 다운로드</strong></a>
		</td>
	</tr>
</table>
<?endif;?>