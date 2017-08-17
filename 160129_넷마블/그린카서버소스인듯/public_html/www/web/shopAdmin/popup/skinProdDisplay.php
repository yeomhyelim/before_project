<?php
	## 2014.08.26 kim hee sung.
	## 진영장관리
	## http://demo2.eumshop.co.kr/shopAdmin/?menuType=popup&mode=skinProdDisplay&subPageCode=ZL0001
	## 저장 버튼을 누르면 -> /home/shop_eng/www/web/shopAdmin/layout/act.php 페이지에서 skinBestName 부분을 처리함.

	require_once MALL_CONF_LIB."DesignSetMgr.php";
	
	$designSetMgr		= new DesignSetMgr();	

	$strSubPageCode		= $_POST["subPageCode"]		? $_POST["subPageCode"]					: $_REQUEST["subPageCode"];
	$ds					= substr($strSubPageCode,0,2);

	// 샵메인 정보 로드
	$designSetMgr->setDS_TYPE("SKIN_".$ds);
	$skinRow = $designSetMgr->getCodeView($db);

?>


<? include "./include/header.inc.php"?>

<script type="text/javascript">
<!--
	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});

	function goProdDisplay(){
		var doc				= document.form;

		doc.menuType.value = "layout";

//		C_getAction("skinBestName","<?=$PHP_SELF?>");	
//		return;

		doc.mode.value		= "act";
		doc.act.value		= "skinBestName";
		var formData		= $("#form").serialize();

		C_AjaxPost("prodDsplaySaveFromPopupAct", "./index.php", formData, "post");
	}

	var aryData = "";
	function goAjaxRet(name,result){
		if (name == "prodDsplaySaveFromPopupAct") {			
			console.log(data);
			if (data[0].RET == "Y") {
				aryData = "Y";
//				parent.goAllBestChangeValueParentEvent($("*"));
				parent.popProdDisplayCloseEvent();
				parent.goAllBestChangeValueParentEvent($("input:[name^=<?=strtolower($ds)?>_best_list]"));
				alert(data[0].MSG);		
//				parent.location.reload();
			} else {
				console.log(data);
			}
		}
	}

	function goClose()
	{
		parent.goClose();
	}
//-->
</script>

<div class="layerPopWrap">
	<div class="popTop">
		<h2>진열장 관리</h2>			
		<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>

	<div class="popBoxWrap">
		<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="ic_type" value="<?=$strIC_TYPE?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">
		<!-- ******** 컨텐츠 ********* -->
		<div class="tableList">
			<table>
			<tr>
				<th>진열명</th>
			</tr>
			<?	for($i=1;$i<=5;$i++):		?>
			<tr>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="<?=strtolower($ds)?>_best_list<?=$i?>_name" name="<?=strtolower($ds)?>_best_list<?=$i?>_name" value="<?=$skinRow[$ds.'_BEST_LIST'.$i.'_NAME']?>"/>
				</td>
			</tr>
			<?	endfor;			?>
			</table>
		</div>
		<!-- ******** 컨텐츠 ********* -->
		</form>
	</div>
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goProdDisplay();" id="menu_auth_m" style="display:none"><strong>저장</strong></a>
	<a class="btn_big" href="javascript:goClose();"><strong>닫기</strong></a>
</div>


</body>

</html>