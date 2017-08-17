<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["MM00029"]//포인트 엑셀(CSV)일괄지급?></h2>
	<div class="clr"></div>
</div>

<div class="tableForm mt20">
		<!-- ******** 컨텐츠 ********* -->
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MM00119"]//회원ID 타입?></th> 
					<td>
						<input type="radio" name="pt_member_op" value="id" checked><?=$LNG_TRANS_CHAR["OW00004"]//회원ID ?>
						<input type="radio" name="pt_member_op" value="mail"> <?=$LNG_TRANS_CHAR["OW00033"]//이메일?>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MM00120"]//포인트 옵션?></th> 
					<td>
						<input type="radio" name="pt_sum_op" value="+" checked><?=$LNG_TRANS_CHAR["MM00123"]//포인트 추가 ?>
						<input type="radio" name="pt_sum_op" value="-"><?=$LNG_TRANS_CHAR["MM00124"]//포인트 감소?>
					</td>
				<tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MM00121"]//포인트 금액?></th> 
					<td>
						<input type="radio" name="pt_point_op"  value="A" checked><?=$LNG_TRANS_CHAR["MM00125"]//엑셀내용에서 적용 ?>
						<input type="radio" name="pt_point_op" value="B"><?=$LNG_TRANS_CHAR["MM00126"]//직접입력?>
						<input type="text" name="pt_point"> <?=$LNG_TRANS_CHAR["CW00034"]//포인트 ?>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MM00122"]//사유?></th>
					<td>
						<input type="radio" name="pt_memo_op" value="A" checked><?=$LNG_TRANS_CHAR["MM00125"]//엑셀내용에서 적용 ?>
						<input type="radio" name="pt_memo_op" value="B"><?=$LNG_TRANS_CHAR["MM00126"]//직접입력?>
						<input type="text" name="pt_memo">
					</td>
				</tr>
				<tr>
					<th>Excel File</th>
					<td><input type="file" name="file1"/></td>
				</tr>
			</table>

			<div class="btnCenter">
				<a href="javascript:goMemberPointWritActClickEvent()" id="menu_auth_m" style="display:none" class="btn_Big_Blue _w200"><strong><?=$LNG_TRANS_CHAR["CW00051"]//적용?></strong></a>
			</div>
				
				
</div>

	<div class="noticeInfoWrap">
		<ul>
			<?=$LNG_TRANS_CHAR['MS00085']//이벤트 당첨 등 일괄 지급이 필요한 경우 사용됩니다.?>
		</ul>
	</div>
