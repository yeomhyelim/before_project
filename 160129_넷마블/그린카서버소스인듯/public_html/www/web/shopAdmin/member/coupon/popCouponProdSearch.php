<?php

	## 모듈설정
//	require_once MALL_CONF_LIB . 'ProductAdmMgr.php';
	$objProductListModule	= new ProductAdmListModule($db);
//	$productMgr = new ProductAdmMgr();
//	$productMgr->setP_LNG($strAdmSiteLng);

	## 기본설정
	$strOrder = $_GET['order'];
	$intPage = $_GET['page'];
	$intPageLine = $_GET['pageLine'];
	$strWelfareNo = $_GET['searchWelfareNo'];
	$strSearchBrand = $_GET['searchBrand'];
	$strSearchRegStartDt = $_GET['searchRepStartDt'];
	$strSearchRegEndDt = $_GET['searchRepEndDt'];
	$strSearchLaunchStartDt = $_GET['searchLaunchStartDt'];
	$strSearchLaunchEndDt = $_GET['searchLaunchEndDt'];
	$strSearchCateHCode1 = $_GET['searchCateHCode1'];
	$strSearchCateHCode2 = $_GET['searchCateHCode2'];
	$strSearchCateHCode3 = $_GET['searchCateHCode3'];
	$strSearchCateHCode4 = $_GET['searchCateHCode4'];
	$strSearchField = $_GET['searchField'];
	$strSearchKey = $_GET['searchKey'];

	## 언어 설정
	$strLang = $_GET['lang'];
	if(!$strLang) $strLang = $S_SITE_LNG;
	$strStLngLower = strtolower($strStLng);


	## 카테고리 설정
	$strCate = '';
	if($strSearchCateHCode1) $strCate = $strSearchCateHCode1;
	if($strSearchCateHCode2) $strCate = $strSearchCateHCode2;
	if($strSearchCateHCode3) $strCate = $strSearchCateHCode3;
	if($strSearchCateHCode4) $strCate = $strSearchCateHCode4;
	if($strCate):
		$intCateCnt = strlen($strCate);
		if($intCateCnt > 0) $strSearchProdCate1 = substr($strCate, 0, 3);
		if($intCateCnt > 3) $strSearchProdCate2 = substr($strCate, 0, 6);
		if($intCateCnt > 6) $strSearchProdCate3 = substr($strCate, 0, 9);
		if($intCateCnt > 9) $strSearchProdCate4 = substr($strCate, 0, 12);
	endif;

	## 상품 출력(다국어)사용 여부
	if($S_PROD_MANY_LANG_VIEW == 'Y'):
		$param['P_MANY_LNG_VIEW']		= 'Y';
		$param['P_USE_LNG']				= explode('/', $S_USE_LNG);
	endif;

	## 복지사 검색(복지사로 로그인 했을 경우 복지사로만 검색되도록 변경)
	if($a_admin_type == 'W') $strWelfareNo = $a_admin_weal_no;

	## 데이터 불러오기
	$param								= '';
	$param["P_LNG"]						= $strLang;
	$param['P_AUTH']					= 'Y';
	$param['P_VIEW']					= 'webYes';
	$param['P_BRAND']					= $strSearchBrand;
	$param['WELFARE_NO']				= $strWelfareNo;
	$param['P_REP_START_DT']			= $strSearchRegStartDt;
	$param['P_REP_END_DT']				= $strSearchRegEndDt;
	$param['P_LAUNCH_START_DT']			= $strSearchLaunchStartDt;
	$param['P_LAUNCH_END_DT']			= $strSearchLaunchEndDt;
	$param['P_SEARCH_FIELD']			= $strSearchField;
	$param['P_SEARCH_KEY']				= $strSearchKey;
	$param['P_CATE']					= $strCate;
	$intTotal							= $objProductListModule->getProductListSelectEx("OP_COUNT", $param);			// 데이터 전체 개수
	$intPageLine						= ( $intPageLine )		? $intPageLine	: 10;									// 리스트 개수
	$intPage							= ( $intPage )			? $intPage		: 1;
	$intFirst							= ( $intTotal == 0 )	? 0				: $intPageLine * ( $intPage - 1 );

	$param['P_IMG_SHOW']				= 'Y';
	$param['P_SEARCH_SORT']				= $strOrder;
	$param['LIMIT_LINE']				= $intPageLine;
	$param['LIMIT']						= $intFirst;
	$resResult							= $objProductListModule->getProductListSelectEx("OP_LIST", $param);
	$intPageBlock						= 10;																		// 블럭 개수
	$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage							= ceil( $intTotal / $intPageLine );


	## paging 설정
	$intPage			= $intPage;									// 현재 페이지
	$intTotPage			= $intTotPage;								// 전체 페이지 수
	$intTotBlock		= ceil($intTotPage / $intPageBlock);		// 전체 블럭 수
	$intBlock			= ceil($intPage / $intPageBlock);			// 현재 블럭
	$intPrevBlock		= (($intBlock - 2) * $intPageBlock) + 1;	// 이전 블럭
	$intNextBlock		= ($intBlock * $intPageBlock) + 1;			// 다음 블럭
	$intFirstBlock		= (($intBlock - 1) * $intPageBlock) + 1;	// 현재 블럭 시작 시저
	$intLastBlock		= $intBlock * $intPageBlock;				// 현재 블럭 종료 시점

	if($intFirstBlock <= 0) { $intFirstBlock = 1; }
	if($intPrevBlock  <= 0) { $intPrevBlock	= 1; }
	if($intNextBlock >= $intTotPage) { $intNextBlock	= $intTotPage; }
	if($intLastBlock >= $intTotPage) { $intLastBlock	= $intTotPage; }

	## 5. 페이징 링크 주소
	$queryString	= explode("&", $_SERVER['QUERY_STRING']);
	$linkPage		= "";
	foreach($queryString as $string):
		list($key,$val)		= explode("=", $string);
		if($key == "page")	{ continue; }
		if($linkPage)		{ $linkPage .= "&"; }
		$linkPage		   .= $string;
	endforeach;
	$linkPage		= "./?{$linkPage}&page=";


	include './include/header.inc.php';
?>
<script language="javascript" type="text/javascript" src="/common/js/jquery-1.8.24-ui.min.js"></script>
<script>
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
$(document).ready(function(){
	// 부모창에 쿠폰적용 상품리스트가 존재하면 가져온다.
	var $parentList = $('input[name="productExpCode[]"]', parent.document) ;
	if ( $parentList.length > 0 )
		$('.default_result').append( $('#ulExpProd', parent.document).html() ).trigger('create') ;

	// 쿠폰적용 상품리스트 , 검색 상품리스트 상호 드랍 & 드래그 지원
	$('.default_result , .search_result').droppable({
		connectToSortable:'.default_result , .search_result' ,
		drop: function ( e, ui ) {
			if ( $(this).attr('class') == ui.draggable.parent().attr('class') )
				return ;
			ui.draggable.parent().find('li:eq(' + ui.draggable.parent().find('li').index( ui.draggable ) + ')').trigger('dblclick') ;
		}
	}).sortable() ;

	$(document).on('dblclick' , '.search_result li' , function(){
		var data = $(this).data('product-info') ;
		if ( $('#default_product').find('input[value="' + data['P_CODE'] + '"]').length > 0 )
			return alert ( '이미 쿠폰리스트에 존재하는 상품입니다.' ) ;
		$('#default_product ul').prepend( $('<li class="ExpProdLine"><input type="hidden" name="productExpCode[]" value="' + data['P_CODE'] + '"><img src="' + data['PM_REAL_NAME'] + '" style="width:50px;height:50px;">' + decodeURIComponent ( data['P_NAME'] ) + '</li>') ).trigger('create') ;
		$('#ulExpProd', parent.document).prepend( $('<li class="ExpProdLine"><input type="hidden" name="productExpCode[]" value="' + data['P_CODE'] + '"><img src="' + data['PM_REAL_NAME'] + '" style="width:50px;height:50px;">' + decodeURIComponent ( data['P_NAME'] ) + '</li>') ).trigger('create') ;
	});

	$(document).on('dblclick' , '.default_result li' , function(){
		if ( confirm ( '쿠폰목록에서 제외하시겠습니까? ' ) )
		{
			$('input[name="productExpCode[]"][value="' + $(this).find('input[name="productExpCode[]"]').val() + '"]', parent.document).closest('li').remove() ;
			$(this).remove() ;
		}
	});

	var strHCode = "";
	callCateList(1,"","","searchCateHCode1","<?=$strSearchCateHCode1?>");
	<?php if($strSearchCateHCode1):?>
	callCateList(2,"<?=$strSearchCateHCode1?>","","searchCateHCode2","<?php echo $strSearchCateHCode2;?>");
	<?php endif;?>
	<?php if($strSearchCateHCode2):?>
	callCateList(3,"<?=$strSearchCateHCode1.$strSearchCateHCode2?>","","searchCateHCode3","<?php echo $strSearchCateHCode3;?>");
	<?php endif;?>
	<?php if($strSearchCateHCode3):?>
	callCateList(4,"<?=$strSearchCateHCode1.$strSearchCateHCode2.$strSearchCateHCode3?>","","searchCateHCode4","<?php echo $strSearchCateHCode4;?>");
	<?php endif;?>

	$("#searchCateHCode1").change(function() {
		if ($(this).val())
			callCateList(2,$(this).val(),"","searchCateHCode2");
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



function goSearch(mode){
	C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
}
</script>
<style type="text/css">
#default_product	{ float:left; display:block; width:48%; height:600px; overflow-y:scroll ; }
#between_space		{ float:left; display:block; width:3%; height:600px;}
#search_product		{ float:left; display:block; width:48%; height:600px; overflow-y:scroll ; }
</style>
<form name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="page" value="<?=$intPage?>">
<!-- start title //-->
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?php echo $LNG_TRANS_CHAR["MW00151"] //쿠폰적용상품?></h2>
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>
</div>
<!-- end title //-->
<!-- start search //-->
<div class="tableFormWrap">
	<table class="tableForm">
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00027"] //카테고리선택?></th>
			<td>
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
			<td>
				<select name="searchField" id="searchField">
					<option value="name"<?php if($strSearchField=='name'){echo ' selected';}?>><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
					<option value="code"<?php if($strSearchField=='code'){echo ' selected';}?>><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
					<option value="maker"<?php if($strSearchField=='maker'){echo ' selected';}?>><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
					<option value="orgin"<?php if($strSearchField=='orgin'){echo ' selected';}?>><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
					<option value="model"<?php if($strSearchField=='model'){echo ' selected';}?>><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
				</select>
				<input type="text" <?=$nBox?>  style="width:150px;" id="searchKey" name="searchKey" value="<?php echo $strSearchKey;?>"/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00008"] //상품출시일?></th>
			<td>
				<input type="text" <?=$nBox?> name="searchLaunchStartDt" data-simple-datepicker readOnly value="<?php echo $strSearchLaunchStartDt;?>"/> ~
				<input type="text" <?=$nBox?> name="searchLaunchEndDt" data-simple-datepicker readOnly value="<?php echo $strSearchLaunchEndDt;?>"/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00009"] //상품등록일?></th>
			<td>
				<input type="text" <?=$nBox?> name="searchRepStartDt" data-simple-datepicker readOnly value="<?php echo $strSearchRepStartDt;?>"/> ~
				<input type="text" <?=$nBox?> name="searchRepEndDt" data-simple-datepicker readOnly value="<?php echo $strSearchRepEndDt;?>"/>
				<a class="btn_blue_big" href="javascript:goSearch('popCouponProdSearch');"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			※ 적용상품 제외 : 좌측 쿠폰 적용 상품을 더블클릭 또는 우측의 검색된 상품쪽으로 마우스로 드래그해 옮기세요.<br>
			※ 검색상품 추가 : 우측 검색된 상품을 마우스로 더블클릭 또는 좌측의 쿠폰적용 상품쪽으로 마우스로 드래그해 옮기세요.<br>
			<span style="color:red;">※ 리스트 적용을 원하시면 쿠폰관리창 하단 수정을 눌러 저장하세요.</span>
			</td>
		</tr>
	</table>
</div>
</form>
<hr/>
<div id="default_product">
	<h2>쿠폰 적용 상품 리스트</h2>
	<ul class="default_result"></ul>
</div>
<div id="between_space"></div>
<div id="search_product" class="popDefault_result">
	<h2>검색 상품 리스트</h2>
	<?php if(!$intTotal):?>
	<p>검색된 상품이 없습니다.</p>
	<?php else:?>
	<ul style="display:none">
		<li>
			<div class="prodImg">이미지</div>
			<div class="prodInfo">
				<dl>
					<dd>상품명</dd>
					<dd>상품코드</dd>
					<dd>판매가격</dd>
					<dd>남은수량</dd>
					<dd>등록일</dd>
				</dl>
			</div>
			<div class="clr"></div>
		</li>
	</ul>
	<ul class="search_result">
	<?php
	while ( $row = mysql_fetch_array ( $resResult ) ) :
		$productInfo = json_encode
		(
			array
			(
				'P_CODE'		=> $row['P_CODE'] ,
				'PM_REAL_NAME'	=> $row['PM_REAL_NAME'] ,
				'P_NAME'		=> rawurlencode ( $row['P_NAME'] ) ,
			)
		) ;
	?>
		<li data-product-info=<?=$productInfo?>>
			<div class="prodImg"><img src="<?=$row['PM_REAL_NAME']?>" style="width:50px;height:50px;"></div>
			<div class="prodInfo">
				<dl>
					<dd class="tit">상품명 : <span><?=$row['P_NAME']?></span></dd>
					<dd>상품코드 : <span><?=$row['P_CODE']?></span></dd>
					<dd>판매가격 : <span><?=number_format ( $row['P_SALE_PRICE'] )?>원</span></dd>
					<!-- <dd>남은 수량 : <span><?=number_format ( $row['P_QTY'] )?>ea</span></dd> -->
					<dd>등록일 : <span><?=substr ( $row['P_REG_DT'] , 0 , 10 )?></span></dd>
				</dl>
			</div>
			<div class="clr"></div>
		</li>
	<?php endwhile;?>
	</ul>
	<?php endif;?>

	<div class="paginate" style="width:300px;margin:20px;">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
</div>
<!-- end search //-->
