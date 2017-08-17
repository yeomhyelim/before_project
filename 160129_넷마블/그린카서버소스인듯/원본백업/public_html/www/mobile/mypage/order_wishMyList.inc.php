<?php
	/**
	 * eumshop - mobile - mypage - wishMyList
	 *
	 * 담아둔 목록 리스트
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/mobile/mypage/order_wishMyList.inc.php
	 * @manual		
	 * @history
	 *				2014.06.16 kim hee sung - 소스 정리
	 */

	## 기본 설정
	$intMemberNo = $g_member_no;

	## 체크
	if(!$intMemberNo):
		echo "로그인이 필요합니다.";
		return;
	endif;

	## 전체 주문개수
	## 주문 취소 개수는 포함되어 있지 않습니다.
	$strWishTotal = $intWishTotal;
	$strWishTotal = number_format($strWishTotal);

	## 페이지 제목 설정
	$strPageTitle = $LNG_TRANS_CHAR["CW00005"]; //담아둔 상품

?>

<h2><?php echo $strPageTitle;?>(<?php echo $strWishTotal;?>)</h2>
<div class="myOrderListWrap myOrderListBodyWrap">
	<!--<div class="txtInf"><?php echo $LNG_TRANS_CHAR["OS00003"]; //지금바로 주문하지 않을 상품을 옮겨놓거나 담아두실 수 있습니다.?></div>-->
	<?php if(!$intWishTotal):?>
	<?php echo $LNG_TRANS_CHAR["OS00004"]; //WISH 리스트에 담긴 상품이 없습니다.?>
	<?php else:?>
	<?php while($row = mysql_fetch_array($wishResult)):
			
			## 기본 설정
			$intPW_NO = $row['PW_NO'];
			$strP_CODE = $row['P_CODE'];
			$strP_NAME = $row['P_NAME'];
			$strPM_REAL_NAME = $row['PM_REAL_NAME'];
			$strP_EVENT_UNIT = $row['P_EVENT_UNIT'];
			$strP_EVENT = $row['P_EVENT'];
			$intPW_PRICE =$row['PW_PRICE'];
			$intPW_ADD_OPT_PRICE = $row['PW_ADD_OPT_PRICE'];
			$intPW_QTY = $row['PW_QTY'];

			## 이벤트 텍스트 설정
			$strProdEventText = "";		
			if($strP_EVENT_UNIT && $strP_EVENT):
				if($cartRow['P_EVENT_UNIT'] == "%"):
					$strProdEventText = callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow['P_EVENT'],"%"));
					$strProdEventText = "({$strProdEventText})";
				else:
					$strProdEventText = callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow['P_EVENT'],""));
					$strProdEventText = "({$S_SITE_CUR} {$strProdEventText})";
				endif;
			endif;

			## 옵션 설정
			$strCartOptAttrVal = "";
			for($i=1;$i<=10;$i++):
				$strPW_OPT_ATTR = $row["PW_OPT_ATTR{$i}"];
				if(!$strPW_OPT_ATTR) { continue; }
				if($strCartOptAttrVal) { $strCartOptAttrVal .= "/"; }
				$strCartOptAttrVal .= $strPW_OPT_ATTR;
			endfor;

			## 추가 옵션 설정
			$productMgr->setPW_NO($intPW_NO);
			$aryProdCartAddOptList = $productMgr->getProdBasketAddList($db);

			## 상품 가격 설정
			$strPrice = "";
			$strPrice = getCurToPrice($intPW_PRICE);
			$strPrice = getCurMark() . " " . $strPrice . getCurMark2();

			## 미국 달러 설정
			$strPriceUsd = "";
			if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"):
				$strPriceUsd = getCurToPrice($intPW_PRICE,"US");
				$strPriceUsd = getCurMark("USD") . " " . $strPriceUsd . getCurMark2("USD");

				$strPrice = "{$strPriceUsd} ({$strPrice})";
			endif;

			## 추가 금액 설정
			$strAddPrice = "";
			if($intPW_ADD_OPT_PRICE > 0):
				$strAddPrice = getCurToPrice($intPW_ADD_OPT_PRICE);
				$strAddPrice = getCurMark() . " " . $strAddPrice . getCurMark2();
			endif;
	?>
	<div class="prodInfoWrap">
		<div class="prodInfo">
			<!-- 상품명 //-->
			<div class="prodTit"><a href="./?menuType=product&mode=view&prodCode=<?php echo $strP_CODE;?>"><?php echo $strP_NAME;?><?php echo $strProdEventText;?></a></div>
			
			<!-- 상품명 //-->
			<div class="prodInfoBox">
				<div class="prodListImg"><img src="<?php echo $strPM_REAL_NAME;?>"/></div>
				<div class="detailProdInfo">
					<ul>						
						<!--<li><span class="tit">원산지</span>대한민국</li>-->
						<!-- 상품 옵션 //-->
						<!--<li><?php echo $strCartOptAttrVal;?></li>-->
						<!-- 상품 옵션 //-->
						<!-- 상품 추가 옵션 //-->
						<?php if($aryProdCartAddOptList && is_array($aryProdCartAddOptList)):?>
						<?php foreach($aryProdCartAddOptList as $key => $data):?>
						<li><?php echo $LNG_TRANS_CHAR["OW00006"]; //추가선택?> : <?php echo $data['PBA_OPT_NM'];?></li>
						<?php endforeach;?>
						<?php endif;?>
						<!-- 상품 추가 옵션 //-->
						<!-- 상품 가격 //-->
						<li class="prodPrice"><span class="tit"><?= $LNG_TRANS_CHAR["PW00081"]; //가격 ?></span><?= $strPrice;?></li>
						<!-- 옵션 -->
						<li><span class="tit">Packing</span> <?= $strCartOptAttrVal; ?></li>
						<!-- 상품 가격 //-->
						<!-- 상품 추가 금액 //-->
						<?php if($strAddPrice):?>
						<li class="addPrice"><?php echo $LNG_TRANS_CHAR["OW00007"]; //추가금액?>:<?php echo $strAddPrice;?></li>
						<?php endif;?>
						<!-- 상품 추가 금액 //-->
						<!-- 상품 수량 //-->
						<li class="cartCntForm">
							<span class="tit"><?= $LNG_TRANS_CHAR["PW00019"]; //구매수량 ?></span>
							<a href="javascript:goQtyUpMinus('wish',-1, <?php echo $intPW_NO;?>);" class="btnCntUp"><span>▼</span></a>							
							<input type="text" id="wishQty<?php echo $intPW_NO;?>" name="wishQty<?php echo $intPW_NO;?>" value="<?php echo $intPW_QTY;?>" class="cartCntForm"/><a href="javascript:goQtyUpMinus('wish', 1, <?php echo $intPW_NO;?>);" class="btnCntUp"><span>▲</span></a>
							<a href="javascript:goQtyUpdate('wish', <?php echo $intPW_NO;?>);" class="btn_cnt_modify"><?php echo $LNG_TRANS_CHAR["OW00072"]; //수정?></a>
						</li>
						<!-- 상품 수량 //-->
					</ul>
				</div>
			</div>
			<div class="clr"></div>
			<div class="conditionBtn">
				<input type="checkbox" id="wishNo[]" name="wishNo[]" value="<?php echo $intPW_NO;?>"/>
				<a href="javascript:goBasket(<?php echo $intPW_NO;?>);"><?php echo $LNG_TRANS_CHAR["OW00090"]; //장바구니?></a>
				<a href="javascript:goWishDel(<?php echo $intPW_NO;?>);"><?php echo $LNG_TRANS_CHAR["CW00036"]; //삭제?></a>
			</div>
		</div>
	</div>
	<?php endwhile;?>
	<div id="pagenate">
		<?=drawUserPaging($intWishPage,$intPageLine,$intPageBlock,$intWishTotal,$intWishTotPage,$linkWishPage,"","","",""," | ")?>
	</div>
	<?php endif;?>
</div>