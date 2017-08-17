<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();

	$intM_NO	= $_POST["no"]			? $_POST["no"]			: $_REQUEST["no"];

	## 설정
	## 언어 설정
	$aryUseLng			= explode("/", $S_USE_LNG);

	## 회원소속관리 불러오기
	$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
	//include_once $fileName;
	//member.cate.inc.php 파일 자체가 아예 없음.
	if(is_file($fileName)):
		require_once "$fileName";
	endif;

## 키워드 검색
	$strSearchQuery					= "";
	$strSearchField					= $_REQUEST['searchField'];
	$strSearchKey					= $_REQUEST['searchKey'];

	if($strSearchKey):
		// 검색어
		$arySearchField['id']			= "M.M_ID LIKE ('%{$strSearchKey}%')";														// 아이디
		$arySearchField['name']			= "(M.M_F_NAME LIKE ('%{$strSearchKey}%') OR M.M_L_NAME LIKE ('%{$strSearchKey}%'))";		// 이름
		$arySearchField['nick']			= "M.M_NICK_NAME LIKE ('%{$strSearchKey}%')";												// 닉네임
		$arySearchField['email']		= "M.M_MAIL LIKE ('%{$strSearchKey}%')";													// 이메일
		$arySearchField['phone']		= "M.M_PHONE LIKE ('%{$strSearchKey}%')";													// 전화번호
		$arySearchField['fax']			= "M.M_FAX LIKE ('%{$strSearchKey}%')";														// 팩스번호
		$arySearchField['hp']			= "M.M_HP LIKE ('%{$strSearchKey}%')";														// 휴대폰
		$arySearchField['zip']			= "M.M_ZIP LIKE ('%{$strSearchKey}%')";														// 우편번호
		$arySearchField['address']		= "(M.M_ADDR LIKE ('%{$strSearchKey}%') OR M.M_ADDR2 LIKE ('%{$strSearchKey}%'))";			// 주소
		
		$strSearchQuery					= "";
		foreach($arySearchField as $key => $val):
			if($strSearchQuery) { $strSearchQuery .= " OR "; }
			$strSearchQuery				.= $val;
		endforeach;
		if($arySearchField[$strSearchField]) { $strSearchQuery = $arySearchField[$strSearchField]; }
	endif;
	
	## 소속 검색
	if($_REQUEST['searchNation'] || $_REQUEST['searchCate1'] || $_REQUEST['searchCate2'] || $_REQUEST['searchCate3'] || $_REQUEST['searchCate4']):
		
		## 설정
		require_once MALL_CONF_LIB."memberCateMgr.php";
		$memberCateMgr			= new MemberCateMgr();

		## 검색 카테고리 설정
		$cateCode				= "";
		if($_REQUEST['searchCate1']) { $cateCode = $_REQUEST['searchCate1']; }
		if($_REQUEST['searchCate2']) { $cateCode = $_REQUEST['searchCate2']; }
		if($_REQUEST['searchCate3']) { $cateCode = $_REQUEST['searchCate3']; }
		if($_REQUEST['searchCate4']) { $cateCode = $_REQUEST['searchCate4']; }

		## 데이터
		$param								= "";
		$param['MEMBER_CATE_MGR_JOIN']		= "Y";
		$param['C_NATION']					= $_REQUEST['searchNation'];
		$param['C_CODE']					= $cateCode;
//		$aryMemberCate						= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param);		
//		$searchMemberCate					= implode(",", $aryMemberCate);				
	endif;

	## 리스트
	$param								= "";
	$param['SEARCH_QUERY']				= $strSearchQuery;
	$param['M_CATE']					= $cateCode;
		
	$intPage							= $_REQUEST['page'];
	$intTotal							= $memberMgr->getMemberListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수 
	$intPageLine						= 10;																		// 리스트 개수 
	$intPage							= ( $intPage )				? $intPage		: 1;
	$intFirst							= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
//			$param['TE_WRITE_TOTAL_COLUMN']		= "Y";
	$param['ORDER_BY']					= $arySortType[$sortType];
	$param['LIMIT']						= "{$intFirst},{$intPageLine}";
	$result								= $memberMgr->getMemberListEx($db, "OP_LIST", $param);

	$intPageBlock						= 10;																		// 블럭 개수 
	$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage							= ceil( $intTotal / $intPageLine );

?>
<script type="text/javascript">
<!--
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

	function goSearch(){
		var data							= new Array(30);
		data['searchField']					= $("#searchField").val();
		data['searchKey']					= $("#searchKey").val();
		data['searchNation']				= $("select[name=searchNation]").val();
		data['searchCate1']					= $("select[name=searchCate1]").val();
		data['searchCate2']					= $("select[name=searchCate2]").val();
		data['searchCate3']					= $("select[name=searchCate3]").val();
		data['searchCate4']					= $("select[name=searchCate4]").val();
		data['page']						= 1;
		C_getAddLocationUrl(data);	
	}

	function goMemberPointMoveAct()
	{
		var strSelectCodeList = "";
		var strHtml = "";
		
		$("input[id^=chkNo]").each(function() {
			
			if ($(this).is(":checked")){
				var isDupChk = "";
				var intM_NO = $(this).val();
				$(opener.document).find("input[id^=chkMemMoveNo]").each(function(){
					if ($(this).val() == intM_NO)
					{
						isDupChk = "Y";
						return false;
					}
				});
				
				if (isDupChk != "Y")
				{
					var strMemberInfo = $("#spanMemInfo_"+$(this).val()).text();
					strHtml += "<li><input type=\"hidden\" name=\"chkMemMoveNo[]\" id=\"chkMemMoveNo[]\" value=\""+$(this).val()+"\">";
					strHtml += "		"+strMemberInfo+"<a href=\"javascript:goMovSelectMemDelete(this);\">[x]</a>";
					strHtml += "</li>";

				}
			}
		});
		opener.goMoveMemInsert(strHtml);
		//parent.goPopClose();

	}

//-->
</script>

<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
	});

//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>포인트를 이동할 회원 검색</h2>
		<a  href="javascript:self.close();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
	<div id="contentWrap">
		<div class="paymentInfo mt20">
			<ul>
				<li>
					<select id="searchField" style="width:133px">
						<option value=""		<?if($strSearchField == "")			{echo " selected";}?>>전체</option>
						<option value="id"		<?if($strSearchField == "id")		{echo " selected";}?>>아이디</option>
						<option value="name"	<?if($strSearchField == "name")		{echo " selected";}?>>이름</option>
						<option value="nick"	<?if($strSearchField == "nick")		{echo " selected";}?>>닉네임</option>
						<option value="email"	<?if($strSearchField == "email")	{echo " selected";}?>>이메일</option>
						<option value="phone"	<?if($strSearchField == "phone")	{echo " selected";}?>>전화번호</option>
						<option value="fax"		<?if($strSearchField == "fax")		{echo " selected";}?>>팩스번호</option>
						<option value="hp"		<?if($strSearchField == "hp")		{echo " selected";}?>>휴대폰</option>
						<option value="zip"		<?if($strSearchField == "zip")		{echo " selected";}?>>우편번호</option>
						<option value="address"	<?if($strSearchField == "address")	{echo " selected";}?>>주소</option>
					</select>
					<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> data-enter-event="goSearch" data-auto-focus/>
					<a class="btn_blue_big" href="javascript:goSearch();" style="width:50px;text-align:center"><strong>검색</strong></a>
				</li>
				<li>
					<select name="searchNation" id="c_nation">
						<option value=""<?if($_REQUEST['searchNation'] == ""){ echo " selected";}?>>전체</option>
						<?foreach($aryUseLng as $key => $lng):?>
						<option value="<?=$lng?>"<?if($_REQUEST['searchNation'] == $lng){ echo " selected";}?>><?=$S_ARY_COUNTRY[$lng]?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate1" id="c_cate" no="1">
						<option value=""<?if($_REQUEST['searchCate1'] == ""){ echo " selected";}?>>1차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 1) { continue; }				?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate1'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate2" id="c_cate" no="2">
						<option value=""<?if($_REQUEST['searchCate2'] == ""){ echo " selected";}?>>2차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 2) { continue; }				?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate2'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate3" id="c_cate" no="3">
						<option value=""<?if($_REQUEST['searchCate3'] == ""){ echo " selected";}?>>3차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 3) { continue; }				?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate3'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate4" id="c_cate" no="4">
						<option value=""<?if($_REQUEST['searchCate4'] == ""){ echo " selected";}?>>4차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 4) { continue; }				?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate4'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
				</li>
			</ul>
		</div>
		<!-- (1) 회원 정보 -->
		<div class="tableList mt10">
			<form name="form" method="post">
			<input type="hidden" name="menuType" value="<?=$strMenuType?>">
			<input type="hidden" name="mode" value="<?=$strMode?>">
			<input type="hidden" name="act" value="<?=$strMode?>">
			<input type="hidden" name="page" value="<?=$intPage?>">
				<table>
					<colgroup>
						<col style="width:50px;"/>
						<col/>
					</colgroup>
					<tr>
						<th></th>
						<th>번호</th>
						<th>회원ID</th>
						<th>연락처/이메일</th>
						<th>포인트</th>
					</tr>
					<?if ($intTotal == 0){?>
					<tr>
						<td colspan="12"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
					</tr>
					<?}else{
						while($row = mysql_fetch_array($result)){
							$strM_NAME = $row['M_ID'];
							if ($row['M_L_NAME']) $strM_NAME .= "(".$row['M_L_NAME'].")";
							if ($S_MEM_CERITY == "2"){
								$strM_NAME = $row['M_NAME'];
							}
					?>
					<tr>
						<td><input type="checkbox" name="chkNo[]" id="chkNo[]" value="<?=$row[M_NO]?>" <?=($intM_NO == $row['M_NO'])?"disabled":"";?>></td>
						<td><?=number_format($intListNum);?></td>
						<td><span id="spanMemInfo_<?=$row[M_NO]?>"><?=$strM_NAME?></span></td>
						<td><?=$row[M_HP]?>/<?=$row[M_MAIL]?></td>
						<td><?=number_format($row['M_POINT']);?></td>
					</tr>
					<?		$intListNum--;
						}}?>
					
				</table>
			</form>
		</div>
		<div class="buttonWrap">
			<a class="btn_big" href="javascript:goMemberPointMoveAct();"><strong>선택</strong></a>
			<a class="btn_big" href="javascript:javascript:self.close();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //창닫기?></strong></a>
		</div>
	</div>
</div>
</body>
</html>