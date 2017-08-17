var PagePanel = {
	tabBar: null,

	Init: function() {

		var config = {
			tabBarContainerID: "__tabBarContainer",
			showDelButton: true,
			maxTabCount: 10,
			minTabCount: 1,
			selectedIndex: 0,
			ParentName: "PagePanel.tabBar"
		};

		this.tabBar = new TabLib(config);
		
		var oThis = this;
		$(window).bind("resize", function() { 
			var $contOff = $('.iframe_cont').offset();

			var tabOffset = $("#__tabBarContainer").offset();
			var tabBarOffset =$(".tabBarContainer").offset();	
			var tabHeight = 0;
			if(!tabBarOffset){
				tabHeight = $(window).height() - tabBarOffset.top;
			}
			else{
				tabHeight = $(window).height() - tabOffset.top;
			}
			$('#__tabBarContainer').css('height', tabHeight);
			$('#__tabBarContainer').css('width', $(window).width() - tabOffset.left);
			oThis.PageSize(); 
		});
	},

	Open: function(menuID, pageTitle, pageURL) {
		var $currentItem = this.tabBar.$tabs.find("li[data-menuID='" + menuID + "']");
		var makeOK = true;
		
		if ($currentItem.length > 0) {
			var currentLink = $currentItem.attr("data-menuLink");
			
			if (currentLink == pageURL) {
				makeOK = false;
			}
			else {
				$currentItem.attr("data-menuLink", pageURL);
			}
		}

		if (makeOK) {
			var param = {
				menuID: menuID,
				title: pageTitle,
				insertType: "iframe",
				iframeURL: pageURL
			};

			this.tabBar.Add(param);
		}
		else {
			this.tabBar.Select($currentItem[0]);
		}
	},

	TabNav: function(tag) {
		this.tabBar.Nav(tag);
	},
	TabDelId: function(menuId) {
		this.tabBar.DelId(menuId);
	},
	TabDelAll: function() {
		this.tabBar.DelAll();
	},

	PageMove: function(currentURL) {
		this.tabBar.PageGo(currentURL);
	},
	
	PageSize: function() {
		this.tabBar.PanelResize();
	}

	
};