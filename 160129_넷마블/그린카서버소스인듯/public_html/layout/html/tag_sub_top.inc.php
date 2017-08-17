<div id="topArea" class="topArea">
	<div class="glbArea">
		<div class="glbWrap">{{__글로벌메뉴2__}}</div>
	</div>
	<div class="topContainer">
		<div id="topWrap">
			<h1>{{__쇼핑몰로고__}}</h1>
			<div class="topSearchBox">
				{{__상품검색2__}}
				<a href="javascript:void(0);" eum-toggle="cateAllView" class="btnAllCate">카테고리</a>
				<div id="cateAllView" class="cateAllViewBox" style="display:none;"><div class="topTop"></div><!--?name=상품카테고리메뉴1&mode=productCateMenu&display=YYNN&event=NNNN--></div>
			</div>
			<div class="icoNavLeft">
				<a href="./?menuType=mypage&mode=wishMyList" class="btnWish"><img src="/upload/images/ico_glb_1.png"> <span>Wish</span></a>
				<a href="./?menuType=mypage&mode=cartMyList"><img src="/upload/images/ico_glb_2.png"> <span>Cart</span></a>
				<a href="./?menuType=mypage&mode=buyList"><img src="/upload/images/ico_glb_3.png"> <span>MyPage</span></a>
			</div>
			<div class="clr"></div>
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