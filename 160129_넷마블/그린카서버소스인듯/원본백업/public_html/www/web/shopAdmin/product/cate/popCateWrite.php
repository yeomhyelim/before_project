<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";

	$cateMgr = new CateMgr();		
	$memberMgr = new MemberMgr();

	/* 접근 그룹 */
	$aryMemberGroup = $memberMgr->getGroupList($db);

	/* 카테고리 종류 */
	$strCateType	= $_REQUEST['cateType'];
	
	$intCateLevel	= $_REQUEST['cateLevel'];
	$strCateCode	= $_REQUEST['cateCode'];

	if ($intCateLevel && $strCateCode){
		
		$cateMgr->setCL_LNG($strStLng);			
		switch($intCateLevel){
			case 1:
				$strC_HCODE1 = "";
			break;
			case 2:
				$strC_HCODE1 = SUBSTR($strCateCode,0,3);
				
				$cateMgr->setC_LEVEL(1);			
				$cateMgr->setC_LEVEL(1);
				$cateMgr->setC_HCODE("");
//				$cateMgr->setC_VIEW_YN("Y");
				$aryCate01 = $cateMgr->getCateLevelAry($db);

			break;
			case 3:
				$strC_HCODE1 = SUBSTR($strCateCode,0,3);
				$strC_HCODE2 = SUBSTR($strCateCode,3,3);
			
				$cateMgr->setC_LEVEL(1);			
				$cateMgr->setC_LEVEL(1);
				$cateMgr->setC_HCODE("");
//				$cateMgr->setC_VIEW_YN("Y");
				$aryCate01 = $cateMgr->getCateLevelAry($db);

				$cateMgr->setC_LEVEL(2);
				$cateMgr->setC_HCODE($strC_HCODE1);
//				$cateMgr->setC_VIEW_YN("Y");
				$aryCate02 = $cateMgr->getCateLevelAry($db);
			
			break;
			
			case 4:
				$strC_HCODE1 = SUBSTR($strCateCode,0,3);
				$strC_HCODE2 = SUBSTR($strCateCode,3,3);
				$strC_HCODE3 = SUBSTR($strCateCode,6,3);

				$cateMgr->setC_LEVEL(1);			
				$cateMgr->setC_LEVEL(1);
				$cateMgr->setC_HCODE("");
//				$cateMgr->setC_VIEW_YN("Y");
				$aryCate01 = $cateMgr->getCateLevelAry($db);
			
				$cateMgr->setC_LEVEL(2);
				$cateMgr->setC_HCODE($strC_HCODE1);
//				$cateMgr->setC_VIEW_YN("Y");
				$aryCate02 = $cateMgr->getCateLevelAry($db);

				$cateMgr->setC_LEVEL(3);
				$cateMgr->setC_HCODE($strC_HCODE1.$strC_HCODE2);
//				$cateMgr->setC_VIEW_YN("Y");
				$aryCate03 = $cateMgr->getCateLevelAry($db);

			break;

		}
	}

?>
<? include "./include/header.inc.php"?>
<style type="text/css">
	#contentArea{position:relative;min-width:750px;}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
	
		callCateList(1,"","","cateHCode1","<?=$strC_HCODE1?>");
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
		//alert(cateSelected);
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
		<h2><?=$LNG_TRANS_CHAR["PW00112"] //카테고리관리?> [<?=$LNG_TRANS_CHAR["CW00002"] //등록?>]</h2>
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>

<div id="contentArea">
<form name="form" name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="act">
<input type="hidden" name="act" value="cateWrite">
<input type="hidden" name="cateType" value="<?=$strCateType?>">
	<!-- ******** 컨텐츠 ********* -->
<div class="popBox">
	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00183"] //분류선택?></th>
				<td colspan="3">
					<select id="cateHCode1" name="cateHCode1">
						<option value="">=<?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate01)){
			
							for($i=0;$i<sizeof($aryCate01);$i++){
								$strSelected = ($aryCate01[$i][CATE_CODE] == $strC_HCODE1)? "selected":"";
								echo "<option value=\"".$aryCate01[$i][CATE_CODE]."\"".$strSelected.">".$aryCate01[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<select id="cateHCode2" name="cateHCode2">
						<option value="">=<?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate02)){
			
							for($i=0;$i<sizeof($aryCate02);$i++){
								$strSelected = ($aryCate02[$i][CATE_CODE] == $strC_HCODE2)? "selected":"";
								echo "<option value=\"".$aryCate02[$i][CATE_CODE]."\"".$strSelected.">".$aryCate02[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<select id="cateHCode3" name="cateHCode3">
						<option value="">=<?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate03)){
			
							for($i=0;$i<sizeof($aryCate03);$i++){
								$strSelected = ($aryCate03[$i][CATE_CODE] == $strC_HCODE3)? "selected":"";
								echo "<option value=\"".$aryCate03[$i][CATE_CODE]."\"".$strSelected.">".$aryCate03[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<!--select id="cateHCode4" name="cateHCode4">
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
				<th><span  class="icoNa_<?=($S_USE_LNG!="KR")?$strStLng : "";?>"><?=$LNG_TRANS_CHAR["PW00184"] //분류명?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?> id="cateName" name="cateName" maxlength="50" value="<?=$cateRow[CL_NAME]?>" class="titIn"/>
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
					<span class="helpTxtGray"><?=$LNG_TRANS_CHAR["BS00087"]//가상카테고리는 사용자 페이지에 노출 되지 않습니다.  분류체계가 가상으로 생성되 링크 URL을 별도 관리 가능합니다.?> </span>
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
					<input type="radio" id="cateView" name="cateView" value="Y" <?=($cateRow[C_VIEW_YN]=="Y" || !$cateRow[C_VIEW_YN])?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00187"]//화면보임?>
					<input type="radio" id="cateView" name="cateView" value="N"><?=$LNG_TRANS_CHAR["OW00164"]//화면 표시 안함?>
					
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00100"] //버튼이미지?></th>
				<td>
					<input type="file" <?=$nBox?>   id="cateImg1" name="cateImg1"/>
				</td>
				<th style="width:100px;"><?=$LNG_TRANS_CHAR["PW00101"] //마우스오버이미지?></th>
				<td>
					<input type="file" <?=$nBox?>  id="cateImg2" name="cateImg2"/>
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goCateAct('cateWrite');"><strong style="width:80px;"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
	</div>
</form>
	<div class="noticeInfoWrap">
		<ul>
			<?=$LNG_TRANS_CHAR['MS00087'] //* 대분류 등록일때는 분류~ ?>
		</ul>
	</div>
</div>
</div><!-- //popBox -->

<iframe name="ifrmSubmit" id="ifrmSubmit" width="0" height="0" border="0"></iframe>

</body>
</html>