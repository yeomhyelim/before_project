<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-10-23												|# 
#|작성내용	: 최상위 콘트롤러 클레스									|# 
#/*====================================================================*/# 

class Controller2
{
	## 데이터 베이스
	protected $db					= null;
	## 내용 데이터
	protected $aryRow				= null;		// 삭제 예정
	## 파라미터 데이터
	protected $aryParam				= null;
	## 
//	protected $data					= null;
	/**
	 *		생성자 함수
	 **/
	public function __construct($objDB, $aryParam) 
	{
		$this->db				= $objDB;
		$strLoadFunction		= $aryParam['LOAD'];

		if($strLoadFunction) 
		{
			$this->{$strLoadFunction}($aryParam);
		}
	}

//	public function __get($name) 
//	{
//		return $this->data[$name];
//	}
//
//	public function __set($name, $val) 
//	{
//		$this->data[$name] = $val;
//	}
}