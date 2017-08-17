
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
