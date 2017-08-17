<?php
	## 언어 설정
	$strLang = $_GET['lang'];
	if(!$strLang) { $strLang =$S_ST_LNG; }
	$strLang = strtoupper($strLang);
	$strLangLower = strtolower($strLang);

	## script 설정
	## 스크립트 설정 
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/basic/policy.js";

?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00023"] //정책및약관관리?> <!-- a href="http://www.eumshop.com/shopManual/?c=basic&p=0102" target="_blank"><img src="http://eumshop.co.kr/shopManual/images/common/ico_menual.gif"/></a --></h2>
			<div class="locationWrap">
				<span>home</span> / <span><?=$LNG_TRANS_CHAR["BW00087"] //기본설정?></span> / <strong><?=$LNG_TRANS_CHAR["BW00023"] //정책및약관관리?></strong>
			</div>
			<div class="clr"></div>
	</div>

	<!-- 언어 선택 탭 -->
		<?include "./include/tab_language.inc.php";?>
	<!-- 언어 선택 탭-->
	<!-- ******** 컨텐츠 ********* -->

	<div class="tableForm">
		<h3><?=$LNG_TRANS_CHAR["BW00024"] //이용약관관리?></h3>
		<table>
			<tr>
				<td>
					<?php include MALL_HOME."/common/eumEditor2/editor1.php";?>
					<textarea name="use_policy" style="display:none"><?php echo $row["S_USE_POLICY_{$strLang}"]?></textarea>
				</td>
			</tr>
		</table>
		<br>
		<h3><?=$LNG_TRANS_CHAR["BW00025"] //개인정보보호정책?></h3>
		<table>
			<tr>
				<td>
					<?php include MALL_HOME. "/common/eumEditor2/editor2.php";?>
					<textarea name="person_policy" style="display:none"><?php echo $row["S_PERSON_POLICY_{$strLang}"]?></textarea>
				</td>
			</tr>
		</table>
	</div>
	<br>

	<div class="buttonWrap">
		<a href="javascript:void(0);" onclick="goBasicPolicyModifyActEvent();" id="menu_auth_m" class="btn_Big_Blue"  style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
</div>