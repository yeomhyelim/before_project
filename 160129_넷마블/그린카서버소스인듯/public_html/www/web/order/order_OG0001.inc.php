<!-- (2) 상단 서브 카테고리 -->
<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
<!-- (2) 상단 서브 카테고리 -->

<div class="cartListWrap mt20">
		
		<div class="tableProdList mt10">
			<table>
				<colgroup>
					<col style="width:50px;"/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col style="width:180px;"/>
				</colgroup>
				<tr>
					<th>번호</th>
					<th>상품정보</th>
					<th>주문금액</th>
					<th>수량</th>
					<th>결제금액</th>
					<th>관리</th>
				</tr>
				<?if ($intTotal == 0){?>
				<tr>
					<td colspan="6">주문내역이 없습니다.</td>
				</tr>
				<?}else{
					
					while($row = mysql_fetch_array($result)){
						$btnOrderCancel1 = $btnOrderCancel2 = $btnOrderOk = "";
						$strOrderStatus = $row[O_STATUS];
						/*주문중,입금확인중,결제완료일때 취소가능*/
						if ($strOrderStatus == "J" || $strOrderStatus == "O" || $strOrderStatus == "A"){
							$btnOrderCancel1 = "<a href=\"javascript:goMyOrderCancel(".$row[O_NO].");\"><img src=\"../himg/mypage/A0001/btn_order_cancel.gif\"/></a>";
						}

						/* 배송시작/배송중/배송완료일때 에스크로 결제일 경우 정산보류->주문취소신청*/
						if ($strOrderStatus == "B" || $strOrderStatus== "I" || $strOrderStatus == "D"){
							if ($row[O_ESCROW] == "Y"){
								//$btnOrderCancel2 = "<a href=\"javascript:goMyOrderCancel(".$row[O_NO].");\"><img src=\"../himg/$D_LAYOUT_HIMG/mypage/btn_order_cancel.gif\"/></a>";	
								
								$btnOrderOk = "<a href=\"".$S_KCP_BUY_OK.$g_conf_site_cd."&tno=".$row[O_APPR_NO]."&order_no=".$row[O_KEY]."\" target=\"_blank\"><img src=\"../himg/mypage/A0001/btn_prod_delivery_ok.gif\"/></a>";
							}
						}
					?>
				<tr>
					<td><?=$intListNum?></td>
					<td class="prodInfo">
						<!--<a href="#"><img src="/himg/test_prod/prod_06.jpg" style="width:50px;"/></a>//-->
						<ul>
							<li><a href="javascript:goOrderView('buyNonView',<?=$row[O_NO]?>);"><?=$row[O_J_TITLE]?></a></li>
						</ul>
						<div class="clear"></div>
					</td>
					<td><strong class="priceBoldGray"><?=NUMBER_FORMAT($row[O_TOT_PRICE])?>원</strong></td>
					<td><?=NUMBER_FORMAT($row[O_TOT_QTY])?>개</td>
					<td><strong class="priceOrange"><?=NUMBER_FORMAT($row[O_TOT_SPRICE])?>원</strong></td>
					<td class="checkOrderBtn">
						<img src="../himg/mypage/<?=$S_DESIGN_LAYOUT?>/ico_order_step_<?=$row[O_STATUS]?>.gif"/>
						<?=$btnOrderCancel1?>
						<?=$btnOrderCancel2?>
						<?=$btnOrderOk?>
						<?if ($strOrderStatus == "I" || $strOrderStatus == "D"){?> 
						<ul>
							<li><span>배송사</span>: <?=$aryDeliveryCom[$row[O_DELIVERY_COM]]?> 택배</li>
							<li><span>송장번호</span>: <a href="#" class="priceBoldGray"><?=$row[O_DELIVERY_NUM]?> <span class="linkIco">▶</span></a></li>
						</ul>
						<?}?>
					</td>
				</tr>
				<?
						$intListNum--;
					}
				?>
				<?}?>
			</table>
			<div id="pagenate">
				<?=drawUserPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","","",""," | ")?>
			</div>
		</div><!-- tableProdList -->		
	</div><!-- cartListWrap -->
