<script type="text/javascript">
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
	
<!-- 디자인관리의 : 디자인명과 디자인코드 hidden으로 전달 -->
<!--input type="hidden" name="im_code" id="im_code" value="<?=$strIM_CODE?>"-->

<div class="contentTop">
	<h2>
		<?=$LNG_TRANS_CHAR["BW00163"] //음직이는 배너 관리?>
		<div class="clr"></div>
	</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table class="mt20" id="tabSlideBanner">
		<!--tr>
			<th>디자인타입</th>
			<td>
				<a href="#" class="btn_sml ml10" id="btnSkinSliderBanner"><span>디자인선택</span></a> <span id="design_code"></span>
			</td>
		</tr-->
		<!--tr>
			<th>예약어</th>
			<td><strong id="userTag"></strong></td>
		</tr -->
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00164"] //코드?></th>
			<td><input type="text" name="im_code" id="im_code" <?=$nBox?> value="" style="width:100px" /></td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00165"] //설명?></th>
			<td><input type="text" name="sb_comment" id="sb_comment" <?=$nBox?> value="" style="width:460px" /></td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00172"] //슬라이딩 이미지 수?></th>
			<td><input type="text" name="sb_images_cnt" id="sb_images_cnt" <?=$nBox?> value="1" />
				<a href="javascript:goAddSlideBanner();" class="btn_blue_sml ml10"><span><?=$LNG_TRANS_CHAR["CW00028"] //이미지 추가하기?></span></a></td>
		</tr>
		<!--tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="sb_w_size" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="sb_h_size" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr-->
		<tr>	
			<th><?=$LNG_TRANS_CHAR["BW00166"] //링크 타입?></th>
			<td><input type="radio" name="sb_link_type" id="sb_link_type" value="M" checked/><?=$LNG_TRANS_CHAR["BW00167"] //현재 페이지 열기?>
				<input type="radio" name="sb_link_type" id="sb_link_type" value="B" class="ml10"/><?=$LNG_TRANS_CHAR["BW00168"] //새창으로 열기?> 						
				<input type="radio" name="sb_link_type" id="sb_link_type" value="N" class="ml10"/><?=$LNG_TRANS_CHAR["BW00169"] //연결 없음?></td>
		</tr>
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
	<a href="javascript:goSliderBannerAct('sliderBannerWrite');" class="btn_blue_big" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00016"] //저장?></strong></a>
</div>