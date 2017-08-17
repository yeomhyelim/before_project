
<!DOCTYPE html>
<head>
<title>:: Admin ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="ROBOTS" content="no" />
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<META NAME="GOOGLEBOT" CONTENT= "NOINDEX, NOFOLLOW">

	<link rel="stylesheet" type="text/css" href="./common/css/layout.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/calendar.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/design.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/treeMenu.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/button.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/farbtastic.css"/>
	<link rel="stylesheet" type="text/css" href="../common/css/jquery.jqplot.min.css" /> 
	<link rel="stylesheet" type="text/css" href="./common/css/jquery.smartPop.css" />
	
	<script language="javascript" type="text/javascript" src="../common/js/jquery-1.7.2.min.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.validate.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.alphanumeric.pack.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/common.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/commonReady.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/cal.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/swf.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/common.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/farbtastic.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/jquery.smartPop.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/toggle.checkbox.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/tinybox.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.eum.ajax.js"></script>

	<script type="text/javascript">
		<!--
			var strSiteJsLng		= "KR";
			var strAdminSiteLng		= "KR";
			var intAdminLevel		= "0"; //�ֻ��������� ����
			var strAdminType		= "A"; //�ֻ��������� ����

			var strMenuAuthBtn_L	= "";	//����
			var strMenuAuthBtn_W	= "";	//����
			var strMenuAuthBtn_M	= "";	//����
			var strMenuAuthBtn_D	= "";	//����
			var strMenuAuthBtn_E	= "";	//����
			var strMenuAuthBtn_C	= "";	//����
			var strMenuAuthBtn_S	= "";	//SMS
			var strMenuAuthBtn_P	= "";	//����Ʈ
			var strMenuAuthBtn_U	= "";	//���ε�
			var strMenuAuthBtn_E1	= "";	//��Ÿ����1
			var strMenuAuthBtn_E2	= "";	//��Ÿ����2
			var strMenuAuthBtn_E3	= "";	//��Ÿ����3
			var strMenuAuthBtn_E4	= "";	//��Ÿ����4
			var strMenuAuthBtn_E5	= "";	//��Ÿ����5

			var G_PHP_PARAM			= "menuType=layoutM&mode=htmlModify&lang=KR";
		//-->
	</script>

  <!-- toggle for checkbox -->
  <script type="text/javascript" charset="utf-8">
    $(window).load(function() {
      $('.on_off :checkbox').iphoneStyle();
      
      var onchange_checkbox = ($('.onchange :checkbox')).iphoneStyle({
        onChange: function(elem, value) { 
          $('span#status').html(value.toString());
        }
      });
      
      setInterval(function() {
        onchange_checkbox.prop('checked', !onchange_checkbox.is(':checked')).iphoneStyle("refresh");
        return
      }, 2500);
    });
  </script>
</head>
<body>


<script type="text/javascript">
	function menuFn(index) { 
		$("#menu"+index).hover(function(){ 
			$('.showSecond'+index).css('display','block');
			},function(){
				$('.showSecond'+index).css('display','none');
			});
		$('.showSecond'+index).hover(function(){ 
			$(this).css('display','block');
			}, function(){ 
			$(this).css('display','none');
		}); 
	}

	$(document).ready(function () {	
		
		$('#nav li').hover(
			function () {
				//show its submenu
				$('ul', this).slideDown(100);

			}, 
			function () {
				//hide its submenu
				$('ul', this).slideUp(100);			
			}
		);

		$("#topSiteUseLng").change(function() {			
			if ($(this).val())
			{
				var data = "menuType=basic&mode=json&act=changeUseLng&siteUserUseLng="+$(this).val();
				
				$.ajax({
					url			: "./index.php"
				   ,data		: data
				   ,type		: "POST"
				   ,dataType	: "json"
				   ,success		: function(data) {	
						if(data['__STATE__'] == "SUCCESS") {
							location.reload();
						} else {
							alert("You can not change the language.");
						}
				   }
				});
			}
		});
	});


	/* 실시간 현재시간 */
	var i=0; 
	function clockF() 
	{ 
		today = new Date(); 
		
		i=i+1000; 
		servertime=1395403894*1000; 
		processtime=servertime+i; 
		today.setTime(processtime); 

		var sec = (today.getSeconds() < 10) ? "0" + today.getSeconds() : today.getSeconds();
		var nowTime = today.getHours() + ":" + today.getMinutes() + ":" + sec; 
		$(".clockWrap").html("<strong>" + nowTime + "</strong>");
	} 

	setInterval('clockF()' , 1000) ;

</script>

<div id="topArea">

	<div id="topWrap">
		<div>
						<h1><a href="../shopAdmin/?menuType=main&mode=memberList"><img src="/shopAdmin/himg/common/logo_admin.gif"></a></h1><!-- eum  -->
						<div class="loginInfo">
				<strong> 관리자</strong>(master)
								
				
								<a href="./login.php?mode=shopAdmLogout" class="btn_sml"><span>Logout</span></a>
					
				<a href="http://demo2.eumshop.co.kr" target="_blank" class="btn_sml"><span>내 쇼핑몰 바로가기</span></a>
			</div>
			<div class="clear"></div>
		</div>
		<div id="mainNavi">
			<span class="clockWrap"><strong>21:11:34</strong></span>
				<ul class="mnBox">
				<li><span><a href="./?menuType=basic&mode=info" class="mn1">기본설정</a></span></li><li><span><a href="./?menuType=layout&mode=skinSave" class="mn1">디자인관리</a></span></li><li><span><a href="./?menuType=member&mode=memberList" class="mn1">회원관리</a></span></li><li><span><a href="./?menuType=product&mode=prodList" class="mn1">상품관리</a></span></li><li><span><a href="./?menuType=order&mode=list" class="mn1">주문관리</a></span></li><li><span><a href="./?menuType=seller&mode=shopList" class="mn1">입점관리</a></span></li><li><span><a href="./?menuType=community&mode=boardMain" class="mn1">커뮤니티관리</a></span></li><li><span><a href="./?menuType=oper&mode=popupList" class="mn1">운영관리</a></span></li><li><span><a href="./?menuType=weblog&mode=visitYear" class="mn1">통계관리</a></span></li>					<li style="width:5px;height:39px;"></li>
				</ul>
			<div class="clear"></div>
		</div><!-- mainNavi -->
	</div><!-- topWrap -->
</div>

	<div id="contentArea">
		<table style="width:100%;">
			<tr>
				<td class="leftWrap">
					<!-- ******************** leftArea ********************** -->
						






<div id="leftArea">
			
	
		
			
</div><!-- leftArea -->

					<!-- ******************** leftArea ********************** -->
				</td>
				<td class="contentWrap">
					<div class="bodyTopLine"></div>
					<!-- ******************** contentsArea ********************** -->
						<div class="layoutWrap">
						<form name="form" id="form">
							<input type="hidden" name="menuType"	value="layoutM">
							<input type="hidden" name="mode"		value="htmlModify">
							<input type="hidden" name="act"			value="htmlModify">
							<input type="hidden" name="lang"		value="KR">
							<link rel="stylesheet" href="./common/css/jquery.treeview.css" />
<link rel="stylesheet" href="./common/js/codemirror-4.0/lib/codemirror.css" />
<link rel="stylesheet" href="./common/js/codemirror-4.0/theme/cobalt.css" />
<link rel="stylesheet" href="./common/js/codemirror-4.0/addon/display/fullscreen.css">
<div id="contentArea">
	<div class="contentTop">
		<h2>모바일 편집기</h2>
	</div>
	
<script type="text/javascript">
	function goTabPageMove(query, lng) {
		location.href = "./?" + query + "&lang=" + lng;
	}
</script>

<div class="langugeTabWrap">
	<div class="tabBtn">
				<a href="javascript:goTabPageMove('menuType=layoutM&mode=htmlModify','KR')" class="tabKr selected">한국어</a>
						<a href="javascript:goTabPageMove('menuType=layoutM&mode=htmlModify','US')" class="tabUs">English</a>
						<a href="javascript:goTabPageMove('menuType=layoutM&mode=htmlModify','JP')" class="tabJp">日本語</a>
						<a href="javascript:goTabPageMove('menuType=layoutM&mode=htmlModify','CN')" class="tabCn">中国语</a>
						<a href="javascript:goTabPageMove('menuType=layoutM&mode=htmlModify','ID')" class="tabId">인도네시아어</a>
								
		<!-- a href="#" class="tabPh">필리핀어</a>
		<a href="#" class="tabEs">스페인어</a>
		<a href="#" class="tabMn">몽골어</a -->
	</div>
</div>
	<div class="tableForm" style="margin-top:10px;">
		<table>
			<tr>
				<td style="width:150px"> 
					<ul id="skinList" class="filetree treeview">
												<li class="collapsable">
							<div class="hitarea collapsable-hitarea"></div>
							<span class="folder">member</span>
						</li>
																		<li class="last">
							<span class="file">main.php</span>
						</li>
												<li class="last">
							<span class="file">member.php</span>
						</li>
											</ul>
				</td>
				<td>
					<div class="my-fullscreen">
						<div style="background:#fff;">
							<a class="btn_blue_sml" href="javascript:goHtmlEditMakeFileMoveEvent();"><strong>폴더 생성</strong></a>
							<a class="btn_blue_sml" href="javascript:goHtmlEditMakeFileMoveEvent();"><strong>파일 생성</strong></a>
							<a class="btn_blue_sml" href="javascript:goLayoutMHtmlModifyFullScreenEvent();"><strong>전체 화면</strong></a>
						</div>
						<textarea id="code"></textarea>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goContentAct('contentWrite');" id="menu_auth_w" style=""><strong>저장</strong></a>
	</div>
</div>						</form>
						</div>
					<!-- ******************** contentsArea ********************** -->
				</td>
			</tr>
		</table>
	</div>

<div id="footerArea">
	Copyright (c)  2012.  All rights reserved.
</div>
	<script language="javascript" type="text/javascript" src="/common/js/jquery.treeview.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/codemirror-4.0/lib/codemirror.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/codemirror-4.0/mode/xml/xml.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/codemirror-4.0/addon/display/fullscreen.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/layoutM/htmlModify.js"></script>

</body>
</html>	