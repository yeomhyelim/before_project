<?
	## 모듈 설정
	require_once MALL_HOME . "/module2/CommGrp.module.php";
	require_once MALL_HOME . "/module2/CommCode.module.php";
	require_once MALL_HOME . "/module2/EmailMgr.module.php";

	$objCommGrpModule		= new CommGrpModule($db);
	$objCommCodeModule		= new CommCodeModule($db);
	$objEmailMgrModule		= new EmailMgrModule($db);

	## 기본 설정

	## 공통코드그룹 정보 가져오기
	$param					= "";
	$param['CG_CODE']		= "EMAIL";
	$aryCommGrpRow1			= $objCommGrpModule->getCommGrpSelectEx("OP_SELECT", $param);
	$intCG_NO1				= $aryCommGrpRow1['CG_NO'];

	## 공통코드그룹 정보 가져오기
	$param					= "";
	$param['CG_CODE']		= "EMAIL_SEND";
	$aryCommGrpRow2			= $objCommGrpModule->getCommGrpSelectEx("OP_SELECT", $param);
	$intCG_NO2				= $aryCommGrpRow2['CG_NO'];

	## 공통코드 리스트 가져오기
	$param					= "";
	$param['CG_NO']			= $intCG_NO1;
	$param['CC_USE']		= "Y";
	$aryCommCodeRow			= $objCommCodeModule->getCommCodeSelectEx("OP_ARYTOTAL", $param);

	## 스크립트 설정
	$aryScriptEx[] = "./common/js/sendmail/sendmail.js";
	
?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00043"] //자동메일 설정?></h2>
		<div class="clr"></div>
	</div>
	<div class="tableFormWrap mt30">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00043"] //자동 메일전송 설정?></th>
				<td>
					<input type="radio" name="s_email_use" id="s_email_use" value="Y" <?=($siteInfoRow['S_EMAIL_USE'] == "Y") ? "checked" : ""; ?> /> <?=$LNG_TRANS_CHAR["EW00044"] //자동 E-Mail전송 사용함?> &nbsp;
					<input type="radio" name="s_email_use" id="s_email_use" value="N" <?=($siteInfoRow['S_EMAIL_USE'] != "Y") ? "checked" : ""; ?> /> <?=$LNG_TRANS_CHAR["EW00045"] //자동 E-Mail전송 사용안함?> &nbsp;
					<a class="btn_blue_big" href="javascript:goEmailUseModifyActEvent()" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00043"] //설정 변경?></strong></a>
				</td>
			</tr>
		</table>
	</div>
	<div class="tableFormWrap mt30">
		<?include "./include/tab_language.inc.php";?>
	</div>
	<?foreach($aryCommCodeRow as $key => $data):
		$strName			= $data["CC_NAME_{$strStLng}"];
		$strCode			= $data['CC_CODE'];

		## 데이터 불러오기
		$param							= "";
		$param['EM_LNG']				= $strStLng;
		$param['EM_GRP_CODE']			= $strCode;
		$param['CG_NO']					= $intCG_NO2;
		$param['CC_USE']				= "Y";
		$param['COMM_CODE_JOIN']		= "Y";
		$aryEmailMgrRow					= $objEmailMgrModule->getEmailMgrSelectEx("OP_ARYTOTAL", $param);	

		## 데이터 체크
		if(!$aryEmailMgrRow) { continue; }			?>
		<div class="autoSmsWrap">
			<h3><?=$strName?></h3>
			<div class="tableFormWrap mt10">
				<?foreach($aryEmailMgrRow as $key1 => $data1): 
					$intEmNo		= $data1["EM_NO"];
					$strTarget		= $data1["CC_NAME_{$strStLng}"];	
					$strEmSender	= $data1['EM_SENDER'];
					$strEmRecipient	= $data1['EM_RECIPIENT'];
					$strTitle		= $data1['EM_TITLE'];
					$strText		= $data1['EM_TEXT'];
					$strAuto		= $data1['EM_AUTO'];
					## 자동여부 설정
					if(!$strAuto) { $strAuto = "N"; }	?>
				<table class="tableForm" id="view_<?=$intEmNo?>">
					<tr>
						<th>전송대상</th>
						<td><?=$strTarget?></td>
					</tr>
					<tr>
						<th>제목</th>
						<td>
							<div style="padding-bottom: 5px;">
								<a class="btn_sml" href="javascript:goEmailModifyMoveEvent('<?=$intEmNo?>')" id="menu_auth_m"><strong>편집하기</strong></a>
							</div> 
							<p id="view_title_<?=$intEmNo?>"><?=$strTitle?></p>
						</td>
					</tr>
				</table>
				<table class="tableForm" id="modify_<?=$intEmNo?>" style="display:none;" >
					<tr>
						<th>전송대상</th>
						<td><?=$strTarget?></td>
					</tr>
					<tr>
						<th>자동여부</th>
						<td>
							<input type="radio" name="em_auto_<?=$intEmNo?>" value="Y"<?if($strAuto=="Y"){echo " checked";}?>/> 자동전송 사용 &nbsp; 
							<input type="radio" name="em_auto_<?=$intEmNo?>" value="N"<?if($strAuto=="N"){echo " checked";}?>/> 자동전송 사용안함
						</td>
					</tr>
					<tr>
						<th>보내는 사람</th>
						<td>
							<input type="input" name="em_sender_<?=$intEmNo?>" value="<?=$strEmSender?>" style="width:300px;"/>
						</td>
					</tr>
					<tr>
						<th>받는 사람</th>
						<td>
							<input type="input" name="em_recipient_<?=$intEmNo?>" value="<?=$strEmRecipient?>" style="width:300px;"/>
						</td>
					</tr>
					<tr>
						<th>제목</th>
						<td>
							<input type="input" name="em_title_<?=$intEmNo?>" value="<?=$strTitle?>" style="width:700px;"/>
						</td>
					</tr>
					<tr>
						<th>내용</th>
						<td>
							<textarea name="em_text_<?=$intEmNo?>" style="width:700px;height:200px;"><?=$strText?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div style="text-align: center; padding-bottom: 5px;width:700px;">
								<a href="javascript:goEmailModifyActEvent('<?=$intEmNo?>')" class="btn_blue_big" id="menu_auth_m" style="display: inline-block;" ><strong>수정</strong></a>
								<a href="javascript:goEmailCancelMoveEvent('<?=$intEmNo?>')" class="btn_big" ><strong>취소</strong></a>
							</div>
						</td>
					</tr>
				</table>
				<?endforeach;?>
			</div>
		</div>
	<?endforeach;?>
	
</div>