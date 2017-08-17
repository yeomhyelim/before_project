<?
	require_once MALL_CONF_LIB."SiteMgr.php";

	$siteMgr = new SiteMgr();		


	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	$intS_NO		 = $_POST["s_no"]			? $_POST["s_no"]			: $_REQUEST["s_no"];
	$intSC_NO		= $_POST["sc_no"]			? $_POST["sc_no"]			: $_REQUEST["sc_no"];
	/*##################################### Parameter 셋팅 #####################################*/

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];


	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act"){
		include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "004";
	/* 관리자 권한 설정 */

	## 언어 설정
	$strLang = $_GET['lang'];
	if(!$strLang) { $strLang = $S_ST_LNG; }
	$strLangLower = strtolower($strLang);
?>
<? include "./include/header.inc.php"?>
<?
	switch($strMode){
		case "siteCommList":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "005";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$intPageBlock = 10;
			$intPageLine  = 10;

			$siteMgr->setPageLine($intPageLine);
			$siteMgr->setSearchStatusY($strSearchStatusY);
			$siteMgr->setSearchStatusN($strSearchStatusN);
			$siteMgr->setSearchKey($strSearchKey);

			$intTotal	= $siteMgr->getSiteCommTotal($db);
			
			$intTotPage	= ceil($intTotal / $siteMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$siteMgr->setLimitFirst($intFirst);

			$result = $siteMgr->getSiteCommList($db);		
	
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";

		break;

		case "siteCommView":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "005";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$siteMgr->setSC_NO($intSC_NO);
			$row = $siteMgr->getSiteCommView($db);

		break;

		case "siteCommModify":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "005";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$siteMgr->setSC_NO($intSC_NO);
			$row = $siteMgr->getSiteCommView($db);
			
		break;

		case "delRetHelp":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "005";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			$row = $siteMgr->getSiteTextView($db);
//			echo $db->query;
		break;
	}

	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}
?>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});

	function goSearch()
	{
		C_getMoveUrl("<?=$strMode?>","get","<?=$PHP_SELF?>");
	}

	/* 공통관리 */
	function goMoveUrl(mode,no)
	{
		switch (mode)
		{
		case "siteCommWriteOK":

			if(!C_chkInput("sc_title", true, "<?=$LNG_TRANS_CHAR['PW00106']?>",true)) return; //제목
			if(!C_chkInput("sc_text", true, "<?=$LNG_TRANS_CHAR['PW00107']?>",true)) return; //내용

			C_getAction(mode,"<?=$PHP_SELF?>")
		
		break;

		case "siteCommModifyOK":

			if(!C_chkInput("sc_title", true, "<?=$LNG_TRANS_CHAR['PW00106']?>",true)) return;
			if(!C_chkInput("sc_text", true, "<?=$LNG_TRANS_CHAR['PW00107']?>",true)) return;

			C_getAction(mode,"<?=$PHP_SELF?>")
		break;

		case "siteCommModify":

			document.form.sc_no.value = no;
			C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");

		break;

		case "siteCommWrite":

			C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");

		break;

		case "siteCommView":

			document.form.sc_no.value = no;
			C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");

		break;

		case "siteCommList":

			C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");

		break;

		case "siteCommDelete":

			var  x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택한 데이타를 삭제하시겠습니까?
			if (x == true)
			{
				document.form.sc_no.value = no;
				C_getAction(mode,"<?=$PHP_SELF?>")
			}

		break;

		case "delRetHelpModify":

			C_getAction(mode,"<?=$PHP_SELF?>")

		break;

		} // switch	
	}

	
//-->
</script>
<!-- ******************** TopArea ********************** -->
	<? include "./include/top.inc.php"?>
<!-- ******************** TopArea ********************** -->
	<div id="contentArea">
	<table style="width:100%;">
		<tr>
			<td class="leftWrap">
				<!-- ******************** leftArea ********************** -->
					<?include "./include/left.inc.php"?>
				<!-- ******************** leftArea ********************** -->
			</td>
			<td class="contentWrap">
				<div class="bodyTopLine"></div>
				<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
					<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="sc_no" value="<?=$intSC_NO?>">
						<input type="hidden" name="lang" value="<?php echo $strLang;?>"/>
						<?
							include $includeFile;
						?>				
					</form>
					</div>
				<!-- ******************** contentsArea ********************** -->
			</td>
		</tr>
	</table>
	</div>
<!-- ******************** footerArea ********************** -->
	<?include "./include/bottom.inc.php"?>
<!-- ******************** footerArea ********************** -->
</body>
</html>