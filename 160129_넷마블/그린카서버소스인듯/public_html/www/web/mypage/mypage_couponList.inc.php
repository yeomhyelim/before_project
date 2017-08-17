	
		<h4 class="titMyCoupon"><span><?=$LNG_TRANS_CHAR["CW00014"] //쿠폰 현황?></span></h4>
		<div class="myOrderListWrap">
				<table>
					<colgroup>
						<col style="width:100px;"/>
						<col style="width:200px;"/>
						<col style="width:90px;"/>
						<col/>
						<col style="width:100px;"/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00063"] //일시?></th>
						<th><?=$LNG_TRANS_CHAR["OW00075"] //쿠폰번호?></th>
						<th><?=$LNG_TRANS_CHAR["OW00077"] //금액?></th>
						<th><?=$LNG_TRANS_CHAR["OW00066"] //내역?></th>
						<th><?=$LNG_TRANS_CHAR["OW00067"] //유효기간?></th>
						<th><?=$LNG_TRANS_CHAR["CW00038"] //사용여부?></th>
					</tr>
					<?if($intTotal=="0"){?>
					<tr>
						<td colspan="6" class="dataNoList"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
					</tr>		
					<?}?>
					<?
						while($row = mysql_fetch_array($result)){
							if ($row[CI_USE] == "Y") $strUseYN = "<strong class=\"priceOrange\">".$LNG_TRANS_CHAR["CW00035"]."</strong>"; //사용
							else $strUseYN = "<strong class=\"priceBoldBlue\">".$LNG_TRANS_CHAR["CW00067"]."</strong>"; //미사용
					?>
					<tr>
						<td><?=SUBSTR($row[CI_REG_DT],0,10)?></td>
						<td><strong class="priceBoldGray"><?=$row[CI_CODE]?></strong></td>
						<td><strong class="priceBoldGray"><?=getCurToPrice($row[CU_PRICE])?></strong></td>					
						<td><?=$row[CU_NAME]?></td>
						<td><?=SUBSTR($row[CI_END_DT],0,10)?></td>
						<td><?=$strUseYN?></td>
					</tr>
					<?
						}
					?>
				</table>
			</div>

			<div id="pagenate">
				<?=drawUserPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
			</div>

			<div class="btnCenter">		
				<a href="javascript:goCouponReg();" class="nextBigBtn"><span><?=$LNG_TRANS_CHAR["OW00107"] //쿠폰등록?></span></a>
			</div>