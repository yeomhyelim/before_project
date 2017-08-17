<script type="text/javascript">
<!--

	$(document).ready(function(){

		/** 백업후 삭제 **/
		var defaultValue			= new Array(4);
		$("select[id=searchCate]").each(function(index) {
			productCate[index+1]	= $(this).find("option");
			defaultValue[index+1]	= $(this).val();
			if(index <= 3) {
				$(this).change(function() {
					var no = $(this).attr("no");
					productCateMake(no);
				});
			}
		});

		for(var no in defaultValue){
			$("select[id=searchCate][no="+no+"]").val(defaultValue[no]);	
			productCateMake(no);
		}	
	});

	function productCateMake(no){
		no			= Number(no);
		var code	= $("select[id=searchCate][no="+no+"]").val();
		var length	= 0;
		if(code) { length = code.length; }

		for(var i=(no+1);i<=4;i++){
			$("select[id=searchCate][no="+i+"]").find("option").remove();
			$("select[id=searchCate][no="+i+"]").append(productCate[i].eq(0));
		}
		$(productCate[no+1]).each(function() {
			if(length == 0 || code == $(this).val().substr(0,length)){
				$("select[id=searchCate][no="+(no+1)+"]").append($(this));
			}
			$("select[id=searchCate][no="+(no+1)+"]").val("");
		});
	}

	
	function goSearch(){
		var data							= new Array(20);
		data['searchField']					= $("#searchField").myVal();
		data['searchKey']					= $("#searchKey").myVal();
		data['searchCate1']					= $("select[name=searchCate1]").myVal();
		data['searchCate2']					= $("select[name=searchCate2]").myVal();
		data['searchCate3']					= $("select[name=searchCate3]").myVal();
		data['searchCate4']					= $("select[name=searchCate4]").myVal();
		data['searchProductView']			= $(":radio[name=searchProductView]:checked").myVal();


		data['searchStock1']				= $(":checkbox[name=searchStock1]:checked").myVal();
		data['searchStock2']				= $(":checkbox[name=searchStock2]:checked").myVal();
		data['searchStock3']				= $(":checkbox[name=searchStock3]:checked").myVal();

		data['searchShop']					= $("select[name=searchShop]").myVal();
		data['page']						= 1;
		data['pageLine']					= ($("select[name=pageLine]").val()) ? $("select[name=pageLine]").val() : 50;

//		alert(data['searchProductView']);
		C_getAddLocationUrl(data);	
	}

	$.fn.myVal = function() {
		if($(this).length <= 0) { return ""; }
		return $(this).val();
	}

	$.fn.myCheckVal = function() {
		var data = "";
		$(this).each(function() {
			if(data) { data = data + ","; }
			data = data + $(this).myVal();
		});
		return data;
	}
//-->
</script>		
		
		
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="N" <?=($strSearchField=="N")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
				<option value="C" <?=($strSearchField=="C")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
				<option value="M" <?=($strSearchField=="M")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
				<option value="O" <?=($strSearchField=="O")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
				<option value="D" <?=($strSearchField=="D")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
			</select>
			<input type="text" id="searchKey" name="searchKey" <?=$nBox?> value="<?=$strSearchKey?>"/>
			<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchFormWrap -->
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00027"] //카테고리선택?></th>
				<td>
					<?for($i=1;$i<=4;$i++):?>
					<select name="searchCate<?=$i?>" id="searchCate" no="<?=$i?>" style="width:100px">
						<option value=""<?if($_REQUEST["searchCate{$i}"] == ""){ echo " selected";}?>><?=$i?> <?=$LNG_TRANS_CHAR["PW00021"] // 카테고리?></option>
						<?foreach($S_ARY_CATE_NAME as $code => $data):
							if(strlen($code) != (3*$i)) { continue; } ?>
						<option value="<?=$code?>"<?if($_REQUEST["searchCate{$i}"] == $code){ echo " selected";}?>><?=$data['CATE_NM']?></option>
						<?endforeach;?>
					</select>
					<?endfor;?>
					<!--<select id="searchCateHCode1" name="searchCateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode2" name="searchCateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode3" name="searchCateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode4" name="searchCateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?></option>
					</select>//-->
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00159"] //재고상태?></th>
				<td>
					<input type="checkbox" id="searchStock1" name="searchStock1" value="Y" <?=($_REQUEST['searchStock1']=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00041"]//품절?>
					<input type="checkbox" id="searchStock2" name="searchStock2" value="Y" <?=($_REQUEST['searchStock2']=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00042"]//재입고?>
					<input type="checkbox" id="searchStock3" name="searchStock3" value="Y" <?=($_REQUEST['searchStock3']=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00043"]//무제한?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
				<td>
					<input type="radio" id="searchProductView" name="searchProductView" value=""<?if($_REQUEST['searchProductView'] == ""){echo " checked";}?>> <?=$LNG_TRANS_CHAR["CW00022"]//전체?>
					<input type="radio" id="searchProductView" name="searchProductView" value="webYes"<?if($_REQUEST['searchProductView'] == "webYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00169"] //웹 사용?>
					<input type="radio" id="searchProductView" name="searchProductView" value="webNo"<?if($_REQUEST['searchProductView'] == "webNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00170"] //웹 사용안함?> 
					<input type="radio" id="searchProductView" name="searchProductView" value="mobileYes"<?if($_REQUEST['searchProductView'] == "mobileYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00171"] //모바일 사용?>
					<input type="radio" id="searchProductView" name="searchProductView" value="mobileNo"<?if($_REQUEST['searchProductView'] == "mobileNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00172"] //모바일 사용안함?> <br>
					<input type="radio" id="searchProductView" name="searchProductView" value="webMobileYes"<?if($_REQUEST['searchProductView'] == "webMobileYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00173"] //웹/모바일 사용?>
					<input type="radio" id="searchProductView" name="searchProductView" value="webMobileNo"<?if($_REQUEST['searchProductView'] == "webMobileNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00174"] //웹/모바일 사용안함?>
				</td>
			</tr>
			<?if($bShopUse):?>
			<tr>
				<th>입점사</th>
				<td>
					<select name="searchShop" id="searchShop" style="width:200px">
						<option value=""<?if($_REQUEST["searchShop"] == ""){ echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?></option>
						<?foreach($aryShopList as $key => $data): ?>
						<option value="<?=$key?>"<?if($_REQUEST["searchShop"] == "{$key}"){ echo " selected";}?>><?=$data?></option>
						<?endforeach;?>
					</select>
				</td>
			</tr>
			<?endif;?>
		</table>