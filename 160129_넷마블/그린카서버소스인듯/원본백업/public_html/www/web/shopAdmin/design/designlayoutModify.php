<div class="contentTop">
	<h2>레이아웃 설정</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
	<div class="layouttdst">
		<table>
			<tr>
			<!-- td class="btnPrev"><a href="#"><img src="/shopAdmin/himg/common/btn_prev.gif"/></a></td -->
			<td>
				<img src="/shopAdmin/himg/design/layout_type_A.gif"/>
				<span><input type="radio" name="dl_codeTemp" id="dl_codeTemp" value="A" <?=$myDesignRow[DL_CODE] == "A" ? "checked" : ""?>/>  A 타입</span>
			</td>
			<td>
				<img src="/shopAdmin/himg/design/layout_type_B.gif"  class="ml10"/>
				<span><input type="radio" name="dl_codeTemp" id="dl_codeTemp" value="B"<?=$myDesignRow[DL_CODE] == "B" ? "checked" : " " ?>/> B 타입</span>
			</td>
			<td>
				<img src="/shopAdmin/himg/design/layout_type_C.gif"/>
				<span><input type="radio" name="dl_codeTemp" id="dl_codeTemp" value="C" <?=$myDesignRow[DL_CODE] == "C" ? "checked" : ""?> class="ml10"/> C 타입</span>
			</td>
			<td>
				<img src="<?= DESIGN_LAYOUT_HOME . $myDesignUrl ?>" style="width:153px;height:161px" />
				<span>사용중인 레이아웃</span>
			</td>
			<!-- td class="btnNext"><a href="#"><img src="/shopAdmin/himg/common/btn_next.gif"/></a></td -->
			</tr>
		</table>

		<div class="buttonWrap">
			<a class="btn_blue_big" href="javascript:goDesignlayoutAct('designlayoutModify');"  id="menu_auth_m"><strong>설정하기</strong></a>
		</div>
		<div id="designSample" class="designListWrap">
			<?	
				// 레이아웃 샘플 이미지 출력 
				$i = 0;
				while($row = mysql_fetch_array($sampleRow))		{		
					if ( $row[DM_SAMPLE_IMAGE_1] ) {
						$url = DESIGN_LAYOUT_HOME . $row[DM_SAMPLE_IMAGE_1] ;
						if ( $row[DM_DESIGN_TYPE] == $myDesignRow[DL_CODE] && $row[DM_DESIGN_CODE] == $myDesignRow[DL_DESIGN_CODE] ) {
							echo  "<a href=\"javascript:changeLayoutType(" . $i . ", '" . $row[DM_DESIGN_TYPE] . "', '" . $row[DM_DESIGN_CODE] . "')\" class=\"imgSelected\"><img src=\"" . $url . "\"  /></a>";	
						} else {
							echo  "<a href=\"javascript:changeLayoutType(" . $i  . ", '" . $row[DM_DESIGN_TYPE] . "', '" . $row[DM_DESIGN_CODE] . "')\"><img src=\"" .  $url . "\" /></a>";	
						}
						$i++;
					}	
				}		
			?>
		</div>
	</div>

	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goDesignlayoutAct('designlayoutModify');"  id="menu_auth_m"><strong>설정하기</strong></a>
	</div>

