<script type="text/javascript">
<!--
	function goLayoutSkinSaveActClickEvent() {

		var doc = document.form;
		doc.mode.value		= "act";
		doc.act.value		= "skinQuickMenuListHtml";
		var formData		= $("#form").serialize();
		C_AjaxPost("skinMainInfoSave", "./index.php", formData, "post");	
	}
//-->
</script>
<img src="./himg/layout/sample/PL0001.jpg"/>
<a class="btn_blue_big" href="#" id="btnSkinQuickMenuSet"><strong>진열관리</strong></a>

<a href="javascript:goLayoutSkinSaveActClickEvent()" class="btn_Big_Blue"><strong>쇼핑몰에 적용</strong></a>
