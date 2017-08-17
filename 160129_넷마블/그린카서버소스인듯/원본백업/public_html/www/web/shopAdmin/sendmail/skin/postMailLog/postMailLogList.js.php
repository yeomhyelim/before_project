<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
	});

	/*-- 이벤트 --*/
	function postMailListMoveClickEvent()			{ goFirstPageMove('postMailList'); }			// 뒤로
	function postMailListExcelUploadClickEvent(no)	{	goExceUpload(no);					}			// 엑셀업로드
	function postMailLogSendMoveClickEvent(no)		{	goMailLogSend(no);					}			// SMS문자발송

	/*-- 이벤트 정의 --*/
	function onPageLoad() {

	}


	function goMailExcelDown(){
		location.href = "./?menuType=popup&mode=download&gb=mail_kor_insert";
	}
	/*-- 기능 함수 --*/
	function goFirstPageMove(mode) {
		document.form.page.value = "";
		goMove(mode);
	}

	function goSelectMove(mode, no) {
		// 이동
		document.form.pm_no.value = no;
		goMove(mode);
	}

	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goSelectAct(mode, no) {
		// 액션
		document.form.pm_no.value = no;
		goAct(mode);
	}

	function goAct(mode) {
		// 액션
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goExceUpload(no){
		$("#pm_no").val(no);
		document.form.encoding = "multipart/form-data";
		C_getAction("postMailExcelUpload","<?=$PHP_SELF?>");
	}

	function goMailLogSend(no)
	{
		$("#pm_no").val(no);		
		if(!C_chkInput("send_name",true,"보내는사람",true)) return; //쿠폰명
		if(!C_chkInput("send_email",true,"보내는메일",true)) return; //쿠폰명
		
		$("#spanLoading").html("<img src=\"/himg/etc/icon_loading_2.gif\">");
		C_getAction("postMailLogSend","<?=$PHP_SELF?>");
	}
//-->
</script>