<?
	## 설정
	$lng = strtolower($strStLng);
?>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 스크립트 옵션</h3>
	<table>
		<tr>
			<th>스크립트</th>
			<td>
				<textarea name="bi_datascript_data" id="bi_datascript_data" style="width:100%;height:500px" title="<?// higheditor_full ?>"><?include "{$_REQUEST['S_DOCUMENT_ROOT']}{$_REQUEST['S_SHOP_HOME']}/layout/html/community/{$lng}/board.{$_REQUEST['b_code']}.script.tag.php"?></textarea>				
			</td>
		</tr>
	</table>
</div>
<!-- ******** 컨텐츠 ********* -->