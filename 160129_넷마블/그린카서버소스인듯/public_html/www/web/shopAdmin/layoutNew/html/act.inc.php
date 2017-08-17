<?
	switch($strAct):
	case "popHtmlMakeFile":
		// 파일 생성

		## 클래스 생성
		require_once MALL_HOME . "/classes/file/file.handler.class.php";
		$file			= new FileHandler();

		## 설정
		$dirLang		= strtolower($_POST['lang']);
		$dir			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/htmlTag/{$dirLang}";
		$fileName		= "{$dir}/{$_POST['fileName']}";

		## 파일 체크
		if(!$_POST['fileName']):
			$strMsg = "파일명이 없습니다.";
			$strUrl = $_SERVER['HTTP_REFERER'];
			if($strUrl)		{ goUrl($strMsg, $strUrl);		}
			else			{ goClose($strMsg);				}
			exit;
		endif;
		if(is_file($fileName)):
			$strMsg = "파일이 존재합니다.";
			$strUrl = $_SERVER['HTTP_REFERER'];
			if($strUrl)		{ goUrl($strMsg, $strUrl);		}
			else			{ goClose($strMsg);				}
			exit;
		endif;

		## 파일 생성
		if($file->makeFile($fileName) != 1):
			$strUrl = $_SERVER['HTTP_REFERER'];
			$strMsg = "파일을 생성 할 수 없습니다.";
			if($strUrl)		{ goUrl($strMsg, $strUrl);		}
			else			{ goClose($strMsg);				}
		endif;

		$strMsg = "파일이 생성 되었습니다.";
		if($strUrl)		{ goUrl($strMsg, $strUrl);		}
		else			{ goClose($strMsg);				}
		exit;

	break;
	endswitch;	
?>