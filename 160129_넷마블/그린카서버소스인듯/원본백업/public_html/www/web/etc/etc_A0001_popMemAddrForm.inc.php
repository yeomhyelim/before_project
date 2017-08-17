<?
	require_once MALL_CONF_LIB."MemberMgr.php";
	
	$memberMgr = new MemberMgr();

	$intMA_NO				= $_POST["no"]			? $_POST["no"]			: $_REQUEST["no"];

	$aryHp					= getCommCodeList("HP");
	$aryPhone				= getCommCodeList("PHONE");
	
	/* 국가 리스트 */
	if ($S_SITE_LNG != "KR"){
		$aryCountryList		= getCountryList();			
		$aryCountryState	= getCommCodeList("STATE","");
	}

	if ($intMA_NO > 0){
		$memberMgr->setMA_NO($intMA_NO);
		$row = $memberMgr->getMemberAddrView($db);

		$aryMemPhone	= explode("-",$row[MA_PHONE]);
		$aryMemHp		= explode("-",$row[MA_HP]);
		$aryMemZip		= explode("-",$row[MA_ZIP]);

	}
?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		var strHtml = "";
		
		<?if ($S_SITE_LNG != "KR"){?>
		$("#bcountry").change(function(){
			var strVal	= $("#bcountry option:selected").val();
				
			$("#divState1").css("display","block");
			$("#divState2").css("display","none");
			if (strVal == "US")
			{
				$("#divState1").css("display","none");
				$("#divState2").css("display","block");
			}
		});
		<?}?>
	
		$("input[name='baddrType']").click(function() {			
			if ($(this).is(":checked") == true)
			{	
				$("#mode").val("json");
				$("#act").val("memberBasicAddr");
				
				var formData = $("#form").serialize();
				C_AjaxPost("memberBasicAddr","./index.php",formData,"post");		
			}
		});	
	});

	function goMemAddrAct()
	{
		<?if ($S_SITE_LNG == "KR"){?>
		if(!C_chkInput("bname",true,"<?=$LNG_TRANS_CHAR['OW00017']?>",true)) return; //받는사람명
		if(!C_chkInput("bphone2",true,"<?=$LNG_TRANS_CHAR['OW00018']?>",true)) return; //받는사람 전화번호
		if(!C_chkInput("bphone3",true,"<?=$LNG_TRANS_CHAR['OW00018']?>",true)) return; //받는사람 전화번호
		if(!C_chkInput("bhp2",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return; //받는사람 핸드폰
		if(!C_chkInput("bhp3",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return; //받는사람 핸드폰
		if(!C_chkInput("bzip1",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return; //받는사람 우편번호
		if(!C_chkInput("bzip2",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return; //받는사람 우편번호
		if(!C_chkInput("baddr1",true,"<?=$LNG_TRANS_CHAR['OW00022']?>",true)) return; //받는사람 주소
		if(!C_chkInput("baddr2",true,"<?=$LNG_TRANS_CHAR['OW00023']?>",true)) return; //받는사람 상세주소
		<?}else{?>
		if(!C_chkInput("bname",true,"<?=$LNG_TRANS_CHAR['OW00017']?>",true)) return; //받는사람명
		if(!C_chkInput("bphone1",true,"<?=$LNG_TRANS_CHAR['OW00018']?>",true)) return; //받는사람 전화번호
		if(!C_chkInput("bhp1",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return; //받는사람 핸드폰
		
		var strCountry	= $("#bcountry option:selected").val();
		if (C_isNull(strCountry))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00041']?>"); //국가를 선택해주세요.
			return;
		}	

		if(!C_chkInput("baddr1",true,"<?=$LNG_TRANS_CHAR['OW00022']?>",true)) return; //받는사람 주소
		if(!C_chkInput("baddr2",true,"<?=$LNG_TRANS_CHAR['OW00023']?>",true)) return; //받는사람 상세주소
		if(!C_chkInput("bcity",true,"<?=$LNG_TRANS_CHAR['OW00041']?>",true)) return; //받는사람 city
		
		var strState = "";
		if (strCountry == "US")
		{
			strState =  $("#bstate_2 option:selected").val();
		
			if (C_isNull(strState))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00042']?>"); //State를 선택해주세요.
				return;
			}	
		}
		
		if(!C_chkInput("bzip1",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return; //받는사람 우편번호

		<?}?>

		var doc = document.form;
		doc.menuType.value = "member";
		doc.mode.value = "json";
		doc.act.value="memberAddr";
		
		var formData = $("#form").serialize();
		C_AjaxPost("memberAddr","./index.php",formData,"post");
		
		
		

		//document.form.method = "post";
		//document.form.action = "<?=$PHP_SELF?>";
		//document.form.submit();	

		
				
	}

	function goAjaxRet(name,result){

		var doc = document.form;
		var data = eval(result);
		
		if (name == "memberAddr")
		{						
			if (data[0].RET == "Y")
			{
				self.close();
				opener.location.reload();
				return;
			}
		} else if (name == "memberBasicAddr"){
			if (!C_isNull(data[0].RET) && data[0].RET != "<?=$intMA_NO?>"){
				alert("<?=$LNG_TRANS_CHAR['OS00064']?>"); //이미 등록한 기본배송지가 있습니다. 기본배송지를 변경하시겠습니까?
				return;
			}
		}

	}
	/* 우편번호 찾기 */
	function goZip(num)
	{
		window.open('?menuType=etc&mode=address2&num=' + num,'new','width=600px,height=670px,top=300px,left=400px,toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,location=no');

		//window.open('?menuType=etc&mode=address&num='+num,'new','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}
//-->
</script>

<style>
	div.tableOrderForm{padding:15px;}
	div.tableform table{width:100%;}
	div.tableform table th{width:120px;height:22px;padding:5px;border:1px solid #cccccc;background:#f5f5f5;}
	div.tableform table td{padding:5px;border:1px solid #cccccc;}
</style>
<body>
<div class="popAddrWrap">
	<h2><?=$LNG_TRANS_CHAR["OW00085"] //주소록?></h2>
	<form name='form' method='post' id="form">
	<input type="hidden" name="menuType" value="member">
	<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" id="act" value="<?=$strMode?>">
	<input type="hidden" name="addrNo" id="addrNo" value="<?=$intMA_NO?>">
	<div class="tableOrderForm mt10">
		<div class="tableform">
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00086"] //기본배송지?></th>
					<td>
						<input type="checkbox" name="baddrType" id="baddrType" value="1" <?=($row[MA_TYPE]=="1")?"checked":"";?>> <?=$LNG_TRANS_CHAR["CW00035"] //사용?>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00017"] //받는사람명?></th>
					<td><input type="input" id="bname" name="bname" class="defInput _w200" maxlength="50" value="<?=$row[MA_NAME]?>"/></td>
				</tr>
				<?if ($S_SITE_LNG != "KR"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00018"] //전화번호?></th>
					<td>
						<input type="input" id="bphone1" name="bphone1" class="defInput _w200" maxlength="30" value="<?=$row[MA_PHONE]?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00019"] //핸드폰?></th>
					<td>
						<input type="input" id="bhp1" name="bhp1" class="defInput _w200" maxlength="30" value="<?=$row[MA_HP]?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00040"] //국가?></th>
					<td>
						<?=drawSelectBoxMore("bcountry",$aryCountryList,$row[MA_COUNTRY],$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00022"] //주소?></th>
					<td>
						<input type="input" id="baddr1" name="baddr1" class="defInput _w200"  value="<?=$row[MA_ADDR1]?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00023"] //상세주소?></th>
					<td>
						<input type="input" id="baddr2" name="baddr2" class="defInput _w200"  value="<?=$row[MA_ADDR2]?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00041"] //City?></th>
					<td>
						<input type="input" id="bcity" name="bcity" class="defInput _w200"  value="<?=$row[MA_CITY]?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00042"] //State?></th>
					<td>
						<div id="divState1" <?=($strJCountry=="US")?"style=\"display:none\"":"";?>>
							<input type="input" id="bstate_1" name="bstate_1" value="N/A" class="defInput _w200" maxlength="50" value="<?=$row[MA_STATE]?>"/>
						</div>
						<div id="divState2" <?=($strJCountry!="US")?"style=\"display:none\"":"";?>>
							<?=drawSelectBoxMore("bstate_2",$aryCountryState,$row[MA_STATE],$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
						</div>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00021"] //우편번호?></th>
					<td>
						<input type="input" id="bzip1" name="bzip1" class="defInput _w200"  value="<?=$row[MA_ZIP]?>"/>
					</td>
				</tr>
				<?}else{?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00018"] //전화번호?></th>
					<td>
						<?=drawSelectBoxMore("bphone1",$aryPhone,$aryMemPhone[0],$design ="defSelect",$onchange="",$etc="id=\"bphone1\"",$firstItem="",$html="N")?>

						<input type="input" id="bphone2" name="bphone2" class="defInput _w50" maxlength="4" value="<?=$aryMemPhone[1]?>"/> -
						<input type="input" id="bphone3" name="bphone3" class="defInput _w50" maxlength="4" value="<?=$aryMemPhone[2]?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00019"] //핸드폰?></th>
					<td>
						<?=drawSelectBoxMore("bhp1",$aryHp,$aryMemHp[0],$design ="defSelect",$onchange="",$etc="id=\"bhp1\"",$firstItem="",$html="N")?>
						<input type="input" id="bhp2" name="bhp2" class="defInput _w50" maxlength="4" value="<?=$aryMemHp[1]?>"/> -
						<input type="input" id="bhp3" name="bhp3" class="defInput _w50" maxlength="4" value="<?=$aryMemHp[2]?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00022"] //주소?> </th>
					<td>
						<dl>
							<dd><input type="input" id="bzip1" name="bzip1" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemZip[0]?>"/>
							 -  <input type="input" id="bzip2" name="bzip2" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemZip[1]?>"/>
							 	<a href="javascript:daumPopZip();" class="btnIDChk">우편번호</a></dd>
								<span id="guide" style="color:#999"></span>
							<dd class="mt5"><input type="input" id="baddr1" name="baddr1" class="defInput _w300" readonly value="<?=$row[MA_ADDR1]?>"/></dd>
							<dd class="mt5"><input type="input" id="baddr2" name="baddr2" class="defInput _w300" maxlength="100" value="<?=$row[MA_ADDR2]?>"/></dd>
						</dl>
					</td>
				</tr>
				<?}?>

			</table>
		</div>
		<div class="btnCenter">
			<span id="spanTotCouponPrice"></span>
			<a href="javascript:goMemAddrAct();" class="btnSave"><?=$LNG_TRANS_CHAR["OW00084"] //배송지저장?></a>
			<a href="javascript:self.close();" class="btnClose"><?=$LNG_TRANS_CHAR["CW00034"] //닫기?></a>
		</div>
	</div>
</div>
</form>
</body>
</html>