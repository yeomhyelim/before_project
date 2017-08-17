<? include "./include/header.inc.php"?>
<?
	## 클래스 설정
	$objProductAuctionModule	= new ProductAuctionModule($db);
	
	## 상품함수관련
	require_once MALL_PROD_FUNC;
		
	$strProdCode				= $_GET['prodCode'];

	## 입찰정보 
	$param						= "";
	$param['P_CODE']			= $strProdCode;
	$param['P_LNG']				= $S_SITE_LNG;
	$prodAucRow					= $objProductAuctionModule->getProductAuctionViewEx($param);

	if (!$prodAucRow){
		goUrl($LNG_TRANS_CHAR["PS00063"]); //해당상품에 대한 입찰정보가 존재하지 않습니다.
		echo "<script language='javascript'>parent.goPopClose();</script>";
		exit;
	}	

	
	## 변수 선언
	$strProdName				= $prodAucRow['P_NAME'];
	$strProdAucDate				= $prodAucRow['P_AUC_ST_DT']." ~ ".$prodAucRow['P_AUC_END_DT'];
	switch($prodAucRow['P_AUC_STATUS']){
		case "1":
			$strProdAucStatusName = "경매시작전";
		break;
		case "2":
			$strProdAucStatusName = "진행중";
		break;
		case "3":
			$strProdAucStatusName = "경매중지";
		break;
		case "4":
			$strProdAucStatusName = "경매완료";
		break;
		case "5":
			$strProdAucStatusName = "경매종료";
		break;
	}

	## 입찰리스트
	$intPageBlock		= 10;
	$intPageLine		= 10;
	$intTotal			= $objProductAuctionModule->getProductAuctionApplySelectEx("OP_COUNT",$param);
	$intTotPage			= ceil($intTotal / $intPageLine);

	if(!$intPage)	$intPage =1;
	if ($intTotal==0) {
		$intFirst	= 1;
		$intLast	= 0;			
	} else {
		$intFirst	= $intPageLine *($intPage -1);
		$intLast	= $intPageLine * $intPage;
	}
	
	$param['LIMIT_START']	= $$intFirst;
	$param['LIMIT_END']		= $$intLast;
	$prodAucApplyResult		= $objProductAuctionModule->getProductAuctionApplySelectEx("OP_LIST",$param);
	
	$arrRow					= "";
	if ($intTotal > 0){
		$intCount			= 0;
		while($prodAucApplyRow = mysql_fetch_array($prodAucApplyResult)){
			
			$strProdAucApplyMemberName	= "";
			$strProdAucApplyRegDate		= "";
			$intProdAucApplyPrice		= 0;

			$strPriceLeftMark					= getCurMark($S_ST_CUR);
			if ($strPriceLeftMark) $strPriceLeftMark .= " ";
			$strPriceRightMark					= getCurMark2($S_ST_CUR);

			$strPriceUseLeftMark				= getCurMark($prodAucApplyRow['PAA_USE_CUR']);
			if ($strPriceUseLeftMark) $strPriceUseLeftMark .= " ";
			$strPriceUseRightMark				= getCurMark2($prodAucApplyRow['PAA_USE_CUR']);

			if ($prodAucApplyRow['M_F_NAME']) $strProdAucApplyMemberName  = $prodAucApplyRow['M_F_NAME']." ";
			if ($prodAucApplyRow['M_L_NAME']) $strProdAucApplyMemberName .= $prodAucApplyRow['M_L_NAME'];
			$strProdAucApplyRegDate					= $prodAucApplyRow['PAA_REG_DT'];
			$strProdAucApplyPrice					= $strPriceLeftMark.getFormatPrice($prodAucApplyRow['PAA_PRICE'],2,$S_ST_CUR).$strPriceRightMark;
			$strProdAucApplyCurPrice				= "";
			if ($S_ST_CUR != $prodAucApplyRow['PAA_USE_CUR']){
				$strProdAucApplyCurPrice			= "(".$strPriceUseLeftMark.getFormatPrice($prodAucApplyRow['PAA_CUR_PRICE'],2,$prodAucApplyRow['PAA_USE_CUR']).$strPriceUseRightMark.")";
			}

			$arrRow[$intCount]['APPLY_NO']			= $prodAucApplyRow['PAA_NO'];
			$arrRow[$intCount]['APPLY_NAME']		= $strProdAucApplyMemberName;
			$arrRow[$intCount]['APPLY_DATE']		= $strProdAucApplyRegDate;
			$arrRow[$intCount]['APPLY_PRICE']		= $strProdAucApplyPrice;
			$arrRow[$intCount]['APPLY_CUR_PRICE']	= $strProdAucApplyCurPrice;

			
			$intCount++;
		}
	}

	$queryString	= explode("&", $_SERVER['QUERY_STRING']);
	$strLinkPage	= "";
	foreach($queryString as $string):
		list($key,$val)		= explode("=", $string);
		if($key == "page")	{ continue; }
		if($strLinkPage)		{ $strLinkPage .= "&"; }
		$strLinkPage		   .= $string;
	endforeach;
	$strLinkPage		= "./?{$strLinkPage}&page=";	
?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var strProdCode				= "<?=$strProdCode?>";
	
	$(document).ready(function(){
	});
	
	function goProdAucApplySucAct(){
		
		var data	= new Object();
		var intCnt	= 0;
		$("input[id^=chkNo]").each(function() {
			if($(this).attr("checked")=="checked") {
				data["chkNo["+intCnt+"]"]	= $(this).val();
				intCnt++;
			}
		});

		if (intCnt == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}

		if (intCnt > 1)
		{
			alert("<?=$LNG_TRANS_CHAR['PS00072']?>"); //낙찰자는 한명만 선택할 수 있습니다.
			return;
		}

		data['menuType']			= "product";
		data['mode']				= "act";
		data['act']					= "prodAuctionApplySucess";
		data['page']				= $("input[name=page]").val();

		C_getSelfAction(data);
	}
	
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["PW00274"]; //경매기록보기?></h2>
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
	<form name="form" id="form">		
		<div class="tableForm mt20">
			<!-- ******** 컨텐츠 ********* -->
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></th>
					<td style="text-align:left;"><?=$strProdName?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00271"] //판매기간?></th>
					<td style="text-align:left;">
						<?=$strProdAucDate?>
						<span id="prodAuctionStatus"><?=$strProdAucStatusName?></span>
					</td>
				</tr>
			</table>
		</div>
		<div class="tableList">
			<table>
				<colgroup>
					<col style="width:50px;"/>
					<col style="width:100px;"/>
					<col/>
					<col/>
				</colgroup>
				<tr>
					<th></th>
					<th><?=$LNG_TRANS_CHAR["PW00272"] //입찰자ID?></th>
					<th><?=$LNG_TRANS_CHAR["PW00273"] //입찰일자?></th>
					<th><?=$LNG_TRANS_CHAR["PW00270"] //입찰가격?></th>
				</tr>
				<?
					if (is_array($arrRow)){
						foreach($arrRow as $key => $data){
							
							$intProdAucApplyNo			= $data['APPLY_NO'];
							$strProdAucApplyMemberName	= $data['APPLY_NAME'];
							$strProdAucApplyRegDate		= $data['APPLY_DATE'];
							$strProdAucApplyPrice		= $data['APPLY_PRICE'];
							$strProdAucApplyCurPrice	= $data['APPLY_CUR_PRICE'];
				?>
				<tr>
					<td><input type="checkbox" name="chkNo[]" id="chkNo[]" value="<?=$intProdAucApplyNo?>"></td>
					<td><?=$strProdAucApplyMemberName?></td>
					<td><?=$strProdAucApplyRegDate?></td>
					<td><?=$strProdAucApplyPrice?><?=$strProdAucApplyCurPrice?></td>
				</tr>
				<?
						}
					}
				?>
			</table>
		</div>
		<div class="paginate">
			<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$strLinkPage,"","")?>
		</div>
		<div class="buttonWrap">
			<?if($prodAucRow['P_AUC_STATUS'] == "5" && !$prodAucRow['P_AUC_SUC_M_NO']){?>
			<a class="btn_blue_big" href="javascript:goProdAucApplySucAct();" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["PW00275"]?></strong></a>
			<?}?>
			<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["PW00091"] //닫기?></strong></a>
		</div>
	</form>
</div>
</body>
</html>