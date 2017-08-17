<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00016"] //배너관리?> </h2>
		<div class="clr"></div>
	</div>
	<br>



	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
					<input type="checkbox" name="searchStatusY" id="searchStatusY" value="Y" <?=($strSearchStatusY=="Y")?"checked":"";?>> <?=$LNG_TRANS_CHAR["EW00017"] //보임?>
					<input type="checkbox" name="searchStatusN" id="searchStatusN" value="N" <?=($strSearchStatusN=="N")?"checked":"";?>> <?=$LNG_TRANS_CHAR["EW00018"] //안보임?>
					<input type="text" name="searchKey" id="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> style="width:450px;"/>
					<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchTableWrap -->
	</div>


	<div>
		<div class="listTabWrap">
			<?	
					$strHtml		= "<span>전체</span>";
					$strSelected	= ($intA_NO == "") ? " class=\"selected\"" : "";
					$strHtml		= sprintf("<a href=\"javascript:goBannerList('')\"%s>%s</a>", $strSelected, $strHtml);
				while($row = mysql_fetch_array($bannerGrpResult)) : 
					$strSelected	= ($intA_NO == $row['A_NO']) ? " class=\"selected\"" : "";
					$row['A_NAME']	= sprintf("<a href=\"javascript:goBannerList('%s')\"%s><span>%s</span></a>",$row['A_NO'], $strSelected, $row['A_NAME']);
					$strHtml		= sprintf("%s  %s", $strHtml, $row['A_NAME']);
				endwhile;	
				echo $strHtml;			
				?>
				
		</div>		
		<div class="clr"></div>
	</div>


	<div class="tableListWrap mt20">
		<table class="imgTable">
			<!-- (1) -->
			<?if($intTotal=="0"){?>
			<tr>
				<td colspan="9"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
			</tr>		
			<?} else { ?>
			<tr>
			<?
				$cnt = 0;
				while($row = mysql_fetch_array($result)){
					$bImage = "";
					if($row["B_FILE_{$S_ST_LNG}"] && $row[B_TYPE] == "F") {
						$bType		= "플래시";
						$bImage		= "<script type='text/javascript'>insertFlash('../upload/banner/".$row["B_FILE_{$S_ST_LNG}"]."', '100', '50', '', '', '');</script>";
					}
					else if($row["B_FILE_{$S_ST_LNG}"]) {
						$bType	= $LNG_TRANS_CHAR["EW00020"]; //"이미지";
						$bImage = "<img class='listImg' src='../upload/banner/".$row["B_FILE_{$S_ST_LNG}"]."'/>";
					}
			?>
			
				<td>
					<div class="imgListWrap">
						<?=$bImage?>
						<ul>
							<!-- li><?=$row[B_TITLE]?> <span>[<?=($row[B_END_DT]>$S_NOW_YYYYMMDD)?$LNG_TRANS_CHAR["EW00002"]:$LNG_TRANS_CHAR["EW00003"]; //"진행중":"종료";?>]</span></li -->
							<li>
								<a href="javascript:goMoveUrl('bannerModify',<?=$row[B_NO]?>)" id="menu_auth_m" class="inBtn"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></a> 
								<a  href="javascript:goMoveUrl('bannerDelete',<?=$row[B_NO]?>);" id="menu_auth_d" class="inBtn"><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></a> 
							</li>
						</ul>	
					</div>
				</td>
				<?
					if($cnt%4 == 3) echo "</tr><tr>";
					?>
			<?
					$cnt++;
				}
			}
			?>
		</table>
	</div>

	<!-- tableList -->
		<!-- Pagenate object --> 
		<div class="paginate">  
			<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
		</div>  
		<!-- Pagenate object -->

		<div class="buttonBoxWrap">
			<a class="btn_new_blue" href="javascript:goMoveUrl('bannerWrite');" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //배너추가?></strong></a>
		</div>



	<!-- 기능 공지 시작 -->
		<div class="noticeWrap">
			<div class="titleNotice"><img src="/shopAdmin/himg/common/tit_notice.gif"/></div>
			* <?=$LNG_TRANS_CHAR["ES00002"] //배너를 등록한 후 쇼핑몰에 적용 하기 위해서는 반드시 <strong>"등록배너 쇼핑몰에 적용하기"버튼을 클릭</strong> 하셔야 합니다.?><br/>
			* <?=$LNG_TRANS_CHAR["ES00003"] //적용하기클릭 후 해당 위치의 페이지를 확인해 보세요.?>
		</div>
	<!-- 기능 공지 끝 -->
</div>
