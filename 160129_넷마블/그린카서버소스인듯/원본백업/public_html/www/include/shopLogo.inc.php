<?
	
	$responseText = "";
	if ( $S_WEB_LOGO_TYPE == "I" ) :
		$responseText = sprintf ( "<a href=\"./\"><img src=\"%s\" style=\"vertical-align:bottom;\"/></a>", $S_WEB_LOGO_IMG );
	elseif ( $S_WEB_LOGO_TYPE == "F" ) :
		$responseText = sprintf ( "<script type=\"text/javascript\">insertFlash(\"%s\", '174', '76', \"#FFFFFF\", \"main\",\"\");</script>", $S_WEB_LOGO_IMG);
	endif;

	echo $responseText;

?>

