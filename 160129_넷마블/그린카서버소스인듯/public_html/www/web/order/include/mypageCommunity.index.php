<?
	## STEP 1.
	## BOARD_INFO 정보
	$boardInfo = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.{$_REQUEST['b_code']}.info.php";
	if(!is_file($boardInfo)) { echo "설정 파일이 없습니다.", exit; } 
	require_once $boardInfo;
	if(!$strMode) { $strMode = $BOARD_INFO[$_REQUEST['b_code']]['bi_start_mode']; } /* 첫 페이지 설정 */
	$_REQUEST['BOARD_INFO']	 = $BOARD_INFO[$_REQUEST['b_code']]; 

	## STEP 2.
	## 기본 설정 정보 등록
	$_REQUEST['S_DOCUMENT_ROOT']		= $S_DOCUMENT_ROOT;
	$_REQUEST['S_SHOP_HOME']			= $S_SHOP_HOME;

	## STEP 3.
	## view class 설정
	require_once MALL_HOME . "/modules/community/mypage/basic.1.0/community.mypage.view.php";

	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.view.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.view.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.view.php";

	## STEP 4.
	## MODE 별 수행
	$strMode1 = $_REQUEST['mode1'];
	switch($strMode1):
	case "dataList":
		$dataView = new CommunityMypageView($db, $_REQUEST);
		$dataView->getListProcess();
	break;
	case "dataView":
			$dataView						= new CommunityMypageView($db, $_REQUEST);
			$dataSelectRow					= $dataView->getView();

			
	break;
	case "dataModify":
		$dataView = new CommunityMypageView($db, $_REQUEST);
//		$dataView->getModifyProcess();
	break;
	case "dataWrite":
		$dataView = new CommunityMypageView($db, $_REQUEST);
//		$dataView->getWriteProcess();
	break;
	endswitch;
?>

<script language="javascript" type="text/javascript" src="/common/js/mypage/community.js"></script>

<? include "{$S_DOCUMENT_ROOT}www/web/order/layout/mypage/qna.1.0/{$strMode1}.layout.php";?>