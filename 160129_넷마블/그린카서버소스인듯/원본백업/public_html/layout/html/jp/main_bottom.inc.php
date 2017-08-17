<!-- ******* 하단영역 시작 ************************* -->
<div id="bottomArea">
	<div id="bottomWrap" style="border-top:1px solid #ddd;">
		<div class="bottomNavi">
			<a href="/">HOME</a> | 
			<a href="?menuType=contents&mode=userPage&id=00001">会社概要</a> | 
			<a href="?menuType=member&mode=agreement">利用規約</a>  | 
			<a href="?menuType=member&mode=private">個人情報保護ポリシー</a>
		</div>
		<div class="shopInfo">
			<table>
				<tr>
					<td class="copyLogo"><? include sprintf ( "%swww/include/shopLogo.inc.php", $S_DOCUMENT_ROOT  ); ?><td>
					<td>
						<ul>
							<li>Company Name: Woojung International  | Address: Chungbuk, Cheongju, Heungdeok-gu, Sannam Dong, 581 | CEO: Jay Hong </li> 
							<li>Company Registration Number: <? echo  $S_COM_NUM1 ; ?>  | Telephone Number: 011-285-0114  | Manager of Personal Information: Cho Su Youn(test.mail@eumshop.com)</li>
							<li>Copyright ⓒ 2014 <strong><? echo  $S_SITE_URL ; ?></strong>.  All rights reserved.</li>
						</ul>
					<td>
				</tr>
			</table>
		</div>
		<div class="clear"></div>
	</div>
</div><!-- bottomArea -->
<!-- ******* 하단영역 끝 ************************* -->
<script language='javascript' src='/common/js/counter.js'></script>
<? include sprintf ( "%swww/include/footer.inc.php", $S_DOCUMENT_ROOT ); ?>
<? include MALL_HOME . "/include/goMobile.inc.php"; ?>