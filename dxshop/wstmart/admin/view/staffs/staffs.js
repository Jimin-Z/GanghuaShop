var mmg,WST_CURR_PAGE = 0;
function initGrid(staffId,p){
    mmg = layui.table;
    mmg.render({
    elem: '#mmg',url:WST.U('admin/staffs/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
    cols: [[
      {title:'#',type:'numbers'},
      {field:'loginName', title: '职员账号'},
      {field:'staffName',title: '职员名称'},
      {field:'roleName', title: '职员角色'},
      {field:'staffNo',title: '职员编号'},
      {field:'workStatus', title: '工作状态',templet: function(item){
      	 return (item['workStatus']==1)?"<span class='statu-yes'><i class='fa fa-check-circle'></i> 在职</span>":"<span class='statu-no'><i class='fa fa-ban'></i> 离职</span>";
      }},
      {field:'lastTime',title: '登录时间'},
      {field:'lastIP', title: '登录IP'},
      {field:'op', title: '操作',fixed: 'right',width:150,templet: function(item){
           var h = "";
		   if(WST.GRANT.ZYGL_02 || WST.GRANT.ZYGL_03)h = '<a class="btn btn-blue btngroup btn'+item['staffId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
	       return h;
      }}
    ]],
    done:function(res, curr, count){
        var e = this;
        var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
        if(count>0 && curr>total_page){
            loadGrid(total_page);
            return;
        }
        WST_CURR_PAGE = curr;
        var btns = [];
        for(var i=0;i<res.data.length;i++){
           btns.length = 0;
           if(WST.GRANT.ZYGL_02){
              btns.push({title: '修改密码',act: 100});
              btns.push({title: '编辑',act: 101});
           }
           if(WST.GRANT.ZYGL_03)btns.push({title: '删除',act: 102});
           layui.dropdown.render({
              elem: '.btn'+res.data[i].staffId,
              dataId:res.data[i].staffId,
              trigger: 'hover',
              data: btns,
              click: function(obj,othis){
                  switch(obj.act){
                     case 100:toEditPass(this.dataId);break;
                     case 101:toEdit(this.dataId);break;
                     case 102:toDel(this.dataId);break;
                  }
              }
            });
        }
    }
    });
}
function loadGrid(p){
	p=(p<=1)?1:p;
	mmg.reload('mmg',{page:{curr:p},where:{key:$('#key').val()}});
}
function toEdit(id){
	location.href=WST.U('admin/staffs/'+((id==0)?'toAdd':'toEdit'),'id='+id+'&p='+WST_CURR_PAGE);
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该职员吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           $.post(WST.U('admin/staffs/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
	           		            loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}
function checkLoginKey(obj){
	if($.trim(obj.value)=='')return;
	var params = {key:obj.value,userId:0};
	var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/staffs/checkLoginKey'),params,function(data,textStatus){
    	layer.close(loading);
    	var json = WST.toAdminJson(data);
    	if(json.status!='1'){
    		WST.msg(json.msg,{icon:2});
    		obj.value = '';
    	}
    });
}
function save(p){
	var params = WST.getParams('.ipt');
	if(params.staffId==0){
		if(!$('#loginName').isValid())return;
		if(!$('#loginPwd').isValid())return;
	}
	if(!$('#staffName').isValid())return;
	var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/staffs/'+((params.staffId==0)?"add":"edit")),params,function(data,textStatus){
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
function toEditPass(id){
	var w = WST.open({type: 1,title:"修改密码",shade: [0.6, '#000'],border: [0],content:$('#editPassBox'),area: ['490px', '300px'],
	    btn: ['确定', '取消'],end:function(){$('#editPassBox').hide();},yes: function(index, layero){
	    	$('#editPassFrom').isValid(function(v){
	    		if(v){
		        	var params = WST.getParams('.ipt');
		        	params.staffId = id;
		        	var ll = WST.msg('数据处理中，请稍候...');
				    $.post(WST.U('admin/Staffs/editPass'),params,function(data){
				    	layer.close(ll);
				    	var json = WST.toAdminJson(data);
						if(json.status==1){
							WST.msg(json.msg, {icon: 1});
							layer.close(w);
						}else{
							WST.msg(json.msg, {icon: 2});
						}
				   });
	    		}})
        }
	});
}
