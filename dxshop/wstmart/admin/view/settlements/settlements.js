var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/settlements/pageShopQuery'),
        cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'店铺编号', field:'shopSn', width:120},
            {title:'店铺名称', field:'shopName'},
            {title:'店主姓名', field:'shopkeeper', width:120},
            {title:'店主联系电话', field:'telephone', width:150},
            {title:'待结算订单数', field:'noSettledOrderNum', width:150},
            {title:'待结算金额', field:'waitSettlMoney' , width:150,templet: function(item){
                return '￥'+item['waitSettlMoney'];
            }},
            {title:'待结算佣金', field:'noSettledOrderFee' , width:150,templet: function(item){
                return '￥'+item['noSettledOrderFee'];
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                var h = "<span id='s_"+item['shopId']+"' dataval='"+item['shopName']+"'></span><a class='btn btn-blue' href='javascript:toView(" + item['shopId'] + ")'><i class='fa fa-search'></i>订单列表</a>&nbsp;&nbsp;";
                return h;
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadShopGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function toView(id){
   location.href=WST.U('admin/settlements/toOrders','id='+id+'&p='+WST_CURR_PAGE);
}
function initOrderGrid(id,p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/settlements/pageShopOrderQuery','id='+id),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'订单号', field:'orderNo'},
            {title:'支付方式', field:'payTypeName'},
            {title:'商品金额', field:'goodsMoney'},
            {title:'运费', field:'deliverMoney' ,templet: function(item){
                return '￥'+item['deliverMoney'];
            }},
            {title:'待结算金额', field:'waitSettlMoney' ,templet: function(item){
                return '￥'+item['waitSettlMoney'];
            }},
            {title:'订单总金额', field:'totalMoney' ,templet: function(item){
                return '￥'+item['totalMoney'];
            }},
            {title:'实付金额', field:'realTotalMoney' ,templet: function(item){
                return '￥'+item['realTotalMoney'];
            }},
            {title:'已退还金额', field:'refundedPayMoney' ,templet: function(item){
                return '￥'+(parseFloat(item['refundedPayMoney'])+parseFloat(item['refundedScoreMoney']));
            }},
            {title:'失效积分换算金额', field:'refundedGetScoreMoney' ,renderer:function(val,item,rowIndex){
                return '￥'+parseFloat(item['refundedGetScoreMoney']);
            }},
            {title:'佣金', field:'commissionFee' ,templet: function(item){
                return '￥'+item['commissionFee'];
            }},
            {title:'下单时间', field:'createTime' ,width:170}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadOrderGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function loadShopGrid(p){
    p=(p<=1)?1:p;
	var areaIdPath = WST.ITGetAllAreaVals('areaId1','j-areas').join('_');
    var sd=$('#startDate').val();
    var ed=$('#endDate').val();
    console.log('line 85');
    mmg.reload('dataTable',{where:{shopName:$('#shopName').val(),areaIdPath:areaIdPath,startDate:sd,endDate:ed},page:{curr:p}});
}
function loadOrderGrid(p){
	var id = $('#id').val();
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{where:{orderNo:$('#orderNo').val(),payType:$('#payType').val(),id:id},page:{curr:p}});
}
