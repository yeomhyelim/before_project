
/* 이벤트 정의 */
//function goAttachedfileTempFileUploadAct()			{	goFileAct("attachedfileTempFileUpload");		}		// 커뮤니티 펌부파일 파일업로드
function goAttachedfileTempFileUploadAct()				{	goFileJson("attachedfileTempFileUpload", "goAttachedfileTempFileUploadCallBack");		}		// 커뮤니티 펌부파일 파일업로드
function goAttachedfileClose()							{	self.close(); }

function goAttachedfileTempFileUploadCallBack(obj) {
	if(obj.mode){
		// 파일 업로드가 되었다면.
		window.opener.goAttachedfileCallBack(obj.data);
	}
	self.close();
}