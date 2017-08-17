<?php
	/**
	 * 작성일		: 2014.01.29
	 * 작성자		: kim hee sung
	 * 내  용		: 데이터베이스에 등록된 상품 이미지 사이즈를 자동으로 resize 합니다.
	 * 참고사항		: 
	 * 사용법		: 
	 */

	$objProductMgrModule		= new ProductMgrModule($db);
	$objProductImgModule		= new ProductImgModule($db);

	if(!$EUMSHOP_APP_INFO['limitEnd']) { $EUMSHOP_APP_INFO['limitEnd'] = 100000; }

	/**
	 * resize 정보
	 */
	$aryResizeInfo['main']['width']			= 200;
	$aryResizeInfo['main']['height']		= 165;

	$aryResizeInfo['list']['width']			= 200;
	$aryResizeInfo['list']['height']		= 165;
	
	$aryResizeInfo['view']['width']			= 420;
	$aryResizeInfo['view']['height']		= 345;
	
	$aryResizeInfo['view2']['width']		= 420;
	$aryResizeInfo['view2']['height']		= 345;

	$aryResizeInfo['view3']['width']		= 420;
	$aryResizeInfo['view3']['height']		= 345;

	$aryResizeInfo['large']['width']		= 630;
	$aryResizeInfo['large']['height']		= 520;

	$aryResizeInfo['large2']['width']		= 630;
	$aryResizeInfo['large2']['height']		= 520;

	$aryResizeInfo['large3']['width']		= 630;
	$aryResizeInfo['large3']['height']		= 520;

	$aryResizeInfo['mobile_main']['width']	= 200;
	$aryResizeInfo['mobile_main']['height']	= 165;

	$aryResizeInfo['mobile_view']['width']	= 420;
	$aryResizeInfo['mobile_view']['height']	= 345;

	/**
	 * 리스트 데이터 만들기
	 */
	$aryParam						= "";
	$aryParam['LNG']				= $S_SITE_LNG;
	$aryParam['PRODUCT_INFO_JOIN']	= "Y";
	$intTotal						= $objProductMgrModule->getProductMgrSelectEx("OP_COUNT", $aryParam);				// 데이터 전체 개수 
	$intPageLine					= $EUMSHOP_APP_INFO['limitEnd'];											// 리스트 개수 
	$intPage						= ( $intPage )				? $intPage		: 1;
	$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$aryParam['LIMIT']				= "{$intFirst},{$intPageLine}";
	$resProductMgrResult			= $objProductMgrModule->getProductMgrSelectEx("OP_LIST", $aryParam);

	$intPageBlock					= 10;																		// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );

?>

<table border="1">
<tr>
	<th><input type="checkbox" id="chkAll" data_target="prodNo"/></th>
	<th>상품코드</th>
	<th>상품이름</th>
	<th>상품이미지</th>
</tr>
<?while($row = mysql_fetch_array($resProductMgrResult)):
	$strP_CODE		= $row['P_CODE'];
	$strP_NAME		= $row['P_NAME'];
	
	$param			= "";
	$param['P_CODE']= $strP_CODE;
	$aryProductImg	= $objProductImgModule->getProductImgSelectEx("OP_ARYTOTAL", $param);	?>

<tr>
	<td><input type="checkbox" id="prodNo" value="<?=$strP_CODE?>"></td>
	<td><?=$strP_CODE?></td>
	<td><?=$strP_NAME?></td>
	<td>
		<table>
			<tr>
				<th>이미지 타입</th>
				<th>이미지 주소</th>
				<th>가로</th>
				<th>세로</th>
				<th>변경된가로</th>
				<th>변경된세로</th>
			</tr>
			<?foreach($aryProductImg as $key => $data):
				$strPM_TYPE						= $data['PM_TYPE'];
				$strPM_REAL_NAME				= $data['PM_REAL_NAME'];
				list($intWidth, $intHeight)		= getimagesize(SHOP_HOME . "/{$strPM_REAL_NAME}");		
				
				## Resize
				$intResizeWidth					= 0;
				$intResizeHeight				= 0;
				if($aryResizeInfo[$strPM_TYPE]['width'] && $aryResizeInfo[$strPM_TYPE]['height']):
					if($aryResizeInfo[$strPM_TYPE]['width'] < $intWidth):
						## 2014.02.03 kim hee sung, 상품이미지를 모두 리사이즈 합니다. 데이터를 확인하고, 백업을 반드시 한다음, 사용하시기 바랍니다.
						## 이미지 비율체크는 안합니다. 정해진 사이즈로 resize 되기 때문에, 이미지 마다 비율이 다르다면, 사용을 하지 마시기 바랍니다.
//						ImageFunc::getImageResize(SHOP_HOME . "/{$strPM_REAL_NAME}", SHOP_HOME . "/{$strPM_REAL_NAME}", $aryResizeInfo[$strPM_TYPE]['width'], $aryResizeInfo[$strPM_TYPE]['height']);
//						list($intResizeWidth, $intResizeHeight) = getimagesize(SHOP_HOME . "/{$strPM_REAL_NAME}");		
					endif;
				endif;
					?>
			<tr>
				<td><?=$strPM_TYPE?></td>
				<td><?=$strPM_REAL_NAME?></td>
				<td><?=$intWidth?></td>
				<td><?=$intHeight?></td>
				<td><?=$intResizeWidth?></td>
				<td><?=$intResizeHeight?></td>
			</tr>
			<?endforeach;?>
		</table>
	</td>
</tr>
<?endwhile;?>
</table>