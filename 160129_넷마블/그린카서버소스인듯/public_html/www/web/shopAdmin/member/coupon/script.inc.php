<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");	
	
		/* 쿠폰 생성 */
		<?if ($strMode == "couponWrite" || $strMode == "couponModify"){?>
			
			goCouponExpCateogry();

			$('input[name=start_dt]').simpleDatepicker();
			$('input[name=end_dt]').simpleDatepicker();	

			$("#use").live("click",function(){
				var strCouponUse = $(this).val();

				/* 특정 카테고리/특정상품일때 */
				$('div[id^="divUse"]').hide();
				if (strCouponUse == "2" || strCouponUse == "3")
				{					
					$("#divUse"+strCouponUse).show();
				}
			});

			$("#img_mth").live("click",function(){
				var strCouponImg = $(this).val();
				
				$("#divImg1").css("display", "none");
				$("#divImg2").css("display", "none");
				
				$("#divImg"+strCouponImg).css("display", "block");
				 
			});

			$("#period").live("click",function(){
				var strCouponPeriod = $(this).val();
				
				$("#divPeriod1").css("display", "none");
				$("#divPeriod2").css("display", "none");
				
				if (strCouponPeriod != "3")
				{	
					$("#divPeriod"+strCouponPeriod).css("display", "block");
				} 
				 
			});
		<?}?>	
	});


	/* 쿠폰 생성 및 수정 */
	function goCouponExpCateogryInsert()
	{
		var strHtml			= "";
		var strCateExpNm	= "";
		var strCateExpCode	= "";

		var strCateCode1 = $("#cateHCode1 option:selected").val();
		var strCateCode2 = $("#cateHCode2 option:selected").val();
		var strCateCode3 = $("#cateHCode3 option:selected").val();
		var strCateCode4 = $("#cateHCode4 option:selected").val();

		var strCateName1 = $("#cateHCode1 option:selected").text();
		var strCateName2 = $("#cateHCode2 option:selected").text();
		var strCateName3 = $("#cateHCode3 option:selected").text();
		var strCateName4 = $("#cateHCode4 option:selected").text();
		
		if (!C_isNull(strCateCode1))
		{
			strCateExpNm	+= strCateName1;
			strCateExpCode  += strCateCode1;
		}

		if (!C_isNull(strCateCode2))
		{
			strCateExpNm	+= " > "+strCateName2;
			strCateExpCode  += strCateCode2;
		}

		if (!C_isNull(strCateCode3))
		{
			strCateExpNm	+= " > "+strCateName3;
			strCateExpCode  += " > "+strCateCode4;
		}

		if (!C_isNull(strCateCode4))
		{
			strCateExpNm	+= strCateName4;
			strCateExpCode  += strCateCode4;
		}

		if (C_isNull(strCateExpCode))
		{
			alert("<?=$LNG_TRANS_CHAR['MS00043']?>"); ////카테고리를 선택해주세요.
			return;
		}

		strHtml  = "<li><input type=\"hidden\" name=\"categoryExpCode[]\" id=\"categoryExpCode[]\" value=\""+strCateExpCode+"\">";
		strHtml += strCateExpNm + "<a class=\"btn_sml\" onClick=\"goCouponExpCategoryDelete(this);\"><strong><?=$LNG_TRANS_CHAR['CW00004']//삭제?></strong></a></li>";
		
		if ($("#ulExpCate").find("li").length == 0)
		{
			$("#ulExpCate").html(strHtml);
		} else {
			
			var intDupCnt = 0;
			/* 이미 선택된 카테고리는 INSERT 제외 */
			$("input[id^=categoryExpCode]").each(function() {
				if (strCateExpCode == this.value)
				{
					alert("<?=$LNG_TRANS_CHAR['MS00044']?>"); ////이미 선택하신 카테고리입니다.
					intDupCnt++;
				}
			});
			
			if (intDupCnt == 0)
			{
				$("#ulExpCate > li").after(strHtml);
			}
		}
		
		/* 카테고리 재설정 */
		goCouponExpCateogry();
	}

	/* 할인예외 카테고리 팝업창*/
	function goCouponExpCateogry()
	{

		callCateList(1,"","","cateHCode1");
		var strHCode = "";

		$("#cateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","cateHCode2");
			}
		});

		$("#cateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","cateHCode3");
			}
		});

		$("#cateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$("#cateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","cateHCode4");
			}
		});
	}

	// 쿠폰사용등록 특정 카테고리 삭제
	function goCouponExpCategoryDelete(obj)
	{
		var intNo = $(obj).parent().index();
		$("#ulExpCate > li").eq(intNo).remove();
	}

	function goCouponExpProductSearch(no)
	{
		$.smartPop.open({  bodyClose: false, width: 950, height: 500, url: './?menuType=member&mode=popCouponProdSearch&cuNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}
	
	function goCouponExpProductInsert(html)
	{
		$("#ulExpProd").html(html);
//		$("#ulExpProd").append(html); 2015.02.23 kim hee sung 어떤이유인지 이부분을 사용하고 있었는데 아래 부분에서 오류가 발생했음.
//		http://hsl.truetech.co.kr/shopAdmin/?menuType=member&mode=couponModify&cuNo=1&searchField=N&searchKey=&searchCouponIssue=&searchCouponUse=&page=						
	}

	function goCouponMoveUrl(no,mode)
	{
		var doc = document.form;
		
		
		if (mode == "couponDelete")
		{
			doc.cuNo.value = no;
			var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //데이터를 삭제하시겠습니까?
			if (x == true)
			{
				C_getAction(mode,"<?=$PHP_SELF?>");
			}
		} else if (mode == "popCouponMemberSearch"){
		
			$.smartPop.open({  bodyClose: false, width: 750, height: 500, url: './?menuType=member&mode='+mode+'&cuNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
		} else if (mode == "couponIssueDelete"){
			doc.ciNo.value = no;
			var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //데이터를 삭제하시겠습니까?
			if (x == true)
			{
				C_getAction(mode,"<?=$PHP_SELF?>");
			}
		} else {
			doc.cuNo.value = no;
			C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
		}
	}

	function goCouponAct(mode)
	{
		if(!C_chkInput("name",true,"<?=$LNG_TRANS_CHAR['MW00111']?>",true)) return; //쿠폰명
		
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goCouponImgDel()
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['MS00046']?>"); //선택된 이미지를 삭제하시겠습니까?
		if (x == true)
		{
			C_getAction("couponImgDel","<?=$PHP_SELF?>");
		}
	}

	function callCateList(cateLevel,cateHCode,cateView,cateObj)
	{
		var strJsonParam = "menuType=product&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strAdmSiteLng?>";

		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data){	
				
				var strCateSelectedText = "";
				if (cateLevel == "1")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00013']?>";
				} else if (cateLevel == "2")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00014']?>";
				} else if (cateLevel == "3")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00015']?>";
				} else if (cateLevel == "4")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00016']?>";
				}

				$("#"+cateObj).html("<option value=''>"+strCateSelectedText+"</option>");
				for(var i=0;i<data.length;i++){
					$("#"+cateObj).append("<option value='"+data[i].CATE_CODE+"'>"+data[i].CATE_NAME+"</option>");
				}
			}
		});
	}

	function goSearch(){
		C_getMoveUrl("<?=$strMode?>","get","<?=$PHP_SELF?>");
	}


	/* 레이어창 닫기 */
	function goPopClose()
	{		
		$.smartPop.close();
	}

	function goGroupExpCateogryInsert()
	{
		var strHtml			= "";
		var strCateExpNm	= "";
		var strCateExpCode	= "";

		var strCateCode1 = $("#cateHCode1 option:selected").val();
		var strCateCode2 = $("#cateHCode2 option:selected").val();
		var strCateCode3 = $("#cateHCode3 option:selected").val();
		var strCateCode4 = $("#cateHCode4 option:selected").val();

		var strCateName1 = $("#cateHCode1 option:selected").text();
		var strCateName2 = $("#cateHCode2 option:selected").text();
		var strCateName3 = $("#cateHCode3 option:selected").text();
		var strCateName4 = $("#cateHCode4 option:selected").text();
		
		if (!C_isNull(strCateCode1))
		{
			strCateExpNm	+= strCateName1;
			strCateExpCode  += strCateCode1;
		}

		if (!C_isNull(strCateCode2))
		{
			strCateExpNm	+= " > "+strCateName2;
			strCateExpCode  += strCateCode2;
		}

		if (!C_isNull(strCateCode3))
		{
			strCateExpNm	+= " > "+strCateName3;
			strCateExpCode  += " > "+strCateCode4;
		}

		if (!C_isNull(strCateCode4))
		{
			strCateExpNm	+= strCateName4;
			strCateExpCode  += strCateCode4;
		}

		if (C_isNull(strCateExpCode))
		{
			alert("<?=$LNG_TRANS_CHAR['MS00043']?>"); //카테고리를 선택해주세요.
			return;
		}

		strHtml  = "<li><input type=\"hidden\" name=\"categoryExpCode[]\" id=\"categoryExpCode[]\" value=\""+strCateExpCode+"\">";
		strHtml += strCateExpNm + "<a class=\"btn_sml\" onClick=\"goCouponExpCategoryDelete(this);\"><strong>삭제</strong></a></li>";
		
		if ($("#ulExpCate").find("li").length == 0)
		{
			$("#ulExpCate").html(strHtml);
		} else {
			
			var intDupCnt = 0;
			/* 이미 선택된 카테고리는 INSERT 제외 */
			$("#ulExpCate > li").each(function(i) {
				var strHiddenCateExpCode = $(this).find("input[id^=categoryExpCode]").val();
				if (strCateExpCode == strHiddenCateExpCode)
				{
					alert("<?=$LNG_TRANS_CHAR['MS00044']?>"); //이미 선택하신 카테고리입니다.
					intDupCnt++;
				}
			});
			
			if (intDupCnt == 0)
			{
				$("#ulExpCate").append(strHtml);
			}
		}
		
		/* 카테고리 재설정 */
		goGroupExpCateogry();
	}

	/* 할인예외 카테고리 팝업창*/
	function goGroupExpCateogry()
	{

		callCateList(1,"","","cateHCode1");
		var strHCode = "";

		$("#cateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","cateHCode2");
			}
		});

		$("#cateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","cateHCode3");
			}
		});

		$("#cateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$("#cateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","cateHCode4");
			}
		});	

	}

	function goExcel(mode)
	{
		var doc = document.form;
		doc.mode.value = "excel";
		doc.act.value = mode;
		doc.method = "get";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}
//-->
</script>