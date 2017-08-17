<?
	## STEP 1.
	## 소요기간
	if($g_member_no):
		require_once MALL_CONF_LIB."MemberMgr.php";	
		$memberMgr		= new MemberMgr();
		$settingRow		= $memberMgr->getSettingView($db);
	endif;
	## STEP 2.
	## 포인트 정보
	if($g_member_no):
		$memberMgr->setM_NO($g_member_no);
		$memberRow = $memberMgr->getMemberView($db);
	endif;

	## STEP 3.
	## 설정
	if($memberRow):
		$intPoint		= NUMBER_FORMAT($memberRow['M_POINT']);				// 보유하고 있는 포인트 점수
		$intDuring		= $settingRow['J_RE_DAY'];							// 재가입 할 수 없는 기간(일 단위)
	endif;
?>

<?include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); ?>
<link rel="stylesheet" type="text/css" href="/layout/css/common.css" />

<script type="text/javascript">
<!--
	var readyEvent = "<?=$_REQUEST['callBack']?>";

	$(document).ready(function(){
		if(readyEvent) {
			window[readyEvent]();
		}
		var out_txt		= 

		$('.target').change(function() {
			var tmp = $('.target option:selected').val();
			$("#textContent").attr('style',"display:none;");
			switch (tmp)
			{
				case "1" : 
				msg = "<?=$LNG_TRANS_CHAR['MW00070']  //아이디 변경?>";
				break;

				case "2" : 
				msg = "<?=$LNG_TRANS_CHAR['MW00071']  //개인정보 유출 우려?>";
				break;

				case "3" : 
				msg = "<?=$LNG_TRANS_CHAR['MW00072']  //잦은 서비스 오류 및 장애?>";
				break;

				case "4" : 
				msg = "<?=$LNG_TRANS_CHAR['MW00073']  //서비스 이용 불만족?>";
				break;

				case "5" : 
				msg = "<?=$LNG_TRANS_CHAR['MW00074']  //단조로운 사이트 구성?>";
				break;

				case "6" : 
				msg = "<?=$LNG_TRANS_CHAR['MW00075']  //변화가 없는 사이트?>";
				break;

				case "7" : 
				msg = "<?=$LNG_TRANS_CHAR['MW00076']  //찾고자 하는 정보 미흡?>";
				break;

				case "8" : 
				msg = "<?=$LNG_TRANS_CHAR['MW00077']  //자주 이용하지 않음.?>";
				break;

				case "9" : 
				$("#textContent").attr('style',"display:block;");
				msg = "";
				break;
			}

			$("input[name=out_txt]").val(msg);
		});
	});

	function goMypageDropoutActEvent()			{ goMypageDropoutAct();			}
	function goMemberDropoutCallBackEvent()		{ goMemberDropoutCallBack();	} 

	function goMemberDropoutCallBack() {
		alert("<?=$LNG_TRANS_CHAR['MS00048'] //회원 탈퇴 되었습니다.?>");
		this.close();
		opener.location.href = "./";
	}

	function goMypageDropoutAct() {
		var out_sel		= $("select[name=out_sel]").val();

		var out_txt		= $("input[name=out_txt]").val();
		var pass		= $("input[name=pass]").val();
		if(!out_txt){
			alert("<?=$LNG_TRANS_CHAR['MS00046'] //탈퇴 사유를 입력하세요.?>");
			$("input[name=out_txt]").focus();
			return false;
		}
		if(!pass){
			alert("<?=$LNG_TRANS_CHAR['MS00047'] //비밀번호를 입력하세요.?>");
			$("input[name=pass]").focus();
			return false;
		}

		var doc = document.form;
		doc.menuType.value	= "member";
		doc.mode.value		= "act";
		doc.act.value		= "memberDropout";
		doc.method			= "post";
		doc.action			= "<?=$PHP_SELF?>";
		doc.submit();
	}
//-->
</script>

<body>
	<form name="form" method="post" id="form">
	<input type="hidden" name="menuType"  value="<?=strMenuType?>">
	<input type="hidden" name="mode"	  value="<?=strMode?>">
	<input type="hidden" name="act"		  value="<?=strAct?>">
	<input type="hidden" name="page"      value="<?=strPage?>">

	<div class="memOutWrap">
		<div class="titWrap"><strong><?=$LNG_TRANS_CHAR["MW00067"] //회원탈퇴 신청?></strong></div>
		<div class="txtInfo">
		<!-- <?=callLangTrans($LNG_TRANS_CHAR["MS00038"],array($intPoint)) //회원 탈퇴 신청하시면 보유하고 계시는  {{단어1}} 포인트는 자동 소멸 됩니다.?><br> -->
		<?=callLangTrans($LNG_TRANS_CHAR["MS00039"],array($intDuring)) //탈퇴 신청 후  {{단어1}} 일 동안은 재가입을 할 수 없습니다.?> <br>
		<!-- <?=$LNG_TRANS_CHAR["MS00040"] //재가입 후에도 소멸된 포인트는 복구 되지 않습니다.?> <br> -->
		<?=$LNG_TRANS_CHAR["MS00041"] //신중히 생각하시고 신청해 주시기 바랍니다.?>
		</div>

		<div class="stepOut">
			<h4><?=$LNG_TRANS_CHAR["MW00068"] //탈퇴 신청 방법?></h4>
			<ul>
				<li>1. <?=$LNG_TRANS_CHAR["MS00042"] //탈퇴를 신청하게 된 사유를 입력합니다.?></li>
				<li>2. <?=$LNG_TRANS_CHAR["MS00043"] //비밀번호 확인란에 본인 재확인을 위해 비밀번호를 입력 합니다.?></li>
				<li>3. <?=$LNG_TRANS_CHAR["MS00044"] //탈퇴신청 버튼을 누르면  탈퇴 신청이 완료 됩니다.?></li>
			<ul>
		</div>

		<div class="outTable">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00069"] //탈퇴 사유?></th>
					<td>
						<select name="out_sel" style="width:96%;border:1px solid #adadad;" class="target" />
							<option value="">---------------------------------</option>
							<!--option value="1">아이디 변경</option-->
							<option value="2"><?=$LNG_TRANS_CHAR["MW00071"] //개인정보 유출 우려?></option>
							<option value="3"><?=$LNG_TRANS_CHAR["MW00072"] //잦은 서비스 오류 및 장애?></option>
							<option value="4"><?=$LNG_TRANS_CHAR["MW00073"] //서비스 이용 불만족?></option>
							<option value="5"><?=$LNG_TRANS_CHAR["MW00074"] //단조로운 사이트 구성?></option>
							<option value="6"><?=$LNG_TRANS_CHAR["MW00075"] //변화가 없는 사이트?></option>
							<option value="7"><?=$LNG_TRANS_CHAR["MW00076"] //찾고자 하는 정보 미흡?></option>
							<option value="8"><?=$LNG_TRANS_CHAR["MW00077"] //자주 이용하지 않음.?></option>
							<option value="9"><?=$LNG_TRANS_CHAR["MW00078"] //기타(50자 이내)?></option>
						</select>
						<div id="textContent" style="display:none;">
						<input type="text" name="out_txt" style="width:96%;border:1px solid #adadad;"/>
						</div>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00003"] //비밀번호 확인?></th>
					<td>
						<input type="password"  name="pass" style="border:1px solid #adadad;"/>
						<div class="passInfo">
							* <?=$LNG_TRANS_CHAR["MS00044"] //회원로그인 비밀번호를 입력해 주세요.?>
						</div>
					</td>
				</tr>
			</table>
		</div>

			<div class="btnCenter">
				<a href="javascript:goMypageDropoutActEvent()" class="btnMemOut"><span><?=$LNG_TRANS_CHAR["MW00067"]  //회원탈퇴?></span></a>
				<a href="javascript:this.close()" class="cancelBigBtn"><span><?=$LNG_TRANS_CHAR["MW00044"] //취소?></span></a>
			</div>
	</div>
	</form>
</body>
</html>