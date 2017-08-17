<?
	## 경매상품일경우 경매상품정보
	if ($S_PRODUCT_AUCTION_USE == "Y"){
		$auctionParam				= "";
		$auctionParam['P_CODE']		= $strP_CODE; 
		$intProdAuctionCount		= $productMgr->getProdAuctionCount($db,$auctionParam);
		$strProdAuctionUseYN		= "N";
		
		if ($intProdAuctionCount > 0) {
			$strProdAuctionUseYN	= "Y";
			$prodAucRow				= $productMgr->getProdAuctionView($db,$auctionParam);
		
			$intProdAucRemainTime	= 0;
			if ($prodAucRow){
				$intProdAucRemainTime	  = strtotime($prodAucRow['P_AUC_END_DT']) - time();
											
				$strProdAucBestMemberName = "";
				$intProdAucApplyCnt		  = $prodAucRow['P_AUC_APPLY_CNT'];
				if ($prodAucRow['M_F_NAME']) $strProdAucBestMemberName  = $prodAucRow['M_F_NAME']." ";
				if ($prodAucRow['M_L_NAME']) $strProdAucBestMemberName .= $prodAucRow['M_L_NAME'];	
				if ($strProdAucBestMemberName) {
					$strProdAucBestMemberName = strHanCutUtf2($strProdAucBestMemberName, 1,false,'**');
				}

				$strProdAucSucMemberName = "";
				if ($prodAucRow['M_SUC_F_NAME']) $strProdAucSucMemberName  = $prodAucRow['M_SUC_F_NAME']." ";
				if ($prodAucRow['M_SUC_L_NAME']) $strProdAucSucMemberName .= $prodAucRow['M_SUC_L_NAME'];	
				if ($strProdAucSucMemberName) {
					$strProdAucSucMemberName = strHanCutUtf2($strProdAucSucMemberName, 1,false,'**');
				}
			}
		}
	}
?>