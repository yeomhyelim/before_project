<?php
	## 스크립트 설정 
	$aryScriptEx[]				= "/common/js/jquery.form.js";
	if($S_COMMUNITY_EDTOR == "eumEditor2"):
	$aryScriptEx[]				= "/common/eumEditor2/js/eumEditor2.js";
	else:
	$aryScriptEx[]				= "/common/eumEditor/highgardenEditor.js";
	endif;
	$aryScriptEx[]				= "./common/js/community_v2.0/data/dataWrte.js";
?>
<div class="contentTop">
	<h2><?php echo $strB_NAME;?></h2>
	<div class="clr"></div>
</div>

<br>

<div class="tableFormWrap">
	<form name="writeForm" id="tx_editor_form" method="post" enctype="multipart/form-data" action="./">
	<input type="hidden" name="menuType" value="community_v2.0">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="b_code" value="<?php echo $strBCode;?>">
	<input type="hidden" name="ub_p_code" value="<?php echo $strPCode;?>">
	<input type="hidden" name="editorDir" value="<?php echo $strEditorDir;?>">
	<table class="tableForm">
		<?php if($intUseLang>1):?>
		<tr>
			<th><?= $LNG_TRANS_CHAR["BW00194"]; //언어 ?></th>
			<td><select name="ub_lng">
					<option value="--"><?= $LNG_TRANS_CHAR["BW00195"]; //언어선택 ?></option>
					<option value="--"><?= $LNG_TRANS_CHAR["CW00022"]; //전체 ?></option>
					<!--
					<?php foreach($aryUseLang as $lng):
							## 기본 설정
							$strLngName = $S_ARY_COUNTRY[$lng];
					?>
					<option value="<?php echo $lng;?>"><?php echo $strLngName;?></option>
					<?php endforeach;?>
					-->
					<?
					$aryCountryLng = array('KR'=>'한국어','US'=>'English','CN'=>'中国语');
					$arrTopSiteUseLng = explode("/",$S_USE_LNG);
					if (count($arrTopSiteUseLng) == 1) array_push($arrTopSiteUseLng, "KR");
					foreach($arrTopSiteUseLng as $lngKey => $lngVal){?>
						<option value="<?=$lngVal?>" <?=($a_admin_lng == $lngVal)?"selected":"";?>><?=$aryCountryLng[$lngVal]?></option>
					<?}?>
				</select>
			</td>
		</tr>
		<?php endif;?>
		<?php if(in_array("카테고리", $aryColumn)):?>
		<tr>
			<th>카테고리</th>
			<td>
				<select name="ub_bc_no">
					<option value="">카테고리 선택</option>
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
			<th class="name"><?= $LNG_TRANS_CHAR["BW00189"]; //작성자 ?><span>*</span></th>
			<td><input type="text" name="ub_name" value="<?php echo $strMemberName;?>" maxlength="10" class="_w300" check="empty" alt="작성자"></td>
		</tr>
		<tr>
			<th class="name"><?= $LNG_TRANS_CHAR["MW00003"]; //이메일 ?></th>
			<td><input type="text" name="ub_mail" value="<?php echo $strMemberEmail;?>" maxlength="25" class="_w300"></td>
		</tr>
		<?php include "dataWrite.userfield.inc.php";?>
		<tr>
			<th class="name"><?= $LNG_TRANS_CHAR["MW00158"]; //제목 ?><span>*</span></th>
			<td><input type="text" name="ub_title" style="width:98%;" maxlength="100" check="empty" alt="제목"><br>
				<input type="checkbox" name="ub_func_notice" value="Y"><?= $LNG_TRANS_CHAR["BW00196"]; //공지글 ?>
				<input type="checkbox" name="ub_func_lock" value="Y"<?php if($strBI_DATAWRITE_LOCK_USE=="E"){echo " checked disabled";}?>> <?= $LNG_TRANS_CHAR["BW00197"]; //비밀글 ?>
			</td>
		</tr>
		<?php if(in_array("점수",$aryColumn)):?>
		<tr>
			<th class="name">평점</th>
			<td><?php for($i=1;$i<=5;$i++):?>
				<input type="radio" name="ub_p_grade" value="<?php echo $i;?>"<?php if($i==5){echo " checked";}?>>
				<img src="/himg/board/icon/icon_star_<?php echo $i;?>.png">
				<?php endfor;?>	
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<th class="name"><?= $LNG_TRANS_CHAR["MW00159"]; //내용 ?><span>*</span></th>
			<td>
				<?php if($S_COMMUNITY_EDTOR == "eumEditor2"):?>
				<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
				<textarea name="ub_text" id="ub_text"  style="display:none" check="empty" alt="내용"></textarea>
				<?php else:?>
				<textarea name="ub_text" id="ub_text" title="<?php echo $strBI_DATAWRITE_FORM;?>" style="width:98%;height:300px;" check="empty" alt="내용"></textarea>
				<?php endif;?>
			</td>
		</tr>
		<?php if($isFile):?>
		<tr>
			<th class="name">첨부파일<span>*</span></th>
			<td><a href="javascript:void(0);" onclick="goCommunityDataWriteAtcFormToggleEvent();" class="btn_blue_sml"><span>첨부파일</span></a>
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
								<a href="javascript:void(0);" onclick="goCommunityDataWriteAtcDeleteActEvent(<?php echo $key;?>)">[X]</a>
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
							<a href="javascript:void(0);" onclick="goCommunityDataWriteAtcWriteActEvent();" class="btn_blue_sml"><span>업로드</span></a>
							<a href="javascript:void(0);" onclick="goCommunityDataWriteAtcFormToggleEvent();" class="btn_blue_sml"><span>닫기</span></a>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<?php endif;?>
	</table>
	</form>
</div>
<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:void(0);" onclick="goCommunityWriteActEvent();" id="menu_auth_w"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"]//등록?></strong></a>
	<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityWriteListMoveEvent();" ><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"]//취소?></strong></a>
</div>