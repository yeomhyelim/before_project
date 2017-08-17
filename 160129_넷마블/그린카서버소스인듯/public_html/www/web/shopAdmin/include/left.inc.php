<?
	switch($strMenuType):
	case "community":

		## 기본 설정
		$strAdminType						= $_SESSION['ADMIN_TYPE'];
		$strAdminTm							= $_SESSION['ADMIN_TM'];
		$strAdminShopList					= $_SESSION['ADMIN_SHOP_LIST'];
		$strShopMenuList					= array("S_NOTICE", "PROD_QNA", "PROD_REVIEW","S_REQ");
		$strLangS							= $S_ST_LNG; // 시작 언어(기준언어)
		$strLangSLower						= strtolower($strLangS);

		## conf 파일 설정
		$groupListFile				= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/groupList.info.php";
		$boardListFile				= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/boardList.info.php";

		if($S_COMMUNITY_VERSION == "V2.0"):
			$groupListFile			= MALL_SHOP . "/conf/community/{$strLangSLower}/groupList.info.php";
			$boardListFile			= MALL_SHOP . "/conf/community/{$strLangSLower}/boardList.info.php";
		endif;

		if(is_file($groupListFile)) { include $groupListFile; }
		if(is_file($boardListFile)) { include $boardListFile; }

		## 입점사인경우 메뉴 사용 안함.
		if($strAdminType == "S") { break; }

		## 최고관리자가 아니면 사용 안함.
		if($a_admin_no != 1) { break; }

		## 그룹 리스트
		$k							= 0;
		$aryMenuGroup				="";
		$aryMenuGroup[$k]			= "관리";
		$bCode						= $_REQUEST['b_code'];
		$strMode					= $strMode;

		## 메뉴 숨김 처리
		if(in_array($bCode, array("S_NOTICE", "S_REQ"))):
			break;
		endif;

		## 메뉴 리스트
		$s							= 0;
		/*  커뮤니티 관리 주석 처리. 남덕희 */
		if( $_SERVER['HTTP_HOST'] == 'localhost' ) {

			$aryMenu[$k][$s]['name'] = $LNG_TRANS_CHAR['BW00179'];//커뮤니티 관리
			$aryMenu[$k][$s]['url'] = "./?menuType=community&mode=boardList";
			$s++;

			$aryMenu[$k][$s]['name'] = $LNG_TRANS_CHAR['BW00180'];//커뮤니티 정지
			$aryMenu[$k][$s]['url'] = "./?menuType=community&mode=boardNonList";
			$s++;

			if ($S_COMMUNITY_VERSION == "V2.0"):
				$aryMenu[$k][$s]['name'] = $LNG_TRANS_CHAR['BW00181'];//커뮤니티 그룹
				$aryMenu[$k][$s]['url'] = "./?menuType=community&mode=groupList";
				$s++;
			else:
				$aryMenu[$k][$s]['name'] = $LNG_TRANS_CHAR['BW00181'];//커뮤니티 그룹
				$aryMenu[$k][$s]['url'] = "./?menuType=community&mode=groupWrite";
				$s++;
			endif;
		}

//		$aryMenu[$k][$s]['name']	= $LNG_TRANS_CHAR['BW00182']; //커뮤니티 아이콘
//		$aryMenu[$k][$s]['url']		= "./?menuType=community&mode=boardIconList";



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
		$intCntTotal				= sizeof($aryBoardList["-1"]);
		if($intCntTotal):
			$aryMenuGroup[$k]			= $LNG_TRANS_CHAR["BW00183"];//그룹미분류
			foreach($aryBoardList["-1"] as $key2 => $data2):
				$bCodeTemp					= $data2['b_code'];
				if(substr($bCodeTemp, 0, 2) == "S_") { continue; }

				$aryMenu[$k][$key2]['name']	= $data2['b_name'];
				$aryMenu[$k][$key2]['url']	= "./?menuType=community&mode=dataList&b_code={$bCodeTemp}";
			endforeach;
		endif;
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
			<li class="subMn"><a href="<?=$url?>"><?=$name?></a></li>
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
		<div class="subNavi">
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00001"] //기본설정?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=basic&mode=info"><?=$LNG_TRANS_CHAR["MM00002"] //쇼핑몰기본정보?></a></li>
					<li><a href="./?menuType=basic&mode=policy"><?=$LNG_TRANS_CHAR["MM00003"] //정책및약관관리?></a></li>
				</ul>
			</div>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00004"] //>운영/정책설?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=basic&mode=order"><?=$LNG_TRANS_CHAR["MM00005"] //주문/배송설정?></a></li>
					<!-- <li><a href="./?menuType=basic&mode=point"><?=$LNG_TRANS_CHAR["MM00006"] //적립금설정?></a></li> -->
					<!-- li><a href="./?menuType=basic&mode=coupon"><?=$LNG_TRANS_CHAR["MM00007"] //쿠폰설정?></a></li //-->
				</ul>
			</div>
			<? if($S_USE_LNG != "KR"): ?>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00010"] //환율설정?></div>
			<div class="naviList">
				<ul>
					<!-- li><a href="./?menuType=basic&mode=language"><?=$LNG_TRANS_CHAR["MM00009"] //사용언어?></a></li //-->
					<li><a href="./?menuType=basic&mode=exchange"><?=$LNG_TRANS_CHAR["MM00010"] //환율설정?></a></li>
				</ul>
			</div>
			<? endif;?>
			<? if($S_USE_LNG != "KR"): ?>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00011"] //배송요율관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=eumAdm&mode=deliveryList"><?=$LNG_TRANS_CHAR["MM00012"] //배송요율관리?></a></li>
					<li><a href="./?menuType=eumAdm&mode=countryList"><?=$LNG_TRANS_CHAR["MM00013"] //배송국가관리?></a></li>
				</ul>
			</div>
			<? endif;?>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00014"] //관리자관리?></div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=basic&mode=adminList"><?=$LNG_TRANS_CHAR["MM00015"] //관리자리스트?></a></li>
					<li><a href="./?menuType=basic&mode=adminList&searchStatus=9"><?=$LNG_TRANS_CHAR["MM00016"] //삭제리스트?></a></li>
					<li><a href="./?menuType=basic&mode=admin"><?=$LNG_TRANS_CHAR["MM00017"] //관리자비밀번호변경?></a></li>
				</ul>
			</div>
		</div>
	<?}?>
	<?//(2) 디자인 관리
		if(in_array($strMenuType, array("layout","layout_v2.0")))
		{?>
		<div class="subNavi">
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00039"] //레이아웃?></div>
			<div class="naviList">
				<ul>
					<!--
					<li><a href="./?menuType=layout&mode=skinSave"><?=$LNG_TRANS_CHAR["MM00040"] //세부페이지설정?></a></li>
					<li><a href="./?menuType=layout&mode=pageDesignSave&layoutPage=main&editPage=html&layoutView=edit&de_no=1"><?=$LNG_TRANS_CHAR["MM00041"] //HTML편집?></a></li>
					<li><a href="./?menuType=layout&mode=introSave"><?=$LNG_TRANS_CHAR["MM00042"] //첫화면 설정?></a></li>
					-->
					<li><a href="?menuType=layout&mode=sliderBannerList"><?=$LNG_TRANS_CHAR["MM00043"] //움직이는 배너?></a></li>
				</ul>
			</div>
			<!--
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00044"] //컨텐츠관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=layout&mode=contentList"><?=$LNG_TRANS_CHAR["MM00045"] //추가페이지?></a></li>
					<li><a href="./?menuType=layout&mode=contentWrite"><?=$LNG_TRANS_CHAR["MM00046"] //추가페이지등록?></a></li>
				</ul>
			</div>
			-->
		</div>
	<?}?>
	<?//(2) 회원관리
		$strNum = ($_POST['num']) ? $_POST['num'] : $_REQUEST['num'];
		if(($strMenuType=="member" && $strNum != "002") || $strMenuType == "sendpaper" || $strMenuType == "sendmail"|| $strMenuType == "sendsms")
		{

			?>
		<div class="subNavi">
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00018"] //회원관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=member&mode=memberList"><?=$LNG_TRANS_CHAR["MM00019"] //회원목록?></a></li>
					<li><a href="./?menuType=member&mode=memberList&searchOut=Y"><?=$LNG_TRANS_CHAR["MM00020"] //회원탈퇴/삭제내역?></a></li>
					<li><a href="./?menuType=member&mode=memberInsertWrite"><?=$LNG_TRANS_CHAR["MM00021"] //회원추가등록?></a></li>
					<!-- li><a href="./?menuType=member&mode=memberInsertExcelWrite"><?=$LNG_TRANS_CHAR["MM00022"] //회원대량등록?></a></li -->
				</ul>
			</div>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00023"] //그룹및가입관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=member&mode=group"><?=$LNG_TRANS_CHAR["MM00024"] //회원등급관리?></a></li>
					<li><a href="./?menuType=member&mode=setting"><?=$LNG_TRANS_CHAR["MM00025"] //회원가입관리?></a></li>
					<!-- li><a href="./?menuType=member&mode=joinItem"><?=$LNG_TRANS_CHAR["MM00026"] //회원가입 항목관리?></a></li -->
					<!-- li><a href="./?menuType=member&mode=memberEvent"><?=$LNG_TRANS_CHAR["MM00027"] //생일/기념일 관리?></a></li -->
				</ul>
			</div>

			<!--
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00028"] //포인트관리?></div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=member&mode=pointList"><?=$LNG_TRANS_CHAR["MM00028"] //포인트관리?></a></li>
					<!-- li><a href="./?menuType=member&mode=memberPointExcelWrite"><?=$LNG_TRANS_CHAR["MM00029"] //포인트 엑셀일괄지급?></a></li -->
					<!-- li><a href="./?menuType=member&mode=couponList"><?=$LNG_TRANS_CHAR["MM00030"] //쿠폰관리?></a></li>
					<li><a href="./?menuType=member&mode=couponWrite"><?=$LNG_TRANS_CHAR["MM00031"] //쿠폰생성?></a></li
				</ul>
			</div>
			-->

			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00032"] //메일/SMS?></div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=sendmail&mode=postMailList"><?=$LNG_TRANS_CHAR["MM00033"] //전체메일발송관리?></a></li>
					<li class="subMn"><a href="./?menuType=sendmail&mode=sendmail&lang=<?=$a_admin_lng?>"><?=$LNG_TRANS_CHAR["MM00037"] //메일관리?></a></>
					<li><a href="./?menuType=sendsms&mode=postSmsList"><?=$LNG_TRANS_CHAR["MM00034"] //SMS발송관리?></a></li>
					<!--li><a href="./?menuType=sendpaper&mode=postPaperList">쪽지전송관리</a></li-->
					<li class="subMn"><a href="./?menuType=sendsms&mode=autosms"><?=$LNG_TRANS_CHAR["MM00036"] //SMS관리?></a></li>

					<!-- li class="subMn"><a href="./?menuType=sendmail&mode=collectionEmail"><?=$LNG_TRANS_CHAR["MM00038"] //메일구독?></a></li //-->
				</ul>
			</div>
		</div>
	<?}?>

	<?//(3) 상품관리
		if($strMenuType=="product" || $strMenuType=="productEtc")
		{?>
		<div class="subNavi">
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00047"] //상품관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=product&mode=prodList"><?=$LNG_TRANS_CHAR["MM00048"] //판매상품목록?></a></li>
					<li><a href="./?menuType=product&mode=prodWrite"><?=$LNG_TRANS_CHAR["MM00049"] //상품신규등록?></a></li>
					<li><a href="./?menuType=product&mode=prodStockList"><?=$LNG_TRANS_CHAR["MM00050"] //일시/품절상품관리?></a></li>
					<!-- li><a href="./?menuType=product&mode=prodViewList"><?=$LNG_TRANS_CHAR["MM00051"] //상품출력관리?></a></li -->
					<!-- li><a href="./?menuType=product&mode=gift"><?=$LNG_TRANS_CHAR["MM00052"] //고객사은품관리?></a></li -->
					<!-- li><a href="./?menuType=product&mode=prodWishList"><?=$LNG_TRANS_CHAR["MM00053"] //WISH/CART목록조회?></a></li -->

				</ul>
			</div>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00054"] //상품부가관리?></div>
			<div class="naviList">
				<ul>
					<!-- li><a href="./?menuType=product&mode=prodDisplay"><?=$LNG_TRANS_CHAR["MM00055"] //진열장관리?></a></li -->
					<!-- li><a href="./?menuType=product&mode=prodRecList"><?=$LNG_TRANS_CHAR["MM00056"] //추천상품관리?></a></li -->
					<li><a href="./?menuType=product&mode=prodAtOneTimeWrite"><?=$LNG_TRANS_CHAR["MM00057"] //상품대량등록/수정?></a></li>
					<!-- li><a href="./?menuType=product&mode=prodEvent"><?=$LNG_TRANS_CHAR["MM00058"] //상품기간/할인관리?></a></li -->
				</ul>
			</div>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00059"] //카테고리관리?></div>
			<div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=product&mode=cateList"><?=$LNG_TRANS_CHAR["MM00059"] //카테고리관리?></a></li>
				</ul>
			</div>
			<!-- div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00060"] //기획전관리?></div //-->
			<!-- div class="naviList" style="border-bottom:none;">
				<ul>
					<li><a href="./?menuType=product&mode=prodPlanList"><?=$LNG_TRANS_CHAR["MM00061"] //기획전목록?></a></li>
					<li><a href="./?menuType=product&mode=catePlanList"><?=$LNG_TRANS_CHAR["MM00062"] //기획전카테고리?></a></li>
				</ul>
			</div //-->
			<!-- div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00063"] //브랜드관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=product&mode=prodBrandList"><?=$LNG_TRANS_CHAR["MM00063"] //브랜드관리?></a></li>
				</ul>
			</div //-->


			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00064"] //기타?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=productEtc&mode=siteCommList"><?=$LNG_TRANS_CHAR["MM00065"] //공통관리?></a></li>
					<li><a href="./?menuType=productEtc&mode=delRetHelp"><?=$LNG_TRANS_CHAR["MM00066"] //배송/반품교환 안내?></a></li>
				</ul>
			</div>

		</div>
	<?}?>

	<?//(4) 주문관리
		if($strMenuType=="order" || ($strMenuType=="member" && $strNum == "002") )
		{?>
		<div class="subNavi">
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00067"] //주문관리?></div>
			<div class="naviList">
				<ul>

					<li>
					<li><a href="./?menuType=order&mode=list"><?=$LNG_TRANS_CHAR["MM00068"] //주문리스트?></a></li>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=J"><?=$LNG_TRANS_CHAR["MM00069"] //무통장입금 관리?></a></li>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=C"><?=$LNG_TRANS_CHAR["MM00070"] //취소신청목록?></a></li>
					<!--li><a href="./?menuType=order&mode=list&searchOrderStatus=E">주문상담내역</a></li-->
					<?if($S_MEM_SMART_SEARCH == "Y"):?>
						<li><a href="./?menuType=member&mode=dataEdit&num=002">주문스마트쿼리</a></li>
					<?endif;?>
				</ul>
			</div>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00071"] //배송관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=order&mode=deliveryList"><?=$LNG_TRANS_CHAR["MM00072"] //송장입력목록?></a></li>
					<li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=I"><?=$LNG_TRANS_CHAR["MM00073"] //배송중목록?></a></li>
					<li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=D"><?=$LNG_TRANS_CHAR["MM00074"] //배송완료목록?></a></li>
					<!--li><a href="./?menuType=order&mode=deliveryFastInput">배송준비중목록</a></li-->
					<!--li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=B">배송준비목록</a></li-->
				</ul>
			</div>
			<!--div class="subMnTit">택배연동서비스</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="#">우체국택배안내/신청</a></li>
					<li><a href="#">우체국택배</a></li>
				</ul>
			</div-->
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00075"] //정산관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=E"><?=$LNG_TRANS_CHAR["MM00076"] //매확정목록?></a></li>
					<?if ($S_MALL_TYPE == "M"){?>
					<li><a href="./?menuType=order&mode=accList&searchAccStatus=N"><?=$LNG_TRANS_CHAR["MM00077"] //정산예정목록?></a></li>
					<li><a href="./?menuType=order&mode=accList&searchAccStatus=Y"><?=$LNG_TRANS_CHAR["MM00078"] //정산완료목록?></a></li>
					<?}?>
				</ul>
			</div>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00079"] //반품관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=R"><?=$LNG_TRANS_CHAR["MM00080"] //반품/교환신청목록?></a></li>
					<li><a href="./?menuType=order&mode=list&searchOrderStatus=T"><?=$LNG_TRANS_CHAR["MM00081"] //환불신청목록?></a></li>
				</ul>
			</div>
			<!--<div class="subMnTit">거래증빙서류관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="#">세금계산서신청관리</a></li>
					<li><a href="#">현금영수증신청관리</a></li>
				</ul>
			</div>//-->
			<!--div class="subMnTit">주문수기등록</div> -- 2013.06.24 kim hee sung 개발 미완, 숨김 처리
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=order&mode=selfOrderWrite">주문수기등록</a></li>
					<li><a href="./?menuType=order&mode=selfOrderList">수기주문목록</a></li>
					<li><a href="./?menuType=order&mode=addressList">주소록관리</a></li>
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
		<div class="subNavi">
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00085"] //운영관리?></div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=oper&mode=popupList"><?=$LNG_TRANS_CHAR["MM00086"] //팝업창관리?></a></li>
					<li class="subMn"><a href="./?menuType=oper&mode=bannerList"><?=$LNG_TRANS_CHAR["MM00087"] //배너관리?></a></li>
					<li class="subMn"><a href="./?menuType=oper&mode=adverList"><?=$LNG_TRANS_CHAR["MM00088"] //배너그룹관리?></a></li>
				</ul>
			</div>

		</div>
	<?}?>

	<?//(7) 통계관리
		if($strMenuType=="weblog")
		{?>
		<div class="subNavi">
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00089"] //방문자분석?></div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=weblog&mode=visitYear"><?=$LNG_TRANS_CHAR["MM00090"] //월별 방문자 분석?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=visitMonth"><?=$LNG_TRANS_CHAR["MM00091"] //일별 방문자 분석?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=visitDay"><?=$LNG_TRANS_CHAR["MM00092"] //시간별 방문자 분석?></a></li>
					<!-- li class="subMn"><a href="./?menuType=weblog&mode=visitHostKeyWord"><?=$LNG_TRANS_CHAR["MM00093"] //호스트별방문자분석?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=visitRefer"><?=$LNG_TRANS_CHAR["MM00094"] //질의어별방문자분석?></a></li //-->
					<li class="subMn"><a href="http://www.google.com/analytics/" target="_blank">구글분석</a></li>
				</ul>
			</div>
						<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00095"] //매출분석?></div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderMonthStatics"><?=$LNG_TRANS_CHAR["MM00096"] //월별매출분석?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderDayStatics"><?=$LNG_TRANS_CHAR["MM00097"] //일별매출통계?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderQuarterStatics"><?=$LNG_TRANS_CHAR["MM00098"] //분기별 매출통계?></a></li>
				</ul>
			</div>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00099"] //상품분석?></div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderProdCateStatics"><?=$LNG_TRANS_CHAR["MM00100"] //카테고리분석?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderProdStatics"><?=$LNG_TRANS_CHAR["MM00101"] //판매순위 분석?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=prodBasketStatics"><?=$LNG_TRANS_CHAR["MM00102"] //장바구니 분석?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=prodWishStatics"><?=$LNG_TRANS_CHAR["MM00103"] //상품보관함 분석?></a></li>
					<!--<li class="subMn"><a href="./?menuType=board&mode=dataList&bCode=NOTICE">검색어분석</a></li>//-->
				</ul>
			</div>
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00104"] //주문분석?></div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderDayStatics2"><?=$LNG_TRANS_CHAR["MM00105"] //일별 주문통계?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderMonthStatics2"><?=$LNG_TRANS_CHAR["MM00106"] //월별 주문통계?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderProdStatusStatics"><?=$LNG_TRANS_CHAR["MM00107"] //상품별 주문통계?></a></li>
					<?if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
						<li class="subMn"><a href="./?menuType=weblog&mode=orderMemberCateList">소속별 주문통계</a></li>
					<?}?>
					<!-- li class="subMn"><a href="./?menuType=weblog&mode=orderAgeStatics"><?=$LNG_TRANS_CHAR["MM00108"] //연령별 주문분석?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderAreaStatics"><?=$LNG_TRANS_CHAR["MM00109"] //지역별 주문분석?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=orderSexStatics"><?=$LNG_TRANS_CHAR["MM00110"] //성별 주문분석?></a></li -->
				</ul>
			</div>



			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00111"] //회원통계?></div>
			<div class="naviList">
				<ul>
					<li class="subMn"><a href="./?menuType=weblog&mode=memberRegStatics"><?=$LNG_TRANS_CHAR["MM00111"] //회원통계?></a></li>
					<!--<li class="subMn"><a href="./?menuType=weblog&mode=memberAreaStatics"><?=$LNG_TRANS_CHAR["MM00112"] //지역별통계?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=memberAgeStatics"><?=$LNG_TRANS_CHAR["MM00113"] //연령별통계?></a></li>
					<li class="subMn"><a href="./?menuType=weblog&mode=memberSexStatics"><?=$LNG_TRANS_CHAR["MM00114"] //성별통계?></a></li>-->
				</ul>
			</div>
		</div>
	<?}?>
	<?//(2) 디자인 설정
		if(($strMenuType=="seller") || ($_REQUEST['b_code'] == "S_NOTICE") || ($_REQUEST['b_code'] == "S_REQ"))
		{?>

		<div class="subNavi">
			<div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00082"] //입점업체관리?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=seller&mode=shopList"><?=$LNG_TRANS_CHAR["MM00082"] //입점업체관리?></a></li>
					<li><a href="./?menuType=seller&mode=shopWrite"><?=$LNG_TRANS_CHAR["MM00083"] //입점업체등록?></a></li>
					<?php if($S_MALL_TYPE == "M" && $S_SHOP_USER_APPLY_USE == "Y"):?>
					<li><a href="./?menuType=seller&mode=shopPolicy">입점사 약관관리</a></li>
					<?php endif;?>
				</ul>
			</div>
			<!-- div class="subMnTit"><?=$LNG_TRANS_CHAR["MM00084"] //입점업체공지?></div -->
			<div class="subMnTit"><?="입점업체문의사항" //입점업체문의사항?></div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=community&mode=dataList&b_code=S_NOTICE"><?=$LNG_TRANS_CHAR["MM00084"] //입점업체공지?></a></li>
					<li><a href="./?menuType=community&mode=dataList&b_code=S_REQ"><?="입점업체문의사항" //입점업체문의사항?></a></li>
				</ul>
			</div>
			<?/*
			<div class="subMnTit">입점업체 1:1문의</div>
			<div class="naviList">
				<ul>
					<li><a href="./?menuType=community&mode=dataList&b_code=S_REQ">입점업체 1:1문의</a></li>
				</ul>
			</div>
			*/?>
		</div>
	<?}?>
	<?//(4) 주문관리
		if($strMenuType=="orderM"|| ($strMenuType=="member" && $strNum == "002"))
		{?>
		<div class="subNavi">
			<div class="subMnTit">주문관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=orderM&mode=list">주문리스트</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=J">입금예정목록</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=E">구매확정목록</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=C">취소신청목록</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=R">반품/교환신청목록</a></li>
					<li><a href="./?menuType=orderM&mode=list&searchOrderStatus=T">환불신청목록</a></li>
					<!--li><a href="./?menuType=order&mode=list&searchOrderStatus=E">주문상담내역</a></li-->
					<?if($S_MEM_SMART_SEARCH == "Y"):?>
					<li><a href="./?menuType=member&mode=dataEdit&num=002">주문스마트쿼리</a></li>
					<?endif;?>
				</ul>
			</div>
			<div class="subMnTit">배송관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=order&mode=deliveryFastInput">배송준비중목록</a></li>
					<li><a href="./?menuType=order&mode=deliveryList">송장입력목록</a></li>
					<!--li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=B">배송준비목록</a></li-->
					<li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=I">배송중목록</a></li>
					<li><a href="./?menuType=order&mode=deliveryList&searchOrderStatus=D">배송완료목록</a></li>
				</ul>
			</div>
			<!--div class="subMnTit">택배연동서비스</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="#">우체국택배안내/신청</a></li>
					<li><a href="#">우체국택배</a></li>
				</ul>
			</div-->
			<?if ($S_MALL_TYPE == "M"){?>
			<div class="subMnTit">정산관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=order&mode=accList&searchAccStatus=N">정산예정목록</a></li>
					<li><a href="./?menuType=order&mode=accList&searchAccStatus=Y">정산완료목록</a></li>
				</ul>
			</div>
			<?}?>
			<!--<div class="subMnTit">거래증빙서류관리</div>
			<div class="naviList">
				<ul>
					<li>
					<li><a href="#">세금계산서신청관리</a></li>
					<li><a href="#">현금영수증신청관리</a></li>
				</ul>
			</div>//-->
			<!--div class="subMnTit">주문수기등록</div> -- 2013.06.24 kim hee sung 개발 미완, 숨김 처리
			<div class="naviList">
				<ul>
					<li>
					<li><a href="./?menuType=order&mode=selfOrderWrite">주문수기등록</a></li>
					<li><a href="./?menuType=order&mode=selfOrderList">수기주문목록</a></li>
					<li><a href="./?menuType=order&mode=addressList">주소록관리</a></li>
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
//입점사
}else{
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

		if (is_array($aryAdminLeftSubMenu)){

			for($j=0;$j<sizeof($aryAdminLeftSubMenu);$j++){

				if ($strTopMenuCode == "006" && $aryAdminLeftSubMenu[$j][MN_NO] == "6002"){

					$aryAdminComunityLeftGroupList	= getCommuityLeftGroupList($a_admin_no);
					$aryAdminLeftSubMenu2			= getTopLowMenuArray02($a_admin_no, $strTopMenuCode, $aryAdminLeftSubMenu[$j][MN_CODE], $menu_code="",$strAdmSiteLng);

					if (is_array($aryAdminComunityLeftGroupList)){
						for($p=0;$p<sizeof($aryAdminComunityLeftGroupList);$p++){
							if($strAdmSiteLng == "KR"){
								echo "<div class=\"subMnTit\">".$aryAdminComunityLeftGroupList[$p]['GROUP_NAME_KR']."</div>";
							}
							if($strAdmSiteLng == "US"){
								if($p == "0"){
									echo "<div class=\"subMnTit\">Operation Management</div>";
								}
								if($p == "1"){
									echo "<div class=\"subMnTit\">Product Inquiry</div>";
								}
								if($p == "2"){
									echo "<div class=\"subMnTit\">Customer</div>";
								}
								if($p == "3"){
									echo "<div class=\"subMnTit\">Others</div>";
								}
							}
							if($strAdmSiteLng == "CN"){
								if($p == "0"){
									echo "<div class=\"subMnTit\">运营管理</div>";
								}
								if($p == "1"){
									echo "<div class=\"subMnTit\">商品咨询</div>";
								}
								if($p == "2"){
									echo "<div class=\"subMnTit\">客服中心</div>";
								}
								if($p == "3"){
									echo "<div class=\"subMnTit\">其它</div>";
								}
							}

							if (is_array($aryAdminLeftSubMenu2)){
								echo "<div class=\"naviList\">";
								echo "<ul>";
								for($jj=0;$jj<sizeof($aryAdminLeftSubMenu2);$jj++){

									if ($aryMallAdminMenu[$aryAdminLeftSubMenu2[$jj][MN_NO]]["MN_GROUP_NO"] == $aryAdminComunityLeftGroupList[$p]['GROUP_CODE']){
										echo "<li><a href=\"".$aryMallAdminMenu[$aryAdminLeftSubMenu2[$jj][MN_NO]]["MN_URL"]."\">".$aryMallAdminMenu[$aryAdminLeftSubMenu2[$jj][MN_NO]]["MN_NAME_".$strAdmSiteLng]."</a></li>";
									}
								}
								echo "</ul>";
								echo "</div>";
							}
						}
					}

				} else {

					## 20150625 입점사관리자일 경우 카테고리 주석처리
					if($aryAdminLeftSubMenu[$j][MN_NO] != "40"){

						echo "<div class=\"subMnTit\">".$aryMallAdminMenu[$aryAdminLeftSubMenu[$j][MN_NO]]["MN_NAME_".$strAdmSiteLng]."</div>";

						$aryAdminLeftSubMenu2 = getTopLowMenuArray02($a_admin_no, $strTopMenuCode, $aryAdminLeftSubMenu[$j][MN_CODE], $menu_code="",$strAdmSiteLng);

						//echo "<!-- ".$db->query."<br>//-->";
						if (is_array($aryAdminLeftSubMenu2)){
							echo "<div class=\"naviList\">";
							echo "<ul>";
							for($jj=0;$jj<sizeof($aryAdminLeftSubMenu2);$jj++){
								if ($aryMallAdminMenu[$aryAdminLeftSubMenu2[$jj][MN_NO]]["MN_USE"] != "Y") continue;
								echo "<li><a href=\"".$aryMallAdminMenu[$aryAdminLeftSubMenu2[$jj][MN_NO]]["MN_URL"]."\">".$aryMallAdminMenu[$aryAdminLeftSubMenu2[$jj][MN_NO]]["MN_NAME_".$strAdmSiteLng]."</a></li>";
							}

							## 애협 소속관리자도 소속별주문리스트 보이게 처리
							if ($aryAdminLeftSubMenu[$j][MN_NO] == 92 && $S_FIX_MEMBER_CATE_USE_YN == "Y" && $a_admin_type != "S"){
								echo "<li><a href=\"?menuType=weblog&mode=orderMemberCateList\">소속별 주문통계</a></li>";
							}

							echo "</ul>";
							echo "</div>";
						} else {

							echo "<div class=\"naviList\">";
							echo "<ul>";
							echo "<li><a href=\"".$aryMallAdminMenu[$aryAdminLeftSubMenu[$j][MN_NO]]["MN_URL"]."\">".$aryMallAdminMenu[$aryAdminLeftSubMenu[$j][MN_NO]]["MN_NAME_".$strAdmSiteLng]."</a></li>";

							echo "</ul>";
							echo "</div>";
						}

					}


				}
			}
		}
		?>
	</div>
</div>
<?}?>

