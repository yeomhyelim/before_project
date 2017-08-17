<?

	$strKey			= $_POST["key"]		? $_POST["key"]			: $_REQUEST["key"];
	$strNum		= $_POST["num"]		? $_POST["num"]			: $_REQUEST["num"];
	$page			= $_POST["page"]		? $_POST["page"]			: $_REQUEST["page"];

	$intNo			= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	$strGubun		= $_POST["gb"]				? $_POST["gb"]				: $_REQUEST["gb"];

	$list	= "./address.php?mode=list";
	
	if($strKey) {
		
		$pageline = 10;                            #페이지당 출력리스트 갯수	
		$pageblock = 10;                           #페이지 블럭
		
		if(!$page)	$page =1;

		$query = " SELECT * FROM ZIPCODE WHERE (DONG like '%$strKey%')";
		$total_record = $db->getNum($query);
		$total_page =ceil($total_record / $pageline);	
		
		if($total_record ==0){
			$first =1;
			$last =0;
		}else{
			$first =$pageline *($page -1);
			$last  =$pageline * $page;
		}
		//$query .=" ORDER BY SEQ ASC  LIMIT $first,$pageline";
		$query .=" ORDER BY SEQ ASC";
		$result =$db->getExecSql($query);
		$article_num = $total_record -$pageline *($page -1);	
		
		$link ="$list&num=$strNum&key=$strKey&page=";    

	}

?>


<script language="JavaScript" type="text/JavaScript">
<!--
	function goSearch(){
		var doc = document.form;    
//		doc.action     = "<?=$list?>";
//		doc.target     = "_self";
		doc.menuType.value = "etc";
		doc.mode.value = "address";
		doc.num.value = "";
		doc.submit();	
	}

	function goEnter()
	{
		if(event.keyCode == 13) 
			goSearch();
	}

<?
	if($strNum=="1"){ //
		echo ("
			function goZip(zip1,zip2,addr1,sido) {
				opener.document.form.zip1.value	= zip1;
				opener.document.form.zip2.value	= zip2;
				opener.document.form.addr1.value	= addr1;
				window.close();
				return;
			}
		");
	}else if($strNum=="2"){
		echo ("
			function goZip(zip1,zip2,addr1,sido) {
				opener.document.form.bzip1.value	= zip1;
				opener.document.form.bzip2.value	= zip2;
				opener.document.form.baddr1.value	= addr1;
				window.close();
				return;
			}
		");	
	}else if($strNum=="3"){ // OSP관리
		echo ("
			function goZip(zip1,zip2,addr1,sido) {
				opener.document.form.osp_zip1.value	= zip1;
				opener.document.form.osp_zip2.value	= zip2;
				opener.document.form.osp_addr1.value= addr1;
				window.close();
				return;
			}
		");	
	}
?>
//-->
</script>