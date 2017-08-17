<script type="text/javascript">
//<![CDATA[
// 팝업 닫고 다시 로드
	function goPopClose()
	{
		parent.goLayoutPopCloseEvent();
		//self.close();
	}

//]]>
</script>
<div id="<?php echo $strAppID?>" class="popProdInquiryBox">
	<div class="titWrap">
		<h2>이미지 보기</h2>
		<a href="javascript:goPopClose();" class="btnClose write">X</a>
	</div>
	<div>
		<img src="<?=$strImageSrc?>">
	</div>
</div>