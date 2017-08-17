	<style>
	<!--
	br{mso-data-placement:same-cell;}
	td{mso-number-format:"\@";}
	-->
	</style>
		<table border="1">
			<tr>
				<th>1차카테고리</th>
				<th>2차카테고리</th>
				<th>3차카테고리</th>
				<th>4차카테고리</th>
				<th><?="카테고리코드" //카테고리코드?></th>
				<th><?=$LNG_TRANS_CHAR["PW00099"] //카테고리정렬?></th>
				<th><?=$LNG_TRANS_CHAR["PW00094"] //사용여부?></th>
			</tr>
			<?
				if (is_array($aryCate01)){
			
					for($i=0;$i<sizeof($aryCate01);$i++){
						$aryCate02 = $aryCate03 = $aryCate04 = "";
											
						$strCateCode01  = $aryCate01[$i][CATE_CODE];
		//				if ($aryCate01[$i][CATE_LOW_YN] == "Y"){
							$cateMgr->setC_LEVEL(2);
							$cateMgr->setC_HCODE($aryCate01[$i][CATE_CODE]);
							$cateMgr->setC_VIEW_YN("");
							$aryCate02 = $cateMgr->getCateLevelAry($db);
		//				}
			?>
			<tr>
				<td><?=$aryCate01[$i][CATE_NAME]?></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?=$aryCate01[$i][CATE_CODE]?></td>
				<td><?=$aryCate01[$i][CATE_ORDER]?></td>
				<td><?=$aryCate01[$i][CATE_VIEW_YN]?></td>
			</tr>
			<?

						if (is_array($aryCate02)){
			
							for($ii=0;$ii<sizeof($aryCate02);$ii++){
								
								$aryCate03 = $aryCate04 = "";

								$strCateCode02  = $aryCate01[$i][CATE_CODE];
								$strCateCode02 .= $aryCate02[$ii][CATE_CODE];

			//					if ($aryCate02[$ii][CATE_LOW_YN] == "Y"){
									$cateMgr->setC_LEVEL(3);
									$cateMgr->setC_HCODE($aryCate01[$i][CATE_CODE].$aryCate02[$ii][CATE_CODE]);
									$cateMgr->setC_VIEW_YN("");
									$aryCate03 = $cateMgr->getCateLevelAry($db);
			//					}

							?>
			<tr>
				<td></td>
				<td><?=$aryCate02[$ii][CATE_NAME]?></td>
				<td></td>
				<td></td>
				<td><?=$aryCate01[$i][CATE_CODE]?><?=$aryCate02[$ii][CATE_CODE]?></td>
				<td><?=$aryCate02[$ii][CATE_ORDER]?></td>
				<td><?=$aryCate02[$ii][CATE_VIEW_YN]?></td>
			</tr>
							<?
								
							
								if (is_array($aryCate03)){
					
									for($iii=0;$iii<sizeof($aryCate03);$iii++){
										$aryCate04 = "";

										$strCateCode03  = $aryCate01[$i][CATE_CODE];
										$strCateCode03 .= $aryCate02[$ii][CATE_CODE];
										$strCateCode03 .= $aryCate03[$iii][CATE_CODE];

				//						if ($aryCate03[$iii][CATE_LOW_YN] == "Y"){
											$cateMgr->setC_LEVEL(4);
											$cateMgr->setC_HCODE($aryCate01[$i][CATE_CODE].$aryCate02[$ii][CATE_CODE].$aryCate03[$iii][CATE_CODE]);
											$cateMgr->setC_VIEW_YN("");
											$aryCate04 = $cateMgr->getCateLevelAry($db);
				//						}
										
										?>

			<tr>
				<td></td>
				<td></td>
				<td><?=$aryCate03[$iii][CATE_NAME]?></td>
				<td></td>
				<td><?=$aryCate01[$i][CATE_CODE]?><?=$aryCate02[$ii][CATE_CODE]?><?=$aryCate03[$iii][CATE_CODE]?></td>
				<td><?=$aryCate03[$iii][CATE_ORDER]?></td>
				<td><?=$aryCate03[$iii][CATE_VIEW_YN]?></td>
			</tr>
										<?
										if (is_array($aryCate04)){
											for($iiii=0;$iiii<sizeof($aryCate04);$iiii++){
												$strCateCode04  = $aryCate01[$i][CATE_CODE];
												$strCateCode04 .= $aryCate02[$ii][CATE_CODE];
												$strCateCode04 .= $aryCate03[$iii][CATE_CODE];
												$strCateCode04 .= $aryCate04[$iiii][CATE_CODE];

												?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td><?=$aryCate04[$iiii][CATE_NAME]?></td>
				<td><?=$aryCate01[$i][CATE_CODE]?><?=$aryCate02[$ii][CATE_CODE]?><?=$aryCate03[$iii][CATE_CODE]?><?=$aryCate04[$iiii][CATE_CODE]?></td>
				<td><?=$aryCate04[$iiii][CATE_ORDER]?></td>
				<td><?=$aryCate04[$iiii][CATE_VIEW_YN]?></td>
			</tr>
												<?
											} //->4차 카테고리 완료(for)
										}
									} //->3차 카테고리 완료(for)
								}
							} //->2차 카테고리 완료(for)
						}
					} //->1차 카테고리 완료(for)
				}	
			?>
		</table>