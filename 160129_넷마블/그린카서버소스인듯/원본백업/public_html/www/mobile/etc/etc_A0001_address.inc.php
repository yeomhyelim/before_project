<?
	$strKey		= $_POST["key"]		? $_POST["key"]			: $_REQUEST["key"];
	$strNum		= $_POST["num"]		? $_POST["num"]			: $_REQUEST["num"];
	$page		= $_POST["page"]	? $_POST["page"]		: $_REQUEST["page"];

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
<? include "./include/header.inc.php";?>


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
	}else if($strNum=="3"){ // 사업자번호
		echo ("
			function goZip(zip1,zip2,addr1,sido) {
				opener.document.form.busi_zip1.value	= zip1;
				opener.document.form.busi_zip2.value	= zip2;
				opener.document.form.busi_addr1.value= addr1;
				window.close();
				return;
			}
		");	
	}
?>
//-->
</script>
<body>
<form name='form' method='post'>
<div class="popContainer">
	<h3>우편번호검색</h3>
	<div class="zipTxtInfo">
		찾고자 하는 지역의 이름이나 <br>
		그 일부를 동(읍/면/리) 단위로 입력하여 주십시오.<br> 
		<strong>예) 대치동, 청담동, 명동 </strong>
	</div>
	<div id="showAddress">	
		<input type="hidden" name='num' value="<?=$strNum?>" />
		<input type="hidden" name="menuType" value="etc" />
		<input type="hidden" name="mode" value="=address" />
		<input type="hidden" name="num" value="<?=$strNum?>" />

		<div class="zipSearchWrap">
			<span>지역명</span>
			<input type="text" name="key" value="<?=$strKey?>" onkeypress="goEnter()"/>
			<a href="javascript:goSearch();" class="btn_zip_search">검색</a>
		</div>
		
		<div class="scrolWrap">			
			<ul class="zipTable">
				 <? if($strKey) { ?>
					<?	if(!strcmp($total_record,0)){	?>
						<div class="selectAdd">검색된 주소가 없습니다.</div>
					<?}else{
						while($row =mysql_fetch_array($result)){			

							$zip1		= substr($row[ZIPCODE],0,3);
							$zip2		= substr($row[ZIPCODE],4);
							//$address1	= trim($row[SIDO])." ".trim($row[GUBUN])." ".trim($row[DONG]);

							$address1	= trim($row[SIDO])." ".trim($row[CUGUN])." ".trim($row[DONG])." ".trim($row[BUNJI]);
							$address1  .= " ".trim($row[BLDG]);

							$sido		= trim($row[SIDO]);
							$address	= trim($row[SIDO])." ".trim($row[CUGUN])." ".trim($row[DONG])." ".trim($row[RI]);
							$address   .= " ".trim($row[BLDG])." ".trim($row[BUNJI]);

							echo ("
								<li>
									<a href=\"javascript:goZip('$zip1', '$zip2','$address1','$sido')\">
										$zip1-$zip2
										<p>$address</p>
									</a>
								</li>
							");								

							$article_num--;
						}  //->while문			
						
						?>
					<?}?>
				<?}?>	
		</div><!--  scrolWrap -->	
	</div>
	<div class="btnClose">
		<a onclick="window.close();" class="btn_popClose">닫기</a>
	</div>	
</div><!-- popUpWrap -->
<!--//주소창 팝업-->
</form>