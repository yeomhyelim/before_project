<?
#/*====================================================================*/# 
#|화일명	: _function.lib.inc.php																		|#
#|작성자	: 김희성																						|#
#|작성일	: 2011.02.09																				|#
#|작성내용	: design 공통 함수																			|#
#/*====================================================================*/# 


##############################################################
# 파일 관련																	 #
##############################################################
/**
 * 이미지 파일 업로드
 * @param string bufferName 	: <input> 태그의 이름
 * @param string upLoadPath 	: 서버에 저장할 폴더명
 * @param string realName		: 서버에 업로드된 파일명
 */ 

function imageFileUpLoad($bufferName, $upLoadPath, &$realName, $strUserFileName="") 
{
	global $fh;

	if ($_FILES[$bufferName][name]) :
		if(!getAllowImgFileExt($_FILES[$bufferName][name], "Y")) :
			goErrMsg($LNG_TRANS_CHAR["CS00009"]); //"첨부하신 파일은 확장자가 금지된 파일입니다."
			exit;
		endif;
		
		$filename 			= $_FILES[$bufferName][name];
		$tmpname			= $_FILES[$bufferName][tmp_name];
		$filesize 			= $_FILES[$bufferName][size];
		$filetype 			= $_FILES[$bufferName][type];
		$number 			= date("YmdHis");
		$path				= WEB_UPLOAD_PATH . $upLoadPath ;
		
		if($strUserFileName) :
			$strUserFileName = $strUserFileName . "." . strtolower($fh->getFileExtension($filename));
		else:
///			$strUserFileName = $strUserFileName . "_" . $number . "." . $fh->getFileExtension($filename);
			$strUserFileName = $filename . "_" . $number . "." . strtolower($fh->getFileExtension($filename));
		endif;

		$fres 				= $fh->doUpload($number, $path, $filename, $tmpname, $filesize, $filetype, $strUserFileName);
		@chmod( $path . "/" . $strFileName ,0707);	
		if($fres) :
			$realName 	= $fres[file_real_name] ;
			return 1;
		else :
			return -1;
		endif;
	endif;
	
}

/**
 * 디렉토리 체크후 없으면 생성
 * @param string upload 	: 디렉토리명 (예 : /layout/product/bestTitle => /home/shop_1000/eum_dev/upload/layout/product/bestTitle
 */ 
function HS_makeDir($upload) {

	/* 디렉토리 체크 및 생성 */
	if(!is_dir( WEB_UPLOAD_PATH . $upload )) :
		// 업로드 할 폴더가 없는 경우
		$aryUpload	= explode("/",$upload);
		$strDir		= WEB_UPLOAD_PATH;
		foreach($aryUpload as $path) :
			if($path) :
				$strDir .= "/" . $path;
				if(!is_dir( $strDir )) :
					@mkdir( $strDir ,0707);
					@chmod( $strDir ,0707);		
				endif;
			endif;
		endforeach;
		if(!is_dir( WEB_UPLOAD_PATH . $upload )) :
			return;
		endif;
	endif;
	/* 디렉토리 체크 및 생성 */

	return 1;
}
/**
 * 이미지 파일 업로드
 * @param string bufferName 	: <input> 태그의 이름
 * @param string upLoadPath 	: 서버에 저장할 폴더명
 * @param string keyName		: 배열 키 네임						
 * @param string realName		: 서버에 업로든된 파일명
 */ 
function imageFileUpLoadArray($bufferName, $upLoadPath, $keyName, &$realName) 
{
	global $fh;

	if ($_FILES[$bufferName][name][$keyName]) :
		if(!getAllowImgFileExt($_FILES[$bufferName][name][$keyName], "Y")) :
			goErrMsg("첨부하신 파일은 확장자가 금지된 파일입니다.");
			exit;
		endif;
	
		$filename 		= $_FILES[$bufferName][name][$keyName];
		$tmpname  		= $_FILES[$bufferName][tmp_name][$keyName];
		$filesize 		= $_FILES[$bufferName][size][$keyName];
		$filetype 		= $_FILES[$bufferName][type][$keyName];
		$number 		= date("YmdHis") . "_" . $keyName;
		$path			= "../upload/" . $upLoadPath ;
		$fres 			= $fh->doUpload("$number", $path, $filename, $tmpname, $filesize, $filetype);
		if($fres) :
			$realName 	= $fres[file_real_name] ;
			return 1;
		else :
			return -1;
		endif;
	endif;
	
}

/**
 * $filePath (파일경로 + 파일 이름) 에 $data 를 업데이트 합니다.
 * 디자인관리 / 레이아웃 / 페이지디자인설정 / 바로적용하기 버튼 클릭시 실행
 * SHOP ID / layout / html / 폴더에 기본적으로 저장됨.
 * @param string $filePath		: 파일 경로
 * @param string $data			: 저장할 데이터
 */
function updateHtmlFile($filePath, $data)
{
	if ( file_exists($filePath) ) :
	
		/* 백업 파일 만들기 최대 10개 까지 생성후 오래된 파일 부터 순차적으로 삭제 */
	
	endif;
	
	$file = fopen ( $filePath, "w" );
	
	if ( !$file ) :

		// 파일 생성이 안되거나 쓰기 권한이 없는 경우
		return -1;
	
	endif;
	
	fputs($file, $data);	
	
	fclose($file);
	
	@chmod( $filePath , 0707 );
	
}

function changeLayoutFile($dir)
{
	global $S_DOCUMENT_ROOT, $S_SHOP_HOME;
	
	$updateDir		 	= sprintf( "%s%s/layout/html/", $S_DOCUMENT_ROOT, $S_SHOP_HOME );
	$aryFiles 			= dir( $dir );
	
//	echo $dir . "<br>";
//	echo $updateDir . "<br>";
	
	if ( !$aryFiles ) :
		// 폴더가 없거나 권한이 없음
		return;
	endif;
	
	while ( $file = $aryFiles->read() ) :
	
		if ( $file == "." || $file == ".." ) :
			continue;
		endif;
				
		if ( file_exists($updateDir . $file ) ) :
			// 기존 백업 파일 삭제
			if ( file_exists( $updateDir . "temp_tag_" . $file ) ) :
				unlink (  $updateDir . "temp_tag_" . $file );
			endif;	
			// 파일 백업
			rename( $updateDir . "tag_" . $file , $updateDir . "temp_" . $file );
		endif;		
		
		// 파일 복사
		if ( !copy( $dir . "/" . $file , $updateDir . "tag_" . $file  ) ) :
			// 복사가 안됩니다.
		endif;
		
		if ( file_exists($updateDir . "tag_" . $file ) ) :
			$data = file_get_contents( $updateDir . "tag_" . $file );
			
			if ($data ) :
				changeLayoutData( $data, $strLayoutTransData  );
				updateHtmlFile($updateDir . $file, $strLayoutTransData);
			endif;
		endif;
		
	endwhile;
}

function changeLayoutData( $data, &$outData )
{
	global $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, $db, $S_ST_LNG;
	
	$designConfigFile			= sprintf( "%swww/config/design_conf.php", $S_DOCUMENT_ROOT );
	
	if ( !file_exists($designConfigFile)  ) :
		// 설정 파일이 없음.
		return;	
	endif;	

	include $shopConfigFile;
	include $designConfigFile;


	foreach ( $DESIGN_TAG as $tag => $str ) :
		$str			= sprintf( "<? %s ?>", $str );
		$data 			= str_replace($tag, $str , $data);
	endforeach;
	
	$outData 			= $data;

	return 1;
}

function changeLayoutDataEx(&$data)
{

	preg_match("/{{__MAIN_BOARD__\/\/.*}}/", $data, $matches, PREG_OFFSET_CAPTURE, 3);
	if($matches[0][0]):
		$strMainBoardTag		= $matches[0][0];
		$strMainBoardTag 		= str_replace("{{__MAIN_BOARD__//","" , $strMainBoardTag);	
		$strMainBoardTag 		= str_replace("}}","" , $strMainBoardTag);	
		$aryMainBoardTag		= explode(":", $strMainBoardTag);

		foreach($aryMainBoardTag as $tag):
			$aryValue = explode("=", $tag);
			if($aryValue[0] && $aryValue[1]):
				$str	.= sprintf("\$MAIN_BOARD['%s'] = \"%s\";", $aryValue[0], $aryValue[1]);
			endif;
		endforeach;
		$str .= "include sprintf ( \"%swww/web/main/include/mainBoard.index.inc.php\", \$S_DOCUMENT_ROOT );";
		$str  = "<? {$str} ?>";
		$data 	= str_replace($matches[0][0], $str , $data);
	endif;

	$outData 			= $data;

	return 1;
}

function changeLayoutDataEx2(&$data)
{
	preg_match("/{{__커뮤니티__\/\/.*}}/", $data, $matches, PREG_OFFSET_CAPTURE, 3);
	if($matches[0][0]):
		$strMainBoardTag		= $matches[0][0];
		$strMainBoardTag 		= str_replace("{{__커뮤니티__//","" , $strMainBoardTag);	
		$strMainBoardTag 		= str_replace("__}}","" , $strMainBoardTag);	

		$str  = "\$s=\"{$strMainBoardTag}\";";
		$str .= "include sprintf ( \"%swww/include/Menu/boardMenuStyle.0002.php\", \$S_DOCUMENT_ROOT );";
		$str  = "<? {$str} ?>";
		$data 	= str_replace($matches[0][0], $str , $data);
	endif;

	$outData 			= $data;

	return 1;
}

function changeLayoutDataEx3(&$bi_datascript_data)
{
	## STEP 2.
	## 수행파일 만들기
	## include 사용 형태 <%include "/html/top_5.inc.php"%>
	$bi_datascript_data = str_replace("&lt;", "<", $bi_datascript_data);
	$bi_datascript_data = str_replace("&gt;", ">", $bi_datascript_data);
	preg_match_all("/<%.*%>/", $bi_datascript_data, $preg_data);
	foreach($preg_data[0] as $data):
		$dataTemp = $data;
		$dataTemp = str_replace("<%", "", $dataTemp);
		$dataTemp = str_replace("%>", "", $dataTemp);

		/* include 치환 */
		if(preg_match("/^include[ |\"]/", $dataTemp)):
			$dataTemp			= str_replace("include", "", $dataTemp);
			$dataTemp			= str_replace("\"", "", $dataTemp);
			$dataTemp			= str_replace(" ", "", $dataTemp);
			$dataTemp			= "<? include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}{$dataTemp}\"; ?>";
			$bi_datascript_data	= str_replace($data, $dataTemp, $bi_datascript_data);
		endif;
	endforeach;

}

/** 작성일 : 2013.06.27
  * 작성자 : kim hee sung
  * 내  용 : 문자을 언어별로 출력
  *
  **/
function changeLayoutDataEx4(&$bi_datascript_data)
{
	## STEP 2.
	## 수행파일 만들기
	## include 사용 형태 <%include "/html/top_5.inc.php"%>
	$bi_datascript_data = str_replace("&lt;", "<", $bi_datascript_data);
	$bi_datascript_data = str_replace("&gt;", ">", $bi_datascript_data);
	preg_match_all("/<@.*@>/iU", $bi_datascript_data, $preg_data);

	foreach($preg_data[0] as $data):
		$dataTemp = $data;
		$dataTemp = str_replace("<@", "", $dataTemp);
		$dataTemp = str_replace("@>", "", $dataTemp);
		$dataTemp = "<?=GET_U_TRANS(\"{$dataTemp}\");?>";
		$bi_datascript_data	= str_replace($data, $dataTemp, $bi_datascript_data);
	endforeach;
}

function changeLayoutDataEx5(&$bi_datascript_data)
{
	## STEP 1.
	## 변경할 파일 검색 파일 검색
	## include 사용 형태 <!--?ID=12345678901234567890&WIDTH=100&HEIGHT=200-->
	$bi_datascript_data = str_replace("&lt;", "<", $bi_datascript_data);
	$bi_datascript_data = str_replace("&gt;", ">", $bi_datascript_data);
	preg_match_all("/<!--\?.*-->/iU", $bi_datascript_data, $preg_data);

	## STEP 2.
	## 검색 파일 변경
	foreach($preg_data[0] as $data):

		## STEP 2-1.
		## 필요 없는 내용 삭제
		$dataTemp	= $data;
		$dataTemp	= str_replace("<!--?", "", $dataTemp);
		$dataTemp	= str_replace("-->", "", $dataTemp);
		
		## STEP 2-2.
		## 구분
		$dataTemp1	= "  \$EUMSHOP_APP_INFO = \"\";";
		$dataTemp2	= explode("&", $dataTemp); 
		foreach($dataTemp2 as $temp):
			list($key, $value) = explode("=", $temp);
			if($dataTemp1) { $dataTemp1 .= "\r\n"; }
			$dataTemp1 .= "  \$EUMSHOP_APP_INFO['{$key}'] = \"{$value}\";";
		endforeach;
		
		if($dataTemp1) { $dataTemp1 .= "\r\n  include \"{\$S_DOCUMENT_ROOT}www/web/app/index.php\";"; }
		$dataTemp1				= "<?\r\n{$dataTemp1}\r\n?>";
		$bi_datascript_data		= str_replace($data, $dataTemp1, $bi_datascript_data);
	endforeach;

//	print_r($dataTemp1);
//	exit;
}

function changeLayoutDataEx6(&$bi_datascript_data)
{
	## STEP 1.
	## 변수 치환
	preg_match_all("/{\\$.*}/iU", $bi_datascript_data, $preg_data);

	## STEP 2.
	## 검색 파일 변경
	foreach($preg_data[0] as $data):

		## STEP 2-1.
		## 필요 없는 내용 삭제
		$dataTemp	= $data;
		$dataTemp	= str_replace("{\$", "", $dataTemp);
		$dataTemp	= str_replace("}", "", $dataTemp);
		$dataTemp	= "<?=\$_EDIT['{$dataTemp}']?>";

		$bi_datascript_data		= str_replace($data, $dataTemp, $bi_datascript_data);
	endforeach;

}

/**
 * SHOP_ID / conf / shop.inc.php 파일 수정 및 데이터 추가
 * @param array $aryData			=> 배열 데이터
 * 데이터 구조는
 * $aryData['key'] = "";				=> 검색할 키값
 * $aryData['data'] = "";			=> 저장할 데이터 값
 * $aryData['write'] = "";			=> 데이터를 사용한 경우 true , 사용하지 않는 경우 null
 */
function shopConfigFileUpdate ( $aryData, $fileName )
{
	global $S_DOCUMENT_ROOT, $S_SHOP_HOME;
	
	$shopConfigFile 		= sprintf( "%s%s/conf/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $fileName );
	$aryNewData			= "<?\n";
	
	if ( !file_exists( $shopConfigFile ) ) :
		$file = fopen ( $filePath, "w" );
		fclose($file);
		@chmod( $filePath , 0707 );
	endif;

	if ( file_exists( $shopConfigFile ) ) :

		$aryFile 				= file ( $shopConfigFile );
		
		foreach ( $aryFile as $file ) :
		
			$tempCheck = null;
	
			if ( strstr ( $file, "<?" ) || strstr ( $file, "?>" ) ) :
				continue;
			endif;
			
			$max = sizeof( $aryData );
			for ( $i=0 ;  $i < $max ; $i++ ) :
				$data = &$aryData[$i];
				if ( strstr( $file, $data['key'] ) != false ) :
					$aryNewData		.= sprintf( "	%s		= %s;\n", $data['key'] , $data['data'] );
					$data['write'] 	 = "OK";
					$tempCheck 		 = true;
					break;
				endif;
			endfor;
						
			if ( $tempCheck ) :
				continue;
			endif;
			
			$aryNewData 		.= $file;
			
		endforeach;
	
	endif;

	/* 데이터 사용 유무를 체크하여 사용하지 않는 경우 데이터 기록 */
	$max = sizeof( $aryData );
	for ( $i=0 ;  $i < $max ; $i++ ) :
		$data = &$aryData[$i];
		if ( $data['write'] !== "OK" ) :
			$aryNewData	.= sprintf( "	%s		= %s;\n", $data['key'] , $data['data'] );
		endif;
	endfor;

	$aryNewData			.= "?>\n";
	
	updateHtmlFile( $shopConfigFile, $aryNewData );
}

/**
 * shopCssFileUpdate
 * @param array $aryData			=> 배열 데이터
 * @param array $fileNameOrg		=> css 원본 소스 파일
 * @param array $fileNameUse		=> css 사용 중인 파일
 */
function shopCssFileUpdate( $aryData, $fileNameOrg, $fileNameUse )
{	
	global $S_DOCUMENT_ROOT, $S_SHOP_HOME;
	
	$shopConfigFileOrg 		= sprintf( "%swww/web/shopAdmin/layout/%s", $S_DOCUMENT_ROOT, $fileNameOrg );
	$shopConfigFileUse		= sprintf( "%s%s/layout/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME,  $fileNameUse);

	if ( file_exists( $shopConfigFileOrg ) && file_exists( $shopConfigFileUse ) ) :
		$aryFileOrg				= file ( $shopConfigFileOrg );
		$aryFileUse				= file ( $shopConfigFileUse );

		foreach($aryData as $data) :
			$key		= sprintf("{__%s__}", substr($data['key'],1));
			$val		= preg_replace("/\"/","",$data['data']);
			foreach($aryFileOrg as &$orgData) :
				$orgData	= str_replace($key, $val, $orgData);
			endforeach;
		endforeach;

		foreach($aryFileUse as $useData):
			$strWrite = "";
			foreach($aryFileOrg as &$orgData) :
				$strOrgKey = preg_replace("/{.*}/","",$orgData);
				$strOrgKey = trim($strOrgKey);
				$strUseKey = preg_replace("/{.*}/","",$useData);
				$strUseKey = trim($strUseKey);
//				if ( strstr( $useData, $strKey ) != false ) :
				if ( $strOrgKey == $strUseKey) :
					$aryDataNew[]	= $orgData;
					$strWrite		= "OK";
					$orgData		= "OK";
					break;					
				endif;
			endforeach;
			if($strWrite != "OK") :
				$aryDataNew[] = $useData;
			endif;
		endforeach;

		foreach($aryFileOrg as $fileData) :
			if($fileData != "OK") :
				$aryDataNew[] = $fileData;
			endif;
		endforeach;
			
		/* 파일 생성 */
		$file = fopen ( $shopConfigFileUse, "w" );
		if ( !$file ) { return -1; }
		foreach($aryDataNew as $data) :
			if(strlen($data) <= 2) { continue; }
			if(substr_count($data, "{__") >= 1) { continue; }
			if(substr_count($data,"\n") == 0) { $data = $data . "\r\n"; }
			fputs($file, $data);	
		endforeach;
		fclose($file);
		@chmod( $filePath , 0707 );
		/* 파일 생성 */
	endif;

}



