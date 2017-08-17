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

</style>
<script type="text/javascript">
<!--
	var memberCate1 = "";
	var memberCate2 = "";
	var memberCate3 = "";
	var memberCate4 = "";
	$(document).ready(function(){

		/** 백업후 삭제 **/
		var nation	= $("select#c_nation").val();

		memberCate1		= $("select#c_cate_1 > option");
		memberCate2		= $("select#c_cate_2 > option");
		memberCate3		= $("select#c_cate_3 > option");
		memberCate4		= $("select#c_cate_4 > option");

		$("select#c_cate_1 > option").remove();
		$("select#c_cate_1").append($(memberCate1).eq(0)); 
		$("select#c_cate_2 > option").remove();
		$("select#c_cate_2").append($(memberCate2).eq(0)); 
		$("select#c_cate_3 > option").remove();
		$("select#c_cate_3").append($(memberCate3).eq(0)); 
		$("select#c_cate_4 > option").remove();
		$("select#c_cate_4").append($(memberCate4).eq(0)); 

		/** 1차 카테고리 적용 **/
		$(memberCate1).each(function(){
			if($(this).attr("nation") == nation) {
				if($(this).val().length == 3) {
					$("select#c_cate_1").append($(this)); 
				}
			}
		});

		$("select#c_nation").change(function() {
			var nation = $(this).val();
			$("select#c_cate_1").val("");
			$("select#c_cate_2").val("");
			$("select#c_cate_3").val("");
			$("select#c_cate_4").val("");
		});

		$("select#c_cate_1").change(function() {
			$("select#c_cate_2 > option").remove();
			$("select#c_cate_2").append($(memberCate2).eq(0)); 
			$("select#c_cate_3 > option").remove();
			$("select#c_cate_3").append($(memberCate3).eq(0)); 
			$("select#c_cate_4 > option").remove();
			$("select#c_cate_4").append($(memberCate4).eq(0)); 
			
			var nation			= $("select#c_nation").val();
			var cateCode		= $(this).val();
			
			/** 2차 카테고리 적용 **/
			$(memberCate2).each(function() {
				if($(this).attr("nation") == nation) {
					if($(this).val().substr(0,3) == cateCode) {
						$("select#c_cate_2").append($(this)); 
					}
				}
			});			
		});

		$("select#c_cate_2").change(function() {
			$("select#c_cate_3 > option").remove();
			$("select#c_cate_3").append($(memberCate3).eq(0)); 
			$("select#c_cate_4 > option").remove();
			$("select#c_cate_4").append($(memberCate4).eq(0)); 

			var nation			= $("select#c_nation").val();
			var cateCode		= $(this).val();
			
			/** 3차 카테고리 적용 **/
			$(memberCate3).each(function() {
				if($(this).attr("nation") == nation) {
					if($(this).val().substr(0,6) == cateCode) {
						$("select#c_cate_3").append($(this)); 
					}
				}
			});			
		});

		$("select#c_cate_3").change(function() { 
			$("select#c_cate_4 > option").remove();
			$("select#c_cate_4").append($(memberCate4).eq(0)); 

			var nation			= $("select#c_nation").val();
			var cateCode		= $(this).val();
			
			/** 3차 카테고리 적용 **/
			$(memberCate4).each(function() {
				if($(this).attr("nation") == nation) {
					if($(this).val().substr(0,9) == cateCode) {
						$("select#c_cate_4").append($(this)); 
					}
				}
			});			
		});
	});

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


//-->
</script>


	<div id="contentArea">
		<div class="layoutWrap">
		<form name="form" id="form">
			<input type="hidden" name="menuType"	value="<?=$strMenuType?>">
			<input type="hidden" name="mode"		value="<?=$strMode?>">
			<input type="hidden" name="act"			value="<?=$strMode?>">
			<input type="hidden" name="close"		value="">

			<div class="contentTop">
				<h2>회원소속 카테고리 관리</h2>
			</div>

			<div class="tableForm mt10">
				<table>
					<tr>
						<th>국가</th>
						<td><select name="c_nation" id="c_nation">
								<?foreach($aryUseLng as $key => $lng):?>
								<option value="<?=$lng?>"><?=$S_ARY_COUNTRY[$lng]?></option>
								<?endforeach;?>
							</select></td>
					</tr>
					<tr>
						<th>소속 선택</th>
						<td><select name="c_cate_1" id="c_cate_1">
								<option value="">1차 카테고리</option>
								<?foreach($MEMBER_CATE as $code => $data):
									if($data['C_LEVEL'] != 1) { continue; }				?>
								<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"><?=$data['C_NAME']?></option>
								<?endforeach;?>
							</select>
							<select name="c_cate_2" id="c_cate_2">
								<option value="">2차 카테고리</option>
								<?foreach($MEMBER_CATE as $code => $data):
									if($data['C_LEVEL'] != 2) { continue; }				?>
								<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"><?=$data['C_NAME']?></option>
								<?endforeach;?>
							</select>
							<select name="c_cate_3" id="c_cate_3">
								<option value="">3차 카테고리</option>
								<?foreach($MEMBER_CATE as $code => $data):
									if($data['C_LEVEL'] != 3) { continue; }				?>
								<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"><?=$data['C_NAME']?></option>
								<?endforeach;?>
							</select>
							<select name="c_cate_4" id="c_cate_4">
								<option value="">4차 카테고리</option>
								<?foreach($MEMBER_CATE as $code => $data):
									if($data['C_LEVEL'] != 4) { continue; }				?>
								<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"><?=$data['C_NAME']?></option>
								<?endforeach;?>
							</select>
						</td>
						<tr>
							<th>카테고리명</th>
							<td><input type="text" name="c_name" value="본부" style="width:500px" check="write" alt="카테고리명"/></td>
						</tr>
						<tr>
							<th>포인트적립</th>
							<td>영업사원 구매시 포인트 
								<input type="text" name="c_point" value="5"/><select name="c_point_off">
																				<option value="1">%</option>
																				<option value="2">point</option>
																			</select> 포인트 적립</td>
						</tr>
						<tr>
							<th>사용 여부</th>
							<td><input type="radio" name="c_view" value="Y" checked/> 사용
								<input type="radio" name="c_view" value="N"/> 사용하지 않음</td>
						</tr>
					</tr>
					</tr>
				</table>
			</div>

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goMemberCateWriteActEvent('');"><strong>등록</strong></a>
				<a class="btn_blue_big" href="javascript:goMemberCateWriteActEvent('close');"><strong>등록후닫기</strong></a>
				<a class="btn_blue_big" href="javascript:parent.goPopCloseEvent();"><strong>닫기</strong></a>
			</div>
		</form>
		</div>
	</div>

</body>

</html>