<?php

	## 액션
	if($strMode == "act" || $strMode == "json"):
		include dirname(__FILE__) . "/{$strMode}.php";
		exit;
	endif;

	include "./include/header.inc.php";
	include_once "layout-default.php";