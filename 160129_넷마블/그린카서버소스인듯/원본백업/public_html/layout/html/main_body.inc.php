<?
  $EUMSHOP_APP_INFO = "";
  $EUMSHOP_APP_INFO['name'] = "레이어팝업";
  $EUMSHOP_APP_INFO['mode'] = "popup";
  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
?>

<div class="mainContentList">
	<div class="mainBannerArea">
		<div class="mainBannerWrap">
			<?
			  $EUMSHOP_APP_INFO = "";
			  $EUMSHOP_APP_INFO['name'] = "메인슬라이더";
			  $EUMSHOP_APP_INFO['mode'] = "bannerSlider";
			  $EUMSHOP_APP_INFO['skin'] = "fullImageSkin";
			  $EUMSHOP_APP_INFO['code'] = "MAIN_BANNER";
			  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
			?>
		</div>
	</div>

	<div class="mainBannerListArea">
		<div class="mainBannerListWrap"><? include sprintf ( "%s%s/layout/banner/%s/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, "banner_1.html.php" ); ?></div>
	</div>

	<div class="mainBestWrap">
		<div class="bestProdListWrap">
			<h3 class="icoTit">BEST <span>PRODUCT</span></h3>
			<? $no = 1; include sprintf ( "%swww/web/product/include/bestList.index.inc.php", $S_DOCUMENT_ROOT ); ?>
		</div>

		<div class="bestProdListWrap">
			<h3 class="icoTit">BEST <span>COMPANY</span></h3>
			<? $no = 1; include sprintf ( "%swww/web/shop/bestList.index.inc.php", $S_DOCUMENT_ROOT ); ?> 
		</div>
	</div>

	<div class="bottomBannerArea">
		<div class="bottomBannerWrap"><? include sprintf ( "%s%s/layout/banner/%s/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, "banner_4.html.php" ); ?></div>
	</div>
</div>
<script>
/** 이미지 변경 시작 //변경할이미지의 아래있어야 실행됨 */
var imgChangeTime = '';
$(document).ready(function () { 
	timeCheck();
});
function timeCheck(){
	//imgChangeTime = setInterval(function() { imgTimeChange() }, 8000);
}
//이미지숫자패턴
function imgPatternIndex(imgSrc){
	var imgUrl = imgSrc.split('.');
	var expImgUrllength = imgUrl.length;	
	var imgCnt	= expImgUrllength - 2;
	var imgNameLength = imgUrl[imgCnt].length;
	var imgIndex = imgUrl[imgCnt].substr(imgNameLength-1,1);
	return imgIndex;
}

//이미지자동변경
function imgTimeChange(){
	var imgSrcUrl1 = $(".mainBannerWrap .leftBannerBox").children("img");
	imgChange(imgSrcUrl1, 'fade');

	var imgSrcUrl2 = $(".mainBannerWrap .rightBannerBox").children().children().eq(0).children("img")
	imgChange(imgSrcUrl2 , '');

	var imgSrcUrl3 = $(".mainBannerWrap .rightBannerBox").children().children().eq(1).children("img")
	imgChange(imgSrcUrl3 , '');

	var imgSrcUrl4 = $(".mainBannerWrap .rightBannerBox").children().children().eq(2).children("img")
	imgChange(imgSrcUrl4 , '');
}

//이미지변경
function imgChange(url,fade){
	var maxCnt = 4;	
	var imgSrcUrl = url.attr("src");
	var orignIndex = imgPatternIndex(imgSrcUrl);
	var changeImgIndex = parseInt(orignIndex) + 1;
	if(changeImgIndex > maxCnt) changeImgIndex = 1;
	
	var changeImg = imgSrcUrl.replace(orignIndex,changeImgIndex);
	
	
//$(url).fadeout(5);
	if(fade=='fade'){
	$(url).fadeOut(500,function(){
		$(url).attr({"src":changeImg}).fadeIn(500);
	//$(url).attr({"src":changeImg}).fadein(500);
	});
	}else{
		$(url).attr({"src":changeImg}).fadeIn(500);
	}
}	

//메인이미지클릭시
function mainTabImgChange(intEq)
{
	clearInterval(imgChangeTime);
	timeCheck();

	var img = $(".mainBannerWrap .rightBannerBox").children().children().eq(intEq).children("img");
	var leftImgTab = $(".mainBannerWrap .leftBannerBox").children("img").attr("src");
	
	var leftImgIndex = imgPatternIndex(leftImgTab);

	var imgSrc = $(img).attr("src");

	var rightImgIndex = imgPatternIndex(imgSrc);

	var imgSrcChange = imgSrc.replace(rightImgIndex,leftImgIndex);
	var leftImgSrcChange = leftImgTab.replace(leftImgIndex,rightImgIndex);

	
	$(img).attr({"src":imgSrcChange});

	var leftImg = $(".mainBannerWrap .leftBannerBox").children();

	$(leftImg).fadeOut(500,function(){
		$(".mainBannerWrap .leftBannerBox").children().attr({"src":leftImgSrcChange}).fadeIn(500);
	});
}
/** 이미지 변경 끝 //변경할이미지의 아래있어야 실행됨 */
</script>