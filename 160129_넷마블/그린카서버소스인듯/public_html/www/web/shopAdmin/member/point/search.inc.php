<?
	if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){
	
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
	}

?>
<script type="text/javascript">
<!--
	<?if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){?>

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
	<?}?>
	function goSearch(){
		var data							= new Array(30);
		data['searchField']					= $("#searchField").val();
		data['searchKey']					= $("#searchKey").val();
		data['searchStartStartDt']			= $("#searchStartStartDt").val();
		data['searchStartEndDt']			= $("#searchStartEndDt").val();
		data['searchExpStartDt']			= $("#searchExpStartDt").val();
		data['searchExpEndDt']				= $("#searchExpEndDt").val();
		data['searchNation']				= $("select[name=searchNation]").val();
		data['searchCate1']					= $("select[name=searchCate1]").val();
		data['searchCate2']					= $("select[name=searchCate2]").val();
		data['searchCate3']					= $("select[name=searchCate3]").val();
		data['searchCate4']					= $("select[name=searchCate4]").val();
		data['searchSex']					= $(":radio[name=searchSex]:checked").val();
		data['searchPointStart']			= $("#searchPointStart").val();
		data['searchPointEnd']				= $("#searchPointEnd").val();
		data['searchBirthMonth']			= $("#searchBirthMonth").val();
		data['searchBirthDay']				= $("#searchBirthDay").val();
		data['searchPointType']				= $("#searchPointType").val();
		data['page']						= 1;
		
		C_getAddLocationUrl(data);	
	}
//-->
</script>
<div class="searchFormWrap">
	<select id="searchField" style="width:133px">
		<option value=""		<?if($strSearchField == "")			{echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?></option>
		<option value="id"		<?if($strSearchField == "id")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["MW00095"]//아이디?></option>
		<option value="name"	<?if($strSearchField == "name")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["MW00097"]//이름?></option>
	</select>
	<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> data-enter-event="goSearch" data-auto-focus/>
</div>
<table>
	<colgroup>
		<col style="width:70px;"/>
		<col />
	<colgroup/>
	<tr>
		<th><?=$LNG_TRANS_CHAR["MM00117"]//포인트 시작일?></th>
		<td>
			<input type="text" id="searchStartStartDt" value="<?=$_REQUEST['searchStartStartDt']?>" data-simple-datepicker readOnly style="width:80px"> -
			<input type="text" id="searchStartEndDt"   value="<?=$_REQUEST['searchStartEndDt']?>" data-simple-datepicker readOnly  style="width:80px">
			<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchStartStartDt','searchStartEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchStartStartDt','searchStartEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchStartStartDt','searchStartEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchStartStartDt','searchStartEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchStartStartDt','searchStartEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchStartStartDt','searchStartEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]//전체?></strong></a>
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["MM00118"]//포인트 종료일?></th>
		<td>
			<input type="text" id="searchExpStartDt" value="<?=$_REQUEST['searchExpStartDt']?>" data-simple-datepicker readOnly style="width:80px"> -
			<input type="text" id="searchExpEndDt"   value="<?=$_REQUEST['searchExpEndDt']?>" data-simple-datepicker readOnly  style="width:80px">
			<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]//전체?></strong></a>
		</td>
	</tr>
	<?if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){?>
	<tr>
		<th>소속</th>
		<td  colspan="3">
			<select name="searchNation" id="c_nation">
				<option value=""<?if($_REQUEST['searchNation'] == ""){ echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?></option>
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
		</td>
	</tr>
	<?}?>
	<!--
	<tr>
		<th><?=$LNG_TRANS_CHAR["MW00013"]//성별?></th>
		<td>
			<input type="radio" id="searchSex" name="searchSex" value="" <?if($_REQUEST['searchSex'] == "") { echo " checked"; }?>><?=$LNG_TRANS_CHAR["CW00022"] //전체?>
			<input type="radio" id="searchSex" name="searchSex" value="M"<?if($_REQUEST['searchSex'] == "M"){ echo " checked"; }?>><?=$LNG_TRANS_CHAR["MW00024"] //남?>
			<input type="radio" id="searchSex" name="searchSex" value="W"<?if($_REQUEST['searchSex'] == "W"){ echo " checked"; }?>><?=$LNG_TRANS_CHAR["MW00025"] //여?>
		</td>
	</tr>
	-->
	<tr>
		<th><?=$LNG_TRANS_CHAR["MW00176"]//적립금?></th>
		<td>
			<input type="text" id="searchPointStart" value="<?=$_REQUEST['searchPointStart']?>" style="width:80px">원 -
			<input type="text" id="searchPointEnd"   value="<?=$_REQUEST['searchPointEnd']?>"  style="width:80px">원
		</td>
	</tr>
	<!--
	<tr>
		<th><?=$LNG_TRANS_CHAR["MW00012"]//생년월일?></th>
		<td>
			<?=drawSelectBoxDate("searchBirthMonth", 1, 12, 1, $_REQUEST['searchBirthMonth'], "", $LNG_TRANS_CHAR["CW00022"],"")?><?=$LNG_TRANS_CHAR["CW00013"] //월?>
			<?=drawSelectBoxDate("searchBirthDay", 1, 31, 1, $_REQUEST['searchBirthDay'], "", $LNG_TRANS_CHAR["CW00022"],"")?><?=$LNG_TRANS_CHAR["CW00014"] //일?>
		</td>
	</tr>
	-->
	<tr>
		<th><?=$LNG_TRANS_CHAR["EW00040"]//종류?></th>
		<td>
			<?=drawSelectBoxMore("searchPointType",$aryPointTypeList,$strSearchPointType,$design ="",$onchange="",$etc="",$firstItem=$LNG_TRANS_CHAR["CW00041"],$html="N")?>
		</td>
	</tr>
	<tr>
		<td colspan="4" style="text-align:center">
			<a class="btn_search" href="javascript:goSearch();" style="width:400px;text-align:center"><strong class="ico_search"><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
			<a class="btn_big_reset" href="./?menuType=<?=$strMenuType?>&mode=<?=$strMode?>"><strong><?=$LNG_TRANS_CHAR["CW00085"] //초기화?></strong></a>
			<a class="btn_excel_big" href="javascript:goExcel('excelPointList');" id="menu_auth_e" style="display: inline-block;"><strong>Download</strong></a>
		</td>
	</tr>
</table>