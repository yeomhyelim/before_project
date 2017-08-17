<ul class="layoutType">
	<li>
		<?if($strEditPage == "top"){?>
			<img src="/shopAdmin/himg/design/layout_1_on.gif"/>
		<?}else{?>
			<a href="<?= $layoutToHref ?>&editPage=top&de_no=1" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_1.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
	<li>
		<?if($strEditPage == "body"){?>
			<img src="/shopAdmin/himg/design/layout_7_on.gif"/>
		<?}else{?>
			<a href="<?= $layoutToHref ?>&editPage=body&de_no=3" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_7.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
		<li>
		<?if($strEditPage == "bottom"){?>
			<img src="/shopAdmin/himg/design/layout_5_on.gif"/>
		<?}else{?>
			<a href="<?= $layoutToHref ?>&editPage=bottom&de_no=5" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_5.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
</ul>