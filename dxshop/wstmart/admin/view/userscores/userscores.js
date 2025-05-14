var mmg;
function gridInit(id,p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/userscores/pageQuery','id='+id),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'来源', field:'dataSrc'},
            {title:'积分变化', field:'dataSrc',templet:function(item){
                if(item['scoreType']==1){
                    return '<font color="red">+'+item['score']+'</font>';
                }else{
                    return '<font color="green">-'+item['score']+'</font>';
                }
            }},
            {title:'备注', field:'dataRemarks'},
            {title:'日期', field:'createTime',width: 200}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(id,total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function loadGrid(id,p){
    p = (p<=1)?1:p;
    mmg.reload('dataTable',{where:{id:id,startDate:$('#startDate').val(),endDate:$('#endDate').val()},page:{curr:p}});
}
var w;
function toAdd(id){
	var ll = WST.msg('正在加载信息，请稍候...');
	$.post(WST.U('admin/userscores/toAdd',{id:id}),{},function(data){
		layer.close(ll);
		w =WST.open({type: 1,title:"调节会员积分",shade: [0.6, '#000'],offset:'50px',border: [0],content:data,area: ['550px', '380px'],success:function(){
            layui.form.render();
        }});
	});
}
function editScore(){
	var params = WST.getParams('.ipt');
	var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/userscores/add'),params,function(data,textStatus){
    	layer.close(loading);
    	var json = WST.toAdminJson(data);
    	if(json.status=='1'){
    		WST.msg("操作成功",{icon:1});
    		closeFrom();
    		loadGrid(params.userId);
    	}else{
    		WST.msg(json.msg,{icon:2});
    	}
    });
}
function closeFrom(){
    layer.close(w);
}
