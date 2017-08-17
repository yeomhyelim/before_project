<?php
	/**
	 * eumshop app - communityPassword
	 *
	 * 커뮤니티 비밀번호 앱입니다.
	 * 비회원글을 수정 or 삭제를 할 때, 사용합니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityPassword/communityPassword.php
	 * @manual		&mode=communityPassword
	 * @history
	 *				2014.07.22 kim hee sung - 개발 완료
	 */

	/**
	 * 스킨 설정
	 */
	if(!$strAppSkin) { $strAppSkin		= "defaultSkin"; }

	/**
	 * 이동
	 */
	include MALL_HOME . "/web/app/{$strAppMode}/{$strAppMode}.{$strAppSkin}.php";