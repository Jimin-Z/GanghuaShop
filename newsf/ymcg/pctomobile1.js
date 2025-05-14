function browserRedirect()   {
	var sUserAgent = navigator.userAgent.toLowerCase();
	var bIsIpad = sUserAgent.match(/ipad/i) == 'ipad';
	var bIsIphone = sUserAgent.match(/iphone os/i) == 'iphone os';
	var bIsMidp = sUserAgent.match(/midp/i) == 'midp';
	var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == 'rv:1.2.3.4';
	var bIsUc = sUserAgent.match(/ucweb/i) == 'web';
	var bIsCE = sUserAgent.match(/windows ce/i) == 'windows ce';
	var bIsWM = sUserAgent.match(/windows mobile/i) == 'windows mobile';
	var bIsAndroid = sUserAgent.match(/android/i) == 'android';
	if(bIsIpad || bIsIphone || bIsMidp || bIsUc7 || bIsUc || bIsCE || bIsWM || bIsAndroid ){
		var strPath = window.location.host;	
		var pathname = window.location.pathname;	
		var href = window.location.href;
		console.log(pathname)
		if(pathname == "/abouthq.htm"){
			pathname = "/abouthq.htm";
		}else{
			pathname= pathname;
		}
		if(strPath =="www.globevisa.hk"){
			if (pathname == "/index.html") {
				window.location.href = "http://m.globevisa.hk";
			} else {
				window.location.href = "http://m.globevisa.hk" + pathname;
			}
		}else if(strPath =="www.globevisa.com.cn") {
			if (pathname == "/index.html") {
				window.location.href = "https://m.globevisa.com.cn";
			} else {
				window.location.href = "https://m.globevisa.com.cn" + pathname;
			}
		}else if(strPath =="www.globevisa.cn") {
			if (pathname == "/index.html") {
				window.location.href = "https://m.globevisa.cn";
			} else {
				window.location.href = "https://m.globevisa.cn" + pathname;
			}
		} else if(strPath =="www.globevisa.com") {
                        if (pathname == "/cn/indexhk.html") {
                                window.location.href = "https://m.globevisa.com/cn/indexhk.html";
                        } else {
                                window.location.href = "https://m.globevisa.com" + pathname;
                        }
                }

	}
}
browserRedirect();
