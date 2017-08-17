<?php

	## 모듈 설정
	$objBoardMgrNewModule = new BoardMgrNewModule($db);
	$objBoardDataModule = new BoardDataModule($db);

	## 언어설정
	$strLang = $_GET['lang'];
	if(!$strLang) { $strLang = $S_ST_LNG; }
	$strLangLower = strtolower($strLang);


	## 커뮤니티 리스트 불러오기
	$param = "";
	$param['LANG'] = $strLang;
	$param['B_USE'] = "Y";
	$param['BI_ADMIN_MAIN_SHOW'] = "Y";
	$param['BI_ADMIN_MAIN_SORT'] = "Y";
	$aryBoardList = $objBoardMgrNewModule->getBoardDataSelectEx2("OP_ARYTOTAL", $param);

	## 메인 커뮤니티 리스트 만들기
	$aryBoardListData = "";
	if($aryBoardList):
		foreach($aryBoardList as $key => $row):
			$strBI_ADMIN_MAIN_SHOW = $row['BI_ADMIN_MAIN_SHOW'];
			$intBI_ADMIN_MAIN_SORT = $row['BI_ADMIN_MAIN_SORT'];
			if($strBI_ADMIN_MAIN_SHOW != "Y") { continue; }
			$aryBoardListData[] = $row;
		endforeach;
	endif;

?>
<div class="contentTop">
	<h2>커뮤니티 현황</h2>
	<div class="clr"></div>
</div>
<!-- ******** 컨텐츠 ********* -->
<div class="mainInfoWrap mt20">
	<ul class="listWrap">
		<?php if(!$aryBoardListData):?>
		<li>
			게시판 설정에서 등록 할 수 있습니다.
		</li>
		<?php else:?>
		<?php foreach($aryBoardListData as $key => $row):

			## 기본설정
			$strBCode = $row['B_CODE'];
			$strBName = $row['B_NAME'];

			## 오늘 등록된 개수 설정
			$param = "";
			$param['B_CODE'] = $strBCode;
			$param['searchRegDTStart'] = date("Y-m-d");
			$param['searchRegDTEnd'] = date("Y-m-d");
			$param['UB_DEL_NOT'] = "Y";
			$intTodayTotal = $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);
			$strTodayTotal = number_format($intTodayTotal);

			## 총 개수 설정
			$param = "";
			$param['B_CODE'] = $strBCode;
			$param['UB_DEL_NOT'] = "Y";
			$intAllTotal = $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);
			$strAllTotal = number_format($intAllTotal);

			## 내용이 없으면 출력 안함
			if(!$intAllTotal) { continue; }

			## 데이터 불러오기
			$param = "";
			$param['B_CODE'] = $strBCode;
			$param['UB_DEL_NOT'] = "Y";
			$param['LIMIT_END'] = 5;
			$param['ORDER_BY'] = 'defaultDesc';
			$aryBoardDataList = $objBoardDataModule->getBoardDataSelectEx2("OP_ARYTOTAL", $param);


		?>
		<li>
			<div class="mainTableList">
				<div class="mainListTitleWrap">
					<h4><span><?php echo $strBName;?>(오늘: <strong><?php echo $strTodayTotal;?>건</strong>/총 <strong><?php echo $strAllTotal;?>건</strong>)</span></h4>
					<span class="moreBtn"><a href="./?menuType=community&mode=dataList&b_code=<?php echo $strBCode;?>">더보기</a></span>
					<div class="clear"></div>
				</div>
				 <table>
					<colgroup>
						<col/>
						<col style="width:70px"/>
						<col style="width:70px"/>
					</colgroup>
					<?php
						foreach($aryBoardDataList as $key2 => $row2){

							## 작성자 설정
							$strRegName = $row2['UB_NAME'];

							## 작성일 설정
							$strNowDate = date("Y.m.d");
							$strNowDate = date("Y.m.d", strtotime($row2['UB_REG_DT']));
							$isToday = false;
							if($strNowDate == $strNowDate) { $isToday = true; }

					?>
					<tr>
						<td class="listTitle">
							<a href="./?menuType=community&mode=dataView&b_code=<?php echo $strBCode;?>&ubNo=<?php echo $row2['UB_NO'];?>">
								<?php echo strHanCutUtf2($row2['UB_TITLE'],30);?>
								<?php if($isToday):?><img src="./himg/common/ico_new.gif"/><?endif;?>
							</a>
						</td>
						<td><?php echo $strRegName;?></td>
						<td class="regDate"><?php echo $strRegDate;?></td>
					</tr>
					<?php }?>
				 </table>
			 </div>
		</li>
		<?php endforeach;?>
		<?php endif;?>
	</ul>
	<div class="clear"></div>
</div>