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
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/reports/scoreConsumeByPage',WST.getParams('.ipt')),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'用户', field:'userName',templet: function(item){
                $("#totalScore").html(item['totalScore']);
                $("#totalScoreMoney").html(item['totalScoreMoney']);
                return item['userName'];
            }},
            {title:'描述', field:'dataRemarks'},
            {title:'积分数', field:'score'},
            {title:'抵扣金额', field:'scoreMoney'},
            {title:'时间', field:'createTime' , width: 200}
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
        location.href=WST.U('admin/reports/toExportScoreConsume',params);
    }});
}
