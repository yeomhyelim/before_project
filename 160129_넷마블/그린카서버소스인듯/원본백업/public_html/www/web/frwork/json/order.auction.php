<?
			/* 경매관련정보 UPDATE */
			if ($S_PRODUCT_AUCTION_USE == "Y"){
				## 클래스 설정
				$objProductAuctionModule					= new ProductAuctionModule($db);
				$strProdAuctionCode							= "";
				$strProdAuctionOrderYN						= "N";
				switch($strAuctionMode){
					case "1":
						## 포인트 결제
						if ($prodAucRow){						
							$strProdAuctionCode				= $prodAucRow['P_CODE'];
							$strProdAuctionOrderYN			= "Y";
						}
					break;
					case "2":
						## 일반결제
						if (is_array($aryOrderCartList)){
							$auctionParam					= "";
							$auctionParam['P_CODE']			= $aryOrderCartList[0]['P_CODE'];
							$auctionParam['P_LNG']			= $S_SITE_LNG;
							$auctionParam['P_AUC_DT']		= "Y";
							
							$auctionParam['NOT_AUC_STATUS'] = "'1','3'";
							$prodAucRow						= $objProductAuctionModule->getProductAuctionViewEx($auctionParam);
							
							if ($prodAucRow){
								if ($prodAucRow['P_AUC_ORDER'] != "Y"){
									$strProdAuctionCode		= $prodAucRow['P_CODE'];
									$strProdAuctionOrderYN	= "Y";
								}
							}
						}
					break;
				}
				
				## 구매시 해당 상품의 경매 구매정보 UPDATE
				if ($strProdAuctionCode && $strProdAuctionOrderYN == "Y"){
					$auctionParam							= "";
					$auctionParam['P_CODE']					= $strProdAuctionCode;
					$auctionParam['P_AUC_ORDER_NO']			= $intO_NO;
					if ($prodAucRow['P_AUC_STATUS'] == "2"){
						$auctionParam['P_AUC_STATUS']		= "4";
					}
					
					$auctionParam['P_AUC_ORDER']			= $strProdAuctionOrderYN;
					$auctionParam['P_AUC_ORDER_DT']			= "NOW()";						
					$objProductAuctionModule->getProductAuctionStatusUpdateEx($auctionParam);
					
				}
			}

?>