<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";

	$couponMgr				= new CouponMgr();
	$productMgr				= new ProductAdmMgr();
	$productMgr->setP_LNG($strAdmSiteLng);

	$intCU_NO				= $_POST["cuNo"]					? $_POST["cuNo"]					: $_REQUEST["cuNo"];

	$strSearchHCode1		= $_POST["searchCateHCode1"]		? $_POST["searchCateHCode1"]		: $_REQUEST["searchCateHCode1"];
	$strSearchHCode2		= $_POST["searchCateHCode2"]		? $_POST["searchCateHCode2"]		: $_REQUEST["searchCateHCode2"];
	$strSearchHCode3		= $_POST["searchCateHCode3"]		? $_POST["searchCateHCode3"]		: $_REQUEST["searchCateHCode3"];
	$strSearchHCode4		= $_POST["searchCateHCode4"]		? $_POST["searchCateHCode4"]		: $_REQUEST["searchCateHCode4"];
	$strSearchLaunchStartDt = $_POST["searchLaunchStartDt"]		? $_POST["searchLaunchStartDt"]		: $_REQUEST["searchLaunchStartDt"];
	$strSearchLaunchEndDt	= $_POST["searchLaunchEndDt"]		? $_POST["searchLaunchEndDt"]		: $_REQUEST["searchLaunchEndDt"];
	$strSearchRepStartDt	= $_POST["searchRepStartDt"]		? $_POST["searchRepStartDt"]		: $_REQUEST["searchRepStartDt"];
	$strSearchRepEndDt		= $_POST["searchRepEndDt"]			? $_POST["searchRepEndDt"]			: $_REQUEST["searchRepEndDt"];
	$strSearchWebView		= $_POST["searchWebView"]			? $_POST["searchWebView"]			: $_REQUEST["searchWebView"];	
	$strSearchMobileView	= $_POST["searchMobileView"]		? $_POST["searchMobileView"]		: $_REQUEST["searchMobileView"];	

	/* 검색부분 */
	$productMgr->setSearchHCode1($strSearchHCode1);
	$productMgr->setSearchHCode2($strSearchHCode2);
	$productMgr->setSearchHCode3($strSearchHCode3);
	$productMgr->setSearchHCode4($strSearchHCode4);

	$productMgr->setSearchField($strSearchField);
	$productMgr->setSearchKey($strSearchKey);
	$productMgr->setSearchLaunchStartDt($strSearchLaunchStartDt);
	$productMgr->setSearchLaunchEndDt($strSearchLaunchEndDt);
	$productMgr->setSearchRepStartDt($strSearchRepStartDt);
	$productMgr->setSearchRepEndDt($strSearchRepEndDt);
	$productMgr->setSearchWebView($strSearchWebView);
	$productMgr->setSearchMobileView($strSearchMobileView);
	/* 검색부분 */

	$intPageBlock	= 10;
	$intPageLine	= 10;
	
	$productMgr->setPageLine($intPageLine);

	$intTotal	= $productMgr->getProdTotal($db);
	$intTotPage	= ceil($intTotal / $productMgr->getPageLine());

	if(!$intPage)	$intPage =1;

	if ($intTotal==0) {
		$intFirst	= 1;
		$intLast	= 0;			
	} else {
		$intFirst	= $intPageLine *($intPage -1);
		$intLast	= $intPageLine * $intPage;
	}
	$productMgr->setLimitFirst($intFirst);

	$result = $productMgr->getProdList($db);
	$intListNum = $intTotal - ($intPageLine *($intPage-1));		
	
	$linkPage  = "?menuType=$strMenuType&mode=$strMode&cateHCode1=$strC_HCODE1&cateHCode2=$strC_HCODE2";
	$linkPage .= "&cateHCode3=$strC_HCODE3&cateHCode4=$strC_HCODE4";
	$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$linkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
	$linkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
	$linkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView&cuNo=$intCU_NO&page=";

	/* 등록된 쿠폰 상품 정보 */
	$couponMgr->setCU_NO($intCU_NO);
	$aryCouponApplyList = $couponMgr->getCouponApplyList($db);

?>

<? include "./include/header.inc.php"?>

<style type="text/css">
	#contentArea{position:relative;min-width:650px;padding:10px}
</style>
<script type="text/javascript">
<!--

	$(document).ready(function(){
		
		var strHCode = "";
		callCateList(1,"","","searchCateHCode1","<?=$strSearchHCode1?>");

		$("#searchCateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","searchCateHCode2");
			}
		});

		$("#searchCateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#searchCateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","searchCateHCode3");
			}
		});

		$("#searchCateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#searchCateHCode1 option:selected").val()+$("#searchCateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","searchCateHCode4");
			}
		});
	});
	
	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
		var strJsonParam = "menuType=product&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strAdmSiteLng?>";
		
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data){	
				var strCateSelectedText = "";
				if (cateLevel == "1")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00013']?>";
				} else if (cateLevel == "2")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00014']?>";
				} else if (cateLevel == "3")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00015']?>";
				} else if (cateLevel == "4")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00016']?>";
				}

				$("#"+cateObj).html("<option value=''>"+strCateSelectedText+"</option>");
				for(var i=0;i<data.length;i++){
					var strCateSelected = "";
					if (data[i].CATE_CODE == cateSelected)
					{
						strCateSelected = "selected";
					}
					$("#"+cateObj).append("<option value='"+data[i].CATE_CODE+"' "+strCateSelected+">"+data[i].CATE_NAME+"</option>");
				}
			}
		});
	}

	function goSearch(mode){
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

//-->
</script>
<?include "script.inc.php"; ?>
<div id="contentArea">
<form name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="page" value="<?=$intPage?>">	
<input type="hidden" name="cuNo" value="<?=$intCU_NO?>">
<input type="hidden" name="p_code" value="">
	<div id="contentArea">
		<!-- ******** 컨텐츠 ********* -->
		<div class="tableForm">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["CW00027"] //카테고리선택?></th>
					<td colspan="3">
						<select id="searchCateHCode1" name="searchCateHCode1">
							<option value=""><?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?></option>
						</select>
						<select id="searchCateHCode2" name="searchCateHCode2" >
							<option value=""><?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?></option>
						</select>
						<select id="searchCateHCode3" name="searchCateHCode3" >
							<option value=""><?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?></option>
						</select>
						<select id="searchCateHCode4" name="searchCateHCode4">
							<option value=""><?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00030"] //검색어?></th>
					<td colspan="3">
						<select name="searchField" id="searchField">
							<option value="N"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
							<option value="C"><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
							<option value="M"><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
							<option value="O"><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
							<option value="D"><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
						</select>
						<input type="text" <?=$nBox?>  style="width:150px;" id="searchKey" name="searchKey"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00008"] //상품출시일?></th>
					<td colspan="3">
						<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchStartDt" name="searchLaunchStartDt" maxlength="10"/>
						~
						<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchEndDt" name="searchLaunchEndDt" maxlength="10"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00009"] //상품등록일?></th>
					<td colspan="3">
						<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepStartDt" name="searchRepStartDt" maxlength="10"/>
						~
						<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepEndDt" name="searchRepEndDt" maxlength="10"/>
						<span class="searchWrapImg">
							<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
							<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
							<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
							<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
							<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
							<a class="btn_sml" href="./?menuType=member&mode=popGroupProdSearch"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
						</span>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
					<td colspan="3">
						<input type="checkbox" id="searchWebView" name="searchWebView" value="Y"><?=$LNG_TRANS_CHAR["PW00011"] //웹보임?>
						<input type="checkbox" id="searchMobileView" name="searchMobileView" value="Y"><?=$LNG_TRANS_CHAR["PW00012"] //모바일보임?>
						<a class="btn_blue_big" href="javascript:goSearch('popProductSearch');"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
					</td>
				</tr>
			</table>
		</div>
		<br>
		<div class="tableList">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
					<th><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></th>
					<th><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></th>
					<th><?=$LNG_TRANS_CHAR["BW00054"] //판매가?></th>
					<th><?=$LNG_TRANS_CHAR["PW00017"] //재고?></th>
					<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
					<th>선택</th>
				</tr>
				<?if ($intTotal == 0){?>
				<tr>
					<td colspan="7"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
				</tr>
				<?}else{
					while($row = mysql_fetch_array($result)){
					
					?>
				<tr>
					<td><?=$intListNum?></td>
					<td style="text-align:left">
						<img src="..<?=$row[PM_REAL_NAME]?>" style="width:50px;height:50px;">
						<?=$row[P_NAME]?>
					</td>
					<td><?=$row[P_NUM]?></td>
					<td><?=number_format($row[P_SALE_PRICE])?></td>
					<td><?=number_format($row[P_QTY])?></td>
					<td><?=SUBSTR($row[P_REP_DT],0,10)?></td>
					<td><a class="btn_sml" href="javascript:goDataEditProductSelectEvent('<?=$row['P_CODE']?>')"><strong>선택</strong></a></td>
				</tr>
				<?
						$intListNum--;
					}
				}
				?>
			</table>
		</div>
		<div class="paginate" style="width:300px;margin:20px;">
			<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
		</div>
	</div>
</form>
</div>