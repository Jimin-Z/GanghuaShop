var mmg;
function initGrid(p){
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('shop/shoproles/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'角色名称', field:'roleName',width:200},
			{title:'创建时间', field:'createTime'},
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
			btns.push({title: '编辑', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
			btns.push({title:'删除',clickFun:"del", cls:"btn-red", icon:"fa-trash-o"});
			WST.initGridButtons({id:'.btngroup',btns:btns});
		}
	});
}

function loadGrid(p){
	p=(p<=1)?1:p;
	mmg.reload('dataTable',{page:{curr:p},where:{roleName:$('#roleName').val()}});
}

function toEdit(id){
	location.href = WST.U('shop/shoproles/edit','id='+id+'&p='+WST_CURR_PAGE);
}
function toAdd(){
    location.href = WST.U('shop/shoproles/add','p='+WST_CURR_PAGE);
}

/**保存角色数据**/
function save(p){
	$('#shoprole').isValid(function(v){
		if(v){
			var params = WST.getParams('.ipt');
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		    $.post(WST.U('shop/shoproles/'+((params.id==0)?"toAdd":"toEdit")),params,function(data,textStatus){
		    	layer.close(loading);
		    	var json = WST.toJson(data);
		    	if(json.status=='1'){
		    		WST.msg(json.msg,{icon:1},function(){
						WST.backPrePage();
					});
		    	}else{
		    		WST.msg(json.msg,{icon:2});
		    	}
		    });
		}
	});
}
//删除角色
function del(id){
	var c = WST.confirm({content:'您确定要删除该角色吗?',yes:function(){
		layer.close(c);
		var load = WST.load({msg:'正在删除，请稍后...'});
		$.post(WST.U('shop/shoproles/del'),{id:id},function(data,textStatus){
			layer.close(load);
		    var json = WST.toJson(data);
		    if(json.status==1){
		    	WST.msg(json.msg,{icon:1});
                loadGrid(WST_CURR_PAGE);
		    }else{
		    	WST.msg(json.msg,{icon:2});
		    }
		});
	}});
}
