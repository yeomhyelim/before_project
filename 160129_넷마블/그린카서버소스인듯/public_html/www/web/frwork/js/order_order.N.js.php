<script language="javascript">

	function _pay(_frm) 
	{
 		_frm.sndReply.value           = getLocalUrl("kspay_wh_rcv.php") ;
		
		var agent = navigator.userAgent;
		var midx		= agent.indexOf("MSIE");
		var out_size	= (midx != -1 && agent.charAt(midx+5) < '7');
    	
		var width_	= 500;
		var height_	= out_size ? 568 : 518;
		var left_	= screen.width;
		var top_	= screen.height;
    	
		left_ = left_/2 - (width_/2);
		top_ = top_/2 - (height_/2);
		
		op = window.open('about:blank','AuthFrmUp',
		        'height='+height_+',width='+width_+',status=yes,scrollbars=no,resizable=no,left='+left_+',top='+top_+'');

		if (op == null)
		{
			alert("팝업이 차단되어 결제를 진행할 수 없습니다.");
			return false;
		}
		
		_frm.target = 'AuthFrmUp';
		_frm.action ='https://kspay.ksnet.to/store/KSPayFlashV1.3/KSPayPWeb.jsp?sndCharSet=utf-8';
		//_frm.action ='http://210.181.28.116/store/KSPayFlashV1.3/KSPayPWeb.jsp?sndCharSet=utf-8';
		
		_frm.submit();
    }

	function getLocalUrl(mypage) 
	{ 
		var myloc = location.href; 
		//return myloc.substring(0, myloc.lastIndexOf('/')) + '/common/' + mypage;

		return  '<?=$S_SITE_URL?>/common/ksnet/' + mypage;
	} 
	
	// goResult() - 함수설명 : 결재완료후 결과값을 지정된 결과페이지(kspay_wh_result.php)로 전송합니다.
	function goResult(){
		document.form.method = "post";
		document.form.target = "";
		document.form.action = "/common/ksnet/kspay_wh_result.php";
		document.form.submit();
	}
	// eparamSet() - 함수설명 : 결재완료후 (kspay_wh_rcv.php로부터)결과값을 받아 지정된 결과페이지(kspay_wh_result.php)로 전송될 form에 세팅합니다.
	function eparamSet(rcid, rctype, rhash){
		document.form.reWHCid.value 	= rcid;
		document.form.reWHCtype.value   = rctype  ;
		document.form.reWHHash.value 	= rhash  ;
	}

</script>