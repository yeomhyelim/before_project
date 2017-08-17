<?	
	#/*====================================================================*/# 
	#|작성자	: 박영미(ivetmi@naver.com)									|# 
	#|작성일	: 2013-08-16												|# 
	#|작성내용	: 포인트선물하기											|# 
	#/*====================================================================*/# 

	## 설정
	## 언어 설정
	$aryUseLng			= explode("/", $S_USE_LNG);

	## 회원소속관리 불러오기
	//$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
	//include_once $fileName;
	//member.cate.inc.php 파일 자체가 아예 없음.
	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
	endif;

	
?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	var memberCate = new Array(4);
	$(document).ready(function(){
		/** 백업후 삭제 **/
		var defaultValue			= new Array(4);
		$("select[id=c_cate]").each(function(index) {
			memberCate[index+1]		= $(this).find("option");
			defaultValue[index+1]	= $(this).val();
			if(index <= 3) {
				$(this).change(function() {
					var no = $(this).attr("no");
					memberCateMake(no);
					memberCateWrite(no);
				});
			}
		});

		memberCateMake(0);
		for(var key in defaultValue){
			if(defaultValue[key]){
				$("select[id=c_cate][no="+key+"]").val(defaultValue[key]);	
				memberCateMake(key);
			}
		}		
	
		$("select#c_nation").change(function() { memberCateMake(0); });


		/** 포인트 기부 방법 선택 **/
		$("input:radio[id=pointGiveType]").click(function(){ 
			var strVal	= $(this).val();
			$("#divMemberCate").css("display","none");
			if (strVal == "C")
			{
				$("#divMemberCate").css("display","");
			} else {
				window.open('?menuType=etc&mode=popMemPointGiftSearch','memPointGiftSearch','width=500px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');		
			}
		});

		$('#pointMark').numeric({allow:"."});
		$("#pointMark").css("ime-mode", "disabled"); 

	});

	function memberCateMake(no){
		no			= Number(no);
		var nation	= $("select[id=c_nation]").val();
		var code	= $("select[id=c_cate][no="+no+"]").val();
		var length	= 0;
		if(code) { length = code.length; }

		for(var i=(no+1);i<=4;i++){
			$("select[id=c_cate][no="+i+"]").find("option").remove();
			$("select[id=c_cate][no="+i+"]").append(memberCate[i].eq(0));
		}
		$(memberCate[no+1]).each(function() {
			if($(this).attr("nation") == nation) {
				if(length == 0 || code == $(this).val().substr(0,length)){
					$("select[id=c_cate][no="+(no+1)+"]").append($(this));
				}
			}
			$("select[id=c_cate][no="+(no+1)+"]").val("");
		});
	}

	function memberCateWrite(no) {
		no				= Number(no);
		var nation		= $("select[id=c_nation]").val();
		var code		= $("select[id=c_cate][no="+no+"]").val();
		var codeText	= $("select[id=c_cate][no="+no+"] option:selected").text();
		var length	= 0;
		if(code) { length = code.length; }
		var strHtml = "";
		if(no == 3){
			
			var isCheck = true;
			$("input:hidden[id^=pointGiveCode]").each(function(){  
				
				if ($(this).val() == code)
				{
					isCheck = false;
				}
			});
			
			if (isCheck)
			{
				strHtml += "<li>";
				strHtml += "	<input type=\"hidden\" name=\"pointGiveCode[]\" id=\"pointGiveCode[]\" value=\""+code+"\">"+codeText;
				strHtml += "</li>";
								
				$("#ulPointGiveList").append(strHtml);
			}
		}
	}

	function goMemberPointMoveInsert(html)
	{
		$("#ulPointGiveList").html("");
		$("#ulPointMoveMemInfo").append(html);
	}

	function goMemberPointMoveDelete(obj)
	{
		var intNo = $(obj).parent().index();
		$("#ulPointMoveMemInfo > li").eq(intNo).remove();
	}


	function goMemPointGiftAct()
	{
		var strPointGiveType = $("input[id=pointGiveType]:checked").val();
		
		if (strPointGiveType == "C")
		{
			if ($("input:hidden[id^=pointGiveCode]").length == 0)
			{
				alert("선택된 대상이 없습니다.");
				return;
			}
		}

		if (strPointGiveType == "M")
		{
			if ($("input:hidden[id^=chkMemMoveNo]").length == 0)
			{
				alert("선택된 대상이 없습니다.");
				return;
			}
		}

		
		if(!C_chkInput("pointMark",true,"선물하는 포인트",true)) return; //선물하는포인트
		if(!C_chkInput("pointMemo",true,"설명",true)) return; //설명

		if ($("#pointMark").val() <= 0)
		{
			alert("선물하는 포인트가 0보다 크게 입력하셔야 합니다.");
			return;
		}

		var doc = document.form;
		doc.menuType.value = "member";
		doc.mode.value = "json";
		doc.jsonMode.value = "memberPointMove";
		doc.act.value = "memberPointMove";
		
		var formData = $("#form").serialize();
		//doc.submit();
		C_AjaxPost("memberPointMove","./index.php",formData,"post");	
	}

	function goAjaxRet(name,result){
		if (name == "memberPointMove")
		{			
			var doc = document.form;
			var data = eval(result);
			
			alert(data[0].MSG);
			if (data[0].RET == "Y")
			{
				opener.location.reload();
				self.close();
			} else {
				if (data[0].CODE == "9999")
				{
					opener.location.href = "./menuType=member&mode=login";
					self.close();
				}
			}
		}
	}
//-->
</script>
<style>
	div.tableOrderForm{padding:15px;}
	div.tableform table{width:100%;}
	div.tableform table th{width:100px;height:22px;padding:5px;border:1px solid #cccccc;background:#f5f5f5;}
	div.tableform table td{padding:5px;border:1px solid #cccccc;}
</style>
<body>
<h2 style="margin-top:15px;margin-left:10px;border-bottom:2px solid #262626;">포인트 선물하기</h2>
<form name='form' method='post' id="form">
<input type="hidden" name="menuType" value="member">
<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
<input type="hidden" name="act" id="act" value="<?=$strMode?>">
<input type="hidden" name="jsonMode" id="jsonMode" value="">
<div class="tableOrderForm mt10">
	<div class="tableform">
		<table>
			<colgroup>
				<col style="width:100px;"/>
				<col/>
			</colgroup>
			<tr>
				<th>지급방법</th>
				<td>
					<input type="radio" name="pointGiveType" id="pointGiveType" value="C" checked>소속기부
					<input type="radio" name="pointGiveType" id="pointGiveType"	value="M">개인에게 선물하기
					<div id="divMemberCate">
						<select name="searchNation" id="c_nation">
							<option value=""<?if($_REQUEST['searchNation'] == ""){ echo " selected";}?>>전체</option>
							<?foreach($aryUseLng as $key => $lng):?>
							<option value="<?=$lng?>"<?if($_REQUEST['searchNation'] == $lng){ echo " selected";}?>><?=$S_ARY_COUNTRY[$lng]?></option>
							<?endforeach;?>
						</select>
						<select name="searchCate1" id="c_cate" no="1">
							<option value=""<?if($_REQUEST['searchCate1'] == ""){ echo " selected";}?>>1차 카테고리</option>
							<?foreach($MEMBER_CATE as $code => $data):
								if($data['C_LEVEL'] != 1) { continue; }				?>
							<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate1'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
							<?endforeach;?>
						</select>
						<select name="searchCate2" id="c_cate" no="2">
							<option value=""<?if($_REQUEST['searchCate2'] == ""){ echo " selected";}?>>2차 카테고리</option>
							<?foreach($MEMBER_CATE as $code => $data):
								if($data['C_LEVEL'] != 2) { continue; }				?>
							<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate2'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
							<?endforeach;?>
						</select>
						<select name="searchCate3" id="c_cate" no="3">
							<option value=""<?if($_REQUEST['searchCate3'] == ""){ echo " selected";}?>>3차 카테고리</option>
							<?foreach($MEMBER_CATE as $code => $data):
								if($data['C_LEVEL'] != 3) { continue; }				?>
							<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate3'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
							<?endforeach;?>
						</select>
						<select name="searchCate4" id="c_cate" no="4">
							<option value=""<?if($_REQUEST['searchCate4'] == ""){ echo " selected";}?>>4차 카테고리</option>
							<?foreach($MEMBER_CATE as $code => $data):
								if($data['C_LEVEL'] != 4) { continue; }				?>
							<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate4'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
							<?endforeach;?>
						</select>					
					
					</div>
				</td>
			</tr>
			<tr>
				<th>선택된 대상</th>
				<td>
					<ul id="ulPointGiveList">
					</ul>
					<ul id="ulPointMoveMemInfo">
					</ul>
				</td>
			</tr>
			<tr>
				<th>선물하는 포인트</th>
				<td>
					<input type="input" id="pointMark" name="pointMark" class="defInput _w100" maxlength="10" value=""/> point
				</td>
			</tr>
			<tr>
				<th>설명</th>
				<td>
					<input type="input" id="pointMemo" name="pointMemo" class="defInput _w200" maxlength="30" value=""/>
				</td>
			</tr>
		</table>
	</div>
	<div class="btnCenter">
		<span id="spanTotCouponPrice"></span>
		<a href="javascript:goMemPointGiftAct();">[적용]</a>
		<a href="javascript:self.close();">[<?=$LNG_TRANS_CHAR["CW00034"] //닫기?>]</a>
	</div>
</div>
</form>
</body>
</html>