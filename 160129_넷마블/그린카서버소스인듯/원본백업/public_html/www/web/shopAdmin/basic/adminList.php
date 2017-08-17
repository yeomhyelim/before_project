<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00078"] //부관리자 관리?></h2>
		<div class="locationWrap"><span>home</span> / <span><?=$LNG_TRANS_CHAR["BW00087"] //기본설정?></span> / <strong><?=$LNG_TRANS_CHAR["BW00078"] //부관리자 관리?></strong></div>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="T" <?=($strSearchField=="T")?"selected":"";?>><?=$LNG_TRANS_CHAR["CW00023"] //이름?></option>
				<option value="I" <?=($strSearchField=="I")?"selected":"";?>><?=$LNG_TRANS_CHAR["CW00024"] //ID?></option>
			</select>
			<input type="input" value="<?=$strSearchKey?>" name="searchKey" id="searchKey"/><a  href="javascript:goSearch();" class="btn_blue_big"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchFormWrap -->
	</div>


	<div class="tableListWrap">
		<div class="tableListTopWrap">
			<span class="listCntNum">* <?=callLangTrans($LNG_TRANS_CHAR["CS00027"],array($intTotal))?><!--총 <strong><?=$intListNum?>개</strong>의 데이터가 있습니다.//--></span>
			<div class="selectedSort">
				<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["PW00117"] //목록수?>:</span>
				<select name="pageLine" style="vertical-align:middle;">
					<option value="10" <? if($intPageLine==10) echo 'selected';?>>10</option>
					<option value="20" <? if($intPageLine==20) echo 'selected';?>>20</option>
					<option value="30" <? if($intPageLine==30) echo 'selected';?>>30</option>
					<option value="40" <? if($intPageLine==40) echo 'selected';?>>40</option>
					<option value="50" <? if($intPageLine==50) echo 'selected';?>>50</option>
					<option value="60" <? if($intPageLine==60) echo 'selected';?>>60</option>
					<option value="70" <? if($intPageLine==70) echo 'selected';?>>70</option>
					<option value="80" <? if($intPageLine==80) echo 'selected';?>>80</option>
					<option value="90" <? if($intPageLine==90) echo 'selected';?>>90</option>
					<option value="100" <? if($intPageLine==100) echo 'selected';?>>100</option>
					<option value="200" <? if($intPageLine==200) echo 'selected';?>>200</option>
				</select>
			</div>
		<div class="clear"></div>
	</div>


	<div>
		<table class="tableList">
			<colgroup>
				<col style="width:50px;"/>
				<col/>
				<col/>
				<col/>
				<col style="width:150px;"/>
				<col style="width:80px;"/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //No?></th>
				<th><?=$LNG_TRANS_CHAR["CW00023"] //이름?></th>
				<th><?=$LNG_TRANS_CHAR["CW00024"] //ID?></th>
				<th><?=$LNG_TRANS_CHAR["CW00025"] //연락처?></th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?php if(!$intTotal):?>
			<tr>
				<td colspan="7"><?=$LNG_TRANS_CHAR["CS00001"] //데이터가 없습니다.?></td>
			</tr>
			<?php else:?>
			<?php while($row = mysql_fetch_array($resResult)):

					## 기본 설정
					$intM_NO = $row['M_NO'];
					$strM_NAME = $row['M_NAME'];
					$strM_ID = $row['M_ID'];
					$strM_HP = $row['M_HP'];
					$strA_REG_DT = $row['A_REG_DT'];
					$strM_MAIL = $row['M_MAIL'];
					$strA_TM_YN = $row['A_TM_YN'];
					$intA_STATUS = $row['A_STATUS'];

					## ID 설정
					$strIDNanme = $strM_ID;
					if($strM_MAIL):
						if($strIDNanme) { $strIDNanme .= "/"; }
						$strIDNanme .= $strM_MAIL;
					endif;

					## 등록일 설정
					$strA_REG_DT = date("Y-m-d", strtotime($strA_REG_DT));
			?>
			<tr>
				<td><?php echo $intListNum--;?></td>
				<td><?php echo $strM_NAME;?></td>
				<td><?php echo $strIDNanme;?></td>
				<td><?php echo $strM_HP;?></td>
				<td><?php echo $strA_REG_DT;?></td>
				<td>
					<a class="btn_sml" href="javascript:goMoveUrl('adminModify',<?php echo $intM_NO;?>);" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a> 
					<?php if($intA_STATUS==1):?>
					<a class="btn_sml" href="javascript:goAdminDel(<?php echo $intM_NO;?>);" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
					<?php else:?>
					<a class="btn_sml" href="javascript:goAdminRestore(<?php echo $intM_NO;?>);" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00005"] //복원?></strong></a>
					<?php endif;?>
				</td>
			</tr>
			<?php endwhile;?>
			<?php endif;?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate mt20">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object -->

	<? if ( $strSearchStatus != 9 ) : ?>
	<div class="buttonBoxWrap">
			<a class="btn_new_blue" href="javascript:goMoveUrl('adminWrite');" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["BW00088"] //부 관리자 추가?></strong></a>
	</div>
	<? endif; ?>

	<div class="noticeInfoWrap">
		<ul>
			<li>- <?=$LNG_TRANS_CHAR["BS00015"] //쇼핑몰을 운영하기 위한 관리자를 추가하실 수 있습니다.?> </li>
			<li>- <?=$LNG_TRANS_CHAR["BS00016"] //각부서별 관리인원을 추가해 주시고 해당 관리자의 메뉴 권한을 설정해 주세요.?> </li>
			<li>- <?=$LNG_TRANS_CHAR["BS00017"] //부 관리자는 메뉴별 권한에 따라 접근할 수 있는 메뉴가 제한됩니다.?> </li>
		</ul>
		<ul class="mt10">
			<li><strong><?=$LNG_TRANS_CHAR["BS00018"] //부관리자 추가를 위한 절차 안내?></strong></li>
			<li>
				<?=$LNG_TRANS_CHAR["BS00019"] //① 등록된 회원을 검색하여 회원그룹을 "<strong>관리자 그룹</strong>"으로 변경 합니다.?> 
				 <div class="helpTxt ml15">	
					<?=$LNG_TRANS_CHAR["BS00020"] //회원관리 메뉴에서 회원의 등급을 먼저 변경하세요.?><a href="./?menuType=member&mode=memberList"><?=$LNG_TRANS_CHAR["BW00090"] //회원검색?> <span style="font-size:9px;">▶</span></a>
				</div>
			</li>
			<li><?=$LNG_TRANS_CHAR["BS00021"] //② 본 메뉴에서 "부 관리자 추가" 버튼을 클릭하시면 관리자 추가 페이지로 이동합니다.?></li>
			<li><?=$LNG_TRANS_CHAR["BS00022"] //③ 해당회원을 검색하여 선택해 주시고 해당 관리자의 메뉴별 권한을 체크해 주세요.?></li>
		</ul>
	</div>
</div>
	
