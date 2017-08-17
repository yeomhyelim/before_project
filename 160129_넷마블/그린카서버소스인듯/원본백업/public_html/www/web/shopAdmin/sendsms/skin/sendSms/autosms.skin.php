<?php

	## 정리
	$arySmsGroupList = '';
	$arySmsDataList = '';
	while($smsRow = mysql_fetch_array($smsListRow)):
	
		## 기본설정
		$strSM_GRP_CODE = $smsRow['SM_GRP_CODE'];

		## 설정
		$arySmsGroupList[$strSM_GRP_CODE] = $smsRow;
		$arySmsDataList[$strSM_GRP_CODE][] = $smsRow;

	endwhile;
?>
<script>
	function goTextMaxLengthCut(myThis, max) {
		var text = $(myThis).val();
		var leng = C_getByteLength(text);

		if(leng > max) {
			alert("80자를 초과하였습니다!");
			$(myThis).val(C_getByteCut(text, max));
			leng = max;
		}
		$(myThis).parent().parent().find('.textLen').html(leng);
	}
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2>기본정보</h2>
		<div class="clr"></div>
	</div>
	<!-- 
	<div class="smsPointInfoWrap mt30">
		<div class="pointPriceInfo"><h3>자동 SMS전송  <span>(현재 전송 가능한 문자 메시지는 <strong><?php echo$siteInfoRow['S_SMS_MONEY']?></strong> 건 입니다.)</span></h3></div>
		<a class="btn_blue_big" href="#"><strong>SMS 포인트 충전하기</strong></a>
		<div class="clear"></div>
	</div>
	 -->
	<div class="tableForm">
		<table>
			<tr>
				<th>자동 SMS전송 사용 유무</th>
				<td>
					<input type="radio" name="s_smsUse" id="s_smsUse" value="Y"<?php if($siteInfoRow['S_SMS_USE'] == "Y") { echo " checked";}?>/> 자동 SMS전송 사용함 &nbsp;
					<input type="radio" name="s_smsUse" id="s_smsUse" value="N"<?php if($siteInfoRow['S_SMS_USE'] != "Y") { echo " checked";}?>/> 자동 SMS전송 사용안함 &nbsp;
					<a class="btn_blue_big" href="javascript:void(0);" onclick="goMoveUrl('smsUseType','');" id="menu_auth_m" style="display:none"><strong>설정 변경</strong></a>
				</td>
			</tr>
		</table>
	</div>
	<div class="autoSmsWrap mt30">
		<table>
			<?php foreach($arySmsGroupList as $groupKey => $groupRow):?>
			<tr>
				<th><?php echo $groupRow['SM_GRP_NAME'];?></th>
			</tr>
			<tr>
				<td>
				<?php foreach($arySmsDataList[$groupKey] as $dataKey => $dataRow):
						
						## 문자열 길이 설정
						$intNum = strlen( iconv("utf-8", "euc-kr", $dataRow['SM_TEXT']) ); 
				?>
					<div class='sendSmsWrap'>
						<h4><?php echo $dataRow['SM_SEND_NAME'];?></h4>
						<input type="hidden" name="sm_no[]" id="sm_no[]" value="<?php echo $dataRow['SM_NO'];?>"/>
						<input type="hidden" name="sm_send_code[]" id="sm_send_code[]" value="<?php echo $dataRow['SM_SEND_CODE'];?>"/>
						<div class="smsFormWrap">
							<textarea name="sm_text[]" id="sm_text[]" onkeyup="goTextMaxLengthCut(this, 80)"><?php echo $dataRow['SM_TEXT'];?></textarea>
							<p><strong><span class="textLen"><?php echo $intNum;?></span>/80</strong> Byte</p>
						</div>
						<div><input type="checkbox" name="sm_auto[]" id="sm_auto[]" value="<?php echo $dataRow['SM_NO'];?>"<?php if($dataRow['SM_AUTO'] == "Y"){echo " checked";}?>/> 자동발송 사용</div>
					</div>
				<?php endforeach;?>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>
<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:goMoveUrl('smsModify','');" id="menu_auth_m" style="display:none"><strong  class="ico_write">설정 저장</strong></a>
</div>