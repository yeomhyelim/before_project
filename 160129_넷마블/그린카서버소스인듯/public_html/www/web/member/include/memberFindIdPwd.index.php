<?php
	
	$strIncludeTemp = "memberFindIdPwd.{$S_MEMBER_LOGIN_IMAGE_DESIGN}.skin.php";

	if($S_MEM_CERITY == 2) { $strIncludeTemp = "memberFindIdPwd.ML0003.skin.php"; }

	include $strIncludeTemp;




