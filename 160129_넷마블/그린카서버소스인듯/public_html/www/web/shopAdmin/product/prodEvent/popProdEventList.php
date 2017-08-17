<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		

	$intSE_NO		= $_POST["no"]					? $_POST["no"]				: $_REQUEST["no"];

	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	/* 언어 선택 */
	$productMgr->setP_LNG($strStLng);
	$productMgr->setSearchEvent($intSE_NO);
	
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

	$linkPage  = "?menuType=$strMenuType&mode=$strMode&no=$intSE_NO&page=";
			
?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		
	});

	function goClose()
	{
		parent.location.reload();
		parent.goPopClose();
	}

	/* 상품목록 검색*/
	function goSearch(mode){
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goProdDelete()
	{
		var strChkVal = C_getCheckedCode(document.form["chkNo[]"]);
		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}
		C_getAction("prodEventProductDelete",'<?=$PHP_SELF?>');
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>상품기간/할인 상품적용하기</h2>			
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
<input type="hidden" name="no" id="no" value="<?=$intSE_NO?>">
	<!-- ******** 컨텐츠 ********* -->

	<div class="tableList">
		<table>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></th>
				<th><?=$LNG_TRANS_CHAR["BW00054"] //판매가?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="4"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	
				/* PHP CODE */
				}else{				
					while($row = mysql_fetch_array($result))		{	

				/* PHP CODE */
			?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[P_CODE]?>"></td>
				<td style="width:50px;"><a href="javascript:goOpenWindow('<?=$row[P_CODE]?>')"><img src="..<?=$row[PM_REAL_NAME]?>" class="prodPhoto"></a></td>
				<td class="prodListInfo">					
					<ul>
						<li class="title"><?=$row[P_NAME]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($row[P_CATE],$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$row[P_NUM]?></li>
					</ul>
					<div class="clr"></div>
				</td>
				<td><?=getFormatPrice($row[P_SALE_PRICE],2)?></td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<div class="paginate mt20">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goProdDelete();" ><strong><?=$LNG_TRANS_CHAR["PW00131"] //상품삭제?></strong></a>
	</div>
</form>
</div>
</body>
</html>