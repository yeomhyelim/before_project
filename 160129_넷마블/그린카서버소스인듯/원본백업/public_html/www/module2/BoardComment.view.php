<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-22												|# 
#|작성내용	: 커뮤니티 댓글 뷰 클레스									|# 
#/*====================================================================*/# 

require_once "View.php";

class BoardCommentView extends View2
{
	private $resResult			= null;
	private $aryRow				= null;
	private $intListNum			= null;
	private $objBoardComment	= null;

	public function __construct($objDB, $aryParam) {

		## 모듈 설정
		require_once MALL_HOME . "/module2/BoardComment.module.php";
		$this->objBoardComment			= new BoardCommentModule($objDB);		

		## 부모 선언자 실행
		parent::__construct($objDB, $aryParam);
	}

	/**
	 *		데이터 리스트를 만드는 함수
	 **/
	public function makeListData($aryParam) {

		## 기본 변수 설정
		$strBCode						= $aryParam['B_CODE'];
		$strOrderBy						= $aryParam['ORDER_BY'];
		$intPage						= $aryParam['PAGE'];

		## 기본 변수 설정 체크
		if(!$strBCode)		{ return; }
		if(!$intPage)		{ $intPage = 0; }

		## 데이터 불러오기
		$aryParamData					= "";
		$aryParamData['B_CODE']			= $strBCode;
		$aryParamData['ORDER_BY']		= $strOrderBy;
		$this->resResult				= $this->objBoardComment->getBoardCommentSelectEx("OP_LIST", $aryParamData);

		return 1;
	}

	/**
	 *		데이터 내용을 만드는 함수
	 **/
	public function makeSelectData($aryParam) {

		## 기본 변수 설정
		$strBCode						= $aryParam['B_CODE'];
		$strOrderBy						= $aryParam['ORDER_BY'];
		$intPage						= $aryParam['PAGE'];

		## 기본 변수 설정 체크
		if(!$strBCode)		{ return; }
		if(!$intPage)		{ $intPage = 0; }

		## 데이터 불러오기
		$aryParamData					= "";
		$aryParamData['B_CODE']			= $strBCode;
		$this->resResult				= $this->objBoardComment->getBoardCommentSelectEx("OP_SELECT", $aryParamData);

		return 1;
	}

	/**
	 *		mysql_fetch_array 사용
	 **/
	public function getFetch() {

		## mysql_fetch_array 실행
		$this->aryRow = mysql_fetch_array($this->resResult, MYSQL_ASSOC);
		
		## 결과 전달
		return $this->aryRow;
	}

	/**
	 *		글번호 전달
	 **/
	public function getNo() {

		## 결과 전달
		return $this->aryRow['CM_NO'];
	}

	/**
	 *		작성자 전달
	 **/
	public function getWriterName() {

		## 결과 전달
		return $this->aryRow['CM_NAME'];
	}

	/**
	 *		작성일 전달
	 **/
	public function getRegDate($dateFmt="Y-m-d", $timeFmt="H:i:s") {
		
		## 기본 설정
		$strRegDate				= strtotime($this->aryRow['CM_REG_DT']);

		## 오늘 작성한 글은 시간. 그 이후는 날짜
		if(date("ymd") == date("ymd", $strRegDate)) {
			$strRegDate			= date($timeFmt, $strRegDate);
		} else {
			$strRegDate			= date($dateFmt, $strRegDate);
		}
		
		## 결과 전달
		return $strRegDate;
	}

	/**
	 *		작성글 전달
	 **/
	public function getText() {

		## 결과 전달
		return $this->aryRow['CM_TEXT'];
	}

}