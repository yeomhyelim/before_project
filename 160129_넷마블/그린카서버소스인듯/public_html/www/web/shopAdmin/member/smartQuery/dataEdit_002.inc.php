<?
	/** 기본 항목 **/
	$cnt = 0;
	$select_column[$cnt]['COLUMN']		= "B.O_KEY";
	$select_column[$cnt]['NAME']		= "주문번호";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.M_NO";
	$select_column[$cnt]['NAME']		= "회원번호";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "C.M_ID";
	$select_column[$cnt]['NAME']		= "회원아이디";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_J_TITLE";
	$select_column[$cnt]['NAME']		= "주문타이틀";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_J_NAME";
	$select_column[$cnt]['NAME']		= "주문자명";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_J_PHONE";
	$select_column[$cnt]['NAME']		= "주문자연락처";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_J_HP";
	$select_column[$cnt]['NAME']		= "주문자핸드폰";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_J_MAIL";
	$select_column[$cnt]['NAME']		= "주문자메일";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_B_NAME";
	$select_column[$cnt]['NAME']		= "받는사람명";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_B_PHONE";
	$select_column[$cnt]['NAME']		= "배송지연락처";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_B_HP";
	$select_column[$cnt]['NAME']		= "배송지핸드폰";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_B_MAIL";
	$select_column[$cnt]['NAME']		= "배송지메일";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_B_ZIP";
	$select_column[$cnt]['NAME']		= "배송지우편번호";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_B_ADDR1";
	$select_column[$cnt]['NAME']		= "배송지주소1";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_B_ADDR2";
	$select_column[$cnt]['NAME']		= "배송지주소2";
	$cnt++;

	if($S_SITE_LNG != "KR"): 
	$select_column[$cnt]['COLUMN']		= "B.O_B_COUNTRY";
	$select_column[$cnt]['NAME']		= "배송지국가";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_B_CITY";
	$select_column[$cnt]['NAME']		= "배송지CITY";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_B_STATE";
	$select_column[$cnt]['NAME']		= "배송지주소STATE";
	$cnt++;
	endif;

	$select_column[$cnt]['COLUMN']		= "B.O_B_MEMO";
	$select_column[$cnt]['NAME']		= "메모";
	$cnt++;

//	$select_column[$cnt]['WHERE_USE']	= "N";
//	$select_column[$cnt]['COLUMN']		= "B.O_PG";
//	$select_column[$cnt]['NAME']		= "결제사(PG)";
//	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_SETTLE";
	$select_column[$cnt]['NAME']		= "결제방법";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_BANK_NAME";
	$select_column[$cnt]['NAME']		= "무통장입금자명";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_BANK";
	$select_column[$cnt]['NAME']		= "무통장입금은행";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_BANK_ACC";
	$select_column[$cnt]['NAME']		= "무통장입금계좌번호";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_DELIVERY_COM";
	$select_column[$cnt]['NAME']		= "배송회사";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_DELIVERY_NUM";
	$select_column[$cnt]['NAME']		= "배송번호";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "B.O_TOT_CUR_SPRICE";
	$select_column[$cnt]['NAME']		= "총결제금액";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "C.M_SMSYN";
	$select_column[$cnt]['NAME']		= "SMS수신여부";
	$cnt++;

	$select_column[$cnt]['COLUMN']		= "C.M_MAILYN";
	$select_column[$cnt]['NAME']		= "메일수신여부";
	$cnt++;

	$select_column[$cnt]['TYPE']		= "o_status";
	$select_column[$cnt]['COLUMN']		= "B.O_STATUS";
	$select_column[$cnt]['NAME']		= "주문상태";
	$cnt++;

	$select_column[$cnt]['WHERE_USE']	= "N";
	$select_column[$cnt]['COLUMN']		= "B.O_REG_DT";
	$select_column[$cnt]['NAME']		= "구매일자";
	$cnt++;

	/** 상품 필드 **/
	$cnt = 0;
	$where_prod_buy_column[$cnt]['COLUMN']		= "A.P_CODE";
	$where_prod_buy_column[$cnt]['NAME']		= "상품코드";
	$cnt++;

	/** 날짜 항목(주문 필드) **/
	$cnt = 0;
	$where_order_date_column[$cnt]['COLUMN']	= "B.O_REG_DT";
	$where_order_date_column[$cnt]['NAME']		= "구매일자";
	$cnt++;	

	/** de_where_defalut **/
	$de_where_defalut			= "A.O_NO IS NOT NULL AND IFNULL(C.M_OUT,'N') <> 'Y' ";
	$de_where_join_defalut		= "B.O_STATUS NOT IN ('F','W')	";
?>