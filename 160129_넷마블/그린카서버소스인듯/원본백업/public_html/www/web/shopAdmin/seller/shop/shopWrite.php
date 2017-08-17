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

			$(".divState1").css("display","block");
			$(".divState2").css("display","none");

			if (strVal == "US")
			{
				$(".divAddr1").css("display","none");
				$(".divAddr2").css("display","");
				$(".divState1").css("display","none");
				$(".divState2").css("display","");
				$(".krView").css("display","none");
				$(".otherView").css("display","");
			}
			else if (strVal == "KR")
			{
				$(".divAddr1").css("display","");
				$(".divAddr2").css("display","none");
				$(".krView").css("display","");
				$(".otherView").css("display","none");
				$(".krView td").attr("colspan",$(".tableForm col").length-1);
			}
			else
			{
				$(".divAddr1").css("display","none");
				$(".divAddr2").css("display","");
				$(".krView").css("display","none");
				$(".otherView").css("display","");
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
	var count = 2;
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
		<h2><?=$LNG_TRANS_CHAR["SW00001"] //입점몰 등록?></h2>
		<div class="clr"></div>
	</div>
	<!-- 언어 선택 탭 -->
	<?include "./include/tab_language.inc.php";?>
	<!-- 언어 선택 탭-->
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th>
				<span class="mustItem">&nbsp;</span>표시가 있는 입력란은 필수 입력란입니다. 꼭 입력해 주세요
				</th>
			</tr>
		</table>
	</div>
	<div class="tableForm">
		<!--  ****************  -->
		<table>
			<tr>
				<!--th><?=$LNG_TRANS_CHAR["SW00005"] //회사형태?></th>
				<td colspan="3">
					<input type="radio" <?=$nBox?>  id="com_type" name="com_type" value="C" checked/>기업
					<input type="radio" <?=$nBox?>  id="com_type" name="com_type" value="P"/>개인
				</td-->
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["MW00075"]; //국가 ?></span></th>
				<td>
					<?=drawSelectBoxMore("com_country",$aryCountryList,$shopRow[SH_COM_COUNTRY],$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
				</td>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00004"] //회사명?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:90%;" id="com_name" name="com_name"/>
				</td>
			</tr>
			<tr>
				
				<th><?=$LNG_TRANS_CHAR["SW00006"] //대표자?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="com_rep_nm" name="com_rep_nm"/>
				</td>
				<th>Type</th>
				<td>
					<select name="com_category">
						<?
						$strTyoeOption ='';
						foreach($aryType as $key => $val){
							$strTyoeOption .= "<option value='".$key."'>".$val."</option>";
						}
						echo $strTyoeOption;?>
					</select>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00007"] //대표전화?></span></th>
				<td>
					<div class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_phone1" name="com_phone1" value="<?=$strComPhone1?>" maxlength="4"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_phone2" name="com_phone2" value="<?=$strComPhone2?>" maxlength="4"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_phone3" name="com_phone3" value="<?=$strComPhone3?>" maxlength="4"/>
					</div>
					<div class="otherView" style="display:<?=($S_SITE_LNG != 'KR') ? '' : 'none';?>">
					<input type="text" <?=$nBox?> id="com_phone" name="com_phone" value="<?=$strComPhone?>"  maxlength=""/>
					</div>
				</td>
				<th><?=$LNG_TRANS_CHAR["SW00008"] //대표팩스?></th>
				<td>
				<div class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_fax1" name="com_fax1" value="<?=$strComFax1?>"  maxlength="4"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_fax2" name="com_fax2" value="<?=$strComFax2?>"  maxlength="4"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_fax3" name="com_fax3" value="<?=$strComFax3?>"  maxlength="4"/>
					</div>
					<div class="otherView" style="display:<?=($S_SITE_LNG != 'KR') ? '' : 'none';?>">
					<input type="text" <?=$nBox?>   id="com_fax" name="com_fax" value="<?=$strComFax?>"  maxlength=""/>
					</div>
				</td>
			</tr>
			
			<!--tr>
				<th><?=$LNG_TRANS_CHAR["SW00010"] //업태?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:90%;" id="com_uptae" name="com_uptae"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["SW00011"] //업종?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="com_upjong" name="com_upjong"/>
				</td>
			</tr-->
			<tr class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00012"] //사업자번호?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:40px;" id="com_num1_1" name="com_num1_1" value="<?=$strComNum1_1?>" maxlength="3"/>
					-
					<input type="text" <?=$nBox?>  style="width:30px;" id="com_num1_2" name="com_num1_2" value="<?=$strComNum1_2?>" maxlength="2"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_num1_3" name="com_num1_3" value="<?=$strComNum1_3?>" maxlength="5"/>
				</td>
				<!--th><?=$LNG_TRANS_CHAR["SW00013"] //통산판매번호?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_num2_1" name="com_num2_1" value="<?=$strComNum2_1?>" maxlength="5"/>
					-
					<input type="text" <?=$nBox?>  style="width:100px;" id="com_num2_2" name="com_num2_2" value="<?=$strComNum2_2?>" />
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_num2_3" name="com_num2_3" value="<?=$strComNum2_3?>" />
				</td-->
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00015"] //주소?></span></th>
				<td colspan="3">
					<div id="divAddr1" <?=($S_SITE_LNG!="KR" || $shopRow[SH_COM_COUNTRY] != "KR")?"style=\"display:none\"":"";?>>
						<input type="text" <?=$nBox?>  style="width:50px;" id="com_zip1" name="com_zip1" value="<?=$strComZip1?>"/>
						-
						<input type="text" <?=$nBox?>  style="width:50px;" id="com_zip2" name="com_zip2" value="<?=$strComZip2?>"/>
						<a class="btnIDChk" href="javascript:goZip(1)"><?=$LNG_TRANS_CHAR["SW00014"] //우편번호?></a><br>
					</div>
					<input type="text" <?=$nBox?>  style="width:540px;" id="com_addr" name="com_addr" value="<?=$shopRow['SH_COM_ADDR']?>" class="mt5"/>
					<div class="divAddr1" <?=($shopRow[SH_COM_COUNTRY]!="KR")?"style=\"display:none\"":"";?>>
						<input type="text" <?=$nBox?>  style="width:540px" id="com_addr2" name="com_addr2" value="<?=$shopRow['SH_COM_ADDR2']?>" class="mt5"/>
					</div>
					<div id="divAddr2" <?=($S_SITE_LNG=="KR")?"style=\"display:none\"":"";?>>
						<input type="text" <?=$nBox?>  style="width:440px;" id="com_city" name="com_city" value="<?=$shopRow['SH_COM_CITY']?>" class="mt5" alt="도시"/>도시
						<div id="divState1" <?=($S_SITE_LNG=="US")?"style=\"display:none\"":"";?>>
							<input type="input" id="com_state_1" name="com_state_1" class="defInput _w200" maxlength="50" value="<?=($shopRow['SH_COM_STATE'])? $shopRow['SH_COM_STATE']: "N/A";?>"/>
						</div>
						<div id="divState2" <?=($S_SITE_LNG!="US")?"style=\"display:none\"":"";?>>
							<?=drawSelectBoxMore("com_state_2",$aryCountryState,$shopRow['SH_COM_STATE'],$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00009"] //대표메일?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="com_mail" name="com_mail"/>
				</td>
			</tr>
			<!--tr>
				<th><?=$LNG_TRANS_CHAR["SW00017"] //인감도장?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="com_file1" name="com_file1"/>
				</td>
			</tr -->
			<tr class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
				<th><?=$LNG_TRANS_CHAR["SW00018"] //통장사본?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="com_file2" name="com_file2"/>
				</td>
			</tr>
			<tr class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
				<th><?=$LNG_TRANS_CHAR["SW00158"] //통장사본 ?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="com_file3" name="com_file3"/>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00020"] //승인여부?></span></th>
				<td colspan="3">
					<input type="radio" <?=$nBox?>  id="shop_appr" name="shop_appr" value="Y" checked/><?=$LNG_TRANS_CHAR["CW00006"] //승인?>
					<input type="radio" <?=$nBox?>  id="shop_appr" name="shop_appr" value="H"/><?=$LNG_TRANS_CHAR["SW00070"] //보류?>
					<input type="radio" <?=$nBox?>  id="shop_appr" name="shop_appr" value="N"/><?=$LNG_TRANS_CHAR["CW00040"] //미승인?>
					<input type="radio" <?=$nBox?>  id="shop_appr" name="shop_appr" value="S"/><?=$LNG_TRANS_CHAR["SW00071"] //승인대기?>
				</td>
			</tr>
		</table>
	</div>
	
	<h3 style="margin-top:30px;">세부정보</h3>
	<div class="tableFormWrap">
		<!--  ****************  -->
		<table class="tableForm">
			<tr>
				<th>웹사이트</th>
				<td>http://<input type="text" id="com_site" name="com_site" value="<?=$shopRow["SH_COM_SITE"];?>">	
						<div class="helpTxt">
							* <?= $LNG_TRANS_CHAR["SS00008"]; //대표 웹사이트 하나만 등록해 주세요. ?> 
						</div>
				</td>
				<th>설립년도</th>
				<td>
				<?$myear = date("Y");
				?>
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
				<th>직원수</th>
				<td><input type="text" id="com_number" name="com_number" value="<?=$shopRow["SH_COM_NUMBER"];?>" >명	</td>
				<th>연간 총 매출액</th>
				<td><input type="text" id="com_total_sale" name="com_total_sale" value="<?=$shopRow["SH_COM_TOTAL_SALE"];?>">	</td>
			</tr>
			<tr>
				<th>수출비율</th>
				<td><input type="text" id="com_rate" name="com_rate" value="<?=$shopRow["SH_COM_RATE"];?>">%	</td>
				<th>연간 총 샌산량</th>
				<td><input type="text" id="com_total_production" name="com_total_production" value="<?=$shopRow["SH_COM_TOTAL_PRODUCTION"];?>">	</td>
			</tr>
			<tr>
				<th>주요유통시장</th>
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
				<th>공장위치</th>
				<td><input type="text" id="com_local" name="com_local" value="<?=$shopRow["SH_COM_LOCAL"];?>">	</td>
				<th>공장크기</th>
				<td><input type="text" id="com_size" name="com_size" value="<?=$shopRow["SH_COM_SIZE"];?>">㎡	</td>
			</tr>
			<tr>
				<th>R&D직원수</th>
				<td><input type="text" id="com_rd" name="com_rd" value="<?=$shopRow["SH_COM_RD"];?>"> 명</td>
				<th>Production capacity</th>
				<td><input type="text" id="com_cate" name="com_cate" value="<?=$shopRow["SH_COM_CATE"];?>">	</td>
			</tr>
			<tr>
				<th>인증서</th>
				<td colspan="3" id="dynamic_table">
					<div>
					<input type="text" id="com_certificates1" name="com_certificates1" value="<?=$shopRow["SH_COM_CERTIFICATES1"];?>"><input type="file" <?=$nBox?>  id="com_certificates1_file" name="com_certificates1_file"/>
					<a class="btn_sml" onclick="javascript:Addinput()"><span><?= $LNG_TRANS_CHAR["SW00104"]; //추가 ?></span></a>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<h3 style="margin-top:30px;">소개정보</h3>
	<div class="tableFormWrap">
		<!--  ****************  -->
		<table class="tableForm">
			<tr>
				<th>간략소개</th>
				<td><input type="text" id="com_intro1" name="com_intro1" value="<?=$shopRow["SH_COM_INTRO1"];?>"  maxlength='255' />	</td>
			</tr>
			<tr>
				<th>소개내용(350자)</th>
				<td><textarea type="text" id="com_intro2" name="com_intro2" style="width:100%;height:150px;" maxlength="700" ><?=$shopRow["SH_COM_INTRO2"];?></textarea><?//title="higheditor_full"?></td>
			</tr>
			<tr>
				<th>회사사진&로고</th>
				<td>
					<input type="file" <?=$nBox?>  id="com_file4" name="com_file4"/>
					<?if($sh_file4):?>
					<img src="<?=$sh_file4?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_file4_del" value="<?=$shopRow["SH_COM_FILE4"]?>"/> 삭제
					<?endif;?>
				</td>
			</tr>
			<!-- tr>
				<th>Company video</th>
				<td>
					<input type="file" <?=$nBox?>  id="com_file5" name="com_file5"/>
					<?if($sh_file5):?>
					<img src="<?=$sh_file5?>" style="width:70px;height:70px">
					<input type="checkbox" name="com_file5_del" value="<?=$shopRow["SH_COM_FILE5"]?>"/> 삭제
					<?endif;?>
				</td>
			</tr -->
		</table>
	</div>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goSumCheckSubmit('shopWrite');" id="menu_auth_w"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		<a class="btn_new_gray" href="#"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->