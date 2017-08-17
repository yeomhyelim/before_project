<?php

	$aryCountryList		= getCountryList();			
	$aryCountryState	= getCommCodeList("STATE","");

?>
			<div class="joinWrap mt20">
				<h4 class="joinTit1"><span><?=$LNG_TRANS_CHAR["SW00001"] //회원기본 정보?></span></h4>
				<div class="requiredFieldInfo"><span><?=$LNG_TRANS_CHAR["CS00002"] // * 는 필수입력 항목입니다.?></span></div>
				<div class="regWrap">
					<table>
						<colgroup>
							<col/>
							<col/>
							<col/>
							<col/>
						</colgroup>
						<tr>
							<th><?=$LNG_TRANS_CHAR["SW00005"] //회사형태?></th>
							<td colspan="3">
								<input type="radio" <?=$nBox?>  id="com_type" name="com_type" value="C"/>기업
								<input type="radio" <?=$nBox?>  id="com_type" name="com_type" value="P" checked/>개인
							</td>
						</tr>
						<tr>
							<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00004"] //회사명?></span></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:90%;" id="com_name" name="com_name"/>
							</td>
							<th><?=$LNG_TRANS_CHAR["SW00006"] //대표자?></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:300px;" id="com_rep_nm" name="com_rep_nm"/>
							</td>
						</tr>
						<tr>
							<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00007"] //대표전화?></span></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:90%;" id="com_phone1" name="com_phone1" value="<?=$strComPhone1?>" maxlength=""/>
							</td>
							<th><?=$LNG_TRANS_CHAR["SW00008"] //대표팩스?></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:300px;" id="com_fax1" name="com_fax1" value="<?=$strComFax1?>"  maxlength=""/>
							</td>
						</tr>
						<tr>
							<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00009"] //대표메일?></span></th>
							<td colspan="3">
								<input type="text" <?=$nBox?>  style="width:300px;" id="com_mail" name="com_mail"/>
							</td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["SW00010"] //업태?></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:90%;" id="com_uptae" name="com_uptae"/>
							</td>
							<th><?=$LNG_TRANS_CHAR["SW00011"] //업종?></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:300px;" id="com_upjong" name="com_upjong"/>
							</td>
						</tr>
						<tr>
							<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00012"] //사업자번호?></span></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:90%;" id="com_num1_1" name="com_num1_1" value="<?=$strComNum1_1?>" maxlength=""/>
							</td>
							<th><?=$LNG_TRANS_CHAR["SW00013"] //통산판매번호?></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:300px;" id="com_num2_1" name="com_num2_1" value="<?=$strComNum2_1?>" maxlength=""/>
							</td>
						</tr>
						<tr>
							<th><strong><?php if($S_JOIN_ADDR["NES"]=="Y"){echo "*";}?></strong> <?=$LNG_TRANS_CHAR["MW00021"] //국가?> </th>
							<td colspan="3">
								<?=drawSelectBoxMore("com_country",$aryCountryList,'',$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
							</td>
						</tr>
						<tr>
							<th><?php if($S_JOIN_ADDR["NES"]=="Y"){echo "*";}?></strong> <?=$LNG_TRANS_CHAR["MW00011"] //주소?> </th>
							<td colspan="3">
								<dl>
									<dd><input type="text" id="com_addr" name="com_addr" class="defInput _w300" maxlength="200"/></dd>
								</dl>
							</td>
						</tr>
						<!-- 2014.09.11 kim hee sung 상세 주소 사용 안함 tr> 
							<th><?php if($S_JOIN_ADDR["NES"]=="Y"){echo "*";}?></strong> <?=$LNG_TRANS_CHAR["MW00013"] //상세주소?> </th>
							<td colspan="3">
								<dl>
									<dd><input type="text" id="com_addr2" name="com_addr2" class="defInput _w300" maxlength="200"/></dd>
								</dl>
							</td>
						</tr //-->
						<tr>
							<th><?php if($S_JOIN_ADDR["NES"]=="Y"){echo "*";}?></strong> <?=$LNG_TRANS_CHAR["MW00022"] //도시?> </th>
							<td colspan="3">
								<dl>
									<dd><input type="text" id="com_city" name="com_city" class="defInput _w300" maxlength="200"/></dd>
								</dl>
							</td>
						</tr>
						<tr>
							<th><?php if($S_JOIN_ADDR["NES"]=="Y"){echo "*";}?></strong> <?=$LNG_TRANS_CHAR["MW00023"] //주?> </th>
							<td colspan="3">
								<div id="divState1" class="<?php if($strLang=="US"){echo "hide";}?>">
									<input type="text" id="com_state_1" name="com_state_1" value="N/A" class="defInput _w200" maxlength="50" value=""/>
								</div>
								<div id="divState2" class="<?php if($strLang!="US"){echo "hide";}?>">
									<?=drawSelectBoxMore("com_state_2",$aryCountryState,'',$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
								</div>
							</td>
						</tr>
						<tr>
							<th><?php if($S_JOIN_ADDR["NES"]=="Y"){echo "*";}?></strong> <?=$LNG_TRANS_CHAR["MW00014"] //우편번호?> </th>
							<td colspan="3">
								<dl>
									<dd><input type="text" id="com_zip1" name="com_zip1" class="defInput _w100" maxlength="20"></dd>
								</dl>
							</td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["SW00019"] //증빙서류?></th>
							<td colspan="3">
								<input type="file" <?=$nBox?>  id="com_file3" name="com_file3"/>
							</td>
						</tr>
					</table>
				</div>



				<div class="tableForm">
					<!--  ****************  -->
					<h4 class="mt30"><?php echo $LNG_TRANS_CHAR["SW00027"]; // 상점 정보?></h4>
					<table>
						<tbody><tr>
							<th><span class="mustItem"><?php echo $LNG_TRANS_CHAR["SW00028"]; // 상점명?></span></th>
							<td>
								<input type="text" name="store_name" class="nbox" style="width:90%"/>
							</td>
							<th><?php echo $LNG_TRANS_CHAR["SW00039"]; // 영문상점명?></th>
							<td>
								<input type="text" name="store_name_eng" class="nbox" style="width:90%"/>
							</td>
						</tr>
						<tr>
							<th><?php echo $LNG_TRANS_CHAR["SW00029"]; // 상점 간략설명?></th>
							<td colspan="3">
								<input type="text" name="store_text" class="nbox _w700"/>
							</td>
						</tr>
						<tr>
							<th><?php echo $LNG_TRANS_CHAR["SW00031"]; // 상점 로고?></th>
							<td colspan="3">
								<input type="file" name="store_logo" class="nbox" name="store_logo"/>
							</td>
						</tr>
						<tr>
							<th><?php echo $LNG_TRANS_CHAR["SW00032"]; // 상점 이미지?></th>
							<td colspan="3">
								<input type="file" name="store_img" class="nbox" name="store_img"/>								
							</td>
						</tr>
						<tr>
							<th><?php echo $LNG_TRANS_CHAR["SW00033"]; // 상점용 탑배너?></th>
							<td colspan="3">
								<input type="file" name="store_thumb_img" class="nbox" name="store_thumb_img"/>
							</td>
						</tr>
						<tr>
							<th><?php echo $LNG_TRANS_CHAR["SW00030"]; // 상점 설명?></th>
							<td colspan="3">
								<textarea name="store_memo" class="_w700" style="height:112px;"></textarea>
							</td>
						</tr>

					</tbody></table>
				</div>



				<div class="tableForm mt20">
					<!--  ****************  -->
					<h4 class="mt10"><?=$LNG_TRANS_CHAR["SW00034"] //거래은행 및 계좌정보?></h4>
					<table>
						<tr>
							<th><?=$LNG_TRANS_CHAR["SW00035"] //예금주?></span></th>
							<td colspan="3">
								<?if($a_admin_type == "S"):?>
								<?=$sh_com_deposit?>
								<?else:?>
								<input type="text" <?=$nBox?>  style="width:150px;" id="com_deposit" name="com_deposit" value="<?=$shopRow['SH_COM_DEPOSIT']?>"/>
								<?endif;?>
							</td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["SW00036"] //계좌정보?></span></th>
							<td colspan="3">
								<?if($a_admin_type == "S"):?>
									<?=$sh_com_bank?>
								<?else:?>
									<?=drawSelectBoxMore("com_bank",$aryBank,$shopRow[SH_COM_BANK],$design ="defSelect",$onchange="",$etc="","::".$LNG_TRANS_CHAR['SW00037']."::",$html="N")?>
									<input type="text" <?=$nBox?>  style="width:200px;" id="com_bank_num" name="com_bank_num" value="<?=$shopRow[SH_COM_BANK_NUM]?>"/>
								<?endif;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="btnCenter mt30">
				<a href="./?menuType=main" class="cancelBigBtn"><?=$LNG_TRANS_CHAR['MW00044'] //취소?></a>
				<a href="javascript:goShopApplyRegAct();" class="nextBigBtn"><?=$LNG_TRANS_CHAR['MW00043'] //다음?></a>
			</div>