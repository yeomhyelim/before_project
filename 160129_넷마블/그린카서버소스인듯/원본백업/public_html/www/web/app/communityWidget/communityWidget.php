<?php
	/**
	 * eumshop app - communityWidget
	 *
	 * 커뮤니티 위젯입니다. 단순 게시판 리스트를 표시합니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @manual		&mode=communityWidget&b_code=NOTICE&limitEnd=5&column=번호;제목&ub_bc_no=2&titleMaxLeng=10
	 * @history
	 *				2013.12.29 kim hee sung - 개발 완료
	 */

	/**
	 * app id
	 */
	$intAppID					= $intAppID + 1; 
	$strAppID					= "COMMUNITY_WIDGET_{$intAppID}";
//	$strAppID					= "APP_ID_{$intAppID}";

	/**
	 * 커뮤니티 객체 선언
	 */
	$boardData					= new BoardDataView($db, $aryParam);

	/**
	 * 커뮤니티 리스트 컬럼 이름 및 순위 정의(기본)
	 */
	$strColumn						= $EUMSHOP_APP_INFO['column'];
	$strAppShowLng					= $EUMSHOP_APP_INFO['showLng'];
	if(!$strAppShowLng) { $strAppShowLng = "all"; }
	if(!$strColumn) { $strColumn	= "번호;제목;작성일"; }
	$aryColumn						= explode(";", $strColumn);
	
	/**
	 * 커뮤니티 테이블 조인 체크
	 */
	$strBoardFLJoin						= "";
	$strBoardCategoryJoin				= "";
	if(in_array("리스트이미지", $aryColumn))	{ $strBoardFLJoin			= "Y"; }
	if(in_array("카테고리", $aryColumn))		{ $strBoardCategoryJoin		= "Y"; }

	/**
	 * 커뮤니티 리스트 데이터 파라미터 설정
	 */
	$aryParam							= "";
	$aryParam['B_CODE']					= $EUMSHOP_APP_INFO['b_code'];
	$aryParam['UB_BC_NO']				= $EUMSHOP_APP_INFO['ub_bc_no'];
	$aryParam['LIMIT_END']				= $EUMSHOP_APP_INFO['limitEnd'];
	$aryParam['BOARD_FL_JOIN']			= $strBoardFLJoin;
	$aryParam['BOARD_CATEGORY_JOIN']	= $strBoardCategoryJoin;
	$aryParam['ORDER_BY']				= 'defaultDesc';
	$strAppShowLng = 'share';
	if($strAppShowLng == "share"):
		$aryParam['UB_LNG_IN'][]		= "--";
		$aryParam['UB_LNG_IN'][]		= $S_SITE_LNG;
	endif;
	if($S_COMMUNITY_COMMENT_VERSION == "V2.0" || $S_COMMUNITY_VERSION == "V2.0"):
		$aryParam['UB_DEL']				= "N";
	endif;

	/**
	 * 리스트 데이터 만들기
	 */
	$boardData->makeListData($aryParam);
//	ECHO $db->query;

	/**
	 * 커뮤니티 제목 옵션 설정(기본)
	 */
	$aryParamTitle								= "";
	$aryParamTitle['IS_MAX_LENG_USE']			= true;
	$aryParamTitle['MAX_LENG']					= $EUMSHOP_APP_INFO['titleMaxLeng'];

	/**
	 * 커뮤니티 제목 옵션 설정(첫번째 라인 설정)
	 */
	$aryParamTitle1									= $aryParamTitle;
	if($EUMSHOP_APP_INFO['titleMaxLeng1']):
		$aryParamTitle1['MAX_LENG']					= $EUMSHOP_APP_INFO['titleMaxLeng1'];		
	endif;

	/**
	 * 커뮤니티 리스트 컬럼 이름 및 순위 정의(첫번째 라인 설정)
	 */
	$strColumn1						= $EUMSHOP_APP_INFO['column1'];
	if(!$strColumn1) { $strColumn1	= $strColumn; }
	$aryColumn1						= explode(";", $strColumn1);
?>
<!-- community widget html code (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
<?if($boardData->getTotal()):?>
	<ul>
<?	$idx = 1; 
	while($boardData->getFetch()):
	if($idx > 1) {
		$aryColumn1			= $aryColumn;
		$aryParamTitle1		= $aryParamTitle;
	}
?>
		<li class="data<?=$idx?>">
<?foreach($aryColumn1 as $key => $data):?>
<?if($data == "번호"):?>
			<span class="no"><?php echo $boardData->getListNumber();?></span>
<?endif;?>
<?if($data == "카테고리"):?>
			<span class="category"><?php echo $boardData->getCategoryName();?></span>
<?endif;?>
<?if($data == "리스트이미지"):?>
			<span class="image"><a href="javascript:goAppDataViewMoveEvent('<?php echo $EUMSHOP_APP_INFO['b_code']?>','<?php echo $boardData->getNo();?>')"><img src="<?php echo $boardData->getListImageUrl()?>"></a></span>
<?endif;?>
<?if($data == "제목"):?>
			<span class="title"><a href="javascript:goAppDataViewMoveEvent('<?php echo $EUMSHOP_APP_INFO['b_code']?>','<?php echo $boardData->getNo();?>')"><?php echo $boardData->getTitle($aryParamTitle1);?></a></span>
<?endif;?>
<?if($data == "작성자"):?>
			<span class="writer"><?php echo $boardData->getWriterName();?></span>
<?endif;?>
<?if($data == "아이디"):?>
			<span class="id"><?php echo $boardData->getWriterID();?></span>
<?endif;?>
<?if($data == "작성일"):?>
			<span class="date"><?php echo $boardData->getRegDate();?></span>
<?endif;?>
<?if($data == "조회수"):?>
			<span class="read"><?php echo $boardData->getHit();?></span>
<?endif;?>
<?endforeach;?>
			<div class="clr"></div>
		</li>
<?	$idx++; 
	endwhile;?>
		<div class="clr"></div>
	</ul>
<?endif;?>
</div>
<!-- community widget html code (<?php echo $strAppID?>) -->