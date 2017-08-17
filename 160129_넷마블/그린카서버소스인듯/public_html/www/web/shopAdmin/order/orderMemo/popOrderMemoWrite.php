<?php

	## 모듈 설정
	require_once MALL_HOME . "/module/ShopOrderMgr.php";
	require_once MALL_HOME . "/module2/BoardData.module.php";
	$boardData				= new BoardDataModule($db);
	$shopOrderMgr			= new ShopOrderMgr();

	## 기본 설정
	$intONo							= $_GET['oNo'];
	$bCode							= "USER_REPORT";
	$intShopNo						= $_SESSION['ADMIN_SHOP_NO'];	
	$intPage						= $_GET['page'];
	$intMemberNo					= $_GET['memberNo'];
	$searchField2					= $_GET['searchField2'];
	$searchKey2						= $_GET['searchKey2'];
	$searchRegStartDt				= $_GET['searchRegStartDt'];
	$searchRegEndDt					= $_GET['searchRegEndDt'];
	$searchResultState				= $_GET['searchResultState'];
	$strResultField					= "AD_TEMP2";
	$strResultFieldLower			= strtolower($strResultField);

	## 기본 설정 체크
	if(!$intONo	):
		echo "주문번호가 없습니다.";
		exit;
	endif;

	## 설정 파일 불러오기
	if($bCode && !$aryBoardInfo):
		include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.{$bCode}.info.php";
		$aryBoardInfo				= $BOARD_INFO[$bCode];
		if(!$aryBoardInfo):
			echo "설정 파일이 없습니다.";
			exit;
		endif;
	endif;

	## 주문 데이터 불러오기
	$param					= "";
	$param['o_no']			= $intONo;
	$shopOrderRow			= $shopOrderMgr->getOrderListEx($db, "OP_SELECT", $param);

	## 주문 데이터 설정
	$strOrderKey			= $shopOrderRow['O_KEY'];


	## 주문 상품 데이터 불러오기
	$param							= "";
	$param['o_no']					= $intONo;
	$param['p_shop_no']				= $intShopNo;
	$orderCartArray					= $shopOrderMgr->getOrderCartListEx($db, "OP_ARYTOTAL", $param);
	$orderCartCnt					= sizeof($orderCartArray);

	## header 설정
	include "./include/header.inc.php"

?>
	<div class="layerPopWrap">
		<div class="popTop" id="searchArea" style="position:relative">
			<h2>메모(주문번호: <?=$strOrderKey?>)</h2>		
		</div>
	</div>
	<br>
	<div id="contentArea" style="margin:0 10px 0 10px">
		<div class="tableForm">
			<form name="form" name="form" id="form">
			<input type="hidden" name="menuType" value="order">
			<input type="hidden" name="mode" 	 value="json">
			<input type="hidden" name="act"		 value="orderMemoWrite">
			<input type="hidden" name="oNo"		 value="<?=$intONo?>">
			<table>
				<tbody>
					<tr>
						<th>상품선택</th>
						<td><select name="ub_p_code">
								<option value="">전체상품</option>
								<?foreach($orderCartArray as $key => $data):  
									$srtPCode		= $data['P_CODE'];	
									$srtPName		= $data['P_NAME'];		?>
								<option value="<?=$srtPCode?>"<?if($orderCartCnt==1){echo " selected";}?>><?=$srtPName?></option>
								<?endforeach;?>
							</select>
						</td>
					<tr>
						<th>내용</th>
						<td><textarea name="ub_text" id="ub_text"  title="higheditor_full" style="width:100%;height:300px"></textarea></td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>

		<div style="margin:10px 10px 0 10px">

			<div class="btnCenter">
				<a class="btn_big" href="javascript:goOrderMemoWriteActEvent();"><strong>등록</strong></a>
				<a class="btn_big" href="javascript:goOrderMemoListMoveEvent();"><strong>취소</strong></a>
			</div>

		</div>
	</div>


</body>

</html>