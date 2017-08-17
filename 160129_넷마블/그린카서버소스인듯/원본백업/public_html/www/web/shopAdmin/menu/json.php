<?
	$intNo			= $_POST["no"]				? $_POST["no"]			: $_REQUEST["no"];

	$strCode1		= $_POST["code1"]			? $_POST["code1"]		: $_REQUEST["code1"];
	$strCode2		= $_POST["code2"]			? $_POST["code2"]		: $_REQUEST["code2"];
	$strCode3		= $_POST["code3"]			? $_POST["code3"]		: $_REQUEST["code3"];

	$result_array = array();
	


	if ($strCode3) {
		$intMenuLevel	= 3;
	
		$arrayRow		= getTopLowMenuArray02($intNo, $strCode1, $strCode2, $strCode3);
//echo $db->query;

	} else {
		$intMenuLevel	= 2;

		$arrayRow		= getTopLowMenuArray($intNo, $strCode1, $strCode2);
	}
	
	if (is_array($arrayRow)){
		
		$aryResut[0]["RET"]		= "Y";

		$aryResut[0]["AUTH_L"]	= $arrayRow[0][AM_L];
		$aryResut[0]["AUTH_W"]	= $arrayRow[0][AM_W];
		$aryResut[0]["AUTH_M"]	= $arrayRow[0][AM_M];
		$aryResut[0]["AUTH_D"]	= $arrayRow[0][AM_D];
		$aryResut[0]["AUTH_E"]	= $arrayRow[0][AM_E];
		$aryResut[0]["AUTH_C"]	= $arrayRow[0][AM_C];
		$aryResut[0]["AUTH_S"]	= $arrayRow[0][AM_S];
		$aryResut[0]["AUTH_P"]	= $arrayRow[0][AM_P];
		$aryResut[0]["AUTH_U"]	= $arrayRow[0][AM_U];
		
		$aryResut[0]["AUTH_E1"]	= $arrayRow[0][AM_E1];
		$aryResut[0]["AUTH_E2"]	= $arrayRow[0][AM_E2];
		$aryResut[0]["AUTH_E3"]	= $arrayRow[0][AM_E3];
		$aryResut[0]["AUTH_E4"]	= $arrayRow[0][AM_E4];
		$aryResut[0]["AUTH_E5"]	= $arrayRow[0][AM_E5];


	} else {
		
		$aryResut[0]["RET"]	= "N";
	}
	
	$result_array = json_encode($aryResut);
	echo $result_array;
?>