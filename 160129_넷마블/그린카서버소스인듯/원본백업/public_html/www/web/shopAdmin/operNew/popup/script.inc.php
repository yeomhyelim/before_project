<script type="text/javascript">
<!--
	function goPopupWriteMoveEvent()				{ goPopupWriteMove();				}
	function goPopupWriteActEvent()					{ goPopupWriteAct();				}
	function goPopupWriteCancelEvent()				{ goPopupWriteCancel();				}
	function goPopupModifyMoveEvent(po_no)			{ goPopupModifyMove(po_no);			}
	function goPopupDeleteActEvent(po_no)			{ goPopupDeleteAct(po_no);			}
	function goPopupModifyActEvent()				{ goPopupModifyAct();				}
	function goPopupModifyCancelEvent()				{ goPopupModifyCancel();			}
	function goSortMoveEvent(sortType)				{ goSortMove(sortType);				}

	$(document).ready(function(){

	});

	function goPopupWriteMove() {
		var data			= new Array(5);
		data['menuType']	= $("input[name=menuType]").val();
		data['mode']		= "popupWrite";
		C_getSelfMove(data);
	}

	function goPopupWriteAct() {
		var mode	= "popupWrite";
		var act		= "./";
		C_getFileAction(mode, act);
	}

	function goPopupWriteCancel() {
		var data			= new Array(5);
		data['menuType']	= $("input[name=menuType]").val();
		data['mode']		= "popupList";
		C_getSelfMove(data);
	}

	function goPopupModifyMove(po_no) {
		var data			= new Array(5);
		data['menuType']	= $("input[name=menuType]").val();
		data['mode']		= "popupModify";
		data['po_no']		= po_no;
		C_getSelfMove(data);
	}

	function goPopupDeleteAct(po_no) {
		var x = confirm("삭제 하시겠습니까?"); 
		if (!x) { return; }

		var data			= new Array(5);
		data['menuType']	= $("input[name=menuType]").val();
		data['mode']		= "act";
		data['act']			= "popupDelete";
		data['po_no']		= po_no;
		C_getSelfAction(data);
	}

	function goPopupModifyAct() {
		var mode	= "popupModify";
		var act		= "./";
		C_getFileAction(mode, act);
	}

	function goPopupModifyCancel() {
		var data			= new Array(5);
		data['menuType']	= $("input[name=menuType]").val();
		data['mode']		= "popupList";
		C_getSelfMove(data);	
	}

	function goSortMove(sortType) {
		var data			= new Array(5);
		data['menuType']	= $("input[name=menuType]").val();
		data['mode']		= "popupList";
		data['sortType']	= sortType;
		C_getSelfMove(data);
	}

//-->
</script>

