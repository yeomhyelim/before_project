<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");	
	});

	function goMemberCateWriteMoveEvent()			{ goMemberCateWriteMove();				}
	function goMemberCateModifyMoveEvent(c_code)	{ goMemberCateModifyMove(c_code);		}
	function goPopCloseEvent()						{ goPopClose(); }

	function goMemberCateModifyMove(c_code) {
		var href			= "./?menuType=member&mode=popMemberCateModify&c_code=" + c_code;
		var closeImgSrc		= "/shopAdmin/himg/common/btn_pop_close.png";

		$.smartPop.open({
						 bodyClose	: false
						,width		: 600
						,height		: 350
						,url		: href
//						,closeImg	: {width:23, height:23, src:closeImgSrc} 
		});
	}

	function goMemberCateWriteMove() {
		var href			= "./?menuType=member&mode=popMemberCateWrite";
		var closeImgSrc		= "/shopAdmin/himg/common/btn_pop_close.png";

		$.smartPop.open({
						 bodyClose	: false
						,width		: 600
						,height		: 350
						,url		: href
//						,closeImg	: {width:23, height:23, src:closeImgSrc} 
		});
	}

	function goPopClose() {
		$.smartPop.close();
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

	/* 소속 구매 내역 */
	function goMemberCateOrderList(code)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 600, url: './?menuType=member&mode=popMemberCateOrderList&cateCode='+code, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	/* 엑셀 다운로드 */
	function goExcel(mode)
	{
		var doc = document.form;
		doc.mode.value = "excel";
		doc.act.value = mode;
		doc.method = "get";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}
//-->
</script>