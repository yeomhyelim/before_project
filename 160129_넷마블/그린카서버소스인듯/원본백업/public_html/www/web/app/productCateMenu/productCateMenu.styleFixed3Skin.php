<?php
	/**
	 * eumshop app - productCateMenu - styleFixed3Skin
	 *
	 * 카테고리 출력
	 * 조건1) 하위 카테고리가 있으면 펼침, 하위 카테고리가 없으면 페이지 이동
	 * 조건2) 링크 페이지 
	 * category.menu.kr.inc.php 설정 파일을 사용
	 * 펼침/닫김 슬라이드 형태로 작동.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productCateMenu/productCateMenu.styleFixed3Skin.php
	 * @manual		menuType=app&mode=productCateMenu&skin=styleFixed3Skin&maxLevel=2
	 * @history
	 *				2014.06.07 kim hee sung - 개발 완료
	 */

	## 카테고리 정보 불러오기
	include_once MALL_SHOP . "/conf/category.menu.{$S_SITE_LNG_PATH}.inc.php";

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenu.styleFixed3Skin.js";

	## appID 설정
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_CATE_MENU_{$intAppID}";
	endif;

	## 기본 설정
	$strAppSelectCate			= $EUMSHOP_APP_INFO['selectCate'];
	$intAppMaxLevel				= $EUMSHOP_APP_INFO['maxLevel'];
	$strAppSelectCate1			= substr($strAppSelectCate, 0, 3);
	$strAppSelectCate2			= substr($strAppSelectCate, 3, 3);
	$strAppSelectCate3			= substr($strAppSelectCate, 6, 3);
	$strAppSelectCate4			= substr($strAppSelectCate, 9, 3);
?>

<!-- eumshop app - productCateMenu - styleFixed1Skin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID;?>">
	<!-- 1차 카테고리 //-->
	<div class="cate1-wrap">
		<ul class="cateList">
			<?php foreach($S_CATE_MENU1 as $key1 => $data1):

					## 기본설정
					$isSubMenu = true;
					$strOnClass = "";
					$strHideClass = " hide";
					$strCODE = $data1['CODE'];
					$strNAME = $data1['NAME'];
					$strIMG1 = $data1['IMG1'];
					$strIMG2 = $data1['IMG2'];
					$strSubCnt = sizeof($S_CATE_MENU2[$key1]);
					if($strSubCnt <= 0) { $isSubMenu = false; }
					if($intAppMaxLevel == 1) { $isSubMenu = false; }
					
					## 선택 카테고리 설정
					if($strAppSelectCate1 == $key1):
						$strOnClass = " on"; 
						$strHideClass = "";
					endif;
			?>
			<li class="cate1<?php echo $strOnClass;?>">
				<?php if(!$isSubMenu):?>
				<a href="#;" onClick="goProductCateMenuStyleFixed3SkinListMoveEvent('<?php echo $key1;?>','','','')"><span><?php echo $strNAME;?></span></a>
				<?php else:?>
				<a href="#;" onClick="goProductCateMenuStyleFixed3SkinShowEvent('<?php echo $strAppID;?>', this, 'cate2-wrap')"><span><?php echo $strNAME;?></span></a>
				<!-- 2차 카테고리 //-->
				<div class="cate2-wrap<?php echo $strHideClass;?>">
					<ul class="cate2">
						<?php foreach($S_CATE_MENU2[$key1] as $key2 => $data2):

								## 기본설정
								$isSubMenu = true;
								$strOnClass = "";
								$strHideClass = " hide";
								$strCODE = $data2['CODE'];
								$strNAME = $data2['NAME'];
								$strIMG1 = $data2['IMG1'];
								$strIMG2 = $data2['IMG2'];
								$strSubCnt = sizeof($S_CATE_MENU3[$key1][$key2]);
								if($strSubCnt <= 0) { $isSubMenu = false; }
								if($intAppMaxLevel == 2) { $isSubMenu = false; }
					
								## 선택 카테고리 설정
								if($strAppSelectCate1 == $key1 && $strAppSelectCate2 == $key2):
									$strOnClass = " on"; 
									$strHideClass = "";
								endif;
						?>
						<li class="cate2<?php echo $strOnClass;?>">
							<?php if(!$isSubMenu):?>
							<a href="#;" onClick="goProductCateMenuStyleFixed3SkinListMoveEvent('<?php echo $key1;?>','<?php echo $key2;?>','','')"><span><?php echo $strNAME;?></span></a>
							<?php else:?>
							<a href="#;" onClick="goProductCateMenuStyleFixed3SkinShowEvent('<?php echo $strAppID;?>', this, 'cate3-wrap')"><span><?php echo $strNAME;?></span></a>
							<!-- 3차 카테고리 //-->
							<div class="cate3-wrap<?php echo $strHideClass;?>">
								<ul class="cate3">
									<?php foreach($S_CATE_MENU3[$key1][$key2] as $key3 => $data3):

											## 기본설정
											$isSubMenu = true;
											$strOnClass = "";
											$strHideClass = " hide";
											$strCODE = $data3['CODE'];
											$strNAME = $data3['NAME'];
											$strIMG1 = $data3['IMG1'];
											$strIMG2 = $data3['IMG2'];
											$strSubCnt = sizeof($S_CATE_MENU4[$key1][$key2][$key3]);
											if($strSubCnt <= 0) { $isSubMenu = false; }
											if($intAppMaxLevel == 3) { $isSubMenu = false; }
					
											## 선택 카테고리 설정
											if($strAppSelectCate1 == $key1 && $strAppSelectCate2 == $key2 && $strAppSelectCate3 == $key3):
												$strOnClass = " on"; 
												$strHideClass = "";
											endif;
									?>
									<li class="cate3<?php echo $strOnClass;?>">
										<?php if(!$isSubMenu):?>
										<a href="#;" onClick="goProductCateMenuStyleFixed3SkinListMoveEvent('<?php echo $key1;?>','<?php echo $key2;?>','<?php echo $key3;?>','')"><span><?php echo $strNAME;?></span></a>
										<?php else:?>
										<a href="#;" onClick="goProductCateMenuStyleFixed3SkinShowEvent('<?php echo $strAppID;?>', this, 'cate4-wrap')"><span><?php echo $strNAME;?></span></a>
										<!-- 4차 카테고리 //-->
										<div class="cate4-wrap<?php echo $strHideClass;?>">
											<ul class="cate4">
												<?php foreach($S_CATE_MENU4[$key1][$key2][$key3] as $key4 => $data4):

														## 기본설정
														$isSubMenu = true;
														$strOnClass = "";
														$strHideClass = " hide";
														$strCODE = $data4['CODE'];
														$strNAME = $data4['NAME'];
														$strIMG1 = $data4['IMG1'];
														$strIMG2 = $data4['IMG2'];
					
														## 선택 카테고리 설정
														if($strAppSelectCate1 == $key1 && $strAppSelectCate2 == $key2 && $strAppSelectCate3 == $key3 && $strAppSelectCate4 == $key4):
															$strOnClass = " on"; 
															$strHideClass = "";
														endif;
												?>
												<li class="cate4<?php echo $strOnClass;?>">
													<a href="#;" onClick="goProductCateMenuStyleFixed3SkinListMoveEvent('<?php echo $key1;?>','<?php echo $key2;?>','<?php echo $key3;?>','<?php echo $key4;?>')"><span><?php echo $strNAME;?></span></a>
												</li>
												<?php endforeach;?>
											</ul>
										</div>
										<!-- 4차 카테고리 //-->
										<?php endif;?>
									</li>
									<?php endforeach;?>
								</ul>
							</div>
							<!-- 3차 카테고리 //-->
							<?php endif;?>
						</li>
						<?php endforeach;?>
					</ul>
				</div>
				<!-- 2차 카테고리 //-->
				<?php endif;?>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
	<!-- 1차 카테고리 //-->
</div>
<!-- eumshop app - productCateMenu - styleFixed1Skin (<?php echo $strAppID?>) -->