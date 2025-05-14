var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/cashdraws/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'提现单号', field:'cashNo'},
            {title:'提现类型', field:'accType' ,templet: function(item){
                if(item['accType']==1)return '微信';
                if(item['accType']==2)return '支付宝';
                if(item['accType']==3)return '银行卡';
            }},
            {title:'会员类型', field:'targetTypeName'},
            {title:'会员名称', field:'loginName' ,templet: function(item){
                return WST.blank(item['userName'])+"("+item['loginName']+")";
            }},
            {title:'提现账号信息', field:'accTargetName' ,templet: function(item){
                if(item['accType']==1){
                    return item['accNo'];
                }else{
                    return  item['accTargetName']+' | '+item['accNo']+' | '+item['accAreaName'];
                }
            }},
            {title:'持卡人/姓名', field:'accUser'},
            {title:'提现金额', field:'money' ,templet: function(item){
                return '￥'+item['money'];
            }},
            {title:'申请时间', field:'createTime',width:200},
            {title:'状态', field:'cashSatus' ,templet: function(item){
                return (item['cashSatus']==1)?"<span class='statu-yes'><i class='fa fa-check-circle'></i> 提现成功</span>":((item['cashSatus']==-1)?"<span class='statu-no'><i class='fa fa-ban'></i> 提现失败&nbsp;</span>":"<span class='statu-wait'><i class='fa fa-clock-o'></i> 待处理&nbsp;</span>");
            }},
            {title:'操作', field:'' ,width:200, fixed: 'right',align:'center', templet: function(item){
                var h = "";
                h += "<a class='btn btn-blue' href='javascript:toView(" + item['cashId'] + ")'><i class='fa fa-search'></i>查看</a> ";
                if(item['cashSatus']==0 && WST.GRANT.TXSQ_04)h += "<a class='btn btn-green' href='javascript:toEdit(" + item['cashId'] + ")'><i class='fa fa-pencil'></i>处理</a> ";
                return h;
            }}
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

function toEdit(id){
	location.href=WST.U('admin/cashdraws/toHandle','id='+id+'&p='+WST_CURR_PAGE);
}
function toView(id){
	location.href=WST.U('admin/cashdraws/toView','id='+id+'&p='+WST_CURR_PAGE);
}
function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{where:{cashNo:$('#cashNo').val(),cashSatus:$('#cashSatus').val(),targetType:$('#targetType').val()},page:{curr:p}});
}

function save(p){
	var params = WST.getParams('.ipt');
	if(typeof(params.cashSatus)=='undefined'){
		WST.msg('请选择提现结果',{icon:2});
		return;
	}
	if(params.cashSatus==-1 && $.trim(params.cashRemarks)==''){
		WST.msg('输入提现失败原因',{icon:2});
		return;
	}
	if(WST.confirm({content:'您确定该提现申请'+((params.cashSatus==1)?'成功':'失败')+'吗？',yes:function(){
		var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	    $.post(WST.U('admin/cashdraws/handle'),params,function(data,textStatus){
	    	layer.close(loading);
	    	var json = WST.toAdminJson(data);
	    	if(json.status=='1'){
                WST.msg("操作成功",{icon:1},function(){
                    WST.backPrePage();
                });
	    	}else{
	    		WST.msg(json.msg,{icon:2});
	    	}
	    });
	}}));
}
function toExport(){
    var params = {};
    params = WST.getParams('.j-ipt');
    var box = WST.confirm({content:"您确定要导出提现申请记录吗?",yes:function(){
        layer.close(box);
        location.href=WST.U('admin/cashdraws/toExport',params);
    }});
}
