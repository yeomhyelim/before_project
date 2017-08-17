<?
	## 설정
	$dataList	=  $_REQUEST['result']['DataMgr'];
	$countList	=  $_REQUEST['result']['count'];
	$boardInfo	=  $_REQUEST['result']['board_info'];
?>

<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["BW00178"]//커뮤니티 현황?></h2>
	<div class="clr"></div>
</div>

<!-- ******** 컨텐츠 ********* -->
<div class="mainInfoWrap mt20">
	<ul class="listWrap">
		<?if(!is_array($dataList)):?>
			<?=$LNG_TRANS_CHAR["CS00001"]//등록된 게시판이 없습니다.?>
		<?else:?>
		<?$intCnt=0;?>
		<?foreach($dataList as $b_code => $result):?>
		<?if($boardInfo[$b_code]['bi_admin_main_show']!="Y") { continue; }?>
		<?if($boardInfo[$b_code]['b_kind']=="talk") { continue; }?>
		<li>
			<!-- (1)list start -->
				<div class="mainTableList">
					<div class="mainListTitleWrap">
						<h4><span><?=$boardInfo[$b_code]['b_name']?>(<?=$LNG_TRANS_CHAR["CW00017"]//오늘?>: <strong><?=$countList[$b_code]['TODAY']?><?=$LNG_TRANS_CHAR["MW00167"]//건?></strong>/총 <strong><?=$countList[$b_code]['TOTAL']?><?=$LNG_TRANS_CHAR["MW00167"]//건?></strong>)</span></h4>
						<span class="moreBtn"><a href="./?menuType=community&mode=dataList&b_code=<?=$b_code?>"><?=$LNG_TRANS_CHAR["CW00087"]//더보기?></a></span>
						<div class="clear"></div>
					</div>
					 <table>
						<colgroup>
							<col/>
							<col style="width:70px"/>
							<col style="width:70px"/>
						</colgroup>
						<?while($row = mysql_fetch_array($result)):?>
						<tr>
							<td class="listTitle"><a href="javascript:goDataViewMove1('<?=$b_code?>','<?=$row['UB_NO']?>')"><?=$row['UB_TITLE']?>
								<?if($boardInfo[$b_code]['bi_comment_use']!="N"):?>
								<?if(!$row['CMT_CNT']) { $row['CMT_CNT'] = 0; }?>
								(<?=$row['CMT_CNT']?>)
								<?endif;?>
								<?if(date("Y.m.d", strtotime($row['UB_REG_DT'])) == date("Y.m.d", time())):?><img src="./himg/common/ico_new.gif"/><?endif;?></a>
							</td>
							<td><?=$row['UB_NAME']?></td>
							<td class="regDate"><?=date("Y.m.d", strtotime($row['UB_REG_DT']))?></td>
						</tr>
						<?endwhile?>
					 </table>
				 </div>
			<!-- (1)list end -->
				<div class="clr"></div>
		</li>
		<?$intCnt++;?>
		<?endforeach;?>
		<?endif;?>
	</ul>
	<div class="clear"></div>
</div><!-- mainInfoWrap -->