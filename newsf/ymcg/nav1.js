$(function () {
	/*导航部分11122233*/
	var add_s_time="";
	/*左侧加入三个标签 nav_column 用来控制纵向*/
	var nav_column="<div class='nav_column'></div>";
	var nav_kj="<div class='nav_kj_column'></div>";
	$(".nav_loop").each(function () {
		for(var i=0;i<5;i++){
			$(this).append(nav_column);
		}
	});

	$(".nav_kj_item").each(function () {
		for(var i=0;i<2;i++){
			$(this).find(".nav_kj_loop").append(nav_kj);
		}
	});

	//菜单导航超长时，显示左、右滑动箭头（默认显示滚动条）
	var navW = $(".h_nav nav").width();
	var navH = $(".h_nav nav").height();
	var ulW = $(".h_nav nav ul").width();
	var ulH = $(".h_nav nav ul").height();
	if (ulW > navW || ulH > navH) {
		if ($(".h_nav .nav_btn").length > 0) {
			var btn_x_move = ($(".h_nav nav").width() / 2 + 30) + 'px';
			$(".h_nav").addClass('btnScroll');
			$('.h_nav .nav_right').css({ transform: 'translate(' + btn_x_move +', -50%)'}).addClass('show');
			$(".h_nav .nav_btn").click(function () {
				var scrollBtn = $(this);
				var moveLeft = 0;
				if (scrollBtn.hasClass('nav_right')) {
					moveLeft = $(".h_nav nav ul").outerWidth(true) - $(".h_nav nav").width();
				}
				$(".h_nav nav").animate({ scrollLeft: moveLeft }, 'slow', function () {
					scrollBtn.removeClass('show').siblings('.nav_btn').css({
						transform: scrollBtn.hasClass('nav_right') ? 'translate(-' + btn_x_move + ', -50%)' : 'translate(' + btn_x_move + ', -50%)'
					}).addClass('show');
				});
			});
		}
		//浏览器不支持“width:max-content”样式时，通过循环扩充导航ul宽度，直到一行展示为止
		if (ulH > navH) {
			while (true) {
				ulW = ulW + 10;
				$(".h_nav nav ul").width(ulW);
				if ($(".h_nav nav ul").height() <= navH) { break; }
			}
		}
	}

	$(".h_nav nav li").hover(function () {

		// var abhq_item_h=277;
		// $(".abhq_item").each(function () {
		// 	if($(this).outerHeight()>abhq_item_h){
		// 		abhq_item_h=$(this).outerHeight();
		// 	}
		// }).css("height",abhq_item_h);


		$(this).addClass("choose_li");
		var nav_id=$(this).attr('nav_id');
		// if(nav_id != '2'){
		// 	$(".nav_item_right").css({
		// 		'width':'30%'
		// 	});
		// 	$(".nav_item_left").css({
		// 		'width':'70%'
		// 	});
		// }
		$(".h_nav_main_center[nav_id="+nav_id+"]").show();
		if(!$(this).hasClass("navBr")){


			if(nav_id==4){
				$(".h_nav_main_center[nav_id='4']").find(".nav_kj_loop").each(function () {
					$(this).find(".nav_kj_column").each(function () {
						$(this).closest(".nav_kj_item").find(".nav_kj_loop>dl").hq_nav_br($(this),$(this).closest(".nav_kj_item").find(".nav_kj_loop>dl"),450);
						if(!$(this).children().length){
							$(this).remove();
						}
					});
					var nav_kj_length= $(".h_nav_main_center[nav_id='4']").find(".nav_kj_column").length;
					$(".h_nav_main_center[nav_id='4']").find(".nav_kj_column").css("width",231);
				});
				console.log('xixix');
			}else if(nav_id==0){
				//$(this).find(".nav_about_hq").css();
			}else{

				$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_column").each(function () {
					$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_loop>dl").hq_nav_br($(this),$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_loop>dl"),360);
					if(!$(this).children().length){
						$(this).remove();
					}
				});

				var firstPorject= $(".h_nav_main_center[nav_id="+nav_id+"]").find("dl").eq(0).find("dd").find("a").html();
				//kevin写的，严谨的一批
				$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_loop").find("dl").eq(0).find("dd").eq(0).addClass("choose_dd");
				$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_loop").find("dl").eq(0).find("dt").eq(0).addClass("choose_dt");
				$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_item_right").find(".nav_add_service").find("header").find('span').html(firstPorject);
				$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_item_right").find(".nav_add_service").find(".add_service_main").find("ul").css("display","none");
				$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_item_right").find(".nav_add_service").find(".add_service_main").find("ul").eq(0).css("display","block");


				var nav_length=$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_column").length;
                if(nav_id == '2'){
                    //美洲暂时特殊处理
                    $(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_column").css("width",((1150/2)-1)/3);
                }else{
                    $(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_column").css("width",((1150/2)-1)/nav_length);
                }
				if(nav_id == '3' && nav_length == 4){ // 亚非移居是四列的时候
					$(".h_nav_main_center[nav_id="+nav_id+"]").find(".nav_column").css("width",((1150/2)-1)/nav_length+27);
				}
			}
			$(this).addClass("navBr");
		}
	},function () {
		$(".h_nav_main_center").hide();
		$(this).removeClass("choose_li");
	});


	$(".h_nav_main_center").hover(function () {
		var nav_id=$(this).attr('nav_id');
		$(this).show();
		$(".h_nav nav li[nav_id="+nav_id+"]").addClass("choose_li");
	},function () {
		$(this).hide();
		$(".h_nav nav li").removeClass("choose_li");
	});

	// 导航悬浮展现专题
	$(".h_nav_main_center dl dt a,.h_nav_main_center dl dd a").hover(function(){
		var _zt_json = _zt_html = '';
		var _zt_data = $(this).attr('data-zt') || $(this).parents('.h_nav_main_center').attr('data-zt');
		if(_zt_data){
			try { _zt_json = JSON.parse(_zt_data); } catch (err) {}
			if (typeof _zt_json =='object'){
				for (var d in _zt_json) {
					if(_zt_json[d]['pcLink'] != null){
						if (S_Query.type == '5') {
							_zt_html += '<a href="/cn' + _zt_json[d]['pcLink'] + '" target="_blank"><img src="' + _zt_json[d]['coverImg'] + '" alt="" style="width:251px;height:117px;"></a>'
						} else {
							_zt_html += '<a href="' + _zt_json[d]['pcLink'] + '" target="_blank"><img src="' + _zt_json[d]['coverImg'] + '" alt="" style="width:251px;height:117px;"></a>'
						}
					}
				}
			}
		}
		if(_zt_html == ''){
			$(this).parents('.h_nav_main_center').find('.nav_item_right .nav_addS_img').css('display','none');
		}else{
			$(this).parents('.h_nav_main_center').find('.nav_item_right .nav_addS_img').html(_zt_html).css('display', 'block');
		}
	})
	/*增值服务项*/
	$(".nav_loop dd a").hover(function () {
		var  _this=$(this);
		var add_s=$(this).closest("dd").attr("add_s");
		$(this).closest(".nav_loop").find(".choose_dd").removeClass("choose_dd");
		$(this).closest("dd").addClass("choose_dd");
		$(this).closest(".nav_loop").find(".choose_dt").removeClass("choose_dt");
		$(this).closest("dd").siblings("dt").addClass("choose_dt");


		add_s_time=setTimeout(function (){

			//console.log($(".add_service_main ul[add_s="+add_s+"]").find("li").is(":empty"));
			if($(".add_service_main ul[add_s="+add_s+"]").find('li').index() !=-1){
				 $(".add_service_main ul[add_s="+add_s+"]").closest(".nav_add_service").show();
				_this.closest(".nav_item_rl").find(".nav_add_service header span").text(_this.text());
				$(".add_service_main ul[add_s="+add_s+"]").show().siblings("ul").hide();
				$(".nav_item_right").css({
					'width':'50%'
				});
				$(".nav_item_left").css({
					'width':'50%'
				});
			}else{
				console.log(123);

				// $(".nav_item_right").css({
				// 	'width':'30%'
				// });
				// $(".nav_item_left").css({
				// 	'width':'70%'
				// });
				 $(".nav_add_service").hide();


			}


		},200);
	},function (){
		clearTimeout(add_s_time);
	});
	$(".nav_loop dd a").mouseout(function(){
		// $(".nav_add_service").hide();

	 });
	$(".nav_kj_loop dd a").hover(function(){
		$(this).closest(".nav_kj").find(".choose_dt").removeClass("choose_dt");
	   // $(".h_nav .choose_dt").removeClass("choose_dt");
		$(this).closest("dd").siblings("dt").addClass("choose_dt");
	})
	/* 环球规模 */
	$("#hqgm").hover(function() {
		$(".hq_city_nav").show();
	},function() {
		$(".hq_city_nav").hide();
	})
	$(".J_hdt_mobile").hover(function() {
		$(".J_hdt_qrCode").show();
	},function() {
		$(".J_hdt_qrCode").hide();
	})

});
