<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-22												|# 
#|작성내용	: 커뮤니티 데이터 뷰 클레스									|# 
#/*====================================================================*/# 

require_once "Controller.php";

class BoardDataController extends Controller2
{
	## 모듈 클레스 
	private $objBoardDataModule		= null;
	## 뷰 클래스
	private $objBoardDataView		= null;
	## 커뮤니티 코드
	private $strBCode				= null;
	/**
	 *		생성자 함수
	 */
	public function __construct($objDB, $aryParam) {

		## 모듈 설정
		$this->objBoardDataModule	= new BoardDataModule($objDB);	
		$this->objBoardDataView		= new BoardDataView($objDB);	

		## 커뮤니티 정보 설정
		$this->aryBoardInfo			= $aryParam['BOARD_INFO'];

		## 부모 생성자 실행
		parent::__construct($objDB, $aryParam);
	}
	/**
	 *		insert
	 *		데이터를 등록하는 방법은 3가지가 있음.
	 *		1. makeInsertData($aryParam) 함수 호출시 $aryParam 인자 값으로 등록하는 방법
	 *		2. setParam($aryParam) 함수를 사용하여 데이터를 등록한 후 makeInsertData() 함수를 호출 하여 등록하는 방법
	 *		3. set***() 한수 각각을 정의 후 makeInsetData() 함수를 호출 하여 등록하는 방법
	 */
	public function makeInsertData($aryParam) {

		## 기본 설정
		if($aryParam) { 
			$this->setParam($aryParam); 
		}

		## 기본 설정 체크
		if(!$this->aryRow)					{ return;	}
		if(!$this->aryRow['B_CODE'])		{ return;	}
		if(!$this->aryRow['UB_TITLE'])		{ return;	}

		## 데이터 등록
		$ubNo = $this->objBoardDataModule->getBoardDataInsertEx($this->aryRow);

		## 데이터 등록 체크
		if($ubNo <= 0) { return; }

		## 답변글 체크
		if(!$this->aryRow['UB_ANS_NO']) {
			// 일반글인경우
			$this->setAnsNo($ubNo);
		} else {
			// 답변글인경우	
		}

		## 계층형 컬럼 업데이트
		$this->setNo($ubNo);
		$this->objBoardDataModule->getBoardDataAnsUpdateEx($this->aryRow);

		## 완료
		return 1;
	}
	/**
	 *		update
	 */
	public function makeUpdateData($aryParam) {

	}
	/**
	 *		set param
	 */
	public function setParam($aryParam) {
		
		$this->setBCode($aryParam['B_CODE']);
		$this->setNo($aryParam['UB_NO']);
		$this->setName($aryParam['UB_NAME']);
		$this->setMemberNo($aryParam['UB_M_NO']);
		$this->setMemberId($aryParam['UB_M_ID']);
		$this->setPassword($aryParam['UB_PASS']);
		$this->setEmail($aryParam['UB_MAIL']);
		$this->setUrl($aryParam['UB_URL']);
		$this->setTitle($aryParam['UB_TITLE']);
		$this->setText($aryParam['UB_TEXT']);
		$this->setTextMobile($aryParam['UB_TEXT_MOBILE']);
		$this->setFunction($aryParam['UB_FUNC']);
		$this->setIp($aryParam['UB_IP']);
		$this->setRead($aryParam['UB_READ']);
		$this->setBcNo($aryParam['UB_BC_NO']);
		$this->setLng($aryParam['UB_LNG']);
		$this->setAnsNo($aryParam['UB_ANS_NO']);
		$this->setAnsStep($aryParam['UB_ANS_STEP']);
		$this->setAnsMemberNo($aryParam['UB_ANS_M_NO']);
		$this->setPtNo($aryParam['UB_PT_NO']);
		$this->setCiNo($aryParam['UB_CI_NO']);
		$this->setWinner($aryParam['UB_WINNER']);
		$this->setPCode($aryParam['UB_P_CODE']);
		$this->setPGrade($aryParam['UB_P_GRADE']);
		$this->setRegDate($aryParam['UB_REG_DT']);
		$this->setRegNo($aryParam['UB_REG_NO']);
		$this->setModDate($aryParam['UB_MOD_DT']);
		$this->setModNo($aryParam['UB_MOD_NO']);
	}
	/**
	 *		set 커뮤니티 코드
	 */
	public function setBCode($strBCode) {
		if(!$strBCode) { $strBCode = $_POST['b_code']; }
		if(!$strBCode) { $strBCode = $this->aryBoardInfo['b_code']; }
		$this->strBCode				= $strBCode;
		$this->strBCodeLower		= strtolower($strBCode); 
		$this->aryRow['B_CODE']		= $strBCode;
	}
	/**
	 *		set 글번호
	 */
	public function setNo($intNo) {
		if(!$intNo) { $intNo		= $_POST['ubNo']; }
		if(!$intNo) { $intNo		= 0; }
		$this->aryRow['UB_NO']		= $intNo;
	}
	/**
	 *		set 회원 이름
	 */
	public function setName($strName) {
		if(!$strName) { $strName	= $_POST['name']; }
		$this->aryRow['UB_NAME']	= $strName;
	}
	/**
	 *		set 회원 번호
	 */
	public function setMemberNo($intMemberNo) {
		if(!$intMemberNo) { $intMemberNo	= $_POST['memberNo']; }
		if(!$intMemberNo) { $intMemberNo	= $_SESSION['member_no']; }
		if(!$intMemberNo) {	$intMemberNo	= $_SESSION['ADMIN_NO']; }
		if(!$intMemberNo) {	$intMemberNo	= -1; }
		$this->aryRow['UB_M_NO']			= $intMemberNo;
	}
	/**
	 *		set 회원 아이디
	 */
	public function setMemberId($strMemberId) {
		if(!$strMemberId) { $strMemberId	= $_POST['memberId']; }
		if(!$strMemberId) { $strMemberId	= $_SESSION['member_id']; }
		if(!$strMemberId) {	$strMemberId	= $_SESSION['ADMIN_ID']; }
		$this->aryRow['UB_M_ID']			= $strMemberId;
	}
	/**
	 *		set 비밀번호
	 */
	public function setPassword($strPassword) {
		if(!$strPassword) { $strPassword	= $_POST['password']; }
		$this->aryRow['UB_PASS']			= $strPassword;
	}
	/**
	 *		set 이메일
	 */
	public function setEmail($strEmail) {
		if(!$strEmail) {
			if($_POST['email1'] && $_POST['email2']) {
				$strEmail				= $_POST['email1'] . "@" . $_POST['email2']; 
			}
		}
		if(!$strEmail) { $strEmail			= $_SESSION['member_email']; }
		if(!$strEmail) { $strEmail			= $_SESSION['ADMIN_MAIL']; }
		$this->aryRow['UB_MAIL']			= $strEmail;
	}
	/**
	 *		set 웹주소
	 */
	public function setUrl($strUrl) {
		if(!$strUrl) { $strUrl				= $_POST['url']; }
		$this->aryRow['UB_URL']				= $strUrl;
	}
	/**
	 *		set 제목
	 */
	public function setTitle($strTitle) {
		if(!$strTitle) { $strTitle			= $_POST['title']; }
		$this->aryRow['UB_TITLE']			= $strTitle;
	}
	/**
	 *		set 내용
	 */
	public function setText($strText) {
		if(!$strText) { $strText			= $_POST['text']; }
		$this->aryRow['UB_TEXT']			= $strText;
	}
	/**
	 *		set 모바일 내용
	 */
	public function setTextMobile($strTextMobile) {
		if(!$strTextMobile) { $strTextMobile= $_POST['textMobile']; }
		$this->aryRow['UB_TEXT_MOBILE']		= $strTextMobile;
	}
	/**
	 *		set 기능(공지글, 비밀글)
	 */
	public function setFunction($strFunction) {
	}
	/**
	 *		set 아이피
	 */
	public function setIp($strIp) {
		if(!$strIp) { $strIp				= $_POST['ip']; }
		if(!$strIp) { $strIp				= ClientInfo::getClientIP(); }
		$this->aryRow['UB_IP']				= $strIp;
	}
	/**
	 *		set 조회수
	 */
	public function setRead($intRead) {
		if(!$intRead) { $intRead			= 0; }
		$this->aryRow['UB_READ']			= $intRead;
	}
	/**
	 *		set 카테고리 번호
	 */
	public function setBcNo($intBcNo) {
		if(!$intBcNo) { $intBcNo			= $_POST['bcNo']; }
		if(!$intBcNo) { $intBcNo			= 0; }
		$this->aryRow['UB_BC_NO']			= $intBcNo;
	}
	/**
	 *		set 언어
	 */
	public function setLng($strLng) {
		global $S_SITE_LNG;
		if(!$strLng) { $strLng				= $_POST['lng'];	}
		if(!$strLng) { $strLng				= $S_SITE_LNG;		}
		$this->aryRow['UB_LNG']				= $strLng;
	}
	/**
	 *		set (계층형)최상위글 번호
	 */
	public function setAnsNo($intAnsNo) {
		if(!$intAnsNo) { $intAnsNo			= $_POST['ansNo']; }
		if(!$intAnsNo) { $intAnsNo			= 0; }
		$this->aryRow['UB_ANS_NO']			= $intAnsNo;
	}
	/**
	 *		set (계층형)답변 모양
	 */
	public function setAnsStep($strAnsStep) {
		if(!$strAnsStep) { $strAnsStep		= $_POST['ansStep']; }
		if(!$strAnsStep) { $strAnsStep		= ""; }
		$this->aryRow['UB_ANS_STEP']		= $strAnsStep;
	}
	/**
	 *		set (계층형)원글 회원 번호
	 */
	public function setAnsMemberNo($intAnsMemberNo) {
		if(!$intAnsMemberNo) { $intAnsMemberNo		= $_POST['andMemberNo'];	}
		if(!$intAnsMemberNo) { $intAnsMemberNo		= $_SESSION['member_no'];	}
		if(!$intAnsMemberNo) { $intAnsMemberNo		= $_SESSION['ADMIN_NO'];	}
		if(!$intAnsMemberNo) { $intAnsMemberNo		= -1;						}
		$this->aryRow['UB_ANS_M_NO']				= $intAnsMemberNo;
	}
	/**
	 *		set (이벤트)포인트번호
	 */
	public function setPtNo($intPtNo) {
		if(!$intPtNo) { $intPtNo			= $_POST['ptNo']; }
		if(!$intPtNo) { $intPtNo			= 0; }
		$this->aryRow['UB_PT_NO']			= $intPtNo;
	}
	/**
	 *		set (이벤트)쿠폰번호
	 */
	public function setCiNo($intCiNo) {
		if(!$intCiNo) { $intCiNo			= $_POST['ciNo']; }
		if(!$intCiNo) { $intCiNo			= 0; }
		$this->aryRow['UB_CI_NO']			= $intCiNo;
	}
	/**
	 *		set (이벤트)당첨자
	 */
	public function setWinner($strWinner) {
		if(!$strWinner) { $strWinner		= $_POST['winner']; }
		if(!$strWinner) { $strWinner		= ""; }
		$this->aryRow['UB_WINNER']			= $strWinner;
	}
	/**
	 *		set (상품)코드
	 */
	public function setPCode($strPCode) {
		if(!$strPCode) { $strPCode			= $_POST['pCode']; }
		if(!$strPCode) { $strPCode			= ""; }
		$this->aryRow['UB_P_CODE']			= $strPCode;
	}
	/**
	 *		set (상품)평점
	 */
	public function setPGrade($intPGrade) {
		if(!$intPGrade) { $intPGrade		= $_POST['pGrade']; }
		if(!$intPGrade) { $intPGrade		= ""; }
		$this->aryRow['UB_P_GRADE']			= $intPGrade;
	}
	/**
	 *		set 등록일
	 */
	public function setRegDate($strRegDate) {
		if(!$strRegDate) { $strRegDate		= $_POST['regDate']; }
		if(!$strRegDate) { $strRegDate		= "NOW()"; }
		$this->aryRow['UB_REG_DT']			= $strRegDate;
	}
	/**
	 *		set 등록자
	 */
	public function setRegNo($intRegNo) {
		if(!$intRegNo) { $intRegNo		= $_POST['regNo']; }
		if(!$intRegNo) { $intRegNo		= $_SESSION['member_no']; }
		if(!$intRegNo) { $intRegNo		= $_SESSION['ADMIN_NO']; }
		if(!$intRegNo) { $intRegNo		= -1; }
		$this->aryRow['UB_REG_NO']		= $intRegNo;
	}
	/**
	 *		set 수정일
	 */
	public function setModDate($strModDate) {
		if(!$strModDate) { $strModDate		= $_POST['modDate']; }
		if(!$strModDate) { $strModDate		= "NOW()"; }
		$this->aryRow['UB_MOD_DT']			= $strModDate;
	}
	/**
	 *		set 수정자
	 */
	public function setModNo($intModNo) {
		if(!$intModNo) { $intModNo		= $_POST['modNo']; }
		if(!$intModNo) { $intModNo		= $_SESSION['member_no']; }
		if(!$intModNo) { $intModNo		= $_SESSION['ADMIN_NO']; }
		if(!$intModNo) { $intModNo		= -1; }
		$this->aryRow['UB_MOD_NO']		= $intModNo;
	}

}