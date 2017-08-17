<?php if($aryScriptData):?>
<script>
	var objScriptData = <?php echo json_encode($aryScriptData);?>;
</script>
<?php endif;?>
 <?if($aryScriptEx):
  $aryScriptEx = array_unique($aryScriptEx);
  foreach($aryScriptEx as $key => $data):?>
	<script language="javascript" type="text/javascript" src="<?=$data?>"></script>
<?endforeach;
 endif;?>