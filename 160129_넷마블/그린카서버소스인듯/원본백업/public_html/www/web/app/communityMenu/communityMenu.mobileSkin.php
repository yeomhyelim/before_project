<?php
	/**
	 * eumshop app - communityMenu - mobileSkin
	 *
	 * 커뮤니티 메뉴(그룹,커뮤니티)
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityMenu/communityMenu.mobileSkin.php
	 * @manual		menuType=app&mode=communityList&skin=mobileSkin
	 * @history
	 *				2014.06.08 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "COMMUNITY_MENU_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/communityMenu/communityMenu.mobileSkin.js";

	## 기본설정
	$strLangS = $S_ST_LNG;
	$strLangSLower = strtolower($strLangS);
	$strGroupListConfFile = MALL_SHOP . "/conf/community/{$strLangSLower}/groupList.info.php";
	$strBoardListConfFile = MALL_SHOP . "/conf/community/{$strLangSLower}/boardList.info.php";

	## 그룹 리스트 불러오기
	include $strGroupListConfFile;

	## 커뮤니티 리스트 불러오기
	include $strBoardListConfFile;

	## 체크
	if(!$BOARD_LIST) { return; }

	## 커뮤니티 리스트 그룹별로 설정
	$aryBoardList = "";
	foreach($BOARD_LIST as $boardKey => $boardData):
		
		## 기본설정
		$strBName = $boardData['b_name'];
		$intBBgNo = $boardData['b_bg_no'];

		$aryTemp = "";
		$aryTemp['B_CODE'] = $boardKey;
		$aryTemp['B_NAME'] = $strBName;

		$aryBoardList[$intBBgNo][] = $aryTemp;

	endforeach;

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
//	$aryLanguage['OS00013']	= $LNG_TRANS_CHAR['OS00013'];
//	$aryLanguage['PW00010']	= $LNG_TRANS_CHAR['PW00010'];
//	$aryLanguage['PW00009']	= $LNG_TRANS_CHAR['PW00009'];
//	$aryLanguage['OS00029']	= $LNG_TRANS_CHAR['OS00029'];
//	$aryLanguage['CW00034']	= $LNG_TRANS_CHAR['CW00034'];
//	$aryLanguage['CW00001']	= $LNG_TRANS_CHAR['CW00001'];
	
	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;
?>
<!-- eumshop app - communityMenu - mobileSkin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<div class="cate1-wrap">
		<ul class="cateList">
			<?php foreach($GROUP_LIST as $groupKey => $groupData):
					
					## 기본설정
					$strBgName = $groupData['bg_name'];

					## 커뮤니티 리스트 불러오기
					$aryBoard = $aryBoardList[$groupKey];	

					## 제외 게시판 그룹
					if(in_array($strBgName, array('운영관리'))) continue;
			?>
			<li class="cate1-item"><a href="javascript:void(0);"><span><?php echo $strBgName;?></span></a>
				<?php if($aryBoard):?>
				<div class="cate2-wrap">
					<ul class="cateList">
						<?php foreach($aryBoard as $boardKey => $boardData):
						
								## 기본설정
								$strB_CODE = $boardData['B_CODE'];
								$strB_NAME = $boardData['B_NAME'];

								## 제외 게시판
								if(in_array($strB_CODE, array('USER_REPORT'))) continue;
						?>
						<li class="cate2-item"><a href="/?menuType=community&mode=dataList&b_code=<?php echo $strB_CODE;?>"><span><?php echo $strB_NAME;?></span></a></li>
						<?php endforeach;?>
					</ul>
				</div>
				<?php endif;?>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
<!-- eumshop app - communityMenu - mobileSkin (<?php echo $strAppID?>) -->