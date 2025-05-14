play_times = 0,
popup_position = 0,//全部展示123456789
ip = '';
post = '';
$(function(){
	/*  离线宝 */
	if($("#callBtn_lxb").length >= 1){
		document.getElementById("callBtn_lxb").onclick = function(){
			lxb.call(document.getElementById("telInput_lxb").value);
			//initiativeCall(document.getElementById("telInput_lxb").value,document.getElementById("telInput_lxb").dataset.from);
		};
	}

	//表单弹窗关闭
	$(".close_btns").on("click",function () {
		$(".open_windows").fadeOut(400);
	});
	/*右侧飘窗*/
	setTimeout(function () {
		var _thisUrl=window.location.href;
		if (_thisUrl.indexOf("abouthq") == -1) {  
		 $(".wrap").css("opacity",0).animate({opacity:1},1).show(); 
		}
		
	},4000);
	
    $("#btn").click(function () {
		if($(this).parent().hasClass('active')){
			$(this).parent().removeClass('active');
		}else{
			$(this).parent().addClass('active');
		}
	})
	$(function() {
        var DOM = {
            J_fixed: $(".J_fixed"),
            J_header: $(".J_header"),
            J_box: $(".J_box"),
            J_hdt_mobile: $(".J_hdt_mobile"),
            J_hdt_qrCode: $(".J_hdt_qrCode"),
            J_hd_search_select: $(".J_hd_search_select"),
            J_hd_search_option: $(".J_hd_search_option"),
            J_search_selected: $(".J_search_selected"),
            J_nav_item: $(".J_nav_item"),
            J_nav_item_list: $(".J_nav_item_list"),
            J_ft_top: $(".J_ft_top"),
            J_ft_thead_list: $(".J_ft_thead_list"),
            J_ft_tbody: $(".J_ft_tbody"),
            J_right: $(".J_right"),
            J_backTop: $(".J_backTop")
        };

        DOM.J_hdt_mobile.hover(function() {
                DOM.J_hdt_qrCode.fadeIn(300);
                $(this).find("a").addClass("current")
            },
            function() {
                DOM.J_hdt_qrCode.fadeOut(300);
                $(this).find("a").removeClass("current")
            });

        DOM.J_hd_search_select.hover(function() {
                $(this).css({
                    "overflow-y": "visible"
                })
            },
            function() {
                $(this).css({
                    "overflow-y": "hidden"
                })
            });

        DOM.J_hd_search_option.on('click', 'li',
            function() {
                var $_selected = DOM.J_hd_search_option.find('.selected'),
                    $_selectedText = $_selected.html(),
                    $_thisText = $(this).html();

                DOM.J_search_selected.val($_thisText);
                $_selected.html($_thisText);
                $(this).html($_selectedText);
                $(this).closest(".g-hd-search").find("input[type='hidden']").val($_thisText);
            });

        DOM.J_nav_item.hover(function() {
                var $_this = $(this);
                $_this.addClass("current").siblings().removeClass("current");
            },
            function() {
                var $_this = $(this);
                $_this.removeClass("current");
            });

        var $_current_row, $_timer = null,
            $_mouseInSub = false,
            $_mouseTrack = [];

        DOM.J_nav_item_list.on("mouseenter",
            function() {

                $(d).bind("mousemove", moveHandler);
                addOffsetLeft($(this));
            }).on("mouseleave",
            function() {

                if ($_current_row) {
                    $_current_row.removeClass("current");
                    $_current_row = null;
                }
                removeOffsetLeft($(this));
                $(d).unbind("mousemove", moveHandler)
            }).on("mouseenter", "dl",
            function() {
                $_mouseInSub = true
            }).on("mouseleave", "dl",
            function() {
                $_mouseInSub = false
            }).on("mouseenter", "li",
            function() {
                var $_this = $(this);
                var $_dd_length = $_this.find("dd").length;
                if ($_dd_length > 3) {
                    $_dd_length = 3

                }
                $_this.find("dl").width($_dd_length * 210);
                if (!$_current_row) {
                    $_current_row = $_this;
                    $_current_row.addClass("current");
                    return
                }

                if ($_timer) {
                    clearTimeout($_timer);
                }

                var curMousePosition = $_mouseTrack[$_mouseTrack.length - 1],
                    prevMousePosition = $_mouseTrack[$_mouseTrack.length - 2],
                    $_delay = needDelay($_this.parent(), curMousePosition, prevMousePosition);

                if ($_delay) {
                    $_timer = setTimeout(function() {
                            if ($_mouseInSub) {
                                return
                            }
                            $_current_row.removeClass("current");
                            $_current_row = $_this;
                            $_current_row.addClass("current");
                            $_timer = null;
                        },
                        300)
                } else {
                    var $_prev_current_row = $_current_row;
                    $_current_row = $_this;
                    $_prev_current_row.removeClass("current");
                    $_current_row.addClass("current");
                }
            });

        function moveHandler(e) {
            $_mouseTrack.push({
                x: e.pageX,
                y: e.pageY
            });

            if ($_mouseTrack.length > 3) {
                $_mouseTrack.shift();
            }
        }
        DOM.J_ft_top.find("dd:eq(14)").addClass("no-before");
        //DOM.J_ft_thead_list.find("li:eq(20)").addClass("no-float");

        var $_timer2 = null;
        DOM.J_ft_thead_list.on("mouseenter", "li",
            function() {
                var $_this = $(this),
                    $_index = $_this.index();

                $_timer2 = setTimeout(function() {
                        if (!$_this.hasClass("current")) {
                            $_this.addClass("current").siblings("li").removeClass("current");
                        }

                        DOM.J_ft_tbody.find("dl").eq($_index).addClass("show").siblings().removeClass("").attr("class", "")
                    },
                    300);

            }).on("mouseleave", "li",
            function() {
                clearTimeout($_timer2);
                $_timer2 = null;
            });

        DOM.J_right.on("mouseover", "li",
            function() {
                if ($(this).find("div").length > 0) {
                    $(this).addClass("current")
                }
            });
        DOM.J_right.on("mouseout", "li",
            function() {
                if ($(this).find("div").length > 0) {
                    $(this).removeClass("current")
                }
            });

        $(".J_close").on("click",
            function() {
				$("#g-right-da").stop().animate({right:"-60px"},function(){
					$(".J_shouji").animate({right:"0px"});
				});
            });

        $(".J_shouji").on("click",
            function() {
                $(".J_shouji").stop().animate({right:"-60px"},function(){
					$("#g-right-da").animate({right:"0px"});
				});
            });

        var $_J_fixed_height = DOM.J_fixed.height();

        $(window).on("scroll",
            function() {
                if ($(window).scrollTop() > $_J_fixed_height) {

                    DOM.J_fixed.addClass("current");
                    DOM.J_header.hide();
                    DOM.J_box.show();
					$("#g-right").css("top",100);
					$('.mechat_left').css("top",243);
                    if ($(window).scrollTop() > $(window).height()) {
                        DOM.J_backTop.show();
                    }
					
					$(".globe_abouthq_window").css("position","fixed");
					$(".globe_abouthq_window").css("top","90px");
                } else {
                    DOM.J_fixed.removeClass("current");
                    DOM.J_header.show();
                    DOM.J_box.hide();
                    DOM.J_backTop.hide();
					$("#g-right").css("top",190);
					$('.mechat_left').css("top",333);
					$(".globe_abouthq_window").css("position","fixed");
					$(".globe_abouthq_window").css("top","180px");
                }

            });

        $(window).trigger("scroll");

        DOM.J_backTop.on("click",
            function() {
                $("html, body").stop().animate({
                        scrollTop: 0
                    },
                    300)
            })
    })
	/*
		给您回电弹窗
	*/
	$('#window-mask .close_btn').click(function(){
		$('#window-mask').slideUp();
	})
	$('.gnhd').click(function(){
    $('#window-mask').slideDown();
	})
	
	
	/* 左侧飘窗 */
	var onlineHeight = $(".sl_online_box").outerHeight()
	var areaHight = $(".sl_name").height()
	$(".sider_left").hover(
		function(){
			$(".sl_area").toggleClass("sl_area_anim")
			$(".sl_online_box").css("height",areaHight)
			$(".sl_close").parents(".sider_left").addClass("selected")
		},
		function(){
			$(".sl_area").removeClass("sl_area_anim")
			$(".sl_online_box").css("height",onlineHeight)
			$(".sl_close").parents(".sider_left").removeClass("selected")
			
		}
	)
	$(".sl_close").click(function(){
		$(".sl_area").removeClass("sl_area_anim")
		$(".sl_online_box").css("height",onlineHeight)
		$(".sl_close").parents(".sider_left").removeClass("selected")
	})

})
/*  底部  弹窗  */

$(function(){
	var l_l = $(".dibulunbo").length;
	var date = new Date();
	var m = date.getSeconds();
	var ym = m % l_l;
	var _thisUrl=window.location.href;
	setTimeout(function () {
		if(_thisUrl.indexOf("sqzl")==-1){
			$(".dibulunbo").eq(ym).css("opacity",0).animate({opacity:1},1000).show();
		}
	},4000);
	$(".feiyong_close,.feiyong_close_2").on("click",function(){
		$(".dibulunbo").hide();
	})
})
$(".feiyong_tanchu,.open_feiyong").on('click',function(){
	$(".feiyong_tanchu").unbind('click');
	$(".feiyong_tanchu").css('display',"none");
	$(".first_close").css('display',"none");
	$(".feiyong_zong").css("height","600px")
	//$(".feiyong_tanchu").attr('src','/statics/assets/images/feiyong_title_mei.png');
	$(".feiyong_zong").animate({"bottom":"0px"});
}) 

$(".feiyong_close").on('click',function(){
	$(".feiyong_zong").css("display","none");
	setTimeout(feiyongShow(),40000);
})
function feiyongShow(){
	$(".feiyong_zong").css("display","block");
}

// 项目合作
function xxhz() {
    $(".xxhz").css('display');
    if($('.xxhz').css('display') == 'none'){
        $('.xxhz').show();
    }else {
        $('.xxhz').hide();
    }

    $(".xx_img2").click(function(){  $('.xxhz').hide();  });
}

function sun(){
    $(".windowsimgall").show();
    $(".wind").show();
    var expires = new Date(new Date(new Date().getTime() + 30*24 * 60 * 60 * 1000).setHours(0, 0, 0, 0));
}

     
           


    function sunn(){
        $(".windowsimgall_index").show();
        $(".winds").show();
        var expires = new Date(new Date(new Date().getTime() + 30*24 * 60 * 60 * 1000).setHours(0, 0, 0, 0));

    }

$(function(){
    //如果cookie中不存在没弹的次数 并且 cookie 限制30分钟里面也不存在 就重新调用后台进行获取
    // setCookie('isclose','半小时内不会再弹',1800)
    // delCookie('play_time')
    // delCookie('popup_position')
    // delCookie('isclose')
    post = $('.post input').val();
    var isClose=getCookie('isclose_'+post);
    var play = getCookie('play_time_'+post)
    //查询cookie 是否还存有没弹完的次数 并且还没存入限制cookie中
    if(play != '' && !isClose){
        tk();//继续弹值
    }else{
        if(!isClose){
            var str = '';
            var	_url = "https://restful.huanqiuyimin.com/Web/index_popups?isDisplay="+post;
            $.getJSON(_url,function(msg) {
                if(msg.data.code == 1){
                    ip = msg.data['ip']
                    popup_position = msg.data['pc_popup_position'];
                    setCookie('popup_position_'+post,popup_position,1800)

                    var play = msg.data['pc_play_times'].split('#');
                    var time = parseInt(play[0]*1000);
                    if(popup_position == 1){//只在首页存值
                        str = ""
                        setTimeout('sunn()',time);
                        console.log('为11')
                    }else{
                        setTimeout('sun()',time);
                    }
                    if(play.length>1){//不止展现一次
                        play_times = play
                        setCookie('play_time_'+post,play_times.join(','),1800)

                    }else{
                        setCookie('play_time_'+post,0,1800)
                        play_times = 0;
                    }
                }

            })
        }
    }


})
function onurl(url,id){//点击+1
    var _url = "https://restful.huanqiuyimin.com/Web/add_clicks?id="+id+'&site=1'+'&url='+window.location.href;
    console.log(_url);
    $.getJSON(_url,function(msg) {
        console.log(msg);
        $(".wind").hide();
        $(".windowsimgall").hide();
        $(".winds").hide();
        $(".windowsimgall_index").hide();
        //window.open(url);
    })
}
function tk(){//弹框弹出与否
    var play_time = getCookie('play_time_'+post);
    var popup_position = getCookie('popup_position_'+post);
    if(play_time!=0){
        var play_times= new Array()
        play_times = play_time.split('%2C');
        play_times.splice(0,1);//删除一个
        console.log('数组'+play_times)
        if(play_times.length >= 1){
            //将剩余的次数存cookie
            setCookie('play_time_'+post,play_times.join(','),1800)
            var time = parseInt(play_times[0]*1000);
            if(popup_position == 1){
                setTimeout('sunn()',time);
                console.log('为11')
            }else{
                setTimeout('sun()',time);
                console.log('走这')
            }
            // setTimeout('sunn()',time);
        }else{
            //最后一次弹完半小时内不会再弹
            setCookie('isclose_'+post,'半小时内不会再弹',1800)
            delCookie('play_time_'+post)
            delCookie('popup_position_'+post)
            console.log('结束')
        }
    }else{
        setCookie('isclose_'+post,'半小时内不会再弹',1800)
        delCookie('play_time_'+post)
        delCookie('popup_position_'+post)
        console.log('jieshu')
    }
}

$(".closewinds").on('click',function () {
    $(".winds").hide();
    $(".windowsimgall_index").hide();
    console.log('close'+play_times)
    tk();
    //  if(!isClose){
    //   	setTimeout('sun()',40000);
    //   	setCookie("isClose",'yes','1');
    //    }

})
$(".closewind").on('click',function () {
    $(".wind").hide();
    $(".windowsimgall").hide();
    console.log('close'+play_times)
    tk();

})
  // $(function(){
  // 	var isClose=getCookie("isClose");
  //     setTimeout('sun()',10000);
  //
  //  })
  // $(".closewind").on('click',function () {
  // 	var isClose=getCookie("isClose");
  //       $(".wind").hide();
  //       $(".windowsimgall").hide();
  //
  //  		    if(!isClose){
  //  		    	setTimeout('sun()',40000);
  //  		     	setCookie("isClose",'yes','1');
  //  		   }
  //
  // })