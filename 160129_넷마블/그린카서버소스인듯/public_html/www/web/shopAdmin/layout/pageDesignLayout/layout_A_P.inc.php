<ul class="layoutType">
	<li><img src="/shopAdmin/himg/design/layout_1_off.gif"/></li>
	<li>
		<?if($strPageDesign == "PD"){?>
			<img src="/shopAdmin/himg/design/layout_7_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=PD" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_7.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
		<li><img src="/shopAdmin/himg/design/layout_5_off.gif"/></li>
</ul>