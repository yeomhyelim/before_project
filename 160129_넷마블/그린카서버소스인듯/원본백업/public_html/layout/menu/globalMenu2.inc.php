<?php
	## 스크립트 설정
	$aryScript[] = "/common/js/jquery.ddslick.min.js";
	$aryScriptEx[] = "/common/js/jquery.ddslick.min.js";

	## 기본 설정
	$strSiteLng = $S_SITE_LNG;
	$aryUseLng = explode("/", $S_USE_LNG);

	$aryLngName['KR'] = "Korean";
	$aryLngName['AU'] = "English";
	$aryLngName['CN'] = "Chinese";
	$aryLngName['JP'] = "Japanese";
	$aryLngName['RU'] = "Russian";
	$aryLngName['US'] = "English";

	## 언어 설정
	$aryDDSlickData = "";
	$strUseLngOption= "";
	foreach($aryUseLng as $key => $lng):
		$strUseLngOption .= "<option value=\"".$lng."\" ";
		$strUseLngOption .= ($strSiteLng == $lng) ? "selected" : "";
		$strUseLngOption .= ">".$aryLngName[$lng]."</option>";
	endforeach;
?>
<script type="text/javascript" language="javascript">
	function siteLngChange(){
		var strParam	= G_PHP_PARAM;
		var langSelect = $("#langs option:selected").val();
		 langSelect =  langSelect.toLowerCase();
		var strUrl = "/" + langSelect + "/";
		if(strParam) { strUrl =  strUrl + "?"; }
		location.href = strUrl + strParam;
	}
	
		function goSalesManagement () {
			var href		= "http://www.fingbook.com/shopAdmin/";
			window.open(href,"판매관리","width=1200px,height=800px,location=yes,scrollbars=yes,status=yes,resizable=yes");
		}
</script>
<div class="glbList">
	<span class="gList">
	<? if($g_member_no): // 회원 모드?>
		<span class="name"><?=callLangTrans($LNG_TRANS_CHAR["CW00044"], array("{$g_member_name} {$g_member_last_name}"))?></span>
		<a href="./?menuType=member&mode=act&act=logout"><?=$LNG_TRANS_CHAR["CW00049"]?></a> |
	<?else:?>
		<a href="./?menuType=member&mode=login"><?=$LNG_TRANS_CHAR["CW00045"]?></a>  |
		<a href="./?menuType=member&mode=join1"><?=$LNG_TRANS_CHAR["CW00047"]?></a> |
	<?endif;?>


	<? if($g_member_no): // 회원 모드?>
			
	<?else:?>			

	<? endif; ?>
			<a href="./?menuType=contents&mode=userPage&id=00005"><?=$LNG_TRANS_CHAR["CW00043"]//고객센터?></a> |
			<a onclick="goSalesManagement()";><?= $LNG_TRANS_CHAR["CW00133"]; //판매관리 ?></a> |
			<select id="langs" name="langs" onchange="javascript:siteLngChange();">
				<?=$strUseLngOption;?>
			</select>
	</span>
</div>
