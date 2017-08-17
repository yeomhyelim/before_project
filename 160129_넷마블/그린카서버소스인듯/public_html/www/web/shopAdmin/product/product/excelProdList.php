<?
	## 언어 설정
	$strLang							= $_REQUEST['lang'];
	if(!$strLang) { $strLang = $S_ST_LNG; }

	##이미지 설정
	$aryProductImage['main']			= "리스트이미지2";
	$aryProductImage['list']			= "리스트이미지1";
	$aryProductImage['view']			= "상세이미지1";
	$aryProductImage['large']			= "확대이미지1";
	$aryProductImage['mobile_main']		= "모바일리스트이미지";
	$aryProductImage['mobile_view']		= "모바일상세이미지";
	$aryProductImage['view2']			= "상세이미지2";
	$aryProductImage['view3']			= "상세이미지3";
	$aryProductImage['view4']			= "상세이미지4";
	$aryProductImage['view5']			= "상세이미지5";
	$aryProductImage['view6']			= "상세이미지6";
	$aryProductImage['view7']			= "상세이미지7";
	$aryProductImage['view8']			= "상세이미지8";
	$aryProductImage['view9']			= "상세이미지9";
	$aryProductImage['view10']			= "상세이미지10";
	$aryProductImage['view11']			= "상세이미지11";
	$aryProductImage['view12']			= "상세이미지12";
	$aryProductImage['large2']			= "확대이미지2";
	$aryProductImage['large3']			= "확대이미지3";
	$aryProductImage['large4']			= "확대이미지4";
	$aryProductImage['large5']			= "확대이미지5";
	$aryProductImage['large6']			= "확대이미지6";
	$aryProductImage['large7']			= "확대이미지7";
	$aryProductImage['large8']			= "확대이미지8";
	$aryProductImage['large9']			= "확대이미지9";
	$aryProductImage['large10']			= "확대이미지10";
	$aryProductImage['large11']			= "확대이미지11";
	$aryProductImage['large12']			= "확대이미지12";
	$aryProductImage['file1']			= "첨부파일1";
	$aryProductImage['file2']			= "첨부파일2";
	$aryProductImage['file3']			= "첨부파일3";

?>
	<style>
	<!--
	br{mso-data-placement:same-cell;}
	td{mso-number-format:"\@";}
	-->
	</style>
	<table border="1" width="20000px">
		<tr>
			<th>상품번호</th>
			<th>상품명(필수)</th>
			<th>상품코드</th>
			<th>카테고리</th>
			<th>제조사</th>
			<th>원산지</th>	
			<th>브랜드</th>	
			<th>모델명</th>		
			<th>웹사용여부</th>		
			<th>모바일사용여부</th>
			<th>상품출시일</th>
			<th>상품등록일</th>
			<th>우선순위</th>
			<th>판매가</th>
			<th>소비자가격</th>
			<th>입고가</th>
			<th>포인트</th>
			<th>포인트종류</th>
			<th>포인트반올림자리수</th>
			<th>포인트반올림기준</th>
			<th>수량</th>
			<th>품절여부</th>
			<th>재입고여부</th>
			<th>무제한상품</th>
			<th>최소수량</th>
			<th>최고수량</th>
			<th>과세/비과세여부</th>
			<th>상품대체문구</th>
			<th>배송종류</th>
			<th>배송금액</th>
			<th>검색어</th>
			<th>기타</th>
			<th>웹상품설명</th>
			<th>모바일상품설명</th>
			<th>메모</th>
			<th>배송안내</th>
			<th>교환/환불안내</th>
			<th>상품무게</th>
			<th>상품추가정보</th>
			<th>추가옵션관리-사용유무</th>
			<th>추가옵션관리</th>
			<!--th>상품옵션관리-사용유무</th-->
			<th>옵션종류</th>
			<th>상품옵션관리-이름</th>
			<th>상품옵션관리-내용</th>
			<?foreach($aryProductImage as $key => $name):?>
			<th><?=$name?></th>
			<?endforeach;?>
			<th>색상</th>
			<th>사이즈</th>
			<?if ($S_MALL_TYPE != "R"){?>
			<th>입점사</th>
			<?}?>
		</tr>
		<tr>
			<td>no</td>
			<td>name</td>
			<td>code</td>
			<td>category</td>
			<td>maker</td>
			<td>origin</td>	
			<td>brand</td>	
			<td>model</td>		
			<td>web_use</td>		
			<td>mob_use</td>
			<td>release_date</td>
			<td>reg_date</td>
			<td>order</td>
			<td>sale_price</td>
			<td>consumer_price</td>
			<td>stock_price</td>
			<td>point</td>
			<td>pointType</td>
			<td>pointOff1</td>
			<td>pointOff2</td>
			<td>quantity</td>
			<td>stockOut</td>
			<td>restock</td>
			<td>stockLimit</td>
			<td>minQty</td>
			<td>maxQty</td>
			<td>tax</td>
			<td>priceText</td>
			<td>deliveryKind</td>
			<td>deliveryPrice</td>
			<td>searchText</td>
			<td>etc</td>
			<td>webText</td>
			<td>mobileText</td>
			<td>memo</td>
			<td>deliveryText</td>
			<td>returnText</td>
			<td>weight</td>
			<td>prodItem</td>
			<td>prodOptYN</td>
			<td>prodOpt</td>
			<!--td>prodOptAdminYN</td-->
			<td>optionKind</td>
			<td>prodOptAdminName</td>
			<td>prodOptAdmin</td>
			<?foreach($aryProductImage as $key => $name):?>
			<td><?=$key?></td>
			<?endforeach;?>
			<td>color</td>
			<td>size</td>
			<?if ($S_MALL_TYPE != "R"){?>
			<td></td>
			<?}?>
		</tr>
		<?while($row = mysql_fetch_array($result)):

			## 상품추가정보 데이터
			$param								= "";
			$param['PRODUCT_ITEM_LNG_JOIN']		= $strLang;
			$param['P_CODE']					= $row['P_CODE'];
			$prodItemResult						= $productMgr->getProdItemEx($db, "OP_LIST", $param);
			$prodItem							= "";
			while($tempRow = mysql_fetch_array($prodItemResult)):
				$prodItem .= "fun(항목명){{{$tempRow['PI_NAME']}}}fun(항목설명){{{$tempRow['PI_TEXT']}}}<br>";
			endwhile;

			## 추가옵션관리
			$param								= "";
			$param['PRODUCT_OPT_LNG_JOIN']		= $strLang;
			$param['P_CODE']					= $row['P_CODE'];
			$param['PO_TYPE']					= "A"; // 추가옵션항목
			$prodAddOptResult					= $productMgr->getProdOptEx($db, "OP_LIST", $param);

			## 추가옵션관리(항목명 설정)
			$prodAddOpt							= "";
			while($prodAddOptRow = mysql_fetch_array($prodAddOptResult)):
				$param									= "";
				$param['PRODUCT_ADD_OPT_LNG_JOIN']		= $strLang;
				$param['PO_NO']							= $prodAddOptRow['PO_NO'];
				$prodAddOptItemResult					= $productMgr->getProdAddOptEx($db, "OP_LIST", $param);
				while($prodAddOptItemRow = mysql_fetch_array($prodAddOptItemResult)):
					$prodAddOpt					.= "fun(추가옵션명){{{$prodAddOptRow['PO_NAME1']}}}fun(필수사항){{{$prodAddOptRow['PO_ESS']}}}fun(항목명){{{$prodAddOptItemRow['PAO_NAME']}}}fun(추가금액){{{$prodAddOptItemRow['PAO_PRICE']}}}<br>";
				endwhile;
			endwhile;			

			## 상품옵션관리
			$param								= "";
			$param['PRODUCT_OPT_LNG_JOIN']		= $strLang;
			$param['P_CODE']					= $row['P_CODE'];
			$param['PO_TYPE']					= "O"; // 상품옵션항목
			$prodOptRow							= $productMgr->getProdOptEx($db, "OP_SELECT", $param);

			$prodOpt							= "";
			for($i=1;$i<=10;$i++):
				$po_name						= $prodOptRow["PO_NAME{$i}"];
				if(!$po_name) { continue; }	
				$prodOpt			.= "fun(옵션명{$i}){{{$po_name}}}<br>";
			endfor;


			## 상품옵션관리_내용
			$prodOptAttr						= "";
			if($prodOptRow['PO_NO']):
				$param								= "";
				$param['PRODUCT_OPT_ATTR_LNG_JOIN']	= $strLang;
				$param['PO_NO']						= $prodOptRow['PO_NO'];
				$prodOptResult						= $productMgr->getProdOptAttrEx($db, "OP_ARYTOTAL", $param);
				foreach($prodOptResult as $key => $rowTemp):
					
					$prodOptTemp					= "";
					for($i=1;$i<=10;$i++):
						$poa_attr					= $rowTemp["POA_ATTR{$i}"];
						if(!$poa_attr) { continue; }	
						$prodOptTemp			   .= "fun(옵션명{$i}){{{$poa_attr}}}";
					endfor;

					$prodOptAttr		.= "{$prodOptTemp}fun(재고){{{$rowTemp['POA_STOCK_QTY']}}}fun(판매가격){{{$rowTemp['POA_SALE_PRICE']}}}fun(소비자가격){{{$rowTemp['POA_CONSUMER_PRICE']}}}fun(입고가격){{{$rowTemp['POA_STOCK_PRICE']}}}fun(포인트){{{$rowTemp['POA_POINT']}}}<br>";	
				endforeach;
			endif;

			## 상품 이미지, 첨부파일
			$prodImg							= "";
			$param								= "";
			$param['P_CODE']					= $row['P_CODE'];
			$prodImgResult						= $productMgr->getProdImgEx($db, "OP_ARYTOTAL", $param);
			foreach($aryProductImage as $key => $name):
				$aryProductImage[$key] = "";
			endforeach;
			foreach($prodImgResult as $key => $rowTemp):
				$aryProductImage[$rowTemp['PM_TYPE']] = $rowTemp['PM_REAL_NAME'];
			endforeach;

			$regDate		= date("Y-m-d", strtotime($row['TE_REG_DT']));
			$winDate		= date("Y-m-d", strtotime($row['TE_WIN_DT']));

			## 태그 형식으로 변경
			$row['P_WEB_TEXT']	= htmlspecialchars($row['P_WEB_TEXT']);
			$row['P_MOB_TEXT']	= htmlspecialchars($row['P_MOB_TEXT']);
		?>
		<tr>
			<td><?=$row['P_CODE']; //상품번호?></td>
			<td><?=$row['P_NAME']; //상품명(필수)?></td>
			<td><?=$row['P_NUM']; //상품코드?></td>
			<td><?=$row['P_CATE']; //카테고리?></td>
			<td><?=$row['P_MAKER']; //제조사?></td>
			<td><?=$row['P_ORIGIN']; //원산지?></td>	
			<td><?=$row['P_BRAND']; //브랜드?></td>	
			<td><?=$row['P_MODEL']; //모델명?></td>		
			<td><?=$row['P_WEB_VIEW']; //웹사용여부?></td>		
			<td><?=$row['P_MOB_VIEW']; //모바일사용여부?></td>
			<td><?=$row['P_LAUNCH_DT']; //상품출시일?></td>
			<td><?=$row['P_LAUNCH_DT']; //상품등록일?></td>
			<td><?=$row['P_ORDER']; //우선순위?></td>
			<td><?=$row['P_SALE_PRICE']; //판매가?></td>
			<td><?=$row['P_CONSUMER_PRICE']; //소비자가격?></td>
			<td><?=$row['P_STOCK_PRICE']; //입고가?></td>
			<td><?=$row['P_POINT']; //포인트?></td>
			<td><?=$row['P_POINT_TYPE']; //포인트종류?></td>
			<td><?=$row['P_POINT_OFF1']; //포인트반올림자리수?></td>
			<td><?=$row['P_POINT_OFF2']; //포인트반올림기준?></td>
			<td><?=$row['P_QTY']; //수량?></td>
			<td><?=$row['P_STOCK_OUT']; //품절여부?></td>
			<td><?=$row['P_RESTOCK']; //재입고여부?></td>
			<td><?=$row['P_STOCK_LIMIT']; //무제한상품?></td>
			<td><?=$row['P_MIN_QTY']; //최소수량?></td>
			<td><?=$row['P_MAX_QTY']; //최고수량?></td>
			<td><?=$row['P_TAX']; //과세/비과세여부?></td>
			<td><?=$row['P_PRICE_TEXT']; //상품대체문구?></td>
			<td><?=$row['P_BAESONG_TYPE']; //배송종류?></td>
			<td><?=$row['P_BAESONG_PRICE']; //배송금액?></td>
			<td><?=$row['P_SEARCH_TEXT']; //검색어?></td>
			<td><?=$row['P_ETC']; //기타?></td>
			<td ><?=$row['P_WEB_TEXT']; //웹상품설명?></td>
			<td><?=$row['P_MOB_TEXT']; //모바일상품설명?></td>
			<td><?=$row['P_MEMO']; //메모?></td>
			<td><?=$row['P_DELIVERY_TEXT']; //배송안내?></td>
			<td><?=$row['P_RETURN_TEXT']; //교환/환불안내?></td>
			<td><?=$row['P_WEIGHT']; //상품무게?></td>
			<td><?=$prodItem; //상품추가정보?></td>
			<td><?=$row['P_ADD_OPT'] //추가옵션관리-사용유무?></td>
			<td><?=$prodAddOpt; // 추가옵션관리?></td>
			<!--td>prodOptAdminYN</td-->
			<td><?=$row['P_OPT']//옵션종류?></td>
			<td><?=$prodOpt; //상품옵션관리-이름?></td>
			<td><?=$prodOptAttr; //상품옵션관리-내용?></td>
			<?foreach($aryProductImage as $key => $name):?>
			<td><?=$name?></td>
			<?endforeach;?>
			<td><?=$row['P_COLOR']//색상?></td>
			<td><?=$row['P_SIZE']//사이즈?></td>
			<?if ($S_MALL_TYPE != "R"){?>
			<td><?=$row['ST_NAME']?></td>
			<?}?>

		</tr>
		<?endwhile;?>
	</table>