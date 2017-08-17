<!-- ******************  탑영역 시작 ******************************   -->
<div id="topArea">
	<div id="topWrap">
		<table>
			<tr>
				<td rowspan="2"><? include sprintf ( "%swww/include/shopLogo.inc.php", $S_DOCUMENT_ROOT  ); ?></td>
			</tr>
			<tr>
				<td class="glbWrap">
					<? include sprintf ( "%s%s/layout/menu/globalMenu2.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME  ); ?>
				</td>
			</tr>
		</table>
		

		<div id="mainNavi">
                        <div class="mnWrap">
			<a href="/"><img src="/images/mn_1.gif"/></a>
			<a href="./?menuType=product&mode=list&lcate=003"><img src="/images/mn_2.gif"/></a>
			<a href="./?menuType=product&mode=list&lcate=032"><img src="/images/mn_3.gif"/></a>
			<a href=".?menuType=community&b_code=DATA"><img src="/images/mn_4.gif"/></a>
			<a href="./?menuType=community&b_code=PHOTO"><img src="/images/mn_5.gif"/></a>
                         <a href="./?menuType=contents&mode=helpDiskMain"><img src="/images/mn_6.gif"/></a>
                       </div>
			<div class="searchWrap">
				<? include sprintf ( "%s%s/layout/menu/productSearch.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME  ); ?>
			</div>
			<div class="clear"></div>
		</div>

	</div><!-- topWrap -->
</div>
<!-- ******************  탑영역 끝 ******************************   -->