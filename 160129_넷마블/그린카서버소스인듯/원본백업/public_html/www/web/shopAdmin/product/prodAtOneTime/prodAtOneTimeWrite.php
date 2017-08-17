<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00057"] //상품대량등록/수정?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00220"]//엑셀양식 다운로드?></th>
				<td>
					<a href="javascript:goAtOneTimeSampleDowndown()" class="btn_big"><strong><?=$LNG_TRANS_CHAR["PW00180"]//상품등록 엑셀양식 다운로드?></strong></a>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00181"]//상품대량 등록?></th>
				<td>
					<input type="file" name="excelFile"> <a href="javascript:goAtOneTimeWrite()" class="btn_big" ><strong><?=$LNG_TRANS_CHAR["PW00182"]//등록하기?></strong></a>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00076"]//사용방법?></th>
				<td>
					<?=$LNG_TRANS_CHAR["PS00040"]//1. 상품등록 엑셀양식 파일을 다운 받습니다.?> <br>
					<?=$LNG_TRANS_CHAR["PS00041"]//2. MS-Excel 프로그램을 이용하여 다운 받은 엑셀 파일을 실행합니다.?> <br>
					<?=$LNG_TRANS_CHAR["PS00042"]//3. 양식에 맞게 데이터를 입력하고 저장합니다.?> <br>
					<?=$LNG_TRANS_CHAR["PS00043"]//4. 저장된 데이터를 선택 후, 등록하기 버튼을 실행하여 상품대량등록 합니다.?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00077"]//꼭! 알아두기?></th>
				<td>
					<?=$LNG_TRANS_CHAR["PS00044"]//1. 상품코드가 없는 경우, 신규 데이터로 등록됩니다.?> <br>
					<?=$LNG_TRANS_CHAR["PS00045"]//2. 상품명이 없는 경우, 등록 할 수 없습니다. ?><br>
					<?=$LNG_TRANS_CHAR["PS00046"]//3. 한글로 명시된 명은 수정 가능하며, 영문으로 된 코드는 변경할 수 없습니다.(변경시 잘못된 데이터가 등록될 수 있습니다.)?>
				</td>
			</tr>
		</table>
	</div>


</div>
<!-- ******** 컨텐츠 ********* -->



