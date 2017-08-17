<link rel="stylesheet" href="./common/css/jquery.treeview.css" />
<script src="../common/js/jquery.cookie.js"></script>
<script src="../common/js/jquery.treeview.js"></script>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		goSkinSampleHtml('ZL0001');
//		$.getJSON("http://www.eumshop.com/api/json/shopDesign.json.php?act=getShopSkinListHtml&dm_code=<?=$layoutRow['DM_CODE']?>&callback=?", function(data) {
//			if (!C_isNull(data[0]["DESIGN_SKIN"]))
//			{
//				$("#skinList").html(data[0]["DESIGN_SKIN"]);
//				$("#skinList").treeview();
//				
//				var strFirstSubPageCode = $("#skinList li ul li a").eq(0);
//				var strFirstSubFunc = strFirstSubPageCode.attr("href").substr(11)+";";
//				alert(strFirstSubFunc);
//				eval(strFirstSubFunc);
//			}
//		});

		$("#menu_auth_m").bind("click", function() {
			var strSubPageCode = $("#subPageCode").val();
			$.smartPop.open({  bodyClose: false, background: '#000', width: 600, height: 700, url: './?menuType=popup&mode=designSkinList&subPageCode='+strSubPageCode, closeImg: {width:13, height:13, src:'../himg/common/btn_pop_close.png'} });
        });

		$("#menu_auth_e1").bind("click", function() {	
			$.getJSON("./?menuType=layout&mode=json&jsonMode=makeSkinConfFile&subPageCode="+strSubPageCode, function(data) {
				alert(data[0]["MSG"]);
			});
		});
		
	});
//-->
</script>

<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["BW00160"] //세부페이지 설정?></h2>
	<div class="clr"></div>
</div>

<div class="tableForm">
	<ul id="skinList" class="filetree">
		<li>
			<span class="folder">메인</span>
			<ul>
				<li><a href="javascript:goSkinSampleHtml('ZL0001')"><span class="file">샵메인</span></a></li>
			</ul>
		</li>
		<li>
			<span class="folder">상품</span>
			<ul>
				<li><a href="javascript:goSkinSampleHtml('PL0001')"><span class="file">상품리스트</span></a></li>
				<li><a href="javascript:goSkinSampleHtml('PV0001')"><span class="file">상품상세보기</span></a></li>
				<li><a href="javascript:goSkinSampleHtml('PS0001')"><span class="file">상품검색결과</span></a></li>
				<li><a href="javascript:goSkinSampleHtml('PJ0001')"><span class="file">브랜드 메인화면</span></a></li>
				<li><a href="javascript:goSkinSampleHtml('PH0001')"><span class="file">브랜드 세부화면</span></a></li>
			</ul>
		</li>
		<li>
			<span class="folder">회원</span>
			<ul>
				<li><a href="javascript:goSkinSampleHtml('ML0001')"><span class="file">회원로그인</span></a></li>
			</ul>
		</li>
		<li>
			<span class="folder">기타</span>
			<ul>
				<li><a href="javascript:goSkinSampleHtml('EQ0001')"><span class="file">퀵메뉴</span></a></li>
			</ul>
		</li>
	</ul>
	<div id="skinSampleView">
	</div>
	<div class="clear"></div>
</div>
<!--div class="btnCenter">
	<a class="btn_blue_big" href="#" id="menu_auth_m" style="display:none"><strong>디자인변경</strong></a>
	<a class="btn_blue_big" href="#" id="menu_auth_e1" style="display:none"><strong>사이트적용</strong></a>
</div-->


<!-- ******** 컨텐츠 ********* -->
