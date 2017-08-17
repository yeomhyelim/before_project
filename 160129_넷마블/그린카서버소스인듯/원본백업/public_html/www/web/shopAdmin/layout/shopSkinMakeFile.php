<?
		if(!$designSetMgr) { 
			require_once MALL_CONF_LIB . "DesignSetMgr.php";
			$designSetMgr = new DesignSetMgr();	
		}

		$aryTypeName = array ( "LAYOUT", "INTRO", "SKIN" );

		$arySkinKey = array(
			"PL" => "PRODUCT_LIST"
		   ,"PV" => "PRODUCT_VIEW"
		   ,"MF" => "MEMBER_FINDIDPWD"
		   ,"MI" => "MEMBER_JOINFORM"
		   ,"MT" => "MEMBER_JOIN1"
		   ,"ME" => "MEMBER_JOINEND"
		   ,"ML" => "MEMBER_LOGIN"
		   ,"OB" => "ORDER_BUYLIST"					// 구매내역 리스트
		   ,"OG" => "ORDER_BUYNONLIST"				// 구매내역 리스트 (비회원)
		   ,"OA" => "ORDER_BUYVIEW"					// 구매내역 상세
		   ,"OH" => "ORDER_BUYNONVIEW"					// 구매내역 상세 (비회원)
		   ,"OC" => "ORDER_CARTMYLIST"				// 장바구니 ( 마이페이지 )
		   ,"ON" => "ORDER_CART"					// 장바구니 
		   ,"OD" => "ORDER_ORDER"					// 상품주문
		   ,"OE" => "ORDER_ORDEREND"				// 상품주문 완료
		   ,"OW" => "ORDER_WISHMYLIST"				// 담아둔상품 (마이페이지 )
		   ,"OP" => "ORDER_POINTLIST"				// 포인트 리스트
		   ,"OO" => "ORDER_COUPONLIST"				// 쿠폰 리스트
		   ,"OM" => "ORDER_MYINFO"					// 회원정보변경
		   ,"PS" => "PRODUCT_SEARCH"
		);
		/* 스킨 정보 저장 */
		$intCnt			= 0; 
		$aryData		= null;		
		foreach($aryTypeName as $name) :
			$designSetMgr->setDS_TYPE($name);
			$designSetMgr->setDS_CODE("");
			$confDataList	= $designSetMgr->getConfDataList($db);				
			foreach($confDataList as $dataList):	
				if($name!="SKIN") :
					$keyA								= $dataList['DS_TYPE'];
					$keyB								= $dataList['DS_CODE'];	
					if($_CONF_FIELD_NAME[$keyA][$keyB]) :
						$aryData[$intCnt]['key']			= sprintf( "\$%s", $_CONF_FIELD_NAME[$keyA][$keyB] );
						$aryData[$intCnt]['data'] 			= sprintf( "\"%s\"", $dataList['DS_VAL'] );	
						$intCnt++;
					endif;	
				else :
					if ($arySkinKey[$dataList['DS_CODE']]){
						$aryData[$intCnt]['key']			= sprintf( "\$S_SKIN['%s']", $arySkinKey[$dataList['DS_CODE']] );
						$aryData[$intCnt]['data'] 			= sprintf( "\"%s\"", $dataList['DS_VAL'] );	
						$intCnt++;
					} else {
						$aryData[$intCnt]['key']			= sprintf( "\$S_SKIN_%s", $dataList['DS_CODE'] );
						$aryData[$intCnt]['data'] 			= sprintf( "\"%s\"", $dataList['DS_VAL'] );	
						$intCnt++;						
					}

					if($name == "INTRO"){
						
					}
				endif;	
			endforeach;
		endforeach;

		require_once "_function.lib.inc.php";
		$fileName	= "site_skin.conf.inc.php";
		shopConfigFileUpdate ( $aryData, $fileName );
?>