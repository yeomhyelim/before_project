
	function goCommentPointGiveActEvent(where) { goCommentPointGiveAct(where); }
	function goCommentCouponGiveActEvent(where) { goCommentCouponGiveAct(where); }

	function goCommentPointGiveAct(where) {
		 var mode = "data"+where+"PointGive";
		if(goCheckBox() <= 0) { alert("회원을 먼저 선택해주세요."); return false; }
		var  x = confirm("1선택하신 회원에게 포인트를 발급 하시겠습니까?");
		if (x == true) { 
			goAct(mode);
		}
	}

	function goCommentCouponGiveAct(where) {
		 var mode = "data"+where+"CouponGive";
		if(goCheckBox() <= 0) { alert("회원을 먼저 선택해주세요."); return false; }
		var  x = confirm("선택하신 회원에게 쿠폰을 발급 하시겠습니까?");
		if (x == true) { 
			goAct(mode);
		}
	}

