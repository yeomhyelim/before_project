<?

	require_once MALL_CONF_MYSQL;
	require_once MALL_CONF_FILE;
	require_once MALL_COMM_LIB;
	require_once MALL_CONF_TBL;

	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."AdminMgr.php";
	require_once MALL_CONF_LIB."ShopMgr.php";

	require_once "../conf/admin.menu.inc.php";
	require_once "../conf/shop.inc.php";

	$memberMgr = new MemberMgr();
	$adminMgr = new AdminMgr();
	$shopMgr = new ShopMgr();

	$strMode		= $_POST["mode"]							? $_POST["mode"]							: $_REQUEST["mode"];	
	$strAutoLoginId = $_COOKIE["COOKIE_ADM_SHOP_AUTO_LOGIN"]	? $_COOKIE["COOKIE_ADM_SHOP_AUTO_LOGIN"]	: "";
	
	if ($strMode == "admLogin"){
		
		$db->connect();
		
		$strLOGIN_ID	= $_POST["id"]				? $_POST["id"]				: $_REQUEST["id"];
		$strLOGIN_PWD	= $_POST["pass"]			? $_POST["pass"]			: $_REQUEST["pass"];	
		$strAutoLogin	= $_POST["chkAutoLogin"]	? $_POST["chkAutoLogin"]	: $_REQUEST["chkAutoLogin"];	
						
		$strLOGIN_ID	= strTrim($strLOGIN_ID,50);
		$strLOGIN_PWD	= strTrim($strLOGIN_PWD,100);

		if ($strAutoLogin == "Y"){
			setCookie("COOKIE_ADM_SHOP_AUTO_LOGIN",$strLOGIN_ID,time()+(86400 * 30),"/shopAdmin");
		} else {
			setCookie("COOKIE_ADM_SHOP_AUTO_LOGIN","",time()-86400,"/shopAdmin");
		}

		if ($S_MEM_CERITY == "1") $memberMgr->setM_ID($strLOGIN_ID);
		else $memberMgr->setM_MAIL($strLOGIN_ID);
		$memberMgr->setM_PASS($strLOGIN_PWD);

		$row = $memberMgr->getMemberInfo($db);
		if ($row){
			if ($memberMgr->getMemberPwdCheck($db) > 0){

				$strUrl = "./?menuType=main&mode=memberList";
				
				if ($row[G_LEVEL] < 1 || $row[G_LEVEL] == 9){
					goErrMsg("샵관리자로 로그인 후 이용하세요.");
					exit;
				}
				
				$shopMgr->setM_NO($row[M_NO]);
				$intUserNo = $shopMgr->getShopUserNo($db);
				if ($intUserNo <= 0) {
					goErrMsg("샵관리자로 로그인 할 수 없습니다..");
					exit;
				}
                
                
				$shopMgr->setSU_NO($intUserNo);
				$shopRow = $shopMgr->getShopUserView($db);
				if ($shopRow[SU_USE] == "N"){
					goErrMsg("사용할 수 없는 관리자입니다.");
					exit;				
				}
					
				$adminMgr->setM_NO($row[M_NO]);
				$adminMgr->setAM_TYPE("S");
				$aryAdminTopMenu = $adminMgr->getLoginMenuUrl($db);
				if (!is_array($aryAdminTopMenu)) {
					goErrMsg("메뉴 설정이 되지 않은 관리자입니다.");
					exit;
				}
				

				$strUrl			= "";
				$strMenuUrlSkip = "N";
				for($i=0;$i<sizeof($aryMallAdminLMenu);$i++){
					if (is_array($aryAdminTopMenu)){

						/* 메인화면 추가(각 쇼핑몰 관리자메뉴권한에 정렬이 포함되지 않음 */
						for($j=0;$j<sizeof($aryAdminTopMenu);$j++){
							if ($aryAdminTopMenu[$j][MN_NO] == 167) {
								$strUrl = "./?menuType=main&mode=memberList";
								$strMenuUrlSkip = "Y";
								break;
							}
						}

							if ($strMenuUrlSkip == "N"){
        						for($j=0;$j<sizeof($aryAdminTopMenu);$j++){
        							if ($aryAdminTopMenu[$j][MN_NO] == $aryMallAdminLMenu[$i][MN_NO] && $aryMallAdminMenu[$aryAdminTopMenu[$j][MN_NO]][MN_USE] == "Y"){
        								
//         								$adminMgr->setMN_HIGH_01($aryAdminTopMenu[$j][MN_CODE]);
//         								$aryAdminTopSubMenu1 = $adminMgr->getLoginLowMenuArray($db);
        								
//         								$adminMgr->setMN_HIGH_02($aryAdminTopSubMenu1[0][MN_CODE]);
//         								$aryAdminTopSubMenu2 = $adminMgr->getLoginLowMenuArray02($db);
        								
//         								if (is_array($aryAdminTopSubMenu2)){
// 											$strUrl = $aryMallAdminMenu[$aryAdminTopSubMenu2[0][MN_NO]][MN_URL];
// 											break;
//         								}else{
// 											$strUrl = $aryMallAdminMenu[$aryAdminTopSubMenu1[0][MN_NO]][MN_URL];
// 											break;
//         								}
        								$strUrl = $aryMallAdminLMenu[$i][MN_URL];
        								
        							}
        						}
                            }
					}
					
					if ($strUrl) break;
				}
				
				## 입점사 국가별 언어설정
				//$intSH_NO = $shopMgr->getShopUserNo($db);
				$shopMgr->setSH_NO($shopRow[SH_NO]);
				$shopViewRow = $shopMgr->getShopView($db);
				$strCountryLng = $shopViewRow[SH_COM_COUNTRY];
				$arrTopSiteUseLng	= explode("/",$S_USE_LNG); 
				if (in_array($strCountryLng,$arrTopSiteUseLng)){
					$strShopLng = $strCountryLng;
				}else{
					$strShopLng = 'US';
				}

				$_SESSION["ADMIN_LOGIN"]	= true;
				$_SESSION["ADMIN_ID"]		= $row[M_ID];
				$_SESSION["ADMIN_MAIL"]		= $row[M_MAIL];
				$_SESSION["ADMIN_NAME"]		= $row[M_NAME];
				$_SESSION["ADMIN_LEVEL"]	= ($shopRow[SU_TYPE]=="A") ? "3":"4";
				$_SESSION["ADMIN_NO"]		= $row[M_NO];
				$_SESSION["ADMIN_IP"]		= $S_REOMTE_ADDR;
				//입점사 국가별 언어설정
				//$_SESSION["ADMIN_LNG"]		= $S_ST_LNG;
				$_SESSION["ADMIN_LNG"]		= $strShopLng;
				$_SESSION["ADMIN_TYPE"]		= "S";
				$_SESSION["ADMIN_SHOP_NO"]	= $shopRow[SH_NO];
				$_SESSION['ADMIN_MAIN_USE']	= $strMenuUrlSkip;


				
				/* 관리자 메뉴 update 
				$xml_string = file_get_contents("http://www.eumshop.com/api/xml/shop.lang.version.xml.php");
				$xml = simplexml_load_string($xml_string);
				
				if ($xml->adminVersion != $MALL_ADMIN_MENU_VERSION){
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, 'http://www.eumshop.com/api/php/shop.lang.menu.php');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$data = curl_exec($ch);

					curl_close($ch);
					
					$file = "../conf/admin.menu.inc.php";
					@chmod($file,0755);
					$fw = fopen($file, "w");
					fputs($fw,$data, strlen($data));
					fclose($fw);
				}
				 관리자 메뉴 update */

				$db->disConnect();
                if($strUrl){
                    goUrl("",$strUrl);
                }else{
                    goErrMsg("메뉴 설정이 필요합니다.","./sellerLogin.php");
                }
				
				exit;
			} else {
				goUrl("비밀번호가 일치하지 않습니다.","./sellerLogin.php");
				exit;
			}
		} else {
			goErrMsg("존재하지 않는 아이디입니다.","./sellerLogin.php");
			exit;
		}
		$db->disConnect();
	} else if ($strMode == "shopAdmLogout") {

		$_SESSION["ADMIN_LOGIN"]	= false;
		$_SESSION["ADMIN_ID"]		= "";
		$_SESSION["ADMIN_MAIL"]		= "";
		$_SESSION["ADMIN_NAME"]		= "";
		$_SESSION["ADMIN_LEVEL"]	= "-1";
		$_SESSION["ADMIN_NO"]		= "";
		$_SESSION["ADMIN_IP"]		= "";
		$_SESSION["ADMIN_LNG"]		= "";
		$_SESSION["ADMIN_TYPE"]		= "";
		$_SESSION["ADMIN_SHOP_NO"]	= "";

		/*setCookie("ADMIN_LOGIN",false,time()-86400,"/shopAdmin");
		setCookie("ADMIN_ID","",time()-86400,"/shopAdmin");
		setCookie("ADMIN_NAME","",time()-86400,"/shopAdmin");
		setCookie("ADMIN_LEVEL","",time()-86400,"/shopAdmin");
		setCookie("ADMIN_NO","",time()-86400,"/shopAdmin");
		setCookie("ADMIN_IP","",time()-86400,"/shopAdmin");
		*/
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>:: 로그인 ::</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="ROBOTS" content="no" />
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<META NAME="GOOGLEBOT" CONTENT= "NOINDEX, NOFOLLOW">

	<link rel="stylesheet" type="text/css" href="./common/css/layout.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/button.css"/>

	<script language="javascript" type="text/javascript" src="../common/js/jquery-1.7.2.min.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/toggle.checkbox.js"></script>

	<script language="javascript">
		function goLogin(){
			doc = document.form;

			if (doc.id.value == "")
			{
				alert("아이디를 입력하세요.");
				doc.id.focus();
				return;
			}

			if (doc.pass.value == "")
			{
				alert("비밀번호를 입력하세요.");
				doc.pass.focus();
				return;
			}
			
			doc.action = "";
			doc.submit();
		}
	</script>
  <!-- toggle for checkbox -->
  <script type="text/javascript" charset="utf-8">
    $(window).load(function() {
      $('.on_off :checkbox').iphoneStyle();
      
      var onchange_checkbox = ($('.onchange :checkbox')).iphoneStyle({
        onChange: function(elem, value) { 
          $('span#status').html(value.toString());
        }
      });
      
      setInterval(function() {
        onchange_checkbox.prop('checked', !onchange_checkbox.is(':checked')).iphoneStyle("refresh");
        return
      }, 2500);
    });
  </script>

</head>
<body  style="background: #e4f6ff url(/shopAdmin/himg/login/bg_login.gif) left top repeat;" onLoad="document.form.id.focus()" >
	<!-- div class="loginTop">
		<h1><img src="/shopAdmin/himg/login/logo_login.gif"/></h1>
		<div class="qnaEumshop">이음샵에 대해 더 알고싶으신가요? <a href="http://eumshop.co.kr/customer/?bCode=QNA&mode=write" target="_blank">1:1 쇼핑몰 상담</a></div>
		<div class="clear"></div>
	</div -->
	<div class="titleImgWrap"><img src="/shopAdmin/himg/login/tit_login.png"/></div>
			<div class="loginWrap">
				<div class="loginForm">	
						<?php if($S_MALL_TYPE == "M"):?>
							<div class="loginTabBox">
								<a href="./login.php"><strong>Master Login</strong></a>
								<a href="./sellerLogin.php" class="on"><strong>Seller Login</strong></a>
							</div>
						<?php endif;?>
						

						<form name="form" method="post">
						<input type="hidden" name="mode" value="admLogin">
						<ul>
							<li><input type="text" name="id" id="id" value="<?=$strAutoLoginId?>" tabindex="1" onkeydown="if(event.keyCode==13) document.form.pass.focus();" onFocus="this.className='input_focus'" onBlur="if ( this.value == '' ) { this.className='input_id_blur' }" class="input_id_blur"/></li>
							<li><input type="password" name="pass" id="pass" value="<?=$strTestPwd?>" tabindex="2" onkeydown="if(event.keyCode==13) goLogin();"  onFocus="this.className='input_focus'" onBlur="if ( this.value == '' ) { this.className='input_pw_blur' }" class="input_pw_blur"/></li>
							<li><a href="javascript:goLogin();" class="btns"><img src="/shopAdmin/himg/login/btn_login.png" tabindex="3"/></a></li>
							<li><span class="on_off"><input type="checkbox" name="chkAutoLogin" tabindex="4" id="on_off" value="Y" <?=($strAutoLoginId)?"checked":"";?>/></span> <label class="on_txt">Save ID</label></li>
						</ul>
						</form>
				</div><!-- loginForm -->
			</div><!-- loginWrap-->

			<div class="loginCopyright">Copyrightⓒ PROFITY. All Rights Reserved.</div>
</body>
</html>