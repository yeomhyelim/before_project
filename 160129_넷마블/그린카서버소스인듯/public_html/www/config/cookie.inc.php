<?
		$strP_CODE		= $_POST["prodCode"]	? $_POST["prodCode"]	: $_REQUEST["prodCode"];
		
		if($strP_CODE) :
			$intProdMax					= ($S_QUICK_MENU_LIST_CNT_1) ? $S_QUICK_MENU_LIST_CNT_1 : 5;
			$strProdToday				= $strP_CODE;
			$aryProdToday				= explode("/", $g_prod_today);
			if($aryProdToday) : 
				foreach($aryProdToday as $prodCode) :
					if(!$prodCode) { continue; }
					if(!$strProdToday) { continue; }
					if(!strstr($strProdToday, $prodCode)) :
						$strProdToday = sprintf("%s/%s", $strProdToday, $prodCode);
					endif;
				endforeach;
			endif;
			setCookie("COOKIE_PROD_TODAY", $strProdToday, 0, "/");
		endif;

?>