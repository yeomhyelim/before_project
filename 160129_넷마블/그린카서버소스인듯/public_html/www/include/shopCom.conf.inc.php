<?
		//주요유통시장
		$aryEntry = array();
		$aryEntry[SH_COM_COUNTRY1] =  $LNG_TRANS_CHAR["CW00120"]; // 국내시장
		$aryEntry[SH_COM_COUNTRY2] =  $LNG_TRANS_CHAR["CW00121"]; //아시아
		$aryEntry[SH_COM_COUNTRY3] =  $LNG_TRANS_CHAR["CW00122"]; //유럽
		$aryEntry[SH_COM_COUNTRY4] =  $LNG_TRANS_CHAR["CW00123"]; //북아메리카
		$aryEntry[SH_COM_COUNTRY5] =  $LNG_TRANS_CHAR["CW00124"]; //남아메리카
		$aryEntry[SH_COM_COUNTRY6] =  $LNG_TRANS_CHAR["CW00125"]; //오세아니아
		$aryEntry[SH_COM_COUNTRY7] =  $LNG_TRANS_CHAR["CW00126"]; //아프리카
		$aryEntryCnt = sizeof($aryEntry);

		#Type
		$aryType['M'] = $LNG_TRANS_CHAR["CW00093"];
		$aryType['S'] = $LNG_TRANS_CHAR["CW00092"];
		/*TYPE 제조/공금사 삭제 요청. 남덕희*/
		//$aryType['B'] = $LNG_TRANS_CHAR["CW00094"];
		
		#모바일 메인용 Type 20150714
		$aryTypeM['M'] = $LNG_TRANS_CHAR["CW00140"];
		$aryTypeM['S'] = $LNG_TRANS_CHAR["CW00141"];
		/*TYPE 제조/공금사 삭제 요청. 남덕희*/
		//$aryTypeM['B'] = $LNG_TRANS_CHAR["CW00142"];
		
		/* 등급이미지*/
			//신용등급
		$aryCreditGradeImg["G"]		= "/upload/images/ico_sale_1.png";
		$aryCreditGradeImg["S"]		= "/upload/images/ico_sale_2.png";
		$aryCreditGradeImg["B"]		= "/upload/images/ico_sale_3.png";
			//판매등급
		$arySaleGradeImg["B"]		= "/upload/images/ico_credit_1.png";
		$arySaleGradeImg["E"]		= "/upload/images/ico_credit_2.png";
		$arySaleGradeImg["G"]		= "/upload/images/ico_credit_3.png";
			//현장확인
		$aryLocusGradeImg["Y"]		= "/upload/images/ico_confirm_1.png";
		$aryLocusGradeImg["N"]		= "/upload/images/ico_confirm_2.png";
?>