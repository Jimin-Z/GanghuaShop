$(document).ready(function () {
	var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	var base64DecodeChars = new Array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);
	/**
	 * base64±àÂë
	 * @param {Object} str
	 */
	function base64encode(str) {
		var out, i, len;
		var c1, c2, c3;
		len = str.length;
		i = 0;
		out = "";
		while (i < len) {
			c1 = str.charCodeAt(i++) & 0xff;
			if (i == len) {
				out += base64EncodeChars.charAt(c1 >> 2);
				out += base64EncodeChars.charAt((c1 & 0x3) << 4);
				out += "==";
				break;
			}
			c2 = str.charCodeAt(i++);
			if (i == len) {
				out += base64EncodeChars.charAt(c1 >> 2);
				out += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
				out += base64EncodeChars.charAt((c2 & 0xF) << 2);
				out += "=";
				break;
			}
			c3 = str.charCodeAt(i++);
			out += base64EncodeChars.charAt(c1 >> 2);
			out += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
			out += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
			out += base64EncodeChars.charAt(c3 & 0x3F);
		}
		return out;
	}
	/**
	 * base64½âÂë
	 * @param {Object} str
	 */
	function base64decode(str) {
		var c1, c2, c3, c4;
		var i, len, out;
		len = str.length;
		i = 0;
		out = "";
		while (i < len) {
			/* c1 */
			do {
				c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
			}
			while (i < len && c1 == -1);
			if (c1 == -1)
				break;
			/* c2 */
			do {
				c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
			}
			while (i < len && c2 == -1);
			if (c2 == -1)
				break;
			out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));
			/* c3 */
			do {
				c3 = str.charCodeAt(i++) & 0xff;
				if (c3 == 61)
					return out;
				c3 = base64DecodeChars[c3];
			}
			while (i < len && c3 == -1);
			if (c3 == -1)
				break;
			out += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));
			/* c4 */
			do {
				c4 = str.charCodeAt(i++) & 0xff;
				if (c4 == 61)
					return out;
				c4 = base64DecodeChars[c4];
			}
			while (i < len && c4 == -1);
			if (c4 == -1)
				break;
			out += String.fromCharCode(((c3 & 0x03) << 6) | c4);
		}
		return out;
	}
	/**
		连接websooket服务器，实时推送监控数据
	*/
	// var socketUrl = "wss://socket.globevisa.com.cn/visitwss",
	// 	ws = new WebSocket(socketUrl),
	// 	domain = window.location.host,
	// 	socketLock = false;
	// port = 0;
	// if (domain == 'm.globevisa.cn' || domain == 'm.globevisa.com.cn') {
	// 	port = '1';
	// } else if (domain == 'm.globevisa.com') {
	// 	port = '2';
	// } else if (domain == 'www.globevisa.com') {
	// 	port = '3';
	// }

	// var sendurl = top.location.href;
	// // 实例 onerror
	// ws.onerror = function (evt, e) {
	// 	restartConnect(socketUrl);
	// }
	// ws.onopen = function (event) {
	// 	console.log("客户端已连接上!");
	// 	var isset = sendurl.indexOf("#");
	// 	if (isset != '-1') {
	// 		var from = location.href.split('#');
	// 		if (from[1] == '') {
	// 			from = '';
	// 		} else {
	// 			from = from[1];
	// 		}
	// 	} else {
	// 		var from = '';
	// 	}
	// 	var yxgjObj = document.getElementById("yxgj_");
	// 	var ymmdObj = document.getElementById("ymmd_");
	// 	if (yxgjObj == null) {
	// 		yxgj = "";
	// 	} else {
	// 		if (yxgjObj.value == '') {
	// 			yxgj = "";
	// 		} else {
	// 			yxgj = yxgjObj.value;
	// 		}
	// 	}
	// 	if (ymmdObj == null) {
	// 		ymmd = "";
	// 	} else {
	// 		if (ymmdObj.value == '') {
	// 			ymmd = "";
	// 		} else {
	// 			ymmd = ymmdObj.value;
	// 		}
	// 	}
	// 	var titleArr = document.getElementsByTagName("title"),
	// 		keywordsArr = document.getElementsByName("keywords"),
	// 		descriptionArr = document.getElementsByName("description");
	// 	var title = '', keywords = '', description = '', mqCookieArr = '';
	// 	if (titleArr.length == 0) {
	// 		title = "";
	// 	} else {
	// 		if (titleArr[0].innerHTML == '') {
	// 			title = "";
	// 		} else {
	// 			title = titleArr[0].innerHTML;
	// 		}
	// 	}
	// 	if (keywordsArr.length == 0) {
	// 		keywords = "";
	// 	} else {
	// 		if (keywordsArr[0].content == '') {
	// 			keywords = "";
	// 		} else {
	// 			keywords = keywordsArr[0].content;
	// 		}
	// 	}
	// 	if (descriptionArr.length == 0) {
	// 		description = "";
	// 	} else {
	// 		if (descriptionArr[0].content == '') {
	// 			description = "";
	// 		} else {
	// 			description = descriptionArr[0].content;
	// 		}
	// 	}
	// 	var phone = getCookie('phone')
	// 	if (!getCookie('cookieID')) {
	// 		setCookie('cookieID', $.md5(parseInt(Math.random() * 8999 + 1000, 10) + Math.round(new Date().getTime() / 1000).toString() + parseInt(Math.random() * 10)), 0);
	// 	}
	// 	var cookieID = getCookie('cookieID')
	// 	if (phone == undefined) {
	// 		phone = '';
	// 	}
	// 	var senddata = '',
	// 		link = base64encode(sendurl),
	// 		history = base64encode(document.referrer),
	// 		cookie_id = cookieID,
	// 		tel = phone,
	// 		from = from,
	// 		yxgj = yxgj,
	// 		modular = $('#F_M').val(),
	// 		controller = $('#F_C').val(),
	// 		action = $('#F_A').val(),
	// 		param = $('#F_PARAM').val(),
	// 		ymmd = ymmd;
	// 	senddata += 'VISIT-LINK:' + link + '\n';
	// 	senddata += 'VISIT-HISTORY:' + history + '\n';
	// 	senddata += 'VISIT-COODIEID:' + cookie_id + '\n';
	// 	senddata += 'VISIT-TEL:' + tel + '\n';
	// 	senddata += 'VISIT-PORT:' + port + '\n';
	// 	senddata += 'VISIT-FORM:' + from + '\n';
	// 	senddata += 'VISIT-YXGJ:' + yxgj + '\n';
	// 	senddata += 'VISIT-YMMD:' + ymmd + '\n';
	// 	senddata += 'VISIT-MODULAR:' + modular + '\n';
	// 	senddata += 'VISIT-CONTROLLER:' + controller + '\n';
	// 	senddata += 'VISIT-ACTION:' + action + '\n';
	// 	senddata += 'VISIT-PARAM:' + param + '\n';
	// 	senddata += 'VISIT-TITLE:' + title + '\n';
	// 	senddata += 'VISIT-KEYWORDS:' + keywords + '\n';
	// 	senddata += 'VISIT-DESC:' + description + '\n';

	// 	ws.send(senddata);
	// };
	// ws.onmessage = function (event) {
	// 	var msgHot = eval("(" + event.data + ")");
	// 	if (msgHot.code == '10001') {
	// 		$('#F_CLIENT_ID').val(msgHot.data['client_id'])
	// 		$('#F_CLIENT_IP').val(msgHot.data['client_ip'])
	// 	}
	// }
	// var heartbeat = setInterval(
	// 	function () {
	// 		var readyState = ws.readyState;
	// 		if (readyState != 1) {
	// 			restartConnect(socketUrl);
	// 		} else {
	// 			sendsooket(port)
	// 		}
	// 	}, '2000');
	// ws.onclose = function (event) {
	// 	console.log('连接也关闭')
	// 	//清除定时器
	// 	clearInterval(heartbeat)
	// };
	// function restartConnect(socketUrl) {
	// 	if (socketLock) {
	// 		return;
	// 	}
	// 	console.log('connect again');
	// 	socketLock = true;

	// 	// 避免重复请求
	// 	setTimeout(function () {
	// 		ws = new WebSocket(socketUrl);
	// 		socketLock = false;
	// 	}, 3000);
	// }
	// function sendsooket(port) {
	// 	var RETRY_T = $('#RETRY_T').val();
	// 	if (RETRY_T <= 120) {
	// 		var sendurl = top.location.href;
	// 		var depth = '';
	// 		var CLIENT_ID = $('#F_CLIENT_ID').val();
	// 		var DEPTH_Y = $('#DEPTH_Y').val();
	// 		var DEPTH_T = $('#DEPTH_T').val();
	// 		var REQUEST = 'updateDepth';
	// 		var link = base64encode(sendurl);
	// 		depth += 'VISIT-DEPTH_Y:' + DEPTH_Y + '\n';
	// 		depth += 'VISIT-DEPTH_T:' + DEPTH_T + '\n';
	// 		depth += 'VISIT-CLIENT_ID:' + CLIENT_ID + '\n';
	// 		depth += 'VISIT-REQUEST:' + REQUEST + '\n';
	// 		depth += 'VISIT-LINK:' + link + '\n';
	// 		depth += 'VISIT-PORT:' + port + '\n';
	// 		ws.send(depth);
	// 		$('#RETRY_T').val(Number(RETRY_T) + Number(1));
	// 	}
	// }

	$('#DEPTH_T').val(document.scrollingElement.scrollHeight);
	preventTir()
	function preventTir() {
		var btn = $(document);
		// 赋予事件
		btn.scroll(function (event) {
			if (event.originalEvent) {
				// 用户点击的
				$('#DEPTH_Y').val(document.scrollingElement.scrollTop);
				$('#RETRY_T').val(0);
			} else {
				// JS代码调的
			}
		});
	}

});
function recordUserAction(type, tel, formTitle) {

	//点击美洽回调
	if (type == 2) {
		var client_id_new = $('#F_CLIENT_ID').val();
		var client_ip_new = $('#F_CLIENT_IP').val();
		$.post('https://cloud.huanqiuyimin.com/data/api/pushData', { type: type, client_id: client_id_new, client_ip: client_ip_new }, function (msg) {
			console.log(msg);
		});
	}
}

