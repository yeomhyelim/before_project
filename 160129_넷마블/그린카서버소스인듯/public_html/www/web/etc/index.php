<?
	## 2014.09.01 kim hee sung, 내용 추가
	if(in_array($strMode, array("eumEditor2Image"))):
		include "{$strMode}.inc.php";
		exit;
	endif;
	if(in_array($strAct, array("eumEditor2Image"))):
		include "{$strAct}.inc.php";
		exit;
	endif;

	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json"){
		if ($strMode == "act"){
			include WEB_FRWORK_ACT."etc.php";
			exit;
		}
		
		if ($strMode == "json"){
			include WEB_FRWORK_JSON."etc.php";
			exit;
		}
	}
	/*##################################### Act Page 이동 #####################################*/
	
	/*-- *********** Header Area *********** --*/
	if($strMode == "download"):
		// 다운로드는 header 정보가 없어야 함.
		include sprintf ( "%swww/web/%s/%s_A0001_%s.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $strMode  );
		exit;
	else:
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 
	endif;
	/*-- *********** Header Area *********** --*/

//	include "../layout/html/config.inc.php";
//	include "./layout/html/sub_html.inc.php";
	
?>

<!-- (1) 서브메인영역 -->
	<div class="contentWrap">
		<? include sprintf ( "%swww/web/%s/%s_A0001_%s.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $strMode  ); ?>
	</div>
<!-- (1) 서브메인영역 -->

