<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."PointMgr.php";
	
	$memberMgr = new MemberMgr();
	$pointMgr = new PointMgr();
	
	$intM_NO					= $_POST["memberNo"]					? $_POST["memberNo"]					: $_REQUEST["memberNo"];
	$intPage					= $_POST["page"]						? $_POST["page"]						: $_REQUEST["page"];

	if (!$intM_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["CS00013"]); //"해당 회원정보가 존재하지 않습니다."
		exit;
	}

	$memberMgr->setM_NO($intM_NO);
	$pointMgr->setM_NO($intM_NO);

	$memberRow = $memberMgr->getMemberView($db);

	$intPageBlock = 10;
	$intPageLine  = 10;
	$pointMgr->setPageLine($intPageLine);
	$pointMgr->setSearchKey($strSearchKey);
	$pointMgr->setSearchField($strSearchField);
	$pointMgr->setSearchPointType($strSearchPointType);

	$intTotal	= $pointMgr->getPointTotal($db);
	$intTotPage	= ceil($intTotal / $pointMgr->getPageLine());

	if(!$intPage)	$intPage =1;

	if ($intTotal==0) {
		$intFirst	= 1;
		$intLast	= 0;			
	} else {
		$intFirst	= $intPageLine *($intPage -1);
		$intLast	= $intPageLine * $intPage;
	}
	$pointMgr->setLimitFirst($intFirst);

	$result = $pointMgr->getPointList($db);		

	$intListNum = $intTotal - ($intPageLine *($intPage-1));		
	
	$linkPage  = "?menuType=$strMenuType&mode=$strMode";
	$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$linkPage .= "&searchPointType=$strSearchPointType&memberNo=$intM_NO";
	$linkPage .= "&page=";

	/* 포인트 종류 배열 */
	$aryPointTypeList = getCommCodeList('point');
	
	/* 포인트 소멸 일자 */
	$strPointEndDt = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+1));
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
		<h2>[<?=$memberRow[M_NAME]?>]님의 포인트 내역</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
	<div id="contentWrap">
		<div class="paymentInfo mt20">
			<ul>
				<li><?=callLangTrans($LNG_TRANS_CHAR["MS00008"],array($memberRow[M_ID],$memberRow[M_NAME],NUMBER_FORMAT($memberRow[M_POINT])))?></li>
			</ul>
		</div>
		<!-- (1) 회원 정보 -->
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
						<col />
						<col style="width:18%;">
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
						<th><?=$LNG_TRANS_CHAR["MW00057"] //포인트종류?></th>
						<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
						<th><?=$LNG_TRANS_CHAR["MW00055"] //포인트설명?></th>
						<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
					</tr>
					<!-- (1) -->
					<?if($intTotal=="0"){?>
					<tr>
						<td colspan="6"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
					</tr>		
					<?}?>
					<?
						while($row = mysql_fetch_array($result)){
					?>
					<tr>
						<td><?=$intListNum--?></td>
						<td style="width:45px;margin:0 auto;">
							<span><em><?=$row[POINT_TYPE_NM]?></em></span>
						</td>
						<td><?=NUMBER_FORMAT($row[PT_POINT])?></td>
						<td><?=$row[PT_MEMO]?></td>
						<td><?=$row[PT_REG_DT]?></td>
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