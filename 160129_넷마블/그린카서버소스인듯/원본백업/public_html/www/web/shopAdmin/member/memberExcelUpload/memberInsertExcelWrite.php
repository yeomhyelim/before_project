<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MW00219"]  //회원대량등록?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap mt20">
		<div class="titInfoTxt">
			<ul>
				<li>* <?=$LNG_TRANS_CHAR["MS00060"] //엑셀이나 기타 OFF라인에서 확보된 회원의 정보를 업로드 합니다.?></li>
			</ul>
		</div>

		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00220"] //엑셀양식 다운로드?></th>
				<td>
					<a href="javascript:goMemberInsertExcelDown('kor');" class="btn_big"><strong class="icoExcel"><?=$LNG_TRANS_CHAR["MW00221"] //회원등록 엑셀양식 다운로드?></strong></a>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["MS00061"] //샘플 양식을 다운로드 하셔서 업로드하고자 하는 데이터를 맞춰 주세요.?>
					</div>
				</td>
			</tr>
			<tr>
				<th> <?=$LNG_TRANS_CHAR["MW00219"]  //회원대량등록?></th>
				<td>
					<input type="file" name="excelFile"> 
				</td>
			</tr>
		</table>
	</div>
	
	<div class="buttonBoxWrap">
		<a href="javascript:goMemberInsertWrite()" class="btn_new_blue"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록하기?></strong></a>
	</div>
	<?
		$strErrMsg	= $_POST["errMsg"];
		if ($strErrMsg){
	?>
	<div class="tableFormWrap mt20">
		<table class="tableForm">
			<tr>
				<td><?=$strErrMsg?></td>
			</tr>
		</table>
	</div>
	<?}?>

	<div class="noticeInfoWrap">
		<ul>
			<li><strong><?=$LNG_TRANS_CHAR["CW00076"] //사용방법?></strong> </li>
			<li>① <?=$LNG_TRANS_CHAR["MS00062"] //회원등록 엑셀양식 파일을 다운 받습니다 ?></li>
			<li>② <?=$LNG_TRANS_CHAR["MS00063"] //MS-Excel 프로그램을 이용하여 다운 받은 엑셀 파일을 실행합니다. ?></li>
			<li>③ <?=$LNG_TRANS_CHAR["MS00064"] //양식에 맞게 데이터를 입력하고 저장합니다. ?></li>
			<li>④ <?=$LNG_TRANS_CHAR["MS00065"] //저장된 데이터를 선택 후, 등록하기 버튼을 실행하여 회원을 대량등록 합니다. ?></li>
		</ul>
		<ul class="mt10">
			<li><strong><?=$LNG_TRANS_CHAR["CW00077"] //꼭! 알아두기?></strong> </li>
			<li>① <?=$LNG_TRANS_CHAR["MS00066"] //회원그룹이 없는 경우, 신규 데이터로 등록되지 않습니다.?></li>
			<li>② <?=$LNG_TRANS_CHAR["MS00067"] //엑셀 3번째줄부터 데이터를 입력하세요.(엑셀 1/2번째줄은 삭제하지마세요.)?></li>
		</ul>
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->



