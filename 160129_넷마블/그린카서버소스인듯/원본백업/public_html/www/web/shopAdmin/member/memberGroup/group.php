<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MW00026"] //회원그룹관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableListWrap mt20">
		<div class="titInfoTxt">
			<ul>
				<li>- <?=$LNG_TRANS_CHAR["BS00085"]//회원 그룹을 설정합니다.?></li>
				<li>- <?=$LNG_TRANS_CHAR["BS00086"]//운영에 필요한 그룹을 설정해 주세요.?></li>
			</ul>
		</div>
		<table class="tableList">
			<colgroup>
				<col width=40/>
				<col />
				<!--<col width=60/> -->
				<!-- <col width=120/> -->
				<!--<col width=80/>//-->
				<!-- <col width=80/> -->
				<!-- <col width=120/> -->
				<col width=120/>
				<!-- <col width=80/> -->
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["MW00006"] //그룹?></th>
				<!-- <th><?=$LNG_TRANS_CHAR["MW00226"]//등급기준?></th> -->
				<!--<th><?=$LNG_TRANS_CHAR["MW00031"] //할인율?></th>//-->
				<!-- <th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th> -->
				<!-- <th><?=$LNG_TRANS_CHAR["MW00248"] //결제조건?></th> -->
				<th><?=$LNG_TRANS_CHAR["EW00132"]//회원수?></th>
				<!-- <th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th> -->
			</tr>
			<?
				if (is_array($aryGroupList)){
					$intListNum = 1;
					for($i=0;$i<sizeof($aryGroupList);$i++){
						if ($aryGroupList[$i][G_CODE] != "001"){
							$strGroupPriceSt = "";
							if ($aryGroupList[$i]["G_PRICE_ST"] == "P") $strGroupPriceSt = "주문금액";
							elseif($aryGroupList[$i]["G_PRICE_ST"] == "S") $strGroupPriceSt = "결제금액";
							
							${"aryGroupSettle_".$row[G_CODE]}  = explode("/",$row[G_SETTLE]);
			?>
			<tr>
				<td><?=$intListNum?></td>
				<td class="alignLeft"><?=$aryGroupList[$i][G_NAME]?></td>
				<!-- <td><?=$strGroupPriceSt?></td> -->
				<!--<td><?=$aryGroupList[$i][G_DISCOUNT_RATE]?><?=$S_ARY_PRICE_UNIT[$aryGroupList[$i][G_DISCOUNT_UNIT]]?></td>//-->
				<!-- <td><?=$aryGroupList[$i][G_POINT_RATE]?><?=$S_ARY_PRICE_UNIT[$aryGroupList[$i][G_POINT_UNIT]]?></td> -->
				<!--
				<td>
					<?=in_array("B", ${"aryGroupSettle_".$row[G_CODE]})?"무통장입금/":"";?>
					<?=in_array("C", ${"aryGroupSettle_".$row[G_CODE]})?"카드/":"";?>
					<?=in_array("A", ${"aryGroupSettle_".$row[G_CODE]})?"계좌이체/":"";?>
					<?=in_array("T", ${"aryGroupSettle_".$row[G_CODE]})?"가상계좌":"";?>
				</td>
				-->
				<td><?=NUMBER_FORMAT($aryGroupList[$i][G_MEMBER_CNT])?></td>
				<!-- 
				<td>
					<a class="btn_sml" href="javascript:goGruopModify('<?=$aryGroupList[$i][G_CODE]?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] // 수정?></strong></a>
					<?if(intval($aryGroupList[$i][G_CODE]) > 5):?>
					<a class="btn_sml" href="javascript:goGroupDelete('<?=$aryGroupList[$i][G_CODE]?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] // 삭제?></strong></a>
					<?endif;?>
				</td>
				-->
			</tr>
			<?
						$intListNum++;
						}
					}
				}
			?>
		</table>
	</div>
	<!-- tableList 
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goGroupAdd();" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00028"] //그룹추가?></strong></a>
	</div>
	-->

 

	<br>
	<div id="divGroupForm" style="<?=($strG_CODE!="")?"":"display:none";?>">
		<div class="tableForm">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00222"] //등급명?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:300px;" id="name" name="name" value="<?=$row[G_NAME]?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00223"]//등급설명?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:300px;" id="memo" name="memo" value="<?=$row[G_MEMO]?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00033"] //등급표시?></th>
					<td>
						<input type="radio" id="show" name="show" value="T" <?=($row[G_SHOW] == "T")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00249"]//노출함?>
						<input type="radio" id="show" name="show" value="I" <?=($row[G_SHOW] == "I")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00250"]//노출안함?>
						<div class="helpTxtGray">
							* <?=$LNG_TRANS_CHAR['MS00076']//추가할인이 있는경우 "VIP회원(10%할인적용)"형식으로 보여집니다.?>
						</div>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00224"]//적용방법?></th>
					<td>
						<input type="radio" id="apply" name="apply" value="A" <?=($row[G_APPLY] == "A")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00251"]//자동적용?>
						<input type="radio" id="apply" name="apply" value="S" <?=($row[G_APPLY] == "S")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00252"]//수동적용?>
						<div class="helpTxtGray">
							* <?=$LNG_TRANS_CHAR['MS00077']//[자동적용] : 기준에 자동 적용됩니다.?><br>
							* <?=$LNG_TRANS_CHAR['MS00077']//[수동적용] : 관리자의 등급 변경을 통해 적용됩니다.?>
						</div>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00006"]//결제방법?></th>
					<td>
						<?if ($strSettleB == "Y"){?>
						<input type="checkbox" id="settle[]" name="settle[]" value="B" <?=in_array("B", $aryGroupSettle)?"checked":"";?>>무통장입금
						<?}?>
						<?if ($strSettleC == "Y"){?>
						<input type="checkbox" id="settle[]" name="settle[]" value="C" <?=in_array("C", $aryGroupSettle)?"checked":"";?>>카드
						<?}?>
						<?if ($strSettleA == "Y"){?>
						<input type="checkbox" id="settle[]" name="settle[]" value="A" <?=in_array("A", $aryGroupSettle)?"checked":"";?>>계좌이체
						<?}?>
						<?if ($strSettleT == "Y"){?>
						<input type="checkbox" id="settle[]" name="settle[]" value="T" <?=in_array("T", $aryGroupSettle)?"checked":"";?>>가상계좌
						<?}?>
						<?if ($strSettleM == "Y"){?>
						<input type="checkbox" id="settle[]" name="settle[]" value="M" <?=in_array("M", $aryGroupSettle)?"checked":"";?>>휴대폰
						<?}?>
						<div class="helpTxtGray">
							* <?=$LNG_TRANS_CHAR['MS00079']//결제방법은 해외는 적용되지 않습니다.?>
						</div>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00226"]//등급기준?></th>
					<td>
						<input type="radio" id="price_st" name="price_st" value="P" <?=($row[G_PRICE_ST] == "P")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00172"]//주문금액?>
						<input type="radio" id="price_st" name="price_st" value="S" <?=($row[G_PRICE_ST] == "S")?"checked":"";?>><?=$LNG_TRANS_CHAR["OW00008"]//결제금액?>
						<div class="helpTxtGray">
							* <?=$LNG_TRANS_CHAR['MS00080'] //주문금액 : 각종할인(쿠폰/적립금/할인금액등) 금액을 제외하지 않고 주문이 발생한 총 누적금액?><br>
							* <?=$LNG_TRANS_CHAR['MS00081'] //결제금액 : 각종할인(쿠폰/적립금/할인금액등) 금액을 제외한 실제 고객이 결제한 총 금액?><br>
							* <?=$LNG_TRANS_CHAR['MS00082'] //실제 고객이 결제한 총 금액 기준을 추천합니다.?>
						</div>
					</td>
				</tr>
				<tr>
					<th>최소구매금액</th>
					<td><input type="text" name="min_buy_price" value="<?php echo $intMinBuyPrice;?>"> 원 이상</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00227"]//등급조건?></th>
					<td>
						<?=$LNG_TRANS_CHAR["MW00028"]//구매금액?> : <input type="text" <?=$nBox?>  style="width:100px;" id="price_min" name="price_min" value="<?=$row[G_PRICE_MIN]?>"/> <?=$LNG_TRANS_CHAR["MW00036"] //이상?> ~ <input type="text" <?=$nBox?>  style="width:100px;" id="price_max" name="price_max" value="<?=$row[G_PRICE_MAX]?>"/><?=$LNG_TRANS_CHAR["MW00037"] //미만?> <br>
						<?=$LNG_TRANS_CHAR["MW00029"] //구매횟수?> : <input type="text" <?=$nBox?>  style="width:100px;" id="buy_cnt" name="buy_cnt" value="<?=$row[G_BUY_CNT]?>"/> <?=$LNG_TRANS_CHAR["MW00036"] //이상?>  <br>
						<?=$LNG_TRANS_CHAR["MW00030"] //상품후기 횟수?> : <input type="text" <?=$nBox?>  style="width:72px;" id="product_cnt" name="product_cnt" value="<?=$row[G_PRODUCT_CNT]?>"/> <?=$LNG_TRANS_CHAR["MW00036"] //이상?> 
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00228"]//등급혜택?></th>
					<td>
						<input type="radio" id="discount_st" name="discount_st" value="1" <?=($row[G_DISCOUNT_ST] == "1")?"checked":"";?> ><?=$LNG_TRANS_CHAR["MW00253"]//추가적립금 없음?>
						<!--input type="radio" id="discount_st" name="discount_st" value="2" <?=($row[G_DISCOUNT_ST] == "2")?"checked":"";?>>추가할인//-->
						<input type="radio" id="discount_st" name="discount_st" value="3" <?=($row[G_DISCOUNT_ST] == "3")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00254"]//추가적립금 지급?>
						<!--input type="radio" id="discount_st" name="discount_st" value="4" <?=($row[G_DISCOUNT_ST] == "4")?"checked":"";?>>추가할인/추가적립 동시적용//-->
						
						<div id="divDiscountPrice" style="<?=($row[G_DISCOUNT_ST] == "2" || $row[G_DISCOUNT_ST] == "4")?"":"display:none";?>">
						<br>
						<?=$S_ST_CUR?> <input type="text" <?=$nBox?>  style="width:100px;" id="discount_price" name="discount_price" value="<?=$row[G_DISCOUNT_PRICE]?>"/>  / <?=$LNG_TRANS_CHAR["MW00031"] //할인율?> <input type="text" <?=$nBox?>  style="width:50px;" id="discount_rate" name="discount_rate" value="<?=$row[G_DISCOUNT_RATE]?>"/>
						<select name="discount_unit" id="discount_unit">
							<option value="1" <?=($row[G_DISCOUNT_UNIT]=="1")?"selected":"";?>>%</option>
							<option value="2" <?=($row[G_DISCOUNT_UNIT]=="2")?"selected":"";?>><?=$S_ST_CUR?></option> 
						</select>
						<select name="discount_point" id="discount_point">
							<option value="0" <?=(!$row[G_DISCOUNT_POINT])?"selected":"";?>>0자리</option>
							<option value="1" <?=($row[G_DISCOUNT_POINT]=="1")?"selected":"";?>>1자리</option>
							<option value="2" <?=($row[G_DISCOUNT_POINT]=="2")?"selected":"";?>>2자리</option> 
						</select>
						<select name="discount_off" id="discount_ff">
							<option value="1" <?=($row[G_DISCOUNT_OFF]=="1")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00038"]//절삭?></option>
							<option value="2" <?=($row[G_DISCOUNT_OFF]=="2")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00039"]//반올림?></option> 
						</select>

						(<?=$LNG_TRANS_CHAR["MS00003"] //입력하신 금액 이상일때 할인 혜택 제공?>)
						</div>
						<div id="divDiscountPoint" style="<?=($row[G_DISCOUNT_ST] == "3" || $row[G_DISCOUNT_ST] == "4")?"":"display:none";?>">
						<br>
						<?=$S_ST_CUR?> <input type="text" <?=$nBox?>  style="width:100px;" id="point_price" name="point_price" value="<?=$row[G_POINT_PRICE]?>"/> / <?=$LNG_TRANS_CHAR["CW00034"] //포인트?> <input type="text" <?=$nBox?>  style="width:50px;" id="point_rate" name="point_rate" value="<?=$row[G_POINT_RATE]?>"/>
						<select name="point_unit" id="point_unit">
							<option value="1" <?=($row[G_POINT_UNIT]=="1")?"selected":"";?>>%</option>
							<option value="2" <?=($row[G_POINT_UNIT]=="2")?"selected":"";?>><?=$S_ST_CUR?></option> 
						</select>
						<select name="point_point" id="point_point">
							<option value="0" <?=(!$row[G_POINT_POINT])?"selected":"";?>>0자리</option>
							<option value="1" <?=($row[G_POINT_POINT]=="1")?"selected":"";?>>1자리</option>
							<option value="2" <?=($row[G_POINT_POINT]=="2")?"selected":"";?>>2자리</option> 
						</select>
						<select name="point_off" id="point_off">
							<option value="1" <?=($row[G_POINT_OFF]=="1")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00038"]//절삭?></option>
							<option value="2" <?=($row[G_POINT_OFF]=="2")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00039"]//반올림?></option> 
						</select>
						(<?=$LNG_TRANS_CHAR["MS00004"] //입력하신 금액 이상일때 추가 적립 제공?>)
						</div>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00229"]//추가혜택?></th>
					<td>
						<input type="radio" id="add_discount" name="add_discount" value="N" <?=($row[G_ADD_DISCOUNT] == "N")?"checked":"";?> onclick="javascript:goGroupAddDistcount();"><?=$LNG_TRANS_CHAR["MW00256"]//>가격할인 없음?>
						<input type="radio" id="add_discount" name="add_discount" value="Y" <?=($row[G_ADD_DISCOUNT] == "Y")?"checked":"";?> onclick="javascript:goGroupAddDistcount();"><?=$LNG_TRANS_CHAR["MW00255"]//가격할인?>
						<div id="divAddDiscountPrice" style="<?=($row[G_ADD_DISCOUNT] == "Y")?"":"display:none";?>">
						<br>
						<?=$S_ST_CUR?> <input type="text" <?=$nBox?>  style="width:100px;" id="add_discount_price" name="add_discount_price" value="<?=$row[G_ADD_DISCOUNT_PRICE]?>"/>  / <?=$LNG_TRANS_CHAR["MW00031"] //할인율?> <input type="text" <?=$nBox?>  style="width:50px;" id="add_discount_rate" name="add_discount_rate" value="<?=$row[G_ADD_DISCOUNT_RATE]?>"/>
						<select name="add_discount_unit" id="add_discount_unit">
							<option value="1" <?=($row[G_ADD_DISCOUNT_UNIT]=="1")?"selected":"";?>>%</option>
							<option value="2" <?=($row[G_ADD_DISCOUNT_UNIT]=="2")?"selected":"";?>><?=$S_ST_CUR?></option> 
						</select>
						<select name="add_discount_point" id="add_discount_point">
							<option value="1" <?=($row[G_ADD_DISCOUNT_POINT]=="1")?"selected":"";?>>1자리</option>
							<option value="2" <?=($row[G_ADD_DISCOUNT_POINT]=="2")?"selected":"";?>>2자리</option> 
						</select>
						<select name="add_discount_off" id="add_discount_off">
							<option value="1" <?=($row[G_ADD_DISCOUNT_OFF]=="1")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00038"]//절사?></option>
							<option value="2" <?=($row[G_ADD_DISCOUNT_OFF]=="2")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00039"]//반올림?></option> 
						</select>
						(<?=$LNG_TRANS_CHAR["MS00003"] //입력하신 금액 이상일때 할인 혜택 제공?>)
						</div>
						<div class="helpTxtGray">
							* <?=$LNG_TRANS_CHAR['MS00083']//상품리스트에 할인된 가격으로 보여집니다.?>
						</div>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00230"]//할인예외카테고리?></th>
					<td>
						<select id="cateHCode1" name="cateHCode1">
							<option value=""><?=$LNG_TRANS_CHAR["PW00013"]?></option>
						</select>
						<select id="cateHCode2" name="cateHCode2" >
							<option value=""><?=$LNG_TRANS_CHAR["PW00014"]?></option>
						</select>
						<select id="cateHCode3" name="cateHCode3" >
							<option value=""><?=$LNG_TRANS_CHAR["PW00015"]?></option>
						</select>
						<!--select id="cateHCode4" name="cateHCode4">
							<option value=""><?=$LNG_TRANS_CHAR["PW00016"]?></option>
						</select-->
						<a class="btn_sml" href="javascript:goGroupExpCateogryInsert();"><strong><?=$LNG_TRANS_CHAR["CW00051"]//적용?></strong></a>
						<br>
						<ul id="ulExpCate">
							<?=$strGroupExpCategoryHtml?>
						</ul>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00231"]//할인예외상품?></th>
					<td>
						<a class="btn_sml" href="javascript:goGroupExpProductSearch();"><strong><?=$LNG_TRANS_CHAR["CW00072"]//상품검색?></strong></a>
						<ul id="ulExpProd">
							<?=$strGroupExpProductHtml?>
						</ul>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00232"]//등급아이콘?></th>
					<td>
						<input type="file" style="width:300px;" id="iconImg1" name="iconImg1"/>
						<?if ($row[G_ICON]){?>
						<img src="../upload/icon/memberGroup/<?=$row[G_ICON]?>" border="0"><a href="javascript:goGroupIconDel(1);">[x]</a>
						<?}?>
					</td>
				</tr>
					
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00233"]//등급이미지?></th>
					<td>
						<input type="file" style="width:300px;" id="iconImg2" name="iconImg2"/>
						<?if ($row[G_IMG]){?>
						<img src="../upload/icon/memberGroup/<?=$row[G_IMG]?>" border="0"><a href="javascript:goGroupIconDel(2);">[x]</a>
						<?}?>
					</td>
				</tr>
					
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00234"]//할인혜택?></th>
					<td>
						<input type="file" style="width:300px;" id="iconImg3" name="iconImg3"/>
						<?if ($row[G_FILE]){?>
						<img src="../upload/icon/memberGroup/<?=$row[G_FILE]?>" border="0"><a href="javascript:goGroupIconDel(3);">[x]</a>
						<?}?>
					</td>
				</tr>
			</table>
		</div>

		<div class="buttonBoxWrap">
			<?if ($strG_CODE){?>
				<a class="btn_new_blue" href="javascript:goGroupAct('groupModify');" id="menu_auth_m" style="display:none"><strong><?=($strG_CODE!="")?$LNG_TRANS_CHAR["CW00003"]:$LNG_TRANS_CHAR["CW00002"];?></strong></a>
			<?}else{?>
				<a class="btn_new_blue" href="javascript:goGroupAct('groupAdd');" id="menu_auth_w" style="display:none"><strong><?=($strG_CODE!="")?$LNG_TRANS_CHAR["CW00003"]:$LNG_TRANS_CHAR["CW00002"];?></strong></a>
			<?}?>
				<a class="btn_new_glay" href="javascript:C_getMoveUrl('group','get','<?=$PHP_SELF?>');"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
		</div>
	</div>
</div>
