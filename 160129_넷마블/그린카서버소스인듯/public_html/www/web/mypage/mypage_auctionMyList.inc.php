	<h4 class="titMyPoint"><span><?=$LNG_TRANS_CHAR["PW00070"] //경매관리?></span></h4>
	<div class="myOrderListWrap">
			<table>
				<colgroup>
					<col style="width:150px;"/>
					<col/>
					<col style="width:100px;"/>
					<col style="width:100px;"/>
					<col style="width:100px;"/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00074"] //일시?></th>
					<th><?=$LNG_TRANS_CHAR["OW00058"] //상품명?></th>
					<th><?=$LNG_TRANS_CHAR["PW00063"] //입찰가?></th>					
					<th><?=$LNG_TRANS_CHAR["PW00069"] //낙찰자?></th>
					<th><?=$LNG_TRANS_CHAR["PW00072"] //경매상태?></th>
				</tr>
				<?if($intTotal=="0"){?>
				<tr>
					<td colspan="6" class="dataNoList"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
				</tr>		
				<?}?>
				<?
					while($row = mysql_fetch_array($result)){
						
						## 경매기간
						$strProdAucDate				= $row['P_AUC_ST_DT']." ".$row['P_AUC_END_DT'];
						
						## 상품명						
						$strProdAucName				= "<a href='./?menuType=product&mode=view&prodCode={$row['P_CODE']}'>".$row['P_NAME']."</a>";
						
						## 입찰가
						$strPriceLeftMark			= getCurMark($row['P_AUC_APPLY_USE_CUR']);
						if ($strPriceLeftMark) $strPriceLeftMark .= " ";
						$strPriceRightMark			= getCurMark2($row['P_AUC_APPLY_USE_CUR']);
						
						$strProdAucApplyCurPrice	= $strPriceLeftMark.getFormatPrice($row['P_AUC_APPLY_CUR_PRICE'],2).$strPriceRightMark;
						
						## 경매상태
						switch($row['P_AUC_STATUS']){
							case "2":
								$strProdAucStatusName = $LNG_TRANS_CHAR["PW00075"]; //"진행중";
							break;
							case "4":
								$strProdAucStatusName = $LNG_TRANS_CHAR["PW00076"]; //"완료";
							break;
							case "5":
								$strProdAucStatusName = $LNG_TRANS_CHAR["PW00068"]; //"종료";
							break;
						}

						## 낙찰자
						$strProdAucApplySucMemberName	= "";
						if ($row['M_F_NAME']) $strProdAucApplySucMemberName  = $row['M_F_NAME']." ";
						if ($row['M_L_NAME']) $strProdAucApplySucMemberName .= $row['M_L_NAME'];
						if ($row['P_AUC_SUC_M_NO'] != $g_member_no)
							$strProdAucApplySucMemberName = strHanCutUtf2($strProdAucApplySucMemberName, 1,false,'**');
						
						## 구매여부
						$strProdAucBuyText				= "";
						if ($row['P_AUC_SUC_M_NO'] == $g_member_no){
							$strProdAucBuyText = "<span>".$LNG_TRANS_CHAR["PW00073"]."</span>";
						}

						## 입찰횟수
						$intProdAucApplyCnt				= $row['P_AUC_APPLY_CNT'];
						$btnProdAucApplyList			= "";
						if ($intProdAucApplyCnt > 1){
							$btnProdAucApplyList		= "<a href='javascript:goProdAuctionMyApplyList(\"".$row['P_CODE']."\")' class=''>".$LNG_TRANS_CHAR["PW00077"]."</a>"; //상세보기
						}
				?>
				<tr>
					<td><?=$strProdAucDate?></td>
					<td><?=$strProdAucName?><?=$strProdAucBuyText?></td>
					<td><?=$strProdAucApplyCurPrice?><?=$btnProdAucApplyList?></td>
					<td><?=$strProdAucApplySucMemberName?></td>
					<td><?=$strProdAucStatusName?></td>
				</tr>
				<?
					}
				?>
			</table>
		</div>

		<div id="pagenate">
			<?=drawUserPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
		</div>
