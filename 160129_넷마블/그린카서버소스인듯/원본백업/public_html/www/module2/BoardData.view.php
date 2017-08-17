<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-22												|# 
#|작성내용	: 커뮤니티 데이터 뷰 클레스									|# 
#/*====================================================================*/# 

require_once "View.php";

class BoardDataView extends View2
{
	## 모듈 클레스 
	private $objBoardData		= null;
	## 커뮤니티 설정 정보
	private $aryBoardInfo		= null;
	## 커뮤니티 코드
	private $strBCode			= null;
	## 커뮤니티 코드 소문자
	private $strBCodeLower		= null;
	## 커뮤니티 글번호
	private $intUbNo			= 0;
	## 커뮤니티 카테고리 번호
	private $intUbBcNo			= 0;
	## 커뮤니티 언어
	private $strUbLng			= null;
	## 커뮤니티 언어 멀티
	private $aryUbLngIn			= null;
	## 커뮤니티 삭제 유무
	private $strUbDel			= null;
	/**
	 *		생성자 함수
	 **/
	public function __construct($objDB, $aryParam) {

		## 모듈 설정
		$this->objBoardData			= new BoardDataModule($objDB);		

		## 커뮤니티 정보 설정
		$this->aryBoardInfo			= $aryParam['BOARD_INFO'];

		## 부모 생성자 실행
		parent::__construct($objDB, $aryParam);
	}
	/**
	 *		데이터 리스트를 만드는 함수
	 **/
	public function makeListData($aryParam) {

		## 기본 설정
		$this->setBCode($aryParam['B_CODE']);
		$this->setBoardInfo($aryParam['BOARD_INFO']);
		$this->setUbBcNo($aryParam['UB_BC_NO']);
		$this->setUbLng($aryParam['UB_LNG']);
		$this->setUbLngIn($aryParam['UB_LNG_IN']);
		$this->setUbDel($aryParam['UB_DEL']);
		$this->setPage($aryParam['PAGE']);
		$this->setListDefault($aryParam['LIST_DEFAULT']);
		$this->setColumnDefault($aryParam['COLUMN_DEFAULT']);
		$this->setPageDefault($aryParam['PAGE_DEFAULT']);
		$this->setLimitStart($aryParam['LIMIT_START']);
		$this->setLimitEnd($aryParam['LIMIT_END']);
		$this->setSearchField($aryParam['SEARCH_FIELD']);
		$this->setSearchKey($aryParam['SEARCH_KEY']);
		$this->setBoardLFJoin($aryParam['BOARD_FL_JOIN']);
		$this->setBoardCategoryJoin($aryParam['BOARD_CATEGORY_JOIN']);

		## b_code 체크
		if(!$this->strBCode) { return; }

		## 최대 개수 설정
		$aryParamData							= "";
		$aryParamData['B_CODE']					= $this->strBCode;
		$aryParamData['UB_BC_NO']				= $this->intUbBcNo;
		$aryParamData['UB_LNG']					= $this->strUbLng;
		$aryParamData['UB_LNG_IN']				= $this->aryUbLngIn;
		$aryParamData['UB_DEL']					= $this->strUbDel;
		$aryParamData['searchField']			= $this->strSearchField;
		$aryParamData['searchKey']				= $this->strSearchKey;
		$this->intTotal							= $this->objBoardData->getBoardDataSelectEx2("OP_COUNT", $aryParamData);

		## 데이터 불러오기
		$aryParamData['ORDER_BY']				= $aryParam['ORDER_BY'];
		$aryParamData['LIMIT_START']			= $this->intLimitStart;
		$aryParamData['LIMIT_END']				= $this->intLimitEnd;
//		$aryParamData['BOARD_FL_JOIN']			= $this->strBoardFLJoin;
//		$aryParamData['BOARD_CATEGORY_JOIN']	= $this->strBoardCategoryJoin;
		$aryParamData['JOIN_FL']				= $this->strBoardFLJoin;
		$aryParamData['JOIN_BC']				= $this->strBoardCategoryJoin;
		$this->resResult						= $this->objBoardData->getBoardDataSelectEx2("OP_LIST", $aryParamData);

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
		$this->aryRow					= $this->objBoardData->getBoardDataSelectEx("OP_SELECT", $aryParamData);
		return 1;
	}
	/**
	 *		커뮤니티 설정 정보 설정
	 **/
	public function setBoardInfo($aryBoardInfo) {

		if(!$aryBoardInfo) {
			$strBoardInfoFile		= SHOP_HOME . "/conf/community2/board.{$this->strBCodeLower}.info.php";
			if(is_file($strBoardInfoFile)) {
				include $strBoardInfoFile;
				$aryBoardInfo		= $BOARD_INFO[$this->strBCode];
			}
		}

		$this->aryBoardInfo			= $aryBoardInfo;	
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
	 *		커뮤니티 글번호 설정
	 **/
	public function setUbNo($intUbNo) {

		if(!$intUbNo) { $intUbNo = $_GET['ubNo']; }
		$this->intUbNo = $intUbNo;
	}
	/**
	 *		커뮤니티 카테고리 번호 설정
	 **/
	public function setUbBcNo($intUbBcNo) {

		if(!$intUbBcNo) { $intUbBcNo = $_GET['ubBcNo']; }
		$this->intUbBcNo = $intUbBcNo;
	}
	/**
	 *		커뮤니티 언어 설정
	 **/
	public function setUbLng($strUbLng) {

		if(!$strUbLng) { $strUbLng = $_GET['ubLng']; }
		$this->strUbLng = $strUbLng;
	}
	/**
	 *		커뮤니티 언어 설정 멀티
	 **/
	public function setUbLngIn($aryUbLngIn) {
		$this->aryUbLngIn = $aryUbLngIn;
	}
	/**
	 *		커뮤니티 삭제 유무
	 **/
	public function setUbDel($strUbDel) {

		if(!$strUbDel) { $strUbDel = $_GET['ubDel']; }
		$this->strUbDel = $strUbDel;
	}
	/**
	 *		가로줄 수 설정
	 **/
	public function setListDefault($intListDefault) {
		
		if(!$intListDefault) { $intListDefault = $this->aryBoardInfo['bi_list_default']; }

		parent::setListDefault($intListDefault);
	}
	/**
	 *		세로줄 수 설정
	 **/
	public function setColumnDefault($intColumnDefault) {

		if(!$intColumnDefault) { $intColumnDefault = $this->aryBoardInfo['bi_column_default']; }

		parent::setColumnDefault($intColumnDefault);
	}
	/**
	 *		페이지 수 설정
	 **/
	public function setPageDefault($intPageDefault) {

		if(!$intPageDefault) { $intPageDefault = $this->aryBoardInfo['bi_page_default']; }
		
		parent::setPageDefault($intPageDefault);
	}
	/**
	 *		리스트이미지 조인 설정
	 **/
	public function setBoardLFJoin($strBoardFLJoin) {
		
		$this->strBoardFLJoin = $strBoardFLJoin;
	}
	/**
	 *		카테고리 조인 설정
	 **/
	public function setBoardCategoryJoin($strBoardCategoryJoin) {
		
		$this->strBoardCategoryJoin = $strBoardCategoryJoin;
	}
	/**
	 *		글번호 출력
	 **/
	public function getNo() {

		return $this->aryRow['UB_NO'];
	}
	/**
	 *		작성자 출력
	 **/
	public function getWriterName() {

		return $this->aryRow['UB_NAME'];
	}
	/**
	 *		작성자 아이디
	 **/
	public function getWriterID() {

		return $this->aryRow['UB_M_ID'];
	}
	/**
	 *		작성일 출력
	 **/
	public function getRegDate($strBasicFmt="Y-m-d", $strTodayFmt="H:i:s") {
		
		## 기본 설정
		$strRegDate				= strtotime($this->aryRow['UB_REG_DT']);

		## 오늘 작성한 글은 시간. 그 이후는 날짜
		if(date("ymd") == date("ymd", $strRegDate)) {
			$strRegDate			= date($strTodayFmt, $strRegDate);
		} else {
			$strRegDate			= date($strBasicFmt, $strRegDate);
		}

		return $strRegDate;
	}
	/**
	 *		글제목 출력
	 **/
	public function getTitle($aryParam) {

		## 기본 설정
		$strTitle			= $this->aryRow['UB_TITLE'];
		$intMaxLeng			= $this->aryBoardInfo['bi_datalist_title_len'];

		## 최대 길이 체크 사용 유무
		$isMaxLengDontUse	= $aryParam['IS_MAX_LENG_USE'];
		if($aryParam['MAX_LENG']) { $intMaxLeng = $aryParam['MAX_LENG']; }

		## 최대 표시 문자 길이 체크 및 짜르기
		if($intMaxLeng && $isMaxLengDontUse):
			$temp		= mb_substr($strTitle, 0, $intMaxLeng, "UTF-8");
			if(mb_strlen($temp, "UTF-8") != mb_strlen($strTitle, "UTF-8")) { $temp .= "..."; }
			$strTitle	= $temp;
		endif;

		return $strTitle;
	}
	/**
	 *		내용 출력
	 **/
	public function getText() {

		return $this->aryRow['UB_TEXT'];
	}
	/**
	 *		내용 타입 출력
	 *		return member			: 회원글
	 *		return nomember			: 비회원글
	 *		return my				: 자신글
	 **/
	public function getAuthType() {

		$strAuthType		= "member";
		if($this->aryRow['UB_M_NO'] == -1)							{ $strAuthType = "nomember";		}
		if($this->aryRow['UB_M_NO'] == $_SESSION['member_no'])		{ $strAuthType = "my";			}

		return $strAuthType;
	}
	/**
	 *		카테고리 이름 출력
	 **/
	public function getCategoryName() {

		return $this->aryRow['BC_NAME'];
	}
	/**
	 *		게시판 코드 출력
	 **/
	public function getBCode() {

		return $this->aryRow['UB_B_CODE'];
	}
	/**
	 *		조회수 출력
	 **/
	public function getHit() {

		return $this->aryRow['UB_READ'];
	}
	/**
	 *		이미지 파일 주소 출력
	 **/
	public function getListImageUrl() {
		
		return $this->aryRow['FL_DIR'] . '/' . $this->aryRow['FL_NAME'];
	}
}