<ul class="layoutType">
	<li><img src="/shopAdmin/himg/design/layout_1_off.gif"/></li>
	<li>
		<?if($strPageDesign == "SL"){?>
			<img src="/shopAdmin/himg/design/layout_2_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=SL" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_2.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
		<?if($strPageDesign == "SD"){?>
			<img src="/shopAdmin/himg/design/layout_6_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=SD" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_6.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
		<li><img src="/shopAdmin/himg/design/layout_5_off.gif"/></li>
</ul>