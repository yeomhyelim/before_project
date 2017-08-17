<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/layout_v2.0/sliderBanner/sliderBannerWrite.js";
	$aryScriptEx[] = "/common/js/jquery.form.js";
?>
<!-- 제목 //-->
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["BW00163"] //음직이는 배너 관리?></h2>
	<div class="clr"></div>
</div>
<!-- 제목 //-->

<br>

<!-- 움직이는 배너 수정 정보 //-->
<div class="tableForm mt20">
	<form id="formData" method="post" enctype="multipart/form-data" action="./">
	<input type="hidden" name="menuType" value="layout_v2.0">
	<input type="hidden" name="mode" value="json">
	<input type="hidden" name="act" value="sliderBannerWrite">
	<input type="hidden" name="sb_no" value="<?php echo $intSbNo;?>">
	<input type="hidden" name="lang" value="<?php echo $strStLng;?>">
	<table class="mt20" id="tabSlideBanner">
		<tr>
			<th><?php echo $LNG_TRANS_CHAR["BW00164"]; //코드?></th>
			<td><input type="text" name="sb_code" id="sb_code" <?=$nBox?> value="" style="width:100px" data-auto-focus/></td>
		</tr>
		<tr>
			<th><?php echo $LNG_TRANS_CHAR["BW00165"]; //설명?></th>
			<td><input type="text" name="sb_comment" id="sb_comment" <?=$nBox?> value="" style="width:460px" /></td>
		</tr>
		<tr>
			<th><?php echo $LNG_TRANS_CHAR["BW00172"]; //슬라이딩 이미지 수?></th>
			<td> <input type="TEXT" name="sb_images_cnt" id="sb_images_cnt" value="1" <?=$nBox?> readonly />  <a href="javascript:goLayoutSliderBannerWriteImageAddEvent();" class="btn_blue_sml ml10"><span><?=$LNG_TRANS_CHAR["CW00028"] //이미지 추가하기?></span></a></td>
		</tr>
		<tr>	
			<th><?=$LNG_TRANS_CHAR["BW00166"] //링크 타입?></th>
			<td><input type="radio" name="sb_link_type" id="sb_link_type" value="M" checked/><?=$LNG_TRANS_CHAR["BW00167"] //현재 페이지 열기?>
				<input type="radio" name="sb_link_type" id="sb_link_type" value="B"/><?=$LNG_TRANS_CHAR["BW00168"] //새창으로 열기?>
				<input type="radio" name="sb_link_type" id="sb_link_type" value="N"/><?=$LNG_TRANS_CHAR["BW00169"] //연결 없음?></td>
		</tr>
		<tr class="sliderImageForm" idx="1">
			<th><span id="trCnt" class="numberOrange_1 mr5"></span> <?=$LNG_TRANS_CHAR["BW00115"] //적용이미지?><a href="javascript:goLayoutSliderBannerWriteImageDeleteEvent('1')" id="btnDelete">[<?=$LNG_TRANS_CHAR["CW00004"] //삭제?>]</a> </th>
			<td>
				<dl class="tdListUl">
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00144"] //이미지?></span><input type="file" name="si_img_0" id="si_img" <?=$nBox?>  style="height:22px;"/></dd>
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00101"] //링크?></span><input type="text" name="si_link[]" id="si_link" <?=$nBox?> style="width:400px;" value=""/></dd>
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00173"] //카피문구?></span><input type="text" name="si_text[]" id="si_text" <?=$nBox?> style="width:400px;" value=""/></dd>
				</dl>
			</td>
		</tr>
	</table>
	</form>
</div>
<!-- 움직이는 배너 수정 정보 //-->

<!-- 버튼 정의 //-->
<div class="buttonWrap">
	<a href="javascript:goLayoutSliderBannerWriteActEvent();" id="menu_auth_m" class="btn_blue_big" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00016"] //저장?></strong></a>
	<a href="javascript:goLayoutSliderBannerWriteListMoveEvent();" class="btn_big" ><strong><?=$LNG_TRANS_CHAR["CW00001"] //저장?></strong></a>
</div>
<!-- 버튼 정의 //-->