/*
 * Tab Func
 * 
 * 작성자 : 안성운
 * 작성일 : 2012-09-25
 */
function TabLib(config) {
	if (typeof(config) != "object") return;

	this.queue = [];
	this.$box = $("#" + config.tabBarContainerID);
	this.selectedIndex = 0;
	this.prevIndex = 0;
	this.$tabs = this.$box.find("div.tabBarContainer ul");
	this.$panels = null;
	this.showDelButton = false;	
	this.currentTop = 0;
	this.currentLeft = 0;
	this.currentPageNo = 1;
	this.ParentName = config.ParentName;
	
	if (this.$box.length > 0) {
		// 삭제버튼표시여부
		if (typeof(config.showDelButton) == "boolean") {
			this.showDelButton = config.showDelButton;
		}
		
		var oThis = this;
		var $navBtn = this.$box.find("div.pageNav").find("img");	
		$navBtn.eq(0).bind("click", function() { oThis.Nav('P'); });
		$navBtn.eq(1).bind("click", function() { oThis.Nav('N'); });
	}
	
	/*
	var oThis = this;
	window.setInterval(function() { oThis.AddQueue(); }, 500);
	*/
}

// 탭선택
TabLib.prototype.Select = function(el) {

	if (!el) return;
	if (this.$panels == null) this.$panels = this.$box.find("div.tabsPanels");

	var $items = this.$tabs.find("li");
	$items.removeClass("on");
	$items.find("img").hide();
	

	var $currentItem = $(el);
	
	var pos = $currentItem.position();
	this.currentLeft = pos.left;
	if(Math.abs(this.currentLeft%100)== 95){
		if (this.currentLeft > 0) this.currentLeft = this.currentLeft * -1;
	
		if (this.currentLeft == 20)
			this.currentPageNo = 1;
		else
			this.currentPageNo = ((Math.abs(this.currentLeft)- 95) / 100);
	}
	else{
		if (this.currentLeft > 0) this.currentLeft = this.currentLeft * -1;
		
		if (this.currentLeft == 20)
			this.currentPageNo = 1;
		else
			this.currentPageNo = ((Math.abs(this.currentLeft)+ 26) / 100);
	}

	this.$panels.hide();
	this.prevIndex = this.selectedIndex;

	$currentItem.addClass("on");
	if (this.showDelButton) $currentItem.find("img").show();
	this.prevIndex = this.selectedIndex;
	for (var i = 0; i < $items.length; i++) {
		if ($items.eq(i).hasClass("on")) {
			this.selectedIndex = i;
			break;
		}
	}
	this.$panels.eq(this.selectedIndex).show();
};

// 인덱스로 탭 선택
TabLib.prototype.SelectAtIndex = function(index) {
	var $currentTab = this.$tabs.find("li:eq(" + index + ")");

	if (typeof($currentTab) == "object") {
		this.Select($currentTab[0]);
	}
};

// 탭 추가
TabLib.prototype.Add = function(param) {
	var menuID = param.menuID + "";

	//if (!menuID.isEng()) return;
	if (typeof(param.title) == "string") tabTitle = param.title;
	
	var userTabYN = param.userTab + "";
	if (/^[YNyn]$/.test(userTabYN))
		userTabYN = userTabYN.toUpperCase();
	else
		userTabYN = "N";

	if (this.$tabs.find("li[data-menuID='" + menuID + "']").length > 0) {
		this.Select(this.$tabs.find("li[data-menuID='" + menuID + "']"));
		this.$tabs.find("li[data-menuID='" + menuID + "']").find("em").html(param.title);
		this.PageGo(param.iframeURL);
	}
	else {
		var addParam = {
			tabObj: this,
			$box: this.$box,
			$tabs: this.$tabs,
			parentName: this.ParentName,
			tabParam: param,
			showDelButton: this.showDelButton,
			userTabYN: userTabYN
		};

		//this.queue.push(new Tab(addParam));
		var newTab = new Tab(addParam);
		newTab.Add();
	}
};

//탭 내용 크기조정
TabLib.prototype.PanelResize = function() {
	var boxWidth = this.$box.width();
	var boxHeight = this.$box.height();
	var $iframes = this.$box.find("iframe");
	var iframesCount = $iframes.length;

	var tabBarOffset =$(".tabBarContainer").offset();
	if(tabBarOffset != ""){
		boxHeight = $(window).height() - tabBarOffset.top - $(".tabBarContainer").height();
	}

	for (var i = 0; i < iframesCount; i++) {
		$iframes.eq(i).attr("width", boxWidth);
		$iframes.eq(i).attr("height", boxHeight);
		$iframes.eq(i).css({
			width: boxWidth + "px",
			height: boxHeight + "px"
		});
	}
};

// 탭내 페이지 이동
TabLib.prototype.PageGo = function(currentURL) {
	if (this.$panels == null) this.$panels = this.$box.find("div.tabsPanels");
	var $currentPanel = this.$panels.eq(this.selectedIndex);
	var $iframe = $currentPanel.find("iframe");
	var iframeID = $iframe.attr("id");
	var savedSrc = $iframe.attr("src");
	$iframe.remove();

	if (currentURL.indexOf("/") == -1) {
		var prevPagePath = savedSrc.substr(0, savedSrc.lastIndexOf("/") + 1);
		currentURL = prevPagePath + currentURL;
	}

	$currentPanel.find("p.loading").show();
	$iframe = $("<iframe class=\"__TabContentsFrame\" id=\"" + iframeID + "\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" scrolling=\"auto\"></iframe>");
	$currentPanel.append($iframe);

	var boxWidth = this.$box.width();
	//var iframeBoundWidth = boxWidth;
	
	var tabBarOffset =$(".tabBarContainer").offset();
	var boxHeight = this.$box.height();
	boxHeight = $(window).height() - tabBarOffset.top - $(".tabBarContainer").height();

	var iframeSrc = currentURL;
	document.getElementById(iframeID).src = iframeSrc;

    $iframe.attr("width", boxWidth);
    $iframe.attr("height", boxHeight);
    $iframe.css({
    	width: boxWidth + "px",
    	height: boxHeight + "px"
    });
};

// 탭 삭제
TabLib.prototype.Del = function(el) {
	if (!el) return;

	if (this.$panels == null) this.$panels = this.$box.find("div.tabsPanels");
	this.$tabs.find("li:eq(" + this.selectedIndex + ")").remove();
	this.$panels.eq(this.selectedIndex).remove();

	this.$panels = this.$box.find("div.tabsPanels");

	--this.selectedIndex;
	this.SelectAtIndex(this.selectedIndex);
};

// 탭 삭제 MenuId
TabLib.prototype.DelId = function(menuId) {
	// 탭 정의
	var $items = this.$tabs.find("li");
	// 탭에서 현재 누른 위치 찾기
	// 누른 페이지 찾기.
	var selIdx = 0;

	// 열린 페이지 삭제
	if(this.prevIndex == this.selectedIndex){
		selIdx = $items.length -2;
	}// 다른 페이지 삭제
	else if(this.prevIndex > this.selectedIndex){
		selIdx = this.prevIndex - 1;
	}
	else if(this.prevIndex > this.selectedIndex){
		selIdx = this.prevIndex;
	}
	// 누른 위치 삭제
	this.$tabs.find("li:eq(" + this.selectedIndex + ")").remove();
	this.$panels.eq(this.selectedIndex).remove();
	this.$panels = this.$box.find("div.tabsPanels");
	
	this.SelectAtIndex(selIdx);
};

// 탭 전체 삭제
TabLib.prototype.DelAll = function() {
	var $items = this.$tabs.find("li");
	var len  = $items.length;
	for (var i = len;i >= 0 ; i-- )
	{
		this.$tabs.find("li:eq(" + i + ")").remove();
		this.$panels.eq(i).remove();
	}
	this.$panels = this.$box.find("div.tabsPanels");
};

// 탭 NAV
TabLib.prototype.Nav = function(tag) {
	var $items = this.$tabs.find("li");
	var tabNavPageCount = $items.length;
	
	switch (tag) {
		case "P":
			if (this.currentPageNo == 1)
				this.currentPageNo = 1;
			else
				this.currentPageNo = this.currentPageNo - 1;
			break;
		case "N":
			if (this.currentPageNo == tabNavPageCount)
				this.currentPageNo = tabNavPageCount;
			else
				this.currentPageNo = this.currentPageNo + 1;
			break;
	}

	this.SelectAtIndex(this.currentPageNo-1);
};

/*
 * 탭 추가 함수
 */
function Tab(p) { this.p = p; }
Tab.prototype.Add = function(callback) {
	var p = this.p;
	var boxWidth = p.$box.width();
	var boxHeight = p.$box.height();
	var iframeID = "";
	var iframeSrc = "";

	iframeID = "tabLibIframe_" + p.tabParam.menuID;

	var tabBarOffset =$(".tabBarContainer").offset();
	boxHeight = $(window).height() - tabBarOffset.top - $(".tabBarContainer").height();

	var $div = $("<div></div>");
	var $iframe = $("<iframe class=\"__TabContentsFrame\" id=\"" + iframeID + "\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" scrolling=\"auto\"></iframe>");
	
    $div.append($iframe);

    var currentURL = p.tabParam.iframeURL;
    
    if(currentURL.indexOf("?")<0){
    	currentURL += "?menuId=" +p.tabParam.menuID ;
    }
    else{
    	currentURL += "&menuId=" +p.tabParam.menuID ;
    }
	
    //var currentURL = p.tabParam.iframeURL+"?menuId=" +p.tabParam.menuID ;
	iframeSrc = currentURL ;

    $iframe.attr("width", boxWidth);
	$iframe.attr("height", boxHeight);

    $iframe.css({
    	width: boxWidth + "px",
    	height: boxHeight + "px"
    });

	addPanelHTML = $div.html();
	
	var $newPanel = $("<div class=\"tabsPanels\" style=\"display:none;\">" + addPanelHTML + "</div>");

	if (p.$box.find("div.tabsPanels").length == 0)
		p.$box.append($newPanel);
	else
		p.$box.find("div.tabsPanels:last").after($newPanel);

	if (insertType = "iframe") {
	    document.getElementById(iframeID).src = iframeSrc;
	}

	var currentTabObj = p.tabObj;
	currentTabObj.$panels = p.$box.find("div.tabsPanels");

	var $newTab = $("<li data-menuID=\"" + p.tabParam.menuID + "\" data-menuLink=\"" + p.tabParam.iframeURL + "\" ><em class='link'><b>" + p.tabParam.title + "</b></em></li>");
	
	if (p.showDelButton) {
		var s = "" + $newTab.html() + "<a href='javascript:fnTabDelId(\""+ p.tabParam.menuID +"\");' class='close'>닫기</a>";
		$newTab.html(s);
	}

	if (p.userTabYN == "Y") {
		$newTab.find("span").find("img:first").remove();
	}

	if (p.$tabs.find("li").length == 0)
		p.$tabs.append($newTab);
	else
		p.$tabs.find("li:last").after($newTab);

	$newTab.bind("click", function() { currentTabObj.Select(this); });
	$newTab.trigger("click");

	if (typeof(callback) == "object" || typeof(callback) == "function") {
		callback();
	}
};