<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";

	$memberMgr = new MemberMgr();

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];
	$strNum			= $_POST["num"]				? $_POST["num"]				: $_REQUEST["num"];


	/* 데이터 리스트 */
	$intTotal								= $memberMgr->getMemberTotal( $db );						// 데이터 전체 개수 

	$intPageLine							= 5;														// 리스트 개수 
	$intPage								= ( $intPage )				? $intPage		: 1;
	$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
	$memberMgr->setLimitFirst( $intFirst );
	$memberMgr->setPageLine( $intPageLine );
	

	$memberListResult				= $memberMgr->getMemberList( $db );	

	$intPageBlock					= 10;																// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );					// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );
	/* 데이터 리스트 */


	$linkPage  = "?menuType=$strMenuType&mode=$strMode";
	$linkPage .= "&page=";
?>

<? include "./include/header.inc.php"?>

<script type="text/javascript">
<!--
	$(document).ready(function(){

	});

	/* 이벤트 등록 */


	function goClose() {
		parent.goClose();
	}

	function goMember(memberNo) {
		parent.popMemberListCallBack(memberNo);
		goClose();
	}

//-->
</script>

		<div class="layerPopWrap">
			<div class="popTop">
				<h2>회원 검색</h2>			
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clr"></div>
			</div>

			<div class="tableList">
				<table style="border-left:1px solid #D2D0D0">
					<colgroup>
						<col width=40/>
						<col width=70/>
						<col width=70/>
						<col />
						<col width=100/>
					</colgroup>
					<tr>
						<th>번호</th>
						<th>아이디</th>
						<th>이름</th>
						<th>주소</th>
						<th>연락처</th>
					</tr>
					<?	if ($intTotal == 0):?>
					<tr>
					<td colspan="11"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
					</tr>
					<?	else:
							while($row = mysql_fetch_array($memberListResult)):	?>
					<tr>
						<td><?=$intTotal--?></td>
						<td><?=$row['M_ID']?></td>
						<td>
							<a href="javascript:goMember('<?=$row['M_NO']?>')">
								<?=$row['M_F_NAME']?> <?=$row['M_L_NAME']?>
							</a>
						</td>
						<td>(<?=$row['M_ZIP']?>) <?=$row['M_ADDR']?> <?=$row['M_ADDR2']?></td>
						<td><?=$row['M_MAIL']?><br><?=$row['M_PHONE']?><br><?=$row['M_HP']?></td>
					</tr>
					<?		endwhile;
						endif;
					?>

				</table>
			</div>

			<!-- Pagenate object --> 
			<div class="paginate">  
				<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
			</div>  
		</div>
	</body>
</html>