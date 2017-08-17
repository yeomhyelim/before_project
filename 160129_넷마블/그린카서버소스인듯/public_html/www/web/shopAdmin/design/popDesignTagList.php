<script type="text/javascript">

	function getCopyData( tag )
	{
		window.clipboardData.setData( "Text", tag );
		alert("클립보드에 복사되었습니다.");
	}

</script>

<?
	$designConfigFile		= sprintf( "%swww/config/design_conf.php", $S_DOCUMENT_ROOT );
		
	if ( !file_exists($designConfigFile)  ) :
		// 설정 파일이 없음.
		return;
	endif;
	
	$aryFile 				= file ( $designConfigFile );
	
	echo "<table><tr><td>태그 이름</td><td>클립보드에 복사</td></tr>";
	foreach( $aryFile as $data ) :
		if ( !preg_match_all ( "/{{__.*?__}}/", $data, $out, PREG_PATTERN_ORDER ) ) :
			continue;
		endif;
		$tagName = "";
		foreach ( $out 		as $out_1 ) :
		foreach ( $out_1 	as $out_2 ) :
				$tagName	 .= $out_2;
		endforeach;
		endforeach;
		
?>
	
	<tr>
		<td><?= $tagName ?></td>
		<td><a href="javascript:getCopyData('<?= $tagName ?>')">복사</a></td>
	</tr>	
	
<?
	endforeach;
	echo "</table>";
?>