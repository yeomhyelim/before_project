<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";
	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name=searchLaunchStartDt]').simpleDatepicker();
		$('input[name=searchLaunchEndDt]').simpleDatepicker();
		$('input[name=searchRepStartDt]').simpleDatepicker();
		$('input[name=searchRepEndDt]').simpleDatepicker();


	});

	/* 리스트 정렬 */
	function goOrderEvent(order) {
		var data							= new Array(20);
		data								= goSearchDataSet(data);
		data['page']						= "<?=$intPage?>";

		C_getAddLocationUrl(data);
	}



	/* 상품상세보기 열기 */
	function goOpenWindow(prodCode) 
	{
		var strParam = "../<?=strtolower($S_ST_LNG)?>/?menuType=product&mode=view&prodCode=" + prodCode;
		window.open(strParam);
	}

	/* 상품정보 수정 호출*/
	function goProdModify(no,lang)
	{
		var data						= new Array(5);
		data							= goSearchDataSet(data);
		data['page']					= "<?=$intPage?>";
		
		data['prodCode']				= no;
		data['prodLang']				= lang;
		data['mode']					= "prodModify";
	
		C_getAddLocationUrl(data);
	}

	/* 상품정보 삭제*/
	function goProdDelete(no)
	{
		var doc = document.form;
		doc.prodCode.value = no;

		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			C_getAction("prodDelete",'<?=$PHP_SELF?>');
		}
	}
		
	/* 상품복사 */
	function goProdCopy(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=product&mode=popProdCopy&prodCode='+no, closeImg: {width:23, height:23} });
	}

	/* 상품일괄변경 */
	function goProdAllUpdate()
	{
		var strChkVal = C_getCheckedCode(document.form["chkNo[]"]);
		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}

		C_getMultiCheck("prodAllUpdate","<?=$PHP_SELF?>","<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
	}

	/* 상품 카테고리 일괄변경 */
	function goProdCateUpdate()
	{
		var strChkVal = C_getCheckedCode(document.form["chkNo[]"]);
		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}

		$.smartPop.open({  bodyClose: false, width: 600, height: 300, url: './?menuType=product&mode=popProdCateUpdate', closeImg: {width:23, height:23} });
	}
	
	/** 2013.04.22 이벤트 함수 **/
	function goProdShareMultiMoveEvent() { goProdShareMultiMove();	}

	/** 2013.04.22 상품공유 일괄변경 */
	function goProdShareMultiMove() {

		var prodCodeMulti = "";
		$("input[id=chkNo]").each(function() {
			if($(this).attr("checked")=="checked") {
				if(prodCodeMulti) { prodCodeMulti = prodCodeMulti + ",";					}
									prodCodeMulti = prodCodeMulti + $(this).val();
			}
		});

		if(!prodCodeMulti) {
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}

		$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popProdShare&prodCodeMulti='+prodCodeMulti, closeImg: {width:23, height:23} });
	}

	/** public 함수 **/

	/**
	 * goCheckBox()
	 * 리스트 체크 박스 선택 개수 리턴
	 **/
	function goCheckBox() {
		var intCnt = 0;
		$("input[id=chkNo]").each(function() {
			if($(this).attr("checked")=="checked") {
				intCnt++;
			}
		});
		return intCnt;
	}

	function goProdListExcelMoveEvent() {
		var data		= new Array();
		data			= goSearchDataSet(data);

		data['mode']	= "excel";
		data['act']		= "excelProdList";
		C_getAddLocationUrl(data);
	}

	/* 상품 공유 설정 */
	function goProdShare(no)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popProdShare&prodCode='+no, closeImg: {width:23, height:23} });
	}
	
	/* 상품 리스트 상품공유 목록 html insert */
	function goProdShareHtml(no,html)
	{
		$("#divProdShareHtml_"+no).html(html);
	}

//-->
</script>
	