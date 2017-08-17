<?php
	/**
	 * eumshop app - communityView - defaultSkin
	 *
	 * 커뮤니티 보기 내용을 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityView/communityView.defaultSkin.php
	 * @manual		menuType=app&mode=communityView
	 * @history
	 *				2014.06.08 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "COMMUNITY_VIEW_{$intAppID}";
	endif;

	## 모듈 설정
	$objBoardDataModule			= new BoardDataModule($db);

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/communityView/communityView.defaultSkin.js";

	## 기본 설정
	$strAppBCode				= $EUMSHOP_APP_INFO['b_code'];
	$strAppUBNo					= $EUMSHOP_APP_INFO['ub_no'];
	if(!$strAppBCode) { return; }
	if(!$strAppUBNo) { return; }

	## 내용 불러오기
	$param						= "";
	$param['B_CODE']			= $strAppBCode;
	$param['UB_NO']				= $strAppUBNo;
	$aryAppRow					= $objBoardDataModule->getBoardDataSelectEx("OP_SELECT", $param);
	$strAppUB_NAME				= $aryAppRow['UB_NAME'];
	$strAppUB_M_ID				= $aryAppRow['UB_M_ID'];
	$strAppUB_MAIL				= $aryAppRow['UB_MAIL'];
	$strAppUB_TITLE				= $aryAppRow['UB_TITLE'];
	$intAppUB_READ				= $aryAppRow['UB_READ'];
	$strAppUB_TEXT				= $aryAppRow['UB_TEXT'];
	$strAppUB_LNG				= $aryAppRow['UB_LNG'];
	$strAppUB_REG_DT			= $aryAppRow['UB_REG_DT'];
	if(!$aryAppRow) { return; }


?>
<!-- eumshop app - communityView - defaultSkin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<div class="tableForm">
		<table class="tableForm">		
		<tbody>
			<tr>
				<th class="boardTit" colspan="8"><?php echo $strAppUB_TITLE;?></th>
			</tr>
			<tr class="writerInfo">
				<th class="name">작성자</th>
				<td style="text-align:left"><?php echo $strAppUB_NAME;?><span class="txtDate">(<?php echo $strAppUB_REG_DT;?>)</span></td>
				<th class="read">조회수</th>
				<td><?php echo $intAppUB_READ;?></td>
			</tr>
		</tbody>
		</table>
		<div class="viewContentArea">
			<?php echo $strAppUB_TEXT;?>
		</div>
	</div>
	<div class="btnRight">	
		<a href="javascript:goCommunityViewDefaultSkinListMoveEvent();" id="menu_auth_w" class="btn_board_list"><strong>목록</strong></a>
	</div>
</div>
<!-- eumshop app - communityView - defaultSkin (<?php echo $strAppID?>) -->
