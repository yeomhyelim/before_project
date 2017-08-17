<?
								/* 주문후 사용기간 데이터 INSERT */
								if ($S_FIX_ORDER_APPR_PERIOD_USE == "Y"){
									
									$param						= "";
									$param['o_no']				= $intO_NO;

									$intOrderPeriodCnt			= $orderMgr->getOrderPeriodCount($db,$param);

									if ($intOrderPeriodCnt == 0)
									{
										$orderMgr->setO_NO($intO_NO);

										$orderProdCartRow			= $orderMgr->getOrderPeriodCartList($db,$param);
										$strOrderProdCode			= $orderProdCartRow['P_CODE'];
										### ORDER_PERID INSERT
										$param					= "";
										$param['O_NO']			= $intO_NO;
										$param['P_CODE']		= $strOrderProdCode;
										$param['OP_CODE']		= $strOrderPeriodApprNo; /** 2015.02.19 kim hee sung, 사용하는 부분이 없는것 같습니다. **/
										$param['OP_REG_NO']		= ($a_admin_no) ? $a_admin_no : $g_member_no;
										$orderMgr->getOrderPeriodInsert($db,$param);
										
										### ORDER_AUIDT INSERT(발행코드)
										if (SUBSTR($orderProdCartRow['P_CATE'],0,3) != "001")
										{
											
											/* 구매수량만큼 생성 */
											for($i=1;$i<=$orderProdCartRow['OC_QTY'];$i++){
												$strOrderAuditApprNo		= STRTOUPPER(getCode(10));
												
												$param						= "";
												$param['O_NO']				= $intO_NO;
												$param['P_CODE']			= $strOrderProdCode;
												$param['OA_CODE']			= $strOrderAuditApprNo;
												$intDupOrderAuditNoCnt		= $orderMgr->getOrderAuditDupCode($db,$param);
												
												if ($intDupOrderAuditNoCnt > 0){
													$strFlag = false;

													while($strFlag == false){
														
														$strOrderAuditApprNo		= STRTOUPPER(getCode(10));
														
														$param						= "";
														$param['O_NO']				= $intO_NO;
														$param['P_CODE']			= $strOrderProdCode;
														$param['OA_CODE']			= $strOrderAuditApprNo;

														$intDupOrderAuditNoCnt		= $orderMgr->getOrderAuditDupCode($db,$param);
														
														if($intDupOrderAuditNoCnt == 0){
															$strFlag = true;
															break;
														}
													}			
												}

												$orderMgr->getOrderAuditInsert($db,$param);
											}
											
										}
									}

								}
?>