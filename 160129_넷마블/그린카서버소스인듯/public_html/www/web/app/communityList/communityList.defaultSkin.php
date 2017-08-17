<?php
	/**
	 * eumshop app - communityList - defaultSkin
	 *
	 * 커뮤니티 리스트를 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityList/communityList.defaultSkin.php
	 * @manual		menuType=app&mode=communityList
	 * @history
	 *				2014.06.08 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "COMMUNITY_LIST_{$intAppID}";
	endif;

	## 모듈 설정
	$objBoardDataModule			= new BoardDataModule($db);

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/communityList/communityList.defaultSkin.js";

	## 기본 설정
	$strAppBCode				= $EUMSHOP_APP_INFO['bCode'];
	$strAppColumn				= $EUMSHOP_APP_INFO['column'];
	$intAppidx					= 0;
	if(!$strAppBCode) { return; }
	if(!$strAppColumn) { $strAppColumn	= "번호;제목;작성일"; }
	$aryAppColumn				= explode(";", $strAppColumn);

	## 데이터 불러오기
	$param								= "";
	$param['B_CODE']					= $strAppBCode;
	$intAppTotal						= $objBoardDataModule->getBoardDataSelectEx("OP_COUNT", $param);					// 데이터 전체 개수 
	$intAppPageLine						= ( $intAppPageLine )		? $intAppPageLine	: 10;								// 리스트 개수 
	$intAppPage							= ( $intAppPage )			? $intAppPage		: 1;
	$intAppFirst						= ( $intAppTotal == 0 )		? 0					: $intAppPageLine * ( $intAppPage - 1 );

	$param['ORDER_BY']					= $strAppOrderBy;
	$param['LIMIT']						= "{$intAppFirst},{$intAppPageLine}";
	$resAppResult						= $objBoardDataModule->getBoardDataSelectEx("OP_LIST", $param);
	$intAppPageBlock					= 10;																				// 블럭 개수 
	$intAppListNum						= $intAppTotal - ( $intAppPageLine * ( $intAppPage - 1 ) );							// 번호
	$intAppTotPage						= ceil( $intAppTotal / $intAppPageLine );
//	echo $db->query;

	## paging 설정
	$intAppPage				= $intAppPage;									// 현재 페이지
	$intAppTotPage			= $intAppTotPage;								// 전체 페이지 수
	$intAppTotBlock			= ceil($intAppTotPage / $intAppPageBlock);		// 전체 블럭 수
	$intAppBlock			= ceil($intAppPage / $intAppPageBlock);			// 현재 블럭
	$intAppPrevBlock		= (($intAppBlock - 2) * $intAppPageBlock) + 1;	// 이전 블럭
	$intAppNextBlock		= ($intAppBlock * $intAppPageBlock) + 1;		// 다음 블럭
	$intAppFirstBlock		= (($intAppBlock - 1) * $intAppPageBlock) + 1;	// 현재 블럭 시작 시저
	$intAppLastBlock		= $intAppBlock * $intAppPageBlock;				// 현재 블럭 종료 시점
	if($intAppFirstBlock <= 0) { $intAppFirstBlock	= 1; }
	if($intAppPrevBlock  <= 0) { $intAppPrevBlock		= 1; }
	if($intAppNextBlock >= $intAppTotPage) { $intAppNextBlock	= $intAppTotPage; }
	if($intAppLastBlock >= $intAppTotPage) { $intAppLastBlock	= $intAppTotPage; }

?>
<!-- community widget html code (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<?php if($intAppTotal): ?>
	<ul>
		<?php while($row = mysql_fetch_array($resAppResult)):

				## 기본 설정
				$intUBNo			= $row['UB_NO'];
				$strTitle			= $row['UB_TITLE'];	
				$strCategoryName	= $row['BC_NAME'];	
				$strListImageUrl	= $row['FL_DIR'] . $row['FL_NAME'];	
				$strWriterName		= $row['UB_NAME'];	
				$strRegDate			= $row['UB_REG_DT'];	
				$intHit				= $row['UB_READ'];	
				$idx				= $idx + 1;

				## 제목 설정
				## 최대 표시 문자 길이 체크 및 짜르기
				if($intMaxLeng):
					$temp		= mb_substr($strTitle, 0, $intMaxLeng, "UTF-8");
					if(mb_strlen($temp, "UTF-8") != mb_strlen($strTitle, "UTF-8")) { $temp .= "..."; }
					$strTitle	= $temp;
				endif;

				## 날짜 설정
				$strRegDate		= date("Y-m-d", strtotime($strRegDate));
		?>
		<li class="data<?php echo $intAppidx;?>">
		<?php foreach($aryAppColumn as $key => $data):?>
			<?php if($data == "번호"):?>
			<span class="no"><?php echo $intAppListNum--;?></span>
			<?php endif;?>
			<?php if($data == "카테고리"):?>
			<span class="category"><?php echo $strCategoryName?></span>
			<?php endif;?>
			<?php if($data == "리스트이미지"):?>
			<span class="image"><img src="<?php echo $strListImageUrl?>"></span>
			<?php endif;?>
			<?php if($data == "제목"):?>
			<span class="title"><a href="javascript:goCommunityListDefaultSkinViewMoveEvent('<?php echo $strAppBCode?>','<?php echo $intUBNo?>')"><?php echo $strTitle;?></a></span>
			<?php endif;?>
			<?php if($data == "작성자"):?>
			<span class="writer"><?php echo $strWriterName?></span>
			<?php endif;?>
			<?php if($data == "작성일"):?>
			<span class="date"><?php echo $strRegDate?></span>
			<?php endif;?>
			<?php if($data == "조회수"):?>
			<span class="read"><?php echo $intHit?></span>
			<?php endif;?>
		<?php endforeach;?>
			<div class="clr"></div>
		</li>
		<?php endwhile; ?>
	</ul>
	<?php  endif; ?>
</div>
<!-- community widget html code (<?php echo $strAppID?>) -->
