<?

	$S_MEMBER_LOGIN_IMAGE_DESIGN					= ($S_MEMBER_LOGIN_IMAGE_DESIGN) ? $S_MEMBER_LOGIN_IMAGE_DESIGN : "ML0001";

	$arySkinFolder	= array(	"login"				=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/member_body_{$strMode}.inc.php",
								"findIdPwd"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/member_body_{$strMode}.inc.php",
								"join1"				=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/member_body_{$strMode}.inc.php",
								"joinForm"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/member_body_{$strMode}.inc.php",
								"joinEnd"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/member_body_{$strMode}.inc.php",
								"joinKind"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/member_body_{$strMode}.inc.php",
								"private"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/member_body_{$strMode}.inc.php",
								"agreement"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/member_body_{$strMode}.inc.php"						);


	include $arySkinFolder[$strMode];
 ?>

      
