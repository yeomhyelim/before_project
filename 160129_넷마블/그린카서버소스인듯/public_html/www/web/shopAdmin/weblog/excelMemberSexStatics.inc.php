		<table border="1">
			<colgroup>
				<col style="width:80px;"/>				
				<col />
				<col />
			</colgroup>
			<tr>
				<th ><?=$LNG_TRANS_CHAR["EW00073"] //일별?></th>
				<th ><?=$LNG_TRANS_CHAR["EW00086"] //남?></th>
				<th ><?=$LNG_TRANS_CHAR["EW00087"] //여?></th>
			</tr>
			<?
			if (is_array($aryMemberList)){

				for($i=1;$i<=2;$i++){
					$arrMemSex[$i]["CNT"]		= 0;
				}

				for($i=0;$i<sizeof($aryMemberList);$i++){
					for($j=1;$j<=2;$j++){
						$arrMemSex[$j]["CNT"]	= $arrMemSex[$j]["CNT"]	+ $aryMemberList[$i]["M_CNT".$j];
					}
					?>
			<tr>
				<td><?=$aryMemberList[$i][M_REG_DT]?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT1])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT2])?></td>		
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<?for($i=1;$i<=2;$i++){?>
				<td><?=NUMBER_FORMAT($arrMemSex[$i]["CNT"])?></td>
				<?}?>
			</tr>
		</table>
