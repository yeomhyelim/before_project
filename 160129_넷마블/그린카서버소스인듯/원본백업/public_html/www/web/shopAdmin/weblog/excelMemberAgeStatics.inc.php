		<table border="1">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00073"] //일별?></th>
				<th>10</th>
				<th>20</th>
				<th>30</th>
				<th>40</th>
				<th>50</th>
				<th><?=$LNG_TRANS_CHAR["EW00081"] //60이상?></th>
			</tr>
			<?
			if (is_array($aryMemberList)){
				for($i=1;$i<=16;$i++){
					$arrMemArea[$i]["CNT"]		= 0;
				}
				for($i=0;$i<sizeof($aryMemberList);$i++){

					for($j=1;$j<=16;$j++){
						$arrMemArea[$j]["CNT"]	= $arrMemArea[$j]["CNT"]	+ $aryMemberList[$i]["M_CNT".$j];
					}
					?>
			<tr>
				<td><?=$aryMemberList[$i][M_REG_DT]?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT1])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT2])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT3])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT4])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT5])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT5])?></td>
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<?for($i=1;$i<=6;$i++){?>
				<td><?=NUMBER_FORMAT($arrMemArea[$i]["CNT"])?></td>
				<?}?>
			</tr>
		</table>
