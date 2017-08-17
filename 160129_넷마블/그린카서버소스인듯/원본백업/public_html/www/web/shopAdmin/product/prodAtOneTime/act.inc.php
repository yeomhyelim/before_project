<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	$productMgr = new ProductAdmMgr();

//	function imageSave($oldPath, $newPath)
//	{
//		$path_parts		= pathinfo($oldPath);
//		$ext			= $path_parts['extension'];
//		$tempPath		= $newPath . date("YmdHis");
//
//		for($i = 0; $i < 10; $i++) {
//			$newPath = $tempPath ."_" . $i . "." . $ext;
//			if(!file_exists($newPath)) {
//				break;
//			}
//		}
//
//		if($ext == "jpg") {
//			$im_jpg			= imagecreatefromjpeg($oldPath);
//			$re = imagejpeg($im_jpg, $newPath);
//		} else if($ext == "gif") {
//			$im_gif			= imagecreatefromgif($oldPath);
//			$re = imagegif($im_gif, $newPath);
//		} else if($ext == "png") {
//			$im_png			= imagecreatefrompng($oldPath);
//			$re = imagepng($im_png, $newPath);
//		}
//
//
//		if($re == 1)
//			return $newPath;
//
//		return -1;
//	}
//
//	$fileName = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/temp/naver.gif";
//	echo imageSave("http://sstatic.naver.net/search/img3/h1_naver.gif", $fileName);
	$imgSaveFolderName = ( isset ( $strImgSaveFolderName ) && ! empty ( $strImgSaveFolderName ) ?  $strImgSaveFolderName : '/upload/product/20150203/' ) ;

	switch ($strAct) :

		case "prodAtOneTimeWrite":
			// 상품 대량 등록

			## 상품 첨부파일, 이미지 정의
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

			$_FILE		= $_FILES['excelFile'];

			if($_FILE['error'] > 0) :
				// error 처리
				echo "업로드 오류 처리 하세요...";
				break;
			endif;

			if(!$_FILE['name']):
				// 파일명이 없을 때 처리.
				echo "파일명 설정이 안되어 있습니다. 처리하세요...";
				break;
			endif;

			// 파일 업로드
			$uid	 			= "prodAtOnetimeUpload_".date("YmdHis");	// 파일업로드명의 구분자
			$upload_dir			= WEB_UPLOAD_PATH . "/temp" ;				// 업로드할 폴더명
			$file_name			= $_FILE['name'];							// 파일명
			$file_tmp_name		= $_FILE['tmp_name'];						// 업로드할 임시 파일명
			$file_size			= $_FILE['size'];							// 업로드할 파일 크기
			$file_type			= $_FILE['type'];							// 업로드할 파일 타입

			$fres 				= $fh->doUpload($uid, $upload_dir, $file_name, $file_tmp_name, $file_size, $file_type);

			if(!$fres) :
				// 업로드 실패 처리
				echo "업로드 실패 영역 처리 하세요...";
				break;
			endif;

			$strFileInServer	= $fres['upload_dir'] . "/" . $fres['file_real_name'];
			@chmod($strFileInServer , 0707);	// 권한 변경

			/* Excel 영역 */
			require_once MALL_EXCEL_READER;
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('utf-8');
			$data->read($strFileInServer);
			error_reporting(E_ALL ^ E_NOTICE);

			$aryDeliveryComAll = getCommCodeList("DELIVERY","Y");

			/* 셀 정의 */
			$intCnt		= 1;
			foreach($data->sheets[0]['cells'][2] as $cellName) :
				if(!$cellName) :
					print_r($data->sheets[0]['cells']);
					// 셀 정의 값이 없으면 등록 불가.
					echo "셀 정의 값이 없으면 등록 불가 영역 처리 하세요...";
					exit;
				endif;
				$cell[$intCnt] = $cellName;
				$intCnt++;
			endforeach;

			## 오류 검사
			for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++) :

				for($j=1;$j<$intCnt;$j++):
					$aryProdInfo[$cell[$j]]		= $data->sheets[0]['cells'][$i][$j];
				endfor;

				if(!$aryProdInfo['name']):
					// 상품명이 없으면 오류

					// 파일 삭제
					$fh->fileDelete($strFileInServer);
					$strUrl = "./?menuType=".$strMenuType."&mode=prodAtOneTimeWrite";
					$strMsg = "상품명이 없습니다.({$i}번째 상품)";
					goUrl($strMsg,$strUrl);

					exit;
				endif;

			endfor;

			if($a_admin_type == "S"): // 입점몰인 경우.
				require_once MALL_CONF_LIB."ShopMgr.php";
				$shopMgr = new ShopMgr();

				$shopMgr->setSH_NO($a_admin_shop_no);
				$shopInfo = $shopMgr->getShopView($db);

			endif;

			$categorys		= array () ;
			$cates			= array () ;
			$cateCodeArr	= array () ;
			$cateNameArr	= array () ;

			$categorys = $productMgr->getProductCategoryList ( $db , '' );

			foreach ( $categorys as $k => $v )
			{
				if ( ! array_key_exists ( $v['C_CODE'] , $cateCodeArr ) )
				{
					$cateCodeArr[$v['C_CODE']] = $v['CL_NAME'] ;
					$cateNameArr[$v['CL_NAME']] = $v['C_CODE'] ;
				}
			}
			foreach ( $categorys as $k => $v )
			{

				if ( $v['C_LEVEL'] == 1 )
					$vname = $v['CL_NAME'] ;
				else if ( $v['C_LEVEL'] == 2 )
					$vname = $cateCodeArr[substr ( $v['C_CODE'] , 0 , 3 )] . '/' . $v['CL_NAME'] ;
				else if ( $v['C_LEVEL'] == 3 )
					$vname = $cateCodeArr[substr ( $v['C_CODE'] , 0 , 3 )] . '/' . $cateCodeArr[substr ( $v['C_CODE'] , 0 , 6 )] . '/' . $v['CL_NAME'] ;
				else if ( $v['C_LEVEL'] == 4 )
					$vname = $cateCodeArr[substr ( $v['C_CODE'] , 0 , 3 )] . '/' . $cateCodeArr[substr ( $v['C_CODE'] , 0 , 6 )] . '/' . $cateCodeArr[substr ( $v['C_CODE'] , 0 , 9 )] . '/' . $v['CL_NAME'] ;
				if ( ! array_key_exists ( $vname , $cates ) )
					$cates[$vname] = $v['C_CODE'] ;
			}

			$intSuccessCnt			= "";
			for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++) :

				for($j=1;$j<$intCnt;$j++):
					$aryProdInfo[$cell[$j]]		= $data->sheets[0]['cells'][$i][$j];
				endfor;

				/* point 설정 */
				if($aryProdInfo['point'] == "0"):
					$aryProdInfo['point']		= $S_POINT_PRICE;;
					$aryProdInfo['pointType']	= $S_POINT_PRICE_UNIT;
					$aryProdInfo['pointOff1']	= $S_POINT_PRICE_POS;
					$aryProdInfo['pointOff2']	= "1";
				endif;

				// 카테고리명으로 카테고리 등록
				if ( empty ( $aryProdInfo['category'] ) && ! empty ( $aryProdInfo['cate_name1'] ) )
				{
					$cateName =  ( empty ( $aryProdInfo['cate_name1'] ) ? '' : $aryProdInfo['cate_name1'] ) ;
					$cateName .= ( empty ( $aryProdInfo['cate_name2'] ) ? '' : '/' . $aryProdInfo['cate_name2'] ) ;
					$cateName .= ( empty ( $aryProdInfo['cate_name3'] ) ? '' : '/' . $aryProdInfo['cate_name3'] ) ;
					$cateName .= ( empty ( $aryProdInfo['cate_name4'] ) ? '' : '/' . $aryProdInfo['cate_name4'] ) ;
					$aryProdInfo['category'] = $cates[$cateName] ;
				}

				#$aryProdInfo['list']	= $imgSaveFolderName . $aryProdInfo['code'] . '.JPG';
				#$aryProdInfo['view']	= $imgSaveFolderName . $aryProdInfo['code'] . '.JPG';
				#$aryProdInfo['large']	= $imgSaveFolderName . $aryProdInfo['code'] . '.JPG';




				$productMgr->setP_BRAND("");// 브랜드
				if ($aryProdInfo['brand']){
					$productMgr->setPR_NAME($aryProdInfo['brand']);
					$intP_BRAND = $productMgr->getProdBrandNo($db);
					$productMgr->setP_BRAND($intP_BRAND);
				}

				$productMgr->setP_NAME($aryProdInfo['name']);						// 상품명
				$productMgr->setP_NUM($aryProdInfo['code']);						// 상품코드
				$productMgr->setP_CATE($aryProdInfo['category']);					// 카테고리
				$productMgr->setP_MAKER($aryProdInfo['maker']);						// 제조사
				$productMgr->setP_ORIGIN($aryProdInfo['origin']);					// 원산지
				//$productMgr->setP_BRAND($aryProdInfo['brand']);						// 브랜드
				$productMgr->setP_MODEL($aryProdInfo['model']);						// 모델명
				$productMgr->setP_WEB_VIEW($aryProdInfo['web_use']);				// 웹사용여부
				$productMgr->setP_MOB_VIEW($aryProdInfo['mob_use']);				// 모바일사용여부
				$productMgr->setP_LAUNCH_DT($aryProdInfo['release_date']);			// 상품 출시일
				$productMgr->setP_REP_DT($aryProdInfo['reg_date']);					// 상품 등록일
				$productMgr->setP_ORDER($aryProdInfo['order']);						// 우선순위
				$productMgr->setP_SALE_PRICE($aryProdInfo['sale_price']);			// 판매가
				$productMgr->setP_CONSUMER_PRICE($aryProdInfo['consumer_price']);	// 소비자가격
				$productMgr->setP_STOCK_PRICE($aryProdInfo['stock_price']);			// 입고가
				$productMgr->setP_POINT($aryProdInfo['point']);						// 포인트
				$productMgr->setP_POINT_TYPE($aryProdInfo['pointType']);			// 포인트 종류
				$productMgr->setP_POINT_OFF1($aryProdInfo['pointOff1']);			// 포인트반올림자리수
				$productMgr->setP_POINT_OFF2($aryProdInfo['pointOff2']);			// 포인트반올림기준
				$productMgr->setP_QTY($aryProdInfo['quantity']);					// 수량
				$productMgr->setP_STOCK_OUT($aryProdInfo['stockOut']);				// 품절여부
				$productMgr->setP_RESTOCK($aryProdInfo['restock']);					// 재입고여부
				$productMgr->setP_STOCK_LIMIT($aryProdInfo['stockLimit']);			// 무제한상품
				$productMgr->setP_MIN_QTY($aryProdInfo['minQty']);					// 최소수량
				$productMgr->setP_MAX_QTY($aryProdInfo['maxQty']);					// 최고수량
				$productMgr->setP_TAX($aryProdInfo['tax']);							// 과세/비과세여부
				$productMgr->setP_PRICE_TEXT($aryProdInfo['priceText']);			// 상품대체문구
				$productMgr->setP_OPT($aryProdInfo['optionKind']);					// 옵션종류
				$productMgr->setP_ADD_OPT($aryProdInfo['prodOptYN']);				// 추가옵션유무
				$productMgr->setP_BAESONG_TYPE($aryProdInfo['deliveryKind']);		// 배송종류
				$productMgr->setP_BAESONG_PRICE($aryProdInfo['deliveryPrice']);		// 배송금액
				$productMgr->setP_SEARCH_TEXT($aryProdInfo['searchText']);			// 검색어
				$productMgr->setP_ETC($aryProdInfo['etc']);							// 기타
				$productMgr->setP_WEB_TEXT($aryProdInfo['webText']);				// 웹상품설명
				$productMgr->setP_MOB_TEXT($aryProdInfo['mobileText']);				// 모바일상품설명
				$productMgr->setP_MEMO($aryProdInfo['memo']);						// 메모
				$productMgr->setP_DELIVERY_TEXT($aryProdInfo['deliveryText']);		// 배송안내
				$productMgr->setP_RETURN_TEXT($aryProdInfo['returnText']);			// 교환/환불안내
				$productMgr->setP_COLOR($aryProdInfo['color']);						// 색상
				$productMgr->setP_SIZE($aryProdInfo['size']);						// 사이즈
//				$productMgr->setP_NAME($aryProdInfo['eventUnit']);					// 이벤트금액_단위
//				$productMgr->setP_NAME($aryProdInfo['eventPrice']);					// 이벤트가격(%)
//				$productMgr->setP_NAME($aryProdInfo['listIcon']);					// 리스트 아이콘
//				$productMgr->setP_LIST_ICON_VIEW($aryProdInfo['listIconView']);		// 리스트아이콘보여주기구분
//				$productMgr->setP_LIST_ICON_ST($aryProdInfo['listIconST']);			// 리스트아이콘시작시간
//				$productMgr->setP_LIST_ICON_ET($aryProdInfo['listIconET']);			// 리스트아이콘종료시간
				$productMgr->setP_WEIGHT($aryProdInfo['weight']);					// 상품무게
//				$productMgr->setP_NAME($aryProdInfo['shopNo']);						// 입점몰번호
//				$productMgr->setP_NAME($aryProdInfo['shopPrice']);					// 입점몰상품가격
//				$productMgr->setP_NAME($aryProdInfo['scraping']);					// 스크랩핑여부
//				$productMgr->setP_NAME($aryProdInfo['icon']);						// 진열장
				if ($a_admin_shop_no) $productMgr->setP_SHOP_NO($a_admin_shop_no);
				else $productMgr->setP_SHOP_NO(0);

				if($a_admin_type == "S"): // 입점몰인 경우.
					if($shopInfo['SH_COM_PROD_AUTH'] == "Y"): // 승인이 필요한 경우
						$productMgr->setP_WEB_VIEW("N");
						$productMgr->setP_MOB_VIEW("N");
					endif;

					//입점사가 상품 포인트 입력 금지
					if ($S_FIX_MALL_PROD_POINT_INSERT == "N"){
						$productMgr->setP_POINT(0);
					}
				endif;

				$strInsertMode = "insert";
				if($aryProdInfo['no']) :
					// 상품 update
					$strInsertMode = "update";
					$productMgr->setP_CODE($aryProdInfo['no']);
					echo $aryProdInfo['no'] . "업데이트 안됨";
					exit;
				else:
					// 상품 insert
					/* 상품 코드 생성 */
					$strP_CODE = $productMgr->getProductCode($db);
					$productMgr->setP_CODE($strP_CODE);
				endif;

				/* 상품 기본정보 INSERT */
				$productMgr->getProdInsert($db);
				$productMgr->getProdColorUpdate($db);	// 색상 업데이트
				$productMgr->getProdSizeUpdate($db);	// 사이즈 업데이트
				$intSuccessCnt++;

				/* 상품 기본정보 언어별 INSERT */
				for($j=0;$j<sizeof($arySiteUseLng);$j++):
					if ($arySiteUseLng[$j]):
						$productMgr->setP_LNG($arySiteUseLng[$j]);
						$productMgr->getProdInfoInsert($db);
					endif;
				endfor;

				/* 상품추가정보 INSERT */
				if($aryProdInfo['prodItem']):
					// 상품 항목 관리 PRODUCT_ITEM 등록 정보
					$aryProdInfo['prodItem']	= str_replace("\r","",$aryProdInfo['prodItem']);
					$aryProdInfo['prodItem']	= str_replace("\n","",$aryProdInfo['prodItem']);
					$aryProdItemTemp			= explode("}}", $aryProdInfo['prodItem']);
					$intPI_ORDER				= 1;
					foreach($aryProdItemTemp as $prodItem):
						$prodItem	= str_replace("fun(", "", $prodItem);
						$prodItem	= str_replace(")", "", $prodItem);
						$aryItem	= explode("{{",$prodItem);
						if($aryItem[0]):
							// 데이터
							if($aryItem[0] == "항목명"):
								$productMgr->setPI_NAME($aryItem[1]);
							elseif($aryItem[0] == "항목설명"):
								$productMgr->setPI_TEXT($aryItem[1]);
								$productMgr->setPI_ORDER($intPI_ORDER);
								$productMgr->getProdItemInsert($db);
								$intPI_NO = $db->getLastInsertID();
								$productMgr->setPI_NO($intPI_NO);
								for($j=0;$j<sizeof($arySiteUseLng);$j++):
									if ($arySiteUseLng[$j]):
										$productMgr->setPI_LNG($arySiteUseLng[$j]);
										$productMgr->getProdItemLngInsert($db);
									endif;
								endfor;
								$intPI_ORDER++;
							endif;
						endif;
					endforeach;
				endif;

				/* 추가 옵션 관리 INSERT */
				if ($S_MALL_TYPE == "R"){

					if($aryProdInfo['prodOpt']):
						$productMgr->setPO_TYPE("A");
						$aryProdInfo['prodOpt']	= str_replace("\r","",$aryProdInfo['prodOpt']);
						$aryProdInfo['prodOpt']	= str_replace("\n","",$aryProdInfo['prodOpt']);
						$aryProdOptTemp			= explode("}}", $aryProdInfo['prodOpt']);
						$strOptInsert			= ""; // PRODUCT_OPT_KR insert 유무
						foreach($aryProdOptTemp as $prodOpt):
							$prodOpt	= str_replace("fun(", "", $prodOpt);
							$prodOpt	= str_replace(")", "", $prodOpt);
							$aryOpt		= explode("{{",$prodOpt);
							if($aryOpt[0]):
								// 데이터
								if($aryOpt[0] == "추가옵션명"):
									if($aryOpt[1]):
										$productMgr->setPO_NAME1($aryOpt[1]);
										$strOptInsert = "Y";
									endif;
								endif;
								if($aryOpt[0] == "필수사항"):
									if($aryOpt[1]):
										$productMgr->setPO_ESS($aryOpt[1]);
									endif;
									if($strOptInsert == "Y") :
										$productMgr->getProdOptInsert($db);
										$intPO_NO = $db->getLastInsertID();
										$productMgr->setPO_NO($intPO_NO);
										$strOptInsert = "";
										if ($intPO_NO > 0) :
											/* 언어별 INSERT */
											for($j=0;$j<sizeof($arySiteUseLng);$j++){
												if ($arySiteUseLng[$j]){
													$productMgr->setP_LNG($arySiteUseLng[$j]);
													$productMgr->getProdOptLngInsert($db);
												}
											}
										endif;
									endif;
								endif;
								if($aryOpt[0] == "항목명"):
									$productMgr->setPAO_NAME($aryOpt[1]);
								endif;
								if($aryOpt[0] == "추가금액"):
									$productMgr->setPAO_PRICE($aryOpt[1]);
									$productMgr->getProdAddOptInsert($db);
									$intPAO_NO = $db->getLastInsertID();
									$productMgr->setPAO_NO($intPAO_NO);
									/* 언어별 INSERT */
									for($k=0;$k<sizeof($arySiteUseLng);$k++){
										if ($arySiteUseLng[$k]){
											$productMgr->setP_LNG($arySiteUseLng[$k]);
											$productMgr->getProdAddOptLngInsert($db);
										}
									}
								endif;
							endif;
						endforeach;
					endif;
				}

				/* 상품옵션관리(제목) */
				if($aryProdInfo['prodOptAdminName']):
					$aryProdInfo['prodOptAdminName']	= str_replace("\r","",$aryProdInfo['prodOptAdminName']);
					$aryProdInfo['prodOptAdminName']	= str_replace("\n","",$aryProdInfo['prodOptAdminName']);
					$aryProdOptAdinNameTemp				= explode("}}", $aryProdInfo['prodOptAdminName']);
					foreach($aryProdOptAdinNameTemp as $prodOptAdminName) :
						$prodOptAdminName		= str_replace("fun(", "", $prodOptAdminName);
						$prodOptAdminName		= str_replace(")", "", $prodOptAdminName);
						$aryProdOptAdminName	= explode("{{",$prodOptAdminName);
						if($aryProdOptAdminName[0]):
							for($k=1;$k<=10;$k++):
								if($aryProdOptAdminName[0] == "옵션명{$k}") :
									$productMgr->{"setPO_NAME{$k}"}($aryProdOptAdminName[1]);
								endif;
							endfor;
						endif;
					endforeach;
				endif;

				/* 상품옵션관리(내용) */
				if($aryProdInfo['prodOptAdmin']):
					$aryProdInfo['prodOptAdmin']	= str_replace("\r","",$aryProdInfo['prodOptAdmin']);
					$aryProdInfo['prodOptAdmin']	= str_replace("\n","",$aryProdInfo['prodOptAdmin']);
					$aryProdOptAdminTemp			= explode("}}", $aryProdInfo['prodOptAdmin']);
					$intProdOptAdminCnt				= 1;
					$productMgr->setPO_TYPE("O");
					$productMgr->setPO_ESS($aryProdInfo['prodOptAdminYN']);
					$productMgr->setPO_ESS("Y");
					$productMgr->getProdOptInsert($db);
					$intPO_NO = $db->getLastInsertID();
					$productMgr->setPO_NO($intPO_NO);
					/* 언어별 INSERT */
					for($j=0;$j<sizeof($arySiteUseLng);$j++){
						if ($arySiteUseLng[$j]){
							$productMgr->setP_LNG($arySiteUseLng[$j]);
							$productMgr->getProdOptLngInsert($db);
						}
					}

					foreach($aryProdOptAdminTemp as $prodOptAdmin):
						$prodOptAdmin		= str_replace("fun(", "", $prodOptAdmin);
						$prodOptAdmin		= str_replace(")", "", $prodOptAdmin);
						$aryProdOptAdmin	= explode("{{",$prodOptAdmin);
						if($aryProdOptAdmin[0]):
							// 데이터
							if(!in_array($aryProdOptAdmin[0], array("재고","판매가격","소비자가격","입고가격","포인트"))):
								$productMgr->{"setPOA_ATTR{$intProdOptAdminCnt}"}($aryProdOptAdmin[1]);
								$intProdOptAdminCnt++;
							endif;
							if($aryProdOptAdmin[0] == "판매가격"):
								$productMgr->setPOA_SALE_PRICE($aryProdOptAdmin[1]);
							endif;
							if($aryProdOptAdmin[0] == "소비자가격"):
								$productMgr->setPOA_CONSUMER_PRICE($aryProdOptAdmin[1]);
							endif;
							if($aryProdOptAdmin[0] == "입고가격"):
								$productMgr->setPOA_STOCK_PRICE($aryProdOptAdmin[1]);
							endif;
							if($aryProdOptAdmin[0] == "재고"):
								$productMgr->setPOA_STOCK_QTY($aryProdOptAdmin[1]);
							endif;
							if($aryProdOptAdmin[0] == "포인트"):
								$productMgr->setPOA_POINT($aryProdOptAdmin[1]);

								if($a_admin_type == "S"): // 입점몰인 경우.
									//입점사가 상품 포인트 입력 금지
									if ($S_FIX_MALL_PROD_POINT_INSERT == "N"){
										$productMgr->setPOA_POINT(0);
									}
								endif;

								$productMgr->getProdOptAttrInsert($db);
								$intPOA_NO = $db->getLastInsertID();
								$productMgr->setPOA_NO($intPOA_NO);
								/* 언어별 INSERT */
								for($k=0;$k<sizeof($arySiteUseLng);$k++):
									if ($arySiteUseLng[$k]):
										$productMgr->setP_LNG($arySiteUseLng[$k]);
										$productMgr->getProdOptAttrLngInsert($db);
									endif;
								endfor;

								for($s=1;$s<=10;$s++):
									$productMgr->{"setPOA_ATTR{$s}"}("");
									$productMgr->{"setPO_NAME{$s}"}("");
								endfor;

								$intProdOptAdminCnt = 1;
							endif;
						endif;
					endforeach;
				endif;


				/* 이미지 */
				## 상품 이미지, 첨부파일 초기화 및 적용
				foreach($aryProductImage as $key => $name):
					if(!$aryProdInfo[$key]) { continue; }
					$productMgr->setPM_TYPE($key);
					$productMgr->setPM_SAVE_NAME($aryProdInfo[$key]);
					$productMgr->setPM_REAL_NAME($aryProdInfo[$key]);
					$productMgr->getProdImgInsert($db);
				endforeach;

## 2013.08.19 첨부파일 배열 형태로 변경
//				if($aryProdInfo['listImage']):
////					$productMgr->setPM_TYPE("main");		## 2013.04.04 엑셀 형식 변경
//					$productMgr->setPM_TYPE("list");
//					$productMgr->setPM_SAVE_NAME($aryProdInfo['listImage']);
//					$productMgr->setPM_REAL_NAME($aryProdInfo['listImage']);
//					$productMgr->getProdImgInsert($db);
//				endif;
//				if($aryProdInfo['list2Image']):
////					$productMgr->setPM_TYPE("list");		## 2013.04.04 엑셀 형식 변경
//					$productMgr->setPM_TYPE("main");
//					$productMgr->setPM_SAVE_NAME($aryProdInfo['list2Image']);
//					$productMgr->setPM_REAL_NAME($aryProdInfo['list2Image']);
//					$productMgr->getProdImgInsert($db);
//				endif;
//				if($aryProdInfo['mobileListImage']):
//					$productMgr->setPM_TYPE("mobile_main");
//					$productMgr->setPM_SAVE_NAME($aryProdInfo['mobileListImage']);
//					$productMgr->setPM_REAL_NAME($aryProdInfo['mobileListImage']);
//					$productMgr->getProdImgInsert($db);
//				endif;
//				if($aryProdInfo['mobileViewImage']):
//					$productMgr->setPM_TYPE("mobile_view");
//					$productMgr->setPM_SAVE_NAME($aryProdInfo['mobileViewImage']);
//					$productMgr->setPM_REAL_NAME($aryProdInfo['mobileViewImage']);
//					$productMgr->getProdImgInsert($db);
//				endif;
## 2013.04.04 엑셀 형식 변경
## 상세이미지 fun(1){{a.jpg}} -> a.jpg 형으로 변경
## 2013.04.05 엑셀 형식 변경 복구
## 2013.08.19 첨부파일 배열 형태로 변경
//				if($aryProdInfo['viewImage']):
//					// 상세이미지
//					$productMgr->setPM_TYPE("view");
//					$productMgr->setPM_SAVE_NAME($aryProdInfo['viewImage']);
//					$productMgr->setPM_REAL_NAME($aryProdInfo['viewImage']);
//					$productMgr->getProdImgInsert($db);
//					$intLargeImageCnt++;
//				endif;
//				if($aryProdInfo['viewImage']):
//					$aryProdInfo['viewImage']	= str_replace("\r","",$aryProdInfo['viewImage']);
//					$aryProdInfo['viewImage']	= str_replace("\n","",$aryProdInfo['viewImage']);
//					$aryViewImageTemp			= explode("}}", $aryProdInfo['viewImage']);
//					$intViewImageCnt			= 1;
//					foreach($aryViewImageTemp as $viewImage):
//						$viewImage		= str_replace("fun(", "", $viewImage);
//						$viewImage		= str_replace(")", "", $viewImage);
//						$aryViewImage	= explode("{{",$viewImage);
//						if($aryViewImage[0]):
//							// 데이터
//							$strPM_TYPE	= ($intViewImageCnt == 1 ) ? "view" : "view{$intViewImageCnt}";
//							$productMgr->setPM_TYPE($strPM_TYPE);
//							$productMgr->setPM_SAVE_NAME($aryViewImage[1]);
//							$productMgr->setPM_REAL_NAME($aryViewImage[1]);
//							$productMgr->getProdImgInsert($db);
//							$intViewImageCnt++;
//						endif;
//					endforeach;
//				endif;

## 2013.04.04 엑셀 형식 변경
## 확대 이미지 fun(1){{a.jpg}} -> a.jpg 형으로 변경
## 2013.04.05 엑셀 형식 변경 복구
## 2013.08.19 첨부파일 배열 형태로 변경
//				if($aryProdInfo['zoomImage']):
//					// 확대이미지
//					$productMgr->setPM_TYPE("large");
//					$productMgr->setPM_SAVE_NAME($aryProdInfo['zoomImage']);
//					$productMgr->setPM_REAL_NAME($aryProdInfo['zoomImage']);
//					$productMgr->getProdImgInsert($db);
//					$intLargeImageCnt++;
//				endif;
//				if($aryProdInfo['zoomImage']):
//					$aryProdInfo['zoomImage']	= str_replace("\r","",$aryProdInfo['zoomImage']);
//					$aryProdInfo['zoomImage']	= str_replace("\n","",$aryProdInfo['zoomImage']);
//					$aryLargeImageTemp			= explode("}}", $aryProdInfo['zoomImage']);
//					$intLargeImageCnt			= 1;
//					foreach($aryLargeImageTemp as $largeImage):
//						$largeImage		= str_replace("fun(", "", $largeImage);
//						$largeImage		= str_replace(")", "", $largeImage);
//						$aryLargeImage	= explode("{{",$largeImage);
//						if($aryLargeImage[0]):
//							// 데이터
//							$strPM_TYPE	= ($intLargeImageCnt == 1 ) ? "large" : "large{$intLargeImageCnt}";
//							$productMgr->setPM_TYPE($strPM_TYPE);
//							$productMgr->setPM_SAVE_NAME($aryLargeImage[1]);
//							$productMgr->setPM_REAL_NAME($aryLargeImage[1]);
//							$productMgr->getProdImgInsert($db);
//							$intLargeImageCnt++;
//						endif;
//					endforeach;
//				endif;

## 2013.04.04 엑셀 형식 변경
## 추가 이미지 fun(1)((a.jpg}} 형식으로 추가
## 2013.04.05 엑셀 형식 변경 복구
//				if($aryProdInfo['tempImage']):
//					$aryProdInfo['tempImage']	= str_replace("\r","",$aryProdInfo['tempImage']);
//					$aryProdInfo['tempImage']	= str_replace("\n","",$aryProdInfo['tempImage']);
//					$aryLargeImageTemp			= explode("}}", $aryProdInfo['tempImage']);
//					$intLargeImageCnt			= 2;
//					foreach($aryLargeImageTemp as $largeImage):
//						$largeImage		= str_replace("fun(", "", $largeImage);
//						$largeImage		= str_replace(")", "", $largeImage);
//						$aryLargeImage	= explode("{{",$largeImage);
//						if($aryLargeImage[0]):
//							 데이터
//							$strPM_TYPE	= "large{$intLargeImageCnt}";
//							$productMgr->setPM_TYPE($strPM_TYPE);
//							$productMgr->setPM_SAVE_NAME($aryLargeImage[1]);
//							$productMgr->setPM_REAL_NAME($aryLargeImage[1]);
//							$productMgr->getProdImgInsert($db);
//							$intLargeImageCnt++;
//						endif;
//					endforeach;
//				endif;

				/* 첨부파일 */
## 2013.08.19 첨부파일 배열 형태로 변경
//				if($aryProdInfo['file1']):
//					$productMgr->setPM_TYPE("file1");
//					$productMgr->setPM_SAVE_NAME($aryProdInfo['file1']);
//					$productMgr->setPM_REAL_NAME($aryProdInfo['file1']);
//					$productMgr->getProdImgInsert($db);
//				endif;
//				if($aryProdInfo['file2']):
//					$productMgr->setPM_TYPE("file2");
//					$productMgr->setPM_SAVE_NAME($aryProdInfo['file2']);
//					$productMgr->setPM_REAL_NAME($aryProdInfo['file2']);
//					$productMgr->getProdImgInsert($db);
//				endif;
//				if($aryProdInfo['file3']):
//					$productMgr->setPM_TYPE("file3");
//					$productMgr->setPM_SAVE_NAME($aryProdInfo['file3']);
//					$productMgr->setPM_REAL_NAME($aryProdInfo['file3']);
//					$productMgr->getProdImgInsert($db);
//				endif;

				if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && $aryProdInfo['movie1']):
					$productMgr->setPM_TYPE("movie1");
					$productMgr->setPM_SAVE_NAME("");
					$productMgr->setPM_REAL_NAME($aryProdInfo['movie1']);
					$productMgr->getProdImgInsert($db);
				endif;



			endfor;
			/* Excel 영역 */


			// 파일 삭제
			$fh->fileDelete($strFileInServer);

			$strUrl = "./?menuType=".$strMenuType."&mode=prodAtOneTimeWrite";
			$strMsg = "총 {$intSuccessCnt}개 등록되었습니다.";

		break;

	endswitch;











?>