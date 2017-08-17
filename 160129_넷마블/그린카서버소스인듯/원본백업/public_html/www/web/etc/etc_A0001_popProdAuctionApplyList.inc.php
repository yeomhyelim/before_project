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
	$param['NOT_AUC_STATUS']	= "'1','3'";
	$param['P_AUC_DT']			= "Y";
	$prodAucRow					= $objProductAuctionModule->getProductAuctionViewEx($param);

	if (!$prodAucRow){
		goUrl($LNG_TRANS_CHAR["PS00025"]); //해당상품에 대한 입찰정보가 존재하지 않습니다.
		echo "<script language='javascript'>parent.goOpenWinSmartPopClose();</script>";
		exit;
	}
	
	## 변수 선언
	$strProdName				= $prodAucRow['P_NAME'];
	$strProdAucDate				= $prodAucRow['P_AUC_ST_DT']." ~ ".$prodAucRow['P_AUC_END_DT'];
	switch($prodAucRow['P_AUC_STATUS']){
		case "2":
			$strProdAucStatusName = "진행중";
		break;
		case "4":
			$strProdAucStatusName = "완료";
		break;
		case "5":
			$strProdAucStatusName = "종료";
		break;
	}

	## 마이페이지에서 클릭시 해당 경매신청 데이터중 내것만 가지고 오기
	if ($_GET['prodAucMyList'] == "Y" && $g_member_no){
		$param['PAA_APPLY_M_NO'] = $g_member_no;	
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
	
	$param['LIMIT_START']	= $intFirst;
	$param['LIMIT_END']		= $intLast;
	$prodAucApplyResult		= $objProductAuctionModule->getProductAuctionApplySelectEx("OP_LIST",$param);
	
	$arrRow					= "";
	if ($intTotal > 0){
		$intCount			= 0;
		while($prodAucApplyRow = mysql_fetch_array($prodAucApplyResult)){
			
			$strProdAucApplyMemberName			= "";
			$strProdAucApplyRegDate				= "";
			$intProdAucApplyPrice				= 0;

			if ($prodAucApplyRow['M_F_NAME']) $strProdAucApplyMemberName  = $prodAucApplyRow['M_F_NAME']." ";
			if ($prodAucApplyRow['M_L_NAME']) $strProdAucApplyMemberName .= $prodAucApplyRow['M_L_NAME'];
			$strProdAucApplyMemberName = strHanCutUtf2($strProdAucApplyMemberName, 1,false,'**');

			$strProdAucApplyRegDate				= $prodAucApplyRow['PAA_REG_DT'];
			$intProdAucApplyPrice				= $prodAucApplyRow['PAA_CUR_PRICE'];
			
			$strPriceLeftMark					= getCurMark($prodAucApplyRow['PAA_USE_CUR']);
			if ($strPriceLeftMark) $strPriceLeftMark .= " ";
			$strPriceRightMark					= getCurMark2($prodAucApplyRow['PAA_USE_CUR']);

			$arrRow[$intCount]['APPLY_NAME']	= $strProdAucApplyMemberName;
			$arrRow[$intCount]['APPLY_DATE']	= $strProdAucApplyRegDate;
			$arrRow[$intCount]['APPLY_PRICE']	= $strPriceLeftMark.getFormatPrice($intProdAucApplyPrice,2,$prodAucApplyRow['PAA_USE_CUR']).$strPriceRightMark;
			
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
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	
	var strProdCode				= "<?=$strProdCode?>";
	
	$(document).ready(function(){
	});

//-->
</script>
<body>
<div class="popContainer">
	<div class="cancelHight">
	<h2><?=$LNG_TRANS_CHAR["PW00067"]; //경매기록보기?></h2>
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
					<th><?=$LNG_TRANS_CHAR["PW00064"] //판매기간?></th>
					<td style="text-align:left;">
						<?=$strProdAucDate?>
						<span id="prodAuctionStatus"><?=$strProdAucStatusName?></span>
					</td>
				</tr>
			</table>
		</div>
		<div class="popTableList">
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00065"] //입찰자ID?></th>
					<th><?=$LNG_TRANS_CHAR["PW00066"] //입찰일자?></th>
					<th><?=$LNG_TRANS_CHAR["PW00063"] //입찰가격?></th>
				</tr>
				<?
					if (is_array($arrRow)){
						foreach($arrRow as $key => $data){

							$strProdAucApplyMemberName	= $data['APPLY_NAME'];
							$strProdAucApplyRegDate		= $data['APPLY_DATE'];
							$strProdAucApplyPrice		= $data['APPLY_PRICE'];
				?>
				<tr>
					<td><?=$strProdAucApplyMemberName?></td>
					<td><?=$strProdAucApplyRegDate?></td>
					<td><?=$strProdAucApplyPrice?></td>
				</tr>
				<?
						}
					}
				?>
			</table>
		</div>
		<div id="pagenate">
			<?=drawUserPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$strLinkPage,"","","",""," | ")?>
		</div>
		
		<div class="btnCenter">
			<a href="javascript:parent.goOpenWinSmartPopClose();" class="popCloseBtn"><span><?=$LNG_TRANS_CHAR["CW00034"]; //닫기?></span></a>
		</div>
	</div>
</div>
</form>
</body>
</html>