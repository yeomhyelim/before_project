<?php

	/*-- *********** Header Area *********** --*/

	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT);

	include WEB_FRWORK_HELP."member.php";

	/*-- *********** Header Area *********** --*/
	include (!$strPageTarget) ? "../layout/html/member_html.inc.php" : "../layout/member/member_html.{$strPageTarget}.inc.php";
?>

<div id="indicatorLayer" style="position:absolute;top:0px;left:0px;background:#000;z-index:9998;-ms-filter:alpha(opacity=20);filter:alpha(opacity=20);-moz-opacity:0.2;opacity:0.2;"></div>