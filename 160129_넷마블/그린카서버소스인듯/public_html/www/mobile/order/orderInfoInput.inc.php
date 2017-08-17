<?php

	## 스크립트 설정
	$aryScriptEx[] = "/common/tinybox2/tinybox.js";

?>
<!-- (1) 주문자 정보 -->
		<div class="tableOrderForm">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00091"] //주문자 정보?></span>
				&emsp;&emsp;
				<input type="checkbox" name="orderDelivery" id="orderDelivery" onclick="goOrderDeliveryChk2()"> [<?= $LNG_TRANS_CHAR["OW00124"]; //배송지와 동일 ?>]
			</div>
			<div class="tableBox">
				<table class="tableFormType">
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00015"] //주문자명?></th>
						<td><input type="text" id="jname" name="jname" maxlength="20" value="<?=$strJName?>" class="i_w"/></td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00016"] //전화번호?></th>
						<td>
							<?=drawSelectBoxMore("jphone1",$aryPhone,$strJPhone1,$design ="telSelect",$onchange="",$etc="id=\"jphone1\"",$firstItem="",$html="N")?> -
							<input type="tel" id="jphone2" name="jphone2" class="i_tel" maxlength="4" value="<?=$strJPhone2?>"/> -
							<input type="tel"  id="jphone3" name="jphone3" class="i_tel" maxlength="4" value="<?=$strJPhone3?>"/>
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00010"] //핸드폰?></th>
						<td>
							<?=drawSelectBoxMore("jhp1",$aryHp,$strJHp1,$design ="telSelect",$onchange="",$etc="id=\"jhp1\"",$firstItem="",$html="N")?> -
							<input type="tel" id="jhp2" name="jhp2" class="i_tel" maxlength="4" value="<?=$strJHp2?>"/> -
							<input type="tel"  id="jhp3" name="jhp3" class="i_tel" maxlength="4" value="<?=$strJHp3?>"/>
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00011"] //이메일?></th>
						<td><input type="email" id="jmail" name="jmail" class="i_w" maxlength="50" value="<?=$strJMail?>"/></td>
					</tr>
				</table>
			</div>
		</div>
		<!-- tableOrderForm -->						
		<!-- (1) 주문자 정보 -->

		<!-- (2) 베송지 정보 -->
		<div class="tableOrderForm">
			<div class="titBox"><span class="barRed"></span><span class="tit">배송지 정보</span>
				&emsp;&emsp;
				<input type="checkbox" name="jInfoYN" id="jInfoYN" onclick="goOrderDeliveryChk()"> [<?= $LNG_TRANS_CHAR["OW00125"]; //주문지와 동일 ?>]	
			</div>
			
			<div class="tableBox">
				<table class="tableFormType">
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00029"] //배송지 확인?></th>
						<td>
							<span>
								<?php if($aryMemberAddrList):?>
								<?php foreach($aryMemberAddrList as $addrKey => $addrRow):?>
								<input type="radio" id="basicAddr" name="basicAddr" value="<?php echo $addrRow['MA_NO'];?>"<?php if($addrRow['MA_TYPE']==1){echo ' checked';}?>>
								<?php echo $addrRow['MA_NAME'];?><?php if($addrRow['MA_TYPE']==1){echo "({$LNG_TRANS_CHAR['OW00086']})";} // 기본배송지?>
								<?php endforeach;?>
								<input type="radio" id="basicAddr" name="basicAddr" value="Y" onclick=""/> <?php echo $LNG_TRANS_CHAR['OW00088'] //새로입력?>
								<a href="javascript:goMemberAddrList();" class="btnAddr"><span><?php echo $LNG_TRANS_CHAR['OW00085']; //주소록?></span></a>
								<?php else:?>
								<input type="hidden" id="basicAddr" name="basicAddr" value="Y"/>
								<input type="checkbox" id="jInfoYN" name="jInfoYN" value="Y" onclick="goOrderDeliveryChk();" checked/> <?php echo $LNG_TRANS_CHAR['OS00039']; //주문고객 정보와 동일합니다?>
								<?php endif;?>
							</span>
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00017"] //받는사람명?></th>
						<td><input type="text" id="bname" name="bname" class="i_w" maxlength="20" value="<?=$strJName?>"/></td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00018"] //전화번호?></th>
						<td>
							<?=drawSelectBoxMore("bphone1",$aryPhone,$strBPhone1,$design ="telSelect",$onchange="",$etc="id=\"bphone1\"",$firstItem="",$html="N")?> -

							<input type="tel" id="bphone2" name="bphone2" class="i_tel" maxlength="4" value="<?=$strBPhone2?>"/> -
							<input type="tel" id="bphone3" name="bphone3" class="i_tel" maxlength="4" value="<?=$strBPhone3?>"/>
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00019"] //핸드폰?></th>
						<td>
							<?=drawSelectBoxMore("bhp1",$aryHp,$strBHp1,$design ="telSelect",$onchange="",$etc="id=\"bhp1\"",$firstItem="",$html="N")?> -
							<input type="tel" id="bhp2" name="bhp2" class="i_tel" maxlength="4"  value="<?=$strBHp2?>"/> -
							<input type="tel" id="bhp3" name="bhp3" class="i_tel" maxlength="4"  value="<?=$strBHp3?>"/>
						</td>
					</tr>
					<!--<tr>
						<th><?=$LNG_TRANS_CHAR["OW00020"] //이메일?></th>
						<td><input type="text" id="bmail" name="bmail" class="i_w" maxlength="50"/></td>
					</tr>//-->
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00022"] //주소?> </th>
						<td>
							<div class="zipCodeWrap">
									<input type="tel" id="bzip1" name="bzip1" maxlength="3" readonly value="<?=$strJZip1?>"/> 
									<span>-</span>
									<input type="tel" id="bzip2" name="bzip2" maxlength="3" readonly value="<?=$strJZip2?>"/> 
									
							
									<?php $strInNameZip1 = "bzip1";?>
									<?php $strInNameZip2 = "bzip2";?>
									<?php $strInNameAdd1 = "baddr1";?>
									<?php $strInNameAdd2 = "baddr2";?>
									<?php include MALL_HOME . "/mobile/include/popZip.php";?>
								</div>

									<input type="text" id="baddr1" name="baddr1" class="i_w" readonly value="<?=$strJAddr1?>"/>
									<input type="text" id="baddr2" name="baddr2" class="i_w" maxlength="100" value="<?=$strJAddr2?>"/>
							
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00028"] //메모?> </th>
						<td>
							<textarea name="bmemo" id="bmemo"  class="t_w"/></textarea>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- tableOrderForm -->
		<!-- (2) 배송지 정보 -->