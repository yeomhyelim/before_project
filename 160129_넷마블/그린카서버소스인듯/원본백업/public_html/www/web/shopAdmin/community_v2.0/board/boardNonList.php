<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/community_v2.0/board/boarNonList.js";
?>
<div class="contentTop">
	<h2>운영정지 게시판</h2>
	<div class="clr"></div>
</div>

<div class="tableListWrap">
	<table class="tableList">
		<colgroup>
			<col width="40/">
			<col width="60/">
			<col>
			<col width="100/">
		</colgroup>
		<tbody>
		<tr>
			<th>번호</th>
			<th colspan="2">게시판정보</th>
			<th>관리</th>
		</tr>
		<tr>
			<td>1</td>
			<td class="vTop noRboder">
				<img src="/shopAdmin/himg/layout/sample/board_type_data_basic.gif">
			</td>
			<td class="alignLeft">
				<ul class="inTdUlList">
					<li><span>타이틀</span>: <strong>상담관리</strong></li>
					<li><span>관리그룹</span>: -</li>
					<li><span>코드명</span>: USER_REPORT</li>
					<li><span>디자인</span>: basic</li>
					<li><span></span><a href="http://copy-mall.eumshop.com/kr/?menuType=community&amp;b_code=USER_REPORT" target="_blank" class="btn_sml"><strong style="font-weight:normal;">게시판 보기 &gt;</strong></a></li>
				</ul>
			</td>
			<td><a href="javascript:goBoardStartActEvent('USER_REPORT')" class="btn_blue_sml" id="menu_auth_m" style="display: inline-block;"><strong>운영복구</strong></a>
				<a href="javascript:goBoardDeleteActEvent('USER_REPORT')" class="btn_sml" id="menu_auth_m" style="display: inline-block;"><strong>완전삭제</strong></a>
			</td>
		</tr>
		</tbody>
	</table>
</div>