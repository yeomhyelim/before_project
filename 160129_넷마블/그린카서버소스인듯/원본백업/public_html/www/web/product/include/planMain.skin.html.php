	<div class="evt_main">
		<?=$prodPlanRow['PL_HTML']?>
	</div>
	<?
		foreach($aryProdPlanCateList as $key => $data){
			
			$strProdListAllView		= "N";		//카테고리명 보이게 처리
			$strProdListTopIconView = "Y";		//카테고리명위에 TOP ICON 보이게 처리
			$strSearchHCodeImg		= "";
			$strTitleCode			= "";

			$strProdPlanCateCode	= $data['PL_P_CATE'];
			$strCateCode1			= SUBSTR($strProdPlanCateCode,0,3);
			$strCateCode2			= SUBSTR($strProdPlanCateCode,3,3);
			$strCateCode3			= SUBSTR($strProdPlanCateCode,6,3);
			$strCateCode4			= SUBSTR($strProdPlanCateCode,9,3);
			
			if ($strCateCode1 == "000") $strCateCode1 = "";
			if ($strCateCode2 == "000") $strCateCode2 = "";
			if ($strCateCode3 == "000") $strCateCode3 = "";
			if ($strCateCode4 == "000") $strCateCode4 = "";
			
			$param['C_CODE']			= $strCateCode1;
			$prodPlanCateRow			= $planMgr->getProdPlanCateInfo($db,$param);
			$strSearchHCodeName1		= $prodPlanCateRow['CL_NAME'];
			$strSearchHCodeImg			= $prodPlanCateRow['CL_IMG1'];

			if ($strCateCode2){
				$param['C_CODE']		= $strCateCode1.$strCateCode2;

				$prodPlanCateRow			= $planMgr->getProdPlanCateInfo($db,$param);
				$strSearchHCodeName2		= $prodPlanCateRow['CL_NAME'];
				$strSearchHCodeImg			= $prodPlanCateRow['CL_IMG1'];
			}

			if ($strCateCode3){
				$param['C_CODE']		= $strCateCode1.$strCateCode2.$strCateCode3;
				
				$prodPlanCateRow			= $planMgr->getProdPlanCateInfo($db,$param);
				$strSearchHCodeName3		= $prodPlanCateRow['CL_NAME'];
				$strSearchHCodeImg			= $prodPlanCateRow['CL_IMG1'];
			}

			if ($strCateCode4){
				$param['C_CODE']		= $strCateCode1.$strCateCode2.$strCateCode3.$strCateCode4;

				$prodPlanCateRow			= $planMgr->getProdPlanCateInfo($db,$param);
				$strSearchHCodeName4		= $prodPlanCateRow['CL_NAME'];
				$strSearchHCodeImg			= $prodPlanCateRow['CL_IMG1'];
			}

			$aryProdPlanCateList[$key]['PL_P_CATE_CODE'] = $strCateCode1.$strCateCode2.$strCateCode3.$strCateCode4;
			
			## 기본 설정
			$param['P_WEB_VIEW'] = "Y";

			/* 카테고리별 상품 리스트 */
			$param['PL_P_CATE'] = $data['PL_P_CATE'];
			$param['ORDER_BY']	= ($strSearchSort) ? $strSearchSort : "DE";
			$intTotal	= $planMgr->getProdPlanCateProdList($db,"OP_COUNT",$param);
			
			$intHList	= $intTotal;
			$intListNum	= $intTotal;

			$result = $planMgr->getProdPlanCateProdList($db,"OP_LIST",$param);
			
			/* 카테고리 이미지 표시 */			
			if ($strSearchHCodeImg){
				$strTitleCode		= sprintf("<img src='/upload/category/%s/%s'/>", strtolower($S_SITE_LNG),$strSearchHCodeImg);
				$strProdListAllView	= "Y";
			}
			echo "<div id='prodBodyWrap'>";
			echo "<div id='event_prod_Wrap'>";
			include "prodList." . $S_PRODLIST_DESIGN . ".skin.html.php";
			echo "</div>";
			echo "</div>";
		}
	?>