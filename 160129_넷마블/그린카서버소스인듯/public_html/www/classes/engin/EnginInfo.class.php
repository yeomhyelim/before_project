<?php
    /**
     * /home/shop_eng/www/classes/engin/enginInfo.class.php
     * @author eumshop(thav@naver.com)
     * enginInfo class
	 * $engin = new EnginInfo();	
     */
	class EnginInfo {
		/**
		 * __construct()
		 * 생성자
		 */
		function __construct() {

		}

		function getFindData($pattern, $subject) {
			$aryFindData = "";
			preg_match_all($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, 0);
			$matches = $matches[0];
			if($matches):
				$i = 0;
				foreach($matches as $matchesKey => $matchesData):

					## 기본 설정
					$strTag = $matchesData[0];
					$strTag = str_replace(array("{@", "}","\""), "", $strTag);
					$aryFindData[$i]['tag'] = $matchesData[0];

					## 테그 구분
					$aryTag = explode(";", $strTag);
					foreach($aryTag as $tagKey => $tagData):
						list($strKey, $strData) = explode("=", $tagData);
						$aryFindData[$i]['data'][$strKey] = $strData;
					endforeach;
					$i++;
				endforeach;
			endif;
			return $aryFindData;
		}
	}

