<?
	require_once MALL_CONF_LIB."PointMgr.php";
	
	$pointMgr = new PointMgr();
	
	if (!$intM_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["CS00013"]); //"해당 회원정보가 존재하지 않습니다."
		exit;
	}

	$memberMgr->setM_NO($intM_NO);
	$pointMgr->setM_NO($intM_NO);

	$memberRow = $memberMgr->getMemberView($db);

	$intPageBlock = 10;
	$intPageLine  = 10;
	$pointMgr->setPageLine($intPageLine);
	$pointMgr->setSearchKey($strSearchKey);
	$pointMgr->setSearchField($strSearchField);
	$pointMgr->setSearchPointType($strSearchPointType);

	$intTotal	= $pointMgr->getPointTotal($db);
	
	$intTotPage	= ceil($intTotal / $pointMgr->getPageLine());

	if(!$intPage)	$intPage =1;
	
	if ($intTotal==0) {
		$intFirst	= 1;
		$intLast	= 0;			
	} else {
		$intFirst	= $intPageLine *($intPage -1);
		$intLast	= $intPageLine * $intPage;
	}
	$pointMgr->setLimitFirst($intFirst);

	$result = $pointMgr->getPointList($db);		

	$intListNum = $intTotal - ($intPageLine *($intPage-1));		
	
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

	/* 포인트 종류 배열 */
	$aryPointTypeList = getCommCodeList('point');
	
	/* 포인트 소멸 일자 */
	$strPointEndDt = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+1));
?>

<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
	});

	/* 회원 포인트 [+-] */
	function goMemberPointWrite(no)
	{
		$.smartPop.open({  bodyClose: false, width: 500, height: 380, url: './?menuType=member&mode=popMemberPointWrite&memberNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	/* 레이어창 닫기 */
	function goPopClose()
	{
		location.reload();	
		$.smartPop.close();
	}
//-->
</script>

<div id="contentArea">
		<div class="paymentInfo mt20">
			<ul>
				<li><?=callLangTrans($LNG_TRANS_CHAR["MS00008"],array($memberRow[M_ID],$memberRow[M_NAME],NUMBER_FORMAT($memberRow[M_POINT])))?>
					<a class="btn_sml" href="javascript:goMemberPointWrite(<?=$memberRow[M_NO]?>);"><span>+/-</span></a></li>
			</ul>
		</div>
		<!-- (1) 회원 정보 -->
		<div class="tableList mt10">
				<table style="border-left:1px solid #D2D0D0">
					<colgroup>
						<col style="width:20%;">
						<col />
						<col />
						<col />
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
						<th><?=$LNG_TRANS_CHAR["MW00057"] //포인트종류?></th>
						<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
						<th><?=$LNG_TRANS_CHAR["MW00055"] //포인트설명?></th>
					</tr>
					<!-- (1) -->
					<?if($intTotal=="0"){?>
					<tr>
						<td colspan="6"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
					</tr>		
					<?}?>
					<?
						while($row = mysql_fetch_array($result)){
							if ($row[PT_POINT] > 0) $strPointGubun = "plus";
							else $strPointGubun = "minus";
					?>
					<tr>
						<td><?=$row[PT_REG_DT]?></td>
						<td class="alignLeft">
							<span><em><?=$row[POINT_TYPE_NM]?></em></span>
						</td>
						<td class="alignRight">
							<?=NUMBER_FORMAT($row[PT_POINT])?><img src="/shopAdmin/himg/common/icon_point_<?=$strPointGubun?>.gif" class="imngRIcon"/>
						</td>
						<td class="alignLeft"><?=$row[PT_MEMO]?></td>
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
</div>
</body>
</html>