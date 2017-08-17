<?
	## 설정
	require_once MALL_CONF_LIB."memberCateMgr.php";
	$memberCateMgr			= new MemberCateMgr();

	## 언어 설정
	$aryUseLng			= explode("/", $S_USE_LNG);

?>
	<table border="1">
		<tr>
			<th>번호</th>
			<th>소속 카테고리</th>
			<th>사용여부</th>
			<th>회원수</th>
			<th>포인트</th>
			<th>구매금액</th>
		<tr>
		<?foreach($aryUseLng as $key => $lng):
			if ($lng == "KR"){
		?>
		<tr>
			<td>-</td>
			<td style="text-align:left"><?=$S_ARY_COUNTRY[$lng]?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?
			$param						 = "";
			$param['C_NATION']			 = $lng;
			$param['ORDER_BY']			 = "C.C_CODE ASC, C.C_LEVEL ASC";
			$param['COL_ADD_POINT']		 = "Y";
			$param['COL_ADD_ORDER']		 = "Y";
			$param['C_LEVEL_VIEW_LIMIT'] = 2;
			$memberCateResult			= $memberCateMgr->getMemberCateListEx($db, "OP_LIST", $param);
			$index						= 1;
			while($row = mysql_fetch_array($memberCateResult)):
				$step				= $row['C_LEVEL'];
				$strStepMark		= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				for($i=1;$i<=$step;$i++){
					$strStepMark .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				$step				= "cate{$step}";

				$param				= "";
				$param['C_CODE']	= $row['C_CODE'];
				$intMemberCnt		= $memberCateMgr->getMemberCateCntEx($db,$param);
		?>
		<tr>
			<td><?=$index++?></td>
			<td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$strStepMark?><?="{$row['C_NAME']}"?></td>
			<td><?=($row['C_VIEW']=="Y")?"사용":"미사용";?></td>
			<td><?=number_format($intMemberCnt)?></td>
			<td>
				<?if (($row['C_LEVEL'] == "2"|| $row['C_LEVEL'] == "3")&& $row['C_M_NO']){?>
					<?=NUMBER_FORMAT($row['C_TOT_POINT'])?>
				<?}?>
			</td>
			<td>
				<?if (($row['C_LEVEL'] == "2"|| $row['C_LEVEL'] == "3")&& $row['C_M_NO']){?>
					<?=NUMBER_FORMAT($row['C_TOT_ORDER_PRICE'])?><BR>
				<?}?>
			</td>
		</tr>
		<?	endwhile;?>
		<?	}?>
		<?endforeach;?>
	</table>

