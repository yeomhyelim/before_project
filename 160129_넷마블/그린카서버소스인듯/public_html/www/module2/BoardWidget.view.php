<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-24												|# 
#|작성내용	: 커뮤니티 위젯 뷰 클레스									|# 
#/*====================================================================*/# 

require_once "View.php";

class BoardWidgetView extends View2
{
	## 모듈 클레스 
	private $objBoardWidget		= null;
//	## 커뮤니티 설정 정보
//	private $aryBoardInfo		= null;
//	## 커뮤니티 코드
//	private $strBCode			= null;
//	## 커뮤니티 코드 소문자
//	private $strBCodeLower		= null;
//	## 커뮤니티 글번호
//	private $intUbNo			= 0;
	/**
	 *		생성자 함수
	 **/
	public function __construct($objDB, $aryParam) {

		## 모듈 설정
		$this->objBoardWidget		= new BoardWidgetModule($objDB);		

//		## 커뮤니티 정보 설정
//		$this->aryBoardInfo			= $aryParam['BOARD_INFO'];

		## 부모 생성자 실행
		parent::__construct($objDB, $aryParam);
	}
	/**
	 *		데이터 리스트를 만드는 함수
	 **/
	public function makeListData($aryParam) {

		## 기본 설정
		$this->setBCode($aryParam['B_CODE']);
		$this->setPage($aryParam['PAGE']);
		$this->setListDefault($aryParam['LIST_DEFAULT']);
		$this->setColumnDefault($aryParam['COLUMN_DEFAULT']);
		$this->setPageDefault($aryParam['PAGE_DEFAULT']);
		$this->setLimitStart($aryParam['LIMIT_START']);
		$this->setLimitEnd($aryParam['LIMIT_END']);
		$this->setSearchField($aryParam['SEARCH_FIELD']);
		$this->setSearchKey($aryParam['SEARCH_KEY']);

		## b_code 체크
		if(!$this->strBCode) { return; }

		## 최대 개수 설정
		$aryParamData							= "";
		$aryParamData['BW_B_CODE']				= $this->strBCode;
		$aryParamData['searchField']			= $this->strSearchField;
		$aryParamData['searchKey']				= $this->strSearchKey;
		$this->intTotal							= $this->objBoardWidget->getBoardWidgetSelectEx("OP_COUNT", $aryParamData);

		## 데이터 불러오기
		$aryParamData['ORDER_BY']				= "";
		$aryParamData['LIMIT_START']			= $this->intLimitStart;
		$aryParamData['LIMIT_END']				= $this->intLimitEnd;
		$aryParamData['BOARD_FL_JOIN']			= "Y";
		$aryParamData['BOARD_CATEGORY_JOIN']	= "Y";
		$this->resResult						= $this->objBoardWidget->getBoardWidgetSelectEx("OP_LIST", $aryParamData);

		## 리스트 번호 설정
		$this->setListNumber();
		return true;
	}
	/**
	 *		데이터 내용을 만드는 함수
	 **/
	public function makeSelectData($aryParam) {

		## 기본 설정
		$this->setUbNo($aryParam['UB_NO']);
		$this->setBCode($aryParam['B_CODE']);
		$this->setBoardInfo($aryParam['BOARD_INFO']);

		## b_code 체크
		if(!$this->strBCode)	{ return; }
		if(!$this->intUbNo)		{ return; }

		## 데이터 불러오기
		$aryParamData					= "";
		$aryParamData['B_CODE']			= $this->strBCode;
		$aryParamData['UB_NO']			= $this->intUbNo;
		$this->aryRow					= $this->objBoardWidget->getBoardWidgetSelectEx("OP_SELECT", $aryParamData);

		return 1;
	}
	/**
	 *		커뮤니티 코드 정보 설정
	 **/
	public function setBCode($strBCode) {

		if(!$strBCode) { $strBCode = $this->aryBoardInfo['b_code']; }
		if(!$strBCode) { $strBCode = $_GET['b_code']; }
		$this->strBCode			= $strBCode;
		$this->strBCodeLower	= strtolower($strBCode); 
	}
	/**
	 *		커뮤니티 위젯 코드 출력
	 **/
	public function getWidgetCode() {
		
		return $this->aryRow['BW_CODE'];
	}
	/**
	 *		커뮤니티 위젯 이름 출력
	 **/
	public function getName() {

		return $this->aryRow['BW_NAME'];
	}
	/**
	 *		커뮤니티 위젯 스킨 출력
	 **/
	public function getSkin() {
		
		return $this->aryRow['BW_SKIN'];
	}
	/**
	 *		커뮤니티 위젯 CSS 출력
	 **/
	public function getCss() {
		
		return $this->aryRow['BW_CSS'];
	}
	/**
	 *		커뮤니티 위젯 작성일 출력
	 **/
	public function getRegDate($strBasicFmt="Y-m-d", $strTodayFmt="H:i:s") {
		
		## 기본 설정
		$strRegDate				= strtotime($this->aryRow['BW_REG_DT']);

		## 오늘 작성한 글은 시간. 그 이후는 날짜
		if(date("ymd") == date("ymd", $strRegDate)) {
			$strRegDate			= date($strTodayFmt, $strRegDate);
		} else {
			$strRegDate			= date($strBasicFmt, $strRegDate);
		}
		
		## 결과 전달
		return $strRegDate;
	}
}