<script type="text/javascript">
<!--
	var G_PHP_SELF		= "<?=$PHP_SELF?>";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});
		
	/* 이벤트 등록 */
	function goAtOneTimeWrite()				{ goFileAct("prodAtOneTimeWrite"); }	// 등록하기
	function goAtOneTimeSampleDowndown()	{ goMove("excel"); }

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

//-->
</script>