var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.AU('cron://cron/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'计划任务名称', field:'cronName', width: 180},
            {title:'计划任务描述', field:'cronDesc'},
            {title:'上次执行时间', field:'runTime', width: 170, templet: function(item){
                return (item['runTime']==0)?'-':item['runTime'];
            }},
            {title:'执行状态', field:'isEnable', width: 100, templet: function(item){
                return (item['isRunSuccess']==1)?'<span class="statu-yes"><i class="fa fa-check-circle"></i> 成功</span>':'<span class="statu-no"><i class="fa fa-times-circle"></i> 失败</span>';
            }},
            {title:'下次执行时间', field:'nextTime', width: 170, templet: function(item){
                return (item['nextTime']==0)?'-':item['nextTime'];
            }},
            {title:'作者', name:'auchor', width: 100, templet: function(item){
                return !item['author']?'':'<a href="'+item['authorUrl']+'" target="_blank">'+item['author']+'</a>';
            }},
            {title:'计划状态', field:'isEnable', width: 100, templet: function(item){
                return (item['isEnable']==1)?'<span class="statu-yes"><i class="fa fa-check-circle"></i> 启用</span>':'<span class="statu-wait"><i class="fa fa-ban"></i> 停用</span>';
            }},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                return '<a data-id="'+item['id']+'" class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            var btns = [];
            for(var i=0;i<res.data.length;i++){
                btns = [];
                if(WST.GRANT.CRON_JHRW_04){
                    btns.push({title: '修改',act:102, cls:"btn-blue", icon:"fa-pencil"});
                    if(res.data[i]['isEnable']==0){
                        btns.push({title: '启用',act:111, cls:"btn-blue", icon:"fa-check"});
                    }else{
                        btns.push({title: '停用',act:110, cls:"btn-blue", icon:"fa-ban"});
                        btns.push({title: '执行',act:105, cls:"btn-blue", icon:"fa-refresh"});
                    }
                    if(!res.data[i]['cronCode'])btns.push({title: '删除',act:103, cls:"btn-red", icon:"fa-trash-o"});
                }
                layui.dropdown.render({
                    elem: '.btn'+res.data[i].id,
                    dataId:res.data[i].id,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                            case 102:toEdit(this.dataId);break;
                            case 103:del(this.dataId);break;
                            case 105:run(this.dataId);break;
                            case 110:changgeEnableStatus(this.dataId,0);break;
                            case 111:changgeEnableStatus(this.dataId,1);break;
                        }
                    }
                });
            }
        }
    });
}
function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{page:{curr:p}});
}

function toEdit(id){
	location.href=WST.AU('cron://cron/toEdit','id='+id+'&p='+WST_CURR_PAGE);
}
function checkType(v){
   $('.cycle').hide();
   $('.cycle'+v).show();
}
function run(id){
	var box = WST.confirm({content:'你确定要执行该任务吗？',yes:function(){
		var loading = WST.msg('正在执行计划任务，请稍后...',{icon: 16,time:6000000000});
		$.post(WST.AU('cron://cron/runCron'),{id:id},function(data,textStatus){
			layer.close(loading);
	        var json = WST.toAdminJson(data);
	        if(json.status=='1'){
	           	WST.msg(json.msg,{icon:1});
	           	layer.close(box);
                loadGrid(WST_CURR_PAGE);
	        }else{
	           	WST.msg(json.msg,{icon:2});
	        }
		})
	}});
}
function edit(id,p){
    var params = WST.getParams('.ipt');
	params.id = id;
	var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	$.post(WST.AU('cron://cron/edit'),params,function(data,textStatus){
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
}
function changgeEnableStatus(id,type){
	var msg = (type==1)?"您确定要启用该计划任务吗?":"您确定要停用该计划任务吗?"
	var box = WST.confirm({content:msg,yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.AU('cron://cron/changeEnableStatus'),{id:id,status:type},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
                              loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

function del(id){
	var box = WST.confirm({content:"您确定要删除该计划任务吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.AU('cron://cron/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
                                loadGrid(WST_CURR_PAGE)
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}






		