<?
	$result_array = array();
	/*##################################### Parameter 셋팅 #####################################*/
	$strJsonMode		= $_POST["jsonMode"]		? $_POST["jsonMode"]		: $_REQUEST["jsonMode"];
	$strDisplayUseYN	= $_POST["displayUseYN"]	? $_POST["displayUseYN"]	: $_REQUEST["displayUseYN"];
	/**************************** 정리 (2013-01-06) ****************************/
	// 샵메인
	if(!$strJsonMode) { $strJsonMode = $strAct; }


	/**************************** 정리 (2013-01-06) ****************************/
	switch ($strJsonMode){
		case "subPageCodeVal":
			// 세부페이지 카테고리 클릭 처리
			// 2015.03.13 kim hee sung 소스 정리

			## 참고사항
			## 샵메인				= ZL0001
			## 상품리스트			= PL0001
			## 상품상세보기			= PV0001
			## 상품검색결과			= PS0001
			## 브랜드 메인화면		= PJ0001
			## 브랜드 세부화면		= PH0001
			## 회원로그인			= ML0001
			## 퀵메뉴				= EQ0001

			## 기본설정
			$strSubPageCode = $_POST['subPageCode'];
			if(!$strSubPageCode) $strSubPageCode = $_GET['subPageCode'];
			
			## 체크
			if(!$strSubPageCode):
				$result[0]['MOD'] = 'ERROR';
				$result[0]['MSG'] = '서브페이지코드(subPageCode)가 없습니다.';
				echo json_encode($result);	
				break;
			endif;

			## DS_CODE 설정
			$strDsCode = substr($strSubPageCode, 0, 2);

			## 스킨 불러오기
			$designSetMgr->setDS_TYPE("SKIN");
			$designSetMgr->setDS_CODE($strDsCode);
			$strSkinCode = $designSetMgr->getCodeVal($db);
			$strSkinDsCode = substr($strSkinCode, 0, 2);
			if(!$strSkinCode) $strSkinCode = $strSubPageCode;
			if($strSkinDsCode != $strDsCode) $strSkinCode = $strSubPageCode;

			## 마무리
			$result[0]['MOD'] = 'OK';
			$result[0]['RET'] = $strSkinCode;
			echo json_encode($result);			
		break;

		case "makeSkinConfFile":

			$designSetMgr->setDS_TYPE("SKIN_" . SUBSTR($strSubPageCode,0,1) );
			$designSetMgr->setDS_CODE(SUBSTR($strSubPageCode,0,1));
			$confDataList	= $designSetMgr->getConfDataList($db);
			$intCnt			= 0; 

			$arySkinFileName	= array ( "Z" => "main" , "P" => "product", "M" => "member", "O" => "order", "E" => "etc");
			
			foreach($confDataList as $dataList):	
				$keyA						= $dataList['DS_TYPE'];
				$keyB						= $dataList['DS_CODE'];		
				
				if($_CONF_FIELD_NAME[$keyA][$keyB]) :
					$aryData[$intCnt]['key']			= sprintf( "\$%s", $_CONF_FIELD_NAME[$keyA][$keyB] );
					$aryData[$intCnt]['data'] 			= sprintf( "\"%s\"", $dataList['DS_VAL'] );		
					$intCnt++;
				endif;	

			endforeach;

			$fileName	= $arySkinFileName[SUBSTR($strSubPageCode,0,1)];
			$fileName	= sprintf("site_%s_%s.conf.inc.php", "skin", $fileName);
			
			shopConfigFileUpdate ( $aryData, $fileName );
			
			/* CSS 등록 */
			$fileNameOrg = "css/{$arySkinFileName[SUBSTR($strSubPageCode,0,1)]}.org.css";
			$fileNameUse = "css/{$arySkinFileName[SUBSTR($strSubPageCode,0,1)]}.css";
			shopCssFileUpdate( $aryData, $fileNameOrg, $fileNameUse );
			
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
			   ,"OR" => "ORDER_ADDRLIST"				// 주소록관리
			   ,"OU" => "ORDER_COMMUNITY"				// 마이페이지 커뮤니티
			   ,"PS" => "PRODUCT_SEARCH"
			   ,"PH" => "PRODUCT_BRANDLIST"				//  브랜드 상품 리스트
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
						
					endif;	
				endforeach;
			endforeach;

			$fileName	= "site_skin.conf.inc.php";
			shopConfigFileUpdate ( $aryData, $fileName );

			/* 카테고리 파일 생성 */
			if (SUBSTR($strSubPageCode,0,2) == "PL"){
				include MALL_HOME."/web/shopAdmin/layout/categoryMakeFile.php";
			}
			/* 카테고리 파일 생성 */

			$result[0]['MSG'] = $LNG_TRANS_CHAR["CS00004"]; //"수정되었습니다.";
			echo json_encode($result);	
		break;	

	}
	

	$db->disConnect();

?>