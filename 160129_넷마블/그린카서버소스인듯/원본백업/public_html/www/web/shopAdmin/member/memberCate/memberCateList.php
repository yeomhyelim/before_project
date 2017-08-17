
<div class="contentTop">
	<h2>회원소속관리</h2>
	<div class="clr"></div>
</div>

<div class="button">
	<a class="btn_blue_big" href="javascript:goMemberCateWriteMoveEvent();"><strong><?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
	<a class="btn_excel_big" href="javascript:goExcel('excelMemberCateList');" id="menu_auth_e"><strong>Excel Download</strong></a>
</div>

<div class="tableList">
	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col style="width:50px;">
			<col />
			<col style="width:100px;">
			<col style="width:60px;">
			<col style="width:100px;">
			<col style="width:100px;">
		</colgroup>
		<tr>
			<th>번호</th>
			<th>소속 카테고리</th>
			<th>사용여부</th>
			<th>회원수</th>
			<th>포인트</th>
			<!--th>구매금액</th//-->
			<th>관리</th>
		<tr>
		<?foreach($aryUseLng as $key => $lng):?>
		<tr>
			<td>-</td>
			<td style="text-align:left"><?=$S_ARY_COUNTRY[$lng]?></td>
			<td></td>
			<td></td>
			<td></td>
<!--			<td></td>//-->
			<td>-</td>
		</tr>
		<?
			$param						= "";
			$param['C_NATION']			= $lng;
			$param['ORDER_BY']			= "C.C_CODE ASC, C.C_LEVEL ASC";
			$param['COL_ADD_POINT']		= "Y";
//			$param['COL_ADD_ORDER']		= "Y";
			$memberCateResult			= $memberCateMgr->getMemberCateListEx($db, "OP_LIST", $param);
			while($row = mysql_fetch_array($memberCateResult)):
				$step				= $row['C_LEVEL'];
				$step				= "cate{$step}";

				$param				= "";
				$param['C_CODE']	= $row['C_CODE'];
				$intMemberCnt		= $memberCateMgr->getMemberCateCntEx($db,$param);
		?>
		<tr>
			<td>-</td>
			<td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="<?=$step?>"><?="{$row['C_NAME']}"?></span></td>
			<td><?=($row['C_VIEW']=="Y")?"사용":"미사용";?></td>
			<td><?=number_format($intMemberCnt)?></td>
			<td>
				<?if (($row['C_LEVEL'] == "2"|| $row['C_LEVEL'] == "3")&& $row['C_M_NO']){?>
					<?=NUMBER_FORMAT($row['C_TOT_POINT'])?><BR>
					<a class="btn_sml" href="javascript:goMemberPointWrite(<?=$row['C_M_NO']?>);"><span>+/-</span></a><a class="btn_sml" href="javascript:goMemberPointList('<?=$row['C_M_NO']?>');" ><span><?=$LNG_TRANS_CHAR["CW00070"] //상세?></span></a>
				<?}?>
			</td>
			<!--<td>
				<?if (($row['C_LEVEL'] == "2"|| $row['C_LEVEL'] == "3")&& $row['C_M_NO']){?>
					<?=NUMBER_FORMAT($row['C_TOT_ORDER_PRICE'])?><BR>
					<a class="btn_sml" href="javascript:goMemberCateOrderList('<?=$row['C_CODE']?>');"><span><?=$LNG_TRANS_CHAR["CW00070"] //상세?></span></a>
				<?}?>
			</td>//-->
			<td><a class="btn_blue_sml" href="javascript:goMemberCateModifyMoveEvent('<?=$row['C_CODE']?>');"><strong>수정</strong></a></td>
		</tr>
		<?	endwhile;?>
		<?endforeach;?>
	</table>
</div>

