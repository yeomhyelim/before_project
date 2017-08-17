<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
	});

	/*-- 이벤트 --*/
	function postSmsListMoveClickEvent()			{	goFirstPageMove('postSmsList');		}			// 뒤로
	function postSmsListExcelUploadClickEvent(no)	{	goExceUpload(no);					}			// 엑셀업로드
	function postSmsLogSendMoveClickEvent(no)		{	goSmsLogSend(no);					}			// SMS문자발송
	/*-- 이벤트 정의 --*/
	function onPageLoad() {

	}
	
	function goSmsExcelDown(){
		location.href = "./?menuType=popup&mode=download&gb=sms_kor_insert";
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
		$("#ps_no").val(no);
		document.form.encoding = "multipart/form-data";
		C_getAction("postSmsExcelUpload","<?=$PHP_SELF?>");
	}

	function goSmsLogSend(no)
	{
		$("#ps_no").val(no);
		C_getAction("postSmsLogSend","<?=$PHP_SELF?>");
	}

//-->
</script>