
/* 트위터 */
function goTwitter(msg,url) {
	var href = "http://twitter.com/home?status=" + encodeURIComponent(msg) + " " + encodeURIComponent(url);
	var name = "twitter";
	goSns(href, name);
}

function goMe2Day(msg, url) {
	var href = "http://me2day.net/posts/new?new_post[body]=" + encodeURIComponent(msg) + "&new_post[tags]=" + encodeURIComponent(url);
	var name = "me2Day";
	goSns(href, name);
}

function goFacebook(link, picture, name, caption, description) {

	var obj = {
	  method		: 'feed',
	  link			: link,
	  picture		: picture,
	  name			: name,
	  caption		: caption,
	  description	: description
	};

	function callback(response) {
		if (response && response.post_id) {
			alert('감사합니다. 등록되었습니다.');
		} else {
		
		}
	}

	FB.ui(obj, callback);
}

function goSns(href, name) {
	var a = window.open(href, name, '');
	if ( a ) { a.focus(); }
}
