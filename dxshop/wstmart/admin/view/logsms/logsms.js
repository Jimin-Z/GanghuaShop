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
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/logsms/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:true,
        cols: [[
            {title:'使用者ID', field:'smsUserId'},
            {title:'消息内容', field:'smsContent'},
            {title:'消息代码', field:'smsCode'},
            {title:'发送方式', field:'smsFunc'},
            {title:'发送号码', field:'smsPhoneNumber'},
            {title:'消息IP', field:'smsIP'},
            {title:'发送时间', field:'createTime' ,width:200},
            {title:'返回状态', field:'smsReturnCode' }
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
