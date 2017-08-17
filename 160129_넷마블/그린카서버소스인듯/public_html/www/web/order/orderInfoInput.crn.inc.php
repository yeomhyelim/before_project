<?
	## 통관 보여주기
	$strOrderCrnDisplay = "N";
	if ($S_SITE_LNG == "KR" || ($S_SITE_LNG !="KR" && $strJCountry == "KR")){
		$strOrderCrnDisplay = "Y";
	}
?>
<div class="orderCrnWrap" style="<?=($strOrderCrnDisplay!="Y")?"display:none":"";?>" id="divOrderCrnForm">
	<h4>통관 시 개인정보제공안내</h4>

	<div class="orderCrnForm">	
			주문 상품이 국내 통관 도중 일반수입신고절차를 거치게 될 경우 관세법 제 241조 및『수입통관 사무처리에 관한 고시』에 따라 고객님의 성명, 주소, 주민등록번호를 세관에 제출해야 합니다. <br/>
			이에 고객님의 편의와 빠른 통관처리를 위해 고객님이 입력하신 수취인 주민등록번호가 판매자 및 관세사를 통해 관세청에 제출될 수 있습니다.<br/>
			<span class="red">한국 통관법상, 건강기능식품은 1회 주문시 상품갯수가 6개까지 제한되므로 주문하실 때 반드시 확인 부탁드립니다.</span>
	</div>

	<div class="crnAgree">
		<div class="ipBox">
			<!--<input type="radio" class="ip_number2" value="1" name="j_shipping_no_type" checked/> <span>주민번호</span>//-->
			<input type="radio" class="ip_number2" value="1" name="j_shipping_local" id="j_shipping_local" checked>내국인
			<input type="radio" class="ip_number2" value="2" name="j_shipping_local" id="j_shipping_local">통관고유부호
			<!--<input type="radio" class="ip_number1" value="2" name="j_shipping_no_type"/> <span>여권번호/외국인등록번호</span>//-->
		</div>
		<div class="agree">
			<input type="checkbox"  name="j_shipping_no_agree" id="j_shipping_no_agree" value="Y"/> <span>위 내용을 확인하였으며 이에 동의합니다.</span>
		</div>
		<div class="clr"></div>
		
		<div class="ip1Box" style="display:none" id="divOrderShippingNo2">
			<label>통관고유부호</label>
			<input type="text" name="j_shipping_no2"  id="j_shipping_no2" maxlength="20"/>
		</div>
		<div class="ip2Box"  id="divOrderShippingNo1">
			<label>주민번호</label>
			<input type="text" name="j_shipping_no1_1"  id="j_shipping_no1_1" maxlength="6"/> <span>-</span> <input type="password" name="j_shipping_no1_2"  id="j_shipping_no1_2" maxlength="7"/>
		</div>
	</div>
</div>