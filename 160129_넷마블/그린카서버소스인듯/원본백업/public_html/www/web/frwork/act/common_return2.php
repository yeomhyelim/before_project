<?
	$orderMgr->setO_STATUS("E");
	$result = $orderMgr->getOrderStatusUpdate($db);
	if (!$result) {
		$strResult  = "9801";
	}


	/** 구매완료시 소속에게 포인트 주기 */
	if ($S_FIX_MEMBER_CATE_USE_YN == "Y" && $SHOP_POINT_MOVE_FLAG == "Y" && $S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN == "Y"){
		$param			= "";
		$param["M_NO"]	= $orderRow['M_NO'];
		$aryOrderMemberCateList = $orderMgr->getOrderMemberCateList($db,$param);
		if ($orderRow['O_SETTLE'] == "P") $intOrderTotal	= $orderRow['O_TOT_CUR_PRICE'];
		else $intOrderTotal	= $orderRow['O_TOT_CUR_SPRICE'];

		if (is_array($aryOrderMemberCateList)){

			for($i=0;$i<sizeof($aryOrderMemberCateList);$i++){
				$intPoint		= 0;
				$strPointType	= "";
				$intPointMark	= 0;
				$intGiveMemNo	= $aryOrderMemberCateList[$i]['C_M_NO']; //소속가상회원
				
				if ($orderRow['M_GROUP'] == "007"){
					/* 영업사원 */
					$strPointType	= $aryOrderMemberCateList[$i]['C_POINT_OFF'];
					$intPointMark	= $aryOrderMemberCateList[$i]['C_POINT'];
				} else {
					/* 영업사원 제외 회원 */
					$strPointType	= $aryOrderMemberCateList[$i]['C_POINT2_OFF'];
					$intPointMark	= $aryOrderMemberCateList[$i]['C_POINT2'];													
				}

				if ($strPointType == "1") $intPoint = ($intOrderTotal * ($intPointMark/100)); //%
				else $intPoint = $intPointMark;

				if ($S_ST_LNG == "KR") $intPoint = getTruncateDown($intPoint,0);
				else  $intPoint = getTruncateDown($intPoint,2);
				
				/* 소속에게 포인트 주기 */
				if ($intPoint > 0 && $intGiveMemNo > 0){
					
					/* 중복 체크 */
					$paramData					= "";
					$paramData["M_NO"]			= $intGiveMemNo;
					$paramData["O_NO"]			= $orderRow['O_NO'];
					$paramData["POINT_TYPE"]	= "002";
					$paramData["POINT_ETC"]		= "소속포인트";
					$intPointDupCnt				= $memberMgr->getMemberPointDupCnt($db,$paramData);
					
					if ($intPointDupCnt == 0){
						$memberMgr->setM_NO($intGiveMemNo);
						$memberMgr->setM_POINT($intPoint);
						$result = $memberMgr->getMemberPointUpdate($db);
						
						/* 포인트 관리 데이터 INSERT */
						$orderMgr->setM_NO($intGiveMemNo);
						$orderMgr->setB_NO(0);
						$orderMgr->setPT_TYPE('002');
						$orderMgr->setPT_POINT($memberMgr->getM_POINT());
						$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00126"]."[".$orderRow[O_KEY]."]"); //구매포인트적립
						$orderMgr->setPT_START_DT(date("Y-m-d"));
						$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
						$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
						$orderMgr->setPT_ETC('소속포인트');
						$orderMgr->setPT_REG_NO(1);
						$orderMgr->getOrderPointInsert($db);
					}
				}
				/* 소속에게 포인트 주기 */
			}
		}
	}
	/** 구매완료시 소속에게 포인트 주기 */

	/** 주문 상품 구매상태 변경 **/
	if ($S_SHOP_ORDER_VERSION == "V2.0"){
		include MALL_HOME."/web/frwork/act/payOrderEndCartStatusUpdate.php";

	} else {
		/** 몰인몰일 경우 입점사 구매상태 변경 **/
		if ($S_MALL_TYPE == "M"){
			if ($orderRow['O_USE_LNG'] == "KR"){
				include MALL_HOME."/web/frwork/act/payOrderEndMallStatusUpdate.php";
			}
		}
	}
?>