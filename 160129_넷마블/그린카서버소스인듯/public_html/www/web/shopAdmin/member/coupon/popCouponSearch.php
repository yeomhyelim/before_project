<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";

	$productMgr = new ProductAdmMgr();
	$couponMgr = new CouponMgr();
	$productMgr->setP_LNG($strAdmSiteLng);

	/* 검색부분 */
	$couponMgr->setSearchField($strSearchField);
	$couponMgr->setSearchKey($strSearchKey);
	$couponMgr->setSearchCouponIssue("5");
	$couponMgr->setSearchCouponUse($strSearchCouponUse);
	
	$couponMgr->setSearchRegStartDt(date("Y-m-d"));
	$couponMgr->setSearchRegEndDt(date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y"))));

	/* 검색부분 */

	$intPageBlock	= 10;
	//$intPageLine	= 10;
	if(!$intPageLine) $intPageLine = 10;	
	$couponMgr->setPageLine($intPageLine);

	$intTotal	= $couponMgr->getCouponTotal($db);
	$intTotPage	= ceil($intTotal / $couponMgr->getPageLine());

	if(!$intPage)	$intPage =1;

	if ($intTotal==0) {
		$intFirst	= 1;
		$intLast	= 0;			
	} else {
		$intFirst	= $intPageLine *($intPage -1);
		$intLast	= $intPageLine * $intPage;
	}
	$couponMgr->setLimitFirst($intFirst);

	$result = $couponMgr->getCouponList($db);
	$intListNum = $intTotal - ($intPageLine *($intPage-1));	
	
	$linkPage  = "?menuType=$strMenuType&mode=$strMode";
	$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$linkPage .= "&searchCouponIssue=$strSearchCouponIssue";
	$linkPage .= "&searchCouponUse=$strSearchCouponUse&page=";

?>
<style type="text/css">
	#contentArea{position:relative;min-width:650px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var multiNo = "<?=$_REQUEST['multiNo']?>";

	$(document).ready(function(){
		
	});
	
	function goSearch(mode){
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goSubmitCoupon(cu_no){
		var x = confirm("<?=$LNG_TRANS_CHAR['MS00042']?>"); ////선택하신 쿠폰으로 입력하시겠습니까?
		if (x == true)
		{
			var code					= $("#coupon_"+cu_no);
			var cu_name					= $(code).find("#cu_name").text();
			
			var data					= new Object();
			data.multiNo				= multiNo;
			data.cu_no					= cu_no;
			data.cu_name				= cu_name;
			data.where					= "<?=$_REQUEST['where']?>";

			var obj						= new Object();
			obj.mode					= 1;
			obj.data					= data;

			parent.goCouponCSelectLayerPopCallBack(obj);
			parent.goPopClose();

		} else {
			$("input[id^=cuNo]").each(function(i){
				$(this).attr("checked",false);
			});
		}
	}

//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["MW00152"] //쿠폰목록?></h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="page" value="<?=$intPage?>">	
	<div id="contentArea">
		<!-- ******** 컨텐츠 ********* -->
		<div class="tableList">
			<table>
				<colgroup>
					<col style="width:5%;">
					<col style="width:8%;">
					<col />
					<col style="width:10%;">
					<col style="width:10%;">
					<col style="width:18%;">
				</colgroup>
				<tr>
					<th></th>
					<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
					<th><?=$LNG_TRANS_CHAR["MW00111"] //쿠폰명?></th>
					<th><?=$LNG_TRANS_CHAR["MW00112"] //쿠폰종류?></th>
					<th><?=$LNG_TRANS_CHAR["MW00118"] //쿠폰금액(율)?></th>
					<th><?=$LNG_TRANS_CHAR["MW00119"] //쿠폰기간?></th>
				</tr>

				<?if($intTotal=="0"){?>
				<tr>
					<td colspan="8"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
				</tr>		
				<?}?>
				<?
					while($row = mysql_fetch_array($result)){
						
						if ($row[CU_ISSUE] == "1") { $strIssueName = $LNG_TRANS_CHAR["MW00113"];} //"회원발급"
						else if ($row[CU_ISSUE] == "2") { $strIssueName = $LNG_TRANS_CHAR["MW00114"];} //"회원 다운로드"
						else if ($row[CU_ISSUE] == "3") { $strIssueName = $LNG_TRANS_CHAR["MW00115"];} //"회원 가입시 자동발급"
						else if ($row[CU_ISSUE] == "4") { $strIssueName = $LNG_TRANS_CHAR["MW00116"];} //"구매 후 자동발급"
						else if ($row[CU_ISSUE] == "5") { $strIssueName = $LNG_TRANS_CHAR["MW00125"];} //"이벤트발급";
				?>
				<tr id="coupon_<?=$row['CU_NO']?>">
					<td><input type="checkbox" name="cuNo[]" id="cuNo[]" value="<?=$row[CU_NO]?>" onclick="javascript:goSubmitCoupon('<?=$row['CU_NO']?>');"></td>
					<td><?=$intListNum--?></td>
					<td id="cu_name"><?=$row[CU_NAME]?></td>
					<td><span><em><?=$strIssueName?></em></span></td>
					<td><?=$row[CU_PRICE]?><?=($row[CU_PRICE_OFF]=="1")?"%":$S_SITE_ST;?></td>
					<td>
						<?
							if ($row[CU_PERIOD] == "1") { echo SUBSTR($row[CU_START_DT],0,10)." ~ ".SUBSTR($row[CU_END_DT],0,10);}
							else if ($row[CU_PERIOD] == "2") { echo callLangTrans($LNG_TRANS_CHAR["MW00122"],array($row[CU_USE_DAY]));}
							else { echo $LNG_TRANS_CHAR["MW00123"];}
						?>
					</td>
				</tr>
				<?
					}
				?>
			</table>
		</div>
		<!-- Pagenate object --> 
		<div class="paginate" style="padding:10px 5px;">  
			<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
		</div>  
		<!-- Pagenate object -->
	</div>
</form>
</div>