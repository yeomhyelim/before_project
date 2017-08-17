<?
	# 문자발송로그리스트
	# postSmsLogList.skin.php
?>

<input type="hidden" name="ps_no" id="ps_no" value="" />

<div id="contentArea">
<div class="contentTop">
	<h2>발신내역</h2>
	<div class="clr"></div>
</div>


<!-- ******** 컨텐츠 ********* -->
<div class="tableListWrap">
	<table class="tableList">
		<colgroup>
			<col style="width:50px;">
			<col />
			<col />
			<col />
			<col />
		</colgroup>
		<tr>
			<th>번호</th>
			<th>보낸사람이름</th>
			<th>보낸사람연락처</th>
			<th>받는사람이름</th>
			<th>받는사람연락처</th>
			<th>보낸시간</th>
			<th>결과</th>
		</tr>
		<? 
			while($row = mysql_fetch_array($postSmsLogResult)) : 

				if ($row['PL_SEND_RESULT'] == "1") $strSendResult = "성공";
				elseif ($row['PL_SEND_RESULT'] == "2") $strSendResult = "전송준비중";
				else $strSendResult = "실패";

		?>
		<tr>
			<td><?=$intListNum--?></td>
			<td><?=$row['PL_FROM_M_NAME']?></td>
			<td><?=$row['PL_FROM_M_HP']?></td>
			<td><?=$row['PL_TO_M_NAME']?></td>
			<td><?=$row['PL_TO_M_HP']?></td>
			<td><?=($row['PL_SEND_RESULT'] != "2") ? $row['PL_SEND_DATE']:"";?></td>
			<td><?=$strSendResult?></td>
		</tr>	
		<? endwhile; ?>
	</table>
</div>

<!-- 페이지 -->
<div class="paginate">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

<!-- 버튼 -->
<div class="buttonBoxWrap">
	<a class="btn_new_gray" href="javascript:postPaperListMoveClickEvent();"  ><strong class="ico_cancel">뒤로</strong></a>
	<a class="btn_new_blue" href="javascript:postSmsLogSendMoveClickEvent(<?=$intPS_NO?>);"  class="ico_sms"><strong>SMS보내기</strong></a>
</div>
<div class="tableForm mt20">
	<table>
		<tr>
			<th>엑셀양식 다운로드
			<td>
				<a href="javascript:goSmsExcelDown();" class="btn_big"><strong>엑셀양식 다운로드</strong></a>
			</td>
		</tr>
		<tr>
			<th> SMS 등록
			<td>
				<input type="file" name="excelFile"> <a href="javascript:postSmsListExcelUploadClickEvent(<?=$intPS_NO?>)" class="btn_big"><strong>등록하기</strong></a>
			</td>
		</tr>
		<tr>
			<th> 사용방법
			<td>
				1. SMS발송내역등 엑셀양식 파일을 다운 받습니다. <br>
				2. MS-Excel 프로그램을 이용하여 다운 받은 엑셀 파일을 실행합니다. <br>
				3. 양식에 맞게 데이터를 입력하고 저장합니다. <br>
				4. 저장된 데이터를 선택 후, 등록하기 버튼을 실행하여 SMS 발송내역을 대량등록 합니다.
				5. [SMS 보내기] 버튼을 이용하여 SMS를 전송합니다.(SMS는 [전송준비중]인 발송내역만 전송됩니다.]
			</td>
		</tr>
		<tr>
			<th> 꼭! 알아두기
			<td>
				1. 받는사람명과 받는사람핸드폰번호를 반드시 입력하셔야 합니다.<br>
				2. 엑셀 2번째줄부터 데이터를 입력하세요.(엑셀 1번째줄은 삭제하지마세요.)
			</td>
		</tr>
	</table>
</div>
<!-- ******** 컨텐츠 ********* -->