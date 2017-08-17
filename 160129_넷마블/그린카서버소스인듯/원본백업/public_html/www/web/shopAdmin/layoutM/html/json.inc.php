<?php
	switch($strAct):
	case "htmlModify":
		// html 코드 수정

		## 기본 설정
		$strLang = $_GET['lang'];
		$strFile = $_POST['file'];
		$strHtml = $_POST['html'];

		## 유효성 체크
		if(!$strFile):
			$result['__STATE__'] = "NO_FILE";
			$result['__MSG__'] = "저장할 파일을 선택하세요.";
			break;
		endif;
		if(!$strLang) { $strLang  = $S_SITE_LNG; }
		$strLangLower = strtolower($strLang);
		$root = SHOP_HOME . "/mobile/layout/html/{$strLangLower}";
		$rootBak = SHOP_HOME . "/mobile/layout/html-bak/{$strLangLower}";
		$rootCompiler = SHOP_HOME . "/mobile/layout/html-c/{$strLangLower}";
		$aryBakFileInfo = pathInfo($rootBak . $strFile);
		$aryCompilerFileInfo = pathInfo($rootCompiler . $strFile);
		$rootConfig = "{$aryCompilerFileInfo['dirname']}/config-{$aryCompilerFileInfo['basename']}";
		$rootConfig = str_replace(".html", ".php", $rootConfig);

		## 파일 백업
		if(is_file($root . $strFile)):
			FileDevice::makeFolder($aryBakFileInfo['dirname']);
			copy($root . $strFile, $rootBak . $strFile . "_bak_" . date("YmdHis"));
		endif;

		## 10개 이상이면 삭제
		$aryBakFileList = glob($rootBak . $strFile. "*");
		if(sizeof($aryBakFileList) >= 10):
			FileDevice::fileDelete($aryBakFileList[0]);
		endif;

		## 데이터 기록
		FileDevice::fileWrite($root . $strFile, $strHtml);

		## 컴파일 초기설정
		$strHtml = str_replace("{@contents}", "{@include=contents}", $strHtml);

		## 컴파일
		$aryIncludeData = EnginInfo::getFindData("/{@include.*}/iU", $strHtml);
		$aryLayoutData = EnginInfo::getFindData("/{@layout.*}/iU", $strHtml);
		$aryAppData = EnginInfo::getFindData("/{@app.*}/iU", $strHtml);	
		$aryDivAppData = EnginInfo::getFindData("/app\=\".*\"/iU", $strHtml);

		## include
		if($aryIncludeData):
			## app 데이터
			foreach($aryIncludeData as $includeKey => $includeData):
				## 기본설정
				$strIncludeTag = $includeData['tag'];
				$aryIncludeData = $includeData['data'];

				## include 데이터 만들기
				$strInclude  = "\$e='';";
				$strInclude .= "\$e['mode']='include';";
				foreach($aryIncludeData as $dataKey => $dataData):
					$strInclude .= "\$e['{$dataKey}']='{$dataData}';";
				endforeach;
				$strInclude .= "include MALL_HOME . '/web/app/engin.php';";
				$strInclude  = "<?php {$strInclude} ?>";
				$strInclude  = str_replace(".html", ".php", $strInclude);
				
				## html 코드 설정
				$strHtml = str_replace($strIncludeTag, $strInclude, $strHtml);
			endforeach;
		endif;

		## layout
		$strLayout = "";
		if($aryLayoutData):
			## 기본설정
			$strTag = $aryLayoutData[0]['tag'];
			$strData = $aryLayoutData[0]['data']['layout'];

			## 레이아웃 만들기
			$strLayout = "\$layout = '{$strData}';";
			$strLayout  = str_replace(".html", ".php", $strLayout);

			## html 코드 설정
			$strHtml = str_replace($strTag, "", $strHtml);
		endif;
		## 파일 만들기
		FileDevice::getMadeInfo($rootConfig, $strLayout, "/* layout */");

		## app
		$aryApp = "";
		$strApp = "";
		$intCnt = 0;
		if($aryAppData):	
			## app 데이터
			foreach($aryAppData as $appKey => $appData):
				## 기본설정
				$strTag = $appData['tag'];
				$aryData = $appData['data'];

				foreach($aryData as $key => $data):
					if($key == "app"):
						if(in_array($data, $aryApp)) { continue; }
						$aryApp[] = $data;
					endif;
					if($strApp) { $strApp .= "\r\n"; }
					$strApp .= "\$config[{$intCnt}]['{$key}'] = '{$data}';";
				endforeach;
				$intCnt++;
				
				## html 코드 설정
				$strHtml = str_replace($strTag, "", $strHtml);
			endforeach;
		endif;

		## div app
		if($aryDivAppData):
			foreach($aryDivAppData as $divAppKey => $divAppData):
				## 기본설정
				$strTag = $divAppData['tag'];
				$aryData = $divAppData['data'];

				foreach($aryData as $key => $data):
					if($key == "app"):
						if(in_array($data, $aryApp)) { continue; }
						$aryApp[] = $data;
					endif;
					if($strApp) { $strApp .= "\r\n"; }
					$strApp .= "\$config[{$intCnt}]['{$key}'] = '{$data}';";
				endforeach;
				$intCnt++;
			endforeach;
		endif;

		## 파일 만들기
		$strApp  = str_replace(".html", ".php", $strApp);
		FileDevice::getMadeInfo($rootConfig, $strApp, "/* app */");

		## 컴파일 데이터 기록
		$aryFileInfo = pathInfo($rootCompiler . $strFile);
		if($aryFileInfo['extension'] == "html"):
			$strFile = str_replace(".html", ".php", $strFile);
		endif;
		FileDevice::makeFolder($aryFileInfo['dirname']);
		FileDevice::fileWrite($rootCompiler . $strFile, $strHtml);

		## 전달 데이터 만들기
		$result['__STATE__'] = "SUCCESS";
		$result['__MSG__'] = "저장 완료";

	break;

	case "bakFileRead":
		// 백업 파일 내용 불러오기
		
		## 기본 설정
		$strLang = $_GET['lang'];
		$strFile = $_POST['file'];
		$strBakFile = $_POST['bakFile'];

		## 유효성 체크
		if(!$strLang) { $strLang  = $S_SITE_LNG; }
		$strLangLower = strtolower($strLang);
		$root = SHOP_HOME . "/mobile/layout/html/{$strLangLower}";
		$rootBak = SHOP_HOME . "/mobile/layout/html-bak/{$strLangLower}";
		
		## 데이터 불러오기
		$strText = file_get_contents($rootBak . $strFile . "_bak_" . $strBakFile);

		## 전달 데이터 만들기
		$result['__STATE__'] = "SUCCESS";
		$result['__DATA__']['html']  = $strText;


	break;

	case "fileRead":
		// 파일 내용 불러오기
		
		## 기본 설정
		$strLang = $_GET['lang'];
		$strFile = $_POST['file'];

		## 유효성 체크
		if(!$strLang) { $strLang  = $S_SITE_LNG; }
		$strLangLower = strtolower($strLang);
		$root = SHOP_HOME . "/mobile/layout/html/{$strLangLower}";
		$rootBak = SHOP_HOME . "/mobile/layout/html-bak/{$strLangLower}";
		
		## 데이터 불러오기
		$strText = file_get_contents($root . $strFile);

		## 백업파일 리스트 가져오기
		$aryBakFileList = glob($rootBak . $strFile. "*");
		$aryBakFileData = "";
		if($aryBakFileList):
			foreach($aryBakFileList as $key => $data):
				$aryFileInfo = pathInfo($data);
				list($strBakFile, $strBakTime) = explode("_bak_", $aryFileInfo['basename']);
				$aryBakFileData[$key]['key'] = $strBakTime;
				$aryBakFileData[$key]['name'] = date("Y년m월d일 H시i분s초", strtotime($strBakTime));
			endforeach;
		endif;

		## 전달 데이터 만들기
		$result['__STATE__'] = "SUCCESS";
		$result['__DATA__']['html']  = $strText;
		$result['__DATA__']['bakList']  = $aryBakFileData;

	break;

	case "fileDelete":

		## 기본 설정
		$strLang = $_GET['lang'];
		$strFile = $_POST['file'];

		## 유효성 체크
		if(!$strLang) { $strLang  = $S_SITE_LNG; }
		$strLangLower = strtolower($strLang);
		$root = SHOP_HOME . "/mobile/layout/html/{$strLangLower}";
		$rootCompiler = SHOP_HOME . "/mobile/layout/html-c/{$strLangLower}";
		FileDevice::fileDelete($root . $strFile);
		FileDevice::fileDelete($rootCompiler . $strFile);

	break;

	case "fileList":
		// 파일/폴더 리스트
		// script 자체 지원으로 일반적인 형식으로 데이터를 리턴 하지 않습니다.

		## 기본 설정
		$strLang = $_GET['lang'];
		$strFolderOnly = $_GET['folderOnly'];
		$strDir = $_POST['dir'];

		## 유효성 체크
		if(!$strLang) { $strLang  = $S_SITE_LNG; }
		$strLangLower = strtolower($strLang);
		$root = SHOP_HOME . "/mobile/layout/html/{$strLangLower}";

		## 데이터 만들기
		$strHtml = "";
		if(file_exists($root . $strDir)):
			$files = scandir($root . $strDir);
			
			## dir
			foreach($files as $file):
				if(!file_exists($root . $strDir . $file) || $file == '.' || $file == '..' || !is_dir($root . $strDir . $file)) { continue; }
				$strRel = htmlentities($strDir . $file) . "/";
				$strName = htmlentities($file);
				$strHtml .= "<li class='directory collapsed'><a href='#' rel='{$strRel}'>{$strName}</a></li>";
			endforeach;

			## file
			if($strFolderOnly != "Y"):
				foreach($files as $file):
					if(!file_exists($root . $strDir . $file) || $file == '.' || $file == '..' || is_dir($root . $strDir . $file)) { continue; }
					$strRel = htmlentities($strDir . $file);
					$strName = htmlentities($file);
					$ext = preg_replace('/^.*\./', '', $file);
					$strHtml .= "<li class='file ext_{$ext}'><a href='#' rel='{$strRel}' class='btnFile'>{$strName}</a><a href='#' rel='{$strRel}' class='btnX'>x</a></li>";
				endforeach;
			endif;

			$strHtml = "<ul class='jqueryFileTree style='display:none'>{$strHtml}</ul>";
		endif;
		
		echo $strHtml;
		exit;
	break;
	endswitch;