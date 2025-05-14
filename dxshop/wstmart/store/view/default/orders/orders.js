
var mmg;

function waituserPayByPage(p,limit){
	$(".layui-none").hide();
	$('#loading').show();
	var params = {};
	params = WST.getParams('.s-ipt');
	params.key = $.trim($('#key').val());
	params.page = p;
	params.limit = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('store/orders/waituserPayByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
            if(json.total>0){
                if(params.page>json.last_page && json.last_page >0){
                    waituserPayByPage(json.last_page);
                    return;
                }
                var gettpl = document.getElementById('tblist').innerHTML;
                layui.laytpl(gettpl).render(json.data, function(html){
                    $(html).insertAfter('#loadingBdy');
                    $('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
                });
                layui.laypage.render({
                    elem: 'pager',
                    count:json.total,
                    limit:json.per_page,
                    curr: json.current_page,
					prev:'<i class="layui-icon"></i>',
					next:'<i class="layui-icon"></i>',
                    layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
                    theme: '#1890ff',
                    groups: 3,
                    jump: function(e, first){
                        WST_PAGE_LIMIT = e.limit;
                        if(!first){
                            waituserPayByPage(e.curr,e.limit);
                        }
                    }
                });
            }else{
				$('#pager').empty();
				$(".layui-none").show();
            }
       	}
	});
}
function waitDivleryByPage(p,limit){
	$(".layui-none").hide();
	$('#loading').show();
	var params = {};
	params = WST.getParams('.s-ipt');
	params.key = $.trim($('#key').val());
	params.page = p;
    params.limit = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('store/orders/waitDeliveryByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
            if(json.total>0){
                if(params.page>json.last_page && json.last_page >0){
                    waitDivleryByPage(json.last_page);
                    return;
                }
                var gettpl = document.getElementById('tblist').innerHTML;
                layui.laytpl(gettpl).render(json.data, function(html){
                    $(html).insertAfter('#loadingBdy');
                    $('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
                });
                layui.laypage.render({
                    elem: 'pager',
                    count:json.total,
                    limit:json.per_page,
                    curr: json.current_page,
					prev:'<i class="layui-icon"></i>',
					next:'<i class="layui-icon"></i>',
                    layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
                    theme: '#1890ff',
                    groups: 3,
                    jump: function(e, first){
                        WST_PAGE_LIMIT = e.limit;
                        if(!first){
                            waitDivleryByPage(e.curr,e.limit);
                        }
                    }
                });
            }else{
				$('#pager').empty();
				$(".layui-none").show();
            }
       	}
	});
}
function deliveredByPage(p,limit){
	$(".layui-none").hide();
	$('#loading').show();
  var params = {};
  params = WST.getParams('.s-ipt');
  params.key = $.trim($('#key').val());
  params.page = p;
  params.limit = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
  $.post(WST.U('store/orders/deliveredByPage'),params,function(data,textStatus){
    $('#loading').hide();
      var json = WST.toJson(data);
      $('.j-order-row').remove();
      if(json.status==1){
        json = json.data;
          if(json.total>0){
              if(params.page>json.last_page && json.last_page >0){
                  deliveredByPage(json.last_page);
                  return;
              }
              var gettpl = document.getElementById('tblist').innerHTML;
              layui.laytpl(gettpl).render(json.data, function(html){
                  $(html).insertAfter('#loadingBdy');
                  $('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
              });
              layui.laypage.render({
                  elem: 'pager',
                  count:json.total,
                  limit:json.per_page,
                  curr: json.current_page,
				  prev:'<i class="layui-icon"></i>',
				  next:'<i class="layui-icon"></i>',
                  layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
                  theme: '#1890ff',
                  groups: 3,
                  jump: function(e, first){
                      WST_PAGE_LIMIT = e.limit;
                      if(!first){
                          deliveredByPage(e.curr,e.limit);
                      }
                  }
              });
          }else{
			  $('#pager').empty();
			  $(".layui-none").show();
          }
     }
  });
}

function deliver(id,deliverType){
	if(deliverType==1){
        WST.confirm({content:"您确定用户已提货了吗？", yes:function(tips){
            var ll = WST.load('数据处理中，请稍候...');
            $.post(WST.U('store/orders/deliver'),{id:id,expressId:0,expressNo:''},function(data){
				var json = WST.toJson(data);
				if(json.status>0){
					WST.msg(json.msg,{icon:1});
					waitDivleryByPage(WST_CURR_PAGE);
					layer.close(tips);
				    layer.close(ll);
				}else{
					WST.msg(json.msg,{icon:2});
				}
			});
        }});
	}
}
function finisedByPage(p,limit){
	$(".layui-none").hide();
	$('#loading').show();
	var params = {};
	params = WST.getParams('.s-ipt');
	params.key = $.trim($('#key').val());
	params.page = p;
    params.limit = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('store/orders/finishedByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
            if(json.total>0){
                $('.order_remaker').remove();
                if(params.page>json.data.last_page && json.data.last_page >0){
                    finisedByPage(json.data.last_page);
                    return;
                }
                var gettpl = document.getElementById('tblist').innerHTML;
                layui.laytpl(gettpl).render(json.data, function(html){
                    $(html).insertAfter('#loadingBdy');
                    $('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
                });
                layui.laypage.render({
                    elem: 'pager',
                    count:json.total,
                    limit:json.per_page,
                    curr: json.current_page,
					prev:'<i class="layui-icon"></i>',
					next:'<i class="layui-icon"></i>',
                    layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
                    theme: '#1890ff',
                    groups: 3,
                    jump: function(e, first){
                        WST_PAGE_LIMIT = e.limit;
                        if(!first){
                            finisedByPage(e.curr,e.limit);
                        }
                    }
                });
            }else{
				$('#pager').empty();
				$(".layui-none").show();
            }
       	}
	});
}
function failureByPage(p,limit){
	$(".layui-none").hide();
	$('#loading').show();
	var params = {};
	params = WST.getParams('.s-ipt');
	params.key = $.trim($('#key').val());
	params.page = p;
    params.limit = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('store/orders/failureByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
            if(json.total>0){
                $('.order_remaker').remove();
                if(params.page>json.last_page && json.last_page >0){
                    failureByPage(json.last_page);
                    return;
                }
                var gettpl = document.getElementById('tblist').innerHTML;
                layui.laytpl(gettpl).render(json.data, function(html){
                    $(html).insertAfter('#loadingBdy');
                    $('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
                });
                layui.laypage.render({
                    elem: 'pager',
                    count:json.total,
                    limit:json.per_page,
                    curr: json.current_page,
					prev:'<i class="layui-icon"></i>',
					next:'<i class="layui-icon"></i>',
                    layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
                    theme: '#1890ff',
                    groups: 3,
                    jump: function(e, first){
                        WST_PAGE_LIMIT = e.limit;
                        if(!first){
                            failureByPage(e.curr,e.limit);
                        }
                    }
                });
            }else{
				$('#pager').empty();
				$(".layui-none").show();
            }
       	}
	});
}
function view(id,src){
	location.href=WST.U('store/orders/view','id='+id+'&src='+src+'&p='+WST_CURR_PAGE);
}

//导出订单
function toExport(typeId,status,type){
	var params = {};
	params = WST.getParams('.s-ipt');
	params.typeId = typeId;
	params.orderStatus = status;
	params.type = type;
	var box = WST.confirm({content:"您确定要导出订单吗?",yes:function(){
		layer.close(box);
		location.href=WST.U('store/orders/toExport',params);
         }});
}

function toBacks(p,src){
	location.href=WST.U('store/orders/'+src,'p='+p);
}


/**
 * 查询订单信息
 */
function getVerificatOrder(){
	var params = {};
	var verificationCode = $("#verificationCode").val();
	$('#orderInfo').html("");
	if(verificationCode.length<10){
		WST.msg('请输入正确的核验码',{icon:2});
		return;
	}
	params.verificationCode = verificationCode;
	$('#loading').show();
	$.post(WST.U('store/orders/getVerificatOrder'),params,function(data,textStatus){
	    $('#loading').hide();
	    var json = WST.toJson(data);
	    if(json.status=='1'){
	       	var gettpl = document.getElementById('tblist').innerHTML;
	       	layui.laytpl(gettpl).render(json.data, function(html){
	       		$('#orderInfo').html(html);
	       		$('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.ROOT+'/'+WST.conf.GOODS_LOGO});
	       	});
	    }else{
	      	WST.msg(json.msg,{icon:2});
	    }
	});
}

/**
 * 验证确认核销
 */
function orderVerificat() {
	var params = {};
	var verificationCode = $("#verificationCode").val();
	if(verificationCode.length<10){
		WST.msg('请输入正确的核验码',{icon:2});
		return;
	}
	params.verificationCode = verificationCode;
	var box = WST.confirm({content:"您确定要核销吗?",yes:function(){
		layer.close(box);
		$.post(WST.U('store/orders/orderVerificat'),params,function(data,textStatus){
		    var json = WST.toJson(data);
		    if(json.status=='1'){
		       	WST.msg(json.msg);
		       	getVerificatOrder();
		    }else{
		      	WST.msg(json.msg,{icon:2});
		    }
		});
  	}});

}


/*********** 门店拒收 **********/
function toReject(id){
	var ll = WST.load({msg:'正在加载信息，请稍候...'});
	$.post(WST.U('store/orders/toReject'),{id:id},function(data){
		layer.close(ll);
		var w = WST.open({
			    type: 1,
			    title:"拒收订单",
			    shade: [0.6, '#000'],
			    border: [0],
			    content: data,
			    area: ['500px', '300px'],
			    btn: ['提交', '关闭窗口'],
		        yes: function(index, layero){
		        	var params = {};
		        	params.reason = $.trim($('#shopRejectReason').val());
		        	params.content = $.trim($('#content').val());
		        	params.id = id;
		        	if(params.reason==10000 && params.content==''){
		        		WST.msg('请输入拒收原因',{icon:2});
		        		return;
		        	}
		        	ll = WST.load({msg:'数据处理中，请稍候...'});
				    $.post(WST.U('store/orders/reject'),params,function(data){
				    	layer.close(w);
				    	layer.close(ll);
				    	var json = WST.toJson(data);
						if(json.status==1){
							WST.msg(json.msg, {icon: 1});
							waitDivleryByPage(WST_CURR_PAGE);
						}else{
							WST.msg(json.msg, {icon: 2});
						}
				   });
		        }
			});
	});
}

function changeRejectType(v){
	if(v==10000){
		$('#rejectTr').show();
	}else{
		$('#rejectTr').hide();
	}
}

function remarks(id,src){
	var ll = WST.load({msg:'正在加载记录，请稍候...'});
	$.post(WST.U('store/orders/getShopRemarks'),{orderId:id},function(data){
		layer.close(ll);
		var json = WST.toJson(data);
		if(json.status>0 && json.data){
			var tmp = json.data;
			WST.open({type: 1,title:"订单【"+tmp.orderNo+"】备注",shade: [0.6, '#000'],border: [0],
				content: '<textarea style="width:calc(100% - 25px);height:calc(100% - 20px);margin:5px" id="m_orderShopRemarks">'+WST.blank(tmp.orderShopRemarks)+'</textarea>',area: ['500px', '350px'],btn: ['确定','取消'],end:function(){},
				yes:function(index, layero){
					var ll = WST.load({msg:'正在提交信息，请稍候...'});
					$.post(WST.U('store/orders/editShopRemarks'),{orderId:id,orderShopRemarks:$('#m_orderShopRemarks').val()},function(data){
						var json = WST.toJson(data);
						if(json.status>0){
							WST.msg(json.msg,{icon:1});
							switch(src){
								case 'waituserPay':
									waituserPayByPage();
									break;
								case 'waitDelivery':
									waitDivleryByPage();
									break;
								case 'delivered':
									deliveredByPage();
									break;
								case 'finished':
									finisedByPage();
									break;
								case 'failure':
									failureByPage();
									break;
							}
							layer.close(index);
							layer.close(ll);
						}else{
							WST.msg(json.msg,{icon:2});
						}
					});
				}
			});
		}
	});
}
