<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	
	$orderMgr = new OrderMgr();
	$memberMgr = new MemberMgr();
	
	$intM_NO					= $_POST["memberNo"]					? $_POST["memberNo"]					: $_REQUEST["memberNo"];

	if (!$intM_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["CS00013"]); //"해당 회원정보가 존재하지 않습니다."
		exit;
	}

	$memberMgr->setM_NO($intM_NO);
	$orderMgr->setM_NO($intM_NO);
	$memberRow = $memberMgr->getMemberView($db);



	$orderMgr->setSearchOrderStatus('E');

	$intPageBlock	= 10;
	$intPageLine	= 10;
	
	$orderMgr->setPageLine($intPageLine);

	$intTotal	= $orderMgr->getOrderTotal($db);
	$intTotPage	= ceil($intTotal / $orderMgr->getPageLine());

	if(!$intPage)	$intPage =1;

	if ($intTotal==0) {
		$intFirst	= 1;
		$intLast	= 0;			
	} else {
		$intFirst	= $intPageLine *($intPage -1);
		$intLast	= $intPageLine * $intPage;
	}
	$orderMgr->setLimitFirst($intFirst);

	$result = $orderMgr->getOrderList($db);
	$intListNum = $intTotal - ($intPageLine *($intPage-1));	
	
	$linkPage  = "?menuType=$strMenuType&mode=$strMode";
	$linkPage .= "&memberNo=$intM_NO&page=";
?>
<? include "./include/header.inc.php"?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
	});
	
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>[<?=$memberRow[M_NAME]?>]님의 구매내역</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
	<div id="contentWrap">
		<div class="tableList mt10">
			<form name="form" method="post">
			<input type="hidden" name="menuType" value="<?=$strMenuType?>">
			<input type="hidden" name="mode" value="<?=$strMode?>">
			<input type="hidden" name="act" value="<?=$strMode?>">
			<input type="hidden" name="page" value="<?=$intPage?>">
			<input type="hidden" name="no" value="<?=$intM_NO?>">
				<table style="border-left:1px solid #D2D0D0">
					<colgroup>
						<col style="width:8%;">
						<col style="width:20%;">
						<col style="width:20%;">
						
						<col style="width:18%;">
						<col />
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
						<th>주문번호</th>
						<th>주문상태</th>
						<th>주문금액</th>
						<th>주문일자</th>
					</tr>
					<!-- (1) -->
					<?if($intTotal=="0"){?>
					<tr>
						<td colspan="6"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
					</tr>		
					<?}?>
					<?
						while($row = mysql_fetch_array($result)){

							$strOrderSettle = $btnOrderCancel = $brnOrderCalOff = $brnOrderAccClear = "";
							if ($row[O_SETTLE] == "C") $strOrderSettle = $S_ARY_SETTLE_TYPE["C"]; //신용카드
							else if ($row[O_SETTLE] == "A") $strOrderSettle = $S_ARY_SETTLE_TYPE["A"]; //계좌이체
							else if ($row[O_SETTLE] == "T") $strOrderSettle = $S_ARY_SETTLE_TYPE["T"]; //가상계좌
							else if ($row[O_SETTLE] == "B") $strOrderSettle = $S_ARY_SETTLE_TYPE["B"]; //무통장입금"
							else if ($row[O_SETTLE] == "P") $strOrderSettle = $S_ARY_SETTLE_TYPE["P"]; //포인트/쿠폰

					?>
					<tr>
						<td><?=$intListNum--?></td>
						<td style="width:45px;margin:0 auto;">
							<span><em><?=$row[O_KEY]?></em></span>
						</td>
						<td><?=$strOrderSettle?></td>
						<td class="txtRedPrice"><?=$S_SITE_ST?> <?=getFormatPrice($row[O_TOT_CUR_SPRICE],2)?></td>
						<td><?=$row[O_REG_DT]?></td>
					</tr>
					<?
						}
					?>
				</table>
			</form>
		</div>
		<!-- Pagenate object --> 
		<div class="paginate" style="padding:10px">  
			<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
		</div>  	
		<!-- Pagenate object --> 
		<div class="buttonWrap">
			<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //창닫기?></strong></a>
		</div>
	</div>
</div>
</body>
</html>