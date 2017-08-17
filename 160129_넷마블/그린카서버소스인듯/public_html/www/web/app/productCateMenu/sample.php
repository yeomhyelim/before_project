
<script type="text/javascript">
//분류 팝업 설정
$(function() {
	$('.main_menu li').mouseenter(function() {
		var sub = $(this).attr('sub');
		var width = $(this).width();
		var temp = parseInt(width/2, 10);

	    //표시영역 좌표 구하기
	    //var top = $(this).offset().top;
	    //var left = $(this).offset().left;
	    var top = $(this).position().top;
	    var left = $(this).position().left;

		$('.sub'+sub).css('top', (top+20)+'px');
		$('.sub'+sub).css('left', (left-65+temp)+'px');

		$('.sub_menu').hide();
		//$('.sub'+sub).show();
		$('.sub'+sub).fadeIn();
	});

	$('#wrap_top').mouseleave(function(e) {
		$('.sub_menu').hide();
	});

	$('.sub_menu').mouseenter(function(e) {
		e.stopPropagation();
	});

	$('.sub_menu').mouseleave(function(e) {
		e.stopPropagation();
		$(this).hide();
	});
});
</script>

<style type="text/css">





#wrap_top { position:relative; width:100%; height:284px; margin:0 auto; border:1px solid}


.main_menu { padding:0 0 0 164px;width:100%; }
.main_menu ul {list-style: none;margin:0;padding:22px 0 0 208px;}
.main_menu li {list-style: none;margin:0 22px 0 0;padding:0 26px 0 0;float:left;border:1px solid}
.main_menu .last {background: none;}
.sub_menu {position: absolute;top:0;left:0;z-index: 999;padding:21px 0 16px 0;}
.sub_menu .sub_menu_top {position: absolute;top:0;left:0;}
.sub_menu .sub_menu_bottom {position: absolute;bottom:0;left:0;}
.sub_menu ul {list-style: none;margin:0;padding:0;}
.sub_menu li {list-style: none;margin:0;padding:0;height:24px;}


</style>

<!-- 상단 (로고, 메뉴, 홈메뉴) 시작-->
<div id="wrap_index">

	<div id="wrap_top">

        <!-- 메뉴 시작 -->
        <div class="main_menu">
        	<ul>
        		<li sub="01">
					<a href="http://www.andersonenglish.co.kr/page/anderson01" class="rollover">
						<img class="png24" src="http://www.andersonenglish.co.kr/images/anderson/top_menu01.png">
						<img class="png24 over" src="http://www.andersonenglish.co.kr/images/anderson/top_menu01_ov.png">
					</a>
        		</li>
        		<li sub="02">
					<a href="/lecture/free/001" class="rollover">
						<img class="png24" src="http://www.andersonenglish.co.kr/images/anderson/top_menu02.png">
						<img class="png24 over" src="http://www.andersonenglish.co.kr/images/anderson/top_menu02_ov.png">
					</a>
        		</li>
        		<li sub="03">
					<a href="/lecture/teacher/001" class="rollover">
						<img class="png24" src="http://www.andersonenglish.co.kr/images/anderson/top_menu03.png">
						<img class="png24 over" src="http://www.andersonenglish.co.kr/images/anderson/top_menu03_ov.png">
					</a>
        		</li>
        		<li sub="04">
					<a href="/payment/insert01" class="rollover">
						<img class="png24" src="http://www.andersonenglish.co.kr/images/anderson/top_menu04.png">
						<img class="png24 over" src="http://www.andersonenglish.co.kr/images/anderson/top_menu04_ov.png">
					</a>
        		</li>
        		<li sub="05">
					<a href="/board/list/commu01?init" class="rollover">
						<img class="png24" src="http://www.andersonenglish.co.kr/images/anderson/top_menu05.png">
						<img class="png24 over" src="http://www.andersonenglish.co.kr/images/anderson/top_menu05_ov.png">
					</a>
        		</li>
        		<li sub="06" class="last">
					<a href="/mypage" class="rollover">
						<img class="png24" src="http://www.andersonenglish.co.kr/images/anderson/top_menu06.png">
						<img class="png24 over" src="http://www.andersonenglish.co.kr/images/anderson/top_menu06_ov.png">
					</a>
        		</li>
        	</ul>
        </div>
        <!-- 메뉴 종료 -->

		<div class="sub_menu sub01" style="display: none;">
			<div class="sub_menu_top"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_top.gif"/></div>
			<div class="sub_menu_bottom"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_bot.gif"/></div>
			<ul>
				<li>
					<a href="http://www.andersonenglish.co.kr/page/anderson01" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu01.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu01_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/board/list/anderson02?init" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu02.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu02_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="http://www.andersonenglish.co.kr/page/anderson03" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu03.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu03_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="http://www.andersonenglish.co.kr/page/anderson05" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu04.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu04_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="http://www.andersonenglish.co.kr/page/anderson06" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu05.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub01_menu05_ov.gif" class="over">
					</a>
				</li>
			</ul>
		</div>

		<div class="sub_menu sub02" style="display: none;">
			<div class="sub_menu_top"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_top.gif"/></div>
			<div class="sub_menu_bottom"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_bot.gif"/></div>
			<ul>
				<li>
					<a href="/lecture/free/001" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub02_menu01.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub02_menu01_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/lecture/free/002" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub02_menu02.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub02_menu02_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/lecture/free/004" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub02_menu03.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub02_menu03_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/lecture/free/005" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub02_menu04.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub02_menu04_ov.gif" class="over">
					</a>
				</li>
			</ul>
		</div>

		<div class="sub_menu sub03" style="display: none;">
			<div class="sub_menu_top"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_top.gif"/></div>
			<div class="sub_menu_bottom"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_bot.gif"/></div>
			<ul>
				<li>
					<a href="/lecture/teacher/001" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu01.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu01_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/lecture/teacher/002" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu02.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu02_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/lecture/teacher/004" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu04.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu04_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/lecture/teacher/005" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu05.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu05_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="http://www.andersonenglish.co.kr/page/teach04" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu03.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub03_menu03_ov.gif" class="over">
					</a>
				</li>
			</ul>
		</div>

		<div class="sub_menu sub04" style="display: none;">
			<div class="sub_menu_top"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_top.gif"/></div>
			<div class="sub_menu_bottom"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_bot.gif"/></div>
			<ul>
				<li>
					<a href="/payment/insert01" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub04_menu01.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub04_menu01_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/mypage" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub04_menu02.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub04_menu02_ov.gif" class="over">
					</a>
				</li>
			</ul>
		</div>

		<div class="sub_menu sub05" style="display: none;">
			<div class="sub_menu_top"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_top.gif"/></div>
			<div class="sub_menu_bottom"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_bot.gif"/></div>
			<ul>
				<li>
					<a href="/board/list/commu01?init" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu01.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu01_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/qna/list?init" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu02.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu02_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/board/list/commu03?init" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu03.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu03_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/board/list/commu04?init" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu04.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu04_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/board/list/commu05?init" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu05.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub05_menu05_ov.gif" class="over">
					</a>
				</li>
			</ul>
		</div>

		<div class="sub_menu sub06" style="display: none;">
			<div class="sub_menu_top"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_top.gif"/></div>
			<div class="sub_menu_bottom"><img src="http://www.andersonenglish.co.kr/images/anderson/top_sub_img_bot.gif"/></div>
			<ul>
				<li>
					<a href="/mypage" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub06_menu01.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub06_menu01_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/mypage/qna" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub06_menu02.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub06_menu02_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/mypage/payment" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub06_menu03.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub06_menu03_ov.gif" class="over">
					</a>
				</li>
				<li>
					<a href="/member/update" class="rollover">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub06_menu04.gif">
						<img src="http://www.andersonenglish.co.kr/images/anderson/top_sub06_menu04_ov.gif" class="over">
					</a>
				</li>
			</ul>
		</div>

    </div>

</div>
<!-- 상단 (로고, 메뉴, 홈메뉴) 종료-->














</body>
</html>

