
var LNG_TRANS_CHAR = new Object();
LNG_TRANS_CHAR['KR'] = new Object();
LNG_TRANS_CHAR['US'] = new Object();
LNG_TRANS_CHAR['CN'] = new Object();
LNG_TRANS_CHAR['ES'] = new Object();
LNG_TRANS_CHAR['ID'] = new Object();
LNG_TRANS_CHAR['JP'] = new Object();
LNG_TRANS_CHAR['MX'] = new Object();
LNG_TRANS_CHAR['RU'] = new Object();
LNG_TRANS_CHAR['TW'] = new Object();

LNG_TRANS_CHAR['KR']['SN00001'] = "감사합니다. 등록되었습니다.";
LNG_TRANS_CHAR['US']['SN00001'] = "Thank you. Registered.";
LNG_TRANS_CHAR['CN']['SN00001'] = "Thank you. Registered.";
LNG_TRANS_CHAR['ES']['SN00001'] = "Thank you. Registered.";
LNG_TRANS_CHAR['US']['SN00001'] = "Thank you. Registered.";
LNG_TRANS_CHAR['ID']['SN00001'] = "Thank you. Registered.";
LNG_TRANS_CHAR['JP']['SN00001'] = "Thank you. Registered.";
LNG_TRANS_CHAR['MX']['SN00001'] = "Thank you. Registered.";
LNG_TRANS_CHAR['RU']['SN00001'] = "Thank you. Registered.";
LNG_TRANS_CHAR['TW']['SN00001'] = "Thank you. Registered.";

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
			alert(LNG_TRANS_CHAR[strSiteJsLng]['SN00001']);
		} else {
		
		}
	}

	FB.ui(obj, callback);
}


function goSns(href, name) {
	var a = window.open(href, name, '');
	if ( a ) { a.focus(); }
}

function goKakaoTalk(msg,url)
{
    /* 
    msg, url, appid, appname은 실제 서비스에서 사용하는 정보로 업데이트되어야 합니다. 
    */
    kakao.link("talk").send({
        msg : msg,
        url : url,
        appid : "<?=$S_HTTP_HOST?>",
        appver : "2.0",
        appname : "<?=$S_SITE_KNAME?>",
        type : "link"
    });
}

function goKakaoStory(msg,url,img)
{
    /* 
    msg, url, appid, appname은 실제 서비스에서 사용하는 정보로 업데이트되어야 합니다. 
    */
    kakao.link("story").send({   
        post : url,
        appid : "<?=$S_HTTP_HOST?>",
        appver : "1.0",
        appname : "<?=$S_SITE_KNAME?>",
        urlinfo : JSON.stringify({title:msg, desc:msg, imageurl:[img], type:"article"})
    });
}



function goPinterest(msg,url,media) {
    var href = "http://www.pinterest.com/pin/create/button/?media=" + encodeURIComponent(media) + "&url=" + encodeURIComponent(url) + "&description=" + encodeURIComponent(msg);
    var name = "pinterest";
    goSns(href, name);
}

function goWeibo(msg,url,pic) {
    var href = "http://service.weibo.com/share/share.php?url=" + encodeURIComponent(url) + "&title=" + encodeURIComponent(msg) + "&pic=" + encodeURIComponent(pic);
    var name = "weibo";
    goSns(href, name);
}
