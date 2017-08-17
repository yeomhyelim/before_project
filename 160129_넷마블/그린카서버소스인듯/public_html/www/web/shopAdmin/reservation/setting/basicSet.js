// 준성수기 폼 추가 

function goAddFormEvent(myThis) {
alert("ok");
//		// 기본 설정
//		var objTarget = $(myThis).parent().parent();
//		var objClone = $(myThis).parent().clone();
//
//		// 추가버튼 삭제로 변경
//		var strHtml = '<a href="javascript:void(0);" onclick="goDelEvent(this);"  class="btn_sml"><span>- 삭제</span></a>';
//		objClone.find('a').remove();
//		objClone.append(strHtml);
//
//		// 체크박스 초기화
////		objClone.find('input').val('');
////		objClone.find('select option:first').attr('selected', true);
//		
//		// 복사
//		objTarget.append(objClone);
	}

	//추가 준성수기 폼 삭제

	function goDelEvent(myThis) {
		
		$(myThis).parent().remove();

	}