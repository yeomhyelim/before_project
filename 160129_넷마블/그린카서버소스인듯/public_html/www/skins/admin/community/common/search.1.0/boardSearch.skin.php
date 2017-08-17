<select name="searchKey" id="searchKey">
	<option value="name"<?if($_REQUEST['searchKey']=="name"){echo " selected";}?>>게시판명</option>
	<option value="code"<?if($_REQUEST['searchKey']=="code"){echo " selected";}?>>게시판코드</option>
</select>
<input type="text" name="searchVal" id="searchVal" value="<?=$_REQUEST['searchVal']?>" alt="검색어" check="search" />
<a class="btn_sml" href="javascript:goBoardSearchListMoveEvent();" id="menu_auth_w" style=""><strong>검색</strong></a>	