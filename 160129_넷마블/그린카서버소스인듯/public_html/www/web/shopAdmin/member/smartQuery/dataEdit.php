<?
	## 설정
	$de_select = explode(",", $_POST['de_select']);
	foreach($de_select as $key => $column):
		$column				= explode(".",$column);
		$de_select[$key]	= trim($column[1]);
	endforeach;
	$de_select_name = explode(",", $_POST['de_select_name']);
	foreach($de_select_name as $key => $column):
		$de_select_name[$key]	= trim($column);
	endforeach;
	
	## STEP 3.
	## 설정 리스트 불러오기
	$dataEditSetInfoFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEditSet/dataEditSet_{$strNum}.config.info.php";
	include_once $dataEditSetInfoFile;

	## 총개수
	$totalMsg = "";
	if($intTotal) { $totalMsg = "검색결과: {$intTotal}개의 데이터가 검색되었습니다."; }

	## 상품명
	$prodNameMsg = "";
	if($prodRow['P_NAME']) { $prodNameMsg = "상품명: {$prodRow['P_NAME']}"; }

	## 모유 형태
	$feedType['MOT'] = "모유";
	$feedType['MIL'] = "분유";
	$feedType['MIX'] = "혼합";
	$feedType['ETC'] = "기타";
?>

	<div class="contentTop">
		<h2>회원 스마트쿼리</h2>
	</div>
	
	<div class="userDefineBtn">
		<?foreach($dataEditSet as $key => $data):?>
		<?if($data['NAME']=="") { continue; }?>
			<a href="javascript:goDataEditSearchMoveEvent('<?=$key?>')" class="btn_big"><span><?=$data['NAME']?></span></a>
		<?endforeach;?>
		<a class="btn_blue_big" href="javascript:goDataEditSearchMoveEvent('')"><strong class="icoSearch">검색설정</strong></a>
		<div class="helpTxt">
			<ul>
				<li>- <strong>검색설정</strong> 버튼을 클릭하여 원하는 데이터의 조건을 만들어 주세요.</li>
				<li>- 검색설정 결과는 자주쓰는 버튼을 등록 가능합니다. 등록된 버튼을 클릭하여 추가조건을 대입하여 검새하세요. </li>
				<li>- 검색된 결과를 원하는 형태로 사용하실 수 있습니다.</li>
				<li>- 엑셀 다운로드, SMS로 전송, Email로 전송등 검색 결과 데이터를 활용하세요.</li>
			</ul>
		</div>
	</div>
	
	<a class="btn_big" href="javascript:goDataEditExcelMoveEvent()"><strong class="icoExcel">검색결과엑셀 저장</strong></a>
	<a class="btn_big" href="javascript:goDataEditSmsMoveEvent()"><strong class="icoSms">검색결과SMS 발송하기</strong></a>
	<a class="btn_big" href="javascript:goDataEditEmailMoveEvent()"><strong class="icoEmail">검색결과 이메일 발송하기</strong></a>


	<div class="tableList">
		<?=$prodNameMsg?><br>
		<?=$totalMsg?>
		<!-- 로딩폼 -->
		<div id="loadingForm" alt="로딩폼" style="display:none">
			<img src='/shopAdmin/himg/common/loader_bar_type.gif'/>
		</div>
		<!-- 로딩폼 -->
		<table id="dataEditList">
			<?if(mysql_error()):?>
				<tr>
					<th></th>
				</tr>
				<tr>
					<td>문법 오류...</td>
				</tr>
			<?else:?>
			<tr>
				<?if(is_array($de_select_name)):?>
					<th>번호</th>
				<?foreach($de_select_name as $column):?>
					<th><?=$column?></th>
				<?endforeach;?>
				<?else:?>
					<th>컬럼명</th>
					<th>컬럼명</th>
					<th>컬럼명</th>
					<th>컬럼명</th>
				<?endif;?>
			</tr>
			<?while($row = mysql_fetch_array($result)):	?>
				<tr><?if(is_array($de_select)):?>
					<td><?=$intListNum--?></td>
						<?foreach($de_select as $column):?>
							<?if($column == "O_STATUS"):?>
								<td><?=$S_ARY_SETTLE_STATUS[$row[$column]]?></td>
							<?elseif($column == "O_SETTLE"):?>
								<td><?=$S_ARY_SETTLE_TYPE[$row[$column]]?></td>
							<?elseif(in_array($column , array("MF_FEED_1", "MF_FEED_2", "MF_FEED_3"))):?>
								<td><?=$feedType[$row[$column]]?></td>
							<?else:?>
								<td><?=$row[$column]?></td>
							<?endif;?>
						<?endforeach;?>
					<?else:?>
						<td>데이타</td>
						<td>데이타</td>
						<td>데이타</td>
						<td>데이타</td>
					<?endif;?>
				</tr>
			<?endwhile;?>
			<?endif;?>
		</table>
	</div>
	<!-- Pagenate object --> 
	<div class="paginate">  
		<?=drawPagingEx($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object -->


<input type="hidden" name="de_select" alt="컬럼명" value="<?=$_POST['de_select']?>"/> 
<input type="hidden" name="de_select_name" alt="컬럼명(한글)" value="<?=$_POST['de_select_name']?>"/> 
<input type="hidden" name="de_where" alt="조건" value="<?=$_POST['de_where']?>"/> 
<input type="hidden" name="de_order" alt="정렬" value="<?=$_POST['de_order']?>"/> 
<input type="hidden" name="de_where_join" alt="연결" value="<?=$_POST['de_where_join']?>"/> 
<input type="hidden" name="num" alt="번호" value="<?=$strNum?>"/> 
<input type="hidden" name="page" alt="페이지번호" value="<?=$_POST['page']?>"/> 
<input type="hidden" name="p_code" alt="상품코드" value=""/> 
<input type="hidden" name="setNo" alt="설정저장번호" value=""/>
<input type="hidden" name="total" alt="검색결과 리스트 수" value="<?=$intTotal?>"/>
