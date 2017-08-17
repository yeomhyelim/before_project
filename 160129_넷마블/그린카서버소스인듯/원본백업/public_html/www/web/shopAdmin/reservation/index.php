<?
	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "";
	/* 관리자 Top 메뉴 권한 설정 */

	/* 페이지 분류 */
	$aryIncludeFolder = array(
								"basicSet"					=> "setting",
								"roomSetEtc"				=> "roomSetEtc",
								"poproomSetEtc"				=> "roomSetEtc",
								"poproomTypeSet"			=> "roomSetEtc",
								"poproomSetEtcModify"		=> "roomSetEtc",
								"poproomTypeSetModify"		=> "roomSetEtc",
								"roomSetFix"				=> "roomSetFix",
								"roomSetPolicy"				=> "roomSetPolicy",
								"poproomSetFix"				=> "roomSetFix",
								"roomSetFixWrite"			=> "roomSetFix",
								"poproomSetFixModify"		=> "roomSetFix",
								"roomSetFixModify"			=> "roomSetFix",
								"poproomSetFix2"			=> "roomSetFix",
								"roomSetFixModify2"			=> "roomSetFix",
								"poproomSetFixModify2"		=> "roomSetFix",
								"roomSetPolicyWrite"		=> "roomSetPolicy",
								"roomList"					=> "roomList",
								"roomWrite"					=> "roomList",
								"roomDataWrite"				=> "roomList",
								"roomModify"				=> "roomList",
								"roomDataModify"			=> "roomList",
							 );

	/* 페이지 분류 */

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || SUBSTR($strMode,0,3) == "pop" || $strMode == "excel"){

		if (SUBSTR($strMode,0,3) == "pop") include $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".php";
		else include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/

	include $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".helper.inc.php";

	if (!$includeFile){
		$includeFile = $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".php";
	}

?>
<? include "./include/header.inc.php"?>
<?include $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".script.inc.php";?>
<?include $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".helper.inc.php";?>
<!-- ******************** TopArea ********************** -->
	<? include "./include/top.inc.php"?>
<!-- ******************** TopArea ********************** -->
	<div id="contentArea">
		<table style="width:100%;">
			<tr>
				<td class="leftWrap">
					<!-- ******************** leftArea ********************** -->
						<?include $strIncludePath."/left.inc.php"?>
					<!-- ******************** leftArea ********************** -->
				</td>
				<td class="contentWrap">
					<div class="bodyTopLine"></div>
					<!-- ******************** contentsArea ********************** -->
						<div class="layoutWrap">
						<?
							include $includeFile;
						?>
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