<?
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "deliveryWrite"			=> "delivery"
								,"deliveryModify"			=> "delivery"
								,"deliveryDelete"			=> "delivery"
								,"countryZoneWrite"			=> "country"
								,"countryZoneModify"		=> "country"
								,"countryZoneDelete"		=> "country"

								,"countryStateWrite"		=> "state"
								,"countryStateModify"		=> "state"
								,"countryStateDelete"		=> "state"

							 );
	/* 페이지 분류 */
	
	include $strIncludePath.$aryIncludeFolder[$strAct]."/act.inc.php";
	
	goUrl($strMsg,$strUrl);
?>