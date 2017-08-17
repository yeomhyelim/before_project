<?
	switch($strMenuType):
	case "community":

		## conf 파일 설정
		$groupListFile				= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/groupList.info.php";
		$boardListFile				= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/boardList.info.php";
		if(is_file($groupListFile)) { include $groupListFile; }
		if(is_file($boardListFile)) { include $boardListFile; }

		## 기본 설정
		$strAdminType						= $_SESSION['ADMIN_TYPE'];
		$strAdminTm							= $_SESSION['ADMIN_TM'];
		$strAdminShopList					= $_SESSION['ADMIN_SHOP_LIST'];
		$strShopMenuList					= array("S_NOTICE", "PROD_QNA", "PROD_REVIEW");

		## 입점사인경우 메뉴 사용 안함.
		if($strAdminType == "S") { break; }

		## 그룹 리스트
		$k							= 0;
		$aryMenuGroup				="";
		$aryMenuGroup[$k]			= "관리";
		$$bCode						= $_REQUEST['b_code'];
		$strMode					= $strMode;

		## 메뉴 숨김 처리
		if(in_array($bCode, array("S_NOTICE", "S_REQ"))):
			break;
		endif;

		## 메뉴 리스트
		$s							= 0;

		$aryMenu[$k][$s]['name']	= "커뮤니티 관리";
		$aryMenu[$k][$s]['url']		= "./?menuType=community&mode=boardList";
		$s++;

		$aryMenu[$k][$s]['name']	= "커뮤니티 정지";
		$aryMenu[$k][$s]['url']		= "./?menuType=community&mode=boardNonList";
		$s++;

		$aryMenu[$k][$s]['name']	= "커뮤니티 그룹";
		$aryMenu[$k][$s]['url']		= "./?menuType=community&mode=groupWrite";

		## 커뮤니티 리스트 세팅
		$aryBoardList				= array();
		if($BOARD_LIST):
			foreach($BOARD_LIST as $key => $data):
				$bgNo				= $data['b_bg_no'];
				$bName				= $data['b_name'];
				$length				= sizeof($aryBoardList[$bgNo]);

				$aryBoardList[$bgNo][$length]['b_code']		= $key;
				$aryBoardList[$bgNo][$length]['b_name']		= $bName;
			endforeach;
		endif;

		## 커뮤니티 메뉴 설정
		if($GROUP_LIST):
			foreach($GROUP_LIST as $key => $data):
				$k++;
				$aryMenuGroup[$k]				= $data['bg_name'];
				$key							= (int)$key;
				foreach($aryBoardList[$key] as $key2 => $data2):
					$bCodeTemp					= $data2['b_code'];
					if(substr($bCodeTemp, 0, 2) == "S_") { continue; }

					$aryMenu[$k][$key2]['name']	= $data2['b_name'];
					$aryMenu[$k][$key2]['url']	= "./?menuType=community&mode=dataList&b_code={$bCodeTemp}";
				endforeach;
			endforeach;
		endif;

		## 커뮤니티 그룹 없음 설정
		$k++;
		$aryMenuGroup[$k]			= "그룹없음";
		foreach($aryBoardList["-1"] as $key2 => $data2):
			$bCodeTemp					= $data2['b_code'];
			if(substr($bCodeTemp, 0, 2) == "S_") { continue; }

			$aryMenu[$k][$key2]['name']	= $data2['b_name'];
			$aryMenu[$k][$key2]['url']	= "./?menuType=community&mode=dataList&b_code={$bCodeTemp}";
		endforeach;
	break;
	endswitch;
?>

<?if($aryMenuGroup):?>
<div class="subNavi">
	<?foreach($aryMenuGroup as $key => $data):?>
	<div class="subMnTit"><?=$data?></div>
	<?if($aryMenu[$key]):?>
	<div class="naviList">
		<ul>
			<?foreach($aryMenu[$key] as $key2 => $data2):
				$name			= $data2['name'];
				$url			= $data2['url'];		?>
			<li class="subMn"><a href="<?=$url?>">ㆍ<?=$name?></a></li>
			<?endforeach;?>
		</ul>
	</div>
	<?endif;?>
	<?endforeach;?>
</div>
<?endif;?>






<?
	if ($a_admin_level == 0){?>
<div id="leftArea">
	<?//(1) 쇼핑몰 기본설정
		if(in_array($strMenuType, array("basic","eumAdm")))
		{?>
		<img src="/shopAdmin/himg/common/tit_sub_basic.gif">
		<div class="subNavi">
			<div class="subMnTit">기본정보</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=basic&mode=info">ㆍ쇼핑몰기본정보</a></li>
					<li><a href="./?menuType=basic&mode=policy">ㆍ정책및약관관리</a></li>
				</ul>
			</div>
			<div class="subMnTit">운영/정책설정</div>
			<div class="naviList">
				<ul>
					<!--<li><a href="./?menuType=basic&mode=language">ㆍ사용언어</a></li>//-->
					<li><a href="./?menuType=basic&mode=order">ㆍ주문/배송설정</a></li>
					<li><a href="./?menuType=basic&mode=point">ㆍ적립금설정</a></li>
					<li><a href="./?menuType=basic&mode=coupon">ㆍ쿠폰설정</a></li>
				</ul>
			</div>
			<? if($S_USE_LNG != "KR"): ?>
			<div class="subMnTit">언어설정</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=basic&mode=language">ㆍ사용언어</a></li>
					<li><a href="./?menuType=basic&mode=exchange">ㆍ환율설정</a></li>
				</ul>
			</div>
			<? endif;?>
			<? if($S_USE_LNG != "KR"): ?>
			<div class="subMnTit">배송요율관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=eumAdm&mode=deliveryList">ㆍ배송요율관리</a></li>
					<li><a href="./?menuType=eumAdm&mode=countryList">ㆍ배송국가관리</a></li>
				</ul>
			</div>
			<? endif;?>
			<div class="subMnTit">관리자관리</div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=basic&mode=adminList">ㆍ관리자리스트</a></li>
					<li><a href="./?menuType=basic&mode=adminList&searchStatus=9">ㆍ삭제리스트</a></li>
					<li><a href="./?menuType=basic&mode=admin">ㆍ관리자비밀번호변경</a></li>
				</ul>
			</div>
		</div>
	<?}?>
	<?//(2) 회원관리
		$strNum = ($_POST['num']) ? $_POST['num'] : $_REQUEST['num'];
		if(($strMenuType=="member" && $strNum != "002") || $strMenuType == "sendpaper" || $strMenuType == "sendmail" || $strMenuType == "sendsms")
		{

			?>
		<img src="/shopAdmin/himg/common/tit_sub_member.gif">
		<div class="subNavi">
			<div class="subMnTit">회원관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=member&mode=memberList">ㆍ회원목록</a></li>
					<li><a href="./?menuType=member&mode=memberList&searchOut=Y">ㆍ회원탈퇴/삭제내역</a></li>
					<?if($S_MEM_SMART_SEARCH == "Y"):?>
					<li><a href="./?menuType=member&mode=dataEdit&num=001">ㆍ회원스마트쿼리</a></li>
					<?endif;?>
					<li><a href="./?menuType=member&mode=memberInsertWrite">ㆍ회원추가등록</a></li>
					<li><a href="./?menuType=member&mode=memberInsertExcelWrite">ㆍ회원대량등록</a></li>
				</ul>
			</div>
			<div class="subMnTit">그룹및가입관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=member&mode=group">ㆍ회원등급관리</a></li>
					<li><a href="./?menuType=member&mode=setting">ㆍ회원가입관리</a></li>
					<li><a href="./?menuType=member&mode=joinItem">ㆍ회원가입 항목관리</a></li>
					<li><a href="./?menuType=member&mode=memberEvent">ㆍ생일/기념일 관리</a></li>
					<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"):?>
					<li><a href="./?menuType=member&mode=memberCateList">ㆍ회원소속관리</a></li>
					<?endif;?>
				</ul>
			</div>
			<div class="subMnTit">포인트관리</div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=member&mode=pointList">ㆍ포인트관리</a></li>
					<li><a href="./?menuType=member&mode=memberPointExcelWrite">ㆍ포인트 엑셀일괄지급</a></li>
					<li><a href="./?menuType=member&mode=couponList">ㆍ쿠폰관리</a></li>
					<li><a href="./?menuType=member&mode=couponWrite">ㆍ쿠폰생성</a></li>
				</ul>
			</div>
			<div class="subMnTit">메일/SMS</div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=sendmail&mode=postMailList">ㆍ전체메일발송관리</a></li>
					<li><a href="./?menuType=sendsms&mode=postSmsList">ㆍSMS발송관리</a></li>
					<!--li><a href="./?menuType=sendpaper&mode=postPaperList">ㆍ쪽지전송관리</a></li-->
				</ul>
			</div>
			<div class="subMnTit">자동 SMS/메일관리</div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=sendsms&mode=autosms">ㆍSMS관리</a></li>
					<li class="subMn"><a href="./?menuType=sendmail&mode=sendmail&lang=<?=$a_admin_lng?>">ㆍ메일관리</a></li>
				</ul>
			</div>
		</div>
	<?}?>

	<?//(3) 상품관리
		if($strMenuType=="product" || $strMenuType=="productEtc")
		{?>
		<img src="/shopAdmin/himg/common/tit_sub_product.gif">
		<div class="subNavi">
			<div class="subMnTit">상품관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=product&mode=prodList">ㆍ판매상품목록</a></li>
					<li><a href="./?menuType=product&mode=prodWrite">ㆍ상품신규등록</a></li>
					<li><a href="./?menuType=product&mode=prodStockList">ㆍ일시/품절상품관리</a></li>
					<li><a href="./?menuType=product&mode=prodViewList">ㆍ상품출력관리</a></li>
					<li><a href="./?menuType=product&mode=gift">ㆍ고객사은품관리</a></li>
					<li><a href="./?menuType=product&mode=prodWishList">ㆍWISH/CART목록조회</a></li>

				</ul>
			</div>
			<div class="subMnTit">상품부가관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=product&mode=prodDisplay">ㆍ진열장관리</a></li>
					<li><a href="./?menuType=product&mode=prodRecList">ㆍ추천상품관리</a></li>
					<li><a href="./?menuType=product&mode=prodAtOneTimeWrite">ㆍ상품대량등록/수정</a></li>
					<li><a href="./?menuType=product&mode=prodEvent">ㆍ상품기간/할인관리</a></li>
				</ul>
			</div>
			<!--<div class="subMnTit">관련상품관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=product&mode=prodGrpList">ㆍ관련상품관리</a></li>
				</ul>
			</div>//-->
			<div class="subMnTit">카테고리관리</div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=product&mode=cateList">ㆍ카테고리관리</a></li>
				</ul>
			</div>
			<div class="subMnTit">기획전관리</div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=product&mode=prodPlanList">ㆍ기획전목록</a></li>
					<li><a href="./?menuType=product&mode=catePlanList">ㆍ기획전카테고리</a></li>
				</ul>
			</div>
			<div class="subMnTit">브랜드관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=product&mode=prodBrandList">ㆍ브랜드관리</a></li>
				</ul>
			</div>
			<div class="subMnTit">기타</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=productEtc&mode=siteCommList">ㆍ공통관리</a></li>
					<li><a href="./?menuType=productEtc&mode=delRetHelp">ㆍ배송/반품교환 안내</a></li>
					<?if($S_SHOP_NAME == "ceosb"):?>
					<li><a href="./?menuType=product&mode=ceosbInterviewList">ㆍCEO 김상 인터뷰 칼럼</a></li>
					<?endif;?>
				</ul>
			</div>
			<!--<div class="subMnTit">스크랩핑</div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=product&mode=scraping">ㆍ상품가져오기</a></li>
					<li><a href="./?menuType=product&mode=scripingAllList">ㆍ전체목록</a></li>
					<li><a href="./?menuType=product&mode=scrapingNonList">ㆍ적용목록</a></li>
					<li><a href="./?menuType=product&mode=scrapingAuthList">ㆍ미적용목록</a></li>
				</ul>
			</div>//-->
		</div>
	<?}?>

	<?//(4) 주문관리
		if($strMenuType=="order" || ($strMenuType=="member" && $strNum == "002") )
		{?>
		<img src="/shopAdmin/himg/common/tit_sub_order.gif">
		<div class="subNavi">
			<div class="subMnTit">주문관리</div>
			<div class="naviList">
				<ul>

					<li>
					<li><a href="./?menuType=order&mode=list">ㆍ주문리스트</a></li>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=J">ㆍ<?=$LNG_TRANS_CHAR["OW00153"] //무통장입금 관리?></a></li>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=C">ㆍ취소신청목록</a></li>
					<!--li><a href="./?menuType=order&mode=list&searchOrderStatus=E">ㆍ주문상담내역</a></li-->
					<?if($S_MEM_SMART_SEARCH == "Y"):?>
					<li><a href="./?menuType=member&mode=dataEdit&num=002">ㆍ주문스마트쿼리</a></li>
					<?endif;?>
					<?if ($S_MALL_TYPE != "M"){?>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=E">ㆍ구매확정목록</a></li>
					<?}?>
				</ul>
			</div>
			<div class="subMnTit">배송관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=order&mode=deliveryList">ㆍ송장입력목록</a></li>
					<li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=I">ㆍ배송중목록</a></li>
					<li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=D">ㆍ배송완료목록</a></li>
					<!--li><a href="./?menuType=order&mode=deliveryFastInput">ㆍ배송준비중목록</a></li-->
					<!--li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=B">ㆍ배송준비목록</a></li-->
				</ul>
			</div>
			<!--div class="subMnTit">택배연동서비스</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="#">ㆍ우체국택배안내/신청</a></li>
					<li><a href="#">ㆍ우체국택배</a></li>
				</ul>
			</div-->
			<?if ($S_MALL_TYPE == "M"){?>
			<div class="subMnTit">정산관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=E">ㆍ구매확정목록</a></li>
					<li><a href="./?menuType=order&mode=accList&searchAccStatus=N">ㆍ정산예정목록</a></li>
					<li><a href="./?menuType=order&mode=accList&searchAccStatus=Y">ㆍ정산완료목록</a></li>
				</ul>
			</div>
			<?}?>
			<div class="subMnTit">반품관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=R">ㆍ반품/교환신청목록</a></li>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=T">ㆍ환불신청목록</a></li>
				</ul>
			</div>
			<!--<div class="subMnTit">거래증빙서류관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="#">ㆍ세금계산서신청관리</a></li>
					<li><a href="#">ㆍ현금영수증신청관리</a></li>
				</ul>
			</div>//-->
			<!--div class="subMnTit">주문수기등록</div> -- 2013.06.24 kim hee sung 개발 미완, 숨김 처리
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=order&mode=selfOrderWrite">ㆍ주문수기등록</a></li>
					<li><a href="./?menuType=order&mode=selfOrderList">ㆍ수기주문목록</a></li>
					<li><a href="./?menuType=order&mode=addressList">ㆍ주소록관리</a></li>
				</ul>
			</div-->
			<?if ($SHOP_ADMIN_ADD_MENU_USE == "Y"){
				echo $SHOP_ADMIN_ADD_MENU_HTML["ORDER"];
				?>
			<?}?>
		</div>
	<?}?>
	<?//(6) 운영관리
		if($strMenuType=="oper" || $strMenuType == "operNew")
		{?>
		<img src="/shopAdmin/himg/common/tit_sub_manage.gif">
		<div class="subNavi">
			<div class="subMnTit">운영관리</div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=oper&mode=popupList">ㆍ팝업창관리</a></li>
					<li class="subMn"><a href="./?menuType=oper&mode=bannerList">ㆍ배너관리</a></li>
					<li class="subMn"><a href="./?menuType=oper&mode=adverList">ㆍ배너그룹관리</a></li>
				</ul>
			</div>

		</div>
	<?}?>

	<?//(7) 통계관리
		if($strMenuType=="weblog")
		{?>
		<img src="/shopAdmin/himg/common/tit_sub_static.gif">
		<div class="subNavi">
			<div class="subMnTit">방문자분석</div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="http://www.google.com/analytics/" target="_blank">ㆍ구글분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=visitYear">ㆍ월별 방문자 분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=visitMonth">ㆍ일별 방문자 분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=visitDay">ㆍ시간별 방문자 분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=visitHostKeyWord">ㆍ호스트별방문자분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=visitRefer">ㆍ질의어별방문자분석</a></li>
				</ul>
			</div>
						<div class="subMnTit">매출분석</div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderMonthStatics">ㆍ월별매출분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderDayStatics">ㆍ일별매출통계</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderQuarterStatics">ㆍ분기별 매출통계</a></li>
				</ul>
			</div>
			<div class="subMnTit">상품분석</div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderProdCateStatics">ㆍ카테고리분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderProdStatics">ㆍ판매순위 분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=prodBasketStatics">ㆍ장바구니 분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=prodWishStatics">ㆍ상품보관함 분석</a></li>
					<!--<li class="subMn"><a href="./?menuType=board&mode=dataList&bCode=NOTICE">ㆍ검색어분석</a></li>//-->
				</ul>
			</div>
			<div class="subMnTit">주문분석</div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderDayStatics2">ㆍ일별 주문통계</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderMonthStatics2">ㆍ월별 주문통계</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderProdStatusStatics">ㆍ상품별 주문통계</a></li>
					<?if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderMemberCateList">ㆍ소속별 주문통계</a></li>
					<?}?>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderAgeStatics">ㆍ연령별 주문분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderAreaStatics">ㆍ지역별 주문분석</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderSexStatics">ㆍ성별 주문분석</a></li>
				</ul>
			</div>
			<div class="subMnTit">회원통계</div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=weblog&mode=memberRegStatics">ㆍ회원통계</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=memberAreaStatics">ㆍ지역별통계</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=memberAgeStatics">ㆍ연령별통계</a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=memberSexStatics">ㆍ성별통계</a></li>
				</ul>
			</div>
		</div>
	<?}?>
	<?//(2) 디자인 설정
		if($strMenuType=="layout")
		{?>
		<img src="/shopAdmin/himg/common/tit_sub_design.gif">
		<div class="subNavi">
			<div class="subMnTit">레이아웃</div>
			<div class="naviList">
				<ul>
					<?if($S_LAYOUT_SETUP_USE == "Y"):?>
					<li><a href="./?menuType=layout&mode=layoutSave">ㆍ레이아웃 설정</a></li>
					<?endif;?>
					<li><a href="./?menuType=layout&mode=skinSave">ㆍ세부페이지설정</a></li>
					<li><a href="./?menuType=layout&mode=pageDesignSave&layoutPage=main&editPage=html&layoutView=edit&de_no=1">ㆍHTML편집</a></li>
					<li><a href="./?menuType=layout&mode=introSave">ㆍ첫화면 설정</a></li>
					<li><a href="?menuType=layout&mode=sliderBannerList">ㆍ움직이는 배너</a></li>
				</ul>
			</div>
			<div class="subMnTit">컨텐츠관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=layout&mode=contentList">ㆍ추가페이지</a></li>
					<li><a href="./?menuType=layout&mode=contentWrite">ㆍ추가페이지등록</a></li>
				</ul>
			</div>

		</div>
	<?}?>
	<?//(2) 디자인 설정
		if(($strMenuType=="seller") || ($_REQUEST['b_code'] == "S_NOTICE") || ($_REQUEST['b_code'] == "S_REQ"))
		{?>

		<div class="subNavi">
			<div class="subMnTit">입점업체관리</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=seller&mode=shopList">ㆍ입점업체관리</a></li>
					<li><a href="./?menuType=seller&mode=shopWrite">ㆍ입점업체등록</a></li>
				</ul>
			</div>
			<div class="subMnTit">입점업체공지</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=community&mode=dataList&b_code=S_NOTICE">ㆍ입점업체공지</a></li>
				</ul>
			</div>
			<?/*
			<div class="subMnTit">입점업체 1:1문의</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=community&mode=dataList&b_code=S_REQ">ㆍ입점업체 1:1문의</a></li>
				</ul>
			</div>
			*/?>
		</div>
	<?}?>
	<?//(4) 주문관리
		if($strMenuType=="orderM"|| ($strMenuType=="member" && $strNum == "002"))
		{?>
		<img src="/shopAdmin/himg/common/tit_sub_order.gif">
		<div class="subNavi">
			<div class="subMnTit">주문관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=orderM&mode=list">ㆍ주문리스트</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=J">ㆍ입금예정목록</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=E">ㆍ구매확정목록</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=C">ㆍ취소신청목록</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=R">ㆍ반품/교환신청목록</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=T">ㆍ환불신청목록</a></li>
					<!--li><a href="./?menuType=order&mode=list&searchOrderStatus=E">ㆍ주문상담내역</a></li-->
					<?if($S_MEM_SMART_SEARCH == "Y"):?>
					<li><a href="./?menuType=member&mode=dataEdit&num=002">ㆍ주문스마트쿼리</a></li>
					<?endif;?>
				</ul>
			</div>
			<div class="subMnTit">배송관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=order&mode=deliveryFastInput">ㆍ배송준비중목록</a></li>
					<li><a href="./?menuType=order&mode=deliveryList">ㆍ송장입력목록</a></li>
					<!--li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=B">ㆍ배송준비목록</a></li-->
					<li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=I">ㆍ배송중목록</a></li>
					<li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=D">ㆍ배송완료목록</a></li>
				</ul>
			</div>
			<!--div class="subMnTit">택배연동서비스</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="#">ㆍ우체국택배안내/신청</a></li>
					<li><a href="#">ㆍ우체국택배</a></li>
				</ul>
			</div-->
			<?if ($S_MALL_TYPE == "M"){?>
			<div class="subMnTit">정산관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=order&mode=accList&searchAccStatus=N">ㆍ정산예정목록</a></li>
					<li><a href="./?menuType=order&mode=accList&searchAccStatus=Y">ㆍ정산완료목록</a></li>
				</ul>
			</div>
			<?}?>
			<!--<div class="subMnTit">거래증빙서류관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="#">ㆍ세금계산서신청관리</a></li>
					<li><a href="#">ㆍ현금영수증신청관리</a></li>
				</ul>
			</div>//-->
			<!--div class="subMnTit">주문수기등록</div> -- 2013.06.24 kim hee sung 개발 미완, 숨김 처리
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=order&mode=selfOrderWrite">ㆍ주문수기등록</a></li>
					<li><a href="./?menuType=order&mode=selfOrderList">ㆍ수기주문목록</a></li>
					<li><a href="./?menuType=order&mode=addressList">ㆍ주소록관리</a></li>
				</ul>
			</div-->
			<?if ($SHOP_ADMIN_ADD_MENU_USE == "Y"){
				echo $SHOP_ADMIN_ADD_MENU_HTML["ORDER"];
				?>
			<?}?>
		</div>
	<?}?>

</div><!-- leftArea -->
<?
}else{
	/*
	switch($strTopMenuCode){
		case "001":
			$strSubMenuTitImg = "tit_sub_basic.gif";
		break;
		case "002":
			$strSubMenuTitImg = "tit_sub_design.gif";
		break;
		case "003":
			$strSubMenuTitImg = "tit_sub_member.gif";
		break;
		case "004":
			$strSubMenuTitImg = "tit_sub_product.gif";
		break;
		case "005":
			$strSubMenuTitImg = "tit_sub_order.gif";
		break;
		case "006":
			$strSubMenuTitImg = "tit_sub_community.gif";
		break;
		case "007":
			$strSubMenuTitImg = "tit_sub_manage.gif";
		break;
		case "008":
			$strSubMenuTitImg = "tit_sub_static.gif";
		break;
		case "009":
			$strSubMenuTitImg = "tit_sub_shop.gif";
		break;
		case "010":
			$strSubMenuTitImg = "tit_sub_order.gif";
		break;
		case "011":
			$strSubMenuTitImg = "tit_sub_community.gif";
		break;
	}*/

	switch($strTopMenuCode){
		case "001":
			$strSubMenuTitImg = "기본설정";
		break;
		case "002":
			$strSubMenuTitImg = "디자인관리";
		break;
		case "003":
			$strSubMenuTitImg = "회원관리";
		break;
		case "004":
			$strSubMenuTitImg = "상품관리";
		break;
		case "005":
			$strSubMenuTitImg = "주문관리";
		break;
		case "006":
			$strSubMenuTitImg = "커뮤니티관리";
		break;
		case "007":
			$strSubMenuTitImg = "운영관리";
		break;
		case "008":
			$strSubMenuTitImg = "통계관리";
		break;
		case "009":
			$strSubMenuTitImg = "입점관리";
		break;
		case "010":
			$strSubMenuTitImg = "주문관리";
		break;
	}

	$aryAdminLeftSubMenu = getTopLowMenuArray($a_admin_no, $strTopMenuCode,"",$strAdmSiteLng);

	?>
<div id="leftArea">
	<div class="subNavi">
		<?
		if ($strTopMenuCode == "006" && $aryAdminLeftSubMenu[$j][MN_NO] == "6002"){
			if (is_array($aryAdminLeftSubMenu)){

				for($j=0;$j<sizeof($aryAdminLeftSubMenu);$j++){



						$aryAdminComunityLeftGroupList	= getCommuityLeftGroupList($a_admin_no);
						$aryAdminLeftSubMenu2			= getTopLowMenuArray02($a_admin_no, $strTopMenuCode, $aryAdminLeftSubMenu[$j][MN_CODE], $menu_code="",$strAdmSiteLng);

						if (is_array($aryAdminComunityLeftGroupList)){
							for($p=0;$p<sizeof($aryAdminComunityLeftGroupList);$p++){
								echo "<div class=\"subMnTit\">".$aryAdminComunityLeftGroupList[$p]['GROUP_NAME_KR']."</div>";

								if (is_array($aryAdminLeftSubMenu2)){
									echo "<div class=\"naviList\">";
									echo "<ul>";
									for($jj=0;$jj<sizeof($aryAdminLeftSubMenu2);$jj++){
										if ($aryMallAdminMenu[$aryAdminLeftSubMenu2[$jj][MN_NO]]["MN_GROUP_NO"] == $aryAdminComunityLeftGroupList[$p]['GROUP_CODE']){
											echo "<li><a href=\"".$aryMallAdminMenu[$aryAdminLeftSubMenu2[$jj][MN_NO]]["MN_URL"]."\">ㆍ".$aryMallAdminMenu[$aryAdminLeftSubMenu2[$jj][MN_NO]]["MN_NAME_".$strAdmSiteLng]."</a></li>";
										}
									}
									echo "</ul>";
									echo "</div>";
								}
							}
						}

					}
			}
		} else {


			include "./include/adminLeftMenu".$a_admin_type.".inc.php";

			foreach($aryMallAdminLeftMenu as $leftMenuKey => $arrLeftMenu){
				$intLeftMenuCount = getTopLowMenuArray03($a_admin_no, $strTopMenuCode, $arrLeftMenu['SUB_MENU_NO'],$strAdmSiteLng);
				if ($intLeftMenuCount > 0){
					$intLeftMenuNo = $arrLeftMenu[MN_NO];

					echo "<div class=\"subMnTit\">".$aryMallAdminMenu[$intLeftMenuNo]["MN_NAME_".$strAdmSiteLng]."</div>";
					echo "<div class=\"naviList\">";
					echo "<ul>";

					foreach($aryMallAdminLeftSubMenu[$intLeftMenuNo] as $leftMenuSubKey => $arrLeftSubMenu){
						$intLeftSubMenuNo		= $arrLeftSubMenu['MN_NO'];
						$intLeftSubMenuCount	= getTopLowMenuArray03($a_admin_no, $strTopMenuCode, $intLeftSubMenuNo,$strAdmSiteLng);
						if ($intLeftSubMenuCount > 0){
							echo "<li><a href=\"".$aryMallAdminMenu[$intLeftSubMenuNo]["MN_URL"]."\">ㆍ".$aryMallAdminMenu[$intLeftSubMenuNo]["MN_NAME_".$strAdmSiteLng]."</a></li>";
						}
					}

					echo "</ul>";
					echo "</div>";
				}
			}
		}
		?>
	</div>
</div>
<?}?>

