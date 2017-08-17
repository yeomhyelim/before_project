	/**
	 *
	 * popup - defaultSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/www/common/js/app/popup/popup.defaultSkin.js
	 * @manual		
	 * @history
	 *				2014.06.10 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goPopupDefaultSkinReadyMoveEvent(strAppID) {

		var objTarget = $("#" + strAppID);

		objTarget.find("[id^=dialog_]").each(function(i) {
			var title		= $(this).attr("title");
			var width		= $(this).attr("width");
			var height		= $(this).attr("height");
			var top			= $(this).attr("top");
			var left		= $(this).attr("left");

//			top				= Number(top);
//			left			= Number(left);
			var position = $( this).dialog( "option", "position" );

//			$(this).css({ top: 0, left: 0 });

			$(this).dialog({
				dialogClass: 'myPosition_' + i
				,width			: width
				,minWidth		: width
				,minHeight		: height
				,title			: title
			});

			$('.myPosition_' + i).css({'position':'absolute','top': top + 'px','left': left + 'px'});

//			$(this).dialog({ 
////				 position		: [top, left]
//				 position		: { my: "center", at: "center", of: window }
////				 position		: [100, 100]
//				,width			: width
//				,minWidth		: width
//				,minHeight		: height
//				,title			: title
//			});


//			$(this).dialog( "option", "position", [100,100] );

		});

	}

	function goPopupDefaultSkinCloseActEvent(strAppID, po_no, isFlag) {

		$('[id=dialog_' + po_no + ']').dialog('close');

		if(!isFlag) { return; }
		
		var key			= "POPUP_" + po_no;
		var value		= po_no;
	//	var date		= new Date();

	//	date.setHours(23, 59, 59);

	//	document.cookie		= key + "=" + value + ";expires=" + date.toUTCString();
		C_SetCookie(key, value);

		
	}