	<!-- 포인트 현황 -->
	<div class="orderStateWrap">
		<div class="totalPointWrap">
			<strong>total:</strong> <strong class="txtCnt"><?=NUMBER_FORMAT($memberRow['M_POINT'])?></strong>
		</div>
		<div class="txtInfoWrap">
			<ul>
				<li>ㆍ<?=callLangTrans($LNG_TRANS_CHAR["OS00049"],array(getCurToPrice($memberRow[M_POINT]))) //보유하신 포인트는 총00포인트 입니다.?></li>
				<li>ㆍ<?=callLangTrans($LNG_TRANS_CHAR["OS00032"],array(getCurToPrice($S_POINT_MIN)))//포인트 사용은 00인트 부터 사용 가능합니다.?></li>
			<ul>
		</div>
		<?if ($SHOP_POINT_MOVE_FLAG == "Y" && $S_FIX_MEMBER_POINT_GIFT_FLAG == "Y"){?>
		<div>
			<a href="javascript:goMemberPointGift();">[포인트선물하기]</a>
		</div>
		<?}?>
	</div>
	<!-- 포인트  -->

	<h4 class="titMyPoint"><span><?=$LNG_TRANS_CHAR["CW00025"] //포인트 현황?></span></h4>
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
						$strReceiveMemberId	= "";
						if ($row[PT_POINT] > 0) $strPointGubun = "plus";
						else $strPointGubun = "minus";
				
						$strPointType = "";
						if ($row['PT_TYPE'] == "011" || $row['PT_TYPE'] == "010") $strPointType = "(선물)";
						
						if ($SHOP_POINT_MOVE_FLAG == "Y" && $S_FIX_MEMBER_POINT_GIFT_FLAG == "Y"){
							if ($row['PT_TYPE'] == "011" || $row['PT_TYPE'] == "010"){
								$param					= "";
								if ($row['PT_TYPE'] == "011") $param['RECEIVE_M_NO']	= $row['PT_ETC'];
								else $param['RECEIVE_M_NO']	= $row['PT_REG_NO'];
								$receiveMemberRow		= $pointMgr->getMemberView($db,$param);
								$strReceiveMemberId		= $receiveMemberRow['M_ID'];
							}
						}
				?>
				<tr>
					<td><?=SUBSTR($row[PT_REG_DT],0,10)?></td>
					<td><?=$strPointType?><?=$row[PT_MEMO]?><?=($strReceiveMemberId)?"({$strReceiveMemberId})":"";?></td>
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
