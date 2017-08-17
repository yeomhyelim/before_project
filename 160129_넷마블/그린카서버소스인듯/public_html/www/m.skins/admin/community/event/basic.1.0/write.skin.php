	<table>
		<tr>
			<th>기간</th>
			<td>
				<input type="text" name="ub_event_s_dt" id="ub_event_s_dt" style="width:100px;" value="2012-12-10"> 부터
				<input type="text" name="ub_event_e_dt" id="ub_event_e_dt" style="width:100px;" value="2013-05-02"> 까지
			</td>
		</tr>
		<tr>
			<th>작성자</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:10%;" id="ub_name" name="ub_name" alt="작성자" check="Y" value="<?=$S_SITE_ENG_NM?>" maxlength="10"/>
			</td>
		</tr>
		<tr>
			<th>제목</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:100%;" id="ub_title" name="ub_title" alt="제목" check="Y"/>
			</td>
		</tr>
		<tr>
			<th>간략설명</th>
			<td>
				<textarea style="width:100%;height:50px" id="ub_explain" name="ub_explain" ></textarea>
			</td>
		</tr>
		<tr>
			<th>내용</th>
			<td>
				
				<textarea style="width:100%;height:300px" id="ub_text" name="ub_text" title="<?=$_REQUEST['BOARD_INFO']['bi_datawrite_form']?>" alt="내용" check="Y"></textarea>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_attachedfile_use']):?>
		<tr>
			<th>첨부파일</th>
			<td>
				<a class="btn_sml" href="javascript:goAttachedfileOpen();" id="menu_auth_w" style=""><strong>파일선택</strong></a>
				<div id="fileList">
				</div>
				<textarea id="fileList_form" style="display:none" alt="파일폼">
					<li id="" style="float:left;display: inline-block;">
						<img src="" style="width:50px;height:50px;"/>
						<input type="hidden" name="fl_temp_file[]" id="fl_temp_file" value=""/>
						<input type="hidden" name="fl_temp_key[]"  id="fl_temp_key"  value=""/>
						<a href="">[X]</a>
					</li>
				</textarea>
			</td>
		</tr>
		<?endif;?>
	</table>