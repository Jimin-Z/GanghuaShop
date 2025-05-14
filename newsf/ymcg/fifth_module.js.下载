$(function()               {

addHover();

width();

});

//123456


function addHover(){

	$('.fhm-c-list').find('.fhm-cl-li').hover(function(e) {

		clearInterval(timer);

		$(this).siblings().stop().fadeTo(100,0.5);

		

			$(this).find('.fhm-cl-b a').css({

				'color':'rgba(255,255,255,1)'

			});

		

		$(this).find('.fhm-cl-b li:last-child a').animate(

				{backgroundPosition:"(8px -34px)"},

				{duration:300}

			);

		$(this).find('.fhm-cl-b li:first-child a').animate(

				{backgroundPosition:"(8px -30px)"},

				{duration:300}

			);

			//alert(0);

		var xl = $(this).offset().left;

		var xr =$(window).width()-(xl+162);

		if(xl>xr){

			$(this).children('.fhm-cl-p').css({

				'right':'143px',

				'display':'block'

			})

		}else{

			$(this).children('.fhm-cl-p').css({

				'left':'143px',

				'display':'block'

			})

		}

	},function(){

		$(this).siblings().stop().fadeTo(100,1);

		$(this).children('.fhm-cl-p').css({

			'display':'none'

		});

			

		$(this).find('.fhm-cl-b p').css({

				'color':'#a67e3d'

		});
		
		$(this).find('.fhm-cl-b a').css({

				'color':'rgba(245,234,214,1)' 

		});

		$(this).find('.fhm-cl-b a.cur').css({

				'color':'#dbdee1'

		});

			


		$(this).find('.fhm-cl-b li:last-child a').animate(

				{backgroundPosition:"(8px 8px)"},

				{duration:300}

			);

		$(this).find('.fhm-cl-b li:first-child a').animate(

				{backgroundPosition:"(8px 8px)"},

				{duration:300}

			);

	});

	/* $('.fhm-a-t').mouseover(function(){

			$(this).addClass('fhm-a-cur');

			$(this).parent().siblings().children('.fhm-a-t').removeClass('fhm-a-cur');

			var index = $(this).parent().index();

			$('.fhm-c-list').eq(index).addClass('dbk');

			$('.fhm-c-list').eq(index).siblings().removeClass('dbk');

	}); */
	var ys_300;
	
	$('.fhm-a-t').on("mouseover",function(){
			var _that=$(this);
			ys_300=setTimeout(function () {
                _that.addClass('fhm-a-cur');

				_that.parent().siblings().children('.fhm-a-t').removeClass('fhm-a-cur');

				var index = _that.parent().attr("name");
				
				console.log(index);

				$(".fhm-c-list[name="+index+"]").addClass('dbk').siblings("section").removeClass('dbk');
            },300);
			
	});
	
	$('.fhm-a-t').on("mouseout",function(){
		 clearTimeout(ys_300);

	});


};



function width(){

		var index = $('.fhm-c-list').length;
		

		for(var i = 0 ; i < index ; i++){

			if($('.fhm-c-list').eq(i).find('.fhm-cl-li').length>8){
				$('.fhm-c-list').eq(i).children('.fhm-cl-ul').append($('.fhm-c-list').eq(i).find('.fhm-cl-li:lt(12)').clone(true));
			}else{
			    $('.fhm-c-list').eq(i).children('.fhm-cl-ul').append($('.fhm-c-list').eq(i).find('.fhm-cl-li:lt(8)').clone(true));
				
				$('.fhm-c-list').eq(i).children('.fhm-cl-ul').append($('.fhm-c-list').eq(i).find('.fhm-cl-li:lt(9)').clone(true));
			}
			

			var length = $('.fhm-c-list').eq(i).find('.fhm-cl-li').length;

			$('.fhm-c-list').eq(i).children('.fhm-cl-ul').width(length*162)+'px';

		timer(i)	

	};

};



function timer(h){

		var width = $('.fhm-c-list').eq(h).children('.fhm-cl-ul').width()- (162*8);
		

		var timer = null,

			num = 0,

			gun = -1,
			
			frame_rate_timer = 20,

			myFn = function(){

			num+=gun;
						
			if(num < - width){

				num = 0;

			}else if(num > width){

				num = -width;

			}

			$('.fhm-c-list').eq(h).children('.fhm-cl-ul').css('left',''+num+'px');
		
		};

		timer = setInterval(myFn,frame_rate_timer);

		$('.fhm-corresponding').hover(function(){

			clearInterval(timer);

		},function(){

			timer = setInterval(myFn,frame_rate_timer);
			

		})
		

}


	$(".fhm-cl-ul li").hover(function(){
			//alert(123);
			$(this).find('.video').show();
			$(this).find('.videoImg').show();
			$(this).find(".videomq").show(); 
		},function(){
			$(this).find('.video').hide();
			$(this).find('.videoImg').hide();
			$(this).find(".videomq").hide();
		});
		$(".video").hover(function(){
		
			$(this).prev().find(".videoImg").css({
				'transform':'rotate(180deg)',
				'-webkit-transform':'rotate(180deg)'
			})
		},function(){
			$(this).prev().find(".videoImg").css({
				'transform':'rotate(0deg)',
				'-webkit-transform':'rotate(0deg)'
			})
		})



