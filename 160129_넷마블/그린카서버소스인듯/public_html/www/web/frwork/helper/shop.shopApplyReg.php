<?
	if (!$strShopType) $strShopType = "C";
	$aryBank = getCommCodeList("BANK");
	
	$aryCountryList		= getCountryList();
	$aryCountryState	= getCommCodeList("STATE","");

	$aryCountryListTotalAry		= getCountryListTotalAry();
	

?>