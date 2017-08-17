<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00194"]	//기획전카테고리관리?></h2>
		<div class="clr"></div>
	</div>
	<!-- ******** 컨텐츠 ********* -->
<!-- 언어 선택 탭 -->
<?include "./include/tab_language.inc.php";?>
<!-- 언어 선택 탭-->
<!-- 카테고리 쓰기 -->
<?include "cateWrite.inc.php";?>
<!-- 카테고리 쓰기 -->
	<div class="tableList">
		<table>
			<tr>
				<th style="width:50px;"></th>
				<th><?=$LNG_TRANS_CHAR["PW00021"] //카테고리명?></th>
				<th><?=$LNG_TRANS_CHAR["PW00099"] //카테고리정렬?></th>
				<th><?=$LNG_TRANS_CHAR["PW00094"] //사용여부?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?
				$intIdx = 1;
				if (is_array($aryCate01)){
			
					for($i=0;$i<sizeof($aryCate01);$i++){
						$aryCate02 = $aryCate03 = $aryCate04 = "";
												
						$strCateCode01  = $aryCate01[$i][CATE_CODE];
						if ($aryCate01[$i][CATE_LOW_YN] == "Y"){
							$cateMgr->setC_LEVEL(2);
							$cateMgr->setC_HCODE($aryCate01[$i][CATE_CODE]);
							$cateMgr->setC_VIEW_YN("");
							$aryCate02 = $cateMgr->getCateLevelAry($db);
						}

						$strCate01MouseOver = $strCate01MouseOut = "";
						if ($aryCate01[$i][CATE_IMG2]){
							$strCate01MouseOver = "onmouseover=\"cateMouseOverOut(this,'../upload/category/".strtolower($aryCate01[$i][CATE_LNG])."/".$aryCate01[$i][CATE_IMG2]."')\"";
							$strCate01MouseOut = "onmouseout=\"cateMouseOverOut(this,'../upload/category/".strtolower($aryCate01[$i][CATE_LNG])."/".$aryCate01[$i][CATE_IMG1]."')\"";
						}
			?>
			<tr>
				<td style="width:50px;"><?=$intIdx?></td>
				<td style="text-align:left">
					<strong><?=$aryCate01[$i][CATE_NAME]?>(<?=$aryCate01[$i][CATE_CODE]?>)</strong>
				</td>
				<td><?=$aryCate01[$i][CATE_ORDER]?></td>
				<td><?=$aryCate01[$i][CATE_VIEW_YN]?></td>
				<td>
					<?if ($aryCate01[$i][CATE_SHARE] == "Y"){?>
					<a class="btn_blue_sml" href="javascript:goCateShare(1,'<?=$strCateCode01?>000000000');" id="menu_auth_m" style="display:none"><strong>가상카테고리상품설정</strong></a>
					<?}?>
					<a class="btn_blue_sml" href="javascript:goCateModify('<?=$strCateCode01?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goCateDelete('<?=$strCateCode01?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
			<?

						if (is_array($aryCate02)){
			
							for($ii=0;$ii<sizeof($aryCate02);$ii++){
								
								$aryCate03 = $aryCate04 = "";

								$strCateCode02  = $aryCate01[$i][CATE_CODE];
								$strCateCode02 .= $aryCate02[$ii][CATE_CODE];

								if ($aryCate02[$ii][CATE_LOW_YN] == "Y"){
									$cateMgr->setC_LEVEL(3);
									$cateMgr->setC_HCODE($aryCate01[$i][CATE_CODE].$aryCate02[$ii][CATE_CODE]);
									$cateMgr->setC_VIEW_YN("");
									$aryCate03 = $cateMgr->getCateLevelAry($db);
								}

								$strCate02MouseOver = $strCate02MouseOut = "";
								if ($aryCate02[$ii][CATE_IMG2]){
									$strCate02MouseOver = "onmouseover=\"cateMouseOverOut(this,'../upload/category/".strtolower($aryCate02[$ii][CATE_LNG])."/".$aryCate02[$ii][CATE_IMG2]."')\"";
									$strCate02MouseOut = "onmouseout=\"cateMouseOverOut(this,'../upload/category/".strtolower($aryCate02[$ii][CATE_LNG])."/".$aryCate02[$ii][CATE_IMG1]."')\"";
								}

								$intIdx++;
							?>
			<tr>
				<td><?=$intIdx?></td>
				<td style="text-align:left">
					<span class="cate2"><?=$aryCate02[$ii][CATE_NAME]?>(<?=$aryCate02[$ii][CATE_CODE]?>)</span>					
				</td>
				<td><?=$aryCate02[$ii][CATE_ORDER]?></td>
				<td><?=$aryCate02[$ii][CATE_VIEW_YN]?></td>
				<td>
					<a class="btn_blue_sml" href="javascript:goCateModify('<?=$strCateCode02?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goCateDelete('<?=$strCateCode02?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
							<?
								
							
								if (is_array($aryCate03)){
					
									for($iii=0;$iii<sizeof($aryCate03);$iii++){
										$aryCate04 = "";

										$strCateCode03  = $aryCate01[$i][CATE_CODE];
										$strCateCode03 .= $aryCate02[$ii][CATE_CODE];
										$strCateCode03 .= $aryCate03[$iii][CATE_CODE];

										if ($aryCate03[$iii][CATE_LOW_YN] == "Y"){
											$cateMgr->setC_LEVEL(4);
											$cateMgr->setC_HCODE($aryCate01[$i][CATE_CODE].$aryCate02[$ii][CATE_CODE].$aryCate03[$iii][CATE_CODE]);
											$cateMgr->setC_VIEW_YN("");
											$aryCate04 = $cateMgr->getCateLevelAry($db);
										}
										
										$strCate03MouseOver = $strCate03MouseOut = "";
										if ($aryCate03[$iii][CATE_IMG2]){
											$strCate03MouseOver = "onmouseover=\"cateMouseOverOut(this,'../upload/category/".strtolower($aryCate03[$iii][CATE_LNG])."/".$aryCate03[$iii][CATE_IMG2]."')\"";
											$strCate03MouseOut = "onmouseout=\"cateMouseOverOut(this,'../upload/category/".strtolower($aryCate03[$iii][CATE_LNG])."/".$aryCate03[$iii][CATE_IMG1]."')\"";
										}

										$intIdx++;
										?>

			<tr>
				<td><?=$intIdx?></td>
				<td style="text-align:left">
					<span class="cate3"><?=$aryCate03[$iii][CATE_NAME]?>(<?=$aryCate03[$iii][CATE_CODE]?>)</span>					
				</td>
				<td><?=$aryCate03[$iii][CATE_ORDER]?></td>
				<td><?=$aryCate03[$iii][CATE_VIEW_YN]?></td>
				<td>
					<a class="btn_blue_sml" href="javascript:goCateModify('<?=$strCateCode03?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goCateDelete('<?=$strCateCode03?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
										<?
										if (is_array($aryCate04)){
											for($iiii=0;$iiii<sizeof($aryCate04);$iiii++){
												$strCateCode04  = $aryCate01[$i][CATE_CODE];
												$strCateCode04 .= $aryCate02[$ii][CATE_CODE];
												$strCateCode04 .= $aryCate03[$iii][CATE_CODE];
												$strCateCode04 .= $aryCate04[$iiii][CATE_CODE];

												$strCate04MouseOver = $strCate04MouseOut = "";
												if ($aryCate04[$iiii][CATE_IMG2]){
													$strCate04MouseOver = "onmouseover=\"cateMouseOverOut(this,'../upload/category/".strtolower($aryCate04[$iiii][CATE_LNG])."/".$aryCate04[$iiii][CATE_IMG2]."')\"";
													$strCate04MouseOut = "onmouseout=\"cateMouseOverOut(this,'../upload/category/".strtolower($aryCate04[$iiii][CATE_LNG])."/".$aryCate04[$iiii][CATE_IMG1]."')\"";
												}

												$intIdx++;
												?>
			<tr>
				<td><?=$intIdx?></td>
				<td style="text-align:left">
					<span class="cate4"><?=$aryCate04[$iiii][CATE_NAME]?>(<?=$aryCate04[$iiii][CATE_CODE]?>)</span>					
				</td>
				<td><?=$aryCate04[$iiii][CATE_ORDER]?></td>
				<td><?=$aryCate04[$iiii][CATE_VIEW_YN]?></td>
				<td>
					<a class="btn_blue_sml" href="javascript:goCateModify('<?=$strCateCode04?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goCateDelete('<?=$strCateCode04?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
												<?
											} //->4차 카테고리 완료(for)
										}
									} //->3차 카테고리 완료(for)
								}
							} //->2차 카테고리 완료(for)
						}

						$intIdx++;
					} //->1차 카테고리 완료(for)
				}	
			?>
		</table>
	</div>
	
</div>
<!-- ******** 컨텐츠 ********* -->