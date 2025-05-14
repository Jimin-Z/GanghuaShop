var mmg,WST_CURR_PAGE = 0;
function initGrid(p){
  mmg = layui.table;
  mmg.render({elem: '#mmg',url:WST.U('admin/roles/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
    cols: [[
      {title:'#',type:'numbers'},
      {field:'roleName', title: '角色名称',width:180},
      {field:'roleDesc',title: '角色备注'},
      {field:'op', title: '操作',fixed: 'right',width:150,templet: function(item){
          var h = "";
          if(WST.GRANT.JSGL_02 || WST.GRANT.JSGL_03)h = '<a class="btn btn-blue btngroup btn'+item['roleId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
          return h
      }}
    ]],
    done:function(res, curr, count){
      var e = this;
      var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
      if(count>0 && curr>total_page){
            loadQuery(total_page);
            return;
      }
      WST_CURR_PAGE = curr;
      var btns = [];
       for(var i=0;i<res.data.length;i++){
           btns.length = 0;
           if(WST.GRANT.JSGL_02)btns.push({title: '修改',act: 100});
           if(WST.GRANT.JSGL_03)btns.push({title: '删除',act: 101});
           layui.dropdown.render({
              elem: '.btn'+res.data[i].roleId,
              dataId:res.data[i].roleId,
              trigger: 'hover',
              data: btns,
              click: function(obj,othis){
                  switch(obj.act){
                     case 100:toEdit(this.dataId);break;
                     case 101:toDel(this.dataId);break;
                  }
              }
            });
       }
    }
    });
}
function loadQuery(p){
  p=(p<=1)?1:p;
  mmg.reload('mmg',{page:{curr:p}});
}
function toEdit(id){
	location.href=WST.U('admin/roles/toEdit','id='+id+'&p='+WST_CURR_PAGE);
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该角色吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           $.post(WST.U('admin/roles/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
                              loadQuery(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}
function getNodes(event, treeId, treeNode){
  zTree = $.fn.zTree.getZTreeObj('menuTree');
  if($.inArray(treeNode.privilegeCode,rolePrivileges)>-1){
    zTree.checkNode(treeNode,true,true);
  }
}
function save(p){
	if(!$('#roleName').isValid())return;
	var nodes = zTree.getChangeCheckedNodes();
	var privileges = [];
	for(var i=0;i<nodes.length;i++){
		if(nodes[i].isParent==0)privileges.push(nodes[i].privilegeCode);
	}
	var params = WST.getParams('.ipt');
	params.privileges = privileges.join(',');
	var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/roles/'+((params.roleId==0)?"add":"edit")),params,function(data,textStatus){
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

function getJsonTree(roleId){
    var loading = WST.msg('正在加载数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/privileges/listQueryByRole'),{roleId:roleId},function(data,textStatus){
      layer.close(loading);
      var json = WST.toAdminJson(data);
      if(json.length>0){
          if(zTree)zTree.destroy();
          var setting = {
                data: {
                  simpleData: {
                     enable: true
                  }
                },
                check: {
                    enable: true,
                    chkStyle:"checkbox"
                },
                callback:{
                  onNodeCreated:getNodes
                }
          };
          zTree = $.fn.zTree.init($("#menuTree"), setting,json);
      }else{
        WST.msg(json.msg,{icon:2});
      }
    });
}