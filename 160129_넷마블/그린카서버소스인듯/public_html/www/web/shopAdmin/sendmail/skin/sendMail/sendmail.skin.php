<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["EW00043"] //자동메일 설정?></h2>
	<div class="clr"></div>
</div>

<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm mt30">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00043"] //자동 메일전송 설정?></th>
				<td>
					<input type="radio" name="s_emailUse" id="s_emailUse" value="Y" <?=($siteInfoRow[S_EMAIL_USE] == "Y") ? "checked" : ""; ?> /> <?=$LNG_TRANS_CHAR["EW00044"] //자동 E-Mail전송 사용함?> &nbsp;
					<input type="radio" name="s_emailUse" id="s_emailUse" value="N" <?=($siteInfoRow[S_EMAIL_USE] != "Y") ? "checked" : ""; ?> /> <?=$LNG_TRANS_CHAR["EW00045"] //자동 E-Mail전송 사용안함?> &nbsp;
					<a class="btn_blue_big" href="javascript:goMoveUrl('emailUseType','','');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00043"] //설정 변경?></strong></a>
				</td>
			</tr>
		</table>
	</div>
	<div class="tableForm mt10">
		<?=drawSelectBoxMore("mailLng",$S_ARY_USE_COUNTRY,$strLang,$design ="","javascript:goSelectLang(this);",$etc="",$firstItem="",$html="N")?>
	</div>
		<?
			$strTagClose	= "";
			$strGrpCodeTemp	= "";		// 그룹 체크
			$responseText	= "";
			$count			= 0;		// form 이름 카운트

			while($emailRow = mysql_fetch_array($emailListRow))
			{
				if($emailRow[EM_GRP_CODE] != $strGrpCodeTemp) 
				{
					$strGrpCodeTemp = $emailRow[EM_GRP_CODE];
					$responseText .= ($strTagClose == "") ? "" : "</div></div>"; $strTagClose = "Y";
					$responseText .= "<div class='autoSmsWrap mt30'>";
					$responseText .= "<h3>".$emailRow[EM_GRP_NAME]."</h3>";
					$responseText .= "<div class='tableForm mt10'>";
				}

				$txtModify	   = "<div style='padding-bottom: 5px;'><a class='btn_sml' href='javascript:goMoveUrl(\"sendMailModify\",".$emailRow[EM_NO].")' id='menu_auth_m'><strong>".$LNG_TRANS_CHAR["CW00044"]."</strong></a></div>"; //편집하기
				$responseText .= "<input type=\"hidden\" name=\"em_send_code\" value=\"". $emailRow[EM_SEND_CODE] ."\"/><div id='modifyText_".$emailRow[EM_NO]."'><table class='mt10'>";
				$responseText .= "<tr><th>".$LNG_TRANS_CHAR["EW00046"]."</th><td>".$emailRow[EM_SEND_NAME]."</td></tr>"; //전송대상
				$responseText .= "<tr><th>".$LNG_TRANS_CHAR["EW00005"]."</th><td>$txtModify".$emailRow[EM_TITLE]."</td></tr>"; //제목
				$responseText .= "</table></div>";

				$strAutoSendY = ($emailRow[EM_AUTO] == "Y") ? "checked" : "";
				$strAutoSendN = ($emailRow[EM_AUTO] != "Y") ? "checked" : "";
				
				$responseText .= "<div class='tableForm mt10' id='modifyEdit_".$emailRow[EM_NO]."' style='display:none;'><table>";
				$responseText .= "<tr><th>".$LNG_TRANS_CHAR["EW00046"]."</th><td><strong>".$emailRow[EM_SEND_NAME]."</strong></td></tr>";
				$responseText .= "<tr><th>".$LNG_TRANS_CHAR["EW00047"]."</th><td><input type='radio' name='em_auto_$count' id='em_auto_$count' value='Y' $strAutoSendY/> ".$LNG_TRANS_CHAR["EW00048"]." &nbsp; <input type='radio' name='em_auto_$count' id='em_auto_$count' value='N' $strAutoSendN/> ".$LNG_TRANS_CHAR["EW00049"]."</td></tr>";
				$responseText .= "<tr><th>".$LNG_TRANS_CHAR["EW00050"]."</th><td><!-- select name=''><option value=''>".$LNG_TRANS_CHAR["EW00051"]."</option><option value=''>".$LNG_TRANS_CHAR["EW00055"]."</option><option value=''>".$LNG_TRANS_CHAR["EW00052"]."</option></select --><input type='input' name='em_sender' id='em_sender' value='".$emailRow[EM_SENDER]."' style=\"width:300px;\"/></td></tr>";
				$responseText .= "<tr><th>".$LNG_TRANS_CHAR["EW00053"]."</th><td>{{상점명}} {{오늘날짜}} {{아이디}} {{고객명}} {{상점URL}}</td></tr>";
				$responseText .= "<tr><th>".$LNG_TRANS_CHAR["EW00005"]."</th><td><input type='input' name='em_title' id='em_title' value='".$emailRow[EM_TITLE]."' $nBox style='width:700px;'/></td></tr>";
				$responseText .= "<tr><th>".$LNG_TRANS_CHAR["EW00054"]."</th><td><textarea $nBox  name='em_text' id='em_text' style='width:700px;height:200px;'>".$emailRow[EM_TEXT]."</textarea></td></tr>";
				$responseText .= "<tr><td colspan=2><div style='padding-bottom: 5px;text-align:center;'><a class='btn_blue_big' href='javascript:goMoveUrl(\"sendMailModifyOK\",".$emailRow[EM_NO].",$count);' id='menu_auth_m' style='display:none'><strong>".$LNG_TRANS_CHAR["CW00003"]."</strong></a> &nbsp; <a class='btn_big' href='javascript:goMoveUrl(\"modifyCancel\",".$emailRow[EM_NO].");'><strong>".$LNG_TRANS_CHAR["CW00008"]."</strong></a></div></td></tr>";
				$responseText .= "</table></div>";
				$count++;

			}

			$responseText .= "</div>";

			echo $responseText;

		?>

<!-- ******** 컨텐츠 ********* -->