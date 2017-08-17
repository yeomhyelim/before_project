		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="N"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
				<option value="C"><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
				<option value="M"><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
				<option value="O"><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
				<option value="D"><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
			</select>
			<input type="text" id="searchKey" name="searchKey" <?=$nBox?>/>
			<a class="btn_blue_big" href="javascript:goSearch('prodViewList');"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchFormWrap -->
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00027"] //카테고리선택?></th>
				<td>
					<select id="searchCateHCode1" name="searchCateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode2" name="searchCateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode3" name="searchCateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode4" name="searchCateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
				<td>
					<input type="checkbox" id="searchWebViewY" name="searchWebViewY" value="Y"><?=$LNG_TRANS_CHAR["PW00011"] //보임?>
					<input type="checkbox" id="searchWebViewN" name="searchWebViewN" value="N"><?=$LNG_TRANS_CHAR["PW00012"] //안보임?>
				</td>
			</tr>
		</table>
