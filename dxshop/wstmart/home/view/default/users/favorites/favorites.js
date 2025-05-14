var WST_CURR_PAGE = 1;
//关注的商品列表
function freGoodsList(pages,limit){
	var param = {};
	param.pagesize = 8;
	param.page = pages;
	param.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
    $.post(WST.U('home/favorites/listGoodsQuery'),param,function(data){
        var json = WST.toJson(data);
        if(json.status==1){
        	json = json.data;
        	if(param.page>json.last_page && json.last_page >0){
               freGoodsList(json.last_page);
               return;
            }
	        var gettpl = document.getElementById('list').innerHTML;
	        layui.laytpl(gettpl).render(json.data, function(html){
	            $('#list-goods').html(html);
	        });
	        if(json.total>0){
	          layui.laypage.render({
		          elem: 'goodsPage',
		          count:json.total,
		          limit:json.per_page,
		          curr: json.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      freGoodsList(e.curr,e.limit);
	                    }
	               }
	           });
	        }else{
              $('#pager').empty();
	        }
	        
	    	$(".wst-fav-goimg").hover(function(){
	    		$(this).find(".js-operate").slideDown();
	    	},function(){
	    		$(this).find(".js-operate").slideUp();
	    	});
	    	$('.goodsImg2').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+window.conf.GOODS_LOGO});//商品默认图片
        }
    });
}
function getGoods(id){
	location.href=WST.U('home/goods/detail','goodsId='+id);
}
function cancelFavorite(id,type){
	WST.confirm({content:"您确定要取消关注吗？", yes:function(tips){
	    var load = WST.load({msg:'请稍后...'});
		var param = {};
		param.id = id;
		param.type = type;
	    $.post(WST.U('home/favorites/cancel'),param,function(data,textStatus){
	      layer.close(load);
	      var json = WST.toJson(data);
	      if(json.status=='1'){
	        WST.msg(json.msg,{icon:1},function(){
	        	if(type==0){
	        		freGoodsList(WST_CURR_PAGE);
	        	}else{
	        		freShopList(WST_CURR_PAGE);
	        	}
	        	
	        });
	      }else{
	        WST.msg(json.msg,{icon:2});
	      }
	    });
	}});
}
//关注的店铺列表
function freShopList(pages){
	var param = {};
	param.pagesize = 5;
	param.page = pages;
	param.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
    $.post(WST.U('home/favorites/listShopQuery'),param,function(data){
        var json = WST.toJson(data);
        if(json.status==1){
        	json = json.data;
        	if(param.page>json.last_page && json.last_page >0){
               freShopList(json.last_page);
               return;
            }
	        var gettpl = document.getElementById('list').innerHTML;
	        layui.laytpl(gettpl).render(json.data, function(html){
	            $('#list-shops').html(html);
	        });
	        //商品滑动
	    	var goodsNum = json.data.length;
	    	for(var i=0;i<goodsNum;++i){
		    	$("#js-goods"+i).als({
		    		visible_items: 5,
		    		scrolling_items: 1,
		    		orientation: "horizontal",
		    		circular: "yes",
		    		autoscroll: "no",
		    		start_from: 2
		    	});
	    	}
	    	$('.goodsImg2').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+window.conf.GOODS_LOGO});//商品默认图片
	        $('.shopsImg2').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+window.conf.SHOP_LOGO});//店铺默认头像
	        if(json.total>0){
	          layui.laypage.render({
		          elem: 'shopsPage',
		          count:json.total,
		          limit:json.per_page,
		          curr: json.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      freShopList(e.curr,e.limit);
	                    }
	               }
	           });
	        }else{
              $('#pager').empty();
	        }
        }
    });
}
function getShop(id){
	location.href=WST.U('home/shops/index','shopId='+id);
}