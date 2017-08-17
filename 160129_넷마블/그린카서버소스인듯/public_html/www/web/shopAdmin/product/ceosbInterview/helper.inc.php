<?
	## 종류
	$aryKind[1]				= "감성 인터뷰 칼럼";
	$aryKind[2]				= "강일홍의 연예가 클로즈업";
	$aryKind[3]				= "아름다운 사람들의 스토리";

	## 모드별 수행
	switch($strMode):
	case "ceosbInterviewList":
		// ceosb 인터뷰 컬럼 리스트

		## 모듈 설정
		require_once MALL_HOME . "/module2/CeosbInterviewColumn.module.php";
		$ceosbInterviewColumn			= new CeosbInterviewColumnModule($db);

		## 기본 설정
		$intPage						= $_GET["page"];

		## 그룹 리스트
		$param							= "";
		$intTotal						= $ceosbInterviewColumn->getCeosbInterviewColumnSelectEx("OP_COUNT", $param);				// 데이터 전체 개수 
		$intPageLine					= 10;																						// 리스트 개수 
		$intPage						= ( $intPage )				? $intPage		: 1;
		$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

		$param['LIMIT']					= "{$intFirst},{$intPageLine}";
		$ceosbInterviewColumnResult		= $ceosbInterviewColumn->getCeosbInterviewColumnSelectEx("OP_LIST", $param);

		$intPageBlock					= 10;																						// 블럭 개수 
		$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );											// 번호
		$intTotPage						= ceil( $intTotal / $intPageLine );	

		## 페이징 링크 주소
		$queryString	= explode("&", $_SERVER['QUERY_STRING']);
		$linkPage		= "";
		foreach($queryString as $string):
			list($key,$val)		= explode("=", $string);
			if($key == "page")	{ continue; }
			if($linkPage)		{ $linkPage .= "&"; }
			$linkPage		   .= $string;
		endforeach;

		$linkPage		= "./?{$linkPage}&page=";
//		echo $linkPage;
	break;

	case "ceosbInterviewModify":
		// ceosb 인터뷰 컬럼 수정
	case "ceosbInterviewView":
		// ceosb 인터뷰 컬럼 보기

		## 모듈 설정
		require_once MALL_HOME . "/module2/CeosbInterviewColumn.module.php";
		$ceosbInterviewColumn			= new CeosbInterviewColumnModule($db);
		
		## 기본 설정
		$strICCode						= $_GET['icCode'];

		## 기본 설정 체크
		if(!$strICCode):
			echo "내용이 없습니다.";
			exit;
		endif;

		## 내용 가져오기
		$param							= "";
		$param['IC_CODE']				= $strICCode;
		$ceosbInterviewColumnRow		= $ceosbInterviewColumn->getCeosbInterviewColumnSelectEx("OP_SELECT", $param);	
		
		## 내용 체크
		if(!$ceosbInterviewColumnRow):
			echo "내용이 없습니다.";
			exit;
		endif;

		## 내용 설정
		$strTitle			= $ceosbInterviewColumnRow['IC_TITLE'];
		$strSummary			= $ceosbInterviewColumnRow['IC_SUMMARY'];
		$strPreview			= $ceosbInterviewColumnRow['IC_PREVIEW'];
		$strText			= $ceosbInterviewColumnRow['IC_TEXT'];
		$strKeyword			= $ceosbInterviewColumnRow['IC_KEYWORD'];
		$strImage1			= $ceosbInterviewColumnRow['IC_IMAGE1'];
		$strImage2			= $ceosbInterviewColumnRow['IC_IMAGE2'];
		$strUse				= $ceosbInterviewColumnRow['IC_USE'];
		$intKind			= $ceosbInterviewColumnRow['IC_KIND'];

		## 종류 설정
		$strKind			= $aryKind[$intKind];

	break;

	endswitch;
