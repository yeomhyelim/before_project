<script type="text/javascript">
<!--

	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();	
	
		$('input[name=searchOutStartDt]').simpleDatepicker();
		$('input[name=searchOutEndDt]').simpleDatepicker();		
		
		
	});

	
//	/* 회원목록 검색*/
//	function goSearch(){
//		C_getMoveUrl("<?=$strMode?>","get","<?=$PHP_SELF?>");
//	}

	/* 주문정보 엑셀 다운로드 */
	function goExcel(mode)
	{
		var data				= new Object();	
		data['menuType']		= "member";
		data['mode']			= "excel";
		data['act']				= mode;
		C_getAddLocationUrl(data);
	}


	/* 회원승인 */
	function goMemberAuth(no)
	{
		var doc = document.form;
		doc.memberNo.value = no;

		C_getAction("memberAuth","<?=$PHP_SELF?>");
	}

	/* 회원정보수정 */
	function goMemberModify(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=member&mode=popMemberModify&memberNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	/* CRM */
	function goMemberCrmView(no, tab)
	{
		var href = "./?menuType=member&mode=popMemberCrmView&tab="+tab+"&memberNo="+no;
		window.open(href, "CRM", "width=1100px,height=800px,scrollbars=yes");
	}

	function goMemberAct(mode)
	{
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goMemberDelete(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>");
		if (x == true)
		{
			var doc = document.form;
			doc.mode.value = "act";
			doc.act.value = "memberDelete";
			doc.memberNo.value = no;
			
			var formData = $("#form").serialize();
			C_AjaxPost("memberDelete","./index.php",formData,"post");	
		}
	}

	/* 선택된 회원 삭제 */
	function goMemberAllDelete(no)
	{		
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //삭제하실 데이터를 선택해주세요.
		if (x == true)
		{
			var doc = document.form;
			doc.mode.value = "act";
			doc.act.value = "memberAllDelete";
			
			var formData = $("#form").serialize();
			C_AjaxPost("memberAllDelete","./index.php",formData,"post");	
		}
	}
	
	/* 회원복원 */
	function goMemberRecovery(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00008']?>");
		if (x == true)
		{
			var doc = document.form;
			doc.mode.value = "act";
			doc.act.value = "memberRecovery";
			
			doc.memberNo.value = no;

			var formData = $("#form").serialize();
			C_AjaxPost("memberRecovery","./index.php",formData,"post");	
		}
	}

	
	/* 회원그룹변경*/
	function goMemberGroupChange()
	{
		var doc			= document.form;		
		var strChkVal	= C_getCheckedCode(doc["chkNo[]"]);
		var strVal		= $("#changeGroup option:selected").val();

		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}
		
		C_getAjax("memberGroupChange","act");
	}

	function goAjaxRet(name,result){

		if (name == "memberAllDelete" || name == "memberDelete" || name == "memberRecovery" || name == "memberGroupChange" || name=="groupIconDel" || name=="groupImgDel" || name=="groupFileDel")
		{			
			var doc = document.form;
			var data = eval(result);
			
			if (data[0].RET == "Y")
			{
				alert(data[0].MSG);
				
				if (name == "memberAllDelete" || name == "memberAllDelete" || name == "memberRecovery" || name == "memberGroupChange")
				{
					location.reload();
				} else {
					location.href = "./?menuType=member&mode=group&groupCode="+$("#groupCode").val();
				}
				return;
			}

		} else if (name == "groupView" || name == "groupWrite"){
			
			
			$("#divGroupForm").css("display","block");
			$("#divGroupForm").html(result);

			goGroupExpCateogry();

		} 
	}
	
	/* 이메일 보내기 */
	function goMailWrite(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=sendmail&mode=postMailSend&target=pop&memberNo='+no });
	}

	/* 문자 보내기 */
	function goSmsWrite(no)
	{
		$.smartPop.open({  bodyClose: false, width: 200, height: 320, url: './?menuType=sendsms&mode=postSmsSend&target=pop&memberNo='+no });
	}

	/* 쪽지 보내기 */
	function goPaperWrite(sendType)
	{
		if (sendType == "A")
		{
			var strChkVal	= C_getCheckedCode(document.form["chkNo[]"]);
			if (C_isNull(strChkVal))
			{
				alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
				return;
			}
		}
		
		$("input[name=sendType]").val(sendType);
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=sendpaper&mode=postPaperSend&target=pop' });
	}

	/* 회원 포인트 정보 상세보기 */
	function goMemberPointView(no){

		C_openWindow("./?menuType=popup&mode=memberPointList&no="+no,"<?=$LNG_TRANS_CHAR['CW00034']?>","800","600"); //포인트
	}
	
	/* 회원 주소 상세보기 */
	function goMemberAddrView(no)
	{
		$.smartPop.open({  bodyClose: false, width: 500, height: 300, url: './?menuType=member&mode=popMemberAddr&memberNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}
	
	/* 회원 포인트 [+-] */
	function goMemberPointWrite(no)
	{
		$.smartPop.open({  bodyClose: false, width: 500, height: 380, url: './?menuType=member&mode=popMemberPointWrite&memberNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	/* 회원 포인트 내역 */
	function goMemberPointList(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 600, url: './?menuType=member&mode=popMemberPointList&memberNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	/* 회원 쿠폰 내역 */
	function goMemberCouponList(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=member&mode=popMemberCouponList&memberNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	/* 회원 주문 내역 */
	function goMemberOrderList(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=member&mode=popMemberOrderList&memberNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goMemberOrderView(no){
		C_openWindow("./?menuType=popup&mode=orderView&no="+no,"<?=$LNG_TRANS_CHAR['OW00012']?>","600","600"); //주문정보 상세보기
	}


	/* 레이어창 닫기 */
	function goPopClose()
	{		
		location.reload();
		$.smartPop.close();
	}

	/* 리스트 정렬 */
	function goOrderSort(col,sort)
	{

		var data = new Array();

		data['searchOrderSortCol']		= col;
		data['searchOrderSort']			= sort;

		goAddLocation(data);
		
// 2013.12.10 kim hee sung 파람미터 추가시 input 박스 꼐속해서 추가해줘야 하는 단점 보안
//		$("#searchOrderSortCol").val(col);
//		$("#searchOrderSort").val(sort);
//
//		C_getMoveUrl("memberList","get","<?=$PHP_SELF?>");
	}

	/* 선택한 회원 포인트 [+-] */
	function goMemberAllPointWrite()
	{
		
		var intCnt = 0;
		$("input[id^=chkNo]").each(function() {
			
			if ($(this).is(":checked")){
				intCnt++;
			}
		});

		if (intCnt <= 0)
		{
			alert("회원을 선택해주세요.");
			return;
		}

		$.smartPop.open({  bodyClose: false, width: 500, height: 380, url: './?menuType=member&mode=popMemberPointWrite&gb=2', closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}
//-->
</script>