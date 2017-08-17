<?
	## 초기화
	$strSearchCountry			= $_GET['searchCountry'];
	$strSearchField				= $_GET['searchField'];
	$strSearchKey				= $_GET['searchKey'];
	$strSearchComAuth1			= $_GET['searchComAuth1'];
	$strSearchComAuth2			= $_GET['searchComAuth2'];
	$strSearchComAuth3			= $_GET['searchComAuth3'];
	$strSearchCategory1			= $_GET['searchCategory1'];
	$strSearchCategory2			= $_GET['searchCategory2'];
	$strSearchCategory3			= $_GET['searchCategory3'];
	$strSearchCreditGrade1		= $_GET['searchCreditGrade1'];
	$strSearchCreditGrade2		= $_GET['searchCreditGrade2'];
	$strSearchCreditGrade3		= $_GET['searchCreditGrade3'];
	$strSearchSaleGrade1		= $_GET['searchSaleGrade1'];
	$strSearchSaleGrade2		= $_GET['searchSaleGrade2'];
	$strSearchSaleGrade3		= $_GET['searchSaleGrade3'];
	$strSearchLocusGrade1		= $_GET['searchLocusGrade1'];
	$strSearchLocusGrade2		= $_GET['searchLocusGrade2'];

?>
<script type="text/javascript">
	<!--
	$(document).ready(function (){	

	});

	function goSearch(){
		var data					= new Array(10);
		data['searchCountry']		= $("#searchCountry").val();
		data['searchField']			= $("#searchField").val();
		data['searchKey']			= $("#searchKey").val();
		data['searchComAuth1']		= $(":checkbox[name=searchComAuth1]:checked").val();
		data['searchComAuth2']		= $(":checkbox[name=searchComAuth2]:checked").val();
		data['searchComAuth3']		= $(":checkbox[name=searchComAuth3]:checked").val();
		data['searchCategory1']		= $(":checkbox[name=searchCategory1]:checked").val();
		data['searchCategory2']		= $(":checkbox[name=searchCategory2]:checked").val();
		data['searchCategory3']		= $(":checkbox[name=searchCategory3]:checked").val();
		data['searchCreditGrade1']		= $(":checkbox[name=searchCreditGrade1]:checked").val();
		data['searchCreditGrade2']		= $(":checkbox[name=searchCreditGrade2]:checked").val();
		data['searchCreditGrade3']		= $(":checkbox[name=searchCreditGrade3]:checked").val();
		data['searchSaleGrade1']		= $(":checkbox[name=searchSaleGrade1]:checked").val();
		data['searchSaleGrade2']		= $(":checkbox[name=searchSaleGrade2]:checked").val();
		data['searchSaleGrade3']		= $(":checkbox[name=searchSaleGrade3]:checked").val();
		data['searchLocusGrade1']		= $(":checkbox[name=searchLocusGrade1]:checked").val();
		data['searchLocusGrade2']		= $(":checkbox[name=searchLocusGrade2]:checked").val();
		data['page']				= 1;

		C_getAddLocationUrl(data);	
	}
	//-->
</script>
<div class="searchFormWrap"">
	<select id="searchCountry" name="searchCountry">
		<option value="">국가선택</option>
		<option value="KR" <?if($strSearchCountry == "KR")	{echo " selected";}?>>한국</option>
		<option value="CN" <?if($strSearchCountry == "CN")	{echo " selected";}?>>중국</option>
		<option value="US" <?if($strSearchCountry == "US")	{echo " selected";}?>>미국</option>
		<option value="JP" <?if($strSearchCountry == "JP")	{echo " selected";}?>>일본</option>
	</select>
	<select id="searchField" style="width:133px">
		<option value=""		<?if($strSearchField == "")			{echo " selected";}?>>전체</option>
		<option value="company"	<?if($strSearchField == "company")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["SW00004"] //회사명?></option>
		<option value="shop"	<?if($strSearchField == "shop")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["SW00028"] //상점명?></option>
		<option value="boss"	<?if($strSearchField == "boss")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["SW00006"] //대표자?></option>
		<option value="bnumber"	<?if($strSearchField == "bnumber")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["SW00012"] //사업자번호?></option>
		<option value="email"	<?if($strSearchField == "email")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["SW00009"] //이메일?></option>
	</select>
	<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> data-enter-event="goSearch" data-auto-focus style="width:210px;"/>
	<a class="btn_search_new" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
	<a class="btn_big_reset" href="./?menuType=seller&mode=shopList"><strong><?=$LNG_TRANS_CHAR["CW00085"] //초기화?></strong></a>
</div>
<table>
	<tr>
		<th>Type</th>
		<td>
			<input type="checkbox" id="searchCategory1" name="searchCategory1" value="M" <?if($strSearchCategory1 == "M")	{echo " checked";}?>> 제조사
			<input type="checkbox" id="searchCategory2" name="searchCategory2" value="S" <?if($strSearchCategory2 == "S")	{echo " checked";}?>> 공급사
			<input type="checkbox" id="searchCategory3" name="searchCategory3" value="B" <?if($strSearchCategory3 == "B")	{echo " checked";}?>> 제조/공급사
		</td>
	</tr>
	<tr>
		<th>요청일</th>
		<td>
			<input type="text" id="searchLastLoginStartDt" value="<?=$_REQUEST['searchLastLoginStartDt']?>" data-simple-datepicker  style="width:80px"> -
			<input type="text" id="searchLastLoginEndDt"   value="<?=$_REQUEST['searchLastLoginEndDt']?>" data-simple-datepicker   style="width:80px"> 
			<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"] //전체?></strong></a>
		</td>
	</tr>
	<tr>
		<th>승인일</th>
		<td>
			<input type="text" id="searchLastLoginStartDt" value="<?=$_REQUEST['searchLastLoginStartDt']?>" data-simple-datepicker  style="width:80px"> -
			<input type="text" id="searchLastLoginEndDt"   value="<?=$_REQUEST['searchLastLoginEndDt']?>" data-simple-datepicker   style="width:80px"> 
			<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"] //전체?></strong></a>		
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["SW00020"] //승인여부?></th>
		<td>
			<input type="checkbox" id="searchComAuth1" name="searchComAuth1" value="Y"  <?if($strSearchComAuth1 == "Y")		{echo " checked";}?>/><?=$LNG_TRANS_CHAR["CW00022"] //전체?>
			<input type="checkbox" id="searchComAuth2" name="searchComAuth2" value="Y"  <?if($strSearchComAuth2 == "Y")		{echo " checked";}?>/><?=$LNG_TRANS_CHAR["CW00006"] //승인?>
			<input type="checkbox" id="searchComAuth3" name="searchComAuth3" value="R"  <?if($strSearchComAuth3 == "R")		{echo " checked";}?>/>승인요청

			
			<!--input type="radio" <?=$nBox?>  id="searchComAuth" name="searchComAuth" value=""  <?if($strSearchComAuth == "")		{echo " checked";}?>/><?=$LNG_TRANS_CHAR["CW00022"] //전체?>
			<input type="radio" <?=$nBox?>  id="searchComAuth" name="searchComAuth" value="Y" <?if($strSearchComAuth == "Y")	{echo " checked";}?>/><?=$LNG_TRANS_CHAR["CW00006"] //승인?>
			<input type="radio" <?=$nBox?>  id="searchComAuth" name="searchComAuth" value="H" <?if($strSearchComAuth == "H")	{echo " checked";}?>/><?=$LNG_TRANS_CHAR["SW00070"] //보류?> 
			<input type="radio" <?=$nBox?>  id="searchComAuth" name="searchComAuth" value="N" <?if($strSearchComAuth == "N")	{echo " checked";}?>/><?=$LNG_TRANS_CHAR["CW00040"] //미승인?>
			<input type="radio" <?=$nBox?>  id="searchComAuth" name="searchComAuth" value="S" <?if($strSearchComAuth == "S")	{echo " checked";}?>/><?=$LNG_TRANS_CHAR["SW00071"] //대기?> -->
		</td>
	</tr>
	<tr>
		<th>신용등급</th>
		<td class="gradeIco">
			<input type="checkbox" id="searchCreditGrade1" name="searchCreditGrade1" value="G" <?if($strSearchCreditGrade1 == "G")	{echo " checked";}?> /> <span class="gradeIco"><img src="<?=$aryCreditGradeImg["G"]?>" /></span>골드등급
			<input type="checkbox" id="searchCreditGrade2" name="searchCreditGrade2" value="S" <?if($strSearchCreditGrade2 == "S")	{echo " checked";}?> /> <span class="gradeIco"><img src="<?=$aryCreditGradeImg["S"]?>" /></span>실버등급
			<input type="checkbox" id="searchCreditGrade3" name="searchCreditGrade3" value="B" <?if($strSearchCreditGrade3 == "B")	{echo " checked";}?> /> <span class="gradeIco"><img src="<?=$aryCreditGradeImg["B"]?>" /></span>일반등급
		</td>
	</tr>
	<tr>
		<th>판매등급</th>
		<td class="gradeIco">
			<input type="checkbox" id="searchSaleGrade1" name="searchSaleGrade1" value="B" <?if($strSearchSaleGrade1 == "B")	{echo " checked";}?> /> <span class="gradeIco"><img src="<?=$arySaleGradeImg["B"]?>" /></span>최우수
			<input type="checkbox" id="searchSaleGrade2" name="searchSaleGrade2" value="E" <?if($strSearchSaleGrade2 == "E")	{echo " checked";}?> /> <span class="gradeIco"><img src="<?=$arySaleGradeImg["E"]?>" /></span>우수
			<input type="checkbox" id="searchSaleGrade3" name="searchSaleGrade3" value="G" <?if($strSearchSaleGrade3 == "G")	{echo " checked";}?> /> <span class="gradeIco"><img src="<?=$arySaleGradeImg["G"]?>" /></span>일반
		</td>
	</tr>
	<tr>
		<th>현장확인</th>
		<td class="gradeIco">
			<input type="checkbox" id="searchLocusGrade1" name="searchLocusGrade1" value="N" <?if($strSearchLocusGrade1 == "N")	{echo " checked";}?> /> <span class="gradeIco"><img src="<?=$aryLocusGradeImg["N"]?>" /></span>미확인
			<input type="checkbox" id="searchLocusGrade2" name="searchLocusGrade2" value="Y" <?if($strSearchLocusGrade2 == "Y")	{echo " checked";}?> /> <span class="gradeIco"><img src="<?=$aryLocusGradeImg["Y"]?>" /></span>확인	
		</td>
	</tr>
</table>

