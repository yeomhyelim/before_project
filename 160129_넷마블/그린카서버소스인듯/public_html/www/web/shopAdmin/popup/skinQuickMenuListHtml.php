<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode			= $_POST["subPageCode"]			? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];
	$strQuickMenuKind		= $_POST["quickMenuKind"]		? $_POST["quickMenuKind"]		: $_REQUEST["quickMenuKind"];

	if (!$strSubPageCode){
		exit;
	}

	$designSetMgr->setDS_TYPE("SKIN_EQ");
	$row = $designSetMgr->getCodeView($db);
		
	$strQuickMenuUse = $row["EQ_QUICK_MENU_USE_".$strQuickMenuKind];		// 사용유무
	$strQuickMenuAct = $row["EQ_QUICK_MENU_ACT_".$strQuickMenuKind];		// 액션
	$strQuickMenuSpe = $row["EQ_QUICK_MENU_SPE_".$strQuickMenuKind];		// 스피드
	$strQuickMenuTop = $row["EQ_QUICK_MENU_TOP_".$strQuickMenuKind];		// 탑위치
	$strQuickMenuLef = $row["EQ_QUICK_MENU_LEF_".$strQuickMenuKind];		// 우측 위치
	$strQuickMenuListCnt	= $row["EQ_QUICK_MENU_LIST_CNT_".$strQuickMenuKind];		// 상품 개수
	$strQuickMenuEffect		= $row["EQ_QUICK_MENU_EFFECT_".$strQuickMenuKind];			// 효과
	$strQuickMenuAlign		= $row["EQ_QUICK_MENU_ALIGN_".$strQuickMenuKind];			// 효과

	$strQuickMenuSize		= $row["EQ_QUICK_MENU_PIMG_SIZ_".$strQuickMenuKind];		// 가로/세로 사이즈
	list($strQuickMenuSizeWidth, $strQuickMenuSizeHeight) = explode("*",$strQuickMenuSize);

?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goAct(){
		<? /** 2013.06.24  kim hee sung 이사님 요청으로 text 입력 폼으로 변경 **/ ?> 
		var width	= $("input#quickMenuProdImgSize_width").val();
		var height	= $("input#quickMenuProdImgSize_height").val();
		$("input[name=quickMenuProdImgSize]").val(width + "*" + height);

		var doc = document.form;
		doc.menuType.value = "layout";
		
		document.form.encoding = "multipart/form-data";
		C_getAction("skinQuickMenuListHtml","<?=$PHP_SELF?>");				
	}

	function goClose() {
		parent.goSelfClose();
	}
//-->
</script>

	<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">
		<input type="hidden" name="quickMenuKind" value="<?=$strQuickMenuKind?>">
			<div class="layerPopWrap">
			<div class="popTop">
				<h2>퀵메뉴 설정</h2>
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clear"></div>
			</div>

		<div class="tableList" style="margin-top:10px;">
			<table>
			<tr>
				<th>사용유무</th>
				<td><input type="radio" name="quickMenuUse" value="Y" <?=$strQuickMenuUse=="Y"?"checked":""?>/> 사용 
					<input type="radio" name="quickMenuUse" value="N" <?=$strQuickMenuUse!="Y"?"checked":""?>/> 사용 안함</td>
			</tr>
			<tr>									
				<th>상품 리스트 개수</th>
				<td><select name="quickMenuProdListCnt" style="width:200px;">
						<option value="1" <?=$strQuickMenuListCnt==1?"selected":""?>>1 개</option>
						<option value="2" <?=$strQuickMenuListCnt==2?"selected":""?>>2 개</option>
						<option value="3" <?=$strQuickMenuListCnt==3?"selected":""?>>3 개</option>
						<option value="4" <?=$strQuickMenuListCnt==4?"selected":""?>>4 개</option>
						<option value="5" <?=$strQuickMenuListCnt==5?"selected":""?>>5 개</option>
						<option value="6" <?=$strQuickMenuListCnt==6?"selected":""?>>6 개</option>
						<option value="7" <?=$strQuickMenuListCnt==7?"selected":""?>>7 개</option>
						<option value="8" <?=$strQuickMenuListCnt==8?"selected":""?>>8 개</option>
						<option value="9" <?=$strQuickMenuListCnt==9?"selected":""?>>9 개</option>
						<option value="10" <?=$strQuickMenuListCnt==10?"selected":""?>>10 개</option>
						</select><?=$S_QUICK_MENU_LIST_CNT_1?></td>
			</tr>
			<tr>
				<th>상품이미지 크기</th>
				<? /** 2013.06.24 kim hee sung 이사님 요청으로 text 입력 폼으로 변경 
				<td><select name="quickMenuProdImgSize" style="width:200px;">
						<option value="50*50">가로:50 px * 세로:50 px</option>
						<option value="60*70">가로:60 px * 세로:70 px</option>
						<option value="80*90">가로:80 px * 세로:90 px</option>
						<option value="90*100">가로:90 px * 세로:100 px</option>
						<option value="100*110">가로:100 px * 세로:110 px</option>
					<select></td>		**/?>
				<td>
					<input type="text" id="quickMenuProdImgSize_width" style="width:50px" value="<?=$strQuickMenuSizeWidth?>"> X
					<input type="text" id="quickMenuProdImgSize_height" style="width:50px" value="<?=$strQuickMenuSizeHeight?>">
					<input type="hidden" name="quickMenuProdImgSize" value="<?=$strQuickMenuSize?>">
				</td>
			</tr>
			<tr>
				<th>효과</th>
				<td><select name="quickMenuEffect" style="width:200px;">
						<option value="F" <?=$strQuickMenuEffect=="F"?"selected":""?>>퀵메뉴 상단 고정</option>
						<option value="S" <?=$strQuickMenuEffect=="S"?"selected":""?>>퀵메뉴 항상 보임</option>
						<option value="A" <?=$strQuickMenuEffect=="A"?"selected":""?>>퀵메뉴 효과 A</option>
					<select> 속도 : <input type="text" name="quickMenuSpe" value="<?=$strQuickMenuSpe?>" style="width:50px;"></td>
			</tr>
			<tr>
				<th>정렬</th>
				<td><select name="quickMenuAlign" style="width:200px;">
						<option value="left" <?=$strQuickMenuAlign=="left"?"selected":""?>>퀵메뉴 왼쪽 정렬</option>
						<option value="right" <?=$strQuickMenuAlign=="right"?"selected":""?>>퀵메뉴 오른쪽 정렬</option>
					<select></td>
			</tr>
			<tr>
				<th>위치</th>
				<td><span class="spanTitle">탑위치</span> <input type="text" name="quickMenuTop" id="quickMenuTop"  value="<?=$strQuickMenuTop?>" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
					<span class="spanTitle">우측위치</span> <input type="text" name="quickMenuLef" id="quickMenuLef"  value="<?=$strQuickMenuLef?>" <?=$nBox?>  style="width:40px;"/> px</td>
			</tr>
			</table>
		</div>

		<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goAct();" id="menu_auth_w"><strong>저장</strong></a>
		<a class="btn_blue_big" href="javascript:goClose();"><strong>닫기</strong></a>
		</div>
	</form>
</body>
</html>
