/*
 * 메뉴 정보 조회하여 tab으로 오픈
 * tMenuIdx : 메뉴 인덱스, tParam : url뒤에 붙힐 파라메터, tType : L(왼쪽영역), P(탭내에서 다른탭을 여는 경우)
 * 
 */
function OpenTabMenu(tMenuIdx, tUrl, tParam, tTitle, tType) {
	if(!tMenuIdx) return;
	if(!tParam) tParam = "";
	if(!tType) tType = "P";
	
	//매번 다른 페이지로 호출하기 위해 파라메터 추가
	var todayDate = new Date();
	var tempNewNo = todayDate.getFullYear() + todayDate.getMonth() + todayDate.getDate() + todayDate.getHours() + todayDate.getMinutes() + todayDate.getSeconds() + todayDate.getMilliseconds();
	var tLink = tUrl;	//해당 메뉴 url
	if(!tTitle) tTitle = "메뉴 "+tMenuIdx;
	if(tParam.length > 0)
		tLink = tLink + "?" + tParam;
		//tab 오픈
		//__TabOpen(rowData.MENU_IDX, rowData.TITLE, tLink);
		
		//왼쪽영역에서 새탭을 여는 경우
	if(tType == "L")
		PagePanel.Open(tMenuIdx, tTitle, tLink);
	//탭내에서 다른 탭을 여는 경우
	else if(tType == "P")
		parent.PagePanel.Open(tMenuIdx, tTitle, tLink);
}


function fnTabNav(tag) {
	if(!tag) return;
	PagePanel.TabNav(tag);	
}

function fnTabDelId(menuId) {
	if(!menuId) return;
	PagePanel.TabDelId(menuId);
}

function fnTabDelAll() {
	PagePanel.TabDelAll();
}