<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode	= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];

	if (!$strSubPageCode){
		exit;
	}

	$ds				= substr($strSubPageCode,0,2);
	$designSetMgr->setDS_TYPE("SKIN_{$ds}");
	$row = $designSetMgr->getCodeView($db);
?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goAct(){
		var doc = document.form;
		doc.menuType.value = "layout";
		
		//document.form.encoding = "multipart/form-data";
		C_getAction("skinProdListSubCate","<?=$PHP_SELF?>");				
	}

	function goSubCateDesignList(){
		$("#btnSubCateDesign").bind("click", function() {

			var strSubPageCode = $("#subPageCode").val();
			$.smartPop.open({  bodyClose: false, width: 600, height: 700, url: './?menuType=popup&mode=designSkinBtnList&subPageCode='+strSubPageCode+'&btnCode=C', closeImg: {width:13, height:13, src:'../himg/common/btn_pop_close.png'} });
		});
	}

	function goSubCateDesignSubmit(code)
	{
		document.form.subCateDesign.value = code;
		$("#spanSubCateDesign").text(code);
	}

	function goClose()
	{
		parent.goClose();
	}

	function goSelfClose()
	{
		$.smartPop.close();
	}
//-->
</script>
	<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">
		<input type="hidden" name="subCateDesign" value="<?=$row["{$ds}_SUB_CATE_DESIGN"]?>">
			<div class="layerPopWrap">
				<div class="popTop">
				<h2>상품리스트(서브카테고리) 관리</h2>
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clear"></div>
			</div>
			<!-- ******** 컨텐츠 ********* -->
				<div class="tableList" style="margin-top:10px;">
				<table>
					<tr>
						<th>1차 카테고리 옵션</th>
						<td>
							<input type="radio" name="pl_sub_cate_l1_mode" id="" value="N" <?=($row["{$ds}_SUB_CATE_L1_MODE"]=="N" || !$row["S_PRODUCT_CATE_L1_MODE"])?"checked":"";?>/> 숨김 
							<input type="radio" name="pl_sub_cate_l1_mode" id="" value="T" <?=($row["{$ds}_SUB_CATE_L1_MODE"]=="T")?"checked":"";?>/> 텍스트
							<input type="radio" name="pl_sub_cate_l1_mode" id="" value="I" <?=($row["{$ds}_SUB_CATE_L1_MODE"]=="I")?"checked":"";?>/> 이미지
						</td>
					</tr>
					<tr>
						<th>2차 카테고리 옵션</th>
						<td>
							<input type="radio" name="pl_sub_cate_l2_mode" id="" value="N" <?=($row["{$ds}_SUB_CATE_L2_MODE"]=="N" || !$row["S_PRODUCT_CATE_L2_MODE"])?"checked":"";?>/> 숨김 
							<input type="radio" name="pl_sub_cate_l2_mode" id="" value="T" <?=($row["{$ds}_SUB_CATE_L2_MODE"]=="T")?"checked":"";?>/> 텍스트
							<input type="radio" name="pl_sub_cate_l2_mode" id="" value="I" <?=($row["{$ds}_SUB_CATE_L2_MODE"]=="I")?"checked":"";?>/> 이미지
						</td>
					</tr>
					<tr>
						<th>3차 카테고리 옵션</th>
						<td>
							<input type="radio" name="pl_sub_cate_l3_mode" id="" value="N" <?=($row["{$ds}_SUB_CATE_L3_MODE"]=="N" || !$row["S_PRODUCT_CATE_L3_MODE"])?"checked":"";?>/> 숨김 
							<input type="radio" name="pl_sub_cate_l3_mode" id="" value="T" <?=($row["{$ds}_SUB_CATE_L3_MODE"]=="T")?"checked":"";?>/> 텍스트
							<input type="radio" name="pl_sub_cate_l3_mode" id="" value="I" <?=($row["{$ds}_SUB_CATE_L3_MODE"]=="I")?"checked":"";?>/> 이미지
						</td>
					</tr>
					<tr>
						<th>4차 카테고리 옵션</th>
						<td>
							<input type="radio" name="pl_sub_cate_l4_mode" id="" value="N" <?=($row["{$ds}_SUB_CATE_L4_MODE"]=="N" || !$row["S_PRODUCT_CATE_L4_MODE"])?"checked":"";?>/> 숨김 
							<input type="radio" name="pl_sub_cate_l4_mode" id="" value="T" <?=($row["{$ds}_SUB_CATE_L4_MODE"]=="T")?"checked":"";?>/> 텍스트
							<input type="radio" name="pl_sub_cate_l4_mode" id="" value="I" <?=($row["{$ds}_SUB_CATE_L4_MODE"]=="I")?"checked":"";?>/> 이미지
						</td>
					</tr>
					<!--tr>
						<th>디자인</th>
						<td>
							<span id="spanSubCateDesign"><?=$row["{$ds}_SUB_CATE_DESIGN"]?></span>
							<a class="btn_blue_sml" href="javascript:goSubCateDesignList();" id="btnSubCateDesign"><strong>디자인선택</strong></a>
						</td>
					</tr-->
				</table>
			</div><!-- tableList -->

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAct();" id="menu_auth_w"><strong>저장</strong></a>
				<a class="btn_blue_big" href="javascript:goClose();"><strong>닫기</strong></a>
			</div>
		</div>
	</form>
</body>
</html>