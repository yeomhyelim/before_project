<? 
	## 설정
	$tableName				= "DataMgr"; 
?>

<div class="tableList">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/mypage/qna.1.0/list.m.skins.php" ?>
</div>

<?if($_REQUEST['buttonLock']['dataWrite']==1): //글쓰기권한 ?>
<div class="btnRight">
	<a class="btn_new_big" href="javascript:goDataWriteMove();" id="menu_auth_w"><strong>글쓰기</strong></a>
</div>
<?elseif($_REQUEST['buttonLock']['dataWrite']==2):?>
<div class="btnRight">
	<a href="javascript:alert('로그인이 필요합니다.');" id="menu_auth_w" class="btn_board_write"><strong>글쓰기</strong></a>
</div>
<?endif;?>



<div class="paginate">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/common/page.1.0/list.page.m.skins.php" ?>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="">