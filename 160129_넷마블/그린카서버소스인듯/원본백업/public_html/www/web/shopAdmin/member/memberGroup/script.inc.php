<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");	
	});
	
	function goGroupAdd(){
		var doc = document.form;
		doc.groupCode.value = "";
		C_getAjax("groupWrite","act");
	}

	function goGroupDistcountSt(){
		
		$("input[name=discount_st]").each(function() {
			if (this.checked)
			{
				var strDiscountStVal = this.value;
			
				$("#divDiscountPrice").css("display","none");
				$("#divDiscountPoint").css("display","none");
				if (strDiscountStVal == "2" || strDiscountStVal == "4")
				{
					$("#divDiscountPrice").css("display","block");
				}

				if (strDiscountStVal == "3" || strDiscountStVal == "4")
				{
					$("#divDiscountPoint").css("display","block");
				}
			}
		});
	}

	function goGroupAddDistcount(){
		
		$("input[name=add_discount]").each(function() {

			if (this.checked)
			{
				var strAddDiscountStVal = this.value;
				
				$("#divAddDiscountPrice").css("display","none");
				if (strAddDiscountStVal == "Y")
				{
					$("#divAddDiscountPrice").css("display","block");
				}
			}
		});
	}

	function goGroupAct(mode)
	{
		if(!C_chkInput("name",true,"<?=$LNG_TRANS_CHAR['MW00006']?>",true)) return; //그룹
		
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goGruopModify(no)
	{
		var doc = document.form;
		doc.groupCode.value = no;

		doc.mode.value = "act";
		doc.act.value = "groupView";
		
		C_getAjax("groupView","act");
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
			alert("카테고리를 선택해주세요.");
			return;
		}

		strHtml  = "<li><input type=\"hidden\" name=\"categoryExpCode[]\" id=\"categoryExpCode[]\" value=\""+strCateExpCode+"\">";
		strHtml += strCateExpNm + "<a class=\"btn_sml\" onClick=\"goGroupExpCategoryDelete(this);\"><strong>삭제</strong></a></li>";
		
		if ($("#ulExpCate").find("li").length == 0)
		{
			$("#ulExpCate").html(strHtml);
		} else {
			
			var intDupCnt = 0;
			/* 이미 선택된 카테고리는 INSERT 제외 */
			$("input[id^=categoryExpCode]").each(function() {
				if (strCateExpCode == this.value)
				{
					alert("이미 선택하신 카테고리입니다.");
					intDupCnt++;
				}
			});
			
			if (intDupCnt == 0)
			{
				$("#ulExpCate > li").after(strHtml);
			}
		}
		
		/* 카테고리 재설정 */
		goGroupExpCateogry();
	}

	function goGroupExpProductSearch(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=member&mode=popGroupProdSearch&groupCode='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goGroupExpProductInsert(html)
	{
		$("#ulExpProd").html(html);
	}
	
	function goGroupExpCategoryDelete(obj)
	{
		var intNo = $(obj).parent().index();
		$("#ulExpCate > li").eq(intNo).remove();
	}

	function goGroupIconDel(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>");
		if (x == true)
		{
			var doc = document.form;
			var strGroupIconDelMode = "";
			
			if (no == "1")
			{
				strGroupIconDelMode = "groupIconDel";	
			} else if (no == "2")
			{
				strGroupIconDelMode = "groupImgDel";	
			} else if (no == "3")
			{
				strGroupIconDelMode = "groupFileDel";	
			}
			C_getAjax(strGroupIconDelMode,"act");
		}
	}

	function goGroupDelete(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>");
		if (x == true)
		{
			var doc = document.form;
			doc.groupCode.value = no;

			C_getAction("groupDelete","<?=$PHP_SELF?>");
		}
	}
	
	function goGroupCancel()
	{
		$("#divGroupForm").css("display","none");
	}

	function goAjaxRet(name,result){

		if (name=="groupIconDel" || name=="groupImgDel" || name=="groupFileDel")
		{			
			var doc = document.form;
			var data = eval(result);
			
			if (data[0].RET == "Y")
			{
				alert(data[0].MSG);				
				location.href = "./?menuType=member&mode=group&groupCode="+$("#groupCode").val();
				return;
			}

		} else if (name == "groupView" || name == "groupWrite"){
			
			
			$("#divGroupForm").css("display","block");
			$("#divGroupForm").html(result);

			goGroupExpCateogry();
		} 
	}

	/* 레이어창 닫기 */
	function goPopClose()
	{		
		$.smartPop.close();
	}
//-->
</script>