var mmg;
function initGrid(p,userId){
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('store/storeusers/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'账号名', field:'loginName'},
			{title:'角色名称', field:'roleId' ,templet: function(item){
				return item['roleId']?(item['roleName']?item['roleName']:'无'):'管理员';
			}},
			{title:'创建时间', field:'createTime' ,width:200},
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
				btns.push({title: '编辑',clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
				if(res.data[i]['roleId'] > 0 && res.data[i]['userId']!=userId)btns.push({title: '删除',clickFun:"del", cls:"btn-red", icon:"fa-trash-o"});
				layui.dropdown.render({
					elem: '.btn'+res.data[i].id,
					dataId:res.data[i].id,
					trigger: 'hover',
					data: btns,
					click: function(obj,othis){
						var _fn = window[obj.clickFun];
						if($(this.elem).data('fun-'+obj.clickFun)){
							_fn && eval(obj.clickFun+'('+$(this.elem).data('fun-'+obj.clickFun)+')');
						}else{
							_fn && _fn($(this.elem).data('id'));
						}
					}
				});
			}
		}
	});
}

function loadGrid(p){
	p=(p<=1)?1:p;
	mmg.reload('dataTable',{where:{userName:$('#userName').val()},page:{curr:p}});
}

function toEdit(id){
	location.href = WST.U('store/storeusers/edit','id='+id+'&p='+WST_CURR_PAGE);
}
function toAdd(){
    location.href = WST.U('store/storeusers/add','p='+WST_CURR_PAGE);
}
function toNotify(id){
    location.href = WST.U('store/storeusers/notify','id='+id+'&p='+WST_CURR_PAGE);
}

/**保存角色数据**/
function add(p){
	$('#editForm').isValid(function(v){
		if(v){
			var params = WST.getParams('.ipt');
			if(WST.conf.IS_CRYPT=='1'){
	            var public_key=$('#token').val();
	            var exponent="10001";
	       	    var rsa = new RSAKey();
	            rsa.setPublic(public_key, exponent);
	            params.loginPwd = rsa.encrypt(params.loginPwd);
	            params.reUserPwd = rsa.encrypt(params.reUserPwd);
	        }
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		    $.post(WST.U('store/storeusers/toAdd'),params,function(data,textStatus){
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

function edit(p){
	$('#editForm').isValid(function(v){
		if(v){
			var params = WST.getParams('.ipt');
			if(WST.conf.IS_CRYPT=='1' && params.newPass!=""){
	            var public_key=$('#token').val();
	            var exponent="10001";
	       	    var rsa = new RSAKey();
	            rsa.setPublic(public_key, exponent);
	            params.oldPass = rsa.encrypt(params.oldPass);
	            params.newPass = rsa.encrypt(params.newPass);
	            params.reNewPass = rsa.encrypt(params.reNewPass);
	        }
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		    $.post(WST.U('store/storeusers/toEdit'),params,function(data,textStatus){
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
	var c = WST.confirm({content:'删除门店管理帐号，只是删除该帐号与门店的关系，您确定要删除吗?',yes:function(){
		layer.close(c);
		var load = WST.load({msg:'正在删除，请稍后...'});
		$.post(WST.U('store/storeusers/del'),{id:id},function(data,textStatus){
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
