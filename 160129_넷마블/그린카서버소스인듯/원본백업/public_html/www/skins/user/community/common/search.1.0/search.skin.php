<select name="searchKey" id="searchKey">
	<option value="title"<?if($_REQUEST['searchKey']=="title"){echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00062"] //제목?></option>
	<option value="text"<?if($_REQUEST['searchKey']=="text"){echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00063"] //내용?></option>
	<option value="title_text"<?if($_REQUEST['searchKey']=="title_text"){echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00062"] //제목?>+<?=$LNG_TRANS_CHAR["CW00063"] //내용?></option>
	<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
	<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
	<option value="name"<?if($_REQUEST['searchKey']=="name"){echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00053"] //작성자?></option>
	<?endif;?>
	<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
	<option value="id"<?if($_REQUEST['searchKey']=="id"){echo " selected";}?>><?=$LNG_TRANS_CHAR["MW00001"] //아이디?></option>
	<?endif;?>
	<?endif;?>
</select>
<input type="text" name="searchVal" id="searchVal" value="<?=$_REQUEST['searchVal']?>" alt="검색어" check="search" />
<a href="javascript:goSearchListMoveEvent();" id="menu_auth_w" class="btnBoardSearch"><strong><?=$LNG_TRANS_CHAR["CW00061"] //검색?></strong></a>	

