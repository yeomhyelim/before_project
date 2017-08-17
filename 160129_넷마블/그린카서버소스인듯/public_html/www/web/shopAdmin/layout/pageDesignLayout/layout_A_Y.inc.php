<ul class="layoutType">
	<li>
		<?if($strPageDesign == "YT"){?>
			<img src="/shopAdmin/himg/design/layout_1_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YT&subPageDesign=<?=$strSubPageDesign?>" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_1.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
	<li>
		<?if($strPageDesign == "YD"){?>
			<img src="/shopAdmin/himg/design/layout_7_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=<?=$strSubPageDesign?>" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_7.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
	<li>
		<?if($strPageDesign == "YB"){?>
			<img src="/shopAdmin/himg/design/layout_5_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YB&subPageDesign=<?=$strSubPageDesign?>" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_5.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
</ul>