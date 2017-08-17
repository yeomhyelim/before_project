	<table border="1">
		<tr>
			<th><?=getEuckrString($LNG_TRANS_CHAR["CW00009"]) //번호?></th>
			<th><?=getEuckrString($LNG_TRANS_CHAR["MW00142"]) //발급코드?></th>
			<th><?=getEuckrString($LNG_TRANS_CHAR["MW00143"]) //발급받은 회원정보?></th>
			<th><?=getEuckrString($LNG_TRANS_CHAR["MW00144"]) //발급일?></th>
			<th><?=getEuckrString($LNG_TRANS_CHAR["MW00145"]) //사용유무?></th>
			<th><?=getEuckrString($LNG_TRANS_CHAR["MW00146"]) //사용일자?></th>
		</tr>
		<?
			$intListNum = 1;
			while($couponIssueRow = mysql_fetch_array($result)){
				if ($S_MEM_CERITY == "1") $strMemberId = $couponIssueRow[M_ID];
				else $strMemberId = $couponIssueRow[M_MAIL];
		?>
		<tr>
			<td><?=getEuckrString($intListNum++)?></td>
			<td style='mso-number-format:"\@";'><?=getEuckrString($couponIssueRow[CI_CODE])?></td>
			<td><?if ($couponIssueRow[M_NO] > 0){?><?=getEuckrString($couponIssueRow[M_NAME])?>(<?=getEuckrString($strMemberId)?>)<?}?></td>
			<td><?=getEuckrString($couponIssueRow[CI_REG_DT])?></td>
			<td><?=($couponIssueRow[CI_USE]=="Y")? getEuckrString($LNG_TRANS_CHAR["CW00010"]): getEuckrString($LNG_TRANS_CHAR["CW00075"]); //사용/미사용?></td>
			<td><?=getEuckrString($couponIssueRow[CI_USE_DT])?></td>
		</tr>
		<?
			}
		?>
	</table>