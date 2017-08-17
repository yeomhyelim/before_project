<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-08-19												|# 
#|작성내용	: 회원 추가정보 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class MemberAddModule extends Module2
{
		function getMemberAddSelectEx($op, $param)
		{


		}

		function getMemberAddInsertEx($param)
		{

		}

		function getMemberAddAnsUpdateEx($param)
		{


		}

		function getMemberAddPhotoUpdateEx($param)
		{
			## 기본설정
			$intM_NO = $param['M_NO'];
			$strM_PHOTO = $param['M_PHOTO'];

			## 체크
			if(!$intM_NO) { return; }

			$paramData					= "";
			$paramData['M_PHOTO']		= $this->db->getSQLString($strM_PHOTO);

			## WHERE 설정
			$where				= "M_NO = {$intM_NO}";
			
			return $this->db->getUpdateParam("MEMBER_ADD", $paramData, $where);	

		}


		function getSelectQuery($query, $op)
		{
			if ( $op == "OP_LIST" ) :
				return $this->db->getExecSql($query);
			elseif ( $op == "OP_SELECT" ) :
				return $this->db->getSelect($query);
			elseif ( $op == "OP_COUNT" ) :
				return $this->db->getCount($query);
			elseif ( $op == "OP_ARYLIST" ) :
				return $this->db->getArray($query);
			elseif ( $op == "OP_ARYTOTAL" ) :
				return $this->db->getArrayTotal($query);
			else :
				return -100;
			endif;
		}	
}