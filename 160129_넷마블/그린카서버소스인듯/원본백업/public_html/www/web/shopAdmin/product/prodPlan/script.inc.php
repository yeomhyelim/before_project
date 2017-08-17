<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
			
		<?if ($strMode == "prodPlanWrite" || $strMode == "prodPlanModify"){?>
		callCateList(1,"","","cateHCode1","<?=$strC_HCODE1?>");
		var strHCode = "";
		
		$("#cateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","cateHCode2","");
			}
		});

		$("#cateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","cateHCode3","");
			}
		});

		$("#cateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$("#cateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","cateHCode4","");
			}
		});

//		$('input[name=pp_start_dt]').simpleDatepicker();
//		$('input[name=pp_end_dt]').simpleDatepicker();
		$('input[name=pp_start_dt]').datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-m-d'
		});
		$('input[name=pp_end_dt]').datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-m-d'
		});

		<?}else{?>
		$('input[name=searchStartDt]').simpleDatepicker();
		$('input[name=searchEndDt]').simpleDatepicker();
		<?}?>
	});
	
	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
//		alert(cateSelected);
		var strJsonParam = "menuType=product&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strStLng?>&cateType=P";
		
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
					var strCateSelected = "";
					if (data[i].CATE_CODE == cateSelected)
					{
						strCateSelected = "selected";
					}
					$("#"+cateObj).append("<option value='"+data[i].CATE_CODE+"' "+strCateSelected+">"+data[i].CATE_NAME+"</option>");
				}
			}
		});
	}

	function goProdCateAdd()
	{
		var strCateCode1		= $("#cateHCode1").val();
		var strCateCode2		= $("#cateHCode2").val();
		var strCateCode3		= $("#cateHCode3").val();
		var strCateCode4		= $("#cateHCode4").val();

		var strCateCodeName1	= $("#cateHCode1 option:selected").text();
		var strCateCodeName2	= (strCateCode2) ? $("#cateHCode2 option:selected").text() : "";
		var strCateCodeName3	= (strCateCode3) ? $("#cateHCode3 option:selected").text() : "";
		var strCateCodeName4	= (strCateCode4) ? $("#cateHCode4 option:selected").text() : "";
		
		if (!strCateCode1)
		{
			alert("카테고리를 선택해주세요.");
			return;
		}

		/* 상품리스트 타이틀 */
		var strCateCode			= strCateCode1+strCateCode2+strCateCode3+strCateCode4;
		var strCateCodeName		= strCateCodeName1;
		if (strCateCodeName2) strCateCodeName += "> "+ strCateCodeName2;
		if (strCateCodeName3) strCateCodeName += "> "+ strCateCodeName3;
		if (strCateCodeName4) strCateCodeName += "> "+ strCateCodeName4;

		/* 중복 상품 카테고리 체크 */
		var intDivCnt = 0;
		$("div[id^='divProdCate_']").each(function(){
			
			if ($(this).attr("id") == "divProdCate_"+strCateCode)
			{
				intDivCnt++;
			}
		});

		if (intDivCnt > 0)
		{
			alert("중복된 카테고리가 존재합니다.");
			return;
		}
		
		
		/* 상품리스트 스크롤 div 생성 */
		var divProdCateScrollContainer	= $('<div />').attr('id','divProdCate_'+strCateCode).css({'overflow-x':'hidden','overflow-y':'scroll','width':'100%','height':'250px'});
		var divProdCateTopWrap			= $('<div />').attr('id','divProdCateTop').addClass('tableListTopWrap').addClass('mt20');
		var divProdCateClear			= $('<div />').addClass('clear');
		var divProdCateTableList		= $('<div />').attr('id','divProdCateTableList').addClass('tableList');
		
		var strProdCateTableHtml		= "<table>";
			strProdCateTableHtml	   += "<tr>";
			strProdCateTableHtml	   += "<th><?=$LNG_TRANS_CHAR['CW00009'] //번호?></th>";
			strProdCateTableHtml	   += "<th><?=$LNG_TRANS_CHAR['PW00002'] //상품명?></th>";
			strProdCateTableHtml	   += "<th><?=$LNG_TRANS_CHAR['PW00003'] //상품코드?></th>";
			strProdCateTableHtml	   += "<th><?=$LNG_TRANS_CHAR['BW00054'] //판매가?></th>";
			strProdCateTableHtml	   += "<th><?=$LNG_TRANS_CHAR['PW00017'] //재고?></th>";
			strProdCateTableHtml	   += "<th><?=$LNG_TRANS_CHAR['CW00026'] //등록일?></th>";
			strProdCateTableHtml	   += "<th><?=$LNG_TRANS_CHAR['CW00004'] //삭제?></th>";
			strProdCateTableHtml	   += "</tr>";
			strProdCateTableHtml	   += "</table>";

		var strProdCateTopHtml		    = "<input type='hidden' name='prodCateCode[]' id='prodCateCode[]' value='"+strCateCode+"'>";
			strProdCateTopHtml		   += "<span>"+strCateCodeName+"</span>";
			strProdCateTopHtml		   += "<div class='selectedSort'>";
			strProdCateTopHtml		   += "<a class='btn_blue_big' href=\"javascript:goProdAdd(\'"+strCateCode+"\');\" id='menu_auth_w'><strong><?='상품등록' //상품등록?></strong></a>";
			strProdCateTopHtml		   += "</div>";
			
		divProdCateTopWrap.append(strProdCateTopHtml);	
		divProdCateTableList.append(strProdCateTableHtml);

		divProdCateScrollContainer.append(strProdCateTopHtml).append(divProdCateClear).append(divProdCateTableList);
		$("#divProdCateList").append(divProdCateScrollContainer);
		/* 상품리스트 스크롤 div 생성 */

		/* 카테고리 초기화 */
		$("#cateHCode1").val("");
		$("#cateHCode2").val("");
		$("#cateHCode3").val("");
		$("#cateHCode4").val("");
	}

	function goProdAdd(code)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popPlanProdSearch&cateCode='+code, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goProdCateTrDel(code,no)
	{
		var trIdx = no;
		var prodCateTableObj = $("#divProdCate_"+code+" > #divProdCateTableList > table > tbody");
		
		prodCateTableObj.find("tr").eq(trIdx).remove();
		
		var intTrCnt = prodCateTableObj.find("tr").length;
		for(var i=1;i<intTrCnt;i++){
			prodCateTableObj.find("tr:eq("+i+") td:eq(0) #spanTrNo").text(i);
			prodCateTableObj.find("tr:eq("+i+") td:eq(6) > a").attr("href","javascript:goProdCateTrDel('"+code+"','"+i+"');");
		}
	}

	function goAct(mode)
	{
		if(!C_chkInput("pp_title",true,"기획전명",true)) return; //기획전명

		C_getAction(mode,'<?=$PHP_SELF?>');
	}

	function goProdPlanWrite()
	{
		var data						= new Array(5);
		
		data['menuType']			= "product";
		data['mode']				= "prodPlanWrite";

		C_getAddLocationUrl(data);
	}

	function goProdPlanModify(no,lang)
	{
		var data					= new Array(5);
		
		data['planNo']				= no;
		data['planLang']			= lang
		data['mode']				= "prodPlanModify";
	
		data['page']				= $("input[name=page]").val();
		
		data['searchField']			= $("#searchField").val();
		data['searchKey']			= $("#searchKey").val();
		data['searchStartDt']		= $("#searchStartDt").val();
		data['searchEndDt']			= $("#searchEndDt").val();
		data['searchViewY']			= $("#searchViewY:checked").val();
		data['searchViewN']			= $("#searchViewN:checked").val();
		
		C_getAddLocationUrl(data);
	}

	function goProdPlanDelete(no)
	{
		var data						= new Array(5);
		
		data['menuType']			= "product";
		data['mode']				= "act";
		data['act']					= "prodPlanDelete"; 
		data['page']				= $("input[name=page]").val();
		
		data['searchField']			= $("#searchField").val();
		data['searchKey']			= $("#searchKey").val();
		data['searchStartDt']		= $("#searchStartDt").val();
		data['searchEndDt']			= $("#searchEndDt").val();
		data['searchViewY']			= $("#searchViewY:checked").val();
		data['searchViewN']			= $("#searchViewN:checked").val();
		
		data['planNo']				= no;
		C_getSelfAction(data);
	}

	function goProdPlanList(lang)
	{
		var data					= new Array(5);
		
		data['lang']				= lang
		data['mode']				= "prodPlanList";
	
		data['page']				= $("input[name=page]").val();
		
		data['searchField']			= $("#searchField").val();
		data['searchKey']			= $("#searchKey").val();
		data['searchStartDt']		= $("#searchStartDt").val();
		data['searchEndDt']			= $("#searchEndDt").val();
		data['searchViewY']			= $("#searchViewY").val();
		data['searchViewN']			= $("#searchViewN").val();
		
		C_getAddLocationUrl(data);
	}

	function goSearch(mode){
		$("input[name=page]").val("");
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goPopClose()
	{		
		$.smartPop.close();
	}
//-->
</script>

