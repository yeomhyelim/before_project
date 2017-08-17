<?php
	if($S_SEND_MAIL_VERSION == "1"):
		include_once "mail.func_v1.php";
	else:
		include_once "mail.func_v0.php";
	endif;