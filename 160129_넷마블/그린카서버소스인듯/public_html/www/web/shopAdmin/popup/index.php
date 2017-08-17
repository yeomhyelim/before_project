<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	$productMgr = new ProductAdmMgr();		

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];


	$intNo			= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	$strGubun		= $_POST["gb"]				? $_POST["gb"]				: $_REQUEST["gb"];
	
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json"){
		include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/

	
	switch($strMode){
	}
	
	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
		
	}

	include $includeFile;
?>

