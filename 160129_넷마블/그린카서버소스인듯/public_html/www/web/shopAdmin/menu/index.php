<?
	require_once MALL_CONF_LIB."MenuMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	
	$menuMgr = new MenuMgr();
	$siteMgr = new SiteMgr();

	
	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	
	$intMN_NO		= $_POST["mn_no"]			? $_POST["mn_no"]			: $_REQUEST["mn_no"];

	$siteRow = $siteMgr->getSiteInfoView($db);
	$aryUseLng = explode("/",$siteRow[S_USE_LNG]);
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json"){
		include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/
?>
<? include "./include/header.inc.php"?>
<?
	

	switch($strMode){
		case "list":
			
			$menuRet01 = $menuMgr->getList01($db);								
		break;

		case "list2":
			
			$menuRet01 = $menuMgr->getList01($db);								
		break;

		case "write":
						
			$menuAry01 = $menuMgr->getListAry01($db);

		break;
	}
	
	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}

?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
		
	});	

	function goMoveUrl(mode){
		C_getMoveUrl(mode,"post","<?=$PHP_SELF?>");	
	}

	function goAct(mode)
	{
		if (mode == "write")
		{
			if(!C_chkInput("mn_name_kr", true, "Menu Name")) return;
		}

		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goMnLevelChk(level){
		if (level == 1)
		{
			trHighMenu.style.display = "none";
		} else {
			trHighMenu.style.display = "";
		}
	}

	function goMnHigh(selObj){
		var val = selObj.options[selObj.selectedIndex].value;
		
		var intMN_LEVEL = 0;
		for(var i=0;i<document.form.mn_level.length;i++){
			if (document.form.mn_level[i].checked == true)
			{	
				intMN_LEVEL = document.form.mn_level[i].value;
				break;
			}
		}
		if (!C_isNull(val) && intMN_LEVEL == "3")
		{
			$("#divHighMenu").load("./?menuType=menu&mode=act&act=highMenu&mn_high_01="+val);
		}
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
						<input type="hidden" name="mn_no" value="<?=$intMN_NO?>">
						<?if ($strMode != "list"){?>
						<input type="hidden" name="searchField" value="<?=$strSearchField?>">
						<input type="hidden" name="searchKey" value="<?=$strSearchKey?>">
						<?}?>
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

