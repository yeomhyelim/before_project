<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";

	$cateMgr = new CateMgr();		
	$memberMgr = new MemberMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];
	$strStLng		= $_POST["lang"]			? $_POST["lang"]			: $_REQUEST["lang"];

	$strCATE_CODE	= $_POST["cateCode"]		? $_POST["cateCode"]		: $_REQUEST["cateCode"];
	$strC_HCODE1	= $_POST["cateHCode1"]		? $_POST["cateHCode1"]		: $_REQUEST["cateHCode1"];
	$strC_HCODE2	= $_POST["cateHCode2"]		? $_POST["cateHCode2"]		: $_REQUEST["cateHCode2"];
	$strC_HCODE3	= $_POST["cateHCode3"]		? $_POST["cateHCode3"]		: $_REQUEST["cateHCode3"];
	$strC_HCODE4	= $_POST["cateHCode4"]		? $_POST["cateHCode4"]		: $_REQUEST["cateHCode4"];	
	
	/* 카테고리 종류 */
	$strCateType	= $_POST["cateType"]		? $_POST["cateType"]		: $_REQUEST["cateType"];
	/*##################################### Parameter 셋팅 #####################################*/	
?>

<? include "./include/header.inc.php"?>
<?	
	switch($strMode){
		case "popCateModify":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$cateMgr->setCL_LNG($strStLng);
			$cateMgr->setC_LEVEL(1);			
			$cateMgr->setC_LEVEL(1);
			$cateMgr->setC_HCODE("");
//			$cateMgr->setC_VIEW_YN("Y");
			$aryCate01 = $cateMgr->getCateLevelAry($db);

			$cateMgr->setC_LEVEL(2);
			$cateMgr->setC_HCODE(SUBSTR($strCATE_CODE,0,3));
//			$cateMgr->setC_VIEW_YN("Y");
			$aryCate02 = $cateMgr->getCateLevelAry($db);

			$cateMgr->setC_LEVEL(3);
			$cateMgr->setC_HCODE(SUBSTR($strCATE_CODE,0,6));
//			$cateMgr->setC_VIEW_YN("Y");
			$aryCate03 = $cateMgr->getCateLevelAry($db);

			$cateMgr->setC_LEVEL(4);
			$cateMgr->setC_HCODE(SUBSTR($strCATE_CODE,0,9));
//			$cateMgr->setC_VIEW_YN("Y");
			$aryCate04 = $cateMgr->getCateLevelAry($db);
			
			
			$cateMgr->setC_CODE($strCATE_CODE);
			$cateRow = $cateMgr->getView($db);

			/* 접근 그룹 */
			$aryMemberGroup = $memberMgr->getGroupList($db);

		break;
	}

?>
<style type="text/css">
	#contentArea{position:relative;min-width:500px;}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
	
		var strHCode = "";
		callCateList(1,"","","cateHCode1","<?=substr($cateRow['C_CODE'],0,3)?>");
		var strHCode = "";
		
		$("#cateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","cateHCode2","");
			}
		});

		$("#cateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","cateHCode3","");
			}
		});

		$("#cateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$("#cateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","cateHCode4","");
			}
		});
	});

	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
//		alert(cateSelected);
		var strJsonParam = "menuType=product&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strStLng?>&cateType=<?=$strCateType?>";
		
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

	function goCateAct(mode)
	{	
		if(!C_chkInput("cateName",true,"<?=$LNG_TRANS_CHAR['PW00021']?>",true)) return; //카테고리

		document.form.encoding = "multipart/form-data";
		document.form.target = "ifrmSubmit";
		C_getAction(mode,"<?=$PHP_SELF?>");				
	}

	function goClose()
	{
		parent.location.reload();
		parent.goPopClose();
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["PW00112"] //카테고리관리?> [<?=$LNG_TRANS_CHAR["CW00003"] //수정?>]</h2>
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>

<div id="contentArea">
<form name="form" name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="act">
<input type="hidden" name="act" value="cateModify">
<input type="hidden" name="cateCode" id="cateCode" value="<?=$strCATE_CODE?>">	
<input type="hidden" name="lang" value="<?=$strStLng?>"/>
<input type="hidden" name="cateType" value="<?=$strCateType?>">

	<!-- ******** 컨텐츠 ********* -->
<div class="popBox">
	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00183"] //분류선택?></th>
				<td colspan="3">
					<select id="cateHCode1" name="cateHCode1" disabled>
						<option value="">=<?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate01)){
			
							for($i=0;$i<sizeof($aryCate01);$i++){
								$strSelected = ($aryCate01[$i][CATE_CODE] == SUBSTR($strCATE_CODE,0,3))? "selected":"";
								echo "<option value=\"".$aryCate01[$i][CATE_CODE]."\" ".$strSelected.">".$aryCate01[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<select id="cateHCode2" name="cateHCode2" disabled>
						<option value="">=<?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate02)){
			
							for($i=0;$i<sizeof($aryCate02);$i++){
								$strSelected = ($aryCate02[$i][CATE_CODE] == SUBSTR($strCATE_CODE,3,3))? "selected":"";
								echo "<option value=\"".$aryCate02[$i][CATE_CODE]."\"".$strSelected.">".$aryCate02[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<select id="cateHCode3" name="cateHCode3" disabled>
						<option value="">=<?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate03)){
			
							for($i=0;$i<sizeof($aryCate03);$i++){
								$strSelected = ($aryCate03[$i][CATE_CODE] == SUBSTR($strCATE_CODE,6,3))? "selected":"";
								echo "<option value=\"".$aryCate03[$i][CATE_CODE]."\"".$strSelected.">".$aryCate03[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<!--select id="cateHCode4" name="cateHCode4" disabled>
						<option value="">=<?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate04)){
			
							for($i=0;$i<sizeof($aryCate04);$i++){
								$strSelected = ($aryCate04[$i][CATE_CODE] == SUBSTR($strCATE_CODE,9,3))? "selected":"";
								echo "<option value=\"".$aryCate04[$i][CATE_CODE]."\"".$strSelected.">".$aryCate04[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select-->
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00184"] //분류명?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?> id="cateName" name="cateName" maxlength="50" value="<?=strConvertCut2($cateRow[CL_NAME],0,"N")?>" class="titIn"/>
				</td>
			</tr>
			<?if (!$strCateType){?>
			<tr>
				<!-- 2013.12.02 kim hee sung 기능 구현 안됨. 숨김 처리 , 문제점: 하위 카테고리 함께 적용 여부
				<th><?=$LNG_TRANS_CHAR["PW00098"] //접근가능그룹?></th>
				<td>
					<select name="cateGroup" id="cateGroup">
					<option value="">ALL</option>
					<?
						if (is_array($aryMemberGroup)){
							for($i=0;$i<sizeof($aryMemberGroup);$i++){
								$strSelected = ($cateRow[C_GROUP] == $aryMemberGroup[$i][G_CODE]) ? "selected":"";

								echo "<option value=\"".$aryMemberGroup[$i][G_CODE]."\"".$strSelected.">".$aryMemberGroup[$i][G_NAME]."</option>";
							}
						}
					?>
					</select>
				</td>
				-->
				<th><?=$LNG_TRANS_CHAR["PW00185"] //가상카테고리사용?></th>
				<td colspan="3">
					<input type="checkbox" id="cateShare" name="cateShare" value="Y" <?=($cateRow[C_SHARE]=="Y")?"checked":"";?>>
					<span class="helpTxtGray"><?=$LNG_TRANS_CHAR["BS00087"]//가상카테고리는 사용자 페이지에 노출 되지 않습니다.  분류체계가 가상으로 생성되 링크 URL을 별도 관리 가능합니다.?></span>
				</td>
			</tr>
			<?}?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00186"] //정렬순서?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="cateOrder" name="cateOrder" value="<?=$cateRow[C_ORDER]?>"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00187"] //화면보임?></th>
				<td>
					<input type="radio" id="cateView" name="cateView" value="Y" <?=($cateRow[CL_VIEW_YN]=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00187"]//화면보임?>
					<input type="radio" id="cateView" name="cateView" value="N" <?=($cateRow[CL_VIEW_YN]=="N")?"checked":"";?>><?=$LNG_TRANS_CHAR["OW00164"]//화면 표시 안함?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00100"] //기본이미지?></th>
				<td>
					<input type="file" <?=$nBox?>   id="cateImg1" name="cateImg1"/>
					<?if($cateRow['CL_IMG1']):?>
					<br><input type="checkbox" name="cateImg1_del" value="Y"> <?=$LNG_TRANS_CHAR["PW00277"]//파일 삭제?>
					<?endif;?>
				</td>
				<th style="width:100px;"><?=$LNG_TRANS_CHAR["PW00101"] //마우스오버이미지?></th>
				<td>
					<input type="file" <?=$nBox?>  id="cateImg2" name="cateImg2"/>
					<?if($cateRow['CL_IMG2']):?>
					<br><input type="checkbox" name="cateImg2_del" value="Y"> <?=$LNG_TRANS_CHAR["PW00277"]//파일 삭제?>
					<?endif;?>
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goCateAct('cateModify');" id="menu_auth_m"><strong style="width:80px;"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
	</div>
	<div class="noticeInfoWrap">
		<ul>
			<?=$LNG_TRANS_CHAR['MS00087'] //* 대분류 등록일때는 분류~ ?>
		</ul>
	</div>
</div>

	
</div><!-- //popBox -->
<iframe name="ifrmSubmit" id="ifrmSubmit" <?=($S_SHOP_HOME!="demo1")?"width=\"0\" height=\"0\"":"width=\"300\" height=\"300\"";?>></iframe>

</body>
</html>