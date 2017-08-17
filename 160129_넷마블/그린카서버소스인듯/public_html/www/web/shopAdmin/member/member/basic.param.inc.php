<?
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];
	
	$strSearchOut				= $_POST["searchOut"]					? $_POST["searchOut"]					: $_REQUEST["searchOut"];
	$strSearchRegStartDt		= $_POST["searchRegStartDt"]			? $_POST["searchRegStartDt"]			: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt			= $_POST["searchRegEndDt"]				? $_POST["searchRegEndDt"]				: $_REQUEST["searchRegEndDt"];
	$strSearchOutStartDt		= $_POST["searchOutStartDt"]			? $_POST["searchOutStartDt"]			: $_REQUEST["searchOutStartDt"];
	$strSearchOutEndDt			= $_POST["searchOutEndDt"]				? $_POST["searchOutEndDt"]				: $_REQUEST["searchOutEndDt"];

	$strSearchLastLoginStartDt	= $_POST["searchLastLoginStartDt"]		? $_POST["searchLastLoginStartDt"]		: $_REQUEST["searchLastLoginStartDt"];
	$strSearchLastLoginEndDt	= $_POST["searchLastLoginEndDt"]		? $_POST["searchLastLoginEndDt"]		: $_REQUEST["searchLastLoginEndDt"];
	$strSearchVisitStartCnt		= $_POST["searchVisitStartCnt"]			? $_POST["searchVisitStartCnt"]			: $_REQUEST["searchVisitStartCnt"];
	$strSearchVisitEndCnt		= $_POST["searchVisitEndCnt"]			? $_POST["searchVisitEndCnt"]			: $_REQUEST["searchVisitEndCnt"];
	$strSearchSex				= $_POST["searchSex"]					? $_POST["searchSex"]					: $_REQUEST["searchSex"];
	$strSearchMailYN			= $_POST["searchMailYN"]				? $_POST["searchMailYN"]				: $_REQUEST["searchMailYN"];
	$strSearchSmsYN				= $_POST["searchSmsYN"]					? $_POST["searchSmsYN"]					: $_REQUEST["searchSmsYN"];
	$strSearchBirthMonth		= $_POST["searchBirthMonth"]			? $_POST["searchBirthMonth"]			: $_REQUEST["searchBirthMonth"];
	$strSearchBirthDay			= $_POST["searchBirthDay"]				? $_POST["searchBirthDay"]				: $_REQUEST["searchBirthDay"];
	$strSearchRecId				= $_POST["searchRecId"]					? $_POST["searchRecId"]					: $_REQUEST["searchRecId"];
	$strSearchGroup				= $_POST["searchGroup"]					? $_POST["searchGroup"]					: $_REQUEST["searchGroup"];
	
	$intM_NO					= $_POST["memberNo"]					? $_POST["memberNo"]					: $_REQUEST["memberNo"];

	$strSearchOrderSortCol		= $_POST["searchOrderSortCol"]			? $_POST["searchOrderSortCol"]			: $_REQUEST["searchOrderSortCol"];
	$strSearchOrderSort			= $_POST["searchOrderSort"]				? $_POST["searchOrderSort"]				: $_REQUEST["searchOrderSort"];
?>