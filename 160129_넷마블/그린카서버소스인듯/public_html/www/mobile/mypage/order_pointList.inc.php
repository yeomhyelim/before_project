	<!-- 포인트 현황 -->
	<div class="orderStateWrap">
		<div class="totalPointWrap">
			<strong>total:</strong> <strong class="txtCnt"><?=NUMBER_FORMAT($memberRow['M_POINT'])?></strong>
		</div>
		<div class="txtInfoWrap">
			<ul>
				<li>ㆍ<?=callLangTrans($LNG_TRANS_CHAR["OS00049"],array(getCurToPrice($memberRow[M_POINT]))) //보유하신 포인트는 총00포인트 입니다.?></li>
				<li>ㆍ<?=callLangTrans($LNG_TRANS_CHAR["OS00050"],array(getCurToPrice($S_POINT_MIN)))//포인트 사용은 00인트 부터 사용 가능합니다.?></li>
			<ul>
		</div>
	</div>
	<!-- 포인트  -->

	<h4><?=$LNG_TRANS_CHAR["CW00025"] //포인트 현황?></h4>
	<div class="myOrderListWrap">
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
					<col style="width:100px;"/>
					<col style="width:100px;"/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00063"] //일시?></th>
					<th><?=$LNG_TRANS_CHAR["OW00066"] //내역?></th>
					<th><?=$LNG_TRANS_CHAR["OW00065"] //포인트?></th>					
					<th><?=$LNG_TRANS_CHAR["OW00067"] //유효기간?></th>
				</tr>
				<?if($intTotal=="0"){?>
				<tr>
					<td colspan="6" class="dataNoList"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
				</tr>		
				<?}?>
				<?
					while($row = mysql_fetch_array($result)){
						if ($row[PT_POINT] > 0) $strPointGubun = "plus";
						else $strPointGubun = "minus";
				?>
				<tr>
					<td><?=SUBSTR($row[PT_REG_DT],0,10)?></td>
					<td><?=$row[PT_MEMO]?></td>
					<td class="pointState"><?=getCurToPrice($row[PT_POINT])?><img src="/himg/mypage/A0002/icon_point_<?=$strPointGubun?>.gif"></td>					
					<td><?=SUBSTR($row[PT_END_DT],0,10)?></td>
				</tr>
				<?
					}
				?>
			</table>
		</div>

		<div id="pagenate">
			<?=drawUserPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
		</div>
