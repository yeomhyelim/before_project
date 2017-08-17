<!-- ******* 하단영역 시작 ************************* -->
<div id="bottomArea">
	<div id="bottomWrap">
		<div class="bottomNavi">
			<a href="/">HOME</a> | 
			<a href="?menuType=contents&mode=userPage&id=00001">회사소개</a> | 
			<a href="?menuType=member&mode=agreement">이용약관</a>  | 
			<a href="?menuType=member&mode=private">개인정보보호정책</a>  
			<a href="?menuType=contents&mode=userPage&id=00027">|  이용안내</a> 
		</div>
		<div class="shopInfo">
			<table>
				<tr>
					<td class="copyLogo"><? include sprintf ( "%swww/include/shopLogo.inc.php", $S_DOCUMENT_ROOT  ); ?><td>
					<td>
						<ul>
							<li>상호:<? echo  $S_SITE_NM ; ?>  <span></span><? echo  $S_COM_ADDR ; ?> <span>대표:</span><? echo  $S_REP_NM ; ?></li> 				
							<li>사업자번호: <? echo  $S_COM_NUM1 ; ?> <span>통신판매업신고:</span><? echo  $S_COM_NUM2 ; ?> <span>대표전화:</span> <? echo  $S_COM_PHONE ; ?> </li>
							<li><span>개인정보관리책임:</span> <? echo  $S_PIM_NAME ; ?>(<? echo  $S_PIM_MAIL ; ?>)</li>
							<li>Copyright ⓒ 2012 <strong><? echo  $S_SITE_URL ; ?></strong> All rights reserved.</li>
						</ul>
					<td>
				</tr>
			</table>
		</div>
		<!-- div class="icoWrap">
			<img src="/himg/bottom/A0001/kcp_escrow.gif"/>
			<? echo  ""; ?>
		</div -->
		<div class="clear"></div>
	</div>
</div><!-- bottomArea -->
<!-- ******* 하단영역 끝 ************************* -->