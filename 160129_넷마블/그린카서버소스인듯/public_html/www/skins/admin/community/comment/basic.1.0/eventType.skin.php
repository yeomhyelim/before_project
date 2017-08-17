<?
	## 설정
	$eventTypeList	= $_REQUEST['result']['CommentMgrEventType'];
?>

<script>
$(document).ready(function() {
	$("select[name=cm_event_type]").change(function(){
		var data				= new Array(5);
		data['cm_event_type']	= $(this).val();
		data['page']			= 1;
		goAddLocation(data);
	});
});
</script>

<?if(is_array($eventTypeList)):?>
<select name="cm_event_type">
	<?foreach($eventTypeList as $type => $val):?>
	<option value="<?=$type?>"<?if($_REQUEST['cm_event_type'] == $type){echo "selected";}?>>이벤트 <?=$type?></option>
	<?endforeach;?>
</select>
<?endif;?>