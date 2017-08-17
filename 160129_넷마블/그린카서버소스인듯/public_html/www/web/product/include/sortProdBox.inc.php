<script type="text/javascript">
<!--
//전체조건검색레이어닫기
function goLayerSearchClose(){
	$("#popProductAllView").attr("style","display:none;");
}

//전체조건 검색
function goDetailSearch(){
	$("#topSearchKeyword").val($("input[name='searchKey']").val());
	var doc = document.form;
	doc.sort.value = doc.detailSort.value;
	doc.mode.value = "search";
	doc.page.value = 1;
	doc.method = 'get';
	doc.submit();
}

//검색초기화
function goDetailSearchZero(){
	$(":checkbox").attr("checked",false);
	//location.href='./?menuType=product&mode=list&lcate=<?=$strSearchHCode1;?>&mcate=<?=$strSearchHCode2;?>&scate=<?=$strSearchHCode3;?>';
}
//-->
</script>
		
		<div class="productAllView" id="allViewBox">
			<span class="txt"><a class="btnAllViewBox"><?= $LNG_TRANS_CHAR["CW00091"] //상세검색 ?></a></span>
			<div id="popProductAllView" class="popProductAllView" style="display:none;">
				<div class="popProductAll">
					<a href="javascript:goLayerSearchClose();" class="popClose">Close</a>
					<table>
						<tr>
							<th><?=$LNG_TRANS_CHAR["PW00028"] //원산지 ?></th>
							<td class="optList firstLine">
								<ul>
								<?php
								$k = 0;
								for($i=0;$i < sizeof($aryProductOrigin); $i++){
									$k = $i+1;
								?>
									<li><input type="checkbox" name="searchOrigin<?php echo $k;?>" value="<?=$aryProductOrigin[$i][COL]?>" <?php echo ($aryProductOrigin[$i][COL] == $arySearchOrigin[1][$i]) ? "checked" : "";?>> <?=$aryCountryList[$aryProductOrigin[$i][COL]]?></li>
								<?php
								}
								?>
								</ul>
							</td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["CW00064"] //카테고리 ?></th>
							<td class="optList cateList">
								<ul>
								<?php 
								$k = 0;
								for($i=0;$i < sizeof($aryCategorys); $i++){
									$k = $i+1;
								?>
									<li><input type="checkbox" name="searchLCate<?php echo $k;?>" value="<?php echo $aryCategorys[$i][CATE_CODE]?>" <?php echo ($aryCategorys[$i][CATE_CODE] == $arySearchLCate[1][$i]) ? "checked" : "";?>  > <?php echo $aryCategorys[$i][CATE_NAME]?></li>
								<?php
								}
								?>
								</ul>
							</td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["PW00062"] //즉시구매 ?></th>
							<td class="optList">
								<ul>
									<li><input type="checkbox" name="searchPriceFilter1" value="EXW" <?php echo ($arySearchPriceFilter[1][0] == "EXW") ? "checked" : "";?>> <?=$LNG_TRANS_CHAR["PW00062"] //즉시구매 ?> </li>
									<li><input type="checkbox" name="searchPriceFilter2" value="FOB" <?php echo ($arySearchPriceFilter[1][1] == "FOB") ? "checked" : "";?>> <?=$LNG_TRANS_CHAR["PW00087"] //문의구매 ?></li>
								</ul>
							</td>
						</tr>
						<tr>
							<th>TYPE</th>
							<td class="optList">
								<ul>
									<li><input type="checkbox" name="searchType1" value="S" <?php echo ($arySearchType[1][0] == "S") ? "checked" : "";?>> <?=$LNG_TRANS_CHAR["CW00092"] //공급사 ?></li>
									<li><input type="checkbox" name="searchType2" value="M" <?php echo ($arySearchType[1][1] == "M") ? "checked" : "";?>> <?=$LNG_TRANS_CHAR["CW00093"] //제조사 ?></li>
									<!--// 제조/공급사 삭제요청. 남덕희
									<li><input type="checkbox" name="searchType3" value="B" <?php echo ($arySearchType[1][2] == "B") ? "checked" : "";?>> <?=$LNG_TRANS_CHAR["CW00094"] //제조/공급사 ?></li>
									-->
								</ul>
							</td>
						</tr>
						
						<tr>
							<th><?=$LNG_TRANS_CHAR["PW00086"] //가격순 ?></th>
							<td class="optList">
								<ul>
									<li><input type="radio" name="detailSort" value="RD" <?php echo ($strSearchSort == "RD") ? "checked" : "";?>> <?=$LNG_TRANS_CHAR["PW00035"] //높은가격순 ?></li>
									<li><input type="radio" name="detailSort" value="RA" <?php echo ($strSearchSort == "RA") ? "checked" : "";?>> <?=$LNG_TRANS_CHAR["PW00034"] //낮은가격순 ?></li>
								</ul>
							</td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["PW00083"] //등급 ?></th>
							<td class="typeWrap">
								<ul>
									<li class="tit"><?= $LNG_TRANS_CHAR["CW00114"]; //신용등급 ?></li>
									<li><input type="checkbox" name="searchCreditGrade1" value="G" <?php echo ($arySearchCreditGrade[1][0] == "G") ? "checked" : "";?>> <img src="<?php echo $aryCreditGradeImg["G"];?>"> <?=$LNG_TRANS_CHAR["CW00095"] //골드등급 ?></li>
									<li><input type="checkbox" name="searchCreditGrade2" value="S" <?php echo ($arySearchCreditGrade[1][1] == "S") ? "checked" : "";?>> <img src="<?php echo $aryCreditGradeImg["S"];?>"> <?=$LNG_TRANS_CHAR["CW00096"] //실버등급 ?></li>
									<li><input type="checkbox" name="searchCreditGrade3" value="B" <?php echo ($arySearchCreditGrade[1][2] == "B") ? "checked" : "";?>> <img src="<?php echo $aryCreditGradeImg["B"];?>"> <?=$LNG_TRANS_CHAR["CW00097"] //일반등급 ?></li>
								</ul>
								<ul>
									<li class="tit"><?= $LNG_TRANS_CHAR["CW00113"]; //판매등급 ?></li>
									<li><input type="checkbox" name="searchSaleGrade1" value="B" <?php echo ($arySearchSaleGrade[1][0] == "B") ? "checked" : "";?>> <img src="<?php echo $arySaleGradeImg["B"];?>"> <?=$LNG_TRANS_CHAR["CW00098"] //최우수등급 ?></li>
									<li><input type="checkbox" name="searchSaleGrade2" value="E" <?php echo ($arySearchSaleGrade[1][1] == "E") ? "checked" : "";?>> <img src="<?php echo $arySaleGradeImg["E"];?>"> <?=$LNG_TRANS_CHAR["CW00099"] //우수등급 ?></li>
									<li><input type="checkbox" name="searchSaleGrade3" value="G" <?php echo ($arySearchSaleGrade[1][2] == "G") ? "checked" : "";?>> <img src="<?php echo $arySaleGradeImg["G"];?>"> <?=$LNG_TRANS_CHAR["CW00100"] //일반등급 ?></li>
								</ul>
								<ul>
									<li class="tit"><?= $LNG_TRANS_CHAR["CW00115"]; //현장확인 ?></li>
									<li><input type="checkbox" name="searchLocusGrade1" value="Y" <?php echo ($arySearchLocusGrade[1][0] == 'Y') ? "checked" : "";?>> <img src="<?php echo $aryLocusGradeImg["Y"];?>"> <?=$LNG_TRANS_CHAR["CW00101"] //확인 ?></li>
									<li><input type="checkbox" name="searchLocusGrade2" value="N" <?php echo ($arySearchLocusGrade[1][1] == 'N') ? "checked" : "";?>> <img src="<?php echo $aryLocusGradeImg["N"];?>"> <?=$LNG_TRANS_CHAR["CW00102"] //미확인 ?></li>
								</ul>
								<div class="clr"></div>
							</td>
						</tr>
					</table>
					<div class="popBtnWrap">
						<a href="javascript:goDetailSearch();" class="btnClk"><?= $LNG_TRANS_CHAR["CW00061"] //검색 ?></a>
						<a href="javascript:goDetailSearchZero();"><?= $LNG_TRANS_CHAR["CW00103"] //검색초기화 ?></a>
					</div>
				</div>
			</div>
		</div>