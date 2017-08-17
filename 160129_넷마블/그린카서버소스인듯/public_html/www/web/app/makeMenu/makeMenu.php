<?php
	/**
	 * 작성일		: 2013.12.13
	 * 작성자		: kim hee sung
	 * 내  용		: 상품 카테고리를 ul, li 테그로 감싸고 메뉴형태로 만듭니다.
	 * 참고사항		: 수정을 원하시는 경우 반드시 주석을 작성해주시기 바랍니다.
	 *				  개발 규칙이 있으므로 반드시 개발자에게 문의 바랍니다.
	 * 사용법		: strAppDisplay[0] ~ strAppDisplay[3] 까지 입력 받음
	 *				  Y		: 출력
	 *				  N		: 숨김 
	 *				  D		: 제거(상위 카테고리와 상관없이 뿌려주고 싶을때 사용)
	 *				  F		: 해당 카테고리만 출력
	 *				  strAppEvent[0] ~ strAppEvent[3] 까지 입력 받음
	 *				  N		: 이벤트 없음.
	 *				  O		: mouse Over , 마우스가 올라갔을때 하위 카테고리가 보여집니다.
	 *				  C		: mouse Click ,클릭했을때 하위 카테고리가 보여집니다.(예정)
	 **/

	## 기본 설정
	$intAppID						= $intAppID + 1; 
	$strAppID						= "APP_ID_{$intAppID}";
	$aryCate1						= "";
	$aryCate2						= "";
	$aryCate3						= "";
	$aryCate4						= "";

	## 옵션 설정
	if($EUMSHOP_APP_INFO['conf'])		{ $strAppConf		= $EUMSHOP_APP_INFO['conf'];		}
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

	if($strAppConf):
		include SHOP_HOME . "/app/makeMenu/{$strAppConf}.inc.php";
	endif;

	## 하위 카테고리 개수 설정
	## 카테고리를 생성할때 LOW_CNT 값을 정확하게 만들지 않고 있습니다.
	## share , view 데이터를 체크하여 쉐어 상품이거나 비출력 상품은 LOW_CNT 에 추가를 해서는 안되는데 지금은 추가되므로 다시 정의합니다.
	if(is_array($S_MENU_CATE1)):
		$idx1										= 0;
		foreach($S_MENU_CATE1 as $key1 => $data1):

			## 해당 카테고리가 아니면 continue
			if($strAppDisplay[0] == "F"):
				if($strSelectCate1 != $strCate1) { continue; }
			endif;

			## 사용 데이터 만들기
			$aryCate1[$idx1]						= $data1;

			## 초기화
			$aryCate1[$idx1]['LOW_CNT']				= 0;
			
			if(is_array($S_MENU_CATE2)):
				$idx2								= 0;
				foreach($S_MENU_CATE2[$key1] as $key2 => $data2):

					## 해당 카테고리가 아니면 continue
					if($strAppDisplay[0] == "F"):
						if($strSelectCate1 != $strCate1) { continue; }
					endif;
					if($strAppDisplay[1] == "F"):
						if($strSelectCate2 != $strCate2) { continue; }
					endif;

					## 개수 설정
					$aryCate1[$idx1]['LOW_CNT']++;

					## 사용 데이터 만들기
					$aryCate2[$idx1][$idx2]					= $data2;

					## 초기화
					$aryCate2[$idx1][$idx2]['LOW_CNT']		= 0;

					if(is_array($S_MENU_CATE3)):
						$idx3								= 0;
						foreach($S_MENU_CATE3[$key1][$key2] as $key3 => $data3):

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
							
							## 개수 설정
							$aryCate2[$idx1][$idx2]['LOW_CNT']++;

							## 사용 데이터 만들기
							$aryCate3[$idx1][$idx2][$idx3]	= $data3;

							#### 4차 카테고리 부분 
							
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

?>
<style>
	.menuCate1 li.cate1 {float:left;padding:10px;border:1px solid;position:relative;z-index:10;}
	.menuCate2 {width:100px;left:0px;top:30px;position:absolute;border:0px solid;z-index:20;}
	.menuCate2 li.cate2 {width:100px;padding:10px;border:1px solid;}
	.menuCate3 {border:0px solid;width:100px;left:120px;margin-top:-27px;;position:absolute;border:1px solid;z-index:30;}
	.menuCate3 li.cate3 {width:100px;padding:10px;}
</style>
<div id="<?=$strAppID?>" appEvent="<?=$strAppEvent?>">
	<?if(is_array($aryCate1)):?>
	<?if($strAppDisplay[0] != "D"):?>
	<div class="menuCate1" style="<?=$strAppCate1Display?>">
		<div class="cate1-wrap">
			<ul>
	<?endif;?>
				<?foreach($aryCate1 as $key1 => $data1):
					$strName		= $data1['NAME'];
					$strUrl			= $data1['URL'];
					$strImg1		= $data1['IMG1'];
					$strImg2		= $data1['IMG2'];
					$intLowCnt		= $data1['LOW_CNT'];
					$strSelectedClass	= "";	 
					$strEndClass		= "";

					## 이름 설정
					if($strImg1 && $strImg2):
						$strName	= "<img src='{$strImg1}' src2='{$strImg2}' alt='{$strName}'>";
					elseif($strImg1):
						$strName	= "<img src='{$strImg1}' alt='{$strName}'>";
					endif;

					## 링크 설정
					$strHref		= $strUrl;

					## selected 구분 설정
					if($strSelectCate1 == $strCate1) { $strSelectedClass	= " selected"; }

					## end 구분 설정
					if(sizeof($aryCate1) == ($key1+1)) { $strEndClass = " end"; }				?>
				<?if($strAppDisplay[0] != "D"):?>
				<li class="cate1 cate1-c<?=$key1?><?=$strEndClass?>"><a href="<?=$strHref?>" class="cate1-name<?=$strSelectedClass?>"><?=$strName?></a>
				<?endif;?>
					<?if(is_array($aryCate2) && $intLowCnt > 0):?>
					<?if($strAppDisplay[1] != "D"):?>
					<div class="menuCate2" style="<?=$strAppCate2Display?>">
						<div class="cate2-wrap">
							<ul>
					<?endif;?>
								<?foreach($aryCate2[$key1] as $key2 => $data2):
									$strName		= $data2['NAME'];
									$strUrl			= $data2['URL'];
									$strImg1		= $data2['IMG1'];
									$strImg2		= $data2['IMG2'];
									$intLowCnt		= $data2['LOW_CNT'];
									$strSelectedClass	= "";	 
									$strEndClass		= "";

									## 이름 설정
									if($strImg1 && $strImg2):
										$strName	= "<img src='{$strImg1}' src2='{$strImg2}' alt='{$strName}'>";
									elseif($strImg1):
										$strName	= "<img src='{$strImg1}' alt='{$strName}'>";
									endif;

									## 링크 설정
									$strHref		= $strUrl;

									## selected 구분 설정
									if($strSelectCate1 == $strCate1 && $strSelectCate2 == $strCate2) { $strSelectedClass	= " selected"; }
					
									## end 구분 설정
									if(sizeof($aryCate2[$key1]) == ($key2+1)) { $strEndClass = " end"; }				?>
								<?if($strAppDisplay[1] != "D"):?>
								<li class="cate2 cate2-c<?=$key2?><?=$strEndClass?>"><a href="<?=$strHref?>" class="cate2-name<?=$strSelectedClass?>"><?=$strName?></a>
								<?endif;?>
									<?if(is_array($aryCate3) && $intLowCnt > 0):?>
									<div class="menuCate3" style="<?=$strAppCate3Display?>">
										<div class="cate3-wrap">
											<ul>
												<?foreach($aryCate3[$key1][$key2] as $key3 => $data3):
													$strName		= $data3['NAME'];
													$strUrl			= $data3['URL'];
													$strImg1		= $data3['IMG1'];
													$strImg2		= $data3['IMG2'];
													$intLowCnt		= $data3['LOW_CNT'];
													$strSelectedClass	= "";	 
													$strEndClass		= "";

													## 이름 설정
													if($strImg1 && $strImg2):
														$strName	= "<img src='{$strImg1}' src2='{$strImg2}' alt='{$strName}'>";
													elseif($strImg1):
														$strName	= "<img src='{$strImg1}' alt='{$strName}'>";
													endif;

													## 링크 설정
													$strHref		= $strUrl;

													## selected 구분 설정
													if($strSelectCate1 == $strCate1 && $strSelectCate2 == $strCate2 && $strSelectCate3 == $strCate3) { $strSelectedClass	= " selected"; }
					
													## end 구분 설정
													if(sizeof($aryCate3[$key1][$key2]) == ($key3+1)) { $strEndClass = " end"; }				?>
												<li class="cate3 cate3-c<?=$key3?><?=$strEndClass?>"><a href="<?=$strHref?>" class="cate3-name<?=$strSelectedClass?>"><?=$strName?></a></li>
												<?endforeach;?>
												<div class="clr"></div>
											</ul>
										</div>		
									</div><!-- cate3 -->
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