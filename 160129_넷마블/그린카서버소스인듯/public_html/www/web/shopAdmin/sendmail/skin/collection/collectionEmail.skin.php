<?
	## 모듈 설정
	$objEmailCollection		= new EmailCollectionModule($db);

	## 그룹 리스트
	$param							= "";
	$intTotal						= $objEmailCollection->getEmailCollectionSelectEx("OP_COUNT", $param);				// 데이터 전체 개수 
	$intPageLine					= 10;																				// 리스트 개수 
	$intPage						= ( $intPage )				? $intPage		: 1;
	$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$param['LIMIT']					= "{$intFirst},{$intPageLine}";
	$objEmailCollectionResult		= $objEmailCollection->getEmailCollectionSelectEx("OP_LIST", $param);

	$intPageBlock					= 10;																		// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );
?>
<div id="contentArea">
<div class="contentTop">
	<h2>메일구독 리스트</h2>
	<div class="clr"></div>
</div>

<div class="button">
	<a class="btn_blue_big" href="javascript:goCollectionEmailExcelDowndownActEvent()" id="menu_auth_m" style="display:none"><strong>엑셀 다운로드</strong></a>
</div>

<br>

<div class="tableList">
	<table>
		<colgroup>
			<col width=40/>
			<col width=200/>
			<col width=200/>
		</colgroup>
		<tr>
			<th>번호</th>
			<th>메일주소</th>
			<th>작성일</th>
		</tr>
<?		while($row = mysql_fetch_array($objEmailCollectionResult)):
			$strEmail		= $row['EC_EMAIL'];
			$strRegDate		= $row['EC_REG_DT'];	?>
		<tr>
			<td><?=$intListNum--?></td>
			<td><?=$strEmail?></td>
			<td><?=$strRegDate?></td>
		</tr>
		<?endwhile;?>
	</table>
</div>

<div class="paginate mt20">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

