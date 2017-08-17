



	<!--table-->
		<?$sort = 1000;$s=0;?>
		<?for($i=1;$i<=3;$i++):?>
		<?if($userfieldFieldUse[$s]=="Y"):?>
		<tr>
			<th><?=$userfieldName[$s]?></th>
			<td>
				<input type="text" name="ad_phone<?=$i?>_1" style="width:50px;"> - 
				<input type="text" name="ad_phone<?=$i?>_2" style="width:50px;"> - 
				<input type="text" name="ad_phone<?=$i?>_3" style="width:50px;">
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?endfor;?>
		<?if($userfieldFieldUse[$s]=="Y"):?>
		<tr>
			<th><?=$userfieldName[$s]?></th>
			<td>
				<div style="padding:0 0 5px 0;">
					<input type="text" name="ad_zip_1" style="width:50px;"> - 
					<input type="text" name="ad_zip_2" style="width:50px;">
				</div>
				<div style="padding:0 0 5px 0;">
					<input type="text" name="ad_addr1" style="width:400px;">
				</div>
				<div>
					<input type="text" name="ad_addr2" style="width:400px;">
				</div>
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?if($userfieldFieldUse[$s]=="Y"):?>
		<tr>
			<th><?=$userfieldName[$s]?></th>
			<td>
				<input type="text" name="ad_company" style="width:300px;">
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?for($i=1;$i<=20;$i++):?>
		<?if($userfieldFieldUse[$s]=="Y"):?>
		<tr>
			<th><?=$userfieldName[$s]?></th>
			<td>
				<input type="text" name="ad_temp<?=$i?>" style="width:300px;">
			</td>
		</tr>
		<?endif;?>
		<?$s++;?>
		<?endfor;?>
	<!--/table-->
