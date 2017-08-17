<?

	# 상품 스킨 PL0001

	## 네비게시션 설정
	$naviTitle = "";
	if($strSearchHCodeName1) {
		if($naviTitle) { $naviTitle = "{$naviTitle} > "; }
		$naviTitle = "{$strSearchHCodeName1}";
	}
	if($strSearchHCodeName2) {
		if($naviTitle) { $naviTitle = "{$naviTitle} > "; }
		$naviTitle = "{$strSearchHCodeName2}";
	}
	if($strSearchHCodeName3) {
		if($naviTitle) { $naviTitle = "{$naviTitle} > "; }
		$naviTitle = "{$strSearchHCodeName3}";
	}
	if($strSearchHCodeName4) {
		if($naviTitle) { $naviTitle = "{$naviTitle} > "; }
		$naviTitle = "{$strSearchHCodeName4}";
	}

	## 정렬 설정
	## 2015.01.20 kim hee sung 등록일 추가, 및 제조사 주석처리.
	$strSort = $_GET['sort'];

	$sortArr = array
	(
		//'M'	=> $LNG_TRANS_CHAR["PW00026"] , //제조사
		'N'	=> $LNG_TRANS_CHAR["OW00058"] , //상품명
		'R'	=> $LNG_TRANS_CHAR["PW00004"] , //판매가격
		'T'	=> $LNG_TRANS_CHAR["PW00078"] , //등록일
//		'P'	=> $LNG_TRANS_CHAR["PW00008"] , //적립금
//		'S'	=> $LNG_TRANS_CHAR["PW00079"]   //인기순
	) ;

	## 2015.03.04 kim hee sung 정렬 출력방식 옵션으로 변경
	if($S_PROUDCT_ORDER_LIST):
		foreach($S_PROUDCT_ORDER_LIST as $key):
			if($key == 'P')			$sortArr['P'] =  $LNG_TRANS_CHAR["PW00008"];  //적립금
			else if($key == 'S')	$sortArr['P'] =  $LNG_TRANS_CHAR["PW00079"];  //인기순
		endforeach;
	endif;

?>

<script type="text/javascript">
	<!--
	$(function() {
		$('#popComGradeAllBox').on('click', function() {
			var gradeAllView = $('#popComGradeAllView');
			if(gradeAllView.css('display') == 'none') {
				gradeAllView.css('display', 'block');
			} else {
				gradeAllView.css('display', 'none');
			}
		});
	});
//-->
</script>

<style>
	.prodNewListWrapA .listProdImg{width:<?=$intWSize?>px;height:<?=$intHSize?>px;}
	.prodNewListWrapA .title{color:<?=$strColor1?>;}
	.prodNewListWrapA .comment{color:<?=$strColor2?>;}
	.prodNewListWrapA .pricePoint{color:<?=$strColor3?>;}
	.prodNewListWrapA .priceConsumer{color:<?=$strColor4?>}
	.prodNewListWrapA .priceSale{color:<?=$strColor5?>;}

	div.productInfoWrap{margin-bottom:20px;text-align:<?=$strWAlign?>}
	div.productInfoWrap ul{margin-top:5px;}
	div.productInfoWrap ul li{padding: 2px 0;}
	div.productInfoWrap ul li img{vertical-align:middle;margin-top:-1px;margin-right:3px;}
	div#infscr-loading {width:100px; margin:0 auto; text-align:center;}
</style>

<div id="divSelectOpt">
<input type="hidden" name="cartOptNo[]" value="0">
<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="0">
<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="0">
<input type="hidden" id="0_cartQty" name="0_cartQty" value="0">
</div>
<div class="prodTopArea">
	<h2><?php echo ($strSearchKey) ? $strSearchKey." ".$LNG_TRANS_CHAR["CW00089"] : $naviTitle;?></h2>
	<div class="locationWrap">
		<ul>
			<li class="home">H</li>
			<li><a href="./?menuType=product&mode=list&lcate=<?=$strSearchHCode1?>&mcate=&scate="><?php echo $strSearchHCodeName1;?></a></li>
			<li><a href="./?menuType=product&mode=list&lcate=<?=$strSearchHCode1?>&mcate=<?=$strSearchHCode2?>&scate="><?php echo $strSearchHCodeName2;?></a></li>
			<li class="end"><a href="./?menuType=product&mode=list&lcate=<?=$strSearchHCode1?>&mcate=<?=$strSearchHCode2?>&scate=<?=$strSearchHCode3?>"><?php echo $strSearchHCodeName3;?></a><?//=$strP_NAME?></li>
		</ul>
	</div>
	<div class="clr"></div>
</div>
<?
		if($strMode == "search" ){
	?>
	<!--div class="wikiWrap">
		<h2>“<span>파이오렌-B</span>” 위키백과</h2>
		<div class="wiki">
			글라이신은 HO₂CCH₂NH₂의 화학식을 갖는 유기물이다. 글라이신은 20개의 기본 아미노산 중의 하나로 동물 단백질에서 흔히 발견된다.
			글라이신의 3자 부호는 Gly이며, 1자 부호는 G이며, GGU, GGC, GGA, GGG의 코돈으로 암호화된다. 글라이신의 측쇄는 수소이며, 이는 모든 아미노산
			중에서 가장 작고 기본적이다.
		</div>
	</div-->

	<div class="comProdInfoTableWrap">
		<!-- <div class="comProdCntWrap">총 <span><?php echo (!$intProdCountTotal) ? 0 : number_format($intProdCountTotal);?></span>개의 검색결과가 나왔습니다.</div> -->
		<div class="comProdCntWrap"><?=callLangTrans($LNG_TRANS_CHAR["MS00156"],array((!$intProdCountTotal) ? 0 : number_format($intProdCountTotal))); ?></div>
		<div class="comProdInfoTable">
			<?
				for($i =0; $i<sizeof($aryCategorys);$i++)
				{
			?>
			<div class="prodCntWrap">
				<ul class="prodCnt">
					<li><?=$aryCategorys[$i][CATE_NAME];?></li>
					<li>
					<span><?
						if($aryProdCount[$aryCategorys[$i][CATE_CODE]])
						{
							echo $aryProdCount[$aryCategorys[$i][CATE_CODE]];
						}
						else
						{
							echo '0';
						}
					?></span><?= $LNG_TRANS_CHAR["PW00020"] //개 ?>
					</li>
				</ul>
			</div>
			<?
				}
			?>
			<div class="clr"></div>
		</div>
		<!--
		<table class="comProdInfoTable">
			<tr>
				<?
				for($i =0; $i<sizeof($aryCategorys);$i++){
				?>
				<td class="prodCnt">
				<?
					if($aryProdCount[$aryCategorys[$i][CATE_CODE]]){
						echo $aryProdCount[$aryCategorys[$i][CATE_CODE]];
					}else{
						echo '0';
					}
				?>
				</td>
				<?}?>
			</tr>
			<tr>
				<?
				for($i =0; $i<sizeof($aryCategorys);$i++){
				?>
				<td><?=$aryCategorys[$i][CATE_NAME];?></td>
				<?}?>
			</tr>
		</table>
		-->
	</div>
	<?}?>
	<!-- 정렬 -->

	<div class="listTopSortWrap">
		<?include "sortProdBox.inc.php";?>
		<div class="sortListBtn">
			<? foreach ( $sortArr as $sortKey => $sortVal ) : ?>
			<?
				$onClass = 'product_order' ;
				if ( strpos ( $strSort , $sortKey ) !== false ) // 현재 정렬기준이면
				{
					$onClass = 'product_order_on poa' ;
					if ( substr ( $strSort , -1 ) == 'D' )		// 내림차순이면
						$onClass = 'product_order_on pod' ;
				}

			?>
				<span class="txt">
					<a href="javascript:void(0);" data-order="<?=$sortKey?>" class="<?=$onClass?>"><?=$sortVal?></a>
				</span>
			<? endforeach ; ?>
		</div>
		<!-- <div class="cntProd">총 <strong><?php echo $intTotal;?></strong> 개</div> -->
		<div class="cntProd"><?=callLangTrans($LNG_TRANS_CHAR["MS00157"],array($intTotal)); ?> </div>
		<div class="clr"></div>
	</div>

	<div class="prodListSearchWrap">
		<div class="searchIn"><input type="text" name="searchSubKey" placeholder="<?=($strSearchSubKey) ? $strSearchSubKey : $LNG_TRANS_CHAR["CW00090"];?>" value=""><a href="javascript:goDetailSearch();" class="btnSearch">검색</a></div>
		<div class="listSelectWrap">
			<div class="productAllView">
				<a href="#" class="popComGradeAllBox" id="popComGradeAllBox"><?= $LNG_TRANS_CHAR["CW00112"]; //업체등급심사 안내 ?><span class="listOff"></span></a>
				<div id="popComGradeAllView" class="popComGradeAllView" style="display:none;">
					<div class="popComGradeAll">
						<div class="gradeBox">
							<h3><?= $LNG_TRANS_CHAR["CW00113"]; //판매등급 ?></h3>
							<ul>
								<li><img src="<?=$aryCreditGradeImg["G"]?>"><span><?= $LNG_TRANS_CHAR["CW00095"]; //골드등급 ?></span></li>
								<li><img src="<?=$aryCreditGradeImg["S"]?>"><span><?= $LNG_TRANS_CHAR["CW00096"]; //실버등급 ?></span></li>
								<li><img src="<?=$aryCreditGradeImg["B"]?>"><span><?= $LNG_TRANS_CHAR["CW00097"]; //일반등급 ?></span></li>
							</ul>
						</div>

						<div class="gradeBox">
							<h3><?= $LNG_TRANS_CHAR["CW00114"]; //신용등급 ?></h3>
							<ul>
								<li><img src="<?=$arySaleGradeImg["B"]?>"><span><?= $LNG_TRANS_CHAR["CW00098"]; //최우수등급 ?></span></li>
								<li><img src="<?=$arySaleGradeImg["E"]?>"><span><?= $LNG_TRANS_CHAR["CW00099"]; //우수등급 ?></span></li>
								<li><img src="<?=$arySaleGradeImg["G"]?>"><span><?= $LNG_TRANS_CHAR["CW00100"]; //일반등급 ?></span></li>
							</ul>
						</div>

						<div class="gradeBox lastBox">
							<h3><?= $LNG_TRANS_CHAR["CW00115"]; //현장확인 ?></h3>
							<ul>
								<li><img src="<?=$aryLocusGradeImg["Y"]?>"><span><?= $LNG_TRANS_CHAR["CW00101"]; //확인 ?></span></li>
								<li><img src="<?=$aryLocusGradeImg["N"]?>"><span><?= $LNG_TRANS_CHAR["CW00102"]; //미확인 ?></span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<select name="searchPageLine" onChange="document.form.submit();">
				<option value="20" <?php echo($strSearchPageLine == '20') ? "selected" : ""; ?>><?= callLangTrans($LNG_TRANS_CHAR["MS00158"],array(20)); ?></option>
				<option value="50" <?php echo($strSearchPageLine == '50') ? "selected" : ""; ?>><?= callLangTrans($LNG_TRANS_CHAR["MS00158"],array(50)); ?></option>
				<option value="100" <?php echo ($strSearchPageLine == '100') ? "selected" : ""; ?>><?= callLangTrans($LNG_TRANS_CHAR["MS00158"],array(100)); ?></option>
			</select>
			<a href="#" id="btnListView"><img src="/upload/images/ico_prod_list_1.gif"></a>
			<a href="#" id="btnTileView"><img src="/upload/images/ico_prod_list_2.gif"></a>
		</div>
		<div class="clr"></div>
	</div>

<!-- 정렬 -->
<?if($intTotal > 0){?>



<?	//2015. 04. 13 by.mk
	//Data setting * notice : important variable *

	/**
	 * notice
	 * - 차후 몇가지 문제점이 생길 여지가 있음.
	 * - 현재 방식은 단순히 div 를 show/hide 시키는 방식.
	 * - 예상되는 문제점으로는 뒤로가기 or 검색처리 등등..
	 * - 가장 좋은 방법은 GET 값을 가지고 product/include/prodList.index.inc.php 에서 분기를 태워 별도로 skin 적용을 하는 방안이 적절해 보임.
	 * - ex) prodList.PL0002.skin.html.php 랄지..
	 * - by.mk
	 */
	$row = array();
	while ( $_row = mysql_fetch_array($result) ) {
		array_push($row, $_row);
	}
?>

	<input type="hidden" name="cartOptNo[]" value="0">
	<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="<?if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($prodRow['P_SALE_PRICE'],"US")?><?}else{?><?=getProdDiscountPrice($prodRow,"1",0,"US")?><?}?>">
	<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($prodRow['P_SALE_PRICE'])?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?>">
	<input type="hidden" id="0_cartQty" name="0_cartQty" value="<?=$prodRow[P_MIN_QTY]?>" class="i_wCnt"/>
	<input type="hidden" id="prodCompare" name="prodCompare" value="<?=$strProdCompareCookie;?>">

<!-- Start to display list view. 2015.04.13 by.mk -->
<div class="prodNewListWrapB" style="display: block;">
	<table class="listTypeTable">
<!--start loop-->
<?
	foreach ($row as $key => $value) {
		## 기본 설정
		$strP_CODE			= $row[$key]['P_CODE'];
		$strP_NAME			= $row[$key]['P_NAME'];
		$intP_GRADE			= $row[$key]['P_GRADE'];
		$intP_GRADE_CNT		= $row[$key]['P_GRADE_CNT'];
		$strP_COLOR			= $row[$key]['P_COLOR'];
		$intP_SALE_PRICE	= $row[$key]['P_SALE_PRICE'];
		$intP_POINT			= $row[$key]['P_POINT'];
		$strP_POINT_TYPE	= $row[$key]['P_POINT_TYPE'];
		$strP_POINT_OFF1	= $row[$key]['P_POINT_OFF1'];
		$strP_POINT_OFF2	= $row[$key]['P_POINT_OFF2'];
		$strPM_REAL_NAME	= $row[$key]['PM_REAL_NAME'];
		$strPM_REAL_NAME2	= $row[$key]['PM_REAL_NAME2']; // 이미지2 (마우스 오버시 이미지)
		$strP_EVENT			= $row[$key]['P_EVENT'];
		$strP_LIST_ICON		= $row[$key]['P_LIST_ICON'];
		$strP_COLOR_IMG		= $row[$key]['P_COLOR_IMG'];
		$strP_BRAND_NAME	= $row[$key]['P_BRAND_NAME'];
		$strP_MODEL			= $row[$key]['P_MODEL'];
		$strP_ETC			= $row[$key]['P_ETC'];

		$strP_PRICE_FILTER	= $row[$key]['P_PRICE_FILTER'];
		$strP_PRICE_UNIT	= $row[$key]['P_PRICE_UNIT'];
		$strP_CAS_NO		= $row[$key]['P_CAS_NO'];
		$strP_OTHER_NAMES	= $row[$key]['P_OTHER_NAMES'];
		$strP_MIN_QTY		= $row[$key]['P_MIN_QTY'];
		$strP_ORIGIN		= $row[$key]['P_ORIGIN'];

		$intP_CONSUMER_PRICE = $row[$key]['P_CONSUMER_PRICE'];
		$strP_PRICE_TEXT	= $row[$key]['P_PRICE_TEXT'];
		$intP_QTY			= $row[$key]['P_QTY']; // 수량
		$strP_STOCK_OUT		= $row[$key]['P_STOCK_OUT']; // 품절여부
		$strP_RESTOCK		= $row[$key]['P_RESTOCK']; // 재입고여부
		$strP_STOCK_LIMIT	= $row[$key]['P_STOCK_LIMIT']; // 무제한상품
		$strP_BAESONG_TYPE = $row[$key]['P_BAESONG_TYPE']; // 배송타입
		$strP_MEMO			= $row[$key]['P_MEMO'];

		$strSH_COM_NAME			= $row[$key]['SH_COM_NAME'];
		$strSH_COM_CATEGORY		= $row[$key]['SH_COM_CATEGORY'];
		$strSH_COM_CREDIT_GRADE = $row[$key]['SH_COM_CREDIT_GRADE'];
		$strSH_COM_SALE_GRADE	= $row[$key]['SH_COM_SALE_GRADE'];
		$strSH_COM_LOCUS_GRADE	= $row[$key]['SH_COM_LOCUS_GRADE'];
		$strSH_COM_COUNTRY		= $row[$key]['SH_COM_COUNTRY'];
		$strP_CATE				= substr($row[$key]['P_CATE'],0,3);
		$strP_OPT				= $row[$key]['P_OPT'];
		$strP_MAX_QTY			= $row[$key]['P_MAX_QTY'];
		$strP_TYPE				= $row[$key]['P_TYPE'];
		$strP_SAIL_UNIT			= $row[$key]['P_SAIL_UNIT'];


		## 품절 여부 체크
		## 무제한 상품이 아니면서, 품절체크가 되었거나 상품 개수가 0일때 sold out
		$isSoldOut = false;
//						if($strP_STOCK_OUT == "Y" || ($intP_QTY <= 0 && $strP_STOCK_LIMIT == "Y")) { $isSoldOut = true; } 2014.07.28 kim hee sung 잘못된 공식
		if($strP_STOCK_LIMIT != "Y" && ($intP_QTY <= 0 || $strP_STOCK_OUT == "Y")) { $isSoldOut = true; }
		//PRINT_R($row[$key]);

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
								$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
								if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
							} //->if

							$strPO_NO = 'cartOpt'.$kk.'_'.$aryProdOpt[$i][PO_NO];
							$strPOA_ATTR1 = $aryProdOpt[$i]["OPT_ATTR".$kk][0][POA_ATTR1];
							$strSort = $kk;
						} //->if
					} //->for
				} //->for

				$strProdOpt = "<span class=\"w_20\">";
				$strProdOpt .= $aryProdOpt[0]["PO_NAME1"];
				$strProdOpt .= "</span>";
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
						$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
						if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

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
			if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
			{
				$strCartOptPrice = getCurToPrice($row[$key]['P_SALE_PRICE'],"US");
			}else{
				$strCartOptPrice = getProdDiscountPrice($row[$key],"1",0,"US");
			}


			//<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="
			if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
			{
				$strCartOptOrgPrice = getCurToPrice($row[$key]['P_SALE_PRICE']);
			}else{
				$strCartOptOrgPrice = getProdDiscountPrice($row[$key]);
			}
		}
		else
		{
			if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
			{
				$strCartOptPrice = getCurToPrice($row[$key]['P_SALE_PRICE']);
			}else{
				$strCartOptPrice = getProdDiscountPrice($row[$key]);
			}

			$strCartOptOrgPrice = '0';
		}



		/* 상품 추가 옵션*/
		if ($prodRow[P_ADD_OPT] == "Y"){
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

		## 재고 수량 표시
		$strP_QTY = "";
		if($S_IS_QTY_SHOW == "Y"):
			## 제고 수량 설정
			if($intP_QTY) { $strP_QTY = "<span>".$LNG_TRANS_CHAR["PW00080"]."</span>" . $intP_QTY; }
		endif;

		## 색상 설정
		$aryP_COLOR_IMG = "";
		if($strP_COLOR && $strShow6):
			$aryP_COLOR = explode("|", $strP_COLOR);
			foreach($aryP_COLOR as $key => $val):
				if($val != "Y") { continue; }
				if($S_ARY_PROD_COLOR[$key]['USE'] != "Y") { continue; }
				$aryP_COLOR_IMG[] = $S_ARY_PROD_COLOR[$key]['IMG'];
			endforeach;
		endif;

		## 적립금 설정
		$intProdPoint = getProdPoint($intP_SALE_PRICE, $intP_POINT, $strP_POINT_TYPE, $strP_POINT_OFF1, $strP_POINT_OFF2);
		$intProdPointMoney = 0;
		if($intProdPoint <= 0) { $strShow3 = ""; }
		if($strShow3 == "Y") { $intProdPointMoney = getCurToPrice($intProdPoint); }

		## 소비자가격 설정
		$strTextConsumerPrice = "";
		$strTextConsumerPriceUsd = "";
		if($intP_CONSUMER_PRICE > 0):
			$strTextConsumerPrice = getCurToPrice($intP_CONSUMER_PRICE);
			$strTextConsumerPrice = "{$strMoneyIconL}{$strTextConsumerPrice}{$strMoneyIconR}";
			if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextConsumerPriceUsd = getCurMark("USD") . getCurToPrice($intP_CONSUMER_PRICE, "US") . getCurMark2("USD"); }
		endif;

		## 상품 가격 설정
		$strTextPriceUsd = "";

		// 가격표시 변경.. 남덕희
		$strTextPrice = $strP_PRICE_FILTER;
		$strTextPrice .= ' ' .getCurMarkFilter($strP_PRICE_FILTER, $S_SITE_LNG). getCurToPriceFilter($row[$key]['P_SALE_PRICE'],'','',$strP_PRICE_FILTER);
		if($S_SITE_LNG == 'CN'){
			$strTextPrice .= ' (' .getCurMarkFilter($strP_PRICE_FILTER, 'US'). getCurToPriceFilter($row[$key]['P_SALE_PRICE'],'US','',$strP_PRICE_FILTER).')' ;
		}

/*
		if($strP_PRICE_FILTER=='FOB')
		{
			//$strTextPrice = getCurMark("$").getProdDiscountPrice($row[$key],"1",0,"US");
			//$strTextPrice = getCurMark("$") . number_format($row[$key][P_SALE_PRICE]);
			$strTextPrice =  number_format($row[$key][P_SALE_PRICE]);
			
			$strTextPrice = $strMoneyIconL . ' ' . $strTextPrice;
			//$strTextPrice .= '$';
		}else{
			$strTextPrice = getProdDiscountPrice($row[$key]);
			
			if($S_SITE_LNG == 'US'){
				$strTextPrice = $strMoneyIconL . ' ' . $strTextPrice;
			}else{
				$strTextPrice = $strMoneyIconL . $strTextPrice ;
			}
			
			$strTextPrice .= $strMoneyIconR;
		}
		
		if($S_SITE_LNG != 'KR' ){
			$strTextPrice = $strP_PRICE_FILTER . ' ' . $strTextPrice;
		}
		if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextPriceUsd = getCurMark("$") . getProdDiscountPrice($row[$key],"1",0,"US") . getCurMark2("USD"); }
		*/
		if($strP_PRICE_TEXT) { $strTextPrice = $strP_PRICE_TEXT; }

		## 이미지 설정
		if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/himg/product/A0001/no_img.gif"; }

		## 마우스 오버시 변경 이미지 설정
		$strOverImage = "";
		if($strTurnUse == "Y" && $strPM_REAL_NAME2):
			$strOverImage = " overImg='{$strPM_REAL_NAME2}'";
		endif;

		## 리스트 이미지를 동영상으로 보이게 하며 특정 카테고리에서만 동영상이 보이도록 처리
		$strProdMovieUrl = "";
		if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && !in_array(SUBSTR($row[$key]['P_CATE'],0,3),$S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST)):
			$productMgr->setP_CODE($strP_CODE);
			$productMgr->setPM_TYPE("movie1");
			$prodMovieRow = $productMgr->getProdImg($db);
			$strProdMovieUrl = $prodMovieRow[0]['PM_REAL_NAME'];
		endif;

		## 이벤트 정보
		$strEvent = "";
		if($strP_EVENT > 0 && getProdEventInfo($row[$key]) == "Y"):
			if($S_EVENT_INFO[$strP_EVENT]["PRICE_TYPE"] == "1"):
				$strEvent = $S_EVENT_INFO[$row[$key][P_EVENT]]["PRICE_MARK"];
			endif;
		endif;

		## 아이콘 설정
		$iconTag = "";
		$icon = explode("/", $strP_LIST_ICON);
		for($x=0; $x<sizeof($icon); $x++):
			$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
		endfor;

		## 상품명 설정
		$strP_NAME = strHanCutUtf2($strP_NAME, $intTitleMaxsize, "N");

		## 평점 설정
		if($intP_GRADE > 0 && $intP_GRADE_CNT > 0){
			$intGrade = $intP_GRADE / $intP_GRADE_CNT;
		}else{
			$intGrade = 0;
		}

		## td style 설정
		$strStyleTD = "";
		if($j==($intWList-1)) { $strStyleTD = "width:{$intWSize}px"; }

		## div class 설정
		$strClassDiv = "productInfoWrap";
		if($j==($intWList-1)) { $strClassDiv .= " endProdList"; }

		## div style 설정
		$strStyleDiv = "width:{$intWSize}px;text-align:{$strWAlign}";

		if($_SERVER['HTTP_HOST'] == "ausieshop.eumshop.co.kr"):
			$strShow9 = "Y";
			$strShow10 = "Y";
		endif;

		## 판매가 할인율
		$intProdDiscountRate	= 0;
		if ($S_FIX_PRODUCT_DISCOUNT_RATE_SHOW == "Y"){
			if($row[$key]['P_CONSUMER_PRICE'] > 0.00001){
			$intProdDiscountRate= getRoundUp((($row[$key]['P_CONSUMER_PRICE'] - $row[$key]['P_SALE_PRICE'])/$row[$key]['P_CONSUMER_PRICE']) * 100,0);
			$strProdDiscountRateText = "<strong class='discountRate'>".$intProdDiscountRate."</strong><span class='rateSign'>%</span>";
			}
		}

		## 무료배송아이콘표시
		$strProdFreeDeliveryText = "";
		if ($S_FIX_PRODUCT_FREE_DELIVERY_SHOW == "Y"){
			if ($strP_BAESONG_TYPE == "2"){
				$strProdFreeDeliveryText = "무료배송";
			}
		}

		## 품절 여부 체크
		## 무제한 상품이 아니면서, 품절체크가 되었거나 상품 개수가 0일때 sold out
		$isSoldOut = false;
//		if($strP_STOCK_OUT == "Y" || ($intP_QTY <= 0 && $strP_STOCK_LIMIT == "Y")) { $isSoldOut = true; } 2014.07.28 kim hee sung 잘못된 공식
		if($strP_STOCK_LIMIT != "Y" && ($intP_QTY <= 0 || $strP_STOCK_OUT == "Y")) { $isSoldOut = true; }

		## 2015.02.09 kim hee sung
		## 상품가격 출력 설정
		##  관리자페이지 > 기본설정 > 주문및결제관리 > 상품가격노출 사용시 해당 그룹 회원에게만 가격 노출합니다.
		if($isPriceHide):
			$strProdDiscountRateText = '';
			$strTextPrice = '';
			$intProdPointMoney = '';
			$strTextConsumerPrice = '';
			$strTextConsumerPriceUsd = '';
		endif;

		//$strBold = '';
		$strCompareIcon = '/upload/images/ico_list_chk1.png';
		if(is_array($aryProdCompareCookie)){
			foreach($aryProdCompareCookie as $key => $val){
				if($val == $strP_CODE){
				 	//$strBold = 'bold';
					$strCompareIcon = '/upload/images/ico_list_chk3.png';
				}
			}
		}
?>

<?
	if ($strP_OPT == "1" || $strP_OPT == "3"){
		/* 다중가격사용안함 */

		if (is_array($aryProdOpt)){
			for($i=0;$i<sizeof($aryProdOpt);$i++){
				$intProdOptAttrCnt = sizeof($aryProdOpt[$i][OPT_ATTR]);
				for($kk=1;$kk<=10;$kk++){
					if ($aryProdOpt[$i]["PO_NAME".$kk]){
						if ($aryProdOpt[$i]["OPT_ATTR".$kk]){
							## 품절표시
							$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
							if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
						} //->if

						$strPO_NO = 'cartOpt'.$kk.'_'.$aryProdOpt[$i][PO_NO];
						$strPOA_ATTR1 = $aryProdOpt[$i]["OPT_ATTR".$kk][0][POA_ATTR1];
						$strSort = $kk;
					} //->if
				} //->for
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
					$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
					if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

					$strPO_NO = 'cartOpt1_'.$aryProdOpt[$i][PO_NO];
					$strPOA_ATTR1 = $aryProdOpt[$i][OPT_ATTR_ALL][0][POA_NO];
					$strSort = $kk;
				}
			}
		}
	}
?>
<!--input type="hidden" id="cartOpt1_<?=$aryProdOpt[$i][PO_NO]?>" name="cartOpt1_<?=$aryProdOpt[$i][PO_NO]?>" onchange="javascript:goSelectProdOpt('cartOpt1_<?=$aryProdOpt[$i][PO_NO]?>',<?=$kk?>);" value="<?=$aryProdOpt[$i][OPT_ATTR_ALL][0][POA_NO]?>"-->

		<tr id="prod<?php echo $strP_CODE;?>" class="prod<?=$strP_CODE?>">
			<td class="prodImgWrap">
				<div class="prodImgBox">
					<a href="javascript:goProdView('<?php echo $strP_CODE;?>');"><img src="<?php echo $strPM_REAL_NAME;?>" class="listProdImg"/></a>
					<!-- 품절 //-->
					<?php if($isSoldOut):?>
					<!--div class="soldout">Sold Out</div-->
					<div class="soldout"><img src="/upload/images/img_soldout.png" /></div>
					<?php endif;?>
					<!-- 품절 //-->
				</div>
				<div class="icoWrap">
					<?if($strP_PRICE_FILTER=='EXW'){?>
					<a href="javascript:goListWish('<?php echo $strP_CODE;?>','<?php echo $strP_STOCK_OUT;?>','<?php echo $intP_QTY;?>','<?php echo $strP_STOCK_LIMIT;?>','<?php echo $strCartOptPrice;?>','<?php echo $strCartOptOrgPrice;?>','<?php echo $strP_MIN_QTY;?>','<?=$strPO_NO?>',<?=$strSort?>,'<?=$strPOA_ATTR1?>','<?=$strP_OPT?>','<?=$strP_MAX_QTY?>');" alt="<?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?>" title="<?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?>">
						<img src="/upload/images/ico_list_star1.png"> <span class="ico_wish"><?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?></span></a>
					<?}else{?>
						<a href="javascript:alert('<?=$LNG_TRANS_CHAR["MS00163"]?>');" alt="<?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?>" title="<?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?>">
							<img src="/upload/images/ico_list_star1.png"> <span class="ico_wish"><?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?></span></a>
					<?}?>
					<a href="javascript:goProdCompare(<?php echo $strP_CODE;?>)" title="<?= $LNG_TRANS_CHAR["PW00085"]; //비교하기 ?>"><img src="<?=$strCompareIcon?>" alt="<?= $LNG_TRANS_CHAR["PW00085"]; //비교하기 ?>" class="comppareIcon"> <span class="ico_chk <?=$strBold?>"><?= $LNG_TRANS_CHAR["PW00085"]; //비교하기 ?></span></a>
				</div>
			</td>

			<td class="prodInfoWrap">
				<ul>
					<li class="tit"><a href="javascript:goProdView('<?php echo $strP_CODE;?>');"><?=$strP_NAME?></a></li>
				</ul>
				<ul class="prodInfo1">
					<li><span><?= $LNG_TRANS_CHAR["PW00028"]; //원산지 ?></span><span class=""><?php echo $aryCountryList[$strP_ORIGIN]?></span></li>
					<li><span><?= $LNG_TRANS_CHAR["CW00064"]; //카테고리 ?></span><span class=""><?php echo $aryCateNames[$strP_CATE]?></span></li>
				</ul>
				<ul class="addINfo">
					<li class="option"><span><?= $LNG_TRANS_CHAR["PW00081"]; //가격 ?></span><?
							if($strShow5 == "Y") {
								if($strTextPriceUsd) {
									echo $strTextPrice; // 가격
									echo ' / ';
									echo $strTextPriceUsd; // USD 달러
								}
								else {
									echo $strTextPrice;// 가격
								}
							}
							if($strP_PRICE_UNIT){
								//echo '(1';
								echo ' / ';
								echo $strP_PRICE_UNIT;
								//echo ') '.$LNG_TRANS_CHAR["PW00099"]; //당;
							}?>

					</li>
					<!--<li><span>CAS No.</span><?php echo $strP_CAS_NO?></li>-->
					<li><?php echo $strProdOpt;	?>
					</li>
					<li><span><?= $LNG_TRANS_CHAR["PW00090"]; //최소구매수량 ?></span><?php echo $strP_MIN_QTY?> <?=$strP_SAIL_UNIT;?></li>
				</ul>


			</td>
			<td class="shopInfoWrap">
				<div class="shopInfoWrap">
					<div class="shopInfo">
						<ul>
							<li><span><?= $LNG_TRANS_CHAR["PW00082"]; //업체명 ?></span> <strong><?=$strSH_COM_NAME?></strong></li>
							<li><span><?= $LNG_TRANS_CHAR["MW00021"]; //국가 ?></span> <strong><?=$aryCountryList[$strSH_COM_COUNTRY]?></strong></li>
							<li><span>TYPE</span> <strong><?=$aryType[$strP_TYPE]?><?/*업체의 TYPE =$aryType[$strSH_COM_CATEGORY]*/?></strong></li>
						</ul>
					</div>
					<div class="shopIcoWrap">
						<ul>
							<li>
								<span><?= $LNG_TRANS_CHAR["PW00083"]; //등급 ?></span>
								<strong>
									<img src="<?=$aryCreditGradeImg[$strSH_COM_CREDIT_GRADE];?>">
									<img src="<?=$arySaleGradeImg[$strSH_COM_SALE_GRADE];?>">
									<img src="<?=$aryLocusGradeImg[$strSH_COM_LOCUS_GRADE];?>">
								</strong>
							</li>
						</ul>
					</div>
				</div>
			</td>
		</tr>
<?
	}
?>
	</table>
</div>
<!-- End list view -->



<!-- Start to display tile view. -->
<div class="prodNewListWrapA" style="display: none;">
	<table class="thumbTable">
		<? for($i=0,$k=0;$i<$intHList;$i++){ ?>
		<tr>
			<? for($j=0;$j<$intWList;$j++){	?>
			<td<? if($j==($intWList-1)) { echo sprintf(" style='width:%dpx'", $intWSize); } ?>>
				<?
					$k++;
					$di = $k-1;

				   if($row[$di]){

						## 기본 설정
						$strP_CODE = $row[$di]['P_CODE'];
						$strP_NAME = $row[$di]['P_NAME'];
						$intP_GRADE = $row[$di]['P_GRADE'];
						$intP_GRADE_CNT = $row[$di]['P_GRADE_CNT'];
						$strP_COLOR = $row[$di]['P_COLOR'];
						$intP_SALE_PRICE = $row[$di]['P_SALE_PRICE'];
						$intP_POINT = $row[$di]['P_POINT'];
						$strP_POINT_TYPE = $row[$di]['P_POINT_TYPE'];
						$strP_POINT_OFF1 = $row[$di]['P_POINT_OFF1'];
						$strP_POINT_OFF2 = $row[$di]['P_POINT_OFF2'];
						$strPM_REAL_NAME = $row[$di]['PM_REAL_NAME'];
						$strPM_REAL_NAME2 = $row[$di]['PM_REAL_NAME2']; // 이미지2 (마우스 오버시 이미지)
						$strP_EVENT = $row[$di]['P_EVENT'];
						$strP_LIST_ICON = $row[$di]['P_LIST_ICON'];
						$strP_COLOR_IMG = $row[$di]['P_COLOR_IMG'];
						$strP_BRAND_NAME = $row[$di]['P_BRAND_NAME'];
						$strP_MODEL = $row[$di]['P_MODEL'];
						$strP_ETC = $row[$di]['P_ETC'];
						$intP_CONSUMER_PRICE = $row[$di]['P_CONSUMER_PRICE'];
						$strP_PRICE_TEXT = $row[$di]['P_PRICE_TEXT'];
						$intP_QTY = $row[$di]['P_QTY']; // 수량
						$strP_STOCK_OUT = $row[$di]['P_STOCK_OUT']; // 품절여부
						$strP_RESTOCK = $row[$di]['P_RESTOCK']; // 재입고여부
						$strP_STOCK_LIMIT = $row[$di]['P_STOCK_LIMIT']; // 무제한상품
						$strP_BAESONG_TYPE = $row[$di]['P_BAESONG_TYPE']; // 배송타입
						$strP_MEMO = $row[$di]['P_MEMO'];
						$strP_ORIGIN = $row[$di]['P_ORIGIN'];

						$strP_PRICE_FILTER = $row[$di]['P_PRICE_FILTER'];
						$strP_PRICE_UNIT = $row[$di]['P_PRICE_UNIT'];
						$strP_CAS_NO = $row[$di]['P_CAS_NO'];
						$strP_OTHER_NAMES = $row[$di]['P_OTHER_NAMES'];
						$strP_MIN_QTY = $row[$di]['P_MIN_QTY'];

						$intP_CONSUMER_PRICE = $row[$di]['P_CONSUMER_PRICE'];
						$strP_PRICE_TEXT = $row[$di]['P_PRICE_TEXT'];
						$intP_QTY = $row[$di]['P_QTY']; // 수량
						$strP_STOCK_OUT = $row[$di]['P_STOCK_OUT']; // 품절여부
						$strP_RESTOCK = $row[$di]['P_RESTOCK']; // 재입고여부
						$strP_STOCK_LIMIT = $row[$di]['P_STOCK_LIMIT']; // 무제한상품
						$strP_BAESONG_TYPE = $row[$di]['P_BAESONG_TYPE']; // 배송타입
						$strP_MEMO = $row[$di]['P_MEMO'];

						$strSH_COM_NAME			= $row[$di]['SH_COM_NAME'];
						$strSH_COM_CATEGORY		= $row[$di]['SH_COM_CATEGORY'];
						$strSH_COM_CREDIT_GRADE = $row[$di]['SH_COM_CREDIT_GRADE'];
						$strSH_COM_SALE_GRADE	= $row[$di]['SH_COM_SALE_GRADE'];
						$strSH_COM_LOCUS_GRADE	= $row[$di]['SH_COM_LOCUS_GRADE'];
						$strSH_COM_COUNTRY		= $row[$di]['SH_COM_COUNTRY'];
						$strP_CATE		= substr($row[$di]['P_CATE'],0,3);
						$strP_OPT				= $row[$di]['P_OPT'];
						$strP_MAX_QTY			= $row[$di]['P_MAX_QTY'];
						$strP_TYPE			= $row[$di]['P_TYPE'];
						$strP_SAIL_UNIT				= $row[$di]['P_SAIL_UNIT'];
						## 품절 여부 체크
						## 무제한 상품이 아니면서, 품절체크가 되었거나 상품 개수가 0일때 sold out
						$isSoldOut = false;
//						if($strP_STOCK_OUT == "Y" || ($intP_QTY <= 0 && $strP_STOCK_LIMIT == "Y")) { $isSoldOut = true; } 2014.07.28 kim hee sung 잘못된 공식
						if($strP_STOCK_LIMIT != "Y" && ($intP_QTY <= 0 || $strP_STOCK_OUT == "Y")) { $isSoldOut = true; }

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
												$strProdOptAttrSoldOut = ($row[$di]['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
												if (($row[$di]['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($row[$di]['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
											} //->if

											$strPO_NO = 'cartOpt'.$kk.'_'.$aryProdOpt[$i][PO_NO];
											$strPOA_ATTR1 = $aryProdOpt[$i]["OPT_ATTR".$kk][0][POA_ATTR1];
											$strSort = $kk;
										} //->if
									} //->for
								} //->for

								$strProdOpt = "<span class=\"w_20\">";
								$strProdOpt .= $aryProdOpt[0]["PO_NAME1"];
								$strProdOpt .= "</span>";
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
										$strProdOptAttrSoldOut = ($row[$di]['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
										if (($row[$di]['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($row[$di]['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

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
							if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
							{
								$strCartOptPrice = getCurToPrice($row[$key]['P_SALE_PRICE'],"US");
							}else{
								$strCartOptPrice = getProdDiscountPrice($row[$key],"1",0,"US");
							}


							//<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="
							if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
							{
								$strCartOptOrgPrice = getCurToPrice($row[$key]['P_SALE_PRICE']);
							}else{
								$strCartOptOrgPrice = getProdDiscountPrice($row[$key]);
							}
						}
						else
						{
							if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
							{
								$strCartOptPrice = getCurToPrice($row[$key]['P_SALE_PRICE']);
							}else{
								$strCartOptPrice = getProdDiscountPrice($row[$key]);
							}

							$strCartOptOrgPrice = '0';
						}

						## 재고 수량 표시
						$strP_QTY = "";
						if($S_IS_QTY_SHOW == "Y"):
							## 제고 수량 설정
							if($intP_QTY) { $strP_QTY = "<span>".$LNG_TRANS_CHAR["PW00080"]."</span>" . $intP_QTY; }
						endif;

						## 색상 설정
						$aryP_COLOR_IMG = "";
						if($strP_COLOR && $strShow6){
							$aryP_COLOR = explode("|", $strP_COLOR);
							foreach($aryP_COLOR as $key => $val){
								if($val != "Y") { continue; }
								if($S_ARY_PROD_COLOR[$key]['USE'] != "Y") { continue; }
								$aryP_COLOR_IMG[] = $S_ARY_PROD_COLOR[$key]['IMG'];
							}
						}

						## 적립금 설정
						$intProdPoint = getProdPoint($intP_SALE_PRICE, $intP_POINT, $strP_POINT_TYPE, $strP_POINT_OFF1, $strP_POINT_OFF2);
						$intProdPointMoney = 0;
						if($intProdPoint <= 0) { $strShow3 = ""; }
						if($strShow3 == "Y") { $intProdPointMoney = getCurToPrice($intProdPoint); }

						## 소비자가격 설정
						$strTextConsumerPrice = "";
						$strTextConsumerPriceUsd = "";
						if($intP_CONSUMER_PRICE > 0){
							$strTextConsumerPrice = getCurToPrice($intP_CONSUMER_PRICE);
							$strTextConsumerPrice = "{$strMoneyIconL}{$strTextConsumerPrice}{$strMoneyIconR}";
							if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextConsumerPriceUsd = getCurMark("USD") . getCurToPrice($intP_CONSUMER_PRICE, "US") . getCurMark2("USD"); }
						}

						## 상품 가격 설정
						$strTextPriceUsd = "";

						if($strP_PRICE_FILTER=='FOB')
						{
							//$strTextPrice = getCurMark("$") .'<strong>' . getProdDiscountPrice($row[$di],"1",0,"US") . '</strong>';
							$strTextPrice = getCurMark("$") .'<strong>' . number_format($row[$di][P_SALE_PRICE]) . '</strong>';
							$strTextPrice = $strMoneyIconL . $strTextPrice;
							//$strTextPrice .= '$';
						}
						else
						{
							$strTextPrice = '<strong>' . getProdDiscountPrice($row[$di]) . '</strong>';
							$strTextPrice = $strMoneyIconL . $strTextPrice;
							$strTextPrice .= $strMoneyIconR;
						}
						if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextPriceUsd = getCurMark("$") . getProdDiscountPrice($row[$di],"1",0,"US") . getCurMark2("USD"); }
						if($strP_PRICE_TEXT) { $strTextPrice = $strP_PRICE_TEXT; }

						## 이미지 설정
						if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/himg/product/A0001/no_img.gif"; }

						## 마우스 오버시 변경 이미지 설정
						$strOverImage = "";
						if($strTurnUse == "Y" && $strPM_REAL_NAME2){
							$strOverImage = " overImg='{$strPM_REAL_NAME2}'";
						}

						## 리스트 이미지를 동영상으로 보이게 하며 특정 카테고리에서만 동영상이 보이도록 처리
						$strProdMovieUrl = "";
						if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && !in_array(SUBSTR($row[$di]['P_CATE'],0,3),$S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST)){
							$productMgr->setP_CODE($strP_CODE);
							$productMgr->setPM_TYPE("movie1");
							$prodMovieRow = $productMgr->getProdImg($db);
							$strProdMovieUrl = $prodMovieRow[0]['PM_REAL_NAME'];
						}

						## 이벤트 정보
						$strEvent = "";
						if($strP_EVENT > 0 && getProdEventInfo($row[$di]) == "Y"){
							if($S_EVENT_INFO[$strP_EVENT]["PRICE_TYPE"] == "1"){
								$strEvent = $S_EVENT_INFO[$row[$di][P_EVENT]]["PRICE_MARK"];
							}
						}

						## 아이콘 설정
						$iconTag = "";
						$icon = explode("/", $strP_LIST_ICON);
						for($x=0; $x<sizeof($icon); $x++){
							$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
						}

						## 상품명 설정
						$strP_NAME = strHanCutUtf2($strP_NAME, $intTitleMaxsize, "N");

						## 평점 설정
				if($intP_GRADE > 0 && $intP_GRADE_CNT > 0){
					$intGrade = $intP_GRADE / $intP_GRADE_CNT;
				}else{
					$intGrade = 0;
				}

						## td style 설정
						$strStyleTD = "";
						if($j==($intWList-1)) { $strStyleTD = "width:{$intWSize}px"; }

						## div class 설정
						$strClassDiv = "productInfoWrap";
						if($j==($intWList-1)) { $strClassDiv .= " endProdList"; }

						## div style 설정
						$strStyleDiv = "width:{$intWSize}px;text-align:{$strWAlign}";

						if($_SERVER['HTTP_HOST'] == "ausieshop.eumshop.co.kr"){
							$strShow9 = "Y";
							$strShow10 = "Y";
						}

						## 판매가 할인율
						$intProdDiscountRate	= 0;
						if ($S_FIX_PRODUCT_DISCOUNT_RATE_SHOW == "Y"){
							if($row[$key]['P_CONSUMER_PRICE'] > 0.00001){
							$intProdDiscountRate= getRoundUp((($row[$di]['P_CONSUMER_PRICE'] - $row[$di]['P_SALE_PRICE'])/$row[$di]['P_CONSUMER_PRICE']) * 100,0);
							$strProdDiscountRateText = "<strong class='discountRate'>".$intProdDiscountRate."</strong><span class='rateSign'>%</span>";
							}
						}

						## 무료배송아이콘표시
						$strProdFreeDeliveryText = "";
						if ($S_FIX_PRODUCT_FREE_DELIVERY_SHOW == "Y"){
							if ($strP_BAESONG_TYPE == "2"){
								$strProdFreeDeliveryText = "무료배송";
							}
						}

						## 품절 여부 체크
						## 무제한 상품이 아니면서, 품절체크가 되었거나 상품 개수가 0일때 sold out
						$isSoldOut = false;
					//	if($strP_STOCK_OUT == "Y" || ($intP_QTY <= 0 && $strP_STOCK_LIMIT == "Y")) { $isSoldOut = true; } 2014.07.28 kim hee sung 잘못된 공식
						if($strP_STOCK_LIMIT != "Y" && ($intP_QTY <= 0 || $strP_STOCK_OUT == "Y")) { $isSoldOut = true; }

						## 2015.02.09 kim hee sung
						## 상품가격 출력 설정
						##  관리자페이지 > 기본설정 > 주문및결제관리 > 상품가격노출 사용시 해당 그룹 회원에게만 가격 노출합니다.
						if($isPriceHide){
							$strProdDiscountRateText = '';
							$strTextPrice = '';
							$intProdPointMoney = '';
							$strTextConsumerPrice = '';
							$strTextConsumerPriceUsd = '';
						}

						//$strBold = '';
						$strCompareIcon = '/upload/images/ico_list_chk2.png';
						foreach($aryProdCompareCookie as $key => $val){
							if($val == $strP_CODE){
								//$strBold = 'bold';
								$strCompareIcon = '/upload/images/ico_list_chk3.png';
							}
						}

					?>
					<!-- 상품 디자인 -->
						<div class="productInfoWrap prod<?=$strP_CODE?>">
								<div class="bestIco_<?php echo $j+1;?>"></div>
								<div class="prodImgWrap">
									<div class="prodImgBox">
										<a href="javascript:goProdView('<?php echo $strP_CODE;?>');"><img src="<?php echo $strPM_REAL_NAME;?>" class="listProdImg"/></a>
										<!-- 품절 //-->
										<?php if($isSoldOut):?>
										<!--div class="soldout">Sold Out</div-->
										<div class="soldout"><img src="/upload/images/img_soldout.png" /></div>
										<?php endif;?>
										<!-- 품절 //-->
									</div>
									<div class="icoWrap">
										<a href="javascript:goListWish('<?php echo $strP_CODE;?>','<?php echo $strP_STOCK_OUT;?>','<?php echo $intP_QTY;?>','<?php echo $strP_STOCK_LIMIT;?>','<?php echo $strCartOptPrice;?>','<?php echo $strCartOptOrgPrice;?>','<?php echo $strP_MIN_QTY;?>','<?=$strPO_NO?>','<?=$strSort?>','<?=$strPOA_ATTR1?>','<?=$strP_OPT?>','<?=$strP_MAX_QTY?>');" alt="<?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?>" title="<?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?>"><img src="/upload/images/ico_list_star2.png" alt="<?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?>" title="<?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?>"></a>
										<a href="javascript:goProdCompare(<?php echo $strP_CODE;?>)" title="<?= $LNG_TRANS_CHAR["PW00085"]; //비교하기 ?>"><img src="<?=$strCompareIcon?>" onclick=""alt="<?= $LNG_TRANS_CHAR["PW00085"]; //비교하기 ?>" title="<?= $LNG_TRANS_CHAR["PW00085"]; //비교하기 ?>" class="comppareIcon"></a>
									</div>
								</div>
							<?php if($strEvent):?>
								<div class="sailInfo">
									<strong><?php echo $strEvent;?></strong>%	<?
							if($strShow5 == "Y") {
								if($strTextPriceUsd) {
									echo $strTextPrice; // 가격
									echo ' / ';
									echo $strTextPriceUsd; // USD 달러
								}
								else {
									echo $strTextPrice;// 가격
								}
							}
							if($strP_PRICE_UNIT){
								//echo '(1';
								//echo $strP_PRICE_UNIT;
								//echo ') 당';
								echo ' / ';
								echo $strP_PRICE_UNIT;
							}?>
								</div>
							<?php endif;?>
							<div class="title"><a href="javascript:goProdView('<?php echo $strP_CODE?>');"><?php echo $strP_NAME;?></a></div>
							<div class="prodInfoSum">
								<ul class="prodInfoTxt">
									<li><span><?= $LNG_TRANS_CHAR["PW00028"]; //원산지 ?></span> <strong><?=$aryCountryList[$strP_ORIGIN]?></strong></li>
									<?php if($strShow4 == "Y" && $intP_CONSUMER_PRICE > 0 && $intP_CONSUMER_PRICE != $intP_SALE_PRICE ):?>
										<li class="priceConsumer">
											<s><?php echo $strTextConsumerPrice; // 소비자가격?></s>
										</li>
									<?php endif;?>
									<?php if($strShow5 == "Y"){?>
										<?php if($strTextPriceUsd){?>
											<li>
												<span class="priceCn"><?php echo $strTextPrice; // 가격?></span>
												<span class="priceCn_us"> / <?php echo $strTextPriceUsd // USD 달러?></span>
											</li>
										<?php }else{?>
											<li class="priceSale"><span><?= $LNG_TRANS_CHAR["PW00081"]; //가격 ?></span> <strong><?php echo $strTextPrice; // 가격?>
													<?if($strP_PRICE_UNIT){
													echo ' / '.$strP_PRICE_UNIT;
													}?>
												</strong>
											</li>
										<?php }?>
									<?php }?>

								</ul>
								</div>
								<div class="shopInfoWrap">
									<div class="shopInfo">
										<ul>
											<li><span><?= $LNG_TRANS_CHAR["PW00082"]; //업체명 ?></span> <strong><?=mb_strimwidth($strSH_COM_NAME, 0, 20,"...", "UTF-8");?></strong></li>
											<li><span><?= $LNG_TRANS_CHAR["OW00040"]; //국가 ?></span> <strong><?=$aryCountryList[$strSH_COM_COUNTRY]?></strong></li>
											<li><span>TYPE</span> <strong><?=$aryType[$strP_TYPE]?></strong></li>
										</ul>
									</div>
									<div class="shopIcoWrap">
										<ul>
											<li>
												<span><?= $LNG_TRANS_CHAR["PW00083"]; //등급 ?></span>
												<strong>
													<img src="<?=$aryCreditGradeImg[$strSH_COM_CREDIT_GRADE];?>">
													<img src="<?=$arySaleGradeImg[$strSH_COM_SALE_GRADE];?>">
													<img src="<?=$aryLocusGradeImg[$strSH_COM_LOCUS_GRADE];?>">
												</strong>
											</li>
										</ul>
									</div>
								</div>
							<div class="clr"></div>
						</div>
					<!-- 상품 디자인 -->
				<? } ?>
			</td>
			<? }	?>
		</tr>
		<? if($intListNum <= $k) { break; } ?>
		<? } ?>
	</table>
</div>
<!-- End tile view -->

<?if ($strProdListAllView != "Y"){?>
<div id="pagenate">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","","","","")?>
</div>
<? if ( $S_SHOP_MORE_VIEW_USE == 'Y' && $intTotPage > 1 ) { ?><a href="<?=$_SERVER['PHP_SELF']?>&page=2" id="btnProductMore" class="btnProductMore">더보기</a><? } ?>
<?}?>

<?}else{?>
<div class="prodNewListWrapA">
	<table>
		<tr>
			<td class="center"><?=$LNG_TRANS_CHAR["PS00001"]?></td>
		</tr>
	</table>
</div>
<?}?>

<script type="text/javascript">
<!--
//C_DelCookie("prodCompare");
	var prodCompareCnt = <?=($intProdCompareCookieCnt) ? $intProdCompareCookieCnt : 0; ?>;
	function goProdCompare(intProdCode)
	{

		if(!$("#chkInfoBox"+intProdCode).html())
		{
			var prodCompareListC = C_GetCookie("prodCompare");
			var prodCompareListI = $("#prodCompare").val();
			var prodAry = prodCompareListI.split("|");
			var prodCode = prodAry.indexOf(intProdCode+"");
			var prodCompareListCnt = prodAry.length -1;

			prodCompareCnt = prodCompareListCnt + 1;
			if(prodCompareCnt > 4){
				alert('4개이상 선택하셨습니다.');
				prodCompareCnt = prodCompareCnt - 1;
				//return;
			}else{

				if(prodCode == -1)
				{
					C_SetCookie("prodCompare",prodCompareListC + intProdCode + "|");
					$("#prodCompare").val( prodCompareListI + intProdCode + "|");
					var prdrow = ".prod" + intProdCode;
					//$(prdrow).find('.ico_chk').attr({"class" : "ico_chk bold"});

					$(".listTypeTable " +prdrow + " .comppareIcon").attr({'src':'/upload/images/ico_list_chk3.png'});
					$(".thumbTable " + prdrow + " .comppareIcon").attr({'src':'/upload/images/ico_list_chk3.png'});

				}else{
					prodCompareCnt = prodCompareCnt - 1;
				}
			}


			//기존에 생성된 비교하기 버튼 제거
			$(".chkInfoBox").remove();

			//비교하기 버튼
			var	prodComparesHtml = "";
				prodComparesHtml += "<div class=\"chkInfoBox\" id=\"chkInfoBox"+intProdCode+"\" style=\"display:;\">";
				prodComparesHtml += "<a href=\"javascript:goProdComparesHtmlClose("+intProdCode+")\" class=\"btnClose\">닫기</a>";
				prodComparesHtml += "<div class=\"infoTxt\"><?= $LNG_TRANS_CHAR['PW00095']; //선택한 상품 ?>(<span id=\"prodComparesCnt\">"+prodCompareCnt+"</span>/4)</div>";
				//prodComparesHtml += "<div class=\"infoTxt\">선택한 상품(<span id=\"prodComparesCnt\">0</span> /10)</div>";
				prodComparesHtml += "<a href=\"javascript:goProdComparesView()\" class=\"btnChk\"><?= $LNG_TRANS_CHAR['PW00085']; //비교하기 ?></a>";
				prodComparesHtml += "</div>";

			$(".prod"+intProdCode + " .icoWrap" ).append(prodComparesHtml);

		}else{

		}
	}

	function goProdComparesHtmlClose(intProdCode){
			$("#chkInfoBox"+intProdCode).remove();

	}

	function goProdComparesView()
	{
		//var prodCoparisonHtml = $("#prodComparisonBox").html();

		var	strPCodeList = $("#prodCompare").val();

		var strUrl = './?menuType=product&mode=prodCompare&prodCodeList=' + strPCodeList;

		$.smartPop.open({	//html: prodCoparisonHtml,
							url : strUrl,
							bodyClose: false,
							width : 955,
							height : 648,
		});
	}

	function loginCheck(pCode){
		alert('로그인후 이용가능합니다.');
		//location.reload();
		//<meta http-equiv="refresh" content="0;url=./?menuType=member&mode=login">
		//window.location.href="./?menuType=member&mode=login";
		window.location.replace("./?menuType=member&mode=login");
	}

//-->
</script>