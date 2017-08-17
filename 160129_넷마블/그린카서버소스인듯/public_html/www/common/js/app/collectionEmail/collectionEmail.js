
	function goCollectionEmailWriteActEvent() {
		var email		= $("input[name=c_email]").val();

		if(!email) {
			alert("Please, enter your e-mail.");
			$("input[name=c_email]").focus();
			return;
		}

		var data			= new Object();
		data['menuType']	= "main";
		data['mode']		= "json";
		data['act']			= "collectionEmailWrite";
		data['email']		= email;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									alert("Successful.");
								} else {
									alert(data['__MSG__']);
//									alert(data);
								}
						   }
		});

	}