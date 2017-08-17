	<!--table-->
		<?$use	= $_REQUEST['BOARD_INFO']['bi_userfield_field_use'];?>
		<?$name = $_REQUEST['BOARD_INFO']['bi_userfield_name'];?>
		<?$sort = 1000;$s=0;?>
		<?for($i=1;$i<=3;$i++):?>
		<?if($use[$s]=="Y"):?>
		<tr >
			<th><?=$name[$s]?></th>
			<td colspan="5">
				<?=$userfieldViewRow["AD_PHONE{$i}"]?>
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?endfor;?>
		<?if($use[$s]=="Y"):?>
		<tr>
			<th><?=$name[$s]?></th>
			<td colspan="5">
				<div style="padding:0 0 5px 0;">
					<?=$userfieldViewRow["AD_ZIP"]?>
				</div>
				<div style="padding:0 0 5px 0;">
					<?=$userfieldViewRow["AD_ADDR1"]?>
				</div>
				<div>
					<?=$userfieldViewRow["AD_ADDR2"]?>
				</div>
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?if($use[$s]=="Y"):?>
		<tr>
			<th><?=$name[$s]?></th>
			<td colspan="5">
				<?=$userfieldViewRow["AD_COMPANY"]?>
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?for($i=1;$i<=20;$i++):?>
		<?if($use[$s]=="Y"):?>
		<tr>
			<th><?=$name[$s]?></th>
			<td colspan="5">
				<?=$userfieldViewRow["AD_TEMP{$i}"]?>
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?endfor;?>
	<!--/table-->
