<?
	//require_once MALL_CONF_LIB."DesignSetMgr.php";
	//$designSetMgr = new DesignSetMgr();	
	require_once MALL_CONF_LIB."ShopMgr.php";
	$ShopMgr = new ShopMgr();	

	$strSubPageCode		= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];
	$intIC_CODE			= $_POST["ic_code"]			? $_POST["ic_code"]			: $_REQUEST["ic_code"];
	$strIC_TYPE			= $_POST["ic_type"]			? $_POST["ic_type"]			: $_REQUEST["ic_type"];
 	$strDS_CODE			= $_POST["ds_code"]			? $_POST["ds_code"]			: $_REQUEST["ds_code"];	
	$intSH_NO			= $_POST["shopNo"]			? $_POST["shopNo"]			: $_REQUEST["shopNo"];	


	$intIC_CODE			= $intBE_NO;
	if (!$intSH_NO){
		exit;
	}

	$strDS_TYPE = sprintf("SKIN_%s", substr($strSubPageCode,0,2));
	//$designSetMgr->setDS_TYPE($strDS_TYPE);
	//$row		= $designSetMgr->getCodeView($db);
	//$ds			= substr($strSubPageCode,0,2);
	//if($intIC_CODE && $strIC_TYPE) :
	//	$ds1	= $ds . "_BEST_LIST" . $intBE_NO;
	//	$ds2	= strtolower($ds1);
	//endif;
		
?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){

	});

	/*-- 이벤트 정의 --*/
	function imgViewWChangeEvent(data) {
		var imgViewW	= $(data).val();
		    imgViewW	= (15 * imgViewW) + 'px'; 
		$("#imageViewCnt").css({'width':imgViewW});
	}


	function titleImageDelete() {
		// 타이틀 이미지 삭제
		var  x = confirm("타이틀 이미지를 삭제하시겠습니까?");
		if (x != true) {
			return;
		}
		var doc					= document.form;
		doc.menuType.value		= "layout";
		doc.mode.value			= "act";
		doc.act.value			= "skinProdListTitleImageDelete";

//		C_getAction("skinProdListTitleImageDelete","<?=$PHP_SELF?>");		
//		return;

		var formData			= $("#form").serialize();
		C_AjaxPost("titleImageDelete", "./index.php", formData, "post");
	}


	function goAct(){

		var doc = document.form;
		doc.menuType.value = "seller";
		
		document.form.encoding = "multipart/form-data";
		C_getAction("shopNotOk","<?=$PHP_SELF?>");		
		return;
		
//		doc.mode.value	= "act";
//		doc.act.value	= "skinProdListImg";
//		var formData	= $("#form").serialize();
//
//		C_AjaxPost("skinProdListImgAct", "./index.php", formData, "post");
		
	}


	function goClose()
	{
		parent.goLayoutPopCloseEvent();
		//self.close();
	}

//-->
</script>
<!--div class="layerPopWrap"-->
<div>
	<div class="popTop">
				<h2>미승인 사유</h2>
		<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>
	<div class="popBoxWrap">
		<form name="form" id="form">
		<input type="hidden" name="menuType" value="popup">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="act" value="">
		<input type="hidden" name="shopNo" value="<?=$intSH_NO?>">

			<!-- ******** 컨텐츠 ********* -->
			<div class=" mt10">
				<br><br>
				<center>
				<table style="width:450px">
					<colgroup>
						<col/>
						<col/>
					</colgroup>
					<tr>
						<th>
							미승인 사유에 대해 20자 내외로 사유를 등록해 주세요<!-- inBorderFFF -->
						</th>
					</tr>
					<tr>
						<th>
							<textarea name="shop_appr_no_reason" style="width:80%;height:100px;"></textarea>
						</th>
					</tr>
				</table>
				</center>
			</div><!-- newTableList --><br><br>
			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAct();"><strong>확인</strong></a>
			</div>
		</form>
	</div>
</div>
</body>
</html>