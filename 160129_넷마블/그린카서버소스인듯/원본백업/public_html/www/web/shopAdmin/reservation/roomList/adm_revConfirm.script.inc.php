<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		//C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});

	function goAct() //객실기본정보등록
	{alert("ok");
		C_getAction("admRsvWrite","<?=$PHP_SELF?>");
	}

	function goShowDetailInfo($i) //객실상세정보 보기
	{
		alerta("ok");
	}

	function goAct2() //객실기본정보수정
	{
		var basic = "";
		$('[name^=checkBaseSetting]').each(function(){
			if(!!$(this).attr("checked")){
				basic = basic + $(this).val() + ",";
			}
		});

		$('[name = BasicSet]').val(basic);

		document.form.encoding = "multipart/form-data";
		C_getAction("roomDataModify","<?=$PHP_SELF?>");
	}

	function goCalcArea1(mythis) {

		var intArea1 = $(mythis).val();

		intArea1 = Number(intArea1)/3.3;

		$(mythis).parent().find('[name=area2]').val(intArea1);
	}

	function goCalcArea2(mythis) {

		var intArea1 = $(mythis).val();

		intArea1 = Number(intArea1)*3.3;

		$(mythis).parent().find('[name=area1]').val(intArea1);
//		// 기본설정
//		var objTarget = $('table[idx=' + intIdx + ']');
//		var intCostOrig = objTarget.find('[name^=costOrig]').val();
//		var intCostEtc = objTarget.find('[name^=costEtc]').val();
//		var intCostNego = 0; // 차감총액
//		var intCostPaid = 0; // 매입가
//
//		// 체크
//		if(!intCostOrig) { intCostOrig = 0; }
//		if(!intCostEtc) { intCostEtc = 0; }
//
//		// 정수형으로 변환
//		intCostOrig = Number(intCostOrig);
//		intCostEtc = Number(intCostEtc);
//
//		// 차감금액
//		objTarget.find('[name^=rdnCost]').each(function() {
//
//			// 기본설정
//			var intRdnCost = $(this).val();
//
//			// 정수형으로 변환
//			intRdnCost = Number(intRdnCost);
//
//			// 체크
//			if(!intRdnCost) { intRdnCost = 0; }
//
//			intCostNego = intCostNego + intRdnCost;
//
//		});
//
//
//		// 계산
//		// 매입가 = 원가격 - 차감총액 + 추가매입
//		intCostPaid = (intCostOrig - intCostNego) + intCostEtc;
//
//		// 적용
//		objTarget.find('[name^=costNego]').val(intCostNego); // 차감총액
//		objTarget.find('[name^=costPaid]').val(intCostPaid); // 매입가

	}

	function goRoomBasicDelete(no){
		var x = confirm("선택한 데이터를 삭제하시겠습니까?");
		if (x==true)
		{
			var data = new Object;
			data['menuType']	= "reservation";
			data['mode']		= "act";
			data['act']			= "roomBasicDelete";
			data['no']			= no;
			C_getSelfAction(data);
		}
	}
//-->
</script>
