<? include "./include/header.inc.php"?>
<? 
	## 설정
	## 언어 설정
	$aryUseLng			= explode("/", $S_USE_LNG);

	## 회원소속관리 불러오기
	$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
	//include_once $fileName;
	//member.cate.inc.php 파일 자체가 아예 없음.
	if(is_file($fileName)):
		require_once "$fileName";
	endif;
?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>

<script type="text/javascript">
<!--
	var memberCate = new Array(4);
	$(document).ready(function(){
	
		/** 백업후 삭제 **/
		$("select[id=c_cate]").each(function(index) {
			memberCate[index+1] = $(this).find("option");
			if(index <= 3) {
				$(this).change(function() {
					var no = $(this).attr("no");
					memberCateMake(Number(no));
					memberCateView(Number(no));
				});
			}
		});

		memberCateMake(0);
		$("select#c_nation").change(function() { memberCateMake(0); });
	});

	function memberCateMake(no){
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

	function goMemberCateWriteActEvent(close) { goMemberCateWriteAct(close); }

	function goMemberCateWriteAct(close) {
		var checkID		= "write";
		var stop		= "N";
		$("input[check="+checkID+"]").each(function() {
			if(stop == "N") {
				var val		= $(this).val();
				var alt		= $(this).attr("alt");
				if(!val){
					alert(alt);
					$(this).focus();
					stop = "Y";
					return;
				}
			}
		});

		if(stop == "Y") { return; } 

		$("input[name=close]").val(close);

		var mode	= "memberCateWrite";
		var act		= "./";
		C_getAction(mode, act);
	}
	
	function memberCateView(no)
	{
		$("#divCateAddInfo").css("display","none");
		<?if($S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN == "Y"){?>
		if (no == 1)
		{
			$("#divCateAddInfo").css("display","");
		}
		<?}?>
	}

	var strIdChkFlag		= "N";
	function goIdChk() {
		var doc		= document.form;
		var strId	= doc.memberId.value;

		if(!C_chkInput("memberId",true,"아이디",true)) return;

		if ($("#memberId").val().length < 4 || $("#memberId").val().length > 12)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00016']?>"); //"아이디는 영문, 숫자 중 4자 이상 12자리 이하 사용  가능합니다."
			doc.memberId.focus();
			return;
		}
				
		$.getJSON("./?menuType=member&mode=json&act=idChk&id="+strId,function(data){	

			alert(data[0].MSG);

			if (data[0].RET == "N") {
				doc.memberId.value = "";
				doc.memberId.focus();
				return;
			
			} else {
				strIdChkFlag = "Y";
			}
		});
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>회원소속</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>


<div id="contentArea">
	<form name="form" id="form">
		<input type="hidden" name="menuType"	value="<?=$strMenuType?>">
		<input type="hidden" name="mode"		value="<?=$strMode?>">
		<input type="hidden" name="act"			value="<?=$strMode?>">
		<input type="hidden" name="close"		value="">
		
		<div class="tableForm mt10">
			<table>
				<tr>
					<th>국가</th>
					<td>
						<select name="c_nation" id="c_nation">
							<?foreach($aryUseLng as $key => $lng):?>
							<option value="<?=$lng?>"><?=$S_ARY_COUNTRY[$lng]?></option>
							<?endforeach;?>
						</select>
					</td>
				</tr>
				<tr>
					<th>소속 선택</th>
					<td>
						<select name="c_cate_1" id="c_cate" no="1">
							<option value="">1차 카테고리</option>
							<?foreach($MEMBER_CATE as $code => $data):
								if($data['C_LEVEL'] != 1) { continue; }				?>
							<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"><?=$data['C_NAME']?></option>
							<?endforeach;?>
						</select>
						<select name="c_cate_2" id="c_cate" no="2">
							<option value="">2차 카테고리</option>
							<?foreach($MEMBER_CATE as $code => $data):
								if($data['C_LEVEL'] != 2) { continue; }				?>
							<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"><?=$data['C_NAME']?></option>
							<?endforeach;?>
						</select>
						<select name="c_cate_3" id="c_cate" no="3">
							<option value="">3차 카테고리</option>
							<?foreach($MEMBER_CATE as $code => $data):
								if($data['C_LEVEL'] != 3) { continue; }				?>
							<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"><?=$data['C_NAME']?></option>
							<?endforeach;?>
						</select>
						<select name="c_cate_4" id="c_cate" no="4" style="display:none">
							<option value="">4차 카테고리</option>
							<?foreach($MEMBER_CATE as $code => $data):
								if($data['C_LEVEL'] != 4) { continue; }				?>
							<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"><?=$data['C_NAME']?></option>
							<?endforeach;?>
						</select>
					</td>
					<tr>
						<th>카테고리명</th>
						<td><input type="text" name="c_name" value="" style="width:310px" check="write" alt="카테고리명"/></td>
					</tr>
					
					<tr>
						<th>사용 여부</th>
						<td><input type="radio" name="c_view" value="Y" checked/> 사용
							<input type="radio" name="c_view" value="N"/> 사용하지 않음</td>
					</tr>
				</tr>
			</table>
		</div>
		<div class="tableForm mt10" id="divCateAddInfo" style="display:none">
			<table>
				<tr>
					<th>포인트적립</th>
					<td>
						<ul>
							<li>
								영업사원 구매시 포인트 
								<input type="text" name="c_point" value=""/><select name="c_point_off">
																				<option value="1">%</option>
																				<option value="2">point</option>
																			</select> 포인트 적립
							</li>
							<li>
								일반사원 구매시 포인트
								<input type="text" name="c_point2" value=""/><select name="c_point2_off">
																				<option value="1">%</option>
																				<option value="2">point</option>
																			</select> 포인트 적립
							</li>
						</ul>										
					</td>
				</tr>
				<tr>
					<th>로그인정보</th>
					<td>
						<ul>
							<li>	
								아이디	<input type="text" name="memberId" id="memberId" value="" maxlength="20">
								<a class="btn_sml" href="javascript:goIdChk();"><strong>아이디검색</strong></a>
							</li>
							<li>
								비밀번호 <input type="password" name="memberPass" id="memberPass" value="" maxlength="20">
							</li>
						</ul>
					</td>
				</tr>
			</table>
		</div>

		<div class="buttonWrap">
			<a class="btn_blue_big" href="javascript:goMemberCateWriteActEvent('');"><strong>등록</strong></a>
			<a class="btn_blue_big" href="javascript:goMemberCateWriteActEvent('close');"><strong>등록후닫기</strong></a>
			<a class="btn_blue_big" href="javascript:location.reload()"><strong>다시입력</strong></a>
			<a class="btn_blue_big" href="javascript:parent.goPopCloseEvent();"><strong>닫기</strong></a>
		</div>
	</form>
</div>

</body>

</html>