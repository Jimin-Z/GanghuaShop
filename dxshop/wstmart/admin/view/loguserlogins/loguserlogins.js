var mmg;
$(function(){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/loguserlogins/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:true,
        cols: [[
            {title:'#',type:'numbers'},
            {title:'用户名', field:'loginName'},
            {title:'登录时间', field:'loginTime' ,width:200},
            {title:'登录来源', field:'loginSrc'},
            {title:'登录IP', field:'loginIp'}
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
})
function loadGrid(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.ipt');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
}
