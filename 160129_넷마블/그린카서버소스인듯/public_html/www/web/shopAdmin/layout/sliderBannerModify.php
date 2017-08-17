<script type="text/javascript">
	$(document).ready(function(){
		$("#tabSlideBanner").find("#trCnt").each(function(i){
			$("#sb_images_cnt").val(i+1);
		});
	});

	function setSelectBanner(no) {
		// 팝업창으로부터 데이터 받음.
		$("#design_code").text(no);
		$("#im_code").val(no);
//		$("#userTag").text("{{__BANNER_" + no + "__}}");
	}

	function goAddSlideBanner() {
		 var template		= $("#template");
		 $("#tabSlideBanner").append($(template).val());

		 $("#tabSlideBanner").find("#trCnt").each(function(i){
			$(this).attr("class", "numberOrange_" + (i+1) + " mr5");
			$("#sb_images_cnt").val(i+1);
		 });
	}

	function goDeleteSlideBanner(obj) {
		 $(obj).parent().parent().remove();
		 $("#tabSlideBanner").find("#trCnt").each(function(i){
			$(this).attr("class", "numberOrange_" + (i+1) + " mr5");
			$("#sb_images_cnt").val(i+1);
		 });

	}

	function goSliderBannerAct(mode){	
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
</script>
<div class="contentTop">
	<h2>
		<?=$LNG_TRANS_CHAR["BW00163"] //음직이는 배너 관리?>
		<div class="clr"></div>
	</h2>
</div>
<br/>
<!-- 언어탭 //-->
<?php include MALL_ADMIN . "/include/tab_language.inc.php";?>
<!-- 언어탭 //-->
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<!-- 디자인관리의 : 디자인명과 디자인코드 hidden으로 전달 -->	
	<input type="hidden" name="im_code" id="im_code" value="<?=$bannerRow['IM_CODE']?>">

	<table class="mt20" id="tabSlideBanner">
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00164"] //코드?></th>
			<td><!--a href="#" class="btn_sml ml10" id="btnSkinSliderBanner"><span>디자인선택</span></a--> <span id="design_code"><?=$bannerRow['IM_CODE']?></span></td>			
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00165"] //설명?></th>
			<td><input type="text" name="sb_comment" id="sb_comment" <?=$nBox?> value="<?=$bannerRow['SB_COMMENT']?>" style="width:460px" /></td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00172"] //슬라이딩 이미지 수?></th>
			<td> <input type="TEXT" name="sb_images_cnt" id="sb_images_cnt" value="<?=$bannerRow['SB_IMAGES_CNT']?>" readonly />  <a href="javascript:goAddSlideBanner();" class="btn_blue_sml ml10"><span><?=$LNG_TRANS_CHAR["CW00028"] //이미지 추가하기?></span></a></td>
		</tr>
		<!--tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="sb_w_size" value="<?=$bannerRow['SB_W_SIZE']?>" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="sb_h_size" value="<?=$bannerRow['SB_H_SIZE']?>" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr-->
		<tr>	
			<th><?=$LNG_TRANS_CHAR["BW00166"] //링크 타입?></th>
			<td><input type="radio" name="sb_link_type" id="sb_link_type" value="M" <?=($bannerRow['SB_LINK_TYPE']=="M")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BW00167"] //현재 페이지 열기?>
				<input type="radio" name="sb_link_type" id="sb_link_type" value="B" <?=($bannerRow['SB_LINK_TYPE']=="B")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BW00168"] //새창으로 열기?>
				<input type="radio" name="sb_link_type" id="sb_link_type" value="N" <?=($bannerRow['SB_LINK_TYPE']=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BW00169"] //연결 없음?></td>
		</tr>
		<? while($row = mysql_fetch_array($bannerImgResult)) : 
				$strImg 			= sprintf( "<img src='../upload/slider/%s' width=\"100\" />" , $row['SI_IMG']); ?>
		<tr>
			<th><span id="trCnt" class="numberOrange_1 mr5"></span> <?=$LNG_TRANS_CHAR["BW00115"] //적용이미지?><a href="#" onClick="goDeleteSlideBanner(this)">[<?=$LNG_TRANS_CHAR["CW00004"] //삭제?>]</a> </th>
			<td>
				<dl class="tdListUl">
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00144"] //이미지?></span><input type="file" name="si_img[]" id="si_img" <?=$nBox?>  style="height:22px;"/></dd>
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00101"] //링크?></span><input type="text" name="si_link[]" id="si_link" <?=$nBox?> style="width:400px;" value="<?=$row['SI_LINK']?>"/></dd>
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00173"] //카피문구?></span><input type="text" name="si_text[]" id="si_text" <?=$nBox?> style="width:400px;" value="<?=$row['SI_TEXT']?>"/></dd>
					<dd><span class="spanTitle"></span><?=$strImg?></dd>
					<input type="hidden" name="si_no_bak[]" value="<?=$row['SI_NO']?>"/>
				</dl>
			</td>
		</tr>
		<? endwhile; ?>
		<textarea id="template" style="display:none;">
		<tr>
			<th><span id="trCnt" class="numberOrange_1 mr5"></span> <?=$LNG_TRANS_CHAR["BW00115"] //적용이미지?><a href="#" onClick="goDeleteSlideBanner(this)">[<?=$LNG_TRANS_CHAR["CW00004"] //삭제?>]</a> </th>
			<td>
				<dl class="tdListUl">
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00144"] //이미지?></span><input type="file" name="si_img[]" id="si_img" <?=$nBox?>  style="height:22px;"/></dd>
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00101"] //링크?></span><input type="text" name="si_link[]" id="si_link" <?=$nBox?> style="width:400px;"/></dd>
					<dd><span class="spanTitle"><?=$LNG_TRANS_CHAR["BW00173"] //카피문구?></span><input type="text" name="si_text[]" id="si_text" <?=$nBox?> style="width:400px;"/></dd>
				</dl>
			</td>
		</tr>	
		</textarea>
	</table>
</div>
	

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goSliderBannerAct('sliderBannerModify');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00016"] //저장?></strong></a>
	<a class="btn_big" href="javascript:goMoveUrl('sliderBannerList');"><strong><?=$LNG_TRANS_CHAR["CW00001"] //저장?></strong></a>
</div>