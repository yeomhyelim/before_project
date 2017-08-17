<?	
	#/*====================================================================*/# 
	#|작성자	: 박영미(ivetmi@naver.com)									|# 
	#|작성일	: 2013-08-16												|# 
	#|작성내용	: 포인트선물하기(회원검색)									|# 
	#/*====================================================================*/# 
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."memberCateMgr.php";

	$memberMgr		= new MemberMgr();
	$memberCateMgr	= new MemberCateMgr();

	$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.inc.php";
	//include_once $fileName;
	if(is_file($fileName)):
		require_once "$fileName";
	endif;

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
	
	if ($strSearchKey && $strSearchField) {

		if($strSearchKey):
			// 검색어			
			$arySearchField['hp']			= "M.M_HP LIKE ('%{$strSearchKey}%')";														// 휴대폰
			$arySearchField['tmp1']			= "MA.M_TMP1 LIKE ('%{$strSearchKey}%')";													// TMP1
			
			$strSearchQuery					= "";
			foreach($arySearchField as $key => $val):
				if($strSearchQuery) { $strSearchQuery .= " OR "; }
				$strSearchQuery				.= $val;
			endforeach;
			if($arySearchField[$strSearchField]) { $strSearchQuery = $arySearchField[$strSearchField]; }
		endif;
		

		## 리스트
		$param								= "";
		$param['SEARCH_QUERY']				= $strSearchQuery;
		
		$param['MEMBER_ADD_MGR_JOIN']		= "Y";
	
		$param['NOT_M_NO']					= $g_member_no;

		$intPage							= $_REQUEST['page'];
		$intTotal							= $memberMgr->getMemberListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수 

		$intPageLine						= 10;																		// 리스트 개수 
		$intPage							= ( $intPage )				? $intPage		: 1;
		$intFirst							= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

		$param['ORDER_BY']					= $arySortType[$sortType];
		$param['LIMIT']						= "{$intFirst},{$intTotal}";
		$result								= $memberMgr->getMemberListEx($db, "OP_LIST", $param);

		$intPageBlock						= 10;																		// 블럭 개수 
		$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
		$intTotPage							= ceil( $intTotal / $intPageLine );	
	}

?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	$(document).ready(function(){

	});


	
	function goSearch(){
		if(!C_chkInput("searchKey",true,"검색어",true)) return; //검색어
		
		var data							= new Array(30);
		data['searchField']					= $("#searchField").val();
		data['searchKey']					= $("#searchKey").val();
		data['page']						= 1;
		C_getAddLocationUrl(data);	
	}

	function goMemberPointMoveApply()
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
					var strMemberInfo = $("#ulMemberCateList_"+$(this).val()+" > li").eq(0).text()+" ["+$("#spanMemberName_"+$(this).val()).text()+"]";
					strHtml += "<li><input type=\"hidden\" name=\"chkMemMoveNo[]\" id=\"chkMemMoveNo[]\" value=\""+$(this).val()+"\">";
					strHtml += "		"+strMemberInfo+"<a href=\"javascript:goMemberPointMoveDelete(this);\">[x]</a>";
					strHtml += "</li>";

				}
			}
		});

		if (C_isNull(strHtml))
		{
			alert("선택된 회원이 없습니다.");
			return;
		}

		opener.goMemberPointMoveInsert(strHtml);
		self.close();
	}
//-->
</script>
<body>
<div class="popContainer">
	<div class="addrHight">
	<h2>포인트 선물하기</h2>
	<form name='form' method='post' id="form">
	<input type="hidden" name="menuType" value="member">
	<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" id="act" value="<?=$strMode?>">

	<div>
		<select id="searchField" style="width:133px">
			<option value="hp"		<?if($strSearchField == "hp")		{echo " selected";}?>>휴대폰</option>
			<?if($S_JOIN_TMP_1['USE'] == "Y"){?>
			<option value="tmp1"	<?if($strSearchField == "tmp1")		{echo " selected";}?>><?=$S_JOIN_TMP_1['NAME_'.$S_SITE_LNG]?></option>
			<?}?>
		</select>
		<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> data-enter-event="goSearch" data-auto-focus/>
		<a href="javascript:goSearch();"><span>검색</span></a>
	</div>
	<div class="popTableList">
		<table>
			<tr>
				<th>선택</th>
				<th>소속</th>
				<th class="nameDiv">이름</th>
			<tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="3">검색된 회원이 없습니다.</td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
					if ($row['M_L_NAME']) $strM_NAME = $row['M_L_NAME'];
					if ($S_MEM_CERITY == "2"){
						$strM_NAME = $row['M_NAME'];
					}

					$param = "";
					$param['M_NO'] = $row['M_NO'];
					$aryMemberCateList = $memberCateMgr->getMemberCateJoinListEx($db,"OP_ARYTOTAL",$param);
			?>
			<tr>
				<td><input type="checkbox" name="chkNo[]" id="chkNo[]" value="<?=$row[M_NO]?>"></td>
				<td>
					<ul id="ulMemberCateList_<?=$row['M_NO']?>">
					<?
					if (is_array($aryMemberCateList)){
						foreach($aryMemberCateList as $key => $data){
							$strMemberCate1 = substr($data['C_CODE'],0,3);
							$strMemberCate2 = (substr($data['C_CODE'],3,6)) ? substr($data['C_CODE'],0,6) : "";
							$strMemberCate3 = (substr($data['C_CODE'],6,9)) ? substr($data['C_CODE'],0,9) : "";
							$strMemberCate4 = (substr($data['C_CODE'],9))	? substr($data['C_CODE'],0,12) : "";

							echo "<li>";
							
							if ($strMemberCate1) echo $MEMBER_CATE[$strMemberCate1]['C_NAME'];
							if ($strMemberCate2) echo " > ".$MEMBER_CATE[$strMemberCate2]['C_NAME'];
							if ($strMemberCate3) echo " > ".$MEMBER_CATE[$strMemberCate3]['C_NAME'];
							if ($strMemberCate4) echo " > ".$MEMBER_CATE[$strMemberCate4]['C_NAME'];
							
							echo "</li>";
						}
					}
					?>
					</ul>
				</td>
				<td><span id="spanMemberName_<?=$row['M_NO']?>"><?=$strM_NAME?></a></span></td>
			</tr>
			<?		$intListNum--;
				}}?>
			
		</table>
	</div>

	<div class="btnCenter">
		<a href="javascript:goMemberPointMoveApply();"><span>적용</span></a>
		<a href="javascript:self.close();" class="popCloseBtn"><span><?=$LNG_TRANS_CHAR["CW00034"] //닫기?></span></a>
	</div>
	</form>
</div>
</body>
</html>