<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		callCateList(1,"","","searchCateHCode1","<?=$strSearchHCode1?>");
		
		<?if ($strSearchHCode1){?>
		callCateList(2,"<?=$strSearchHCode1?>","","searchCateHCode2","<?=$strSearchHCode2?>");
		<?}?>
		<?if ($strSearchHCode2){?>
		callCateList(3,"<?=$strSearchHCode1.$strSearchHCode2?>","","searchCateHCode3","<?=$strSearchHCode3?>");
		<?}?>
		<?if ($strSearchHCode3){?>
		callCateList(4,"<?=$strSearchHCode1.$strSearchHCode2.$strSearchHCode3?>","","searchCateHCode4","<?=$strSearchHCode4?>");
		<?}?>

		var strHCode = "";

		$("#searchCateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","searchCateHCode2","");
			}
		});

		$("#searchCateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#searchCateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","searchCateHCode3","");
			}
		});

		$("#searchCateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#searchCateHCode1 option:selected").val()+$("#searchCateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","searchCateHCode4","");
			}
		});
	});

	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
//		alert(cateSelected);
		var strJsonParam = "menuType=<?=$strMenuType?>&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strStLng?>";
		
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


	/* 관심상품 팝업창 링크 */
	function goPopup(mode,popName,popWidth,popHeight,param)
	{
		C_openWindow("./?menuType=product&mode="+mode+param,popName, popWidth, popHeight);
	}
//-->
</script>