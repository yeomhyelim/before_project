<? include "./include/header.inc.php"?>
<?
	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;	

	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."PointMgr.php";
	
	$memberMgr = new MemberMgr();
	$pointMgr = new PointMgr();
	
	$intM_NO	= $_POST["memberNo"]			? $_POST["memberNo"]			: $_REQUEST["memberNo"];
	$strGubun	= $_POST["gb"]					? $_POST["gb"]					: $_REQUEST["gb"];	
	if (!$strGubun) $strGubun = "1";
	
	if ($strGubun == "1") {	
		if (!$intM_NO){
			$db->disConnect();
			goClose($LNG_TRANS_CHAR["CS00013"]); //"해당 회원정보가 존재하지 않습니다."
			exit;
		}
		
		$memberMgr->setM_NO($intM_NO);
		$pointMgr->setM_NO($intM_NO);

		$memberRow = $memberMgr->getMemberView($db);

	}

	/* 포인트 종류 배열 */
	$aryPointTypeList = getCommCodeList('point');
	
	/* 포인트 소멸 일자 */
	$strPointEndDt = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR));
?>
<? include "./include/header.inc.php"?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$('input[name=pointEndDt]').simpleDatepicker();

		$('#pointPrice').numeric();
		$("#pointPrice").css("ime-mode", "disabled"); 


		<?if($strGubun=="2"){?>
		var intSelectMemberCnt	= 0;
		var strHiddenHtml		= "";
		$(parent.document).find("input[id^=chkNo]").each(function() {
			
			if ($(this).is(":checked")){
				intSelectMemberCnt++;
			
				strHiddenHtml += "<input type=\"hidden\" name=\"chkNo[]\" value=\""+$(this).val()+"\">";
			}
		});

		if (intSelectMemberCnt <= 0)
		{
			alert("포인트를 적립/차감할 회원을 선택해주세요.");
			parent.goPopClose();
			return;
		}
		$("#spanSelectMemberCnt").text(intSelectMemberCnt);
		$("#divHiddenList").html(strHiddenHtml);
		<?}?>
	});

	function goMemberPointAct()
	{
		if(!C_chkInput("pointPrice",true,"<?=$LNG_TRANS_CHAR['CW00034']?>",false)) return; //포인트
		if(!C_chkInput("pointEndDt",true,"<?=$LNG_TRANS_CHAR['MW00054']?>",false)) return; //포인트 소멸일자
		if(!C_chkInput("pointMemo",true,"<?=$LNG_TRANS_CHAR['MW00055']?>",false)) return; //포인트 설명

		var strPointType = $('input[name=pointType]:checked').val();
		if (strPointType == "010")
		{
			if ($("#ulMoveMemInfo").html() == "")
			{
				alert("포인트를 이동하실 회원을 선택해주세요.");
				return;
			}
		
			var doc = document.form;
			doc.mode.value = "json";
			doc.jsonMode.value = "memberPointMove";
			doc.act.value = "memberPointMove";
			
			var formData = $("#form").serialize();
			//doc.submit();
			C_AjaxPost("memberPointMove","./index.php",formData,"post");	
		
		} else {
			document.form.menuType.value = "oper";
			C_getAction("pointWrite","./index.php");		
		}
	}

	function goAjaxRet(name,result){
		if (name == "memberPointMove")
		{			
			var doc = document.form;
			var data = eval(result);
			
			alert(data[0].MSG);
			if (data[0].RET == "Y")
			{
				location.reload();
			}		
		}
	}


	/* 회원검색 */
	function goPointMoveTrView(gb)
	{
		$("#trPointMoveInput").css("display","none");
	//	$("$ulMoveMemInfo").html("");
		if (gb == "2")
		{
			$("#trPointMoveInput").css("display","");
		}
	}

	function goMoveMemInsert(html)
	{
		
		$("#ulMoveMemInfo").append(html);
	}

	function goPopMemberSearch()
	{
		C_openWindow("./?menuType=member&mode=popMemberSearch&no=<?=$intM_NO?>","회원검색","600","600");
	}

	function goMovSelectMemDelete(obj)
	{
		var intNo = $(obj).parent().index();
		$("#ulMoveMemInfo > li").eq(intNo).remove();
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<?if ($strGubun == "1"){?>
		<h2><?=callLangTrans($LNG_TRANS_CHAR["MW00188"],array($memberRow[M_NAME])); //[<?=$memberRow[M_NAME]]님의 포인트 증가/감소?></h2>			
		<?}else{?>
		<h2>선택한 회원은 <span id="spanSelectMemberCnt"></span>명 입니다.</h2>
		<?}?>
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>
</div>
<div id="contentArea">
	<div id="contentWrap">
		<?if ($strGubun == "1"){?>
		<div class="paymentInfo mt20">
			<ul>
				<li><?=callLangTrans($LNG_TRANS_CHAR["MS00008"],array($memberRow[M_ID],$memberRow[M_NAME],NUMBER_FORMAT($memberRow[M_POINT])))?></li>
			</ul>
		</div>
		<?}?>
		<!-- (1) 회원 정보 -->
		<div class="tableForm mt10">
			<form name="form" method="post" id="form">
			<input type="hidden" name="menuType" value="<?=$strMenuType?>">
			<input type="hidden" name="mode" value="<?=$strMode?>">
			<input type="hidden" name="act" value="<?=$strMode?>">
			<input type="hidden" name="page" value="<?=$intPage?>">
			<input type="hidden" name="no" value="<?=$intM_NO?>">
			<input type="hidden" name="jsonMode" value="">
			<input type="hidden" name="gb" value="<?=$strGubun?>">

				<table>
					<colgroup>
						<col style="width:100px;"/>
						<col/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["MW00057"] //포인트 종류?></th>
						<td>
							<input type="radio" name="pointType" id="pointType" value="006" checked onclick="javascript:goPointMoveTrView(1);"><?=$LNG_TRANS_CHAR["MW00060"] //관리자 증감?>
							<input type="radio" name="pointType" id="pointType" value="007" onclick="javascript:goPointMoveTrView(1);"><?=$LNG_TRANS_CHAR["MW00061"] //관리자 감소?>
							<?if ($strGubun == "1" && $SHOP_POINT_MOVE_FLAG == "Y"){?>
							<input type="radio" name="pointType" id="pointType" value="010" onclick="javascript:goPointMoveTrView(2);">포인트이동
							<?}?>
						</td>
					</tr>
					<?if ($strGubun == "1" && $SHOP_POINT_MOVE_FLAG == "Y"){?>
					<tr id="trPointMoveInput" style="display:none">
						<th>포인트 이동 회원</th>
						<td>
							<a href="javascript:goPopMemberSearch();">[회원검색]</a>
							<ul id="ulMoveMemInfo">

							</ul>
						</td>
					</tr>
					<?}?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
						<td>
							<input type="text" name="pointPrice" id="pointPrice" maxlength="10">
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["MW00054"] //소멸일?></th>
						<td>
							<input type="text" name="pointEndDt" id="pointEndDt" value="<?=$strPointEndDt?>" maxlength="10">
							<br>(<?=$LNG_TRANS_CHAR["MS00009"] //포인트 감소일때는 소멸일자는 현재일자로 들어갑니다.?>)
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["MW00055"] //포인트 설명?></th>
						<td><input type="text" name="pointMemo" id="pointMemo" style="width:300px" maxlength="50"></td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["MW00058"] //기타 메모?></th>
						<td><input type="text" name="pointEtc" id="pointEtc"  style="width:300px"  maxlength="50"></td>
					</tr>
				</table>
				<div id="divHiddenList"></div>
			</form>
		</div>
		<div class="buttonWrap">
			<a class="btn_big" href="javascript:goMemberPointAct();"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
			<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //창닫기?></strong></a>
		</div>
	</div>
</div>
</body>
</html>