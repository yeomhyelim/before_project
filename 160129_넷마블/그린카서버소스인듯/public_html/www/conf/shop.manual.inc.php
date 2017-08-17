<?
	## 파일 명			: shop.manual.inc.php
	## 작성 일			: 2013.06.10
	## 최초 작성자		: Kim Hee Sung
	## 파일 설명		: 설정 부분을 데이터베이스, 혹은 프로그램적으로 설정 하는 것이 아니라, 관리자가 수동으로 직접 설정 관리 함.
	## 참고 사항		: 내용 추가시 반드시 주석 처리 요망.
	##					  내용 추가시 반드기 demo1 사이트에 추가 요망

	## 상품 뷰페이지 미니샵 사용 유무
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$PRODUCT_VIEW_MINISHOP_USE = "N";		

	## 북마크 사용 유무 
	## 사용법		= 메뉴얼 참고
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$SITE_BOOKMARK_USE = "Y";	

	## 메인메뉴 상품 개수 표시 여부
	## 사용법		= 없음
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$MAIN_MENU_PRODUCT_COUNT_USE = "Y";	

	## 커뮤니티 리스트의 제목을 클릭하면 펼침으로 내용보기
	## 사용법		= 없음
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$COMMUNITY_LIST_OP['PROD_REVIEW']['SPREAD'] = "Y";	
	
	## 커뮤니티 답변형 게시판 스킨 설정
	## 사용법		= 없음
	## 사용			= ONE_BY_ONE
	## 미사용		= 주석처리 혹은 N
	$COMMUNITY_LIST_OP['MY_QNA']['ANSWER_SKIN'] = "ONE_BY_ONE";	

	## 관리자 커뮤니티 리스트에서 디바이스 아이콘 표시 여부
	## 사용법		= 없음
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$COMMUNITY_LIST_OP['MY_QNA']['ADMIN_DEVICE_ICON_USE'] = "Y";

	## 커뮤니티 뷰페이지 리스트 이미지 출력 유무
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$COMMUNITY_VIEW_OP['MY_QNA']['LIST_IMG_SHOW'] = "N";	

	## 상품 뷰페이지에서 상품 이미지 마우스 오버시 이벤트 설정
	## 사용법		= 없음
	## 사용			= NO : 마우스 이벤트 사용 안함.
	$PRODUCT_VIEW_IMAGE_MOUSEOVER_EVENT = "NO";	

	## 메인 슬라이더 이미지 네비 버튼 숨김 처리
	## 사용			= HIDE : 숨김 처리
	## 미사용		= 주석처리 혹은 N
	$MAIN_SLIDER_IMG_NAVI = "HIDE";	

	## 입점몰에서 쪽지 기능 사용 유무
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$SELLER_PAPER_USE = "N";

	## 관리자 페이지 > 기본설정 > 관리자리스트 > 등록 에서, 영업사원, 관리입점몰 선택 할 수 있는 옵션 설정(ahyeop)
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$ADMIN_SHOP_SELECT_USE = "N";

	## KCP 구매시 복합과세 사용유무(ahyeop)
	## 사용			= Y
	## 미사용		= N
	$SHOP_ORDER_PG_TAX_FLAG = "Y";

	## 폐쇄몰 인트로 로그인 SSO 인증 사용 여부(ahyeop)
	## 사용			= Y
	## 미사용		= N
	$SHOP_MEMBER_SSO_FLAG = "N";

	## 포인트 이관 사용여부(ahyeop)
	## 사용			= Y
	## 미사용		= N
	$SHOP_POINT_MOVE_FLAG = "N";

	## 상품 카테고리별 이미지 테그로 사용 여부
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$PRODUCT_CATEGORY_TAG_USE = "N";

	## 회원그룹 리스트 안보이게 하는 옵션(ahyeop)
	$SHOP_MEMBER_GROUP_NOT_IN = "";

	## 관리자 추가 프로그램 개발(nafigure)
	$SHOP_ADMIN_ADD_MENU_USE			= "N";
	$SHOP_ADMIN_ADD_MENU_HTML["ORDER"]	= "";

	## 회원 아이디(마이페이지)에서 수정 가능하게 옵션(ahyeop)
	$SHOP_MEMBER_ID_MODIFY_FLAG			= "N";


	## 사용자 추가 프로그램 개발(nafigure)
	$SHOP_USER_ADD_MENU_USE						= "N";
	$SHOP_USER_ADD_MENU_["ORDER"]["USE"]		= "N";
	$SHOP_USER_ADD_MENU_["ORDER"]["NAME_KR"]	= "";

	## 사용자 추가 프로그램 개발(nafigure)
	## 주문 후 추가프로그램 개발시 주문 레이아웃 CSS 적용하기 위한 사용
	$S_SKIN["ORDER_NEXTORDERSTEP"]				= "";


	## 상품 카테고리별 메인 페이지 사용 여부
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$PRODUCT_CATEGORY_MAIN_USE = "N";

	## 회원 로그인 방식을 레이어 형식으로 사용 유무
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$MEMBER_LAYER_LOGIN_USE = "N";	

	## 회원 소속관리 사용 유무
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$S_FIX_MEMBER_CATE_USE_YN = "N";	

	## 회원 소속관리 사용중 소속 영업/일반사원 구매시 포인트 지급 사용유무
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN = "N";	

	## 포인트 선물하기 사용
	## 사용			= Y
	## 미사용		= N
	$S_FIX_MEMBER_POINT_GIFT_FLAG = "N";

	## 장바구니에서 견적 사용(쿠키스)
	## 사용			= Y
	## 미사용		= N
	$S_FIX_ORDER_ESTIMATE_FLAG = "N";


	## 상품리스트/상세보기에서 포인트 보여주기(특정그룹) 
	## 특정그룹만 보여주기(그룹코드) - 배열형식으로 들어가야 함 EX)array("007")
	$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST = "";

	## 상품상세보기에서 확대이미지를 보기를 유튜브 동영상 보기를 이용할때 (프리스타일)
	## 확대이미지를 동영상 이미지 카테고리 코드 - 배열형식으로 들어가야 함 EX)array("007")
	$S_FIX_PROD_VIEW_MOVIE_FLAG = "";
	$S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST = "";

	## 상품리스트 다운로드 리스트 사용(프리스타일/ceosb스케치북)
	$S_FIX_PROD_LIST_USER_FLAG = "";
	$S_FIX_PROD_LIST_USER_CATE_NOT_LIST = "";
	
	## 메인 베스트 상품1 스크롤링(up) 사용유무(나피큐어)
	$S_FIX_MAIN_PROD_BEST_1_SCROLL_FLAG = "";


	## 시작금액 ~ 종료금액으로 상품 조회시 파라미터 기준금액으로 검색되게(기준은 파라미터 금액이 기준통화금액으로 변경됨) : 리몰사용
	$S_FIX_PROD_SEARCH_PRICE_ST_CUR = "";

	## 주문 후 완료페이지에서 메인으로 가는 버튼 삭제(확인=>마이페이지로 연결 : 프리스타일사용)
	$S_FIX_ORDER_END_MYPAGE_LINK = "";

	## 해외 주문시 배송비가 '0' 인 상품아닌 카테고리(주문시 배송비를 포함하지 않는다.프리스타일(EX:array())
	$S_FIX_ORDER_DELIVERY_USE_LNG = ""; //사용언어
	$S_FIX_ORDER_DELIVERY_PROD_CATE = "";

	## 상품 기본 정보 중 화면에 보일때 원래 기본항목명이 아닌 몰별로 다른 항목명으로 보이고 싶을때 사용
	## 상품 상세보기 기본정보도 다른 항목으로 보이고 싶을때 사용(노트스토리)
	$S_FIX_PROD_BASIC_ITEM_USE				= "N";
	$S_FIX_PROD_BASIC_ITEM['KR']['MAKE']	= "";
	$S_FIX_PROD_BASIC_ITEM['KR']['ORIGIN']	= "";
	$S_FIX_PROD_BASIC_ITEM['KR']['Model']	= "";


	## 관리자 상품 기본정보 등록중 상품추가항목을 일정한 양식으로 표현(노트스토리)
	$S_FIX_PROD_ITEM_ADD_FORM_USE			= "N";
	$S_FIX_PROD_ITEM_ADD_FORM_LIST			= "";

	## 상품상세보기 사용자 페이지 사용(ceosb스케치북)
	$S_FIX_PROD_VIEW_USER_FLAG = "";

	## 상품뷰페이지 HELPER 부분 사용자 정의 사용(CEO스케치북)
	## 사용 : Y
	## 사용안함 : 공백 OR N
	$S_USER_PRODUCT_VIEW_HELPER				= "";

	## 주문 배송정보 사용여부(CEO스케치북)
	## 사용 : Y
	## 사용안함 : 공백 OR N
	$S_FIX_ORDER_DELIVERY_INFO_YN = "";

	## 주문 결제 기간 내역 및 코드발송 사용(CEO스케치북)
	## 사용 : Y
	## 사용안함 : 공백 OR N
	$S_FIX_ORDER_APPR_PERIOD_USE = "";

	## KCP 가상계좌 이용시 [구매확인]/[구매취소] 프로세스를 사용하지 않음(애협사용:배송완료시 적립시점때문) 
	## 사용 : 공백 OR Y
	## 사용안함 : N
	$S_FIX_AUTO_ORDER_VIRTUAL_PROCESS_USE = "";

	## 커뮤니티 아이콘 사용 유무
	## 사용법		= 관리자 페이지에서 아이콘 선택시 사용자 페이지에서 해당 상품 표시됩니다.
	##				  BOARD_ICON 테이블이 있어야 사용 가능합니다.
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N	
	$S_BOARD_ICON_USE		= "N";
	$S_BOARD_ICON_LIST[]	= "인기글";

	## 상품 카테고리 사용 유무
	## 사용			= 주석처리 혹은 N
	## 미사용		= Y
	$IS_PRODUCT_SUBCATE_UNUSE = "Y";


	## 주문시 개별 상품 배송 등록 사용유무(주문단 버전 1.0 -> 2.0 사용)
	$S_SHOP_ORDER_VERSION  = "V2.0";

	## 해외배송시 수량별 배송 사용
	## 단 배송방법에 따라 기본배송비 금액이 틀려짐
	$S_FIX_DELIVERY_FOR_PRICE['E'] = 0;
	$S_FIX_DELIVERY_FOR_PRICE['R'] = 0;
	$S_FIX_DELIVERY_FOR_PRICE['F'] = 0;
	$S_FIX_DELIVERY_FOR_PRICE['D'] = 0;
	$S_FIX_DELIVERY_FOR_PRICE['T'] = 0;
	$S_FIX_DELIVERY_FOR_PRICE['U'] = 0;
	$S_FIX_DELIVERY_FOR_PRICE['X'] = 0;


	## 상품 상세보기에서 장바구니 담기 클릭시 레이어 팝업으로 표현(bejewel)
	$S_FIX_PRODUCT_CART_POP_USE = "";

	## 상품 리스트 좋아요(관심상품)(bejewel)
	$S_FIX_PRODUCT_LIST_LIKE_USE = "";


	## 상품 대량구매 사용(bejewel)
	$S_FIX_PRODUCT_VIEW_LARGE_BUY_USE = "";

	## 주문총합으로 discount 설정(bejewel)
	$S_FIX_ORDER_TOTAL_DISCOUNT_USE = "";

	## 메일관리 버전 관리
	## 1 : 2014.03.27 업데이한 버전(다중으로 보내는 사람 설정 할 수 있음)
	$S_SEND_MAIL_VERSION		= "1";

	## 태깅가이트사용여부(아로마리즈)
	## 바로구매/장바구니 버튼에 적용
	## 상품 대표이미지에 ID 적용
	$S_FIX_LOG_GUIDE_USE		= "";
	$S_FIX_LOG_ORDER_BTN_USE	= "";
	$S_FIX_LOG_BASKET_BTN_USE	= "";
	$S_FIX_LOG_PROD_IMG_ID_USE	= "";

	
	## 입점사 상품 등록시 포인트 등록 금지(애협:입점사가 포인트 등록이 안되게 막기(등록및대량등록)
	$S_FIX_MALL_PROD_POINT_INSERT = "";

	## 상품찾기 기능 사용
	## 사용법		= 메뉴얼 참고
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$S_PRODUCT_SEARCH_USE = "N";
	
	## 페이팔 결제시 payments 결제방법 결정(Authorization,Sale)
	$S_PAYPAL_PAYMENT_MTH = "";

	## 상품리스트 ADD_CART 사용
	$S_PROD_ADD_CART_USE	= "N";

	## 상품리스트 상품평 사용
	$S_PROD_REVIEW_USE		= "Y";

	## 제고 수량 출력 여부
	## 사용			= Y
	## 미사용		= 주석처리 혹은 N
	$S_IS_QTY_SHOW = "Y";

	## 상품할인율 출력여부
	$S_FIX_PRODUCT_DISCOUNT_RATE_SHOW = "Y";

	## 상품무료배송 출력여부
	$S_FIX_PRODUCT_FREE_DELIVERY_SHOW = "Y";

	## 상품추가항목 (버전 1.0 -> 2.0 사용)
	$S_SHOP_PROD_ADD_ITEM_VERSION  = "V2.O";

	## 신규 팝업 서비스
	## 사용			= true
	## 미사용		= 주석처리 혹은 false
	## 사용을 원하는 경우 POPUP_MGR 테이블이 있어야 합니다.
	## 최초 파이러스텍 적용, browncheap,_copy_sample, demo2 적용됨.
	$S_IS_POPUP2 = true;

	## 상품다국어출력여부사용("Y/N")
	$S_PROD_MANY_LANG_VIEW  = "Y";

	## 커뮤니티 버전 관리
	## 2014.06.21
	## kim hee sung
	## '' or 'V2.0'
	$S_COMMUNITY_VERSION = "V2.0";

	## 디자인관리 버전 관리
	## 2014.06.22
	## kim hee sung
	## '' or 'V2.0'
	$S_LAYOUT_VERSION = "V2.0";


	## 국가가 KR일때 통관정책정보입력방법 사용(Y/N)
	$S_ORDER_KOREA_SHIPPING_POLICY_USE = "N";

	## 비밀번호 찾기시 이전 사이트 회원 DB 암호화를 알 수 없을때 사용(인증제도 : 이메일이고 이전 사이트는 아이디일때 아이디와 함께 찾기로 : 버즈몬)
	$S_MEMBER_PWD_FIND_ID_USE = "";

	## 커뮤니티 코멘트 버전 관리
	## 2014.07.14
	## kim hee sung
	$S_COMMUNITY_COMMENT_VERSION = "";

	## 상품 뷰페이지 탭버튼으로 내용 보기
	## 2014.07.17 kim hee sung
	## 사용			= 스킨이름(tabSkin)
	## 미사용		= 주석처리
	$S_PRODUCT_VIEW_SKIN = "";

	## 상품 경매관리 사용하기
	## 2014.07.24 park young mi
	$S_PRODUCT_AUCTION_USE = "";

	## 몰인몰인경우 상품관리 -> 추가옵션 사용하기
	## 2014.07.24 park young mi
	$S_PRODUCT_ADD_OPT_USE = "";

	## 상품진열장 통합(with 디자인관리 -> 세부페이지설정 -> 샵메인/상품리스트)
	## 2014.08.26 kim hee sung
	$S_PRODUCT_ICON_WITH_DESIGN = ""; // Y or ""

	## 커뮤니티 에디터 설정
	## 2014.08.28 kim hee sung
	## eumEditor2
	$S_COMMUNITY_EDTOR = "eumEditor2";

	## 입점사 사용자 신청 설정
	## 2014.08.29 
	$S_SHOP_USER_APPLY_USE = "";

	## shopProdList 스킨 설정 (shopSkin, shopSkin2)
	## 2014.09.04 kim hee sung
	## shopSkin2 -> zacpop 적용
	$S_SHOP_PROD_LIST_SKIN = "";

	## 입점사 가입 버전관리
	## V2.0 -> 다국어 가입폼 추가
	## 사용을 원하는경우 DB 업데이트 필요합니다.
	$S_SHOP_APPLY_REG_VERSION = "";

	## 상품뷰페이지 이미지 뷰 스킨 설정
	## 2014.09.12 kim hee sung
	## 스킨 설정을 하면 옵션 디자인을 사용하지 않습니다.
	## sliderSkin
	$S_PRODUCT_VIEW_IMAGE_SKIN = "";

	## 상품리스트 페이지에서 1차카테고리가 없을 경우 무조건 '001'로 고정
	## 2014.10.18 PARK YOUNG MI
	$S_PRODUCT_LIST_START_LCATE = "";
	
	## 관리자 주문페이지 ; 회원그룹 아이콘 표시 사용
	$S_ADMIN_ORDER_LIST_MEMBER_ICON_USE = "";

	## 다음 api 사용(애협)
	$S_ZIP_DAUM_API_USE = "";

	## 상품에서 메모 리스트 사용 설정
	## Y = 사용
	$S_PRODUCT_LIST_MEMO_USE = "";

	## 상품고시 사용
	## '' => 사용안함
	## true, Y => 사용함, 필수 사용
	## U => 사용함, 필수 사용안함
	$S_PRODUCT_NOTIFY_USE = '';

	## 판매국가 지정 ( 1개국일 경우 국가 셀렉트박스를 hidden 처리하고 자동셀렉트 처리 ex ) KR:CN:JP
	## 본 변수가 주석처리되어 있거나 판매국가가 복수로 처리되어 있다면 기존과 동일하게 동작함.
	#$S_SALE_COUNTRY_LIST = 'KR' ;

	## 관리자 언어별 셋팅 여부
	## 2014.11.05
	$S_ADMIN_LANG_VIEW_YN = "Y";

	## 상품리스트 정렬 정의
	## 2015.03.04 KIM HEE SUNG 
	## 졍렬 사용 설정
	$S_PROUDCT_ORDER_LIST = array('P','S');

	## 이니시스 에스크로 상점아이디/키
	## $S_PG_SITE_CODE2 = '' ;			// 상점아이디
	## $S_PG_SITE_KEY2  = '' ;			// 상점키


	## 예약관리 메뉴 사용 여부 설정
	$MENU_RESERVATION_USE = false;
?>