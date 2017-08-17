	/**
	 *
	 * productCateMenu - basicSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/productCateMenu/productCateMenuBasicSkin.js
	 * @manual		
	 * @history
	 *				2014.02.04 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goProductCateMenuBasicSkinReadyMoveEvent(strAppID) {
		
		// 기본 설정
		var strSelectCate = G_APP_PARAM[strAppID]['SELECT_CATE'];
		var aryCate1 = G_APP_PARAM[strAppID]['S_ARY_CATE1'];
		var aryCate2 = G_APP_PARAM[strAppID]['S_ARY_CATE2'];
		var objTarget = $('#' +  strAppID);

		// 선택된 카테고리 설정
		var strSelectCate1	= strSelectCate.substr(0, 3);
		var strSelectCate2	= strSelectCate.substr(3, 3);
		var strSelectCate3	= strSelectCate.substr(6, 3);
		var strSelectCate4	= strSelectCate.substr(9, 3);

		// 1차 카테고리
		objTarget.append('<ul class="cateMenu1"><ul>');

		for(var key1 in aryCate1) {

			// 기본 설정
//			var strHref = './?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s';
			var strName1 = aryCate1[key1]['NAME'];
			var strCode1 = aryCate1[key1]['CODE'];
			var strShare1 = aryCate1[key1]['SHARE'];
			var strView1 = aryCate1[key1]['VIEW'];
			var strHtml1 = "";
			var strSelectLi = "";

			var strCode1_1	= strCode1.substr(0, 3);

			// 유효성 체크
			if(strShare1 != "N") { continue; }
			if(strView1  != "Y") { continue; }
			if(strCode1_1 == strSelectCate1) { strSelectLi = "cate1-li-selected"; }

			strHtml1 = '<li code="' + strCode1 + '" class="' + strSelectLi + '">' + 
							'<a href="javascript:goProductCateMenuBasicSkinClickEvent(\'' + strAppID + '\', \'' + strCode1 + '\')" class="cate1-name">' + strName1 + '</a>' + 
					   '</li>';

			objTarget.find('.cateMenu1').append(strHtml1);

			// 2차 카테고리
			objTarget.find('[code=' + strCode1 + ']').append('<div class="cate2-wrap">' + 
																'<ul class="cateMenu2"><ul>' + 
															 '</div>');
			for(var key2 in aryCate2[key1]) {

				// 기본 설정
				var strName2 = aryCate2[key1][key2]['NAME'];
				var strCode2 = aryCate2[key1][key2]['CODE'];
				var strShare2 = aryCate2[key1][key2]['SHARE'];
				var strView2 = aryCate2[key1][key2]['VIEW'];
				var strHtml2 = "";
				var strSelectLi = "";

				var strCode2_1	= strCode2.substr(0, 3);
				var strCode2_2	= strCode2.substr(3, 3);

				// 유효성 체크
				if(strShare2 != "N") { continue; }
				if(strView2  != "Y") { continue; }
				if(strCode2 ==  strSelectCate1 + strSelectCate2) { strSelectLi = "cate2-li-selected"; }

				strHtml2 = '<li code="' + strCode2 + '" class="' + strSelectLi + '"><a href="./?menuType=product&mode=list&lcate=' + strCode2_1 + '&mcate=' + strCode2_2 + '" class="cate2-name">' + strName2 + '</a></li>';

				objTarget.find('[code=' + strCode1 + ']').find('.cateMenu2').append(strHtml2);				
			}
		}
	}

	function goProductCateMenuBasicSkinClickEvent(strAppID, strCode) {

		var objTarget = $('#' +  strAppID);		
		objTarget.find('li.cate1-li-selected').removeClass();
		objTarget.find('li[code=' + strCode + ']').addClass('cate1-li-selected');
	}