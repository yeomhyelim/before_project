	<table>
		<? if($dataView->field['list_total'] <= 0) : ?>
		<tr>
			<td>등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($dataListResult)) :
			   $lock = $dataView->getLockCheck($row);
		?>
		<tr>
			<th><img src="/images/test_img/news0.jpg"/></th>
			<td>
				<strong class="listTitle"><?=stripslashes($row['UB_TITLE'])?></strong>
				산양분유 전문기업 아이배냇㈜(대표이사:전석락)이 지난 22일 진행한 기부이벤트를 성황리에 종료했다고 26일 전했다. 이번 이벤트는 아이배냇 홈페이지에서 ‘행복 나눔 N마크’ 로고 이미지 및 모토를 완성한 100인의...
				<a href="#" class="linkBtn"><img src="/images/content/btn_news_more.gif"/></a>
			</td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>


