<?php

	## 모듈 설정
	require_once MALL_HOME . "/module/ShopOrderMgr.php";
	require_once MALL_HOME . "/module2/BoardData.module.php";
	$boardData				= new BoardDataModule($db);
	$shopOrderMgr			= new ShopOrderMgr();

	## 기본 설정
	$intONo							= $_GET['oNo'];
	$intUbNo						= $_GET['ub_no'];
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
	if(!$intUbNo):
		echo "수정할 내용이 없습니다.";
		exit;
	endif;

	## 메모 데이터 불러오기
	$param					= "";
	$param['UB_NO']			= $intUbNo;
	$param['B_CODE']		= $bCode;
	$param['BOARD_AD_JOIN']	= "Y";
	$boardDataRow			= $boardData->getBoardDataSelectEx("OP_SELECT", $param);

	## 메모 데이터 설정
	$strUbPCode				= $boardDataRow['UB_P_CODE'];
	$strUbText				= $boardDataRow['UB_TEXT'];

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
			<input type="hidden" name="act"		 value="orderMemoModify">
			<input type="hidden" name="ub_no"	 value="<?=$intUbNo?>">
			<table>
				<tbody>
					<tr>
						<th>상품선택</th>
						<td><select name="ub_p_code">
								<option value="">전체상품</option>
								<?foreach($orderCartArray as $key => $data):  
									$strPCode		= $data['P_CODE'];	
									$strPName		= $data['P_NAME'];		?>
								<option value="<?=$strPCode?>"<?if($strUbPCode==$strPCode){echo " selected";}?>><?=$strPName?></option>
								<?endforeach;?>
							</select>
						</td>
					<tr>
						<th>내용</th>
						<td><textarea name="ub_text" id="ub_text"  title="higheditor_full" style="width:100%;height:300px"><?=$strUbText?></textarea></td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>

		<div style="margin:10px 10px 0 10px">

			<div class="btnCenter">
				<a class="btn_big" href="javascript:goOrderMemoModifyActEvent();"><strong>수정</strong></a>
				<a class="btn_big" href="javascript:goOrderMemoListMoveEvent();"><strong>취소</strong></a>
			</div>

		</div>
	</div>


</body>

</html>