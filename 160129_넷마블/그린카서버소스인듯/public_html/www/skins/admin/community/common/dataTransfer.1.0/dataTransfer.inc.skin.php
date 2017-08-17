<?
	## 설정

?>
	<select name="b_code_transfer" id="menu_auth_e2" style="display:none">
		<option value="">게시판 리스트</option>
		<?foreach($BOARD_LIST as $code => $data):?>
		<option value="<?=$code?>"><?=$data['b_name']?></option>
		<?endforeach;?>
	</select>
	<a class="btn_big" href="javascript:goDataTransferActEvent();" id="menu_auth_e2" style="display:none"><strong>복사</strong></a>