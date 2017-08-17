<div id="contentArea">
	<div class="contentTop">
		<h2>환경설정</h2>
		<div class="clr"></div>
	</div>
	<br>


	<div class="tabRevNav">
		<a href="./?menuType=reservation&mode=basicSet">기본환경설정</a>
		<a href="./?menuType=reservation&mode=roomSetEtc">부대시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetFix" class="selected">객실시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetPolicy">예약규정설정</a>
	</div>
	<!-- ******** 컨텐츠 ********* -->



	<div class="tableFo,rWrap">
		<h3>객실시설설정</h3>
		<table class="tableList">
			<tr>
				<th><input type="checkbox" name=""></th>
				<th>시설구분</th>
				<th>출력</th>
				<th>하위</th>
				<th width="10%">관리</th>
			</tr>
			<?$i=0;?>
			<?while($row=mysql_fetch_array($result)){$i++;?>
			<tr>
				<td><input type="checkbox" name=""></td>
				<td><?echo $row['CG_NAME'];?></td>
				<td><?echo $row['CG_USE'];?></td>
				<td><a href="javascript:void(0);" onclick="goTableShow('<?echo $i;?>');">▶</a></td>
				<td><a href="#" onclick="openLayer2('poproomSetFixModify',700,'<?echo $row['CG_NO'];?>')" class="btn_blue_sml"><span>수정</span></a><a href="javascript:goFixDelete(<?=$row["CG_NO"]?>);" class="btn_sml"><span>삭제</span></a></td>
			</tr>
			<?}?>
		</table>
		<div class="buttonBoxWrap">
			<a class="btn_new_blue" href="#" onclick="openLayer('poproomSetFix',700)"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		</div>
	<?$j=0;?>
	<?while($row2=mysql_fetch_array($result2)){$j++;?>
		<table class="tableList" name="roomFix<?echo $j;?>" id="roomFix<?echo $j;?>" class="roomFix<?echo $j;?>" style="display:none">

			<?$strRoomType		= $row2['CG_NAME'];?>
			<?$intCG_NUMBER		= $row2['CG_NO'];?>
			<?$resultGet		= $reservationMgr->getRoomSetFix2($db,$intCG_NUMBER);?>

			<tr>
				<th><input type="checkbox" name=""></th>
				<th width="10%">순위</th>
				<th>시설구분[<?echo $strRoomType;?>]</th>
				<th>출력</th>
				<th width="10%">관리</th>
			</tr>
			<?while($rowGet= mysql_fetch_array($resultGet)){?>
				<tr>
					<td><input type="checkbox" name=""></td>
					<td><?echo $rowGet['CC_SORT'];?></td>
					<td><?echo $rowGet['CC_NAME_KR'];?></td>
					<td><?echo $rowGet['CC_USE'];?></td>
					<td><a href="#" onclick="openLayer5('poproomSetFixModify2',700,'<?echo $rowGet['CC_NO'];?>','<?echo $intCG_NUMBER;?>')" class="btn_blue_sml"><span>수정</span></a><a href="javascript:goFixDelete2(<?=$rowGet["CC_NO"]?>);" class="btn_sml"><span>삭제</span></a></td>
				</tr>
			<?}?>
				<tr>
					<td>
					</td>
					<td>
					</td>
					<td>
						<a class="btn_new_blue" href="#" onclick="openLayer4('poproomSetFix2',700,'<?echo $intCG_NUMBER;?>','<?echo $strRoomType;?>')"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
					</td>
					<td>
					</td>
					<td>
					</td>
				</tr>
		</table>

	<?}?>

	</div>



</div>
