<input type=hidden style=width:100px name=Job maxlength=20 value=""><!--지불방법//-->
<input type=hidden style=width:100px name=StoreId maxlength=20 value="<?=$S_PG_SITE_CODE?>"><!--상점아이디(20)//-->
<input type=hidden style=width:100px name=OrdNo maxlength=40 value=""><!--주문번호(40)//-->
<input type=hidden style=width:100px name=Amt maxlength=12 value="<?=getCurToPriceSave($intCartPriceEndTotal)?>"><!--금액(12)//-->
<input type=hidden style=width:300px name=StoreNm value="<?=$S_SITE_KNAME?>"><!--상점명(50)//-->
<input type=hidden style=width:300px name=ProdNm maxlength=300 value=""><!--상품명(300)//-->
<input type=hidden style=width:300px name=MallUrl value="<?=$S_SITE_URL?>"><!--상점URL(50)//-->
<input type=hidden style=width:300px name=UserEmail maxlength=50 value=""><!--주문자이메일(50)//-->
<input type=hidden style=width:400px name=ags_logoimg_url maxlength=200 value=""><!--상점로고이미지//-->
<input type=hidden style=width:300px name=SubjectData value=""><!--결제창제목입력//-->
<!-- 제목은 1컨텐츠당 5자 이내이며, 상점명;상품명;결제금액;제공기간; 순으로 입력해 주셔야 합니다. -->


<!-- [신용카드, 핸드폰] 결제와 [현금영수증자동발행]을 사용하시는 경우에 반드시 입력해 주시기 바랍니다. -->
<input type=hidden style=width:100px name=UserId maxlength=20 value="">

<!-- 카드 && 가상계좌 사용 변수 //-->
<input type=hidden style=width:100px name=OrdNm maxlength=40 value=""><!--주문자명//-->
<input type=hidden style=width:100px name=OrdPhone maxlength=21 value=""><!--주문자연락처 (21)//-->
<input type=hidden style=width:300px name=OrdAddr maxlength=100 value=""><!--주문자주소 (100)//-->
<input type=hidden style=width:100px name=RcpNm maxlength=40 value="">		<!--수신자명 (40)//-->
<input type=hidden style=width:100px name=RcpPhone maxlength=21 value=""><!--수신자연락처 (21)//-->
<input type=hidden style=width:300px name=DlvAddr maxlength=100 value=""><!--배송지주소 (100)//-->
<input type=hidden style=width:300px name=Remark maxlength=350 value=""><!--기타요구사항 (350)//-->
<input type=hidden style=width:300px name=CardSelect value=""><!--카드사선택//-->
<!-- 결제창에 특정카드만 표기기능입니다. 
		  사용방법 예)  BC, 국민을 사용하고자 하는 경우 ☞ 100:200
						국민 만 사용하고자 하는 경우 ☞ 200
	 모두 사용하고자 할 때에는 아무 값도 입력하지 않습니다.
	 카드사별 코드는 매뉴얼에서 확인해 주시기 바랍니다. -->
<!-- 카드 && 가상계좌 사용 변수 //-->


<!-- 핸드폰 사용 변수 //-->

<!-- CP아이디를 핸드폰 결제 실거래 전환후에는 발급받으신 CPID로 변경하여 주시기 바랍니다. -->
<input type=hidden style=width:100px name=HP_ID maxlength=10 value="">
<!-- CP비밀번호를 핸드폰 결제 실거래 전환후에는 발급받으신 비밀번호로 변경하여 주시기 바랍니다. -->
<input type=hidden style=width:100px name=HP_PWD maxlength=10 value="">
<!-- SUB-CPID는 핸드폰 결제 실거래 전환후에 발급받으신 상점만 입력하여 주시기 바랍니다. -->
<input type=hidden style=width:100px name=HP_SUBID maxlength=10 value="">
<!-- 상품코드를 핸드폰 결제 실거래 전환후에는 발급받으신 상품코드로 변경하여 주시기 바랍니다. -->
<input type=hidden style=width:100px name=ProdCode maxlength=10 value="">
<!-- 상품종류를 핸드폰 결제 실거래 전환후에는 발급받으신 상품종류로 변경하여 주시기 바랍니다. -->
<!-- 판매하는 상품이 디지털(컨텐츠)일 경우 = 1, 실물(상품)일 경우 = 2 -->
<input type=hidden style=width:100px name=HP_UNITType maxlength=1 value="">

<!-- 핸드폰 사용 변수 //-->

<!-- 가상계좌 사용 변수 //-->
<!-- 가상계좌 결제에서 입/출금 통보를 위한 필수 입력 사항 입니다. -->
<!-- 페이지주소는 도메인주소를 제외한 '/'이후 주소를 적어주시면 됩니다. -->
<input type=hidden style=width:300px name=MallPage value="/common/agsPay/commonReturn.php">

<!-- 가상계좌 결제에서 입금가능한 기한을 지정하는 기능입니다. -->
<!-- 발급일자로부터 최대 15일 이내로만 설정하셔야 합니다. -->
<!-- 값을 입력하지 않을 경우, 자동으로 발급일자로부터 5일 이후로 설정됩니다. -->
<input type=hidden style=width:300px name=VIRTUAL_DEPODT value="">

<!-- 가상계좌 사용 변수 //-->



<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->

<!-- 각 결제 공통 사용 변수 -->
<input type=hidden name=Flag value="">				<!-- 스크립트결제사용구분플래그 -->
<input type=hidden name=AuthTy value="">			<!-- 결제형태 -->
<input type=hidden name=SubTy value="">				<!-- 서브결제형태 -->
<input type=hidden name=AGS_HASHDATA value="">	<!-- 암호화 HASHDATA -->

<!-- 신용카드 결제 사용 변수 -->
<input type=hidden name=DeviId value="">			<!-- (신용카드공통)		단말기아이디 -->
<input type=hidden name=QuotaInf value="0">			<!-- (신용카드공통)		일반할부개월설정변수 -->
<input type=hidden name=NointInf value="NONE">		<!-- (신용카드공통)		무이자할부개월설정변수 -->
<input type=hidden name=AuthYn value="">			<!-- (신용카드공통)		인증여부 -->
<input type=hidden name=Instmt value="">			<!-- (신용카드공통)		할부개월수 -->
<input type=hidden name=partial_mm value="">		<!-- (ISP사용)			일반할부기간 -->
<input type=hidden name=noIntMonth value="">		<!-- (ISP사용)			무이자할부기간 -->
<input type=hidden name=KVP_RESERVED1 value="">		<!-- (ISP사용)			RESERVED1 -->
<input type=hidden name=KVP_RESERVED2 value="">		<!-- (ISP사용)			RESERVED2 -->
<input type=hidden name=KVP_RESERVED3 value="">		<!-- (ISP사용)			RESERVED3 -->
<input type=hidden name=KVP_CURRENCY value="">		<!-- (ISP사용)			통화코드 -->
<input type=hidden name=KVP_CARDCODE value="">		<!-- (ISP사용)			카드사코드 -->
<input type=hidden name=KVP_SESSIONKEY value="">	<!-- (ISP사용)			암호화코드 -->
<input type=hidden name=KVP_ENCDATA value="">		<!-- (ISP사용)			암호화코드 -->
<input type=hidden name=KVP_CONAME value="">		<!-- (ISP사용)			카드명 -->
<input type=hidden name=KVP_NOINT value="">			<!-- (ISP사용)			무이자/일반여부(무이자=1, 일반=0) -->
<input type=hidden name=KVP_QUOTA value="">			<!-- (ISP사용)			할부개월 -->
<input type=hidden name=CardNo value="">			<!-- (안심클릭,일반사용)	카드번호 -->
<input type=hidden name=MPI_CAVV value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=MPI_ECI value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=MPI_MD64 value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=ExpMon value="">			<!-- (일반사용)			유효기간(월) -->
<input type=hidden name=ExpYear value="">			<!-- (일반사용)			유효기간(년) -->
<input type=hidden name=Passwd value="">			<!-- (일반사용)			비밀번호 -->
<input type=hidden name=SocId value="">				<!-- (일반사용)			주민등록번호/사업자등록번호 -->

<!-- 계좌이체 결제 사용 변수 -->
<input type=hidden name=ICHE_OUTBANKNAME value="">	<!-- 이체계좌은행명 -->
<input type=hidden name=ICHE_OUTACCTNO value="">	<!-- 이체계좌예금주주민번호 -->
<input type=hidden name=ICHE_OUTBANKMASTER value=""><!-- 이체계좌예금주 -->
<input type=hidden name=ICHE_AMOUNT value="">		<!-- 이체금액 -->

<!-- 핸드폰 결제 사용 변수 -->
<input type=hidden name=HP_SERVERINFO value="">		<!-- 서버정보 -->
<input type=hidden name=HP_HANDPHONE value="">		<!-- 핸드폰번호 -->
<input type=hidden name=HP_COMPANY value="">		<!-- 통신사명(SKT,KTF,LGT) -->
<input type=hidden name=HP_IDEN value="">			<!-- 인증시사용 -->
<input type=hidden name=HP_IPADDR value="">			<!-- 아이피정보 -->

<!-- ARS 결제 사용 변수 -->
<input type=hidden name=ARS_PHONE value="">			<!-- ARS번호 -->
<input type=hidden name=ARS_NAME value="">			<!-- 전화가입자명 -->

<!-- 가상계좌 결제 사용 변수 -->
<input type=hidden name=ZuminCode value="">			<!-- 가상계좌입금자주민번호 -->
<input type=hidden name=VIRTUAL_CENTERCD value="">	<!-- 가상계좌은행코드 -->
<input type=hidden name=VIRTUAL_NO value="">		<!-- 가상계좌번호 -->

<input type=hidden name=mTId value="">	

<!-- 에스크로 결제 사용 변수 -->
<input type=hidden name=ES_SENDNO value="">			<!-- 에스크로전문번호 -->

<!-- 계좌이체(소켓) 결제 사용 변수 -->
<input type=hidden name=ICHE_SOCKETYN value="">		<!-- 계좌이체(소켓) 사용 여부 -->
<input type=hidden name=ICHE_POSMTID value="">		<!-- 계좌이체(소켓) 이용기관주문번호 -->
<input type=hidden name=ICHE_FNBCMTID value="">		<!-- 계좌이체(소켓) FNBC거래번호 -->
<input type=hidden name=ICHE_APTRTS value="">		<!-- 계좌이체(소켓) 이체 시각 -->
<input type=hidden name=ICHE_REMARK1 value="">		<!-- 계좌이체(소켓) 기타사항1 -->
<input type=hidden name=ICHE_REMARK2 value="">		<!-- 계좌이체(소켓) 기타사항2 -->
<input type=hidden name=ICHE_ECWYN value="">		<!-- 계좌이체(소켓) 에스크로여부 -->
<input type=hidden name=ICHE_ECWID value="">		<!-- 계좌이체(소켓) 에스크로ID -->
<input type=hidden name=ICHE_ECWAMT1 value="">		<!-- 계좌이체(소켓) 에스크로결제금액1 -->
<input type=hidden name=ICHE_ECWAMT2 value="">		<!-- 계좌이체(소켓) 에스크로결제금액2 -->
<input type=hidden name=ICHE_CASHYN value="">		<!-- 계좌이체(소켓) 현금영수증발행여부 -->
<input type=hidden name=ICHE_CASHGUBUN_CD value="">	<!-- 계좌이체(소켓) 현금영수증구분 -->
<input type=hidden name=ICHE_CASHID_NO value="">	<!-- 계좌이체(소켓) 현금영수증신분확인번호 -->

<!-- 텔래뱅킹-계좌이체(소켓) 결제 사용 변수 -->
<input type=hidden name=ICHEARS_SOCKETYN value="">	<!-- 텔레뱅킹계좌이체(소켓) 사용 여부 -->
<input type=hidden name=ICHEARS_ADMNO value="">		<!-- 텔레뱅킹계좌이체 승인번호 -->
<input type=hidden name=ICHEARS_POSMTID value="">	<!-- 텔레뱅킹계좌이체 이용기관주문번호 -->
<input type=hidden name=ICHEARS_CENTERCD value="">	<!-- 텔레뱅킹계좌이체 은행코드 -->
<input type=hidden name=ICHEARS_HPNO value="">		<!-- 텔레뱅킹계좌이체 휴대폰번호 -->

<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->
