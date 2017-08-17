<?
		/* 레이아웃 영역 관련 */
		$DESIGN_TAG['{{__탑영역__}}']				= "include sprintf ( \"%s%s/layout/html/main_top.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__본문영역__}}']				= "include sprintf ( \"%s%s/layout/html/main_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__하단영역__}}']				= "include sprintf ( \"%s%s/layout/html/%s/main_bottom.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME, \$S_SITE_LNG_PATH  );";
		$DESIGN_TAG["{{__좌측영역__}}"]				= "include sprintf ( \"%s%s/layout/html/main_left.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG["{{__서브좌측영역__}}"]			= "include sprintf ( \"%s%s/layout/html/sub_left.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG["{{__본문영역자동__}}"]			= "include \"{\$S_DOCUMENT_ROOT}/www/include/bodyAuto.inc.php\";";
		$DESIGN_TAG["{{__서브영역자동__}}"]			= "include \"{\$S_DOCUMENT_ROOT}/www/include/subAuto.inc.php\";";

		$DESIGN_TAG["{{__회원좌측영역__}}"]			= "include sprintf ( \"%s%s/layout/html/member_left.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG["{{__상품좌측영역__}}"]			= "include sprintf ( \"%s%s/layout/html/product_left.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG["{{__주문좌측영역__}}"]			= "include sprintf ( \"%s%s/layout/html/order_left.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG["{{__커뮤니티좌측영역__}}"]		= "include sprintf ( \"%s%s/layout/html/community_left.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";

		$DESIGN_TAG['{{__서브탑영역__}}']			= "include sprintf ( \"%s%s/layout/html/sub_top.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__서브하단영역__}}']			= "include sprintf ( \"%s%s/layout/html/sub_bottom.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";

		/* 메뉴 관련 */
		$DESIGN_TAG['{{__글로벌메뉴__}}']			= "include sprintf ( \"%swww/include/grobalMenu.inc.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG['{{__글로벌메뉴2__}}']			= "include sprintf ( \"%s%s/layout/menu/globalMenu2.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG['{{__글로벌메뉴3__}}']			= "include sprintf ( \"%s%s/layout/menu/globalMenu3.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";

		$DESIGN_TAG['{{__메인탑메뉴__}}']			= "include sprintf ( \"%swww/include/mainTopMenu.inc.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG['{{__메인메뉴__}}']				= "include sprintf ( \"%swww/include/mainMenu_%s.inc.php\", \$S_DOCUMENT_ROOT,'T0001'  );";
		$DESIGN_TAG['{{__펼침메인메뉴__}}']			= "include sprintf ( \"%swww/include/mainMenu_%s.inc.php\", \$S_DOCUMENT_ROOT,'T0002'  );";
		$DESIGN_TAG['{{__왼쪽글로벌메뉴__}}']		= "include sprintf ( \"%swww/include/mainLeftMenu.inc.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG['{{__하단영역메뉴__}}']			= "include sprintf ( \"%swww/include/bottomMenu.inc.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG["{{__서브메뉴영역__}}"]			= "include sprintf ( \"%swww/include/sub.navi.inc.php\", \$S_DOCUMENT_ROOT );";

		$DESIGN_TAG["{{__퀵메뉴__}}"]				= "include sprintf ( \"%swww/include/quickMenu.skin.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__퀵메뉴_스타일0001__}}"]	= "include sprintf ( \"%swww/include/quickMenu.skin.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__퀵메뉴_스타일0002__}}"]	= "include sprintf ( \"%swww/include/quickMenu.0002.skin.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__공통메뉴__}}"]				= "include sprintf ( \"%swww/include/commonMenu.skin.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__현재위치__}}"]				= "include sprintf ( \"%swww/include/location.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG['{{__퀵메뉴_TOP_스타일__}}']	= "include sprintf ( \"%s%s/layout/menu/quickMenuTop.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";

		$DESIGN_TAG["{{__로그카운트__}}"]			= "include sprintf ( \"%swww/include/log.counter.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__앱스크립트__}}"]			= "include sprintf ( \"%swww/include/footer.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__모바일로이동__}}"]			= "include MALL_HOME . \"/include/goMobile.inc.php\";";

		## 작성일 : 2013.06.11
		## 작성자 : kim hee sung
		## 설  명 : 퀵메뉴 시작/종료 구분하여 html 단에서 사용자가 디자인을 변경 할 수 있도록 함.
		$DESIGN_TAG["{{__퀵메뉴_시작__}}"]			= "include sprintf ( \"%swww/include/quickMenu/quickMenu_start.skin.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__퀵메뉴_종료__}}"]			= "include sprintf ( \"%swww/include/quickMenu/quickMenu_end.skin.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__최근본상품__}}"]			= "include sprintf ( \"%swww/include/quickMenu/latelyProduct.skin.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__장바구니상품__}}"]			= "include sprintf ( \"%swww/include/quickMenu/cartProduct.skin.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG["{{__인기상품__}}"]				= "include sprintf ( \"%swww/include/quickMenu/bestProduct.skin.inc.php\", \$S_DOCUMENT_ROOT );";

		$DESIGN_TAG["{{__카테고리_스타일0001__}}"]	= "include sprintf ( \"%swww/include/Menu/categoryStyle.0001.php\", \$S_DOCUMENT_ROOT  );";		// 상품페이지에서만 사용 가능
		$DESIGN_TAG["{{__카테고리_스타일0002__}}"]	= "include sprintf ( \"%swww/include/Menu/categoryStyle.0002.php\", \$S_DOCUMENT_ROOT  );";		// 상품페이지에서만 사용 가능
		$DESIGN_TAG["{{__카테고리_스타일0003__}}"]	= "include sprintf ( \"%swww/include/Menu/categoryStyle.0003.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG["{{__카테고리_스타일0004__}}"]	= "include sprintf ( \"%swww/include/Menu/categoryStyle.0004.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG["{{__카테고리_스타일0005__}}"]	= "include sprintf ( \"%swww/include/Menu/categoryStyle.0005.php\", \$S_DOCUMENT_ROOT  );";		// 2차 배열까지 무조건 출력
		$DESIGN_TAG["{{__카테고리_스타일0006__}}"]	= "include sprintf ( \"%swww/include/Menu/categoryStyle.0006.php\", \$S_DOCUMENT_ROOT  );";		// 3차 배열만 출력, 1차 2차 코드값 있어야함, 4차 출력 안됨, 이미지 출력 안됨.
		$DESIGN_TAG["{{__카테고리_스타일0007__}}"]	= "include sprintf ( \"%swww/include/Menu/categoryStyle.0007.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG["{{__카테고리_스타일0008__}}"]	= "include sprintf ( \"%swww/include/Menu/categoryStyle.0008.php\", \$S_DOCUMENT_ROOT  );";		// 6번 소스와 동일함. 단, 1차 카테고리를 선택하면 2차 카테고리는 출력 안함
		$DESIGN_TAG["{{__카테고리_스타일0009__}}"]	= "include sprintf ( \"%swww/include/Menu/categoryStyle.0009.php\", \$S_DOCUMENT_ROOT  );";

		// 배너 관련
		$DESIGN_TAG["{{__에스크로_배너__}}"]		= "include sprintf ( \"%swww/include/kcp_banner.inc.php\", \$S_DOCUMENT_ROOT );";		// 구매안전(에스크로) 서비스
		$DESIGN_TAG["{{__사업자정보_링크__}}"]		= "include sprintf ( \"%swww/include/bizInfo_link.inc.php\", \$S_DOCUMENT_ROOT );";		// 사업자정보확인 링크
		$DESIGN_TAG['{{__메인이미지배너__}}']		= "include sprintf ( \"%swww/web/main/include/mainbanner.index.inc.php\", \$S_DOCUMENT_ROOT );";

		// 추가페이지
		$DESIGN_TAG['{{__탑인사말__}}']				= "include sprintf ( \"%s%s/layout/menu/globalGreeting.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG['{{__상품검색2__}}']			= "include sprintf ( \"%s%s/layout/menu/productSearch.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG['{{__상품소팅__}}']				= "include sprintf ( \"%s%s/layout/menu/productSorting.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG['{{__사용자좌측로그인__}}']		= "include sprintf ( \"%s%s/layout/menu/leftLogin.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";

		/* 상품리스트(신상품, 베스트, 추천, MD추천, 임시필드)*/
		$DESIGN_TAG['{{__추천아이템1__}}']			= "\$no = 1; include sprintf ( \"%swww/web/product/include/bestList.index.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__추천아이템2__}}']			= "\$no = 2; include sprintf ( \"%swww/web/product/include/bestList.index.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__추천아이템3__}}']			= "\$no = 3; include sprintf ( \"%swww/web/product/include/bestList.index.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__추천아이템4__}}']			= "\$no = 4; include sprintf ( \"%swww/web/product/include/bestList.index.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__추천아이템5__}}']			= "\$no = 5; include sprintf ( \"%swww/web/product/include/bestList.index.inc.php\", \$S_DOCUMENT_ROOT );";

		$DESIGN_TAG['{{__쇼핑몰로고__}}']				= "include sprintf ( \"%swww/include/shopLogo.inc.php\", \$S_DOCUMENT_ROOT  );";

		$DESIGN_TAG['{{__상품검색__}}']					= "include sprintf ( \"%swww/include/productSearch.inc.php\", \$S_DOCUMENT_ROOT  );";

		$DESIGN_TAG['{{__폼문시작__}}']					= "include sprintf ( \"%swww/include/formStart.inc.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG['{{__슬라이딩배너__}}']				= "include sprintf ( \"%swww/include/slider/slidingBanner.A0002.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__메인배너가로3개__}}']			= "include sprintf ( \"%swww/include/mainBannerWidth3.inc.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG['{{__메인신상품__}}']				= "include sprintf ( \"%swww/include/recommend/mainNewProduct.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__메인베스트상품__}}']			= "include sprintf ( \"%swww/include/recommend/mainBestProduct.inc.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG['{{__고객센터__}}']					= "include sprintf ( \"%swww/include/customerCenter.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__폼문끝__}}']					= "include sprintf ( \"%swww/include/formEnd.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__서브본문영역__}}']				= "include sprintf ( \"%s%s/layout/html/sub_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__브랜드좌측영역__}}']			= "include sprintf ( \"%s%s/layout/html/brand_left.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__브랜드본문영역__}}']			= "include sprintf ( \"%s%s/layout/html/brand_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__상품리스트좌측영역__}}']		= "include sprintf ( \"%s%s/layout/html/productList_left.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
//		$DESIGN_TAG['{{__상품리스트본문영역__}}']		= "include sprintf ( \"%s%s/layout/html/productList_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__상품리스트본문영역__}}']		= "include \"{\$S_DOCUMENT_ROOT}www/web/product/productList.index.php\"";
		$DESIGN_TAG['{{__상품뷰좌측영역__}}']			= "include sprintf ( \"%s%s/layout/html/productView_left.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__상품뷰본문영역__}}']			= "include sprintf ( \"%s%s/layout/html/productView_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__주문본문영역__}}']				= "include sprintf ( \"%s%s/layout/html/order_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__마이페이지본문영역__}}']		= "include sprintf ( \"%s%s/layout/html/mypage_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__회원본문영역__}}']				= "include sprintf ( \"%s%s/layout/html/member_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__커뮤니티본문영역__}}']			= "include sprintf ( \"%s%s/layout/html/community_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME );";
		$DESIGN_TAG['{{__서브폼문시작__}}']				= "include sprintf ( \"%swww/web/%s/%s_form_start.inc.php\", \$S_DOCUMENT_ROOT, \$strMenuType, \$strMenuType  );";
		$DESIGN_TAG['{{__서브메인영역__}}']				= "include sprintf ( \"%swww/include/subBody.inc.php\", \$S_DOCUMENT_ROOT  );";
		$DESIGN_TAG['{{__추가페이지본문영역__}}']		= "include sprintf ( \"%s%s/layout/html/sub_body.inc.php\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME  );";
		$DESIGN_TAG['{{__상품카테고리별이미지__}}']		= "include \"{\$S_DOCUMENT_ROOT}www/include/productCateImage.inc.php\";";

		$DESIGN_TAG['{{__커뮤니티본문__}}']				= "include \"{\$includeFile}\";";

		$DESIGN_TAG['{{__서브폼문끝__}}']					= "include sprintf ( \"%swww/web/%s/%s_form_end.inc.php\", \$S_DOCUMENT_ROOT, \$strMenuType, \$strMenuType  );";
		$DESIGN_TAG['{{__쇼핑몰명__}}']					= "echo  \$S_SITE_NM ;";
		$DESIGN_TAG['{{__사업장주소__}}']					= "echo  \$S_COM_ADDR ;";
		$DESIGN_TAG['{{__대표자명__}}']					= "echo  \$S_REP_NM ;";
		$DESIGN_TAG['{{__사업자번호__}}']					= "echo  \$S_COM_NUM1 ;";
		$DESIGN_TAG['{{__통신판매업신고번호__}}']			= "echo  \$S_COM_NUM2 ;";
		$DESIGN_TAG['{{__대표전화번호__}}']				= "echo  \$S_COM_PHONE ;";
		$DESIGN_TAG['{{__관리책임자명__}}']				= "echo  \$S_PIM_NAME ;";
		$DESIGN_TAG['{{__관리책임자이메일__}}']			= "echo  \$S_PIM_MAIL ;";
		$DESIGN_TAG['{{__에스크로확인__}}']				= "echo  \"\";";
		$DESIGN_TAG['{{__쇼핑몰URL__}}']					= "echo  \$S_SITE_URL ;";

		$DESIGN_TAG['{{__main_recommend__}}']			= "\$strTag=\"{{__main_recommend__}}\"; include sprintf ( \"%swww/include/productMainDesign.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__main_md__}}']					= "\$strTag=\"{{__main_md__}}\"; include sprintf ( \"%swww/include/productMainDesign.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__main_best__}}']					= "\$strTag=\"{{__main_best__}}\"; include sprintf ( \"%swww/include/productMainDesign.inc.php\", \$S_DOCUMENT_ROOT );";
		$DESIGN_TAG['{{__main_new__}}']					= "\$strTag=\"{{__main_new__}}\"; include sprintf ( \"%swww/include/productMainDesign.inc.php\", \$S_DOCUMENT_ROOT );";

		$DESIGN_TAG['{{__언어별폴더__}}']				= "echo  \"\$S_SITE_LNG_PATH\";";
		$DESIGN_TAG['{{__개인정보보호정책 내용__}}']	= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/conf/policy.person.{\$S_SITE_LNG_PATH}.inc.php\";";
		$DESIGN_TAG['{{__이용약관 내용__}}']			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/conf/policy.use.{\$S_SITE_LNG_PATH}.inc.php\";";
		$DESIGN_TAG['{{__로그인 폼__}}']				= "include \"{\$S_DOCUMENT_ROOT}www/web/member/include/memberLogin.index.php\";";
		$DESIGN_TAG['{{__비회원 로그인 폼__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/member/include/memberLogin.non.index.php\";";
		$DESIGN_TAG['{{__아이디 비밀번호 찾기 폼__}}']	= "include \"{\$S_DOCUMENT_ROOT}www/web/member/include/memberFindIdPwd.index.php\";";

		$DESIGN_TAG['{{__회원가입약관__}}']				= "include \"{\$S_DOCUMENT_ROOT}www/web/member/include/memberJoin1.index.php\";";
		$DESIGN_TAG['{{__회원가입__}}']					= "include \"{\$S_DOCUMENT_ROOT}www/web/member/include/memberJoinForm.index.php\";";
		$DESIGN_TAG['{{__회원가입완료__}}']				= "include \"{\$S_DOCUMENT_ROOT}www/web/member/include/memberJoinEnd.index.php\";";

//		$DESIGN_TAG['{{__입점사본문영역__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/shop/shop_body.inc.php\";";
		$DESIGN_TAG['{{__입점사본문영역__}}']			= "include MALL_SHOP . '/layout/html/shop_body.inc.php';";
		$DESIGN_TAG['{{__입점사신청약관__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/shop/shop_shopApplyAgree.inc.php\";";
		$DESIGN_TAG['{{__입점사가입폼__}}']				= "include \"{\$S_DOCUMENT_ROOT}www/web/shop/shop_shopApplyReg.inc.php\";";
		$DESIGN_TAG['{{__입점사관리자가입폼__}}']		= "include \"{\$S_DOCUMENT_ROOT}www/web/shop/shop_shopApplyAdmin.inc.php\";";
		$DESIGN_TAG['{{__입점사신청완료__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/shop/shop_shopApplyEnd.inc.php\";";

		$DESIGN_TAG['{{__MY페이지_메뉴__}}']				= "include MALL_WEB_PATH . \"navi/sub_navi_A0001_mypage.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_구매내역리스트__}}']		= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_buyList.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_장바구니리스트__}}']		= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_cartMyList.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_쿠폰리스트__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_couponList.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_내정보변경__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_myInfo.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_포인트관리리스트__}}']	= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_pointList.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_담아둔상품리스트__}}']	= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_wishMyList.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_주소록관리__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_addrList.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_구매내역상세__}}']		= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_buyView.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_회원탈퇴신청__}}']		= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_droupout.index.php\";";
		$DESIGN_TAG['{{__MY페이지_비회원구매내역__}}']		= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_buyNonList.inc.php\";";
		$DESIGN_TAG['{{__MY페이지_커뮤니티__}}']			= "include \$includeFile";
		$DESIGN_TAG['{{__MY페이지_경매리스트__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/mypage/mypage_auctionMyList.inc.php\";";


		$DESIGN_TAG['{{__주문페이지_장바구니__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/order/include/order_cart_basket.index.php\";";
		$DESIGN_TAG['{{__주문페이지_담아두기__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/order/include/order_cart_interestProd.index.php\";";
		$DESIGN_TAG['{{__주문페이지_주문서__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/order/include/order_order.index.php\";";
		$DESIGN_TAG['{{__주문페이지_주문완료__}}']			= "include \"{\$S_DOCUMENT_ROOT}www/web/order/include/order_orderEnd.index.php\";";


		$DESIGN_TAG["{{__커뮤니티영역__}}"]					= "include MALL_SHOP . \"/layout/html/community/{\$S_SITE_LNG_PATH}/board.{\$_REQUEST['b_code']}.script.php\";";

		$DESIGN_TAG["{{__아이베넷_게시판위젯__}}"]			= "include sprintf ( \"%swww/include/community/dataWidget.style.ivenet.inc.php\", \$S_DOCUMENT_ROOT );";

		$DESIGN_TAG["{{__사용자_탑영역__}}"]				= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userTopSkin.inc.php\";";
		$DESIGN_TAG["{{__사용자_메뉴_0__}}"]				= "\$menuID = 0; include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userMenuSkin.inc.php\";";
		$DESIGN_TAG["{{__사용자_메뉴_1__}}"]				= "\$menuID = 0; include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userMenuSkin1.inc.php\";";
		$DESIGN_TAG["{{__사용자_타이틀_1__}}"]				= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userTitleSkin1.inc.php\";";
		$DESIGN_TAG["{{__사용자_카테고리_스타일0001__}}"]	= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCategoryStyle.0001.inc.php\";";
		$DESIGN_TAG["{{__사용자_카테고리_스타일0002__}}"]	= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCategoryStyle.0002.inc.php\";";
		$DESIGN_TAG["{{__사용자_카테고리_스타일0003__}}"]	= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCategoryStyle.0003.inc.php\";";
		$DESIGN_TAG["{{__사용자_카테고리_스타일0004__}}"]	= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCategoryStyle.0004.inc.php\";";
		$DESIGN_TAG["{{__사용자_MY페이지_메뉴__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userMypageMenu.inc.php\";";
		$DESIGN_TAG["{{__사용자_브랜드상품목록__}}"]		= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userBrandProdListStyle.inc.php\";";
		$DESIGN_TAG["{{__사용자_움직니는배너__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSliderBanner.inc.php\";";
		$DESIGN_TAG["{{__사용자_베스트리뷰게시판__}}"]		= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userBestReviewBBS.inc.php\";";
		$DESIGN_TAG["{{__사용자_뉴스게시판__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userNewsBBS.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티메뉴__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunityMenu.inc.php\";";
		$DESIGN_TAG["{{__사용자_상품뷰페이지__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userProductView.inc.php\";";
		$DESIGN_TAG["{{__사용자_상품리스트페이지__}}"]		= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userProductList.inc.php\";";
		$DESIGN_TAG["{{__사용자_검색리스트__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSearchList.inc.php\";";
		$DESIGN_TAG["{{__사용자_구매내역리스트__}}"]		= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userBuyList.inc.php\";";

		$DESIGN_TAG["{{__사용자_스킨1__}}"]					= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSkin1.inc.php\";";
		$DESIGN_TAG["{{__사용자_스킨2__}}"]					= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSkin2.inc.php\";";
		$DESIGN_TAG["{{__사용자_스킨3__}}"]					= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSkin3.inc.php\";";
		$DESIGN_TAG["{{__사용자_스킨4__}}"]					= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSkin4.inc.php\";";
		$DESIGN_TAG["{{__사용자_스킨5__}}"]					= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSkin5.inc.php\";";
		$DESIGN_TAG["{{__사용자_스킨6__}}"]					= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSkin6.inc.php\";";
		$DESIGN_TAG["{{__사용자_스킨7__}}"]					= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSkin7.inc.php\";";
		$DESIGN_TAG["{{__사용자_스킨8__}}"]					= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSkin8.inc.php\";";
		$DESIGN_TAG["{{__사용자_스킨9__}}"]					= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userSkin9.inc.php\";";
		$DESIGN_TAG["{{__사용자_로그가이드__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userLogger.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티_1__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunity1.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티_2__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunity2.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티_3__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunity3.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티_4__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunity4.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티_5__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunity5.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티_6__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunity6.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티_7__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunity7.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티_8__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunity8.inc.php\";";
		$DESIGN_TAG["{{__사용자_커뮤니티_9__}}"]			= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/userCommunity9.inc.php\";";
		$DESIGN_TAG["{{__상품목록탑이미지__}}"]				= "include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}/html/productListTopImg.inc.php\";";

		/* 카운터 스크립트 */
		$DESIGN_TAG["{{__에이스카운터__}}"]					= "include MALL_HOME . \"/include/ace_counter_js.php\";";
		$DESIGN_TAG["{{__네이버카운터__}}"]					= "include MALL_HOME . \"/include/naver_counter_js.php\";";

		/* 레이아웃 B0001 에서 추가된 TAG */


		$DESIGN_TAG['{{__최근소식__}}']					= "include sprintf ( \"%swww/web/board/main_BBSList.inc.php\", \$S_DOCUMENT_ROOT  );";

		$DESIGN_TAG['{{__prodlist_basic__}}']				= "\$strTag=\"{{__prodlist_basic__}}\"; include sprintf ( \"%swww/web/%s/%s_A0001_%s.inc.php\", \$S_DOCUMENT_ROOT, \$strMenuType, \$strMenuType, \$strMode );";

		/* 일반 배너 설정 */
		$bannerConfFolder		= sprintf( "%s%s/layout/banner/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($S_ST_LNG) );

		if(is_dir($bannerConfFolder)) :
			$dir			= dir( $bannerConfFolder );
			while( $file = $dir->read() ) :
				if ( $file == "." || $file == ".." ) {		continue;		}
				$tagName		= str_replace(".html.php", "" , $file);
				$DESIGN_TAG["{{__{$tagName}__}}"] = "include sprintf ( \"%s%s/layout/banner/%s/%s\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME, \$S_SITE_LNG_PATH, \"$file\" );";
			endwhile;
		endif;
		/* 일반 배너 설정 */

		/* ul 형식 배너 */
		for($i=1;$i<=10;$i++):
			$DESIGN_TAG["{{__SLIDER_{$i}__}}"]	= "\$sliderNo = {$i}; include \"{\$S_DOCUMENT_ROOT}www/include/slider.inc.php\";";
		endfor;
		/* ul 형식 배너 */

		/* 커뮤니티(게시판) 그룹/게시판 메뉴 설정 */
//		require_once MALL_CONF_LIB."BoardMgr.php";
//		$boardMgr			= new BoardMgr();
//		$boardGroupResult	= $boardMgr->getBoardGroupSelect($db);
//		while($row = mysql_fetch_array($boardGroupResult)):
//			$DESIGN_TAG["{{__게시판메뉴_{$row['BG_NAME']}__}}"]	= "\$intBG_NO_EX=\"{$row['BG_NO']}\"; include sprintf ( \"%swww/include/Menu/boardMenuStyle.0001.php\", \$S_DOCUMENT_ROOT  );";
//		endwhile;
		/* 커뮤니티(게시판) 그룹/게시판 메뉴 설정 */

		/* 커뮤니티(게시판) 위젯 설정 */
		// $b_code="TEST"; include "{$S_DOCUMENT_ROOT}www/web/community/widget.index.php";
		$boardInfoFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/boardList.info.php";
		if(is_file($boardInfoFile)):
			require_once $boardInfoFile;
			foreach($BOARD_LIST as $b_code => $list):
				$DESIGN_TAG["{{__{$b_code}_위젯__}}"]		= "\$b_code=\"{$b_code}\"; include \"{\$S_DOCUMENT_ROOT}www/web/community/widget.index.php\";";
			endforeach;
		endif;


?>

