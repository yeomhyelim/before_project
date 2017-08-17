			<?if ($strMenuType == "product" && $strSearchHCode1){?>
			<div class="linkedProdWrap">
				<div><img src="/images/title_right_goods.jpg"/></div>

					
					<div class='cartList'>
						<ul>
						<?if (is_array($aryProdCateSellList)){
							for($s=0;$s<sizeof($aryProdCateSellList);$s++){
						?>
							<li>
								<a href="javascript:goProdView('<?=$aryProdCateSellList[$s][P_CODE]?>')"><img src="<?=$aryProdCateSellList[$s][PM_REAL_NAME]?>" width=100 height=100 class='cartProdImg'/></a>	
								<dl>
									<dd><a href="javascript:goProdView('<?=$aryProdCateSellList[$s][P_CODE]?>')"><?=strConvertCut($aryProdCateSellList[$s][P_NAME],"22","N")?></a></dd>
									<dd class='priceInfo'><strong><?=getCurToPrice($aryProdCateSellList[$s][P_SALE_PRICE])?></strong></dd>
								</dl>
								<div class='clear'></div>
							</li>
							<?}}?>
						</ul>
					</div>
					
			</div>
			<?}?>