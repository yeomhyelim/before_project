	<!--table-->
		<?$use	= $_REQUEST['BOARD_INFO']['bi_userfield_field_use'];?>
		<?$name = $_REQUEST['BOARD_INFO']['bi_userfield_name'];?>
		<?$sort = 1000;$s=0;?>
		<?for($i=1;$i<=3;$i++):?>
		<?if($use[$s]=="Y"):?>
		<?$userfieldViewRow["AD_PHONE{$i}"] = explode("-", $userfieldViewRow["AD_PHONE{$i}"]);?>
		<tr>
			<th><?=$name[$s]?></th>
			<td>
				<input type="text" name="ad_phone<?=$i?>_1" style="width:50px;" value="<?=$userfieldViewRow["AD_PHONE{$i}"][0]?>"> - 
				<input type="text" name="ad_phone<?=$i?>_2" style="width:50px;" value="<?=$userfieldViewRow["AD_PHONE{$i}"][1]?>"> - 
				<input type="text" name="ad_phone<?=$i?>_3" style="width:50px;" value="<?=$userfieldViewRow["AD_PHONE{$i}"][2]?>">
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?endfor;?>
		<?if($use[$s]=="Y"):?>
		<?$userfieldViewRow["AD_ZIP"] = explode("-", $userfieldViewRow["AD_ZIP"]);?>
		<tr>
			<th><?=$name[$s]?></th>
			<td>
				<div style="padding:0 0 5px 0;">
					<input type="text" name="ad_zip_1" style="width:50px;" value="<?=$userfieldViewRow["AD_ZIP"][0]?>"> - 
					<input type="text" name="ad_zip_2" style="width:50px;" value="<?=$userfieldViewRow["AD_ZIP"][1]?>">
				</div>
				<div style="padding:0 0 5px 0;">
					<input type="text" name="ad_addr1" style="width:400px;" value="<?=$userfieldViewRow["AD_ADDR1"]?>">
				</div>
				<div>
					<input type="text" name="ad_addr2" style="width:400px;" value="<?=$userfieldViewRow["AD_ADDR2"]?>">
				</div>
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?if($use[$s]=="Y"):?>
		<tr>
			<th><?=$name[$s]?></th>
			<td>
				<input type="text" name="ad_company" style="width:300px;" value="<?=$userfieldViewRow["AD_COMPANY"]?>">
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?for($i=1;$i<=20;$i++):?>
		<?if($use[$s]=="Y"):?>
		<tr>
			<th><?=$name[$s]?></th>
			<td>
				<input type="text" name="ad_temp<?=$i?>" style="width:300px;" value="<?=$userfieldViewRow["AD_TEMP{$i}"]?>">
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?endfor;?>
	<!--/table-->

