<!-- (1) 주문자 정보 -->
		<div class="tableOrderForm mt10">
			<h4 class="orderTit_order"><span><?=$LNG_TRANS_CHAR["OW00091"] //주문자 정보?></span>  
					&emsp;&emsp;
					<input type="checkbox" name="orderDelivery" id="orderDelivery" onclick="goOrderDeliveryChk2()"> [<?= $LNG_TRANS_CHAR["OW00124"]; //배송지와 동일 ?>]
			</h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00015"] //주문자명?></th>
					<td><input type="input" id="jname" name="jname" class="defInput _w250" maxlength="20" value="<?=$strJName?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00016"] //전화번호?></th>
					<td>
						<?=drawSelectBoxMore("jphone1",$aryPhone,$strJPhone1,$design ="defSelect",$onchange="",$etc="id=\"jphone1\"",$firstItem="",$html="N")?> -
						<input type="input" id="jphone2" name="jphone2" class="defInput _w85" maxlength="4" value="<?=$strJPhone2?>"/> -
						<input type="input"  id="jphone3" name="jphone3" class="defInput _w85" maxlength="4" value="<?=$strJPhone3?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00010"] //핸드폰?></th>
					<td>
						<?=drawSelectBoxMore("jhp1",$aryHp,$strJHp1,$design ="defSelect",$onchange="",$etc="id=\"jhp1\"",$firstItem="",$html="N")?> -
						<input type="input" id="jhp2" name="jhp2" class="defInput _w85" maxlength="4" value="<?=$strJHp2?>"/> -
						<input type="input"  id="jhp3" name="jhp3" class="defInput _w85" maxlength="4" value="<?=$strJHp3?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00011"] //이메일?></th>
					<td><input type="input" id="jmail" name="jmail" class="defInput _w250" maxlength="50" value="<?=$strJMail?>"/></td>
				</tr>
				<!-- 배송시 배송비가 포함되는 상품 카테고리가 존재하고 배송비가 포함되지 않은 상품이 0일때 //-->
				<?if($S_FIX_ORDER_DELIVERY_INFO_YN == "N" && is_array($S_FIX_ORDER_DELIVERY_PROD_CATE) && $intDeliveryPriceProdCnt == 0){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00028"] //메모?> </th>
					<td>
						<textarea name="bmemo" id="bmemo" style="width:100%;height:80px"/></textarea>
					</td>
				</tr>
				<?}?>
			</table>
		</div>
		<!-- tableOrderForm -->						
		<!-- (1) 주문자 정보 -->

		<!-- (2) 베송지 정보 -->
		<!-- 배송지정보 사용유무/ 배송정보를 입력해야 하는 상품이 존재할때 -->
		<?if ((!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y") || ($S_FIX_ORDER_DELIVERY_INFO_YN=="N" && $intDeliveryPriceProdCnt > 0)){?>
		<div class="tableOrderForm mt30">
			<h4 class="orderTit_Address"><span><?=$LNG_TRANS_CHAR["OW00092"] //배송지 정보?></span></h4>
			
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00029"] //배송지 확인?></th>
					<td>
						<span>
							<?php if($aryMemberAddrList):?>
							<?php foreach($aryMemberAddrList as $addrKey => $addrRow):?>
							<input type="radio" id="basicAddr" name="basicAddr" value="<?php echo $addrRow['MA_NO'];?>"<?php if($addrRow['MA_TYPE']=='1'){echo ' checked';}?>>
							<?php echo $addrRow['MA_NAME'];?><?php if($addrRow['MA_TYPE']=='1'){echo "({$LNG_TRANS_CHAR['OW00086']})";} // 기본배송지?>
							<?php endforeach;?>
							<input type="radio" id="basicAddr" name="basicAddr" value="Y" onclick=""/> <?php echo $LNG_TRANS_CHAR['OW00088'] //새로입력?>
							<a href="javascript:goMemberAddrList();" class="btnAddr"><span><?php echo $LNG_TRANS_CHAR['OW00085']; //주소록?></span></a>
							<?php else:?>
							<input type="hidden" id="basicAddr" name="basicAddr" value="Y"/>
							<input type="checkbox" id="jInfoYN" name="jInfoYN" value="Y" onclick="goOrderDeliveryChk();"/> <?php echo $LNG_TRANS_CHAR['OS00039']; //주문고객 정보와 동일합니다?>
							<?php endif;?>
						</span>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00017"] //받는사람명?></th>
					<td><input type="input" id="bname" name="bname" class="defInput _w250" maxlength="20" value="<?=$strBName?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00018"] //전화번호?></th>
					<td>
						<?=drawSelectBoxMore("bphone1",$aryPhone,$strBPhone1,$design ="defSelect",$onchange="",$etc="id=\"bphone1\"",$firstItem="",$html="N")?> -

						<input type="input" id="bphone2" name="bphone2" class="defInput _w85" maxlength="4" value="<?=$strBPhone2?>"/> -
						<input type="input" id="bphone3" name="bphone3" class="defInput _w85" maxlength="4" value="<?=$strBPhone3?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00019"] //핸드폰?></th>
					<td>
						<?=drawSelectBoxMore("bhp1",$aryHp,$strBHp1,$design ="defSelect",$onchange="",$etc="id=\"bhp1\"",$firstItem="",$html="N")?> -
						<input type="input" id="bhp2" name="bhp2" class="defInput _w85" maxlength="4"  value="<?=$strBHp2?>"/> -
						<input type="input" id="bhp3" name="bhp3" class="defInput _w85" maxlength="4"  value="<?=$strBHp3?>"/>
					</td>
				</tr>
				<!-- tr>
					<th><?=$LNG_TRANS_CHAR["OW00020"] //이메일?></th>
					<td><input type="input" id="bmail" name="bmail" class="defInput _w200" maxlength="50" value="<?=$strJMail?>"/></td>
				</tr -->
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00022"] //주소?> </th>
					<td>
						<dl>
							<dd><input type="input" id="bzip1" name="bzip1" class="defInput _w30" maxlength="3" readonly value="<?=$strJZip1?>"/>
							  - <input type="input" id="bzip2" name="bzip2" class="defInput _w30" maxlength="3" readonly value="<?=$strJZip2?>"/>
							    <a href="javascript:daumPopZip();" class="btnAddr"><span>우편번호</span></a>
							    <span id="guide" style="color:#999"></span></dd>
							<dd class="mt5">
								<input type="input" id="baddr1" name="baddr1" class="defInput _w200" readonly value="<?=$strJAddr1?>"/>
								<input type="input" id="baddr2" name="baddr2" class="defInput _w300" maxlength="100" value="<?=$strJAddr2?>"/></dd>
						</dl>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00028"] //메모?> </th>
					<td>
						<textarea name="bmemo" id="bmemo" style="width:515px;height:50px"/></textarea>
						<div class="txtBox mt5">
							<div class="ex">아래 문구중 원하시는 내용을 클릭하면 자동 입력됩니다.</div>
							<div class="exMemo ml10">
								<div id="exMemo1" class="exMemoInsert" style="margin-bottom:3px;cursor:pointer;">* 부재중일 때는 전화해주세요.</div>
								<div id="exMemo2" class="exMemoInsert" style="margin-bottom:3px;cursor:pointer;">* 배송전에는 문자를 주세요.</div>
								<div id="exMemo3" class="exMemoInsert" style="margin-bottom:3px;cursor:pointer;">* 주문자 이름을 꼭 남겨주세요.</div>
								<div id="exMemo4" class="exMemoInsert" style="margin-bottom:3px;cursor:pointer;">* 토요일 오후는 집에 있습니다.</div>
							</div>
							<div class="clr"></div>
						</div>
					</td>
				</tr>
			</table>
			<div class="txt_notice_order"></div>
		</div>
		<?}?>
		<!-- tableOrderForm -->
		<!-- (2) 배송지 정보 -->

