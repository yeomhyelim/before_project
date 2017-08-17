	<div class="prodComparisonBox">
		<div class="titWrap">
			<h2><?= $LNG_TRANS_CHAR["PW00085"]; // 비교하기 ?></h2>
			<a href="javascript:goPopClose()" class="btnClose">닫기</a>
		</div>

		<!--<div class="prodInfoTxt">전체 <strong><span id="prodComparesTotal"><?=$intProdCompareCookieCnt; + 1?></span>/4</strong> 개의 제품을 비교합니다.</div>-->
		<div class="prodInfoTxt"><?=callLangTrans($LNG_TRANS_CHAR["PS00035"],array( $intProdCompareCookieCnt + 1 )); ?></div>

		<div class="prodBoxWrap">
			<div class="titBox tit1Wrap">
				<div class="imgWrap">
					<!--<a href="javascript:goProdComparesRight()" class="btnPrev">이전</a>-->
				</div>
				<h3></h3>
				<div class="prodInfo">
					<ul>
						<li><?= $LNG_TRANS_CHAR["PW00028"]; //원산지 ?></li>
						<li><?= $LNG_TRANS_CHAR["CW00064"]; //카테고리 ?></li>
						<li><?= $LNG_TRANS_CHAR["PW00081"]; //가격 ?></li>
						<li><?= $LNG_TRANS_CHAR["PW00090"]; //최소구매수량 ?></li>
						<li>Paking</li>
						<li>CAS No</li>
					</ul>
				</div>
				<div class="prodInfo">
					<ul>
						<li><?= $LNG_TRANS_CHAR["PW00082"]; //업체명 ?></li>
						<li>TYPE</li>
						<li><?= $LNG_TRANS_CHAR["OW00040"]; //국가 ?></li>
						<li><?= $LNG_TRANS_CHAR["PW00083"]; //등급 ?></li>
					</ul>
				</div>
			</div>
			<div id="prodChoiseListBox" class="titBox "  style="width:732px;height:522px;overflow:hidden;">
				<div id="prodChoiseList" style="width:2196px;left:">
<?
	$prodCompareListRow = array();
	while ( $_prodCompareListRow = mysql_fetch_array($prodCompareListResult) )
	{
		array_push($prodCompareListRow, $_prodCompareListRow);
	}
	$intProdCnt=0;
	foreach ($prodCompareListRow as $prodCompareListKey => $prodCompareListValue)
	{
		$strProdCate = substr($prodCompareListValue['P_CATE'],0,3);
		if ($strProdCate){
			$cateMgr->setC_CODE($strProdCate);

			$strstrProdCateName1 = $cateMgr->getCateLevelName($db);
		}

		//$strP_NAME			= $prodCompareListValue['P_NAME'];
		$strP_NAME			= $prodCompareListValue['P_NAME_LNG'];
		$strP_CODE			= $prodCompareListValue['P_CODE'];
		$strP_STOCK_LIMIT	= $prodCompareListValue['P_STOCK_LIMIT'];
		$strP_STOCK_OUT		= $prodCompareListValue['P_STOCK_OUT'];
		$strP_EVENT			= $prodCompareListValue['P_EVENT'];
		$strPM_REAL_NAME	= $prodCompareListValue['PM_REAL_NAME'];
		$strP_PRICE_UNIT	= $prodCompareListValue['P_PRICE_UNIT'];
		$strP_OPT			= $prodCompareListValue['P_OPT'];
		$strP_ORIGIN		= $prodCompareListValue['P_ORIGIN'];
		$strP_SAIL_UNIT		= $prodCompareListValue['P_SAIL_UNIT'];
		$strP_PRICE_FILTER = $prodCompareListValue['P_PRICE_FILTER'];

		if(!$g_member_no)
		{
			$loginCheck = "javascript:goInquiryloginCheck();";//"javascript:parent.loginCheck();";
		}
		else
		{
			$loginCheck = "javascript:parent.popProdInquiry({$strP_CODE});";
		}

		/* 상품 옵션 */
		$productMgr->setP_CODE($strP_CODE);
		$productMgr->setPO_TYPE("O");
		$aryProdOpt = $productMgr->getProdOpt($db);

		if (is_array($aryProdOpt)){
			for($i=0;$i<sizeof($aryProdOpt);$i++){
				if ($aryProdOpt[$i][PO_NO] > 0){
					$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

					/* 다중가격사용안함.다중가격분리형 */
					$aryProdOpt[$i]["OPT_ATTR1"] = $productMgr->getProdOptAttrGroup($db);

					/* 다중각격분리형 */
					$aryProdOpt[$i]["OPT_ATTR_ALL"] = $productMgr->getProdOptAttr($db);
				}
			}
		}

		if ($strP_OPT == "1" || $strP_OPT == "3"){
			/* 다중가격사용안함 */

			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					$intProdOptAttrCnt = sizeof($aryProdOpt[$i][OPT_ATTR]);
					for($kk=1;$kk<=10;$kk++){
						if ($aryProdOpt[$i]["PO_NAME".$kk]){
							if ($aryProdOpt[$i]["OPT_ATTR".$kk]){
								## 품절표시
								$strProdOptAttrSoldOut = ($strP_STOCK_LIMIT != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
								if (($strP_STOCK_OUT == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($strP_STOCK_LIMIT != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
							} //->if

							$strPO_NO = 'cartOpt'.$kk.'_'.$aryProdOpt[$i][PO_NO];
							$strPOA_ATTR1 = $aryProdOpt[$i]["OPT_ATTR".$kk][0][POA_ATTR1];
							$strSort = $kk;
						} //->if
					} //->for
				} //->for

				$strProdOpt = "<span class=\"w_20\">";
				$strProdOpt .= $aryProdOpt[0]["PO_NAME1"];
				$strProdOpt .= " </span>";
				//echo sizeof($aryProdOpt[0]["OPT_ATTR1"]);
				for($i=0;$i < sizeof($aryProdOpt[0]["OPT_ATTR1"]);$i++){
					$strProdOpt .= $aryProdOpt[0]["OPT_ATTR1"][$i][POA_ATTR1]." "; //리스트 옵션 표시
				} //->for

			} //->if

		} else if ($strP_OPT == "2") {
			/* 다중가격일체형 */

			if (is_array($aryProdOpt)){

				for($i=0;$i<sizeof($aryProdOpt);$i++){
					if (is_array($aryProdOpt[$i][OPT_ATTR_ALL])){

						$strProdOptAttr = "";
						for($kk=1;$kk<=10;$kk++){
							if ($aryProdOpt[$i]["PO_NAME".$kk]){
								$strProdOptAttr .= "/".$aryProdOpt[$i][OPT_ATTR_ALL][0]["POA_ATTR".$kk];
							}
						}

						$strProdOptAttr = SUBSTR($strProdOptAttr,1);

						## 품절표시
						$strProdOptAttrSoldOut = ($strP_STOCK_LIMIT != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
						if (($strP_STOCK_OUT == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($strP_STOCK_LIMIT != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

						$strPO_NO = 'cartOpt1_'.$aryProdOpt[$i][PO_NO];
						$strPOA_ATTR1 = $aryProdOpt[$i][OPT_ATTR_ALL][0][POA_NO];
						$strSort = $kk;



						for($j=0;$j<sizeof($aryProdOpt[$i][OPT_ATTR_ALL]);$j++)
						{

							$strProdOptAttr = "";
							for($kk=1;$kk<=10;$kk++){
								if ($aryProdOpt[$i]["PO_NAME".$kk]){
									$strProdOptAttr .= "/".$aryProdOpt[$i][OPT_ATTR_ALL][$j]["POA_ATTR".$kk];
								}
							}

							$strProdOptAttr = SUBSTR($strProdOptAttr,1);

							## 품절표시
							$strProdOptAttrSoldOut = ($strP_STOCK_LIMIT != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'].")" : "";
							if (($strP_STOCK_OUT == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'] == 0 && ($strP_STOCK_LIMIT != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

							$strProdOpt = $strProdOptAttr.$strProdOptAttrSoldOut; //리스트 옵션 표시
						}
					}
				}
			}
		}

		if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y")
		{
			//<input type="hidden" name="cartOptNo[]" value="0">
			//<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="
			if ($strP_EVENT > 0 && getProdEventInfo($prodCompareListRow[$prodCompareListKey]) == "Y")
			{
				$strCartOptPrice = getCurToPrice($prodCompareListRow[$prodCompareListKey]['P_SALE_PRICE'],"US");
			}else{
				$strCartOptPrice = getProdDiscountPrice($prodCompareListRow[$prodCompareListKey],"1",0,"US");
			}


			//<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="
			if ($strP_EVENT > 0 && getProdEventInfo($prodCompareListRow[$prodCompareListKey]) == "Y")
			{
				$strCartOptOrgPrice = getCurToPrice($prodCompareListRow[$prodCompareListKey]['P_SALE_PRICE']);
			}else{
				$strCartOptOrgPrice = getProdDiscountPrice($prodCompareListRow[$prodCompareListKey]);
			}
		}
		else
		{
			if ($strP_EVENT > 0 && getProdEventInfo($prodCompareListRow[$prodCompareListKey]) == "Y")
			{
				$strCartOptPrice = getCurToPrice($prodCompareListRow[$prodCompareListKey]['P_SALE_PRICE']);
			}else{
				$strCartOptPrice = getProdDiscountPrice($prodCompareListRow[$prodCompareListKey]);
			}

			$strCartOptOrgPrice = '0';
		}

		/* 상품 추가 옵션*/
		if ($prodCompareListValue[P_ADD_OPT] == "Y"){
			$productMgr->setPO_TYPE("A");
			$aryProdAddOpt = $productMgr->getProdOpt($db);
			if (is_array($aryProdAddOpt)){
				for($i=0;$i<sizeof($aryProdAddOpt);$i++){
					if ($aryProdAddOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

						$aryProdAddOpt[$i][OPT_ATTR] = $productMgr->getProdAddOpt($db);
					}
				}
			}
		}
		## 상품 가격 설정
		$strTextPriceUsd = "";

		// 통화 구분. 남덕희
		$strTextPriceUnit = getCurMarkFilter($strP_PRICE_FILTER, $S_SITE_LNG);
		$strTextPrice = '<strong>' .$strTextPriceUnit. getCurToPriceFilter($prodCompareListRow[$prodCompareListKey]['P_SALE_PRICE'],'','',$strP_PRICE_FILTER) . '</strong>';


		//if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextPriceUsd = getCurMark("$") . getProdDiscountPrice($prodCompareListRow[$prodCompareListKey],"1",0,"US") . getCurMark2("USD"); }
		if($strP_PRICE_TEXT) { $strTextPrice = $strP_PRICE_TEXT; }

?>
						<div class="prodBox" style="">
							<div class="imgWrap"><img src="<?php echo $strPM_REAL_NAME;?>" class="listProdImg" /></div>
							<h3><?=$strP_NAME?></h3>
							<div class="prodInfoBox">
								<div class="prodInfo">
									<ul>
										<li> <?=$aryCountryList[$strP_ORIGIN]?></li>
										<li> <?=$strstrProdCateName1?></li>
										<li>
										<?
										if($strTextPriceUsd) {
											echo $strTextPrice; // 가격
											echo ' / ';
											echo $strTextPriceUsd; // USD 달러
										}
										else {
											echo $strTextPrice;// 가격
										}
										if($strP_PRICE_UNIT){
											echo '(1';
											echo $strP_PRICE_UNIT;
											echo ') 당';
										}?>
										</li>
										<li> <?=$prodCompareListValue['P_MIN_QTY']?> <?=$strP_SAIL_UNIT?></li>
										<li> <?=$strProdOpt?></li>
										<li> <?=$prodCompareListValue['P_CAS_NO']?></li>
									</ul>
								</div>
								<div class="prodInfo">
									<ul>
										<li> <?=$prodCompareListValue['SH_COM_NAME']?></li>
										<li> <?=$aryType[$prodCompareListValue['SH_COM_CATEGORY']]?></li>
										<li> <?=$aryCountryList[$prodCompareListValue['SH_COM_COUNTRY']]?></li>
										<li class="shopIco">
											<img src="<?=$aryCreditGradeImg[$prodCompareListValue['SH_COM_CREDIT_GRADE']]?>">
											<img src="<?=$arySaleGradeImg[$prodCompareListValue['SH_COM_SALE_GRADE']]?>">
											<img src="<?=$aryLocusGradeImg[$prodCompareListValue['SH_COM_LOCUS_GRADE']]?>">
										</li>
									</ul>
									<div class="btnWrap">
										<a href="<?=$loginCheck;?>" class="btnQna"><?= $LNG_TRANS_CHAR["PW00108"]; //문의하기 ?></a>
										<a href="javascript:parent.goProdView('<?=$strP_CODE?>');" class="btnOrder"><?= $LNG_TRANS_CHAR["PW00021"]; //구매하기 ?></a>
									</div>
								</div>
							</div>
						</div>
<?
$intProdCnt++;
		}
		if($intProdCnt < 4){
			echo '===';
			for($intAddCol = $intProdCnt; $intAddCol < 5; $intAddCol++){
				echo $intAddCol;
				?>
					<div class="prodBox" style="">
						<div class="imgWrap"> </div>
						<h3></h3>
						<div class="prodInfoBox">
							<div class="prodInfo">
								<ul>
									<li></li>
									<li></li>
									<li></li>
									<li></li>
									<li></li>
									<li></li>
								</ul>
							</div>
							<div class="prodInfo">
								<ul>
									<li></li>
									<li></li>
									<li></li>
									<li class="shopIco"></li>
								</ul>
								<div class="btnWrap">
								</div>
							</div>
						</div>
					</div>
<?
			}
		}
?>
				</div>
			</div>
			<div class="titBox">
				<div class="imgWrap">
					<!--<a href="javascript:goProdComparesLeft();" class="btnNext">다음</a>-->
				</div>
				<h3></h3>
				<div class="prodInfo">

				</div>
				<div class="prodInfo">

				</div>
			</div>
			<div class="clr"></div>
		</div>
	</div>

	<script type="text/javascript">
//<![CDATA[
	//var prodCompareCnt = <?=$intProdCompareCnt;?>;
	function goProdComparesLeft()
	{
			var obj = $("#prodChoiseList").position().left;
			leftLength  = parseInt(obj -844);

			if(leftLength < parseInt(-1464))
			{
				//alert("마지막페이지입니다.");
				//$("#prodChoiseList").css({"left": leftLength });
				//$("#prodChoiseList").css({"left": "844" })
			}
			else
			{
				$("#prodChoiseList").css({"left": leftLength });
				//$("#prodChoiseList").css({"left": "844" })
				//document.getElementById("prodChoiseList").style.left=leftLength;
			}
	}
	function goProdComparesRight()
	{
			var obj = $("#prodChoiseList").position().left;
			leftLength  = parseInt(obj +620);//112

			if(leftLength > 0)
			{
				//alert("첫페이지입니다.");
				//$("#prodChoiseList").css({"left": leftLength });
				//$("#prodChoiseList").css({"left": leftLength });
				//$("#prodChoiseList").css({"left": "844" })
			}
			else
			{
				$("#prodChoiseList").css({"left": leftLength });
			}
	}
	// 팝업 닫고 다시 로드
	function goPopClose()
	{
		C_DelCookie("prodCompare");
		parent.$(".listTypeTable .comppareIcon").attr({'src':'/upload/images/ico_list_chk1.png'});
		parent.$(".thumbTable .comppareIcon").attr({'src':'/upload/images/ico_list_chk2.png'});
		parent.$("#prodCompare").val('');
		parent.$(".chkInfoBox").remove();
		parent.goLayoutPopCloseEvent();
		//self.close();
	}

	function goInquiryloginCheck(){
		parent.goLayoutPopCloseEvent();
		parent.loginCheck();
	}

	//]]>
	</script>