<select name="searchGroup" id="searchGroup">
	<option value="">그룹 전체</option>
	<?foreach($GROUP_LIST as $key => $data):?>
	<option value="<?=$key?>"<?if($_REQUEST['searchGroup']==$key){echo " selected";}?>><?=$data['bg_name']?></option>
	<?endforeach;?>
</select>