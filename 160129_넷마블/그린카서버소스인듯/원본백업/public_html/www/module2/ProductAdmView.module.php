<?
#/*====================================================================*/# 
#|화일명	: ProductAdmView.module.php									|# 
#|작성자	: Park Young-MI												|# 
#|작성일	: 2014-01-29												|# 
#|작성내용	: 상품상세보기 모듈(관리자)									|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductAdmViewModule extends Module2
{

	function getProductView($op,$param){
		## 추가컬럼 설정보기
		$fromAddColumn		= "";
		## 상품상세이미지 보기
		$prodViewImgJoin	= "";
		if ($param['P_VIEW_IMG_SHOW']=="Y"){
			$fromAddColumn   .= ",PIMG.PM_REAL_NAME					"; 
				
			$prodViewImgJoin .= "LEFT OUTER JOIN PRODUCT_IMG PIMG	";
			$prodViewImgJoin .= "ON A.P_CODE = PIMG.P_CODE			";
			$prodViewImgJoin .= "AND PIMG.PM_TYPE = 'view'			";
		}

		## 상품리스트이미지 보기
		$prodListImgJoin	= "";
		if ($param['P_LIST_IMG_SHOW']=="Y"){
			$fromAddColumn   .= ",PIMG2.PM_REAL_NAME				"; 
				
			$prodListImgJoin .= "LEFT OUTER JOIN PRODUCT_IMG PIMG2	";
			$prodListImgJoin .= "ON A.P_CODE = PIMG.P_CODE			";
			$prodListImgJoin .= "AND PIMG.PM_TYPE = 'list'			";
		}
		
		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "    ,AI.P_NAME							";
		$query .= "    ,AI.P_SEARCH_TEXT					";
		$query .= "    ,AI.P_ETC							";
		$query .= "    ,AI.P_WEB_TEXT						";
		$query .= "    ,AI.P_MOB_TEXT						";
		$query .= "    ,AI.P_MEMO							";
		$query .= "    ,AI.P_DELIVERY_TEXT					";
		$query .= "    ,AI.P_RETURN_TEXT					";
		$query .= "    ,AI.P_PRICE_TEXT						";
		$query .= "    ,SUBSTRING(A.P_ICON,1,1) ICON1		";
		$query .= "    ,SUBSTRING(A.P_ICON,3,1) ICON2		";
		$query .= "    ,SUBSTRING(A.P_ICON,5,1) ICON3		";
		$query .= "    ,SUBSTRING(A.P_ICON,7,1) ICON4		";
		$query .= "    ,SUBSTRING(A.P_ICON,9,1) ICON5		";
		$query .= "    ,SUBSTRING(A.P_ICON,11,1) ICON6		";
		$query .= "    ,SUBSTRING(A.P_ICON,13,1) ICON7		";
		$query .= "    ,SUBSTRING(A.P_ICON,15,1) ICON8		";
		$query .= "    ,SUBSTRING(A.P_ICON,17,1) ICON9		";
		$query .= "    ,SUBSTRING(A.P_ICON,19,1) ICON10		";		
		
		$query .= $fromAddColumn;
		
		$query .= "FROM ".TBL_PRODUCT_MGR." A               ";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$param['P_LNG']." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE					";				
		
		## 1. 상품상세보기
		$query .= $prodViewImgJoin;

		## 2. 상품리스트보기
		$query .= $prodListImgJoin;
		
		$query .= "WHERE A.P_CODE = '".$param['P_CODE']."'	";
		return $this->getSelectQuery($query, "OP_SELECT");
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