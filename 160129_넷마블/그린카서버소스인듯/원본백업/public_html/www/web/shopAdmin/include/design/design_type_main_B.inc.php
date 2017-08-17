<ul class="layoutType">
	<li>
		<?if($row[DE_EDIT_SECTION]=="topArea"){?>
			<img src="/shopAdmin/himg/design/layout_1_on.gif"/>
		<?}else{?>
			<a href="<?= $layoutToHref ?>&editPage=top&de_no=1" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_1.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
	<li>
		<?if($row[DE_EDIT_SECTION]=="leftArea"){?>
			<img src="/shopAdmin/himg/design/layout_2_on.gif"/>
		<?}else{?>
			<a href="<?= $layoutToHref ?>&editPage=left&de_no=2" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_2.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
		<?if($row[DE_EDIT_SECTION]=="bodyArea"){?>
			<img src="/shopAdmin/himg/design/layout_6_on.gif"/>
		<?}else{?>
			<a href="<?= $layoutToHref ?>&editPage=body&de_no=3" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_6.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>

	</li>
		<li>
		<?if($row[DE_EDIT_SECTION]=="bottomArea"){?>
			<img src="/shopAdmin/himg/design/layout_5_on.gif"/>
		<?}else{?>
			<a href="<?= $layoutToHref ?>&editPage=nottom&de_no=5" id="menu_auth_m"><img src="/shopAdmin/himg/design/layout_5.gif" onmouseover="layout_over(this)" onmouseout="layout_out(this)"/></a>
		<?}?>
	</li>
</ul>