var mmg;
function initSaleGrid(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/reports/topShopSalesByPage',WST.getParams('.ipt')),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'&nbsp;', field:'shopImg',templet: function(item){
                return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['shopImg']
                    +"'><span class='imged' ><img  style='height:180px;width:180px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['shopImg']+"'></span></span>";
            }},
            {title:'店铺', field:'shopName'},
            {title:'总销售额', field:'totalMoney', templet: function(item){
                return '￥'+item['totalMoney'];
            }},
            {title:'在线支付金额', field:'onLinePayMoney', templet: function(item){
                return '￥'+item['onLinePayMoney'];
            }},
            {title:'积分抵扣金额', field:'onLinePayScoreMoney',templet: function(item){
                return '￥'+item['onLinePayScoreMoney'];
            }},
            {title:'货到付款金额', field:'offLinePayMoney', templet: function(item){
                return '￥'+item['offLinePayMoney'];
            }},
            {title:'订单数', field:'orderNum'}
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
    var params = WST.getParams('.ipt');
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{where:params,page:{curr:p}});
}
function toolTip(){
    WST.toolTip();
}
function toExport(){
    var params = WST.getParams('.ipt');
    var box = WST.confirm({content:"您确定要导出该统计数据吗?",yes:function(){
        layer.close(box);
        location.href=WST.U('admin/reports/toExportShopSales',params);
    }});
}
