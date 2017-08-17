<?
	## 작성일 : 2013.08.16
	## 작성자 : kim hee sung
	## 내  용 : 관리자 페이지 > 디자인 관리 > 움직이는 배너 부분에서 등록한 이미지를 ul , li 테그로 만드는 내용
	
	## 초기화
	unset($S_SLIDER_INFO);

	## 버전 2.0 에서 추가된 부분
	$sliderFile			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/sliderBanner/sliderBanner_SLIDER_{$sliderNo}.conf.inc.php";
	if($S_LAYOUT_VERSION == "V2.0"):
		$sliderFile			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/sliderBanner/{$S_SITE_LNG_PATH}/sliderBanner_SLIDER_{$sliderNo}.conf.inc.php";
		if(!is_file($sliderFile)):
			$strStLngLower = strtolower($S_ST_LNG);	
			$sliderFile			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/sliderBanner/{$strStLngLower}/sliderBanner_SLIDER_{$sliderNo}.conf.inc.php";
		endif;
	endif;


	## 사용 가능 여부 체크
	$bUse				= true;
	$imgDir				= "/upload/slider";
	if(!isset($sliderNo))				{ $bUse = false; }
	if($bUse && is_file($sliderFile))	{ include $sliderFile;	}
	else								{ $bUse = false;		}

	if($bUse && is_array($S_SLIDER_INFO)):

	## 링크타입 설정
	$target = $S_SLIDER_INFO['SB_LINK_TYPE']; // M : 현재 페이지 열기 , B : 새창으로 열기, N : 연결 없음
	if($target == "M")		 { $target = "_self";	} 
	else if($target == "B")	 { $target = "_blank";	} 
	else					 { $target = "";		}

?>
<ul id="slider<?=$sliderNo?>">
	<?foreach($S_SLIDER_INFO['SI_IMG'] as $key => $img):
		if(!$img) { continue; }
		$img	= "{$imgDir}/{$img}";	
		$link	= $S_SLIDER_INFO['SI_LINK'][$key];
	?>
	<?if($target):?>
	<li><a href="<?=$link?>" target="<?=$target?>"><img src="<?=$img?>"></a></li>
	<?else:?>
	<li><img src="<?=$img?>"></li>
	<?endif;?>
	<?endforeach;?>
</ul>
<?	endif; unset($S_SLIDER_INFO);?>

