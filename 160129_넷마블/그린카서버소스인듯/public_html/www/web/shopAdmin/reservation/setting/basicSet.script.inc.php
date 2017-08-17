<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		//C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name^=searchRegStartDt]').simpleDatepicker();
		$('input[name^=searchRegEndDt]').simpleDatepicker();
		$('input[name^=searchRegStart_Dt]').simpleDatepicker();
		$('input[name^=searchRegEnd_Dt]').simpleDatepicker();
	});

	function goAct()
	{
		C_getAction("basicSetSave","<?=$PHP_SELF?>");
	}

	//준성수기 폼 추가
	function goAddFormEvent(myThis) {

		// 기본 설정
		var objTarget = $(myThis).parent().parent();
		var objClone = $(myThis).parent().clone();

		// 추가버튼 삭제로 변경
		var strHtml = '<a href="javascript:void(0);" onclick="goDelEvent(this);"  class="btn_sml"><span>- 삭제</span></a>';
		objClone.find('a').remove();
		objClone.append(strHtml);

		// 체크박스 초기화
		objClone.find('input').val('');

		// 복사
		objTarget.append(objClone);

		$('input[name^=searchRegStartDt]').simpleDatepicker();
		$('input[name^=searchRegEndDt]').simpleDatepicker();
		$('input[name^=searchRegStartDt2]').simpleDatepicker();
		$('input[name^=searchRegEndDt2]').simpleDatepicker();
	}

	//추가 준성수기 폼 삭제
	function goDelEvent(myThis) {

		$(myThis).parent().remove();

	}

	function goTimeDelete(no){
		var x = confirm("선택한 데이터를 삭제하시겠습니까?");
		if (x==true)
		{
			var data = new Object;
			data['menuType']	= "reservation";
			data['mode']		= "act";
			data['act']			= "timeDelete";
			data['no']			= no;

			C_getSelfAction(data);
		}
	}
//-->
</script>
