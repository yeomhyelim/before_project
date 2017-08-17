<?
	//if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){
		## 설정

		## 회원소속관리 불러오기
		$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
		//member.cate.inc.php 파일 자체가 아예 없음.
		if(is_file($fileName)):
			require_once "$fileName";
		endif;

## 검색 회원 그룹 배열로 변경
		if($_REQUEST['searchGroup']):
			$arySearchGroup		= str_replace("'", "", $_REQUEST['searchGroup']);
			$arySearchGroup		= explode(",", $arySearchGroup);
		endif;

		## 해당 회원 소속 가져오기
		if(!$memberCateMgr):
			require_once MALL_CONF_LIB."memberCateMgr.php";
			$memberCateMgr			= new MemberCateMgr();
		endif;

		## 차수별 회원 소속 설정
		if (!is_array($aryMemberCateList)):
			$param								= "";
			$param['C_CODE_COLUMN_ARYLIST']		= "Y";
			$param['M_NO']						= $a_admin_no;
			$aryMemberCateList					= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param);
		endif;

//		echo $db->query;
		$aryMemberCate						= "";
		
		//print_r($aryMemberCateList);
if (is_array($aryMemberCateList)) {
	foreach ($aryMemberCateList as $key => $c_code):
		$temp1 = substr($c_code, 0, 3);
		$temp2 = substr($c_code, 0, 6);
		$temp3 = substr($c_code, 0, 9);
		$temp4 = substr($c_code, 0, 12);
		$length = strlen($c_code);
		foreach ($MEMBER_CATE as $code => $data):
//				echo strlen($c_code) . "<br>";
			if ($temp1 == substr($code, 0, $length) && !in_array($code, $aryMemberCate)) {
				$aryMemberCate[] = $code;
			}
			if ($temp2 == substr($code, 0, $length) && !in_array($code, $aryMemberCate)) {
				$aryMemberCate[] = $code;
			}
			if ($temp3 == substr($code, 0, $length) && !in_array($code, $aryMemberCate)) {
				$aryMemberCate[] = $code;
			}
			if ($temp4 == substr($code, 0, $length) && !in_array($code, $aryMemberCate)) {
				$aryMemberCate[] = $code;
			}
		endforeach;
	endforeach;
}

//		print_r($aryMemberCate);

		## 구매기간 설정 옵션 사용 유무
		$isSearchBuyDate		= false;
		if($strMenuType == "member" && $strMode == "memberList"):
			$isSearchBuyDate = true;
		endif;
	//}
			
?>
<script type="text/javascript">
<!--
	<?if ($S_FIX_MEMBER_CATE_USE_YN  == "Y" && $strSearchOut != "Y"){?>

	var memberCate = new Array(4);
	$(document).ready(function(){
	
		/** 백업후 삭제 **/
		var defaultValue			= new Array(4);
		$("select[id=c_cate]").each(function(index) {
			memberCate[index+1]		= $(this).find("option");
			defaultValue[index+1]	= $(this).val();
			if(index <= 3) {
				$(this).change(function() {
					var no = $(this).attr("no");
					memberCateMake(no);
				});
			}
		});

		memberCateMake(0);
		for(var key in defaultValue){
			if(defaultValue[key]){
				$("select[id=c_cate][no="+key+"]").val(defaultValue[key]);	
				memberCateMake(key);
			}
		}		
	
		$("select#c_nation").change(function() { memberCateMake(0); });
	});

	function memberCateMake(no){
		no			= Number(no);
		var nation	= $("select[id=c_nation]").val();
		var code	= $("select[id=c_cate][no="+no+"]").val();
		var length	= 0;
		if(code) { length = code.length; }

		for(var i=(no+1);i<=4;i++){
			$("select[id=c_cate][no="+i+"]").find("option").remove();
			$("select[id=c_cate][no="+i+"]").append(memberCate[i].eq(0));
		}
		$(memberCate[no+1]).each(function() {
			if($(this).attr("nation") == nation) {
				if(length == 0 || code == $(this).val().substr(0,length)){
					$("select[id=c_cate][no="+(no+1)+"]").append($(this));
				}
			}
			$("select[id=c_cate][no="+(no+1)+"]").val("");
		});
	}

	<?}?>

	function goSearch(){
		var data							= new Array(30);
		data['searchField']					= $("#searchField").myVal();
		data['searchKey']					= $("#searchKey").myVal();
		data['searchRegStartOption']		= $(":radio[name=searchRegStartOption]:checked").myVal();
		data['searchRegStartDt']			= $("#searchRegStartDt").myVal();
		data['searchRegEndDt']				= $("#searchRegEndDt").myVal();
		data['searchOrderRegStartDt']		= $("#searchOrderRegStartDt").myVal();
		data['searchOrderRegEndDt']			= $("#searchOrderRegEndDt").myVal();
		data['searchLastLoginOption']		= $(":radio[name=searchLastLoginOption]:checked").myVal();
		data['searchLastLoginStartDt']		= $("#searchLastLoginStartDt").myVal();
		data['searchLastLoginEndDt']		= $("#searchLastLoginEndDt").myVal();
		data['searchDateOption']			= $("#searchRegEndDt").myVal();
		data['searchNation']				= $("select[name=searchNation]").myVal();
		data['searchCate1']					= $("select[name=searchCate1]").myVal();
		data['searchCate2']					= $("select[name=searchCate2]").myVal();
		data['searchCate3']					= $("select[name=searchCate3]").myVal();
		data['searchCate4']					= $("select[name=searchCate4]").myVal();
		//data['searchVisitStartCnt']			= $("#searchVisitStartCnt").myVal();
		//data['searchVisitEndCnt']			= $("#searchVisitEndCnt").myVal();
		//data['searchSex']					= $(":radio[name=searchSex]:checked").myVal();
		data['searchMailYN']				= $(":radio[name=searchMailYN]:checked").myVal();
		data['searchSmsYN']					= $(":radio[name=searchSmsYN]:checked").myVal();
		//data['searchBirthMonth']			= $("#searchBirthMonth").myVal();
		//data['searchBirthDay']				= $("#searchBirthDay").myVal();
		//data['searchRecId']					= $("#searchRecId").myVal();
		<?
		for($i=0; $i < $aryUseLngCnt; $i++){
		?>
		data['searchLang<?=$i?>']					= $("input:checkbox[name='searchLang<?=$i?>']:checked").myVal();
		<?
		}
		?>
		data['searchMemberGroup1']				= $("input:checkbox[name='searchMemberGroup1']:checked").myVal();
		data['searchMemberGroup2']				= $("input:checkbox[name='searchMemberGroup2']:checked").myVal();
		//data['searchSmsYN']					= $(":radio[name=searchSmsYN]:checked").myVal();

		//data['searchSmsYN']					= $(":radio[name=searchSmsYN]:checked").myVal();

		data['page']						= 1;
		
		var searchGroup						= "";
		$("input:checkbox[id='searchGroup']:checked").each(function() {
			if(searchGroup) { searchGroup = searchGroup + ","; }
			searchGroup = searchGroup + "'" + $(this).myVal() + "'";
		});
		data['searchGroup']					= searchGroup;

		C_getAddLocationUrl(data);
	}

	$.fn.myVal = function() {
		if($(this).length <= 0) { return ""; }
		return $(this).val();
	}
//-->
</script>
<div class="searchFormWrap">
	<select id="searchField" style="width:133px">
		<option value=""		<?if($strSearchField == "")			{echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"] //전체?></option>
		<option value="id"		<?if($strSearchField == "id")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["MW00095"] //아이디?></option>
		<option value="name"	<?if($strSearchField == "name")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["MW00097"] //이름?></option>
		<option value="nick"	<?if($strSearchField == "nick")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["MW00071"] //닉네임?></option>
		<option value="email"	<?if($strSearchField == "email")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["OW00033"] //이메일?></option>
		<option value="phone"	<?if($strSearchField == "phone")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["BW00013"] //전화번호?></option>
		<option value="fax"		<?if($strSearchField == "fax")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["BW00014"] //팩스번호?></option>
		<option value="hp"		<?if($strSearchField == "hp")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["BW00174"] //휴대폰?></option>
		<option value="zip"		<?if($strSearchField == "zip")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["MW00078"] //우편번호?></option>
		<option value="address"	<?if($strSearchField == "address")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["OW00036"] //주소?></option>
		<?if ($S_JOIN_TMP_1["USE"] == "Y"){?>
			<option value="tmp1"	<?if($strSearchField == "tmp1")	{echo " selected";}?>><?=$S_JOIN_TMP_1["NAME_KR"]?></option>
		<?}?>
	</select>
	<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>"  data-enter-event="goSearch" data-auto-focus/>
	<a class="btn_search_new" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
	<a class="btn_big_reset" href="./?menuType=<?=$strMenuType?>&mode=<?=$strMode?>"><strong><?=$LNG_TRANS_CHAR["CW00085"] //초기화?></strong></a>
</div>
<div class="clr"></div>
<?if($strSearchOut != "Y"):?>
<table border="0">
	<colgroup>
		<col style="width:70px;"/>
		<col style="width:180px;"/>
		<col style="width:50px;"/>
		<col />
	<colgroup/>
	<tr>
		<th><?=$LNG_TRANS_CHAR["ET00001"] //사이트?></th>
		<td>
		<?
		for($i=0; $i < $aryUseLngCnt; $i++)
		{
		?>
			<input type="checkbox" name="searchLang<?=$i?>" value="<?=$aryUseLng[$i]?>" <?=(${"searchLang".$i} == $aryUseLng[$i]) ? "checked" : "";?>> <?=$aryCountryList[$aryUseLng[$i]]?>

		<?
		}
		?>
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["MW00004"] //가입일?></th>
		<td  colspan="3">
			<input type="text" id="searchRegStartDt" value="<?=$_REQUEST['searchRegStartDt']?>" data-simple-datepicker  style="width:80px"> -
			<input type="text" id="searchRegEndDt"   value="<?=$_REQUEST['searchRegEndDt']?>" data-simple-datepicker   style="width:80px">
			<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"] //전체?></strong></a>
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["MW00242"] //최종 로그인?></th>
		<td  colspan="3">
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
		<th><?=$LNG_TRANS_CHAR["MW00065"] //방문횟수?></th>
		<td>
			<input type="text" <?=$nBox?>  style="width:60px;" id="searchVisitStartCnt" name="searchVisitStartCnt" value="<?=$_REQUEST['searchVisitStartCnt']?>"/>
			~
			<input type="text" <?=$nBox?>  style="width:60px;" id="searchVisitEndCnt" name="searchVisitEndCnt" value="<?=$_REQUEST['searchVisitEndCnt']?>"/>
		</td>
		<th></th>
		<td>

		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["OW00070"]//회원구분?></th>
		<td>
			<input type="checkbox" name="searchMemberGroup1" id="searchMemberGroup1" value="002" <?if($_REQUEST['searchMemberGroup1'] == "002")  { echo " checked"; }?>> 일반
			<input type="checkbox" name="searchMemberGroup2" id="searchMemberGroup2" value="005" <?if($_REQUEST['searchMemberGroup2'] == "005")  { echo " checked"; }?>> 사업자
		</td>
		<th></th>
		<td>

		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["MW00066"] //메인수신여부?></th>
		<td>
			<input type="radio" id="searchMailYN" name="searchMailYN" value=""  <?if($_REQUEST['searchMailYN'] == "")  { echo " checked"; }?>><?=$LNG_TRANS_CHAR["CW00022"] //전체?>
			<input type="radio" id="searchMailYN" name="searchMailYN" value="Y" <?if($_REQUEST['searchMailYN'] == "Y") { echo " checked"; }?>><?=$LNG_TRANS_CHAR["MW00102"] //수신?>
			<input type="radio" id="searchMailYN" name="searchMailYN" value="N" <?if($_REQUEST['searchMailYN'] == "N") { echo " checked"; }?>><?=$LNG_TRANS_CHAR["MW00103"] //수신거부?>
		</td>
		<th><?//=$LNG_TRANS_CHAR["MW00067"] //SMS수신여부?></th>
		<td>
			<!-- input type="radio" id="searchSmsYN" name="searchSmsYN" value="" --> <?//if($_REQUEST['searchSmsYN'] == "")  { echo " checked"; }?><?//=$LNG_TRANS_CHAR["CW00022"] //전체?>
			<!-- input type="radio" id="searchSmsYN" name="searchSmsYN" value="Y" --> <?//if($_REQUEST['searchSmsYN'] == "Y") { echo " checked"; }?><?//=$LNG_TRANS_CHAR["MW00102"] //수신?>
			<!-- input type="radio" id="searchSmsYN" name="searchSmsYN" value="N" --> <?//if($_REQUEST['searchSmsYN'] == "N") { echo " checked"; }?><?//=$LNG_TRANS_CHAR["MW00103"] //수신거부?>
		</td>
	</tr>
	<tr>
		<th><?//=$LNG_TRANS_CHAR["MW00012"] //생년월일?></th>
		<td>
			<?//=drawSelectBoxDate("searchBirthMonth", 1, 12, 1, $_REQUEST['searchBirthMonth'], "", $LNG_TRANS_CHAR["CW00022"],"")?><?//=$LNG_TRANS_CHAR["CW00013"] //월?>
			<?//=drawSelectBoxDate("searchBirthDay", 1, 31, 1, $_REQUEST['searchBirthDay'], "", $LNG_TRANS_CHAR["CW00022"],"")?><?//=$LNG_TRANS_CHAR["CW00014"] //일?>
		</td>
		<th><?//=$LNG_TRANS_CHAR["MW00070"] //추천인ID?></th>
		<td>
			<!-- input type="text" <?=$nBox?>  style="width:100px;" id="searchRecId" name="searchRecId" maxlength="10" value="<?=$_REQUEST['searchRecId']?>"/ //-->
		</td>
	</tr>

</table>
<?endif;?>