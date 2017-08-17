<?php
	## 스크립트 설정
	$aryScriptEx[] = "./common/js/basic/order.js";
?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00026"] //주문및결제관리?></h2>
			<div class="locationWrap"><span>home</span> / <span><?=$LNG_TRANS_CHAR["BW00087"] //기본설정?></span> / <?=$LNG_TRANS_CHAR["BW00026"] //주문및결제관리?> / <strong>국내배송 설정</strong></div>
			<div class="clr"></div>
	</div>

	<div class="tabImgWrap">
			<a href="javascript:javascript:goMoveUrl('order','');" class="selected"><?=$LNG_TRANS_CHAR["BW00094"] //국내배송 설정?></a>	
		<? if($S_USE_LNG != "KR"): ?>
			<a href="javascript:javascript:goMoveUrl('orderFor','');"  ><?=$LNG_TRANS_CHAR["BW00095"] //해외배송 설정?></a>
		<? endif; ?>
	</div>


	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<h3><?=$LNG_TRANS_CHAR["BW00027"] //주문관리?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00028"] //자동주문취소설정?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="auto_cancel" name="auto_cancel" value="<?=$row['S_AUTO_CANCEL']?>"/> <?=$LNG_TRANS_CHAR["CW00014"] //일?>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["BS00002"] //주문 이후 입력한 일자의 시간이 지나면 주문은 자동 주문취소됩니다.?>
					</div>
				</td>
			</tr>
			<?if ($S_MALL_TYPE == "M"){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00177"]  //자동구매완료설정?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="auto_order_end" name="auto_order_end" value="<?=$row[S_AUTO_ORDER_END]?>"/> <?=$LNG_TRANS_CHAR["CW00014"] //일?>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["BS00084"]  //배송완료일로 부터 입력한 일자의 시간이 지나면 자동 구매완료 처리됩니다.?>
					</div>
				</td>
			</tr>
			<?}?>
		</table>
		<br/>
		<h3><?=$LNG_TRANS_CHAR["BW00029"] //배송정책?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00030"] //기본배송비?></th>
				<td>
					<select name="delivery_st" id="delivery_st">
						<option value="S" <?=($row[S_DELIVERY_ST]=="S")?"selected":"";?>><?=$LNG_TRANS_CHAR["BW00096"] //결제금액?></option>
						<option value="P" <?=($row[S_DELIVERY_ST]=="P")?"selected":"";?>><?=$LNG_TRANS_CHAR["BW00097"] //판매금액?></option>
					</select>이 <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?> 
					<input type="text" <?=$nBox?> id="delivery_free" name="delivery_free" value="<?=$row[S_DELIVERY_FREE]?>" style="width:50px;text-align:right;"/><?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?> <?=$LNG_TRANS_CHAR["BS00047"] //일때 배송비 무료배송,이하인경우?>  <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?> 
					<input type="text" <?=$nBox?> id="delivery_fee" name="delivery_fee" value="<?=$row[S_DELIVERY_FEE]?>"style="width:50px;text-align:right;"/><?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?>
					<?=$LNG_TRANS_CHAR["BW00098"] //배송비 적용?>
					<select name="delivery_pay_type">
						<option value=""<?if($row['S_DELIVERY_PAY_TYPE']==""){echo " selected";}?>>배송비 사용자 선택</option>
						<option value="orderPay"<?if($row['S_DELIVERY_PAY_TYPE']=="orderPay"){echo " selected";}?>>주문시 결제 고정</option>
						<option value="selfPay"<?if($row['S_DELIVERY_PAY_TYPE']=="selfPay"){echo " selected";}?>>상품수령 후 지불 고정</option>
					</select>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["BS00003"] //총 주문금액이 배송비 기준 금액으로 무료 금액이상일때는 배송비 무료, 미만일때는 배송비를 부과합니다.?>
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00031"] //국내 배송 택배사 선택?></th>
				<td>
					<ul class="deliveryCompany">
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="001" <?=($aryDeliveryCom["001"])?"checked":"";?>> 우체국</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="006" <?=($aryDeliveryCom["006"])?"checked":"";?>> 이노지스택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="011" <?=($aryDeliveryCom["011"])?"checked":"";?>> KGB택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="002" <?=($aryDeliveryCom["002"])?"checked":"";?>> 경동택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="007" <?=($aryDeliveryCom["007"])?"checked":"";?>> 한진택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="012" <?=($aryDeliveryCom["012"])?"checked":"";?>> 현대택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="003" <?=($aryDeliveryCom["003"])?"checked":"";?>> CJ대한통운</li>
						<!-- <li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="008" <?=($aryDeliveryCom["008"])?"checked":"";?>> CJ GLS</li> //-->
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="004" <?=($aryDeliveryCom["004"])?"checked":"";?>> 동부택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="009" <?=($aryDeliveryCom["009"])?"checked":"";?>> 삼성 HTH</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="005" <?=($aryDeliveryCom["005"])?"checked":"";?>> 로젠택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="010" <?=($aryDeliveryCom["010"])?"checked":"";?>> 옐로우캡</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="051" <?=($aryDeliveryCom["051"])?"checked":"";?>> 천일택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="052" <?=($aryDeliveryCom["052"])?"checked":"";?>> 대신택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="053" <?=($aryDeliveryCom["053"])?"checked":"";?>> 합동택배</li>
					</ul>
				</td>
			</tr>

		</table>
		<br/>
		<h3><?=$LNG_TRANS_CHAR["BW00033"] //은행계좌설정?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00034"] //계좌번호?></th>
				<td>
					<textarea name="bank" id="bank" name="bank" style="width:50%;height:50px"><?=$row[S_BANK]?></textarea>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["BS00048"] //무통장입금을 사용하는 경우 계좌정보를 입력해 주세요.?><br>
						* <?=$LNG_TRANS_CHAR["BS00049"] //여러개의 통장정보가 있는경우 콤마(,)로 구분하여 입력해 주세요.?>
					</div>
				</td>
			</tr>
		</table>
		<br/>
		<h3><?=$LNG_TRANS_CHAR["BW00035"] //결제방법설정?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00036"] //국내 결제방법?></th>
				<td>
					<input type="checkbox" id="settle[]" name="settle[]" value="B" <?=in_array("B", $arySettle)?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00060"] //무통장입금?>
					<input type="checkbox" id="settle[]" name="settle[]" value="C" <?=in_array("C", $arySettle)?"checked":"";?> style="margin-left:10px;"/><?=$LNG_TRANS_CHAR["CW00061"] //신용카드?>
					<input type="checkbox" id="settle[]" name="settle[]" value="A" <?=in_array("A", $arySettle)?"checked":"";?> style="margin-left:10px;"/><?=$LNG_TRANS_CHAR["CW00062"] //계좌이체?>
					<input type="checkbox" id="settle[]" name="settle[]" value="T" <?=in_array("T", $arySettle)?"checked":"";?> style="margin-left:10px;"/><?=$LNG_TRANS_CHAR["CW00063"] //가상계좌?>
					<!--
					<input type="checkbox" id="settle[]" name="settle[]" value="M" <?=in_array("M", $arySettle)?"checked":"";?> style="margin-left:10px;"/><?=$LNG_TRANS_CHAR["CW00082"] //휴대폰?>
					(	
						<input type="radio" id="settle_mobile_type" name="settle_mobile_type" value="1" <?=($row['S_SETTLE_MOBILE_TYPE']=="1")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00083"] //실물?>
						<input type="radio" id="settle_mobile_type" name="settle_mobile_type" value="2" <?=($row['S_SETTLE_MOBILE_TYPE']=="2" || !$row['S_SETTLE_MOBILE_TYPE'])?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00084"] //컨텐츠?>
					)
					-->
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00037"] //국내 PG사?></th>
				<td>
					<input type="radio" id="" name="pg"  value="K" <?=($row[S_PG]=="K")?"checked":"";?>/>KCP
					<!--<input type="radio" id="" name="pg"  value="I" <?=($row[S_PG]=="I")?"checked":"";?> style="margin-left:10px;"/>INIPay-->
					<?php if(1==0): // 2014.08.19 kim hee sung. 이사님 요청사항으로 숨김.?>
					<input type="radio" id="" name="pg"  value="L" <?=($row[S_PG]=="L")?"checked":"";?> style="margin-left:10px;"/>LG 유플러스
					<input type="radio" id="" name="pg"  value="A" <?=($row[S_PG]=="A")?"checked":"";?> style="margin-left:10px;"/>올더게이트
					<input type="radio" id="" name="pg"  value="N" <?=($row[S_PG]=="N")?"checked":"";?> style="margin-left:10px;"/>KSNET
					<?php endif;?>
					<input type="radio" id="" name="pg"  value="X" <?=($row[S_PG]=="X")?"checked":"";?> style="margin-left:10px;"/>엑심베이
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00038"] //국내 PG연동코드?></th>
				<td> 
					SITE CODE: <input type="text"  style="width:80px;margin-right:10px;" name="s_pg_site_code" value="<?=$row[S_PG_SITE_CODE]?>" /> SITE KEY: <input type="text"  style="width:200px;" name="s_pg_site_key" value="<?=$row[S_PG_SITE_KEY]?>" />
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["BS00004"] //전자결제 회사와 계약이 완료되면 사이트코드와 사이트키를 받게 됩니다.<br/>?>
						  <span></span><?=$LNG_TRANS_CHAR["BS00005"] //해당 키를 입력해 주세요.?>
					</div>
				</td>
			</tr>
		</table>
		<br/>
		<!--
		<h3>상품가격노출</h3>
		<table>
			<tr>
				<th>회원 노출</th>
				<td>
					<input type="checkbox" name="priceShowMember" value="Y"<?php if($row['S_PRICE_SHOW_MEMBER']=="Y"){echo " checked";}?>> 로그인한 회원에게 가격을 노출합니다.(비회원 가격 비노출)
					<input type="checkbox" name="priceShowView" value="Y"<?php if($row['S_PRICE_SHOW_VIEW']=="Y"){echo " checked";}?>> 상품 뷰페이지 출력
				</td>
			</tr>
			<?php if($S_MEMBER_GROUP):?>
			<tr>
				<th>등급별 노출</th>
				<td>
					<?php $aryPriceShowGroup = explode(',', $row['S_PRICE_SHOW_GROUP']);?>
					<?php foreach($S_MEMBER_GROUP as $key => $groupRow):?>
					<input type="checkbox" name="priceShowGroup[]" value="<?php echo $key;?>"<?php if(in_array($key, $aryPriceShowGroup)){echo " checked";}?><?php if($row['S_PRICE_SHOW_MEMBER']!="Y"){echo " disabled";}?>> <?php echo $groupRow['NAME'];?>
					<?php endforeach;?>
				</td>
			</tr>
			<?php endif;?>
		</table>
		-->
	</div>

	<div class="buttonWrap">
		<a class="btn_Big_Blue" href="javascript:goOrderModify();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
</div>