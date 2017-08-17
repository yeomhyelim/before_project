<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr			= new DesignSetMgr();	

	$strSubPageCode			= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];
	$strDM_CODE				= $_POST["dm_code"]			? $_POST["dm_code"]			: $_REQUEST["dm_code"];

	if (!$strSubPageCode){
		exit;
	}

	$strKey					= substr($strSubPageCode,0,1);

	$designSetMgr->setDS_TYPE("SKIN_{$strKey}");
	$row					= $designSetMgr->getCodeView($db);

	$strMenuGrpTopUseOpt	= (!$row["{$strKey}_TOP_USE_OP"]) ? "A" : $row["{$strKey}_TOP_USE_OP"];

	/* DB에 등록된 이미지/HTML 리스트 */
	$strDS_CODE				= sprintf("%s%%_TOP_IMG", substr($strSubPageCode,0,1));
	$designSetMgr->setDS_CODE($strDS_CODE);
	$aryMenuTop				= $designSetMgr->getMenuTopList($db);
	$aryMenuHtmlTop			= $designSetMgr->getMenuTopHtmlList($db);
	/* DB에 등록된 이미지 리스트 */
	foreach($aryMenuTop as $menuTop) :
		$key			= substr($menuTop['DS_CODE'],0,2);
		$aryData[$key]	= $menuTop['DS_VAL'];
	endforeach;
	$result				= json_encode($aryData);	
	$result				= addslashes($result);

	$arySkinGrpName		= array("Z" => "메인" , "P" => "상품", "M" => "회원", "O" => "주문");
?>

<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){

		<? if ( $strMenuGrpTopUseOpt == "C" ) : ?>	
		$.getJSON("http://www.eumshop.com/api/json/shopDesign.json.php?act=getShopSkinMenuTopHtml&dm_code=<?=$strDM_CODE?>&ds_code=<?=$strSubPageCode?>&jsonData=<?=$result?>&callback=?", function(data) {
			$("#design_skin").html(data[0].DESIGN_SKIN);
		});	
		<? endif; ?>

		<? /* 페이지 통합 관리 할 때 자동 실행 */ ?>
		<? if ( $strMenuGrpTopUseOpt == "A" ) : ?>	
		goMenuTopHtml("<?=$strKey?>");
		<? endif; ?>
	});

	function goAct(){
		var doc = document.form;
		doc.menuType.value = "layout";
		
		//document.form.encoding = "multipart/form-data";
		C_getAction("skinMenuGrpTop","<?=$PHP_SELF?>");				
	}

	function goMenuTopHtml(code)
	{
		var strUrl = "./?menuType=popup&mode=skinMenuTopHtml&dm_code=<?=$strDM_CODE?>&subPageCode="+code;
		$.smartPop.open({  bodyClose: false, width: 600, height: 450, url: strUrl, closeImg: {width:13, height:13, src:'../himg/common/btn_pop_close.png'} });

	}
	
	function goSelfClose() {
		$.smartPop.close();
	}

	function goClose() {
		parent.goClose();
	}
//-->
</script>
<div id="contentArea">
	<table style="width:100%;">
		<tr>
			<td class="contentWrap">
				<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
					<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">					
						<div id="contentArea">
							<div class="contentTop">
								<h2><?=$arySkinGrpName[$strKey]?> 페이지 Top 관리</h2>
								<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
								<div class="clear"></div>
							</div>
							<!-- ******** 컨텐츠 ********* -->
							<div class="tableForm" style="margin-top:10px;">
								<table>
									<tr>
										<th>적용방법</th>
										<td>
											<input type="radio" name="pl_top_use_op" id="pl_top_use_op" value="A" <?=($strMenuGrpTopUseOpt=="A")?"checked":"";?>/><?=$arySkinGrpName[$strKey]?> 페이지 이미지 통합 적용<br><br>
											<input type="radio" name="pl_top_use_op" id="pl_top_use_op" value="C" <?=($strMenuGrpTopUseOpt=="C")?"checked":"";?>/><?=$arySkinGrpName[$strKey]?> 페이지 이미지 상세 적용<br><br>
											<input type="radio" name="pl_top_use_op" id="pl_top_use_op" value="N" <?=($strMenuGrpTopUseOpt=="N")?"checked":"";?>/><?=$arySkinGrpName[$strKey]?> 페이지 이미지 사용 안함
										</td>
									</tr>
								</table>
							</div><!-- tableList -->

							<div class="buttonWrap">
								<a class="btn_blue_big" href="javascript:goAct();" id="menu_auth_w"><strong>저장</strong></a>
								<a class="btn_blue_big" href="javascript:goClose();"><strong>닫기</strong></a>
							</div>
						</div>
					</form>
					</div>
				<!-- ******************** contentsArea ********************** -->
			</td>
		</tr>
		<tr>
			<td class="contentWrap">
				<div class="layoutWrap">
					<div class="tableList" id="design_skin" style="margin-top:10px;"></div>
				</div>
			</td>
		</tr>
	</table>
</div>
</body>
</html>