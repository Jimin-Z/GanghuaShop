var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/express/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'快递名称', field:'expressName',width:170},
            {title:'快递代码', field:'expressCode' },
            {title:'是否启用', field:'isShow',width:150,templet: function(item){
                return '<input type="checkbox" '+((item['isShow']==1)?"checked":"")+' name="isShow2" lay-skin="switch" lay-filter="isShow2" data="'+item['expressId']+'" lay-text="显示|隐藏">';
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                return '<a data-id="'+item['expressId']+'" class="btn btn-blue btngroup btn'+item['expressId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            if(WST.GRANT.KDGL_02)btns.push({title: '修改', clickFun:"getForEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.KDGL_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
            layui.form.render();
            layui.form.on('switch(isShow2)', function(data){
                var id = $(this).attr("data");
                if(this.checked){
                    toggleIsShow(0,id);
                }else{
                    toggleIsShow(1,id);
                }
            });
        }
    });
}
function toggleIsShow(t,v){
  if(!WST.GRANT.KDGL_02)return;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
      $.post(WST.U('admin/express/editiIsShow'),{id:v,isShow:t},function(data,textStatus){
        layer.close(loading);
        var json = WST.toAdminJson(data);
        if(json.status=='1'){
            WST.msg(json.msg,{icon:1});
            loadGrid(WST_CURR_PAGE);
        }else{
            WST.msg(json.msg,{icon:2});
        }
    });
}
function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{page:{curr:p}});
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/express/del'),{id:id},function(data,textStatus){
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

function getForEdit(id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/express/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           if(json.expressId){
           		WST.setValues(json);
              $('#isShow')[0].checked = (json.isShow==1);
              layui.form.render();
           		toEdit(json.expressId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}

function toEdit(id){
	var title = "新增";
	if(id>0){
		title = "编辑";
	}else{
		$('#expressForm')[0].reset();
	}
	var box = WST.open({title:title,type:1,content:$('#expressBox'),area: ['640px', '350px'],btn:['确定','取消'],
        end:function(){$('#expressBox').hide();},
		yes:function(){
		$('#expressForm').submit();
	}});
	$('#expressForm').validator({
        fields: {
            expressName: {
            	rule:"required;",
            	msg:{required:"快递名称不能为空"},
            	tip:"请输入快递名称",
            	ok:"",
            }
        },
       valid: function(form){
		        var params = WST.getParams('.ipt');
	                params.expressId = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/express/'+((id==0)?"add":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressForm')[0].reset();
	           			    	layer.close(box);
                              loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}

  });

}
