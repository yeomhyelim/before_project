<?

	if (!$strShopType) $strShopType = "C";
	$aryBank = getCommCodeList("BANK");
	
	$aryCountryList		= getCountryList();
	$aryCountryState	= getCommCodeList("STATE","");

	$aryCountryListTotalAry		= getCountryListTotalAry();
include $S_DOCUMENT_ROOT."/mobile/layout/html-c/kr/shop/script.shopApplyReg.php";
include_once MALL_HOME."/include/shopCom.conf.inc.php";

?>
<script>
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
			}
			else if (strVal == "KR")
			{
				$("#divAddr1").css("display","");
				$("#divAddr2").css("display","none");
				$(".krView").css("display","");
				$(".otherView").css("display","none");
				$(".krView td").attr("colspan",$(".tableForm col").length-1);
			}
			else
			{
				$("#divAddr1").css("display","none");
				$("#divAddr2").css("display","");
				$(".krView").css("display","none");
				$(".otherView").css("display","");
			}
		});
	});
</script>
<form name="form" method="post" id="form">
<input type="hidden" name="menuType" value="shop">
<input type="hidden" name="mode" value="shopApplyReg">
<input type="hidden" name="act" value="shopApplyReg">
<input type="hidden" name="shopNo" value="">
<input type="hidden" id="shop_appr" name="shop_appr" value="R"/>
  <div class="shopApplyRegFormWrap">
	<div class="shopApplyRegForm">

		<h2><?=$LNG_TRANS_CHAR["SW00001"] //회원기본 정보?></h2>
		<div class="tableBox">
			<table>
				<tr>
					<th><strong class="redTxt">*</strong><?= $LNG_TRANS_CHAR["MW00021"]; //국가 ?></th>
					<td>
						<?=drawSelectBoxMore("com_country",$aryCountryList,$S_SITE_LNG,$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
					</td>
						<!--<select name="com_country" id="com_country" class="st_country" onchange="javascript:comContryCheck();">
						<?
						for($i=0; $i < sizeof($aryCountryListTotalAry); $i++){
						?>
							<option value="<?echo $aryCountryListTotalAry[$i]["CT_CODE"];?>" <?php echo ($aryCountryListTotalAry[$i]["CT_CODE"] == $strLang) ? "selected" : "" ;?>><?echo $aryCountryListTotalAry[$i]["CT_NAME_{$S_SITE_LNG}"];?></option>
						<?}?>
						</select>-->
					</td>
				</tr>
				<tr>
					<th><strong class="redTxt">*</strong> TYPE</th>
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
					<th><strong class="redTxt">*</strong> <?=$LNG_TRANS_CHAR["SW00006"] //대표자?></th>
					<td>
						<input type="text" <?=$nBox?>   id="com_rep_nm" name="com_rep_nm"/>
					</td>
				</tr>
				<tr>
					<th><strong class="redTxt">*</strong> <span class="mustItem"><?=$LNG_TRANS_CHAR["SW00004"] //회사명?></span></th>
					<td>
						<input type="text" <?=$nBox?>   id="com_name" name="com_name" />
					</td>
				</tr>
				<!-- tr>
					<th><?=$LNG_TRANS_CHAR["SW00005"] //회사형태?></th>
					<td colspan="3">
						<input type="radio" <?=$nBox?>  id="com_type" name="com_type" value="C"/>기업
						<input type="radio" <?=$nBox?>  id="com_type" name="com_type" value="P" checked/>개인
					</td //-->
				</tr>
				<tr>							
					<th><strong class="redTxt">*</strong> <?=$LNG_TRANS_CHAR["SW00008"] //대표팩스?></th>
					<td>
					<div class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
						<input type="text" <?=$nBox?> id="com_fax1" name="com_fax1" value="<?=$strComFax1?>"  maxlength=""/>
						-
						<input type="text" <?=$nBox?> id="com_fax2" name="com_fax2" value="<?=$strComFax2?>"  maxlength=""/>
						-
						<input type="text" <?=$nBox?>  id="com_fax3" name="com_fax3" value="<?=$strComFax3?>"  maxlength=""/>
						</div>
						<div class="otherView" style="display:<?=($S_SITE_LNG != 'KR') ? '' : 'none';?>">
						<input type="text" <?=$nBox?> id="com_fax" name="com_fax" value="<?=$strComFax?>"  maxlength=""/>
						</div>
					</td>
				</tr>
				<tr>
					<th><strong class="redTxt">*</strong> <span class="mustItem"><?=$LNG_TRANS_CHAR["SW00007"] //대표전화?></span></th>
					<td>
						<div class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
						<input type="text" <?=$nBox?> id="com_phone1" name="com_phone1" value="<?=$strComPhone1?>" maxlength=""/>
						-
						<input type="text" <?=$nBox?> id="com_phone2" name="com_phone2" value="<?=$strComPhone2?>" maxlength=""/>
						-
						<input type="text" <?=$nBox?> id="com_phone3" name="com_phone3" value="<?=$strComPhone3?>" maxlength=""/>
						</div>
						<div class="otherView" style="display:<?=($S_SITE_LNG != 'KR') ? '' : 'none';?>">
						<input type="text" <?=$nBox?> id="com_phone" name="com_phone" value="<?=$strComPhone?>"  maxlength=""/>
						</div>
					</td>
				</tr>
				<tr class="krView" style="display:<?=($S_SITE_LNG == 'KR') ? '' : 'none';?>">
					<th><strong class="redTxt">*</strong> <?=$LNG_TRANS_CHAR["SW00012"] //사업자번호?></span></th>
					<td class="number">
						<input type="text" <?=$nBox?> id="com_num1_1" name="com_num1_1" value="<?=$strComNum1_1?>" maxlength="3"/>
						-
						<input type="text" <?=$nBox?> id="com_num1_2" name="com_num1_2" value="<?=$strComNum1_2?>" maxlength="2"/>
						-
						<input type="text" <?=$nBox?> id="com_num1_3" name="com_num1_3" value="<?=$strComNum1_3?>" maxlength="5"/>
					</td>
				</tr>
				<tr>
					<th><strong class="redTxt">*</strong> <?=$LNG_TRANS_CHAR["SW00015"] //주소?></span></th>
					<td>
						<p class="number">
							<div id="divAddr1" class="divAddr1" <?=($S_SITE_LNG!="KR")?"style=\"display:none\"":"";?>>
								<input type="text" <?=$nBox?>  style="width:50px;" id="com_zip1" name="com_zip1" value="" readonly/>
								-
								<input type="text" <?=$nBox?>  style="width:50px;" id="com_zip2" name="com_zip2" value="" readonly/>
								<a href="javascript:sample2_execDaumPostcode();" class="btn_gray"><?=$LNG_TRANS_CHAR["SW00014"] //우편번호?></a>
							</div>
							<input type="text" <?=$nBox?>  style="" id="com_addr" name="com_addr" value="" class="mt5"/>
							<div id="divAddr2" class="divAddr2" <?=($S_SITE_LNG=="KR")?"style=\"display:none\"":"";?>>
								<input type="text" <?=$nBox?>  style="" id="com_city" name="com_city" value="" class="mt5" alt="도시"/><?= $LNG_TRANS_CHAR["CW00130"]; //도시 ?>
								<div id="divState1" <?=($S_SITE_LNG=="US")?"style=\"display:none\"":"";?>>
									<input type="text" id="com_state_1" name="com_state_1" class="defInput _w200" maxlength="50" value="<?=($strState)? $strState: "N/A";?>"/>
								</div>
								<div id="divState2" <?=($S_SITE_LNG!="US")?"style=\"display:none\"":"";?>>
									<?=drawSelectBoxMore("com_state_2",$aryCountryState,$strState,$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
								</div>
							</div>
							<div id="layer" style="display:none;width:100%;height:100%;top:0px;left:0px;position:absolute;overflow-y:scroll;-webkit-overflow-scrolling:touch;">
								<h2>우편번호</h2>
							<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:20px;top:35px;z-index:1;display:none;" onclick="closeDaumPostcode()" alt="닫기 버튼">
							</div>

							<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
							<script>
							// 우편번호 찾기 화면을 넣을 element
							var element_layer = document.getElementById('layer');

							function closeDaumPostcode() {
							// iframe을 넣은 element를 안보이게 한다.
							element_layer.style.display = 'none';

							$('body').css({'position':'static','overflow-y':'auto'});
							}

							function sample2_execDaumPostcode() {

							$('body').css({'position':'fixed','overflow-y':'scroll','width':'100%'});

							new daum.Postcode({
								oncomplete: function(data) {
									// 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

									// 각 주소의 노출 규칙에 따라 주소를 조합한다.
									// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
									var fullAddr = data.address; // 최종 주소 변수
									var extraAddr = ''; // 조합형 주소 변수

									// 기본 주소가 도로명 타입일때 조합한다.
									if(data.addressType === 'R'){
										//법정동명이 있을 경우 추가한다.
										if(data.bname !== ''){
											extraAddr += data.bname;
										}
										// 건물명이 있을 경우 추가한다.
										if(data.buildingName !== ''){
											extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
										}
										// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
										fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
									}

									// 우편번호와 주소 및 영문주소 정보를 해당 필드에 넣는다.
									document.getElementById('com_zip1').value = data.postcode1;
									document.getElementById('com_zip2').value = data.postcode2;
									document.getElementById('com_addr').value = fullAddr;
							//                document.getElementById('').value = data.addressEnglish;

									// iframe을 넣은 element를 안보이게 한다.
									element_layer.style.display = 'none';

									$('body').css({'position':'static','overflow-y':'auto'});

									//$('#baddr2').focus();
								},
								width : '100%',
								height : '100%'
							}).embed(element_layer);

							// iframe을 넣은 element를 보이게 한다.
							element_layer.style.display = 'block';
							}
							</script>
							<!--a class="btn_gray" href="javascript:goZip(4)"><?=$LNG_TRANS_CHAR["SW00014"] //우편번호?></a-->
						</p>

						
						
					</td>
				</tr>
				<tr>
					<th><strong class="redTxt">*</strong> <span class="mustItem">E-mail</span></th>
					<td>
						<input type="text" <?=$nBox?>   id="com_mail" name="com_mail"/>
					</td>
				</tr>
				<!--<tr class="krView" style="display:<?=($strLang == 'KR') ? '' : 'none';?>">
					<th><strong class="redTxt">*</strong> 통장사본</th>
					<td>
						<input type="file" <?=$nBox?>  id="com_file2" name="com_file2" class="ip_file"/>
					</td>
				</tr>
				<tr class="krView" style="display:<?=($strLang == 'KR') ? '' : 'none';?>">
					<th><strong class="redTxt">*</strong> 사업자등록사본</th>
					<td>
						<input type="file" <?=$nBox?>  id="com_file3" name="com_file3" class="ip_file"/>
					</td>
				</tr>//-->
			</table>
		</div>
		<div class="btnCenter mt20 shopApplyBtnBox">
			<ul>
				<li><a href="javascript:goShopApplyRegCheck();" id="btnCheck" class="btn_red"><?= $LNG_TRANS_CHAR["SW00057"]; //입점요청하기 ?></a></li>
				<!-- <li><a href="javascript:goShopApplyDetailView();" id="btnCheck" class="Btn">+전체열기</a></li> -->
			</ul>
		</div>


		<div class="tableFormWrap" style="margin-top:30px;display:none" id="detailInput1">
			<!--  ****************  -->
			<div class="titBox"><span class="barRed"></span><span class="tit"><?= $LNG_TRANS_CHAR["SW00055"]; //세부정보 ?></span></a></div>
			<div class="tableBox">
				<table>
					<tbody>
					<tr>
						<th><strong class="redTxt">*</strong> <?= $LNG_TRANS_CHAR["SW00040"]; //웹사이트 ?></th>
						<td>
							<input type="text" id="com_site" name="com_site" class="nbox"/>
						</td>
					</tr>
					<tr>
						<th><strong class="redTxt">*</strong> <?= $LNG_TRANS_CHAR["SW00041"]; //설립연도 ?></th>
						<td><?$myear = date("Y");?>
							<select name="com_founded">
								<?
								for($i=$myear; $i >= 1900; $i--){
								?>
								<option value="<?=$i;?>" ><?=$i;?></option>
								<?
								};
								?>
							</select></td>
					</tr>
					<tr>
						<th><strong class="redTxt">*</strong> <?= $LNG_TRANS_CHAR["SW00042"]; //직원수 ?></th>
						<td><input type="text" id="com_number" name="com_number" class="nbox"/><?= $LNG_TRANS_CHAR["SW00058"]; //명 ?></td>
					</tr>
					<tr>
						<th><strong class="redTxt">*</strong> <?= $LNG_TRANS_CHAR["SW00045"]; //연간 총 생산량 ?></th>
						<td><input type="text"  id="com_total_production" name="com_total_production" class="nbox"/></td>
					</tr>
					<tr>
						<th><strong class="redTxt">*</strong> <?= $LNG_TRANS_CHAR["SW00044"]; //수출비율 ?></th>
						<td><input type="text" id="com_rate" name="com_rate" class="nbox"/></td>						
					</tr>
					<tr>
						<th><strong class="redTxt">*</strong> <?= $LNG_TRANS_CHAR["SW00046"]; //주요 유통 시장 ?> (%)</th>
						<td>
							<ul class="infoTable">
								<?
								for($i=1; $i <= $aryEntryCnt; $i++){
								?>
								<li><input type="text" class="nbox" id="com_country<?=$i?>" name="com_country<?=$i?>" maxlength="3" value=""><span><?=$aryEntry["SH_COM_COUNTRY{$i}"]?></span></li>
								<?}?>
							</ul>
						</td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00047"]; //공장크기 ?></th>
						<td><input type="text" id="com_size" name="com_size" class="nbox"/>㎡</td>						
					</tr>
					<tr>
						<th><strong class="redTxt">*</strong> <?= $LNG_TRANS_CHAR["SW00048"]; //공장위치 ?></th>
						<td><input type="text" id="com_local" name="com_local" class="nbox"/></td>						
					</tr>
					<tr>
						<th><strong class="redTxt">*</strong> <?= $LNG_TRANS_CHAR["SW00049"]; //R&D직원수 ?></th>
						<td><input type="text" id="com_rd" name="com_rd" class="nbox"/><?= $LNG_TRANS_CHAR["SW00058"]; //명 ?></td>
					</tr>
					<tr>
						<th> <?= $LNG_TRANS_CHAR["SW00050"]; //Production capacity ?></th>
						<td><input type="text" id="com_cate" name="com_cate" class="nbox"/></td>
					</tr>
					<tr>
						<th><strong class="redTxt">*</strong><?= $LNG_TRANS_CHAR["SW00051"]; //인증서 ?></th>
						<td id="dynamic_table">
							<div class="dynamicBox">
								<input type="text" id="com_certificates1" name="com_certificates1" value="">
								<input type="file" id="com_certificates1_file" name="com_certificates1_file"/>
								<a class="btn_gray" onclick="javascript:Addinput()"><span><?= $LNG_TRANS_CHAR["SW00059"]; //추가 ?></span></a>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="tableFormWrap" style="margin-top:30px;display:none" id="detailInput2">
			<!--  ****************  -->
			<div class="titBox"><span class="barRed"></span><span class="tit"><?= $LNG_TRANS_CHAR["PW00089"]; //회사소개 ?></span></a></div>
			<div class="tableBox">
				<table>
					<tbody>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00052"]; //간략소개 ?></th>
						<td><input type="text" id="com_intro1" name="com_intro1" value="" maxlength="100">	</td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00053"]; //소개내용 ?></th>
						<td>
							<textarea name="com_intro2" id="com_intro2" class="" style="height:112px;" title="higheditor_full"></textarea>
						</td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00054"]; //회사사진&로고 ?></th>
						<td>
							<input type="file" name="com_file4" class="nbox" id="com_file4"/>
						</td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00060"]; //Company Video ?></th>
						<td>
							<input type="file" name="com_file5" class="nbox" id="com_file5"/>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="btnCenter mt30 shopApplyBtnBox">
			<!--<a href="./?menuType=main" class="cancelBigBtn"><?=$LNG_TRANS_CHAR['MW00044'] //취소?></a>-->
			<a href="javascript:goShopApplyRegAct();" id="btnCheck" class="btn_red"><?= $LNG_TRANS_CHAR["OW00113"]; //저장 ?><?//=$LNG_TRANS_CHAR['MW00043'] //다음?></a>
		</div>

		<div class="clr"></div>
	</div>	
</div>
</form>