<input type="hidden" name="buyr_name" id="buyr_name" value=""/>
<input type="hidden" name="buyr_mail" id="buyr_mail" value=""/>
<input type="hidden" name="buyr_tel1" id="buyr_tel1" value=""/>
<input type="hidden" name="buyr_tel2" id="buyr_tel2" value=""/>

<input type="hidden" name="rcvr_name" id="rcvr_name" value=""/>
<input type="hidden" name="rcvr_tel1" id="rcvr_tel1" value=""/>
<input type="hidden" name="rcvr_tel2" id="rcvr_tel2" value=""/>
<input type="hidden" name="rcvr_mail" id="rcvr_mail" value=""/>
<input type="hidden" name="rcvr_zipx" id="rcvr_zipx" value=""/>
<input type="hidden" name="rcvr_add1" id="rcvr_add1" value=""/>
<input type="hidden" name="rcvr_add2" id="rcvr_add2" value=""/>

<?
    /* ============================================================================== */
    /* =   2. 가맹점 필수 정보 설정                                                 = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수 - 결제에 반드시 필요한 정보입니다.                               = */
    /* =   site_conf_inc.php 파일을 참고하셔서 수정하시기 바랍니다.                 = */
    /* = -------------------------------------------------------------------------- = */
    // 요청종류 : 승인(pay)/취소,매입(mod) 요청시 사용
?>
    <input type="hidden" name="req_tx"          value="pay" />
    <input type="hidden" name="site_cd"         value="<?=$g_conf_site_cd	?>" />
    <input type="hidden" name="site_key"        value="<?=$g_conf_site_key  ?>" />
    <input type="hidden" name="site_name"       value="<?=$g_conf_site_name ?>" />

<?
    /*
    할부옵션 : Payplus Plug-in에서 카드결제시 최대로 표시할 할부개월 수를 설정합니다.(0 ~ 18 까지 설정 가능)
    ※ 주의  - 할부 선택은 결제금액이 50,000원 이상일 경우에만 가능, 50000원 미만의 금액은 일시불로만 표기됩니다
               예) value 값을 "5" 로 설정했을 경우 => 카드결제시 결제창에 일시불부터 5개월까지 선택가능
    */
?>
    <input type="hidden" name="quotaopt"        value="12"/>
    <!-- 필수 항목 : 결제 금액/화폐단위 -->
    <input type="hidden" name="currency"        value="WON"/>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   2. 가맹점 필수 정보 설정 END                                             = */
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   3. Payplus Plugin 필수 정보(변경 불가)                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제에 필요한 주문 정보를 입력 및 설정합니다.                            = */
    /* = -------------------------------------------------------------------------- = */
?>
    <!-- PLUGIN 설정 정보입니다(변경 불가) -->
    <input type="hidden" name="module_type"     value="01"/>
    <!-- 복합 포인트 결제시 넘어오는 포인트사 코드 : OK캐쉬백(SCSK), 베네피아 복지포인트(SCWB) -->
    <input type="hidden" name="epnt_issu"       value="" />
<?
    /* ============================================================================== */
    /* =   3-1. Payplus Plugin 에스크로결제 사용시 필수 정보                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제에 필요한 주문 정보를 입력 및 설정합니다.                            = */
    /* = -------------------------------------------------------------------------- = */
?>
	<!-- 에스크로 사용 여부 : 반드시 Y 로 설정 -->
    <input type="hidden" name="escw_used"       value="<?=($S_PG_ESCROW!="N")?"Y":"N";?>"/>
	<!-- 에스크로 결제처리 모드 : 에스크로: Y, 일반: N, KCP 설정 조건: O  -->
    <input type="hidden" name="pay_mod"         value="<?=$S_PG_ESCROW?>"/>
	<!-- 배송 소요일 : 예상 배송 소요일을 입력 -->
	<input type="hidden"  name="deli_term" value="03"/>
	<!-- 장바구니 상품 개수 : 장바구니에 담겨있는 상품의 개수를 입력(good_info의 seq값 참조) -->
	<input type="hidden"  name="bask_cntx" value="3"/>
	<!-- 장바구니 상품 상세 정보 (자바 스크립트 샘플 create_goodInfo()가 온로드 이벤트시 설정되는 부분입니다.) -->
	<input type="hidden" name="good_info"       value=""/>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   3-1. Payplus Plugin 에스크로결제 사용시 필수 정보  END                   = */
    /* ============================================================================== */
?>
<!--
      ※ 필 수
          필수 항목 : Payplus Plugin에서 값을 설정하는 부분으로 반드시 포함되어야 합니다
          값을 설정하지 마십시오
-->
    <input type="hidden" name="res_cd"          value=""/>
    <input type="hidden" name="res_msg"         value=""/>
    <input type="hidden" name="tno"             value=""/>
    <input type="hidden" name="trace_no"        value=""/>
    <input type="hidden" name="enc_info"        value=""/>
    <input type="hidden" name="enc_data"        value=""/>
    <input type="hidden" name="ret_pay_method"  value=""/>
    <input type="hidden" name="tran_cd"         value=""/>
    <input type="hidden" name="bank_name"       value=""/>
    <input type="hidden" name="bank_issu"       value=""/>
    <input type="hidden" name="use_pay_method"  value=""/>

    <!--  현금영수증 관련 정보 : Payplus Plugin 에서 설정하는 정보입니다 -->
    <input type="hidden" name="cash_tsdtime"    value=""/>
    <input type="hidden" name="cash_yn"         value=""/>
    <input type="hidden" name="cash_authno"     value=""/>
    <input type="hidden" name="cash_tr_code"    value=""/>
    <input type="hidden" name="cash_id_info"    value=""/>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   3. Payplus Plugin 필수 정보 END                                          = */
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   4. 옵션 정보                                                             = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 옵션 - 결제에 필요한 추가 옵션 정보를 입력 및 설정합니다.             = */
    /* = -------------------------------------------------------------------------- = */

    /* PayPlus에서 보이는 신용카드사 삭제 파라미터 입니다
    ※ 해당 카드를 결제창에서 보이지 않게 하여 고객이 해당 카드로 결제할 수 없도록 합니다. (카드사 코드는 매뉴얼을 참고)
    <input type="hidden" name="not_used_card" value="CCPH:CCSS:CCKE:CCHM:CCSH:CCLO:CCLG:CCJB:CCHN:CCCH"/> */

	if ($S_FIX_ORDER_NOT_USED_CARD){
?>	
	<input type="hidden" name="not_used_card" value="<?=$S_FIX_ORDER_NOT_USED_CARD?>"/>
<?
	}


    /* 신용카드 결제시 OK캐쉬백 적립 여부를 묻는 창을 설정하는 파라미터 입니다
         OK캐쉬백 포인트 가맹점의 경우에만 창이 보여집니다
        <input type="hidden" name="save_ocb"        value="Y"/> */
    
	/* 고정 할부 개월 수 선택
	       value값을 "7" 로 설정했을 경우 => 카드결제시 결제창에 할부 7개월만 선택가능
    <input type="hidden" name="fix_inst"        value="07"/> */

	/*  무이자 옵션
            ※ 설정할부    (가맹점 관리자 페이지에 설정 된 무이자 설정을 따른다)                             - "" 로 설정
            ※ 일반할부    (KCP 이벤트 이외에 설정 된 모든 무이자 설정을 무시한다)                           - "N" 로 설정
            ※ 무이자 할부 (가맹점 관리자 페이지에 설정 된 무이자 이벤트 중 원하는 무이자 설정을 세팅한다)   - "Y" 로 설정
    <input type="hidden" name="kcp_noint"       value=""/> */

    
	/*  무이자 설정
            ※ 주의 1 : 할부는 결제금액이 50,000 원 이상일 경우에만 가능
            ※ 주의 2 : 무이자 설정값은 무이자 옵션이 Y일 경우에만 결제 창에 적용
            예) 전 카드 2,3,6개월 무이자(국민,비씨,엘지,삼성,신한,현대,롯데,외환) : ALL-02:03:04
            BC 2,3,6개월, 국민 3,6개월, 삼성 6,9개월 무이자 : CCBC-02:03:06,CCKM-03:06,CCSS-03:06:04
    <input type="hidden" name="kcp_noint_quota" value="CCBC-02:03:06,CCKM-03:06,CCSS-03:06:09"/> */

    
	/*  가상계좌 은행 선택 파라미터
         ※ 해당 은행을 결제창에서 보이게 합니다.(은행코드는 매뉴얼을 참조) */
?>
    <input type="hidden" name="wish_vbank_list" value="05:03:04:07:11:23:26:32:34:81:71"/>
<?
    
	
	/*  가상계좌 입금 기한 설정하는 파라미터 - 발급일 + 3일
    <input type="hidden" name="vcnt_expire_term" value="3"/> */

    /*  가상계좌 입금 시간 설정하는 파라미터
         HHMMSS형식으로 입력하시기 바랍니다
         설정을 안하시는경우 기본적으로 23시59분59초가 세팅이 됩니다
         <input type="hidden" name="vcnt_expire_term_time" value="120000"/> */


    /* 포인트 결제시 복합 결제(신용카드+포인트) 여부를 결정할 수 있습니다.- N 일경우 복합결제 사용안함
        <input type="hidden" name="complex_pnt_yn" value="N"/>    */

	/* 문화상품권 결제시 가맹점 고객 아이디 설정을 해야 합니다.(필수 설정)
	    <input type="hidden" name="tk_shop_id" value=""/>    */
    
	/* 현금영수증 등록 창을 출력 여부를 설정하는 파라미터 입니다
         ※ Y : 현금영수증 등록 창 출력
         ※ N : 현금영수증 등록 창 출력 안함
		 ※ 주의 : 현금영수증 사용 시 KCP 상점관리자 페이지에서 현금영수증 사용 동의를 하셔야 합니다 */
?>
    <input type="hidden" name="disp_tax_yn"     value="Y"/>
<?
    /* 결제창에 가맹점 사이트의 로고를 플러그인 좌측 상단에 출력하는 파라미터 입니다
       업체의 로고가 있는 URL을 정확히 입력하셔야 하며, 최대 150 X 50  미만 크기 지원

	※ 주의 : 로고 용량이 150 X 50 이상일 경우 site_name 값이 표시됩니다. */
?>
    <input type="hidden" name="site_logo"       value="" />
<?
	/* 결제창 영문 표시 파라미터 입니다. 영문을 기본으로 사용하시려면 Y로 세팅하시기 바랍니다
		2010-06월 현재 신용카드와 가상계좌만 지원됩니다
		<input type='hidden' name='eng_flag'      value='Y'> */
?>

<?
	/* KCP는 과세상품과 비과세상품을 동시에 판매하는 업체들의 결제관리에 대한 편의성을 제공해드리고자, 
	   복합과세 전용 사이트코드를 지원해 드리며 총 금액에 대해 복합과세 처리가 가능하도록 제공하고 있습니다
	
	   복합과세 전용 사이트 코드로 계약하신 가맹점에만 해당이 됩니다
    
	   상품별이 아니라 금액으로 구분하여 요청하셔야 합니다
	
	   총결제 금액은 과세금액 + 부과세 + 비과세금액의 합과 같아야 합니다. 
	   (good_mny = comm_tax_mny + comm_vat_mny + comm_free_mny)
	 */
	 //if ($SHOP_ORDER_PG_TAX_FLAG == "Y"){
?>
	   <input type="hidden" name="tax_flag"          value="TG03">     <!-- 변경불가    -->
	   <input type="hidden" name="comm_tax_mny"	     value="">         <!-- 과세금액    --> 
       <input type="hidden" name="comm_vat_mny"      value="">         <!-- 부가세	    -->
	   <input type="hidden" name="comm_free_mny"     value="">         <!-- 비과세 금액 -->  
<?
	// }
	   /*skin_indx 값은 스킨을 변경할 수 있는 파라미터이며 총 7가지가 지원됩니다. 
	   변경을 원하시면 1부터 7까지 값을 넣어주시기 바랍니다. */
?>
    <input type='hidden' name='skin_indx'      value='1'>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   4. 옵션 정보 END                                                         = */
    /* ============================================================================== */
?>
