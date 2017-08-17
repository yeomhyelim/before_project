<select onChange="goDataListCntChangeEvent(this)">
	<option value="20"<?if($_REQUEST['page_line']=="20"){echo " selected";}?>>20개</option>
	<option value="30"<?if($_REQUEST['page_line']=="30"){echo " selected";}?>>30개</option>
	<option value="50"<?if($_REQUEST['page_line']=="50"){echo " selected";}?>>50개</option>
	<option value="100"<?if($_REQUEST['page_line']=="100"){echo " selected";}?>>100개</option>
</select>