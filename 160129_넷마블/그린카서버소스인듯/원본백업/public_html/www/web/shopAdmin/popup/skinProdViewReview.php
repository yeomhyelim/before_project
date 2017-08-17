<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode	= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];

	if (!$strSubPageCode){
		exit;
	}

	$designSetMgr->setDS_TYPE("SKIN_PV");
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
		C_getAction("skinProdViewReview","<?=$PHP_SELF?>");				
	}
//-->
</script>
	<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">					
			<div class="layerPopWrap">
				<div class="popTop">
				<h2>상품상세보기 사용후기/상품Q&A 관리</h2>
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clear"></div>
			</div>
			<!-- ******** 컨텐츠 ********* -->
				<div class="tableList" style="margin-top:10px;">
				<table>
					<tr>
						<th>사용후기</th>
						<td>
							<input type="radio" name="afterYN" id="afterYN" value="Y" <?=(!$row[PV_AFTER_YN] || $row[PV_AFTER_YN]=="Y")?"checked":"";?>>사용
							<input type="radio" name="afterYN" id="afterYN" value="N" <?=($row[PV_AFTER_YN]=="N")?"checked":"";?>>사용안함
						</td>
					</tr>
					<tr>
						<th>상품Q&A</th>
						<td>
							<input type="radio" name="qnaYN" id="qnaYN" value="Y" <?=(!$row[PV_QNA_YN] || $row[PV_QNA_YN]=="Y")?"checked":"";?>>사용
							<input type="radio" name="qnaYN" id="qnaYN" value="N" <?=($row[PV_QNA_YN]=="N")?"checked":"";?>>사용안함
						</td>
					</tr>
					<tr>
						<th>관련상품</th>
						<td>
							<input type="radio" name="relatedYN" id="relatedYN" value="Y" <?=(!$row[PV_RELATED_YN] || $row[PV_RELATED_YN]=="Y")?"checked":"";?>>사용
							<input type="radio" name="relatedYN" id="relatedYN" value="N" <?=($row[PV_RELATED_YN]=="N")?"checked":"";?>>사용안함
						</td>
					</tr>
				</table>
			</div><!-- tableList -->

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAct();" id="menu_auth_w"><strong>저장</strong></a>
			</div>
		</div>
	</form>
</body>
</html>