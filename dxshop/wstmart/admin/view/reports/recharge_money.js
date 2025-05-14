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
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/reports/rechargeMoneyByPage',WST.getParams('.ipt')),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'会员名称', field:'loginName' ,templet: function(item){
                if(item['targetType']==1){
                    return WST.blank(item['userName'])+"("+item['loginName']+")";
                }else{
                    return WST.blank(item['userName'])+"("+item['loginName']+")";
                }
            }},
            {title:'会员类型', field:'targetType' ,templet: function(item){
                $("#totalRechargeMoney").html(item['totalRechargeMoney']);
                $("#totalGiveMoney").html(item['totalGiveMoney']);
                return (item['targetType']==1)?"【商家】":"【会员】";
            }},
            {title:'充值描述', field:'remark'},
            {title:'充值金额', field:'money' },
            {title:'赠送金额', field:'giveMoney'},
            {title:'充值时间', field:'createTime',width:200}
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
        location.href=WST.U('admin/reports/toExportRechargeMoney',params);
    }});
}
