<?
	# 메인 이미지 배너 스킨
	# mainbanner.motion.effect2.skin.html.php
//	include "mainbanner.motion.skin.js.php";
?>

<style>
.sample_bn{position:relative;z-index:10;left:50%;top:0px;width:<?=$sliderWidth*3?>px; height:<?=$sliderHeight?>px;margin-left:-1435px;}
.sample_bn span.prevBtn{position:absolute;z-index:20;left:866px;top:240px;display:block;width:46px; height:90px;}
.sample_bn span.nextBtn{position:absolute;z-index:20;right:864px;top:230px;display:block;width:55px; height:95px;}
.sample_bn div{position:relative; overflow:hidden; float:left; width:<?=$sliderWidth*3?>px; height:<?=$sliderHeight?>px;}
.sample_bn div ul{position:absolute; left:0px; top:0px; width:20000px; height:<?=$sliderHeight?>px;}
.sample_bn div ul li{float:left; width:<?=$sliderWidth?>px; height:<?=$sliderHeight?>px;}

.sample_bn div.whiteBgL{position:absolute;z-index:11;top:0;left:0;width:900px;height:600px;background:url(../img/bg_white.png) repeat;}
.sample_bn div.whiteBgR{position:absolute;z-index:11;top:0;right:0;width:900px;height:600px;background:url(../img/bg_white.png) repeat;}
</style>


<script type="text/javascript">

var sample_bn_speed = 300; //움직임 속도
var sample_bn_click = 0; //광클릭 방지
var current_page = -1;
function sample_bn_AC(page){
	var obj = jQuery(".sample_bn"); //해당 object 변수
	var after_bt = obj.find(">span").eq(0); //다음버튼 변수
	var before_bt = obj.find(">span").eq(1); //이전버튼 변수
	current_page = page;
	after_bt.click(sample_bn_after);//다음 버튼 클릭시 sample_bn_after펑션 호출
	before_bt.click(sample_bn_before);//이전 버튼 클릭시 sample_bn_before펑션 호출
	obj.find("img").eq(0).css({'opacity':'0.2'});
	obj.find("img").eq(1).css({'opacity':'1'});
	obj.find("img").eq(2).css({'opacity':'0.2'});

}

function sleep(time) {
     var now = new Date();
     var exitTime = now.getTime() + time;

     while (true) {
          now = new Date();
          if (now.getTime() > exitTime)
              return;
     }
}
//다음 버튼 호출
function sample_bn_after(){
	if(sample_bn_click == 0){
		sample_bn_click = 1;//배너의 움직임이 지속되는동안은 클릭시 중첩되지 않게 된다.
		var move_obj = jQuery(".sample_bn > div > ul"); //움직일 객체 변수
		var move_obj_width = (move_obj.find(">li").width() * -1); //움직일 컨텐츠의 넓이값 저장 (다음버튼클릭시 화면은 왼쪽으로 움직이기 위해 음수값을 만든다)
		move_obj.find(">li").eq(0).clone().appendTo(move_obj);//움직일 객체변수의 자식중 li의 0번째 녀석을 clone(복사)하여 appendTo(위치) 위치에 해당하는 곳의 배열중 마지막배열로 삽입한다.
		move_obj.animate(
			{left:move_obj_width}
			,sample_bn_speed
			,function(){
				//해당 펑션은 animate가 작동이 끝난뒤 처리된다.
				//이곳에 오기전까지의 데이터는 1번째을 복사하여 마지막 배열에 추가하였다.
				move_obj.find(">li").eq(0).remove();//remove함수를 사용하여 1번째 배열을 삭제한다.
				move_obj.css("left","0");//left값을 0으로 초기화시킨다. (1번째 배열을 삭제하였기때문에 그공간을 빼준 값이다.)
				//이곳까지 오게 되면 소스상의 데이터는 초기 : 1,2,3 에서 2,3,1로 변경 되어있다.
				//클릭시 마다 적용되며 클릭시마다 배열이 새롭게 변경된다.(무한반복)
				sample_bn_click = 0;//움직임이 끝났고 다음 클릭을 대비하여 값을 초기화한다.
				
			}
		);//move_obj의 left를 저장해놓았던 넓이값만큼 미리정해놓은 속도로 이동시킨다.
		move_obj.find("img").eq(0).css({'opacity':'0.2'});
		move_obj.find("img").eq(1).css({'opacity':'0.2'});
		move_obj.find("img").eq(2).css({'opacity':'1'});
	
	}
}
//이전 버튼 호출
function sample_bn_before(){
	if(sample_bn_click == 0){
		sample_bn_click = 1;//배너의 움직임이 지속되는동안은 클릭시 중첩되지 않게 된다.
		var move_obj = jQuery(".sample_bn > div > ul"); //움직일 객체 변수
		var move_obj_width = (move_obj.find(">li").width() * -1); //움직일 컨텐츠의 넓이값 저장 (다음버튼클릭시 화면은 왼쪽으로 움직이기 위해 음수값을 만든다)
		move_obj.find(">li:last").clone().prependTo(move_obj);//움직일 객체변수의 자식중 li의 마지막 녀석을 clone(복사)하여 prependTo(위치) 위치에 해당하는 곳의 배열중 첫번째배열로 삽입한다.
		move_obj.css("left",move_obj_width+"px");//left값을 객체 하나만큼의 값만큼 -시킨다. (마지막 배열을 가져와 첫번째에 넣었기때문에 그만큼의 값을 -시킨것이다.)

		move_obj.animate(
			{left:0}
			,sample_bn_speed
			,function(){
				//해당 펑션은 animate가 작동이 끝난뒤 처리된다.
				//이곳에 오기전까지의 데이터는 마지막을 복사하여 첫번째 배열에 추가하였다.
				move_obj.find(">li:last").remove();//remove함수를 사용하여 마지막 배열을 삭제한다.
				//이곳까지 오게 되면 소스상의 데이터는 초기 : 1,2,3 에서 3,1,2로 변경 되어있다.
				//클릭시 마다 적용되며 클릭시마다 배열이 새롭게 변경된다.(무한반복)
				sample_bn_click = 0;//움직임이 끝났고 다음 클릭을 대비하여 값을 초기화한다.
				
			}
		);//move_obj의 left를 저장해놓았던 넓이값만큼 미리정해놓은 속도로 이동시킨다.
		move_obj.find("img").eq(0).css({'opacity':'0.2'});
		move_obj.find("img").eq(1).css({'opacity':'1'});
		move_obj.find("img").eq(2).css({'opacity':'0.2'});

	}
}
$(document).ready(function(){
	var windHeight = $(window).height();
	var scrollTop = $(window).scrollTop();
	$('.signInLayer').css('top',scrollTop+(windHeight/2)-196+'px');
	$(window).scroll(function(){
		var windHeight = $(window).height();
		var scrollTop = $(window).scrollTop();
		$('.signInLayer').stop().animate({'top':scrollTop+(windHeight/2)-196+'px'},1000);
	});
	$(window).resize(function(){
		var windHeight = $(window).height();
		var scrollTop = $(window).scrollTop();
		$('.signInLayer').css('top',scrollTop+(windHeight/2)-196+'px');
	});
	$('.btnSign').click(function(){
		$('.darkBg,.signInLayer').show();
		return false;
	});
	$('.closeBtn').click(function(){
		$('.darkBg,.signInLayer').hide();
		return false;
	});
});

</script>

<div class="sample_bn">
	<div>
		<ul>
		<!-- 해당샵의 등록된 이미지 -->
			<?	$intCnt=1;
				foreach($img as $fileName) :    ?>

			<li><img src="../upload/slider/<?=$fileName?>" alt="<?=$intCnt++?>" style="width:<?=$sliderWidth?>px;height:<?=$sliderHeight?>px;"/></li>

			<?	endforeach; ?>
		<!-- 해당샵의 등록된 이미지 -->
		</ul>
	</div>
	<span class="prevBtn"><a href="#link"><img src="/himg/product/A0001/btn_img_prev.png" alt="다음" /></a></span>
	<span class="nextBtn"><a href="#link"><img src="/himg/product/A0001/btn_img_next.png" alt="이전" /></a></span>
	<div class="whiteBgL png_bg"></div>
	<div class="whiteBgR png_bg"></div>
</div>


<script type="text/javascript">
	sample_bn_AC(1);
</script>
