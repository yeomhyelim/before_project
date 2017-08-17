<?php
	## 1차 메뉴 설정
	$strMenu1 = "close";
	$strMenu2 = "close";
	$strMenu3 = "close";
	if($strMenuType == "product") { $strMenu1 = "open"; }
	else if($strMenuType == "community") { $strMenu2 = "open"; }
	else if(in_array($strMenuType, array("mypage", "member"))) { $strMenu3 = "open"; }
	else { $strMenu1 = "open"; }

	## 기본 설정
	$strSiteLng = $S_SITE_LNG;
	$aryUseLng = explode("/", $S_USE_LNG);

	$aryLngName['KR'] = "Korean";
	$aryLngName['AU'] = "English";
	$aryLngName['CN'] = "Chinese";
	$aryLngName['JP'] = "Japanese";
	$aryLngName['RU'] = "Russian";
	$aryLngName['US'] = "USA";

	## 언어 설정
	$aryDDSlickData = "";
	$strUseLngOption= "";
	foreach($aryUseLng as $key => $lng):
		$strUseLngOption .= "<option value=\"".$lng."\" ";
		$strUseLngOption .= ($strSiteLng == $lng) ? "selected" : "";
		$strUseLngOption .= ">".$aryLngName[$lng]."</option>";
	endforeach;

?>
<script type="text/javascript" language="javascript">
	function siteLngChange(){

		var data		= new Object();
		var strParam	= G_PHP_PARAM;
		var langSelect = $("#lang option:selected").val();
		 langSelect =  langSelect.toUpperCase();
		data["lang"] = langSelect;
		C_getAddLocationUrl(data);
	}
</script>
<div class="cateListWrap">
	<div class="cateListTopBox" id="topWrap">
		<h1><a href="/"><img src="<?php echo $S_MOB_LOGO_IMG;?>" alt="136601"></a></h1>
		<div class="langBox">
			<div class="lang">
				<select id="lang" name="lang" onchange="javascript:siteLngChange();">
					<?=$strUseLngOption?>
				</select>
			</div>
			<a href="#page" class="btnSClose"><img src="/upload/images/btn_m_close.png"/></a>
		</div>
		<div class="clr"></div>
	</div>
		
	<div class="subTit">
		<ul>
			<li data-mouseEnter-show2="menu1" class="<?php echo  $strMenu1;?>"><a href="#"><?=$LNG_TRANS_CHAR["CW00064"]//카테고리?></a></li>
			<li data-mouseEnter-show2="menu2" class="<?php echo  $strMenu2;?>"><a href="#"><?=$LNG_TRANS_CHAR["CW00043"]//고객센터?></a></li>
			<li data-mouseEnter-show2="menu3" class="<?php echo  $strMenu3;?>"><a href="#"><?=$LNG_TRANS_CHAR["MW00048"]//마이페이지?></a></li>
		</ul>
		<div class="clr"></div>
	</div>

	<div id="menu1" group="menu" style="<?php if($strMenu1 == "close"){echo "display:none";}?>">
		<?php
		$EUMSHOP_APP_INFO				= "";
		$EUMSHOP_APP_INFO['name']		= "상품카테고리";
		$EUMSHOP_APP_INFO['mode']		= "productCateMenu";
		$EUMSHOP_APP_INFO['skin']		= "styleFixed3Skin";
		$EUMSHOP_APP_INFO['selectCate']	= "";
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
		?>
	</div>
	<div id="menu2" group="menu" style="<?php if($strMenu2 == "close"){echo "display:none";}?>">
		<div class="cate1-wrap">
			<ul class="cateList">
				<li class="cate1"><a href="./?menuType=html&mode=customer"><?=$LNG_TRANS_CHAR["PW00093"]//전화문의?></a></li>
				<li class="cate1"><a href="./?menuType=community&mode=dataWrite&b_code=MY_QNA"><?=$LNG_TRANS_CHAR["CW00023"]//1:1문의?></a></li>
				<li class="cate1"><a href="./?menuType=community&mode=dataList&b_code=FAQ"><?=$LNG_TRANS_CHAR["CW00106"]//자주묻는 질문?></a></li>
				<li class="cate1"><a href="./?menuType=html&mode=bInfo"><?=$LNG_TRANS_CHAR["CW00107"]//입점 및 제휴안내?></a></li>
				<li class="cate1"><a href="./?menuType=shop&mode=shopApplyReg"><?=$LNG_TRANS_CHAR["CW00108"]//입점신청?></a></li>
				<li class="cate1"><a href="./?menuType=community&mode=dataList&b_code=NOTICE"><?=$LNG_TRANS_CHAR["CW00105"]//공지사항?></a></li>
				<li class="cate1"><a href="./?menuType=html&mode=info"><?=$LNG_TRANS_CHAR["CW00110"]//136601 소개?></a></li>
			</ul>
		</div>
	</div>
	<div id="menu3" group="menu" style="<?php if($strMenu3 == "close"){echo "display:none";}?>">
		<div class="cate1-wrap">
			<ul class="cateList">
				<?php if($g_member_no && $g_member_login): // 로그인?>
					<li><a href="/?menuType=mypage&mode=buyList"><span><?=$LNG_TRANS_CHAR["CW00017"]//주문내역?></span></a></li>					
					<li><a href="/?menuType=mypage&mode=cartMyList"><span><?=$LNG_TRANS_CHAR["CW00040"]//장바구니?></span></a></li>
					<li><a href="/?menuType=mypage&mode=wishMyList"><span><?=$LNG_TRANS_CHAR["CW00041"]//담아둔 목록?></span></a></li>
					<li><a href="./?menuType=community&mode=dataList&b_code=PROD_QNA"><span><?= $LNG_TRANS_CHAR["CW00024"]; //상품Q&A ?></span></a></li>
					<li><a href="./?menuType=community&mode=dataList&b_code=MY_QNA"><span><?= $LNG_TRANS_CHAR["CW00023"]; //1:1문의 ?></span></a></li>
					<li><a href="/?menuType=mypage&mode=myInfo"><span><?=$LNG_TRANS_CHAR["CW00015"]//내정보관리?></span></a></li>
					<li><a href="/?menuType=member&mode=act&act=logout"><span><?=$LNG_TRANS_CHAR["CW00049"]//로그아웃?></span></a></li>
				<?php else: // 로그아웃?>
					<li><a href="/?menuType=member&mode=login"><span><?=$LNG_TRANS_CHAR["CW00017"]//주문내역?></span></a></li>					
					<li><a href="/?menuType=mypage&mode=cartMyList"><span><?=$LNG_TRANS_CHAR["CW00040"]//장바구니?></span></a></li>
					<li><a href="/?menuType=mypage&mode=wishMyList"><span><?=$LNG_TRANS_CHAR["CW00041"]//담아둔 목록?></span></a></li>
					<li><a href="./?menuType=community&mode=dataList&b_code=PROD_QNA"><span><?= $LNG_TRANS_CHAR["CW00024"]; //상품Q&A ?></span></a></li>
					<li><a href="./?menuType=community&mode=dataList&b_code=MY_QNA"><span><?= $LNG_TRANS_CHAR["CW00023"]; //1:1문의 ?></span></a></li>
					<li><a href="/?menuType=member&mode=login"><span><?=$LNG_TRANS_CHAR["CW00015"]//내정보관리?></span></a></li>
					<li><a href="/?menuType=member&mode=login"><span><?=$LNG_TRANS_CHAR["CW00045"]//로그인?></span></a></li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>
<div class="clr"></div>
