<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00025"] //브랜드?> <?=$LNG_TRANS_CHAR["CW00007"] //관리?></h2>
		<div class="clr"></div>
	</div>
	
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col style="width:60px;"/>
				<col/>
				<col style="width:100px;"/>
				<col style="width:100px;"/>
				<col style="width:200px;"/>
				<col style="width:200px;"/>
				<col style="width:150px;"/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["PW00025"] //브랜드명?></th>
				<th>정렬</th>
				<th>담당자</th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<? while($row = mysql_fetch_array($prodBrandResult)) :  
					IF(!$row['PR_M_ID']) { $row['PR_M_ID'] = "-"; }				?>
			<tr>
				<td><?=$intTotal--?></td>
				<td class="prodListInfo">
					<ul>
						<li class="title"><?=$row[PR_NAME]?></li>
						<li><span>Code:</span><?=$row[PR_NO]?></li>
								<?if($row['PR_LIST_IMG']):?><li><img src="<?=$row['PR_LIST_IMG']?>"></li><?endif;?>
								<?if($row['PR_TITLE_IMG']):?><li><img src="<?=$row['PR_TITLE_IMG']?>"></li><?endif;?>
								<?if($row['PR_VIEW_IMG']):?><li><img src="<?=$row['PR_VIEW_IMG']?>"></li><?endif;?>
								<?if($row['PR_ADD_IMG']):?><li><img src="<?=$row['PR_ADD_IMG']?>"></li><?endif;?>
					</ul>

					<div class="clear"></div>
				</td>
				<td><?=$row['PR_ALIGN']?></td>
				<td><?=$row['PR_M_ID']?></td>
				<td><?=$row['PR_REG_DT']?></td>
				<td>
					<a class="btn_blue_sml" href="javascript:goMoveUrl('prodBrandModify','<?=$row['PR_NO']?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goDelete('<?=$row['PR_NO']?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
			<? endwhile; ?>
		</table>
	</div>
	<div class="paginate">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goMoveUrl('prodBrandWrite','');" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["PW00025"] //브랜드명?> <?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
	</div>

</div>
<!-- ******** 컨텐츠 ********* -->