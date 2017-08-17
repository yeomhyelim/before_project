		<table border="1">

			<tr>
				<th ><?=$LNG_TRANS_CHAR["EW00073"] //일별?></th>
				<th >강원</th>
				<th >경기</th>
				<th >경남</th>
				<th >경북</th>
				<th >광주</th>
				<th >대구</th>
				<th >대전</th>
				<th >부산</th>
				<th >서울</th>
				<th >울산</th>
				<th >인천</th>
				<th >전남</th>
				<th >전북</th>
				<th >제주</th>
				<th >충남</th>
				<th >충북</th>
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
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT6])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT7])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT8])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT9])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT10])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT11])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT12])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT13])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT14])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT15])?></td>
				<td><?=NUMBER_FORMAT($aryMemberList[$i][M_CNT16])?></td>		
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<?for($i=1;$i<=16;$i++){?>
				<td><?=NUMBER_FORMAT($arrMemArea[$i]["CNT"])?></td>
				<?}?>
			</tr>
		</table>