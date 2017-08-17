<? include "./include/header.inc.php"?>
<? 
	## 설정
	require_once MALL_CONF_LIB."memberCateMgr.php";
	$memberCateMgr			= new MemberCateMgr();

	$param					= "";
	$param['C_CODE']		= $_REQUEST['c_code'];
	$memberCateRow			= $memberCateMgr->getMemberCateListEx($db, "OP_SELECT", $param);

	$c_nation				= $memberCateRow['C_NATION'];
	if($memberCateRow['C_LEVEL'] >= 1) { $cate1 = substr($param['C_CODE'], 0, 3); }
	if($memberCateRow['C_LEVEL'] >= 2) { $cate2 = substr($param['C_CODE'], 0, 6); }
	if($memberCateRow['C_LEVEL'] >= 3) { $cate3 = substr($param['C_CODE'], 0, 9); }
	if($memberCateRow['C_LEVEL'] >= 4) { $cate4 = substr($param['C_CODE'], 0, 12); }

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

</style>
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

	function goMemberCateModifyActEvent(close) { goMemberCateModifyAct(close); }

	function goMemberCateModifyAct(close) {
		var checkID		= "modify";
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

		var mode	= "memberCateModify";
		var act		= "./";
		C_getAction(mode, act);
	}


//-->
</script>


	<div id="contentArea">
		<div class="layoutWrap">
		<form name="form" id="form">
			<input type="hidden" name="menuType"	value="<?=$strMenuType?>">
			<input type="hidden" name="mode"		value="<?=$strMode?>">
			<input type="hidden" name="act"			value="<?=$strMode?>">
			<input type="hidden" name="close"		value="">
			<input type="hidden" name="c_code"		value="<?=$_REQUEST['c_code']?>">
			<div class="contentTop">
				<h2>회원소속 카테고리 수정</h2>
				<div class="clr"></div>
			</div>

			<div class="tableForm mt10">
				<table>
					<tr>
						<th>국가</th>
						<td><select name="c_nation" id="c_nation">
								<?foreach($aryUseLng as $key => $lng):?>
								<option value="<?=$lng?>"<?if($lng == $memberCateRow['C_NATION']) { echo " selected"; }?>><?=$S_ARY_COUNTRY[$lng]?></option>
								<?endforeach;?>
							</select></td>
					</tr>
					<tr>
						<th>소속 선택</th>
						<td><select name="c_cate_1" id="c_cate" no="1">
								<option value="">1차 카테고리</option>
								<?foreach($MEMBER_CATE as $code => $data):
									if($data['C_LEVEL'] != 1) { continue; }				?>
								<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($cate1 == $code) { echo " selected"; }?>><?=$data['C_NAME']?></option>
								<?endforeach;?>
							</select>
							<select name="c_cate_2" id="c_cate" no="2">
								<option value="">2차 카테고리</option>
								<?foreach($MEMBER_CATE as $code => $data):
									if($data['C_LEVEL'] != 2) { continue; }				?>
								<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($cate2 == $code) { echo " selected"; }?>><?=$data['C_NAME']?></option>
								<?endforeach;?>
							</select>
							<select name="c_cate_3" id="c_cate" no="3">
								<option value="">3차 카테고리</option>
								<?foreach($MEMBER_CATE as $code => $data):
									if($data['C_LEVEL'] != 3) { continue; }				?>
								<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($cate3 == $code) { echo " selected"; }?>><?=$data['C_NAME']?></option>
								<?endforeach;?>
							</select>
							<select name="c_cate_4" id="c_cate" no="4" style="display:none">
								<option value="">4차 카테고리</option>
								<?foreach($MEMBER_CATE as $code => $data):
									if($data['C_LEVEL'] != 4) { continue; }				?>
								<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($cate4 == $code) { echo " selected"; }?>><?=$data['C_NAME']?></option>
								<?endforeach;?>
							</select>
						</td>
						<tr>
							<th>카테고리명</th>
							<td><input type="text" name="c_name" value="<?=$memberCateRow['C_NAME']?>" style="width:500px" check="modify" alt="카테고리명"/></td>
						</tr>
						<tr>
							<th>포인트적립</th>
							<td>영업사원 구매시 포인트 
								<input type="text" name="c_point" value="<?=$memberCateRow['C_POINT']?>"/><select name="c_point_off">
																				<option value="1"<?if($memberCateRow['C_POINT_OFF'] == "1") { echo " selected"; }?>>%</option>
																				<option value="2"<?if($memberCateRow['C_POINT_OFF'] == "2") { echo " selected"; }?>>point</option>
																			</select> 포인트 적립</td>
						</tr>
						<tr>
							<th>사용 여부</th>
							<td><input type="radio" name="c_view" value="Y"<?if($memberCateRow['C_VIEW'] == "Y") { echo " checked"; }?>/> 사용
								<input type="radio" name="c_view" value="N"<?if($memberCateRow['C_VIEW'] == "N") { echo " checked"; }?>/> 사용하지 않음</td>
						</tr>
					</tr>
					</tr>
				</table>
			</div>

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goMemberCateModifyActEvent('close');"><strong>수정</strong></a>
				<a class="btn_blue_big" href="javascript:parent.goPopCloseEvent();"><strong>닫기</strong></a>
			</div>
		</form>
		</div>
	</div>

</body>

</html>