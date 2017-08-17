<?php
	/**
	 * eumshop app - communityAnswer - dataBasicSkin
	 *
	 * 커뮤니티 답변을 작성합니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityAnswer/communityAnswer.dataBasicSkin.php
	 * @manual		menuType=app&mode=communityAnswer&skin=dataBasicSkin
	 * @history
	 *				2014.07.30 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "COMMUNITY_ANSWER_{$intAppID}";
	endif;

	## 스크립트 설정
	if($S_COMMUNITY_EDTOR != "eumEditor2"):
	$aryScriptEx[]				= "/common/eumEditor/highgardenEditor.js";
	else:
	$aryScriptEx[]				= "/common/eumEditor2/js/eumEditor2.js";
	endif;
	$aryScriptEx[]				= "/common/js/jquery.form.js";
	$aryScriptEx[]				= "/common/js/app/communityAnswer/communityAnswer.dataBasicSkin.js";

	## 기본 설정
	$strAppBCode = $EUMSHOP_APP_INFO['bCode'];
	$intAppUbNo = $EUMSHOP_APP_INFO['ubNo'];
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	$strAppLang = $S_SITE_LNG;
	$strAppLangLower = strtolower($strAppLang);
	$strAppBCodeLower = strtolower($strAppBCode);
	$intMemberNo = $g_member_no;
	$strMemberGroup = $g_member_group;
	$strMemberName = $g_member_name; // 영문 - 이름, 한글 - 기록 안됨
	$strMemberLastName = $g_member_last_name; // 영문 - 성, 한글 - 성 + 이름
	$strMemberEmail = $g_member_email;
	$strEditorDir = "community/{$strAppBCodeLower}";

	## 체크
	if(!$strAppBCode):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "b_code가 없습니다.";
		getDebug($param);
		return;
	endif;
	if(!$aryAppBoardInfo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "boardInfo가 없습니다.";
		getDebug($param);
		return;		
	endif;
	if(!$intAppUbNo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "ubNo가 없습니다.";
		getDebug($param);
		return;		
	endif;

	## 커뮤니티 설정 
	$strB_CSS = $aryAppBoardInfo['B_CSS']; // 커뮤니티 css 설정
	$strBI_DATAWRITE_FORM = $aryAppBoardInfo['BI_DATAWRITE_FORM']; // 글쓰기 폼 설정
	$strBI_DATAANSWER_USE = $aryAppBoardInfo['BI_DATAANSWER_USE']; // 답변권환(모든회원/비회원-A, 회원전용-M)
	$aryBI_DATAANSWER_MEMBER_AUTH = $aryAppBoardInfo['BI_DATAANSWER_MEMBER_AUTH'];

	## 답변권한 설정
	if(!in_array($strBI_DATAANSWER_USE, array("A","M"))) { return; }
	if($strBI_DATAANSWER_USE == "M"):
		if(!$intMemberNo):
			goUrl("", "./?menuType=member&mode=login");
		endif;
		if(!in_array($strMemberGroup, $aryBI_DATAANSWER_MEMBER_AUTH)):
			goErrMsg($LNG_TRANS_CHAR["MS00102"]); // 게시판을 사용하실 권한이 없습니다.\\n고객센터로 문의하시기 바랍니다.
			return;	
		endif;
	endif;

	## 회원인경우 추가 설정.
	$strUbName = "";
	if($intMemberNo):
		## 이름 설정. 세션정보에서 다시 가져옵니다.
		if($strMemberName && $strMemberLastName) { $strUbName = "{$strMemberName} {$strMemberLastName}"; }
		else if($strMemberLastName) { $strUbName = $strMemberLastName; }
		else if($strMemberName) { $strUbName = $strMemberName; }
	endif;

	## 비밀번호 설정
	$isPassword = true;
	if($intMemberNo) { $isPassword = false; } // 회원인경우 비밀번호 입력 폼을 숨김.

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
	$aryLanguage['MW00103']	= $LNG_TRANS_CHAR['MW00103']; // 필수항목
	$aryLanguage['MS00104']	= $LNG_TRANS_CHAR['MS00104']; // {{단어1}}을 입력하세요.
	$aryLanguage['MS00107']	= $LNG_TRANS_CHAR['MS00107']; // {{단어1}}은 필수 항목입니다.
	$aryLanguage['BS00002']	= $LNG_TRANS_CHAR['BS00002']; // 수정되었습니다.
	$aryLanguage['MS00119']	= $LNG_TRANS_CHAR['MS00119']; // 첨부파일을 선택하세요.
	$aryLanguage['BS00001']	= $LNG_TRANS_CHAR['BS00001']; // 등록되었습니다.

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['B_CODE'] = $strAppBCode;
	$aryAppParam['UB_NO'] = $intAppUbNo;
	$aryAppParam['LANG'] = $strAppLang;
	$aryAppParam['BI_DATAWRITE_END_MOVE'] = $strBI_DATAWRITE_END_MOVE;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;

?>
<!-- eumshop app - communityAnswer - dataBasicSkin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<?php if($strB_CSS):?>
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.<?php echo $strB_CSS;?>.css"/>
	<?php endif;?>
	<div class="tableFormWrap">
		<form name="answerForm" id="tx_editor_form" method="post" enctype="multipart/form-data" action="./">
		<input type="hidden" name="menuType" value="<?php echo $strMenuType;?>">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="act" value="">
		<input type="hidden" name="b_code" value="<?php echo $strAppBCode;?>">
		<input type="hidden" name="ub_lng" value="<?php echo $strAppLang;?>">
		<input type="hidden" name="ub_no" value="<?php echo $intAppUbNo;?>">
		<input type="hidden" name="ub_p_code" value="">
		<input type="hidden" name="editorDir" value="<?php echo $strEditorDir;?>">
		<table class="tableForm">
			<colgroup>
				<col width="150">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00053"]; // 작성자?><span>*</span></th>
					<td><input type="text" name="ub_name" value="<?php echo $strUbName;?>" maxlength="10" class="_w300" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00053"]; // 작성자?>"<?php if($intMemberNo){echo " readonly";}?>></td>
				</tr>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["MW00010"]; // 이메일?></th>
					<td><input type="text" name="ub_mail" value="<?php echo $strMemberEmail;?>" maxlength="25" class="_w300"></td>
				</tr>
				<?php include "communityAnswer.dataBasicSkin.userfield.inc.php";?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00062"]; // 제목?><span>*</span></th>
					<td><input type="text" name="ub_title" style="width:98%;" maxlength="100" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00062"]; // 제목?>">
						<?php if($isNotice):?>
						<input type="checkbox" name="ub_func_notice"><?php echo $LNG_TRANS_CHAR["CW00068"]; // 공지글?>
						<?php endif;?>
						<?php if($isLock):?>
						<input type="checkbox" name="ub_func_lock"><?php echo $LNG_TRANS_CHAR["CW00070"]; // 비밀글?>
						<?php endif;?>
					</td>
				</tr>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00063"]; // 내용?><span>*</span></th>
					<td><?php if($S_COMMUNITY_EDTOR == "eumEditor2"):?>
						<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
						<textarea name="ub_text" id="ub_text"  style="display:none" check="empty" alt="내용"></textarea>
						<?php else:?>
						<textarea name="ub_text" id="ub_text" title="<?php echo $strBI_DATAWRITE_FORM;?>" style="width:98%;height:300px;" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00063"]; // 내용?>"></textarea>
						<?php endif;?>
					</td>
				</tr>
				<?php if($isPassword):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["MW00002"]; // 비밀번호?><span>*</span></th>
					<td><input type="password" name="ub_pass" class="_w300" maxlength="12" check="empty" alt="<?php echo $LNG_TRANS_CHAR["MW00002"]; // 비밀번호?>"></td>
				</tr>
				<?php endif;?>
				<?php if($isFile):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00058"]; // 첨부파일?><span>*</span></th>
					<td><a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinAtcFormToggleEvent('<?php echo $strAppID;?>');" class="btn_board_write"><strong><?php echo $LNG_TRANS_CHAR["CW00058"]; // 첨부파일?></strong></a>
						<div style="position:relative">
							<div class="atcFileList">
								<?php if($arySessionFileList):?>
								<ul>
									<?php foreach($arySessionFileList as $key => $data):
			
											## 기본 설정
											$isDEL = $data['DEL'];
											$intATC_FL_NO = $data['ATC_FL_NO'];
											$intATC_UB_NO = $data['ATC_UB_NO'];
											$strATC_KEY = $data['ATC_KEY'];
											$strATC_DIR = $data['ATC_DIR'];
											$strATC_FILE = $data['ATC_FILE'];
											$aryRealName = explode("_@_", $strATC_FILE);
											$strHtmlTemp = $aryRealName[1];

											## 이미지 설정
											if(in_array($strATC_KEY, array("listImage", "image", "bigImage"))):
												$strHtmlTemp = "<img src='{$strATC_DIR}/{$strATC_FILE}' style='width:50px;height:50px;'>";
											endif;
									?>
									<li class="left">
										<?php echo $strHtmlTemp;?>
										<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinAtcDeleteActEvent('<?php echo $strAppID;?>', <?php echo $key;?>)">[X]</a>
									</li>
									<?php endforeach;?>
									<div class="clr"></div>
								</ul>
								<?php endif;?>
							</div>
							<div class="atcForm hide" style="position:absolute;background:#ffffff;width:300px;height:300px;border:4px solid #afafaf;top:-345px;">
								<div class="tableForm">
									<table class="tableForm">
										<colgroup>
											<col width="150">
											<col>
										</colgroup>
										<tbody>
											<?php for($i=0;$i<$intBI_ATTACHEDFILE_USE;$i++):
											
													## 기본 설정
													$strAtcName = $aryBI_ATTACHEDFILE_NAME[$i];
											?>
											<tr>
												<th><?php echo $strAtcName;?></th>
												<td>
													<input type="file" name="file_<?php echo $i;?>"/>
												</td>
											</tr>
											<?php endfor;?>
										</tbody>
									</table>	
								</div>
								<div class="btnCenter">
									<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinAtcWriteActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write"><strong><?php echo $LNG_TRANS_CHAR["CW00075"]; // 업로드?></strong></a>
									<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinAtcFormToggleEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_cancel"><strong><?php echo $LNG_TRANS_CHAR["CW00034"]; // 닫기?></strong></a>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<?php endif;?>
			</tbody>
		</table>
		</form>
	</div>
	<div class="btnCenter">
		<a href="javascript:void(0);" onclick="goCommunityAnswerDataBasicSkinAnswerActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write"><strong>답변쓰기</strong></a>
		<a href="javascript:void(0);" onclick="goCommunityAnswerDataBasicSkinCancelMoveEvent();" id="menu_auth_w" class="btn_board_cancel"><strong>취소</strong></a>
	</div>
</div>
<!-- eumshop app - communityAnswer - dataBasicSkin (<?php echo $strAppID?>) -->