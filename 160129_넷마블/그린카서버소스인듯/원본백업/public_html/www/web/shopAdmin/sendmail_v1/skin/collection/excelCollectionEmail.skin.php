<?
	## 모듈 설정
	$objEmailCollection		= new EmailCollectionModule($db);

	## 그룹 리스트
	$param							= "";
	$intTotal						= $objEmailCollection->getEmailCollectionSelectEx("OP_COUNT", $param);				// 데이터 전체 개수 
	$objEmailCollectionResult		= $objEmailCollection->getEmailCollectionSelectEx("OP_LIST", $param);
?>
	<table border="1">
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

