<?
	## STEP 1.
	## 파라미터 설정
	$strNum				= $_POST["num"]		? $_POST["num"]		: $_REQUEST["num"];

	## STEP 1.
	## 설정 파일 불러오기
	include_once "dataEdit_column_{$strNum}.inc.php";
	include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEdit/dataEdit_column_{$strNum}.inc.php";

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
		<input type="hidden" name="menuType"  value="<?=$strMenuType?>">
		<input type="hidden" name="mode"      value="<?=$strMode?>">
		<input type="hidden" name="act"       value="">
		<input type="hidden" name="p_code"    value="">
		<input type="text"	 name="num"		  value="<?=$strNum?>">
		<input type="text"   name="de_select_name" id="de_select_name" style="width:100%" alt="컬럼명(한글)" value=""/> <br>
		<input type="text"   name="de_select"      id="de_select"      style="width:100%" alt="컬럼명"       value=""/> <br>
		<input type="text"   name="de_where"       id="de_where"       style="width:100%" alt="조건"		 value="" script="<?=$de_where_defalut?>"/>
		<input type="text"   name="de_where_join"  id="de_where_join"  style="width:100%" alt="연결"		 value="" script="<?=$de_where_join_defalut?>"/> <br>
		<input type="text"   name="de_order"       id="de_order"       style="width:100%" alt="정렬"         value="" script=""/> 

		<h3>항목</h3>
		<div class="titInfoTxt" style="padding-left:0;">
			<ul>
				<li>- 검색결과시 리스트되야 하는 항목을 선택하세요.</li>
				<li>- 꼭 필요한 경우가 아니라면 검색 속도를 위해서는 너무많은 항목검색은 피해주세요.</li>
			</ul>
		</div>

		<div class="queryList">
			<ul>
				<?foreach($select_column as $column):?>
				<li><input type="checkbox" id="select" cname="<?=$column['NAME']?>" value="<?=$column['COLUMN']?>" checked/> <?=$column['NAME']?></li>
				<?endforeach;?>
			</ul>
		</div>

		<h3 class="mt20">검색범위</h3>
		<div class="queryCondition">
			<ul id="whereWordArea">
				<li>
					<select id="whereLink"<?if($i==0){ echo " disabled"; }?>>
						<option value="AND" <?if($whereWordLink[$i]=="AND"){echo " selected";}?>>(AND 방식으로 검색)</option>
						<option value="OR"  <?if($whereWordLink[$i]=="OR" ){echo " selected";}?>>(OR 방식으로 검색)</option>
					</select>
					<select id="whereColumn" onChange="goDataEditWhereColumnWordChangeEvent(this);">
						<option value="">항목</option>
						<?foreach($where_column as $column):?>
						<?if($column['PARTITION'] != "word") { continue; }?>
						<option value="<?=$column['COLUMN']?>" whereWordUser="<?=$column['STYLE']?>" whereTypeMode="<?=$column['MODE']?>"><?=$column['NAME']?></option>
						<?endforeach;?>
					</select>
					<input type="text" id="whereWord" value="">
					<span id="whereWordUser"></span>
					<select id="whereType" onChange="goDataEditWhereWordChangeEvent(this);">
						<option value="=" mode="default"<?if($whereWordType[$i]=="="){echo " selected";}?>>정확히 일치하는 단어/문장</option>
						<option value="<>" mode="default"<?if($whereWordType[$i]=="<>"){echo " selected";}?>>제외하는 단어</option>
						<option value="like" mode="default"<?if($whereWordType[$i]=="like"){echo " selected";}?>>반드시 포함하는 단어</option>
						<option value="is not null" mode="default"<?if($whereWordType[$i]=="is not null"){echo " selected";}?>>IS NOT NULL</option>
						<option value="between" mode="date"<?if($whereWordType[$i]=="between"){echo " selected";}?>>입력된 날짜에 포함하여 검색</option>
						<option value="start" mode="date"<?if($whereWordType[$i]=="start"){echo " selected";}?>>입력된 날짜로부터 현재 까지 검색</option>
						<option value="end" mode="date"<?if($whereWordType[$i]=="end"){echo " selected";}?>>입력된 날짜까지 검색</option>
					</select>
					<a class="btn_sml" href="javascript:goDataEditWhereWordAddEvent()"><strong>추가</strong></a>
					<a class="btn_sml" onClick="goDataEditWhereWordDeleteEvent(this)"><strong>삭제</strong></a>
				</li>
			</ul>
		</div>

		<!--h3 class="mt20">검색범위(날짜)</h3>
		<div class="queryCondition">
			<ul id="whereDateArea">
				<li>
					<select id="whereLink"<?if($i==0){ echo " disabled"; }?>>
						<option value="AND"<?if($whereDateLink[$i]=="AND"){echo " selected";}?>>(AND 방식으로 검색)</option>
						<option value="OR"<?if($whereDateLink[$i]=="OR"){echo " selected";}?>>(OR 방식으로 검색)</option>
					</select>
					<select id="whereColumn">
						<option value="">항목</option>
						<?foreach($where_column as $column):?>
						<?if($column['PARTITION'] != "date") { continue; }?>
						<option value="<?=$column['COLUMN']?>" whereWordUser="<?=$column['STYLE']?>"><?=$column['NAME']?></option>
						<?endforeach;?>
					</select>
					<input type="text" id="whereDateStart" value="<?=$whereDateStart[$i]?>" class="_w50"> - <input type="text" id="whereDateEnd" value="<?=$whereDateEnd[$i]?>" class="_w50">
					<select id="whereType" onChange="goDataEditWhereDateChangeEvent(this);">
						<option value="between"<?if($whereDateType[$i]=="between"){echo " selected";}?>>입력된 날짜에 포함하여 검색</option>
						<option value="start"<?if($whereDateType[$i]=="start"){echo " selected";}?>>입력된 날짜로부터 현재 까지 검색</option>
						<option value="end"<?if($whereDateType[$i]=="end"){echo " selected";}?>>입력된 날짜까지 검색</option>
					</select>
					<a class="btn_sml" href="javascript:goDataEditWhereDateAddEvent()"><strong>추가</strong></a>
					<a class="btn_sml" onClick="goDataEditWhereDateDeleteEvent(this)"><strong>삭제</strong></a>
				</li>
			</ul>
		</div-->

		<h3 class="mt20">검색정렬</h3>
		<div class="queryCondition">
			<ul id="orderArea">
				<li>
					<select id="orderColumn">
						<option value="">항목</option>
						<?foreach($select_column as $column):?>
						<option value="<?=$column['COLUMN']?>"><?=$column['NAME']?></option>
						<?endforeach;?>
					</select>
					<select id="orderType">
						<option value="ASC">오름차순 정렬</option>
						<option value="DESC">내림차순 정렬</option>
					</select>
					<a class="btn_sml" onClick="goDataEditOrderAddEvent()"><strong>추가</strong></a>
					<a class="btn_sml" onClick="goDataEditOrderDeleteEvent(this)"><strong>삭제</strong></a>
				</li>
			</ul>
		</div>

		<div class="btnCenter" id="btnArea">
			<a href="javascript:goDataEditSearchActEvent()" class="btn_Big_Blue" style="width:70%;"><strong>스마트쿼리 실행하기</strong></a>
		</div>
		<div class="btnCenter" id="loadingArea" style="display:none">
			<strong>잠시만 기다려주세요.. 작업중입니다.</strong>
		</div>
	</form>
</div>