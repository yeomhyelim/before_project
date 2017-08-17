<? include "./include/header.inc.php"?>
<? 
	## 설정
	require_once MALL_CONF_LIB."memberCateMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	$memberCateMgr			= new MemberCateMgr();
	$memberMgr				= new MemberMgr();

	## 데이터
	$param					= "";
	$param['C_CODE']		= $_REQUEST['c_code'];
	$memberCateRow			= $memberCateMgr->getMemberCateListEx($db, "OP_SELECT", $param);

	## 회원(로그인) 정보
	if($memberCateRow['C_M_NO']):
		$param				= "";
		$param['M_NO']		= $memberCateRow['C_M_NO'];
		$memberRow			= $memberMgr->getMemberListEx($db, "OP_SELECT", $param);
	endif;

	## 삭제 가능 여부 체크
	$param					= "";
	$param['C_CODE_LIKE_L']	= $_REQUEST['c_code'];
	$childCount				= $memberCateMgr->getMemberCateListEx($db, "OP_COUNT", $param);
	if($childCount == 1):
		$delete_btn_use		= "Y";
	endif;

	## 카테고리 차수별 코드
	if($memberCateRow['C_LEVEL'] >= 1) { $cate1 = substr($_REQUEST['c_code'], 0, 3); }
	if($memberCateRow['C_LEVEL'] >= 2) { $cate2 = substr($_REQUEST['c_code'], 0, 6); }
	if($memberCateRow['C_LEVEL'] >= 3) { $cate3 = substr($_REQUEST['c_code'], 0, 9); }
	if($memberCateRow['C_LEVEL'] >= 4) { $cate4 = substr($_REQUEST['c_code'], 0, 12); }	

	## 회원소속관리 불러오기
	$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
	//include_once $fileName;
	//member.cate.inc.php 파일 자체가 아예 없음.
	if(is_file($fileName)):
		require_once "$fileName";
	endif;

## 소속 정보
	$cateNavi			= "";
	if($MEMBER_CATE[$cate1]['C_NAME']):
		$cateNavi		.= $MEMBER_CATE[$cate1]['C_NAME'];
	endif;
	if($MEMBER_CATE[$cate2]['C_NAME']):
		$cateNavi		.= " > ";
		$cateNavi		.= $MEMBER_CATE[$cate2]['C_NAME'];
	endif;
	if($MEMBER_CATE[$cate3]['C_NAME']):
		$cateNavi		.= " > ";
		$cateNavi		.= $MEMBER_CATE[$cate3]['C_NAME'];
	endif;
	if($MEMBER_CATE[$cate4]['C_NAME']):
		$cateNavi		.= " > ";
		$cateNavi		.= $MEMBER_CATE[$cate4]['C_NAME'];
	endif;
?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>
<script type="text/javascript">
<!--

	var bIDCheck	= false;

	$(document).ready(function(){
		$("#memberId").keypress(function() {
			bIDCheck = "needCheck";
		});
	});

	function goMemberCateModifyActEvent(close)	{ goMemberCateModifyAct(close); }
	function goMemberCateDeleteActEvent()		{ goMemberCateDeleteAct();		}

	function goMemberCateDeleteAct() {
		var x = confirm("삭제 하시겠습니까?"); 
		if (!x) { return; }

		$("input[name=close]").val("close");
		var mode	= "memberCateDelete";
		var act		= "./";
		C_getAction(mode, act);
	}

	function goMemberCateModifyAct(close) {
		
		<?if(!$memberRow['M_ID']):?>
		if($("#memberId").val()){
			if(bIDCheck == "needCheck"){
				alert("아이디 중복확인 버튼을 먼저 눌러주세요.");
				return;
			}
			if(!bIDCheck){
				alert("사용할 수 없는 아이디 입니다.");
				$("#memberId").focus();
				return;
			}
			if(!$("#memberPass").val()){
				alert("비밀번호를 입력하세요.");
				$("#memberPass").focus();
				return;
			}
		}
		<?endif;?>

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

	function goIdChk() {
		var myID	= $("#memberId").val();

		$.eumPost({
			url				: "./",
			data			: {
								menuType		: "member",
								mode			: "json",
								act				: "idChk",
								id				: myID	
							  },
			success			: function(data){
								data = eval(data);
								bIDCheck = true;  
								if(data[0]['RET'] != "Y"){
									bIDCheck = false; 
									$("#memberId").focus(); 
								}								
								alert(data[0]['MSG']);
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
		<input type="hidden" name="c_code"		value="<?=$_REQUEST['c_code']?>">


		<div class="tableForm mt10">
			<table>
				<tr>
					<th>국가</th>
					<td><?=$S_ARY_COUNTRY[$memberCateRow['C_NATION']]?></td>
				</tr>
				<tr>
					<th>소속</th>
					<td><?=$cateNavi?></td>
					<tr>
						<th>카테고리명</th>
						<td><input type="text" name="c_name" value="<?=$memberCateRow['C_NAME']?>" style="width:500px" check="modify" alt="카테고리명"/></td>
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
		<div class="tableForm mt10" id="divCateAddInfo" <?if($memberCateRow['C_LEVEL'] == 1 && $S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN == "Y"){?>style="display:none"<?}?>>
			<table>
				<tr>
					<th>포인트적립</th>
					<td>
						<ul>
							<li>
								영업사원 구매시 포인트 
								<input type="text" name="c_point" value="<?=$memberCateRow['C_POINT']?>"/><select name="c_point_off">
																			<option value="1"<?if($memberCateRow['C_POINT_OFF'] == "1") { echo " selected"; }?>>%</option>
																			<option value="2"<?if($memberCateRow['C_POINT_OFF'] == "2") { echo " selected"; }?>>point</option>
																		</select> 포인트 적립
							</li>
							<li>
								일반사원 구매시 포인트
								<input type="text" name="c_point2" value="<?=$memberCateRow['C_POINT2']?>"/><select name="c_point2_off">
																			<option value="1"<?if($memberCateRow['C_POINT2_OFF'] == "1") { echo " selected"; }?>>%</option>
																			<option value="2"<?if($memberCateRow['C_POINT2_OFF'] == "2") { echo " selected"; }?>>point</option>
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
								아이디	<input type="text" name="memberId" id="memberId" value="<?=$memberRow['M_ID']?>" maxlength="20" <?=($memberRow['M_ID'])?"readonly":"";?>>
								<?if (!$memberRow['M_ID']){?><a class="btn_sml" href="javascript:goIdChk();"><strong>아이디 중복확인</strong></a><?}?>
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
			<a class="btn_blue_big" href="javascript:goMemberCateModifyActEvent('close');"><strong>수정</strong></a>
			<a class="btn_blue_big" href="javascript:parent.goPopCloseEvent();"><strong>닫기</strong></a>
			<?if($delete_btn_use == "Y"):?>
			<a class="btn_blue_big" href="javascript:goMemberCateDeleteActEvent();"><strong>삭제</strong></a>
			<?endif;?>
		</div>
	</form>
</div>

</body>

</html>