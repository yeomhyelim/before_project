
/*
Get Request Parameters
*/
var Request = {
	getParameter: function(name) {
		var rtnVal = "";
		var currentHref = unescape(location.href);
		var parameters = (currentHref.slice(currentHref.indexOf('?') + 1, currentHref.length)).split('&');

		for (var i = -1; ++ i < parameters.length;) {
			var temp = parameters[i].split("=");

			if (temp.length == 2) {
				if (temp[0].toLowerCase() == name.toLowerCase()) {
					rtnVal = temp[1];
					break;
				}
			}
		}

		return rtnVal;
	}
};

/*
 * Cookies
 */
var Cookies = {
	Set: function(name, value, day) {
		var expire = new Date();
		expire.setDate(expire.getDate() + day);
		cookies = name + "=" + escape(value) + "; path=/ ";
		if(typeof day != "undefined") cookies += ";expires=" + expire.toGMTString() + ";";
		document.cookie = cookies;
	},
	
	Get: function(name) {
		name = name + "=";
		var cookieData = document.cookie;
		var start = cookieData.indexOf(name);
		var value = "";

        if (start != -1) {
             start += name.length;
             var end = cookieData.indexOf(";", start);
             if(end == -1)end = cookieData.length;
             value = cookieData.substring(start, end);
        }

        return unescape(value);
	}
};