var WST_CURR_PAGE = 1;
// 提醒发货
function noticeDeliver(id){
	var box = WST.confirm({content:"您确定要提醒发货吗?",yes:function(){
			layer.close(box);
			var ll = WST.load({msg:'正在提交信息，请稍候...'});
			$.post(WST.U('home/orders/noticeDeliver'),{id:id},function(data){
				var json = WST.toJson(data);
				if(json.status>0){
					WST.msg(json.msg,{icon:1});
					waitReceiveByPage(WST_CURR_PAGE);
				    layer.close(ll);
				}else{
					WST.msg(json.msg,{icon:2});
				}
			});
     }});
}

function waitPayByPage(p,limit){
	$('#loading').show();
	var params = {};
	params = WST.getParams('.u-query');
	params.key = $.trim($('#key').val());
	params.page = p;
	params.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('home/orders/waitPayByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
	    	if(params.page>json.last_page && json.last_page >0){
               waitPayByPage(json.last_page);
               return;
            }
	       	var gettpl = document.getElementById('tblist').innerHTML;
	       	layui.laytpl(gettpl).render(json.data, function(html){
	       		$(html).insertAfter('#loadingBdy');
	       		$('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
	       	});
	       	if(json.total>0){
	          layui.laypage.render({
		          elem: 'pager',
		          count:json.total,
		          limit:json.per_page,
		          curr: json.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      waitPayByPage(e.curr,e.limit);
	                    }
	               }
	           });
	        }else{
              $('#pager').empty();
	        }
       	}
	});
}
function waitReceiveByPage(p,limit){
	$('#loading').show();
	var params = {};
	params = WST.getParams('.u-query');
	params.key = $.trim($('#key').val());
	params.page = p;
	params.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('home/orders/waitReceiveByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
	    	if(params.page>json.last_page && json.last_page >0){
               waitReceiveByPage(json.last_page);
               return;
            }
	       	var gettpl = document.getElementById('tblist').innerHTML;
	       	layui.laytpl(gettpl).render(json.data, function(html){
	       		$(html).insertAfter('#loadingBdy');
	       		$('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
	       	});

	       	if(json.total>0){
	          layui.laypage.render({
		          elem: 'pager',
		          count:json.total,
		          limit:json.per_page,
		          curr: json.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      waitReceiveByPage(e.curr,e.limit);
	                    }
	               }
	           });
	        }else{
              $('#pager').empty();
	        }
       	}
	});
}
function toReceive(id){
	WST.confirm({content:'您确定已收货吗？',yes:function(){
		var ll = WST.load({msg:'正在提交信息，请稍候...'});
		$.post(WST.U('home/orders/receive'),{id:id},function(data){
			var json = WST.toJson(data);
			if(json.status>0){
				WST.msg(json.msg,{icon:1});
				waitReceiveByPage(WST_CURR_PAGE);
			    layer.close(ll);
			}else{
				WST.msg(json.msg,{icon:2});
			}
		});
	}})
}
function waitAppraiseByPage(p,limit){
	$('#loading').show();
	var params = {};
	params = WST.getParams('.s-query');
	params.key = $.trim($('#key').val());
	params.page = p;
	params.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('home/orders/waitAppraiseByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
	    	if(params.page>json.last_page && json.last_page >0){
               waitAppraiseByPage(json.last_page);
               return;
            }
	       	var gettpl = document.getElementById('tblist').innerHTML;
	       	layui.laytpl(gettpl).render(json.data, function(html){
	       		$(html).insertAfter('#loadingBdy');
	       		$('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
	       	});
	       	if(json.total>0){
	          layui.laypage.render({
		          elem: 'pager',
		          count:json.total,
		          limit:json.per_page,
		          curr: json.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      waitAppraiseByPage(e.curr,e.limit);
	                    }
	               }
	           });
	        }else{
              $('#pager').empty();
	        }
       	}
	});
}
function finishByPage(p,limit){
	$('#loading').show();
	var params = {};
	params = WST.getParams('.u-query');
	params.key = $.trim($('#key').val());
	params.page = p;
	params.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('home/orders/finishByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
            if(params.page>json.last_page && json.last_page >0){
                finishByPage(json.last_page);
                return;
            }
	       	var gettpl = document.getElementById('tblist').innerHTML;
	       	layui.laytpl(gettpl).render(json.data, function(html){
	       		$(html).insertAfter('#loadingBdy');
	       		$('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
	       	});
	       	if(json.total>0){
	          layui.laypage.render({
		          elem: 'pager',
		          count:json.total,
		          limit:json.per_page,
		          curr: json.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      finishByPage(e.curr,e.limit);
	                    }
	               }
	           });
	        }else{
              $('#pager').empty();
	        }
       	}
	});
}
function cancel(id,type){
	var ll = WST.load({msg:'正在加载信息，请稍候...'});
	$.post(WST.U('home/orders/toCancel'),{id:id},function(data){
		layer.close(ll);
		var w = WST.open({
			    type: 1,
			    title:"取消订单",
			    shade: [0.6, '#000'],
			    border: [0],
			    content: data,
			    area: ['500px', '260px'],
			    btn: ['提交', '关闭窗口'],
		        yes: function(index, layero){
		        	var reason = $.trim($('#reason').val());
		        	ll = WST.load({msg:'数据处理中，请稍候...'});
				    $.post(WST.U('home/orders/cancellation'),{id:id,reason:reason},function(data){
				    	layer.close(w);
				    	layer.close(ll);
				    	var json = WST.toJson(data);
						if(json.status==1){
							WST.msg(json.msg, {icon: 1});
							if(type==0){
								waitPayByPage(WST_CURR_PAGE);
							}else{
								waitReceiveByPage(WST_CURR_PAGE);
							}
						}else{
							WST.msg(json.msg, {icon: 2});
						}
				   });
		        }
			});
	});
}
function toReject(id){
	var ll = WST.load({msg:'正在加载信息，请稍候...'});
	$.post(WST.U('home/orders/toReject'),{id:id},function(data){
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
		        	params.reason = $.trim($('#reason').val());
		        	params.content = $.trim($('#content').val());
		        	params.id = id;
		        	if(params.id==10000 && params.conten==''){
		        		WST.msg('请输入拒收原因',{icon:2});
		        		return;
		        	}
		        	ll = WST.load({msg:'数据处理中，请稍候...'});
				    $.post(WST.U('home/orders/reject'),params,function(data){
				    	layer.close(w);
				    	layer.close(ll);
				    	var json = WST.toJson(data);
						if(json.status==1){
							WST.msg(json.msg, {icon: 1});
							waitReceiveByPage(WST_CURR_PAGE);
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
function cancelByPage(p,limit){
	$('#loading').show();
	var params = {};
	params = WST.getParams('.u-query');
	params.key = $.trim($('#key').val());
	params.page = p;
	params.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('home/orders/cancelByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
            if(params.page>json.last_page && json.last_page >0){
                cancelByPage(json.last_page);
                return;
            }
	       	var gettpl = document.getElementById('tblist').innerHTML;
	       	layui.laytpl(gettpl).render(json.data, function(html){
	       		$(html).insertAfter('#loadingBdy');
	       		$('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
	       	});
	       	if(json.total>0){
	          layui.laypage.render({
		          elem: 'pager',
		          count:json.total,
		          limit:json.per_page,
		          curr: json.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      finishByPage(e.curr,e.limit);
	                    }
	               }
	           });
	        }else{
              $('#pager').empty();
	        }
       	}
	});
}
function abnormalByPage(p,limit){
	$('#loading').show();
	var params = {};
	params = WST.getParams('.u-query');
	params.key = $.trim($('#key').val());
	params.page = p;
	params.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('home/orders/abnormalByPage'),params,function(data,textStatus){
		$('#loading').hide();
	    var json = WST.toJson(data);
	    $('.j-order-row').remove();
	    if(json.status==1){
	    	json = json.data;
	    	if(params.page>json.last_page && json.last_page >0){
               abnormalByPage(json.last_page);
               return;
            }
	       	var gettpl = document.getElementById('tblist').innerHTML;
	       	layui.laytpl(gettpl).render(json.data, function(html){
	       		$(html).insertAfter('#loadingBdy');
	       		$('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
	       	});
	       	if(json.total>0){
	          layui.laypage.render({
		          elem: 'pager',
		          count:json.total,
		          limit:json.per_page,
		          curr: json.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      finishByPage(e.curr,e.limit);
	                    }
	               }
	           });
	        }else{
              $('#pager').empty();
	        }
       	}
	});
}
function refund(id,src){
    var ll = WST.load({msg:'正在加载信息，请稍候...'});
	$.post(WST.U('home/orders/toRefund'),{id:id},function(data){
		layer.close(ll);
		var w = WST.open({
			    type: 1,
			    title:"申请退款",
			    shade: [0.6, '#000'],
			    border: [0],
			    content: data,
			    area: ['500px', '320px'],
			    btn: ['提交', '关闭窗口'],
		        yes: function(index, layero){
		        	var params = {};
		        	params.reason = $.trim($('#reason').val());
		        	params.content = $.trim($('#content').val());
		        	params.money = $.trim($('#money').val());
		        	params.id = id;
		        	if(params.money<0){
		        		WST.msg('无效的退款金额',{icon:2});
		        		return;
		        	}
		        	if(params.id==10000 && params.conten==''){
		        		WST.msg('请输入原因',{icon:2});
		        		return;
		        	}
		        	ll = WST.load({msg:'数据处理中，请稍候...'});
				    $.post(WST.U('home/orderrefunds/refund'),params,function(data){
				    	layer.close(ll);
				    	var json = WST.toJson(data);
						if(json.status==1){
							WST.msg(json.msg, {icon: 1});
							layer.close(w);
							if(src=='abnormal'){
                                abnormalByPage(WST_CURR_PAGE);
							}else{
                                cancelByPage(WST_CURR_PAGE);
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
	location.href=WST.U('home/orders/detail','id='+id+'&src='+src+'&p='+WST_CURR_PAGE);
}
function complain(id,src){
	location.href=WST.U('home/ordercomplains/complain','orderId='+id+'&src='+src+'&p='+WST_CURR_PAGE);
}
function afterSale(id,src){
	location.href=WST.U('home/orderservices/index','orderId='+id+'&src='+src+'&p='+WST_CURR_PAGE);
}


/******************** 评价页面 ***********************/
function appraisesShowImg(id){
  layer.photos({
      photos: '#'+id
    });
}
function toAppraise(id){
  location.href=WST.U("home/orders/orderAppraise",{'oId':id});
}
//文件上传
function upload(n){
    var uploader =WST.upload({
        pick:'#filePicker'+n,
        formData: {dir:'appraises',isThumb:1},
        fileNumLimit:5,
        accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
        callback:function(f,file){
          var json = WST.toJson(f);
          if(json.status==1){
          var tdiv = $("<div style='width:75px;float:left;margin-right:5px;'>"+
                       "<img class='appraise_pic"+n+"' width='75' height='75' src='"+WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb+"' v='"+json.savePath+json.name+"'></div>");
          var btn = $('<div style="position:relative;top:-80px;left:60px;cursor:pointer;" ><img src="'+WST.conf.ROOT+'/wstmart/home/view/default/img/seller_icon_error.png"></div>');
          tdiv.append(btn);
          $('#picBox'+n).append(tdiv);
          btn.on('click','img',function(){
            uploader.removeFile(file);
            $(this).parent().parent().remove();
            uploader.refresh();
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

function validator(n){
  $('#appraise-form'+n).validator({
         fields: {
                  score:  {
                    rule:"required",
                    msg:{required:"评分必须都大于0"},
                    ok:"",
                    target:"#score_error"+n,
                  },

              },

            valid: function(form){
              var params = {};
              //获取该评价的内容
              params.content = $('#content'+n).val();
              // 获取该评价附件
              var photo=[];
              var images = [];
              $('.appraise_pic'+n).each(function(k,v){
                  var img = $(this).attr('v');
                      // 用于评价成功后的显示
                      photo.push(WST.conf.RESOURCE_PATH+'/'+img);
                  images.push(img);
              });
              params.images = images.join(',');
              //获取评分
              params.goodsScore = $('.goodsScore'+n).find('[name=score]').val();
              params.timeScore = $('.timeScore'+n).find('[name=score]').val();
              params.serviceScore = $('.serviceScore'+n).find('[name=score]').val();
              params.goodsId = $('#gid'+n).val();
              params.orderId = $('#oid'+n).val();
              params.goodsSpecId = $('#gsid'+n).val();
              params.orderGoodsId = $('#ogId'+n).val();

              $.post(WST.U('home/goodsAppraises/add'),params,function(data,dataStatus){
                var json = WST.toJson(data);
                if(json.status==1){
                   var thisbox = $('#app-box'+n);
                   var html = '<div class="appraise-area"><div class="appraise-item"><div class="appraise-title">商品评分：</div>';
                       html += '<div class="appraise-content">';
                       // 商品评分
                       for(var i=1;i<=params.goodsScore;i++){
                          html +='<img src="'+WST.conf.STATIC+'/plugins/raty/img/star-on-big.png">';
                       }
                       html +='</div></div><div class="wst-clear"></div><div class="appraise-item"><div class="appraise-title"> 时效评分：</div>'
                       html +='<div class="appraise-content">'
                       // 时效评分
                       for(var i=1;i<=params.timeScore;i++){
                          html +='<img src="'+WST.conf.STATIC+'/plugins/raty/img/star-on-big.png">';
                       }
                       html +='</div></div><div class="wst-clear"></div><div class="appraise-item"><div class="appraise-title">服务评分：</div>';
                       html +='<div class="appraise-content">';
                       // 服务评分
                       for(var i=1;i<=params.serviceScore;i++){
                          html +='<img src="'+WST.conf.STATIC+'/plugins/raty/img/star-on-big.png">';
                       }
                       html +='</div></div><div class="wst-clear"></div><div class="appraise-item"><div class="appraise-title">点评内容：</div>';
                       // 评价内容
                       html +='<div class="appraise-content">';
                        // 获取当前年月日
                       var  oDate = new Date();
                       var year = oDate.getFullYear()+'-';    //获取系统的年；
                       var month = oDate.getMonth()+1+'-';     //获取系统月份，由于月份是从0开始计算，所以要加1
                       var day = oDate.getDate();        // 获取系统日，
                       html +='<p>'+params.content+'['+year+month+day+']</p>';
                       html +='</div></div><div class="wst-clear"></div><div class="appraise-item"><div class="appraise-title"> </div>';
                       // 评价附件
                       html +='<div class="appraise-content">';
                       // 当前生成的相册id
                       var imgBoxId = "appraise-img-"+n;
                       html +='<div id='+imgBoxId+'>'
                       var count = photo.length;
                       for(var m=0;m<count;m++){
                          html += '<img src="'+photo[m].replace(/(.*)\./,'$1_thumb.')+'" layer-src="'+photo[m]+'" width="75" height="75" style="margin-right:5px;">';
                       }
                       html +='</div></div></div></div>';
                       thisbox.html(html);
                       // 调用相册层
                       appraisesShowImg(imgBoxId);

                }else{
                  WST.msg(json.msg,{icon:2});
                }
              });

        }
  });
}

/* 用户评价管理 */
function showImg(id){
  layer.photos({
      photos: '#img-file-'+id
    });
}
function userAppraise(p,limit){
  if(typeof(limit)=='undefined')limit = WST_PAGE_LIMIT;
  $('#list').html('<img src="'+WST.conf.ROOT+'/wstmart/home/view/default/img/loading.gif">正在加载数据...');
  var params = {};
  params = WST.getParams('.s-query');
  params.key = $.trim($('#key').val());
  params.page = p;
  params.pagesize = limit;
  $.post(WST.U('home/goodsappraises/userAppraise'),params,function(data,textStatus){
      var json = WST.toJson(data);
      if(!json.data.data){
      	$('#list').html('');
      }
      if(json.status==1){
          if(params.page>json.data.last_page && json.data.last_page >0){
              userAppraise(json.data.last_page);
              return;
          }
          var gettpl = document.getElementById('tblist').innerHTML;
          layui.laytpl(gettpl).render(json.data.data, function(html){
            $('#list').html(html);
            for(var g=0;g<=json.data.data.length;g++){
              showImg(g);
            }
           $('.j-lazyImg').lazyload({ effect: "fadeIn",failurelimit : 10,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+window.conf.GOODS_LOGO});
          });
          if(json.data.total>0){
	          layui.laypage.render({
		          elem: 'pager',
		          count:json.data.total,
		          limit:json.data.per_page,
		          curr: json.data.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      userAppraise(e.curr,e.limit);
	                    }
	               }
	           });
	      }else{
              $('#pager').empty();
	      }
        }
  });
}
/**************** 用户投诉页面 *****************/
function userComplainInit(){
	 var uploader =WST.upload({
        pick:'#filePicker',
        formData: {dir:'complains',isThumb:1},
        fileNumLimit:5,
        accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
        callback:function(f,file){
          var json = WST.toJson(f);
          if(json.status==1){
          var tdiv = $("<div style='width:75px;float:left;margin-right:5px;'>"+
                       "<img class='complain_pic"+"' width='75' height='75' src='"+WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb+"' v='"+json.savePath+json.name+"'></div>");
          var btn = $('<div style="position:relative;top:-80px;left:60px;cursor:pointer;" ><img src="'+WST.conf.ROOT+'/wstmart/home/view/default/img/seller_icon_error.png"></div>');
          tdiv.append(btn);
          $('#picBox').append(tdiv);
          btn.on('click','img',function(){
            uploader.removeFile(file);
            $(this).parent().parent().remove();
            uploader.refresh();
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
function saveComplain(historyURL){
   /* 表单验证 */
  $('#complainOrderForm').isValid(function(v){
		if(v){
              var params = WST.getParams('.ipt');
              var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
              var img = [];
              $('.complain_pic').each(function(){
                    img.push($(this).attr('v'));
              });
              params.complainAnnex = img.join(',');
              $.post(WST.U('home/orderComplains/saveComplain'),params,function(data,textStatus){
                    layer.close(loading);
                    var json = WST.toJson(data);
                    if(json.status=='1'){
                        WST.msg('您的投诉已提交，请留意信息回复', {icon: 6},function(){
                         location.href = WST.U('home/ordercomplains/index');
                       });
                    }else{
                          WST.msg(json.msg,{icon:2});
                    }
              });
        }
  });
}

/*********************** 用户投诉列表页面 ***************************/
function toView(id){
  location.href=WST.U('home/ordercomplains/getUserComplainDetail','id='+id+'&p='+WST_CURR_PAGE);
}
function complainByPage(p,limit){
  $('#list').html('<img src="'+WST.conf.ROOT+'/wstmart/home/view/default/img/loading.gif">正在加载数据...');
  var params = {};
  params = WST.getParams('.s-query');
  params.key = $.trim($('#key').val());
  params.page = p;
  params.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
  $.post(WST.U('home/ordercomplains/queryUserComplainByPage'),params,function(data,textStatus){
      var json = WST.toJson(data);
      if(json.status==1){
          if(params.page>json.data.last_page && json.data.last_page >0){
              complainByPage(json.data.last_page);
              return;
          }
          var gettpl = document.getElementById('tblist').innerHTML;
          layui.laytpl(gettpl).render(json.data.data, function(html){
            $('#list').html(html);
          });
          if(json.data.total>0){
	          layui.laypage.render({
		          elem: 'pager',
		          count:json.data.total,
		          limit:json.data.per_page,
		          curr: json.data.current_page,
		          layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	               groups: 3,
	               jump: function(e, first){
	               	    WST_PAGE_LIMIT = e.limit;
	                    if(!first){
	                      complainByPage(e.curr,e.limit);
	                    }
	               }
	           });
	        }else{
              $('#pager').empty();
	        }
        }
  });
}
//导出订单
function toExport(typeId,status,type){
	var params = {};
	params = WST.getParams('.u-query');
	params.typeId = typeId;
	params.orderStatus = status;
	params.type = type;
	var box = WST.confirm({content:"您确定要导出订单吗?",yes:function(){
		layer.close(box);
		location.href=WST.U('home/orders/toExport',params);
         }});
}

//调用腾讯地图
function storeMap(){
	var latitude = parseFloat($("#latitude").val());
	var longitude = parseFloat($("#longitude").val());
	var storeName = $("#storeName").val();
	var center = new qq.maps.LatLng(latitude,longitude);
	//定义map变量 调用 qq.maps.Map() 构造函数   获取地图显示容器
	var map = new qq.maps.Map(document.getElementById("container"), {
		center: center,
		zoom:15
	});
	//添加文本备注
	var infoWin = new qq.maps.InfoWindow({
		map: map
	});
	infoWin.open();
	infoWin.setContent(storeName);
	infoWin.setPosition(map.getCenter());
}

