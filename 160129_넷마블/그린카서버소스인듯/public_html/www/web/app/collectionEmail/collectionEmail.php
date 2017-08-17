<?php
	/**
	 * eumshop app - collection email
	 *
	 * 이메일 주소를 수집 합니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @manual		&mode=collectionEmail
	 * @history
	 *				2014.01.03 kim hee sung - 개발 완료
	 */
	
	/**
	 * app id
	 */
	$intAppID					= $intAppID + 1; 
	$strAppID					= "COLLECTION_EMAIL_{$intAppID}";
//	$strAppID					= "APP_ID_{$intAppID}";

?>
<!-- collection email html code (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<input type="text" name="c_email">
	<a href="javascript:goCollectionEmailWriteActEvent()" class="btn_reg_email">SIGN UP</a>
</div>
<!-- collection email html code (<?php echo $strAppID?>) -->