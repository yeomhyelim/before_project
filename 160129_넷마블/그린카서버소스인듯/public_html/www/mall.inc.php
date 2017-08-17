<?	
	// 공통 변수 설정
	DEFINE("MALL_HOME", $S_DOCUMENT_ROOT."www");
	DEFINE("SHOP_HOME", $S_DOCUMENT_ROOT);
	DEFINE("MALL_SHOP", $S_DOCUMENT_ROOT);
	DEFINE("MALL_ADMIN", MALL_HOME . "/web/shopAdmin");

	DEFINE("MALL_CONF_MYSQL",MALL_HOME."/config/mysql.class.php",true);
	DEFINE("MALL_CONF_SMS",MALL_HOME."/config/sms.class.php",true);
	DEFINE("MALL_CONF_FILE",MALL_HOME."/config/file.class.php",true);
	DEFINE("MALL_COMM_LIB",MALL_HOME."/config/common.lib.php",true);
	DEFINE("MALL_CONF_SESS",MALL_HOME."/config/session.inc.php",true);
	DEFINE("MALL_CONF_COOKIE",MALL_HOME."/config/cookie.inc.php",true);
	DEFINE("MALL_CONF_LIB",MALL_HOME."/module/",true);
	DEFINE("MALL_CONF_TBL",MALL_HOME."/config/mall.table.php",true);
	DEFINE("MALL_PROD_FUNC",MALL_HOME."/config/product.func.php",true);
	DEFINE("MALL_ORDER_FUNC",MALL_HOME."/config/order.func.php",true);
	
	DEFINE("WEB_FRWORK_ACT",MALL_HOME."/web/frwork/act/",true);
	DEFINE("WEB_FRWORK_HELP",MALL_HOME."/web/frwork/helper/",true);
	DEFINE("WEB_FRWORK_SKIN",MALL_HOME."/web/frwork/skin/",true);
	DEFINE("WEB_FRWORK_JS",MALL_HOME."/web/frwork/js/",true);
	DEFINE("WEB_FRWORK_JSON",MALL_HOME."/web/frwork/json/",true);
	DEFINE("WEB_FRWORK_CERITY",MALL_HOME."/web/frwork/cerity/",true);

	DEFINE("MOB_FRWORK_ACT",MALL_HOME."/mobile/frwork/act/",true);
	DEFINE("MOB_FRWORK_HELP",MALL_HOME."/mobile/frwork/helper/",true);
	DEFINE("MOB_FRWORK_SKIN",MALL_HOME."/mobile/frwork/skin/",true);
	DEFINE("MOB_FRWORK_JS",MALL_HOME."/mobile/frwork/js/",true);

	DEFINE("MALL_WEB_PATH",MALL_HOME."/web/",true);
	DEFINE("MALL_MOB_PATH",MALL_HOME."/mobile/",true);

	DEFINE("MALL_EXCEL_READER",MALL_HOME."/config/excelReader.php",true);

	/* 언어셋팅 */
	DEFINE("MALL_CONF_LANG",MALL_HOME."/lang/",true);
	
	DEFINE("MALL_CONF_LANG_KR",MALL_HOME."/lang/lang.kr.inc.php",true);
	DEFINE("MALL_CONF_LANG_US",MALL_HOME."/lang/lang.us.inc.php",true);
	DEFINE("MALL_CONF_LANG_JP",MALL_HOME."/lang/lang.jp.inc.php",true);
	DEFINE("MALL_CONF_LANG_CN",MALL_HOME."/lang/lang.cn.inc.php",true);
	DEFINE("MALL_CONF_LANG_RU",MALL_HOME."/lang/lang.ru.inc.php",true);
	DEFINE("MALL_CONF_LANG_ID",MALL_HOME."/lang/lang.id.inc.php",true);
	DEFINE("MALL_CONF_LANG_ES",MALL_HOME."/lang/lang.es.inc.php",true);		// 스페인어
	DEFINE("MALL_CONF_LANG_MX",MALL_HOME."/lang/lang.mx.inc.php",true);		// 스페인어
	DEFINE("MALL_CONF_LANG_TW",MALL_HOME."/lang/lang.tw.inc.php",true);		// 대만
	DEFINE("MALL_CONF_LANG_AU",MALL_HOME."/lang/lang.au.inc.php",true);		// 호주
	DEFINE("MALL_CONF_LANG_MN",MALL_HOME."/lang/lang.mn.inc.php",true);		// 몽골
	DEFINE("MALL_CONF_LANG_DE",MALL_HOME."/lang/lang.de.inc.php",true);		// 독일

	DEFINE("SESS_MEMBER_LOGIN","member_login",true);
	DEFINE("SESS_MEMBER_ID","member_id",true);
	DEFINE("SESS_MEMBER_NO","member_no",true);
	DEFINE("SESS_MEMBER_EMAIL","member_email",true);
	DEFINE("SESS_MEMBER_NAME","member_name",true);
	DEFINE("SESS_MEMBER_LAST_NAME","member_last_name",true);
	DEFINE("SESS_MEMBER_LEVEL","member_level",true);
	DEFINE("SESS_MEMBER_GROUP","member_group",true);
	DEFINE("SESS_MEMBER_GROUP_NAME","member_group_name",true);
	DEFINE("SESS_MEMBER_IPADDR","member_ipaddr",true);
	DEFINE("SESS_MEMBER_FACEBOOK_LOGIN","member_facebook_login",true);
	DEFINE("SESS_MEMBER_NICKNAME","member_nickname",true);

	DEFINE("DESIGN_LAYOUT_HOME" , "http://www.eumshop.com/himg/design/", true);		//레이아웃 이미지 홈 디렉토리
	
	//웹 캐릭터셋(캐릭터셋을 변경할 경우 mysql.class.php 캐랙터셋을 변경해주어야 한다.);
	$S_WEB_CHARSET	= "UTF-8"; 
	
	$S_ARY_COUNTRY["KR"] = "한국";
	$S_ARY_COUNTRY["US"] = "미국";
	$S_ARY_COUNTRY["ID"] = "인도네시아";
	$S_ARY_COUNTRY["CN"] = "중국";
	$S_ARY_COUNTRY["JP"] = "일본";
	$S_ARY_COUNTRY["FR"] = "프랑스";
	$S_ARY_COUNTRY["RU"] = "러시아";
	$S_ARY_COUNTRY["ES"] = "스페인";
	$S_ARY_COUNTRY["MX"] = "멕시코";
	$S_ARY_COUNTRY["TW"] = "대만";
	$S_ARY_COUNTRY["AU"] = "호주";
	$S_ARY_COUNTRY["MN"] = "몽골";
	$S_ARY_COUNTRY["DE"] = "독일";

	$S_ARY_NAT_CUR["KR"] = "KRW";
	$S_ARY_NAT_CUR["US"] = "USD";
	$S_ARY_NAT_CUR["ID"] = "IDR";
	$S_ARY_NAT_CUR["CN"] = "CNY";
	$S_ARY_NAT_CUR["JP"] = "JPY";
	$S_ARY_NAT_CUR["FR"] = "EUR";
	$S_ARY_NAT_CUR["RU"] = "RUB";
	$S_ARY_NAT_CUR["ES"] = "EUR";
	$S_ARY_NAT_CUR["TW"] = "TWD";
	$S_ARY_NAT_CUR["AU"] = "AUD";
	$S_ARY_NAT_CUR["MN"] = "MNT";
	$S_ARY_NAT_CUR["DE"] = "EUR";
		
	$S_ARY_MONEY_ICON["KR"]["R"] = "원";
	$S_ARY_MONEY_ICON["US"]["L"] = "USD";
	$S_ARY_MONEY_ICON["ID"]["L"] = "IDR";
	$S_ARY_MONEY_ICON["CN"]["L"] = "CNY";
	$S_ARY_MONEY_ICON["JP"]["R"] = "円";
	$S_ARY_MONEY_ICON["FR"]["L"] = "EUR";
	$S_ARY_MONEY_ICON["RU"]["L"] = "RUB";
	$S_ARY_MONEY_ICON["RU"]["R"] = "руб";
	$S_ARY_MONEY_ICON["ES"]["L"] = "EUR";
	$S_ARY_MONEY_ICON["TW"]["L"] = "$";
	$S_ARY_MONEY_ICON["AU"]["L"] = "AUD";
	$S_ARY_MONEY_ICON["MN"]["L"] = "₮";
	$S_ARY_MONEY_ICON["DE"]["L"] = "EUR";

	$S_ARY_CURRENCY_ICON["MXN"]["L"] = "MXN";
	$S_ARY_CURRENCY_ICON["MXN"]["R"] = "";

	//단위설정
	$S_ARY_PRICE_UNIT[1] = "%";
	$S_ARY_PRICE_UNIT[2] = "원";
	
	//게시판종류
//	$S_ARY_BOARD_TYPE['BN'] = "일반게시판";
//	$S_ARY_BOARD_TYPE['BG'] = "갤러리게시판";
//	$S_ARY_BOARD_TYPE['BB'] = "블러그게시판";

	$S_KCP_BUY_OK = "https://admin.kcp.co.kr/Modules/Sale/ESCROW/n_order_confirm.jsp?site_cd=";
	$S_KCP_BUY_NO = "https://admin.kcp.co.kr/Modules/Sale/ESCROW/n_deli_cancel.jsp?site_cd=";

	/* 상품 무게 설정 */
	$S_ARY_PROD_WEIGHT["1"] = "1500"; 
	$S_ARY_PROD_WEIGHT["2"] = "1000";
	$S_ARY_PROD_WEIGHT["3"] = "500";

	/* 해외배송 결제방법 */
	$S_ARY_DELIVERY_METHOD["E"] = "EMS";
	$S_ARY_DELIVERY_METHOD["K"] = "K-Packet";
	$S_ARY_DELIVERY_METHOD["R"] = "RR Register";
	$S_ARY_DELIVERY_METHOD["F"] = "Air Parcel";


	$S_ARY_DELIVERY_METHOD["D"] = "DHL";
	$S_ARY_DELIVERY_METHOD["T"] = "TNT";
	$S_ARY_DELIVERY_METHOD["U"] = "UPS";
	$S_ARY_DELIVERY_METHOD["X"] = "FedEx";
	$S_ARY_DELIVERY_METHOD["H"] = "하나택배";
	$S_ARY_DELIVERY_METHOD["S"] = "佐川(さがわ)急便";

	$S_ARY_DELIVERY_METHOD["C01"] = "顺丰快递";
	$S_ARY_DELIVERY_METHOD["C02"] = "圆通快递";
	$S_ARY_DELIVERY_METHOD["C03"] = "中通快递";
	$S_ARY_DELIVERY_METHOD["C04"] = "airmail";
	$S_ARY_DELIVERY_METHOD["C05"] = "韵达快递"; // 윈다택배


	/* 환불은행 정보 */
	$S_ARY_RETURN_BANK["39"] = "경남은행";
	$S_ARY_RETURN_BANK["34"] = "광주은행";
	$S_ARY_RETURN_BANK["04"] = "국민은행";
	$S_ARY_RETURN_BANK["03"] = "기업은행";
	$S_ARY_RETURN_BANK["11"] = "농협";
	$S_ARY_RETURN_BANK["31"] = "대구은행";
	$S_ARY_RETURN_BANK["32"] = "부산은행";
	$S_ARY_RETURN_BANK["45"] = "새마을금고";
	$S_ARY_RETURN_BANK["07"] = "수협";
	$S_ARY_RETURN_BANK["88"] = "신한은행";
	$S_ARY_RETURN_BANK["48"] = "신협";
	$S_ARY_RETURN_BANK["05"] = "외환은행";
	$S_ARY_RETURN_BANK["20"] = "우리은행";
	$S_ARY_RETURN_BANK["71"] = "우체국";
	$S_ARY_RETURN_BANK["35"] = "제주은행";
	$S_ARY_RETURN_BANK["81"] = "하나은행";
	$S_ARY_RETURN_BANK["27"] = "한국시티은행";
	$S_ARY_RETURN_BANK["54"] = "HSBC";
	$S_ARY_RETURN_BANK["23"] = "SC제일은행";
	$S_ARY_RETURN_BANK["02"] = "산업은행";
	$S_ARY_RETURN_BANK["37"] = "전북은행";


	## autoload 실행
	require_once MALL_HOME . "/config/autoload.php";
	

	## 2014.06.27 kim hee sung
	## 현재 요청 URL param
	## config 통합되면 위치 이동이 필요함
	$S_REQUEST_URI_PARAM = $_SERVER['QUERY_STRING'];
	if($S_REQUEST_URI_PARAM) { $S_REQUEST_URI_PARAM = "?{$S_REQUEST_URI_PARAM}"; }

	## sms db 정보
	DEFINE("WEB_CONF_DB_SMS",require_once MALL_SHOP . "/config/db.php",true);
	$DB_SMS_PATH	= WEB_CONF_DB_SMS;


?>
