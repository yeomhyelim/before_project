
	// 에디터 글쓰기 설정
	var rootDir 	= "/common/eumEditor/highgardenEditor";
	var uploadImg 	= "/editor/seller/shop";
	var uploadFile 	= "/kr/";
	var htmlYN		= "Y";

	// 적용하기
	function goSellerShopPolicyModifyActEvent() {

		// 기본설정
		var objTarget = $('[form[name=form]');

		// 설정
		objTarget.find('[name=menuType]').val('seller');
		objTarget.find('[name=mode]').val('json');
		objTarget.find('[name=act]').val('shopPolicyModify');
		objTarget.find('[name=jsonMode]').val('shopPolicyModify');

		// 데이터 전달
		var data = objTarget.serializeArray();
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {

									alert("수정되었습니다.");
									location.reload();
									
								} else {
									var strMsg = data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(data);
								}
						   }
		});
	}