<?
$aryColumnFilter=array('SH_NO','SH_TYPE','SH_COM_TYPE','SH_ADMISSION_DT','SH_REG_DT','SH_REG_NO','SH_MOD_DT','SH_MOD_NO',
	'SH_REQUEST_DT','SH_APPR','SH_APPR_NO_REASON','SH_COM_MAIN','SH_COM_PROD_AUTH',
	'SH_COM_FILE1',
	'SH_COM_COUNTRY1', 'SH_COM_COUNTRY2', 'SH_COM_COUNTRY3', 'SH_COM_COUNTRY4', 'SH_COM_COUNTRY5', 'SH_COM_COUNTRY6', 'SH_COM_COUNTRY7','SH_COM_COUNTRY8','SH_COM_COUNTRY9','SH_COM_COUNTRY10','SH_COM_COUNTRY11','SH_COM_COUNTRY12','SH_COM_COUNTRY13','SH_COM_COUNTRY14', 
	'SH_COM_CREDIT_GRADE','SH_COM_SALE_GRADE','SH_COM_LOCUS_GRADE','SH_COM_ACC_PRICE','SH_COM_ACC_RATE','SH_COM_DEPOSIT','SH_COM_BANK','SH_COM_BANK_NUM',
	'SH_COM_DELIVERY','SH_COM_DELIVERY_ST_PRICE','SH_COM_DELIVERY_PRICE','SH_COM_DELIVERY_COR','SH_COM_DELIVERY_FOR_COR','SH_COM_DELIVERY_FREE',
	'SH_COM_DEVLIERY_PROD','SH_COM_DELIVERY_AREA','SH_COM_DELIVERY_TEXT',
	'SH_COM_CERTIFICATES1','SH_COM_CERTIFICATES2','SH_COM_CERTIFICATES3','SH_COM_CERTIFICATES4','SH_COM_CERTIFICATES5',
	'SH_COM_UPTAE','SH_COM_UPJONG','SH_COM_ZIP','SH_COM_CITY','SH_COM_STATE','SH_COM_NUM2');
//print_r($shopRow);

$aryCertification =  array('SH_COM_CERTIFICATES1_FILE','SH_COM_CERTIFICATES2_FILE','SH_COM_CERTIFICATES3_FILE','SH_COM_CERTIFICATES4_FILE','SH_COM_CERTIFICATES5_FILE');
$intTotalColumn = 0;//총작성수
$intCheckColumn = 0;//유효작성수
$intCertification =0;//인증
$i=1;
foreach($shopRow as $key => $val){
	if(in_array($key , $aryColumnFilter)){
		continue;
	}
	if(intval($key)){
		continue;
	}

	if(in_array($key , $aryCertification)){
		if($val){
			$intCertification++;
		}
	}else{
		$intTotalColumn++;
	}
	
	$val = str_replace('-','',$val);// 전화번호등의 빈값이 들어갈수있음
	if(trim($val) != '' && !in_array($key , $aryCertification)){
		if($val != "0"){
			$intCheckColumn++;
		}
	}
	//echo $key."<br>";
	//echo $i++;
}

//주요유통시장율을 하나로 묶음
$intCheckColumn++;
$intCountryRate = 0;
$intCountryRate = $shopRow[SH_COM_COUNTRY1] + $shopRow[SH_COM_COUNTRY2] + $shopRow[SH_COM_COUNTRY3] + $shopRow[SH_COM_COUNTRY4] + $shopRow[SH_COM_COUNTRY5] + $shopRow[SH_COM_COUNTRY6] + $shopRow[SH_COM_COUNTRY7];
if($intCountryRate == 100){
	$intCheckColumn++;
}

//echo $intTotalColumn;
//echo "<br>";
//echo $intCheckColumn;
//echo "<br>";
//echo $intCertification;
//echo "<br>";
$intCheckPercent =  ceil(($intCheckColumn/$intTotalColumn)*100);


//총 상품수
$param['P_SHOP_NO'] = $intSH_NO;
$param['PRODUCT_INFO_LNG_JOIN']		= $S_SITE_LNG;
$intTotalProduct							= $productMgr->getProdListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수

//require_once MALL_CONF_LIB."ShopOrderNewMgr.php";
//$shopOrderMgr = new ShopOrderMgr();

//총 결제수(완료기준)
$param['searchShopNo']		= $intSH_NO;
$param['searchOrderStatus'] ='E';
$aryOrderResult					= $orderMgr->getOrderListEx($db, "OP_LIST", $param);					// 데이터 전체 개수

$intTotalOrder = 0 ;
while($orderRow = mysql_fetch_array($aryOrderResult))
{	
	$intTotalOrder =  (int)$intTotalOrder+(int)$orderRow[O_TOT_SPRICE];
}



//$intTotalOrder= 100000000;
$intCheckRating = 5;
//$intTotalProduct = 100;
//등록점수
if($intCheckPercent >= 95)
{
	$intPointColumn = 50;
}
else if($intCheckPercent > 80 && $intCheckPercent < 95 )
{
	$intPointColumn = 40;
}
else if($intCheckPercent <= 80)
{
	$intPointColumn = 30;
}

//상품등록 점수
if($intTotalProduct >= 50)
{
	$intPointPrdCnt = 30;
	$intPointPrdCnt2 = 20;
}
else if($intTotalProduct > 20 && $intTotalProduct < 50 )
{
	$intPointPrdCnt = 20;
	$intPointPrdCnt2 = 10;
}
else if($intTotalProduct <= 20)
{
	$intPointPrdCnt = 10;
	$intPointPrdCnt2 = 5;
}

// 고객상품평가 점수
if($intCheckRating >= 4.5 && $intCheckRating <= 5)
{
	$intPointRating = 30;
}
else if($intCheckRating > 4 && $intCheckRating > 4.5 )
{
	$intPointRating = 20;
}
else if($intCheckRating <= 4.5)
{
	$intPointRating = 0;
}

// 판매금액 점수
if($intTotalOrder >= 10000000)
{
	$intPointOrder = 20;
}
else if($intTotalOrder > 5000000 && $intTotalOrder < 10000000 )
{
	$intPointOrder = 10;
}
else if($intTotalOrder <= 5000000)
{
	$intPointOrder = 5;
}

//인증서 등록 점수
$intPointCertification = $intCertification*2;


//신용등급 총점
$intGradePointTotal = $intPointColumn + $intPointPrdCnt + $strSH_WORK_POINT + $intPointCertification - $strSH_GRADE_UNTRUTH_POINT;

//
$intOrderGradePoint	= (int)($intGradePointTotal * 0.3);
//판매등급 총점
$intOrderPointTotal = $intPointPrdCnt2 + $intPointOrder+ ($intGradePointTotal * 0.3) + $intPointRating - $strSH_PROD_UNTRUTH_POINT;



	## 스크립트 설정 
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/seller/shop/shopSite.js";

	## 파일 경로 설정
	if($storeRow['ST_LOGO'])		{ 	$st_logo		= "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_LOGO']}"; }
	if($storeRow['ST_IMG'])			{ 	$st_img			= "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_IMG']}"; }
	if($storeRow['ST_THUMB_IMG'])	{	$st_thumb_img	= "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_THUMB_IMG']}"; }
?>
<script>

function gradeKeyUpSum(){

	var intInfoCheck = $("#info_check").val();
	var intInfoPoint = $("#info_point").val();
	//var intProdCnt = $(".prod_cnt").val();
	var intProdPoint = $("#prod_point").val();
	var intWorkcheck = $("#work_check").val();
	//var intWorkPoint = $("#work_point").val();
	var intCertiCheck = $("#certi_check").val();
	var intCertiPoint = $("#certi_point").val();
	var intGradeUntruth = $("#grade_untruth").val();

	var intGradeUntruthPoint = intGradeUntruth * 50;
	$("#grade_untruth_point").val(intGradeUntruthPoint);

	var intWorkPoint = 0;
	if(intWorkcheck >= 90)
	{
		intWorkPoint = 20;
	}
	else if(intWorkcheck >= 70 && intWorkcheck < 90)
	{
		intWorkPoint = 10;
	}
	else if(intWorkcheck < 70)
	{
		intWorkPoint = 0;
	}

	$("#work_point").val(intWorkPoint);


	var intGradePointTotal  = parseInt(intInfoPoint) + parseInt(intProdPoint) + parseInt(intWorkPoint) + parseInt(intCertiPoint) - parseInt(intGradeUntruthPoint);

	$("#GradePointTotal").html(intGradePointTotal);

	var intGradePoint = intGradePointTotal * 0.3;
	$("#grade_point").val(intGradePoint);

	orderKeyUpSum();

}

function orderKeyUpSum(){
	//var intProdCnt = $(".prod_cnt").val();
	var intProdPoint = $("#prod_point2").val();
	var intOrderCheck = $("#order_check").val();
	var intOrderPoint = $("#order_point").val();

	var intGradePoint = $("#grade_point").val();

	var intRatingCheck = $("#rating_check").val();
	var intRatingPoint = $("#rating_point").val();

	var intProdUntruth = $("#prod_untruth").val();

	var intPprodUntruthPoint = intProdUntruth * 40;
	$("#prod_untruth_point").val(intPprodUntruthPoint);


	var intOrderPointTotal = parseInt(intProdPoint) + parseInt(intOrderPoint) + parseInt(intGradePoint) + parseInt(intRatingPoint) - parseInt(intPprodUntruthPoint);

	$("#OrderPointTotal").html(intOrderPointTotal);

	if(intOrderPointTotal >= 90){
			jQuery('input:radio[name="com_sale_grade"]:input[value="B"]').prop("checked", true); 
	}else if(intOrderPointTotal > 70 && intOrderPointTotal < 90){
			jQuery('input:radio[name="com_sale_grade"]:input[value="E"]').prop("checked", true); 
	}else if(intOrderPointTotal <= 70){
			jQuery('input:radio[name="com_sale_grade"]:input[value="G"]').prop("checked", true); 
	}
}
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?= $LNG_TRANS_CHAR["SW00082"]; //등급 심사 정보 ?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goMoveUrl('shopModify','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["BW00006"]; //회사정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopProduct','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["OW00022"]; //상품정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopGrade','<?=$intSU_NO?>');" class="selected"><?= $LNG_TRANS_CHAR["SW00082"]; //등급 심사 정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopSetting','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00083"]; //거래/배송정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopUser','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00084"]; //관리자정보 ?></a>	
	</div>
	<?if($a_admin_type == "A"):?>
	<!-- ******** 컨텐츠 ********* -->	
	<h3><?= $LNG_TRANS_CHAR["SW00108"]; //신용등급평가기준 ?></h3>
	<div class="tableFormWrap">
		<!--  ****************  -->
		<table class="tableForm">
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00109"]; //평가항목 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00115"]; //가중치 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00116"]; //등급구분 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00125"]; //평가기준 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00132"]; //배점 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00133"]; //기준/배점 결과 ?></th>
			</tr>
			<tr>
				<td rowspan="3"><?= $LNG_TRANS_CHAR["SW00110"]; //입점사 기본 등록정보 기입 ?></td>
				<td rowspan="3">50</td>
				<td><?= $LNG_TRANS_CHAR["SW00117"]; //등록정보 평가 ?> / <?= $LNG_TRANS_CHAR["SW00118"]; //상 ?></td>
				<td><?= $LNG_TRANS_CHAR["SW00126"]; //입점사 작성란 ?>95% <?= $LNG_TRANS_CHAR["SW00127"]; //이상 ?></td>
				<td>50</td>
				<td rowspan="3"><input type="text" id="info_check" name="info_check" value="<?=$intCheckPercent?>" style="width:20px;border:0;text-align:right;" readonly>% <input type="text" id="info_point" name="info_point" value="<?=$intPointColumn?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00117"]; //등록정보 평가 ?> / <?= $LNG_TRANS_CHAR["SW00119"]; //중 ?></td>
				<td><?= $LNG_TRANS_CHAR["SW00126"]; //입점사 작성란 ?>80~95%</td>
				<td>40</td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00117"]; //등록정보 평가 ?> / <?= $LNG_TRANS_CHAR["SW00120"]; //하 ?></td>
				<td><?= $LNG_TRANS_CHAR["SW00126"]; //입점사 작성란 ?>80% <?= $LNG_TRANS_CHAR["SW00128"]; //이하 ?></td>
				<td>30</td>
			</tr>
			<tr>
				<td rowspan="3"><?= $LNG_TRANS_CHAR["SW00111"]; //상품 등록 수 ?></td>
				<td rowspan="3">30</td>
				<td><?= $LNG_TRANS_CHAR["SW00121"]; //상품등록 개수 ?> / <?= $LNG_TRANS_CHAR["SW00118"]; //상 ?></td>
				<td>50<?= $LNG_TRANS_CHAR["SW00129"]; //개 ?> <?= $LNG_TRANS_CHAR["SW00127"]; //이상 ?></td>
				<td>30</td>
				<td rowspan="3"><input type="text" class="prod_cnt" name="prod_cnt" value="<?=$intTotalProduct?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00129"]; //개 ?> <input type="text" id="prod_point" name="prod_point" value="<?=$intPointPrdCnt?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00121"]; //상품등록 개수 ?> / <?= $LNG_TRANS_CHAR["SW00119"]; //중 ?></td>
				<td>21~50<?= $LNG_TRANS_CHAR["SW00129"]; //개 ?></td>
				<td>20</td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00121"]; //상품등록 개수 ?> / <?= $LNG_TRANS_CHAR["SW00120"]; //하 ?></td>
				<td>20<?= $LNG_TRANS_CHAR["SW00129"]; //개 ?> <?= $LNG_TRANS_CHAR["SW00128"]; //이하 ?></td>
				<td>10</td>
			</tr>
			<tr>
				<td rowspan="3"><?= $LNG_TRANS_CHAR["SW00112"]; //업체 실사 ?></td>
				<td rowspan="3">20</td>
				<td><?= $LNG_TRANS_CHAR["SW00122"]; //실사평가?> / <?= $LNG_TRANS_CHAR["SW00118"]; //상 ?></td>				
				<td>Offline checklist 90<?= $LNG_TRANS_CHAR["SW00135"]; //점 ?> <?= $LNG_TRANS_CHAR["SW00127"]; //이상 ?></td>
				<td>20</td>				
				<td rowspan="3"><input type="text" id="work_check" name="work_check" value="<?=$strSH_WORK_CHECK?>" style="width:20px;text-align:right;" onkeyup="gradeKeyUpSum()"><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?> <input type="text" id="work_point" name="work_point" value="<?=$strSH_WORK_POINT?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00122"]; //실사평가?> / <?= $LNG_TRANS_CHAR["SW00119"]; //중 ?></td>				
				<td>Offline checklist 80<?= $LNG_TRANS_CHAR["SW00135"]; //점 ?> <?= $LNG_TRANS_CHAR["SW00127"]; //이상 ?></td>
				<td>10</td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00122"]; //실사평가?> / <?= $LNG_TRANS_CHAR["SW00120"]; //하 ?></td>				
				<td>Offline checklist 70<?= $LNG_TRANS_CHAR["SW00135"]; //점 ?> <?= $LNG_TRANS_CHAR["SW00130"]; //미만 ?></td>
				<td>0</td>
			</tr>
			<tr>
				<td colspan="2"> <?= $LNG_TRANS_CHAR["SW00113"]; //인증 정보 기재시 ?> (Maximun 5)</td>
				<td><?= $LNG_TRANS_CHAR["SW00123"]; //인증서 등록 건당 ?></td>
				<td><?= $LNG_TRANS_CHAR["SW00131"]; //개당 2점 가산 ?></td>
				<td>2</td>
				<td><input type="text" id="certi_check" name="certi_check" value="<?=$intCertification?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00129"]; //개 ?> <input type="text" id="certi_point" name="certi_point" value="<?=$intPointCertification?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
			<tr>
				<td colspan="2"><?= $LNG_TRANS_CHAR["SW00114"]; //입점사 정보 허위기입 ?></td>
				<td><?= $LNG_TRANS_CHAR["SW00124"]; //적발시 ?></td>
				<td></td>
				<td>-50</td>
				<td><input type="text" id="grade_untruth" name="grade_untruth" value="<?=$strSH_GRADE_UNTRUTH?>" style="width:20px;text-align:right;" onkeyup="gradeKeyUpSum()" ><?= $LNG_TRANS_CHAR["SW00129"]; //개 ?> &nbsp;&nbsp;-<input type="text" id="grade_untruth_point" name="grade_untruth_point" value="<?=$strSH_GRADE_UNTRUTH_POINT?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
		</table>
		<div align="right" style="padding-right:20px;font-size:15pt;"><?= $LNG_TRANS_CHAR["SW00134"]; //총 ?> <span id="GradePointTotal"><?=$intGradePointTotal?></span><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></div>
	</div>

	<h3>판매등급평가기준</h3>
	<div class="tableFormWrap">
		<!--  ****************  -->
		<table class="tableForm">
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00109"]; //평가항목 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00115"]; //가중치 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00116"]; //등급구분 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00125"]; //평가기준 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00132"]; //배점 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00144"]; //비고 ?></th>
			</tr>
			<tr>
				<td rowspan="3"><?= $LNG_TRANS_CHAR["SW00111"]; //상품 등록 수 ?></td>
				<td rowspan="3">20</td>
				<td><?= $LNG_TRANS_CHAR["SW00121"]; //상품등록 개수 ?> / <?= $LNG_TRANS_CHAR["SW00118"]; //상 ?></td>
				<td>50<?= $LNG_TRANS_CHAR["SW00134"]; //개 ?> <?= $LNG_TRANS_CHAR["SW00127"]; //이상 ?></td>
				<td>20</td>
				<td rowspan="3"><input type="text" class="prod_cnt" name="prod_cnt" value="<?=$intTotalProduct?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00129"]; //개 ?> <input type="text" id="prod_point2" name="prod_point2" value="<?=$intPointPrdCnt2?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00121"]; //상품등록 개수 ?> / <?= $LNG_TRANS_CHAR["SW00119"]; //중 ?></td>
				<td>21~50<?= $LNG_TRANS_CHAR["SW00129"]; //개 ?></td>
				<td>10</td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00121"]; //상품등록 개수 ?> / <?= $LNG_TRANS_CHAR["SW00120"]; //하 ?></td>
				<td>20<?= $LNG_TRANS_CHAR["SW00134"]; //개 ?> <?=$LNG_TRANS_CHAR["SW00128"]; //이하 ?></td>
				<td>5</td>
			</tr>

			<tr>
				<td rowspan="3"><?= $LNG_TRANS_CHAR["SW00136"]; //판매금액 ?></td>
				<td rowspan="3">20</td>
				<td><?= $LNG_TRANS_CHAR["SW00136"]; //판매금액 ?> / <?= $LNG_TRANS_CHAR["SW00118"]; //상 ?></td>
				<td>1000<?= $LNG_TRANS_CHAR["SW00141"]; //만원 ?> <?= $LNG_TRANS_CHAR["SW00127"]; //이상 ?></td>
				<td>20</td>
				<td rowspan="3"><input type="text" id="order_check" name="order_check" value="<?=$intTotalOrder?>" style="width:20px;border:0;text-align:right;" readonly>원 <input type="text" id="order_point" name="order_point" value="<?=$intPointOrder?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00136"]; //판매금액 ?> / <?= $LNG_TRANS_CHAR["SW00119"]; //중 ?></td>
				<td>500~1000<?= $LNG_TRANS_CHAR["SW00141"]; //만원 ?></td>
				<td>10</td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00136"]; //판매금액 ?> / <?= $LNG_TRANS_CHAR["SW00120"]; //하 ?></td>
				<td>500<?= $LNG_TRANS_CHAR["SW00141"]; //만원 ?> <?= $LNG_TRANS_CHAR["SW00128"]; //이하 ?></td>
				<td>5</td>
			</tr>

			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00137"]; //입점사 신용등급 반영 ?></td>
				<td>30</td>
				<td></td>				
				<td>신용평가점수 * 0.3</td>
				<td>30</td>				
				<td><!--input type="text" name="grade_check" value="<?=$intGradePointTotal?>" style="width:20px;" readonly>점--> <input type="text" id="grade_point" name="grade_point" value="<?=$intOrderGradePoint?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
			<tr>
				<td rowspan="3"><?= $LNG_TRANS_CHAR["SW00138"]; //고객 상품평 ?></td>
				<td rowspan="3">30</td>
				<td><?= $LNG_TRANS_CHAR["SW00140"]; //고객평가 ?> / <?= $LNG_TRANS_CHAR["SW00118"]; //상 ?></td>				
				<td>4.5<?= $LNG_TRANS_CHAR["SW00127"]; //이상 ?> ~ 5.0</td>
				<td>30</td>				
				<td rowspan="3"><input type="text" id="rating_check" name="rating_check" value="<?=$intCheckRating?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?> <input type="text" id="rating_point" name="rating_point" value="<?=$intPointRating?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00140"]; //고객평가 ?> / <?= $LNG_TRANS_CHAR["SW00119"]; //중 ?></td>				
				<td>4.0<?= $LNG_TRANS_CHAR["SW00127"]; //이상 ?> ~ 4.5<?= $LNG_TRANS_CHAR["SW00130"]; //미만 ?></td>
				<td>20</td>
			</tr>
			<tr>
				<td><?= $LNG_TRANS_CHAR["SW00140"]; //고객평가 ?> / <?= $LNG_TRANS_CHAR["SW00120"]; //하 ?></td>				
				<td>4.0<?= $LNG_TRANS_CHAR["SW00130"]; //미만 ?></td>
				<td>0</td>
			</tr>
			<tr>
				<td colspan="2"><?= $LNG_TRANS_CHAR["SW00139"]; //상품정보 허위기입 ?></td>
				<td>적발시</td>
				<td><?= $LNG_TRANS_CHAR["SW00142"]; //상품당 ?> -40<br><?= $LNG_TRANS_CHAR["SW00143"]; //허위기입 적발시 입점사 신용등급하락 ?></td>
				<td>-40</td>
				<td><input type="text" id="prod_untruth" name="prod_untruth" value="<?=$strSH_PROD_UNTRUTH?>" style="width:20px;text-align:right;" onkeyup="orderKeyUpSum()" >개 &nbsp;&nbsp;-<input type="text" id="prod_untruth_point" name="prod_untruth_point" value="<?=$strSH_PROD_UNTRUTH_POINT?>" style="width:20px;border:0;text-align:right;" readonly><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></td>
			</tr>
		</table>
		<div align="right" style="padding-right:20px;font-size:15pt;"><?= $LNG_TRANS_CHAR["SW00134"]; //총 ?> <span id="OrderPointTotal"><?=$intOrderPointTotal?></span><?= $LNG_TRANS_CHAR["SW00135"]; //점 ?></div>
	</div>
	<?endif;?>
	<h3><?= $LNG_TRANS_CHAR["SW00145"]; //업체 등급 심사 ?></h3>
	<div class="tableFormWrap">
		<!--  ****************  -->
		<table class="tableForm">
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00147"]; //신용등급 ?></th>
				<td class="gradeIco">
					<input type="radio" id="com_credit_grade" name="com_credit_grade" value="G" <?=($strComCreditGrade == "G")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?>> <span class="gradeIco"><img src="<?=$aryCreditGradeImg["G"]?>" width="20"></span><?= $LNG_TRANS_CHAR["SW00149"]; //골드 ?>
					<input type="radio" id="com_credit_grade" name="com_credit_grade" value="S" <?=($strComCreditGrade == "S")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?>> <span class="gradeIco"><img src="<?=$aryCreditGradeImg["S"]?>" width="20"></span><?= $LNG_TRANS_CHAR["SW00150"]; //실버 ?>
					<input type="radio" id="com_credit_grade" name="com_credit_grade" value="B" <?=(!$strComCreditGrade || $strComCreditGrade == "B")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?>> <span class="gradeIco"><img src="<?=$aryCreditGradeImg["B"]?>" width="20"></span><?= $LNG_TRANS_CHAR["SW00151"]; //일반 ?>
				</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00146"]; //판매등급 ?></th>
				<td class="gradeIco">
					<input type="radio" id="com_sale_grade" name="com_sale_grade" value="B" <?=($strComSaleGrade == "B")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?>> <span class="gradeIco"><img src="<?=$arySaleGradeImg["B"]?>" width="20"></span><?= $LNG_TRANS_CHAR["SW00152"]; //최우수 ?>
					<input type="radio" id="com_sale_grade" name="com_sale_grade" value="E" <?=($strComSaleGrade == "E")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?>> <span class="gradeIco"><img src="<?=$arySaleGradeImg["E"]?>" width="20"></span><?= $LNG_TRANS_CHAR["SW00153"]; //우수 ?>
					<input type="radio" id="com_sale_grade" name="com_sale_grade" value="G" <?=(!$strComSaleGrade || $strComSaleGrade == "G")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?>> <span class="gradeIco"><img src="<?=$arySaleGradeImg["G"]?>" width="20"></span><?= $LNG_TRANS_CHAR["SW00154"]; //일반 ?>
				</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00148"]; //현장확인 ?></th>
				<td class="gradeIco">
					<input type="radio" id="com_locus_grade" name="com_locus_grade" value="N" <?=(!$strComLocusGrade || $strComLocusGrade == "N")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?>> <span class="gradeIco"><img src="<?=$aryLocusGradeImg["N"]?>" width="20"></span><?= $LNG_TRANS_CHAR["SW00156"]; //미확인 ?>
					<input type="radio" id="com_locus_grade" name="com_locus_grade" value="Y" <?=($strComLocusGrade == "Y")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?>> <span class="gradeIco"><img src="<?=$aryLocusGradeImg["Y"]?>" width="20"></span><?= $LNG_TRANS_CHAR["SW00155"]; //확인 ?>
				</td>
			</tr>
		</table>
	</div>
	<h3 class="mt30"><?=$LNG_TRANS_CHAR["SW00065"] //상품설정?></h3>
	<div class="tableFormWrap">
		<!--  ****************  -->
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00066"] //승인여부?></span></th>
				<td colspan="3">					
					<input type="radio" name="com_prod_auth" id="com_prod_auth" value="N" <?=(!$strComProdAuth || $strComProdAuth == "N")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?> /><?=$LNG_TRANS_CHAR["SW00067"] // 승인노출?>
					<input type="radio" name="com_prod_auth" id="com_prod_auth" value="Y" <?=($strComProdAuth == "Y")?"checked":"";?> <?=($a_admin_type != "A")?"disabled":"";?> /><?=$LNG_TRANS_CHAR["SW00068"] // 바로노출 ?>
				</td>
			</tr>
		</table>
	</div>
	<?if($a_admin_type == "A"):?>
	<div class="buttonBoxWrap">
		<a class="btn_new_gray" href="#"><strong class="ico_cancel">취소</strong></a>
		<a class="btn_new_blue" href="javascript:goAct('shopGrade');" id="menu_auth_m" style="display:none"><strong class="ico_modify">저장</strong></a>
	</div>
	<?endif;?>
</div>
<!-- ******** 컨텐츠 ********* -->