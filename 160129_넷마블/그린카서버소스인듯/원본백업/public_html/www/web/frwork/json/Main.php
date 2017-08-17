<?
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_SHOP . "/conf/order.inc.php";
	
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$productMgr = new ProductMgr();
	$memberMgr = new MemberMgr();

	$intPB_NO				= $_POST["cartNo"]				? $_POST["cartNo"]				: $_REQUEST["cartNo"];
	$intPW_NO				= $_POST["wishNo"]				? $_POST["wishNo"]				: $_REQUEST["wishNo"];

	$intQty					= $_POST["qty"]					? $_POST["qty"]					: $_REQUEST["qty"];

	$intCartPage			= $_POST["cartPage"]			? $_POST["cartPage"]			: $_REQUEST["cartPage"];		// 퀵 장바구니 출력 페이지 설정
	
	$intNo					= $_POST["no"]					? $_POST["no"]					: $_REQUEST["no"];
	$quickPage				= $_POST["quickPage"]			? $_POST["quickPage"]			: $_REQUEST["quickPage"];
	$callback				= $_POST["callback"]			? $_POST["callback"]			: $_REQUEST["callback"];	


	$strTopSearchKeyWord	= $_POST["topSearchKeyword"]	? $_POST["topSearchKeyword"]	: $_REQUEST["topSearchKeyword"];

	$result_array = array();
	
	switch ($strAct){
		case "hostTypeModify":
			// 호스트 변경(웹/모바일)

			## 기본 설정
			$strHostType = $_POST['hostType'];

			## 세션 설정
			$_SESSION['HOST_TYPE'] = $strHostType;

			## 마무리
			$result['__STATE__'] = "SUCCESS";
			$result['__DATA__']['URL']  = "http://" . $_SERVER['HTTP_HOST'];
		break;

		case "cartProductList":
			// 장바구니 상품 리스트
			// 2013.06.14
			// kim hee sung

			## STEP 1.
			## 상품 정보.
			$param['PB_KEY']	= $_REQUEST['COOKIE_CART_PRIKEY'];
			$param['M_NO']		= $g_member_no;
			$prodResult			= $productMgr->getProdBasketListEx($db, "OP_LIST", $param);

			$data	= "";
			$cnt	= 0;
			while ($prodRow = mysql_fetch_array($prodResult)) : 
				$data[$cnt]['PM_REAL_NAME'] = $prodRow['PM_REAL_NAME'];
				$data[$cnt]['P_CODE']		= $prodRow['P_CODE'];
				$data[$cnt]['P_NAME']		= $prodRow['P_NAME'];
				$data[$cnt]['P_SALE_PRICE']	= getCurToPrice($prodRow['P_SALE_PRICE']);
				$cnt++;
			endwhile;

			## STEP 4.
			## 출력.
			$result['TOTAL']	= $cnt;
			$result['DATA']		= $data;
			$result_array		= json_encode($result);
			$db->disConnect();
			echo "{$callback}({$result_array})";
			exit;
		break;

		case "bestProductList":
			// 베스트 상품 리스트
			// 2013.06.14 
			// kim hee sung

			## STEP 1.
			## 상품 정보.
			if(!$_REQUEST['cnt']) { $_REQUEST['cnt'] = 5; }
			$param							= "";
			$param['P_CATE_LIKE']			= $_REQUEST['lcate'];
			$param['LIMIT']					= "0,{$_REQUEST['cnt']}";
			$prodResult						= $productMgr->getProdBestListEx($db, "OP_LIST", $param);

			$data	= "";
			$cnt	= 0;
			while ($prodRow = mysql_fetch_array($prodResult)) : 
				$data[$cnt]['PM_REAL_NAME'] = $prodRow['PM_REAL_NAME'];
				$data[$cnt]['P_CODE']		= $prodRow['P_CODE'];
				$data[$cnt]['P_NAME']		= $prodRow['P_NAME'];
				$data[$cnt]['P_SALE_PRICE']	= getCurToPrice($prodRow['P_SALE_PRICE']);
				$cnt++;
			endwhile;

			## STEP 4.
			## 출력.
			$result['TOTAL']	= $cnt;
			$result['DATA']		= $data;
			$result_array		= json_encode($result);
			$db->disConnect();
			echo "{$callback}({$result_array})";
			exit;
		break;
// 2013.06.14 kim hee sung 쿠키 버전
//		case "cartProductList":
//			// 장바구니 상품 리스트
//			// 2013.06.14 
//			// kim hee sung
//
//			## STEP 1.
//			## 상품 정보 가져오기
//			$aryProdToday				= explode("/", $_COOKIE['COOKIE_PROD_TODAY']);
//			$S_QUICK_MENU_LIST_CNT_1	= ($S_QUICK_MENU_LIST_CNT_1) ? $S_QUICK_MENU_LIST_CNT_1 : "5";
//			$startPoint					= ($quickPage * $S_QUICK_MENU_LIST_CNT_1) - $S_QUICK_MENU_LIST_CNT_1;
//			foreach($aryProdToday as $key => $prodToday) :
//				if(!$prodToday) { continue; }
//				if(($key+1) <= $startPoint) { continue; }
//				if(sizeof($aryProdCode) >= $S_QUICK_MENU_LIST_CNT_1) { break; }
//				$aryProdCode[] = "'{$prodToday}'";
//			endforeach;
//			$strProdCode		= implode(",", $aryProdCode);
//
//			## STEP 2.
//			## 사용자가 본 상품이 없는 경우.
//			if(!$strProdCode):
//				$result[0]['QUICK_PROD_LIST']		= $tagUl;
//				$result_array						= json_encode($result);
//				$db->disConnect();
//				echo $callback."(".$result_array.")";
//				exit;
//			endif;
//
//			## STEP 3.
//			## 상품 정보.
//			$productMgr->setP_CODE_ALL($strProdCode);
//			$prodResult			= $productMgr->getProdInfo($db);
//
//			$data	= "";
//			$cnt	= 0;
//			while ($prodRow = mysql_fetch_array($prodResult)) : 
//				$data[$cnt]['PM_REAL_NAME'] = $prodRow['PM_REAL_NAME'];
//				$data[$cnt]['P_CODE']		= $prodRow['P_CODE'];
//				$data[$cnt]['P_NAME']		= $prodRow['P_NAME'];
//				$data[$cnt]['P_SALE_PRICE']	= getCurToPrice($prodRow['P_SALE_PRICE']);
//				$cnt++;
//			endwhile;
//
//			## STEP 4.
//			## 출력.
//			$result['TOTAL']	= $cnt;
//			$result['DATA']		= $data;
//			$result_array		= json_encode($result);
//			$db->disConnect();
//			echo "{$callback}({$result_array})";
//			exit;
//		break;

		case "quickProdList":

			## STEP 1.
			## 상품 정보 가져오기
			$aryProdToday				= explode("/",$g_prod_today);
			$S_QUICK_MENU_LIST_CNT_1	= ($S_QUICK_MENU_LIST_CNT_1) ? $S_QUICK_MENU_LIST_CNT_1 : "5";
			$startPoint					= ($quickPage * $S_QUICK_MENU_LIST_CNT_1) - $S_QUICK_MENU_LIST_CNT_1;
			
			$aryQuickMenuProdImg		= explode("*", $S_QUICK_MENU_PIMG_SIZ_1);				
			$productMgr->setP_LNG($S_SITE_LNG);
			foreach($aryProdToday as $key => $prodToday) :
				if(!$prodToday) { continue; }
				if(($key+1) <= $startPoint) { continue; }
				if(sizeof($aryProdCode) >= $S_QUICK_MENU_LIST_CNT_1) { break; }
	
				$productMgr->setP_CODE($prodToday);
				$prodQuickRow = $productMgr->getProdView($db);
				if ($prodQuickRow['P_WEB_VIEW'] == "Y"){
					$aryProdCode[] = "'{$prodToday}'";

					$tagImg		= sprintf("<img src=\"%s\" class=\"quickProdImg\" style=\"width:".$aryQuickMenuProdImg[0]."px;height:".$aryQuickMenuProdImg[1]."px\"/>", $prodQuickRow['PM_REAL_NAME']);
					$tagLink	= sprintf("<a href=\"./?menuType=product&mode=view&act=list&prodCode=%s\">%s</a>", $prodQuickRow['P_CODE'], $tagImg);
					$tagLi		= sprintf("%s<li class=\"quickProdLi\">%s</li>\r\n", $tagLi, $tagLink);
				}
			endforeach;
						
			$strProdCode		= implode(",", $aryProdCode);
			if(!$strProdCode):
				// 사용자가 본 상품이 없는 경우.
				$result[0]['QUICK_PROD_LIST']		= $tagUl;
				$result_array						= json_encode($result);
				$db->disConnect();
				echo $callback."(".$result_array.")";
				exit;
			endif;

//			$productMgr->setP_CODE_ALL($strProdCode);
//			$productMgr->setP_WEB_VIEW("Y");
//			$prodResult			= $productMgr->getProdInfo($db);
		
			
//			while ($prodRow = mysql_fetch_array($prodResult)) : 
//				$tagImg		= sprintf("<img src=\"%s\" class=\"quickProdImg\" style=\"width:".$aryQuickMenuProdImg[0]."px;height:".$aryQuickMenuProdImg[1]."px\"/>", $prodRow['PM_REAL_NAME']);
//				$tagLink	= sprintf("<a href=\"./?menuType=product&mode=view&act=list&prodCode=%s\">%s</a>", $prodRow['P_CODE'], $tagImg);
//				$tagLi		= sprintf("%s<li class=\"quickProdLi\">%s</li>\r\n", $tagLi, $tagLink);
//			endwhile;
			

			$tagUl								= sprintf("<ul>%s</ul>", $tagLi);

			$result[0]['QUICK_PAGE_MAX']		= ceil(sizeof($aryProdToday) / $S_QUICK_MENU_LIST_CNT_1);
			$result[0]['QUICK_PROD_LIST']		= $tagUl;
			$result_array						= json_encode($result);
			$db->disConnect();
	//		echo $result_array;
			echo $callback."(".$result_array.")";
			exit;
		break;
		case "lNextPage":
		case "lPrevPage":
		case "lLoadPage":

			$strCodeAll		= "";
			$intPageLine	= 5;
			$intCodeAllLen  = 0;

			$arr = explode("/",$g_prod_today);	

	
			foreach ($arr as &$value) {
				if(strlen($value) > 0)
				{
					$strCodeAll .= "'". $value . "',";
					$intCodeAllLen++;
				}
			}		
			
			$strCodeAll = $intCodeAllLen > 0 ? substr($strCodeAll, 0, strlen($strCodeAll) - 1) : ""; 
			
			
			$productMgr->setM_NO($g_member_no);
			$productMgr->setP_CODE_ALL($strCodeAll);
			$prodResult = $productMgr->getProdInfo($db);

			$responseText	= "";

			//$responseText .= "<div class='btnListUp'><a><img src='/images/common/btn_quick_up.gif'/></a></div>";
			$responseText .= "<div class='slideList'>";
			$responseText .= "<ul class='prodList'>";
			
			if($intCodeAllLen>0)
			{
				while ($prodRow = mysql_fetch_array($prodResult)){
					$responseText .= "<li><a href='javascript:goProdView(".$prodRow[P_CODE].");'><img src='".$prodRow[PM_REAL_NAME]."' style='width:60px;height:90px;'/></a></li>" ;
				}
			}

			$intPageLine = $intPageLine < $intCodeAllLen ? $intPageLine : $intCodeAllLen;

			$responseText .= "</ul>";
			$responseText .= "</div>";
			//$responseText .= "<div class='btnListDown'><a><img src='/images/common/btn_quick_down.gif'/></a></div>";

			if($intCodeAllLen > $intPageLine)
				$responseText .= "<script type='text/javascript'>jQuery(function() {jQuery('.slideList').jCarouselLite({	btnNext: '.btnListUp',btnPrev: '.btnListDown',visible: ".$intPageLine.",speed: 300,circular: true,vertical: true});});</script>";

//			$responseText = $intCodeAllLen;

			echo $responseText;
			$db->disConnect();	
			exit;
		break;
		case "nextPage":
		case "prevPage":
		case "loadPage":
			/*-- 퀵 장바구니 리스트 가져오기 --*/

			$productMgr->setPB_KEY($g_cart_prikey);
			$productMgr->setM_NO($g_member_no);

			$intPageBlock	= 10;
			$intPageLine	= 3;													// 한번에 보여지는 아이템 수
			
			$productMgr->setPageLine($intPageLine);
			$intCartTotal	= $productMgr->getProdBasketTotal($db);					// 총 아이템 수
			$intCartTotPage	= ceil($intCartTotal / $productMgr->getPageLine());
	
			if(!$intCartPage || $intCartPage==0)
				$intCartPage = 1;
			else if($strAct=="nextPage" && $intCartPage < $intCartTotPage)
				$intCartPage = $intCartPage + 1;
			else if($strAct=="prevPage" && $intCartPage > 1)
				$intCartPage = $intCartPage - 1;
			
			if ($intCartTotal==0) {
				$intCartFirst	= 1;
				$intCartLast	= 0;			
			} else {
				$intCartFirst	= $intPageLine *($intCartPage -1);
				$intCartLast	= $intPageLine * $intCartPage;
			}

			$productMgr->setLimitFirst($intCartFirst);
	
			$cartResult		= $productMgr->getProdBasketList($db);
			/*-- 퀵 장바구니 리스트 가져오기 --*/

			$responseText	= "";

			while ($cartRow = mysql_fetch_array($cartResult)){
				$responseText .= "<div class='cartList'><ul><li>";
				$responseText .= "<img src='".$cartRow[PM_REAL_NAME]."' width=100 height=100 class='cartProdImg'/>";	
				$responseText .= "<dl><dd><a href='javascript:goProdView(".$cartRow[P_CODE].");'>".strConvertCut($cartRow[P_NAME],"22","N")."</a></dd>";
				$responseText .= "<dd class='priceInfo'><strong>".NUMBER_FORMAT($cartRow[PB_PRICE])." 원</strong> <a href='javascript:goQuickCartDel(\"cartDel\",".$cartRow[PB_NO].");'><img src='/images/bt_x.jpg'/></a></dd>";
//				$responseText .= "<dd class='priceInfo'><strong>".NUMBER_FORMAT($cartRow[PB_PRICE])." 원</strong> <a href='?menuType=Main&mode=json&act=cartDel'><img src='/images/bt_x.jpg'/></a></dd>";
				$responseText .= "</dl><div class='clear'></div></li></ul></div>";
					
			} 

			if($intCartTotal > 0)
			{
				$responseText .= "<span id='txtHint'></span>";
				$responseText .= "<ul class='quickBtn'>";
				$responseText .= "<li class='buyBtn'><a href='./?menuType=order&mode=cart'><img src='/images/bt_buy.jpg'/></a></li>";
				$responseText .= "<li class='nextBtn'>";
				if($intCartPage > 1)
					$responseText .= "<a href='javascript:goQuickMovePage(\"prevPage\",".$intCartPage.");'><img src='/images/bt_category_left.jpg'/></a>";
				if($intCartPage < $intCartTotPage)
					$responseText .= "<a href='javascript:goQuickMovePage(\"nextPage\",".$intCartPage.");'><img src='/images/bt_category_right.jpg'/></a>";
				$responseText .= "</li>";
				$responseText .= "</ul>";
			}

			echo $responseText;
			$db->disConnect();	
			exit;
		break;
		case "cartDel":
			
			$productMgr->setPB_NO($intNo);
			$productMgr->getProductBasketAddDelete($db);
			$productMgr->getProductBasketDelete($db);

//			$result_array = json_encode($result);

			echo  "Y";

			$db->disConnect();
			exit;
		break;

		case "topProdSearch":
			$productMgr->setSearchKey($strTopSearchKeyWord);
			$productMgr->getProdTopSearchWordInsertUpdate($db);

			$result[0][RET] = "Y";
			$result_array = json_encode($result);

		break;

		case "collectionEmailWrite":
			// 이메일 수집

			## 모듈 설정
			$objCollectionEmail			= new EmailCollectionModule($db);

			## 기본 설정
			$strEmail					= $_POST['email'];

			## 메일 유효성 체크
			if(!StringInfo::isEmailCheck($strEmail)):
				$result['__STATE__']	= "NO_EMAIL_TYPE";
				$result['__MSG__']		= $LNG_TRANS_CHAR["BS00100"]; // 이메일 형식이 아닙니다.
				break;
			endif;


			## 기본 설정 체크
			if(!$strEmail):
				$result['__STATE__']	= "NO_EMAIL";
				$result['__MSG__']		= $LNG_TRANS_CHAR["BS00101"]; // 이메일 주소를 입력하세요.
				break;
			endif;

			## 이메일 등록 여부 체크
			$param						= "";
			$param['EC_EMAIL']			= $strEmail;
			$intTotal					= $objCollectionEmail->getEmailCollectionSelectEx("OP_COUNT", $param);

			if($intTotal > 0):
				$result['__STATE__']	= "HAVE_EMAIL";
				$result['__MSG__']		= $LNG_TRANS_CHAR["BS00102"]; // 이미 등록되었습니다.
				break;				
			endif;
			
			## 이메일 등록
			$param						= "";
			$param['EC_EMAIL']			= $strEmail;
			$param['EC_REG_DT']			= "NOW()";
			$intRe						= $objCollectionEmail->getEmailCollectionInsertEx($param);
				
			## 마무리
			$result['__STATE__']			= "SUCCESS";		
		
		break;

		## 환율계산
		case "exchnageCal":
			$intExchangeMoney			= $_REQUEST["exchangeMoney"];
			if (!$intExchangeMoney) $intExchangeMoney = 1;

			$result[0]['RET']			= getCurMark()." ".getCurToPrice($intExchangeMoney).getCurMark2();
			$result_array = json_encode($result);
		break;

	}


	if(in_array($strAct, array("collectionEmailWrite","hostTypeModify"))):
		$db->disConnect();
		if(!$result) { $result = print_r($_POST, true); }
		echo json_encode($result);
		exit;
	endif;

	$db->disConnect();	
	echo $result_array;

	function rand_code($nc, $a='ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
		 $l = strlen($a) - 1; $r = '';
		 while($nc-->0) $r .= $a{mt_rand(0,$l)};
		 return $r;
	}
?>