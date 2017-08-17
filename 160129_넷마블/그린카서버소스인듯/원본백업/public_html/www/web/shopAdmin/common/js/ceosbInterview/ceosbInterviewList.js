
	function goCeosbInterviewViewMoveEvent(code) {
		data			= new Array();

		data['mode']	= "ceosbInterviewView";
		data['icCode']	= code;

		goAddLocation(data);
	}

	function goCeosbInterviewWriteMoveEvent() {

		data			= new Array();

		data['mode']	= "ceosbInterviewWrite";

		goAddLocation(data);
	}