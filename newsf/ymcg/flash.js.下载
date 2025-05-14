
$(function() {
	var DOM = {
		J_banner : $(".J_banner"),
		J_banner_slider : $(".J_banner_slider"),
		J_banner_pagination : $(".J_banner_pagination"),
		J_banner_btn_prev : $(".J_banner_btn_prev"),
		J_banner_btn_next : $(".J_banner_btn_next"),
	};

	var $_reset_banner_list_length = DOM.J_banner_slider.find("li").length;

	var $_banner_width = DOM.J_banner.width();
	var $_banner_first_clone = DOM.J_banner_slider.find("li:eq(0)").clone(true);

	DOM.J_banner_slider.append($_banner_first_clone);

	var $_banner_list_count_length = DOM.J_banner_slider.find("li").length;

	DOM.J_banner_slider.find("li").width($_banner_width);
	DOM.J_banner_slider.css({
		width : $_banner_list_count_length * $_banner_width + 'px'
	});
	
	createPagination(DOM.J_banner_pagination, $_reset_banner_list_length);

	//之前没有文字的轮播
	function createPagination($_el, $_length) {
		var $_html = "";
		for (var i = 0; i < $_length; i++) {
			if (i === 0) {
				$_html += "<li class='current'><a href='javascript:;'></a></li>"
			} else {
				$_html += "<li><a href='javascript:;'></a></li>"
			}

		}

		$_el.html($_html);
	}
	// function createPagination($_el, $_length) {
	// 	var $_html = "<li><a class='current' href='javascript:;'>护照</a></li><li><a href='javascript:;'>境外开户</a></li><li><a href='javascript:;'>环境精选</a></li><li><a href='javascript:;'>环球会员中心</a></li> <li><a href='javascript:;'>澳大利亚</a></li><li><a href='javascript:;'>葡萄牙</a></li>";
	// 	$_el.html($_html);
	// }
	if($_reset_banner_list_length > 1){

		var $_pagination_key = 0,
			$_slider_key = 0,
			$_move,
			$_timer3 = null,
			$_auto_play = function() {
				if (!DOM.J_banner_slider.is(":animated")) {
					$_pagination_key++;
					if ($_pagination_key > $_banner_list_count_length - 2) {
						$_pagination_key = 0;
					}
					DOM.J_banner_pagination.find("li").eq($_pagination_key).addClass("current")
						.siblings().removeClass("current");

					$_slider_key++;
					if ($_slider_key > $_banner_list_count_length - 1) {
						$_slider_key = 1;
						DOM.J_banner_slider.css({left: 0 + 'px'});
					}

					$_move = $_slider_key * -$_banner_width;
					DOM.J_banner_slider.stop().animate({left: $_move + 'px'}, 300);
				}
			};
		
		$_timer3 = setInterval($_auto_play, 3500);

		DOM.J_banner_btn_next
			.on("click", $_auto_play);

		DOM.J_banner_btn_prev
			.on("click", function() {
				if (!DOM.J_banner_slider.is(":animated")) {
					$_pagination_key--;
					if ($_pagination_key < 0) {
						$_pagination_key = $_banner_list_count_length - 2;
					}
					DOM.J_banner_pagination.find("li").eq($_pagination_key).addClass("current")
						.siblings().removeClass("current");

					$_slider_key--;
					if ($_slider_key < 0) {
						$_slider_key = $_banner_list_count_length - 2;
						DOM.J_banner_slider.css({
							left: ($_banner_list_count_length - 1) * -$_banner_width + 'px'
						});
					}

					$_move = $_slider_key * -$_banner_width;
					DOM.J_banner_slider.stop().animate({left: $_move + 'px'}, 300);
				}
			});

		DOM.J_banner_pagination.on("click", "li", function() {
			$_pagination_key = $(this).index();
			$_slider_key = $(this).index();
			$_move = $_slider_key * -$_banner_width;
			DOM.J_banner_slider.stop().animate({'left': $_move + 'px'}, 300);
			DOM.J_banner_pagination.find("li").eq($_pagination_key).addClass("current")
				.siblings().removeClass("current");
		});

		DOM.J_banner
			.on("mouseenter", function() {
				clearTimeout($_timer3);
				$_timer3 = null;
			})
			.on("mouseleave", function () {
				clearTimeout($_timer3);
				$_timer3 = setInterval(function(){
					$_auto_play()
				},3500);
			});
	}

})