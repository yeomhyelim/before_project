<?php
	/**
	 * eumshop app - communityIcon
	 *
	 * 커뮤니티 아이콘입니다. 커뮤니티 통합하여 설정한 아이콘 리스트를 출력합니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @manual		&mode=communityIcon&icon=인기글&limitEnd=5&column=번호;제목&titleMaxLeng=10
	 * @history
	 *				2014.01.07 kim hee sung - 개발 완료
	 */
	
	/**
	 * app id
	 */
	$intAppID					= $intAppID + 1; 
	$strAppID					= "COMMUNITY_ICON_{$intAppID}";
//	$strAppID					= "APP_ID_{$intAppID}";

	/**
	 * 커뮤니티 아이콘 객체 선언
	 */
	$objBoardIcon				= new BoardIconModule($db);
	$objBoardData				= new BoardDataModule($db);

	/**
	 * 리스트 데이터 만들기
	 */
	$aryParam						= "";
	$aryParam['BI_ICON']			= $EUMSHOP_APP_INFO['icon'];
	$intTotal						= $objBoardIcon->getBoardIconSelectEx("OP_COUNT", $aryParam);				// 데이터 전체 개수 
	$intPageLine					= $EUMSHOP_APP_INFO['limitEnd'];											// 리스트 개수 
	$intPage						= ( $intPage )				? $intPage		: 1;
	$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$aryParam['LIMIT']				= "{$intFirst},{$intPageLine}";
	$resBoardIconResult				= $objBoardIcon->getBoardIconSelectEx("OP_LIST", $aryParam);

	$intPageBlock					= 10;																		// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );

	/**
	 * 커뮤니티 리스트 컬럼 이름 및 순위 정의(기본)
	 */
	$strColumn						= $EUMSHOP_APP_INFO['column'];
	if(!$strColumn) { $strColumn	= "번호;제목;작성일"; }
	$aryColumn						= explode(";", $strColumn);

	/**
	 * 커뮤니티 리스트 컬럼 이름 및 순위 정의(첫번째 라인 설정)
	 */
	$strColumn1						= $EUMSHOP_APP_INFO['column1'];
	if(!$strColumn1) { $strColumn1	= $strColumn; }
	$aryColumn1						= explode(";", $strColumn1);

	/**
	 * 커뮤니티 제목 설정
	 */
	$intMaxLeng						= $EUMSHOP_APP_INFO['titleMaxLeng'];

?>
<!-- community widget html code (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
<?if($intTotal): ?>
	<ul>
<?	$idx = 0;
	while($row = mysql_fetch_array($resBoardIconResult)):
		$strBCode		= $row['BI_B_CODE'];
		$strUBNo		= $row['BI_UB_NO'];	
		
		## 게시판 정보
		$param				= "";
		$param['B_CODE']	= $strBCode;
		$param['UB_NO']		= $strUBNo;
		if(in_array("리스트이미지", $aryColumn1)):
		$param['BOARD_FL_JOIN']			= "Y";
		endif;
		if(in_array("카테고리", $aryColumn1)):
		$param['BOARD_CATEGORY_JOIN']	= "Y";
		endif;
		$aryBoardData		= $objBoardData->getBoardDataSelectEx("OP_SELECT", $param);
		$strTitle			= $aryBoardData['UB_TITLE'];	
		$strCategoryName	= $aryBoardData['BC_NAME'];	
		$strListImageUrl	= $aryBoardData['FL_DIR'] . $aryBoardData['FL_NAME'];	
		$strWriterName		= $aryBoardData['UB_NAME'];	
		$strRegDate			= $aryBoardData['UB_REG_DT'];	
		$intHit				= $aryBoardData['UB_READ'];	
		$idx				= $idx + 1;

		## 제목 설정
		## 최대 표시 문자 길이 체크 및 짜르기
		if($intMaxLeng):
			$temp		= mb_substr($strTitle, 0, $intMaxLeng, "UTF-8");
			if(mb_strlen($temp, "UTF-8") != mb_strlen($strTitle, "UTF-8")) { $temp .= "..."; }
			$strTitle	= $temp;
		endif;
?>
		<li class="data<?=$idx?>">
<?foreach($aryColumn1 as $key => $data):?>
<?if($data == "번호"):?>
			<span class="no"><?php echo $intListNum--;?></span>
<?endif;?>
<?if($data == "카테고리"):?>
			<span class="category"><?php echo $strCategoryName?></span>
<?endif;?>
<?if($data == "리스트이미지"):?>
			<span class="image"><img src="<?php echo $strListImageUrl?>"></span>
<?endif;?>
<?if($data == "제목"):?>
			<span class="title"><a href="javascript:goAppDataViewMoveEvent('<?php echo $strBCode?>','<?php echo $strUBNo?>')"><?php echo $strTitle;?></a></span>
<?endif;?>
<?if($data == "작성자"):?>
			<span class="writer"><?php echo $strWriterName?></span>
<?endif;?>
<?if($data == "작성일"):?>
			<span class="date"><?php echo $strRegDate?></span>
<?endif;?>
<?if($data == "조회수"):?>
			<span class="read"><?php echo $intHit?></span>
<?endif;?>
<?endforeach;?>
			<div class="clr"></div>
		</li>
<?	endwhile; ?>
	</ul>
<?  endif;		?>
</div>
<!-- community widget html code (<?php echo $strAppID?>) -->