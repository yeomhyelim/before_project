<?
	## STEP 1.
	## 설정 파일 불러오기
	include_once "dataEdit_{$_REQUEST['num']}.inc.php";
	include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEdit/dataEdit_{$_REQUEST['num']}.inc.php";

	## STEP 3.
	## 설정 리스트 불러오기
	$dataEditSetInfoFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEditSet/dataEditSet_{$_REQUEST['num']}.config.info.php";
	include_once $dataEditSetInfoFile;

	## STEP 2.
	## 기존에 설정된 설정 정보 불러오기
	$fileName			= $dataEditSet[$_REQUEST['setNo']]['FILE'];
	if(!$fileName):		
		$fileName		= "dataEditSetConfig_{$_REQUEST['num']}.default.info.php";		/** default info **/
	endif;
	$dataEditSetFile	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEditSet/{$fileName}";
	include_once $dataEditSetFile;
?>

<?include "./include/header.inc.php"?>
<?include "script.inc.php"; ?>
	<div class="layerPopWrap">
		<div class="popTop">
			<h2>회원 스마트쿼리</h2>					
			<a href="javascript:self.close();"><img src="/shopAdmin/himg/common/btn_pop_close_white.png" class="closeBtn"/></a>
			<div class="clear"></div>
		</div>
	</div>

		

		<div style="padding:10px;">
			<form name="form" name="form" id="form">
			<input type="hidden" name="menuType" value="<?=$strMenuType?>">
			<input type="hidden" name="mode" value="<?=$strMode?>">
			<input type="hidden" name="act" value="">
			<input type="hidden" name="p_code" value="">
				<h3>항목</h3>
				<div class="titInfoTxt" style="padding-left:0;">
					<ul>
						<li>- 검색결과시 리스트되야 하는 항목을 선택하세요.</li>
						<li>- 꼭 필요한 경우가 아니라면 검색 속도를 위해서는 너무많은 항목검색은 피해주세요.</li>
					</ul>
				</div>
				<input type="text" name="de_select_name" id="de_select_name" style="width:500px" alt="컬럼명(한글)" value=""/> 
				<input type="text" name="de_select" id="de_select" style="width:500px" alt="컬럼명" value=""/> 
				<div class="queryList">
					<ul>
						<?foreach($select_column as $column):?>
						<li><input type="checkbox" name="selectColumn[]"  fildName="<?=$column['NAME']?>" id="select" value="<?=$column['COLUMN']?>"<?if(in_array($column['COLUMN'],$selectColumn)){echo " checked";}?>> <?=$column['NAME']?></li>
						<?endforeach;?>
						<?foreach($select_family_column as $column):?>
						<li><input type="checkbox" name="selectColumn[]"  fildName="<?=$column['NAME']?>" id="select_family" value="<?=$column['COLUMN']?>"<?if(in_array($column['COLUMN'],$selectColumn)){echo " checked";}?>> <?=$column['NAME']?></li>
						<?endforeach;?>
					</ul>
				</div>

				<h3 class="mt20">검색범위(단어)</h3>
				<input type="text" name="de_where_join"  id="de_where_join"  style="width:500px" alt="연결" script="<?=$de_where_join_defalut?>"/> 
				<input type="hidden" name="de_where" id="de_where" style="width:500px" alt="조건" script="<?=$de_where_defalut?>"/>
				<div class="queryCondition">
					<?$cnt = sizeof($whereWordColumn);?>
					<ul id="whereWordArea">
					<?for($i=0;$i<$cnt;$i++):?>					
						<li>
							<select name="whereWordLink[]" id="whereLink"<?if($i==0){ echo " disabled"; }?>>
								<option value="AND"<?if($whereWordLink[$i]=="AND"){echo " selected";}?>>(AND 방식으로 검색)</option>
								<option value="OR"<?if($whereWordLink[$i]=="OR"){echo " selected";}?>>(OR 방식으로 검색)</option>
							</select>
							<select name="whereWordColumn[]" id="whereColumn" onChange="goDataEditWhereColumnWordChangeEvent(this);">
								<option value="">항목</option>
								<?foreach($select_column as $column):?>
								<?if($column['WHERE_USE'] == "N") { continue; } ?>
								<option value="<?=$column['COLUMN']?>"<?if($whereWordColumn[$i]==$column['COLUMN']){echo " selected";}?> type="<?=$column['TYPE']?>" tag="<?=$column['TAG']?>"><?=$column['NAME']?></option>
								<?endforeach;?>
								<?foreach($select_family_column as $column):?>
								<option value="<?=$column['COLUMN']?>"<?if($whereWordColumn[$i]==$column['COLUMN']){echo " selected";}?> type="<?=$column['TYPE']?>" tag="<?=$column['TAG']?>"><?=$column['NAME']?></option>
								<?endforeach;?>
								<?foreach($where_order_column as $column):?>
								<option value="<?=$column['COLUMN']?>"<?if($whereWordColumn[$i]==$column['COLUMN']){echo " selected";}?> type="where_order_column" tag="<?=$column['TAG']?>"><?=$column['NAME']?></option>
								<?endforeach;?>
								<?foreach($where_order_buy_column as $column):?>
								<option value="<?=$column['COLUMN']?>"<?if($whereWordColumn[$i]==$column['COLUMN']){echo " selected";}?> type="where_order_buy_column" tag="<?=$column['TAG']?>"><?=$column['NAME']?></option>
								<?endforeach;?>
								<?foreach($where_prod_buy_column as $column):?>
								<option value="<?=$column['COLUMN']?>"<?if($whereWordColumn[$i]==$column['COLUMN']){echo " selected";}?> type="where_prod_buy_column" tag="<?=$column['TAG']?>"><?=$column['NAME']?></option>
								<?endforeach;?>
							</select>
							<input type="text" name="whereWordText[]" id="whereWord" value="<?=$whereWordText[$i]?>">
							<select id="orderStatus" style="display:none" onChange="goDataEditOrderStatusChangeEvent(this);">
								<option value="">:::선택:::</option>
								<?foreach($S_ARY_SETTLE_STATUS as $key => $val):?>
								<option value="<?=$key?>"><?=$val?></option>
								<?endforeach;?>
							</select>
							<select id="familyFeed" style="display:none" onChange="goDataEditFamilyFeedChangeEvent(this);">
								<option value="">:::선택:::</option>
								<option value="MOT">모유</option>
								<option value="MIL">분유</option>
								<option value="MIX">혼합</option>
								<option value="ETC">기타</option>
							</select>

							<select name="whereWordType[]" id="whereType" onChange="goDataEditWhereWordChangeEvent(this);">
								<option value="="<?if($whereWordType[$i]=="="){echo " selected";}?>>정확히 일치하는 단어/문장</option>
								<option value="<>"<?if($whereWordType[$i]=="<>"){echo " selected";}?>>제외하는 단어</option>
								<option value="like"<?if($whereWordType[$i]=="like"){echo " selected";}?>>반드시 포함하는 단어</option>
								<option value="is not null"<?if($whereWordType[$i]=="is not null"){echo " selected";}?>>IS NOT NULL</option>
							</select>
							<a class="btn_sml" href="javascript:goDataEditWhereWordAddEvent()"><strong>추가</strong></a>
							<a class="btn_sml" onClick="goDataEditWhereWordDeleteEvent(this)"><strong>삭제</strong></a>
						</li>
					<?endfor;?>
					</ul>
				</div>
				
				<h3 class="mt20">검색범위(날짜)</h3>
				<div class="queryCondition">
					<?$cnt = sizeof($whereDateColumn);?>
					<ul id="whereDateArea">
					<?for($i=0;$i<$cnt;$i++):?>
						<li>
							<select name="whereDateLink[]" id="whereLink"<?if($i==0){ echo " disabled"; }?>>
								<option value="AND"<?if($whereDateLink[$i]=="AND"){echo " selected";}?>>(AND 방식으로 검색)</option>
								<option value="OR"<?if($whereDateLink[$i]=="OR"){echo " selected";}?>>(OR 방식으로 검색)</option>
							</select>
							<select name="whereDateColumn[]" id="whereColumn">
								<option value="">항목</option>
								<?foreach($where_date_column as $column):?>
									<option value="<?=$column['COLUMN']?>"<?if($whereDateColumn[$i]==$column['COLUMN']){echo " selected";}?>><?=$column['NAME']?></option>
								<?endforeach;?>
								<?foreach($where_order_date_column as $column):?>
									<option value="<?=$column['COLUMN']?>"<?if($whereDateColumn[$i]==$column['COLUMN']){echo " selected";}?> type="where_order_date_column"><?=$column['NAME']?></option>
								<?endforeach;?>
							</select>
							<input type="text" name="whereDateStart[]" id="whereDateStart" value="<?=$whereDateStart[$i]?>" class="_w50"> - <input type="text" name="whereDateEnd[]" id="whereDateEnd" value="<?=$whereDateEnd[$i]?>" class="_w50">
							<select name="whereDateType[]" id="whereType" onChange="goDataEditWhereDateChangeEvent(this);">
								<option value="between"<?if($whereDateType[$i]=="between"){echo " selected";}?>>입력된 날짜에 포함하여 검색</option>
								<option value="start"<?if($whereDateType[$i]=="start"){echo " selected";}?>>입력된 날짜로부터 현재 까지 검색</option>
								<option value="end"<?if($whereDateType[$i]=="end"){echo " selected";}?>>입력된 날짜까지 검색</option>
							</select>
							<a class="btn_sml" href="javascript:goDataEditWhereDateAddEvent()"><strong>추가</strong></a>
							<a class="btn_sml" onClick="goDataEditWhereDateDeleteEvent(this)"><strong>삭제</strong></a>
						</li>
					<?endfor;?>
					</ul>
				</div>

				<h3 class="mt20">검색정렬</h3>
				<input type="hidden" name="de_order" id="de_order" style="width:500px" alt="정렬" value="" script=""/> 
				<div class="queryCondition">
					<?$cnt = sizeof($orderColumn);?>
					<ul id="orderArea">
					<?for($i=0;$i<$cnt;$i++):?>
						<li>
							<select name="orderColumn[]" id="orderColumn">
								<option value="">항목</option>
								<?foreach($select_column as $column):?>
								<option value="<?=$column['COLUMN']?>"<?if($orderColumn[$i]==$column['COLUMN']){echo " selected";}?>><?=$column['NAME']?></option>
								<?endforeach;?>
							</select>
							<select name="orderType[]" id="orderType" onChange="goDataEditWhereDateChangeEvent(this);">
								<option value="ASC"<?if($whereWordType[$i]=="ASC"){echo " selected";}?>>오름차순 정렬</option>
								<option value="DESC"<?if($whereWordType[$i]=="DESC"){echo " selected";}?>>내림차순 정렬</option>
							</select>
							<a class="btn_sml" href="javascript:goDataEditOrderAddEvent()"><strong>추가</strong></a>
							<a class="btn_sml" onClick="goDataEditOrderDeleteEvent(this)"><strong>삭제</strong></a>
						</li>
					<?endfor;?>
					</ul>
				</div>

				<div class="btnCenter" id="btnArea">
					<a href="javascript:goDataEditSearchActEvent()" class="btn_Big_Blue" style="width:70%;"><strong>스마트쿼리 실행하기</strong></a>
				</div>

				<!-- 설정저장 -->
				<h3 class="mt50">설정저장</h3>
				<div class="searchSaveWrap">
					<input type="hidden" name="num" alt="번호" value="<?=$_REQUEST['num']?>"/> 
					<input type="text" name="saveName" alt="옵션저장이름" value="" class="nbox _w200"/> 
					<a href="javascript:goDataEditWriteActEvent()" class="btn_sml"><strong>저장</strong></a>
					<select name="setNo" onChange="goDataEditSetChangeEvent(this)" style="display:none">
						<option value="">설정 불러오기</option>
						<?foreach($dataEditSet as $key => $data):?>
						<option value="<?=$key?>"<?if($_REQUEST['setNo']=="{$key}"){echo " selected";}?>><?=$data['NAME']?></option>
						<?endforeach;?>
					</select>
					<?if($_REQUEST['setNo']):?>
					<a href="javascript:goDataEditModifyActEvent()" class="btn_sml"><strong>설정수정</strong></a>
					<a href="javascript:goDataEditDeleteActEvent()" class="btn_sml"><strong>설정삭제</strong></a>
					<?endif;?>
				</div>
			</form>
			</div>
		</div>
	</body>
</html>