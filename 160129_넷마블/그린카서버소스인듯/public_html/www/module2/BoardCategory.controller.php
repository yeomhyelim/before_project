<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-12-07												|# 
#|작성내용	: 커뮤니티 카테고리 콘트롤러 클레스							|# 
#/*====================================================================*/# 

require_once "Controller.php";

class BoardCategoryController extends Controller2
{
	## 모듈 클레스 
	private $objBoardCategoryModule		= null;
	## 뷰 클래스
	private $objBoardCategoryView		= null;
	/**
	 *		생성자 함수
	 */
	public function __construct($objDB, $aryParam) {

		## 모듈 설정
		$this->objBoardCategoryModule	= new BoardCategoryModule($objDB);	
		$this->objBoardCategoryView		= new BoardCategoryView($objDB);	

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

		## 이미지 업로드
		$aryParam['BC_IMAGE_1'] = $this->imageUpload("bc_image_1");
		$aryParam['BC_IMAGE_2'] = $this->imageUpload("bc_image_2");

		## 기본 설정
		$this->setBCode($aryParam['BC_B_CODE']);
		$this->setName($aryParam['BC_NAME']);
		$this->setImage1($aryParam['BC_IMAGE_1']);
		$this->setImage2($aryParam['BC_IMAGE_2']);
		$this->setSort($aryParam['BC_SORT']);
		$this->setRegDate($aryParam['BC_REG_DT']);
		$this->setRegNo($aryParam['BC_REG_NO']);
		$this->setModDate($aryParam['BC_MOD_DT']);
		$this->setModNo($aryParam['BC_MOD_NO']);

		## 기본 설정 체크
		if(!$this->aryParam['BC_B_CODE'])		{ return; }
		if(!$this->aryParam['BC_NAME'])			{ return; }

		## 데이터 등록
		$ubNo = $this->objBoardCategoryModule->getBoardCategoryInsertEx($this->aryParam);

		## 데이터 등록 체크
		if($ubNo <= 0) { return; }

		## 완료
		return 1;
	}
	/**
	 *		update
	 */
	public function makeUpdateData($aryParam) {

		## 데이터 불러오기
		$this->objBoardCategoryView->makeSelectData($aryParam);

		## 이미지 업로드
		$aryParam['BC_IMAGE_1'] = $this->imageUpload("bc_image_1");
		$aryParam['BC_IMAGE_2'] = $this->imageUpload("bc_image_2");

		## 기존에 등록된 이미지를 삭제 하고 싶으면 Y 로 설정
		if($aryParam['BC_IMAGE_1']) { $aryParam['BC_IMAGE_1_DEL'] = "Y"; }
		if($aryParam['BC_IMAGE_2']) { $aryParam['BC_IMAGE_2_DEL'] = "Y"; }

		## 이미지 삭제 설정
		$this->setImage1Del($aryParam['BC_IMAGE_1_DEL']);
		$this->setImage2Del($aryParam['BC_IMAGE_2_DEL']);

		## 기존에 등록된 이미지 삭제
		$this->imageDelete("bc_image_1");
		$this->imageDelete("bc_image_2");

		if($this->aryParam['BC_IMAGE_1_DEL'] != "Y") { $aryParam['BC_IMAGE_1'] = $this->objBoardCategoryView->getRowData("BC_IMAGE_1"); }
		if($this->aryParam['BC_IMAGE_2_DEL'] != "Y") { $aryParam['BC_IMAGE_2'] = $this->objBoardCategoryView->getRowData("BC_IMAGE_2"); }

		return $re;

		## 기본 설정
		$this->setNo($aryParam['BC_NO']);
		$this->setBCode($aryParam['BC_B_CODE']);
		$this->setName($aryParam['BC_NAME']);
		$this->setImage1($aryParam['BC_IMAGE_1']);
		$this->setImage2($aryParam['BC_IMAGE_2']);
		$this->setSort($aryParam['BC_SORT']);
		$this->setModDate($aryParam['BC_MOD_DT']);
		$this->setModNo($aryParam['BC_MOD_NO']);

		## 기본 설정 체크
		if(!$this->aryParam['BC_NO'])			{ return; }
		if(!$this->aryParam['BC_B_CODE'])		{ return; }
		if(!$this->aryParam['BC_NAME'])			{ return; }



		## 데이터 수정(신규데이터)
//		$ubNo = $this->objBoardCategoryModule->getBoardCategoryUpdateEx($this->aryParam);

//		## 
//		$strImage1 = $this->objBoardCategoryView->getRowData("BC_IMAGE_1");
//		$strImage2 = $this->objBoardCategoryView->getRowData("BC_IMAGE_2");
	}
	/**
	 *		set 커뮤니티 코드
	 */
	public function setBCode($strBCode) {
		if(!$strBCode) { $strBCode			= $_POST['b_code']; }
		$this->aryParam['BC_B_CODE']		= $strBCode;
	}
	/**
	 *		set 커뮤니티 카테고리 번호
	 */
	public function setNo($intCNo) {
		if(!$intCNo) { $intCNo				= $_POST['bc_no']; }
		$this->aryParam['BC_NO']			= $intCNo;
	}
	/**
	 *		set 커뮤니티 카테고리 이름
	 */
	public function setName($strName) {
		if(!$strName) { $strName			= $_POST['bc_name']; }
		$this->aryParam['BC_NAME']			= $strName;
	}
	/**
	 *		set 커뮤니티 카테고리 이미지 1
	 */
	public function setImage1($strImage1) {
		if(!$strImage1) { $strImage1		= $_POST['bc_image_1']; }
		$this->aryParam['BC_IMAGE_1']		= $strImage1;
	}
	/**
	 *		set 커뮤니티 카테고리 이미지 2
	 */
	public function setImage2($strImage2) {
		if(!$strImage2) { $strImage2		= $_POST['bc_image_2']; }
		$this->aryParam['BC_IMAGE_2']		= $strImage2;
	}
	/**
	 *		set 커뮤니티 카테고리 이미지 1 삭제
	 */
	public function setImage1Del($strImage1Del) {
		if(!$strImage1Del) { $strImage1Del		= $_POST['bc_image_1_del'];		}
		$this->aryParam['BC_IMAGE_1_DEL']		= $strImage1Del;
	}
	/**
	 *		set 커뮤니티 카테고리 이미지 2 삭제
	 */
	public function setImage2Del($strImage2Del) {
		if(!$strImage2Del) { $strImage2Del		= $_POST['bc_image_2_del'];		}
		$this->aryParam['BC_IMAGE_2_DEL']		= $strImage2Del;
	}
	/**
	 *		set 커뮤니티 카테고리 정렬
	 */
	public function setSort($strSort) {
		if(!$strSort) { $strSort			= $_POST['bc_sort']; }
		$this->aryParam['BC_SORT']			= $strSort;
	}
	/**
	 *		set 커뮤니티 카테고리 등록일
	 */
	public function setRegDate($strRegDt) {
		if(!$strRegDt) { $strRegDt			= $_POST['bc_reg_dt']; }
		if(!$strRegDt) { $strRegDt			= "NOW()"; }
		$this->aryParam['BC_REG_DT']		= $strRegDt;
	}
	/**
	 *		set 커뮤니티 카테고리 등록자
	 */
	public function setRegNo($intRegNo) {
		if(!$intRegNo) { $intRegNo		= $_POST['bc_reg_no']; }
		if(!$intRegNo) { $intRegNo		= $_SESSION['member_no']; }
		if(!$intRegNo) { $intRegNo		= $_SESSION['ADMIN_NO']; }
		if(!$intRegNo) { $intRegNo		= -1; }
		$this->aryParam['BC_REG_NO']	= $intRegNo;
	}
	/**
	 *		set 커뮤니티 카테고리 수정일
	 */
	public function setModDate($strModDt) {
		if(!$strModDt) { $strModDt		= $_POST['bc_mod_dt']; }
		if(!$strModDt) { $strModDt		= "NOW()"; }
		$this->aryParam['BC_MOD_DT']	= $strModDt;
	}
	/**
	 *		set 커뮤니티 카테고리 수정자
	 */
	public function setModNo($intModNo) {
		if(!$intModNo) { $intModNo		= $_POST['bc_mod_no']; }
		if(!$intModNo) { $intModNo		= $_SESSION['member_no']; }
		if(!$intModNo) { $intModNo		= $_SESSION['ADMIN_NO']; }
		if(!$intModNo) { $intModNo		= -1; }
		$this->aryParam['BC_MOD_NO']	= $intModNo;
	}

	private function imageUpload($strName) {

		## 기본 설정
		$aryFile						= $_FILES[$strName];
		$strDir							= SHOP_HOME . "/upload/community/category";
		$isDir							= FileDevice::makeFolder($strDir);
		$strDate						= date("YmdHis");
		$arySaveTypeList				= array("image/png","image/jpeg","image/gif");
		$strFileName					= FileDevice::getUniqueFileName($strDir, "{$strDate}_%s_{$strName}_@_{$aryFile['strName']}");

		## 기본 설정 체크
		if(!$aryFile)				{ return; }
		if($aryFile['error'])		{ return; }
		if(!$isDir)					{ return; }
		if(!$strFileName)			{ return; }
		if(!in_array($aryFile['type'], $arySaveTypeList)) { return; }

		## 파일 업로드
		$re								= FileDevice::upload($strName, "{$strDir}/{$strFileName}");
		
		## 파일 업로드 체크
		if(!$re) { return; }

		## 마무리
		return $strFileName;
	}
	private function imageDelete($strName) {
		$strDir				= SHOP_HOME . "/upload/community/category";
		$strNameUpper		= strtoupper($strName);
		$strFileName		= $this->objBoardCategoryView->getRowData($strNameUpper);
		if(!$strFileName) { return; }
		if($this->aryParam["{$strNameUpper}_DEL"] == "Y") { FileDevice::fileDelete("{$strDir}/{$strFileName}"); }
	}
}