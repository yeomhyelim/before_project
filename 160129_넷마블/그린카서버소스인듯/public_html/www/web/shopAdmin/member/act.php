<?
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "memberAuth"				=> "member"
								,"memberModify"				=> "member"
								,"memberDelete"				=> "member"
								,"memberAllDelete"			=> "member"
								,"memberRecovery"			=> "member"
								,"memberGroupChange"		=> "member"
								,"memberReportWrite"		=> "member"
								,"memberCateJoinWrite"		=> "member"
								,"memberCateJoinDelete"		=> "member"
								,"memberReportModify"		=> "member"

								,"memberWrite"				=> "memberInsert"
								,"memberInsertWrite"		=> "memberExcelUpload"

								,"groupAdd"					=> "memberGroup"
								,"groupModify"				=> "memberGroup"
								,"groupView"				=> "memberGroup"
								,"groupProdSearch"			=> "memberGroup"
								,"groupIconDel"				=> "memberGroup"
								,"groupImgDel"				=> "memberGroup"
								,"groupFileDel"				=> "memberGroup"
								,"groupDelete"				=> "memberGroup"
								,"groupWrite"				=> "memberGroup"

								,"settingModify"			=> "memberJoin"
								,"joinItemSave"				=> "memberJoin"

								,"memberEvent"				=> "memberEvent"

								,"couponWrite"				=> "coupon"
								,"couponModify"				=> "coupon"
								,"couponDelete"				=> "coupon"
								,"couponMemberChoiceCreate"	=> "coupon"
								,"couponMemberAllCreate"	=> "coupon"
								,"couponIssueDelete"		=> "coupon"
								,"couponImgDel"				=> "coupon"
								,"couponProdSearch"			=> "coupon"

								,"dataEditEmail"			=> "smartQuery"
								,"dataEditSms"				=> "smartQuery"
								,"dataEditDelete"			=> "smartQuery"
								,"dataEditModify"			=> "smartQuery"
								,"dataEditWrite"			=> "smartQuery"
								
								,"memberPointWrite"			=> "point"

								,"memberCateWrite"			=> "memberCate"
								,"memberCateModify"			=> "memberCate"
								,"memberCateDelete"			=> "memberCate"

							 );
	/* 페이지 분류 */
	
	require_once MALL_HOME."/web/shopAdmin/basic/_function.lib.inc.php";

	/* 여기에 추가되어야 함(메일관련) */
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
	require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";	
	/* 여기에 추가되어야 함(메일관련) */
	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */
	$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
	if(is_file($smsConfFile)):
		require_once $smsConfFile;
	endif;
	require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";	/** 2013.05.06 dataEdit 사용 **/	
	$smsFunc			= new SmsFunc();	
	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */

	include $strIncludePath.$aryIncludeFolder[$strAct]."/act.inc.php";
	goUrl($strMsg,$strUrl);
?>