var mmg;
function initGrid(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/shops/renewMoneyByPage'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'店铺名称', field:'shopName' ,templet: function(item){
                $("#totalRenewMoney").html(item['totalRenewMoney']);
                return item['shopName'];
            }},
            {title:'缴纳年费描述', field:'remark' ,templet: function(item){
                return (item['isRefund']==1)?item['remark']+'(已退款)':item['remark'];
            }},
            {title:'年费金额', field:'money' ,templet: function(item){
                return '￥'+item['money'];
            }},
            {title:'外部流水号', field:'', templet: function(item){
                return WST.blank(item['tradeNo'],'-');
            }},
            {title:'缴纳时间', field:'createTime',width:200},
            {title:'开始日期', field:'startDate'},
            {title:'结束日期', field:'endDate'}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(total_page);
                return;
            }
        }
    });
}
function loadGrid(p){
    p=(p<=1)?1:p;
    var params = WST.getParams('.ipt');
    mmg.reload('dataTable',{where:params,page:{curr:p}});
}
function toolTip(){
    WST.toolTip();
}
function toExport(){
    var params = WST.getParams('.ipt');
    var box = WST.confirm({content:"您确定要导出该统计数据吗?",yes:function(){
        layer.close(box);
        location.href=WST.U('admin/shops/toExportRenewMoney',params);
    }});
}
