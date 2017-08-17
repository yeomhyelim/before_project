//$(document).ready(function() {

	// http://gomihouse.co.kr/counter.php/?countryCode=KR
	var callCountPage	= "http://"+strSiteHost+"/counter.php";
	var callCountParam  = "";
	
	var aryReqUri		= strSiteReqUri.split("?");
	
	callCountParam += "countryCode="+strSiteJsLng;
	if (!C_isNull(aryReqUri[1]))
	{
		callCountParam += "&"+aryReqUri[1];
	}

	if (window.XMLHttpRequest) {
		//code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.open("post", callCountPage, true);
/*
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", callCountParam.length);
	xmlhttp.setRequestHeader("Connection", "close");
*/
	xmlhttp.onreadystatechange = function() 
	{
		if(xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
			} // status==200
		} // readystate
	}; // onreadystate
	xmlhttp.send(callCountParam);

//});

