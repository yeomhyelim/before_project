<div id="topArea" class="topArea">
	<div id="topWrap">
		<div class="glbArea">
			<div class="btnBox">
				<a href="#" class="btnBookmark">즐겨찾기</a>
				<a href="#" class="btnCart">장바구니</a>
				<a href="#" class="btnMy">마이페이지</a>
			</div>

			<div class="glbWrap">{{__글로벌메뉴2__}}</div>
			<div class="clr"></div>
		</div>

		<div class="logoWrap">
			<h1>{{__쇼핑몰로고__}}</h1>
			<div class="topSearchBox">
				{{__상품검색2__}}
				<a href="javascript:void(0);" eum-toggle="cateAllView" class="btnAllCate">카테고리</a>
				<div id="cateAllView" class="cateAllViewBox" style="display:none;">
					<div class="topTop"></div>
					<!--?name=상품카테고리메뉴1&mode=productCateMenu&display=YYNN&event=NNNN-->
				</div>
			</div>
			<div class="clr"></div>
		</div>

		<div class="topNaviWrap">
			<!--?name=상품카테고리메뉴&mode=productCateMenu&display=YNNN&event=NNNN-->
		</div>
	</div>	
</div>

<script>
$(document).ready(function () { 
	var top = $('#topArea').offset().top - parseFloat($('#topArea').css('marginTop').replace(/auto/, 0));
	$(window).scroll(function (event) {
		var y = $(this).scrollTop();
		if (y >= top) {
			$('#topArea').addClass('fixed');
		} else {
			$('#topArea').removeClass('fixed');
		}
	});
});
</script>