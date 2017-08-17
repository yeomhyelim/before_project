<?
	## 설정
	## 배송회사 리스트
	if(!$aryDeliveryComAll):
		$aryDeliveryComAll = getCommCodeList("DELIVERY", "Y");
	endif;

	## 결제방법 검색 결과를 배열로 변경
	$searchSettleType = explode(",", $_REQUEST['searchSettleType']);

	## 검색 디폴트
	if(!$_REQUEST["searchField"]) { $_REQUEST["searchField"] = "orderHp"; }

	## 회원구분 검색
	$strSearchMemberType = $_REQUEST['searchMemberType'];

	if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){
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
		foreach($aryMemberCateList as $key => $c_code):
			$temp1		= substr($c_code, 0, 3);
			$temp2		= substr($c_code, 0, 6);
			$temp3		= substr($c_code, 0, 9);
			$temp4		= substr($c_code, 0, 12);
			$length		= strlen($c_code);
			foreach($MEMBER_CATE as $code => $data):
			//				echo strlen($c_code) . "";
				if($temp1 == substr($code, 0, $length)  && !in_array($code, $aryMemberCate)) { $aryMemberCate[] = $code; }
				if($temp2 == substr($code, 0, $length)  && !in_array($code, $aryMemberCate)) { $aryMemberCate[] = $code; }
				if($temp3 == substr($code, 0, $length)  && !in_array($code, $aryMemberCate)) { $aryMemberCate[] = $code; }
				if($temp4 == substr($code, 0, $length) && !in_array($code, $aryMemberCate)) { $aryMemberCate[] = $code; }
			endforeach;
		endforeach;

		//		print_r($aryMemberCate);
	}

	## 입점업체 리스트
	if ($a_admin_type == "A"){
		if ($ADMIN_SHOP_SELECT_USE == "Y"){
			if ($a_admin_tm == "Y" && $a_admin_shop_list) {
				/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
				$param['SHOP_LIST'] = $a_admin_shop_list;
			}
		}
		$aryShopList = $productMgr->getShopList($db,$param);
	}

	## 상담관리 메모 상담상태 리스트
	if($strMode == "list" || $strMode == "deliveryList"):
		$strSearchOrderMemo		= $_GET['searchOrderMemo'];

		include_once SHOP_HOME . "/conf/community/board.USER_REPORT.info.php";
		$strMemoState			= $BOARD_INFO['USER_REPORT']['bi_ad_temp1_kind_data'];
		$aryMemoState			= explode(";", $strMemoState);
	endif;
?>
<script type="text/javascript">
<!--
	<?	if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){?>
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

	function goSearchDataSet(data)
	{
		data['searchOrderStatus']		= "<?=$_REQUEST['searchOrderStatus']?>";
		data['searchField']				= $("select[id=searchField]").val();
		data['searchKey']				= $("input[id=searchKey]").val();
		///data['searchMemberType']		= $("input[id=searchMemberType]:checked").val();
        data['searchMemberType']		= "member"; //일반회원만..
		data['searchDeliveryStatus']	= $("select[id=searchDeliveryStatus]").val();
		data['searchDeliveryCom']		= $("select[id=searchDeliveryCom]").val();
		data['searchRegStartDt']		= $("input[id=searchRegStartDt]").val();
		data['searchRegEndDt']			= $("input[id=searchRegEndDt]").val();


		<?if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){?>
		data['searchNation']			= $("select[name=searchNation]").val();
		data['searchCate1']				= $("select[name=searchCate1]").val();
		data['searchCate2']				= $("select[name=searchCate2]").val();
		data['searchCate3']				= $("select[name=searchCate3]").val();
		data['searchCate4']				= $("select[name=searchCate4]").val();
		<?}?>

		var searchSettleType			= "";
		$("input:checkbox[id='searchSettleType']:checked").each(function() {
			if(searchSettleType)		{ searchSettleType = searchSettleType + ","; }
			searchSettleType			= searchSettleType + $(this).val();
		});
		data['searchSettleType']		= searchSettleType;

		<?if($a_admin_type == "A"):?>
		data['searchShop']				= $("select[name=searchShop]").val();
		<?endif;?>

		<?if($strMode == "list" || $strMode == "deliveryList"){?>
		//data['searchOrderMemo']			= $("select[name=searchOrderMemo]").val();
		<?}?>

		data['pageLine']				= ($("select[name=pageLine]").val()) ? $("select[name=pageLine]").val() : 50;


		data['searchMemberGroup1']				= $("input:checkbox[name='searchMemberGroup1']:checked").myVal();
		data['searchMemberGroup2']				= $("input:checkbox[name='searchMemberGroup2']:checked").myVal();
		data['page']						= 1;

		var searchGroup						= "";
		$("input:checkbox[id='searchGroup']:checked").each(function() {
			if(searchGroup) { searchGroup = searchGroup + ","; }
			searchGroup = searchGroup + "'" + $(this).myVal() + "'";
		});
		data['searchGroup']					= searchGroup;



		return data;
	}

	function goSearch(){
		if(C_dataEmptyCheck()){ return false; }
		var data						= new Array(5);

		data							= goSearchDataSet(data);
		data['searchYN']				= "Y";

		C_getAddLocationUrl(data);
	}
	$.fn.myVal = function() {
		if($(this).length <= 0) { return ""; }
		return $(this).val();
	}

	$.fn.myCheckVal = function() {
		var data = "";
		$(this).each(function() {
			if(data) { data = data + ","; }
			data = data + $(this).myVal();
		});
		return data;
	}
//-->
</script>
<!-- 기본 검색 -->
<div class="searchFormWrap">
	<select name="searchField" id="searchField">

		<option value="orderNum"	<?if($_REQUEST["searchField"]=="orderNum")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["OW00002"]; //주문번호?></option>
		<option value="deliveryNum"	<?if($_REQUEST["searchField"]=="deliveryNum"){echo " selected";}?>><?= $LNG_TRANS_CHAR["OW00175"]; //배송번호?></option>
		<option value="orderName"	<?if($_REQUEST["searchField"]=="orderName")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["OW00003"] //주문자?></option>
		<option value="orderHp"	<?if($_REQUEST["searchField"]=="orderHp"){echo " selected";}?>><?=$LNG_TRANS_CHAR["OW00171"] //주문자핸드폰?></option>
		<option value="orderMail"	<?if($_REQUEST["searchField"]=="orderMail"){echo " selected";}?>><?="주문자메일" //주문자메일?></option>
		<option value="orderDeliveryName"	<?if($_REQUEST["searchField"]=="orderDeliveryName"){echo " selected";}?>><?="받는사람" //수신인?></option>
		<option value="orderDeliveryHp"	<?if($_REQUEST["searchField"]=="orderDeliveryHp"){echo " selected";}?>><?="받는사람핸드폰" //받는사람핸드폰?></option>
		<option value="orderId"		<?if($_REQUEST["searchField"]=="orderId")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["OW00004"] //회원ID?></option>
	</select>
	<input type="text" id="searchKey" name="searchKey" value="<?=$_REQUEST["searchKey"]?>" <?=$nBox?>/>
	<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"]?></strong></a>
</div>
<table>
<!--
	<tr>
		<th><?=$LNG_TRANS_CHAR["OW00070"] //회원구분?></th>
		<td>
			<input type="radio" name="searchMemberType" id="searchMemberType" value=""			<?if($strSearchMemberType=="")			{echo " checked"; }?>> <?=$LNG_TRANS_CHAR["CW00022"] //전체?>
			<input type="radio" name="searchMemberType" id="searchMemberType" value="member"	<?if($strSearchMemberType=="member")	{echo " checked"; }?>> <?=$LNG_TRANS_CHAR["OW00071"] //회원?>
			<input type="radio" name="searchMemberType" id="searchMemberType" value="nonmember"	<?if($strSearchMemberType=="nonmember")	{echo " checked"; }?>> <?=$LNG_TRANS_CHAR["OW00072"] //비회원?>
		</td>
	</tr>
 -->
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
	<?	if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){?>
	<tr>
		<th>소속</th>
		<td  colspan="3">
			<select name="searchNation" id="c_nation">
				<option value=""<?if($_REQUEST['searchNation'] == ""){ echo " selected";}?>>전체</option>
				<?foreach($aryUseLng as $key => $lng):?>
				<option value="<?=$lng?>"<?if($_REQUEST['searchNation'] == $lng){ echo " selected";}?>><?=$S_ARY_COUNTRY[$lng]?></option>
				<?endforeach;?>
			</select>
			<select name="searchCate1" id="c_cate" no="1">
				<option value=""<?if($_REQUEST['searchCate1'] == ""){ echo " selected";}?>>1차 카테고리</option>
				<?foreach($MEMBER_CATE as $code => $data):
					if($data['C_LEVEL'] != 1) { continue; }
					if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
				<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate1'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
				<?endforeach;?>
			</select>
			<select name="searchCate2" id="c_cate" no="2">
				<option value=""<?if($_REQUEST['searchCate2'] == ""){ echo " selected";}?>>2차 카테고리</option>
				<?foreach($MEMBER_CATE as $code => $data):
					if($data['C_LEVEL'] != 2) { continue; }
					if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
				<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate2'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
				<?endforeach;?>
			</select>
			<select name="searchCate3" id="c_cate" no="3">
				<option value=""<?if($_REQUEST['searchCate3'] == ""){ echo " selected";}?>>3차 카테고리</option>
				<?foreach($MEMBER_CATE as $code => $data):
					if($data['C_LEVEL'] != 3) { continue; }
					if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
				<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate3'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
				<?endforeach;?>
			</select>
			<select name="searchCate4" id="c_cate" no="4">
				<option value=""<?if($_REQUEST['searchCate4'] == ""){ echo " selected";}?>>4차 카테고리</option>
				<?foreach($MEMBER_CATE as $code => $data):
					if($data['C_LEVEL'] != 4) { continue; }
					if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
				<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate4'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
				<?endforeach;?>
			</select>
		</td>
	</tr>
	<?}?>
	<tr>
		<th><?= $LNG_TRANS_CHAR["OW00172"]; //배송관련?></th>
		<td>
			<select id="searchDeliveryStatus" name="searchDeliveryStatus">
				<option value=""><?= $LNG_TRANS_CHAR["SW00074"]; //배송상태 ?></option>
				<?foreach($S_ARY_DELIVERY_STATUS as $key => $value):?>
				<option value="<?=$key?>"<?if($_REQUEST['searchDeliveryStatus'] == $key){echo " selected";}?>><?=$value?></option>
				<?endforeach;?>
			</select>
			<select id="searchDeliveryCom" name="searchDeliveryCom">
				<option value=""><?= $LNG_TRANS_CHAR["OW00053"]; //배송회사 ?></option>
				<?foreach($aryDeliveryComAll as $key => $val):?>
				<option value="<?=$key?>"<?if($_REQUEST['searchDeliveryCom'] == $key){echo " selected";}?>><?=$val?></option>
				<?endforeach;?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["OW00005"] //주문일?></th>
		<td>
			<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$_REQUEST['searchRegStartDt']?>"//>
			~
			<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$_REQUEST['searchRegEndDt']?>"//>
			<span class="searchWrapImg">
				<a href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');" class="btn_sml"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
				<a href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');" class="btn_sml"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
				<a href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');" class="btn_sml"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
				<a href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');" class="btn_sml"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
				<a href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');" class="btn_sml"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
				<a href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');" class="btn_sml"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
			</span>
		</td>
	</tr>
	<?if ($a_admin_type != "S"){
		$strSearchSettleType = explode(",",$_REQUEST['searchSettleType']);
	?>
	<tr>
		<th><?=$LNG_TRANS_CHAR["OW00006"] //결제방법?></th>
		<td>
			<?foreach($S_ARY_SETTLE_TYPE as $key => $value):?>
			<input type="checkbox" id="searchSettleType" name="searchSettleType[]" value="<?=$key?>"<?if(in_array($key, $strSearchSettleType)){echo " checked";}?>><?=$value?>
			<?endforeach;?>
		</td>
	</tr>
	<?}?>
	<!--tr>
		<th><?=$LNG_TRANS_CHAR["OW00010"] //주문상태?></th>
		<td>
			<select>
				<option>주문상태선택</option>
				<?foreach($S_ARY_SETTLE_STATUS as $key => $value):?>
				<option><?=$value?></option>
				<?endforeach;?>
			</select>
		</td>
	</tr-->
	<?if($a_admin_type != "S" && is_array($aryShopList)):?>
	<tr>
		<th>입점사</th>
		<td>
			<select name="searchShop" id="searchShop" style="width:200px">
				<option value=""<?if($_REQUEST["searchShop"] == ""){ echo " selected";}?>>전체</option>
				<?foreach($aryShopList as $key => $data): ?>
				<option value="<?=$key?>"<?if($_REQUEST["searchShop"] == "{$key}"){ echo " selected";}?>><?=$data?></option>
				<?endforeach;?>
			</select>
		</td>
	</tr>
	<?endif;?>
	<?if($strMode == "list" || $strMode == "deliveryList"){?>
	<tr>
		<!--
		<th><?= $LNG_TRANS_CHAR["CW00029"]; //메모 ?></th>
		<td>
			<select name="searchOrderMemo">
				<option value="">전체</option>
				<option value="justList">선택없음</option>
				<?foreach($aryMemoState as $key => $data):?>
				<option value="<?=$data?>"<?if($strSearchOrderMemo==$data){echo " selected";}?>><?=$data?></option>
				<?endforeach;?>
			</select>
		</td>
		-->
	</tr>
	<?}?>
</table>