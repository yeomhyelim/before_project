<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	$productMgr = new ProductAdmMgr();		

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];


	/* 데이터 리스트 */
	$productMgr->setP_LNG($strStLng);																							//언어
	$intTotal								= $productMgr->getProdTotal( $db );													// 데이터 전체 개수 

	$intPageLine							= 10;																				// 리스트 개수 
	$intPage								= ( $intPage )				? $intPage		: 1;
	$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
	$productMgr->setLimitFirst( $intFirst );
	$productMgr->setPageLine( $intPageLine );
	

	$prodListResult							= $productMgr->getProdList( $db );	

	$intPageBlock							= 10;																// 블럭 개수 
	$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );					// 번호
	$intTotPage								= ceil( $intTotal / $intPageLine );
	/* 데이터 리스트 */

	$linkPage  = "?menuType=$strMenuType&mode=$strMode&searchCateHCode1=$strSearchHCode1&searchCateHCode2=$strSearchHCode2";
	$linkPage .= "&searchCateHCode3=$strSearchHCode3&searchCateHCode4=$strSearchHCode4";
	$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$linkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
	$linkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
	$linkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
	$linkPage .= "&searchIcon1=$strSearchIcon1";
	$linkPage .= "&searchIcon2=$strSearchIcon2";
	$linkPage .= "&searchIcon3=$strSearchIcon3";
	$linkPage .= "&searchIcon4=$strSearchIcon4";
	$linkPage .= "&searchIcon5=$strSearchIcon5";
	$linkPage .= "&searchIcon6=$strSearchIcon6";
	$linkPage .= "&searchIcon7=$strSearchIcon7";
	$linkPage .= "&searchIcon8=$strSearchIcon8";
	$linkPage .= "&searchIcon9=$strSearchIcon9";
	$linkPage .= "&searchIcon10=$strSearchIcon10&page=";
?>

<? include "./include/header.inc.php"?>

<script type="text/javascript">
<!--
	$(document).ready(function(){

	});

	/* 이벤트 등록 */
	function goProdOrderSelect(data, pCode) { prodOrderSelect(data, pCode); }
	function goProdOrderCancel(data, pCode) { prodOrdrCancel(data, pCode); }

	function prodOrderSelect(data, pCode) {
		var pImg		= $(data).parent().parent().find("th").eq(2).html();	// 이미지
		var pName		= $(data).parent().parent().find("th").eq(3).html();	// 상품명
		var pPoint		= $(data).parent().parent().find("th").eq(6).html();	// 적립금
		var pQty		= 1;													// 수량
		var pSalePrice	= $(data).parent().parent().find("th").eq(5).html();	// 판매가
		parent.prodOrderSelect(pCode, pImg, pName, pPoint, pQty, pSalePrice);
		$(data).attr("onClick","goProdOrderCancel(this, '"+pCode+"');");
		$(data).html("<strong>선택취소</strong>");
	}

	function prodOrdrCancel(data, pCode) {
		parent.prodOrderSCancel(pCode);
		$(data).attr("onClick","goProdOrderSelect(this, '"+pCode+"');");
		$(data).html("<strong>상품선택</strong>");
	}

	function goClose() {
		parent.goClose();
	}


//-->
</script>

		<div class="layerPopWrap">
			<div class="popTop">
				<h2>상품리스트</h2>			
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clr"></div>
			</div>

			<div class="popBoxWrap">
				<form name="form" id="form">
					<!-- ******** 컨텐츠 ********* -->
					<table border="1">
						<tr>
							<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
							<th style="width:40px;">번호</th>
							<th style="width:50px;">이미지</th>
							<th>상품명</th>
							<th style="width:80px;">등록일</th>
							<th style="width:60px;">가격</th>
							<th style="width:40px;">재고</th>
							<th style="width:80px;">상품선택</th>
						</tr>
						<? while($row = mysql_fetch_array($prodListResult)) : 
							$row['PM_REAL_NAME']	= ($row['PM_REAL_NAME']) ? "<img src=\"{$row['PM_REAL_NAME']}\" style=\"width:50px\"/>" : "";
							$row['P_REP_DT']		= ($row['P_REP_DT']) ? date("Y-m-d", strtotime($row['P_REP_DT'])) : "-";
							$row['P_SALE_PRICE']	= number_format($row['P_SALE_PRICE']);						?>
						<tr>
							<th><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[P_CODE]?>"></th>
							<th><?=$intTotal--?></th>
							<th><?=$row['PM_REAL_NAME']?></th>
							<th style="text-align:left;padding:0 0 0 10px;"><?=$row['P_NAME']?></th>
							<th><?=$row['P_REP_DT']		// 등록일?></th>
							<th><?=$row['P_SALE_PRICE']	// 판매가?></th>
							<th><?=$row['P_QTY']		// 수량?></th>
							<th style="display:none"><?=$row['P_POINT']		// 적립금?></th>
							<th><a class="btn_sml" onClick="goProdOrderSelect(this, '<?=$row['P_CODE']?>');"><strong>상품선택</strong></a></th>
						</tr>
						<? endwhile; ?>
					</table>
					<!-- ******** 컨텐츠 ********* -->
				</form>
			</div>
			<div class="paginate mt20">
				<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
			</div>
			<div style="text-align:left;margin-top:3px;">
				<!--a class="btn_big" href="javascript:goProdAllDelete();" id="menu_auth_d" style=""><strong>선택상품등록</strong></a-->
				<!--a class="btn_big" href="javascript:goProdAllUpdate();"><strong>닫기</strong></a-->
			</div>
		</div>
	</body>
</html>