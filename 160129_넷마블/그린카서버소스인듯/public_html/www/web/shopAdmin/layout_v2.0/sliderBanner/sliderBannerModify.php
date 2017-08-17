<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/layout_v2.0/sliderBanner/sliderBannerModify.js";
	$aryScriptEx[] = "/common/js/jquery.form.js";
?>
<!-- 제목 //-->
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["BW00163"] //음직이는 배너 관리?></h2>
	<div class="clr"></div>
</div>
<!-- 제목 //-->

<br>

<!-- 언어탭 //-->
<?php include MALL_ADMIN . "/include/tab_language.inc.php";?>
<!-- 언어탭 //-->

<!-- 움직이는 배너 수정 정보 //-->
<div class="tableForm mt20">
	<form id="formData" method="post" enctype="multipart/form-data" action="./">
	<input type="hidden" name="menuType" value="layout_v2.0">
	<input type="hidden" name="mode" value="json">
	<input type="hidden" name="act" value="sliderBannerModify">
	<input type="hidden" name="sb_no" value="<?php echo $intSbNo;?>">
	<input type="hidden" name="lang" value="<?php echo $strStLng;?>">
	<table class="mt20" id="tabSlideBanner">
		<tr>
			<th><?php echo $LNG_TRANS_CHAR["BW00164"]; //코드?></th>
			<td><span id="design_code"><?php echo $strSB_CODE;?></span></td>			
		</tr>
		<tr>
			<th><?php echo $LNG_TRANS_CHAR["BW00165"]; //설명?></th>
			<td><input type="text" name="sb_comment" id="sb_comment" <?=$nBox?> value="<?php echo $strSB_COMMENT;?>" style="width:460px" /></td>
		</tr>
		<tr>
			<th><?php echo $LNG_TRANS_CHAR["BW00172"]; //슬라이딩 이미지 수?></th>
			<td> <input type="TEXT" name="sb_images_cnt" id="sb_images_cnt" value="<?php echo $intImageCnt;?>" readonly />  <a href="javascript:goLayoutSliderBannerModifyImageAddEvent();" class="btn_blue_sml ml10"><span><?=$LNG_TRANS_CHAR["CW00028"] //이미지 추가하기?></span></a></td>
		</tr>
		<tr>	
			<th><?=$LNG_TRANS_CHAR["BW00166"] //링크 타입?></th>
			<td><input type="radio" name="sb_link_type" id="sb_link_type" value="M"<?php if($strSB_LINK_TYPE=="M"){echo " checked";}?>/><?=$LNG_TRANS_CHAR["BW00167"] //현재 페이지 열기?>
				<input type="radio" name="sb_link_type" id="sb_link_type" value="B"<?php if($strSB_LINK_TYPE=="B"){echo " checked";}?>/><?=$LNG_TRANS_CHAR["BW00168"] //새창으로 열기?>
				<input type="radio" name="sb_link_type" id="sb_link_type" value="N"<?php if($strSB_LINK_TYPE=="N"){echo " checked";}?>/><?=$LNG_TRANS_CHAR["BW00169"] //연결 없음?></td>
		</tr>
		<?php if($aryImageRow):?>
		<?php foreach($aryImageRow as $key => $data):

				## 기본설정
				$intSI_NO = $data['SI_NO'];
				$strSI_IMG = $data['SI_IMG'];
				$strSI_LINK = $data['SI_LINK'];
				$strSI_TEXT = $data['SI_TEXT'];

				## 이미지 설정
				if($strSI_IMG) { $strSI_IMG = "{$strWebDir}/{$strSI_IMG}"; }
				
		?>
		<tr class="sliderImageForm" idx="<?php echo ++$intIdx;?>">
			<th><span id="trCnt" class="numberOrange_<?php echo $intIdx;?> mr5"></span> <?=$LNG_TRANS_CHAR["BW00115"] //적용이미지?><a href="javascript:goLayoutSliderBannerModifyImageDeleteEvent('<?php echo $intIdx;?>')" id="btnDelete">[<?=$LNG_TRANS_CHAR["CW00004"] //삭제?>]</a> </th>
			<td>
				<dl class="tdListUl">
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00144"] //이미지?></span><input type="file" name="si_img_<?php echo ($intIdx-1);?>" id="si_img" <?=$nBox?>  style="height:22px;"/></dd>
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00101"] //링크?></span><input type="text" name="si_link[]" id="si_link" <?=$nBox?> style="width:400px;" value="<?php echo $strSI_LINK;?>"/></dd>
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00173"] //카피문구?></span><input type="text" name="si_text[]" id="si_text" <?=$nBox?> style="width:400px;" value="<?php echo $strSI_TEXT;?>"/></dd>
					<dd><span class="spanTitle"></span>
						<?php if($strSI_IMG):?>
						<img src="<?php echo $strSI_IMG;?>" style="width:100px">
						<?php endif;?>
					</dd>
				</dl>
				<input type="hidden" name="si_no_bak[]" value="<?php echo $intSI_NO;?>"/>
			</td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
	</table>
	</form>
</div>
<!-- 움직이는 배너 수정 정보 //-->

<!-- 버튼 정의 //-->
<div class="buttonWrap">
	<a href="javascript:goLayoutSliderBannerModifyActEvent();" id="menu_auth_m" class="btn_blue_big" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00016"] //저장?></strong></a>
	<a href="javascript:goLayoutSliderBannerModifyListMoveEvent();" class="btn_big" ><strong><?=$LNG_TRANS_CHAR["CW00001"] //저장?></strong></a>
</div>
<!-- 버튼 정의 //-->