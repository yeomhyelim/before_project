		<table border="1">
			<colgroup>
				<col style="width:80px;"/>				
				<col />
				<col style="background-color:#f1f7f9" />
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00073"] //일별?></th>
				<th><?=$LNG_TRANS_CHAR["EW00084"] //신규회원수?></th>
			</tr>
			<?
			if (is_array($aryMemberList)){
				for($i=0;$i<sizeof($aryMemberList);$i++){
					$intTot += $aryMemberList[$i][M_REG_CNT];
					?>
			<tr>
				<td><?=$aryMemberList[$i][M_REG_DT]?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_REG_CNT])?></td>
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=NUMBER_FORMAT($intTot)?></td>
			</tr>
		</table>
