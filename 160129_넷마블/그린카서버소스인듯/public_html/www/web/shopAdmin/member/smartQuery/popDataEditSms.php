<?
	## 설정
	$send_hp = ($_REQUEST['send_hp']) ? $_REQUEST['send_hp'] : $S_COM_PHONE;
?>

<?include "./include/header.inc.php"?>
<?include "script.inc.php"; ?>
	<div class="layerPopWrap">
		<div class="popTop">
			<h2>SMS전송</h2>					
			<a href="javascript:self.close();"><img src="/shopAdmin/himg/common/btn_pop_close_white.png" class="closeBtn"/></a>
			<div class="clear"></div>
		</div>
	</div>
		<div id="contentArea" style="padding:10px;">
				<form name="form" name="form" id="form">
				<input type="hidden" name="menuType" value="<?=$strMenuType?>">
				<input type="hidden" name="mode" value="<?=$strMode?>">
				<input type="hidden" name="act" value="">

				<input type="hidden" name="de_select" alt="컬럼명" value=""/> 
				<input type="hidden" name="de_select_name" alt="컬럼명(한글)" value=""/> 
				<input type="hidden" name="de_where" alt="조건" value=""/> 
				<input type="hidden" name="de_order" alt="정렬" value=""/> 
				<input type="hidden" name="de_where_join" alt="연결" value=""/> 
				<input type="hidden" name="num" alt="번호" value=""/> 

					<div class="autoSmsWrap left">
						<div class='sendSmsWrap'>
							<div class='smsFormWrap'>
								<textarea name='ps_text' id='ps_text' maxlen="80"></textarea>
								<p><strong id="textByte">0/80</strong> Byte</p>
							</div>
						</div>
					</div>

					<div class="tableForm right">
						<div class="titInfoTxt" style="padding-left:0;">
							<ul>
								<li>* 총 <strong id="total">0,000명</strong>의 대상 회원이 있습니다.</li>
								<li>* 전송할 문구를 작성하신 후 전송버튼을 클릭 해 주세요. </li>
							</ul>
						</div>
						<table>
							<tr>
								<th  style="width:100px;" rowspan="2">대상회원</th>
								<td>
									<ul>
										<li><input type="radio" name="member_type" value="all" alt="모든회원"> 검색된 모든회원</li>
										<li><input type="radio" name="member_type" value="sms_y" alt="SMS 수신 동의한 회원" checked> SMS 수신 동의한 회원</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" name="non_member" value="Y" alt="비회원"> 비회원
									<div class="helpTxt">* 검색결과에 비회원이 있는경우 사용합니다.</div>
								</td>
							</tr>
							<tr>
								<th style="width:100px;">대상핸드폰</th>
								<td>
									<input type="radio" name="send_type" value="order" alt="주문자핸드폰" checked> 회원핸드폰
									<input type="radio" name="send_type" value="delivery" alt="배송지핸드폰"> 배송지핸드폰
								</td>
							</tr>
							<tr>
								<th style="width:100px;">전송번호</th>
								<td><input type="text" name="send_hp" value="<?=$send_hp?>"></td>
							</tr>
							<tr>
								<th style="width:100px;">전송자</th>
								<td><?=$_SESSION['ADMIN_NAME']?> (2013.05.10 11:30:00)</td>
							</tr>
						</table>
						<div class="btnCenter" id="btnArea">
							<a class="btn_blue_big _w250" href="javascript:goDataEditSmsSendEvent()"><strong>SMS 전송</strong></a>
							<a class="btn_big" href="javascript:goDataEditSmsCloseEvent()"><strong>닫기</strong></a>
						</div>
					</div>
					<div class="clr"></div>
					
					
					
					
					
					
				</form>
		</div>
	</body>
</html>