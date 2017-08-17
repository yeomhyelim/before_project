<script type="text/javascript">
<!--
	var G_PHP_SELF		= "<?=$PHP_SELF?>";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
		
		$("#ha_ag_name_select").change(function() { haAgNameSelectWrite(this); });
		$("#orderInfoCopy").click(function() { orderInfoCopy(this); });		
	});
		
	/* 이벤트 등록 */
	function goAddressWriteMove()				{ goMove("addressWrite"); }					// 주소록 등록(페이지 이동)
	function goAddressWriteAct()				{ goAct("addressWrite"); }					// 주소록 등록(액션)
	function goAddressModifyMove(no)			{ goSelectMove("addressModify", no); }		// 주소록 수정(페이지 이동)
	function goAddressModifyAct()				{ goAct("addressModify"); }					// 주소록 수정(액션)
	function goAddressListMove()				{ goMove("addressList"); }					// 주소록 목록
	function goAddressDeleteAct(no)				{ goDeleteAct("addressDelete", no); }		// 주소록 삭제
	function goAddressGroupList()				{ goOpenWindow("addressGrpList"); }			// 주소록 그룹 리스트

	function goProdOrderListPopMove()			{ goPopMove("popProdOrderList"); }			// 상품선택/추가
	function goMemberListPopMove()				{ goPopMove("popMemberList"); }				// 화원검색
	function goProdOrderWriteAct()				{ goAct("prodOrderWrite"); }				// 수기상품 등록
	function goZipCodeListPopMove(num)			{ goPopMoveEx(num, "popZipCodeList"); }		// 우편번호
	function goAddressListPopMove(num)			{ goPopMoveEx(num, "popAddressList"); }		// 주소록
	function goProdOrderDeleteScript(data)		{ prodOrderDelete(data); }					// 삭제 
	function goProdOrderOptionListPopMove(data)	{ prodOrderOptionListPopMove(data, "popProdOptionList"); }	// 옵션변경
	



	function orderInfoCopy(data) {
		if($(data).is(":checked")){
			var name	=  $("#om_o_name").val();		// 이름
			var phone1	=  $("#om_o_phone_1").val();	// 연락처
			var phone2	=  $("#om_o_phone_2").val();	// 연락처
			var phone3	=  $("#om_o_phone_3").val();	// 연락처
			var hp1		=  $("#om_o_hp_1").val();		// 핸드폰
			var hp2		=  $("#om_o_hp_2").val();		// 핸드폰
			var hp3		=  $("#om_o_hp_3").val();		// 핸드폰
			var zip1	=  $("#om_o_zip_1").val();		// 우편번호
			var zip2	=  $("#om_o_zip_2").val();		// 우편번호
			var addr1	=  $("#om_o_addr1").val();		// 기본주소
			var addr2	=  $("#om_o_addr2").val();		// 상세주소
		} else {
			var name	= ""		// 이름
			var phone1	= ""		// 연락처
			var phone2	= ""		// 연락처
			var phone3	= ""		// 연락처
			var hp1		= ""		// 핸드폰
			var hp2		= ""		// 핸드폰
			var hp3		= ""		// 핸드폰
			var zip1	= ""		// 우편번호
			var zip2	= ""		// 우편번호
			var addr1	= ""		// 기본주소
			var addr2	= ""		// 상세주소
		}
		
		$("#om_r_name").val(name);
		$("#om_r_phone_1").val(phone1);
		$("#om_r_phone_2").val(phone2);
		$("#om_r_phone_3").val(phone3);
		$("#om_r_hp_1").val(hp1);
		$("#om_r_hp_2").val(hp2);
		$("#om_r_hp_3").val(hp3);
		$("#om_r_zip_1").val(zip1);
		$("#om_r_zip_2").val(zip2);
		$("#om_r_addr1").val(addr1);
		$("#om_r_addr2").val(addr2);

	}

	function haAgNameSelectWrite(data) {
		$("#ha_ag_name").val($(data).val());
	}

	function prodOrderSelect(pCode, pImg, pName, pPoint,pQty ,pSalePrice) {
		var intTRCnt	= $("#prodOrderList tr").length;

		$("#prodOrderList").append($("#template").val());
		$("#prodOrderList tr:last").find("td").eq(1).html(intTRCnt);			// 번호
		$("#prodOrderList tr:last").find("td").eq(2).html(pImg);				// 사진
		$("#prodOrderList tr:last").find("#op_p_name").val(pName);				// 상품명
		$("#prodOrderList tr:last").find("#op_p_point").val(pPoint);			// 적립금
		$("#prodOrderList tr:last").find("#op_p_sale_price").val(pSalePrice);	// 판매가
		$("#prodOrderList tr:last").find("#op_p_qty").val(pQty);				// 수량
		$("#prodOrderList tr:last").find("#prodOrderPCode").val(pCode);			// 상품코드
	}

	function popZipCodeCallBack(num, zip1,zip2,addr1,addr2, sido) {
		if(num == 1){
			$("#om_o_zip_1").val(zip1);
			$("#om_o_zip_2").val(zip2);
			$("#om_o_addr1").val(addr1);
			$("#om_o_addr2").val(addr2);
			$("#om_o_addr2").focus();
		} else {
			$("#om_r_zip_1").val(zip1);
			$("#om_r_zip_2").val(zip2);
			$("#om_r_addr1").val(addr1);
			$("#om_r_addr2").val(addr2);
			$("#om_r_addr2").focus();
		}
	}

	function popMemberListCallBack(memberNo) {
		var formData = "menuType=order&mode=json&jsonMode=memberSelect&memberNo="+memberNo;
		C_AjaxPost("memberSelect","./index.php",formData,"post");	
	}

	function goAjaxRet(name,result){
		var data = eval(result);
		if(name == "memberSelect"){
			var name = "";
			if(data[0]['M_F_NAME']) { name = name + data[0]['M_F_NAME'];		}
			if(data[0]['M_L_NAME']) { name = name + data[0]['M_L_NAME'];		}
			$("#om_o_name").val(name);

			var email = data[0]['M_MAIL'].split("@");
			$("#om_o_email_1").val(email[0]);
			$("#om_o_email_2").val(email[1]);

			var phone = data[0]['M_PHONE'].split("-");
			$("#om_o_phone_1").val(phone[0]);
			$("#om_o_phone_2").val(phone[1]);
			$("#om_o_phone_3").val(phone[2]);

			var hp = data[0]['M_HP'].split("-");
			$("#om_o_hp_1").val(hp[0]);
			$("#om_o_hp_2").val(hp[1]);
			$("#om_o_hp_3").val(hp[2]);

			var zip = data[0]['M_ZIP'].split("-");
			$("#om_o_zip_1").val(zip[0]);
			$("#om_o_zip_2").val(zip[1]);

			$("#om_o_addr1").val(data[0]['M_ADDR']);
			$("#om_o_addr2").val(data[0]['M_ADDR2']);
		}
	}

	function prodOrderSCancel(pCode) {
		var intTRCnt = 1;
		$("#prodOrderList").find("#prodOrderPCode").each( function() {
			if($(this).val() == pCode) {
				$(this).parent().parent().remove();
			}else{
				$(this).parent().parent().find("td").eq(1).html(intTRCnt);
				intTRCnt++;
			}
		});
	}

	function prodOrderDelete(data) {
		$(data).parent().parent().remove();
	}

	function prodOrderOptionListPopMove(data, mode) {
		var prodCode = $(data).parent().find("#prodOrderPCode").val();
		var strUrl = "./?menuType=order&prodCode="+prodCode+"&mode="+mode;
		$.smartPop.open({ width: 600, height: 500, url: strUrl });
	}

	/* 공동 */

	function goPopMoveEx(num, mode) {
		var strUrl = "./?menuType=order&num="+num+"&mode="+mode;
		$.smartPop.open({ width: 600, height: 500, url: strUrl });
	}

	function goPopMove(mode) {
		var strUrl = "./?menuType=order&mode="+mode;
		$.smartPop.open({ width: 600, height: 500, url: strUrl });
	}

	function goOpenWindow(mode) {
		alert("작업중입니다. 잠시만 기다려주세요..");
	}

	function goDeleteAct(mode, no) {
		var x = confirm("선택된 주소를 삭제하시겠습니까?");
		if (x == true)
		{
			document.form.ha_no.value = no;	
			goAct(mode);
		}
	}

	function goSelectMove(mode, no) {
		// 이동
		document.form.ha_no.value = no;	
		goMove(mode);
	}

	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get", G_PHP_SELF);
	}

	function goFileAct(mode) {
		// 액션(파일 모드)
		document.form.encoding = "multipart/form-data";
		goAct(mode);
	}

	function goAct(mode) {
		// 액션
		C_getAction(mode, G_PHP_SELF);
	}

	function goClose() {
		$.smartPop.close();
	}

//-->
</script>