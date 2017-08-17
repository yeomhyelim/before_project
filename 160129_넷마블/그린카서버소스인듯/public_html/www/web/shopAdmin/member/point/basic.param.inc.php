<?
	$intM_NO					= $_POST["memberNo"]			? $_POST["memberNo"]			: $_REQUEST["memberNo"];
	
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strSearchPointType			= $_POST["searchPointType"]		? $_POST["searchPointType"]		: $_REQUEST["searchPointType"];			// 포인트 종류
	$strSearchExpStartDt		= $_POST["searchExpStartDt"]	? $_POST["searchExpStartDt"]	: $_REQUEST["searchExpStartDt"];
	$strSearchExpEndDt			= $_POST["searchExpEndDt"]		? $_POST["searchExpEndDt"]		: $_REQUEST["searchExpEndDt"];
	$strSearchPointStart		= $_POST["searchPointStart"]	? $_POST["searchPointStart"]	: $_REQUEST["searchPointStart"];
	$strSearchPointEnd			= $_POST["searchPointEnd"]		? $_POST["searchPointEnd"]		: $_REQUEST["searchPointEnd"];

	/* 정렬 */
	$strSearchOrderSortCol		= $_POST["searchOrderSortCol"]			? $_POST["searchOrderSortCol"]			: $_REQUEST["searchOrderSortCol"];
	$strSearchOrderSort			= $_POST["searchOrderSort"]				? $_POST["searchOrderSort"]				: $_REQUEST["searchOrderSort"];
?>