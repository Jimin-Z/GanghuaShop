$(function(){
	$(".ajaxBtn,.get_yzm,.get_yzm_video,.get_sms").click(function(){
		var formData = $(this).closest('form').serializeObject(),//当前表单所带参数123456
			$_this = $(this),//当前按钮
			formFlag = !$_this.hasClass('disabled');//确认表单是否可以提交
			formData = $.extend(true,S_Query,formData);
			formData.Qudao = getCookie('Qudao');
			formData.cookieID = getCookie('cookieID');
			formData.T_bdUrl = getCookie('bdUrl');
			formData.T_bd0 = getCookie('bd0');
			formData.T_bd1 = getCookie('bd1');
			formData.T_bd2 = getCookie('bd2');
			formData.GoogleUrl = getCookie('GoogleUrl');
			formData.google_ckjihua = getCookie('google_ckjihua');
			formData.google_ckzu = getCookie('google_ckzu');
			formData.google_ckid = getCookie('google_ckid');
			formData.google_ckwfrom = getCookie('google_ckwfrom');
			formData.google_ckweb = getCookie('google_ckweb');
			formData.isGuwen = getCookie('isGuwen');
			formData.bd_vid = getCookie('bd_vid');
			formData.client_id = $("#F_CLIENT_ID").val() ? $("#F_CLIENT_ID").val() : '';
			formData.homeSearch = unescape(getCookie('homeSearch'));
		if(formFlag === false){
			layer.msg(S_Msg[S_lang].repeat);
			return false;
		}
		if (formData.bd_vid=='1'){
			formData.bd_vid_href = getCookie('bd_vid_href');
		}
		if (!formData.T_bdUrl && !formData.GoogleUrl){
			formData.landingUrl = getCookie('landing_page');
		}


		if ($_this.hasClass('toWindows')) {
			var _toAction = $_this.attr('toWindows_action'),
				_toSms = $_this.attr('toWindows_sms')
			if (_toAction == undefined) _toAction = '';
			if (_toSms == undefined) _toSms = '';
			toWindows($_this.attr('toWindows_id'),formData,$_this,_toAction,_toSms);
			return false;
		}
		if(formData.userName !== undefined && formData.userName === ''){
			layer.msg(S_Msg[S_lang].name);
			return false;
		}
		if(formData.tel !== undefined && formData.tel === ''){
			layer.msg(S_Msg[S_lang].tel);
			return false;
		}
		formData.regular = $("[name = 'countrycode']").children('option:selected').attr("regular");
		var checkTelResult = matchTel(formData);
		if(!checkTelResult){
			// if($(".PopupHidUserName").length > 0) {
			// 	$(".PopupHidUserName").css("display", "show");
			// }
			// if($(".PopupHidTel1").length > 0) {
			// 	$(".PopupHidTel1").css("display", "show");
			// }
			// if($(".PopupHidTel2").length > 0) {
			// 	$(".PopupHidTel2").css("display", "show");
			// 	$(".tjBtn").css("float","none");
			// }
			layer.msg(S_Msg[S_lang].codeAndTel);
			return false;
		}
		if(formData.captcha !== undefined && formData.captcha === ''){
			layer.msg(S_Msg[S_lang].captcha);
			//走自己网站验证码验证;
			return false;
		}
		if(formData.captcha !== undefined && formData.captcha !== ''){
			if(!verifyCode.validate(formData.captcha)){
				layer.msg(S_Msg[S_lang].captchaError);
				return false;
			}
		}
		if($_this.hasClass('get_sms_passport') || $_this.hasClass('get_yzm') || $_this.hasClass('get_yzm_video') || $_this.hasClass('get_sms')){
			$_this.addClass('disabled');
			//发送验证码
			if($_this.hasClass('get_yzm_video')){
				RequestPwd(formData,$_this,'','','requestPwdVideo')
			}else if($_this.hasClass('get_sms')){
				RequestPwd(formData,$_this,'','',$_this.attr('window_action'))
			}else{
				RequestPwd(formData,$_this)
			}
			return false;
		}
		//表单存在手机验证码时，验证短信不能为空
		// if(formData.pwd !== undefined && formData.pwd === '' && getCookie('phone') == '' && formData.tel != '13111111111'){
		if(formData.pwd !== undefined && formData.pwd === '' && getCookie('phone') == ''){
			layer.msg(S_Msg[S_lang].pwd);
			return false;
		}
		//表单存在手机验证码时，验证短信验证码
		// if (formData.pwd !== undefined && formData.pwd !== '' && formData.tel != '13111111111') {
		if (formData.pwd !== undefined && formData.pwd !== '') {
			if (checkPwd(formData)) {
				layer.msg(S_Msg[S_lang].pwdError);
				return false;
			}
		}

		//根据不同网站，设置不同

		console.log(100200300);
		console.log(parseInt(formData.type));

		if(formData.Differ !== undefined && formData.Differ === 'follow_writer'){
			console.log('撰稿人的东西')
		}
		switch(parseInt(formData.type)){
			case 0:
			case 5://pc系列
				switch(formData.action){
					case 'event_gather':
						var othermark = "";
						if(formData.eventID){
							var event_text = $(".event_name option:selected").text();
							formData.otherMark = "选择的活动是："+event_text;
						}else{

							for(var i=0;i<$(".choose_li").length;i++){
								othermark=othermark+$(".choose_li").eq(i).text()+";";
							}
							formData.otherMark = othermark;
						}
					break;
					case 'zt_public':
						formData.sceneName = $('#sceneName').val();
					break;
					case 'pingfen_nlz':
						var pd=true;
						$(".tm_qh").each(function () {
							if($(this).find(".choose_li").length || $(this).find(".choose_dd").length){

							}else{
								pd=false;
							}
						});

						if(!pd){
							layer.msg("请选择");
							return false;
						}
						formData.sceneName = $('#sceneName').val();
						var mark = score_tm_pj();
						if(mark==""){
							mark = $('#mark').val();
							formData.otherMark = mark;
						}
						formData.sceneId = $('#sceneId').val();
						formData.preFixion = $('#prefix').val();
						formData.projectID = $('#link_project').val();
						formData.cookieID = getCookie("cookieID");

						var score = score_zf();

						if(score==""){
							score = $('#score').val();
							formData.score = score;
						}else{
							formData.score = score;
						}

					break;
					case 'ksbz':
						formData.otherMark ="";
						$(".choose_t").find(".choose_li").each(function(){
							var title = $(this).parent(".clearfix").siblings("span").html();
							title = title.replace(/<.*?>/ig,"");
							var a = $(this).html()
							formData.otherMark +=title+":"+a+"。";
						})
					break;
					case 'azknxh':
						formData.otherMark = "城市:"+formData.city;
					break;

					case 'contrast':
						var ids = names = "";
						$(".pitch-up-current").each(function(i, e) {

							ids += $(this).attr("name") + ",";

							names += $(this).attr("title") + ",";

						});
						formData.countryID = ids.substring(0, ids.length - 1);
						names = names.substring(0, names.length - 1);
						formData.otherMark = '对比国家:'+ names;
						$("#selected").val(formData.countryID);

						$("#countryName").val(names);
						if($('#selected').val() == '') {

							layer.msg("请选择对比项目!");
							return false;
						}
					break;
					case 'ywbd':
						formData.question = $('.question_text').val();
						if(formData.question == '') {
							layer.msg("请填写提问内容");
							return false;
						}
						formData.otherMark = "提问内容:"+formData.question;
						formData.projectID = $('.id_value').val();
					break;
					case 'fytc':
						if(formData.ymProject == '') {
							layer.msg("请选择移民项目");
							return false;
						}
						// if($(".tjrs").html()=='' || $(".tjrs").html()=='希望添加人数'){
						// 	layer.msg("请选择申请人数");
						// 	return false;
						// }

						$(".ajaxBtn").html("计算中...");

						formData.otherMark = '获取费用项目：' + formData.ymProject;
					break;
					case 'fyym'://费用页面
						if(formData.ymProject == '') {
							layer.msg("请选择移民项目");
							return false;
						}
						$(".ajaxBtn").html("计算中...");
						formData.otherMark = '获取费用项目：' + formData.ymProject;
					break;
					case 'ymfy_new':
						formData.yxgj = $.trim($("#dbyxgj").val());
						var ymmdfy = $.trim($("#dbyxxm").val())
						if(formData.yxgj == '') {
							layer.msg("请选择移民国家");
							return false;
						} else if(ymmdfy == '') {
							layer.msg("请选择移民项目");
							return false;
						}
						formData.otherMark = '获取费用项目：' + ymmdfy;
					break;
					case 'sqzl':
						var result= '';
						$(".sa_select").each(function(){
							if($(this).find("i").hasClass("sa_select_off")){
								result += ','+$(this).parent("li").find("dl").text().trim();

							}

						})
						//其他备注拼接字段
						formData.otherMark = '索取项目:'+result.substring(1);
					break;
					case 'xxlhj':
						if(formData.qf == '1'){
							formData.one = $("#radio1").val();
							formData.two = $("#radio2").val();
							formData.three = $("#radio3").val();
							formData.four = $("#radio4").val();;
							formData.five = $("#radio5").val();
							formData.six = $("#radio6").val();
							if(formData.one == '' || formData.two == '' || formData.three == '' || formData.four == '') {
								layer.msg('请您勾选答案');
								return false;
							}
						}
					break;
					case 'active':
					case 'threeyc':
						if(formData.newsname != undefined){
							formData.otherMark = "报名活动:"+formData.newsname;
						}
					break;
					case 'crowdfunding':
						formData.otherMark = "众筹活动:"+formData.newsname;
					break;

					case 'ymzzfw':
						formData.otherMark = "续签服务:"+formData.xqfw;
					break;
					case 'thanks_letter':
						formData.otherMark = $('#letter').val();
					break;

					case 'hfsdfy':
						formData.otherMark = "锁定房源信息:" + formData.info;
					break;
					case 'lxtc':
						formData.otherMark = "留学项目:" + formData.xm;
					break;
					case 'zxly':
						if(formData.ps == ''){
							layer.msg('请填写留言内容');
							return false;
						}
						formData.otherMark = '留言内容:'+formData.ps;
					break;
					case 'shipin':
						formData.otherMark = "观看视频:" + formData.title;
					break;


					case 'successCase':
						var _length = $('.form_xq_choose').find('.choose_li').length;
						var arr = new Array();
						if(_length > 0) {
							for( var i = 0; i < _length; i++) {
								arr[i] = $('.form_xq_choose').find('.choose_li em').eq(i).text();
							}
						}

						formData.otherMark = '需求:'+arr;
					break;

					case 'integrated_technology':
						var education = $('.education').find('.choose_li').text();
						var effect = $('.effect').find('.choose_li').text();

						var _length = $('.occupation').find('.choose_li').length;
						var arr = new Array();
						if(_length > 0) {
							for( var i = 0; i < _length; i++) {
								arr[i] = $('.occupation').find('.choose_li').eq(i).text();
							}
						}

						formData.otherMark = "您具备的最高全日制学历？" + education + ";您是否具备国家级或国际级影响力，如国家或国际级奖项、期刊论文、媒体采访、评审等？" + effect +";您的职业是？" + arr;
					break;

					case 'ozfc':
						formData.three = $.trim($("#jzsj").val());
						formData.four = $.trim($("#yynl").val());
						formData.five = $.trim($("#cgbl").val());
						formData.six = $.trim($("#age").val());
						formData.seven = $.trim($("#xl").val());
						formData.eight = $.trim($("#jy").val());
						formData.one = $.trim($("#uymys").val());
						formData.two = $.trim($("#uymmd").val());
						formData.nine = $('.new_hdsf').val();
						formData.ten = $('.new_yxgj').val();
						if(formData.one == "── 请选择 ──") {
							layer.msg("请选择您的移民预算！");
							return false;
						} else if(formData.two == "── 请选择 ──") {
							layer.msg("请选择您的移民目的！");
							return false;
						} else if(formData.three == "── 请选择 ──") {
							layer.msg("请选择您的居住时间！");
							return false;
						}
					break;
					case 'studyEvaluation':
						formData.otherMark = '';
						if($(".t1").val() == '') {
							layer.msg("您孩子的意向求学国家和地区是哪里?");
							return false;
						} else if($(".t2").val() == '') {
							layer.msg("您孩子选择留学阶段?");
							return false;
						} else if($(".t3").val() == '') {
							layer.msg("您选择让孩子出国留学的因素是?");
							return false;
						}
						formData.t1 = $(".t1").val() ? $(".t1").val() : '';
						formData.otherMark += '您孩子的意向求学国家和地区是:' + formData.t1;
						formData.t2 = $(".t2").val() ? $(".t2").val() : '';
						formData.t2 = '孩子选择留学阶段:' + formData.t2;
						formData.otherMark += ',孩子选择留学阶段:' + formData.t2;
						formData.t3 = $(".t3").val() ? $(".t3").val() : '';
						formData.otherMark += ',您选择让孩子出国留学的因素是:' + formData.t3;
						formData.t4 = $(".t4").val() ? $(".t4").val() : '';
						formData.otherMark += ',您孩子的全科平均成绩是:' + formData.t4;
						formData.t5 = $(".t5").val() ? $(".t5").val() : '';
						formData.otherMark += ',AEAS:' + formData.t5;

						formData.t6 = $(".t6").val() ? $(".t6").val() : '';
						formData.otherMark += ',SSAT:' + formData.t6;

						formData.t7 = $(".t7").val() ? $(".t7").val() : '';
						formData.otherMark += ',IELTS成绩:' + formData.t7;
						formData.t8 = $(".t8").val() ? $(".t8").val() : '';
						formData.otherMark += ',TOFEL成绩:' + formData.t8;
						formData.t9 = $(".t9").val() ? $(".t9").val() : '';
						formData.otherMark += ',其他成绩:' + formData.t9;
						formData.t10 = $(".t10").val() ? $(".t10").val() : '';
						formData.otherMark += ',您的孩子更倾向于哪种学习环境:' + formData.t10;
						formData.t11 = $(".t11").val() ? $(".t11").val() : '';
						formData.otherMark += ',留学预算:' + formData.t11;
						formData.t12 = $(".t12").val() ? $(".t12").val() : '';
						formData.otherMark += ',你的孩子目前在国内就读的学校名称:' + formData.t12;
						formData.t13 = $(".t13").val() ? $(".t13").val() : '';
						formData.otherMark += ',年级:' + formData.t13;
					break;
					case 'pingfen_elitist':
						formData.sceneName = '加拿大杰出人才';
						formData.sceneId = '106';
						formData.preFixion = 'GWZ92';
						formData.yxgj = '加拿大';
					break;
					case 'pingfen_kj':
						formData.marry = $('#marry').val();
						formData.t1 = $(".t1:checked").val();
						formData.t2 = $(".t2:checked").val();
						formData.t3 = $(".t3:checked").val();
						formData.t4 = $(".t4:checked").val();
						formData.t5 = $(".t5:checked").val();
						formData.t6 = $(".t6:checked").val();
						formData.t7 = $(".t7:checked").val();
						formData.t8 = $(".t8:checked").val();
						formData.t9 = $(".t9:checked").val();
						formData.t10 = $(".t10:checked").val();
						formData.t11 = $(".t11:checked").val();
						formData.t12 = $(".t12:checked").val();
						formData.t13 = $(".t13:checked").val();
						formData.t14 = $(".t14:checked").val();
						formData.t15 = $(".t15:checked").val();
						formData.id10 = $(".t10:checked").attr('id');
						formData.id11 = $(".t11:checked").attr('id');
						formData.score10 = $('.'+formData.id10).val();
						formData.score11 = $('.'+formData.id11).val();
						formData.sceneName = '加拿大魁省技术移民';
						formData.sceneId = '76';
						formData.score = 0;
						$(".xz").each(function(){
							formData.score += parseInt($(this).val());
						})
					break;
					case 'pingfen_yc':

						formData.pflx = formData.t0;
						formData.advantage = '';
						if (typeof formData.t2 == 'object') {
							var t2 = '';
							$.each(formData.t2,function(i,item) {
								t2 += ','+item;
							})
							formData.t2 = t2.substring(1);
						}
						if (typeof formData.t3 == 'object') {
							var t3 = '';
							$.each(formData.t3,function(i,item) {
								t3 += ','+item;
							})
							formData.t3 = t3.substring(1);
						}
						$('input[name="t9"]:checked').each(function(){
							formData.advantage += ','+$(this).val();
						});
						formData.advantage = formData.advantage.substring(1);
						formData.sceneName = '香港优才计划评分';
						formData.sceneId = '73';
					break;
					case 'pingfen_aj':
						formData.t1 = $(".t1:checked").val();
						formData.t2 = $(".t2:checked").val();
						formData.t3 = $(".t3:checked").val();
						formData.t4 = $(".t4:checked").val();
						formData.t5 = $(".t5:checked").val();
						formData.t6 = $(".t6:checked").val();
						formData.t7 = $(".t7:checked").val();
						formData.t8 = $(".t8:checked").val();
						formData.t9 = $(".t9:checked").val();
						formData.t10 = '';
						$('input[name="t10"]:checked').each(function(){
							formData.t10 += ','+$(this).val();
						});
						formData.t10 = formData.t10.substring(1);
						console.log(formData.t10);
						formData.t11 = $(".t11:checked").val();
						formData.sceneName = '澳洲独立技术';
						formData.sceneId = '68';
					break;
					case 'pingfen':
						formData.sceneName = '加拿大联邦技术';
						formData.sceneId = '75';
						formData.preFixion = 'GWA1';
						formData.t1 = $(".t1:checked").val();
						formData.t2 = $(".t2:checked").val();
						formData.t3 = $(".t3:checked").val();
						formData.t4 = $(".t4:checked").val();
						formData.t5 = $(".t5:checked").val();
						formData.t6 = $(".t6:checked").val();
						formData.t7 = $(".t7:checked").val();
						formData.t8 = $(".t8:checked").val();
						formData.t9 = $(".t9:checked").val();
						formData.t10 = $(".t10:checked").val();
						formData.t11 = $(".t11:checked").val();
						formData.t12 = $(".t12:checked").val();
						formData.t13 = $(".t13:checked").val();
						formData.t14 = $(".t14:checked").val();
						formData.t15 = $(".t15:checked").val();
						formData.t16 = $(".t16:checked").val();
						formData.t17 = $(".t17:checked").val();
						formData.t18 = $(".t18:checked").val();

						formData.t19 = $(".t19:checked").val();
						formData.t20 = $(".t20:checked").val();
						formData.t21 = $(".t21:checked").val();
						formData.t22 = $(".t22:checked").val();
						formData.t23 = $(".t23:checked").val();
						formData.t24 = $(".t24:checked").val();

						formData.m1 = $(".t1:checked").siblings('.t1_a').val();
						formData.m2 = $(".t2:checked").siblings('.t2_a').val();
						formData.m3 = $(".t3:checked").siblings('.t3_a').val();
						formData.m4 = $(".t4:checked").siblings('.t4_a').val();
						formData.m5 = $(".t5:checked").siblings('.t5_a').val();
						formData.m6 = $(".t6:checked").siblings('.t6_a').val();
						formData.m7 = $(".t7:checked").siblings('.t7_a').val();
						formData.m8 = $(".t8:checked").siblings('.t8_a').val();
						formData.m9 = $(".t9:checked").siblings('.t9_a').val();
						formData.m10 = $(".t10:checked").siblings('.t10_a').val();
						formData.m11 = $(".t11:checked").siblings('.t11_a').val();
						formData.m12 = $(".t12:checked").siblings('.t12_a').val();
						formData.m13 = $(".t13:checked").siblings('.t13_a').val();
						formData.m14 = $(".t14:checked").siblings('.t14_a').val();
						formData.m15 = $(".t15:checked").siblings('.t15_a').val();
						formData.m16 = $(".t16:checked").siblings('.t16_a').val();
						formData.m17 = $(".t17:checked").siblings('.t17_a').val();
						formData.m18 = $(".t18:checked").siblings('.t18_a').val();
						formData.m19 = $(".t19:checked").siblings('.t19_a').val();
						formData.m20 = $(".t20:checked").siblings('.t20_a').val();
						formData.m21 = $(".t21:checked").siblings('.t21_a').val();
						formData.m22 = $(".t22:checked").siblings('.t22_a').val();
						formData.m23 = $(".t23:checked").siblings('.t23_a').val();
						formData.m24 = $(".t24:checked").siblings('.t24_a').val();
						formData.yxgj = "加拿大";
						formData.ymmd = "子女教育";
					break;
					case 'pingfen_auto':
						formData.otherMark = '';
						function CommonException(message, code){
							this.message = message;
							this.code = code;
						}
						$('.must').each(function(){
							var value = $(this).find("input[type='radio']:checked").val();
							if(!value){
								flag = true;
								layer.msg('为保证评估准确，请完成必选题！');
								var exception = new CommonException('必选未完成', 1);
								throw exception;
							}
						})
						formData.sceneId = $('#sceneId').val();
						formData.preFixion = $('#prefix').val();
						formData.sceneName = $('#sceneName').val();
						formData.projectID = formData.link_project = $('#link_project').val();
						var pingfenData = $('#formData').serializeArray();
						var score = 0;
						$.each(pingfenData,function(){
							var dataArr = (this.value).split('|||');
							formData.otherMark += dataArr[0]+' : '+dataArr[1]+'; ';
							score += Number(dataArr[2]);
						})
						if(score < 0){
							score = 0;
						}
						formData.score = score;

					break;
				}
			break;
			case 1:
			case 6://MO系列
			case 10:
			case 33:
			case 35:
				if (formData.type == 10) {
					formData.nickName = $("#wx_nickname").val();
					if (pathname.indexOf('OnlineActivities') !== -1){
						formData.sharing = sharing || 'xiaoxi';
					}else{
						if (pathname.indexOf('/type/qyWork') !== -1) {
							formData.sharing = 'xiaoxi';
						}else{
							formData.sharing = shareUsrLogin;
						}
					}
					formData.isGuwen = getCookie('isGuwen');
				}
				switch(formData.action){

					case 'ygtz':
						formData.otherMark = '';
						$(".bp_question dl").each(function(){
							formData.otherMark += $(this).find('dt').html();
							$(this).find('input').each(function(){
								if($(this).is(":checked")){
									formData.otherMark += ':'+$(this).val();
								}
							})
							formData.otherMark += ';';
						})
					break;
					case 'pingfen_elitist':
						formData.sceneName = '加拿大杰出人才';
						formData.sceneId = '106';
						formData.preFixion = 'GWZ92';
						formData.yxgj = '加拿大';
					break;

					case 'thanks_letter':
						formData.otherMark = $('#letter').val();
					break;

					case 'zxly':
						if(formData.ps == ''){
							layer.msg('请填写留言内容');
							return false;
						}
						formData.otherMark = '留言内容：'+formData.ps;
					break;
					case 'azknxh':
							formData.otherMark = '城市：'+formData.city;
					break;
					case 'crs_text':
						formData.otherMark = ',1.您的资产情况？:' + $.trim($(".item-box1 .current").text()) + ',2.你是否拥有海外账户？:' + $.trim($(".item-box2 .current").text()) + ',3.你是否拥有第二本护照？:' + $.trim($(".item-box3 .current").text()) + ',4.你是否拥有海外常住地址？:' + $.trim($(".item-box4 .current").text()) + ',5.你是否拥有海外纳税号？:' + $.trim($(".item-box5 .current").text());
					break;
					case 'azymtj':
						if (formData.qf == '1') {
							formData.otherMark = '意向项目：'+formData.yxxm;
						}
					break;
					case 'pingfen_yc':

						formData.pflx = formData.t0;
						formData.advantage = '';
						formData.advantage = formData.t9;
						formData.sceneName = '香港优才计划评分';
						formData.sceneId = '73';
					break;
					case 'pingfen_land':
						formData.t1 = $("#t0 option:selected").val();

						formData.t2 = $("#t1 option:selected").val();

						formData.t3 = $("#t2 option:selected").val();

						formData.t4 = $("#t3 option:selected").val();

						formData.t5 = $("#t4 option:selected").val();

						formData.t6 = $("#t5 option:selected").val();

						formData.t7 = $("#t6 option:selected").val();

						formData.t8 = $("#t7 option:selected").val();

						formData.t9 = $("#t8 option:selected").val();

						formData.t10 = $("#t9 option:selected").val();

						formData.t11 = $("#t10 option:selected").val();

						formData.m1 = $("#t1 option:selected").html();
						formData.m2 = $("#t2 option:selected").html();
						formData.m7 = $("#t7 option:selected").html();
						formData.m10 = $("#t10 option:selected").html();

						formData.sceneName = '新西兰派遣创业移民';
						formData.sceneId = '5';
						formData.preFixion = 'GWZ5';
						formData.yxgj = '新西兰';
					break;
					case 'pingfen_aj':

						//获取ABCD选项
						formData.t1 = $(".t1").val();
						formData.t2 = $(".t2").val();
						formData.t3 = $(".t3").val();
						formData.t4 = $(".t4").val();
						formData.t5 = $(".t5").val();
						formData.t6 = $(".t6").val();
						formData.t7 = $(".t7").val();
						formData.t8 = $(".t8").val();
						formData.t9 = $(".t9").val();
						formData.t10 = $(".t10").val();
						formData.t11 = $(".t11").val();

						formData.sceneName = '澳洲独立技术';
						formData.sceneId = '68';
						formData.projectID = formData.link_project = '16,67';
					break;
					case 'xxlhj':
						if(formData.qf == '1'){
							formData.one = $("#a").val();
							formData.two = $("#b").val();
							formData.three = $("#c").val();
							formData.four = $("#d").val();;
							formData.five = $("#e").val();
							formData.six = $("#f").val();
							if(formData.one == '' || formData.two == '' || formData.three == '' || formData.four == '') {
								layer.msg('请您勾选答案');
								return false;
							}
						}
					break;
					case 'fyym':
					 //底部费用弹窗
						if(formData.ymProject == '') {
							layer.msg("请选择移民项目");
							return false;
						}
						//console.log($(".tjrs").hasClass("choose_em"));

						if($(".gfc_people_xq").css("display")=="flex"){
							if($(".tjrs").hasClass("choose_em")==false){

								layer.msg("请选择申请人数");
								return false;

							}
						}

						/* if($(".gfc_left_sqfs").css("display")=="flex"){
							if($(".sqfs").hasClass("choose_em")==false){

								layer.msg("请选择申请方式1");
								return false;

							}

						} */
						formData.otherMark = '获取费用项目：' + formData.ymProject;
					break;


					case 'pingfen':
						formData.sceneName = '加拿大联邦技术';
						formData.sceneId = '75';
						formData.preFixion = 'GWA1';
						formData.age = $("#age option:selected").val();

						formData.marry = $("#marry option:selected").val();

						formData.lang = $("#lang option:selected").val();

						formData.t1 = $("#t1 option:selected").val();

						formData.t2 = $("#t2 option:selected").val();

						formData.t3 = $("#t3 option:selected").val();

						formData.t4 = $("#t4 option:selected").val();

						formData.t5 = $("#t5 option:selected").val();

						formData.t6 = $("#t6 option:selected").val();

						formData.t7 = $("#t7 option:selected").val();

						formData.t8 = $("#t8 option:selected").val();

						formData.t9 = $("#t9 option:selected").val();

						formData.t10 = $("#t10 option:selected").val();

						formData.t11 = $("#t11 option:selected").val();

						formData.t12 = $("#t12 option:selected").val();

						formData.t13 = $("#t13 option:selected").val();

						formData.t14 = $("#t14 option:selected").val();

						formData.t15 = $("#t15 option:selected").val();

						formData.t16 = $("#t16 option:selected").val();

						formData.t17 = $("#t17 option:selected").val();

						formData.t19 = $("#t19 option:selected").val();

						formData.t20 = $("#t20 option:selected").val();

						formData.t21 = $("#t21 option:selected").val();

						formData.t22 = $("#t22 option:selected").val();

						formData.t23 = $("#t23 option:selected").val();

						formData.t24 = $("#t24 option:selected").val();
						formData.yxgj = "加拿大";
						formData.ymmd = "子女教育";
					break;

					case 'active':
						formData.eventID = formData.eventID;
						if(formData.newsname != undefined){
							formData.otherMark = "报名活动："+formData.newsname;
						}
					break;

					case 'threeyc':
						if(formData.newsname != undefined){
							formData.otherMark = "报名活动："+formData.newsname;
						}
					break;

					case 'crowdfunding':
						formData.otherMark = "众筹活动："+formData.newsname;
					break;
					//澳洲综合
					case 'Australia_synthesis':
						formData.otherMark ="";
						$(".form_t").each(function(){

							if($(this).find("dd").hasClass("choose_z")){

								var title = $.trim($(this).find("dt").html());
								var a = $.trim($(this).find(".choose_z").html());
								formData.otherMark +=title+":"+a+"。";
							}


						})
					break;

					case 'enmoform':

						formData.otherMark ="预算："+$(".budget").val()+";从哪里听说我们："+$(".targeted").val();
					break;


					case 'pingfen_auto':
						function CommonException(message, code){
							this.message = message;
							this.code = code;
						}

						formData.sceneId = $('#sceneId').val();
						formData.preFixion = $('#prefix').val();
						formData.sceneName = $('#sceneName').val();
						formData.projectID = formData.link_project = $('#link_project').val();

						var score = 0;
						formData.otherMark = '';

						$(".choose_dd").each(function(){
							var dataArr = $(this).attr("value").split('|||');

							var topic = dataArr[0];
							var answer = dataArr[1];
							if(topic){
								if(!answer){
									answer = '';
								}
								if(!Number(dataArr[2])){
									dataArr[2] = 0;
								}
								formData.otherMark += dataArr[0]+' : '+dataArr[1]+'; ';
								score += Number(dataArr[2]);
							}
						})

						if(score < 0){
							score = 0;
						}
						formData.score = score;
						console.log(formData.otherMark);

					break;


					case 'pingfen_nlz':
						/*总分计算*/
						function score_zf(){
							var score_zf=0;
							$(".save_val").each(function () {
								score_zf=score_zf+parseInt($(this).val());
								console.log($(this).val())
							});
							return score_zf;
						}

						/*总题目 已经选题累加*/
						function score_tm_pj(){
							var score_tm_pj="";
							for(var i=0;i<$(".score_tm").length;i++){
								score_tm_pj=score_tm_pj+$(".score_title").eq(i).val()+$(".score_tm").eq(i).val()+";";
							}
							return score_tm_pj.substring(0,score_tm_pj.length-1);
						}

						formData.sceneId = $('#sceneId').val();
						formData.preFixion = $('#prefix').val();
						formData.sceneName = $('#sceneName').val();
						formData.projectID = formData.link_project = $('#link_project').val();
						formData.score = score_zf();
						formData.otherMark = score_tm_pj();
					break;

					case 'ywbd':
						formData.question = $('.question_text').val();
						//formData.countrycode = $("#PopupinternationalCountryNo").val();
						if(formData.question == '') {
							layer.msg("请填写提问内容");
							return false;
						}

						formData.otherMark = "提问内容:"+formData.question;
						formData.projectID = $('.id_value').val();
					break;
					case 'zt_public':
						formData.sceneName = $('#sceneName').val();
					break;
					case 'tg_public':
						formData.sceneName = $('#sceneName').val();
					break;

					case 'studyEvaluation':
						var yxgj=$("#yxgj").val();
						var lxjd=$("#lxjd").val();
						var pjcj=$("#pjcj").val();
						var lxys=$("#lxys").val();

						if(yxgj==""){
							layer.msg('请选择意向国家');
							return false;
						}else if(lxjd==""){
							layer.msg('请选择留学阶段');
							return false;
						}else if(pjcj==""){
							layer.msg('请选择平均成绩');
							return false;
						}else if(lxys==""){
							layer.msg('请选择留学预算');
							return false;
						}

						formData.otherMark = "意向国家：" + yxgj + "，留学阶段：" + lxjd + "，平均成绩：" + pjcj + "，留学预算：" + lxys;

					break;

					case 'contrast':
						countryIDs = "";
						countryNames = "";

						$(".choose_city").each(function(){
							countryIDs=countryIDs+$(this).attr("name")+",";
							countryNames=countryNames+$(this).find(".ym_country_name span").eq(0).text()+",";
							$.trim(countryNames);
						})

						countryIDs=countryIDs.substring(0,countryIDs.length-1);
						countryNames=countryNames.substring(0,countryNames.length-1);

						if(countryIDs==""){
							layer.msg("请选择对比项目!");
							return false;
						}

						formData.countryIDs  = countryIDs;
						formData.otherMark = '对比国家：'+ countryNames;


					break;
					case 'sqzl':
						var result = [];
						for(var i = 0; i < $(".box-li ul .cur").length; i++) {
							result += $(".box-li ul .cur:eq(" + i + ")").html() + ",";
						}
						if(result == '') {
							layer.msg("请选择项目");
							return false;
						}
						formData.otherMark = '索取项目：' + result.substring(0, (result.length) - 1);
					break;

					case 'free_assessment':
						var allChoiceData = $(".allChoiceData").val();
						var mandatory = $(".mandatory").val();
						if(allChoiceData){
							var dataSplit = allChoiceData.split("!!!");
							var questionArr =new Array();
							var mandatoryArr = [];
							for(var i = 0; i < dataSplit.length; i++) {
								var newSplit = dataSplit[i].split("@@@");
									questionArr[i] = newSplit[0];
							}

							var mandatorySplit = mandatory.split(",");
							for(var i = 0; i < mandatorySplit.length; i++) {
								var newSplit = mandatorySplit[i].split("#");
								if(newSplit[0]){
									mandatoryArr[newSplit[0]] = newSplit[1];
								}

							}
							var pd =0;
							$.each(mandatoryArr, function(inde,q){
								if(q!=undefined){

									var index = $.inArray(inde.toString(),questionArr);
									if(index >= 0){
										pd =0;
									}else{
										///layer.msg('请选择'+q);
										pd = 1;
										return false;
									}

								}

							});

							formData.allChoiceData = allChoiceData;


					   }else{

						   layer.msg('请选择题目！！！');
							return false;
					   }

					break;
					case 'ymzc':
						if($(".item_ys").eq(0).find("dd>span").hasClass("span_hbj")){
							$(".item_ys").eq(0).find("dd>span").each(function () {
								if($(this).hasClass("span_hbj")){
									formData.ymys = formData.one = $(this).text().trim();
								}
							})
						}else{
							layer.msg("选择您的移民预算");
							return false;
						}


						if($(".item_ys").eq(1).find("dd>span").hasClass("span_hbj")){
							$(".item_ys").eq(1).find("dd>span").each(function () {
								if($(this).hasClass("span_hbj")){
									formData.two = $(this).text().trim();
									//alert(two);
								}
							})
						}else{
							layer.msg("选择您的移民目的");
							return false;
						}

						if($(".item_ys").eq(2).find("dd>span").hasClass("span_hbj")){
							$(".item_ys").eq(2).find("dd>span").each(function () {
								if($(this).hasClass("span_hbj")){
									formData.nine = $(this).text().trim();
									//alert(three);
								}
							})
						}else{
							layer.msg("选择您希望获得的身份");
							return false;
						}

						if($(".item_ys").eq(3).find("dd>span").hasClass("span_hbj")){
							$(".item_ys").eq(3).find("dd>span").each(function () {
								if($(this).hasClass("span_hbj")){
									formData.three = $(this).text().trim();
									//alert(four);
								}
							})
						}else{
							layer.msg("选择您的居住天数");
							return false;
						}

						formData.four=$('#yynl').val();
						formData.five="";
						formData.six=$('#age').val();
						formData.seven=$('#education').val();
						formData.eight=$('#gljy').val();
					break;
					default:
					break;
				}
			break;
			case 7://英文PC

				//$(".sl_content").addClass("sl_content_all")
				switch(formData.action){
					case 'fyym'://费用页面

		            	if (formData.ymProject == ''){
		                    layer.msg("Choose at least one project");
		                    return false;
						}
		                if (formData.p_total == ''){
		                    layer.msg("Choose at least one applican");
		                    return false;
		                }
						$(".ajaxBtn").html("In calculation...");
						formData.otherMark = '获取费用项目：' + formData.ymProject;
					break;
					case 'CaSelf_Assm':
						formData.link_project=198;
						break;
					case 'partners':
					case 'CaCEC_Assm':

					break;
					case 'AusSkill_Assm':
						if (!$.trim(formData.email) || !/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(formData.email)) return layer.msg("Please enter your e-mail"),
						!1;
						formData.t2 = 'Nationality:' + formData.t2;
						formData.t5 = 'Graduated Institution:' + formData.t5;
						formData.t8 = 'Year of graduation:' + formData.t8;
						formData.t10 = 'Current Occupation Industry 、 Position:' + formData.t10;
						formData.t10_2 = 'Current Occupation Industry 、 Position:' + formData.t10_2;
						formData.t13_2 = 'age of spouse if applicable:' + formData.t13_2;
						formData.t14_2 = 'age of the oldest children:' + formData.t14_2;
						formData.Industry = 'Work & Education Background of spouse/ partner:' + formData.Industry;
						formData.title2 = 'Work & Education Background of spouse/ partner Job Title:' + formData.title2;
					break;
					case 'SaskSkill_Assm':
						if (!$.trim(formData.t3)) return layer.msg("Please enter your Occupation"),
						!1;

						if (!$.trim(formData.t8)) return layer.msg("Please enter Have minimum net worth of CA$ 20,000 which was obtained legally (3-month deposit proof is required)"),
						!1;
					break;
					case 'UsEB_Assm':
						if (!$.trim(formData.email) || !/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(formData.email)) return layer.msg("Please enter your e-mail"),
						!1;
						formData.t2 = 'Nationality:' + formData.t2;
						formData.t5 = 'Graduated Institution:' + formData.t5;
						formData.t8 = 'Year of graduation:' + formData.t8;
						formData.t10 = 'Current Occupation Industry 、 Position:' + formData.t10;
						formData.t10_2 = 'Current Occupation Industry 、 Position:' + formData.t10_2;
						formData.t13_2 = 'age of spouse if applicable:' + formData.t13_2;
						formData.t14_2 = 'age of the oldest children:' + formData.t14_2;
						formData.Industry = 'Work & Education Background of spouse/ partner:' + formData.Industry;
						formData.title2 = 'Work & Education Background of spouse/ partner Job Title:' + formData.title2;
					break;
					case 'HkQMAS_Assm':
						formData.link_project=53;
						alert(formData.link_project)
						/* if (!$.trim(formData.email) || !/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(formData.email)) return layer.msg("Please enter your e-mail"),
						!1;  */
					break;
					case 'CaFedSkill_Assm':
						if (!$.trim(formData.email) || !/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(formData.email)) return layer.msg("Please enter your e-mail"),
						!1;

						var info = {};
						$('.online').each(function(){

							info['t'+$(this).attr('nn')] = !$(this).find('.li_true').attr('ee') ? '' : $(this).find('.li_true').attr('ee');
							info['m'+$(this).attr('nn')] = !$(this).find('.li_true span').html() ? '' : $(this).find('.li_true span').html();
						});
						info['marry'] = $('#marry').val();
						info['lang'] = $('#lang').val();
						info['dr'] = $('#dr').val();
						info['hearus'] = $('#hearus').val();
						data = $.extend(true,info,data);
					break;
					case 'contentUS':
						formData.pattern = $("[name = 'countrycode']").children('option:selected').attr("regular");
						if (!$.trim(formData.salutation)) return layer.msg("Please enter your salutation"),
						!1;
						if (!$.trim(formData.userName)) return layer.msg("Please enter your first name"),
						!1;
						if (!$.trim(formData.nationality)) return layer.msg("Please enter your nationality"),
						!1;
						if (!$.trim(formData.email) || !/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(formData.email)) return layer.msg("Please enter your e-mail"),
						!1;
						if (!$.trim(formData.tel)) return layer.msg("Please enter your phone number"),
						!1;
						if ($.trim(formData.pattern)) {
							if (!eval("/" + formData.pattern + "/").test(formData.countrycode + formData.tel)) return layer.msg("Please enter your telephone"),
							!1
						} else if (!/^([1-9][0-9]{5,14})$/.test(formData.tel)) return layer.msg("Please enter your telephone"),
						!1;
						if (!$.trim(formData.hearus)) return layer.msg("Please select 'How did you hear about GLOBEVISA?' "),
						!1;
					formData.otherMark = "name:"+formData.userName + "email:"+formData.email+"Phone:"+formData.countrycode + formData.tel +" hear about us: "+formData.hearus+" Nationality: "+formData.nationality+" salutation: "+formData.salutation+" specific_question: "+formData.specific_question+" interest_location: "+formData.interest_location+" interested_in: "+formData.interested_in+" time: "+formData.time;
					break;
					case 'free_evaluating':
					if(formData.email == ''){
						layer.msg('Please enter your email');
						return false;
					}
					formData.otherMark ='姓名:'+formData.userName+',邮箱:'+formData.email+',手机号:'+formData.countrycode + formData.tel +',年龄:'+formData.Age+',意向国家:'+formData.countryprogram+',两年内是否做过英语测试:'+formData.EnglishTest+',英语有多好:'+formData.EnglishLevel+',听:'+formData.Listening+',说:'+formData.Speaking+',读:'+formData.Reading+',写:'+formData.Writing+',教育和培训:'+formData.Education+',国籍所在国家工作经验:'+formData.Homecountry+',国外工作经验:'+formData.Overseas+',婚姻状态:'+formData.MaritalStatus+',12岁以下孩子有几个:'+formData.yearsandyounger12+',13到18岁孩子有几个:'+formData.to1318years+',19岁以上孩子个数:'+formData.yearsandolder19+',从哪里听说我们：'+formData.hearus;
					break;
					case 'program_finder':
						var $_self = $(this), $_closest = $_self.closest(".question"),
							$_newwork = $_closest.find("input[name='new_work']").val(),
							$_investmentamount = $_closest.find("input[name='investment_amount']").val(),
							$_age = $_closest.find("input[name='age']:checked").val(),
							$_position = $_closest.find("input[name='position']:checked").val(),
							$_investmenttype = $_closest.find("input[name='investment_type']:checked").val(),
							$_speed = $_closest.find("input[name='speed']:checked").val(),
							$_relocation = $_closest.find("input[name='relocation']:checked").val(),
							$_mobility="",
							$_quality_of_life = $_closest.find("input[name='quality_of_life']:checked").val(),
							$_family ="",
							$_language = $_closest.find("input[name='language']:checked").val(),
							$_status = $_closest.find("input[name='status']:checked").val(),
							$_username = formData.userName,
							$_code = $_closest.find("select[name='areaCode']").find("option:selected").text().replace(/[^0-9]/gi, ""),
							$_country = $_closest.find("select[name='areaCode']").find("option:selected").text().replace(/[^A-Za-z]/gi, ""),
							$_phone = $_closest.find("input[name='tel']").val(),
							$_areaCode = $_closest.find("select[name='areaCode']").find("option:selected").attr("regular");
						$_closest.find("input[name='mobility']:checked").each(function() {

							$_mobility += $(this).val() + "/";
						});
						$_closest.find("input[name='family']:checked").each(function() {

							$_family += $(this).val() + "/";
						});

						if (!$.trim($_newwork) || $_newwork == '5' || $_newwork == '0') return layer.msg("Please enter NET WORTH"),
							!1;
						if (!$.trim($_investmentamount) || $_investmentamount == '0' || $_investmentamount == '5') return layer.msg("Please enter INVESTMENT AMOUNT"),
							!1;
						if (!$.trim($_age)) return layer.msg("Please enter AGE"),
							!1;
						if (!$.trim($_position)) return layer.msg("Please enter  POSITION"),
							!1;
						if (!$.trim($_investmenttype)) return layer.msg("Please enter INVESTMENT TYPE"),
							!1;
						if (!$.trim($_speed)) return layer.msg("Please enter SPEED"),
							!1;
						if (!$.trim($_relocation)) return layer.msg("Please enter RELOCATION"),
							!1;
						if (!$.trim($_quality_of_life)) return layer.msg("Please enter QUALITY OF LIFE"),
							!1;
						if (!$.trim($_language)) return layer.msg("Please enter Language Proficiency"),
							!1;
						if (!$.trim($_status)) return layer.msg("Please enter Immigration Status"),
							!1;
						if (!$.trim($_username)) return layer.msg("Please enter your name"),
							!1;
						if (!$.trim($_phone)) return layer.msg("Please enter your telephone"),
							!1;
						if ($.trim($_areaCode)) {
							if (!eval("/" + $_areaCode + "/").test($_code+$_phone)) return layer.msg("Please enter your telephone"),
								!1
						} else if (!/^([1-9][0-9]{5,14})$/.test($_phone)) return layer.msg("Please enter your telephone"),
							!1;
						formData.newwork = $_newwork;
						formData.investment_amount = $_investmentamount;
						formData.age = $_age;
						formData.position = $_position;
						formData.investment_type= $_investmenttype;
						formData.speed = $_speed;
						formData.relocation = $_relocation;
						formData.mobility = $_mobility;
						formData.quality_of_life = $_quality_of_life;
						formData.family = $_family;
						formData.language = $_language;
						formData.status = $_status;
						formData.userName = $_username;
						formData.tel = $_phone;
						formData.title = "program_finder";
						formData.otherMark = "NET WORTH:"+formData.newwork +"INVESTMENT AMOUNT:"+formData.investment_amount +"AGE:"+formData.age +"POSITION:"+formData.position +"INVESTMENT TYPE:"+formData.investment_type +"SPEED:"+formData.speed +"RELOCATION:"+formData.relocation +"MOBILITY:"+formData.mobility +"QUALITY OF LIFE:"+formData.quality_of_life +"FAMILY:"+formData.family +"Language Proficiency:"+formData.language +"Immigration Status:"+formData.status;
					break;
					case 'event_gather':
						var othermark = "";
						if(formData.eventID){
							var event_text = $(".event_name option:selected").text();
							formData.otherMark = "选择的活动是："+event_text;
						}else{

							for(var i=0;i<$(".choose_li").length;i++){
								othermark=othermark+$(".choose_li").eq(i).text()+";";
							}
							formData.otherMark = othermark;
						}
					break;
					case 'pingfen_auto':
						formData.otherMark = '';
						function CommonException(message, code){
							this.message = message;
							this.code = code;
						}

						$('.must').each(function(){
							var value = $(this).find("input[type='radio']:checked").val();
							console.log(value);
							if(!value){
								flag = true;
								layer.msg('To ensure result accuracy, please be sure to fill-in all the "*" questions before submission.');
								var exception = new CommonException('必选未完成', 1);
								btnStatus(_this);
								throw exception;
							}
						})

						formData.sceneId = $('#sceneId').val();
						formData.preFixion = $('#prefix').val();
						formData.sceneName = $('#sceneName').val();
						formData.projectID = formData.link_project = $('#link_project').val();
						var pingfenData = $('#formData').serializeArray();
						var score = 0;
						$.each(pingfenData,function(){
							var dataArr = (this.value).split('|||');
							formData.otherMark += dataArr[0]+' : '+dataArr[1]+'; ';
							score += Number(dataArr[2]);
						})
						if(score < 0){
							score = 0;
						}
						formData.score = score;
					break;
				}
			break;
			case 8: //英文手机
				switch(formData.action){
					case 'fyym'://费用页面

		            	if (formData.ymProject == ''){
		                    layer.msg("Choose at least one project");
		                    return false;
						}
		                if (formData.p_total == ''){
		                    layer.msg("Choose at least one applican");
		                    return false;
		                }
						$(".ajaxBtn").html("In calculation...");
						formData.otherMark = '获取费用项目：' + formData.ymProject;
					break;
				}
			break;
			case 2://客户端系列
				var $note,
					$itemBoxsLength = $('.item-box').length,
					$arr = new Array(),
					$info;
				for(var i = 0; i < $itemBoxsLength; i++ ) {
					$arr[i] = itemCheck($(".item-box" + (i + 1)));
					$note = $arr.join('; ')
				}



				if(formData.action == "khd_ymzc"){
					var hdsf = $("[name = 'hdsf']").val();

					var jzts = $("[name = 'jzts']").val();
					var age = $("[name = 'age']").val();
					var education = $("[name = 'education']").val();
					var yynl = $("[name = 'yynl']").val();
					var gljy = $("[name = 'gljy']").val();
					var email = $("[name = 'email']").val();

					//console.log(age);return false;
					formData.otherMark = "希望获得的身份:" + hdsf + ",居住天数:" + jzts + ",年龄:" + age + ",学历:" + education + ",英语能力:" + yynl + ",管理经验:" + gljy + ",邮箱:" + email;

				}else if(formData.action == "tg_public"){

					formData.sceneName = $('#sceneName').val();
					if($note != undefined && $note != '') {
						//备注
						formData.otherMark = $note;
					}

				}else if(formData.action == "khd_apecCard"){
					var one = $('#answer_one').val();
					var two = $('#answer_two').val();
					var three = $('#answer_three').val();
					formData.otherMark = '1.您出入境最大的困扰是:' + one + ',2.您每年大约出入境次数:' + two + ',3.您的主要出入境目的:' + three;
				}else if(formData.action == "khd_lxpg"){

					var lxjd = $("[name = 'lxjd']").val();
					var pjcj = $("[name = 'pjcj']").val();

					formData.otherMark = "留学阶段：" + lxjd + ",平均成绩：" + pjcj;

				}else if(formData.action == "khd_sscy"){
					var age = $("#age").val();

					var gljy = $("#gljy").val();
					var jtjzc = $("#jtjzc").val();

					formData.otherMark = "年龄:" + age + ",管理经验:" + gljy + ",家庭净资产:" + jtjzc;

				}else if(formData.action == "khd_jndlb"){ //客户端-加拿大联邦
					var rzgs = $(".rzgs_text").val();

					var gzzw = $(".gzzw_text").val();
					var rzsj = $(".rzsj_text").val();

					formData.otherMark = "您目前在国内是否有任职公司？:" + rzgs + ";您在目前工作的公司担任什么职位？:" + gzzw + ";您在该公司担任该职位的时间约多久？:" + rzsj;
				}else if(formData.action == "integrated_technology"){ //专题页-技术综合
					var education = $(".education").val();
					var award = $(".award").val();
					var work = $(".work").val();

					formData.otherMark = "1.您具备的最高全日制学历？:" + education + ";2.您是否具备国家级或国际级影响力，如国家或国际级奖项、期刊论文、媒体采访、评审等？:" + award + ";3.您的职业是？:" + work;
				}else{
					if($note != undefined && $note != '') {
						//备注
						formData.otherMark = $note;
					}

				}
			break;
		}
		for(x in formData){
			//x表示是下标，来指定变量，指定的变量可以是数组元素，也可以是对象的属性。
			if(formData[x] == undefined || formData[x] == 'undefined'){
				formData[x] = '';
			}
		}

		$_this.addClass('disabled');
		// if (!getCookie('globename')  && $('#window-modal-tcVer').length >= 1 && formData.tel != '13111111111' && formData.action != 'loginAndReg') {
		// 	RequestPwd(formData,$(".get_yzm"));
		// 	var loadVer = layer.open({
		// 		skin: 'bg-n',
		// 		type: 1,
		// 		shade: [0.3, '#000000'],
		// 		title: false,
		// 		content: $('#window-modal-tcVer'),
		// 		closeBtn: 0,
		// 		area:['calc(706rem / 75)', 'auto']
		// 	})
		// 	$("#VerPwd").bind('input propertychange',function(){
		// 		$("#window-modal-tcVer .yzcw").show();
		// 		var pwd = $.trim($(this).val());
		// 		if (pwd.length == 4) {
		// 			$.post(ApiUrl + '/Sms/smsPwdCheck', { tel : formData.tel, pwd : pwd}, function(msg) {
		// 				if (msg.ret == 200) {
		// 					layer.close(loadVer);
		// 					formData.isTrue = 1;
		// 					callBack(formData);
		// 				}else{
		// 					$("#window-modal-tcVer .yzcw").show();
		// 				}
		// 			},'json');
		// 		}else if (pwd.length > 4) {
		// 			$("#window-modal-tcVer .yzcw").show();
		// 		}
		// 	})
		// 	// 获取验证码按钮
		// 	$("#window-modal-tcVer .get_yzm").unbind('click').click(function() {
		// 		RequestPwd(formData,$(".get_yzm"));
		// 	})
		// 	$("#window-modal-tcVer .close_btn").on("click",function () {
		// 		layer.close(loadVer);
		// 		callBack(formData);
		// 	});
		// }else{
			callBack(formData);
		// }
	})
	$(".WhatsAppClick").click(function(){
		var _sub = {};
			_sub.url = window.location.href;
			_sub.type = S_Query.type;
			_sub.WhatsApp = $(this).html();
			_sub.timestamp = signature.split(',')[0];
			_sub.nonce = signature.split(',')[1];
			_sub.signature = signature.split(',')[2];
		if ($(this).attr('WhatsApp') != undefined && $(this).attr('WhatsApp') != '') {
			_sub.WhatsApp = $(this).attr('WhatsApp');
		}
		$.post(ApiUrl + '/Form/recordWAClick',_sub,function(msg){
			console.log(msg)
		})
	})
})