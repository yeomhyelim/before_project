<select name="searchKey" id="searchKey">
	<option value="title"<?if($_REQUEST['searchKey']=="title"){echo " selected";}?>>제목</option>
	<option value="text"<?if($_REQUEST['searchKey']=="text"){echo " selected";}?>>내용</option>
	<option value="title_text"<?if($_REQUEST['searchKey']=="title_text"){echo " selected";}?>>제목+내용</option>
	<option value="name"<?if($_REQUEST['searchKey']=="name"){echo " selected";}?>>작성자</option>
	<option value="id"<?if($_REQUEST['searchKey']=="id"){echo " selected";}?>>아이디</option>
</select>
<input type="text" name="searchVal" id="searchVal" value="<?=$_REQUEST['searchVal']?>" alt="검색어" check="search" />
<a class="btn_sml" href="javascript:goDataSearchListMoveEvent();" id="menu_auth_w" style=""><strong>검색</strong></a>	