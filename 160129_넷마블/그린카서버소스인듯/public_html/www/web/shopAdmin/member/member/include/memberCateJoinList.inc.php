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

## 회원소속 리스트
	require_once MALL_CONF_LIB."memberCateMgr.php";
	$memberCateMgr			= new MemberCateMgr();
	
	$param								= "";
	$param['M_NO']						= $_REQUEST['memberNo'];
	$param['ORDER_BY']					= "C.C_CODE ASC";
	$param['MEMBER_CATE_MGR_JOIN']		= "Y";
	$memberCateJoinResult				= $memberCateMgr->getMemberCateJoinListEx($db, "OP_LIST", $param);

?>
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

	function goMemberCateJoinWriteActEvent(close)	{ goMemberCateJoinWriteAct(close);	}
	function goMemberCateJoinDeleteActEvent(no)		{ goMemberCateJoinDeleteAct(no);	}

	function goMemberCateJoinDeleteAct(no) {
		var x = confirm("삭제 하시겠습니까?"); 
		if (!x) { return; }

		var data				= new Array(5);
		data['menuType']		= "member";
		data['mode']			= "act";
		data['act']				= "memberCateJoinDelete";
		data['mc_no']			= no;
		C_getSelfAction(data);
	}

	function goMemberCateJoinWriteAct(close) {
		
		var cate1 = $("select[name=c_cate_1]").val();
		if(!cate1){
			alert("1차 카테고리 이상 선택해주세요.");
			return;
		}

		var mode	= "memberCateJoinWrite";
		var act		= "./";
		C_getAction(mode, act);
	}
//-->
</script>
<div class="tableForm">
	<div class="" style="text-align:right"> 
		<select name="c_nation" id="c_nation">
			<?foreach($aryUseLng as $key => $lng):?>
			<option value="<?=$lng?>"><?=$S_ARY_COUNTRY[$lng]?></option>
			<?endforeach;?>
		</select>
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
		<select name="c_cate_4" id="c_cate" no="4">
			<option value="">4차 카테고리</option>
			<?foreach($MEMBER_CATE as $code => $data):
				if($data['C_LEVEL'] != 4) { continue; }				?>
			<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"><?=$data['C_NAME']?></option>
			<?endforeach;?>
		</select>
		<a class="btn_blue_sml" href="javascript:goMemberCateJoinWriteActEvent('');"><strong>등록</strong></a>
	</div>

	<table>
		<colgroup>
			<col style="width:110px;"/>
			<col/>
			<col style="width:60px;"/>
		</colgroup>
		<?while($row = mysql_fetch_array($memberCateJoinResult)):

			## 카테고리 네비
			$c_level	= strlen($row['C_CODE']) / 3;
			$cateNavi	= $S_ARY_COUNTRY[$row['C_NATION']];
			for($i = 1; $i<=4; $i++):
				if($c_level >= $i):
					if($cateNavi) { $cateNavi .= " > "; }
					$cateCode	 = substr($row['C_CODE'], 0, $i*3);
					$cateNavi	.= $MEMBER_CATE[$cateCode]['C_NAME'];	
				endif;
			endfor;
		?>
		<tr>
			<th>소속</th>
			<td><?=$cateNavi?></td>
			<td><a href="javascript:goMemberCateJoinDeleteActEvent('<?=$row['MC_NO']?>')" class="btn_blue_sml"><strong>삭제</strong></a></td>
		</tr>
		<?endwhile;?>
	</table>
</div>