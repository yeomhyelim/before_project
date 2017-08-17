<?
	## 설정
	$strSEND_NAME		= $S_SITE_NM;
	$strSEND_EMAIL		= $S_SITE_MAIL;
?>

<?include "./include/header.inc.php"?>
<?include "script.inc.php"; ?>
	<div class="layerPopWrap">
		<div class="popTop">
			<h2>Email 발송</h2>					
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

				<div class="tableForm">
					<div class="titInfoTxt" style="padding-left:0;">
						<ul>
							<li>* 총 <strong>0,000명</strong>의 대상 회원이 있습니다.</li>
							<li>* 발송할 문구를 작성하신 후 전송버튼을 클릭 해 주세요. </li>
						</ul>
					</div>
					<table>
						<tr>
							<th>보내는 사람 이름</th>
							<td><input type="text" name="send_name" style="width:100%" value="<?=$strSEND_NAME?>"/></td>
						</tr>
						<tr>
							<th>보내는 사람 메일</th>
							<td><input type="text" name="send_email" style="width:100%" value="<?=$strSEND_EMAIL?>"/></td>
						</tr>
						<tr>
							<th>제목</th>
							<td><input type="text" name="pm_title" id="pm_title" style="width:100%" value="<?=$postMailRow['PM_TITLE']?>" /></td>
						</tr>
						<tr>
							<th>내용</th>
							<td><textarea name="pm_text" id="pm_text" title=""  style="width:100%;height:300px" ><?=$postMailRow['PM_TEXT']?></textarea><br></td>
						</tr>
						<tr>
							<th  style="width:100px;" rowspan="2">대상회원</th>
							<td>
								<ul>
									<li><input type="radio" name="member_type" value="all" alt="모든회원"> 검색된 모든회원</li>
									<li><input type="radio" name="member_type" value="mail_y" alt="메일 수신 동의한 회원" checked> Email 수신 동의한 회원</li>
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
							<th style="width:100px;">대상메일</th>
							<td>
								<input type="radio" name="send_type" value="order" alt="주문자메일" checked> 회원메일
								<input type="radio" name="send_type" value="delivery" alt="배송지메일"> 배송지메일
							</td>
						</tr>
						<tr>
							<th>전송자</th>
							<td>master (2013.05.10 11:30:00)</td>
						</tr>
					</table>

					<div class="btnCenter" id="btnArea">
						<a class="btn_blue_big _w400" href="javascript:goDataEditEmailSendEvent()"><strong>Email 발송</strong></a>
						<a class="btn_big" href="javascript:goDataEditEmailCloseEvent()"><strong>닫기</strong></a>
					</div>
				</div>
			</form>

		</div>
	</body>
</html>