advisers($(".csta_out .show"));
$(function(){
	$(".ck_state_tab li").click(function(){
		var stateNum = $(this).index()
		$(this).addClass("on").siblings().removeClass("on")
		$(".cst_state").eq(stateNum).addClass("on").siblings().removeClass("on")
		$(".cst_tab_1 li").eq(0).mouseenter();
		$(".cst_tab_2 li").eq(0).mouseenter();
	})

	$(".cst_tab li").mouseenter(function(){
		var cityNum = $(this).index();
		$(this).addClass("selected").siblings("li").removeClass("selected");
		$(this).parent().next().find(".csta_box").eq(cityNum).addClass('show').siblings().removeClass('show');
		advisers($(this).parent().next().find(".csta_box").eq(cityNum))
	});
	$(".csta_list").on('mouseover','li .cl_info',function(){	
		$(this).parent("dt").fadeOut(400)
		$(this).parent("dt").siblings("dd").fadeIn(400)	
	})
	$(".csta_list").on('mouseleave','li',function(){	
		$(this).find("dt").fadeIn(400)
		$(this).find("dd").fadeOut(400)
	})
})

// 333

function advisers(obj){
	var _this = $(obj);
	var _that = _this.find(".country_slide");
	var _that_prev = _this.find(".next_btn");
	var _that_next = _this.find(".prev_btn");
	var swiper = new Swiper(_that, {
		slidesPerGroup: 5,
		slidesPerView:5,
		autoplay: {
			delay: 4000,
			disableOnInteraction: true,
		},
		loop : true,
		navigation: {
			nextEl: _that_prev,
			prevEl: _that_next,
		},
	});
	$('.country_slide li').hover(function(){
		swiper.autoplay.stop();
	},function(){
		swiper.autoplay.start();
	})
	
}