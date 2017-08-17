
<?
	require_once MALL_CONF_LIB."CouponMgr.php";
	
	$conponMgr = new CouponMgr();
	
	if (!$intM_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["CS00013"]); //"해당 회원정보가 존재하지 않습니다."
		exit;
	}
	
	$memberMgr->setM_NO($intM_NO);
	$conponMgr->setM_NO($intM_NO);

	$memberRow = $memberMgr->getMemberView($db);

	$intPageBlock = 10;
	$intPageLine  = 10;
	
	$conponMgr->setPageLine($intPageLine);
	$conponMgr->setSearchKey($strSearchKey);
	$conponMgr->setSearchField($strSearchField);

	$intTotal	= $conponMgr->getCouponIssueTotal($db);
	
	$intTotPage	= ceil($intTotal / $conponMgr->getPageLine());

	if(!$intPage)	$intPage =1;

	if ($intTotal==0) {
		$intFirst	= 1;
		$intLast	= 0;			
	} else {
		$intFirst	= $intPageLine *($intPage -1);
		$intLast	= $intPageLine * $intPage;
	}
	$conponMgr->setLimitFirst($intFirst);

	$result = $conponMgr->getCouponIssueList($db);		

	$intListNum = $intTotal - ($intPageLine *($intPage-1));		
	
	$linkPage  = "?menuType=$strMenuType&mode=$strMode";
	$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$linkPage .= "&memberNo=$intM_NO";
	$linkPage .= "&page=";

?>

<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
	});
	
//-->
</script>

<div id="contentArea">
	<div id="contentWrap">
		<!-- (1) 회원 정보 -->
		<div class="tableList mt10">
				<table style="border-left:1px solid #D2D0D0">
					<colgroup>
						<col style="width:8%;">
						<col style="width:20%;">
						<col />
						<col style="width:20%;">
						<col style="width:10%;">
						<col style="width:18%;">
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
						<th><?=$LNG_TRANS_CHAR["MW00142"] //쿠폰코드?></th>
						<th><?=$LNG_TRANS_CHAR["MW00111"] //쿠폰명?></th>
						<th><?=$LNG_TRANS_CHAR["MW00153"] //발행일자?></th>
						<th><?=$LNG_TRANS_CHAR["MW00145"] //사용유무?></th>
						<th><?=$LNG_TRANS_CHAR["MW00146"] //사용일자?></th>
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
						<td><?=$row[CI_CODE]?></td>
						<td style="width:45px;margin:0 auto;">
							<span><em><?=$row[CU_NAME]?></em></span>
						</td>
						<td><?=$row[CI_START_DT]?></td>
						<td><?=$row[CI_USE]?></td>
						<td><?=$row[CI_USE_DT]?></td>
					</tr>
					<?
						}
					?>
				</table>
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