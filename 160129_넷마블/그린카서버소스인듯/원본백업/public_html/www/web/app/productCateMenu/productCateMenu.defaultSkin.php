<?php
	/**
	 * 작성일		: 2013.12.13
	 * 작성자		: kim hee sung
	 * 내  용		: 상품 카테고리를 ul, li 테그로 감싸고 메뉴형태로 만듭니다.
	 * 참고사항		: 수정을 원하시는 경우 반드시 주석을 작성해주시기 바랍니다.
	 *				  개발 규칙이 있으므로 반드시 개발자에게 문의 바랍니다.
	 *		 			menuType=app&mode=productCateMenu&display=DBNN&lcate=001
	 * 사용법		: strAppDisplay[0] ~ strAppDisplay[3] 까지 입력 받음
	 *				  Y		: 출력
	 *				  N		: 숨김 
	 *				  D		: 제거(상위 카테고리와 상관없이 뿌려주고 싶을때 사용)
	 *				  F			: 해당 카테고리만 출력
	 *				  S		: 
	 *				  B		: 해당 하위 카테고리만 출력
	 *				  strAppEvent[0] ~ strAppEvent[3] 까지 입력 받음
	 *				  N		: 이벤트 없음.
	 *				  O		: mouse Over , 마우스가 올라갔을때 하위 카테고리가 보여집니다.
	 *				  C		: mouse Click ,클릭했을때 하위 카테고리가 보여집니다.(예정)
	 **/

	/**
	 * 스크립트 설정
	 */
//	$aryScriptEx[]				= "/common/js/tinybox.js";
//	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenu.js";
//	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenuDefaultSkin.js";

	## 기본 설정
	$strAppProductListUrl			= "./?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s";
	$intAppID						= $intAppID + 1; 
	$strAppID						= "APP_ID_{$intAppID}";
	$strSelectCate1					= $_GET['lcate'];
	$strSelectCate2					= $_GET['mcate'];
	$strSelectCate3					= $_GET['scate'];
	$strSelectCate4					= $_GET['fcate'];
	$aryCate1						= "";
	$aryCate2						= "";
	$aryCate3						= "";
	$aryCate4						= "";

	## 옵션 설정
	if($EUMSHOP_APP_INFO['display'])	{ $strAppDisplay	= $EUMSHOP_APP_INFO['display'];		}
	if($EUMSHOP_APP_INFO['event'])		{ $strAppEvent		= $EUMSHOP_APP_INFO['event'];		}

	## 카테고리별 display 설정
	$strAppCate1Display				= "";
	$strAppCate2Display				= "";
	$strAppCate3Display				= "";
	$strAppCate4Display				= "";
	if($strAppDisplay[0] == "N") { $strAppCate1Display = "display:none;"; }
	if($strAppDisplay[1] == "N") { $strAppCate2Display = "display:none;"; }
	if($strAppDisplay[2] == "N") { $strAppCate3Display = "display:none;"; }
	if($strAppDisplay[3] == "N") { $strAppCate4Display = "display:none;"; }

	## 카테고리 정보 불러오기
	include_once SHOP_HOME . "/conf/category.{$S_SITE_LNG_PATH}.inc.php";

	## 하위 카테고리 개수 설정
	## 카테고리를 생성할때 LOW_CNT 값을 정확하게 만들지 않고 있습니다.
	## share , view 데이터를 체크하여 쉐어 상품이거나 비출력 상품은 LOW_CNT 에 추가를 해서는 안되는데 지금은 추가되므로 다시 정의합니다.
	if(is_array($S_ARY_CATE1)):
		$idx1										= 0;
		foreach($S_ARY_CATE1 as $key1 => $data1):
			$strShare								= $data1['SHARE'];
			$strView								= $data1['VIEW'];
			$strCode								= $data1['CODE'];
			$strCate1								= substr($strCode, 0, 3);
			$strCate2								= substr($strCode, 3, 3);
			$strCate3								= substr($strCode, 6, 3);
			$strCate4								= substr($strCode, 9, 3);

			## 쉐어 상품 설정
			if($strShare == "Y") { continue; }		

			## 출력 유무 설정
			if($strView == "N") { continue; }

			## 해당 카테고리가 아니면 continue
			if($strAppDisplay[0] == "F"):
				if($strSelectCate1 != $strCate1) { continue; }
			endif;

			## 사용 데이터 만들기
			$aryCate1[$idx1]						= $data1;

			## 초기화
			$aryCate1[$idx1]['LOW_CNT']				= 0;
			
			if(is_array($S_ARY_CATE2)):
				$idx2								= 0;
				foreach($S_ARY_CATE2[$key1] as $key2 => $data2):
					$strShare								= $data2['SHARE'];
					$strView								= $data2['VIEW'];
					$strCode								= $data2['CODE'];
					$strCate1								= substr($strCode, 0, 3);
					$strCate2								= substr($strCode, 3, 3);
					$strCate3								= substr($strCode, 6, 3);
					$strCate4								= substr($strCode, 9, 3);

					## 쉐어 상품 설정
					if($strShare == "Y") { continue; }		

					## 출력 유무 설정
					if($strView == "N") { continue; }

					## 해당 카테고리가 아니면 continue
					if($strAppDisplay[0] == "F"):
						if($strSelectCate1 != $strCate1) { continue; }
					endif;
					if($strAppDisplay[1] == "F"):
						if($strSelectCate2 != $strCate2) { continue; }
					endif;
					if($strAppDisplay[1] == "S"):
						if($strSelectCate1 != $strCate1) { continue; }
					endif;

					## 개수 설정
					$aryCate1[$idx1]['LOW_CNT']++;

					## 사용 데이터 만들기
					$aryCate2[$idx1][$idx2]					= $data2;

					## 초기화
					$aryCate2[$idx1][$idx2]['LOW_CNT']		= 0;

					//if(is_array($S_ARY_CATE3)):
					if(is_array($S_ARY_CATE3[$key1][$key2])):
						$idx3								= 0;
						foreach($S_ARY_CATE3[$key1][$key2] as $key3 => $data3):
							$strShare								= $data3['SHARE'];
							$strView								= $data3['VIEW'];
							$strCode								= $data3['CODE'];
							$strCate1								= substr($strCode, 0, 3);
							$strCate2								= substr($strCode, 3, 3);
							$strCate3								= substr($strCode, 6, 3);
							$strCate4								= substr($strCode, 9, 3);

							## 쉐어 상품 설정
							if($strShare == "Y") { continue; }		

							## 출력 유무 설정
							if($strView == "N") { continue; }

							## 해당 카테고리가 아니면 continue
							if($strAppDisplay[0] == "F"):
								if($strSelectCate1 != $strCate1) { continue; }
							endif;
							if($strAppDisplay[1] == "F"):
								if($strSelectCate2 != $strCate2) { continue; }
							endif;
							if($strAppDisplay[2] == "F"):
								if($strSelectCate3 != $strCate3) { continue; }
							endif;
							if($strAppDisplay[2] == "S"):
								if($strSelectCate2 != $strCate2) { continue; }
							endif;
		
							## 개수 설정
							$aryCate2[$idx1][$idx2]['LOW_CNT']++;

							## 사용 데이터 만들기
							$aryCate3[$idx1][$idx2][$idx3]	= $data3;

							#### 4차 카테고리 부분 
							if(is_array($S_ARY_CATE4)):
								$idx4								= 0;
								foreach($S_ARY_CATE4[$key1][$key2][$key3] as $key4 => $data4):
									$strShare								= $data4['SHARE'];
									$strView								= $data4['VIEW'];
									$strCode								= $data4['CODE'];
									$strCate1								= substr($strCode, 0, 3);
									$strCate2								= substr($strCode, 3, 3);
									$strCate3								= substr($strCode, 6, 3);
									$strCate4								= substr($strCode, 9, 3);

									## 쉐어 상품 설정
									if($strShare == "Y") { continue; }		

									## 출력 유무 설정
									if($strView == "N") { continue; }

									## 해당 카테고리가 아니면 continue
									if($strAppDisplay[0] == "F"):
										if($strSelectCate1 != $strCate1) { continue; }
									endif;
									if($strAppDisplay[1] == "F"):
										if($strSelectCate2 != $strCate2) { continue; }
									endif;
									if($strAppDisplay[2] == "F"):
										if($strSelectCate3 != $strCate3) { continue; }
									endif;
									if($strAppDisplay[3] == "F"):
										if($strSelectCate4 != $strCate4) { continue; }
									endif;
									if($strAppDisplay[3] == "S"):
										if($strSelectCate3 != $strCate3) { continue; }
									endif;
				
									## 개수 설정
									$aryCate3[$idx1][$idx2][$idx3]['LOW_CNT']++;

									## 사용 데이터 만들기
									$aryCate4[$idx1][$idx2][$idx3][$idx4]	= $data4;

									#### 5차 카테고리 부분 
		
									#### 5차 카테고리 부분 

									## 증가
									$idx4							= $idx4 + 1;

								endforeach;
							endif;
							#### 4차 카테고리 부분 

							## 증가
							$idx3							= $idx3 + 1;

						endforeach;
					endif;

					## 증가
					$idx2									= $idx2 + 1;

				endforeach;
			endif;
			
			## 증가
			$idx1									= $idx1 + 1;

		endforeach;
	endif;

	## B 옵션 설정
	$isAryCateUse					= false;
	$aryCate						= "";
	if(!$strSelectCate1 && $strAppDisplay[0] == "B"):
		$isAryCateUse	= true;
		$aryCate		= $aryCate1;
	elseif(!$strSelectCate2 && $strAppDisplay[1] == "B"):
		$isAryCateUse	= true;
		foreach($aryCate2 as $key1 => $data1):
			foreach($aryCate2[$key1] as $key2 => $data2):
				$strCode								= $data2['CODE'];
				$strCate1								= substr($strCode, 0, 3);
				$strCate2								= substr($strCode, 3, 3);
				$strCate3								= substr($strCode, 6, 3);
				$strCate4								= substr($strCode, 9, 3);
				if($strSelectCate1 == $strCate1):
					$aryCate[]		= $data2;
				endif;
			endforeach;
		endforeach;
	elseif(!$strSelectCate3 && $strAppDisplay[2] == "B"):
		$isAryCateUse	= true;
		foreach($aryCate3 as $key1 => $data1):
			foreach($aryCate3 as $key2 => $data2):
				foreach($aryCate3[$key1][$key2] as $key3 => $data3):
					$strCode								= $data3['CODE'];
					$strCate1								= substr($strCode, 0, 3);
					$strCate2								= substr($strCode, 3, 3);
					$strCate3								= substr($strCode, 6, 3);
					$strCate4								= substr($strCode, 9, 3);
					if($strSelectCate1 == $strCate1 && $strSelectCate2 == $strCate2):
						$aryCate[]		= $data3;
					endif;
				endforeach;
			endforeach;
		endforeach;
	elseif(!$strSelectCate4 && $strAppDisplay[3] == "B"):
		$isAryCateUse	= true;
		foreach($aryCate4 as $key1 => $data1):
			foreach($aryCate4 as $key2 => $data2):
				foreach($aryCate4 as $key3 => $data3):
					foreach($aryCate4[$key1][$key2][$key3] as $key4 => $data4):
						$strCode								= $data4['CODE'];
						$strCate1								= substr($strCode, 0, 3);
						$strCate2								= substr($strCode, 3, 3);
						$strCate3								= substr($strCode, 6, 3);
						$strCate4								= substr($strCode, 9, 3);
						if($strSelectCate1 == $strCate1 && $strSelectCate2 == $strCate2 && $strSelectCate3 == $strCate3):
							$aryCate[]		= $data4;
						endif;
					endforeach;
				endforeach;
			endforeach;
		endforeach;
	endif;

	if($strAppDisplay[0] == "B") { $strAppDisplay[0] = "D"; }
	if($strAppDisplay[1] == "B") { $strAppDisplay[1] = "D"; }
	if($strAppDisplay[2] == "B") { $strAppDisplay[2] = "D"; }
	if($strAppDisplay[3] == "B") { $strAppDisplay[3] = "D"; }

	if($isAryCateUse):
		$strAppDisplay[0]	= "";
		$aryCate1			= $aryCate;
		$aryCate2			= "";
		$aryCate3			= "";
		$aryCate4			= "";
	endif;





?>
<style>
/* 2013.12.16 kim hee sung 사이트에 맞게 코딩하세요.
	.productCate1 li.cate1 {float:left;padding:10px;border:1px solid;position:relative;z-index:10;}
	.productCate2 {width:100px;left:0px;top:30px;position:absolute;border:0px solid;z-index:20;}
	.productCate2 li.cate2 {width:100px;padding:10px;border:1px solid;}
	.productCate3 {border:0px solid;width:100px;left:120px;margin-top:-27px;;position:absolute;border:1px solid;z-index:30;}
	.productCate3 li.cate3 {width:100px;padding:10px;}
*/
</style>
<div id="<?=$strAppID?>" appEvent="<?=$strAppEvent?>">
	<?if(is_array($aryCate1)):?>
	<?if($strAppDisplay[0] != "D"):?>
	<div class="productCate1" style="<?=$strAppCate1Display?>">
		<div class="cate1-do"></div>
		<div class="cate1-wrap cate1-wrap<?=$key1?>">
			<ul>
	<?endif;?>
				<?foreach($aryCate1 as $key1 => $data1):
					$strName		= $data1['NAME'];
					$strCode		= $data1['CODE'];
					$strView		= $data1['VIEW'];
					$strImg1		= $data1['IMG1'];
					$strImg2		= $data1['IMG2'];
					$intLowCnt		= $data1['LOW_CNT'];
					$strCate1		= substr($strCode, 0, 3);
					$strCate2		= substr($strCode, 3, 3);
					$strCate3		= substr($strCode, 6, 3);
					$strCate4		= substr($strCode, 9, 3);
					$strSelectedClass	= "";	 
					$strEndClass		= "";

					## 이름 설정
					if($strImg1 && $strImg2):
						$strName	= "<img src='{$strImg1}' src2='{$strImg2}' alt='{$strName}'>";
					elseif($strImg1):
						$strName	= "<img src='{$strImg1}' alt='{$strName}'>";
					endif;

					## 링크 설정
					$strHref		= sprintf($strAppProductListUrl, $strCate1, $strCate2, $strCate3, $strCate4);

					## selected 구분 설정
					if($strSelectCate1 == $strCate1) { $strSelectedClass	= " selected"; }

					## end 구분 설정
					if(sizeof($aryCate1) == ($key1+1)) { $strEndClass = " end"; }				?>
				<?if($strAppDisplay[0] != "D"):?>
				<li class="cate1 cate1-c<?=$key1?><?=$strEndClass?><?=$strSelectedClass?>"><a href="<?=$strHref?>" class="cate1-name<?=$strSelectedClass?>"><?=$strName?></a>
				<?endif;?>
					<?if(is_array($aryCate2) && $intLowCnt > 0):?>
					<?if($strAppDisplay[1] != "D"):?>
					<div class="productCate2" style="<?=$strAppCate2Display?>">
						<div class="cate2-do cate2-d<?=$key1?>"></div>
						<div class="cate2-wrap cate2-wrap<?=$key1?>">
							<ul>
					<?endif;?>
								<?foreach($aryCate2[$key1] as $key2 => $data2):
									$strName		= $data2['NAME'];
									$strCode		= $data2['CODE'];
									$strImg1		= $data2['IMG1'];
									$strImg2		= $data2['IMG2'];
									$intLowCnt		= $data2['LOW_CNT'];
									$strCate1		= substr($strCode, 0, 3);
									$strCate2		= substr($strCode, 3, 3);
									$strCate3		= substr($strCode, 6, 3);
									$strCate4		= substr($strCode, 9, 3);
									$strSelectedClass	= "";	 
									$strEndClass		= "";

									## 이름 설정
									if($strImg1 && $strImg2):
										$strName	= "<img src='{$strImg1}' src2='{$strImg2}' alt='{$strName}'>";
									elseif($strImg1):
										$strName	= "<img src='{$strImg1}' alt='{$strName}'>";
									endif;

									## 링크 설정
									$strHref		= sprintf($strAppProductListUrl, $strCate1, $strCate2, $strCate3, $strCate4);

									## selected 구분 설정
									if($strSelectCate1 == $strCate1 && $strSelectCate2 == $strCate2) { $strSelectedClass	= " selected"; }
					
									## end 구분 설정
									if(sizeof($aryCate2[$key1]) == ($key2+1)) { $strEndClass = " end"; }				?>
								<?if($strAppDisplay[1] != "D"):?>
								<li class="cate2 cate2-c<?=$key2?><?=$strEndClass?><?=$strSelectedClass?>"><a href="<?=$strHref?>" class="cate2-name<?=$strSelectedClass?>"><?=$strName?></a>
								<?endif;?>
									<?if(is_array($aryCate3) && $intLowCnt > 0):?>
									<?if($strAppDisplay[2] != "D"):?>
									<div class="productCate3" style="<?=$strAppCate3Display?>">
										<div class="cate3-do cate3-d<?=$key2?>"></div>
										<div class="cate3-wrap cate3-wrap<?=$key1?>">
											<ul>
									<?endif;?>
												<?foreach($aryCate3[$key1][$key2] as $key3 => $data3):
													$strName		= $data3['NAME'];
													$strCode		= $data3['CODE'];
													$strImg1		= $data3['IMG1'];
													$strImg2		= $data3['IMG2'];
													$intLowCnt		= $data3['LOW_CNT'];
													$strCate1		= substr($strCode, 0, 3);
													$strCate2		= substr($strCode, 3, 3);
													$strCate3		= substr($strCode, 6, 3);
													$strCate4		= substr($strCode, 9, 3);
													$strSelectedClass	= "";	 
													$strEndClass		= "";

													## 이름 설정
													if($strImg1 && $strImg2):
														$strName	= "<img src='{$strImg1}' src2='{$strImg2}' alt='{$strName}'>";
													elseif($strImg1):
														$strName	= "<img src='{$strImg1}' alt='{$strName}'>";
													endif;

													## 링크 설정
													$strHref		= sprintf($strAppProductListUrl, $strCate1, $strCate2, $strCate3, $strCate4);

													## selected 구분 설정
													if($strSelectCate1 == $strCate1 && $strSelectCate2 == $strCate2 && $strSelectCate3 == $strCate3) { $strSelectedClass	= " selected"; }
					
													## end 구분 설정
													if(sizeof($aryCate3[$key1][$key2]) == ($key3+1)) { $strEndClass = " end"; }				?>
												<?if($strAppDisplay[2] != "D"):?>
												<li class="cate3 cate3-c<?=$key3?><?=$strEndClass?><?=$strSelectedClass?>"><a href="<?=$strHref?>" class="cate3-name<?=$strSelectedClass?>"><?=$strName?></a>
												<?endif;?>
													<?if(is_array($aryCate4) && $intLowCnt > 0):?>
													<?if($strAppDisplay[3] != "D"):?>
													<div class="productCate4" style="<?=$strAppCate4Display?>">
														<div class="cate4-do cate4-d<?=$key3?>"></div>
														<div class="cate4-wrap cate4-wrap<?=$key1?>">
															<ul>
													<?endif;?>
																<?if($aryCate4 && $aryCate4[$key1] && $aryCate4[$key1][$key2] && $aryCate4[$key1][$key2][$key3]):?>
																<?foreach($aryCate4[$key1][$key2][$key3] as $key4 => $data4):
																	$strName		= $data4['NAME'];
																	$strCode		= $data4['CODE'];
																	$strImg1		= $data4['IMG1'];
																	$strImg2		= $data4['IMG2'];
																	$intLowCnt		= $data4['LOW_CNT'];
																	$strCate1		= substr($strCode, 0, 3);
																	$strCate2		= substr($strCode, 3, 3);
																	$strCate3		= substr($strCode, 6, 3);
																	$strCate4		= substr($strCode, 9, 3);
																	$strSelectedClass	= "";	 
																	$strEndClass		= "";

																	## 이름 설정
																	if($strImg1 && $strImg2):
																		$strName	= "<img src='{$strImg1}' src2='{$strImg2}' alt='{$strName}'>";
																	elseif($strImg1):
																		$strName	= "<img src='{$strImg1}' alt='{$strName}'>";
																	endif;

																	## 링크 설정
																	$strHref		= sprintf($strAppProductListUrl, $strCate1, $strCate2, $strCate3, $strCate4);

																	## selected 구분 설정
																	if($strSelectCate1 == $strCate1 && $strSelectCate2 == $strCate2 && $strSelectCate3 == $strCate3 && $strSelectCate4 == $strCate4) { $strSelectedClass	= " selected"; }
									
																	## end 구분 설정
																	if(sizeof($aryCate4[$key1][$key2]) == ($key4+1)) { $strEndClass = " end"; }				?>
																<?if($strAppDisplay[3] != "D"):?>
																<li class="cate4 cate4-c<?=$key3?><?=$strEndClass?><?=$strSelectedClass?>"><a href="<?=$strHref?>" class="cate4-name<?=$strSelectedClass?>"><?=$strName?></a></li>
																<?endif;?>
																<?endforeach;?>
																<?endif;?>
														<?if($strAppDisplay[3] != "D"):?>
																<div class="clr"></div>
															</ul>
														</div>		
													</div><!-- cate4 -->
													<?endif;?>
													<?endif;?>
												<?if($strAppDisplay[2] != "D"):?>
												</li>
												<?endif;?>
												<?endforeach;?>
										<?if($strAppDisplay[2] != "D"):?>
												<div class="clr"></div>
											</ul>
										</div>		
									</div><!-- cate3 -->
									<?endif;?>
									<?endif;?>
								<?if($strAppDisplay[1] != "D"):?>
								</li>
								<?endif;?>
								<?endforeach;?>
					<?if($strAppDisplay[1] != "D"):?>
								<div class="clr"></div>
							</ul>
						</div>		
					</div><!-- cate2 -->
					<?endif;?>
					<?endif;?>
				<?if($strAppDisplay[0] != "D"):?>
				</li>
				<?endif;?>
				<?endforeach;?>
	<?if($strAppDisplay[0] != "D"):?>
				<div class="clr"></div>
			</ul>
		</div>
	</div><!-- cate1 -->
	<?endif;?>
	<?endif;?>
</div>