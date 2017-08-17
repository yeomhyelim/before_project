<?php
	## 기본설정
	$intCateCount = 0;
	$strStLngLower = strtolower($strStLng);

	## 언어 설정
	$strLang = $_GET['lang'];
	if(!$strLang) { $strLang = $S_ST_LNG; }
	$strLangLower = strtolower($strLang);



?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00112"] //카테고리관리?></h2>
		<div class="clr"></div>
	</div>
	<!-- 언어탭 //-->
	<?php include MALL_HOME . "/web/shopAdmin/include/tab_language.inc.php";?>
	<!-- 언어탭 //-->
	<!-- 카테고리 엑셀다운로드, 신규 등록 버튼 //-->

	<?php include MALL_HOME . "/web/shopAdmin/product/cate/cateWrite.inc.php";?>
	<!-- 카테고리 엑셀다운로드, 신규 등록 버튼 //-->
	<!-- 리스트 //-->

	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col width="50"/>
				<col width="100"/>
				<col/>
				<col/>
				<col/>
				<col width="170"/>
			<colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"]//번호?></th>
				<th><?=$LNG_TRANS_CHAR["EW00137"]//이미지?></th>
				<th>[CODE] <?=$LNG_TRANS_CHAR["PW00021"] //카테고리명?></th>
				<th><?=$LNG_TRANS_CHAR["PW00186"] //정렬순서?></th>
				<th><?=$LNG_TRANS_CHAR["PW00094"] //사용여부?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<!-- 1차 카테고리 //-->
			<?php if($aryCate01):?>
			<?php foreach($aryCate01 as $key1 => $data1):
					
					## 기본 설정
					$strCATE_CODE1 = $data1['CATE_CODE'];
					$strCATE_NAME = $data1['CATE_NAME'];
					$strCATE_IMG1 = $data1['CATE_IMG1'];
					$intCATE_ORDER = $data1['CATE_ORDER'];
					$strCATE_VIEW_YN = $data1['CATE_VIEW_YN'];
					$strCATE_SHARE = $data1['CATE_SHARE'];
					$strHref = "/{$strStLngLower}/?menuType=product&mode=list&lcate={$strCATE_CODE1}";
					$strCATE_CODE = $strCATE_CODE1;
					$strFullCateCode = str_pad($strCATE_CODE1, 12, "0");

					## 체크
					if(!$strCATE_VIEW_YN) { $strCATE_VIEW_YN ="N"; }
						
					## 2차 카테고리 검색	
					$cateMgr->setC_LEVEL(2);
					$cateMgr->setC_HCODE($strCATE_CODE);
					$cateMgr->setC_VIEW_YN("");
					$aryCate02 = $cateMgr->getCateLevelAry($db);

					## 이미지 설정
					if($strCATE_IMG1):
						$strCATE_IMG1 = "/upload/category/{$strLangLower}/{$strCATE_IMG1}";
					endif;
			?>
			<tr>
				<td><?php echo ++$intCateCount;?></td>
				<td style="width:100px;text-align:left">
					<?php if($strCATE_IMG1):?>
					<img src="<?php echo $strCATE_IMG1;?>">
					<?php endif;?>
				</td>
				<td style="text-align:left">
					[<?php echo $strCATE_CODE1;?>] <strong><?php echo $strCATE_NAME;?></strong>
					<a href="<?php echo $strHref;?>" target="_brank" class="rightAlign"><img src="/shopAdmin/himg/common/btn_cate_url.gif"></a>
					<div class="clr"></div>
				</td>
				<td><?php echo $intCATE_ORDER;?></td>
				<td><img src="/shopAdmin/himg/common/ico_view_<?php echo $strCATE_VIEW_YN;?>.gif"></td>
				<td>
					<?php if($strCATE_SHARE == "Y"):?>
					<a class="btn_blue_sml" href="javascript:goCateShare(1,'<?php echo $strFullCateCode;?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00276"]//가상카테고리상품설정?></strong></a>
					<?php endif;?>
					<a class="btn_blue_sml" href="javascript:goCateModify('<?php echo $strCATE_CODE1;?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goCateWrite('','');" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
					<a class="btn_sml" href="javascript:goCateDelete('<?php echo $strCATE_CODE1;?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
			<!-- 2차 카테고리 //-->
			<?php if($aryCate02):?>
			<?php foreach($aryCate02 as $key2 => $data2):
					## 기본 설정
					$strCATE_CODE2 = $data2['CATE_CODE'];
					$strCATE_NAME = $data2['CATE_NAME'];
					$strCATE_IMG1 = $data2['CATE_IMG1'];
					$intCATE_ORDER = $data2['CATE_ORDER'];
					$strCATE_VIEW_YN = $data2['CATE_VIEW_YN'];
					$strCATE_SHARE = $data2['CATE_SHARE'];
					$strHref = "/{$strStLngLower}/?menuType=product&mode=list&lcate={$strCATE_CODE1}&mcate={$strCATE_CODE2}";
					$strCATE_CODE = $strCATE_CODE1 . $strCATE_CODE2;
					$strFullCateCode = str_pad($strCATE_CODE, 12, "0");

					## 체크
					if(!$strCATE_VIEW_YN) { $strCATE_VIEW_YN ="N"; }

					## 3차 카테고리 검색	
					$cateMgr->setC_LEVEL(3);
					$cateMgr->setC_HCODE($strCATE_CODE);
					$cateMgr->setC_VIEW_YN("");
					$aryCate03 = $cateMgr->getCateLevelAry($db);	

					## 이미지 설정
					if($strCATE_IMG1):
						$strCATE_IMG1 = "/upload/category/{$strLangLower}/{$strCATE_IMG1}";
					endif;	
			?>
			<tr>
				<td><?php echo ++$intCateCount;?></td>
				<td style="width:100px;text-align:left">
					<?php if($strCATE_IMG1):?>
					<img src="<?php echo $strCATE_IMG1;?>">
					<?php endif;?>
				</td>
				<td style="text-align:left">
					<span class="cate2">&nbsp;</span>
					[<?php echo $strCATE_CODE;?>] <strong><?php echo $strCATE_NAME;?></strong>
					<a href="<?php echo $strHref;?>" target="_brank" class="rightAlign"><img src="/shopAdmin/himg/common/btn_cate_url.gif"></a>
					<div class="clr"></div>
				</td>
				<td><?php echo $intCATE_ORDER;?></td>
				<td><img src="/shopAdmin/himg/common/ico_view_<?php echo $strCATE_VIEW_YN;?>.gif"></td>
				<td>
					<?php if($strCATE_SHARE == "Y"):?>
					<a class="btn_blue_sml" href="javascript:goCateShare(1,'<?php echo $strFullCateCode;?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00276"]//가상카테고리상품설정?></strong></a>
					<?php endif;?>
					<a class="btn_blue_sml" href="javascript:goCateModify('<?php echo $strCATE_CODE;?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goCateWrite('','');" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
					<a class="btn_sml" href="javascript:goCateDelete('<?php echo $strCATE_CODE;?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
			<!-- 3차 카테고리 //-->
			<?php if($aryCate03):?>
			<?php foreach($aryCate03 as $key3 => $data3):
					## 기본 설정
					$strCATE_CODE3 = $data3['CATE_CODE'];
					$strCATE_NAME = $data3['CATE_NAME'];
					$strCATE_IMG1 = $data3['CATE_IMG1'];
					$intCATE_ORDER = $data3['CATE_ORDER'];
					$strCATE_VIEW_YN = $data3['CATE_VIEW_YN'];
					$strCATE_SHARE = $data3['CATE_SHARE'];
					$strHref = "/{$strStLngLower}/?menuType=product&mode=list&lcate={$strCATE_CODE1}&mcate={$strCATE_CODE2}&scate={$strCATE_CODE3}";
					$strCATE_CODE = $strCATE_CODE1 . $strCATE_CODE2 . $strCATE_CODE3;
					$strFullCateCode = str_pad($strCATE_CODE, 12, "0");

					## 체크
					if(!$strCATE_VIEW_YN) { $strCATE_VIEW_YN ="N"; }
	
					## 3차 카테고리 검색	
					$cateMgr->setC_LEVEL(4);
					$cateMgr->setC_HCODE($strCATE_CODE);
					$cateMgr->setC_VIEW_YN("");
					$aryCate04 = $cateMgr->getCateLevelAry($db);

					## 이미지 설정
					if($strCATE_IMG1):
						$strCATE_IMG1 = "/upload/category/{$strLangLower}/{$strCATE_IMG1}";
					endif;		
			?>
			<tr>
				<td><?php echo ++$intCateCount;?></td>
				<td style="width:100px;text-align:left">
					<?php if($strCATE_IMG1):?>
					<img src="<?php echo $strCATE_IMG1;?>">
					<?php endif;?>
				</td>
				<td style="text-align:left">
					<span class="cate3">&nbsp;</span>
					[<?php echo $strCATE_CODE;?>] <strong><?php echo $strCATE_NAME;?></strong>
					<a href="<?php echo $strHref;?>" target="_brank" class="rightAlign"><img src="/shopAdmin/himg/common/btn_cate_url.gif"></a>
					<div class="clr"></div>
				</td>
				<td><?php echo $intCATE_ORDER;?></td>
				<td><img src="/shopAdmin/himg/common/ico_view_<?php echo $strCATE_VIEW_YN;?>.gif"></td>
				<td>
					<?php if($strCATE_SHARE == "Y"):?>
					<a class="btn_blue_sml" href="javascript:goCateShare(1,'<?php echo $strFullCateCode;?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00276"]//가상카테고리상품설정?></strong></a>
					<?php endif;?>
					<a class="btn_blue_sml" href="javascript:goCateModify('<?php echo $strCATE_CODE;?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goCateWrite('','');" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
					<a class="btn_sml" href="javascript:goCateDelete('<?php echo $strCATE_CODE;?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
			<!-- 4차 카테고리 //-->
			<?php if($aryCate04):?>
			<?php foreach($aryCate04 as $key4 => $data4):
					## 기본 설정
					$strCATE_CODE4 = $data4['CATE_CODE'];
					$strCATE_NAME = $data4['CATE_NAME'];
					$strCATE_IMG1 = $data4['CATE_IMG1'];
					$intCATE_ORDER = $data4['CATE_ORDER'];
					$strCATE_VIEW_YN = $data4['CATE_VIEW_YN'];
					$strCATE_SHARE = $data4['CATE_SHARE'];
					$strHref = "/{$strStLngLower}/?menuType=product&mode=list&lcate={$strCATE_CODE1}&mcate={$strCATE_CODE2}&scate={$strCATE_CODE3}&fcate={$strCATE_CODE4}";
					$strCATE_CODE = $strCATE_CODE1 . $strCATE_CODE2 . $strCATE_CODE3 . $strCATE_CODE4;
					$strFullCateCode = str_pad($strCATE_CODE, 12, "0");

					## 체크
					if(!$strCATE_VIEW_YN) { $strCATE_VIEW_YN ="N"; }

					## 이미지 설정
					if($strCATE_IMG1):
						$strCATE_IMG1 = "/upload/category/{$strLangLower}/{$strCATE_IMG1}";
					endif;
			
			?>
			<tr>
				<td><?php echo ++$intCateCount;?></td>
				<td style="width:100px;text-align:left">
					<?php if($strCATE_IMG1):?>
					<img src="<?php echo $strCATE_IMG1;?>">
					<?php endif;?>
				</td>
				<td style="text-align:left">
					<span class="cate4">&nbsp;</span>
					[<?php echo $strCATE_CODE;?>] <strong><?php echo $strCATE_NAME;?></strong>
					<a href="<?php echo $strHref;?>" target="_brank" class="rightAlign"><img src="/shopAdmin/himg/common/btn_cate_url.gif"></a>
					<div class="clr"></div>
				</td>
				<td><?php echo $intCATE_ORDER;?></td>
				<td><img src="/shopAdmin/himg/common/ico_view_<?php echo $strCATE_VIEW_YN;?>.gif"></td>
				<td>
					<?php if($strCATE_SHARE == "Y"):?>
					<a class="btn_blue_sml" href="javascript:goCateShare(1,'<?php echo $strFullCateCode;?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00276"]//가상카테고리상품설정?></strong></a>
					<?php endif;?>
					<a class="btn_blue_sml" href="javascript:goCateModify('<?php echo $strCATE_CODE;?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goCateWrite('','');" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
					<a class="btn_sml" href="javascript:goCateDelete('<?php echo $strCATE_CODE;?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
			<?php endforeach;?>
			<?php endif;?>
			<!-- 4차 카테고리 //-->
			<?php endforeach;?>
			<?php endif;?>
			<!-- 3차 카테고리 //-->
			<?php endforeach;?>
			<?php endif;?>
			<!-- 2차 카테고리 //-->
			<?php endforeach;?>
			<?php endif;?>
			<!-- 1차 카테고리 //-->
		</table>
	</div>
</div>
