<script language=javascript>
	function layout_over(obj)
	{
		var layout_ = obj.src.split('.gif');
		obj.src = layout_[0] + '_on.gif';
	}

	function layout_out(obj)
	{
		var layout_ = obj.src.split('_on.gif');
		obj.src = layout_[0] + '.gif';
	}
</script>

<div class="contentTop">
	<h2>서브화면 설정</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>기본 프레임 설정</h3>
	<table>
		<tr>
			<th>레이아웃</th>
			<td>
				<ul class="layoutType">
					<li><img src="/shopAdmin/himg/design/layout_1.gif"/></li>
					<li>
						<a href="#"><img src="/shopAdmin/himg/design/layout_2.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
						<a href="#"><img src="/shopAdmin/himg/design/layout_3.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
						<a href="#"><img src="/shopAdmin/himg/design/layout_4.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
					</li>
					<li><img src="/shopAdmin/himg/design/layout_5.gif"/></li>
				</ul>
			</td>
		</tr>
		<tr>
			<th>디자인선택</th>
			<td><input type="radio" name="" checked/>HTML</td>
		</tr>
		<tr>
			<th>선택영역</th>
			<td>좌측영역</td>
		</tr>
	</table>
	<div class="designEditerWrap">
		<div class="tabBtnWrap">
			<div class="tabBtnLeft">
				<a href="#" class="btn_blue_big"><strong>편집화면</strong></a>
				<a href="#" class="btn_big"><strong>원본화면</strong></a>
				<a href="#" class="btn_big"><strong>예약어</strong></a>
			</div>
			<div class="btnRight">
				<a href="#" class="btn_blue_sml"><span>늘리기</span></a>
				<a href="#" class="btn_sml"><span>줄이기</span></a>
			</div>
			<div class="clear"></div>
		</div>
		<textarea name="" class="designEditForm">
			<!-- 테스트 소스 시작 -->
					<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
					<html lang="ko">
					<head>
					<title>{_SHOP.shop_browser_title}</title>
					<link rel="shortcut icon" href="{_SHOP.shop_favicon}" />
					<meta http-equiv="content-type" content="text/html; charset=UTF-8">

					{?_DESIGN.designp_use_css}
					<!-- user common css -->
					<style type="text/css">
					{_DESIGN.designp_css_src}
					</style>
					{/}

					<!-- js -->
					<script type="text/javascript" src="/common/js/sky.base.js"></script>
					<script type="text/javascript" src="/common/js/sky.ajax.js"></script>
					<script type="text/javascript" src="/common/js/sky.drag.js"></script>
					<script type="text/javascript" src="/common/js/durian.common.js"></script>
					<script type="text/javascript" src="/common/js/cheditor/cheditor.js"></script>
					<script type="text/javascript" src="/common/js/durian.cheditor.js"></script>
					<script type="text/javascript">
						// global
						var SHOP_ID = '{SHOP_ID}';
						var IMG_SERVER = '{IMG_SERVER}';
					</script>

					{?_DESIGN.designp_use_js}
					<!-- user js -->
					<script type="text/javascript">
					{_DESIGN.designp_js_src}
					</script>
					{/}

					</head>
					<body style="{_DESIGN.designp_base_bg_style}">
					<div align="{_DESIGN.designp_align_text}">

					<table id="area_body" cellspacing="0" cellpadding="0" border="0" width="910">
						<tr>
							<!-- 로고 영역 -->
							<td colspan="4" valign="bottom">{{AREA_LOGO}}</td>
						</tr>
						<tr>
							<!-- 상단 영역 -->
							<td colspan="3" valign="bottom">{{AREA_TOP}}</td>
							<!-- 퀵메뉴 영역 -->
							<td width="0" valign="top">{{AREA_FLY}}</td>
						</tr>
						<tr valign="top">
							<!-- 좌측 영역 -->
							<td width="190">{{AREA_LEFT}}</td>
							<td class="layout_hspace"><!-- 여백 --></td>
							<!-- 본문 영역 -->
							<td>{{BODY}}</td>
							<td></td>
						</tr>
						<tr>
							<!-- 하단 영역 -->
							<td colspan="3">{{AREA_COPY}}</td>
							<td></td>
						</tr>
					</table>


					</div>
					</body>
					</html>
			<!-- 테스트 소스 끝 -->
		</textarea>
	</div><!-- designEditerWrap -->
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goInfoModify();" id="menu_auth_m"><strong>바로적용하기</strong></a>
	</div>
</div><!-- tableForm -->

