<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: park young mi												|# 
#|작성일	: 2014-08-20												|# 
#|작성내용	: 상품경매관리												|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductAuctionModule extends Module2
{
		function getProductAuctionMySelectEx($op,$param)
		{
		
			$column["OP_COUNT"]		= "COUNT(*)	";
			$column["OP_LIST"]		= "  PA.*
										,PAA.P_AUC_APPLY_PRICE
										,PI.P_NAME
										,PAA.P_AUC_APPLY_CUR_PRICE
										,PAA.P_AUC_APPLY_USE_CUR
										,M.M_F_NAME                
										,M.M_L_NAME
										,PAA.P_AUC_APPLY_CNT
			";
			$column["OP_SELECT"]	= "  PA.*
										,PAA.P_AUC_APPLY_PRICE
										,PI.P_NAME
			";

			$query  = "SELECT												";
			$query .= $column[$op]."										";
			$query .= "FROM PRODUCT_AUCTION PA								";
			$query .= "JOIN													";
			$query .= "(													";
			$query .= "    SELECT											";
			$query .= "         P_CODE										";
			$query .= "        ,MAX(PAA_PRICE) P_AUC_APPLY_PRICE			";
			$query .= "        ,MAX(PAA_CUR_PRICE) P_AUC_APPLY_CUR_PRICE	";
			$query .= "        ,MAX(PAA_USE_CUR) P_AUC_APPLY_USE_CUR		";
			$query .= "        ,COUNT(PAA_NO) P_AUC_APPLY_CNT				";
			$query .= "    FROM PRODUCT_AUCTION_APPLY						";
			$query .= "    WHERE M_NO = ".$param['M_NO']."					";
			$query .= "    GROUP BY P_CODE									";
			$query .= ") PAA												";
			$query .= "ON PA.P_CODE = PAA.P_CODE							";
			$query .= "JOIN PRODUCT_MGR P									";
			$query .= "ON PA.P_CODE = P.P_CODE								";
			$query .= "JOIN PRODUCT_INFO_".$param['P_LNG']." PI				";
			$query .= "ON P.P_CODE = PI.P_CODE								";
			$query .= "LEFT OUTER JOIN MEMBER_MGR M							";
			$query .= "ON PA.P_AUC_SUC_M_NO = M.M_NO						";
			$query .= "WHERE PA.P_CODE IS NOT NULL							";

			if ($param['LIMIT_START'] && $param['LIMIT_END']){
				$query .= "ORDER BY PA.P_AUC_END_DT DESC LIMIT ".$param['LIMIT_START'].",".$param['LIMIT_END']."   ";
			}

			return $this->getSelectQuery($query, $op);
		}
		
		
		function getProductAuctionApplySelectEx($op,$param)
		{

			$column["OP_COUNT"]		= "COUNT(*)			";
			$column["OP_LIST"]		= "  PAA.*                     
										,M.M_F_NAME                
										,M.M_L_NAME     ";
			$column["OP_SELECT"]	= "PAA.*			";


			$query  = "SELECT                         ";
			$query .= $column[$op];
			$query .= "FROM PRODUCT_AUCTION_APPLY PAA ";
			$query .= "JOIN MEMBER_MGR M              ";
			$query .= "ON PAA.M_NO = M.M_NO           ";
			$query .= "WHERE PAA.PAA_NO IS NOT NULL	  ";
			
			if ($param['P_CODE']){
				$query .= " AND PAA.P_CODE = '".$param['P_CODE']."'       ";
			}

			if ($param['PAA_NO'] > 0){
				$query .= " AND PAA.PAA_NO = ".$param['PAA_NO']."		";
			}
			
			if ($param['PAA_APPLY_M_NO']){
				$query .= " AND PAA.M_NO = ".$param['PAA_APPLY_M_NO']."		";
			}
			
			$query .= "ORDER BY PAA.PAA_REG_DT DESC	";
			if ($param['LIMIT_START'] && $param['LIMIT_END']){
				$query .= "LIMIT ".$param['LIMIT_START'].",".$param['LIMIT_END']."   ";
			}

			return $this->getSelectQuery($query, $op);
		}

		function getProductAuctionInsertEx($param)
		{			
			if(!$param['P_CODE'])	{ return; }

			$paramData							= "";
			$paramData['P_CODE']				= $this->db->getSQLString($param['P_CODE']);
			$paramData['M_NO']					= $this->db->getSQLInteger($param['M_NO']);
			$paramData['PAA_PRICE']				= $this->db->getSQLInteger($param['P_AUC_PRICE']);

			$paramData['PAA_PRICE']				= $this->db->getSQLInteger($param['P_AUC_PRICE']);
			$paramData['PAA_CUR_PRICE']			= $this->db->getSQLInteger($param['P_AUC_CUR_PRICE']);
			$paramData['PAA_USE_LNG']			= $this->db->getSQLString($param['P_AUC_LNG']);
			$paramData['PAA_USE_CUR']			= $this->db->getSQLString($param['P_AUC_CUR']);

			$paramData['PAA_REG_DT']			= $this->db->getSQLDatetime("NOW()");
			$paramData['PAA_STATUS']			= $this->db->getSQLInteger($param['P_AUC_STATUS']);
			
			return $this->db->getInsertParam("PRODUCT_AUCTION_APPLY", $paramData, true);
		}

		function getProductAuctionMaxPriceUpdateEx($param){
			if(!$param['P_CODE'])	{ return; }

			$paramData							= "";
			$paramData['P_AUC_BEST_PRICE']		= $this->db->getSQLInteger($param['P_AUC_PRICE']);
			$paramData['P_AUC_BEST_M_NO']		= $this->db->getSQLInteger($param['M_NO']);

			if ($param['P_AUC_SUC_PRICE']){
				$paramData['P_AUC_SUC_PRICE']	= $this->db->getSQLInteger($param['P_AUC_SUC_PRICE']);
			}

			if ($param['P_AUC_SUC_M_NO']){
				$paramData['P_AUC_SUC_M_NO']	= $this->db->getSQLInteger($param['P_AUC_SUC_M_NO']);
				$paramData['P_AUC_SUC_DT']		= $this->db->getSQLDatetime("NOW()");
			}

			if($param['P_CODE']):
				$where							= "P_CODE = '".$param['P_CODE']."'";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("PRODUCT_AUCTION", $paramData, $where);
		}

		function getProductAuctionStatusUpdateEx($param)
		{
			if(!$param['P_CODE'])	{ return; }

			$paramData							= "";
			
			if ($param['P_AUC_STATUS']){
				$paramData['P_AUC_STATUS']		= $this->db->getSQLString($param['P_AUC_STATUS']);
			}
			
			if ($param['P_AUC_ORDER']){
				$paramData['P_AUC_ORDER']		= $this->db->getSQLString($param['P_AUC_ORDER']);			
			}

			if ($param['P_AUC_ORDER_NO']){
				$paramData['P_AUC_ORDER_NO']	= $this->db->getSQLString($param['P_AUC_ORDER_NO']);			
			}

			if ($param['P_AUC_ORDER_DT']){
				$paramData['P_AUC_ORDER_DT']	= $this->db->getSQLDatetime("NOW()");	
			}

			if($param['P_CODE']):
				$where							= "P_CODE = '".$param['P_CODE']."'";
			endif;

			
			if(!$where)					{ return; }
			
			return $this->db->getUpdateParam("PRODUCT_AUCTION", $paramData, $where);
		}


		function getProductAuctionApplyUpdateEx($param)
		{
			if(!$param['PAA_NO'])	{ return; }

			$paramData							= "";
			
			if ($param['PAA_STATUS']){
				$paramData['PAA_STATUS']		= $this->db->getSQLString($param['PAA_STATUS']);
			}

			if($param['PAA_NO']):
				$where							= "PAA_NO = '".$param['PAA_NO']."'";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("PRODUCT_AUCTION_APPLY", $paramData, $where);
		}
	
		function getProductAuctionViewEx($param){
			
			$query  = "SELECT PA.*								";
			$query .= "	,PI.P_NAME								";
			$query .= " ,M.M_F_NAME								";
			$query .= " ,M.M_L_NAME								";
			$query .= "FROM PRODUCT_AUCTION PA					";
			$query .= "JOIN PRODUCT_MGR P						";
			$query .= "ON PA.P_CODE = P.P_CODE					";
			$query .= "JOIN PRODUCT_INFO_".$param['P_LNG']." PI	";
			$query .= "ON PA.P_CODE = PI.P_CODE					";
			$query .= "LEFT OUTER JOIN MEMBER_MGR M				";
			$query .= "ON PA.P_AUC_BEST_M_NO = M.M_NO			";
			$query .= "WHERE PA.P_CODE IS NOT NULL				";
			$query .= " AND PA.P_CODE = '".$param['P_CODE']."'	";

			if ($param['P_AUC_DT'] == "Y"){
				$query .= " AND NOW() BETWEEN PA.P_AUC_ST_DT AND PA.P_AUC_END_DT	";
			}
			
			if ($param['P_AUC_STATUS']){
				$query .= " AND PA.P_AUC_STATUS = '".$param['P_AUC_STATUS']."'	";
			}

			if ($param['NOT_AUC_STATUS']){
				$query .= " AND PA.P_AUC_STATUS NOT IN (".$param['NOT_AUC_STATUS'].")	";
			}
			
			return $this->db->getSelect($query);
		}
		
		function getProductAuctionDupCheck($param){
			$query  = "SELECT COUNT(*)											";
			$query .= "FROM PRODUCT_AUCTION_APPLY								";
			$query .= "WHERE P_CODE		= '".$param['P_CODE']."'				";
			$query .= " AND PAA_PRICE  >= '".$param['P_AUC_PRICE']."'			";
			
			return $this->db->getCount($query);
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