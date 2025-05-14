var mmg;
function gridInit(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#month',
        type: 'month'
    });
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/userscores/pageQueryByRanking'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'会员', field:'userName',templet:function(item){
                return '<img src="'+item['userPhoto']+'" height="40"/>'+"【"+item['loginName']+"】"+WST.blank(item['userName']);
            }},
            {title:'最后签到时间', field:'createTime',width: 170},
            {title:'本月连续签到', field:'dataId',width:150},
            {title:'累计签到数', field:'signCount',width:150}
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
    mmg.reload('dataTable',{where:{month:$('#month').val()},page:{curr:p}});
}
