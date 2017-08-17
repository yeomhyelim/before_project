<?
	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	
	$boardMgr = new BoardMgr();
	$memberMgr = new MemberMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	$strBoardCode	= $_POST["bCode"]			? $_POST["bCode"]			: $_REQUEST["bCode"];

	$intB_NO		= $_POST["bNo"]				? $_POST["bNo"]				: $_REQUEST["bNo"];

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
	/* 회원그룹 */
	$aryMemberGroup = $memberMgr->getGroupList($db);

	switch($strMode){
		case "boardList":
			
			$aryBoardList = $boardMgr->getBoardList($db);


		break;

		case "boardModify":
				
			$boardMgr->setB_NO($intB_NO);
			$row = $boardMgr->getBoardView($db);

		break;

		case "dataList":

			$boardMgr->setB_CODE($strBoardCode);
			$aryBoardSet = $boardMgr->getBoardData($db);

			$intPageBlock	= $aryBoardSet[0][B_PAGE_CNT];
			$intPageLine	= $aryBoardSet[0][B_LINE_CNT];
			
			$boardMgr->setPageLine($intPageLine);
			$boardMgr->setSearchField($strSearchField);
			$boardMgr->setSearchKey($strSearchKey);
			//$boardMgr->setSearchCat1($strSearchCat1);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);
						
			$intTotal	= $boardMgr->getDataTotal($db);
			$intTotPage	= ceil($intTotal / $boardMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$boardMgr->setLimitFirst($intFirst);

			$result = $boardMgr->getDataList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		
			
			$linkPage = "$S_PHP_SELF?m=$strMenuName&code=$strCode&searchCat1=$strSearchCat1&searchField=$strSearchField&searchKey=$strSearchKey&page=";

		break;
	}

	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}
?>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		<?if ($strMode == "boardAdd"){?>
		$("#w_auth").live("click",function(){
			
			var strFlag = false;
			if ($(this).val() == "1")
			{
				strFlag = true;
			} 
			
			$("#w_group").attr("disabled",strFlag);
		});

		$("#l_auth").live("click",function(){
			
			var strFlag = false;
			if ($(this).val() == "1")
			{
				strFlag = true;
			} 
			
			$("#l_group").attr("disabled",strFlag);
		});

		$("#v_auth").live("click",function(){
			
			var strFlag = false;
			if ($(this).val() == "1")
			{
				strFlag = true;
			} 
			
			$("#v_group").attr("disabled",strFlag);
		});


		<?}?>

		
	});

	/* 게시판생성추가 */
	function goBoardAdd()
	{
		C_getMoveUrl("boardAdd","get","<?=$PHP_SELF?>");
	}

	function goBoardAct(mode)
	{
		if(!C_chkInput("code",true,"게시판코드",true)) return;
		if(!C_chkInput("title",true,"게시판제목",true)) return;

		C_getAction(mode,"<?=$PHP_SELF?>")
	}

	function goBoardModify(no)
	{
		var doc = document.form;
		doc.bNo.value = no;

		C_getMoveUrl("boardModify","get","<?=$PHP_SELF?>");
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
					<img src="/web/shopAdmin/himg/common/box_coner_top.gif" class="conerTop"/>
					<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="bNo" value="<?=$intB_NO?>">
						
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
