<div id="contentWrap" class="contentNBodyWrap">
	<div class="subNavWrap">
		<div class="navTit"><a href="#">전체카테고리</a></div>
	</div>
	<div class="viewContentWrap">
		<div class="prodTopAreaView">
			<h2><?= $LNG_TRANS_CHAR["PW00100"]; //주문 및 결제 ?></h2>
			<div class="locationWrap">
				<ul>
					<li class="home">H</li>
					<li class="end"><?= $LNG_TRANS_CHAR["PW00100"]; //주문 및 결제 ?></li>
				</ul>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>

		<div class="cartStep_2">
			<ul>
				<li class="step_1"><span><?= $LNG_TRANS_CHAR["PW00022"]; //장바구니 ?></span></li>
				<li class="step_2_on"><span><?= $LNG_TRANS_CHAR["PW00100"]; //주문 및 결제 ?></spen></li>
				<li class="step_3 endStep"><span><?= $LNG_TRANS_CHAR["PW00101"]; //주문완료 ?></spen></li>
			</ul>
		</div>

		<div class="orderFormWrap">
				<? include "{$S_DOCUMENT_ROOT}www/web/order/include/order_order.index.php"; ?>
			</div>
		</div>
	</div>
	<div class="clr"></div>
</div>