	/**
	 *
	 * productList - relatedSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/www/common/js/app/productList/productListRelatedSkin.js
	 * @manual		
	 * @history
	 *				2014.04.16 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goProductListRelatedSkinReadyMoveEvent(strAppID) {

		var data					= new Object();
		data['__APP_ID__']			= strAppID;
//		goProductListRelatedSkinMouseHoverEvent(data);

	}

	function goProductListRelatedSkinMoveEvent(strAppID, myThis) {

		var strBasketPath		= G_APP_PARAM[strAppID]['BASKET_PATH'];
		var strLinkType			= G_APP_PARAM[strAppID]['LINK_TYPE'];
		var strPCode			= $(myThis).attr('pCode');
		var strPSellCode		= $(myThis).attr('pSellCode');
		var intWidth			= 980;
		var intHeight			= $(window).height() - 50;
		var strUrl				= '/?menuType=product&mode=view&prodCode=' + strPCode + '&prodSellCode=' + strPSellCode + '&basketPath=' + strBasketPath + '&height=' + intHeight;
		var data				= new Object();
		data['iframe']			= strUrl;
		data['width']			= intWidth;
		data['height']			= intHeight;
		data['top']				= 0;

		if(strLinkType == "tiny") {
			TINY.box.show(data);
		} else {
			location.href = strUrl;	
		}
	}

	/**
	 * 마우스 hover 이벤트
	 */
	function goProductListRelatedSkinMouseHoverEvent(data) {
		
		// 기본 설정
		var strAppID				= data['__APP_ID__'];
		var strMouseHoverEvent		= G_APP_PARAM[strAppID]['MOUSE_HOVER_EVENT']; 
		var strStyle				= G_APP_PARAM[strAppID]['STYLE'];
		var objTarget				= $("#" + strAppID).find('.' + strStyle);

		// 유효성 검사
		if(strMouseHoverEvent != "Y") { return; }

		// 마우스 이벤트
		objTarget.find("li").hover(function() {

			var strProdCenter	= $(this).find(".prodInfo").html();
			var intWidth		= $(this).find("img").width();
			var intHeight		= $(this).find("img").height() - 20;

			var strHtml			= '<div class="sortHover">' + 
										'<div class="prodCenterWrap">' +
											'<div class="prodCenter">' + 
												strProdCenter +
											'</div>' +
										'</div>' +
								  '</div>';
			$(this).append(strHtml);

			$(this).find(".sortHover").css({width : intWidth, height : intHeight, opacity : '0.0',top : '0px'}).show();
			$(this).find(".sortHover").stop().animate({opacity : '1.0'}, 100);	
		},
		function() {
			
			$(this).find(".sortHover").stop().animate({opacity : '0.0'}, 100, function() {
				$(this).remove();
			});
			
		});
	}	
	
	/**
	 * 다음 페이지
	 */
	function goProductListRelatedSkinListMoveEvent(strAppID, intPage) {

		// 기본 설정
		var strSkin				= G_APP_PARAM[strAppID]['SKIN'];
		var intPageLine			= G_APP_PARAM[strAppID]['PAGE_LINE'];
		var strOrderBy			= G_APP_PARAM[strAppID]['ORDER_BY'];
		var isLock				= G_APP_PARAM[strAppID]['LOCK'];
		var intPNameCut			= G_APP_PARAM[strAppID]['P_NAME_CUT'];
		var strLang				= G_APP_PARAM[strAppID]['LANG'];
		var strSearchKey		= G_APP_PARAM[strAppID]['SEARCH_KEY'];

		// 잠겨있을때 종료
		if(isLock)	{ return; }
		else		{ G_APP_PARAM[strAppID]['LOCK'] = true; }

		// 로딩 보이기
		$("#" + strAppID).find(".loading").show();
		$("#" + strAppID).find(".nextList").hide();

		// 유효성 체크
		if(!intPage) { intPage = 1; }

		// 데이터 전달
		var data			= new Object();
		data['menuType']	= "product";
		data['mode']		= "json";
		data['act']			= "productRelatedList";
		data['page']		= intPage;
		data['pageLine']	= intPageLine;
		data['appID']		= strAppID;	
		data['orderBy']		= strOrderBy;
		data['pNameCut']	= intPNameCut;	
		data['lang']		= strLang;	
		data['searchKey']	= strSearchKey;		

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {

									// 페이지 그리기
									goProductListRelatedSkinListDraw(data);
//									goProductListRelatedSkinMouseHoverEvent(data);

								} else {
									var strMsg		= data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									console.log(strMsg);
								}

						   }
			,complete:function(xhr, status) {
				
				// 잠김 풀기
				G_APP_PARAM[strAppID]['LOCK']	= false;

				// 로딩 숨기기
				$("#" + strAppID).find(".loading").hide();
				$("#" + strAppID).find(".nextList").show();
			}
		});
	}

	/**
	 * 페이지 그리기
	 */
	function goProductListRelatedSkinListDraw(data) {

		var strAppID		= data['__APP_ID__'];
		var aryData			= data['__DATA__'];	
		var aryPage			= data['__PAGE__'];	
		var intPage			= Number(aryPage['page']);
		var intPageNext		= intPage + 1;
		var strStyle		= G_APP_PARAM[strAppID]['STYLE'];
		var objTarget		= $("#" + strAppID).find('.'+strStyle);

		// 페이지 설정
		G_APP_PARAM[strAppID]['PAGE']	= intPage;

//		objTarget.html("");
		objTarget.find(".clr").remove();
		if(aryPage['total'] && aryPage['listNum'] > 0) {
			for(var key in aryData) {
				var strP_CODE					= aryData[key]['P_CODE'];
				var srtP_NAME					= aryData[key]['P_NAME'];
				var strP_SALE_PRICE				= aryData[key]['P_SALE_PRICE'];
				var strPM_REAL_NAME				= aryData[key]['PM_REAL_NAME'];
				var strHtml						= "";

				strHtml							= '<li>' + 
														'<dl id="p_code_' + strP_CODE + '" class="prodlist">' + 
															'<dt>' + 
																'<input type="checkbox" id="prodSelect" value="' + strP_CODE + '">' + 
																'<img id="pm_real_name" src="' + strPM_REAL_NAME + '" style="width:70px;height:70px">' + 
															'</dt>' + 
															'<dd id="p_code">' + strP_CODE + '</dd>' + 
															'<dd id="p_name">' + srtP_NAME + '</dd>' + 
															'<dd id="p_sale_price">' + strP_SALE_PRICE + '</dd>' + 
														'</dl>' + 
													'</li>';

				objTarget.append(strHtml);
			}
			objTarget.append('<div class="clr"></div>');
			$("#" + strAppID).find("a[id=nextList]").attr("href", "javascript:goProductListRelatedSkinListMoveEvent('" + strAppID + "','" + intPageNext + "')");
			
		} else {
			$("#" + strAppID).find("a[id=nextList]").remove();
			$("#" + strAppID).append('<div class="no_data">상품 검색 결과가 없습니다.</div>');
		}
	}