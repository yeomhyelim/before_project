<?php
	## 2014.08.26 kim hee sung 진열장관리와 디자인관리/세부페이지 통합으로 설정 부분 변경
	## 사용을 원하시는 경우. $S_PRODUCT_ICON_WITH_DESIGN 옵션 추가 후, 진열장 관리 다시 저장
	if($S_PRODUCT_ICON_WITH_DESIGN == "Y"):
		include "ZL2.inc.php";
	else:
		include "ZL.inc.php";
	endif;	

	
