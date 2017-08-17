<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	$memberMgr = new MemberMgr();

	$intM_NO		= $_POST["memberNo"]					? $_POST["memberNo"]					: $_REQUEST["memberNo"];

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	if (!$intM_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["CS00013"]); //"해당 회원정보가 존재하지 않습니다."
		exit;
	}

	$memberMgr->setM_NO($intM_NO);
	$memberRow = $memberMgr->getMemberView($db);

	$strMemberJoinType = $memberRow['M_GROUP']; // 회원가입항목처리
	$memberMgr->setG_CODE($memberRow['M_GROUP']);
	$memberGroupRow = $memberMgr->getGroupView($db);

	$strMemberName  = ($memberRow[M_L_NAME]) ? $memberRow[M_L_NAME]:"";
	if ($strMemberName) $strMemberName .= " ";
	$strMemberName .= ($memberRow[M_F_NAME]) ? $memberRow[M_F_NAME]:"";

	if ($S_MEM_CERITY == "1") $strMemberId = " / (id:".$memberRow[M_ID].")";



	if ($memberRow[M_SEX] == "W") $strMemberSexImg = "/shopAdmin/himg/common/photo_img_2.gif";
	else $strMemberSexImg = "/shopAdmin/himg/common/photo_img_1.gif";

	## 검색 필드 설정
	if(!$strSearchField) { $strSearchField = "hp"; }
?>
<script language="javascript" type="text/javascript" src="./common/js/jquery.tokeninput.js" ></script>
<link rel="stylesheet" href="./common/css/token-input.css" type="text/css" />
<link rel="stylesheet" href="./common/css/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
	<!--
		var rootDir 		= "/common/eumEditor/highgardenEditor";
		var uploadImg 		= "/editor/board";
		var uploadFile		= "/<?=$S_SITE_LNG_PATH?>/index.php";
		var htmlYN			= "Y";

// /kr/index.php?menuType=etc&mode=attachImage&editor_upload=/editor/board&ifrmObjId=new_ub_text_iframe


//		function goMemberReportWriteActEvent() { goMemberReportWriteAct(); } // 상담관리 상담등록

		$(document).ready(function(){
			$("input[name=searchKey]").focus();

			$("#searchArea").focusin(function() {
				$("#searchDataList").css("display","");
			});

			$(".memberCrmPop").click(function() {
				$("#searchDataList").css("display","none");
				$("#searchDataList").css({'display':'','height':'0px','border':'0px solid #dfdfdf'});
			});

//			$("#searchArea").focusout(function() {
//				$("#searchDataList").css("display","none");
//				$("#searchDataList").css({'display':'','height':'0px','border':'0px solid #dfdfdf'});
//			});
		});

//		function goMemberReportWriteAct() {
//			C_getAction("memberReportWrite","<?=$PHP_SELF?>");
//		}

		function goMemberSearch(){
			var data				= new Object();
			var searchField			= $("input[name=searchField]:checked").val();

// 2013.12.20 kim hee sung encodeURIComponent() 함수를 사용하면 한글이 깨짐
			var searchKey			= $("#searchKey").val();
//			var searchKey			= encodeURIComponent($("#searchKey").val());

			data['menuType']		= "member";
			data['mode']			= "json";
			data['act']				= "memberCrmSearch";
			data['searchField']		= searchField;
			data['searchKey']		= searchKey;

			$.ajax({
				 type		: "POST"
				,url		: "./index.php"
				,dataType	: "json"
				,data		: data
				,success:function(data){
					if(data['__STATE__'] == "SUCCESS") {
						var dataResult			= data['DATA'];
						var dataResultLength	= dataResult.length;
						if(dataResultLength == 1) {
							goMemberChangeMoveEvent(dataResult[0]['no']);
						} else {
							var html		= "";
							var height		= 10;
							for(var idx in dataResult) {
								var id		= dataResult[idx]['id'];
								var no		= dataResult[idx]['no'];
								var name	= dataResult[idx]['name'];
								if(!id) { id = ""; }
								html		= html + "<li><a href='javascript:goMemberChangeMoveEvent(" + no + ")'>" + id + "(" + name + ")</a></li>";
								height		= height + 23;
							}
							if(height > 102) { height = 102; }
							$("#searchDataList ul").html(html);
							$("#searchDataList").css({'display':'','height':''+height+'px','border':'5px solid #dfdfdf'});
							$("input[name=searchKey]").focus();

						}
					} else if(data['__STATE__'] == "NO_DATA") {
						alert("검색 내용이 없습니다.");
					} else {
						alert(data['__STATE__']);
					}
				}
			});
		}

		function goMemberChangeMoveEvent(no) {
			var data			= new Array();
			data['memberNo']	= no;
			C_getAddLocationUrl(data);
		}

//		function goSearchDataListCloseEvent() {
//			$("#searchDataList").css("display", "none");
//		}

		function goSearchKeyEnterEvent() {
			if(event.keyCode != 13) { return true; }
			goMemberSearch();
			return false;
		}

// 2013.11.11 kimhee sung old style
//		function goMemberSearch(){
//			var strChkVal = $("input:radio[id='searchField']:checked").val();
//			var strJsonParam = "menuType=member&mode=json&act=memberCrmSearch";
//			strJsonParam += "&searchField="+strChkVal+"&searchKey="+encodeURIComponent($("#searchKey").val());
//			$.ajax({
//				type:"POST",
//				url:"./index.php",
//				data :strJsonParam,
//				dataType:"json",
//				success:function(data){
//					if (data[0].CNT == 1)
//					{
//						location.href = "./?menuType=member&mode=popMemberCrmView&tab=memberModify&memberNo="+data[0].M_NO;
//					} else {
//						alert("a");
//						//$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popProdShare&prodCode='+no, closeImg: {width:23, height:23} });
//					}
//				}
//			});
//		}

	//-->
</script>
<style>
	#searchDataList {border:0px solid #dfdfdf;width:296px;height:0px;position:absolute;left:440px;top:29px;background:#fff;color:#000;overflow-y:scroll;}
	#searchDataList ul li {padding:5px 0 5px 15px;border-bottom:1px solid #dfdfdf;}
	#searchDataList .close {position:absolute;top:0px;right:0px;text-align:right;margin:6px 0 0 0}
	#searchDataList .close a {border:1px solid #afafaf;padding:5px;width:25px}
</style>
<form name="form" name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="memberNo" value="<?=$intM_NO?>">
<input type="hidden" name="page" value="<?=$intPage?>">
<input type="hidden" name="tab" value="<?=$_REQUEST['tab']?>">

	<div class="layerPopWrap">
		<div class="popTop" id="searchArea" style="position:relative">
			<h2><?=$LNG_TRANS_CHAR["MW00189"] //회원정보 관리(CRM)?></h2>
			<div class="memSearchWrap">
				<input type="radio" name="searchField" id="searchField" value="name"	<?=($strSearchField=="name")?"checked":"";?>/><?=$LNG_TRANS_CHAR["MW00002"] //성명?>
				<input type="radio" name="searchField" id="searchField" value="id"		<?=($strSearchField=="id")?"checked":"";?>/><?=$LNG_TRANS_CHAR["MW00095"] //아이디?>
				<input type="radio" name="searchField" id="searchField" value="hp"		<?=($strSearchField=="hp")?"checked":"";?>/><?=$LNG_TRANS_CHAR["OW00032"] //핸드폰?>
				<input type="radio" name="searchField" id="searchField" value="phone"	<?=($strSearchField=="phone")?"checked":"";?>/><?=$LNG_TRANS_CHAR["MW00010"] //연락처?>
				<input type="text" name="searchKey" id="searchKey" class="memSearch" value=""  onkeypress="if(!goSearchKeyEnterEvent())return false;"/>
				<a href="javascript:goMemberSearch();" class="btn_sml"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
			</div>
			<a href="javascript:self.close();"><img src="/shopAdmin/himg/common/btn_pop_close_white.png" class="closeBtn"/></a>
			<div class="clear"></div>
			<div id="searchDataList" style="display:none;z-index:9999">
				<ul></ul>
			</div>
		</div>
	</div>

	<div class="memberCrmPop">
		<table>
			<tr>
				<th class="leftCrmNavi" style="width:180px;height:765px;">
					<!-- start: 좌측메뉴 -->
						<?include "include/tab_memberInfo.inc.php";?>
					<!-- end: 좌측메뉴 -->
				</th>
				<td class="infoCrm" style="width:660px;">
					<!-- start: 정보영역 -->
					<div class="memSumInfo">
						<table>
							<tr>
								<td class="photo"><img src="<?=$strMemberSexImg?>"/></td>
								<td class="memInfoDetail">
									<ul>
										<li><span><?=$LNG_TRANS_CHAR["MW00002"] //성명?> </span> : <?=$strMemberName?><?=$strMemberId?> <strong><?=$memberGroupRow[G_NAME]?></strong></li>
										<?if(isset($memberRow['SH_COM_NAME'])){?>
											<li><span><?=$LNG_TRANS_CHAR["SW00080"] //입점사?> </span> : <?=$memberRow['SH_COM_NAME']?></strong></li>
										<?}?>
										<?if(isset($memberRow['SH_COM_NUM'])){?>
											<li><span><?=$LNG_TRANS_CHAR["SW00012"] //사업자번호?> </span> : <?=$memberRow['SH_COM_NUM']?></strong></li>
										<?}?>
										<li><span><?=$LNG_TRANS_CHAR["OW00032"] //핸드폰?></span> : <?=$memberRow[M_HP]?></li>
										<li><span><?=$LNG_TRANS_CHAR["MW00003"] //이메일?></span> : <?=$memberRow[M_MAIL]?></li>
										<li><span><?=$LNG_TRANS_CHAR["MW00190"] //회원가입일?></span> : <?=SUBSTR($memberRow[M_REG_DT],0,10)?> (<?=SUBSTR($memberRow[M_REG_DT],11)?>)</li>
										<li><span><?=$LNG_TRANS_CHAR["MW00191"] //최근접속일?></span> : <?if($memberRow[M_LOGIN_DT]){?><?=SUBSTR($memberRow[M_LOGIN_DT],0,10)?> (<?=SUBSTR($memberRow[M_LOGIN_DT],11)?>)<?}?></li>
									</ul>
								</td>
							</tr>
						</table>
					</div>
					<!-- end: 정보영역 -->
					<div>
						<?
                        include "include/{$_REQUEST['tab']}.inc.php";
						//echo $_REQUEST['tab'];
                        ?>
					</div>
				</td>
				<td class="qnaInfo" style="width:250px;">
				<!-- 상담관리 -->
				<?include "popMemberCrmView.memberReport.inc.php"?>
				<!-- 상담관리 -->
				</td>
			</tr>
		</table>
	</div>
</form>
	</body>
</html>