<?
	## STEP 1.
	## 설정
	$strDE_SELECT_NAME		= $_POST["de_select_name"]		? $_POST["de_select_name"]		: $_REQUEST["de_select_name"];
	$arySelectName			= explode(", ", $strDE_SELECT_NAME);
?>
	<div class="contentTop">
		<h2>회원 스마트쿼리</h2>
	</div>
	
	<div class="userDefineBtn">
		<a class="btn_blue_big" href="javascript:goDataEditSearchMoveEvent('')"><strong class="icoSearch">검색설정</strong></a>
		<div class="helpTxt">
			<ul>
				<li>- <strong>검색설정</strong> 버튼을 클릭하여 원하는 데이터의 조건을 만들어 주세요.</li>
				<li>- 검색설정 결과는 자주쓰는 버튼을 등록 가능합니다. 등록된 버튼을 클릭하여 추가조건을 대입하여 검새하세요. </li>
				<li>- 검색된 결과를 원하는 형태로 사용하실 수 있습니다.</li>
				<li>- 엑셀 다운로드, SMS로 전송, Email로 전송등 검색 결과 데이터를 활용하세요.</li>
			</ul>
		</div>
	</div>
	
	<a class="btn_big" href="javascript:goDataEditExcelMoveEvent()"><strong class="icoExcel">검색결과엑셀 저장</strong></a>
	<a class="btn_big" href="javascript:goDataEditSmsMoveEvent()"><strong class="icoSms">검샐결과SMS 발송하기</strong></a>
	<a class="btn_big" href="javascript:goDataEditEmailMoveEvent()"><strong class="icoEmail">검색결과 이메일 발송하기</strong></a>

	<div class="tableList">
		<table id="dataEditList">
			<tr>
				<?foreach($arySelectName as $key => $name):?>
				<th><?=$name?></th>
				<?endforeach;?>
			</tr>
				<?foreach($arySelectName as $key => $name):?>
				<td>데이타</td>
				<?endforeach;?>
			</tr>
		</table>
	</div>

	<input type="hidden" name="num" value="001"/>
