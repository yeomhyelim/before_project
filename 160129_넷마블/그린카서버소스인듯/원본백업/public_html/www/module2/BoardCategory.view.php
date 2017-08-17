<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-12-06												|# 
#|작성내용	: 커뮤니티 카테고리 뷰 클레스								|# 
#/*====================================================================*/# 

require_once "View.php";

class BoardCategoryView extends View2
{
	## 모듈 클레스 
	private $objBoardCategoryModule				= null;
	/**
	 *		생성자 함수
	 **/
	public function __construct($objDB, $aryParam) {

		## 모듈 설정
		$this->objBoardCategoryModule			= new BoardCategoryModule($objDB);		

		## 부모 생성자 실행
		parent::__construct($objDB, $aryParam);
	}
	/**
	 *		데이터 리스트를 만드는 함수
	 **/
	public function makeListData($aryParam) {

		## 기본 설정
		$this->setBCode($aryParam['BC_B_CODE']);

		## 공동 설정
		$this->setPage($aryParam['PAGE']);
		$this->setListDefault($aryParam['LIST_DEFAULT']);
		$this->setColumnDefault($aryParam['COLUMN_DEFAULT']);
		$this->setPageDefault($aryParam['PAGE_DEFAULT']);
		$this->setLimitStart($aryParam['LIMIT_START']);
		$this->setLimitEnd($aryParam['LIMIT_END']);
		$this->setSearchField($aryParam['SEARCH_FIELD']);
		$this->setSearchKey($aryParam['SEARCH_KEY']);

		## 기본 설정 체크
//		if(!$this->aryParam['BC_B_CODE']) { return; }

		## 최대 개수 설정
		$aryParamData							= "";
		$aryParamData['BC_B_CODE']				= $this->aryParam['BC_B_CODE'];
		$aryParamData['searchField']			= $this->strSearchField;
		$aryParamData['searchKey']				= $this->strSearchKey;
		$this->intTotal							= $this->objBoardCategoryModule->getBoardCategorySelectEx("OP_COUNT", $aryParamData);

		## 데이터 불러오기
		$aryParamData['ORDER_BY']				= "";
		$aryParamData['LIMIT_START']			= $this->intLimitStart;
		$aryParamData['LIMIT_END']				= $this->intLimitEnd;
		$this->resResult						= $this->objBoardCategoryModule->getBoardCategorySelectEx("OP_LIST", $aryParamData);

		## 리스트 번호 설정
		$this->setListNumber();
		return true;
	}
	/**
	 *		데이터 내용을 만드는 함수
	 **/
	public function makeSelectData($aryParam) {

		## 기본 설정
		$this->setBCode($aryParam['BC_B_CODE']);
		$this->setBcNo($aryParam['BC_NO']);

		## b_code 체크
		if(!$this->aryParam['BC_B_CODE'])	{ return; }
		if(!$this->aryParam['BC_NO'])		{ return; }

		## 데이터 불러오기
		$aryParamData						= "";
		$aryParamData['BC_B_CODE']			= $this->aryParam['BC_B_CODE'];
		$aryParamData['BC_NO']				= $this->aryParam['BC_NO'];
		$this->aryRow						= $this->objBoardCategoryModule->getBoardCategorySelectEx("OP_SELECT", $aryParamData);
		return 1;
	}
	/**
	 *		set 커뮤니티 코드
	 */
	public function setBCode($strBCode) {
		if(!$strBCode) { $strBCode = $_GET['b_code'];  }
		if(!$strBCode) { $strBCode = $_POST['b_code']; }
		$this->strBCode						= $strBCode;
		$this->strBCodeLower				= strtolower($strBCode); 
		$this->aryParam['BC_B_CODE']		= $strBCode;
	}
	/**
	 *		set 커뮤니티 카테고리 번호
	 */
	public function setBcNo($intBcNo) {
		if(!$intBcNo) { $intBcNo = $_GET['bc_no'];  }
		if(!$intBcNo) { $intBcNo = $_POST['bc_no']; }
		$this->aryParam['BC_NO']			= $intBcNo;
	}
	/**
	 *		get 커뮤니티 코드
	 */
	public function getBCode($strBCode) {
		return $this->strBCode;
	}
}