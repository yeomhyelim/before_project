<?
#/*====================================================================*/# 
#|화일명	: _function.lib.inc.php																		|#
#|작성자	: 김희성																					|#
#|작성일	: 2011.02.09																				|#
#|작성내용	: sendmail 공통 함수																		|#
#/*====================================================================*/# 




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
		$fileName = sprintf( "%s%s/conf/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $fileName );
	
		shopConfigFileUpdateEx($aryData, $fileName);
	}

	function shopConfigFileUpdateEx ( $aryData, $fileName )
	{
		global $S_DOCUMENT_ROOT, $S_SHOP_HOME;
		
		$shopConfigFile 	= $fileName;
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


	function shopInfoInsertUpdate(&$siteMgr,$aryData,$view = "Y")
	{
		global $db;
		
		if (is_array($aryData)){
			for ($i=0;$i<sizeof($aryData);$i++) :
				$data = &$aryData[$i];
				
				if ($data['column']){
					$siteMgr->setS_COL($data['column']);
					$siteMgr->setS_VAL($data['value']);
					$siteMgr->setS_VIEW($view);
					
					$siteMgr->getSiteInfoInsertUpdate($db);
				}
			endfor;
		}
	}
?>