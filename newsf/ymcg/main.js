/* 生成系统变量 1*/
var S_Query = {},
	cookieTime = 7200,
	ApiUrl = 'https://restful.huanqiuyimin.com',//',//接口地址
	BaseUrl = 'https://www.globevisa.com.cn',//接口地址
	S_lang = 'zh',
	S_domain = window.location.host.substring(parseInt(window.location.host.indexOf('.')) + 1),
	S_Msg = {
		zh:{
			name:'请填写用户姓名！',
			tel:'请填写手机号！',
			repeat:'请勿重复提交！',
			codeAndTel:'所在地区和手机号不匹配！',
			pwd:'请输入手机验证码！',
			pwdError:'手机验证码错误！',
			pwdSend:'验证码已发送到您的手机，请注意查收！',
			captcha:'请输入图形验证码！',
			captchaError:'图形验证码错误！',
		},
		en:{
			name:'Please Enter Your Name',
			tel:'Please enter your telephone number.',
			repeat:'Please Do not submit again!',
			codeAndTel:'Error: location and contact number are incorrect',
			pwd:'请输入手机验证码！en	',
			pwdError:'手机验证码错误！en',
			pwdSend:'验证码已发送到您的手机，请注意查收！en',
			captcha:'请输入图形验证码！en',
			captchaError:'图形验证码错误！en',
		}
	};
S_Query.ThisPage = window.location.href;//当前页面
S_Query.ThisHost = window.location.host;//当前网站
S_Query.Upper_Page = document.referrer;//提交上级页面
S_Query.JsParam = window.location.hash;//#后参数 需要截取开头的#
S_Query.PageTop = 0;//提交页面时，距离页面顶部位置，后期可以在统计中直接定位表单位置;
S_Query.StayTime = 0;//停留时间初始
S_Query.Source = 0;//来源
S_Query.titleName = document.title;
S_Query.PageM = document.getElementById('F_M').value;
S_Query.PageC = document.getElementById('F_C').value;
S_Query.PageA = document.getElementById('F_A').value;
S_Query.PageParam = document.getElementById('F_PARAM').value;
S_Query.type = document.getElementById('domain').getAttribute('domain');
S_Query.timestamp = signature.split(',')[0];
S_Query.nonce = signature.split(',')[1];
S_Query.signature = signature.split(',')[2];
S_Query.userAgent = window.navigator.userAgent || '';
S_Query.companyID = '';

if ($(".c_key #changeAdvisor.fifth-module").length>0){
	$(".c_key #changeAdvisor.fifth-module").hide();
}

// if (window.location.hash != '') {
// 	if(window.location.hash.substring(1) == 'dylan' && getCookie('dylan') == ''){
// 		setCookie('dylan',window.location.hash.substring(1),10);
// 	}
// 	if (getCookie('dylan') != '') {
// 		$("a").click(function() {
// 			if ($(this).attr('href').indexOf('javascript') === -1 && getCookie('dylan') != '') {
// 				$(this).attr('href',$(this).attr('href') +'#' +getCookie('dylan'))
// 			}
// 		})
// 	}
// }
//着陆页
if (S_Query.Upper_Page == '' || S_Query.Upper_Page.indexOf(S_Query.ThisHost) == -1) {
	setCookie('landing_page', S_Query.ThisPage, cookieTime);
}
// 为百度增加bd_vid 区分渠道是百度
if (S_Query.ThisPage.indexOf('bd_vid') > -1) {
	setCookie('bd_vid',1,cookieTime);
	setCookie('bd_vid_href', S_Query.ThisPage, cookieTime);
}
if(S_Query.JsParam !== ''){
	S_Query.JsParam = S_Query.JsParam.substring(1);
	// 国内推广
	if(S_Query.JsParam.indexOf('-') > -1 && S_Query.JsParam.split('-')[3] != undefined && (S_Query.JsParam.split('-')[3].indexOf('pc') > -1 || S_Query.JsParam.split('-')[3].indexOf('mo') > -1 )){
		var source = S_Query.JsParam.split('-')[0];
		if(!getCookie('Qudao')){
			setCookie('Qudao',source,cookieTime);
			setCookie('bdUrl',S_Query.ThisPage,cookieTime);
			setCookie('bd0',S_Query.JsParam.split('-')[0],cookieTime);
			setCookie('bd1',S_Query.JsParam.split('-')[1],cookieTime);
			setCookie('bd2',S_Query.JsParam.split('-')[2],cookieTime);
			setCookie('T_time',parseInt(Math.round(new Date().getTime()/1000).toString()),cookieTime);
		}
	}else{
		var source = S_Query.JsParam;
	}
	S_Query.Source = source;


	// 国外推广
	if (S_Query.JsParam.indexOf('-') > -1 && S_Query.JsParam.split('-')[4] != undefined && (S_Query.JsParam.split('-')[4] == 'pc' || S_Query.JsParam.split('-')[4] == 'mo')) {
		S_Query.Source = S_Query.JsParam.split('-')[0];
		if(!getCookie('Qudao')){
			setCookie('Qudao',S_Query.Source,cookieTime);
		}
		setCookie('GoogleUrl',S_Query.ThisPage,cookieTime);
		setCookie('google_ckjihua',S_Query.JsParam.split('-')[0],cookieTime);
		setCookie('google_ckzu',S_Query.JsParam.split('-')[1],cookieTime);
		setCookie('google_ckid',S_Query.JsParam.split('-')[2],cookieTime);
		setCookie('google_ckwfrom',S_Query.JsParam.split('-')[3],cookieTime);
		setCookie('google_ckweb',S_Query.JsParam.split('-')[4],cookieTime);
		setCookie('T_time',parseInt(Math.round(new Date().getTime()/1000).toString()),cookieTime);
	}

}else if(getQueryString('from')){
	var from = getQueryString('from');
	if (from.indexOf('#') > -1) {
		var fromParam = from.split('#')[1];
		// 国内推广
		if(fromParam.indexOf('-') > -1 && (fromParam.split('-')[3].indexOf('pc') > -1 || fromParam.split('-')[3].indexOf('mo') > -1 )){
			var source = fromParam.split('-')[0];
			if(!getCookie('Qudao')){
				setCookie('Qudao',source,cookieTime);
				setCookie('bdUrl',S_Query.ThisPage,cookieTime);
				setCookie('bd0',fromParam.split('-')[0],cookieTime);
				setCookie('bd1',fromParam.split('-')[1],cookieTime);
				setCookie('bd2',fromParam.split('-')[2],cookieTime);
				setCookie('T_time',parseInt(Math.round(new Date().getTime()/1000).toString()),cookieTime);
			}
		}else{
			var source = fromParam;
		}
		S_Query.Source = source;
	}
}
//判断当前运行环境
getEnv(true);
getWxEnv(true);

//15分钟内追加推广链接
//$("a").click(function (event) {
$("body").on('click', 'a[href]', function (event) {
	if ($(this).attr('href') !== undefined && $(this).attr('href').indexOf('javascript') === -1 && $(this).attr('href').indexOf('tel:') === -1 && $(this).attr('href').indexOf('mailto:') === -1) {
		var port = 'pc';
		if (['1', '2', '33', '35'].indexOf(S_Query.type) > -1) {
			port = 'mo';
		}
		if (getCookie('bd0') && getCookie('bd1') && getCookie('bd2')) {
			if($(this).attr('href').indexOf('#') !== -1){
				$(this).attr('href',$(this).attr('href').substring(0,$(this).attr('href').indexOf('#')) + '#' + getCookie('bd0') + '-' + getCookie('bd1') + '-' + getCookie('bd2') + '-' +  port);
			}else{
				$(this).attr('href',$(this).attr('href') + '#' + getCookie('bd0') + '-' + getCookie('bd1') + '-' + getCookie('bd2') + '-' +  port);
			}
		}else if (getCookie('google_ckjihua') && getCookie('google_ckzu') && getCookie('google_ckid') && getCookie('google_ckwfrom') && getCookie('google_ckweb')){
			if($(this).attr('href').indexOf('#') !== -1){
				$(this).attr('href',$(this).attr('href').substring(0,$(this).attr('href').indexOf('#')) + '#' + getCookie('google_ckjihua') + '-' + getCookie('google_ckzu') + '-' + getCookie('google_ckid') + '-' +  getCookie('google_ckwfrom') + '-' +getCookie('google_ckweb'));
			}else{
				$(this).attr('href',$(this).attr('href') + '#' + getCookie('google_ckjihua') + '-' + getCookie('google_ckzu') + '-' + getCookie('google_ckid') + '-' +  getCookie('google_ckwfrom') + '-' +getCookie('google_ckweb'));
			}
		}else if(window.location.href.indexOf('#') !== -1){
			if($(this).attr('href').indexOf('#') !== -1){
				$(this).attr('href',$(this).attr('href').substring(0,$(this).attr('href').indexOf('#')) + window.location.hash);
			}else{
				$(this).attr('href',$(this).attr('href') + window.location.hash);
			}
		}

		if (S_Query.Env == 'bdxcx') {
			if ($(this).attr('href').toLowerCase().startsWith('/chat') || $(this).attr('href').toLowerCase().indexOf('//static.meiqia.com/') > 0) {
				if (typeof _MEIQIA == 'function') { _MEIQIA('showPanel'); }
				event.preventDefault(); return;
			} else if (typeof redirect_bdxcx == 'function' && redirect_bdxcx($(this))){
				event.preventDefault(); return;
			}
		}

		//微信小程序
		if (S_Query.Env == 'hqcgwxxcx') {
			if ($(this).attr('href').toLowerCase().startsWith('/chat') || $(this).attr('href').toLowerCase().indexOf('//static.meiqia.com/') > 0) {
				if (typeof _MEIQIA == 'function') { _MEIQIA('showPanel'); }
				event.preventDefault(); return;
			} else if (typeof redirect_wxxcx == 'function' && redirect_wxxcx($(this))){
				event.preventDefault(); return;
			}
		}
	}else if($(this).attr('href') != undefined && ($(this).attr('href').indexOf('javascript') !== -1 || $(this).attr('href').indexOf('JavaScript') !== -1)){
		// 解决target打开新页面问题
		$(this).removeAttr('target');
	}
})
// 判断是否存在验证码，并初始化验证码
if($('#captcha').length >= 1){
	var verifyCode = new GVerify({
			id:"captcha",
			type:"number"
	});
}
// 调整备案
if($(".foot-bottom .beian").length >= 1){
	var _host = window.location.host;
	if (_host == 'www.globevisa.com.cn') {
		$(".foot-bottom .beian").html('<a href="https://beian.miit.gov.cn/">粤ICP备19150180号</a>');
	}else if(_host == 'www.globevisa.cn'){
		$(".foot-bottom .beian").html('京公境准字【2012】0036号 <a href="https://beian.miit.gov.cn/">京ICP备08008969 </a>京公网安备11010502007594');
	}else{
		$(".foot-bottom .beian").hide();
	}
}

//页面加载动态
// 	console.log(document.readyState)
document.onreadystatechange = function(){
	if(document.readyState === 'complete'){//页面加载完成
		//赋值当前高度
		S_Query.PageTop = document.body.scrollTop;
		//执行计时
		Stay_Time_Load();
		// 设置语言
		SiteLang();
		// 判断是否登录
		isLogin();
		// 加载美恰必须的city判断
		setCompanyID();
		// 滚动加载当前地区顾问图片资源
		gwScroll();
		if($("[name = 'yxgj']").length >= 1){
			// 国家选择赋值
			setCountrys();
		}
		if($("[name = 'countrycode']").length >= 1){
			// 国家选择赋值
			setSheets();
		}
		if($("[name = 'countrycode_test']").length >= 1){
			// 测试国编
			console.log('可以不走吗')
			setSheets_test();
		}
		if($("[name = 'countrycodes']").length >= 1){
			// 国家选择赋值
			console.log('走了')
			setSheetss();
		}
		if ($(".gfc_cp_main_countrys").length >= 1) {
			setCostCountry();
		}
		if ($("#SSGS").length >= 1 || $("#windows_comanySelect").length >= 1 || $("#uCompany").length >= 1 || $("#windows_comanySelect_mo").length >= 1) {
			getCompanyAll();
		}
	}
}
//监听滚动
window.onscroll = function(){
	S_Query.PageTop = document.body.scrollTop;
}
//停留时间监听时间
function Stay_Time_Load(){
	setTimeout(function() {
		S_Query.StayTime ++;
		Stay_Time_Load();
	},1000);
}
// 获取所有分公司
function getCompanyAll() {
	var _url = ApiUrl + "/Web/existCompanyAll?type="+S_Query.type;
	$.getJSON(_url,function(msg) {
		if (msg.ret == 200) {
			var _data = msg.data,
				_ssgs_gn = '',
				_ssgs_hw = '',
				_ssgs_all = '';
			for (var i = 0; i < _data.length; i++) {
				if (_data[i].isHome == 1) {
					_ssgs_gn += "<li value='"+_data[i].SSGS+"'>"+_data[i].name+"</li>";
				}else{
					_ssgs_hw += "<li value='"+_data[i].SSGS+"'>"+_data[i].name+"</li>";
				}
				_ssgs_all += '<option value="'+_data[i].SSGS+'">'+_data[i].name+'</option>';
			}
			// if (_ssgs_gn) {
				$("#SSGS .ssgs_gn,#windows_comanySelect .ssgs_gn,#windows_comanySelect_mo .ssgs_gn").html(_ssgs_gn);
			// }else{
			// 	$("#SSGS .ssgs_gn,#windows_comanySelect .ssgs_gn,#SSGS .line,#SSGS>p:nth-of-type(1),#windows_comanySelect p:nth-of-type(1),#windows_comanySelect_mo p:nth-of-type(1)").hide();
			// 	$("#SSGS>p:nth-of-type(2)").css({'float':'none'})
			// }
			// if (_ssgs_hw) {
				$("#SSGS .ssgs_hw,#windows_comanySelect .ssgs_hw,#windows_comanySelect_mo .ssgs_hw").html(_ssgs_hw);
			// }else{
			// 	$("#SSGS .ssgs_hw,#windows_comanySelect .ssgs_hw,#SSGS .line,#SSGS>p:nth-of-type(2),#windows_comanySelect p:nth-of-type(2),#windows_comanySelect_mo p:nth-of-type(1)").hide();
			// 	$("#SSGS>p:nth-of-type(1)").css({'float':'none'})
			// }
			if ($("#uCompany").length >= 1 && _ssgs_all != '') {
				_ssgs_all = '<option value="">请选择</option>' + _ssgs_all;
				$("#uCompany").empty();
				$("#uCompany").html(_ssgs_all);
			}
	        $(".company_info .info_close").unbind('click').click(function() {
	        	$(this).parents(".company_info").slideUp();
	        })
	       	$(".company_info .info_middle ul li").unbind('click').click(function() {
	        	$(this).parents(".company_info").slideUp();
	        	var _text = $(this).html();
	        	$(this).parents(".company_info").prev(".sel_company").html('' + _text);
	        	$(this).parents(".company_info").find("[name = 'SSGS']").val($(this).attr('value'));
				$(this).parents(".company_info").find("[name = 'SSGSSS']").val($(this).html());
	       	})
	        $(".sel_company").unbind('click').click(function() {
	        	$(this).next(".company_info").slideToggle();
	        })
	        $("#windows_comanySelect ul li,#windows_comanySelect_mo ul li").unbind('click').click(function() {
				$("#windows_comanySelect ul li,#windows_comanySelect_mo ul li").removeClass('on');
				$(this).addClass('on');
				$("#windows_comanySelect [name = 'SSGS'],#windows_comanySelect_mo [name = 'SSGS']").val($(this).attr('value'))
			})
		}else{
			layer.msg('公司获取失败');
		}
	});
}
// 费用计算器
function setCostCountry() {
	var _url = ApiUrl + "/Project/getCountryProjects";
	$.getJSON(_url,function(msg) {
		if (msg.ret == 200) {
			var _countryHtml = '',
				_projectHtml = '';
			$.each(msg.data, function(i) {
				_countryHtml += "<dd name='c_"+msg.data[i].id+"' class='clearfix'><em></em><span>"+msg.data[i].name+"</span></dd>";
				_projectHtml += "<dl name='c_"+msg.data[i].id+"'>";
				if(msg.data[i]._child != undefined){
					$.each(msg.data[i]._child,function(j) {
						_projectHtml += "<dd id='erp_"+msg.data[i]._child[j].erpID+"'>"+msg.data[i]._child[j].projectName+"</dd>";
					})
				}
				_projectHtml += "</dl>";
			});
			$(".gfc_cp_main_countrys").html(_countryHtml);
			$(".gfc_cp_main_project").html(_projectHtml);
		}
	})
}
/**
 * 检测手机号
 */
function matchTel(formData){
	console.log(formData);
	//当手机号前两位是00的时候，说明手机号带国编了，需要去除国编
	if(formData.tel.substring(0,4) !== '0086'){
		if(formData.tel.substring(0,2) === '00'){
			$("[name = 'countrycode']").children('option').each(function(){
				if(formData.tel.substring(0,$(this).val().length) == $(this).val()){
					$(this).attr('selected','selected');
					formData.countrycode = $(this).val();
					formData.regular = $(this).attr('regular');
				}
			});
		}
	}else{
		formData.tel = formData.tel.substring(4);
	}
	if(formData.countrycode !== '0086'){
		if(formData.tel.indexOf(formData.countrycode) === -1){
			formData.tel = formData.countrycode + formData.tel;
			// formData.tel =  formData.tel
		}
	}
	var telMatch= eval("/^" + formData.regular + "$/");
	if(!telMatch.test(formData.tel)){
		return false;
	}else{
		return true;
	}
}
//设置语言
function SiteLang(){
	var S_domain='';
	switch(parseInt(S_Query.type)){
		case 0:
		case 1:
		case 2:
				S_lang = 'zh';
				//document.domain = S_domain;
			break;
		case 5:
		case 6:
			//	document.domain = S_domain;
				S_lang = 'zh';
			break;
		case 7:
		case 8:
				document.domain = S_domain;
				S_lang = 'en';
			break;
		default:
				document.domain = S_domain;
				S_lang = 'zh';
			break;
	}
	//同时检测是否有cookieID，没有则设置
	if(!getCookie('cookieID')){
		setCookie('cookieID',$.md5(parseInt(Math.random()*8999 + 1000,10) + Math.round(new Date().getTime()/1000).toString() + parseInt(Math.random()*10)),0);
	}
	if ($("#window_top_menu").length >= 1) {
		$("#window_top_menu .menus_list li").each(function() {
			if (parseInt(S_Query.type) == 6) {
				_hide = 'zh';
			}else{
				_hide = 'cn';
			}
			if ($(this).find('a').hasClass(_hide)) {
				$(this).remove();
			}
		})
	}
}
/*
	获取验证码
	formData  表单内容
	$_obj   点击对象
	$_countTimer   多少M之后可再次点击
	$_str    可点击时话术
*/
function RequestPwd(formData,$_obj, $_countTimer, $_str, $_action = 'requestPwd'){
	var action = formData.action;
	$_countTimer = $_countTimer || 60 ;
	$_str = $_str || '点击发送密码' ;
	formData.action = $_action;
	if (formData.type == '10') {
		formData.sharing = shareUsrLogin;
	}
	$.post(ApiUrl + "/Form/WebSiteUnifySubmitMethods",formData,function(msg){
		if(msg.ret == 200){
			layer.msg(S_Msg[S_lang].pwdSend);
			SetTimeOut($_obj, $_countTimer, $_str);
			sendErp(msg.data.id);
		}

	},'json')
	formData.action = action;
}
function toWindows(_id,formData,$_obj, _action = '', _sms = ''){
	if (_action != '' && _action != undefined) {
		$("#"+_id).find("[name = 'action']").val(_action);
	}
	if (_sms != '' && _sms != undefined) {
		$("#"+_id).find(".get_sms").attr('window_action',_sms);
	}
	if (_id == 'contract_window' || _id == 'contract_window_mo') {
		// 记录点击次数
		var _sub = {};
			_sub.projectID = $_obj.attr('data-value');
			_sub.type = formData.type;
			_sub.timestamp = signature.split(',')[0];
			_sub.nonce = signature.split(',')[1];
			_sub.signature = signature.split(',')[2];
		$.post(ApiUrl + '/Form/recordClick',_sub,function(msg){
		})
	}
	if (!getCookie('phone')) {
		if (_id == 'contract_window') {
			var loadContract = layer.open({
	            type: 1,
	            shade: [0.3, '#000000'],
	            title: false,
	            content: $('#contract_window'),
	            shadeClose:true,
	            closeBtn: 0,
	            area: ['auto', 'auto']
	        })
		}else if(_id == 'contract_window_ceshia'){
			var loadContract = layer.open({
	            type: 1,
	            shade: [0.3, '#000000'],
	            title: false,
	            content: $('#contract_window'),
	            shadeClose:true,
	            closeBtn: 0,
	            area:['563px', '360px']
	        })
		}else if(_id == 'contract_window_mo'){
			var loadContract = layer.open({
	            type: 1,
	            shade: [0.3, '#000000'],
	            title: false,
	            content: $('#contract_window_mo'),
	            shadeClose:true,
	            closeBtn: 0,
	            area:['calc(640rem/72)', 'auto']
	        })
		}else if(_id == 'passport_windows'){
			if (_action == 'passport_info' || _action == 'passport_contrast') {
	            var _addPass1 = $("[name = 'addPass1']").val(),
					_addPass2 = $("[name = 'addPass2']").val();
					_addPass3=$("[name = 'addPass3']").val();
	            if(_addPass1 == '' && _addPass2 == '' && _addPass3 == ''){
	                layer.msg("请选择对比护照！");
	                return false;
				}
				ids_str_merge(_addPass1,_addPass2,_addPass3);
			}else if(_action == 'passport_index' || _action == 'passport_my'){
				var i=$('select[name=invest]').val();
	            var f=$('select[name=family]').val();
	            var c=$('select[name=cycle]').val();
	            if(i==0&&f==0&&c==0){
	                layer.msg("请至少选择一项条件");
	                return false;
	            }
	            ifc_str_merge(i,f,c);
			}else if(_action == 'passport_info_fold'){
				var a=$("[name = 'id']").val();
				var b=$("[name = 'kind']").val();
				if(a == '' && b == ''){
					layer.msg("请提交");
					return false;
				}
				iff_str_merge(a,b);
			}else if(_action == 'passport_contrast_fold' || _action == 'passport_my_down'){
				var a = $_obj.parents('li').find("[name = 'id']").val();
				var b=$("[name = 'kind']").val();
				iff_str_merge(a,b);
			}else if(_action=='project_contract'){
				var b=$("[name = 'constractpro']").val();
				constrct_str_merge(b);
			}
			$("#passport_windows").show();
		}
		return false;
	}else{
		if(_id == 'passport_windows'){
      if (_action == 'passport_info' ||  _action == 'passport_contrast') {
				var _addPass1 = $("[name = 'addPass1']").val(),
				_addPass2 = $("[name = 'addPass2']").val();
				_addPass3=$("[name = 'addPass3']").val();
				if(_addPass1 == '' && _addPass2 == '' && _addPass3 == ''){
					layer.msg("请选择对比护照！");
					return false;
				}
				ids_str_merge(_addPass1,_addPass2,_addPass3);
			}else if(_action == 'passport_index' || _action == 'passport_my'){
				var i=$('select[name=invest]').val();
	            var f=$('select[name=family]').val();
	            var c=$('select[name=cycle]').val();
	            if(i==0&&f==0&&c==0){
	                layer.msg("请至少选择一项条件");
	                return false;
	            }
	            ifc_str_merge(i,f,c);
			}else if(_action == 'passport_contrast'){
				var _addPass1 = $("[name = 'addPass1']").val(),
				_addPass2 = $("[name = 'addPass2']").val();
				_addPass3=$("[name = 'addPass3']").val();
				if(_addPass1 == '' && _addPass2 == '' && _addPass3 == ''){
					layer.msg("请选择对比护照！");
					return false;
				}
				ids_str_merge(_addPass1,_addPass2,_addPass3);
			}else if(_action == 'passport_info_fold'){
				var a=$("[name = 'id']").val();
				var b=$("[name = 'kind']").val();
				if(a == '' && b == ''){
					layer.msg("请提交");
					return false;
				}
				iff_str_merge(a,b);
			}else if(_action == 'passport_contrast_fold' || _action == 'passport_my_down'){
				var a = $_obj.parents('li').find("[name = 'id']").val();
				var b=$("[name = 'kind']").val();
				iff_str_merge(a,b);
			}else if(_action=='project_contract'){
				var b=$("[name = 'constractpro']").val();
				constrct_str_merge(b);
			}
    }
		$("#"+_id).find('.ajaxBtn').click();
	}
}
function constrct_str_merge(b){
	var param="id="+b;
	$("#passport_windows").find("[name = 'fold']").val(param);
}
function iff_str_merge(a,b){
	var param="id="+a+ "&type="+b;
	$("#passport_windows").find("[name = 'fold']").val(param);
}
function ids_str_merge(a,b,c){
	var _addPass1 = a,
		_addPass2 = b,
		_addPass3=c;
        _ids = '';
        if (_addPass1 != '') {
            _ids += _addPass1 + ','
        }
        if (_addPass2 != '') {
            _ids += _addPass2 + ','
		}
		if (_addPass3 != '') {
            _ids += _addPass3 + ','
		}
		_ids = _ids.substring(0, _ids.length - 1);
        $("#passport_windows").find("[name = 'ids']").val(_ids);
}
function ifc_str_merge(i,f,c){
	var param="i="+i+ "&f="+f+"&c="+c;
	$("#passport_windows").find("[name = 'ifc']").val(param);
}
/* 倒计时 */
function SetTimeOut($_obj, $_countTimer, $_str) {
	if ($_countTimer === 1) {
		$_obj.attr("disabled", false).val($_str);
		$_countTimer = 60;
		return;
	} else {
		$_obj.attr("disabled", true).val($_countTimer + 's后再次获取');
		$_countTimer--;
	}
	setTimeout(function() {
			SetTimeOut($_obj, $_countTimer, $_str)
	}, 1000)
	// if($_obj.hasClass('tc') && $_countTimer==50){
	// 	$("#window-modal-tcVer .close_btn").show();
	// 	$(".close_window").show();
	// }
}
/* 是否登录信息 */
function isLogin(){
	// if (getCookie("CurEnv") == 'bdxcx') { //FIXME test
	// 	delCookie('phone');
	// }
	if(getCookie('phone')){
		//如果是登录页面，跳转
		if(S_Query.PageM == 'globevisapc' && S_Query.PageC == 'Login'){
			top.location.href = getQueryString('from');
		}
		$(".uwelcome,.uperson,.uout").show();
		$(".uwelcome a").html("您好，" + $.trim(getCookie('phone')).substr(0, 3) + '****' + $.trim(getCookie('phone')).substring(7, 11))
		$(".PopupHidUserName,.PopupHidTel1,.PopupHidTel2,.uperson").hide();
		$("[name = 'tel']").val($.trim(getCookie('phone')));
		$("[name = 'pwd']").attr('name','');
		$.post(ApiUrl + '/Form/getCustomer',{ tel : $.trim(getCookie('phone')),timestamp : S_Query.timestamp,nonce : S_Query.nonce,signature : S_Query.signature},function(msg){
			// if(msg.ret == 200 && msg.data.countrycode != undefined){
			if(msg.ret == 200){
				$("[name = 'userName']").val(msg.data.userName);
				if(msg.data.tel.substring(0,2) === '00'){
					$("[name = 'countrycode']").children('option').each(function(){
						if(msg.data.tel.substring(0,$(this).val().length) == $(this).val()){
							$(this).attr('selected','selected');
						}
					});
				}else{

					console.log(123321456);

					$("[name = 'countrycode']").children('option').each(function(){
						if(msg.data.countrycode == $(this).val()){
							$(this).attr('selected','selected');
						}
					});
				}
			}else{
				loginout();
			}
		},'json')
	}else{
		//未登录
		$(".ulogin,.ureg").show();
	}
}
/* 注册方法 */
function register(){
	// var _url = window.location.href;
	// if(_url.indexOf('login.html') != '-1'){
	// 	if(_url.indexOf('type=reg') == '-1'){
	// 		window.location.href = _url.replace('type=login','type=reg');return false;
	// 	}else{
	// 		window.location.reload();
	// 	}
	// }else{
	// 	window.location.href = "/login.html?type=reg&from="+escape(_url);
		// window.location.href = "https://www.globevisa.com.cn/vip/login.html?type=reg";
	// }
	if (getCookie('bd0') && getCookie('bd1') && getCookie('bd2')) {
		window.location.href = "https://www.globevisa.com.cn/vip/login.html?type=reg#" + getCookie('bd0') + '-' + getCookie('bd1') + '-' + getCookie('bd2') + '-pc';
	}else{
		window.location.href = "https://www.globevisa.com.cn/vip/login.html?type=reg";
	}
}
/* 登录方法 */
function login(){
	// var _url = window.location.href;
	// if(_url.indexOf('login.html') != '-1'){
	// 	if(_url.indexOf('type=login') == '-1'){
	// 		window.location.href = _url.replace('type=reg','type=login');return false;
	// 	}else{
	// 		window.location.reload();
	// 	}
	// }else{
	// 	window.location.href = "/login.html?type=login&from="+escape(_url);
	// }
	if (getCookie('bd0') && getCookie('bd1') && getCookie('bd2')) {
		window.location.href = "https://www.globevisa.com.cn/vip/login.html#" + getCookie('bd0') + '-' + getCookie('bd1') + '-' + getCookie('bd2') + '-pc';
	}else{
		window.location.href = "https://www.globevisa.com.cn/vip/login.html";
	}
}
/* 退出登录 */
function loginout(){
	var _url=top.location.href;
	if(_url.indexOf('type=login') != '-1' || _url.indexOf('type=reg') != '-1'){
		_url = window.location.origin;
	}
	//if(confirm("确认退出？退出后不会影响到您对项目的浏览，但无法查看之前的评估结果，若您需要可重新登录。")){
		delCookie('phone');
		top.location.href = _url;
		/* $.get('https://www.globevisa.com.cn/api/api/loginOut',{},function(ret){
			top.location.href = _url;
		}) */
	//}
}
/*
	国家选择框赋值
*/
function setCountrys(){
	var _url = ApiUrl + "/Web/GetCountrys";
	$.getJSON(_url,function(msg) {
		if (msg.ret == 200) {
			var html = "<option value=''>请选择意向国家和地区</option>";
			$.each(msg.data, function(i, field){
				html += "<option value='"+field.id+"'>"+field.name+"</option>";
		    });
			$("select[name = 'yxgj']").html(html);
		}
	})
}
// 国编
function setSheets() {
	var _url = ApiUrl + "/Web/GetSheets";
	$.getJSON(_url,function(msg) {
		if (msg.ret == 200) {
			var html = "";
			$.each(msg.data, function(i, field){
				if ((S_Query.type == 5 || S_Query.type == 6 || S_Query.type == 7 || S_Query.type == 8) && field.InternationalTel == '65') {
					if (S_Query.type == 7 || S_Query.type == 8) {
						html += "<option value='00" + field.InternationalTel + "' country='"+field.country+"' regular='"+field.regular+"' selected>" + field.full_name + "+" + field.InternationalTel +"</option>";
					}else{
						html += "<option value='00" + field.InternationalTel + "' country='"+field.country+"' regular='"+field.regular+"' selected>" + field.country + "+" + field.InternationalTel +"</option>";
					}
				}else if((S_Query.type == 0 || S_Query.type == 1 || S_Query.type == 2 || S_Query.type == 10) && field.InternationalTel == '86'){
					html += "<option value='00" + field.InternationalTel + "' country='"+field.country+"' regular='"+field.regular+"' selected>" + field.country + "+" + field.InternationalTel +"</option>";
				}else{
					if (S_Query.type == 7 || S_Query.type == 8) {
						html += "<option value='00" + field.InternationalTel + "' country='"+field.country+"' regular='"+field.regular+"'>" + field.full_name + "+" + field.InternationalTel +"</option>";
					}else{
						html += "<option value='00" + field.InternationalTel + "' country='"+field.country+"' regular='"+field.regular+"'>" + field.country + "+" + field.InternationalTel +"</option>";
					}
				}
		    });
			$("select[name = 'countrycode']").html(html);
		}
	})
}


// 国编测试2 augus
/**定义加载国编函数*/
var loadCountry = function(fn){
	var _url = ApiUrl + "/Web/GetSheets";
	$.getJSON(_url,function(msg) {
		if (msg.ret == 200) {
			fn(msg.data)
		}
	})
}
$(function(){
	/**模拟下拉框点击事件*/
	$(".select-i .input-txt,.select-i i").on('click', function (event) {
		var $this = $(this);
		// $this.next(".input-txt").andSelf('.input-txt').each(function () {
		// 	if($this.attr("id") != $(this).attr("id")){
		// 		console.log('点击了下拉框1')
		// 		hideUL($(this))
		// 	}
		// })
		var jt = $this.next(".jt").andSelf('.jt');
		if (jt.hasClass('up')){
			jt.removeClass('up');
			jt.next('ul.ul-select').slideUp().addClass("un-fold");
		}else{
			jt.addClass('up');
			jt.next('ul.ul-select').slideDown().removeClass("un-fold");
		}
		/*阻止冒泡*/
		event.stopPropagation();
	});
	/**当下拉框失去焦点时收起下拉框*/
	$("body").on("click",function () {
		//$('#countryCode').addClass("un-fold");
		// $(".select-i .input-txt").each(function () {
		// 	hideUL($(this));
		// })
		hideUL($('.select-i ul.ul-select:visible'));
	})
	/**下拉列表展开时点击li的事件  项目页只显示编码不显示国家名称*/
	$(".select-i").on("click","ul li",function(){
		var select_ul = $(this).parent("ul.ul-select");
		var select_code = $(this).attr("data-value");
		var select_code_text = $(this).find('strong').text();
		var inputTxt = select_ul.siblings(".input-txt");
		//设置选择值
		if ($('input[name="is_only_show_code"]').val() == 1 || inputTxt.hasClass('onlycode')){
			inputTxt.text('+' + select_code);
		}else{
			inputTxt.text(select_code_text);
		}
		inputTxt.attr("data-value", '00' + select_code);
		$("[name='countrycode']").val('00' + select_code);
		//已选元素添加选中样式
		select_ul.find('strong.selected').removeClass('selected');
		$(this).find('strong').addClass('selected');
		//收起UL下拉框
		hideUL(select_ul);
	});

	/**加载国家*/
	// 精灵图的国旗 <div class="flag-box"><div class="iti-flag ${data[i].abbreviation}"></div></div>

	loadCountry(function(data){
		var html = "";
		var selectOptions='';

		for (var i = 0; i < data.length; i++) {
			html +=
			`<li data-value="${data[i].InternationalTel}">
			<div style="display:inline-block; vertical-align: middle;">
				<img src="${data[i].img}" width="20" alt="">
			</div>
			<strong>${data[i].country}+${data[i].InternationalTel}</strong>
			</li>`;

			var field = data[i];
			if ((S_Query.type == 5 || S_Query.type == 6 || S_Query.type == 7 || S_Query.type == 8) && field.InternationalTel == '65') {
				if (S_Query.type == 7 || S_Query.type == 8) {
					selectOptions += "<option value='00" + field.InternationalTel + "' country='" + field.country + "' regular='" + field.regular + "' selected>" + field.full_name + "+" + field.InternationalTel + "</option>";
				} else {
					selectOptions += "<option value='00" + field.InternationalTel + "' country='" + field.country + "' regular='" + field.regular + "' selected>" + field.country + "+" + field.InternationalTel + "</option>";
				}
			} else if ((S_Query.type == 0 || S_Query.type == 1 || S_Query.type == 2 || S_Query.type == 10) && field.InternationalTel == '86') {
				selectOptions += "<option value='00" + field.InternationalTel + "' country='" + field.country + "' regular='" + field.regular + "' selected>" + field.country + "+" + field.InternationalTel + "</option>";
			} else {
				if (S_Query.type == 7 || S_Query.type == 8) {
					selectOptions += "<option value='00" + field.InternationalTel + "' country='" + field.country + "' regular='" + field.regular + "'>" + field.full_name + "+" + field.InternationalTel + "</option>";
				} else {
					selectOptions += "<option value='00" + field.InternationalTel + "' country='" + field.country + "' regular='" + field.regular + "'>" + field.country + "+" + field.InternationalTel + "</option>";
				}
			}
		}
		$(".select-i ul.ul-select").html(html);

		if ($("select[name = 'countrycode']").length>0){
			$("select[name = 'countrycode']").html(selectOptions);
		} else if ($("input[type='hidden'][name ='countrycode']").length > 0){
			selectOptions = '<select name="countrycode" style="display:none;">' + selectOptions +'</select>';
			$("input[type='hidden'][name ='countrycode']").after(selectOptions).remove();
		}

		if (!isNaN(S_Query.type)){
			if (['0', '1', '2', '10', '33', '35'].indexOf(S_Query.type)>-1){
				$('ul.ul-select li[data-value="86"]').click();
			} else if (['5', '6', '7', '8'].indexOf(S_Query.type) > -1) {
				$('ul.ul-select li[data-value="65"]').click();
			}
		}
	});
});
/**隐藏ul*/
function hideUL(obj) {
	if(obj.prev(".jt").hasClass('up')){
		obj.prev(".jt").removeClass("up");
		obj.slideUp().addClass("un-fold");
	}
}


function setSheets_test() {
	console.log('国编测试2')
	var _url = ApiUrl + "/Web/GetSheets";
	$.getJSON(_url,function(msg) {
		if (msg.ret == 200) {
			var html = "";
			$.each(msg.data, function(i, field){
				if ((S_Query.type == 5 || S_Query.type == 6 || S_Query.type == 7 || S_Query.type == 8) && field.InternationalTel == '65') {
					if (S_Query.type == 7 || S_Query.type == 8) {
						html += `<option value='00${field.InternationalTel}' country='${field.country}' regular='${field.regular}' selected>
						${field.full_name}+${field.InternationalTel}
						</option>`;
					}else{
						html += `<option value='00${field.InternationalTel}' country='${field.country}' regular='${field.regular}' selected>
						${field.country}+${field.InternationalTel}
						</option>`;
					}
				}else if((S_Query.type == 0 || S_Query.type == 1 || S_Query.type == 2 || S_Query.type == 10) && field.InternationalTel == '86'){
					html += `<option value='00${field.InternationalTel}' country='${field.country}' regular='${field.regular}' selected>
					${field.country}+${field.InternationalTel}
					</option>`;
				}else{
					if (S_Query.type == 7 || S_Query.type == 8) {
						html += `<option value='00${field.InternationalTel}' country='${field.country}' regular='${field.regular}'>
						${field.full_name}+${field.InternationalTel}
						</option>`;
					}else{
						html += `<option value='00${field.InternationalTel}' country='${field.country}' regular='${field.regular}'>
						${field.country}+${field.InternationalTel}
						</option>`;
					}
				}
		    });
			$("select[name = 'countrycode_test']").html(html);
		}
	})
}
// 国编测试
function setSheetss() {
	var _url = ApiUrl + "/Web/GetSheets";
	$.getJSON(_url,function(msg) {
		if (msg.ret == 200) {
			var html = "";
			$.each(msg.data, function(i, field){
				console.log('zhi',i,field)
				if ((S_Query.type == 5 || S_Query.type == 6 || S_Query.type == 7 || S_Query.type == 8) && field.InternationalTel == '65') {
					if (S_Query.type == 7 || S_Query.type == 8) {
						html+=`<li value="00${field.InternationalTel}" country="${field.country}" regular="${field.regular}" class="wenzidianji" style="display:flex;margin-bottom: 5px">
							<img style="width:21px;height:15px;margin:0 10px;" src="${field.img}"/>
							<label
								style="color: rgba(73,73,73,0.9);overflow:hidden;white-space:nowrap;font-size: 10px;">${field.full_name}${field.InternationalTel}</label>
						</li>`
					}else{
						html+=`<li value="00${field.InternationalTel}" country="${field.country}" regular="${field.regular}" class="wenzidianji" style="display:flex;margin-bottom: 5px">
							<img style="width:21px;height:15px;margin:0 10px;" src="${field.img}"/>
							<label
								style="color: rgba(73,73,73,0.9);overflow:hidden;white-space:nowrap;font-size: 10px;">${field.full_country}${field.InternationalTel}</label>
						</li>`

					}
				}else if((S_Query.type == 0 || S_Query.type == 1 || S_Query.type == 2 || S_Query.type == 10) && field.InternationalTel == '86'){
					html+=`<li value="00${field.InternationalTel}" country="${field.country}" regular="${field.regular}" class="wenzidianji" style="display:flex;margin-bottom: 5px">
							<img style="width:21px;height:15px;margin:0 10px;" src="${field.img}"/>
							<label
								style="color: rgba(73,73,73,0.9);overflow:hidden;white-space:nowrap;font-size: 10px;">${field.full_country}${field.InternationalTel}</label>
						</li>`

				}else{
					if (S_Query.type == 7 || S_Query.type == 8) {
						html+=`<li value="00${field.InternationalTel}" country="${field.country}" regular="${field.regular}" class="wenzidianji" style="display:flex;margin-bottom: 5px">
							<img style="width:21px;height:15px;margin:0 10px;" src="${field.img}"/>
							<label
								style="color: rgba(73,73,73,0.9);overflow:hidden;white-space:nowrap;font-size: 10px;">${field.full_name}${field.InternationalTel}</label>
						</li>`

					}else{
						html+=`<li value="00${field.InternationalTel}" country="${field.country}" regular="${field.regular}" class="wenzidianji" style="display:flex;margin-bottom: 5px">
							<img style="width:21px;height:15px;margin:0 10px;" src="${field.img}"/>
							<label
								style="color: rgba(73,73,73,0.9);overflow:hidden;white-space:nowrap;font-size: 10px;">${field.country}${field.InternationalTel}</label>
						       </li>`
					}
				}
			});
			$("select[name = 'countrycode']").html(html);
		}
	})
}
/* 根据IP区分 分公司 */
function setCompanyID() {

	console.log(333666);

	//FIXME test 美洽轮播测试
	if (getQueryString('showinfo') === '1') {
		layer.msg('GetCompanyID start', { time: 0, closeBtn: 1 });
	}

	var _url = ApiUrl + "/Web/GetCompanyID?type="+S_Query.type;
	$.getJSON(_url,function(msg) {
		var companyID = 13;
		if (msg.ret == 200) {
			companyID = msg.data.companyID;
		}

		//FIXME test 美洽轮播测试
		if (getQueryString('showinfo') === '1') {
			if (msg.ret == 200) {
				var msgContent = 'ip:' + msg.data.result.data.ip;
				msgContent += '<br>area:' + JSON.stringify(msg.data.result.data.data);
				msgContent += '<br>company:' + companyID;
				layer.msg(msgContent, { time: 0, closeBtn: 1 });
			} else {
				layer.msg(JSON.stringify(msg), { time: 0, closeBtn: 1 });
			}
		}

		if (S_Query.type == '5' || S_Query.type == '6'){
			if (msg.data.lang == '1') {
				zh_tran('t');
			}
		}
		console.log(S_Query.type);
		S_Query.companyID = companyID;
		var arrs = msg.data.online;
		var top = document.documentElement.scrollTop || document.body.scrollTop;
		if ($(".infoList").length >= 1) {
		    $(".infoList").hide();
		    $(".info"+companyID).show();
		    $(".infoList").slide({mainCell:".bdr ul",effect:"leftMarquee",vis:3,interTime:40,autoPlay:true});
		}
		//新版手机站
		if ($(".customer_info").length >= 1) {
			// 触发滚动
			$(".customer_info").slide({mainCell:".company"+companyID, autoPlay:true,effect:"leftMarquee",vis:3,interTime:50,trigger:"click"});
			$(".customer_info").find(".company"+companyID).addClass('on').siblings('ul').removeClass('on');
			$(".customer_info").find('li').each(function() {
				var token = $(this).attr("token");
				var tk = 0;
				if(token){
					if (arrs.indexOf(token) !== -1) {
						$(this).find('.zxzx').html('<em></em>在线咨询');
					}else{
						$(this).find('.zxzx').html('<em></em>留言给我');
					}
				}else{
					$(this).find('.zxzx').html('<em></em>留言给我');
				}
			})
		}
		if ($(".tool-top .company_btn").length >= 1 || $(".customer_more").length >= 1) {
			$(".tool-top .company_btn").click(function() {
				if (S_Query.type == '5' || S_Query.type == '6'){
					window.location.href = "/cn/customers_list.html?id="+ companyID + '&ymgj';
				}else{
					window.location.href = "/customers_list.html?id="+ companyID + '&ymgj';
				}
			})
			$(".customer_more").click(function() {
				if (S_Query.type == '5' || S_Query.type == '6'){
					window.location.href = "/cn/customers_list.html?id="+ companyID;
				}else{
					window.location.href = "/customers_list.html?id="+ companyID;
				}
			})
		}
		if ($(".all-customer").length >= 1) {
			mqSwiper(companyID);
			$(".company"+companyID).addClass('on').siblings('.customer-info').removeClass('on');
			$(".customer-info").find('li').each(function() {
				var token = $(this).attr("token");
				var tk = 0;
				if(token){
					if (arrs.indexOf(token) !== -1) {
						$(this).find('.meiqia-online').html('<em></em>在线咨询');
					}else{
						$(this).find('.meiqia-online').html('<em></em>留言给我');
					}
				}else{
					$(this).find('.meiqia-online').html('<em></em>留言给我');
				}
			})
		}
		//新版手机站123
		$(".fhm-ul-t").find(".fhm-li-t").find(".fhm-a-t").removeClass("fhm-a-cur");
		$(".fhm-ul-t").find("li[name='"+companyID+"']").find(".fhm-a-t").addClass("fhm-a-cur");
		$(".fhm-c-list[name="+companyID+"]").addClass('dbk').siblings("section").removeClass('dbk');

		$("section[name='"+companyID+"']").find(".fhm-cl-li").each(function(){

			var gg_org = $(this).find(".fhm-cl-t").find("a").find("img").attr("data-original");
			var gg_src = $(this).find(".fhm-cl-t").find("a").find("img").attr("src");
			var wx_org = $(this).find(".fhm-cl-p").find("img").attr("data-original");

			if(gg_src =="" && top >= 400){
				$(this).find(".fhm-cl-t").find("a").find("img").attr("src",gg_org);
				$(this).find(".fhm-cl-p").find("img").attr("src",wx_org);
			}
		});

		$(".c_key #changeAdvisor.fifth-module").slideDown('slow');

		// if ($(".mq_xh").length >= 1) {
		//
		// 	console.log(msg.data.result.data.data[0]);
		// 	console.log(1111);
		//
		// }
		// 英文站
		if ($(".city_nav").length >= 1) {
			console.log(msg.data);
			if(msg.data.result.data != '' && msg.data.result.data.data[0] == "中国"){
				$(".city_nav").find("ul").find("li").each(function(){
					if($(this).attr("name")==16 ){
						$(this).addClass("choose_li").siblings().removeClass("choose_li");
						$(".gw_xh").find("dl").find("dd").eq($(this).index()).show().siblings().hide();
					}
				})

			}else{
				$(".city_nav").find("ul").find("li").each(function(){
					if(msg.data.name.indexOf($(this).html()) != -1 ){
						$(this).addClass("choose_li").siblings().removeClass("choose_li");
						$(".gw_xh").find("dl").find("dd").eq($(this).index()).show().siblings().hide();
					}
				})
			}

		}
		$(".hqH_nav").find("li[name='"+companyID+"']").addClass('cur').siblings("li").removeClass('cur');
		$(".hqH").find("dd[name='"+companyID+"']").addClass('show').siblings("dd").removeClass('show');
		var arr = msg.data.gwrand;


		 var tel="手机："+"+"+arr[0]['areacode']+"  "+arr[0]['tel'];
		//var tel="手机："+arr[0]['tel'];
		//PC新闻右侧
		if ($("#advisor").length >= 1) {
			// arr[a]['imgUrl']
			$("#advisor .img_js>img").attr('src',arr[0]['imgUrl']);
			$("#advisor .msg_js_t>img").attr('src',arr[0]['wxUrl']);
			$("#advisor .msg_js_t .name").html(arr[0]['name']);

			$("#advisor .adv_information .adv_information_right").html(tel);


			if(msg.data.isHome == 0){
				$("#advisor .adv_information_left").html('<a target="_blank" href="https://api.whatsapp.com/send?phone='+arr[0]['WhatsApp']+'&text=&source=&data=&app_absent=">WhatsApp：'+arr[0]['WhatsApp']+'</a>');
			}else{
				$("#advisor .adv_information_left em").html(arr[0]['wechat']);
			}
			$("#advisor .adv_information_mq").attr('onclick','Meiqia("'+arr[0]['token']+'","news-right")');
		}

		if ($(".success_case_gw").length >= 1) {
			$(".success_case_gw").find("dd").each(function(e){
				var a = e;
				if (a > 5) {
					a = Math.ceil(a%5) + 1;
				}
				$(this).find(".success_case_lxgw").find("img").attr("src",arr[a]['imgUrl']);
				$(this).find(".success_case_lxgw_main").find("li").eq(0).html(arr[a]['name']);
				$(this).find(".success_case_lxgw_main").find("li").eq(2).html(arr[a]['tel']);
				// $(this).find(".success_case_lxgw").find("a").attr("href",arr[a]['onlineTalk']);
			})
		}
		if ($(".success_case_gws").length >= 1) {
			$(".success_case_gws").find("dd").each(function(e){
				var a = e;
				if (a > 5) {
					a = Math.ceil(a%5) + 1;
				}
				$(this).find(".success_case_lxgw").find("img").attr("src",arr[a]['imgUrl']);
				$(this).find(".success_case_lxgw_main").find("li").eq(0).html('资深顾问');
				$(this).find(".success_case_lxgw_main").find("li").eq(1).html(arr[a]['name']);
				// $(this).find(".success_case_lxgw_main").find("li").eq(2).html('<a ref="JavaScript:;" onclick="'+ 'Meiqia('+arr[a]['token']+')' +'">连线专家解读</a>');
			})
		}
		if ($(".bo_success").length >= 1) {
			$(".bo_success").find("li").each(function(e){
				$(this).find(".bo_success_gw").find("img").attr("src",arr[e]['imgUrl']);
				if ($(this).find(".bo_success_gw_main").find('span.name')){
					$(this).find(".bo_success_gw_main").find('span.name').html(arr[e]['name']);
				}else{
					$(this).find(".bo_success_gw_main").find("span").eq(1).html(arr[e]['name']);
				}
				if (arr[e]['token']){
					var obj = $(this).find(".bo_success_gw_main").find("a[onclick^='Meiqia(']");
					if (obj.length > 0) {
						obj.attr('onclick', obj.attr('onclick').replace(/(Meiqia\(")([^"]+)/g, '$1' + arr[e]['token']));
					}
				}
			})
		}
		if ($(".cs_box .cs_list").length >= 1) {
			$(".cs_list").find("li").each(function(e){
				$(".cs_list").find("li").eq(e).find("dl").find('dt').css("backgroundImage","url("+arr[e]['imgUrl']+")");
				$(".cs_list").find("li").eq(e).find("dl").find('dd').find('span').find('em').html(arr[e]['name']);
				$(".cs_list").find("li").eq(e).find("dl").find('dd').find('span').find('i').html(arr[e]['tel']);
				$(".cs_list").find("li").eq(e).find("dl").find('a').attr("onclick","Meiqia('"+arr[e]['token']+"')");
			})
		}
		if ($(".globe_abouthq_case").length >= 1) {
			$(".globe_abouthq_case").find("li").each(function(e){
				var a = e;
				if (a > 5) {
					a = Math.ceil(a%5) + 1;
				}
				$(".globe_abouthq_case").find("li").eq(e).find(".globe_abouthq_case_gw_info").find('img').attr('src',arr[a]['imgUrl']);
				$(".globe_abouthq_case").find("li").eq(e).find(".globe_abouthq_case_gw_info").find('section').find('p').eq(0).html(arr[a]['name']);
				$(".globe_abouthq_case").find("li").eq(e).find(".globe_abouthq_case_gw_info").find('section').find('p').eq(1).html(arr[a]['tel']);
				$(".globe_abouthq_case").find("li").eq(e).find(".globe_abouthq_case_gw_info").find('a').attr('onclick',"Meiqia('"+arr[a]['token']+"')");
			})
		}
		if ($(".fifth-module").length >= 1) {
			$(".fifth-module").find(".fhm-cl-li").each(function(e){
				var token = $(this).find(".fhm-cl-b").find('p').attr("attr-token");
				var tk = 0;
				if(token){
					for(var i=0;i<arrs.length;i++){
						if(token==arrs[i]){
							$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").html("在线咨询");
							$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").removeClass("cur");
							$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).removeClass("cur");
							tk=1;
						}
					}
					if(tk==0){
						$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").html("留言给我");
						$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").addClass("cur");
						$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).addClass("cur");
					}
				}else{
					$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").html("留言给我");
					$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").addClass("cur");
					$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).addClass("cur");

				}
			})
		}
	})
}

/* jsonp start */

// /*当前IP分公司ID Jsonp*/
// function companyID(companyID){
// 	var arr = eval("("+companyID+")");
// 	$(".fhm-ul-t").find(".fhm-li-t").find(".fhm-a-t").removeClass("fhm-a-cur");
// 	$(".fhm-ul-t").find("li[name='"+arr['companyID']+"']").find(".fhm-a-t").addClass("fhm-a-cur");
// 	$(".fhm-c-list[name="+arr['companyID']+"]").addClass('dbk').siblings("section").removeClass('dbk');
// 	$(".hqH_nav").find("li[name='"+arr['companyID']+"']").addClass('cur').siblings("li").removeClass('cur');
// 	$(".hqH").find("dd[name='"+arr['companyID']+"']").addClass('show').siblings("dd").removeClass('show');
// }
/*美恰信息 Jsonp*/
// function getCustomer(getCustomer){
// 	var arr = eval("("+getCustomer+")");
// 	$(".bo_success").find("li").each(function(e){
// 		$(this).find(".bo_success_gw").find("img").attr("src",arr[e]['imgUrl']);
// 		$(this).find(".bo_success_gw_main").find("span").eq(1).html(arr[e]['name']);
// 		$(this).find(".bo_success_gw_main").find("a").attr("href",arr[e]['onlineTalk']);
// 	})
// 	$(".cs_list").find("li").each(function(e){
// 		$(".cs_list").find("li").eq(e).find("dl").find('dt').css("backgroundImage","url("+arr[e]['imgUrl']+")");
// 		$(".cs_list").find("li").eq(e).find("dl").find('dd').find('span').find('em').html(arr[e]['name']);
// 		$(".cs_list").find("li").eq(e).find("dl").find('dd').find('span').find('i').html(arr[e]['tel']);
// 		$(".cs_list").find("li").eq(e).find("dl").find('a').attr("href",arr[e]['onlineTalk']);
// 	})
// }
// /*在线美恰区分 Jsonp*/
// function onlineStatus(onlineStatus){
// 	var arr = eval("("+onlineStatus+")");
// 	$(".fifth-module").find(".fhm-cl-li").each(function(e){
// 		var token = $(this).find(".fhm-cl-b").find('p').attr("attr-token");
// 		var tk = 0;
// 		if(token){
// 			for(var i=0;i<arr.length;i++){
// 				if(token==arr[i]){
// 					$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").html("在线咨询");
// 					$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").removeClass("cur");
// 					$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).removeClass("cur");
// 					tk=1;
// 				}
// 			}
// 			if(tk==0){
// 				$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").html("留言给我");
// 				$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").addClass("cur");
// 				$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).addClass("cur");
// 			}
// 		}else{
// 			$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").html("留言给我");
// 			$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).find("a").addClass("cur");
// 			$(this).find(".fhm-cl-b").find('ul').find('li').eq(0).addClass("cur");

// 		}
// 	})
// }
/* jsonp end */
/**
 * 国编变化，当前页面下所有国编都跟着变化
 */
$("[name = 'countrycode']").change(function(){
	var index = $(this).val();
	console.log(index)
	$("[name = 'countrycode']").val(index);
})

$("[name = 'countrycode_test']").change(function(){
	var index = $(this).val();
	console.log(index)
	$("[name = 'countrycode_test']").val(index);
})
/**
 * 表单序列化方法
 * $return obj
 */
$.fn.serializeObject = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [ o[this.name] ];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
}
/**
 * 获取COOKIE方法
 */
function getCookie(cookieName) {
	var strCookie = document.cookie;
	var arrCookie = strCookie.split("; ");
	for(var i = 0; i < arrCookie.length; i++) {
		var arr = arrCookie[i].split("=");
		if(cookieName == arr[0]) {
			return arr[1];
		}
	}
	return "";
}
/**
 * 设置cookie
 */
function setCookie(name, value, seconds) {
	seconds = seconds || 0;   //seconds有值就直接赋值，没有为0，这个根php不一样。
	var expires = "";
	if (seconds != 0 ) {      //设置cookie生存时间
		var date = new Date();
		date.setTime(date.getTime()+(seconds*1000));
		expires = "; expires="+date.toGMTString();
	}
	document.cookie = name+"="+escape(value)+expires+"; path=/;domain=" + document.domain;   //转码并赋值
}
/**
 * 删除cookie
 */
function delCookie(key) {
	var date = new Date();
	date.setTime(date.getTime() - 1);
	var delValue = getCookie(key);
	if (!!delValue) {
		document.cookie = key+'='+delValue+';expires='+date.toGMTString()+"; path=/;domain=" + document.domain;
	}
}
/**
 * 获取url参数
 */
function getQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	var r = window.location.search.substr(1).match(reg);
	if (r != null) return decodeURI(r[2]);
	return null;
}
/*
	判断是否有分公司弹窗
*/
function callBack(data) {

	//判断是否弹出选择公司弹框
	var companyCheck = companySelect(data);
	if(!companyCheck && $("#SSGS").length < 1 && ($('#window_company_select').length >= 1 || $('#windows_comanySelect').length >= 1 || $('#windows_comanySelect_mo').length >= 1)){
		if ($('#windows_comanySelect').length >= 1) {
			var loadCompany = layer.open({
				skin: 'windows_comanySelect',
				type: 1,
				shade: [0.3, '#000000'],
				title: false,
				content: $('#windows_comanySelect'),
				closeBtn: 0,
				area:['500px', 'auto']
			})
		//弹窗调整后可 删除
		}else if ($('#window_company_select').length >= 1) {
			var loadCompany = layer.open({
				skin: 'bg-n',
				type: 1,
				shade: [0.3, '#000000'],
				title: false,
				content: $('#window_company_select'),
				closeBtn: 0,
				area:['calc(706rem / 75)', 'auto']
			})
		}else if ($('#windows_comanySelect_mo').length >= 1) {
			var loadCompany = layer.open({
				skin: 'bg-n',
				type: 1,
				shade: [0.3, '#000000'],
				title: false,
				content: $('#windows_comanySelect_mo'),
				closeBtn: 0,
				area:['calc(576rem / 72)', 'auto']
			})
		}
		$("#windows_comanySelect .company_close,#windows_comanySelect .company_btn").removeClass('disabled');
		$("#windows_comanySelect .company_close,#windows_comanySelect .company_btn,#windows_comanySelect_mo .close,#windows_comanySelect_mo .company_btn").unbind('click').click(function(){
			var _that = $(this);
			layer.close(loadCompany);
			console.log('关闭1')
			if(!_that.hasClass('disabled') == false){
				console.log('关闭2')

				layer.msg(S_Msg[S_lang].repeat);
				return false;
			}
			var company = $("#windows_comanySelect [name = 'SSGS'],#windows_comanySelect_mo [name = 'SSGS']").val();
				data.SSGS = company;
				_that.addClass('disabled');
				sendLocal(data);
		})
		//弹窗调整后可 删除
		$(".tc-send1,.tc-send2").removeClass('disabled');
		$(".tc-send1,.tc-send2").unbind('click').click(function(){
			var _that = $(this);
			layer.close(loadCompany);
			if(!_that.hasClass('disabled') == false){
				layer.msg(S_Msg[S_lang].repeat);
				return false;
			}
			_that.addClass('disabled');
			if (_that.hasClass('tc-send1')) {
				var company = $.trim($("#uCompany").val());
				data.SSGS = company;
			}
			sendLocal(data);
		})
	}else{
		sendLocal(data);
	}

	if(data.Differ !== undefined && data.Differ === 'follow_writer'){
		followWriter(data);
		layer.close(loadLoginWindow1);
		// return false;
	}
	if(data.Differ !== undefined && data.Differ === 'follow_writer_mo'){
		followWriterMo(data);
		$(".phone-pop ").css({
                'display': "none"
            })
		// return false;
	}
}
/**
 * 本地数据录入
 * @param data ajax返回数据
 * $return msg ajax  返回json数据
 */
function sendLocal(data){
	var	_url = ApiUrl + "/Form/WebSiteUnifySubmitMethods";
	$.post(_url,data,function(msg){
		if(msg.ret == 200){
			ajax_progress(msg.data);
			sendErp(msg.data.id);
			if(typeof recordUserAction == "function"){
				recordUserAction("1",msg.data.param.tel,msg.data.action.name);
			}
		}else{
			$(".ajax_Btn").removeClass('disabled');
			layer.msg(msg.msg);
		}
	})
}

/**
 * 用户关注撰稿人数据录入
 * @param data ajax返回数据
 * $return msg ajax  返回json数据
 */
function followWriter(data){
	$.post(BaseUrl + "/api/api/followWriter",data,function(msg){
		if(msg.reCode == 10001){
			console.log('撰稿人写入成功')
			$('#writer_guanzhu').html(`
			<div class="guanzhu">
				<p>已关注</p>
			</div>
			`);
		}else if(msg.reCode == 10002){
			$('#writer_guanzhu').html(`
			<div class="guanzhu">
				<p>已关注</p>
			</div>
			`);
		}else{
			console.log('撰稿人写入失败')
		}
	})
}
function followWriterMo(data){
	$.post(BaseUrl + "/api/api/followWriter",data,function(msg){
		if(msg.reCode == 10001){
			console.log('撰稿人写入成功')
			$('#writer_guanzhu').html(`
			<div class="not_guanzhu" >
				  <a style="color: #fff;">已关注</a>
			</div>
			`);
		}else if(msg.reCode == 10002){
			$('#writer_guanzhu_mo').html(`
			<div class="not_guanzhu">
				<a style="color: #fff;">已关注</a>
			</div>
			`);
		}else{
			console.log('撰稿人写入失败')
		}
	})
}

/**
 * ERP数据录入
 * @param id 本地数据录入返回本地数据ID
 * $return msg ajax  返回json数据
 */
function sendErp(id){
	if (id == 0){
		console.log('Not 录入erp');
		return false;
	}
	//异步处理
	$.ajaxSetup({
		async: true
	});
	var data = {
		timestamp:S_Query.timestamp,
		nonce:S_Query.nonce,
		signature:S_Query.signature,
		id:id
	}
	var	_url = ApiUrl + "/form/WebSiteUnifyToErp";
	$.post(_url,data,function(msg){
		console.log(msg);
	},'json');
	console.log('录入erp，id:' + id)
}
/**
 * ajax 处理，对应服务端方法返回的 json 数据处理
 * @param data ajax返回数据
 */
function ajax_progress(data) {
	// if (S_Query.Env == 'bdxcx') { //FIXME test
	// 	layer.msg(data.param.type + '<br>' + data.action.mobileResultType + '<br>' + data.action.action);
	// }

	var action = data.action,//提交标识信息
		param = data.param;//提交信息
	loginAndSetCookie(param);
	console.log(parseInt(param.type));

	//ceshim111111
	var ceshi=param.allChoiceData;

	//根据不同网站，设置不同
	switch(parseInt(param.type)){
		case 0://pc系列中文站
			if(action.resultType == '1'){  // 弹窗类型
				if(param.action == 'free_assessment'){
					if(param.isClickForm=="1"){
						$.post('https://www.globevisa.com.cn/api/api/setFreeAssessmentCooie',{allChoiceData:param.allChoiceData,cookieID:param.cookieID,tel:param.tel,mark:param.otherMark,type:1},function(ret){
							if(ret.reCode == 10001){
								window.location.href="/globevisapc/free_test/free_test_result";
							}
						})

					}else{
						$.post('https://www.globevisa.com.cn/api/api/setFreeAssessmentCooie',{allChoiceData:param.allChoiceData,cookieID:param.cookieID,tel:param.tel,mark:param.otherMark,type:1,up:1},function(ret){
							if(ret.reCode == 10001){
								$(".open_window").hide();
							}
						})

					}
				}else if(param.action == 'label_free_assessment'){
					if(param.isClickForm=="1"){
						$.post('https://www.globevisa.com.cn/api/api/setLabelFreeAssessmentCooie',{allChoiceData:param.allChoiceData,cookieID:param.cookieID,tel:param.tel,mark:param.otherMark,type:1},function(ret){
							if(ret.reCode == 10001){
								window.location.href="/globevisapc/free_test/free_test_result";
							}
						})

					}else{
						$.post('https://www.globevisa.com.cn/api/api/setLabelFreeAssessmentCooie',{allChoiceData:param.allChoiceData,cookieID:param.cookieID,tel:param.tel,mark:param.otherMark,type:1,up:1},function(ret){
							if(ret.reCode == 10001){
								$(".open_window").hide();
							}
						})

					}
				}else if(param.action == 'pingfen_nlz'){
					if(param.isClickForm=="1"){
						$.post('https://www.globevisa.com.cn/api/api/set_nlz_cookie',{tel:param.tel,link_project:param.projectID,sceneId:param.sceneId,score:param.score,mark:param.otherMark,sceneName:param.sceneName,cookieID:param.cookieID,prefix:param.preFixion,cookieType:'pingfen_nlz',type:1},function(ret){
							if(ret.reCode == 10001){
								console.log("登录+cookie成功");
								if (parseInt(param.type) == 5) {
									window.location.href="/cn/sceneResult.html";
								}else{
									window.location.href="/sceneResult.html";
								}
							}
						})
					}else{
						$.post('https://www.globevisa.com.cn/api/api/set_nlz_cookie',{tel:param.tel,cookieID:param.cookieID,cookieType:'pingfen_nlz',type:1,up:1},function(ret){
							if(ret.reCode == 10001){
								console.log("登录+cookie成功");
								$(".open_window").hide();
							}
						})
					}
				}else if(param.action == 'lxzh_new'){
					if($('.lxzh_new_form1').val()==1){
						window.location.href="/ympg.html";
					}else{
						//弹窗
						$('.open_windows').show();
					}
				}else if(param.action == 'hqzl'){
					layer.msg("提交成功!");
					setTimeout(function () {
						window.location.href = "https://www.globevisa.com.cn/globevisapc/Public_page/request_for_information_pdf";
					},2000)
				}else if(param.action == 'show_contract'){
					layer.closeAll()
			        layer.open({
			            type: 2,
			            title: param.contract_name+"办理合同书",
			            // maxmin: true, //开启最大化最小化按钮
			            area: ['50%', '100%'],
			            shadeClose: true,
			            content: 'https://www.globevisa.com.cn/globevisapc/contract/index?id='+param.contract_id
			        });
				}else{
					//弹窗
					$('.open_windows').show()
				}
			}else if(action.resultType == '2'){  //跳转页面
				//跳转
				if(param.action == 'contrast'){
					window.location.href = action.resultAfter + param.countryID;
				}else if(param.action == 'passport_contrast' || param.action == 'passport_info'){
					window.location.href = action.resultAfter + data.param.ids;
				}else if(param.action == 'passport_index' || param.action == 'passport_my'){
					window.location.href = action.resultAfter + data.param.ifc;
				}else if(param.action == 'passport_info_fold' || param.action == 'passport_contrast_fold' || param.action == 'passport_my_down'){
					window.location.href = action.resultAfter + data.param.fold;
				}else if(param.action == 'pingfen_auto'){
					if (parseInt(param.type) == 5) {
						window.location.href="/cn/sceneResult.html";
					}else{
						window.location.href="/sceneResult.html";
					}
				}else if(param.action == 'shipin'){
					window.location.href = "/video/"+param.activeId+".html";
				}else{
					if (parseInt(param.type) == 5) {
						window.location.href = '/cn' + action.resultAfter;
					}else{
						window.location.href = action.resultAfter;
					}
				}
			}else{
				//判断
				if(param.action == "fytc" || param.action == "fyym"){ //其他处理
					console.log(1234567);
					$.post(ApiUrl + '/It/GetFyDetails',{erpid:param.erpid,p_num:param.p_num,fee:param.fee,check_a:param.check_a,check_h:param.check_h,p_total:param.p_total},function(ret){
						if(ret.ret == 200){
							var msg = ret.data.reMsg_html;
							// $(".zhf").html("预计投资额：约"+msg['total']+"元");
							$(".zhf").html("预计投资额："+msg['total']);
							if(msg['j_total']){

								// $(".jtr").html("预计净投入：约"+msg['j_total']+"元");
								$(".jtr").html("预计净投入："+msg['j_total']);
							}else{

								// $(".jtr").html("预计净投入：约"+msg['j_total']+"元人民币");
								$(".jtr").html("预计净投入："+msg['j_total']);
							}
							console.log(msg);

							var fyHtml = '';
							for(jj in msg['info']){
								console.log(msg['info'][jj]['name']);
								console.log(msg['info'][jj]['total'])
								fyHtml+='<dd class="clearfix"><span>'+msg['info'][jj]['name']+'</span><span>'+msg['info'][jj]['total'].toLocaleString()+msg['info'][jj]['bizhong']+'</span><span>'+msg['info'][jj]['t_time']+'</span></dd>';
							}

							$(".allDetail").html(fyHtml);

							$('.allDetail span').each(function(){
								var height = $(this).outerHeight();//获取每个span高度
								if(height > 27){
									$(this).siblings().each(function(){//循环兄弟级
										if($(this).outerHeight() < height){
											$(this).css('line-height',height+'px');
										}
									})
								}
							})
							$(".ajaxBtn").html("开始计算");
							$(".ajaxBtn").removeClass("disabled");
						}
					},'json');
				}else if(param.action == 'loginAndReg'){
					window.location.href = getQueryString('from');
				}else if(action.action == 'video_show'){
					layer.closeAll();
					// $(".video p span").html('已登录')
				}else if(action.action == 'passport_info_down' || action.action == 'passport_contrast_down' || action.action == 'passport_my_down'){
					$("#passport_windows").hide();
					alert('下载');
				}else{
					$('.open_windows').show();
				}
			}
		break;
		case 5://pc系列hk
			if(action.resultType == '1'){
				if(param.action == 'free_assessment'){
					if(param.isClickForm=="1"){
						$.post('https://www.globevisa.com.cn/api/api/setFreeAssessmentCooie',{allChoiceData:param.allChoiceData,cookieID:param.cookieID,tel:param.tel,mark:param.otherMark,type:1},function(ret){
							if(ret.reCode == 10001){
								window.location.href="/globevisapcnew_hk/free_test/free_test_result?a="+ceshi;
							}
						})

					}else{
						$.post('https://www.globevisa.com.cn/api/api/setFreeAssessmentCooie',{allChoiceData:param.allChoiceData,cookieID:param.cookieID,tel:param.tel,mark:param.otherMark,type:1,up:1},function(ret){
							if(ret.reCode == 10001){
								$(".open_window").hide();
							}
						})

					}
				}else if(param.action == 'label_free_assessment'){
					if(param.isClickForm=="1"){
						$.post('https://www.globevisa.com.cn/api/api/setLabelFreeAssessmentCooie',{allChoiceData:param.allChoiceData,cookieID:param.cookieID,tel:param.tel,mark:param.otherMark,type:1},function(ret){
							if(ret.reCode == 10001){
								window.location.href="/globevisapcnew_hk/free_test/free_test_result?a="+ceshi;
							}
						})

					}else{
						$.post('https://www.globevisa.com.cn/api/api/setLabelFreeAssessmentCooie',{allChoiceData:param.allChoiceData,cookieID:param.cookieID,tel:param.tel,mark:param.otherMark,type:1,up:1},function(ret){
							if(ret.reCode == 10001){
								$(".open_window").hide();
							}
						})

					}
				}else if(param.action == 'pingfen_nlz'){
					if(param.isClickForm=="1"){
						$.post('https://www.globevisa.com.cn/api/api/set_nlz_cookie',{tel:param.tel,link_project:param.projectID,sceneId:param.sceneId,score:param.score,mark:param.otherMark,sceneName:param.sceneName,cookieID:param.cookieID,prefix:param.preFixion,cookieType:'pingfen_nlz',type:1},function(ret){
							if(ret.reCode == 10001){
								console.log("登录+cookie成功");
								if (parseInt(param.type) == 5) {
									window.location.href="/cn/sceneResult.html";
								}else{
									window.location.href="/sceneResult.html";
								}
							}
						})
					}else{
						$.post('https://www.globevisa.com.cn/api/api/set_nlz_cookie',{tel:param.tel,cookieID:param.cookieID,cookieType:'pingfen_nlz',type:1,up:1},function(ret){
							if(ret.reCode == 10001){
								console.log("登录+cookie成功");
								$(".open_window").hide();
							}
						})
					}
				}else if(param.action == 'lxzh_new'){
					if($('.lxzh_new_form1').val()==1){
						window.location.href="/ympg.html";
					}else{
						//弹窗
						$('.open_windows').show();
					}
				}else if(param.action == 'hqzl'){
					layer.msg("提交成功!");
					setTimeout(function () {
						window.location.href = "https://www.globevisa.com.cn/globevisapc/Public_page/request_for_information_pdf";
					},2000)
				}else if(param.action == 'show_contract'){
					layer.closeAll()
			        layer.open({
			            type: 2,
			            title: param.contract_name+"办理合同书",
			            // maxmin: true, //开启最大化最小化按钮
			            area: ['50%', '100%'],
			            shadeClose: true,
			            content: 'https://www.globevisa.com.cn/globevisapc/contract/index?id='+param.contract_id
			        });
				}else{
					//弹窗
					  $('.open_windows').show()
					 // window.location.href="/globevisapcnew_hk/Public_Page/formshow";
				}
			}else if(action.resultType == '2'){
				//跳转
				if(param.action == 'contrast'){
					window.location.href = '/cn'+ action.resultAfter + param.countryID;
				}else if(param.action == 'passport_contrast' || param.action == 'passport_info'){
					window.location.href ='/cn'+ action.resultAfter + data.param.ids;
				}else if(param.action == 'passport_index'){
					window.location.href ='/cn'+ action.resultAfter + data.param.ifc;
				}else if(param.action == 'pingfen_auto'){
					if (parseInt(param.type) == 5) {
						window.location.href="/cn/sceneResult.html";
					}else{
						window.location.href="/sceneResult.html";
					}
				}else if(param.action == 'passport_info_fold' || param.action == 'passport_contrast_fold' || param.action == 'passport_my_down'){
					window.location.href = '/cn'+action.resultAfter + data.param.fold;
				}else if(param.action == 'shipin'){
					window.location.href = "/cn/video/"+param.activeId+".html";
				}else{
					if (parseInt(param.type) == 5) {
						window.location.href = '/cn' + action.resultAfter;
					}else{
						window.location.href = action.resultAfter;
					}
				}
			}else{
				//判断
				if(param.action == "fytc" || param.action == "fyym"){
					console.log(1234568);
					$.post(ApiUrl + '/It/GetFyDetails',{erpid:param.erpid,p_num:param.p_num,fee:param.fee,check_a:param.check_a,check_h:param.check_h,p_total:param.p_total},function(ret){
						if(ret.ret == 200){
							var msg = ret.data.reMsg_html;
							// $(".zhf").html("预计投资额：约"+msg['total']+"元");
							$(".zhf").html("预计投资额："+msg['total']);
							if(msg['j_total']){

								// $(".jtr").html("预计净投入：约"+msg['j_total']+"元");
								$(".jtr").html("预计净投入："+msg['j_total']);
							}else{

								// $(".jtr").html("预计净投入：约"+msg['j_total']+"元人民币");
								$(".jtr").html("预计净投入："+msg['j_total']);
							}
							console.log(msg);

							var fyHtml = '';
							for(jj in msg['info']){
								console.log(msg['info'][jj]['name']);
								console.log(msg['info'][jj]['total'])
								fyHtml+='<dd class="clearfix"><span>'+msg['info'][jj]['name']+'</span><span>'+msg['info'][jj]['total'].toLocaleString()+msg['info'][jj]['bizhong']+'</span><span>'+msg['info'][jj]['t_time']+'</span></dd>';
							}

							$(".allDetail").html(fyHtml);

							$('.allDetail span').each(function(){
								var height = $(this).outerHeight();//获取每个span高度
								if(height > 27){
									$(this).siblings().each(function(){//循环兄弟级
										if($(this).outerHeight() < height){
											$(this).css('line-height',height+'px');
										}
									})
								}
							})
							$(".ajaxBtn").html("开始计算");
							$(".ajaxBtn").removeClass("disabled");
						}
					},'json');
				}else if(param.action == 'loginAndReg'){
					window.location.href = getQueryString('from');
				}else if(action.action == 'video_show'){
					layer.closeAll();
					// $(".video p span").html('已登录')
				}else{
					// $('.open_windows').show();
					window.location.href="/globevisapcnew_hk/Public_Page/formshow";
				}
			}
		break;
		case 1://手机系列国内
		case 33:
		case 35:
			if(action.mobileResultType == '1'){
				if(action.action == 'free_assessment'){
					if (parseInt(param.type) == 6) {
						location.href="/cn/free_test_result.html?a="+ceshi;
					}else{
						location.href="/free_test_result.html?a="+ceshi;
					}
				}else if(action.action == 'ymqsBlueBook'){
					layer.msg('提交成功!')
					setTimeout(function(){
						window.location.href="/index/Special/lps";
					}, 2000);
				}else if(param.action == 'show_contract'){
					layer.closeAll()
					layer.open({
		                type: 2,
			            title: param.contract_name+"办理合同书",
		                // maxmin: true, //开启最大化最小化按钮
		                area: ['100%', '100%'],
			            content: 'https://www.globevisa.com.cn/globevisapc/contract/index?id='+param.contract_id
		            });
				}else {
					//弹窗
					$(".personal_tailor_new_bj").show();
				}
			}else if(action.mobileResultType == '2'){
				//跳转国内
				if(param.action == 'contrast'){
					window.location.href = action.mobileResultAfter + param.countryIDs;
				}else if(param.action == 'passport_index' || param.action == 'passport_my'){
					window.location.href = action.resultAfter + data.param.ifc;
				}else if(param.action == 'passport_info_fold'){
					window.location.href = action.resultAfter + data.param.fold;
				}else if(param.action == 'project_contract'){
					window.location.href = action.mobileResultAfter + data.param.fold;
				}else if(param.action == 'project_assess'){
					window.location.href = action.mobileResultAfter;
				}else if(param.action == 'fytc' || param.action == 'fyym'){
					$.ajax({
						type: "POST",
						url: ApiUrl + '/It/GetFyDetails',
						data: {erpid:param.erpid,p_num:param.p_num,fee:param.fee,check_a:param.check_a,check_h:param.check_h,p_total:param.p_total},
						dataTtpe:'json',
						xhrFields: {
						   withCredentials: true
						},
						success: function(msg) {

							//console.log(msg);return;
							setCookie('fyjs_result',msg.data.reMsg);
							console.log(action.mobileResultAfter)
							//console.log(param.type);return
							if (parseInt(param.type) == 6) {
								window.location.href="/cn/" + action.mobileResultAfter;
							}else{
								window.location.href = action.mobileResultAfter+'?msg='+getCookie('fyjs_result');
								//cookie不能跳转试试传参
							}
						}
					});
				}else{
					if (parseInt(param.type) == 6) {
						window.location.href="/cn/" + action.mobileResultAfter;
					}else{
						window.location.href = action.mobileResultAfter;
					}
				}
			}else{
				//判断
				if(action.action == 'video_show'){
					layer.closeAll();
					// $(".video p span").html('已登录')
				}
			}
		break;
		case 6://手机系列hk
			if(action.mobileResultType == '1'){
				if(action.action == 'free_assessment'){
					if (parseInt(param.type) == 6) {
						window.location.href="/cn/free_test_result.html?a="+ceshi;
					}else{
						window.location.href="/free_test_result.html?a="+ceshi;
					}
				}else if(action.action == 'ymqsBlueBook'){
					layer.msg('提交成功!')
					setTimeout(function(){
						window.location.href="/index/Special/lps";
					}, 2000);
				}else if(param.action == 'show_contract'){
					layer.closeAll()
					layer.open({
		                type: 2,
			            title: param.contract_name+"办理合同书",
		                // maxmin: true, //开启最大化最小化按钮
		                area: ['100%', '100%'],
			            content: 'https://www.globevisa.com.cn/globevisapc/contract/index?id='+param.contract_id
		            });
				}else {
					//弹窗
					$(".personal_tailor_new_bj").show();
					// window.location.href="/index_hk/public_page/formshow";
				}
			}else if(action.mobileResultType == '2'){
				//跳转
				if(param.action == 'contrast'){
					if (parseInt(param.type) == 6) {
						window.location.href = '/cn' + action.mobileResultAfter + param.countryIDs;
					}
				}else if(param.action == 'passport_index' || param.action == 'passport_my'){
					window.location.href = '/cn' +action.resultAfter + data.param.ifc;
				}else if(param.action == 'passport_info_fold'){
					window.location.href = '/cn' +action.resultAfter + data.param.fold;
				}else if(param.action == 'project_contract'){
					window.location.href = 'https://m.globevisa.com.cn/index_hk/item/contract?'+ action.resultAfter + data.param.fold;
				}else if(param.action == 'project_assess'){
					window.location.href = '/cn' +action.mobileResultAfter;
				}else if(param.action == 'fytc' || param.action == 'fyym'){
					$.ajax({
						type: "POST",
						url: ApiUrl + '/It/GetFyDetails',
						data: {erpid:param.erpid,p_num:param.p_num,fee:param.fee,check_a:param.check_a,check_h:param.check_h,p_total:param.p_total},
						dataTtpe:'json',
						xhrFields: {
						   withCredentials: true
						},
						success: function(msg) {

							//console.log(msg);return;
							setCookie('fyjs_result',msg.data.reMsg);
							console.log(action.mobileResultAfter)
							//console.log(param.type);return
							if (parseInt(param.type) == 6) {
								window.location.href="/cn/" + action.mobileResultAfter;
							}else{
								window.location.href = action.mobileResultAfter;
							}
						}
					});
				}else{
					if (parseInt(param.type) == 6) {
						window.location.href="/cn/" + action.mobileResultAfter;
					}else{
						window.location.href = action.mobileResultAfter;
					}
				}
			}else{
				//判断
				if(action.action == 'video_show'){
					layer.closeAll();
					// $(".video p span").html('已登录')
				}
			}
		break;
		case 2://客户端
			$(".blank").show();
			if(action.action == "khd_hk2"){
				//香港推广页转化代码
				_taq.push({convert_id:"76041998885", event_type:"form"});
			}
			if(action.action == "khd_jnd3"){
				//加拿大转化代码
				_taq.push({convert_id:"78311759477", event_type:"form"});
			}
		break;
		case 10://直达宝
			if(action.mobileResultType == '1'){
				//弹窗
				$(".personal_tailor_new_bj").show();
			}else if(action.mobileResultType == '2'){
				//跳转
				if(param.action == 'fyym'){
					$.ajax({
						type: "POST",
						url: ApiUrl + '/It/GetFyDetails',
						data: {erpid:param.erpid,p_num:param.p_num,fee:param.fee,check_a:param.check_a,check_h:param.check_h,p_total:param.p_total},
						dataTtpe:'json',
						xhrFields: {
						   withCredentials: true
						},
						success: function(msg) {
							setCookie('fyjs_result',msg.data.reMsg);
							if(getCookie('isStaff') == '1'){
								window.location.href = "/nonstop/index/costResult/type/qyWork.html";
							}else{
								window.location.href = "/nonstop/index/costResult/r/" + param.sharing	+".html";
							}
						}
					});
				}else if(param.action == 'pingfen_auto' || param.action == 'pingfen_nlz' || param.action == 'pingfen_elitist' || param.action == 'pingfen_aj' || param.action == 'pingfen_yc' || param.action == 'pingfen'){
					if(getCookie('isStaff') == '1'){
						window.location.href = "/nonstop/index/auto_result/type/qyWork.html";
					}else{
						window.location.href = "/nonstop/index/auto_result/r/" + param.sharing +".html";
					}
				}else{
					window.location.href = param.mobileResultAfter;
				}
			}else{
				//判断
				//判断
				if(action.action == 'video_show'){
					layer.closeAll();
					$("#pop").hide();
				}
			}
		break;
		case 7://英文PC


			if(action.resultType == '1'){
				if(action.action == 'NzSkill_Assm'){
					$(".open_window").show();
					$(".open_window .title").html(action.title);
					$(".open_window em.fs b").html(action.score);
					$(".open_window em.zf").hide();
					$(".open_window span.msg").html(action.msg);
				}else if(action.action == 'CaFedSkill_Assm'){
					if(action.score < 67){
						grade="Not Eligible";
						marked="According to the information your provided, your current score on the Come To Canada (CTC) is below the basic requirement of 67 points. We recommend you to try using your partner as the primary applicant. If you would like to explore other immigration options please click icon below to talk to our consultant online.";
					}else if(action.score  > 67 && action.EEscore < 400){
						grade="Please Proceed PNP Assessment";
						marked="<p>According to the information your provided, you have acquired over 67 points on the Come To Canada (CTC) assessment. However, the total score on your Express Entry profile is not meeting the minimum requirement. We would like to suggest you to explore opportunity in Provincial Nominee Program (PNP).</p><p>Option 1 - Manitoba PNP has one of the easiest requirement of all PNPs, applicants must be sponsored by close relative who is residing in Manitoba.</p><p>Option 2- Ontario PNP, applicants will be eligible by holding Information Communications Technology - ICT qualification, Job offer from Ontario or to meet French CLB7 level. </p><p>Option 3- New Brunswick PNP, applicants will be eligible by holding a position in an occupation in demand list and to meet one out of seven additional requirements from the NB Government.</p><p>Option 4- Saskatchewan & Nova Scotia PNP, applicants will be eligible by holding a position in an occupation in demand list, and the pass the provincial Expression of Interest (EOI) assessment with over 67 points </p><p>Please click icons to consult our immigration advisor about each PNP program eligibility requirement.</p>";

					}else if(action.score  > 67 && action.EEscore > 400 && action.EEscore < 450){
						grade="Eligible for Ontario PNP";
						marked="According to the information your provided, you have acquired over 67 points on the Come To Canada (CTC) assessment. However, the total score on your Express Entry profile is meeting the minimum requirement for applying Ontario Provincial Nominee Program (OPNP). Our consultant will contact you shortly to confirm the assessment information as some may need professional verification, if you have further questions on the program eligibility criteria, time frame, charges and application process, please click icon below to talk to our consultant online.";
					}else if(action.score  > 67 && action.EEscore > 450){
						grade="Eligible";
						marked="According to the information your provided, you have acquired over 67 points on the Come To Canada (CTC) assessment. However, the total score on your Express Entry profile is meeting the minimum requirement for applying Ontario Provincial Nominee Program (OPNP). Our consultant will contact you shortly to confirm the assessment information as some may need professional verification, if you have further questions on the program eligibility criteria, time frame, charges and application process, please click icon below to talk to our consultant online.";
					}
					$('#EE_score').html(action.EEscore);
					$('#CTC_score').html(action.score);
					$('.ow_main .title').html(grade);
					$('#marked').html(marked);
					$(".open_window").show();
				}else if(action.action == 'SaskSkill_Assm'){
					$(".open_window").show();
					$(".open_window .title").html(action.title);
					if(action.score > 0 ){
						$(".open_window em.fs b").html(action.score);
					}else{
					$(".open_window em.fs").hide();
					}
					$(".open_window em.zf").hide();
					$(".open_window span.msg").html(action.msg);
				}else if(action.action == 'CaCEC_Assm'){
					$(".open_window").show();
					$(".open_window .name").html(action.name);
					$(".open_window .tel").html(action.tel);
				}else if(action.action == 'CaSelf_Assm' || action.action == 'HkQMAS_Assm'){
					window.location.href = "/en/assessment_result.shtml";
				}else if(action.action == 'UsEB_Assm'){
					$(".open_window").show();
					$(".open_window em.fs b").html(action.score);
					$(".open_window .title b").html(action.title);
					$(".open_window span.msg").html(action.msg);
				}else if(action.action == 'AusSkill_Assm'){
					$(".open_window").show();
					$(".open_window em.fs b").html(action.score);
					$(".open_window .title b").html(action.title);
					$(".open_window span.msg").html(action.msg);
				}else if(action.action == 'successful'){
					$(".sl_content").addClass("sl_content_all")
					layer.msg('Submitted successsfully! Our professional consultant will contact you soon!');
				}else{

					//console.log(321);
					layer.msg('The form is submitted successfully! Our consultants will get back to you as soon as possible!')
				}
			}else if(action.resultType == '2'){
				if(action.action == 'pingfen_auto'){
					window.location.href = "/en/assessment_result.shtml";
				} else{
					window.location.href = action.resultAfter;
				}
			}else{
				console.log(ApiUrl);
			//	console.log('lixiaohui')
				//判断
				if(param.action == "fytc" || param.action == "fyym"){
					$.ajax({
						url: ApiUrl + '/It/GetFyDetailEn',
						type: "post",
						data: 'erpid='+param.erpid+"&p_num="+param.p_num+"&fee="+param.fee+"&check_a="+param.check_a+"&check_h="+param.check_h+"&p_total="+param.p_total+"&english="+param.english,
						dataType: "json",
						success: function(msg) {
							$(".zhf").html("Estimated investment amount USD "+msg.data['result']['total']['total']['value']);
							$(".jtr").html("Estimated net investment USD "+msg.data['result']['j_total']['total']['value']);


							var fyHtml = '';
							for(jj in msg.data['result']['info']){
								console.log(msg.data['result']['info'][jj]['name']);
								fyHtml+='<dd class="clearfix"><span>'+msg.data['result']['info'][jj]['name']+'</span><span>'+msg.data['result']['info'][jj]['bizhong']['FNAME']+" "+msg.data['result']['info'][jj]['total'].toLocaleString()+'</span><span>'+msg.data['result']['info'][jj]['t_time']+'</span></dd>';
							}

							$(".allDetail").html(fyHtml);

							$(".ajaxBtn").html("CALCULATE");
							$(".ajaxBtn").removeClass("disabled");

						}
					});
				}else{

					layer.msg('Submitted successsfully! Our professional consultant will contact you soon!');

				}


			}
		break;
		case 8://英文手机
			if(action.mobileResultType == '1'){
				if(param.action == 'scene'){
					//打分集合页
	                if(param.sceneType == 'AusSkill_Assm'){
	                    $('.scoreResultT').show();
	                }else if(param.sceneType == 'CaSelf_Assm'){
	                    $(".scorenumber").html('Your Score : <b >'+param.score+'</b> Points');
	                    if (param.score < 35) {
	                        $('.scoreResultF').show();
	                    }else{
	                        if (param.result == 1) {
	                            $('.scoreResultT').show();
	                        }else{
	                            $('.scoreResultT2').show();
	                        }
	                    }
					}else if(param.sceneType == 'HkQMAS_Assm' || param.sceneType == 'NzSkill_Assm'|| param.sceneType == 'SaskSkill_Assm' || param.sceneType == 'CaFedSkill_Assm'){
                        $(".scorenumber").html('Your Score : <b >'+param.score+'</b> Points');
                        if(param.title == "Not Eligible"){
                            if (param.sceneType == 'CaFedSkill_Assm'){
                                //特殊显示
                                $('.scoreResultT').show();
                            }else{
                                $('.scoreResultF').show();
                            }
                        }else{
                            if (param.sceneType == 'CaFedSkill_Assm'){
                                //特殊显示
                                $('.scoreResultF').show();
                            }else{
                                $('.scoreResultT').show();
                            }
                        }

	                    $(".result_title").html(param.title);
	                }else if(param.sceneType == 'UsEB_Assm'){
	                    $(".scorenumber").html('Your Score : <b >'+param.score+'</b> Points');
	                    if (param.score< 25) {
	                        // 符合
	                        $('.scoreResultT').show();
	                    }else if(param.score== 25){
	                        // 不符合
	                        $('.scoreResultF').show();
	                    }else if(param.score> 25 && param.score< 45){
	                        // 不符合
	                        $('.scoreResultT2').show();
	                    }else if(param.score == 45){
	                        // 不符合
	                        $('.scoreResultF2').show();
	                    }else{
	                        // 不符合
	                        $('.scoreResultT3').show();
	                    }
	                }
	                $(".dt_page").hide();
	                $('.result_page').show();
				}else if(action.action == 'successful'){
					$(".md_content").addClass("md_content_all")
					layer.msg('Submitted successsfully! Our professional consultant will contact you soon!');
				}else{

					layer.msg('Submitted successsfully! Our professional consultant will contact you soon!');
				}
			}else if(action.mobileResultType == '2'){
				if(param.action == 'fytc' || param.action == 'fyym'){
					//费用计算
					layer.msg("Thank you for your submission!");
					setTimeout(function () {
	                    window.location.href = 'https://m.globevisa.com.cn/globevisamo_en/Formall/costCalculatorPhoneInfo?e='+param.erpid+'&p='+param.p_total+'&p_num='+param.p_num+'&p_total='+param.p_total+'&check_a='+param.check_a+'&check_h='+param.check_h+'&fee='+param.fee
	                },1000)
				}
			}else{

			}
		break;
	}
}

/* 根据关键词获取所需连接 */
function  getSearchLink(searchResult) {
	_url = ApiUrl + '/Web/GetCountrys';
	$.post(_url, {}, function(msg) {
		var link = "";
		for(var i=0;i<msg.data.length;i++){
			console.log(searchResult);
			console.log(msg.data[i].name);
			if(msg.data[i].name.indexOf(searchResult) !=-1){
				//console.log(msg.data[i].link);
				link = msg.data[i].link;


			}

		}
		if(window.location.host=="https://www.globevisa.com"||window.location.host=="https://www.huanqiuchuguo.com"){
			var hwzwLink = "/cn";
		}else{
			var hwzwLink = "";
		}


		if(link){
			window.location.href=hwzwLink+link;

		}else{

			layer.msg("未搜索到该国家");
		}



	})
}
/**
 * 验证客户手机验证码是否正确
 * $param tel 获取当前表单name tel字段
 * $return boolean
 */
function checkPwd(data) {
	if(getCookie("phone") == ""){
		$.ajaxSetup({
		  	async: false
	  	});
		var rT = true,
			_url = ApiUrl + '/Sms/smsPwdCheck';
		$.post(_url, { tel : data.tel, pwd : data.pwd}, function(msg) {
			if(msg.ret == 200){
				rT = false;
			}else{
				rT = true;
			}
		},'json');
		return rT;
	}else{
		return true;
	}
}
/**
 * 验证客户是否要选择分公司
 * $param tel 获取当前表单name tel字段
 * $return boolean
 */
function companySelect(data) {
	if(getCookie("phone") == ""){
		//新版判断是否弹出分公司弹窗
		$.ajaxSetup({
		  	async: false
	  	});
		var rT = true,
			_url = ApiUrl + '/Web/existCompany';
		$.post(_url, { tel : data.tel }, function(msg) {
						// $("#uCompany").empty();
						if(msg.ret == 200){
							rT = false;
							// $("#uCompany").append('<option value="">请选择</option>');
							// $.each(msg.data, function(i, field){
							// 	$("#uCompany").append('<option value="'+field.SSGS+'">'+field.name+'</option>');
							// });
						}else{
							rT = true;
						}
					},'json');
		return rT;
	}else{
		return true;
	}
}
/* 登录》设置cookie*/
function loginAndSetCookie(data){
	setCookie('phone',data.tel);
	setCookie('cookieType',data.action);
	if(data.action == 'pingfen_aj'){
		setCookie('aj_score',data.score);
	}else if(data.action == 'studyEvaluation'){
		setCookie('t2',encodeURI(data.t2));
	}else if(data.action == 'pingfen_yc'){
		setCookie('ys_score',data.score);
		setCookie('ys_pflx',data.pflx);
		setCookie('t10',data.t10);
		setCookie('t11',data.t11);
	}else if(data.action == 'pingfen_kj'){
		setCookie('pass',data.pass);
		setCookie('score',data.score);
	}else if(data.action == 'pingfen'){
		var fen = data.score.split('+');
		setCookie('CTC',fen[1]);
		setCookie('EE',fen[0]);
	}else if(data.action == 'free_assessment'){
		setCookie('allChoiceData',data.allChoiceData);
	}else if(data.action == 'label_free_assessment'){
		setCookie('allChoiceDatas',data.allChoiceData);
	}else if(data.action == 'pingfen_nlz'){
		setCookie('score',data.score);
		setCookie('sceneName',data.sceneName);
		setCookie('sceneId',data.sceneId);
	}else if(data.action == 'pingfen_auto'){
		setCookie('score',data.score);
		setCookie('link_project',data.link_project);
		setCookie('sceneId',data.sceneId);
	}else if(data.action == 'HkQMAS_Assm' || data.action == 'CaSelf_Assm'){
		setCookie('score',data.score);
		setCookie('link_project',data.link_project);
	}else if(data.action == 'pingfen_elitist'){
		setCookie('elitist_score',data.score);
		setCookie('elitist_result2',data.result2);
	}
	if(getCookie('phone')){
		$(".uwelcome,.uperson,.uout").show();
		$(".uwelcome a").html('您好，' + getCookie('phone').substring(0,3) + '****' + getCookie('phone').substring(7))
		$(".ulogin,.ureg").hide();
		//判断页面中是否有表单
		if($("#zhuantifrom").val() == "展会活动") {
			if($("#utel").length > 0) {

				$(".guali1").css("display", "none");
				$(".guali2").css("width", "100%");
			}

		} else {

			if($(".PopupHidUserName").length > 0) {
				$(".PopupHidUserName").css("display", "none");
			}
			if($(".PopupHidTel1").length > 0) {
				$(".PopupHidTel1").css("display", "none");
			}
			if($(".PopupHidTel2").length > 0) {
				$(".PopupHidTel2").css("display", "none");
				$(".tjBtn").css("float","none");
			}
			if($(".PopupHidMessage").length > 0) {
				$(".PopupHidMessage").css("display", "none");
			}

			if ($("[name = 'tel']").length > 0 && data.tel) {
				$("[name = 'tel']").each(function (i,e) {
					if ($(e).val() != data.tel) {
						$(e).val(data.tel);
					}
				});

				if ($("[name = 'countrycode']").length > 0) {
					if (data.tel.substring(0, 2) === '00') {
						$("[name = 'countrycode']").each(function (i, e) {
							$(e).children('option').each(function (ii,ee) {
								var countrycode = $(ee).val();
								if (data.tel.substring(0, countrycode.length) == countrycode) {
									$('ul.ul-select li[data-value="' + countrycode + '"]').click();
								}
							});
						});
					} else if (data.countrycode){
						$('ul.ul-select li[data-value="' + data.countrycode + '"]').click();
					}
				}
			}
			if ($("[name = 'userName']").length > 0 && data.userName) {
				$("[name = 'userName']").each(function (i, e) {
					if ($(e).val() != data.userName) {
						$(e).val(data.userName);
					}
				});
			}
		}
	}

	// if (S_Query.Env == 'bdxcx') { //FIXME test
	// 	layer.msg('loginAndSetCookie ok');
	// }
}
/*能力值打分总分计算*/
function score_zf(){
	var score_zf=0;
	$(".save_val").each(function () {
		score_zf=score_zf+parseInt($(this).val());
		console.log($(this).val())
	});
	return score_zf;
}


/*能力值打分 总题目 已经选题累加*/
function score_tm_pj(){
	var score_tm_pj="";
	for(var i=0;i<$(".score_tm").length;i++){
		score_tm_pj=score_tm_pj+$(".score_title").eq(i).val()+$(".score_tm").eq(i).val()+";";
	}
	return score_tm_pj.substring(0,score_tm_pj.length-1);
}

/*滚动加载当前地区顾问图片资源*/
function gwScroll(){
	$(window).scroll(function() {
		var top = document.documentElement.scrollTop || document.body.scrollTop;
		var flag = true;
		if (top >= 400 && flag) {
			$("section[name='"+S_Query.companyID+"']").find(".fhm-cl-li").each(function(){
				var gg_org = $(this).find(".fhm-cl-t").find("a").find("img").attr("data-original");
				var gg_src = $(this).find(".fhm-cl-t").find("a").find("img").attr("src");
				var wx_org = $(this).find(".fhm-cl-p").find("img").attr("data-original");
				if(gg_src ==""){
					$(this).find(".fhm-cl-t").find("a").find("img").attr("src",gg_org);
					$(this).find(".fhm-cl-p").find("img").attr("src",wx_org);
				}
			})
			flag = false;
		}
	});
}

/* 查询当前运行环境 */
function getEnv(checkFlag){
	if ((getCookie("CurEnv") == 'bdxcx' || location.href.indexOf('#bdxcx') > 0) && (/swan\//.test(window.navigator.userAgent) || /^webswan-/.test(window.name))) {
		if (checkFlag && location.href.indexOf('#bdxcx') < 0) {
			location.href = location.href + '#bdxcx'; return;
		}
		S_Query.Env = 'bdxcx';
		setCookie('CurEnv', 'bdxcx');
		if (typeof swan == 'undefined') {
			$.getScript("https://b.bdstatic.com/searchbox/icms/searchbox/js/swan-2.0.31.js", function (response, status) {
				console.log('baiduAppSDK ok');
			});
		}
		$('a.simplified.fl:contains("EN")').hide();
	} else {
		delCookie('CurEnv');
	}
}
/* 查询微信当前运行环境 */
function getWxEnv(checkFlag) {
	if ((getCookie("CurWXEnv") == 'hqcgwxxcx' || location.href.indexOf('#hqcgwxxcx') > 0) && (navigator.userAgent && navigator.userAgent.indexOf('miniProgram') > -1)) {
		if (checkFlag && location.href.indexOf('#hqcgwxxcx') < 0) {
			location.href = location.href + '#hqcgwxxcx'; return;
		}
		S_Query.Env = 'hqcgwxxcx';
		setCookie('CurWXEnv', 'hqcgwxxcx');
		if (typeof swan == 'undefined') {
			$.getScript("https://res.wx.qq.com/open/js/jweixin-1.6.0.js", function (response, status) {
				console.log('weixinAppSDK ok');
			});
		}
		$('a.simplified.fl:contains("EN")').hide();
	} else {
		delCookie('CurWXEnv');
	}
}

/* 百度小程序跳转处理 */
var redirect_bdxcx = function (delay = 1000) {
	var method = function (target) {
		if (S_Query.Env != 'bdxcx' || !target || typeof swan == 'undefined') { return false; }

		var fromHome = toHome = false;
		var fromPath = location.pathname;
		var toPath = target.attr('href');
		if (fromPath == '/' || fromPath == '/AboutBDXCX.html' && (location.href.indexOf('?action=') == -1 || location.href.indexOf('?action=1') > -1)) { fromHome = true; }
		if (toPath == '/' || toPath.indexOf('/?') > -1 || toPath.indexOf('/#') > -1 || toPath.indexOf('/AboutBDXCX.html?action=1') > -1) { toHome = true; }

		if (toPath.startsWith('/chat') && typeof _MEIQIA =='function'){
			_MEIQIA('showPanel');
			return true;
		}

		// if (fromHome == toHome) { return false; }
		// else if (fromHome && !toHome) {
		if ((fromHome || fromPath.indexOf('/ympg.html') > - 1 || fromPath.indexOf('/ympg1.html') > - 1) && !toHome) {
			var jumpUrl = encodeURIComponent(location.protocol + '//' + location.host + toPath);
			swan.webView.navigateTo({ url: '/pages/jump/jump?path=' + jumpUrl});
			return true;
		}
		else if (!fromHome && toHome) {
			swan.webView.reLaunch({ url: '/pages/index/index' });
			return true;
		}

		return false;
	}
	var last = 0;
	return function () {
		if ((new Date().getTime() - last) >= delay) {
			var context = this;
			var args = arguments;
			last = new Date().getTime();
			return method.apply(context, args);
		}
		return true;
	};
}();

/* 微信小程序跳转处理 */

var redirect_wxxcx = function (delay = 1000) {
	var method = function (target) {
		if (S_Query.Env != 'hqcgwxxcx' || !target ) { return false; }
		var fromHome = toHome = false;
		var fromPath = location.pathname;
		var toPath = target.attr('href');
		// console.log('toPath'+target.attr('href'));
		if (fromPath == '/' || fromPath == '/index/about/about_test' && (location.href.indexOf('?action=') == -1)) { fromHome = true; }
		if (toPath == '/' || toPath.indexOf('/?') > -1 || toPath.indexOf('/#') > -1 ) { toHome = true; }
console.log('fromHome='+fromHome);
console.log('toHome='+toHome);
		if (toPath.startsWith('/chat') && typeof _MEIQIA =='function'){
			console.log('startWith')
			_MEIQIA('showPanel');
			return true;
		}
		if (fromHome == toHome) {
			console.log('原页面');
			return false;
		}else if (fromHome && !toHome) {
			console.log('进来了');
			var jumpUrl = encodeURIComponent(location.protocol + '//' + location.host + toPath);
			console.log(jumpUrl);
			wx.miniProgram.navigateTo({ url: '../webview/webview?path='+jumpUrl});
			return true;
		}else if (!fromHome && toHome) {
			console.log('elesooo');
			wx.miniProgram.reLaunch({ url: '../index/index' });
			return true;
		}
		return false;
	}

		var last = 0;
	return function () {
		if ((new Date().getTime() - last) >= delay) {
			var context = this;
			var args = arguments;
			last = new Date().getTime();
			return method.apply(context, args);
		}
		return true;
	};

}();