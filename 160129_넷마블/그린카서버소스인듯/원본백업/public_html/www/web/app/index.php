<?php
	/**
	 * eumshop app
	 *
	 * eumshop app application development framework for PHP 5.1.6 or newer
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @history
	 *				2013.12.29 kim hee sung - dev
	 *				2014.02.12 kim hee sung - skin 변수 추가
	 *				2014.02.13 kim hee sung - appID 설정을 상단에서 설정 할 수 있도록 변경함
	 *				2014.08.03 kim hee sung - view 변수 추가
	 *				2015.03.23 kim hee sung - app에서 app 을 호출할때 무한루프 빠지는 현상 수정
	 */

	## app 메뉴타입으로 접속한 경우.
	if($strMenuType == "app" && $EUMSHOP_APP_INFO['view'] != 'N'):
		$EUMSHOP_APP_INFO			= $_GET;
		$strAppID					= $_GET['appID'];
		$strAppMode					= $_GET['mode'];
		$strAppSkin					= $_GET['skin'];
		$strAppView					= $_GET['view']; // html code 사용 유무(N = 사용안함)
		$strAppReturn				= $_GET['return'];
		$strAppFile					= "index";

		## POST 방식인 경우
		if($_POST['appID']):
			$EUMSHOP_APP_INFO		= $_POST;
			$strAppID				= $_POST['appID'];
			$strAppMode				= $_POST['mode'];
			$strAppSkin				= $_POST['skin'];
			$strAppView				= $_POST['view'];
			$strAppReturn			= $_POST['return'];
			$strAppFile				= $_POST['mode'];
		endif;
	else:
		$strAppID		= $EUMSHOP_APP_INFO['appID'];
		$strAppMode		= $EUMSHOP_APP_INFO['mode'];
		$strAppSkin		= $EUMSHOP_APP_INFO['skin'];
		$strAppView		= $EUMSHOP_APP_INFO['view'];
		$strAppFile		= $EUMSHOP_APP_INFO['mode'];
	endif;


	## include
	include MALL_HOME . "/web/app/{$strAppMode}/{$strAppFile}.php";
