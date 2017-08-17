<?
	## 모듈 설정
	require_once MALL_HOME . "/module2/BoardInfoMgr.module.php";
	$boardInfoMgr			= new BoardInfoMgrModule($db);

	## 기본 설정
	$strBCode				= $_GET['b_code'];
	$strMode				= $_GET['mode'];

	## 추가옵션 리스트
	$param								= "";
	$param['BA_B_CODE']					= $strBCode;
	$param['BA_MODE']					= $strMode;
	$boardInfoMgrArray					= $boardInfoMgr->getBoardInfoMgrSelectEx("OP_ARYTOTAL", $param);

	## 추가옵션 리스트를 배열로
	$aryInfo							= "";
	if($boardInfoMgrArray):
		foreach($boardInfoMgrArray as $key => $data):
			$baKey						= $data['BA_KEY'];
			$baVal						= $data['BA_VAL'];
			$aryInfo[$baKey]			= $baVal;
		endforeach;
	endif;

	## 추가필드 사용 유무 설정
	$biUserfileUse			= $aryInfo['BI_USERFIELD_USE'];
	if(!$biUserfileUse) { $biUserfileUse = "N"; }

?>
<div class="tableForm">
	<h3>커뮤니티 추가필드 옵션</h3>
	<table>
		<tr>
			<th>추가필드 사용 유무</th>
			<td>
				<input type="radio" name="bi_userfield_use" value="Y"<?if($biUserfileUse=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="bi_userfield_use" value="N"<?if($biUserfileUse=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
	</table>
	<br>
</div>


<div class="tableList">
	<table>
		<tr>
			<th style="width:50px"><input type="checkbox"></th>
			<th style="width:100px">이름</th>
			<th>필드이름</th>
			<th style="width:100px">정렬</th>
			<th style="width:100px">설명</th>
			<th style="width:150px">설정</th>
		</tr>
		<?foreach($G_USERFIELD_INFO as $key => $data):

			## 기본 설정
			$comment				= $data['comment'];
			$columnName				= $data['columnName'];
			$columnType				= $data['columnType'];
			$columnSize				= $data['columnSize'];
			$kindList				= explode(";", $data['kindList']);
			$columnNameLower		= strtolower($columnName);
			$fieldName				= $aryInfo["BI_{$columnName}_NAME"];
			$fieldKind				= $aryInfo["BI_{$columnName}_KIND"];
			$fieldData				= $aryInfo["BI_{$columnName}_KIND_DATA"];
			$fieldDefault			= $aryInfo["BI_{$columnName}_KIND_DEFAULT"];
			$onlyAdmin				= $aryInfo["BI_{$columnName}_ONLYADMIN"];
			$essential				= $aryInfo["BI_{$columnName}_ESSENTIAL"];
			$columnNameData			= $aryInfo["BI_{$columnName}_NAME"];

			## 필드 종류 사용유무 설정
			$phoneShow				= false;
			$zipShow				= false;
			$textShow				= false;
			$selectShow				= false;
			if(in_array("phone", $kindList))	{ $phoneShow	= true; }
			if(in_array("zip", $kindList))		{ $zipShow		= true; }
			if(in_array("text", $kindList))		{ $textShow		= true; }
			if(in_array("select", $kindList))	{ $selectShow	= true; }

			## 필드 데이터 사용유무 설정
			$kindDataShow						= false;
			if($selectShow) { $kindDataShow		= true; }

			## columnInfo 설정
			$columnInfo				= $columnType;
			if($columnSize)			{ $columnInfo		= "{$columnInfo}({$columnSize})";	}
			
			## 정렬 데이터 설정
			$columnSortData			= $aryInfo["BI_{$columnName}_SORT"];
			if(!$columnSortData)	{ $columnSortData	= "100000"; }

			## 사용유무 데이터 설정
			$columnUseData			= $aryInfo["BI_{$columnName}_USE"];
			if(!$columnUseData)		{ $columnUseData	= "N"; }							?>
		<tr id="fieldOption_<?=$key?>">
			<td><input type="checkbox"></td>
			<td><?=$comment?></td>
			<td style="text-align:left">
				<ul>
					<li id="fieldKind">
						<div class="left" style=width:100px;">필드 종류</div>
						<div  class="left"> : 
							<select name="bi_<?=$columnNameLower?>_kind" id="fieldKindSelect" onchange="goUserfieldKindChangeEvent('<?=$key?>')">
									<?if($phoneShow):?>
									<option value="phone"<?if($fieldKind=="phone"){echo " selected";}?>>연락처</option>
									<?endif;?>
									<?if($zipShow):?>
									<option value="zip"<?if($fieldKind=="zip"){echo " selected";}?>>우편번호</option>
									<?endif;?>
									<?if($textShow):?>
									<option value="text"<?if($fieldKind=="text"){echo " selected";}?>>입력박스</option>
									<?endif;?>
									<?if($selectShow):?>
									<option value="select"<?if($fieldKind=="select"){echo " selected";}?>>선택박스</option>
									<?endif;?>
								</select>
						</div>
						<div class="clr"></div>
					</li>
					<li id="fieldOnlyadmin">
						<div class="left" style=width:100px;">관리자 옵션</div>
						<div  class="left"> : 
							<input type="checkbox" name="bi_<?=$columnNameLower?>_onlyadmin" value="Y"<?if($onlyAdmin=="Y"){echo " checked";}?>> 관리자 전용
						</div>
						<div class="clr"></div>
					</li>
					<li id="fieldEssential">
						<div class="left" style=width:100px;">필수 옵션</div>
						<div  class="left"> : 
							<input type="checkbox" name="bi_<?=$columnNameLower?>_essential" value="Y"<?if($essential=="Y"){echo " checked";}?>> 필수 입력 받음
						</div>
						<div class="clr"></div>
					</li>
					<li id="fieldName">
						<div class="left" style=width:100px;">필드명</div>
						<div  class="left"> : 
							<input type="text" name="bi_<?=$columnNameLower?>_name" style="width:100px;" value="<?=$fieldName?>">
						</div>
						<div class="clr"></div>
					</li>
					<?if($kindDataShow):?>
					<li id="fieldKindData" style="<?if($fieldKind!="select"){echo "display:none;";}?>">
						<div class="left" style=width:100px;">필드 데이터</div>
						<div  class="left"> : 
							<input type="text" name="bi_<?=$columnNameLower?>_kind_data" style="width:400px" value="<?=$fieldData?>">
						</div>
						<div class="clr"></div>
					</li>
					<li id="fieldKindDefault" style="<?if($fieldKind!="select"){echo "display:none;";}?>">
						<div class="left" style=width:100px;">필드 디폴트</div>
						<div  class="left"> : 
							<input type="text" name="bi_<?=$columnNameLower?>_kind_default" style="width:400px" value="<?=$fieldDefault?>">
						</div>
						<div class="clr"></div>
					</li>
					<?endif;?>
				</ul>
			</td>
			<td><input type="text" name="bi_<?=$columnNameLower?>_sort" value="<?=$columnSortData?>" style="width:50px"></td>
			<td><?=$columnInfo?></td>
			<td><input type="radio" name="bi_<?=$columnNameLower?>_use" value="Y"<?if($columnUseData=="Y"){echo "checked";}?>> 사용
				<input type="radio" name="bi_<?=$columnNameLower?>_use" value="N"<?if($columnUseData=="N"){echo "checked";}?>> 사용안함
			</td>
		</tr>
		<?endforeach;?>
	</table>
</div>