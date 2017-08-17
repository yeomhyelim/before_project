<div style="max-width:1000px;">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00147"] //레이아웃 설정?></h2>
		<div class="clr"></div>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->
	<div class="layouttdst">
		
		<table>
			<tr>
			<!-- td class="btnPrev"><a href="#"><img src="/shopAdmin/himg/common/btn_prev.gif"/></a></td -->
			<td>
				<img src="/shopAdmin/himg/layout/design_type/layout_type_A.gif"/>
				<span><input type="radio" name="dl_codeTemp" id="dl_codeTemp" value="A" <?=$layoutRow['TYPE'] == "A" ? "checked" : ""?>/>  <strong><?=$LNG_TRANS_CHAR["BW00148"] //A타입?></strong> <?=$LNG_TRANS_CHAR["BW00151"] //레이아웃?></span>
			</td>
			<td>
				<img src="/shopAdmin/himg/layout/design_type/layout_type_B.gif"  class="ml10"/>
				<span><input type="radio" name="dl_codeTemp" id="dl_codeTemp" value="B"<?=$layoutRow['TYPE'] == "B" ? "checked" : " " ?>/> <strong><?=$LNG_TRANS_CHAR["BW00149"] //B타입?></strong> <?=$LNG_TRANS_CHAR["BW00151"] //레이아웃?></span>
			</td>
			<td>
				<img src="/shopAdmin/himg/layout/design_type/layout_type_C.gif"/>
				<span><input type="radio" name="dl_codeTemp" id="dl_codeTemp" value="C" <?=$layoutRow['TYPE'] == "C" ? "checked" : ""?> class="ml10"/> <strong><?=$LNG_TRANS_CHAR["BW00150"] //C타입?></strong> <?=$LNG_TRANS_CHAR["BW00151"] //레이아웃?></span>
			</td>
			<td>
				<div id="useDesign"></div>
				<span><?=$LNG_TRANS_CHAR["BW00152"] //사용중인 레이아웃?></span>
			</td>
			<!-- td class="btnNext"><a href="#"><img src="/shopAdmin/himg/common/btn_next.gif"/></a></td -->
			</tr>
		</table>

		<div class="buttonWrap">
			<? if($S_LAYOUT_SETUP_USE != "Y" ): ?>
			<a class="btn_Big_Blue" href="javascript:alert('<?=$LNG_TRANS_CHAR["BS00076"] //디자인 별도타입이므로 수정할 수 없습니다.?>');"  id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00052"] //설정하기?></strong></a>
			<? else: ?>
			<a class="btn_Big_Blue" href="javascript:goDesignlayoutAct('layoutSaveModify');"  id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["BS00077"] //선택 디자인 타입으로 적용?></strong></a>			
			<? endif; ?>
		</div>
		
		<div id="designSample" class="designListWrap"></div>


	</div>
</div>

