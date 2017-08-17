<script type="text/javascript">
<!--
	
	/* 입찰하기 팝업창 */
	function goProdAuctionApply(prodCode)
	{
		if (C_isNull(intMemberNo)){
			location.href = "./?menuType=member&mode=login";
			return;
		}

		var strUrl = "./?menuType=etc&mode=popProdAuctionApply&prodCode="+prodCode;
		goOpenWinSmartPop(strUrl, "", 500, 300, "");
	}

	/* 입찰하기 리스트 */
	function goProdAuctionApplyList(prodCode)
	{
		var strUrl = "./?menuType=etc&mode=popProdAuctionApplyList&prodCode="+prodCode;
		goOpenWinSmartPop(strUrl, "", 500, 500, "");
	}

	/* 입찰하기 즉시 구매 */
	function goProdAuctionOrder(prodCode){
		
		if (C_isNull(intMemberNo))
		{
			var doc = document.form;
			doc.menuType.value = "member";
			doc.mode.value = "login";
			doc.submit();
			return;
		}
		
		var strJsonParam = "menuType=product&mode=json&act=auctionOrder&prodCode="+prodCode;
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data){	
				var strRet		= data[0].RET;
				var strRetMsg	= data[0].MSG;

				if (strRet == "N")
				{
					alert(strRetMsg);
					return;
				}
			
				$("#divSelectOpt").append(data[0].HTML);
				var doc = document.form;
				doc.menuType.value = "order";
				doc.mode.value = "order";
				doc.submit();
			}
		});
	}

	function goLoginPageMove(prodCode){
		var strReturnParam = "prodCode^||^"+prodCode;
		location.href = "./?menuType=member&mode=login&returnMenu=product&returnMode=view&returnParam="+strReturnParam;
	}
//-->
</script>