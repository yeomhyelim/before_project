<?
	require_once MALL_CONF_LIB."BoardMgr.php";
	
	$boardMgr		= new BoardMgr();

	$boardMgr->setB_CODE($MAIN_BOARD['CODE']);
	$aryBoardSet1		= $boardMgr->getBoardData($db);
	$intB_NO1			= $aryBoardSet1[0]['B_NO'];
	$boardMgr->setTable($intB_NO1);
	$intTotal1			= $boardMgr->getDataTotal($db);
	$boardMgr->setLimitFirst(0);
	$boardMgr->setPageLine($MAIN_BOARD['LINE']);
	$result1			= $boardMgr->getDataList($db);


	include "mainBoard.{$MAIN_BOARD['DESIGN']}.skin.html.php";
?>

