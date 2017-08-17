<?
	
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	/* 쿠폰 관리 */
	$strSearchCouponIssue		= $_POST["searchCouponIssue"]	? $_POST["searchCouponIssue"]	: $_REQUEST["searchCouponIssue"];		// 쿠폰 종류
	$strSearchCouponUse			= $_POST["searchCouponUse"]		? $_POST["searchCouponUse"]		: $_REQUEST["searchCouponUse"];			// 쿠폰 사용유무

	$intCU_NO					= $_POST["cuNo"]				? $_POST["cuNo"]				: $_REQUEST["cuNo"];
	$intCI_NO					= $_POST["ciNo"]				? $_POST["ciNo"]				: $_REQUEST["ciNo"];

	/* 선택 */
	$aryChkNo			= $_POST["chkNo"]			? $_POST["chkNo"]			: $_REQUEST["chkNo"];
	
?>