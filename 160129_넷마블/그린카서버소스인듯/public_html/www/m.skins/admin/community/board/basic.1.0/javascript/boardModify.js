$(document).ready(function() {
	$('#bi_attachedfile_use').change(goAttachedFieldChangeShow);
});

/* 이벤트 정의 */
function goBoardListMoveEvent()						{ goBoardListMove();									}		// 목록
function goBoardModifyBasicMoveEvent()				{ goBoardModifyMove("boardModifyBasic");				}		// 기본      설정 변경(이동)
function goBoardModifyScriptMoveEvent()				{ goBoardModifyMove("boardModifyScript");				}		// 스크립트  설정 변경(이동)
function goBoardModifyCategoryMoveEvent()			{ goBoardModifyMove("boardModifyCategory");				}		// 카테고리  설정 변경(이동)
function goBoardModifyPointMoveEvent()				{ goBoardModifyMove("boardModifyPoint");				}		// 카테고리  쿠폰 변경(이동) or 포인트 설정
function goBoardModifyListMoveEvent()				{ goBoardModifyMove("boardModifyList");					}		// 리스트    설정 변경(이동)
function goBoardModifyViewMoveEvent()				{ goBoardModifyMove("boardModifyView");					}		// 보기      설정 변경(이동)
function goBoardModifyWriteMoveEvent()				{ goBoardModifyMove("boardModifyWrite");				}		// 쓰기/수정 설정 변경(이동)
function goBoardModifyDeleteMoveEvent()				{ goBoardModifyMove("boardModifyDelete");				}		// 삭제/기타 설정 변경(이동)
function goBoardModifyCommentMoveEvent()			{ goBoardModifyMove("boardModifyComment");				}		// 코멘트    설정 변경(이동)
function goBoardModifyAttachedfileMoveEvent()		{ goBoardModifyMove("boardModifyAttachedfile");			}		// 첨부파일	 설정 변경(이동)
function goBoardModifyUserfieldMoveEvent()			{ goBoardModifyMove("boardModifyUserfield");			}		// 추가필드  설정 변경(이동)
function goBoardModifyScriptWidgetMoveEvent()		{ goBoardModifyMove("boardModifyScriptWidget");			}		// 위젯편집  설정 변경(이동)

function goBoardModifyBasicAct()			{ goAct("boardModifyBasic");						}		// 기본      설정 변경(액션)
function goBoardModifyScriptAct()			{ goAct("boardModifyScript");						}		// 스크립트  설정 변경(액션)
function goBoardModifyCategoryAct()			{ goAct("boardModifyCategory");						}		// 카테고리  설정 변경(액션)
function goBoardModifyPointAct()			{ goAct("boardModifyPoint");						}		// 카테고리  쿠폰 변경(액션) or 포인트 설정
function goBoardModifyListAct()				{ goAct("boardModifyList");							}		// 리스트    설정 변경(액션)
function goBoardModifyViewAct()				{ goAct("boardModifyView");							}		// 보기      설정 변경(액션)
function goBoardModifyWriteAct()			{ goAct("boardModifyWrite");						}		// 쓰기/수정 설정 변경(액션)
function goBoardModifyDeleteAct()			{ goAct("boardModifyDelete");						}		// 삭제/기타 설정 변경(액션)
function goBoardModifyCommentAct()			{ goAct("boardModifyComment");						}		// 코멘트    설정 변경(액션)
function goBoardModifyAttachedfileAct()		{ goAct("boardModifyAttachedfile");					}		// 첨부파일  설정 변경(액션)
function goBoardModifyUserfieldAct()		{ goAct("boardModifyUserfield");					}		// 추가필드  설정 변경(액션)
function goBoardModifyScriptWidgetAct()		{ goAct("boardModifyScriptWidget");					}		// 위젯편집  설정 변경(액션)


function goBoardListMove() {
	$("#mode").val("boardList");
	var data = new Array("menuType", "mode", "searchGroup", "searchKey", "searchVal", "page");
	goLocation(data);

}

function goBoardModifyMove(mode) {
	$("#mode").val(mode);
	var data = new Array("menuType", "mode", "b_code", "searchGroup", "searchKey", "searchVal", "page");
	goLocation(data);
}

function goAttachedFieldChangeShow() {
	var intCnt = $(this).val();
	fieldOnOff(intCnt, "attachedfile_name_field");
	fieldOnOff(intCnt, "attachedfile_key_field");
}



/* 함수 */
function fieldOnOff(intCnt, idName) {
	$("tr[id="+idName+"]").each(function(i) {
		if(i<intCnt){
			$(this).css("display","");
		}else{
			$(this).css("display","none");
		}
	});
}