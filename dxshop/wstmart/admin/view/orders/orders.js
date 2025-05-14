var mmg;
$(function(){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
})
function initGrid(page){
	var p = WST.arrayParams('.j-ipt');
  mmg = layui.table;
  mmg.render({elem: '#mmg',url:WST.U('admin/orders/pageQuery',p.join('&')),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:page},
    cols: [[
      {title:'#',type:'numbers'},
      {title:'订单编号', field:'orderNo', width: 120, templet:function(item){
          var h = "";
          switch(item['orderSrc']){
             case 0:h += '<i class="fa fa-desktop"></i>';break;
             case 1:h += '<i class="fa fa-wechat"></i>';break;
             case 2:h += '<i class="fa fa-mobile fa-lg"></i>';break;
             case 3:h += '<i class="fa fa-android"></i>';break;
             case 4:h += '<i class="fa fa-apple"></i>';break;
             case 5:h += '<i class="fa fa-gg-circle"></i>';break;
          }
          h += " <a style='cursor:pointer' onclick='javascript:showDetail("+ item['orderId'] +");'>"+item['orderNo']+"</a>";
          return h;
      }},
      {title:'收货人', field:'userName', templet:function(item){
          return item['userName']+' | '+item['userAddress'];
      }},
      {title:'店铺', field:'shopName', width: 150},
      {title:'实收金额', field:'realTotalMoney', width: 90, templet:function(item){return '￥'+item['realTotalMoney'];}},
      {title:'支付方式', field:'payType' , width: 80},
      {title:'配送方式', field:'deliverType', width: 90},
      {title:'订单来源', field:'orderCodeTitle', width: 90},
      {title:'下单时间', field:'createTime', width: 170},
      {title:'订单状态', field:'orderStatus', width: 100, templet:function(item){
          if(item['orderStatus']==-1 || item['orderStatus']==-3){
              return "<span class='statu-no'><i class='fa fa-ban'></i> "+item.status+"</span>";
          }else if(item['orderStatus']==2){
              return "<span class='statu-yes'><i class='fa fa-check-circle'></i> "+item.status+"</span>";
          }else{
              return "<span class='statu-wait'><i class='fa fa-clock-o'></i> "+item.status+"</span>";
          }
      }},
      {field:'op', title: '操作',fixed: 'right',align:'center', width:220,templet: function(item){
          var h = "";
          h += "<a class='btn btn-blue' href='javascript:toView(" + item['orderId'] + ")'><i class='fa fa-search'></i>详情</a> ";
          if(item['orderStatus']!=-1 && item['orderStatus']!=2)h += "<a class='btn btn-blue' href='javascript:changeOrderStatus(" + item['orderId'] + ")'><i class='fa fa-exclamation-triangle'></i>变更订单状态</a> ";
          return h;
      }}
    ]],
    done:function(res, curr, count){
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

function toView(id){
	location.href=WST.U('admin/orders/view','id='+id+'&src=orders&p='+WST_CURR_PAGE);
}
function toBack(p,src){
    location.href= $('#refererURL').val();
}
function loadGrid(page){
	var p = WST.getParams('.j-ipt');
  page=(page<=1)?1:page;
	mmg.reload('mmg',{page:{curr:page},where:p});
}
function toExport(){
	var params = {};
	params = WST.getParams('.j-ipt');
	var box = WST.confirm({content:"您确定要导出订单吗?",yes:function(){
		layer.close(box);
		location.href=WST.U('admin/orders/toExport',params);
    }});
}
function showDetail(id){
    parent.showBox({title:'订单详情',type:2,content:WST.U('admin/orders/view',{id:id,from:1}),area: ['1020px', '500px'],btn:['关闭']});
}
function loadMore(){
    var h = WST.pageHeight();
    if($('#moreItem').hasClass('hide')){
        $('#moreItem').removeClass('hide');
        mmg.resize({height:h-119});
    }else{
        $('#moreItem').addClass('hide');
        mmg.resize({height:h-89});
    }
}

function changeOrderStatus(id){
    location.href=WST.U('admin/orders/changeOrderStatus','id='+id+'&p='+WST_CURR_PAGE);
}
function initChange(){
   var form = layui.form;
   form.on('radio(orderStatus)', function(data){
      if(data.value==0){
          $('.result_-1').hide();
      }else{
          $('.result_0').hide();
      }
      $('.result_'+data.value).show();
   });
}
function changeOrder(orderId,p){
   var params = {}
   params.orderId = orderId;
   params.orderStatus = $('input[name="orderStatus"]:checked').val();
   if(params.orderStatus==-1){
       params.realTotalMoney = $('#realTotalMoney_0').val();
   }else if(params.orderStatus==0){
       params.payFrom = $('#payFrom_0').val();
       params.realTotalMoney = $('#realTotalMoney_0').val();
       params.trade_no = $('#trade_no_0').val();
   }
   var ll = WST.msg('数据处理中，请稍候...');
   $.post(WST.U('admin/orders/changeOrder'),params,function(data){
        layer.close(ll);
        var json = WST.toAdminJson(data);
        if(json.status>0){
            WST.msg(json.msg, {icon: 1,time:1000},function(){
                if(json.data && json.data.refundId){
                    refund(json.data.refundId,p);
                }else{
                    WST.backPrePage();
                }
            });
        }else{
            WST.msg(json.msg, {icon: 2});
        }
    });
}
function refund(id,p){
    params ={id:id}
    var ll = WST.msg('正在进行退款，请稍候...');
    $.post(WST.U('admin/orderrefunds/orderRefund'),params,function(data){
        layer.close(ll);
        var json = WST.toAdminJson(data);
        if(json.status==1){
            WST.msg(json.msg, {icon: 1,time:1000},function(){
                WST.backPrePage();
            });
        }else{
            WST.msg(json.msg, {icon: 2});
        }
   });
}
