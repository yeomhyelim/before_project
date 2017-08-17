<script type="text/javascript">
<!--
	$(document).ready(function(){

	});
	
	/* 입점사 가입 약관 동의 */
	function goShopApplyAgree()
	{
		var strPolicyYN = $(":radio[name='policyYN']:checked").val();
		
		if (strPolicyYN == "N")
		{
			alert("<?=$LNG_TRANS_CHAR['MS00014']?>"); //"가입약관 동의를 선택해주세요."
			return;
		}

		location.href = "./?menuType=shop&mode=shopApplyReg";
	}
//-->
</script>