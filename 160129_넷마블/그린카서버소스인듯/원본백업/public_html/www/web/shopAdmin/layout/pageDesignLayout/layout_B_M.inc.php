<ul class="layoutType">
	<li>
		<?if($strPageDesign == "MT"){?>
			<img src="/shopAdmin/himg/design/layout_1_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=MT" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_1.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
	<li>
		<?if($strPageDesign == "ML"){?>
			<img src="/shopAdmin/himg/design/layout_2_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=ML" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_2.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
		<?if($strPageDesign == "MD"){?>
			<img src="/shopAdmin/himg/design/layout_6_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=MD" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_6.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>

	</li>
		<li>
		<?if($strPageDesign == "MB"){?>
			<img src="/shopAdmin/himg/design/layout_5_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=MB" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_5.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
</ul>