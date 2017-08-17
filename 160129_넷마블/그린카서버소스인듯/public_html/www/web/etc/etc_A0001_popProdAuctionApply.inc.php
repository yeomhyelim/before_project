<?
	## 클래스 설정
	$objProductAuctionModule	= new ProductAuctionModule($db);
	## 상품함수관련
	require_once MALL_PROD_FUNC;
		
	$strProdCode				= $_GET['prodCode'];
	
	## 로그인 체크
	if (!$g_member_no){
		echo "<script language='javascript'>parent.goLoginPageMove('".$strProdCode."');</script>";
		exit;
	}
	
	## 입찰정보 
	$param						= "";
	$param['P_CODE']			= $strProdCode;
	$param['P_LNG']				= $S_SITE_LNG;
	$param['P_AUC_STATUS']		= 2;
	$prodAucRow					= $objProductAuctionModule->getProductAuctionViewEx($param);

	if (!$prodAucRow){
		goUrl($LNG_TRANS_CHAR["PS00025"]); //해당상품에 대한 입찰정보가 존재하지 않습니다.
		echo "<script language='javascript'>parent.goOpenWinSmartPopClose();</script>";
		exit;
	}
	
	## 변수 선언
	$strPriceLeftMark			= getCurMark();
	if ($strPriceLeftMark) $strPriceLeftMark .= " ";
	$strPriceRightMark			= getCurMark2();

	$strProdName				= $prodAucRow['P_NAME'];
	$intProdAucMaxPrice			= ($prodAucRow['P_AUC_BEST_PRICE']) ? $prodAucRow['P_AUC_BEST_PRICE'] : $prodAucRow['P_AUC_ST_PRICE'];
	$strProdAucMaxPrice			= $strPriceLeftMark.getCurToPrice($intProdAucMaxPrice).$strPriceRightMark;
	$intProdAucMaxCurPrice		= getCurToPriceSave($intProdAucMaxPrice);

	$intProdAucRightCurPrice	= getCurToPriceSave($prodAucRow['P_AUC_RIGHT_PRICE']);
	$strProdAucRightPrice		= "(".$LNG_TRANS_CHAR["PW00056"]." ".$strPriceLeftMark.getCurToPrice($prodAucRow['P_AUC_RIGHT_PRICE']).$strPriceRightMark.")";
	
	$intProdAucMinPrice			= $prodAucRow['P_AUC_ST_PRICE'];
	$strProdAucMinPrice			= $strPriceLeftMark.getCurToPrice($intProdAucMinPrice).$strPriceRightMark;	
	
	$intProdAucPriceUnit		= getCurToPriceSave(1000);
	$strProdAucPriceUnit		= $strPriceLeftMark.getCurToPrice(1000).$strPriceRightMark;
	$strProdAucPriceUnitStep	= $strPriceLeftMark.getCurToPrice(1000).$strPriceRightMark;
	$strProdAucPriceUnitStep   .= ",".$strPriceLeftMark.getCurToPrice(2000).$strPriceRightMark;
	$strProdAucPriceUnitStep   .= ",".$strPriceLeftMark.getCurToPrice(3000).$strPriceRightMark;
	
	## 중국어일때 USD 표시
	if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
		$strPriceUsdMark			 = getCurMark("USD")." ";
		
		$intProdAucMaxCurPrice		= getCurToPriceSave($intProdAucMaxPrice,"US");
		$intProdAucRightCurPrice	= getCurToPriceSave($prodAucRow['P_AUC_RIGHT_PRICE'],"US");

		$intProdAucPriceUnit		 = getCurToPriceSave(1000,"US");
		$strProdAucMinPrice			 = $strPriceUsdMark.getCurToPrice($intProdAucMinPrice,"US");	
		$strProdAucMinPrice			.= "(".getCurLeftMark($S_SITE_LNG).getCurToPrice($intProdAucMinPrice);
		
		$strProdAucPriceUnit		 = $strPriceUsdMark.getCurToPrice(1000,"US");
		$strProdAucPriceUnitStep	 = $strPriceUsdMark.getCurToPrice(1000,"US");
		$strProdAucPriceUnitStep	.= ",".$strPriceUsdMark.getFormatPrice(getCurToPriceSave(1000,"US") * 2,2);
		$strProdAucPriceUnitStep	.= ",".$strPriceUsdMark.getFormatPrice(getCurToPriceSave(1000,"US") * 3,2);			
	}
	
	//입찰 가능한 최소 금액은 [ㅇㅇㅇㅇ]입니다.
	$strProdAucPriceText			= callLangTrans($LNG_TRANS_CHAR["PS00026"],array($strProdAucMinPrice));
	
	//입찰금액은 1,000단위로 입찰할 수 있습니다.(1,000원,2000원,3,000원)
	$strProdAucText					= callLangTrans($LNG_TRANS_CHAR["PS00027"],array($strProdAucPriceUnit,$strProdAucPriceUnitStep)); 

?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	
	var intProdAucPriceUnit		= "<?=$intProdAucPriceUnit?>";
	var strProdAucPriceUnit		= "<?=$strProdAucPriceUnit?>";						//이력단위
	var intProdAucMaxCurPrice	= parseFloat("<?=$intProdAucMaxCurPrice?>");		//현재가
	var intProdAucRightCurPrice = parseFloat("<?=$intProdAucRightCurPrice?>");		//즉시구매가
	var strProdCode				= "<?=$strProdCode?>";
	
	$(document).ready(function(){
		<?if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP" && $S_SITE_LNG != "RU"){?>
		$('#aucPrice').alphanumeric({allow:"."});
		<?}else{?>
		$('#aucPrice').numeric();
		<?}?>		
	});

	function goAucAct(){
		if(!C_chkInput("aucPrice",true,"<?=$LNG_TRANS_CHAR['PW00063']?>",true)) return; //입찰가
		
		var intAucPrice = parseFloat($("#aucPrice").val());				
		if (intAucPrice % intProdAucPriceUnit != 0)
		{
			alert("<?=$strProdAucText?>");
			$("#aucPrice").val("");
			return;
		}
		
		if (intAucPrice <= intProdAucMaxCurPrice)
		{
			alert("<?=$LNG_TRANS_CHAR['PS00028']?>"); //현재가보다 큰 금액을 입력하셔야 합니다.
			return;
		}
		
		if (intAucPrice > intProdAucRightCurPrice)
		{
			alert("<?=$LNG_TRANS_CHAR['PS00029']?>"); //즉시구매를 이용해주세요.
			return;
		}
		
		var data			= new Object();
		data['menuType']	= "product";
		data['mode']		= "json";
		data['act']			= "prodAuctionApply";
		data['aucPrice']	= intAucPrice;
		data['prodCode']	= strProdCode;
		
		//C_getSelfAction(data);
		C_getJsonAjaxAction("prodAuctionApply","./index.php",data);
		return;
	}

	function goAjaxRet(name,result){
		if (name == "prodAuctionApply")
		{			
			var data = eval(result);
			if (data[0].RET == "Y"){
				alert("<?=$LNG_TRANS_CHAR['PS00032']?>");
				parent.location.reload();
				//parent.goOpenWinSmartPopClose();
			}
			
			if (data[0].RET == "N"){
				alert(data[0].MSG);
				return;
			}
		}
	}
//-->
</script>
<body>
<div class="popContainer">
	<div class="cancelHight">
	<h2><?=$LNG_TRANS_CHAR["PW00061"]; //입찰하기?></h2>
	<form name='form' method='post'>
	<div class="mt10">
		<div class="popTableList">
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00058"] //상품명?></th>
					<td style="text-align:left;"><?=$strProdName?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00055"] //현재최고가?></th>
					<td style="text-align:left;"><?=$strProdAucMaxPrice?><?=$strProdAucRightPrice?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00063"] //입찰가?></th>
					<td style="text-align:left;">
						<ul>
							<li>
								<input type="text" name="aucPrice" id="aucPrice" value="">
							</li>
							<li>
								* <?=$strProdAucPriceText?>
							</li>
						</ul>
					</td>
				</tr>
			</table>
			<div class="mt10">
				* <?=$strProdAucText?>
			</div>
		</div>
		
		<div class="btnCenter">
			<a href="javascript:goAucAct();" class="popOrderCancelBtn" id="btnOrderCancel"><span><?=$LNG_TRANS_CHAR["PW00061"]; //입찰하기?></span></a>
			<a href="javascript:parent.goOpenWinSmartPopClose();" class="popCloseBtn"><span><?=$LNG_TRANS_CHAR["CW00034"]; //닫기?></span></a>
		</div>
	</div>
</div>
</form>
</body>
</html>