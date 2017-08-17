
<?
	## 작성일		: 2013.06.12
	## 작성자		: kim hee sung
	## 내  용		: 메시지를 전달하거나 받는 모듈 작성
	##				  (문자 보내기, 쪽지 보내기, 메일 보내기)
	## 참고사항		: 쪽지 보내기 기능만 가능(팝업 모드)

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || $strMode == "open" || SUBSTR($strMode,0,3) == "pop"){

		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Message.php";
			exit;
		}

		if (SUBSTR($strMode,0,3) == "pop") {
			include "{$strIncludePath}{$strMode}.php";
			exit;
		}
	}

	/*##################################### Act Page 이동 #####################################*/


?>

