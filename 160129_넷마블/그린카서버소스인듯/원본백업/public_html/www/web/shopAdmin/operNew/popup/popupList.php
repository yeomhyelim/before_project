<?
	## 정렬 설정
	$sortPO_NO			= "NO_DESC";
	$sortPO_STATE		= "STATE_DESC";
	$sortPO_TITLE		= "TITLE_DESC";
	$sortPO_START_DT	= "START_DT_DESC";
	$sortPO_END_DT		= "END_DESC";

		 if($_REQUEST['sortType'] == "NO_DESC")			{ $sortPO_NO		= "NO_ASC";			}
	else if($_REQUEST['sortType'] == "STATE_DESC")		{ $sortPO_STATE		= "STATE_ASC";		}
	else if($_REQUEST['sortType'] == "TITLE_DESC")		{ $sortPO_TITLE		= "TITLE_ASC";		}
	else if($_REQUEST['sortType'] == "START_DT_DESC")	{ $sortPO_START_DT	= "START_DT_ASC";	}
	else if($_REQUEST['sortType'] == "END_DESC")		{ $sortPO_END_DT	= "END_ASC";		}
	else												{										}

	## 파일 설정
	$webFolder							= "/upload/popup/";

?>
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["EW00001"] //팝업관리?></h2>
	<div class="clr"></div>
</div>

<div class="tableList">
	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col style="width:50px;">
			<col style="width:100px;">
			<col style="width:60px;">
			<col />
			<col style="width:100px;">
			<col style="width:100px;">
			<col style="width:100px;">
		</colgroup>
		<tr>
			<th><a href="javascript:goSortMoveEvent('<?=$sortPO_NO?>')"><?=$LNG_TRANS_CHAR["CW00009"] //번호?></a></th>
			<th><a href="javascript:goSortMoveEvent('<?=$sortPO_STATE?>')"><?=$LNG_TRANS_CHAR["EW00004"] //상태?></a></th>
			<th>이미지</th>
			<th><a href="javascript:goSortMoveEvent('<?=$sortPO_TITLE?>')"><?=$LNG_TRANS_CHAR["EW00005"] //제목?></a></th>
			<th><a href="javascript:goSortMoveEvent('<?=$sortPO_START_DT?>')">시작일</a></th>
			<th><a href="javascript:goSortMoveEvent('<?=$sortPO_END_DT?>')">종료일</a></th>
			<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
		</tr>
		<?while($row = mysql_fetch_array($popupResult)):
			$regDate	= date("Y-m-d", strtotime($row['PO_REG_DT']));
			$startDate	= date("Y-m-d", strtotime($row['PO_START_DT']));
			$endDate	= date("Y-m-d", strtotime($row['PO_END_DT']));
			$imgFile	= "";
			if($row['PO_FILE']):
				$imgFile	= "{$webFolder}{$row['PO_FILE']}";
			endif;

			## 상태
			$type			= "진행중";
			$now			= date("Y-m-d");
			if($row['PO_VIEW'] != "Y")			  { $type = "일지정지";			}
			if(getDateDiff($now, $startDate) < 0) { $type = "진행전";			}
			if(getDateDiff($now, $endDate)   > 0) { $type = "진행완료";			}
		?>
		<tr>
			<td><?=$intListNum--?></td>
			<td><?=$type?></td>
			<td><?if($imgFile):?>
				<img src="<?=$imgFile?>" style="width:60px;height:60px">
				<?endif;?></td>
			<td style="text-align:left"><?=$row['PO_TITLE']?></td>
			<td><?=$startDate?></td>
			<td><?=$endDate?></td>
			<td><a href="javascript:goPopupModifyMoveEvent('<?=$row['PO_NO']?>')" class="btn_sml"><span>수정</span></a>
				<a href="javascript:goPopupDeleteActEvent('<?=$row['PO_NO']?>')" class="btn_sml"><span>삭제</span></a></td>
		</tr>
		<?endwhile;?>
	</table>
</div>

<div class="paginate mt20">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

<div class="button">
<a class="btn_blue_big" href="javascript:goPopupWriteMoveEvent();"><strong><?=$LNG_TRANS_CHAR["CW00028"] //팝업추가?></strong></a>
</div>