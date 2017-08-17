<?
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
	
	$memberMgr = new MemberMgr();
	$productMgr = new ProductMgr();

	$strFaceBookLoginUrl = $facebook->getLoginUrl(array(
		'scope' => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown,user_photos,publish_actions,read_stream,friends_likes'
	));
	if ($strFaceBookUserId) { 

		try {
			
			$_facebook_user_profile = $facebook->api('/me'); // 유저 프로필을 가져 옵니다.
			
			if (is_array($_facebook_user_profile)){
			
				$memberMgr->setM_FACEBOOK_ID($_SESSION[$_facebook_user_id]);
				$memberMgr->setM_FACEBOOK_TOKEN($_SESSION[$_facebook_access_token]);
				$facebookRow = $memberMgr->getFaceBookLogin($db);

				$strFaceBookErrNo = "99999";
				if ($g_member_login && $g_member_id){
					
					/* 이미 로그인이 되어있고 페이스북 자동로그인을 사용할 회원 */
					if (!$facebookRow) { 
						$memberMgr->setM_NO($g_member_no);
						$memberMgr->getMemberFaceBookUpdate($db);
					
						$_SESSION[SESS_MEMBER_FACEBOOK_LOGIN]	= true;
					
						$strFaceBookErrNo = "00000";
					}

				} else {
					
					if (!is_array($facebookRow)) { 

						if ($_facebook_user_profile["email"]){

							$memberMgr->setM_MAIL($_facebook_user_profile["email"]);
							$intMailCount	= $memberMgr->getMemberMailCheck($db);
							
							// 아이디 체크
							$strM_ID		= explode("@", $_facebook_user_profile["email"]);
							$strM_ID		= $strM_ID[0];
							$memberMgr->setM_ID($strM_ID);
							$intIdCount		= $memberMgr->getMemberIdCheck($db);
	
							if ($intMailCount == 0 && $intIdCount == 0){
								
								$settingRow = $memberMgr->getSettingView($db);

								$aryBirthDay = explode("/",$_facebook_user_profile["birthday"]);
								$strSex = ($_facebook_user_profile["gender"] == "female") ? "W":"M";

								$memberMgr->setM_AUTH("Y");
								/* 가입시 인증여부 */
								if ($settingRow[J_CERITY] == "Y"){
									$memberMgr->setM_AUTH("N");
								}

								/* 가입시 회원그룹 */
								$memberMgr->setM_GROUP($settingRow[J_GROUP]);

								/* 가입시 포인트 확인*/
								if ($settingRow[J_POINT] > 0){
									$memberMgr->setM_POINT($settingRow[J_POINT]);
								}
								
								$memberMgr->setM_ID($strM_ID);
								$memberMgr->setM_PASS("");
								$memberMgr->setM_F_NAME($_facebook_user_profile["first_name"]);
								$memberMgr->setM_L_NAME($_facebook_user_profile["last_name"]);
								$memberMgr->setM_NICK_NAME("");
								$memberMgr->setM_BIRTH($aryBirthDay[2]."-".$aryBirthDay[0]."-".$aryBirthDay[1]);
								$memberMgr->setM_SEX($strSex);
								$memberMgr->setM_MAIL($_facebook_user_profile["email"]);
								$memberMgr->setM_PHONE("");
								$memberMgr->setM_HP("");
								$memberMgr->setM_WED_DAY("");
								$memberMgr->setM_WED("");
								$memberMgr->setM_ZIP("");
								$memberMgr->setM_ADDR("");
								$memberMgr->setM_ADDR2("");
								$memberMgr->setM_SMSYN("N");
								$memberMgr->setM_MAILYN("N");
								$memberMgr->setM_TEXT("");
								$memberMgr->setM_REC_ID("");
								$memberMgr->setM_CONCERN("");
								$memberMgr->setM_JOB("");

								$memberMgr->getMemberInsert($db);
							
								$intM_NO = $db->getLastInsertID();

								$memberMgr->setM_NO($intM_NO);
								$memberRow = $memberMgr->getMemberView($db);

								/* 추천인 포인트 지급*/
								if ($settingRow[J_REC_POINT1] > 0 && $settingRow[J_REC_POINT2] > 0){
									if ($strM_REC_ID){
									}
								}
							
								$_SESSION[SESS_MEMBER_LOGIN]			= true;
								$_SESSION[SESS_MEMBER_ID]				= $memberRow[M_MAIL];
								$_SESSION[SESS_MEMBER_NAME]				= $memberRow[M_F_NAME];
								$_SESSION[SESS_MEMBER_LAST_NAME]		= $memberRow[M_L_NAME];		
								$_SESSION[SESS_MEMBER_GROUP]			= $memberRow[M_GROUP];
								$_SESSION[SESS_MEMBER_LEVEL]			= $memberRow[G_LEVEL];
								$_SESSION[SESS_MEMBER_NO]				= $intM_NO;
								$_SESSION[SESS_MEMBER_IPADDR]			= $S_REOMTE_ADDR;
								$_SESSION[SESS_MEMBER_FACEBOOK_LOGIN]	= true;
								
								/* 로그인시 장바구니 회원번호 update */
								$productMgr->setM_NO($intM_NO);
								$productMgr->setPB_KEY($g_cart_prikey);
								$productMgr->getProdBasketLoginUpdate($db);

								/* 방문수(로그인) UPDATE */
								$memberMgr->setM_NO($intM_NO);
								$memberMgr->getMemberVisitUpdate($db);

								/* 페이스북 ID,TOKEN UPDATE */
								$memberMgr->setM_FACEBOOK_ID($_SESSION[$_facebook_user_id]);
								$memberMgr->setM_FACEBOOK_TOKEN($_SESSION[$_facebook_access_token]);
								$memberMgr->getMemberFaceBookUpdate($db);

								$strFaceBookErrNo = "00000";	
								
								$db->disConnect();
								echo "<script>opener.location.reload();</script>";
								
							} else {
								// 사이트 회원이 페이스북 회원으로 최초 로그인 할 때
//								$logoutUrl = $facebook->getLogoutUrl(array( 'next' => ($fbconfig['baseurl'].'logout.php') ));
//								setcookie('fbs_'.$facebook->getAppId(), '', time()-100, '/', 'demo1.eumshop.co.kr');
//								session_destroy();
								$strFaceBookErrNo = "99998";
							}
						} else {
							$strFaceBookErrNo = "99997";
						}
					} else {

						$_SESSION[SESS_MEMBER_LOGIN]			= true;
						$_SESSION[SESS_MEMBER_ID]				= $facebookRow[M_MAIL];
						$_SESSION[SESS_MEMBER_NAME]				= $row[M_F_NAME];
						$_SESSION[SESS_MEMBER_LAST_NAME]		= $row[M_L_NAME];		
						$_SESSION[SESS_MEMBER_GROUP]			= $facebookRow[M_GROUP];
						$_SESSION[SESS_MEMBER_LEVEL]			= $facebookRow[G_LEVEL];
						$_SESSION[SESS_MEMBER_NO]				= $facebookRow[M_NO];
						$_SESSION[SESS_MEMBER_IPADDR]			= $S_REOMTE_ADDR;
						$_SESSION[SESS_MEMBER_FACEBOOK_LOGIN]	= true;
						
						/* 로그인시 장바구니 회원번호 update */
						$productMgr->setM_NO($facebookRow['M_NO']);
						$productMgr->setPB_KEY($g_cart_prikey);
						$productMgr->getProdBasketLoginUpdate($db);

						/* 방문수(로그인) UPDATE */
						$memberMgr->setM_NO($facebookRow['M_NO']);
						$memberMgr->getMemberVisitUpdate($db);

						$db->disConnect();
						goPopReflash($LNG_TRANS_CHAR["MS00024"]); //"자동로그인 성공"
						exit;
					}
				}
				
				$strFaceBookLoginUrl = "";
			}

		 } catch (FacebookApiException $e) {
			//error_log($e);
			$strFaceBookUserId = null;			
		 }
	} 

	
	if ($strFaceBookLoginUrl) {
		goUrl("",$strFaceBookLoginUrl);
		//header('Location: '.$strFaceBookLoginUrl);
		exit;
	}

?>
<body>
<form name='form' method='post'>
<div class="popUpWrap">

	<div class="fbTitWrap">
		<span><img src="/upload/images/ico_pop_fb.gif" /></span>
		<h2>Facebook Login</h2>
	</div>

	<div class="zipTxtInfo">
		<?
			switch ($strFaceBookErrNo){
				case "00000":
					//$strFaceBookErrText = "자동로그인이 성공적으로 이루어졌습니다.회원정보수정에서 추가정보를 수정하신 후 이용하시면 더 편리하게 사이트를 이용하실 수 있습니다.";
					$strFaceBookErrText = $LNG_TRANS_CHAR["MS00025"];
				break;

				case "99998":
					//$strFaceBookErrText = "FACEBOOK에 등록된 EMAIL은 이미 회원으로 등록된 이메일입니다.";
					$strFaceBookErrText = $LNG_TRANS_CHAR["MS00026"];
				break;

				case "99997":
					//$strFaceBookErrText = "FACEBOOK으로 자동로그인을 하시면 더 편리하게 사이트를 이용하실 수 있습니다. FACEBOOK 로그인을 사용해주세요.";
					$strFaceBookErrText = $LNG_TRANS_CHAR["MS00027"];
				break;
			}
		?>
		<strong><?=$strFaceBookErrText?></strong>
	</div>
	<div class="btnCenter">
		<a onclick="window.close();">[<?=$LNG_TRANS_CHAR["CW00034"]; //닫기?>]</a>
	</div>	
</div>
<!-- popUpWrap -->
</form>