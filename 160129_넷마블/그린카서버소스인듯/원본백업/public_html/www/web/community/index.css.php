<?
	include MALL_HOME . "/web/app/setStyle/setStyle.php";

	## STEP 1.
	## 공통 CSS 파일 모음
	$aryCommonCssFile[] = "/common/css/top/topArea.{$S_DESIGN_LAYOUT}.css";
	$aryCommonCssFile[] = "/common/css/bottom/bottom.{$S_DESIGN_LAYOUT}.css";
	$aryCommonCssFile[] = "/common/css/layout/layout.{$S_DESIGN_LAYOUT}.css";



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
<?if($aryCss):
  foreach($aryCss as $key => $data):?>
	<link rel="stylesheet" type="text/css" href="<?=$data?>" />	
<?endforeach;
  endif;?>
<link rel="stylesheet" type="text/css" href="/layout/css/<?=$S_SHOP_HOME?>_style.css"/>
<link rel="stylesheet" type="text/css" href="/layout/css/style_<?=$S_SITE_LNG_PATH?>.css"/>
<link rel="stylesheet" type="text/css" href="/layout/css/layout_style.css"/>

