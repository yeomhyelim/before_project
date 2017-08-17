<?php
	/**
	 * eumshop app - communityWrite - mobileSkin
	 *
	 * 커뮤니티 쓰기폼 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityWrite/communityWrite.mobileSkin.php
	 * @manual		menuType=app&mode=communityWrite&skin=mobileSkin
	 * @history
	 *				2015.01.16 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID = $intAppID + 1; 
		$strAppID = "COMMUNITY_WRITE_{$intAppID}";
	endif;

	## 기본 설정
	$strAppBCode = $EUMSHOP_APP_INFO['bCode'];

	## 리스트 기본 
	$EUMSHOP_APP_INFO = "";
	$EUMSHOP_APP_INFO['name'] = "커뮤니티_글쓰기";
	$EUMSHOP_APP_INFO['mode'] = "communityWrite";
	$EUMSHOP_APP_INFO['appID'] = $strAppID;
	$EUMSHOP_APP_INFO['skin'] = "dataBasicSkin";
	$EUMSHOP_APP_INFO['view'] = "N";
	$EUMSHOP_APP_INFO['bCode'] = $strAppBCode;
	$EUMSHOP_APP_INFO['boardInfo'] = $aryAppBoardInfo;
	include MALL_HOME . "/web/app/index.php";

	/*## 리스트 기본 
	$EUMSHOP_APP_INFO = "";
	$EUMSHOP_APP_INFO['name'] = "커뮤니티_리스트";
	$EUMSHOP_APP_INFO['mode'] = "communityList";
	$EUMSHOP_APP_INFO['appID'] = $strAppID;
	$EUMSHOP_APP_INFO['skin'] = "dataBasicSkin";
	$EUMSHOP_APP_INFO['view'] = "N";
	$EUMSHOP_APP_INFO['bCode'] = $strAppBCode;
	$EUMSHOP_APP_INFO['boardInfo'] = $aryAppBoardInfo;
	$EUMSHOP_APP_INFO['pageLine'] = $intAppPageLine;
	include MALL_HOME . "/web/app/index.php";*/



	## 기본설정
	$strAppB_NAME				=  $aryAppBoardInfo['B_NAME'];
	list($strKind, $strSkin)	= explode("_", $strB_KIND_SKIN);

	## 스크립트 설정
	$aryAppParam['SKIN'] = "mobileSkin";
	$aryScriptData['APP'][$strAppID] = $aryAppParam;
?>
<div id="<?php echo $strAppID?>">
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.<?php echo $strB_CSS;?>.css"/>
	<div class="tableFormWrap">
		<form name="writeForm" id="tx_editor_form" method="post" enctype="multipart/form-data" action="./">
		<input type="hidden" name="menuType" value="<?php echo $strMenuType;?>">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="act" value="">
		<input type="hidden" name="b_code" value="<?php echo $strAppBCode;?>">
		<input type="hidden" name="ub_lng" value="<?php echo $strLang;?>">
		<input type="hidden" name="ub_p_code" value="<?php echo $strAppPCode;?>">
		<input type="hidden" name="editorDir" value="<?php echo $strEditorDir;?>">
		<input type="hidden" name="ub_func_text" value="Y">
		<table class="tableForm">
				<?php if($isCategory):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00064"]; // 카테고리?><span>*</span></th>
					<td><select name="ub_bc_no" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00064"]; // 카테고리?>" class="i_sw">
							<option value=""><?php echo $LNG_TRANS_CHAR["MS00103"]; // 선택하세요.?></option>
							<?php foreach($aryCategoryList as $key => $data):
							
									## 기본설정
									$strBC_NAME = $data['bc_name'];							
							?>
							<option value="<?php echo $key;?>"><?php echo $strBC_NAME;?></option>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00053"]; // 작성자?><span>*</span></th>
					<td><input type="text" name="ub_name" value="<?php echo $strUbName;?>" maxlength="10" class="i_tw" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00053"]; // 작성자?>"<?php if($intMemberNo){echo " readonly";}?>></td>
				</tr>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["MW00010"]; // 이메일?></th>
					<td><input type="text" name="ub_mail" value="<?php echo $strMemberEmail;?>" maxlength="25" class="i_tw"></td>
				</tr>
				<?php include "communityWrite.dataBasicSkin.userfield.inc.php";?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00062"]; // 제목?><span>*</span></th>
					<td><input type="text" name="ub_title" class="i_tw" maxlength="100" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00062"]; // 제목?>">
						<?php if($isNotice):?>
							<input type="checkbox" name="ub_func_notice"><?php echo $LNG_TRANS_CHAR["CW00068"]; // 공지글?>
						<?php endif;?>
						<?php if($isLock):?>
							<input type="checkbox" name="ub_func_lock" value="Y"<?php if($strBI_DATAWRITE_LOCK_USE=="E"){echo " checked disabled";}?>><?php echo $LNG_TRANS_CHAR["CW00070"]; // 비밀글?>
						<?php endif;?>
					</td>
				</tr>
				<?php if(in_array("점수",$aryAppColumn)):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00056"]; // 평점?></th>
					<td><?php for($i=1;$i<=5;$i++):?>
						<input type="radio" name="ub_p_grade" value="<?php echo $i;?>"<?php if($i==5){echo " checked";}?>>
						<img src="/himg/board/icon/icon_star_<?php echo $i;?>.png">
						<?php endfor;?>	
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00063"]; // 내용?><span>*</span></th>
					<td>
						<textarea name="ub_text" id="ub_text" check="empty" class="i_ta"></textarea>
					</td>
				</tr>
				<?php if($isPassword):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["MW00002"]; // 비밀번호?><span>*</span></th>
					<td><input type="password" name="ub_pass" class="i_tw" maxlength="12" check="empty" alt="<?php echo $LNG_TRANS_CHAR["MW00002"]; // 비밀번호?>"></td>
				</tr>
				<?php endif;?>
		</table>
		</form>
	</div>
	<div class="btnCenterWrap">
		<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinWriteActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_bbs_write"><strong><?php echo $LNG_TRANS_CHAR["CW00052"]; // 글쓰기?></strong></a>
		<?php if($isCancelBtnShow):?>
		<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinCancelMoveEvent();" id="menu_auth_w" class="btn_bbs_cancel"><strong><?php echo $LNG_TRANS_CHAR["MW00044"]; // 취소?></strong></a>
		<?php endif;?>
	</div>
</div>



