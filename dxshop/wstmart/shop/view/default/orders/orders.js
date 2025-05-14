var mmg;
function initGrid(p){
	mmg = layui.table;
	mmg.render({elem: '#mmg', id:'dataTable',url:WST.U('shop/ordercomplains/queryShopComplainByPage'), cellMinWidth: 80, height: WST.initGridHeight(), skin: 'line', even: true, limit:20, page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'订单编号', field:'orderNo' ,width:200,templet: function(item){
				if(item['orderCodeTitle'] != ""){
					return item['orderNo']+"【"+item['orderCodeTitle']+"】";
				}else{
					return item['orderNo'];
				}
			}},
			{title:'投诉方', field:'loginName' ,width:120,templet: function(item){
				return WST.blank(item['userName'],item['loginName']);
			}},
			{title:'投诉原因', field:'complainContent' ,templet: function(item){
				return WST.cutStr(item['complainContent'],50);
			}},
			{title:'投诉时间', field:'complainTime' ,width:150},
			{title:'投诉状态', field:'complainStatus' ,width:150},
			{title:'操作',field:'',fixed: 'right',width:200,templet: function(item){
				var h = "";
				h += "<a  class='btn btn-blue' onclick='javascript:toView("+item['complainId']+")'><i class='fa fa-search'></i>查看</a> ";
				if(item['needReply']==1)h += "<a  class='btn btn-green' onclick='javascript:toRespond(" + item['complainId'] + ")'><i class='fa fa-pencil'></i>应诉</a> ";
				return h;
			}}
		]],
		done: function(res, curr, count){
			var e = this;
			var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
			if(count>0 && curr>total_page){
				loadGrid(total_page);
				return;
			}
			WST_CURR_PAGE = curr;
		}
	});
}

function loadGrid(p){
    p = (p<=1)?1:p;
	mmg.reload('dataTable',{page:{curr:p},where:{orderNo:$("#orderNo").val()}});
}
function getParams(p,limit){
    $(".layui-none").hide();
    $('#loading').show();
    if(typeof(limit)=='undefined')limit = WST_PAGE_LIMIT;
    var params = {};
    params = WST.getParams('.s-ipt');
    params.key = $.trim($('#key').val());
    params.page = p;
    params.limit = limit;
  return  params;
}
function waituserPayByPage(p,limit){
  	var params =getParams(p,limit);
	$.post(WST.U('shop/orders/waituserPayByPage'),params,function(data,textStatus){
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


function finisedByPage(p,limit){
    var params =getParams(p,limit);
    $.post(WST.U('shop/orders/finishedByPage'),params,function(data,textStatus){
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
function waitDivleryByPage(p,limit){
    var params =getParams(p,limit);
	$.post(WST.U('shop/orders/waitDeliveryByPage'),params,function(data,textStatus){
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

function waitSelfTakeByPage(p,limit){
  var params =getParams(p,limit);
  $.post(WST.U('shop/orders/waitSelfTakeByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
            if(json.total>0){
                if(params.page>json.last_page && json.last_page >0){
                    waitSelfTakeByPage(json.last_page);
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
                            waitSelfTakeByPage(e.curr,e.limit);
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
  var params =getParams(p,limit);
  $.post(WST.U('shop/orders/deliveredByPage'),params,function(data,textStatus){
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
function editOrderMoney(id){
	var ll = WST.load({msg:'正在加载记录，请稍候...'});
	$.post(WST.U('shop/orders/getMoneyByOrder'),{id:id},function(data){
    	layer.close(ll);
    	var json = WST.toJson(data);
		if(json.status>0 && json.data){
			var tmp = json.data;
			$('#m_orderNo').html(tmp.orderNo);
			$('#m_goodsMoney').html(tmp.goodsMoney);
			$('#m_deliverMoney').html(tmp.deliverMoney);
			$('#m_totalMoney').html(tmp.totalMoney);
			$('#m_realTotalMoney').html(tmp.realTotalMoney);
			WST.open({type: 1,title:"修改订单价格",shade: [0.6, '#000'],border: [0],
				content: $('#editMoneyBox'),area: ['550px', '350px'],btn: ['确定','取消'],
				yes:function(index, layero){
					var newOrderMoney = $('#m_newOrderMoney').val();
					WST.confirm({content:'您确定修改后的订单价格为¥<span class="j-warn-order-money">'+newOrderMoney+'</span>吗？',yes:function(cf){

						var ll = WST.load({msg:'正在提交信息，请稍候...'});
						$.post(WST.U('shop/orders/editOrderMoney'),{id:id,orderMoney:newOrderMoney},function(data){
							var json = WST.toJson(data);
							if(json.status>0){
								$('#newOrderMoney').val();
								WST.msg(json.msg,{icon:1});
								waituserPayByPage(WST_CURR_PAGE);
								layer.close(cf);
								layer.close(index);
						    	layer.close(ll);
							}else{
								WST.msg(json.msg,{icon:2});
							}
						});
					}});
				},
				end: function(index, layero){
					$('#editMoneyBox').hide();
				}
			});
            $('#m_newOrderMoney').val("");
		}
    });
}

    function deliver(id,deliverType){
	if(deliverType==1){
        WST.confirm({content:"您确定用户已提货了吗？", yes:function(tips){
            var ll = WST.load('数据处理中，请稍候...');
            $.post(WST.U('shop/orders/deliver'),{id:id,expressId:0,expressNo:''},function(data){
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
	}else{
        $.post(WST.U('shop/orders/waitdeliverbyid'),{id:id},function(json){
        	json = WST.toJson(json);
            if(json.status > 0){
            	json = json.data;
                $('#goods_info').empty();
                $('.user_name').empty();
                $('.user_address').empty();
                $('.user_phone').empty();
                $.each(json.list, function(idx, obj) {
					var goodsSpecNames = "";
					if(obj.goodsSpecNames && WST.blank(obj.goodsSpecNames)!=""){
						goodsSpecNames = "<br><span style='color:#409eff'>"+obj.goodsSpecNames.replace(/@@_@@/g, "、")+"</span>";
					}
                    $('#goods_info').append("<tr><td class='delivery_select'><input class='chk' "+(obj.hasDeliver?'disabled':'')+" type='checkbox' value='"+obj.id+"'/></td>\
												 <td class='delivery_good'><img src='"+WST.conf.RESOURCE_PATH+'/'+obj.goodsImg+"'/></td>\
												 <td style='line-height: 18px;'>"+obj.goodsName+goodsSpecNames+"</td><td>"+obj.goodsNum+"</td><td>"+(obj.hasDeliver?'已发货':'')+"</td></tr>");
                });
				$('.user_name').append(json.userName);
				$('.user_address').append(json.userAddress);
				$('.user_phone').append(json.userPhone);
            }
        });
		WST.open({type: 1,title:"请输入发货快递信息",shade: [0.6, '#000'], border: [0],offset:10,
			content: $('#deliverBox'),area: ['1000px', ''],btn: ['确定发货','取消'],
			yes:function(index, layero){
                var params = {};
                params.id = id;
                params.expressId = $('#expressId').val();
                params.expressNo = $('#expressNo').val();
                params.deliverType = $("input[name='delivery_type']:checked").val();
                if(params.deliverType == 1){
                    if(params.expressId == '' || params.expressNo == ''){
                        WST.msg('请填写快递信息',{icon:2});
                        return;
                    }
                }
                var selectIds = WST.getChks('.chk');
                if(selectIds.length==0){
                    WST.msg('请选择要发货的商品',{icon:2});
                    return;
                }
                params.selectOrderGoodsIds = selectIds.join(',');
                var ll = WST.load({msg:'正在提交信息，请稍候...'});
				$.post(WST.U('shop/orders/deliver'),params,function(data){
					var json = WST.toJson(data);
					if(json.status>0){
						$('#deliverForm')[0].reset();
                        $('.deliver_express').show();
						WST.msg(json.msg,{icon:1});
						waitDivleryByPage(WST_CURR_PAGE);
						layer.close(index);
				    	layer.close(ll);
					}else{
						WST.msg(json.msg,{icon:2});
					}
				});
			},
			end: function(index, layero){
				$('#deliverBox').hide();
			}
	    });
    }
}
function failureByPage(p,limit){
    var params =getParams(p,limit);
	$.post(WST.U('shop/orders/failureByPage'),params,function(data,textStatus){

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
function refundByPage(p){
    var params =getParams(p,limit);
	$.post(WST.U('shop/orders/refundByPage'),params,function(data,textStatus){
		$('#loading').hide();
		var json = WST.toJson(data);
		$('.j-order-row').remove();
		if(json.status==1){
			json = json.data;
            if(json.total>0){
                $('.order_remaker').remove();
                if(params.page>json.last_page && json.last_page >0){
                    refundByPage(json.last_page);
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
                            refundByPage(e.curr,e.limit);
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
function refund(id,type){
    var ll = WST.load({msg:'正在加载信息，请稍候...'});
	$.post(WST.U('shop/orders/toShopRefund'),{id:id},function(data){
		layer.close(ll);
		var w = WST.open({
			    type: 1,
			    title:"退款操作",
			    shade: [0.6, '#000'],
			    border: [0],
			    content: data,
			    area: ['500px', '400px'],
			    btn: ['提交', '关闭窗口'],
		        yes: function(index, layero){
		        	var params = {};
		        	params.refundStatus = $('#refundStatus1')[0].checked?1:-1;
		        	params.content = $.trim($('#shopRejectReason').val());
		        	params.id = id;
		        	if(params.refundStatus==-1 && params.content==''){
		        		WST.msg('请输入不同意原因',{icon:2});
		        		return;
		        	}
		        	ll = WST.load({msg:'数据处理中，请稍候...'});
				    $.post(WST.U('shop/orderrefunds/shoprefund'),params,function(data){
				    	layer.close(ll);
				    	var json = WST.toJson(data);
						if(json.status==1){
							WST.msg(json.msg, {icon: 1});
							layer.close(w);
							if(type=='failure'){
								failureByPage(WST_CURR_PAGE);
							}else{
								refundByPage(WST_CURR_PAGE);
							}

						}else{
							WST.msg(json.msg, {icon: 2});
						}
				   });
		        }
			});
	});
}
function view(id,src){
	location.href=WST.U('shop/orders/view','id='+id+'&src='+src+'&p='+WST_CURR_PAGE);
}


/********** 订单投诉列表 ***********/
function toView(id){
  location.href=WST.U('shop/ordercomplains/getShopComplainDetail','id='+id+'&p='+WST_CURR_PAGE);
}
function toBack(p){
    location.href=WST.U('shop/ordercomplains/shopcomplain','p='+p);
}
function toBacks(p,src){
    location.href=WST.U('shop/orders/'+src,'p='+p);
}
function toRespond(id){
  location.href=WST.U('shop/ordercomplains/respond','id='+id+'&p='+WST_CURR_PAGE);
}

function complainByPage(p){
  $('#list').html('<img src="'+WST.conf.ROOT+'/wstmart/shop/view/default/img/loading.gif">正在加载数据...');
  var params = {};
  params = WST.getParams('.s-query');
  params.key = $.trim($('#key').val());
  params.page = p;
  $.post(WST.U('shop/ordercomplains/queryShopComplainByPage'),params,function(data,textStatus){
      var json = WST.toJson(data);
      if(json.status==1 && json.data){
      	  var json = json.data;
          var gettpl = document.getElementById('tblist').innerHTML;
          layui.laytpl(gettpl).render(json.data, function(html){
            $('#list').html(html);
          });
		  if(json.last_page>1){
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
					  if(!first){
						  complainByPage(e.curr);
					  }
				  }
			  });
		  }
        }
  });
}


/************  应诉页面  ************/
function respondInit(){
$('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
  WST.showPhotos("#photos-complain",true);

  var uploader =WST.upload({
        pick:'#filePicker',
        formData: {dir:'complains',isThumb:1},
        fileNumLimit:5,
        accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
        callback:function(f,file){
          $('#annex').show();
          var json = WST.toJson(f);
          if(json.status==1){
          var tdiv = $("<div style='width:75px;float:left;margin-right:5px;'>"+
                       "<img class='respond_pic"+"' width='75' height='75' src='"+WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb+"' v='"+json.savePath+json.name+"'></div>");
          var btn = $('<div style="position:relative;top:-80px;left:60px;cursor:pointer;" ><img src="'+WST.conf.ROOT+'/wstmart/shop/view/default/img/seller_icon_error.png"></div>');
          tdiv.append(btn);
          $('#picBox').append(tdiv);
          btn.on('click','img',function(){
              uploader.removeFile(file);
              $(this).parent().parent().remove();
              uploader.refresh();
              if($('#picBox').children().size()<=0)$('#annex').hide();
          });
          }else{
              WST.msg(json.msg,{icon:2});
          }
      },
      progress:function(rate){
          $('#uploadMsg').show().html('已上传'+rate+"%");
      }
    });
}
function saveRespond(p){
    $('#respondForm').isValid(function(v){
		if(v){
          var params = WST.getParams('.ipt');
          var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
          var img = [];
          $('.respond_pic').each(function(){
              img.push($(this).attr('v'));
          });
          params.respondAnnex = img.join(',');
          $.post(WST.U('shop/orderComplains/saveRespond'),params,function(data,textStatus){
                layer.close(loading);
                var json = WST.toJson(data);
                if(json.status=='1'){
                    WST.msg('您的应诉已提交，请留意信息回复', {icon: 6},function(){
                       location.href = WST.U('shop/ordercomplains/shopComplain','p='+p);
                   });
                }else{
                      WST.msg(json.msg,{icon:2});
                }
          });
        }
    });
}
//导出订单(selfType 1:待发货订单 2：待自提订单)
function toExport(typeId,status,type,selfType){
	var params = {};
	params = WST.getParams('.s-ipt');
	params.typeId = typeId;
	params.orderStatus = status;
	params.type = type;
	params.selfType = selfType;
	var box = WST.confirm({content:"您确定要导出订单吗?",yes:function(){
		layer.close(box);
		location.href=WST.U('shop/orders/toExport',params);
         }});
}
//导出订单
function toDeliverTemplate(){
	var params = {};
	params = WST.getParams('.s-ipt');
	var box = WST.confirm({content:"本次只会导出未发货的商品信息?",yes:function(){
		layer.close(box);
		location.href=WST.U('shop/orders/toDeliverTemplate',params);
         }});
}
//导入订单
function toExportDeliver(){
	location.href=WST.U('shop/imports/toDeliverExport');
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
	$.post(WST.U('shop/orders/getVerificatOrder'),params,function(data,textStatus){
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
		$.post(WST.U('shop/orders/orderVerificat'),params,function(data,textStatus){
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
function toEditOrderReceiveInfo(orderId){
	$.post(WST.U('shop/orders/getOrderReceiveInfo'),{orderId:orderId},function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status==1){
			layerbox =	layer.open({
				title:'修改收货地址',
				type: 1,
				area: ['800px', '300px'], //宽高
				content: $('.j-edit-box'),
				end: function(index, layero){
					$('.j-edit-box').hide();
				}
			});
			$('.j-edit-box').removeClass('hide');
			WST.setValues(json.data);
			$('#orderId').val(orderId);
			$('input[name="addrUserPhone"]').val(json.data.userPhone);
			$("select[id^='area_0_']").remove();
			var areaIdPath = json.data.areaIdPath.split("_");
			$('#area_0').val(areaIdPath[0]);
			var aopts = {id:'area_0',val:areaIdPath[0],childIds:areaIdPath,className:'j-areas'}
			WST.ITSetAreas(aopts);
		}else{
			WST.msg(json.msg,{icon:2});
		}
	});
}
//保存收货地址
function saveAddress(){
	var isNoSelected = false;
	$('.j-areas').each(function(){
		isSelected = true;
		if($(this).val()==''){
			isNoSelected = true;
			return;
		}
	})
	if(isNoSelected){
		WST.msg('请选择完整收货地址！',{icon:2});
		return;
	}
	var load = WST.load({msg:'正在提交数据，请稍后...'});
	var orderId = $('#orderId').val();
	var params = WST.getParams('.j-eipt');
	params.areaId = WST.ITGetAreaVal('j-areas');
	params.orderId = orderId;
	if(params.userName==''){
		WST.msg('收货人名称不能为空',{icon:2});
		return;
	}
	if(params.userPhone==''){
		WST.msg('联系电话不能为空',{icon:2});
		return;
	}
	if(isNoSelected){
		WST.msg('请选择地址',{icon:2});
		return;
	}
	if(params.userAddress==''){
		WST.msg('请填写详细地址',{icon:2});
		return;
	}
	$.post(WST.U('shop/orders/editOrderReceiveInfo'), params, function(data){
		layer.close(load);
		var json = WST.toJson(data);
		if( json.status == 1 ){
			WST.msg(json.msg, {icon: 1});
			setTimeout(function(){
				layer.close(layerbox);
			},1500);
		}else{
			WST.msg(json.msg,{icon:2});
		}
	});
}
function toEditOrderExpressInfo(orderId){
	$('#express-box').empty();
	$.post(WST.U('shop/orders/getOrderExpressInfo'),{orderId:orderId},function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status==1){
			if(json && json.data && json.data.length>0) {
				var gettpl = document.getElementById('expressList').innerHTML;
				layui.laytpl(gettpl).render(json.data, function (html) {
					$('#express-box').append(html);
				});
				for(var i=0;i<json.data.length;i++){
					var expressId = json.data[i].expressId;
					$('.expressId').each(function(idx,item){
						if(i==idx){
							$(item).find('option').each(function(idx2,item2){
								if(parseInt($(item2).val()) == expressId){
									$(item2).prop("selected",true);
								}
							});
						}
					});
				}
			}
		}else{
			WST.msg(json.msg,{icon:2});
		}
	});
	var box = WST.open({type: 1,title:"修改物流信息",shade: [0.6, '#000'], border: [0],offset:10,
		content: $('#deliverBox'),area: ['1000px', '50%'],btn: ['保存','取消'],
		yes:function(index, layero){
			var params = {};
			var orderExpressIdArr = [];
			var expressIdArr = [];
			var expressNoArr = [];
			var flag = false;
			$('.orderExpressId').each(function(idx,item){
				var orderExpressId = $(item).val();
				orderExpressIdArr.push(orderExpressId);
			});
			$('.expressId').each(function(idx,item){
				var expressId = 0;
				$(item).find('option').each(function(idx2,item2) {
					if($(item2).prop('selected')){
						expressId = parseInt($(item2).val());
					}
				});
				if(expressId==0){
					WST.msg('请选择快递公司',{icon:2});
					flag = true;
				}
				expressIdArr.push(expressId);
			});
			$('.expressNo').each(function(idx,item){
				var expressNo = $(item).val();
				if(expressNo==''){
					WST.msg('请填写快递单号',{icon:2});
					flag = true;
				}
				expressNoArr.push(expressNo);
			});
			if(flag)return;
			params.orderId = orderId;
			params.orderExpressId = orderExpressIdArr.join(',');
			params.expressId = expressIdArr.join(',');
			params.expressNo = expressNoArr.join(',');
			$.post(WST.U('shop/orders/editOrderExpressInfo'), params, function(data){
				var json = WST.toJson(data);
				if( json.status == 1 ){
					WST.msg(json.msg, {icon: 1});
					setTimeout(function(){
						layer.close(box);
					},1500);
				}else{
					WST.msg(json.msg,{icon:2});
				}
			});
		},
		end: function(index, layero){
			$('#deliverBox').hide();
		}
	});

}

/*********** 商家拒收 **********/
function toReject(id){
	var ll = WST.load({msg:'正在加载信息，请稍候...'});
	$.post(WST.U('shop/orders/toReject'),{id:id},function(data){
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
				    $.post(WST.U('shop/orders/reject'),params,function(data){
				    	layer.close(w);
				    	layer.close(ll);
				    	var json = WST.toJson(data);
						if(json.status==1){
							WST.msg(json.msg, {icon: 1});
							waitSelfTakeByPage(WST_CURR_PAGE);
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
	$.post(WST.U('shop/orders/getShopRemarks'),{orderId:id},function(data){
		layer.close(ll);
		var json = WST.toJson(data);
		if(json.status>0 && json.data){
			var tmp = json.data;
			WST.open({type: 1,title:"订单【"+tmp.orderNo+"】备注",shade: [0.6, '#000'],border: [0],
				content: '<textarea style="width:calc(100% - 25px);height:calc(100% - 20px);margin:5px" id="m_orderShopRemarks">'+WST.blank(tmp.orderShopRemarks)+'</textarea>',area: ['500px', '350px'],btn: ['确定','取消'],end:function(){},
				yes:function(index, layero){
					var ll = WST.load({msg:'正在提交信息，请稍候...'});
					$.post(WST.U('shop/orders/editShopRemarks'),{orderId:id,orderShopRemarks:$('#m_orderShopRemarks').val()},function(data){
						var json = WST.toJson(data);
						if(json.status>0){
							WST.msg(json.msg,{icon:1});
							switch(src){
								case 'waituserPay':	waituserPayByPage();break;
								case 'waitDelivery': waitDivleryByPage();break;
								case 'delivered':
									deliveredByPage();break;
								case 'waitSelfTake':
									waitSelfTakeByPage();break;
								case 'finished':
									finisedByPage();break;
								case 'failure':
									failureByPage();break;
								case 'refund':
									refundByPage();	break;
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
