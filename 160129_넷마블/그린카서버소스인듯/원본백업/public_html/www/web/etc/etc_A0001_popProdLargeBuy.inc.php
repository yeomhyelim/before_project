<?
	require_once MALL_CONF_LIB."ProductMgr.php";	
	$productMgr = new ProductMgr();

	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$strProdCode				= $_REQUEST['prodCode'];

	$param						= "";
	$param['P_LNG']				= $S_SITE_LNG;
	$param['P_CODE']			= $strProdCode;
	$param['PROD_INFO_JOIN']	= "Y";
	$prodRow					= $productMgr->getProdListEx($db, "OP_SELECT", $param);
	
	if (!$prodRow){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["PS00001"]); //등록된 상품이 존재하지 않습니다.
		exit;
	}

	$strProdName				= $prodRow['P_NAME'];
	$strProdImg					= $prodRow['PM_REAL_NAME'];
	$strProdPrice				= getCurMark()." ".getCurToPrice($prodRow['P_SALE_PRICE']).getCurMark2();
?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	function goAct()
	{
		if(!C_chkInput("name",true,"<?=$LNG_TRANS_CHAR['CW00053']?>",true)) return; //작성자
		if(!C_chkInput("pass",true,"<?=$LNG_TRANS_CHAR['MW00002']?>",true)) return; //비밀번호
		if(!C_chkInput("subj",true,"<?=$LNG_TRANS_CHAR['CW00062']?>",true)) return; //제목
		if(!C_chkInput("contents",true,"<?=$LNG_TRANS_CHAR['CW00063']?>",true)) return; //내용

		var doc				= document.form;
		doc.menuType.value	= "product";
		doc.mode.value		= "act";
		doc.act.value		= "prodLargeBuyWrite"
		doc.method			= "post";
		doc.action			= "./index.php";
		doc.submit();
	}
//-->
</script>
<body>
<div class="popContainer">
	<div class="cancelHight">
	<h2><?=$LNG_TRANS_CHAR["PW00050"] //대량구매요청?></h2>
	<form name='form' method='post'>
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="prodCode" value="<?=$strProdCode?>">

	<div class="mt10">
		<div class="popTableList">
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<td colspan="4">
						<div class="imgBox">
							<img src="<?=$strProdImg?>" alt="<?=$strProdName?> 이미지" />
						</div>
						<div class="txtBox">
							<?=$strProdName?>
							<p><span class="grayN"><?=$strProdPrice?></span></p>
						</div>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["CW00053"] //작성자?></th>
					<td style="text-align:left;">
						<input type="text" <?=$nBox?> id="name" name="name"  style="width:200px;" maxlength="50" value=""/>
					</td>
					<th><?=$LNG_TRANS_CHAR["MW00002"] //비밀번호?></th>
					<td style="text-align:left;">
						<input type="password" <?=$nBox?> id="pass" name="pass"  style="width:200px;" maxlength="20" value=""/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["CW00062"] //제목?></th>
					<td style="text-align:left;" colspan="3">
						<input type="text" <?=$nBox?> id="subj" name="subj"  style="width:500px;" maxlength="20" value=""/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["CW00063"] //내용?></th>
					<td style="text-align:left;" colspan="3">
						<textarea name="contents" id="contents" style="width:98%;height:150px"></textarea>
					</td>
				</tr>
			</table>
		</div><!-- tableForm -->
	</div>
	<div class="btnCenter">
		<a href="javascript:goAct();" class="popOrderCancelBtn" id="btnOrderCancel"><span><?=$LNG_TRANS_CHAR["CW00052"]; //글쓰기?></span></a>
		<a href="javascript:self.close();" class="popCloseBtn"><span><?=$LNG_TRANS_CHAR["CW00034"]; //닫기?></span></a>
	</div>
</div>
</form>

</body>
</html>