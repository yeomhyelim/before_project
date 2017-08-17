<ul class="layoutType">
	<li>
		<?if($strPageDesign == "CT"){?>
			<img src="/shopAdmin/himg/design/layout_1_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=CT&subPageDesign=<?=$strSubPageDesign?>" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_1.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
	<li>
		<?if($strPageDesign == "CD"){?>
			<img src="/shopAdmin/himg/design/layout_7_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=CD&subPageDesign=<?=$strSubPageDesign?>" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_7.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
	<li>
		<?if($strPageDesign == "CB"){?>
			<img src="/shopAdmin/himg/design/layout_5_on.gif"/>
		<?}else{?>
			<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=CB&subPageDesign=<?=$strSubPageDesign?>" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_5.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
</ul>