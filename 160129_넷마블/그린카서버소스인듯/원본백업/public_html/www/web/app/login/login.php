<?php
	/**
	 * eumshop app - login
	 *
	 * 로그인 폼입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @manual		&mode=login
	 * @history
	 *				2013.12.30 kim hee sung - 개발 완료
	 *				2014.01,.03 Shimtot - 로그인한 경우 액박나는 디자인 변경(CSS는 한중관에만 적용되어있음)
	 */
	
	/**
	 * app id
	 */
	$intAppID					= $intAppID + 1; 
	$strAppID					= "LOGIN_{$intAppID}";
//	$strAppID					= "APP_ID_{$intAppID}";

	/**
	 * ID 저장 정보
	 */
	$strMemberID				= $_COOKIE['COOKIE_SAVE_ID'];

	/**
	 * 로그인 정보
	 */
	$isMemberLogin					= $_SESSION[SESS_MEMBER_LOGIN];
	$strMemberID						= $_SESSION[SESS_MEMBER_ID];
	$strMemberName					= $_SESSION[SESS_MEMBER_NAME];	
	$strMemberLastName			= $_SESSION[SESS_MEMBER_LAST_NAME];		
	$strMemberGroup				= $_SESSION[SESS_MEMBER_GROUP];			
	$strMemberGroupName		= $_SESSION[SESS_MEMBER_GROUP_NAME];		
	$strMemberLevel					= $_SESSION[SESS_MEMBER_LEVEL];			
	$strMemberNo						= $_SESSION[SESS_MEMBER_NO];				
	$strMemberEmail					= $_SESSION[SESS_MEMBER_EMAIL];			
	$strMemberIPAddr				= $_SESSION[SESS_MEMBER_IPADDR];				
	$strMemberFacebookLogin	= $_SESSION[SESS_MEMBER_FACEBOOK_LOGIN];		
	$strMemberNickName			= $_SESSION[SESS_MEMBER_NICKNAME];	
	
	/**
	 * 로그인 한경우 app id 변경
	 */
	if($isMemberLogin):
		$strAppID				= "LOGOUT_{$intAppID}";
	endif;
?>
<?if(!$isMemberLogin):?>
<!-- login html code (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<h3>회원로그인</h3>
	<!-- div class="formtxt_Wrap1">		
		<div class="savId"><input type="checkbox" name="login_save_id" value="Y"<?if($strMemberID){echo " checked";}?>>ID저장</div>
		<a href="./?menuType=member&mode=join1" class="btnRegster">회원가입</a> 
		<a href="./?menuType=member&mode=findIdPwd" class="btnFindIdPwd">아이디/비밀번호 찾기</a>
	</div -->
	<div class="loginForm_Wrap">
		<div class="inputForm_wrap">
			<input type="text"     name="login_id" class="input_id" value="<?=$strMemberID?>" onEnterKey="goLoginActEvent">
			<input type="password" name="login_pw" class="input_pw" onEnterKey="goLoginActEvent">
		</div>
		<a href="javascript:goLoginActEvent();" class="btn_login"><span>로그인</span></a>
		<div class="clr"></div>
	</div>
	<div class="formtxt_Wrap2">
		<div class="savId"><input type="checkbox" name="login_save_id" value="Y"<?if($strMemberID){echo " checked";}?>>ID저장</div>
		<a href="./?menuType=member&mode=join1" class="btnRegster">회원가입</a> 
		<a href="./?menuType=member&mode=findIdPwd" class="btnFindIdPwd">아이디/비밀번호 찾기</a>
	</div>
		<div class="clr"></div>
</div>
<!-- login html code (<?php echo $strAppID?>) -->
<?else:?>
<!-- logout html code (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<ul>
		<li class="btn_logout"><a href="javascript:goLogoutActEvent();" class="btnLogout"><span>로그아웃</span></a></li>
		<li><?=$strMemberName?> 회원님 환영합니다.</li>
		<li>
			<a href="./?menuType=mypage&mode=pointList" class="btn_point"><span>보유포인트</span></a>
			<a href="./?menuType=mypage&mode=myInfo" class="btn_mypage"><span>내정보</span></a>
			<a href="./?menuType=mypage&mode=buyList" class="btn_order"><span>주문관리</span></a>
		</li>
	</ul>

</div>
<!-- logout html code (<?php echo $strAppID?>) -->
<?endif;?>