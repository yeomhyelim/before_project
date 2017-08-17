<?php
	## MATA TAG 설정
	$strMataTagPath = SHOP_HOME . "/layout/html/inc-metatag.php";
	$strMetaTag = FileDevice::getContents($strMataTagPath);

?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00001"] //기본정보?></h2>
		<div class="locationWrap"><span>home</span> / <span><?=$LNG_TRANS_CHAR["BW00087"] //기본설정?></span> / <strong><?=$LNG_TRANS_CHAR["BW00001"] //기본정보?></strong></div>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<h3><?=$LNG_TRANS_CHAR["BW00002"] //쇼핑몰?> <?=$LNG_TRANS_CHAR["BW00001"] //기본정보?></h3>
		<div class="titInfoTxt"><?=$LNG_TRANS_CHAR["BS00036"] //쇼핑몰 <strong>소개,하단정보,이용안내 및 운영에 관련</strong>하여 이용됩니다.  정확히 입력해 주세요.?></div>
		<table>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00001"] //쇼핑몰명?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="site_nm" name="site_nm" value="<?=$row[S_SITE_NM]?>"/>
				</td>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00003"] //쇼핑몰영문명?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="site_eng_nm" name="site_eng_nm" value="<?=$row[S_SITE_ENG_NM]?>"/>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00004"] //URL?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="site_url" name="site_url" value="<?=$row[S_SITE_URL]?>"/>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00005"] //이메일?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="site_mail" name="site_mail" value="<?=$row[S_SITE_MAIL]?>"/>
				</td>
			</tr>
		</table>
		
		<h3><?=$LNG_TRANS_CHAR["BW00006"] //회사정보?></h3>
		<div class="titInfoTxt"><?=$LNG_TRANS_CHAR["BS00036"] //쇼핑몰 <strong>소개,하단정보,이용안내 및 운영에 관련</strong>하여 이용됩니다.  정확히 입력해 주세요.?></div>
		<table>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00007"] //회사명?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="com_nm" name="com_nm" value="<?=$row[S_COM_NM]?>"/>
				</td>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00008"] //대표자명?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="rep_nm" name="rep_nm" value="<?=$row[S_REP_NM]?>"/>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00009"] //사업자등록번호?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:40px;" id="com_num1_1" name="com_num1_1" value="<?=$strComNum1_1?>" maxlength="3"/>
					-
					<input type="text" <?=$nBox?>  style="width:30px;" id="com_num1_2" name="com_num1_2" value="<?=$strComNum1_2?>" maxlength="2"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_num1_3" name="com_num1_3" value="<?=$strComNum1_3?>" maxlength="5"/>
				</td>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00010"] //통신판매업신고번호?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_num2_1" name="com_num2_1" value="<?=$strComNum2_1?>" maxlength="5"/>
					-
					<input type="text" <?=$nBox?>  style="width:100px;" id="com_num2_2" name="com_num2_2" value="<?=$strComNum2_2?>" />
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_num2_3" name="com_num2_3" value="<?=$strComNum2_3?>" />
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00011"] //업태?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="com_busi1" name="com_busi1" value="<?=$row[S_COM_BUSI1]?>"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["BW00012"] //종목?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="com_busi2" name="com_busi2" value="<?=$row[S_COM_BUSI2]?>"/>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00013"] //전화번호?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_phone1" name="com_phone1" value="<?=$strComPhone1?>"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_phone2" name="com_phone2" value="<?=$strComPhone2?>"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_phone3" name="com_phone3" value="<?=$strComPhone3?>"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["BW00014"] //팩스번호?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_fax1" name="com_fax1" value="<?=$strComFax1?>"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_fax2" name="com_fax2" value="<?=$strComFax2?>"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_fax3" name="com_fax3" value="<?=$strComFax3?>"/>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00015"] //주소?></span></th>
				<td colspan="3">
					<ul>
						<li><input type="text" <?=$nBox?>  style="width:50px;" id="com_zip1" name="com_zip1" value="<?=$strComZip1?>"/>
						-
						<input type="text" <?=$nBox?>  style="width:50px;" id="com_zip2" name="com_zip2" value="<?=$strComZip2?>"/>
						<!-- a class="btn_sml" href="javascript:goZip(1)"><strong><?=$LNG_TRANS_CHAR["BW00016"] //우편번호?></strong></a><li //-->
						<li><input type="text" <?=$nBox?>  style="width:500px;" id="com_addr" name="com_addr" value="<?=$row[S_COM_ADDR]?>"/></li>
					</ul>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00174"] //휴대폰?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_hp1" name="com_hp1" value="<?=$strComHp1?>"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_hp2" name="com_hp2" value="<?=$strComHp2?>"/>
					-
					<input type="text" <?=$nBox?>  style="width:50px;" id="com_hp3" name="com_hp3" value="<?=$strComHp3?>"/>
				</td>
			</tr>

		</table>
		
		<h3><?=$LNG_TRANS_CHAR["BW00017"] //개인정보 보호 담당자?></h3>
		<table>
			<tr>
				<th><span class=""><?=$LNG_TRANS_CHAR["BW00018"] //이름?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="pim_name" name="pim_name" value="<?=$row[S_PIM_NAME]?>"/>
				</td>
			</tr>
			<tr>
				<th><span class=""><?=$LNG_TRANS_CHAR["BW00019"] //연락처?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="pim_hp" name="pim_hp" value="<?=$row[S_PIM_HP]?>"/>
				</td>
			</tr>
			<tr>
				<th><span class=""><?=$LNG_TRANS_CHAR["BW00005"] //이메일?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="pim_mail" name="pim_mail" value="<?=$row[S_PIM_MAIL]?>"/>
				</td>
			</tr>
		</table>
		
		<h3><?=$LNG_TRANS_CHAR["BW00020"] //기타관리?></h3>
		<div class="titInfoTxt"><?=$LNG_TRANS_CHAR["BS00037"] //쇼핑몰의 <strong>메인타이틀, 우클릭 금지 및 SNS공유 설정</strong>을 합니다.?></div>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00021"] //상단 타이틀?> / Favicon </th>
				<td class="faviIcon">
					<?php if($row['S_SITE_FAVICON_FILE']):?>
					<img src="/upload/site/<?php echo $row['S_SITE_FAVICON_FILE'];?>" style="width:20px;height:20px">
					<?php endif;?>
					<input type="file" name="site_favicon_file">
					<?php if($row['S_SITE_FAVICON_FILE']):?>
					<input type="checkbox" name="site_favicon_file_del" value="Y">삭제
					<?php endif;?><br>
					<input type="text" <?=$nBox?>  style="width:500px;" id="site_title" name="site_title" value="<?=$row[S_SITE_TITLE]?>"/>
				</td>
			</tr>
			<!--
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00176"]  //헤더추가항목?></th>
				<td>
					<textarea name="site_metaTag" <?=$nBox?>  style="width:500px;height:20px;"><?php echo $strMetaTag;?></textarea>
				</td>
			</tr>
			-->
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00022"] //복사방지 설정?></th>
				<td>
					<input type="radio" id="site_copy" name="site_copy" value="Y" <?=($row[S_SITE_COPY]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
					<input type="radio" id="site_copy" name="site_copy" value="N" <?=($row[S_SITE_COPY]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용하지 않음?>
					<div class="helpTxt">
						<?=$LNG_TRANS_CHAR["BS00001"]?>
					</div>
				</td>
			</tr>
			<!-- tr>
				<th>SNS</th>
				<td>
					<ul>
						<li>
							<input type="checkbox" id="site_facebook" name="site_facebook" value="Y" <?=($row[S_SITE_FACEBOOK]=="Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["BS00038"] //FaceBook 사용?>  <br>
							FaceBook App Id
							<input type="text" <?=$nBox?>  style="width:120px;" id="site_facebook_app_id" name="site_facebook_app_id" value="<?=$row[S_SITE_FACEBOOK_APP_ID]?>"/>
							<input type="text" <?=$nBox?>  style="width:200px;" id="site_facebook_secret" name="site_facebook_secret" value="<?=$row[S_SITE_FACEBOOK_SECRET]?>"/>
							<div class="helpTxt">	
								<ul>
									<li>- <?=$LNG_TRANS_CHAR["BS00039"] //페이스북의 아이디로 회원가입 및 로그인이 가능합니다.?></li>
									<li>- <?=$LNG_TRANS_CHAR["BS00040"] //페이스북 developer 페이지(<a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a>)로 가서 새 앱 만들기를 하셔야 합니다.?></li>
								</ul>
							</div>
						</li>
						<li><input type="checkbox" id="site_twitter" name="site_twitter" value="Y" <?=($row[S_SITE_TWITTER]=="Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["BS00041"]  //Twitter사용?></li>
						<!-- li><input type="checkbox" id="site_me2today" name="site_me2today" value="Y" <?=($row[S_SITE_ME2TODAY]=="Y")?"checked":"";?>/> Me2Today</li -->
					</ul>
				</td>
			</tr -->
		</table>
	</div>

	<div class="buttonWrap">
		<a class="btn_Big_Blue" href="javascript:goInfoModify();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="noticeInfoWrap">
		<ul>
			<li>- <?=$LNG_TRANS_CHAR["BS00042"] //쇼핑몰 세팅 완료 후 운영자의 정보로 정확히 기재해 주셔야 합니다.?> </li>
			<li>- <?=$LNG_TRANS_CHAR["BS00043"] //허위 운영자 정보 및 잘못된 정보 기재 시 불이익이 발생 할 수 있습니다.?> </li>
		</ul>
	</div>
</div>