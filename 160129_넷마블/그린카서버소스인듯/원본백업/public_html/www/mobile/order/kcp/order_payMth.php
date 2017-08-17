<?
    /* ============================================================================== */
    /* =   PAGE : 결제 요청 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   이 페이지는 주문 페이지를 통해서 결제자가 결제 요청을 하는 페이지        = */
    /* =   입니다. 아래의 ※ 필수, ※ 옵션 부분과 매뉴얼을 참조하셔서 연동을        = */
    /* =   진행하여 주시기 바랍니다.                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.05   KCP Inc.   All Rights Reserved.                 = */
    /* ============================================================================== */
?>
<?
	/* ============================================================================== */
    /* =   환경 설정 파일 Include                                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수                                                                  = */
    /* =   테스트 및 실결제 연동시 site_conf_inc.php파일을 수정하시기 바랍니다.     = */
    /* = -------------------------------------------------------------------------- = */

    require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_conf_inc.php";

?>


<!-- 거래등록 하는 kcp 서버와 통신을 위한 스크립트-->
<script type="text/javascript" src="./common/kcp/approval_key.js"></script>


<script language="javascript">
	
	$(document).ready(function(){
		chk_pay();
		create_goodInfo();
	});

	/* kcp web 결제창 호출 (변경불가)*/
    function call_pay_form()
    {

       var v_frm = document.sm_form;

        layer_cont_obj	= document.getElementById("content");
        layer_all_obj	= document.getElementById("layer_all");
		
        layer_cont_obj.style.display = "none";
        layer_all_obj.style.display = "block";

//		document.getElementById("topWraper") .style.display = 'none';
//		document.getElementById("bottomWraper") .style.display = 'none';

        v_frm.target = "frm_all";
        v_frm.action = PayUrl;
		
		if(v_frm.Ret_URL.value == "")
		{
			/* Ret_URL값은 현 페이지의 URL 입니다. */
			alert("연동시 Ret_URL을 반드시 설정하셔야 됩니다.");
			return false;
		}
		else
        {
			v_frm.submit();
		}

        v_frm.submit();
    }

	/* 에스크로 가맹점 장바구니 상품 상세 정보 생성 예제 */ 
	function create_goodInfo()
    {
		var chr30 = String.fromCharCode(30);	// ASCII 코드값 30
        var chr31 = String.fromCharCode(31);	// ASCII 코드값 31
		var good_info = "";
		
		<?
			$temp3 = "";
			$temp4 = "";
			$temp = explode("{-}", $strOrderCartInfoList);
			foreach($temp as $val):
				$temp2 = explode("{+}", $val);
				foreach($temp2 as $val2):
					if($temp3) { $temp3 .=  "+ chr31 +"; }
					$temp3 .=  "\"{$val2}\"";
				endforeach;
				if($temp4) { $temp4 .=  "+ chr30 +"; }
				$temp4 .=  $temp3;
			endforeach;

			echo "good_info = {$temp4};";
		?>
		document.sm_form.good_info.value = good_info;
    }


	/* kcp 통신을 통해 받은 암호화 정보 체크 후 결제 요청*/
    function chk_pay()
    {
        /*kcp 결제서버에서 가맹점 주문페이지로 폼값을 보내기위한 설정(변경불가)*/
        self.name = "tar_opener";

        var pay_form = document.pay_form;

		if (pay_form.res_cd.value == "3001" )
		{
		  alert("사용자가 취소하였습니다.");
		  pay_form.res_cd.value = "";
		}
		else if (pay_form.res_cd.value == "3000" )
		{
		  alert("30만원 이상 결제를 할 수 없습니다.");
		  pay_form.res_cd.value = "";
		}

		if (pay_form.enc_info.value){
			jsf__show_progress(true);
			//pay_form.submit();
			alert("페이지 하단의 확인 버튼을 눌러 주세요.");
		} else {
			jsf__show_progress(false);
			return false;
		}
    }
	
	function  jsf__show_progress( show )
    {
        if ( show == true )
        {
            document.getElementById("show_pay_btn") .style.display  = '';
            document.getElementById("show_progress").style.display = '';
            document.getElementById("show_req_btn") .style.display = 'none';
        }
        else
        { 
            document.getElementById("show_pay_btn") .style.display  = 'none';
            document.getElementById("show_progress").style.display = 'none';
            document.getElementById("show_req_btn") .style.display = '';
        }
    }

    /* 최종 결제 요청*/
    function jsf__pay ()
    {
        var pay_form = document.pay_form;
        pay_form.submit();
    }

</script>

<div id="content">

<form name="sm_form" method="POST" accept-charset="euc-kr">


<input type="hidden" name='good_name' maxlength="100" value='<?=$orderRow[O_J_TITLE]?>'>
<input type="hidden" name='good_mny' size="9" maxlength="9" value='<?=getCurToPriceSave($orderRow[O_TOT_SPRICE])?>' >
<input type="hidden" name='buyr_name' size="20" maxlength="20" value="<?=$orderRow[O_J_NAME]?>">
<input type="hidden" name='buyr_tel1' size="20" maxlength="20" value='<?=$orderRow[O_J_PHONE]?>'>
<input type="hidden" name='buyr_tel2' size="20" maxlength="20" value='<?=$orderRow[O_J_HP]?>'>
<input type="hidden" name='buyr_mail' size="20" maxlength="30" value='<?=$orderRow[O_J_MAIL]?>'>

<input type="hidden" name="tax_flag" value="TG03">     <!-- 변경불가    -->
<input type="hidden" name="comm_tax_mny" value="<?=$comm_tax_mny;?>">     <!-- 과세금액    --> 
<input type="hidden" name="comm_vat_mny" value="<?=$comm_vat_mny;?>">     <!-- 부가세	    -->
<input type="hidden" name="comm_free_mny" value="<?=$comm_free_mny;?>">    <!-- 비과세 금액 -->  

<?	include MALL_MOB_PATH."order/order_orderStep2.php";?>
<div style="padding:10px;">
	<div class="btnCenter" id='show_req_btn'>
		<a href="javascript:kcp_AJAX();" class="payBigBtn btn_red"><span>결제하기</span></a>
		<a href="/?menuType=order&mode=cart" class="cancelBigBtn btn_black"><span>취소</span></a>
	</div>
	<div class="btnCenter" id='show_progress' style='display:none;'>
		반드시 확인버튼을 클릭 하셔야만 결제가 진행됩니다.
	</div>

	<div class="btnCenter" id='show_pay_btn' style='display:none;display:block;clear:both;'>
		<a href="javascript:jsf__pay();" class="payBigBtn"><span>결제확인</span></a>
		<a href="/?menuType=order&mode=cart" class="cancelBigBtn"><span>취소</span></a>
	</div>
</div>
<!-- 필수 사항 -->

<!-- 요청 구분 -->
<input type='hidden' name='req_tx'       value='pay'>
<input type="hidden" name='shop_name'    value="<?=$g_conf_site_name?>"> <!-- 사이트 이름 --> 
<input type="hidden" name='site_cd'      value="<?=$g_conf_site_cd?>"> <!-- 사이트 코드 -->
<input type="hidden" name='currency'     value="410"> <!-- 통화 코드 -->
<input type="hidden" name="eng_flag"     value="N"/>  <!-- 한 / 영 -->
<!-- 결제등록 키 -->
<input type="hidden" name='approval_key' id="approval">
<!-- 결제수단-->
<input type="hidden" name='pay_method'   value="<?=$strPayMethod?>">
<input type="hidden" name="van_code"    value="<?=$van_code?>">
<!-- 최대 할부개월수 -->
<input type="hidden" name='quotaopt'     value="12">

<!-- 주문번호 -->
<input type="hidden" name='ordr_idxx'  value="<?=$ordr_idxx?>">

<!-- 가맹점에서 관리하는 고객 아이디 설정을 해야 합니다.(필수 설정) -->
<input type="hidden" name="shop_user_id"    value="<?=$intO_NO?>"/>
<!-- 복지포인트 결제시 가맹점에 할당되어진 코드 값을 입력해야합니다.(필수 설정) -->
<input type="hidden" name="pt_memcorp_cd"   value=""/>
<!-- 현금영수증 설정 -->
<input type="hidden" name="disp_tax_yn"     value="Y"/>

<!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
<!-- 반드시 가맹점 주문페이지의 URL을 입력 해주시기 바랍니다. -->
<input type="hidden" name='Ret_URL'      value="http://<?=$S_HTTP_HOST?>/mobile/order.mobile.return.php">
<!-- 인증시 필요한 파라미터(변경불가)-->
<input type='hidden' name='ActionResult' value='<?=$strPayActionResult?>'> 
<!-- 인증시 필요한 파라미터(변경불가)-->
<input type="hidden" name='escw_used'    value="<?=$strPayEscw?>">
<!-- 기타 파라메터 추가 부분 - Start - -->
<input type="hidden" name='param_opt_1'	 value="<?=$intO_NO?>"/>
<input type="hidden" name='param_opt_2'	 value="<?=$strOrderCartNo?>"/>
<!-- 쿠폰 배열로 가져가기 위해서 정보 넣음.-->
<? 

	for($i=0; $i < count($_POST[couponUseIssueNo]); $i++) {
		$paramTemp .= $_POST[couponUseIssueNo][$i]."|";
	}

?>


<input type="hidden" name='param_opt_3'	 value="<?=$paramTemp;?>"/>
<!-- 기타 파라메터 추가 부분 - End - -->
<!-- 화면 크기조정 부분 - Start - -->
<input type="hidden" name='tablet_size'	 value="<?=$tablet_size?>"/>
<!-- 화면 크기조정 부분 - End - -->
<!--
	사용 카드 설정
	<input type="hidden" name='used_card'    value="CClg:ccDI">
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
-->
<?if ($S_FIX_ORDER_NOT_USED_CARD){?>
<input type="hidden" name="not_used_card" value="<?=$S_FIX_ORDER_NOT_USED_CARD?>"/>
<?}?>

<!-- 에스크로 결제처리모드 -->
<input type="hidden" name='pay_mod'   value='<?=$strPayMode?>'>
<?if ($orderRow[O_SETTLE] == "T" || $orderRow[O_SETTLE] == "A"){?>
<!-- 수취인이름 -->
<input type="hidden" name='rcvr_name' value='<?=$orderRow[O_B_NAME]?>'>
<!-- 수취인 연락처 -->
<input type="hidden" name='rcvr_tel1' value='<?=$orderRow[O_B_PHONE]?>'>
<!-- 수취인 휴대폰 번호 -->
<input type="hidden" name='rcvr_tel2' value='<?=$orderRow[O_B_HP]?>'>
<!-- 수취인 E-MAIL -->
<input type="hidden" name='rcvr_add1' value='<?=$orderRow[O_B_ADDR1]?>'>
<!-- 수취인 우편번호 -->
<input type="hidden" name='rcvr_add2' value='<?=$orderRow[O_B_ADDR2]?>'>
<!-- 수취인 주소 -->
<input type="hidden" name='rcvr_mail' value='<?=$orderRow[O_B_MAIL]?>'>
<!-- 수취인 상세 주소 -->
<input type="hidden" name='rcvr_zipx' value='<?=$orderRow[O_B_ZIP]?>'>
<!-- 배송소요기간 -->
<?}?>
<input type="hidden" name='deli_term' value='03'>
<input type="hidden" name='ipgm_date' value='<?=date("YmdHis", strtotime("+3 day"))?>'>
<!-- 장바구니 상품 개수 -->
<input type="hidden" name='bask_cntx' value="<?=$intProdCnt?>">
<!-- 장바구니 정보(상단 스크립트 참조) -->
<input type="hidden" name='good_info' value="">
</form>
</div>

<!-- 스마트폰에서 KCP 결제창을 레이어 형태로 구현-->
<?if (preg_match('/(iPhone)/i',$S_USER_AGENT)){?>
<div id="layer_all" style="position:absolute; left:1px; top:1px; width:310;height:400; z-index:999; display:none;">
    <table width="310" border="-" cellspacing="0" cellpadding="0" style="text-align:center">
        <tr>
            <td>
                <iframe name="frm_all" frameborder="0" border="0" width="310" height="400" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
</div>
<?}else{?>
<div id="layer_all" style="position:absolute; left:0px; top:0px; width:100%;height:100%; z-index:998; display:none;">
   <table width="100%" height="100%" border="-" cellspacing="0" cellpadding="0" style="text-align:center">
        <tr width="100%" height="100%">
            <td>
                <iframe name="frm_all" frameborder="0" marginheight="0" marginwidth="0" border="0" width="100%" height="100%" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
</div>
<?}?>
<form name="pay_form" method="POST" action="../index.php">
    <input type="hidden" name="req_tx"         value="<?=$req_tx?>">      <!-- 요청 구분          -->
    <input type="hidden" name="res_cd"         value="<?=$res_cd?>">      <!-- 결과 코드          -->
    <input type="hidden" name="tran_cd"        value="<?=$tran_cd?>">     <!-- 트랜잭션 코드      -->
    <input type="hidden" name="ordr_idxx"      value="<?=$ordr_idxx?>">   <!-- 주문번호           -->
    <input type="hidden" name="good_mny"       value="<?=$good_mny?>">    <!-- 휴대폰 결제금액    -->
    <input type="hidden" name="good_name"      value="<?=$good_name?>">   <!-- 상품명             -->
    <input type="hidden" name="buyr_name"      value="<?=$buyr_name?>">   <!-- 주문자명           -->
    <input type="hidden" name="buyr_tel1"      value="<?=$buyr_tel1?>">   <!-- 주문자 전화번호    -->
    <input type="hidden" name="buyr_tel2"      value="<?=$buyr_tel2?>">   <!-- 주문자 휴대폰번호  -->
    <input type="hidden" name="buyr_mail"      value="<?=$buyr_mail?>">   <!-- 주문자 E-mail      -->
    <input type="hidden" name="enc_info"       value="<?=$enc_info?>">    <!-- 암호화 정보        -->
	<input type="hidden" name="cash_yn"		   value="<?=$cash_yn?>">     <!-- 현금영수증 등록여부-->
    <input type="hidden" name="enc_data"       value="<?=$enc_data?>">    <!-- 암호화 데이터      -->
    <input type="hidden" name="use_pay_method" value="<?=$strPayUsePayMth?>">      <!-- 요청된 결제 수단   -->
    <input type="hidden" name="cash_tr_code"   value="<?=$cash_tr_code?>">
	<input type="hidden" name="param_opt_1"	   value="<?=$param_opt_1?>">
	<input type="hidden" name="param_opt_2"	   value="<?=$param_opt_2?>">
	<input type="hidden" name="param_opt_3"	   value="<?=$param_opt_3?>">

    <input type="hidden" name="rcvr_name"      value="<?=$rcvr_name?>">   <!-- 수취인 이름        -->
    <input type="hidden" name="rcvr_tel1"      value="<?=$rcvr_tel1?>">   <!-- 수취인 전화번호    -->
    <input type="hidden" name="rcvr_tel2"      value="<?=$rcvr_tel2?>">   <!-- 수취인 휴대폰번호  -->
    <input type="hidden" name="rcvr_mail"      value="<?=$rcvr_mail?>">   <!-- 수취인 E-Mail      -->
    <input type="hidden" name="rcvr_zipx"      value="<?=$rcvr_zipx?>">   <!-- 수취인 우편번호    -->
    <input type="hidden" name="rcvr_add1"      value="<?=$rcvr_add1?>">   <!-- 수취인 주소        -->
    <input type="hidden" name="rcvr_add2"      value="<?=$rcvr_add2?>">   <!-- 수취인 상세 주소   -->
	
	<input type="hidden" name="order_no"	   value="<?=$param_opt_1?>">
	<input type="hidden" name="menuType"	   value="order">
	<input type="hidden" name="mode"		   value="pg">
	<input type="hidden" name="act"			   value="pg_mobile">
	<input type="hidden" name="payPg"		   value="K">
</form>
