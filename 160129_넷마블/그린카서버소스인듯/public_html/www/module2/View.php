<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-20												|# 
#|작성내용	: 최상위 뷰 클레스											|# 
#/*====================================================================*/# 

class View2
{
	## 데이터 베이스
	protected $db					= null;
	## 리스트 데이터
	protected $resResult			= null;
	## 내용 데이터
	protected $aryRow				= null;
	## param 데이터
	protected $aryParam				= null;
	## 검색 필드
	protected $strSearchField		= null;
	## 검색 키워드
	protected $strSearchKey			= null;
	## 리스트 번호
	protected $intListNumber		= 0;
	## 리스트 개수
	protected $intTotal				= 0;
	## 현재 페이지
	protected $intPage				= 0;
	## 리스트 시작 시점
	protected $intLimitStart		= 0;
	## 리스트 종료 시점
	protected $intLimitEnd			= 0;
	## 리스트 수
	protected $intListDefault		= 0;
	## 세로줄 수
	protected $intColumnDefault		= 0;
	## 페이지 수
	protected $intPageDefault		= 0;
	## 회원 이름
	protected $strMemberName		= null;
	## 회원 이메일
	protected $strMemberEmail		= null;
	/**
	 *		생성자 함수
	 */
	public function __construct($objDB, $aryParam) {
	
		$this->db				= $objDB;
		$strLoadFunction		= $aryParam['LOAD'];

		if($strLoadFunction) {
			$this->{$strLoadFunction}($aryParam);
		}
	}
	/**
	 *		검색 필드 설정
	 */
	public function setSearchField($strSearchField) {
		
		if(!$strSearchField) {
			$strSearchField		= $_GET['searchField']; 
		}
		$this->strSearchField	= $strSearchField;
	}
	/**
	 *		검색어 설정
	 */
	public function setSearchKey($strSearchKey) {

		if(!$strSearchKey) {
			$strSearchKey		= $_GET['searchKey'];
		}
		$this->strSearchKey		= $strSearchKey;
	}
	/**
	 *		가로줄 수 설정
	 */
	public function setListDefault($intListDefault) {
		
		if(!$intListDefault) { $intListDefault = 0; }

		$this->intListDefault = $intListDefault; 
	}
	/**
	 *		세로줄 수 설정
	 */
	public function setColumnDefault($intColumnDefault) {

		if(!$intColumnDefault) { $intColumnDefault = 0; }

		$this->intColumnDefault = $intColumnDefault; 
	}
	/**
	 *		페이지 수 설정
	 */
	public function setPageDefault($intPageDefault) {

		if(!$intPageDefault) { $intPageDefault = 0; }

		$this->intPageDefault = $intPageDefault; 
	}
	/**
	 *		리스트 번호 설정
	 */
	public function setListNumber($intListNumber = 0) {
		
		if(!$intListNumber) { 
			$intListNumber		= $this->intTotal - ( $this->intLimitEnd * ( $this->intPage - 1 ) ) + 1;
		}
		$this->intListNumber	= $intListNumber;
	}
	/**
	 *		데이터 베이스 시작 시점 설정
	 */
	public function setLimitStart($intLimitStart) {

		if(!$intLimitStart) { 
			$intListDefault			= $this->intListDefault;
			$intColumnDefault		= $this->intColumnDefault;
			if(!$intColumnDefault) { $intColumnDefault = 1; }
			$intLimitStart			= ($intListDefault * $intColumnDefault) * ($this->intPage - 1);
		} 
		$this->intLimitStart		= $intLimitStart;
	}
	/**
	 *		데이터 베이스 종료 시점 설정
	 */
	public function setLimitEnd($intLimitEnd) {

		if(!$intLimitEnd) { 
			$intListDefault			= $this->intListDefault;
			$intColumnDefault		= $this->intColumnDefault;
			if(!$intColumnDefault) { $intColumnDefault = 1; }
			$intLimitEnd			= ($intListDefault * $intColumnDefault);
		}
		$this->intLimitEnd			= $intLimitEnd;
	}
	/**
	 *		페이지 설정
	 */
	public function setPage($intPage) {

		if(!$intPage) { $intPage = $_GET['page']; }
		if(!$intPage) { $intPage = 1; }
		$this->intPage = $intPage;
	}
	/**
	 *		검색 필드 출력
	 */
	public function getSearchField() {
		
		return $this->strSearchField;
	}
	/**
	 *		검색 필드 출력 값과 입력 값 비교 후 출력
	 */
	public function getSearchFieldSelect($strField, $strTrue = " selected", $strFalse = "") {

		if($this->getSearchField() == $strField) {
			return $strTrue;
		}

		return $strFalse;
	}
	/**
	 *		검색어 출력
	 */
	public function getSearchKey() {
		
		return $this->strSearchKey;

	}
	/**
	 *		리스트 번호 출력
	 */
	public function getListNumber() {
		
		return $this->intListNumber;
	}
	/**
	 *		가로줄 수 출력
	 */
	public function getListDefault() {

		return $this->intListDefault;
	}

	/**
	 *		세로줄 수 출력
	 */
	public function getColumnDefault() {

		return $this->intColumnDefault;
	}
	/**
	 *		페이지 수 출력
	 */
	public function getPageDefault() {
	
		return $this->intPageDefault;
	}
	/**
	 *		현재 페이지 출력 
	 */
	public function getPage() {
		
		return $this->intPage;
	}
	/**
	 *		mysql_fetch_array 사용
	 */
	public function getFetch() {

		## mysql_fetch_array 실행
		$this->aryRow = mysql_fetch_array($this->resResult, MYSQL_ASSOC);

		## 리스트 번호 차감
		$this->intListNumber--;
		
		## 결과 전달
		return $this->aryRow;
	}
	/**
	 *		전체 개수 출력
	 */
	public function getTotal() {

		return $this->intTotal;
	}
	/**
	 *		전체 블럭 개수
	 */
	public function getTotalBlock() {
		
		return ceil($this->intTotal / $this->intListDefault);
	}
	/**
	 *		이전 블럭
	 */
	public function getPrevBlock() {
		
		$intFirstBlock		= $this->getFirstBlock();
		$intPrevBlock		= $intFirstBlock - 1;
		
		if($intPrevBlock <= 0) { return; }

		return $intPrevBlock;
	}
	/**
	 *		다음 블럭
	 */
	public function getNextBlock() {

		$intTotalBlock		= $this->getTotalBlock();
		$intNextBlock		= $this->getLastBlock();

		if($intNextBlock > $intTotalBlock) { return; }

		return $intNextBlock;
	}
	/**
	 *		시작 블럭
	 */
	public function getFirstBlock() {

		$intPage			= $this->getPage();
		$intPageDefault		= $this->getPageDefault();

		$intFirstBlock		= ceil($intPage / $intPageDefault) - 1;
		$intFirstBlock		= ($intFirstBlock * $intPageDefault) + 1; 

		return $intFirstBlock;
	}
	/**
	 *		마지막 블럭
	 */
	public function getLastBlock() {
		
		$intTotalBalck		= $this->getTotalBlock();
		$intFirstBlock		= $this->getFirstBlock();
		$intPageDefault		= $this->getPageDefault();
		$intLastBlock		= $intFirstBlock + $intPageDefault;
		
		if($intLastBlock > $intTotalBalck) { $intLastBlock = $intTotalBalck + 1; }

		return $intLastBlock;
	}

	## 회원 관련 ##

	/**
	 *		회원 이름 설정
	 */
	public function setMemberName($strMemberName) {
		if(!$strMemberName) { $strMemberName	= $_SESSION['member_name']; }
		if(!$strMemberName) { $strMemberName	= $_SESSION['ADMIN_NAME']; }
		$this->strMemberName					= $strMemberName;
	}
	/**
	 *		회원 이메일 설정
	 */
	public function setMemberEmail($strMemberEmail) {
		if(!$strMemberEmail) { $strMemberEmail	= $_SESSION['member_email']; }
		if(!$strMemberEmail) { $strMemberEmail	= $_SESSION['ADMIN_EMAIL']; }
		$this->strMemberEmail					= $strMemberEmail;
	}
	/**
	 *		회원 이름 출력
	 */
	public function getMemberName() {
		return $this->strMemberName;
	}
	/**
	 *		회원 이메일 출력
	 */
	public function getMemberEmail($aryParam) {

		if(!$this->strMemberEmail)		{ return; }
		
		list($id, $domain) = explode("@", $this->strMemberEmail);

		if($aryParam['target'] == "id")			{ return $id; }
		elseif($aryParam['target'] == "domain") { return $domain; }
		
		return $this->strMemberEmail;
	}
	/**
	 *		GET 데이터 출력
	 */
	 public function getGetData($strKey) {
		
		return $_GET[$strKey];
	 }
	/**
	 *		ROW 데이터 출력
	 */
	public function getRowData($strKey) {
		
		if($strKey) { return $this->aryRow[$strKey]; }
		
		return $this->aryRow;
	}

}