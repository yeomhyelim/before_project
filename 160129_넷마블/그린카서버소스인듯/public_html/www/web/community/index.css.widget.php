<?
	## STEP 1.
	## 공통 CSS 파일 모음
	$aryCommonCssFile = array ();


	## STEP 2.
	## 요청한 위젯 스킨별 CSS 설정
	switch($_REQUEST['BOARD_INFO']['bi_widget_skin']) :
		
		case "review":
			// 리뷰
		case "qna":
			// qna
			$aryCssFile = array ( "/common/css/community/community.{$_REQUEST['BOARD_INFO']['b_css']}.css" );
		break;

	endswitch;
?>

<? foreach($aryCommonCssFile as $file): ?>
<link rel="stylesheet" type="text/css" href="<?=$file?>"/>
<? endforeach; ?>
<? foreach($aryCssFile as $file): ?>
<link rel="stylesheet" type="text/css" href="<?=$file?>"/>
<? endforeach; ?>
