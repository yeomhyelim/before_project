<?
	## STEP 1.
	## 공통 CSS 파일 모음
	$aryCommonCssFile = array (	"/common/css/layout/layout.A0001.css");


	## STEP 2.
	## 요청한 모듈별, 액션별 JS 파일 실행
	switch($strMode) :
		
		case "dataView":
			// 커뮤니티 글 뷰
		case "dataWrite":
			// 커뮤니티 글 쓰기
		case "dataModify":
			// 커뮤니티 글 수정
		case "dataList":
			// 커뮤니티 글 리스트
		case "dataPassword":
			// 커뮤니티 글 비밀번호
		case "dataAnswer":
			// 커뮤니티 글 답변
			$aryCssFile = array ( "/common/css/community/community.{$_REQUEST['BOARD_INFO']['b_css']}.css" );
		break;
		case "attachedfileWrite":
			// 커뮤니티 글 첨부파일 쓰기
			$aryCssFile = array ( "/common/css/community/community.basicCss1.css" );
		break;

	endswitch;
?>

<? foreach($aryCommonCssFile as $file): ?>
<link rel="stylesheet" type="text/css" href="<?=$file?>"/>
<? endforeach; ?>
<? foreach($aryCssFile as $file): ?>
<link rel="stylesheet" type="text/css" href="<?=$file?>"/>
<? endforeach; ?>
