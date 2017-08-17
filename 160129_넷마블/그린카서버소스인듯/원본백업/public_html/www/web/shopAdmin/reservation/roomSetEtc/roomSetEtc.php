<form name="form" name="form" id="form" >
<input type="hidden" name="menuType" value="reservation">
<input type="hidden" name="mode" value="">
<input type="hidden" name="act" value="">

	<div id="contentArea">
	<div class="contentTop">
		<h2>환경설정</h2>
		<div class="clr"></div>
	</div>
	<br>


	<div class="tabRevNav">
		<a href="./?menuType=reservation&mode=basicSet">기본환경설정</a>
		<a href="./?menuType=reservation&mode=roomSetEtc" class="selected">부대시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetFix">객실시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetPolicy">예약규정설정</a>
	</div>
	<!-- ******** 컨텐츠 ********* -->



	<div class="tableFo,rWrap">
		<h3>부대시설설정</h3>
		<table class="tableList">
			<tr>
				<th><input type="checkbox" name=""></th>
				<th>순서</th>
				<th>시설명</th>
				<th>이용요금</th>
				<th>단위</th>
				<th>비고</th>
				<th>관리</th>
			</tr>
			<?while($row=mysql_fetch_array($result)){?>
			<?if($row['AM_TYPE']=="부대시설"){?>
			<tr>
				<td><input type="checkbox" name=""></td>
				<td><input type="text" name="" value="<?echo $row['AM_ORDER'];?>" class="_w30"></td>
				<td><input type="text" name="" class="_w300" value="<?echo $row['AM_DEV'];?>"></td>
				<td><input type="text" name="" value="<?echo number_format($row['AM_PRICE']);?>">원</td>
				<td><input type="text" name="" value="<?echo $row['AM_UNIT'];?>"></td>
				<td><input type="text" name="" value="<?echo $row['AM_MEMO'];?>"></td>
				<td><a href="#" onclick="openLayer2('poproomSetEtcModify',700,'<?echo $row['AM_NO'];?>')" class="btn_blue_sml"><span>수정</span></a><a href="javascript:goAddSetDelete(<?=$row["AM_NO"]?>);" class="btn_sml"><span>삭제</span></a></td>
			</tr>
			<?}?>
			<?}?>
		</table>
	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="#" onclick="openLayer('poproomSetEtc',700)"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		</div>

		<h3 class="mt30">객실유형설정</h3>
		<table class="tableList">
			<tr>
				<th><input type="checkbox" name=""></th>
				<th>순서</th>
				<th>객실유형</th>
				<th>관리</th>
			</tr>
			<?while($row2=mysql_fetch_array($result2)){?>
			<?if($row2['AM_TYPE']=="객실유형"){?>
			<tr>
				<td><input type="checkbox" name=""></td>
				<td><input type="text" name="" value="<?echo $row2['AM_ORDER'];?>" class="_w30"></td>
				<td><input type="text" name="" class="_w500" value="<?echo $row2['AM_DEV'];?>"></td>
				<td><a href="#" onclick="openLayer3('poproomTypeSetModify',700,200,'<?echo $row2['AM_NO'];?>')" class="btn_blue_sml"><span>수정</span></a><a href="javascript:goAddSetDelete(<?=$row2["AM_NO"]?>);" class="btn_sml"><span>삭제</span></a></td>
			</tr>
			<?}?>
			<?}?>
		</table>
	</div>


	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="#" onclick="openLayer('poproomTypeSet',700,200)"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		</div>
</div>
</form>
