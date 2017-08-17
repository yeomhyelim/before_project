<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-22												|# 
#|작성내용	: 커뮤니티 관리 뷰 클레스									|# 
#/*====================================================================*/# 

require_once "View.php";

class BoardMgrNewView extends View2
{
	## 모듈 클레스 
	private $objBoardMgrNewModule		= null;
	/**
	 *		생성자 함수
	 **/
	public function __construct($objDB, $aryParam) {

		## 모듈 설정
		$this->objBoardMgrNewModule			= new BoardMgrNewModule($objDB);		

		## 부모 생성자 실행
		parent::__construct($objDB, $aryParam);
	}
	/**
	 *		데이터 리스트를 만드는 함수
	 **/
	public function makeListData($aryParam) {

		## 공동 설정
		$this->setPage($aryParam['PAGE']);
		$this->setListDefault($aryParam['LIST_DEFAULT']);
		$this->setColumnDefault($aryParam['COLUMN_DEFAULT']);
		$this->setPageDefault($aryParam['PAGE_DEFAULT']);
		$this->setLimitStart($aryParam['LIMIT_START']);
		$this->setLimitEnd($aryParam['LIMIT_END']);
		$this->setSearchField($aryParam['SEARCH_FIELD']);
		$this->setSearchKey($aryParam['SEARCH_KEY']);

		## 최대 개수 설정
		$aryParamData							= "";
		$aryParamData['searchField']			= $this->strSearchField;
		$aryParamData['searchKey']				= $this->strSearchKey;
		$this->intTotal							= $this->objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_COUNT", $aryParamData);

		## 데이터 불러오기
		$aryParamData['ORDER_BY']				= "";
		$aryParamData['LIMIT_START']			= $this->intLimitStart;
		$aryParamData['LIMIT_END']				= $this->intLimitEnd;
		$aryParamData['BOARD_GROUP_NEW_JOIN']	= "Y";
		$this->resResult						= $this->objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_LIST", $aryParamData);

		## 리스트 번호 설정
		$this->setListNumber();

		## 마무리
		return true;
	}
	/**
	 *		데이터 내용을 만드는 함수
	 **/
	public function makeSelectData($aryParam) {


	}
}