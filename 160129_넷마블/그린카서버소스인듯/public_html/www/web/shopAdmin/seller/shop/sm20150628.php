<?
	## 파일 경로 설정
	if($shopRow['SH_COM_FILE1']) { 	$sh_file1	= "/upload/shop/file1/{$shopRow['SH_COM_FILE1']}"; }
	if($shopRow['SH_COM_FILE2']) { 	$sh_file2	= "/upload/shop/file2/{$shopRow['SH_COM_FILE2']}"; }
	if($shopRow['SH_COM_FILE3']) {	$sh_file3	= "/upload/shop/file3/{$shopRow['SH_COM_FILE3']}"; }
	if($shopRow['SH_COM_FILE4']) {	$sh_file4	= "/upload/shop/file4/{$shopRow['SH_COM_FILE4']}"; }
	if($shopRow['SH_COM_FILE5']) {	$sh_file5	= "/upload/shop/file5/{$shopRow['SH_COM_FILE5']}"; }


	if($shopRow['SH_COM_CERTIFICATES1_FILE']) {	$sh_certificates1	= "/upload/shop/certificates1/{$shopRow['SH_COM_CERTIFICATES1_FILE']}"; $count=1;}
	if($shopRow['SH_COM_CERTIFICATES2_FILE']) {	$sh_certificates2	= "/upload/shop/certificates2/{$shopRow['SH_COM_CERTIFICATES2_FILE']}"; $count=2;}
	if($shopRow['SH_COM_CERTIFICATES3_FILE']) {	$sh_certificates3	= "/upload/shop/certificates3/{$shopRow['SH_COM_CERTIFICATES3_FILE']}"; $count=3;}
	if($shopRow['SH_COM_CERTIFICATES4_FILE']) {	$sh_certificates4	= "/upload/shop/certificates4/{$shopRow['SH_COM_CERTIFICATES4_FILE']}"; $count=4;}
	if($shopRow['SH_COM_CERTIFICATES5_FILE']) {	$sh_certificates5	= "/upload/shop/certificates5/{$shopRow['SH_COM_CERTIFICATES5_FILE']}"; $count=5;}



?>
<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/editor/product";
	var uploadFile 	= "../kr/index.php";
	var htmlYN		= "Y";

	$(document).ready(function()
	{
		$("#com_country").change(function()
		{
			var strVal	= $("#com_country option:selected").val();

			$("#divState1").css("display","block");
			$("#divState2").css("display","none");

			if (strVal == "US")
			{
				$("#divAddr1").css("display","none");
				$("#divAddr2").css("display","");
				$("#divState1").css("display","none");
				$("#divState2").css("display","");
				$(".krView").css("display","none");
				$(".otherView").css("display","");
				$(".krView2").css("display","none");
				$(".otherView2").css("display","");
			}
			else if (strVal == "KR")
			{
				$("#divAddr1").css("display","");
				$("#divAddr2").css("display","none");
				$(".krView").css("display","");
				$(".otherView").css("display","none");
				<?if($strStLng == 'KR'){?>
				$(".krView2").css("display","");
				$(".otherView2").css("display","none");
				<?}else{?>
				$(".krView2").css("display","none");
				$(".otherView2").css("display","");
				<?}?>
				$(".krView td").attr("colspan",$(".tableForm col").length-1);
			}
			else
			{
				$("#divAddr1").css("display","none");
				$("#divAddr2").css("display","");
				$(".krView").css("display","none");
				$(".otherView").css("display","");
				$(".krView2").css("display","none");
				$(".otherView2").css("display","");
			}
		});

		$('textarea[maxlength]').live('keyup change', function() {  
			var str = $(this).val()  
			var mx = parseInt($(this).attr('maxlength'))  
			if (str.length > mx) {  
			$(this).val(str.substr(0, mx));
				return false;  
			}  
		});
	});

	/*파일추가*/
	var count = <?=$count;?>;
	function Addinput(){
		if(count < 6){
			var addStr ="";
			addStr += "<div>";
			addStr += "<input type=\"text\"";
			addStr += " id=\"com_certificates" + count + "\"";
			addStr += " name=\"com_certificates" + count + "\"";
			addStr += " value=\"<?=$shopRow["SH_COM_CERTIFICATES"];?>\">";
			addStr += "<input type=\"file\"";
			addStr += strInputBoxStyle;
			addStr += " id=\"com_certificates" + count + "_file\"";
			addStr += " name=\"com_certificates"+ count +"_file\"/>";
			addStr += "</div>";
			$("#dynamic_table").append(addStr);
			count++;
		}
	}

	// 메인 상품 베스트 수정
	function goSellerShopNotOkEvent(be_no) {
		// ./?menuType=popup&mode=skinMainListTopImg&subPageCode=ZL0001
		//var strUrl = './?menuType=popup&mode=sellerShopNotOk&ic_type=main&be_no=' + be_no + '&ds_code=' + ds_code + '&subPageCode=' + strSubPageCode;
		var strUrl = './?menuType=popup&mode=sellerShopNotOk&shopNo=' + be_no;

		$.smartPop.open({	url: strUrl,
							bodyClose: false, 
							width: 500, 
							height: 250,			
		});
	}

	// 메인 상품 베스트 수정
	function goSellerShopNotOkEvent(be_no) {
		// ./?menuType=popup&mode=skinMainListTopImg&subPageCode=ZL0001
		//var strUrl = './?menuType=popup&mode=sellerShopNotOk&ic_type=main&be_no=' + be_no + '&ds_code=' + ds_code + '&subPageCode=' + strSubPageCode;
		var strUrl = './?menuType=popup&mode=sellerShopNotOk&shopNo=' + be_no;

		$.smartPop.open({	url: strUrl,
							bodyClose: false, 
							width: 500, 
							height: 250,			
		});
	}

	// 팝업 닫고 다시 로드
	function goLayoutPopCloseEvent() {

		$.smartPop.close();
		goSkinSampleHtml(strSubPageCode);

	}

	//주요유통 합산 체크 검사후 전송
	function goSumCheckSubmit(mode)
	{
		//alert('a');
		if(comCountrySum()){
			goAct(mode);
		}else{
			return false;
		}
		
	}

	//주요유통 합산체크
	function comCountrySum()
	{
		var intComCountrySum = 0;
		for(var i=1;i <= <?=$aryEntryCnt?>; i++)
		{
			intComCountrySum = intComCountrySum + parseInt($("#com_country" + i).val());
		}
		if(intComCountrySum > 100){
			alert('주요유통시장의 합은 100%를 넘을수 없습니다.');
			return false;
		}else{
			return true;
		}
	}
//]]>
</script>

<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["SW00024"] //입점몰 수정?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goMoveUrl('shopModify','<?=$intSU_NO?>');" class="selected"><?= $LNG_TRANS_CHAR["BW00006"]; //회사정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopProduct','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["OW00022"]; //상품정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopGrade','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00082"]; //상품정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopSetting','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00083"]; //거래/배송정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopUser','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00084"]; //관리자정보 ?></a>
	</div>
	<!-- 언어 선택 탭 -->
	<?include "./include/tab_language.inc.php";?>
	<!-- 언어 선택 탭-->
	<!-- ******** 컨텐츠 ********* -->
	<h3><?= $LNG_TRANS_CHAR["MW00173"]; //기본정보 ?></h3>
	<div class="tableFormWrap">
		<!--  ****************  -->
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00075"]; //국가 ?></th>
				<td <?if($a_admin_type == "S"): ?> colspan="3" <?endif;?>>
					<?=drawSelectBoxMore("com_country",$aryCountryList,$shopRow[SH_COM_COUNTRY],$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
				</td>
				<!-- 20150625 입점사 일경우 메인출력여부 주석처리 -->
				<?if($a_admin_type != "S"): ?>
				<th><?= $LNG_TRANS_CHAR["SW00085"]; //메인출력여부 ?></th>
				<td>
					<input type="checkbox" id="shop_main" name="shop_main" value="Y" <?=($shopRow[SH_COM_MAIN]=='Y') ? "checked" : "" ;?>/><?= $LNG_TRANS_CHAR["SW00086"]; //메인출력 ?>
				</td>
				<?endif;?>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00004"] //회사명?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:90%;" id="com_name" name="com_name" value="<?=$shopRow[SH_COM_NAME]?>"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["SW00006"] //대표자?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="com_rep_nm" name="com_rep_nm" value="<?=$shopRow[SH_COM_REP_NM]?>"/>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00007"] //대표전화?></span></th>
				<td>
					<div class="krView2" style="display:<?=($shopRow[SH_COM_COUNTRY] == 'KR' && $strStLng == 'KR') ? '' : 'none';?>"><?// ?>
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_phone1" name="com_phone1" value="<?=$strComPhone1?>"  maxlength="4"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_phone2" name="com_phone2" value="<?=$strComPhone2?>"  maxlength="4"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_phone3" name="com_phone3" value="<?=$strComPhone3?>"  maxlength="4"/>
					</div>
					<div class="otherView2" style="display:<?=($shopRow[SH_COM_COUNTRY] != 'KR' ||$strStLng != 'KR') ? '' : 'none';?>"><?// ?>
					<input type="text" <?=$nBox?> id="com_phone" name="com_phone" value="<?=$strComPhone?>"  maxlength=""/>
					</div>
				</td>
				<th><?=$LNG_TRANS_CHAR["SW00008"] //대표팩스?></th>
				<td>
				<div class="krView2" style="display:<?=($shopRow[SH_COM_COUNTRY] == 'KR' && $strStLng == 'KR') ? '' : 'none';?>"><?// ?>
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_fax1" name="com_fax1" value="<?=$strComFax1?>" maxlength="4"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_fax2" name="com_fax2" value="<?=$strComFax2?>" maxlength="4"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_fax3" name="com_fax3" value="<?=$strComFax3?>" maxlength="4"/>
					</div>
					<div class="otherView2" style="display:<?=($shopRow[SH_COM_COUNTRY] != 'KR' || $strStLng != 'KR') ? '' : 'none';?>"><?// ?>
					<input type="text" <?=$nBox?>   id="com_fax" name="com_fax" value="<?=$strComFax?>"  maxlength=""/>
					</div>
				</td>
			</tr>
			
			<!--tr>
				<th><?=$LNG_TRANS_CHAR["SW00010"] //업태?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:90%;" id="com_uptae" name="com_uptae" value="<?=$shopRow[SH_COM_UPTAE]?>"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["SW00011"] //업종?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="com_upjong" name="com_upjong" value="<?=$shopRow[SH_COM_UPJONG]?>"/>
				</td>
			</tr-->
			<tr class="krView" style="display:<?=($shopRow[SH_COM_COUNTRY] == 'KR') ? '' : 'none';?>">
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00012"] //사업자번호?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:40px;" id="com_num1_1" name="com_num1_1" value="<?=$strComNum1_1?>" maxlength="3"/>
					-
					<input type="text" <?=$nBox?>  style="width:30px;" id="com_num1_2" name="com_num1_2" value="<?=$strComNum1_2?>" maxlength="2"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_num1_3" name="com_num1_3" value="<?=$strComNum1_3?>" maxlength="5"/>
				</td>
			</tr>
			<tr>
				<th>Type</th>
				<td colspan="3">
					<select name="com_category">
						<?
						$strTyoeOption ='';
						foreach($aryType as $key => $val){
							$strTyoeOption .= "<option value='".$key."'";
							$strTyoeOption .= ($strComType == $key) ? ' selected ' : '';
							$strTyoeOption .= ">".$val."</option>";
						}
						echo $strTyoeOption;?>
					</select>
				</td>
				<!--th><?=$LNG_TRANS_CHAR["SW00013"] //통산판매번호?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_num2_1" name="com_num2_1" value="<?=$strComNum2_1?>" maxlength="5"/>
					-
					<input type="text" <?=$nBox?>  style="width:100px;" id="com_num2_2" name="com_num2_2" value="<?=$strComNum2_2?>"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_num2_3" name="com_num2_3" value="<?=$strComNum2_3?>"/>
				</td-->
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00015"] //주소?></span></th>
				<td colspan="3">
					<div id="divAddr1" <?=($shopRow[SH_COM_COUNTRY] != "KR") ? " style=\"display:none\" ":"";?>>
						<input type="text" <?=$nBox?>  style="width:50px;" id="com_zip1" name="com_zip1" value="<?=$strComZip1?>"/>
						-
						<input type="text" <?=$nBox?>  style="width:50px;" id="com_zip2" name="com_zip2" value="<?=$strComZip2?>"/>
						<a class="btnIDChk" href="javascript:goZip(1)"><?=$LNG_TRANS_CHAR["SW00014"] //우편번호?></a><br>
					</div>
					<input type="text" <?=$nBox?>  style="width:540px;" id="com_addr" name="com_addr" value="<?=$shopRow['SH_COM_ADDR']?>" class="mt5"/>
					<div id="divAddr2" <?=($shopRow[SH_COM_COUNTRY]=="KR")?"style=\"display:none\"":"";?>>
						<input type="text" <?=$nBox?>  style="width:440px;" id="com_city" name="com_city" value="<?=$shopRow['SH_COM_CITY']?>" class="mt5" alt="도시"/><?= $LNG_TRANS_CHAR["MW00076"]; //도시 ?>
						<div id="divState1" <?=($shopRow[SH_COM_COUNTRY]=="US")?"style=\"display:none\"":"";?>>
							<input type="input" id="com_state_1" name="com_state_1" class="defInput _w200" maxlength="50" value="<?=($shopRow['SH_COM_STATE'])? $shopRow['SH_COM_STATE']: "N/A";?>"/>
						</div>
						<div id="divState2" <?=($shopRow[SH_COM_COUNTRY]!="US")?"style=\"display:none\"":"";?>>
							<?=drawSelectBoxMore("com_state_2",$aryCountryState,$shopRow['SH_COM_STATE'],$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
						</div>
					</div>

					<!--<input type="text" <?=$nBox?>  style="width:50px;" id="com_zip1" name="com_zip1" value="<?=$strComZip1?>"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_zip2" name="com_zip2" value="<?=$strComZip2?>"/>
					<a class="btn_sml" href="javascript:goZip(1)"><strong><?=$LNG_TRANS_CHAR["SW00014"] //우편번호?></strong></a><br>
					<input type="text" <?=$nBox?>  style="width:500px;" id="com_addr" name="com_addr" value="<?=$shopRow['SH_COM_ADDR']?>"/>-->
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00009"] //대표메일?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="com_mail" name="com_mail" value="<?=$shopRow[SH_COM_MAIL]?>"/>
				</td>
			</tr>
			<!-- tr>
				<th><?=$LNG_TRANS_CHAR["SW00017"] //인감도장?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="com_file1" name="com_file1"/>
					<?if($sh_file1):?>
					<img src="<?=$sh_file1?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_file1_del" value="<?=$shopRow['SH_COM_FILE1']?>"/> 삭제
					<?endif;?>
				</td>
			</tr -->


			<tr class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
				<th><?=$LNG_TRANS_CHAR["SW00018"] //통장사본?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="com_file2" name="com_file2"/>
					<?if($sh_file2):?>
					<img src="<?=$sh_file2?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_file2_del" value="<?=$shopRow['SH_COM_FILE2']?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					<?endif;?>
				</td>
			</tr>
			<tr class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
				<th><?=$LNG_TRANS_CHAR["SW00098"] //인증서?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="com_file3" name="com_file3"/>
					<?if($sh_file3):?>
					<img src="<?=$sh_file3?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_file3_del" value="<?=$shopRow['SH_COM_FILE3']?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					<?endif;?>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00020"] //승인여부?></span></th>
				<td colspan="3">
					<?if($a_admin_type == "A"):?>
						<input type="radio" <?=$nBox?>  id="shop_appr" name="shop_appr" value="Y" <?=($shopRow[SH_APPR]=="Y")? "checked":"";?>/><?=$LNG_TRANS_CHAR["CW00006"] //승인?>
						<input type="radio" <?=$nBox?>  id="shop_appr" name="shop_appr" value="N" <?=($shopRow[SH_APPR]=="N")? "checked":"";?>/><?=$LNG_TRANS_CHAR["CW00040"] //미승인?>
					<?else:?>
						<?if($shopRow['SH_APPR'] == "Y"): ?>
							<?=$LNG_TRANS_CHAR["CW00006"] //승인?>
						<?else:?>
							<?=$LNG_TRANS_CHAR["CW00040"] //미승인?>
						<?endif;?>
					<?endif;?>
				</td>
			</tr>
		</table>
	</div>

	<h3 style="margin-top:30px;"><?= $LNG_TRANS_CHAR["SW00102"]; //세부정보 ?></h3>
	<div class="tableFormWrap">
		<!--  ****************  -->
		<table class="tableForm">
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00087"]; //웹사이트 ?></th>
				<td><input type="text" id="com_site" name="com_site" value="<?=$shopRow["SH_COM_SITE"];?>">	</td>
				<th><?= $LNG_TRANS_CHAR["SW00088"]; //설립년도 ?></th>
				<td>
				<?$myear = date("Y");?>
					<select name="com_founded">
						<?
						for($i=$myear; $i >= 1900; $i--){
						?>
						<option value="<?=$i;?>" <?=($shopRow["SH_COM_FOUNDED"] == $i) ? "selected" : "";?>><?=$i;?></option>
						<?
						};
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00089"]; //직원수 ?></th>
				<td><input type="text" id="com_number" name="com_number" value="<?=$shopRow["SH_COM_NUMBER"];?>" > <?= $LNG_TRANS_CHAR["EW00133"]; //명 ?> </td>
				<th><?= $LNG_TRANS_CHAR["SW00090"]; //연간 총 매출액 ?></th>
				<td><input type="text" id="com_total_sale" name="com_total_sale" value="<?=$shopRow["SH_COM_TOTAL_SALE"];?>">	</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00091"]; //수출비율 ?></th>
				<td><input type="text" id="com_rate" name="com_rate" value="<?=$shopRow["SH_COM_RATE"];?>">%	</td>
				<th><?= $LNG_TRANS_CHAR["SW00092"]; //연간 총 샌산량 ?></th>
				<td><input type="text" id="com_total_production" name="com_total_production" value="<?=$shopRow["SH_COM_TOTAL_PRODUCTION"];?>">	</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00093"]; //주요유통시장 ?></th>
				<td colspan="3" class="staticInfo">
					<ul>
						<?
						for($i=1; $i <= $aryEntryCnt; $i++){
						?>
						<li><input type="text" class="i_w_40" id="com_country<?=$i?>" name="com_country<?=$i?>" maxlength="3" value="<?=($shopRow["SH_COM_COUNTRY{$i}"] == "") ? "0" : $shopRow["SH_COM_COUNTRY{$i}"]; ?>">%	<?=$aryEntry["SH_COM_COUNTRY{$i}"]?> </li>
						<?}?>
					</ul>
				</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00095"]; //공장위치 ?></th>
				<td><input type="text" id="com_local" name="com_local" value="<?=$shopRow["SH_COM_LOCAL"];?>">	</td>
				<th><?= $LNG_TRANS_CHAR["SW00094"]; //공장크기 ?></th>
				<td><input type="text" id="com_size" name="com_size" value="<?=$shopRow["SH_COM_SIZE"];?>">㎡	</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00096"]; //R&D직원수 ?></th>
				<td><input type="text" id="com_rd" name="com_rd" value="<?=$shopRow["SH_COM_RD"];?>"> <?= $LNG_TRANS_CHAR["EW00133"]; //명 ?></td>
				<th><?= $LNG_TRANS_CHAR["SW00097"]; //Production capacity ?></th>
				<td><input type="text" id="com_cate" name="com_cate" value="<?=$shopRow["SH_COM_CATE"];?>">	</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00098"]; //인증서 ?></th>
				<td colspan="3" id="dynamic_table">
					<div>
					<input type="text" id="com_certificates1" name="com_certificates1" value="<?=$shopRow["SH_COM_CERTIFICATES1"];?>">
					<input type="file" <?=$nBox?>  id="com_certificates1_file" name="com_certificates1_file"/>
					<?if($sh_certificates1):?>
					<div>
					<img src="<?=$sh_certificates1?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_certificates1_file_del" value="<?=$shopRow["SH_COM_CERTIFICATES1_FILE"]?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					<?endif;?>
					<a class="btn_sml" onclick="javascript:Addinput()"><span><?= $LNG_TRANS_CHAR["SW00104"]; //추가 ?></span></a>
					</div>




					<?
					if($i=1; $i <= $count; $i++){
					?>
					<?if($"sh_certificates1.{$i}"):?>
					<div>
					<img src="<?=$sh_certificates{$i}?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_certificates{$i}_file_del" value="<?=$shopRow["SH_COM_CERTIFICATES{$i}_FILE"]?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					<a class="btn_sml" onclick="javascript:Addinput()"><span><?= $LNG_TRANS_CHAR["SW00104"]; //추가 ?></span></a>
					</div>
					<?}?>



					<?if($sh_certificates1):?>
					<div>
					<img src="<?=$sh_certificates1?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_certificates1_file_del" value="<?=$shopRow["SH_COM_CERTIFICATES1_FILE"]?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					<?endif;?>
					<a class="btn_sml" onclick="javascript:Addinput()"><span><?= $LNG_TRANS_CHAR["SW00104"]; //추가 ?></span></a>
					</div>
					<?if($sh_certificates2):?>
					<div>
					<input type="text" id="com_certificates2" name="com_certificates2" value="<?=$shopRow["SH_COM_CERTIFICATES2"];?>">
					<input type="file" <?=$nBox?>  id="com_certificates2_file" name="com_certificates2_file"/>
					<img src="<?=$sh_certificates2?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_certificates2_file_del" value="<?=$shopRow["SH_COM_CERTIFICATES2_FILE"]?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					</div>
					<?endif;?>					
					<?if($sh_certificates3):?>
					<div>
					<input type="text" id="com_certificates3" name="com_certificates3" value="<?=$shopRow["SH_COM_CERTIFICATES3"];?>">
					<input type="file" <?=$nBox?>  id="com_certificates3_file" name="com_certificates3_file"/>
					<img src="<?=$sh_certificates3?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_certificates3_file_del" value="<?=$shopRow["SH_COM_CERTIFICATES3_FILE"]?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					</div>
					<?endif;?>					
					<?if($sh_certificates4):?>
					<div>
					<input type="text" id="com_certificates4" name="com_certificates4" value="<?=$shopRow["SH_COM_CERTIFICATES4"];?>">
					<input type="file" <?=$nBox?>  id="com_certificates4_file" name="com_certificates4_file"/>
					<img src="<?=$sh_certificates4?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_certificates14_file_del" value="<?=$shopRow["SH_COM_CERTIFICATES4_FILE"]?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					</div>
					<?endif;?>
					<?if($sh_certificates5):?>
					<div>
					<input type="text" id="com_certificates5" name="com_certificates5" value="<?=$shopRow["SH_COM_CERTIFICATES5"];?>">
					<input type="file" <?=$nBox?>  id="com_certificates5_file" name="com_certificates5_file"/>
					<img src="<?=$sh_certificates5?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_certificates5_file_del" value="<?=$shopRow["SH_COM_CERTIFICATES5_FILE"]?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					</div>
					<?endif;?></td>
			</tr>
		</table>
	</div>
	
	<h3 style="margin-top:30px;"><?= $LNG_TRANS_CHAR["SW00105"]; //세부정보 ?></h3>
	<div class="tableFormWrap">
		<!--  ****************  -->
		<table class="tableForm">
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00099"]; //간략소개 ?></th>
				<td><input type="text" style="width:500px;" id="com_intro1" name="com_intro1" value="<?=$shopRow["SH_COM_INTRO1"];?>" maxlength="100">	</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00100"]; //소개내용 ?>(350자)</th>
				<td><textarea type="text" id="com_intro2" name="com_intro2" style="width:100%;height:150px;" maxlength="700" ><?=$shopRow["SH_COM_INTRO2"];?></textarea><?//title="higheditor_full"?></td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00101"]; //회사사진&로고 ?></th>
				<td>
					<input type="file" <?=$nBox?>  id="com_file4" name="com_file4"/>
					<?if($sh_file4):?>
					<img src="<?=$sh_file4?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_file4_del" value="<?=$shopRow["SH_COM_FILE4"]?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					<?endif;?>
				</td>
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["SW00157"]; //Company video ?></th>
				<td>
					<input type="file" <?=$nBox?>  id="com_file5" name="com_file5"/>
					<?if($sh_file5):?>
					<img src="<?=$sh_file5?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_file5_del" value="<?=$shopRow["SH_COM_FILE5"]?>"/> <?= $LNG_TRANS_CHAR["SW00103"]; //삭제 ?>
					<?endif;?>
				</td>
			</tr>
		</table>
	</div>


	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goSumCheckSubmit('shopModify');" id="menu_auth_m" style="display:none"><strong class="ico_modify"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<?
		if($a_admin_type == 'A')
		{
		?>
		<a class="btn_new_blue" href="javascript:goSellerShopNotOkEvent('<?=$shopRow["SH_NO"];?>');" id="menu_auth_m" style="display:none"><strong class="ico_modify">미승인</strong></a>
		<a class="btn_new_blue" href="javascript:goAct('shopOkCheck');" id="menu_auth_m" style="display:none"><strong class="ico_modify">입점승인</strong></a>
		<?
		}
		?>
		<?if($a_admin_type != "S"): // 입점몰 로그인은 목록 페이지 없음 ?>
		<a class="btn_new_gray" href="javascript:goMoveUrl('shopList','');"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00001"] //취소?></strong></a>
		<?endif;?>
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->
<script>
 $("document").ready(function() {  
   
 })
</script>