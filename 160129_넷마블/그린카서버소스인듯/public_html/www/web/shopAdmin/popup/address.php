<?
	$strKey		= $_POST["key"]		? $_POST["key"]			: $_REQUEST["key"];
	$strNum		= $_POST["num"]		? $_POST["num"]			: $_REQUEST["num"];
	$page		= $_POST["page"]	? $_POST["page"]		: $_REQUEST["page"];

	
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
		doc.menuType.value = "popup";
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
				opener.document.form.com_zip1.value	= zip1;
				opener.document.form.com_zip2.value	= zip2;
				opener.document.form.com_addr.value	= addr1;
//				opener.document.form.com_addr.focus();
				window.close();
				return;
			}
		");
	}else if($strNum=="2"){
		echo ("
			function goZip(zip1,zip2,addr1,sido) {
				opener.document.form.zip1.value	= zip1+'-'+zip2;
				opener.document.form.addr1.value= addr1;
				window.close();
				return;
			}
		");	
	}else if($strNum=="3"){ // 입점몰관리
		// 2013.06.18 kim hee sung "...shopAdmin/seller/shop/shopModify.php" 소스에서 사용중입니다.
		echo ("
			function goZip(zip1,zip2,addr1,sido) {
				opener.document.form.com_zip1.value	= zip1;
				opener.document.form.com_zip2.value	= zip2;
				opener.document.form.com_addr.value= addr1;
				window.close();
				return;
			}
		");	
	}else if($strNum=="4"){ // 상점 사용자
		echo ("
			function goZip(zip1,zip2,addr1,sido) {
				opener.document.form.zip1.value	= zip1;
				opener.document.form.zip2.value	= zip2;
				opener.document.form.addr1.value= addr1;
				window.close();
				return;
			}
		");	
	}else if($strNum=="5"){ // 회원사업자
		echo ("
			function goZip(zip1,zip2,addr1,sido) {
				opener.document.form.busi_zip1.value	= zip1;
				opener.document.form.busi_zip2.value	= zip2;
				opener.document.form.busi_addr1.value= addr1;
				window.close();
				return;
			}
		");	
	}else if($strNum=="6"){ // 주문정보
		echo ("
			function goZip(zip1,zip2,addr1,sido) {
				opener.document.form.bzip1.value	= zip1;
				opener.document.form.bzip2.value	= zip2;
				opener.document.form.baddr1.value	= addr1;
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
		<div class="popUpWrap">
			<h2><img src="/himg/etc/tit_search_zip.gif"/></h2>
			<div class="zipTxtInfo">
				찾고자 하는 지역의 이름이나 <br/>
				그 일부를 동(읍/면/리) 단위로 입력하여 주십시오. <br/>
				<strong>예) 대치동, 청담동, 명동 </strong>
			</div>
			<div id="showAddress">	
				<input type="hidden" name='num' value="<?=$strNum?>" />
				<input type="hidden" name="menuType" value="popup" />
				<input type="hidden" name="mode" value="address" />
				<input type="hidden" name="num" value="<?=$strNum?>" />

				<div class="zipSearchWrap">
					<span>지역명</span>
					<input type="text" name="key" value="<?=$strKey?>" onkeypress="goEnter()"/>
					<a href="javascript:goSearch();"><img src="/himg/etc/btn_search_zip.gif"/></a>
				</div>
				<div class="resultTxtInfo">* 검색된 목록에서 우편번호를 선택하세요.</div> 
				
				<div class="scrolWrap">			
					<table cellspacing="0" cellpadding="0" class="addressT">
						<colgroup>
							<col width="68px"/>
							<col/>
						</colgroup>
						<thead>
							<tr>
								<th>우편번호</th>
								<th>주소</th>
							</tr>
						</thead>
						<tbody>
						 <? if($strKey) { ?>
							<?	if(!strcmp($total_record,0)){	?>
							<tr>
								<td colspan="2" class="selectAdd">검색된 주소가 없습니다.</td>
							</tr>
							<?}else{
								while($row =mysql_fetch_array($result)){			

									$zip1		= substr($row[ZIPCODE],0,3);
									$zip2		= substr($row[ZIPCODE],4);
									$address1	= trim($row[SIDO])." ".trim($row[CUGUN])." ".trim($row[DONG]);

									//$address1	= trim($row[SIDO])." ".trim($row[CUGUN])." ".trim($row[DONG])." ".trim($row[BUNJI]);
									//$address1  .= " ".trim($row[BLDG]);

									$sido		= trim($row[SIDO]);
									$address	= trim($row[SIDO])." ".trim($row[CUGUN])." ".trim($row[DONG])." ".trim($row[RI]);
									$address   .= " ".trim($row[BLDG])." ".trim($row[BUNJI]);

									echo ("
										<tr>
											<td class=\"postNo\">$zip1-$zip2</td>
											<td class=\"selectAdd\"><a href=\"javascript:goZip('$zip1', '$zip2','$address1','$sido')\">$address</a></td>
										</tr>
									");								

									$article_num--;
								}  //->while문			
								
								?>
							<?}?>
						<?}?>
						</tbody>
					</table>	
				</div><!--  scrolWrap -->	
			</div>
			<div class="btnCenter">
				<a onclick="window.close();"><img src="/himg/etc/btn_pop_close.gif"/></a>
			</div>	
		</div><!-- popUpWrap -->
		<!--//주소창 팝업-->
		</form>
	</body>
</html>