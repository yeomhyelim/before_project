<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."memberCateMgr.php";
	$memberCateMgr = new MemberCateMgr();

	$strCateCode			= $_REQUEST["cateCode"];

	## 검색 구매기간 설정
	$strSearchRegStartOption			= "editDay";
	$strSearchRegStartDt				= $_REQUEST['searchRegStartDt'];
	$strSearchRegEndDt					= $_REQUEST['searchRegEndDt'];
	if($strSearchRegStartOption == "editDay"):
		if($strSearchRegStartDt || $strSearchRegEndDt):
			if(!$strSearchRegStartDt)	{ $strSearchRegStartDt	= "1900-01-01"; }
			if(!$strSearchRegEndDt)		{ $strSearchRegEndDt	= "2200-01-01"; }
		endif;
	endif;

	$strSearchField					= $_REQUEST['searchField'];
	$strSearchKey					= $_REQUEST['searchKey'];

	## 소속명
	$param							= "";
	$param["C_LEVEL"]				= $_REQUEST['cateLevel'];
	$param["C_CODE"]				= $strCateCode;
	$param['O_REG_DT_BETWEEN'][0]	= $strSearchRegStartDt;
	$param['O_REG_DT_BETWEEN'][1]	= $strSearchRegEndDt;
	$param['O_SEARCH_KEY']			= $strSearchKey;
	$param['O_SEARCH_FIELD']		= $strSearchField;
	$param['O_SEARCH_STATUS']		= $_REQUEST['orderStatus'];
		
	$cateCodeRow					= $memberCateMgr->getMemberCateOrderSumEx($db,$param);
//	echo $db->query;

	$cateCodeNameRow				= $memberCateMgr->getMemberCateListEx($db,"OP_SELECT",$param);

	$strCateCodeName				= $cateCodeNameRow['C_NAME'];
	$intCateCodeTotSPrice			= $cateCodeRow['C_TOT_ORDER_SPRICE'];
	$intCateCodeTotPrice			= $cateCodeRow['C_TOT_ORDER_PRICE'];
	
	## 소속에 속한 회원 주문리스트
	$param							= "";
	$param["C_CODE"]				= $strCateCode;

	$param['O_REG_DT_BETWEEN'][0]	= $strSearchRegStartDt;
	$param['O_REG_DT_BETWEEN'][1]	= $strSearchRegEndDt;

	$param['O_SEARCH_KEY']			= $strSearchKey;
	$param['O_SEARCH_FIELD']		= $strSearchField;

	$param['O_SEARCH_STATUS']		= $_REQUEST['orderStatus'];

	$intPage						= $_REQUEST['page'];
	$intTotal						= $memberCateMgr->getMemberCateOrderListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수 
	
	$intPageLine					= 10;																					// 리스트 개수 
	$intPage						= ( $_REQUEST["page"] )		? $_REQUEST["page"]		: 1;
	$intFirst						= ( $intTotal == 0 )		? 0						: $intPageLine * ( $intPage - 1 );
	$param['ORDER_BY']				= $_REQUEST['orderBySort'];
	$param['LIMIT']					= "{$intFirst},{$intPageLine}";
	
	$result							= $memberCateMgr->getMemberCateOrderListEx($db,"OP_LIST",$param);
//	echo $db->query;
	$intPageBlock					= 10;																					// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );										// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );

	## 페이징 링크 주소
	$queryString	= explode("&", $_SERVER['QUERY_STRING']);
	$linkPage		= "";
	foreach($queryString as $string):
		list($key,$val)		= explode("=", $string);
		if($key == "page")	{ continue; }
		if($linkPage)		{ $linkPage .= "&"; }
		$linkPage		   .= $string;
	endforeach;

	$linkPage		= "./?{$linkPage}&page=";
?>
<? include "./include/header.inc.php"?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
	});
	
	function goSearch(){
		var data							= new Array(30);
		
		data['cateCode']					= $("#cateCode").val();
		data['searchRegStartDt']			= $("#searchRegStartDt").val();
		data['searchRegEndDt']				= $("#searchRegEndDt").val();

		data['searchKey']					= $("#searchKey").val();
		data['searchField']					= $("#searchField").val();

		data['orderStatus']					= $("#orderStatus").val();
		data['cateLevel']					= $("#cateLevel").val();		
		data['page']						= 1;
		
		C_getAddLocationUrl(data);	
	}

	/* CRM */
	function goMemberCrmView(no, tab)
	{
		var href = "./?menuType=member&mode=popMemberCrmView&tab="+tab+"&memberNo="+no;
		window.open(href, "CRM", "width=1100px,height=800px,scrollbars=yes");
	}

	function goOrderBySort(sort){

		var data							= new Array(30);
		
		data['cateCode']					= $("#cateCode").val();
		data['searchRegStartDt']			= $("#searchRegStartDt").val();
		data['searchRegEndDt']				= $("#searchRegEndDt").val();

		data['searchKey']					= $("#searchKey").val();
		data['searchField']					= $("#searchField").val();
		
		data['orderStatus']					= $("#orderStatus").val();
		data['cateLevel']					= $("#cateLevel").val();		

		data['page']						= $("#page").val();
		data['orderBySort']					= sort;
		
		C_getAddLocationUrl(data);	

	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>[<?=$strCateCodeName?>] 회원 구매내역</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
	<div id="contentWrap">
		<div class="paymentInfo mt20">
			<ul>
				<li>
					구매일자 :  <input type="text" id="searchRegStartDt" value="<?=$_REQUEST['searchRegStartDt']?>" data-simple-datepicker  style="width:80px"> -
								<input type="text" id="searchRegEndDt"   value="<?=$_REQUEST['searchRegEndDt']?>" data-simple-datepicker   style="width:80px">

					<a class="btn_blue_big" href="javascript:goSearch();" style="width:50px;text-align:center"><strong>검색</strong></a>

				</li>
				<li>
					검색어&nbsp;&nbsp;&nbsp;&nbsp;:
					<select id="searchField" style="width:133px">
						<option value=""		<?if($strSearchField == "")			{echo " selected";}?>>전체</option>
						<option value="id"		<?if($strSearchField == "id")		{echo " selected";}?>>아이디</option>
						<option value="name"	<?if($strSearchField == "name")		{echo " selected";}?>>이름</option>
						<option value="email"	<?if($strSearchField == "email")	{echo " selected";}?>>이메일</option>
						<option value="hp"		<?if($strSearchField == "hp")		{echo " selected";}?>>휴대폰</option>
					</select>
					<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> data-enter-event="goSearch" data-auto-focus/>
				</li>
				<li>구매확정된 총구매금액은 <?=NUMBER_FORMAT($intCateCodeTotPrice)?> / 총결제금액은 <?=NUMBER_FORMAT($intCateCodeTotSPrice)?> 입니다.</li>
			</ul>
		</div>
		<!-- (1) 회원 정보 -->
		<div class="tableList mt10">
			<form name="form" method="post">
			<input type="hidden" name="menuType" value="<?=$strMenuType?>">
			<input type="hidden" name="mode" value="<?=$strMode?>">
			<input type="hidden" name="act" value="<?=$strMode?>">
			<input type="hidden" name="page" id="page" value="<?=$intPage?>">
			<input type="hidden" name="cateCode" id="cateCode" value="<?=$strCateCode?>">
			<input type="hidden" name="cateLevel" id="cateLevel" value="<?=$_REQUEST['cateLevel']?>">
			<input type="hidden" name="orderStatus" id="orderStatus" value="<?=$_REQUEST['orderStatus']?>">
				<table style="border-left:1px solid #D2D0D0">
					<colgroup>
						<col style="width:8%;">
						<col style="width:30%;">
						<col style="width:30%;">
						<?if ($a_admin_level < 1){?><col /><?}?>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
						<th>
							<?="회원ID" //회원ID?>(<?="회원명" //회원명?>)
						</th>
						<th>
							<?="총구매금액" //총구매금액?>
							<a href="javascript:goOrderBySort('totPriceDesc');"><font color="#ffffff">▲</font></a>
							<a href="javascript:goOrderBySort('totPriceAsc');"><font color="#ffffff">▼</font></a>
						</th>
						<th>
							<?="총결제금액" //총결제금액?>
							<a href="javascript:goOrderBySort('totSPriceDesc');"><font color="#ffffff">▲</font></a>
							<a href="javascript:goOrderBySort('totSPriceAsc');"><font color="#ffffff">▼</font></a>
						</th>
						<?if ($a_admin_level < 1){?><th>-</th><?}?>
					</tr>
					<!-- (1) -->
					<?if($intTotal=="0"){?>
					<tr>
						<td colspan="4"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
					</tr>		
					<?}?>
					<?
						while($row = mysql_fetch_array($result)){
					?>
					<tr>
						<td><?=$intListNum--?></td>
						<td style="width:45px;margin:0 auto;">
							<?if($row[M_ID]){?><span><em><?=$row[M_ID]?></em></span><?}?>
							(<?=$row[M_L_NAME]?>)
							
						</td>
						<td><?=NUMBER_FORMAT($row[O_TOT_PRICE])?></td>
						<td><?=NUMBER_FORMAT($row[O_TOT_SPRICE])?></td>
						<?if ($a_admin_level < 1){?><td><a class="btn_blue_sml" href="javascript:goMemberCrmView('<?=$row[M_NO]?>', 'memberOrderList');"><strong><?="CRM" //CRM?></strong></a></td><?}?>
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
	</div>
</div>
</body>
</html>