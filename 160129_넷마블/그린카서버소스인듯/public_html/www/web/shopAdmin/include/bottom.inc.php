<div id="footerArea">
	Copyright (c)  2012.  All rights reserved.
</div>
<?php if($aryScriptData):?>
<script>
	var objScriptData = <?php echo json_encode($aryScriptData);?>;
</script>
<?php endif;?>
<?if($aryScriptEx):
  foreach($aryScriptEx as $key => $data):?>
	<script language="javascript" type="text/javascript" src="<?=$data?>"></script>
<?endforeach;
  endif;?>