
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
	function gogetSearchDay(st){

		var dt1 = $('[name=hiddendate1]').val();
		var dt2 = $('[name=hiddendate2]').val();
		var dt3 = $('[name=hiddendate3]').val();
		var dt4 = $('[name=hiddendate4]').val();
		var dt5 = $('[name=hiddendate5]').val();

		if(st=="0"){$('[id=searchRegStartDt]').val(dt1);$('[id=searchRegEndDt]').val(dt1);return;}
		if(st=="1"){$('[id=searchRegStartDt]').val(dt1);$('[id=searchRegEndDt]').val(dt2);return;}
		if(st=="2"){$('[id=searchRegStartDt]').val(dt1);$('[id=searchRegEndDt]').val(dt3);return;}
		if(st=="3"){$('[id=searchRegStartDt]').val(dt1);$('[id=searchRegEndDt]').val(dt4);return;}
		if(st=="4"){$('[id=searchRegStartDt]').val(dt1);$('[id=searchRegEndDt]').val(dt5);return;}
		if(st=="5"){$('[id=searchRegStartDt]').val(dt1);$('[id=searchRegEndDt]').val(dt1);return;}
	}

	function goShowDetailInfo(i) //객실상세정보 보기
	{
		var status = $('[name=detail' + i +']').val();

		if(status=="1"){
			$('[name=hiddenroomsetting' + i +']').hide();
			$('[name=detail' + i +']').empty();
			$('[name=detail' + i +']').append("상세보기↓");
			$('[name=detail' + i +']').val("2");
			return;
		}
		$('[name=hiddenroomsetting' + i +']').show();
		$('[name=detail' + i +']').empty();
		$('[name=detail' + i +']').append("상세보기↑");
		$('[name=detail' + i +']').val("1");

	}

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
		data['searchVisitStartCnt']			= $("#searchVisitStartCnt").myVal();
		data['searchVisitEndCnt']			= $("#searchVisitEndCnt").myVal();
		data['searchSex']					= $(":radio[name=searchSex]:checked").myVal();
		data['searchMailYN']				= $(":radio[name=searchMailYN]:checked").myVal();
		data['searchSmsYN']					= $(":radio[name=searchSmsYN]:checked").myVal();
		data['searchBirthMonth']			= $("#searchBirthMonth").myVal();
		data['searchBirthDay']				= $("#searchBirthDay").myVal();
		data['searchRecId']					= $("#searchRecId").myVal();
		data['page']						= 1;

		var searchGroup						= "";
		$("input:checkbox[name^='searchGroup']:checked").each(function() {
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
<div class="searchFormWrap" align="center">
	<select id="searchField" style="width:133px">
		<option value="all"		<?if($strSearchField == "all")			{echo " selected";}?>>전체</option>
		<option value="no"		<?if($strSearchField == "no")			{echo " selected";}?>>예약번호</option>
		<option value="name"	<?if($strSearchField == "name")			{echo " selected";}?>>고객명</option>
		<option value="phone"	<?if($strSearchField == "phone")		{echo " selected";}?>>연락처</option>
	</select>
	<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>"  data-enter-event="goSearch" data-auto-focus/>

<?if($strSearchOut != "Y"):?>
<table class="searchFormWrap" border="0" align="center">
	<colgroup>
		<col style="width:70px;"/>
		<col style="width:180px;"/>
		<col style="width:180px;"/>
		<col style="width:50px;"/>
	<colgroup/>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00178"] //기간 설정?></th>
		<td  colspan="3">
			<input type="text" id="searchRegStartDt" value="<?=$_REQUEST['searchRegStartDt']?>" data-simple-datepicker  style="width:80px"> -
			<input type="text" id="searchRegEndDt"   value="<?=$_REQUEST['searchRegEndDt']?>" data-simple-datepicker   style="width:80px">
			<?$strDate = date("Y-m-d");$strDate1=date("Y-m-d",strtotime($strDate.'+ 7 day'));$strDate2=date("Y-m-d",strtotime($strDate.'+ 15 day'));$strDate3=date("Y-m-d",strtotime($strDate.'+ 1 month'));$strDate4=date("Y-m-d",strtotime($strDate.'+ 2 month'));?>
			<input type="hidden" name="hiddendate1" value="<?echo $strDate;?>">
			<input type="hidden" name="hiddendate2" value="<?echo $strDate1;?>">
			<input type="hidden" name="hiddendate3" value="<?echo $strDate2;?>">
			<input type="hidden" name="hiddendate4" value="<?echo $strDate3;?>">
			<input type="hidden" name="hiddendate5" value="<?echo $strDate4;?>">
			<a class="btn_sml" href="javascript:gogetSearchDay('0');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
			<a class="btn_sml" href="javascript:gogetSearchDay('1');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
			<a class="btn_sml" href="javascript:gogetSearchDay('2');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
			<a class="btn_sml" href="javascript:gogetSearchDay('3');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
			<a class="btn_sml" href="javascript:gogetSearchDay('4');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
		</td>
	</tr>
	<tr>
		<th>예약상태</th>
		<td  colspan="3">
			<input type="checkbox" id="searchGroup[0]" name="searchGroup[0]" value="A" <?for($i=0;$i<4;$i++){if($strGroup[$i]=="'A'") { echo " checked"; }}?>>입금대기
			<input type="checkbox" id="searchGroup[1]" name="searchGroup[1]" value="B" <?for($i=0;$i<4;$i++){if($strGroup[$i]=="'B'") { echo " checked"; }}?>>입금완료
			<input type="checkbox" id="searchGroup[2]" name="searchGroup[2]" value="C" <?for($i=0;$i<4;$i++){if($strGroup[$i]=="'C'") { echo " checked"; }}?>>선금입금
			<input type="checkbox" id="searchGroup[3]" name="searchGroup[3]" value="D" <?for($i=0;$i<4;$i++){if($strGroup[$i]=="'D'") { echo " checked"; }}?>>예약취소
			<input type="checkbox" id="searchGroup[4]" name="searchGroup[4]" value="E" <?for($i=0;$i<4;$i++){if($strGroup[$i]=="'E'") { echo " checked"; }}?>>잔금입금
		</td>
	</tr>
	<tr>
		<td colspan="4" style="text-align:center">
			<a class="btn_search" href="javascript:goSearch();" style="width:400px;text-align:center"><strong class="ico_search"><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
			<a class="btn_big_reset" href="./?menuType=<?=$strMenuType?>&mode=<?=$strMode?>"><strong><?=$LNG_TRANS_CHAR["CW00085"] //초기화?></strong></a>
		</td>
	</tr>
</table>
</div>
<?endif;?>