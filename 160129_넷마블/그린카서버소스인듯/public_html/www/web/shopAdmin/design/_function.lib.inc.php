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
 * @param string realName		: 서버에 업로든된 파일명
 */ 
function imageFileUpLoad($bufferName, $upLoadPath, &$realName) 
{
	global $fh;

	if ($_FILES[$bufferName][name]) :
		if(!getAllowImgFileExt($_FILES[$bufferName][name], "Y")) :
			goErrMsg("첨부하신 파일은 확장자가 금지된 파일입니다.");
			exit;
		endif;
		
		$filename 		= $_FILES[$bufferName][name];
		$tmpname  	= $_FILES[$bufferName][tmp_name];
		$filesize 		= $_FILES[$bufferName][size];
		$filetype 		= $_FILES[$bufferName][type];
		$number 		= date("YmdHis");
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
	global $S_DOCUMENT_ROOT, $S_SHOP_HOME;
	
	$designConfigFile		= sprintf( "%swww/config/design_conf.php", $S_DOCUMENT_ROOT );
	
	if ( !file_exists($designConfigFile)  ) :
		// 설정 파일이 없음.
		return;	
	endif;	

	include $shopConfigFile;
	include $designConfigFile;
	
	foreach ( $DESIGN_TAG as $tag => $str ) :
		$str				= sprintf( "<? %s ?>", $str );
		$data 			= str_replace($tag, $str , $data);

	endforeach;
	

	$outData 			= $data;
	
	return 1;
}


/**
 * SHOP_ID / conf / shop.inc.php 파일 수정 및 데이터 추가
 * @param array $aryData			=> 배열 데이터
 * 데이터 구조는
 * $aryData['key'] = "";				=> 검색할 키값
 * $aryData['data'] = "";			=> 저장할 데이터 값
 * $aryData['write'] = "";			=> 데이터를 사용한 경우 true , 사용하지 않는 경우 null
 */
function shopConfigFileUpdate ( $aryData )
{
	global $S_DOCUMENT_ROOT, $S_SHOP_HOME;
	
	$shopConfigFile 		= sprintf( "%s%s/conf/shop.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME );
	$aryNewData			= "<?\n";
	

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
					$data['write'] 		= "OK";
					$tempCheck 		= true;
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


?>






















