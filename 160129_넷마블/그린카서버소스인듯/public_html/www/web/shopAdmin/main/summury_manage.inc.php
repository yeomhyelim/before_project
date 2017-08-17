<!-- 매출현황 요약 -->
						<div class="mainSummary left">
							<table>
								<colgroup>
									<col/>
									<col style="width:70px;"/>
									<col style="width:70px;"/>
									<col style="width:70px;"/>
									<col style="width:70px;"/>
									<col style="width:70px;"/>
									<col style="width:70px;"/>
								</colgroup>
								<tr>
									<th></th>
									<th><?= date("n.j",strtotime("-2 day", time()))?></th>
									<th><?= date("n.j",strtotime("-1 day", time()))?></th>
									<th><?= date("n.j",strtotime("0 day", time()))?><img src="/shopAdmin/himg/common/ico_today.gif" style="margin-left:5px;"/></th>
									<th><?=$LNG_TRANS_CHAR["EW00100"] //최근1주?></th>
									<th><?=$LNG_TRANS_CHAR["EW00101"] //이번달?></th>
									<th><?=$LNG_TRANS_CHAR["EW00102"] //지난달?></th>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00103"] //매출액(원)?>(<?=$LNG_TRANS_CHAR["EW00130"]//미결제포함?>)</td>
									<td><?=getFormatPrice($aryMainStaticsList[0][DAY2_CNT1],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][DAY1_CNT1],2,$S_ST_CUR)?></td>
									<td><strong><?=getFormatPrice($aryMainStaticsList[0][DAY_CNT1],2,$S_ST_CUR)?></strong></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][WEEK_CNT1],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][MONTH_CNT1],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][PREV_MONTH_CNT1],2,$S_ST_CUR)?></td>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00103"] //매출액(원)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][DAY2_PRICE1],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][DAY1_PRICE1],2,$S_ST_CUR)?></td>
									<td><strong><?=getFormatPrice($aryMainStaticsList[0][DAY_PRICE1],2,$S_ST_CUR)?></strong></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][WEEK_PRICE1],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][MONTH_PRICE1],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][PREV_MONTH_PRICE1],2,$S_ST_CUR)?></td>
								</tr>
								<tr>
									<td class="title" rowspan="2"><?=$LNG_TRANS_CHAR["BW00052"]//결제완료?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][DAY2_A_PRICE],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][DAY1_A_PRICE],2,$S_ST_CUR)?></td>
									<td><strong><?=getFormatPrice($aryMainStaticsList[0][DAY_A_PRICE],2,$S_ST_CUR)?></strong></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][WEEK_A_PRICE],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][MONTH_A_PRICE],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][PREV_MONTH_A_PRICE],2,$S_ST_CUR)?></td>
								</tr>
								<tr>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY2_A_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY1_A_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY_A_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][WEEK_A_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][MONTH_A_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][PREV_MONTH_A_CNT])?></td>
								</tr>
								<tr>
									<td class="title" rowspan="2"><?=$LNG_TRANS_CHAR["EW00109"] //구매완료(건)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][DAY2_E_PRICE],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][DAY1_E_PRICE],2,$S_ST_CUR)?></td>
									<td><strong><?=getFormatPrice($aryMainStaticsList[0][DAY_E_PRICE],2,$S_ST_CUR)?></strong></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][WEEK_E_PRICE],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][MONTH_E_PRICE],2,$S_ST_CUR)?></td>
									<td><?=getFormatPrice($aryMainStaticsList[0][PREV_MONTH_E_PRICE],2,$S_ST_CUR)?></td>
								</tr>
								<tr>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY2_E_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY1_E_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY_E_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][WEEK_E_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][MONTH_E_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][PREV_MONTH_E_CNT])?></td>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00104"] //주문건수(건)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY2_J_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY1_J_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY_J_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][WEEK_J_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][MONTH_J_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][PREV_MONTH_J_CNT])?></td>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00105"] //입금확인(건)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY2_O_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY1_O_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY_O_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][WEEK_O_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][MONTH_O_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][PREV_MONTH_O_CNT])?></td>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00106"] //배송준비중(건)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY2_A_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY1_A_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY_A_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][WEEK_A_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][MONTH_A_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][PREV_MONTH_A_CNT])?></td>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00107"] //배송중(건)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY2_B_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY1_B_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY_B_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][WEEK_B_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][MONTH_B_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][PREV_MONTH_B_CNT])?></td>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00108"] //배송완료(건)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY2_D_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY1_D_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY_D_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][WEEK_D_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][MONTH_D_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][PREV_MONTH_D_CNT])?></td>
								</tr>

								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00110"] //취소/환불/반품(건)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY2_C_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY1_C_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList[0][DAY_C_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][WEEK_C_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][MONTH_C_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList[0][PREV_MONTH_C_CNT])?></td>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00111"] //상품후기(건)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[0][DAY2_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[0][DAY1_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList2[0][DAY_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[0][WEEK_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[0][MONTH_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[0][PREV_MONTH_CNT])?></td>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00112"] //상품문의(건)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[1][DAY2_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[1][DAY1_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList2[1][DAY_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[1][WEEK_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[1][MONTH_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[1][PREV_MONTH_CNT])?></td>
								</tr>
								<? if ( $a_admin_type != "S" ) : ?>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00113"] //1:1문의(건)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[2][DAY2_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[2][DAY1_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList2[2][DAY_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[2][WEEK_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[2][MONTH_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[2][PREV_MONTH_CNT])?></td>
								</tr>
								<tr>
									<td class="title"><?=$LNG_TRANS_CHAR["EW00114"] //회원가입(명)?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[3][DAY2_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[3][DAY1_CNT])?></td>
									<td><strong><?=NUMBER_FORMAT($aryMainStaticsList2[3][DAY_CNT])?></strong></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[3][WEEK_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[3][MONTH_CNT])?></td>
									<td><?=NUMBER_FORMAT($aryMainStaticsList2[3][PREV_MONTH_CNT])?></td>
								</tr>
								<? endif; ?>
							</table>
						</div>
					<!-- 매출현황 요약 -->