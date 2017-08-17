<?
	## 상품평 리스트 불러오기
	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.view.php";
	$dataView														= new CommunityDataView($db,  $_REQUEST);
	$tableName														= "DataMgr";
	$param['b_code']												= "PROD_REVIEW";
	$param['product_mgr_use']										= "Y";
	$param['p_shop_no']												= $_REQUEST['sh_no'];
	$_REQUEST['result'][$tableName]['listResult']					= $dataView->getListEx("OP_LIST", $param);
	$_REQUEST['result'][$tableName]['pageResult']['list_total']		= $param['list_total'];
	$_REQUEST['result'][$tableName]['pageResult']['list_num']		= $param['list_num'];


	## 페이지 만들기
	$param['link']													= "";
	$_REQUEST['result'][$tableName]['pageResult']					= $dataView->getPageInfoEx($param);	

	## 설정 정보
	include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.PROD_REVIEW.info.php";
	$_REQUEST['BOARD_INFO']											= $BOARD_INFO['PROD_REVIEW'];
?>
<?include "top.inc.php"; ?>

	<!-- start: contentArea -->
	<div id="minishopContentArea">		
		<div id="minishopContentWrap">
			<div class="tableList">
				<? include "{$S_DOCUMENT_ROOT}www/skins/user/community/data/basic.1.0/list.skin.php" ?>
			</div>
			<div class="paginate">
				<? include "{$S_DOCUMENT_ROOT}www/skins/user/community/common/page.1.0/list.page.skin.php" ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<!-- end: contentArea -->