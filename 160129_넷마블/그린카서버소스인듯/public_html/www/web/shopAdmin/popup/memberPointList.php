<?
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."PointMgr.php";
	
	$memberMgr = new MemberMgr();
	$pointMgr = new PointMgr();

	$intM_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
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
	
	$linkPage  = "?menuType=$strMenuType&mode=$strMode";
	$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$linkPage .= "&searchPointType=$strSearchPointType&no=$intM_NO";
	$linkPage .= "&page=";

	/* 포인트 종류 배열 */
	$aryPointTypeList = getCommCodeList('point');
	
	/* 포인트 소멸 일자 */
	$strPointEndDt = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+1));
?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$('input[name=pointEndDt]').simpleDatepicker();

		$('#pointPrice').numeric();
		$("#pointPrice").css("ime-mode", "disabled"); 
	});

	
	function goMemberPointAct()
	{
		if(!C_chkInput("pointPrice",true,"<?=$LNG_TRANS_CHAR['CW00034']?>",false)) return; //포인트
		if(!C_chkInput("pointEndDt",true,"<?=$LNG_TRANS_CHAR['MW00054']?>",false)) return; //포인트 소멸일자
		if(!C_chkInput("pointMemo",true,"<?=$LNG_TRANS_CHAR['MW00055']?>",false)) return; //포인트 설명
		
		document.form.menuType.value = "oper";
		C_getAction("pointWrite","./index.php");	
	
	}
//-->
</script>
<div id="contentArea">
	<table style="width:100%;">
		<tr>
			<td class="contentWrap">
				<!-- ******************** contentsArea ********************** -->
				<div class="layoutWrap">
					<div id="contentWrap">
						<div class="paymentInfo mt20">
							<ul>
								<li><?=callLangTrans($LNG_TRANS_CHAR["MS00008"],array($memberRow[M_ID],$memberRow[M_NAME],NUMBER_FORMAT($memberRow[M_POINT])))?></li>
							</ul>
						</div>
						<!-- (1) 회원 정보 -->
						<div class="tableOrderForm mt10">
						<form name="form" method="post">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="page" value="<?=$intPage?>">
						<input type="hidden" name="no" value="<?=$intM_NO?>">
							<h4><?=$LNG_TRANS_CHAR["MW00056"] //포인트 등록?></h4>
							<table>
								<colgroup>
									<col style="width:100px;"/>
									<col/>
								</colgroup>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00057"] //포인트 종류?></th>
									<td>
										<input type="radio" name="pointType" id="pointType" value="006" checked><?=$LNG_TRANS_CHAR["MW00060"] //관리자 증감?>
										<input type="radio" name="pointType" id="pointType" value="007"><?=$LNG_TRANS_CHAR["MW00061"] //관리자 감소?>
									</td>
									<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
									<td><input type="text" name="pointPrice" id="pointPrice" maxlength="10"></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00054"] //소멸일?></th>
									<td colspan="3">
										<input type="text" name="pointEndDt" id="pointEndDt" value="<?=$strPointEndDt?>" maxlength="10">
										(<?=$LNG_TRANS_CHAR["MS00009"] //포인트 감소일때는 소멸일자는 현재일자로 들어갑니다.?>)
									</td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00055"] //포인트 설명?></th>
									<td colspan="3"><input type="text" name="pointMemo" id="pointMemo" style="width:450px" maxlength="50"></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00058"] //기타 메모?></th>
									<td colspan="3"><input type="text" name="pointEtc" id="pointEtc"  style="width:450px"  maxlength="50"></td>
								</tr>
							</table>
						</form>
						</div>
						<div class="buttonWrap">
							<a class="btn_big" href="javascript:goMemberPointAct();"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
							<a class="btn_big" href="javascript:self.close();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //창닫기?></strong></a>
						</div>
						<!-- tableOrderForm -->						
						
						<div class="tableOrderForm mt30">
							<h4><?=$LNG_TRANS_CHAR["MW00062"] //포인트목록?></h4>
							<div class="tableList">
								<table style="border-left:1px solid #D2D0D0">
									<colgroup>
										<col style="width:8%;">
										<col style="width:20%;">
										<col style="width:20%;">
										<col />
										<col style="width:18%;">
									</colgroup>
									<tr>
										<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
										<th><?=$LNG_TRANS_CHAR["MW00057"] //포인트종류?></th>
										<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
										<th><?=$LNG_TRANS_CHAR["MW00055"] //포인트설명?></th>
										<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
									</tr>
									<!-- (1) -->
									<?if($intTotal=="0"){?>
									<tr>
										<td colspan="6"><?=$LNG_TRANS_CHAR["MW00055"] //등록된 데이터가 없습니다.?></td>
									</tr>		
									<?}?>
									<?
										while($row = mysql_fetch_array($result)){
									?>
									<tr>
										<td><?=$intListNum--?></td>
										<td style="width:45px;margin:0 auto;">
											<span><em><?=$row[POINT_TYPE_NM]?></em></span>
										</td>
										<td><?=NUMBER_FORMAT($row[PT_POINT])?></td>
										<td><?=$row[PT_MEMO]?></td>
										<td><?=$row[PT_REG_DT]?></td>
									</tr>
									<?
										}
									?>
								</table>
							</div>
							<!-- tableList -->

							<!-- Pagenate object --> 
							<div class="paginate" style="width:400px;padding:0px 5px;">  
								<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
							</div>  		
						</div><!-- tableOrderForm -->
					</div>
				</div>
				
				<!-- ******************** contentsArea ********************** -->
			</td>
		</tr>
	</table>
</div>
</body>
</html>