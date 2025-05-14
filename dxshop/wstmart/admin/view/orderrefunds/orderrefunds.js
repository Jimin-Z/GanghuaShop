var grid;
$(function(){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });

})
function toView(id,sId){
	location.href=WST.U('admin/orders/view','id='+id+'&serviceId='+sId+'&src=orderrefunds&p='+WST_CURR_PAGE);
}

function initRefundGrid(p){
  mmg = layui.table;
  mmg.render({elem: '#mmg',url:WST.U('admin/orderrefunds/refundPageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
    cols: [[
      {title:'#',type:'numbers'},
      {title:'订单编号', field:'orderNo', width:120,templet: function(item){
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
    {title:'申请人', field:'loginName', width:150},
    {title:'店铺', field:'shopName', width:200},
    {title:'订单来源', field:'orderCodeTitle',width:100},
    {title:'配送方式', field:'deliverType',width:120},
    {title:'实收金额', field:'realTotalMoney', width:100,templet: function(item){
        return "¥"+item['realTotalMoney'];
    }},
    {title:'申请退款金额', field:'backMoney',width:150, templet: function(item){
        return "¥"+item['backMoney'];
    }},
    {title:'退还积分', field:'useScore',width:100},
    {title:'申请时间', field:'createTime', width:150},
    {title:'支付来源', field:'refundTo', width:100},
    {title:'退款状态', field:'isRefund', width:100,templet: function(item){
        if(item['serviceId']>0)return (item['isServiceRefund']==1)?"已退款":"未退款";
        return (item['isRefund']==1)?"已退款":"未退款";
    }},
    {title:'退款备注', field:'refundRemark'},
        {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
        var h = '';
        if((item['serviceId']==0 && item['isRefund']==0) || (item['serviceId']>0 && item['isServiceRefund']==0)){
                    if(WST.GRANT.TKDD_04)h += "<a class='btn btn-blue' href='javascript:toRefund(" + item['refundId'] + ", "+ item['serviceId'] +")'><i class='fa fa-search'></i>退款</a> ";
        }
        h += "<a class='btn btn-blue' href='javascript:toView(" + item['orderId'] + ", "+ item['serviceId'] +")'><i class='fa fa-search'></i>详情</a> ";
        return h;
    }}
    ]],
    done:function(res, curr, count){
      var e = this;
      var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
      if(count>0 && curr>total_page){
        loadRefundGrid(total_page);
        return;
      }
      WST_CURR_PAGE = curr;
    }
  });
}
function loadRefundGrid(page){
	var p = WST.getParams('.j-ipt');
	page=(page<=1)?1:page;
	mmg.reload('mmg',{page:{curr:page},where:p});
}
var w;
function toRefund(id,sId){
	var ll = WST.msg('正在加载信息，请稍候...');
	$.post(WST.U('admin/orderrefunds/toRefund',{id:id,serviceId:sId}),{},function(data){
		layer.close(ll);
		w =WST.open({type: 1,title:"订单退款",shade: [0.6, '#000'],offset:'50px',border: [0],content:data,area: ['700px', '600px']});
	});
}
function orderRefund(id){
	$('#editFrom').isValid(function(v){
		if(v){
        	var params = {};
        	params.content = $.trim($('#content').val());
        	params.id = id;
        	ll = WST.msg('正在处理数据，请稍候...');
		    $.post(WST.U('admin/orderrefunds/orderRefund'),params,function(data){
		    	layer.close(ll);
		    	var json = WST.toAdminJson(data);
				if(json.status==1){
                    layer.close(w);
					WST.msg(json.msg, {icon: 1,time:2500},function(){
                        loadRefundGrid(WST_CURR_PAGE);
                    });
				}else{
					WST.msg(json.msg, {icon: 2});
				}
		   });
		}
    })
}
function showDetail(id){
    parent.showBox({title:'订单详情',type:2,content:WST.U('admin/orders/view',{id:id,from:1}),area: ['1020px', '500px'],btn:['关闭']});
}
function toExport(){
	var params = {};
	params = WST.getParams('.j-ipt');
	var box = WST.confirm({content:"您确定要导出订单吗?",yes:function(){
		layer.close(box);
		location.href=WST.U('admin/orderrefunds/toExport',params);
    }});
}
