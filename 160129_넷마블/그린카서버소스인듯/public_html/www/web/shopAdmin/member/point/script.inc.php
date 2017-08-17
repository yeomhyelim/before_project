<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");	
	});

	/* 포인트 엑셀(CSV)일괄지급 */
	function goMemberPointWritActClickEvent() 
	{
		document.form.encoding = "multipart/form-data";
		C_getAction("memberPointWrite","<?=$PHP_SELF?>");
	}

	function goSearch(){
		C_getMoveUrl("<?=$strMode?>","get","<?=$PHP_SELF?>");
	}

	function goPointSampleDownload(){
		location.href = "./?menuType=popup&mode=download&gb=member_point_sample";
	}

	/* CRM */
	function goMemberCrmView(no)
	{
		var href = "./?menuType=member&mode=popMemberCrmView&tab=memberPointList&memberNo="+no;
		window.open(href, "CRM", "width=1100px,height=800px,scrollbars=yes");
	}

	function goMemberOrderView(no){
		C_openWindow("./?menuType=popup&mode=orderView&no="+no,"<?=$LNG_TRANS_CHAR['OW00012']?>","600","600"); //주문정보 상세보기
	}

	/* 주문정보 엑셀 다운로드 */
	function goExcel(mode)
	{
		var data				= new Object();	
		data['menuType']		= "member";
		data['mode']			= "excel";
		data['act']				= mode;
		C_getAddLocationUrl(data);
	}
//-->
</script>