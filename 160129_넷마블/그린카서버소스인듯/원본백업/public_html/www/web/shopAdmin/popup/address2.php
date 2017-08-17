<?
	$strNum			= $_REQUEST["num"];
	$strReturnUrl	= $S_HTTP_HOST."/shopAdmin/index.php";
	$strZip1		= $_REQUEST['zip1'];
	$strZip2		= $_REQUEST['zip2'];
	$strAddr		= $_REQUEST['addr'];
	$strSido		= $_REQUEST['sido'];

	if ($strZip1 && $strZip2 && $strAddr && $strSido){

?>
<script type="text/javascript">
<!--
	var zip1	= "<?=$strZip1?>";
	var zip2	= "<?=$strZip2?>";
	var addr1	= "<?=$strAddr?>";
	var sido	= "<?=$strSido?>";

<?if($strNum=="1"){?>
	opener.document.form.com_zip1.value	= zip1;
	opener.document.form.com_zip2.value	= zip2;
	opener.document.form.com_addr.value	= addr1;
	window.close();
<?}	else if($strNum=="2"){?>
	opener.document.form.zip1.value	= zip1+'-'+zip2;
	opener.document.form.addr1.value= addr1;
	window.close();
<?} else if($strNum=="3"){ // 입점몰관리
?>
	opener.document.form.com_zip1.value	= zip1;
	opener.document.form.com_zip2.value	= zip2;
	opener.document.form.com_addr.value= addr1;
	window.close();
<?	}else if($strNum=="4"){ // 상점 사용자{ 
?>
	opener.document.form.zip1.value	= zip1;
	opener.document.form.zip2.value	= zip2;
	opener.document.form.addr1.value= addr1;
	window.close();
<?	}else if($strNum=="5"){ // 회원사업자
?>
	opener.document.form.busi_zip1.value	= zip1;
	opener.document.form.busi_zip2.value	= zip2;
	opener.document.form.busi_addr1.value= addr1;
	window.close();
<?	}else if($strNum=="6"){ 
	// 주문정보
?>	
	opener.document.form.bzip1.value	= zip1;
	opener.document.form.bzip2.value	= zip2;
	opener.document.form.baddr1.value	= addr1;
	window.close();
<?}?>
//-->
</script>	
<?	} else {?>
<form name="form" method="post">
<input type="hidden" name="num" value="<?=$strNum?>">
<input type="hidden" name="returnUrl"  value="<?=$strReturnUrl?>">
<input type="hidden" name="returnMenu" value="popup">
<input type="hidden" name="returnMode" value="address2">
</form>

<script type="text/javascript">
<!--
	document.form.action = "http://www.eumshop.com/api/zip/zipCode.php";
	document.form.submit();
//-->
</script>

<?}?>