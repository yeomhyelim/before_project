<?
	$row = $siteMgr->getSiteInfoView($db);

	$strOrderFileText  = "";

	$strOrderFileText .= "\$SHOP_ARY_DELIVERY['SHOP_DELIVERY_ST'] = \"".$row["S_DELIVERY_ST"]."\"; \n";
	$strOrderFileText .= "\$SHOP_ARY_DELIVERY['SHOP_DELIVERY_ST_PRICE'] = \"".$row["S_DELIVERY_FREE"]."\"; \n";
	$strOrderFileText .= "\$SHOP_ARY_DELIVERY['SHOP_DELIVERY_PRICE'] = \"".$row["S_DELIVERY_FEE"]."\";\n";
	$strOrderFileText .= "\$SHOP_ARY_DELIVERY['SHOP_DELIVERY_EXP_PRICE'] = \"\";\n";
	$strOrderFileText .= "\$SHOP_ARY_DELIVERY['SHOP_DELIVERY_EXP_AREA'] = \"\";\n";

	$strOrderFileText .= "\$SHOP_PAY_PG = \"".$row["S_PG"]."\";\n";

	$strOrderFileText .= "\$SHOP_SITE_CODE = \"".$row["S_PG_SITE_CODE"]."\";\n";
	$strOrderFileText .= "\$SHOP_SITE_KEY  = \"".$row["S_PG_SITE_KEY"]."\";\n";


	$strOrderFileText .= "\$SHOP_ARY_DELIVERY['SHOP_DELIVERY_ST_FOR_PRICE'] = \"".$row["S_DELIVERY_FREE_FOR"]."\"; \n";
	$strOrderFileText .= "\$SHOP_ARY_DELIVERY['SHOP_DELIVERY_FOR_PRICE'] = \"".$row["S_DELIVERY_FEE_FOR"]."\";\n";

	$strOrderFileText .= "\$SHOP_PAY_FOR_PG = \"".$row["S_FOR_PG"]."\";\n";



	$strOrderFileText = "<?\n".$strOrderFileText."?>\n";
	$file = "../conf/order.inc.php";
	@chmod($file,0755);
	$fw = fopen($file, "w");
	fputs($fw,$strOrderFileText, strlen($strOrderFileText));
	fclose($fw);
?>