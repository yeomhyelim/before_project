<?
	require_once MALL_CONF_LIB."OrderHandAddrAdmMgr.php";

	$orderHandAddrMgr = new OrderHandAddrAdmMgr();

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];
	$strNum			= $_POST["num"]				? $_POST["num"]				: $_REQUEST["num"];

	/* 검색부분 */
	$orderHandAddrMgr->setSearchField($strSearchField);
	$orderHandAddrMgr->setSearchKey($strSearchKey);
	/* 검색부분 */

	/* 데이터 리스트 */
	$intTotal								= $orderHandAddrMgr->getOrderHandAddrList( $db, "OP_COUNT" );						// 데이터 전체 개수 

	$intPageLine							= 5;																				// 리스트 개수 
	$intPage								= ( $intPage )				? $intPage		: 1;
	$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
	$orderHandAddrMgr->setLimitFirst( $intFirst );
	$orderHandAddrMgr->setPageLine( $intPageLine );
	

	$orderHandAddrResult			= $orderHandAddrMgr->getOrderHandAddrList( $db );	

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
	var G_PHP_SELF		= "<?=$PHP_SELF?>";

	$(document).ready(function(){

	});

	/* 이벤트 등록 */
	function goSearch() {	goMove("popAddressList");	}	// 검색

	function goClose() {
		parent.goClose();
	}

	function goZip(zip1,zip2,addr1,addr2) {
		parent.popZipCodeCallBack('<?=$strNum?>',zip1,zip2,addr1,addr2);
		goClose();
	}

	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get", G_PHP_SELF);
	}
//-->
</script>

		<div class="layerPopWrap">
			<div class="popTop">
				<h2>상품리스트 디자인</h2>			
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clr"></div>
			</div>

			<!-- 검색 영역 -->
			<div class="searchTableWrap">
				<div class="searchFormWrap" style="border:0px solid">
				<form name="form" id="form">
					<input type="hidden" name="menuType" value="<?=$strMenuType?>">
					<input type="hidden" name="mode" value="<?=$strMode?>">
					<input type="hidden" name="act" value="<?=$strMode?>">
					<input type="hidden" name="jsonMode" value="">
					<center>
						<select name="searchField" id="searchField">
							<option value="N" <?=($strSearchField=="N")?"selected":"";?>>이름</option>
							<option value="E" <?=($strSearchField=="E")?"selected":"";?>>이메일</option>
							<option value="P" <?=($strSearchField=="P")?"selected":"";?>>연락처</option>
						</select>
						<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> style="width:200px"/>
						<a class="btn_blue_sml" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"]?></strong></a>
					</center>
				</form>
				</div>
			</div><br>
			<!-- 검색 영역 -->

			<div class="tableList">
				<table style="border-left:1px solid #D2D0D0">
					<colgroup>
						<col width=40/>
						<col width=70/>
						<col width=70/>
						<col />
					</colgroup>
					<tr>
						<th>번호</th>
						<th>그룹</th>
						<th>성명</th>
						<th>주소</th>
					</tr>
					<?	if ($intTotal == 0):?>
					<tr>
					<td colspan="11"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
					</tr>
					<?	else:
							while($row = mysql_fetch_array($orderHandAddrResult)):	
							if(!$row['AG_NAME']) { $row['AG_NAME']= "-"; }	
							$aryZip = explode("-", $row['HA_ZIP']);			?>
					<tr>
						<td><?=$intTotal--?></td>
						<td><?=$row['AG_NAME']?></td>
						<td><?=$row['HA_NAME']?></td>
						<td style="text-align:left;padding-left:10px;">
							<a href="javascript:goZip('<?=$aryZip[0]?>','<?=$aryZip[1]?>','<?=$row['HA_ADDR1']?>','<?=$row['HA_ADDR2']?>')">
							우편번호 : <?=$row['HA_ZIP']?><br>
							주소 : <?=$row['HA_ADDR1']?> <?=$row['HA_ADDR2']?></a>
	<!--					이메일 : <?=$row['HA_EMAIL']?><br>
							연락처 : <?=$row['HA_PHONE1']?><br>
							휴대폰 : <?=$row['HA_PHONE2']?><br>
							메모 : <?=$row['HA_MEMO']?>		-->
						</td>
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